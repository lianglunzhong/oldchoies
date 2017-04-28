<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Sys_User extends Controller_Admin_Site
{

        public function action_list()
        {
                $count = ORM::factory('user')->count_all();

                $pagination = Pagination::factory(
                                array(
                                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                                    'total_items' => $count,
                                    'items_per_page' => 50,
                                    'view' => 'pagination/basic',
                                    'auto_hide' => 'FALSE',
                                )
                );

                $page_view = $pagination->render();

                $data = ORM::factory('user')
                        ->limit($pagination->items_per_page)
                        ->offset($pagination->offset)
                        ->find_all();

                $content = View::factory('admin/sys/user_list')
                        ->set('data', $data)
                        ->set('count', $count)
                        ->set('page_view', $page_view)
                        ->render();

                $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }

        public function action_data()
        {
                //TODO fixed the post
                $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
                $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
                $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
                $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
                //filter
                $filters = Arr::get($_REQUEST, 'filters', array( ));

                if($filters)
                {
                        $filters = json_decode($filters);
                }

                if( ! $sidx) $sidx = 1;

                $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

                if($totalrows) $limit = $totalrows;

                $filter_sql = "";
                $order_sql = '';
                if($filters)
                {
                        foreach( $filters->rules as $item )
                        {
                                //TODO add filter items
                                if($item->field == 'created')
                                {
                                        $date = explode(' to ', $item->data);
                                        $count = count($date);
                                        $from = strtotime($date[0]);
                                        if($count == 1)
                                        {
                                                $to = strtotime($date[0].' +1 day -1 second');
                                        }
                                        else
                                        {
                                                $to = strtotime($date[1].' +1 day -1 second');
                                        }
                                        $_filter_sql[] = $item->field." between ".$from." and ".$to;
                                }
                                else if ($item->field == 'parent_id')
                                {
                                        if($item->data == 'admin')
                                                $_filter_sql[] = 'parent_id = 0';
                                        else
                                        {
                                                $user_id = DB::select('id')->from('auth_user')->where('name', '=', $item->data)->execute()->get('id');
                                                $_filter_sql[] = 'parent_id = '.$user_id;
                                        }
                                }
                                else
                                {
                                        $_filter_sql[] = $item->field."='".$item->data."'";
                                }
                        }
                        if( ! empty($_filter_sql)) $filter_sql = implode(' AND ', $_filter_sql);
                }

                if($filter_sql)
                        $filter_sql = 'WHERE '.$filter_sql;
                $count = ORM::factory('user')->count_all();
                $total_pages = 0;
                $limit = 20;
                if($count > 0)
                {
                        $total_pages = ceil($count / $limit);
                }

                if($page > $total_pages) $page = $total_pages;
                if($limit < 0) $limit = 0;

                $start = $limit * $page - $limit; // do not put $limit*($page - 1)
                if($start < 0) $start = 0;

                $result = DB::query(DATABASE::SELECT, 'SELECT * FROM `users` '
                        .$filter_sql.' GROUP BY id '.$order_sql.' ORDER BY '.$sidx.' '.$sord.' LIMIT '.$limit.' OFFSET '.$start)->execute();
                $response = array( );
                $response['page'] = $page;
                $response['total'] = $total_pages;
                $response['records'] = $count;

                $k = 0;
                $response['userdata']['roles'] = array();
                foreach( $result as $data )
                {
                        $role = DB::select('brief')->from('roles')->where('id', '=', $data['role_id'])->execute()->get('brief');
                        $response['userdata']['roles'][$data['role_id']] = $role ? $role : '无';
                        $response['rows'][$k]['id'] = $data['id'];
                        $response['rows'][$k]['cell'] = array(
                            $data['id'],
                            $data['name'],
                            $data['email'],
                            $data['role_id'],
                            date('Y-m-d', $data['created']),
                            $data['parent_id'] ? User::instance($data['parent_id'])->get('name') : 'admin',
                            $data['active']
                        );
                        $k ++;
                }
                echo json_encode($response);
        }

        public function action_add()
        {
                if ($_POST)
                {
                        $small_language = Arr::get($_POST, 'small_lang', '');
                        if($small_language)
                            $_POST['lang'] = $small_language;
                        $email = Arr::get($_POST, 'email', '');
                        if (!user::instance()->is_register($email))
                        {
                                if (User::instance()->register($_POST))
                                {
                                        message::set('user added');
                                        $this->request->redirect('/admin/sys/user/list');
                                }
                                else
                                {
                                        message::set('error', 'error');
                                        $this->request->redirect('/admin/sys/user/add');
                                }
                        }
                        else
                        {
                                message::set('user email used', 'error');
                                $this->request->redirect('/admin/sys/user/add');
                        }
                }


                $content = View::factory('admin/sys/user_add')->render();
                $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }

        public function action_edit()
        {
                $id = $this->request->param('id');
                $user = User::instance($id)->get();
                $role = ORM::factory('role', $user['role_id']);

                if ($_POST)
                {
                        $id = Arr::get($_POST, 'id', '');
                        $password = Arr::get($_POST, 'password', '');
                        if (!empty($password))
                        {
                                $data['password'] = toolkit::hash($password);
                        }
                        $data['email'] = Arr::get($_POST, 'email', '');
                        $data['name'] = Arr::get($_POST, 'name', '');
                        $data['role_id'] = Arr::get($_POST, 'role_id', '');
                        $data['parent_id'] = Arr::get($_POST, 'parent_id', 0);
                        $data['lang'] = Arr::get($_POST, 'lang', '');
                        $data['active'] = Arr::get($_POST, 'active', '');
                        $small_language = Arr::get($_POST, 'small_lang', '');
                        if($small_language)
                            $data['lang'] = $small_language;

                        $user = User::instance()->edit($id, $data);
                        if ($user)
                                message::set('edit user success');
                        else
                                message::set('error', 'error');
                        Request::instance()->redirect('/admin/sys/user/list');
                }

                $content = View::factory('admin/sys/user_edit')
                        ->set('data', $user)
                        ->set('role', $role)
                        ->render();

                $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }

        public function action_delete()
        {
                $id = $this->request->param('id');
                $user = User::instance()->delete($id);
                if ($user)
                        echo 'success';
                else
                        echo 'error';
                exit;
        }

        public function action_export()
        {
            header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
            header('Content-type:application/vnd.ms-excel');//输出的类型
            header('Content-Disposition: attachment; filename="choies_user.csv"'); //下载显示
            echo iconv("UTF-8", "GBK//IGNORE",'name,email,role'."\r\n");
            $result = DB::query(DATABASE::SELECT, 'SELECT name,email,role_id FROM `users` where active = 1' )->execute('slave')->as_array();
            foreach ($result as $data)
            {
                $role = DB::select('brief')->from('roles')->where('id', '=', $data['role_id'])->execute('slave')->get('brief');

                echo '"' .$data['name']. '"', ',';
                echo '"' .$data['email']. '"', ',';
                echo '"' .$role. '"', ',';
                echo "\n";                        
            }
        }

}

