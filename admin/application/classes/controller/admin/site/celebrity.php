<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Celebrity extends Controller_Admin_Site
{

    public function action_list()
    {
        $content = View::factory('admin/site/celebrity_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";
        $_filter_sql = array();

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {

                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'admin')
                {
                    $user = ORM::factory('user')->where('name', '=', $item->data)->find();
                    $_filter_sql[] = $item->field . "='" . $user->id . "'";
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
        }
        if (!empty($_filter_sql))
            $filter_sql = " WHERE " . implode(' AND ', $_filter_sql);

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM celebrits ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM celebrits ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }
        $i = 0;
        foreach ($result as $data)
        {
            $point = Customer::instance($data['customer_id'])->points();
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                0,
                $data['id'],
                $data['customer_id'],
                $data['name'],
                $data['email'],
                $data['country'],
                $data['level'],
                isset($users[$data['admin']]) ? $users[$data['admin']] : '',
//                            user::instance($data['admin'])->get('name'),
                date('Y-m-d H:i', $data['created']),
                $data['updated'] ? date('Y-m-d H:i', $data['updated']) : '',
                $data['remark'],
                $data['is_able'] ? 'Yes' : 'No',
                $point,
                empty($data['height'])?0:$data['height'],
                empty($data['weight'])?0:$data['weight'],
                empty($data['bust'])?0:$data['bust'],
                empty($data['waist'])?0:$data['waist'],
                empty($data['hips'])?0:$data['hips'],
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_add()
    {
        if ($_POST)
        {
            $data = array();
            $data['email'] = trim(Arr::get($_POST, 'email', ''));
            $result = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $data['email'])->execute('slave')->get('id');
            if ($result)
            {
                Message::set('This Celebrity already exists!', 'error');
                Request::instance()->redirect('admin/site/celebrity/add');
            }
            $customer = ORM::factory('customer')
                ->where('email', '=', $data['email'])
                ->where('site_id', '=', $this->site_id)
                ->find();
            if ($customer->loaded())
            {
                $data['customer_id'] = $customer->id;
            }
            $data['name'] = Arr::get($_POST, 'name', '');
            $data['country'] = Arr::get($_POST, 'country', '');
            $data['sex'] = Arr::get($_POST, 'sex', '');
            $birthday = Arr::get($_POST, 'birthday', '');
            $data['birthday'] = strtotime($birthday);
            $data['level'] = Arr::get($_POST, 'level', 1);
            $data['admin'] = Session::instance()->get('user_id');
            $data['created'] = time();
            $result = DB::insert('celebrits', array_keys($data))->values($data)->execute();

            if ($result)
            {
                $blog = Arr::get($_POST, 'blog', array());
                if (!empty($blog['type']))
                {
                    $celebrity_id = $result[0];
                    foreach ($blog['type'] as $key => $type)
                    {
                        if (!$blog['url'][$key])
                            continue;
                        $blogArr['celebrity_id'] = $celebrity_id;
                        $blogArr['celebrity_email'] = $data['email'];
                        $blogArr['type'] = $type;
                        $blogArr['url'] = $blog['url'][$key];
                        $blogArr['profile'] = $blog['profile'][$key];
                        DB::insert('celebrity_blogs', array_keys($blogArr))->values($blogArr)->execute();
                    }
                }
                Message::set('Add Celebrity success!', 'success');
                Request::instance()->redirect('admin/site/celebrity/list');
            }
            else
            {
                Message::set('Add Celebrity faild!', 'error');
                Request::instance()->redirect('admin/site/celebrity/add');
            }
        }

        $content = View::factory('admin/site/celebrity_add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        if ($_POST)
        {
            $data = array();
            $data['email'] = trim(Arr::get($_POST, 'email', ''));
            $data['name'] = trim(Arr::get($_POST, 'name', ''));
            $data['country'] = Arr::get($_POST, 'country', '');
            $data['sex'] = Arr::get($_POST, 'sex', '');
            $birthday = Arr::get($_POST, 'birthday', '');
            $data['birthday'] = strtotime($birthday);
            $data['level'] = Arr::get($_POST, 'level', 1);
            $data['remark'] = Arr::get($_POST, 'remark', '');
            $data['admin'] = Session::instance()->get('user_id');
            $data['updated'] = time();
            $customer_id = DB::select('id')->from('accounts_customers')->where('email', '=', $data['email'])->execute('slave')->get('id');
            if($customer_id)
                $data['customer_id'] = $customer_id;
            $result = DB::update('celebrities_celebrits')->set($data)->where('id', '=', $id)->execute();

            if ($result)
            {
                $delete_blog = Arr::get($_POST, 'delete_blog', '');
                $deleteArr = explode(',', $delete_blog);
                foreach($deleteArr as $d)
                {
                    $d_id = (int) $d;
                    if($d_id)
                        DB::delete('celebrity_blogs')->where('id', '=', $d_id)->execute();
                }
                $blog = Arr::get($_POST, 'blog', array());
                if (!empty($blog['type']))
                {
                    $celebrity_id = $id;
                    foreach ($blog['type'] as $key => $type)
                    {
                        if (!$blog['url'][$key])
                            continue;
                        $blogArr['celebrity_id'] = $celebrity_id;
                        $blogArr['celebrity_email'] = $data['email'];
                        $blogArr['type'] = $type;
                        $blogArr['url'] = $blog['url'][$key];
                        $blogArr['profile'] = $blog['profile'][$key];
                        if (isset($blog['blog_id'][$key]))
                        {
                            DB::update('celebrity_blogs')->set($blogArr)->where('id', '=', $blog['blog_id'][$key])->execute();
                        }
                        else
                        {
                            DB::insert('celebrity_blogs', array_keys($blogArr))->values($blogArr)->execute();
                        }
                    }
                }
                Message::set('Edit Celebrity success!', 'success');
                Request::instance()->redirect('admin/site/celebrity/list');
            }
            else
            {
                Message::set('Edit Celebrity faild!', 'error');
                Request::instance()->redirect('admin/site/celebrity/add');
            }
        }

        $celebrity = DB::select()->from('celebrities_celebrits')->where('id', '=', $id)->and_where('is_able', '=', 1)->execute('slave')->current();
        $admin = $celebrity['admin'];
        $user = Session::instance()->get('user_id');
        $parent = DB::select('parent_id')->from('auth_user')->where('id', '=', $admin)->execute('slave')->get('parent_id');
        if ($celebrity['admin'] != $user AND $user != $parent)
        {
            Message::set('You do not have access to edit!', 'faild');
            Request::instance()->redirect('admin/site/celebrity/list');
        }
        $blogs = DB::select()->from('celebrity_blogs')->where('celebrity_id', '=', $id)->execute('slave')->as_array();
        $content = View::factory('admin/site/celebrity_edit')
            ->set('celebrity', $celebrity)
            ->set('blogs', $blogs)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_view()
    {
        $id = $this->request->param('id');
        $celebrity = DB::select()->from('celebrities_celebrits')->where('id', '=', $id)->and_where('is_able', '=', 1)->execute('slave')->current();
        $blogs = DB::select()->from('celebrity_blogs')->where('celebrity_id', '=', $id)->execute()->as_array();
        $address = DB::query(Database::SELECT, 'SELECT addresses.* FROM addresses LEFT JOIN customers ON addresses.customer_id = customers.id WHERE customers.email = "' . $celebrity['email'] . '"')->execute('slave')->current();
        $this->request->response = View::factory('admin/site/celebrity_view')
            ->set('celebrity', $celebrity)
            ->set('blogs', $blogs)
            ->set('address', $address)
            ->render();
    }

    public function action_disable($id)
    {
        $result = DB::update('celebrities_celebrits')->set(array('is_able' => 0))->where('id', '=', $id)->execute();
        if ($result)
        {
            Message::set('Disable Celebrity success!', 'success');
            Request::instance()->redirect('admin/site/celebrity/list');
        }
        else
        {
            Message::set('Disable Celebrity faild!', 'error');
            Request::instance()->redirect('admin/site/celebrity/list');
        }
    }

    public function action_enable($id)
    {
        $result = DB::update('celebrities_celebrits')->set(array('is_able' => 1))->where('id', '=', $id)->execute();
        if ($result)
        {
            Message::set('Enable Celebrity success!', 'success');
            Request::instance()->redirect('admin/site/celebrity/list');
        }
        else
        {
            Message::set('Enable Celebrity faild!', 'error');
            Request::instance()->redirect('admin/site/celebrity/list');
        }
    }

    public function action_delete($id)
    {
        DB::delete('celebrity_blogs')->where('celebrity_id', '=', $id)->execute();
        DB::delete('celebrities_celebrityorder')->where('celebrity_id', '=', $id)->execute();
        $result = DB::delete('celebrities_celebrits')->where('id', '=', $id)->execute();
        if ($result)
        {
            Message::set('Delete Celebrity success!', 'success');
            Request::instance()->redirect('admin/site/celebrity/list');
        }
        else
        {
            Message::set('Delete Celebrity faild!', 'error');
            Request::instance()->redirect('admin/site/celebrity/list');
        }
    }

    public function action_assign()
    {
        if ($_POST)
        {
            $celebrity_id = Arr::get($_POST, 'celebrity_id', 0);
            $user = Arr::get($_POST, 'user', '');
            if (!$celebrity_id OR !$user)
            {
                Message::set('Assign celebrity failed', 'error');
            }
            else
            {
                $result = DB::update('celebrities_celebrits')->set(array('admin' => $user))->where('id', '=', $celebrity_id)->execute();
                if ($result)
                {
                    Message::set('Assign celebrity success', 'success');
                }
                else
                {
                    Message::set('Assign celebrity failed', 'error');
                }
            }
            $this->request->redirect('admin/site/celebrity/list');
        }
    }

    public function action_bulk_assign()
    {
        if ($_POST)
        {
            $ids = Arr::get($_POST, 'ids', array());
            $user = Arr::get($_POST, 'user', 0);
            if (empty($ids) OR !$user)
            {
                Message::set('Assign celebrity failed!', 'error');
                $this->request->redirect('admin/site/celebrity/list');
            }
            else
            {
                $user_id = Session::instance()->get('user_id');
                $admins = DB::select('id')->from('auth_user')->where('parent_id', '=', $user_id)->execute('slave')->as_array();
                foreach ($ids as $id)
                {
                    $c_admin = DB::select('admin')->from('celebrities_celebrits')->where('id', '=', $id)->execute('slave')->get('admin');
                    $admin = array('id' => $c_admin);
                    if (in_array($admin, $admins) OR $c_admin == $user_id)
                    {
                        DB::update('celebrities_celebrits')->set(array('admin' => $user))->where('id', '=', $id)->execute();
                    }
                }
                Message::set('Assign celebrity success!', 'success');
                $this->request->redirect('admin/site/celebrity/list');
            }
        }
    }

    public function action_email_assign()
    {
        if ($_POST)
        {
            $emailArr = Arr::get($_POST, 'EMAILARR', '');
            $user = Arr::get($_POST, 'user', 0);
            if (!$emailArr OR !$user)
            {
                Message::set('Assign celebrity failed!', 'error');
                $this->request->redirect('admin/site/celebrity/list');
            }
            else
            {
                $emails = explode("\n", $emailArr);
                $user_id = Session::instance()->get('user_id');
                //$admins = DB::select('id')->from('auth_user')->where('parent_id', '=', $user_id)->execute('slave')->as_array();
                $admins = DB::select('id')->from('auth_user')->where('active', '=', 1)->execute('slave')->as_array();
                $user_arr = array('id' => $user);
                foreach ($emails as $email)
                {
                    $c_admin = DB::select('id', 'admin')->from('celebrities_celebrits')->where('email', '=', $email)->execute('slave')->current();
                    $admin = array('id' => $c_admin['admin']);

                    //if(in_array($admin, $admins) OR $c_admin['admin'] == $user_id)
                    if (in_array($user_arr, $admins) OR $c_admin['admin'] == $user_id)
                    {
                        DB::update('celebrities_celebrits')->set(array('admin' => $user))->where('id', '=', $c_admin['id'])->execute();
                    }
                }
                Message::set('Assign celebrity success!', 'success');
                $this->request->redirect('admin/site/celebrity/list');
            }
        }
    }

    public function action_order_list()
    {
        $content = View::factory('admin/site/celebrity_order_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_order_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";
        $time_from = "";

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if ($item->field == 'ordernum')
                {
                    $filter_sql .= " AND orders.ordernum='" . $item->data . "'";
                }
                elseif ($item->field == 'sku')
                {
                    $filter_sql .= " AND order_items.sku='" . $item->data . "'";
                }
                elseif ($item->field == 'admin')
                {
                    $filter_data = DB::select('id')->from('auth_user')->where('name', '=', $item->data)->execute('slave')->current();
                    $filter_sql .= " AND celebrits.admin='" . $filter_data['id'] . "'";
                }
                elseif ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $filter_sql .= ' AND `orders`.' . $item->field . " between " . $from . " and " . $to;
                    $time_from = ' AND `orders`.' . $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'url')
                {
                    $filter_url = $item->data;
                }
                else
                {
                    $filter_sql .= " AND celebrits." . $item->field . "='" . $item->data . "'";
                }
            }
        }
        elseif ($_GET)
        {
            foreach ($_GET as $key => $val)
            {
                if ($key == 'ordernum')
                {
                    $filter_sql .= " AND orders.ordernum='" . $val . "'";
                }
                elseif ($key == 'sku')
                {
                    $filter_sql .= " AND order_items.sku='" . $val . "'";
                }
                elseif ($key == 'admin')
                {
                    $filter_data = DB::select('id')->from('auth_user')->where('name', '=', $val)->execute('slave')->current();
                    $filter_sql .= " AND celebrits.admin='" . $filter_data['id'] . "'";
                }
                elseif ($key == 'url')
                {
                    $filter_url = $val;
                }
                elseif ($key == 'kohana_uri')
                {
                    $filter_sql .= '';
                }
                else
                {
                    $filter_sql .= " AND celebrits." . $key . "='" . $val . "'";
                }
            }
        }

        if ($sidx == 'created')
        {
            $sidx = 'orders.created';
        }
        elseif ($sidx == 'ship_date')
        {
            $sidx = 'orders.shipping_date';
        }
        elseif ($sidx == 'id')
        {
            $sidx = 'orders.id';
            $sord = 'DESC';
        }
        else
        {
            $sidx = 'orders.id';
            $sord = 'DESC';
        }

        $limit = $limit > 10000 ? 20 : $limit;
        $count = DB::query(DATABASE::SELECT, 'SELECT count(celebrits.id) FROM `celebrits`,orders,order_items WHERE celebrits.customer_id=orders.customer_id AND orders.id=order_items.order_id AND orders.payment_status="verify_pass" AND order_items.status != "cancel" ' .
                $filter_sql)->execute('slave')->get('count(celebrits.id)');

        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;

        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT celebrits.id,celebrits.name,celebrits.admin,celebrits.email,orders.ordernum,orders.created,orders.shipping_date,order_items.sku 
                FROM `celebrits`,orders,order_items WHERE celebrits.customer_id=orders.customer_id AND orders.id=order_items.order_id AND orders.payment_status="verify_pass" AND order_items.status != "cancel" ' .
                $filter_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }
        $i = 0;
        foreach ($result as $key => $data)
        {
            $shipment = DB::select('tracking_code', 'ship_date')->from('orders_ordershipments')->where('ordernum', '=', $data['ordernum'])->execute('slave')->current();
            $urls = DB::query(Database::SELECT, 'SELECT url, show_date FROM celebrity_products WHERE ordernum=' . $data['ordernum'] . ' AND sku="' . $data['sku'] . '"')
                    ->execute('slave')->as_array();
            $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(order_items.id) AS count FROM `celebrits`,orders,order_items 
                                                WHERE celebrits.email=orders.email AND orders.id=order_items.order_id AND orders.payment_status="verify_pass" AND order_items.status != "cancel" AND order_items.sku = "' . $data['sku'] . '"' .
                    $time_from)->execute('slave')->get('count');
            if ($urls)
            {
                foreach ($urls as $url)
                {
                    $flow = DB::query(Database::SELECT, 'SELECT flow FROM celebrity_flows WHERE celebrity_id=' . $data['id'] . ' AND type="product" AND name="' . $data['sku'] . '" ORDER BY id DESC')->execute('slave')->get('flow');
                    $response['rows'][$i]['id'] = $key;
                    $response['rows'][$i]['cell'] = array(
                        $key,
                        $data['id'],
                        $data['name'],
                        $data['email'],
                        $data['ordernum'],
                        date('Y-m-d', $data['created']),
                        isset($shipment['tracking_code']) ? $shipment['tracking_code'] : '',
                        isset($shipment['ship_date']) ? date('Y-m-d', $shipment['ship_date']) : '',
                        $data['sku'],
                        $count,
                        $url['url'],
                        $url['show_date'] ? date('Y-m-d', $url['show_date']) : '',
                        $flow,
                        $users[$data['admin']],
//                                            User::instance($data['admin'])->get('name'),
                    );
                    $i++;
                }
            }
            else
            {
                $response['rows'][$i]['id'] = $key;
                $response['rows'][$i]['cell'] = array(
                    $key,
                    $data['id'],
                    $data['name'],
                    $data['email'],
                    $data['ordernum'],
                    date('Y-m-d', $data['created']),
                    isset($shipment['tracking_code']) ? $shipment['tracking_code'] : '',
                    isset($shipment['ship_date']) ? date('Y-m-d', $shipment['ship_date']) : '',
                    $data['sku'],
                    $count,
                    '',
                    '',
                    '',
                    $users[$data['admin']],
//                                    User::instance($data['admin'])->get('name'),
                );
                $i++;
            }
        }
//                print_r($response);exit;

        echo json_encode($response);
    }

    public function action_getcelebrity_orderlist()
    {
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=customers.csv');  
        echo "\xEF\xBB\xBF" . "C_id,Name,Email,Ordernum,Created,Track_code,Ship_date,Sku,Coun,Url,Show date,Flow,Admin\n";  
        $result = DB::query(DATABASE::SELECT, 'SELECT celebrits.id,celebrits.name,celebrits.admin,celebrits.email,orders.ordernum,orders.created,orders.shipping_date,order_items.sku 
                FROM `celebrits`,orders,order_items WHERE celebrits.customer_id=orders.customer_id AND orders.id=order_items.order_id AND orders.payment_status="verify_pass" AND order_items.status != "cancel"  and orders.created between 1430438400 and 1435190400')->execute('slave');

        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }
        $i = 0;
        foreach ($result as $key => $data)
        {
            $shipment = DB::select('tracking_code', 'ship_date')->from('orders_ordershipments')->where('ordernum', '=', $data['ordernum'])->execute('slave')->current();
            $urls = DB::query(Database::SELECT, 'SELECT url, show_date FROM celebrity_products WHERE ordernum=' . $data['ordernum'] . ' AND sku="' . $data['sku'] . '"')
                    ->execute('slave')->as_array();
            $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(order_items.id) AS count FROM `celebrits`,orders,order_items 
                                                WHERE celebrits.email=orders.email AND orders.id=order_items.order_id AND orders.payment_status="verify_pass" AND order_items.status != "cancel" AND order_items.created between 1430438400 and 1435190400 and order_items.sku = "' . $data['sku'] . '"')->execute('slave')->get('count');
            if ($urls)
            {
                foreach ($urls as $url)
                {
                    $flow = DB::query(Database::SELECT, 'SELECT flow FROM celebrity_flows WHERE celebrity_id=' . $data['id'] . ' AND type="product" AND name="' . $data['sku'] . '" ORDER BY id DESC')->execute('slave')->get('flow');
                    $response['rows'][$i]['id'] = $key;
                      echo  $data['id'] . ',';
                      echo  $data['name'] . ',';
                      echo  $data['email'] . ',';
                      echo  $data['ordernum'] . ',';
                      echo  date('Y-m-d', $data['created']) . ',';
                      echo  isset($shipment['tracking_code']) ? $shipment['tracking_code'] . ',' : '';
                      echo  isset($shipment['ship_date']) ? date('Y-m-d', $shipment['ship_date']) . ',' : '';
                      echo  $data['sku'] . ',';
                      echo  $count . ',';
                      echo  $url['url'] . ',';
                      echo  $url['show_date'] ? date('Y-m-d', $url['show_date']) . ',' : '';
                      echo  $flow . ',';
                      echo  $users[$data['admin']] . ',';
                      echo "\n";                      
            
                    $i++;
                }
            }
            else
            {
                    echo  $data['id'] . ',';
                    echo  $data['name'] . ',';
                    echo  $data['email'] . ',';
                    echo  $data['ordernum'] . ',';
                    echo  date('Y-m-d', $data['created']) . ',';
                    echo  isset($shipment['tracking_code']) ? $shipment['tracking_code'] . ',': '';
                    echo  isset($shipment['ship_date']) ? date('Y-m-d', $shipment['ship_date']) . ',' : '';
                    echo  $data['sku'];
                    echo  $count;
                    echo   ''. ',';
                    echo   ''. ',';
                    echo   ''. ',';
                    echo   $users[$data['admin']] . ',';
                    echo "\n";
                $i++;
            }
        }
    }

    public function action_export_products()
    {
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            $file = 'celebrities';
            if ($start)
            {
                $file .= "-from-$start";
                $sql .= ' AND order_shipments.ship_date >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $sql .= ' AND order_shipments.ship_date < ' . strtotime($end);
            }
            $admin = Arr::get($_POST, 'admin', 0);
            if ($admin)
            {
                $sql .= ' AND celebrits.admin = ' . $admin;
            }
            $c_orders = DB::query(Database::SELECT, 'SELECT orders.ordernum,orders.id,orders.shipping_date,celebrits.admin,celebrits.email,celebrits.id as c_id FROM orders,celebrits,order_shipments WHERE orders.customer_id=celebrits.customer_id AND orders.id=order_shipments.order_id AND orders.shipping_status="shipped" ' . $sql)->execute('slave')->as_array();

            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename=' . $file . '.csv');
            echo "\xEF\xBB\xBF" . "Ordernum,Email,Customer_id,Admin,Track Code,Ship Date,Sku,Url\n";
            $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
            $users = array();
            foreach ($userArr as $user)
            {
                $users[$user['id']] = $user['name'];
            }
            foreach ($c_orders as $c)
            {
//                                $admin = User::instance($c['admin'])->get('name');
                $products = DB::select('sku')->from('orders_orderitem')->where('order_id', '=', $c['id'])->execute('slave')->as_array();
                $track_code = DB::select('tracking_code')->from('orders_ordershipments')->where('ordernum', '=', $c['ordernum'])->execute('slave')->get('tracking_code');
                foreach ($products as $product)
                {
                    $urls = DB::select('url')->from('celebrities_celebrityorder')->where('ordernum', '=', $c['ordernum'])->and_where('sku', '=', $product['sku'])->execute('slave')->as_array();
                    if (count($urls) > 0)
                    {
                        foreach ($urls as $url)
                        {
                            echo $c['ordernum'] . ',';
                            echo $c['email'] . ',';
                            echo $c['c_id'] . ','; 
                            echo '"' . $users[$c['admin']] . '"' . ',';
                            echo "'" . $track_code . ',';
                            echo date('Y-m-d', $c['shipping_date']) . ',';
                            echo $product['sku'] . ',';
                            echo $url['url'] . ',';
                            echo "\n";
                        }
                    }
                    else
                    {
                        echo $c['ordernum'] . ',';
                        echo $c['email'] . ',';
                        echo '"' . $admin . '"' . ',';
                        echo "'" . $track_code . ',';
                        echo date('Y-m-d', $c['shipping_date']) . ',';
                        echo $product['sku'] . ',';
                        echo ',';
                        echo "\n";
                    }
                }
            }
        }
    }

    public function action_export_urls()
    {
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            $file = 'celebrities-urls';
            $sqls = array();
            if ($start)
            {
                $file .= "-from-$start";
                $sqls[] = 'O.created >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $sqls[] = 'O.created < ' . strtotime($end);
            }
            $sql = implode(' AND ', $sqls);
            $c_orders = DB::query(Database::SELECT, 'SELECT P.ordernum, P.sku, P.url, O.created FROM celebrity_products P LEFT JOIN orders O ON P.order_id = O.id WHERE ' . $sql . ' ORDER BY P.ordernum')->execute('slave');

            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename=' . $file . '.csv');
            echo "\xEF\xBB\xBF" . "Ordernum,Created,SKU,URL\n";
            foreach ($c_orders as $c)
            {
                echo $c['ordernum'] . ',';
                echo date('Y-m-d H:i:s', $c['created']) . ',';
                echo $c['sku'] . ',';
                echo $c['url'] . ',';
                echo "\n";
            }
        }
    }

    public function action_edit_url()
    {
        if ($_POST)
        {
            if (!isset($_POST['url']) AND !isset($_POST['newurl']) AND !isset($_POST['delete_url']))
            {
                Message::set('Edit Url Faild', 'error');
                echo '<script language="javascript">top.location.replace("http://' . $_SERVER['HTTP_HOST'] . '/admin/site/celebrity/order_list?' . $_POST['query_string'] . '");</script>';
                exit;
            }
            $delete_url = Arr::get($_POST, 'delete_url', array());
            foreach ($delete_url as $d_url)
            {
                DB::delete('celebrities_celebrityorder')->where('celebrity_id', '=', $_POST['celebrity_id'])->and_where('url', '=', $d_url)->execute();
            }
            $urlArr = Arr::get($_POST, 'url', array());
            foreach ($urlArr as $key => $u)
            {
                if (!$u)
                    unset($urlArr[$key]);
            }
            $newUrl = Arr::get($_POST, 'newurl', array());
            foreach ($newUrl as $key => $u)
            {
                if (!$u)
                    unset($newUrl[$key]);
            }
            $success = 0;
            $show_date = Arr::get($_POST, 'show_date', array());
            if (!empty($urlArr))
            {
                foreach ($urlArr as $key => $url)
                {
                    $url = trim($url);
                    $result = DB::select('url')->from('celebrities_celebrityorder')
                            ->where('id', '=', $key)
                            ->execute('slave')->current();
                    if ($result['url'])
                    {
                        $date = isset($show_date[$key]) && $show_date[$key] ? strtotime($show_date[$key]) : 0;
                        $data = array('url' => $url, 'show_date' => $date);
                        $result1 = DB::update('celebrities_celebrityorder')->set($data)->where('id', '=', $key)->execute();
                        if ($result1)
                            $success++;
                    }
                }
            }

            $new_date = Arr::get($_POST, 'new_date', array());
            if (!empty($newUrl))
            {
                $data = array();
                $data['celebrity_id'] = Arr::get($_POST, 'celebrity_id', 0);
                $data['ordernum'] = Arr::get($_POST, 'ordernum', '');
                $data['order_id'] = Order::get_from_ordernum($data['ordernum']);
                $data['sku'] = Arr::get($_POST, 'sku', '');
                foreach ($newUrl as $key => $url)
                {
                    $data['url'] = trim($url);
                    $data['show_date'] = isset($new_date[$key]) && $new_date[$key] ? strtotime($new_date[$key]) : 0;
                    $result1 = DB::insert('celebrity_products', array_keys($data))->values($data)->execute();
                    if ($result1)
                        $success++;
                }
            }

            if ($success)
            {
                Message::set($success . ' Url Edit Success', 'success');
                echo '<script language="javascript">top.location.replace("http://' . $_SERVER['HTTP_HOST'] . '/admin/site/celebrity/order_list?' . $_POST['query_string'] . '");</script>';
                exit;
            }
            else
            {
                Message::set('Edit Url Faild', 'error');
                echo '<script language="javascript">top.location.replace("http://' . $_SERVER['HTTP_HOST'] . '/admin/site/celebrity/order_list?' . $_POST['query_string'] . '");</script>';
                exit;
            }
        }

        $id = $this->request->param('id');
        $email = DB::select('email')->from('celebrities_celebrits')->where('id', '=', $id)->execute('slave')->current();
        $sku = $_GET['sku'];
        $ordernum = $_GET['ordernum'];
        $query_strings = explode('&', $_SERVER['QUERY_STRING']);
        $query = array();
        foreach ($query_strings as $key => $string)
        {
            if ($key > 1)
            {
                $query[] = substr($string, 3);
            }
        }
        $query_string = implode('&', $query);
        $url = DB::select('id', 'url', 'show_date')->from('celebrities_celebrityorder')
                ->where('celebrity_id', '=', $id)
                ->and_where('ordernum', '=', $ordernum)
                ->and_where('sku', '=', $sku)
                ->execute('slave')->as_array();
        $this->request->response = View::factory('admin/site/celebrity_edit_url')
            ->set('celebrity_id', $id)
            ->set('celebrity_email', $email['email'])
            ->set('ordernum', $ordernum)
            ->set('sku', $sku)
            ->set('url', $url)
            ->set('query_string', $query_string)
            ->render();
    }

    public function action_upload()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $admin = Session::instance()->get('user_id');
        while ($data = fgetcsv($handle))
        {
            if ($row == 1)
            {
                $blog_keys = array();
                if (isset($data[6]))
                {
                    for ($i = 6; $i < count($data); $i++)
                    {
                        $blog_keys[$i] = $data[$i];
                    }
                }
                $row++;
                continue;
            }
            try
            {
                $data = Security::xss_clean($data);
                $celebrity = array();
                $celebrity['email'] = $data[1];
                $result = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $celebrity['email'])->execute('slave')->current();
                if ($result['id'])
                {
                    $error[] = "Add celebrity " . $celebrity['email'] . " Fail: Duplicate Email.";
                    $row++;
                    continue;
                }
                $customer = DB::select('id')
                        ->from('accounts_customers')
                        ->where('email', '=', $celebrity['email'])
                        ->where('site_id', '=', $this->site_id)
                        ->execute('slave')->current();
                if (!empty($customer))
                {
                    $celebrity['customer_id'] = $customer['id'];
                }
                $celebrity['name'] = $data[0];
                $celebrity['country'] = $data[2];
                $celebrity['sex'] = $data[6];
                $celebrity['birthday'] = strtotime($data[7]);
                $celebrity['level'] = $data[8];
                $celebrity['admin'] = $admin;
                $celebrity['created'] = time();
                $result1 = DB::insert('celebrits', array_keys($celebrity))->values($celebrity)->execute();
                if (!$result1)
                {
                    $error[] = "Add celebrity " . $celebrity['email'] . " Fail.";
                }
                else
                {
                    foreach ($blog_keys as $key => $blog_key)
                    {
                        if (!$data[$key])
                        {
                            continue;
                        }
                        $blog = array();
                        $blog['celebrity_id'] = $result1[0];
                        $blog['celebrity_email'] = $data[1];
                        $blog['type'] = $blog_key;
                        $urlArr = explode(':', $data[$key]);
                        $blog['url'] = $urlArr[0];
                        $blog['profile'] = $urlArr[1] ? $urlArr[1] : 0;
                        DB::insert('celebrity_blogs', array_keys($blog))->values($blog)->execute();
                    }
                }
                $row++;
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        $num = $row - count($error) - 2;
        die("Upload " . $num . " celebrities successfully.");
    }

    public function action_export()
    {
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            $file = 'celebrities';
            $sql = '';
            if ($start)
            {
                $file .= "-from-$start";
                $sql .= 'WHERE created >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $sql .= ' AND created < ' . strtotime($end);
            }

            $filename = $file.'.csv';

            $celebrities = DB::query(Database::SELECT, 'SELECT * FROM celebrits ' . $sql)->execute('slave');
            
            /** Error reporting */
            error_reporting(E_ALL);
//                        date_default_timezone_set('America/Chicago');
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            echo "\xEF\xBB\xBF" . "id,name,email,country,state,city,address,sex,birthday,level,admin,created,is able,Blogs\n";
            $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
            $users = array();
            foreach ($userArr as $user)
            {
                $users[$user['id']] = $user['name'];
            }
            foreach ($celebrities as $celebritiy)
            {   
                echo $celebritiy['id'] . ',';
                echo $celebritiy['name'] . ',';
                echo $celebritiy['email'] . ',';
                echo $celebritiy['country'] . ',';
                echo isset($celebritiy['state']) ? $celebritiy['state'] : '', ',';
                echo isset($celebritiy['city']) ? $celebritiy['city'] : '', ',';
                $address = isset($celebritiy['address']) ? $celebritiy['address'] : '';
                if($address)
                {
                    $address = str_replace(',', ';', $celebritiy['address']);
                }
                
                echo $address, ',';
                echo $celebritiy['sex'] == 1 ? 'Man,' : 'Woman,';
                echo date('Y-m-d', $celebritiy['birthday']) . ',';
                echo $celebritiy['level'] . ',';
//                                echo user::instance($celebritiy['admin'])->get('name') . ',';
                echo isset($users[$celebritiy['admin']]) ? $users[$celebritiy['admin']] : '' . ',';
                echo date('Y-m-d', $celebritiy['created']) . ',';
                echo $celebritiy['is_able'] . ',';
                $blogs = '';
                $result = DB::select('url')->from('celebrity_blogs')->where('celebrity_id', '=', $celebritiy['id'])->execute('slave')->as_array();
                if (!empty($result))
                {
                    foreach ($result as $val)
                    {
                        $blogs .= $val['url'] . ',';
                    }
                }
                echo '"' . $blogs . '",';
                echo "\n";
            }

        }
    }

    public function action_flow()
    {
        $content = View::factory('admin/site/celebrity_flow')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_flow_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";
        $_filter_sql = array();

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if ($item->field == 'admin')
                {
                    $admin = DB::select('id')->from('auth_user')->where('name', '=', $item->data)->execute('slave')->get('id');
                    $_filter_sql[] = "celebrits.admin=" . $admin;
                }
                elseif ($item->field == 'email')
                {
                    $celebrity_id = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $item->data)->execute('slave')->get('id');
                    $_filter_sql[] = "celebrity_flows.celebrity_id=" . $celebrity_id;
                }
                else
                {
                    $_filter_sql[] = "celebrity_flows." . $item->field . "='" . $item->data . "'";
                }
            }
        }
        if (!empty($_filter_sql))
            $filter_sql = " WHERE " . implode(' AND ', $_filter_sql);

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $count = DB::query(Database::SELECT, 'SELECT COUNT(celebrity_flows.id) AS count FROM 
                                celebrity_flows LEFT JOIN celebrits ON celebrity_flows.celebrity_id=celebrits.id ' . $filter_sql)
                ->execute('slave')->get('count');
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT celebrity_flows.id,celebrity_flows.celebrity_id,
                                celebrity_flows.type,celebrity_flows.name,celebrity_flows.flow,celebrits.email,celebrits.admin 
                                FROM celebrity_flows LEFT JOIN celebrits ON celebrity_flows.celebrity_id=celebrits.id ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }
        $i = 0;
        foreach ($result as $data)
        {
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                $data['id'],
                $data['celebrity_id'],
                $data['email'],
                $data['type'],
                $data['name'],
                $data['flow'],
                $users[$data['admin']]
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_backups()
    {
        $admins = DB::query(Database::SELECT, 'SELECT id,name FROM users WHERE id > 100')->execute('slave')->as_array();
        $content = View::factory('admin/site/celebrity_backups')->set('admins', $admins)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_backups_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";
        $_filter_sql = array();

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {

                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'country')
                {
                    $country = DB::select('isocode')->from('countries')->where('name', '=', $item->data)->execute('slave')->get('isocode');
                    $_filter_sql[] = $item->field . "='" . $country . "'";
                }
                else
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
            }
        }
        if (!empty($_filter_sql))
            $filter_sql = " WHERE " . implode(' AND ', $_filter_sql);

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM celebrity_backups' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM celebrity_backups' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $data)
        {
            $siteArr = unserialize($data['sites']);
            $sites = '';
            if (!empty($siteArr))
            {
                foreach ($siteArr as $key => $val)
                {
                    $sites .= $val['url'] . ': ' . $val['flow'] . '<br>';
                }
            }

            $name = DB::query(DATABASE::SELECT,"select U.name from celebrits C left join users U on C.admin=U.id 
                where C.email='".$data['email']."' limit 1")->execute('slave')->get('name');
            $assign_name = user::instance($data['assign'])->get('name');
            $country = DB::select('name')->from('countries')->where('isocode', '=', $data['country'])->execute('slave')->get('name');
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                '',
                $data['id'],
                $data['email'],
                $sites,
                $data['comment'],
                $data['gender'],
                $country,
                $data['is_join'],
                date('Y-m-d', $data['created']),
                $name?$name:"",
                $assign_name?$assign_name:"", 
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_backup_assign()
    {
        if ($_POST)
        {
            $id = Arr::get($_POST, 'celebrity_id', 0);
            $admin = Arr::get($_POST, 'user', 0);
            if (!$id OR !$admin)
            {
                $data = 'Assign Backup Celebrity Error!';
            }
            else
            {
                $backups = DB::select()->from('celebrity_backups')->where('id', '=', $id)->and_where('is_join', '=', 0)->execute('slave')->current();
//                                $celebrity = array(
//                                    'email' => $backups['email'],
//                                    'sex' => 2,
//                                    'level' => 3,
//                                    'admin' => $admin,
//                                    'created' => time(),
//                                    'updated' => time()
//                                );
//                                $result = DB::insert('celebrits', array_keys($celebrity))->values($celebrity)->execute();
//                                if($result)
                if (!empty($backups))
                {
//                                        $celebrity_id = $result[0];
                    $sites = unserialize($backups['sites']);
                    $body = $backups['email'] . '<br>';
                    foreach ($sites as $key => $site)
                    {
//                                                $blog = array(
//                                                    'celebrity_id' => $celebrity_id,
//                                                    'celebrity_email' => $backups['email'],
//                                                    'type' => $site['type'],
//                                                    'url' => $site['url'],
//                                                    'profile' => $site['flow'],
//                                                );
//                                                DB::insert('celebrity_blogs', array_keys($blog))->values($blog)->execute();
                        $body .= $site['url'] . ': ' . $site['flow'] . '<br>';
                    }
                    DB::update('celebrity_backups')->set(array('is_join' => 1))->where('id', '=', $id)->execute();

                    //send email
                    $rcpt = User::instance($admin)->get('email');
                    $from = 'business@choies.com';
                    $subject = 'Choies Collaboration';
                    $body .= $backups['comment'];
                    Mail::Send($rcpt, $from, $subject, $body);

                    $data = 'Success';
                }
                else
                {
                    $data = 'Assign Backup Celebrity Failed!';
                }
            }
        }
        echo json_encode($data);
        exit;
    }

    public function action_backup_bulkassign()
    {
        if ($_POST)
        {
            $admin = Arr::get($_POST, 'user', 0);
            $ids = Arr::get($_POST, 'ids', array());
            $error = '';
            if (empty($ids) OR !$admin)
            {
                $error = 'Assign Backup Celebrity Error!';
            }
            else
            {
                foreach ($ids as $id)
                {
                    $backups = DB::select()->from('celebrity_backups')->where('id', '=', $id)->and_where('is_join', '=', 0)->execute('slave')->current();
                    if (!empty($backups))
                    {
                        $sites = unserialize($backups['sites']);
                        $body = $backups['email'] . '<br>';
                        foreach ($sites as $key => $site)
                        {
                            $body .= $site['url'] . ': ' . $site['flow'] . '<br>'; 
                        }
                        DB::update('celebrity_backups')->set(array('is_join' => 1,'assign'=>$admin))->where('id', '=', $id)->execute();

                        //send email
                        $rcpt = User::instance($admin)->get('email');
                        $from = 'business@choies.com';
                        $subject = 'Choies Collaboration';
                        $body .= $backups['comment'];
                        Mail::Send($rcpt, $from, $subject, $body);
                    }
                    else
                    {
                        $error .= 'Assign Backup Celebrity ' . $id . ' Failed!<br/>';
                    }
                }
            }
            echo $error ? $error : 'All Backup Celebrities Assign Success!';
        }
    }

    public function action_backup_delete($id)
    {
        $result = DB::delete('celebrity_backups')->where('id', '=', $id)->execute();
        echo $result ? 'success' : '失败';
    }

    public function action_backup_bulkdelete()
    {
        if ($_POST)
        {
            $ids = Arr::get($_POST, 'ids', array());
            $error = '';
            if (empty($ids))
            {
                $error = 'Delete Backup Celebrites Failed!';
            }
            else
            {
                foreach ($ids as $id)
                {
                    $result = DB::delete('celebrity_backups')->where('id', '=', $id)->execute();
                    if (!$result)
                    {
                        $error .= 'Delete Backup Celebrity ' . $id . ' Failed!<br/>';
                        ;
                    }
                }
            }
            echo $error ? $error : 'All Backup Celebrities Delete Success!';
        }
    }

    public function action_backup_export()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'start', 0));
//                $date += 28800; /* 8 hours */		
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'end', 0);

        if ($date_end)
        {
            $file_name = "celebrity_backups-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
//			$date_end += 28800;
        }
        else
        {
            $file_name = "celebrity_backups-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "ID,Email,Sites,Comment,Created,Is Assign\n";
        $result = DB::query(Database::SELECT, 'SELECT * FROM celebrity_backups WHERE created BETWEEN ' . $date . ' AND ' . $date_end)->execute('slave');
        foreach ($result as $data)
        {
            echo $data['id'] . ',';
            echo $data['email'] . ',';
            $siteArr = unserialize($data['sites']);
            $sites = '';
            if (!empty($siteArr))
            {
                foreach ($siteArr as $key => $val)
                {
                    $sites .= $val['url'] . ': ' . $val['flow'] . '; ';
                }
            }
            echo $sites . ',';
            echo '"' . $data['comment'] . '",';
            echo date('Y-m-d', $data['created']) . ',';
            echo $data['is_join'] . ',';
            echo "\n";
        }
    }

    public function action_fee()
    {
        $content = View::factory('admin/site/celebrity_fee')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_fee_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";
        $_filter_sql = array();

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {

                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'admin')
                {
                    $user = ORM::factory('user')->where('name', '=', $item->data)->find();
                    $_filter_sql[] = $item->field . "='" . $user->id . "'";
                }
                else
                {
                    $_filter_sql[] = "`" . $item->field . "`='" . $item->data . "'";
                }
            }
        }
        if (!empty($_filter_sql))
            $filter_sql = " WHERE " . implode(' AND ', $_filter_sql);

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM celebrity_fees ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM celebrity_fees ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }
        foreach ($result as $data)
        {
            $customer = ORM::factory('customer')
                ->where('email', '=', $data['email'])
                ->where('site_id', '=', $this->site_id)
                ->find();
            if ($customer->loaded())
            {
                $customer_id = $customer->id;
            }
            else
            {
                $customer_id = '';
            }
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                $data['id'],
                date('Y-m-d H:i', $data['created']),
                $data['email'],
                $data['pp_account'],
                $data['fee'],
                $data['currency'],
                $data['for'],
                isset($users[$data['admin']]) ? $users[$data['admin']] : '',
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_fee_add()
    {
        try
        {
            if ($_POST)
            {
                $email = trim(Arr::get($_POST, 'email', ''));
                $admin = Session::instance()->get('user_id');
                $c_id = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->and_where('admin', '=', $admin)->execute('slave')->get('id');
                if (!$c_id)
                {
                    echo json_encode('This Is Not Your Celebrity!');
                    exit;
                }
                $data['pp_account'] = trim(Arr::get($_POST, 'pp', ''));
                $data['fee'] = (float) Arr::get($_POST, 'fee', '');
                if (!$data['pp_account'] OR !$data['fee'])
                {
                    echo json_encode('Your input is incorrect!');
                    exit;
                }
                $data['celebrity_id'] = $c_id;
                $data['email'] = $email;
                $data['admin'] = $admin;
                $data['fee'] = round($data['fee'], 2);
                $data['currency'] = Arr::get($_POST, 'currency', 'USD');
                $data['for'] = Arr::get($_POST, 'what_for', 'USD');
                $data['created'] = $_POST['created'] ? strtotime($_POST['created']) : time();
                $result = DB::insert('celebrity_fees', array_keys($data))->values($data)->execute();
                if ($result)
                {
                    echo json_encode('success');
                }
                else
                {
                    echo json_encode('Add Celebrity Fee failed');
                }
            }
        }
        catch (Exception $e)
        {
            echo json_encode($e);
        }
    }

    public function action_fee_edit($id)
    {
        $id = $id = $this->request->param('id');
        $fee = Arr::get($_GET, 'fee', 0);
        try
        {
            if (!$fee)
            {
                echo 'Fee Cannot Be Zero';
            }
            else
            {
                $result = DB::update('celebrity_fees')->set(array('fee' => round($fee, 2)))->where('id', '=', $id)->execute();
                echo $result ? 'success' : 'Failed';
            }
        }
        catch (Exception $e)
        {
            echo $e;
        }
    }

    public function action_fee_delete($id)
    {
        try
        {
            $result = DB::delete('celebrity_fees')->where('id', '=', $id)->execute();
            echo $result ? 'success' : 'Failed';
        }
        catch (Exception $e)
        {
            echo $e;
        }
    }

    public function action_contacted()
    {
        $content = View::factory('admin/site/celebrity_contacted')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_contacted_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";
        $_filter_sql = array();

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {

                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'admin')
                {
                    $user = ORM::factory('user')->where('name', '=', $item->data)->find();
                    $_filter_sql[] = $item->field . "='" . $user->id . "'";
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
        }
        if (!empty($_filter_sql))
            $filter_sql = " WHERE " . implode(' AND ', $_filter_sql);

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM celebrity_contacted ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM celebrity_contacted ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }
        $i = 0;
        foreach ($result as $data)
        {
            $celebrity_id = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $data['email'])->execute('slave')->get('id');
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                0,
                $data['id'],
                date('Y-m-d H:i', $data['created']),
                $celebrity_id,
                $data['email'],
                $data['sites'],
                $users[$data['admin']],
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_contacted_import()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $admin = Session::instance()->get('user_id');
        while ($data = fgetcsv($handle))
        {
            try
            {
                $data = Security::xss_clean($data);
                $celebrity = array();
                if ($data[0])
                {
                    $celebrity['email'] = $data[0];
                    $celebrity['sites'] = $data[1];
                    $celebrity['admin'] = Session::instance()->get('user_id');
                    $celebrity['created'] = time();
                    DB::insert('celebrity_contacted', array_keys($celebrity))->values($celebrity)->execute();
                    $row++;
                }
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        $num = $row - count($error) - 2;
        die("Upload " . $num . " celebrities successfully.");
    }

    public function action_contacted_delete()
    {
        if ($_POST)
        {
            $ids = Arr::get($_POST, 'ids', array());
            if (empty($ids))
            {
                Message::set('Delete data failed!', 'error');
                $this->request->redirect('admin/site/celebrity/contacted');
            }
            else
            {
                $user_id = Session::instance()->get('user_id');
                $parent = DB::select('parent_id', 'role_id')->from('auth_user')->where('id', '=', $user_id)->execute('slave')->current();
                if ($parent['parent_id'] == 0 AND $parent['role_id'] == 4)
                {
                    DB::delete('celebrity_contacted')->where('id', 'IN', $ids)->execute();
                    Message::set('Delete data success!', 'success');
                }
                else
                    Message::set('Delete data failed!', 'error');
                $this->request->redirect('admin/site/celebrity/contacted');
            }
        }
    }

    public function action_exprotcsv()
    {
        ob_end_clean();
        ob_start();
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition: attachment; filename=Celebrity_' . date('Y-m-d', time()) . '.xls');
        header("Content-Transfer-Encoding: binary ");

        $buffer = $_POST['csvBuffer'];
        $buffer = iconv("utf-8", "gbk", $buffer);
        try
        {
            echo $buffer;
        }
        catch (Exception $e)
        {
            echo 'Sorry, Server is too busy, please try again later,THX.';
        }
    }

    public function action_exprot_all()
    {
        $start = $_POST['start'] ? strtotime($_POST['start']) : strtotime('2013-07-01');
        $end = $_POST['end'] ? ( strtotime($_POST['end']) + 86400 ) : time();

        $result = DB::select()->from('celebrity_contacted')->where('created', 'between', array($start, $end))->execute('slave');

        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }

        $file = 'fii';
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=' . $file . '.csv');
        echo "\xEF\xBB\xBF" . "Id,Created,C Id,Email,Sites,Admin\n";

        foreach ($result as $data)
        {
            $celebrity_id = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $data['email'])->execute('slave')->get('id');

            echo $data['id'] . ',';
            echo date('Y-m-d', $data['created']) . ',';
            echo "'" . $celebrity_id . ',';
            echo '"' . $data['email'] . '"' . ',';
            echo "'" . $data['sites'] . ',';
            echo '"' . $users[$data['admin']] . '"' . ',';
            echo "\n";
        }
    }

    public function action_export_orders()
    {
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            $file = 'celebrities';
            $sql = '';
            if ($start)
            {
                $file .= "-from-$start";
                $sql .= ' AND o.created >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $sql .= ' AND o.created < ' . strtotime($end);
            }
            $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
            $users = array();
            foreach ($userArr as $user)
            {
                $users[$user['id']] = $user['name'];
            }
            $result = DB::query(Database::SELECT, 'SELECT c.name,c.email,c.admin,o.created,o.ordernum,o.verify_date,i.sku,i.product_id FROM `celebrits` c,orders o,order_items i 
                                WHERE c.customer_id=o.customer_id AND o.id=i.order_id AND o.payment_status="verify_pass" AND i.status != "cancel" ' . $sql . ' ORDER BY o.created')
                ->execute('slave');
            $filename = $file.'.csv';
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            echo "\xEF\xBB\xBF" . "Email,Name,Created,Ordernum,Verify_date,SKU,Price,Admin\n";

            foreach ($result as $data)
            {

                $pro = Product::instance($data['product_id']);    
                if($pro->get('id') !== NULL && $pro->get('status') == 1)
                {
                $price = $pro->price();
                echo $data['email'] . ',';
                echo $data['name'] . ',';
                echo date('Y-m-d', $data['created']) . ',';
                echo $data['ordernum'] . ',';
                echo date('Y-m-d', $data['verify_date']) . ',';
                echo $data['sku'] . ',';
                echo '"' . $price . '"' . ',';
                echo '"' . $users[$data['admin']] . '"' . ',';
                echo "\n";
                }
            }
        }
    }

    public function action_special_bulkfor()
    {
        $file_types = array(
            "application/vnd.ms-excel",
            "text/csv",
            "application/csv",
            "text/comma-separated-values",
            "application/octet-stream",
            "application/oct-stream"
        );
        if (!isset($_FILES) || (!in_array($_FILES["file"]["type"], $file_types)))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $admin = Session::instance()->get('user_id');
        $success = array();
   //     $types = Kohana::config('promotion.types');
        while ($data = fgetcsv($handle))
        {

            try
            {
                if ($data[0] == 'email' OR $data[0] == 'email')
                {
                    $row++;
                    continue;
                }
          //      $array = array();
                if ($data[0])
                {

                    $email1 = $data[0];

                            $updates = DB::delete('celebrities_celebrits')->where('email', '=', $email1)->execute();
                            print_r($updates);



                    $row++;
                }
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        $successes = implode("<br/>", $success);
        die("Success skus:<br/>" . $successes);
    }

    public function action_import_basic()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $basics = array();
        $head = array();
        $amount = 0;
        $success = '';
        $columns = array();
        $result = DB::query(1, 'SHOW COLUMNS FROM celebrits')->execute();
        foreach ($result as $c)
        {
            $columns[] = $c['Field'];
        }
        while ($data = fgetcsv($handle))
        {
            foreach ($data as $key => $val)
            {
                $val = str_replace('', "\n", $val);
                $data[$key] = Security::xss_clean(iconv('gbk', 'utf-8', $val));
            }

            if ($row == 1)
            {
                foreach ($data as $val)
                {
                    $head[] = strtolower(trim($val));
                }
            }
            else
            {
                $basic = array();
                foreach ($data as $key => $value)
                {
                    if (!$key OR $value == '')
                        continue;
                    if ($head[$key] == 'taobao_url')
                    {
                        $query = parse_url($value, PHP_URL_QUERY);
                        parse_str($query, $GET);
                        if (isset($GET['id']))
                            $basic['taobao_id'] = $GET['id'];
                        elseif (isset($GET['default_item_id']))
                            $basic['taobao_id'] = $GET['default_item_id'];
                        else
                            $basic['taobao_id'] = '';
                        $basic[$head[$key]] = $value;
                    }
                    elseif ($head[$key] == 'admin')
                    {
                        $admin = DB::select('id')->from('auth_user')->where('name', '=', $value)->execute('slave')->get('id');
                        $basic[$head[$key]] = $admin;
                    }
                    elseif ($head[$key] == 'attributes')
                    {
                        $attributes = array();
                        $attributes['Size'] = explode("#", $value);
                        $basic[$head[$key]] = serialize($attributes);
                    }
                    elseif ($head[$key] == 'filter_attributes')
                    {
                        $basic[$head[$key]] = $value;
                        $basic['oid'] = 0;
                    }
                    else
                        $basic[$head[$key]] = $value;
                }
                $email = trim($data[0]);
                $celebrity_id = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->execute()->get('id');
                if ($celebrity_id AND !empty($basic))
                {
                    $check_columns = 1;
                    foreach ($basic as $key => $val)
                    {
                        if (!in_array($key, $columns))
                        {
                            $check_columns = 0;
                            break;
                        }
                    }
                    if ($check_columns && !empty($basic))
                    {
                        $result = DB::update('celebrities_celebrits')->set($basic)->where('id', '=', $celebrity_id)->execute();
                        if($result)
                        {
                            $success .= $email . '<br>';
                            $amount ++;
                        }
                    }
                }
            }
            $row++;
        }
        if($success)
        {
            Kohana_log::instance()->add('upload celebrits basic-' . Session::instance()->get('user_id'), implode(',', $head) . ': ' . str_replace('<br>', ',', $success));
        }
        echo $amount . ' celebrits basics import successfully:<br>';
        echo $success;
    }

public function action_input_bwh()
    {

        //验证输入
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" 
            && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" 
            && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        //循环读取数据
        
        //校验入数据库

        //写log
        //成功页面提示

        $data_arr = array();
        if (( $handle  =  fopen ( $_FILES['file']['tmp_name'] ,  "r" )) !==  FALSE ) {
            while (( $data  =  fgetcsv ( $handle ,  1000 ,  "," )) !==  FALSE ) {
               $data_arr[]=$data;
               //var_dump($data);
            }
             fclose ( $handle );
        }
        //var_dump($data_arr);
        $data_arr2=array();
        for ($i=1;$i<count($data_arr);$i++) {
            $data_arr2[$i-1]['email']=trim($data_arr[$i][0]);
            $data_arr2[$i-1]['height']=intval(trim($data_arr[$i][1]));
            $data_arr2[$i-1]['weight']=intval(trim($data_arr[$i][2]));
            $data_arr2[$i-1]['bust']=intval(trim($data_arr[$i][3]));
            $data_arr2[$i-1]['waist']=intval(trim($data_arr[$i][4]));
            $data_arr2[$i-1]['hips']=intval(trim($data_arr[$i][5]));
        }
         //var_dump($data_arr2);
         try{
            foreach ($data_arr2 as $drr) {
            $sql='update celebrits set height='.$drr['height'].' ,weight='.$drr['weight'].' ,bust='.$drr['bust'].' ,waist='.$drr['waist'].' ,hips='.$drr['hips'].' where email="'.$drr['email'].'"';
            $result = DB::query(Database::UPDATE, $sql)
                ->execute();
         }
         }catch(Exception $e){
            echo $e->getMessage();
            exit();
         }
         //echo json_encode($data_arr2);
         //exit();
         
         Kohana_log::instance()->add('upload celebrits BWH' ,json_encode($data_arr2));
         echo "success";
         


    }

public function action_output_celebrity_info()
    {




        //验证输入
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" 
            && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" 
            && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        //循环读取数据
         $data_arr = array();
        if (( $handle  =  fopen ( $_FILES['file']['tmp_name'] ,  "r" )) !==  FALSE ) {
            while (( $data  =  fgetcsv ( $handle ,  1000 ,  "," )) !==  FALSE ) {
               $data_arr[]=$data;
               //var_dump($data);
            }
             fclose ( $handle );
        }
        //var_dump($data_arr);
        $data_arr2=array();
        for ($i=1;$i<count($data_arr);$i++) {
            $data_arr2[$i-1]['email']=trim($data_arr[$i][0]);
        }
        //var_dump($data_arr2);
        //exit();
        $res_data_arr=array();
         try{
            foreach ($data_arr2 as $drr) {
                $sql='select addresses.state,addresses.city,addresses.address
                    from celebrits
                    inner join addresses on celebrits.customer_id=addresses.customer_id
                    where celebrits.email="'.$drr['email'].'"
                    limit 1

                ';
            //$sql='select celebrits from set height='.$drr['height'].' ,weight='.$drr['weight'].' ,bust='.$drr['bust'].' ,waist='.$drr['waist'].' ,hips='.$drr['hips'].' where email="'.$drr['email'].'"';
            $result = DB::query(Database::SELECT, $sql)
                ->execute();
                if(!empty($result)){
                    foreach ($result as $r) {
                        //var_dump($r);
                        //exit();
                        $res_data_arr[$drr['email']]['state']=$r['state'];
                        $res_data_arr[$drr['email']]['city']=$r['city'];
                        $res_data_arr[$drr['email']]['address']=$r['address'];
                        //var_dump($res_data_arr);
                        //exit();
                    }
                }else{
                    $res_data_arr[$drr['email']]['state']='';
                        $res_data_arr[$drr['email']]['city']='';
                        $res_data_arr[$drr['email']]['address']='';
                }
            }
         }catch(Exception $e){
            echo $e->getMessage();
            exit();
         }
         //echo json_encode($data_arr2);
         //exit();
         
         //var_dump($res_data_arr);
            error_reporting(E_ALL);
            date_default_timezone_set('America/Chicago');
            header("Content-type:text/csv");   
            header("Content-Disposition:attachment;filename=none.csv");
            $str='';
            $str.="\xEF\xBB\xBF" .'email,state,city,address'."\n";
            echo $str;
            foreach ($res_data_arr as $k=>$v) {
                $str=$k.','.$v['state'].','.$v['city'].','.$v['address']."\n";
                echo $str;
            }
    }




    public function action_output_celebrity_amount()
    {



        //验证输入
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" 
            && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" 
            && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        //循环读取数据
         $data_arr = array();
        if (( $handle  =  fopen ( $_FILES['file']['tmp_name'] ,  "r" )) !==  FALSE ) {
            while (( $data  =  fgetcsv ( $handle ,  1000 ,  "," )) !==  FALSE ) {
               $data_arr[]=$data;
               //var_dump($data);
            }
             fclose ( $handle );
        }
        //var_dump($data_arr);
        $data_arr2=array();
        for ($i=1;$i<count($data_arr);$i++) {
            $data_arr2[$i-1]['email']=trim($data_arr[$i][0]);
        }
        //var_dump($data_arr2);
        //exit();
        $res_data_arr=array();
         try{
            foreach ($data_arr2 as $drr) {
                $sql='select orders.id oid,order_items.sku sku, orders.amount_coupon coupon,orders.amount_point points,orders.amount amount
                    from orders
                    inner join order_items on orders.id=order_items.order_id
                    WHERE orders.payment_status in ("success","verify_pass") AND orders.email="'.$drr['email'].'"
                    

                ';
            //$sql='select celebrits from set height='.$drr['height'].' ,weight='.$drr['weight'].' ,bust='.$drr['bust'].' ,waist='.$drr['waist'].' ,hips='.$drr['hips'].' where email="'.$drr['email'].'"';
            $result = DB::query(Database::SELECT, $sql)
                ->execute();
                if(!empty($result)){
                    foreach ($result as $r) {
                        //var_dump($r);
                        //exit();
                        $re=array();
                        $re['email']=$drr['email'];
                        $re['order_id']=$r['oid'];
                        $re['sku']=$r['sku'];
                        $re['all_amount']=number_format(floatval($r['coupon'])+floatval($r['points'])+floatval($r['amount']), 2);
                        $re['amount']=$r['amount'];



                        $res_data_arr[]=$re;
                        //var_dump($res_data_arr);
                        //exit();
                    }
                }
                // }else{
                //     $res_data_arr[$drr['email']]['state']='';
                //         $res_data_arr[$drr['email']]['city']='';
                //         $res_data_arr[$drr['email']]['address']='';
                // }
            }
         }catch(Exception $e){
            echo $e->getMessage();
            exit();
         }
         //echo json_encode($data_arr2);
         //exit();
         
         //var_dump($res_data_arr);
            error_reporting(E_ALL);
            date_default_timezone_set('America/Chicago');
            header("Content-type:text/csv");   
            header("Content-Disposition:attachment;filename=none.csv");
            $str='';
            $str.="\xEF\xBB\xBF" .'email,order no.,sku,all_amount,amount'."\n";
            echo $str;
            foreach ($res_data_arr as $v) {
                $str=$v['email'].','.$v['order_id'].','.$v['sku'].','.$v['all_amount'].','.$v['amount']."\n";
                echo $str;
            }
    }

    public function action_celebrity_show()
    {
        $c_images = DB::query(Database::SELECT, 'SELECT DISTINCT product_id FROM celebrity_images WHERE site_id=1 and type in (1,3) and is_show = 1 ORDER BY id DESC limit 0,1500')->execute('slave')->as_array();  

        foreach($c_images as $key => $value)
        {
            $pro_ins = Product::instance($value['product_id']);
            if($pro_ins->get('visibility') != 1 || $pro_ins->get('status') != 1)
            {
                DB::update('celebrity_images')->set(array('is_show' => 0))->where('product_id', '=', $value['product_id'])->execute();
            }
        }


    }




}

?>