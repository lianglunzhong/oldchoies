<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Customer extends Controller_Admin_Site
{

    public function action_list()
    {
        $count = ORM::factory('customer')->count_all();

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

        $data = ORM::factory('customer')
            ->where('site_id', '=', $this->site_id)
            ->order_by("id", "asc")
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->find_all();

        $mail_types = DB::select('name')
            ->from('mail_types')
            ->where('site_id', '=', $this->site_id)
            ->execute('slave');

        $manual_types = Kohana::config('manualmail.type');
        foreach ($mail_types as $type)
        {
            if (in_array($type['name'], $manual_types))
                $mail_type[$type['name']] = $type['name'];
        }
        if (empty($mail_type))
        {
            $mail_type['null'] = "未设置任何邮件";
        }

        // 用户统计 for last week
        $last_week = strtotime('midnight') - 604800 + 86400;
        $dates = array();
        for ($i = 0; $i < 7; $i++)
        {
            $midnight = $last_week + $i * 86400;
            $dates[] = date('Y-m-d', $midnight);
        }

        $cache = Cache::instance('memcache');
        $key = "admin_customers_statistics";
        if( ! ($customers_statistics = $cache->get($key)))
        {
            $customers_statistics = array(
                'today_register' => array(),
                'today_login' => array(),
                'register_allcount'=> array()
            );

            for ($i = 0; $i < 7; $i++)
            {
                $midnight = $last_week + $i * 86400;
                $next_day = $midnight + 86400;
                $keycount = "admin_customers_register_allcount" . $next_day;
                if (!($register_allcount = $cache->get($keycount))) {
                    $register_allcount = DB::select(DB::expr('COUNT(customers.id) AS customers_count'))
                        ->from('accounts_customers')
                        ->where('flag', '=', 0)
                        ->where('site_id', '=', $this->site_id)
                        ->where('created', '<=', $next_day)
                        ->execute('slave')
                        ->get('customers_count');

                    $cache->set($keycount, $register_allcount, 600);
                }

                $today_register = DB::query(Database::SELECT, "SELECT COUNT(customers.id) AS count FROM `accounts_customers` WHERE flag=0 AND site_id =" . $this->site_id . " AND created >= " . $midnight . " AND created < " . $next_day)
                    ->execute('slave')->get('count');

                $today_login = DB::query(Database::SELECT, "SELECT COUNT(customers.id) AS count FROM `accounts_customers` WHERE 	last_login_time >= " . $midnight . " AND 	last_login_time < " . $next_day)
                    ->execute('slave')->get('count');

                $customers_statistics['today_register'][date('Y-m-d', $midnight)] = $today_register;
                $customers_statistics['today_login'][date('Y-m-d', $midnight)] = $today_login;
                $customers_statistics['register_allcount'][date('Y-m-d', $midnight)] = $register_allcount;
            }
            $cache->set($key, $customers_statistics, 600);
        }

        $content = View::factory('admin/site/customer_list')
            ->set('mail_type', $mail_type)
            ->set('data', $data)
            ->set('count', $count)
            ->set('page_view', $page_view)
            ->set('dates', $dates)
            ->set('customers_statistics', $customers_statistics)
            ->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete($id)
    {
        echo ORM::factory('customer', $id)->delete() ? 'success' : '删除失败';
    }

    public function action_resetpwd($id)
    {
        $customer = ORM::factory('customer')
            ->where('site_id', '=', $this->site_id)
            ->where('id', '=', $id)
            ->find();
        if ($customer->loaded())
        {
            $customer->password = toolkit::hash('123456');
            $customer->save();
            echo 'success';
        }
        else
        {
            echo 'Server is busy !';
        }
    }

    public function action_login($id)
    {
        $customer = Customer::instance($id);
        echo json_encode(array(
            'success' => true,
            'action' => 'https://' . Site::instance()->get('domain') . '/customer/login',
            'email' => $customer->get('email'),
            'password' => $customer->get('password'),
        ));
    }

    public function action_edit($id)
    {
        $customer = Customer::instance($id);
        if (!$customer->get('id'))
        {
            message::set('客户不存在或者已经被删除');
            $this->request->redirect('admin/site/customer/list');
        }

        View::set_global('id', $id);
        $countries = ORM::factory('country')
            ->where('site_id', '=', $this->site_id)
            ->find_all();
        $orders = ORM::factory('order')
            ->where('site_id', '=', $this->site_id)
            ->where('customer_id', '=', $id)
            ->find_all();
        $customer_edit_basic = View::factory('admin/site/customer_edit_basic')
            ->set('data', $customer->get())
            ->set('addresses', $customer->addresses())
            ->set('countries', $countries)
            ->set('orders', $orders)
            ->render();
        $customer_edit_affiliate = View::factory('admin/site/customer_edit_affiliate')
            ->set('affiliate_id', $id)
            ->set('affiliate_level', $customer->get('affiliate_level'))
            ->set('affiliate_levels', Kohana::config('affiliate.rate', array()))
            ->set('affiliate_rate', $customer->get('affiliate_rate'))
            ->set('affiliate_records', $customer->affiliate_records())
            ->set('affiliate_payments', $customer->affiliate_payments())
            ->render();
        $customer_edit_point = View::factory('admin/site/customer_edit_point')
            ->set('point_pending', $customer->points_pending())
            ->set('point_activated', $customer->points_activated())
            ->set('point_avail', $customer->points())
            ->set('point_records', $customer->point_records())
            ->set('point_payments', $customer->point_payments())
            ->render();

        $content = View::factory('admin/site/customer_edit')
            ->set('customer_edit_basic', $customer_edit_basic)
            ->set('customer_edit_affiliate', $customer_edit_affiliate)
            ->set('customer_edit_point', $customer_edit_point)
            ->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_edit_basic($id)
    {
        $customer = ORM::factory('customer', $id);
        if (!$customer->loaded())
        {
            message::set('客户不存在或者已经被删除');
            $this->request->redirect('admin/site/customer/list');
        }

        if ($_POST)
        {
            $post = Validate::factory($_POST)
                ->filter(TRUE, 'trim')
                ->filter('email', 'trim')
                ->filter('firstname', 'trim')
                ->filter('lastname', 'trim')
                ->filter('birthday', 'strtotime')
                ->filter('country', 'trim')
                ->filter('status', 'trim');
            if ($post->check())
            {
                $customer->values($post);
                if ($customer->save())
                {
                    message::set('客户修改成功');
                    Request::instance()->redirect("/admin/site/customer/edit/$id");
                }
                else
                {
                    message::set('Update customer information failed.');
                }
            }
            else
            {
                message::set(implode(',', $post->errors()));
            }
        }
    }

    public function action_edit_basic_address()
    {
        if ($_POST){
            $arr = $_POST;
        foreach($arr as $k=>$v){
            $data['address'] = $v;

            DB::update('accounts_address')->set($data)->where('id', '=', $k)->execute();
        }
                    message::set('已修改');
            $this->request->redirect('admin/site/customer/list');
      }
    }

    public function action_edit_affiliate($id)
    {
        $customer = ORM::factory('customer', $id);
        if (!$customer->loaded())
        {
            message::set('客户不存在或者已经被删除');
            $this->request->redirect('admin/site/customer/list');
        }

        if ($_POST)
        {
            $update['affiliate_rate'] = (float) $_POST['rate'];
            if (in_array($_POST['level'], array('starter', 'standard', 'vip')))
            {
                $update['affiliate_level'] = $_POST['level'];
            }

            if ($customer->values($update) && $customer->save())
            {
                message::set('更新成功');
            }
            else
            {
                message::set('更新失败', 'error');
            }
        }

        $this->request->redirect("/admin/site/customer/edit/$id#customer-edit-affiliate");
    }

    public function action_add_affiliate_payment($id)
    {
        $customer = Customer::instance($id);
        if (!$customer->get('id'))
        {
            message::set('客户不存在或者已经被删除');
            $this->request->redirect('admin/site/customer/list');
        }

        if ($_POST)
        {
            $payment['commission'] = (float) $_POST['commission'];
            $payment['note'] = $_POST['note'];
            if ($customer->add_commission_payment($payment))
            {
                $customer->commission_dec($payment['commission']);
                message::set('成功添加支付记录');
            }
            else
            {
                message::set('添加失败', 'error');
            }
        }

        $this->request->redirect("/admin/site/customer/edit/$id#customer-edit-affiliate");
    }

    public function action_edit_point($id)
    {
        $customer = Customer::instance($id);
        if (!$customer->get('id'))
        {
            message::set('客户不存在或者已经被删除');
            $this->request->redirect('admin/site/customer/list');
        }

        if ($_POST)
        {
            if ($customer->_set(array('points' => intval($_POST['points']))))
            {
                $customer->add_point(array('amount' => $_POST['points'], 'type' => 'tryon', 'status' => 'activated', 'user_id' => Session::instance()->get('user_id')));
                message::set('更新积分信息成功');
            }
            else
            {
                message::set('更新积分信息失败', 'error');
            }
        }

        $this->request->redirect("/admin/site/customer/edit/$id#customer-edit-point");
    }

    public function action_add_point_record($id)
    {
        $customer = Customer::instance($id);
        if (!$customer->get('id'))
        {
            message::set('客户不存在或者已经被删除');
            $this->request->redirect('admin/site/customer/list');
        }

        if ($_POST)
        {
            $amount = intval(Arr::get($_POST, 'amount', 0));
            $type = Arr::get($_POST, 'type', 'review');
            $status = Arr::get($_POST, 'status', 'pending');
            if (!$amount || !in_array($status, array('pending', 'activated')))
            {
                message::set('积分数据不合法', 'error');
                $this->request->redirect("/admin/site/customer/edit/$id#customer-edit-point");
            }

            $customer->add_point(array(
                'type' => $type,
                'amount' => $amount,
                'status' => $status,
                'user_id' => Session::instance()->get('user_id'),
            ));

            if ($status == 'activated')
            {
                $customer->point_inc($amount);
            }

            message::set('添加积分记录成功');
        }

        $this->request->redirect("/admin/site/customer/edit/$id#customer-edit-point");
    }

    public function action_del_point_record($id)
    {
        $ret = DB::delete('point_records')
            ->where('id', '=', $id)
            ->execute();
        if ($ret)
            message::set('已删除积分记录');
        else
            message::set('删除失败', 'error');

        $this->request->redirect(Request::$referrer . '#customer-edit-point');
    }

    public function action_add()
    {
        if ($_POST)
        {
            $customer = ORM::factory('customer');
            $customer->email = $_POST['email'];
            $customer->firstname = $_POST['firstname'];
            $customer->lastname = $_POST['lastname'];
            $customer->password = $_POST['password'];
            $customer->country = $_POST['country'];
            $customer->created = time();
            $customer->save();
            message::set('客户添加成功！');
            Request::instance()->redirect('/admin/site/customer/list');
        }
        else
        {
            $countries = ORM::factory('country')->where('site_id', '=', $this->site_id)->find_all();
            $view = View::factory('admin/site/customer_add')->set('countries', $countries);
            $this->request->response = View::factory('admin/template')->set('content', $view)->render();
        }
    }

    public function action_select()
    {
        $count = ORM::factory('customer')
            ->where('site_id', '=', $this->site_id)
            ->where('firstname', 'like', '%' . $_POST['firstname'] . '%')
            ->where('lastname', 'like', '%' . $_POST['lastname'] . '%')
            ->count_all();

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

        $data = ORM::factory('customer')
            ->where('site_id', '=', $this->site_id)
            ->where('firstname', 'like', '%' . $_POST['firstname'] . '%')
            ->where('lastname', 'like', '%' . $_POST['lastname'] . '%')
            ->order_by("id", "asc")
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->find_all();

        $content = View::factory('admin/site/customer_list')
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
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
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
                    $_filter_sql[] = '`customers`.' . $item->field . " between " . $from . " and " . $to;
                }
                else if ($item->field == 'name')
                {
                    $_filter_sql[] = "CONCAT(`customers`.firstname, ' ', `customers`.lastname) LIKE '%" . $item->data . "%'";
                }
                else if ($item->field == 'orders')
                {
                    $order_sql = ' HAVING orders=' . $item->data . ' ';
                }
                else if ($item->field == 'ip')
                {
                    $_filter_sql[] = 'customers.ip=' . ip2long($item->data) . ' ';
                }
                else
                {
                    $_filter_sql[] = '`customers`.' . $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`customers`.`id`) AS num FROM `customers` WHERE `customers`.site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave');
        $count = $result[0]['num'];
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT `customers`.*,COUNT(`orders`.customer_id) AS orders 
		FROM `customers` LEFT JOIN `orders` ON `orders`.customer_id=`customers`.id 
		WHERE `customers`.site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $customer)
        {
			$users_email = DB::select('name')->from('auth_user')->where('id','=',$customer['users_admin'])->where('created', '>', 0)->execute('slave')->get('name');
            $responce['rows'][$k]['id'] = $customer['id'];
            $responce['rows'][$k]['cell'] = array(
                0,
                $customer['id'],
                $customer['email'],
                $customer['firstname'] . ' ' . $customer['lastname'],
                $customer['affiliate_level'],
                $customer['commissions'],
                Customer::instance($customer['id'])->commissions_pending(),
                $customer['points'],
                $customer['order_total'],
                $customer['is_facebook'],
                date('Y-m-d', $customer['created']),
                $customer['orders'],
                long2ip($customer['ip']),
                $customer['ip_country'],
                $customer['is_vip'],
                $users_email,
                $customer['lang'],
                $customer['flag'],
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_export1()
    {
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            $query = DB::select('created', 'email', 'firstname', 'lastname')->from('accounts_customers');
            $site = Site::instance();

            $file = 'customers';
            if ($start)
            {
                $file .= "-from-$start";
                $query->where('created', '>=', strtotime($start));
            }

            if ($end)
            {
                $file .= "-to-$end";
                $query->where('created', '<', strtotime($end));
            }
            $query->where('site_id', '=', $site->get('id'));
            $customers = $query->execute('slave');

            /** Error reporting */
            error_reporting(E_ALL);

            date_default_timezone_set('Europe/London');

            /** PHPExcel */
            require_once 'application/libraries/PHPExcel.php';

// Create new PHPExcel object
            $objPHPExcel = new PHPExcel();

// Set properties
            $objPHPExcel->getProperties()->setCreator("cofree")
                ->setLastModifiedBy("cofree")
                ->setTitle("Office 2007 XLSX --Newsletter")
                ->setSubject("Office 2007 XLSX --Newsletter")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

            /*
             * 获取session ：：order_list_excel中的数据！
             */

            $i = 2;

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Time(注册时间)')
                ->setCellValue('B1', 'Email')
                ->setCellValue('C1', 'Name');

            foreach ($customers as $key => $rs)
            {


                $date = date('Y-m-d H:i:s', $rs['created']);
                if (isset($rs))
                {

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A$i", $date)
                        ->setCellValue("B$i", $rs['email'])
                        ->setCellValue("C$i", $rs['firstname'] . ' ' . $rs['lastname']);
                    $i = $i + 1;
                }
                else
                {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A$i", $date)
                        ->setCellValue("B$i", $rs['email'])
                        ->setCellValue("C$i", $rs['firstname'] . ' ' . $rs['lastname']);
                    $i = $i + 1;
                }

                //  var_dump($i);exit;
//设置单元格自动换行
                //     $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                //        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                //       $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                //       $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                //       $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                //        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                //        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                //         $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                //$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);//setAutoSize(true);//setWidth(90);
//设置单元格内自动换行

                $objPHPExcel->getActiveSheet()->getStyle("A$i")->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle("B$i")->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle("C$i")->getAlignment()->setWrapText(true);



                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30); //setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            }
// Rename sheet
            $objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename=' . $file . '.xlsx');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;

            /* header('Content-Type: text/plain');
              header("Content-Disposition: attachment; filename=\"$file.txt\"");
              foreach ($customers as $customer)
              {
              print "{$customer['email']}\n";
              } */
        }
    }

    public function action_export()
    {
        if ($_POST)
        {

            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            $point_from = Arr::get($_POST, 'point_from', NULL);
            $point_to = Arr::get($_POST, 'point_to', NULL);
            $is_fb = Arr::get($_POST, 'is_fb', '');

            $submit = Arr::get($_POST, 'submit', 'Export');
            if($submit == 'Export')
            {
                $file = 'customers';
                $sql = '';
                if ($start)
                {
                    $file .= "-from-$start";
                    $sql .= ' AND customers.created >= ' . strtotime($start);
                }

                if ($end)
                {
                    $file .= "-to-$end";
                    $sql .= ' AND accounts_customers.created < ' . strtotime($end);
                }

                if ($point_from)
                {
                    $sql .= ' AND accounts_customers.points >= ' . $point_from;
                }

                if ($point_to)
                {
                    $sql .= ' AND accounts_customers.points < ' . $point_to;
                }

                if ($is_fb == 'on')
                {
                    $sql .= ' AND accounts_customers.is_facebook = 1';
                }
                $customers = DB::query(Database::SELECT, 'SELECT `accounts_customers`.* FROM `accounts_customers` WHERE `accounts_customers`.site_id=' . $this->site_id . $sql)
                    ->execute('slave');

                /** Error reporting */
                error_reporting(E_ALL);

                date_default_timezone_set('America/Chicago');
                header('Content-type: text/txt');
                header('Content-Disposition: attachment; filename=' . $file . '.txt');
                foreach ($customers as $customer)
                {
                    if ($customer['country'])
                        $country = $customer['country'];
                    else
                        $country = DB::select('country')->from('accounts_address')->where('customer_id', '=', $customer['id'])->execute('slave')->get('country');
                    $date = date('Y-m-d H:i:s', $customer['created']);
                    echo $date . "\t" . $customer['email'] . "\t" . $customer['firstname'] . "\t" . $customer['points'] . "\t" . $country . "\n";
                }
            }
            elseif($submit == 'Export_ip')
            {
                $file = 'customers';
                $sql = '';
                if ($start)
                {
                    $file .= "-from-$start";
                    $sql .= ' AND customers.created >= ' . strtotime($start);
                }

                if ($end)
                {
                    $file .= "-to-$end";
                    $sql .= ' AND customers.created < ' . strtotime($end);
                }

                if ($point_from)
                {
                    $sql .= ' AND customers.points >= ' . $point_from;
                }

                if ($point_to)
                {
                    $sql .= ' AND customers.points < ' . $point_to;
                }

                if ($is_fb == 'on')
                {
                    $sql .= ' AND customers.is_facebook = 1';
                }
                $customers = DB::query(Database::SELECT, 'SELECT email, created, ip_country FROM customers WHERE site_id=' . $this->site_id . $sql)
                    ->execute('slave');

                /** Error reporting */
                error_reporting(E_ALL);

                date_default_timezone_set('America/Chicago');
                header('Content-type: text/csv');
                header('Content-Disposition: attachment; filename=' . $file . '.csv');

                echo "\xEF\xBB\xBF" . "Email,Created,Ip country\n";
                foreach ($customers as $customer)
                {
                    echo $customer['email'] . ',';
                    echo date('Y-m-d H:i:s', $customer['created']) . ',';
                    echo $customer['ip_country'] . ',';
                    echo "\n";
                }
            }
        }
    }

    public function action_guo_add11()
    {
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=customers.csv');  
        echo "\xEF\xBB\xBF" . "Fullname,Email,conadd,Firstname,Lastname,Country,Address,City,Province,code\n";  
 $result = DB::query(DATABASE::SELECT, "SELECT DISTINCT  `c`.email, o.customer_id, count( o.customer_id ) AS con,   o.shipping_firstname,  o.shipping_lastname,o.shipping_country,o.shipping_state,o.shipping_city,o.shipping_address,o.shipping_phone
FROM  orders o 
LEFT JOIN customers c ON o.customer_id = c.id where c.email != '' and o.created >1422720000  GROUP BY o.customer_id")->execute();   
 
         foreach($result as $v)
        {  
            $fullname = $v['shipping_firstname'].$v['shipping_lastname'];
            if(empty($fullname)){
                $arr = explode("@",$v['email']);
                $fullname = $arr[0];
            }
            $add = str_replace(',', '' , $v['shipping_address']);
            $add = str_replace(PHP_EOL, '', $add);
            $add = str_replace(' ', '', $add);
            $cit = str_replace(',', '' , $v['shipping_city']);
            $cit = str_replace(PHP_EOL, '', $cit);
            $coun = str_replace(',', '' , $v['shipping_country']);
            $coun = str_replace(PHP_EOL, '', $coun);
            $sta = str_replace(',', '' , $v['shipping_state']);
            $sta = str_replace(PHP_EOL, '', $sta);
            if(strlen($v['shipping_phone']) >10){
                $pho = 0;
            }else{
                $pho = $v['shipping_phone'];
            }
            echo $fullname . ',';
            echo $v['email'] . ',';
            echo $v['con'] . ',';
            echo $v['shipping_firstname']. ',';
            echo $v['shipping_lastname']. ',';
            echo $coun. ',';
            echo $add . ',';
            echo $cit. ',';
            echo $sta. ',';
            echo $pho. ',';
            echo "\n";
        }
    }

    public function action_guo_add()
    {
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=customers.csv');  
        echo "\xEF\xBB\xBF" . "Fullname,Email,Firstname,Lastname,Birthday,Country,Address,City,Province,code\n";  
 $result = DB::query(DATABASE::SELECT, 'SELECT DISTINCT  `customers`.email,  `customers`.id,  `customers`.firstname,  `customers`.lastname,  `customers`.birthday,  `customers`.country,  `addresses`.address, `addresses`.city,  `addresses`.state,  `addresses`.phone
FROM  `customers` 
LEFT JOIN  `addresses` ON  `addresses`.customer_id =  `customers`.id
WHERE  `customers`.site_id=' . $this->site_id . ' AND  `addresses`.is_default =0')->execute();   
/*echo '<pre>';
print_r($result);
die; */
         foreach($result as $v)
        {  
            $fullname = $v['firstname'].$v['lastname'];
            if(empty($fullname)){
                $arr = explode("@",$v['email']);
                $fullname = $arr[0];
            }
            $add = str_replace(',', '' , $v['address']);
            $add = str_replace(PHP_EOL, '', $add);
            $cit = str_replace(',', '' , $v['city']);
            $cit = str_replace(PHP_EOL, '', $cit);
            $coun = str_replace(',', '' , $v['country']);
            $coun = str_replace(PHP_EOL, '', $coun);
            $sta = str_replace(',', '' , $v['state']);
            $sta = str_replace(PHP_EOL, '', $sta);
            if(strlen($v['phone']) >10){
                $pho = 0;
            }else{
                $pho = $v['phone'];
            }
            echo $fullname . ',';
            echo $v['email'] . ',';
            echo $v['firstname']. ',';
            echo $v['lastname']. ',';
            echo date('Y-m-d', $v['birthday']) . ',';
            echo $coun. ',';
            echo $add . ',';
            echo $cit. ',';
            echo $sta. ',';
            echo $pho. ',';
            echo "\n";
        }
    }

    public function action_getfileforcomment()
    {
        $time = strtotime('2015-08-12');
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=customers.csv');  
        echo "\xEF\xBB\xBF" . "user_id,firstname,comments\n";  
 $result = DB::query(DATABASE::SELECT, 'SELECT user_id,firstname,comments
FROM  giveaway WHERE created >' . $time)->execute(); 

      foreach($result as $v)
        {  
            echo $v['user_id']. ',';
            echo $v['firstname']. ',';
            echo $v['comments']. ',';
            echo "\n";         
        }
    }

    public function action_getfilesku()
    {
        $time = strtotime('2015-08-12');
       $skuArr = array('BREA0408B023W',
'CBZY4113',
'CDPY0992',
'CDZY4429',
'CIZY4393',
'CIZY4395',
'CROP0426B126K',
'CROP0428B054W',
'CSPY0527',
'CTGP0023P1',
'CWZY4371',
'DRES0319B222A',
'DRES0320B735K',
'DRES0323B770K',
'DRES0409B096P',
'DRES0413B102P',
'DRES0420B054K',
'DRES0422B041W',
'DRES0427B148K',
'DRES0506B201K',
'DRES0506B209K',
'DRES0511B065W',
'DRES0515B247G',
'DRES0526B273C',
'JUMP0331B229A',
'JUMP0409B023C',
'JUMP0409B250A',
'JUMP0412B259A',
'JUMP0417B041K',
'JUMP0424B069C',
'JUMP0429B180E',
'JUMP0506B200K',
'JUMP0507B330A',
'JUMP0512B201C',
'JUMP0513B067W',
'JUMP0513B632B',
'JUMP0521B364A',
'JUMP0605B347C',
'SKIR0426B289A',
'TSHI0413B985K',
'TWOP0122B209A',
'TWOP0412B254A',
'TWOP0413B975K',
'TWOP0422B077K',
'TWOP0426B286A',
'TWOP0426B297A',
'TWOP0429B160K',
'TWOP0507B176C',
'TWOP0507B313A',
'TWOP0520B240C',
'VEST0408B027W',
'SKIR0122B204A',
'CROP0422B276A',
'BLOU0326B092P',
'JUMP0331B232A',
'TWOP0426B300A',
'SWIM0520B432K',
'DRES1027A136A',
'DRES0323B771K',
'DRES0422B037W',
);

        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=customers.csv');  
        echo "\xEF\xBB\xBF" . "sku,vote\n";  
        $result = DB::select('sku')->from('giveaway')->where('created', '>', $time)->execute()->as_array();

        $votes = array();
        foreach($skuArr as $s)
        {
            $votes[$s] = 0;
        }
        foreach($result as $re)
        {
            $skus = explode(',', $re['sku']);
            foreach($skus as $sku)
            {
                $sku = trim($sku);
                if(in_array($sku, $skuArr))
                    $votes[$sku] ++;
            }
        }

      foreach($skuArr as $v2)
        {  
            echo $v2. ',';
            echo $votes[$v2]. ',';
            echo "\n";         
        }
    }

    public function action_export_vip()
    {
        /** Error reporting */
        error_reporting(E_ALL);
        date_default_timezone_set('America/Chicago');
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=vip_customers.csv');
        echo "\xEF\xBB\xBF" . "Email,Vip Level,Points\n";

        $vips = DB::select('email', 'vip_level', 'points')->FROM('accounts_customers')->where('vip_level', '>', 0)->order_by('vip_level')->order_by('id')->execute();
        foreach($vips as $vip)
        {
            echo $vip['email'] . ',';
            echo $vip['vip_level'] . ',';
            echo $vip['points'] . ',';
            echo "\n";
        }
    }

    public function action_orders()
    {
        if (isset($_POST['all']))
        {
            $this->request->redirect('/admin/site/customer/orders');
        }
        if ($_POST['start'])
        {
            $date = strtotime(Arr::get($_POST, 'start', 0));
            $date += 28800;

            // 添加更新结束时间
            $date_end = Arr::get($_POST, 'end', 0);

            if ($date_end)
            {
                $date_end = strtotime($date_end);
                $date_end += 28800;
            }
            else
            {
                $date_end = $date + 86400;
            }
            $this->request->redirect('/admin/site/customer/orders?history=' . $date . '-' . $date_end);
        }
        $content = View::factory('admin/site/customer_orders')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_orders_data()
    {
        $daterange = '';
        if ($_GET['history'])
        {
            $history = $_GET['history'];
            $date = explode('-', $history);
            $daterange = ' AND orders.created >= ' . $date[0] . ' AND orders.created < ' . $date[1];
        }
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 'id';

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'orders')
                {
                    $order_sql = ' HAVING orders=' . $item->data . ' ';
                }
                else
                {
                    $_filter_sql[] = '`customers`.' . $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT `customers`.id,COUNT(`orders`.customer_id) AS orders 
		FROM `customers` LEFT JOIN `orders` ON `orders`.customer_id=`customers`.id 
		WHERE `customers`.site_id=' . $this->site_id . ' AND `orders`.payment_status="verify_pass" AND '
                . $filter_sql . $daterange . ' GROUP BY id ' . $order_sql)->execute('slave')->as_array();
        $count = count($result);
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT `customers`.id,`customers`.email,COUNT(`orders`.customer_id) AS orders 
		FROM `customers` LEFT JOIN `orders` ON `orders`.customer_id=`customers`.id 
		WHERE `customers`.site_id=' . $this->site_id . ' AND `orders`.payment_status="verify_pass" AND '
                . $filter_sql . $daterange . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $customer)
        {
            $orders = DB::select('amount', 'rate')->from('orders_order')->where('customer_id', '=', $customer['id'])->and_where('payment_status', '=', 'verify_pass')->execute('slave')->as_array();
            $order_total = 0;
            foreach ($orders as $order)
            {
                if (is_null($order['rate']))
                    $order['rate'] = 1;
                $order_total += $order['amount'] / $order['rate'];
            }
            $responce['rows'][$k]['id'] = $customer['id'];
            $responce['rows'][$k]['cell'] = array(
                $customer['id'],
                $customer['email'],
                $customer['orders'],
                round($order_total, 4),
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_orders_export()
    {
        if (!$_POST)
        {
            die('invalid request');
        }
        $daterange = '';
        $filename = '';
        if ($_POST['history'])
        {
            $history = $_POST['history'];
            $date = explode('-', $history);
            $daterange = ' AND orders.created >= ' . $date[0] . ' AND orders.created < ' . $date[1];
            $filename = '_' . date('Y-m-d', $date[0]) . '_' . date('Y-m-d', $date[1]);
        }
        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="customer_orders' . $filename . '.csv"');
        echo "\xEF\xBB\xBF" . "ID,Email,Orders,Order_total\n";
        $result = DB::query(DATABASE::SELECT, 'SELECT `customers`.id,`customers`.email,COUNT(`orders`.customer_id) AS orders 
                        FROM `customers` LEFT JOIN `orders` ON `orders`.customer_id=`customers`.id 
                        WHERE `customers`.site_id=' . $this->site_id . ' AND `orders`.payment_status="verify_pass"' . $daterange . ' GROUP BY id ORDER BY orders')
            ->execute('slave');
        foreach ($result as $customer)
        {
            $orders = DB::select('amount', 'rate')->from('orders_order')->where('customer_id', '=', $customer['id'])->and_where('payment_status', '=', 'verify_pass')->execute('slave')->as_array();
            $order_total = 0;
            foreach ($orders as $order)
            {
                if (is_null($order['rate']))
                    $order['rate'] = 1;
                $order_total += $order['amount'] / $order['rate'];
            }
            echo $customer['id'] . ',';
            echo $customer['email'] . ',';
            echo $customer['orders'] . ',';
            echo round($order_total, 4) . ',';
            echo "\n";
        }
    }

    public function action_order_times()
    {
        $result = DB::query(DATABASE::SELECT, 'SELECT `customers`.id,`customers`.email,COUNT(`orders`.customer_id) AS orders 
		FROM `customers` LEFT JOIN `orders` ON `orders`.customer_id=`customers`.id 
		WHERE `customers`.site_id=' . $this->site_id . ' AND `orders`.payment_status="verify_pass" GROUP BY id ORDER BY orders')
            ->execute('slave');
        $num = 1;
        $array = array();
        $array[$num] = 0;
        foreach ($result as $customer)
        {
            if ($customer['orders'] != $num)
            {
                $num = $customer['orders'];
                $array[$num] = 0;
            }
            $array[$num]++;
        }
        echo '下单次数 客户数量<br>';
        foreach ($array as $time => $cust_num)
        {
            echo $time . ' ' . $cust_num . '<br>';
        }
    }

    public function action_import_points()
    {
        $status = 'activated';
        if ($_POST)
        {
            $points = Arr::get($_POST, 'points', 0);
            if (!$points)
            {
                Message::set('Points cannot be zero!', 'error');
                $this->request->redirect('/admin/site/customer/list');
            }
            $type = Arr::get($_POST, 'type', '');
            if (!$type)
            {
                Message::set('Type cannot be empty!', 'error');
                $this->request->redirect('/admin/site/customer/list');
            }
            $emailArr = Arr::get($_POST, 'EmalARR', '');
            if (!$emailArr)
            {
                Message::set('Email cannot be empty!', 'error');
                $this->request->redirect('/admin/site/customer/list');
            }
            $emails = explode("\n", $emailArr);
            foreach ($emails as $email)
            {
                $customer_id = Customer::instance()->is_register(trim($email));
                if ($customer_id)
                {
                    $customer = Customer::instance($customer_id);
                    $customer->add_point(array(
                        'type' => $type,
                        'amount' => $points,
                        'status' => $status,
                        'user_id' => Session::instance()->get('user_id'),
                    ));

                    if ($status == 'activated')
                    {
                        $customer->point_inc($points);
                    }
                }
            }
            Message::set('Import points success!', 'success');
            $this->request->redirect('/admin/site/customer/list');
        }
    }

    public function action_vip_add()
    {
        $webemail = Site::instance()->get('email');
        $currency = Site::instance()->currencies();
        $vips = DB::select()->from('vip_types')->execute('slave')->as_array();
        $result = DB::query(Database::SELECT, "SELECT id, trans_id, customer_id, email, currency, amount FROM order_payments
                                        WHERE vip_status =0 AND amount >0 AND payment_status = 'success' AND created > 1370044800
                                        ORDER BY customer_id LIMIT 0, 500")
            ->execute('slave');
        $called = array(
            1 => '',
            2 => 'Bronze',
            3 => 'Silver',
            4 => 'Gold',
            5 => 'Diamond'
        );
        $count = 0;
        $customer = 0;
        $tr_id = '';
        foreach ($result as $order)
        {
            if ($order['trans_id'] == $tr_id)
            {
                DB::update('orders_orderpayments')->set(array('vip_status' => 1))->where('id', '=', $order['id'])->execute();
                continue;
            }
            $tr_id = $order['trans_id'];
            $order_total = Customer::instance($order['customer_id'])->get('order_total');
            $current_amount = $order['amount'] / $currency[strtoupper($order['currency'])]['rate'];
            if ($customer == $order['customer_id'])
                $add_amount = $amount + $current_amount;
            else
                $add_amount = $order_total + $current_amount;
            $level = 5;
            $current_vip = array();
            foreach ($vips as $val)
            {
                if ($val['condition'] > $add_amount)
                {
                    $level = $val['level'];
                    $current_vip = $val;
                    break;
                }
            }
            if (empty($current_vip))
                $current_vip = $vips[count($vips) - 1];
            $update = DB::update('accounts_customers')->set(array('order_total' => $add_amount))->where('id', '=', $order['customer_id'])->execute();
            if ($update)
            {
                $update1 = DB::update('orders_orderpayments')->set(array('vip_status' => 1))->where('customer_id', '=', $order['customer_id'])->and_where('trans_id', '=', $order['trans_id'])->execute();

                if (!$update1)
                    continue;
                $c_update = DB::update('accounts_customers')->set(array('vip_level' => $level))->where('id', '=', $order['customer_id'])->execute();
                if ($c_update AND !Customer::instance($order['customer_id'])->is_celebrity())
                {
                    $rcpt = $order['email'];
                    $from = $webemail;
                    $subject = 'Congratulations! You are now Choies ' . $called[$level] . ' VIP Member!';
                    if ($level < 5)
                        $extra = 'Shop a little more to <span style="color:red;">$' . $current_vip['condition'] . '</span>, you can become our <span style="color:red;">' . $called[$level + 1] . ' VIP</span> Member.<br/>';
                    else
                        $extra = '';
                    $body = '
Dear Choieser,<br/>
<br/>
Thanks for shopping on Choies.com! You have purchased <span style="color:red;">$' . $add_amount . '</span>, and now you are one of Choies honored <span style="color:red;">' . $called[$level] . ' VIP</span> members. 
And you can enjoy extra <span style="color:red;">' . ((1 - $current_vip['discount']) * 100) . '%</span> off discount for items and <span style="color:red;">' . $current_vip['return'] . '%</span> order points of your product purchase amount. 
' . $extra . '
For more detailed information, please check <a href="/vip-policy">VIP Policy</a>.<br/>
You can also check your VIP Status at any time in <a href="/customer/summary">Your Account</a>.<br/>
<br/>
If you have any further questions, please feel free to contact: <br/>
<a href="mailto:'.$webemail.'">'.$webemail.'</a> or <a href="mailto:lisaconnor@choies.com">lisaconnor@choies.com</a> <br/>
<br/>
You may also like our facebook & Twitter:<br/>
<a href="http://www.facebook.com/choiesofficial">http://www.facebook.com/choiesofficial</a><br/>
<a href="http://twitter.com/choiescloth">http://twitter.com/choiescloth</a><br/>
<br/>
Best Regards,<br/>
Choies Team
                                ';
                    if (strpos($rcpt, '@hotmail.') or strpos($rcpt, '@live.'))
                    {
                        Mail::SendSMTP($rcpt, $from, $subject, $body);
                    }
                    else
                    {
                        Mail::Send($rcpt, $from, $subject, $body);
                    }
                }
            }
            $count++;
            $customer = $order['customer_id'];
            $amount = $add_amount;
        }
        echo $count . ' orders add to vip system' . '<br>';

        $vips = DB::select()->from('vip_types')->execute('slave')->as_array();
        $result = DB::query(Database::SELECT, "SELECT id, trans_id, customer_id, currency, amount FROM order_payments
                                        WHERE vip_status=0 AND payment_status IN ('refund', 'partial_refund')
                                        ORDER BY id")
            ->execute('slave');
        $count = 0;
        $tr_id = '';
        foreach ($result as $order)
        {
            if ($order['trans_id'] == $tr_id)
            {
                DB::update('orders_orderpayments')->set(array('vip_status' => 1))->where('id', '=', $order['id'])->execute();
                continue;
            }
            $tr_id = $order['trans_id'];
            $order_total = Customer::instance($order['customer_id'])->get('order_total');
            $add_amount = $order_total - abs($order['amount']) / $currency[strtoupper($order['currency'])]['rate'];
            $level = 5;
            foreach ($vips as $val)
            {
                if ($val['condition'] > $add_amount)
                {
                    $level = $val['level'];
                    break;
                }
            }
            if ($add_amount < 0)
                $add_amount = 0;
            $data = array(
                'order_total' => $add_amount,
                'vip_level' => $level
            );
            $update = DB::update('accounts_customers')->set($data)->where('id', '=', $order['customer_id'])->execute();
            if ($update)
            {
                DB::update('orders_orderpayments')->set(array('vip_status' => 1))->where('id', '=', $order['id'])->execute();
            }
            $count++;
        }
        echo $count . ' refunds add to vip system';
    }

    public function action_birth_points()
    {
        $tomorrow = date("m-d", strtotime("+1 day"));
        $lastweek = date("m-d", strtotime("+1 week"));
        if($tomorrow > '12-25')
        {
            $births = DB::query(Database::SELECT, 'SELECT id, email, birthday FROM customers 
                        WHERE (birth BETWEEN "' . $tomorrow . '" AND "12-31" OR birth BETWEEN "01-01" AND "' . $lastweek . '") AND vip_level > 0')->execute('slave');
        }
        else
        {
            $births = DB::query(Database::SELECT, 'SELECT id, email, birthday FROM customers 
                        WHERE birth BETWEEN "' . $tomorrow . '" AND "' . $lastweek . '" AND vip_level > 0')->execute('slave');
        }
//                $births = DB::query(Database::SELECT, 'SELECT id, email, birthday FROM customers 
//                        WHERE id = 3')->execute('slave');
        foreach ($births as $customer)
        {
            $send_day = DB::query(Database::SELECT, 'SELECT created FROM point_records 
                                WHERE customer_id = ' . $customer['id'] . ' AND type = "birthday"')
                    ->execute('slave')->get('created');
            if (!$send_day OR $send_day - time() > 31536000)
            {
                $points = date('Y', $customer['birthday']) + date('m', $customer['birthday']) + date('d', $customer['birthday']);
                $update = DB::query(Database::UPDATE, 'UPDATE accounts_customers SET points=points+' . $points . ',give_points=1 WHERE id=' . $customer['id'])->execute();
                if ($update)
                {
                    Customer::instance($customer['id'])->add_point(array('amount' => $points, 'type' => 'birthday', 'status' => 'activated'));
                    $mail_params['points'] = $points;
                    $mail_params['email'] = $customer['email'];
                    Mail::SendTemplateMail('VIP BIRTHDAY GIFT', $mail_params['email'], $mail_params);
                    echo $customer['email'] . ' Add Birthday Points Success<br/>';
                }
            }
        }
    }

    public function action_export_by_country()
    {
        set_time_limit(0);
        if ($_POST)
        {
            $type = Arr::get($_POST, 'type', 'register');
            $country = Arr::get($_POST, 'country', '');
            $filename = '';
            $sql = array();
            $file = '';
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            if ($start)
            {
                $file .= "-from-$start";
                if ($type == 'register') {
                    $sql[] .= '`customers`.created >= ' . strtotime($start);
                }else{
                    $sql[] .= 'created >= ' . strtotime($start);
                }
            }

            if ($end)
            {
                $file .= "-to-$end";
                if ($type == 'register') {
                    $sql[] .= '`customers`.created < ' . strtotime($end);
                }else{
                    $sql[] .= 'created < ' . strtotime($end);
                }
            }

            if ($type == 'register')
            {
                if ($country)
                {
                    $sql[] = '`customers`.country = "' . $country . '" ';
                }
                $timestatus1=8*3600;
                $filename = 'Register_customers_' . $country . $file . '.csv';
                $result = DB::query(Database::SELECT, 'SELECT `customers`.`email`, `customers`.`country`, FROM_UNIXTIME(`customers`.created+'.$timestatus1.') AS `time`,COUNT(`orders`.customer_id) AS `orders`
                    FROM `customers` LEFT JOIN `orders` ON `orders`.customer_id=`customers`.id  WHERE (`customers`.flag =0 or `customers`.flag =3) and `customers`.site_id=' . $this->site_id .' AND '. implode(' AND ', $sql) . ' GROUP BY `customers`.id ORDER BY `customers`.id')->execute('slave');

                if ($filename)
                {
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $filename . '"');
                    echo "\xEF\xBB\xBF" . "Email,Country,Time,Orders\n";
                    foreach ($result as $data)
                    {
                        echo $data['email'] . ',';
                        echo $data['country'] . ',';//$str='123'.$ab.'45';
                        echo $data['time'] . ',';
                        echo $data['orders'] . ',';
                        echo "\n";
                    }
                }else{
                    $this->request->redirect('/admin/site/customer/list');
                }
            }
            elseif ($type == 'order')
            {

                if ($country)
                {
                    $sql[] = 'shipping_country = "' . $country . '" ';
                }
                $timestatus=8*3600;
                $filename = 'Order_customers_' . $country . $file . '.csv';
                $result = DB::query(Database::SELECT, 'SELECT `email`, `shipping_country` AS country, FROM_UNIXTIME(created+'.$timestatus.') AS `time` ,amount,rate 
                    FROM orders WHERE ' . implode(' AND ', $sql) . ' AND payment_status = "verify_pass" AND is_active = 1 ORDER BY id')->execute('slave')->as_array();
                

                if ($filename)
                {

                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="' . $filename . '"');
                    echo "\xEF\xBB\xBF" . "Email,Country,Time,Revenue\n";
try{
                    foreach ($result as $data)
                    {

                        echo $data['email'] . ',';
                        echo $data['country'] . ',';//$str='123'.$ab.'45';
                        echo $data['time'] . ',';
                        $rate=floatval($data['rate']);
                        $amount=floatval($data['amount']);
                        if(empty($rate)){
                            echo 'null'.',';
                        }else{
                            $revenue=round($amount/$rate,2);
                            echo $revenue . ',';   
                        }
                        echo "\n";

                    }
}catch(Exception $e){
print $e->getMessage();   
exit();
}
                }else{
                    $this->request->redirect('/admin/site/customer/list');
                }
                
            }
            
        }
    }

/*    public function action_wishlist_mail()
    {
        $result = DB::query(DATABASE::SELECT, 'SELECT DISTINCT w.customer_id FROM wishlists w LEFT JOIN products p ON w.product_id = p.id 
            WHERE w.site_id = 1 AND w.is_mailed = 0 AND p.visibility = 1 AND p.status = 1 AND p.stock <> 0 ORDER BY w.customer_id ASC LIMIT 0, 100')->execute('slave')->as_array();
        echo 'Customer Wishlist Mail Send Success:<br>';
        foreach ($result as $val)
        {
            $wishlists = DB::query(DATABASE::SELECT, 'SELECT w.product_id, p.name, p.link, p.configs FROM wishlists w LEFT JOIN products p ON w.product_id = p.id 
                WHERE w.customer_id = ' . $val['customer_id'] . ' AND p.visibility = 1 AND p.status = 1 AND p.stock <> 0')
                    ->execute('slave')->as_array();
            $rcpt = Customer::instance($val['customer_id'])->get('email');
            if ($rcpt AND !empty($wishlists))
            {
                $from = Site::instance()->get('email');
                $subject = "See What's In Your Wishlists?";
                $body = View::factory('admin/site/mail_wishlist')->set('wishlists', $wishlists);
//                if (strpos($rcpt, '@hotmail.') or strpos($rcpt, '@live.'))
                if (0)
                {
                    $send = Mail::SendSMTP($rcpt, $from, $subject, $body);
                }
                else
                {
                    $send = Mail::Send($rcpt, $from, $subject, $body);
                }
                if ($send)
                {
                    $update = DB::update('wishlists')->set(array('is_mailed' => 1))->where('site_id', '=', $this->site_id)->where('customer_id', '=', $val['customer_id'])->execute();
                    if ($update)
                        echo $rcpt . '<br>';
                }
            }
        }
    }*/

    public function action_coupon_mail(){
        $sql = "select C.id,M.email,C.code,M.firstname,C.expired    
            from carts_coupons C , carts_customercoupons L , customers M 
            where  C.id=L.coupon_id and L.customer_id=M.id and C.expired>unix_timestamp(now()) and C.expired<(unix_timestamp(now())+3600*24*3) and C.code like \"SIGNUP15OFF%\" and C.used=0 and C.is_mailed=0
            group by L.customer_id
            limit 100";
        $result = DB::query(DATABASE::SELECT,$sql)->execute('slave');
        foreach ($result as $value) {
            $mail_params = array();
            $mail_params['firstname'] = isset($value['firstname'])?$value['firstname']:"";
            $mail_params['coupon_code'] = $value['code'];
            $day = ceil(($value['expired']-time())/(3600*24));
            $mail_params['day'] = $day;
            $mail = $value['email'];
            Mail::SendTemplateMail('15 OFF CODE REMINDING', $mail, $mail_params);
            DB::query(DATABASE::UPDATE,"update carts_coupons set is_mailed=1 where id=".$value['id'])->execute();
            echo $mail."-SUCCESS!<br>";
        }
    }

    public function action_update_country()
    {
        // include the php script  
        require(APPPATH . "classes/geoip.inc.php");
        $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
        
        $customers = DB::select('id', 'ip')
        ->from('accounts_customers')
        ->where('ip_country', '=', '')
        ->where('ip', '<>', 0)
        ->where('ip', '<>', '2147483647')
        ->order_by('id')
        ->limit(1000)
        ->offset(0)
        ->execute('slave');
        foreach($customers as $c)
        {
            $ip = long2ip($c['ip']);
            $country_code = geoip_country_code_by_addr($gi, $ip);
            echo $c['id'] . '-' . $ip . ':' . $country_code . '<br>';
            if($country_code)
                DB::update('accounts_customers')->set(array('ip_country' => $country_code))->where('id', '=', $c['id'])->execute();
            else
                DB::update('accounts_customers')->set(array('ip_country' => '-'))->where('id', '=', $c['id'])->execute();
        }
        echo '<script type="text/javascript">
                    window.setInterval(pagerefresh, 10000);
                    function pagerefresh() 
                    { 
                        window.location.reload();
                    }     
            </script>';
    }

    //guo add
    public function action_get_country()
    {
        // include the php script  
        require(APPPATH . "classes/geoip.inc.php");
        $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=customers.csv');  
        echo "\xEF\xBB\xBF" . "Email\n";           
        $customers = DB::select('id', 'ip','email')
        ->from('accounts_customers')
      //  ->where('ip_country', '=', '')
        ->where('ip', '<>', 0)
        ->where('ip', '<>', '2147483647')
        ->order_by('id')
/*        ->limit(1000)
        ->offset(0)*/
        ->execute('slave');
        $arr = array();
        foreach($customers as $c)
        {
            $ip = long2ip($c['ip']);
            $country_code = geoip_country_code_by_addr($gi, $ip);
           // echo $c['id'] . '-' . $ip . ':' . $country_code . '<br>';
            if($country_code == 'FR'){
                $arr[]['email'] =$c['email']; 
            }
  
        }

        foreach($arr as $v){

           echo $v['email']. ',';
            echo "\n";
        }

    }

    public function action_vip()
    {
        if($_POST)
        {
            $start = Arr::get($_POST, 'start', '');
            $end = Arr::get($_POST, 'end', '');
            if(!$start)
            {
                $this->request->redirect('/admin/site/customer/vip');
            }
            $type = Arr::get($_POST, 'submit', 'filter');
            if($type == 'filter')
            {
                $url = '?total=' . $start . '-' . $end;
                $this->request->redirect('/admin/site/customer/vip' . $url);
            }
            else
            {
                $filter_sql = '';
                if(!$end)
                {
                    $filter_sql .= ' AND' . ' order_total >= ' . trim($start);
                }
                else
                {
                    $filter_sql .= ' AND' . ' order_total >= ' . trim($start) . ' AND order_total <= ' . trim($end);
                }
                $customers = DB::query(DATABASE::SELECT, 'SELECT id, email, ip_country, created, order_total, vip_level FROM customers
                        WHERE site_id=' . $this->site_id . ' AND vip_level > 1 '
                        . $filter_sql)->execute('slave');
                $filename = 'Vip_customer ' . $start . '-' . $end;
                /** Error reporting */
                error_reporting(E_ALL);

                date_default_timezone_set('America/Chicago');
                header('Content-type: text/csv');
                header('Content-Disposition: attachment; filename=' . $filename . '.csv');

                echo "\xEF\xBB\xBF" . "Id,Email,Country,Vip level,Created,Order total,Order Qty,Last Order Date\n";
                foreach ($customers as $customer)
                {
                    $orders = DB::select('id', 'created')->from('orders_order')->where('customer_id', '=', $customer['id'])->where('payment_status', 'IN', array('verify_pass', 'success'))->where('refund_status', '=', '')->execute('slave');
                    $last_order_date = 0;
                    $order_qty = 0;
                    foreach($orders as $order)
                    {
                        $order_qty ++;
                        if($order['created'] > $last_order_date)
                            $last_order_date = $order['created'];
                    }
                    echo $customer['id'] . ',';
                    echo $customer['email'] . ',';
                    echo $customer['ip_country'] . ',';
                    echo $customer['vip_level'] . ',';
                    echo date('Y-m-d', $customer['created']) . ',';
                    echo $customer['order_total'] . ',';
                    echo $order_qty . ',';
                    echo date('Y-m-d H:i:s', $last_order_date) . ',';
                    echo "\n";
                    
                }
                exit;
            }
        }
        $content = View::factory('admin/site/customer_vip')->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_vip_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
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
                else
                {
                    $_filter_sql[] = $item->field . " = " . $item->data;
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $filter_total = trim(Arr::get($_REQUEST, 'total', ''));
        if($filter_total)
        {
            $filterTotal = explode('-', $filter_total);
            if(!isset($filterTotal[1]) OR !$filterTotal[1])
            {
                $filter_sql .= ' order_total >= ' . trim($filterTotal[0]);
            }
            else
            {
                $filter_sql .= ' order_total >= ' . trim($filterTotal[0]) . ' AND order_total <= ' . trim($filterTotal[1]);
            }
        }

        if($filter_sql)
            $filter_sql = ' AND ' . $filter_sql;

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(`id`) AS num FROM `customers` WHERE site_id=' . $this->site_id . ' AND is_vip >= 1 '
                . $filter_sql)->execute('slave')->get('num');
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT id, email, ip_country, created, order_total, is_vip FROM customers
        WHERE site_id=' . $this->site_id . ' AND is_vip >= 1 '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $customer)
        {
            $orders = DB::select('id', 'created')->from('orders_order')->where('customer_id', '=', $customer['id'])->where('payment_status', 'IN', array('verify_pass', 'success'))->where('refund_status', '=', '')->execute('slave');
            $last_order_date = 0;
            $order_qty = 0;
            foreach($orders as $order)
            {
                $order_qty ++;
                if($order['created'] > $last_order_date)
                    $last_order_date = $order['created'];
            }
            $responce['rows'][$k]['id'] = $customer['id'];
            $responce['rows'][$k]['cell'] = array(
                $customer['id'],
                $customer['email'],   
                $customer['ip_country'],
                $customer['is_vip'],
                date('Y-m-d', $customer['created']),
                $customer['order_total'],
                $order_qty,
                date('Y-m-d H:i:s', $last_order_date),
            );
            $k++;
        }
        echo json_encode($responce);
    }

    //大批量用户数据导入 guo update time 2015/9/15
    public function action_memerin(){
        $startTime = microtime(true);
        set_time_limit(0);
        ini_set("memory_limit", "1024M");
        $file_types = array(
            "application/vnd.ms-excel",
            "text/csv",
            "application/csv",
            "text/comma-separated-values",
            "application/octet-stream",
            "application/oct-stream"
        );
        if (!isset($_FILES) || (!in_array($_FILES["tb_file"]["type"], $file_types)))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["tb_file"]["tmp_name"], "r");
        $row = 1;
        while ($data = fgetcsv($handle))
        {

            try
            {
                if ($data[0] == 'email' OR $data[0] == 'email')
                {
                    $row++;
                    continue;
                }
                $array = array();
                if ($data[0])
                {

                    $email = $data[0];
                    $user_ip = $this->rand_ip();//随机IP
                    $user_ip = str_replace('.', '', $user_ip);
                    $created = $this->rand_date();//随机IP

                    $datas['email'] = $email;
                    $datas['firstname'] = $data[2];
                    $datas['lastname'] = $data[1];
                    $datas['country'] = $data[3];
                    $datas['ip_country'] = $data[3];
                    $datas['ip'] = $user_ip;
                    $datas['created'] = $created;
                    $datas['flag'] = 1;
                    DB::insert('customers', array_keys($datas))->values($datas)->execute();
                    $row++;
                }
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }

        $endtime = microtime(true);
        echo '执行时长：'.($endtime-$startTime).'，共执行插入：'.$row.'条';
    }
    
    //随机IP
    public function rand_ip(){
        $ip_long = array(
                array('607649792', '608174079'), //36.56.0.0-36.63.255.255
                array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
                array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
                array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
                array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
                array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
                array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
                array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
                array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
                array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
        );
        $rand_key = mt_rand(0, 9);
        $ip       = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
        return $ip;
    }
    
    //随机日期
    public function rand_date(){
        $start_time = strtotime(date('2015-09-01')); 
        $end_time  = strtotime(date('2016-03-19')); 
        $rand_date = mt_rand($start_time,$end_time);
        return $rand_date;
    }
    
    //随机First_name
    public function rand_fname(){
        $str = "abcdefghijklmnopqrstuvwxyz";
        $finalStr = "";
        for($j=0;$j<4;$j++){
            $finalStr .= substr($str,rand(0,25),1);
        }
        return ucfirst($finalStr);
    }
    
    //随机last_name
    public function rand_lname(){
        $str = "abcdefghijklmnopqrstuvwxyz";
        $finalStr = "";
        for($j=0;$j<4;$j++){
            $finalStr .= substr($str,rand(0,25),1);
        }
        return $finalStr;
    }
    
    //随机国家
    public function rand_country(){
        $country = DB::query(Database::SELECT, 'select isocode from countries order by id desc')->execute()->as_array();
        $int = array_rand($country);
        return $country[$int]['isocode'];
    }

    public function action_birthday()
    {
        api::send_birthday_email();
    //     $today = date('Y-m-d');
    //     $temp = explode('-', $today);
    //     $birth = array($temp['1'],$temp['2']);
    //     $birthday = implode('-', $birth);
    // try
    //         {
    //             $user = DB::select('email','firstname')->from('accounts_customers')
    //                 ->where('birth','!=', '')
    //                 ->and_where('birth','=', $birthday)
    //                 ->execute();
    //           foreach($user as $v){
    //                     $mail_params['firstname'] = $v['email'];
    //                     $mail_params['email'] = $v['firstname'];

    //                     var_dump($mail_params);

    //             // Mail::SendTemplateMail('BIRTHDAY', $mail_params['email'], $mail_params);
              
    //           }

    //         }
    // catch( Database_Exception $e )
    // {
    //     echo $e->getMessage();
    // }

/*            echo '<script type="text/javascript">
                window.setInterval(pagerefresh, 10000);
                window.setInterval(logout, 11000);
                function pagerefresh() 
                { 
                    window.open("/news/sendmail1"); 
                }
                function logout()
                {
                    parent.window.opener = null;
                    parent.window.open("", "_self");
                    parent.window.close();
                }
            </script>';
        exit;*/
        //return $user;

    }

public function action_export_by_wishlist_not_payment()
     {
        
        $to_date=time();
        $from_date=time()-3600*24*15;
        //查找15天内下心愿单的信息
        $sql = 'select customer_id cid,
                product_id pid,
                FROM_UNIXTIME(created) created
                from wishlists 
                where  created<'.$to_date.' and created>='.$from_date.'
                order by cid,created
                ';
                
        $result = DB::query(DATABASE::SELECT, $sql)->execute('slave')->as_array();
        if(empty($result)) {return false;}
        $wishlist_arr=array();
        foreach ($result as  $v0) {
            $wishlist_arr[$v0['cid']][$v0['pid']]=$v0['created'];
        }
        if(empty($wishlist_arr)){return false;}
        
        foreach ($wishlist_arr as $cid => $arr) {
            if(empty($cid)){
                continue;
            }
            // $pid=implode(',', $pid_arr);
            //查找已购，找到就从数组中删掉
            $sql = 'select oi.product_id oi_pid
                    from orders o
                    LEFT JOIN order_items oi on o.id=oi.order_id
                    where o.customer_id='.$cid.'  and o.payment_status="verify_pass"
                ';
                
            $result = DB::query(DATABASE::SELECT, $sql)->execute('slave')->as_array();
            if(empty($result)){
                continue;
            }
            $oi_pid_tmp=array();
            foreach ($result as $v1) {
                $oi_pid_tmp[$v1['oi_pid']]=$v1['oi_pid'];
            }
            if(empty($oi_pid_tmp)){
                continue;
            }
            //筛选
            


            foreach ($arr as $pid=>$time) {
                if(in_array($pid,$oi_pid_tmp)){
                    
                    unset($wishlist_arr[$cid][$pid]);
                }
            }
           

        }



        $res_data=array();
        foreach ($wishlist_arr as $cid => $arr) {

            $sql = 'select email from customers where id='.$cid.' limit 1';
            $result = DB::query(DATABASE::SELECT, $sql  )->execute('slave')->current();
            if(empty($result['email'])){
                continue;
            }
            $email=$result['email'];
            $skus=array();
            foreach ($arr as $pid=>$time) {
                $sql = 'select sku,status from products where id='.$pid.' limit 1';
                $result = DB::query(DATABASE::SELECT, $sql  )->execute('slave')->current();
                if(empty($result['sku'])){
                    continue;
                }
                $skus[$result['sku']]=array(
                    'time'=>$time,
                    'status'=>$result['status'],
                    );
                
            }
            $res_data[$email]=$skus;
        }

        $str='';
        $str.='Customer,SKU,Time,Status'."\n";
     
        foreach ($res_data as $email => $skus) {

            foreach ($skus as $sku => $v1) {

                $str.=$email.",".$sku.",".$v1['time'].",".$v1['status']."\n";
            }
        }

        header("Content-type:text/csv");   
        header("Content-Disposition:attachment;filename=wishlist_not_payment.csv");   
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
        header('Expires:0');   
        header('Pragma:public');  
        echo $str;

        // header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
        // header('Content-type:application/vnd.ms-excel');//输出的类型
        // header('Content-Disposition: attachment; filename="prolistinfo.csv"'); //下载显示
        // echo iconv("UTF-8", "GBK//IGNORE",$str);


        
        
     }

public function action_output_customer_by_order_category_once()
      {
            $sql = 'select 
            orders.customer_id,customers.email,customers.ip_country,count(orders.id) order_count 
            from orders
            left JOIN customers on orders.customer_id= customers.id
            where customers.flag = 0 and  payment_status in ("success","verify_pass")  
            GROUP BY customer_id';
            $result = DB::query(DATABASE::SELECT, $sql  )->execute('slave');
            $res_arr=array();
             foreach ($result as $r_value) {
                if($r_value['order_count']==1){
                    $re=array();
                    $re['email']=$r_value['email'];
                    $re['country']=$r_value['ip_country'];
                    $res_arr[]=$re;
                }
            }
            $str='';
            $str.="\xEF\xBB\xBF" .'Email,Country'."\n";
            foreach ($res_arr as $value) {
                $str.=$value['email'].','.$value['country']."\n";
            }
            error_reporting(E_ALL);
            date_default_timezone_set('America/Chicago');
            header("Content-type:text/csv");   
            header("Content-Disposition:attachment;filename=once.csv");   
            
            echo $str; 
      }

      public function action_output_customer_by_order_category_oncemore()
      {
        $sql = 'select 
            orders.customer_id,customers.email,customers.ip_country,count(orders.id) order_count 
            from orders
            left JOIN customers on orders.customer_id= customers.id
            where customers.flag = 0 and  payment_status in ("success","verify_pass")  
            GROUP BY customer_id';
            $result = DB::query(DATABASE::SELECT, $sql  )->execute('slave');
            $res_arr=array();
             foreach ($result as $r_value) {
                if(intval($r_value['order_count'])>1){
                    $re=array();
                    $re['email']=$r_value['email'];
                    $re['country']=$r_value['ip_country'];
                    $res_arr[]=$re;
                }
            }
            $str='';
            $str.="\xEF\xBB\xBF" .'Email,Country'."\n";
            foreach ($res_arr as $value) {
                $str.=$value['email'].','.$value['country']."\n";
            }
            error_reporting(E_ALL);
            date_default_timezone_set('America/Chicago');
            header("Content-type:text/csv");   
            header("Content-Disposition:attachment;filename=oncemore.csv");   
              
            echo $str; 
      }

      public function action_output_customer_by_order_category_none()
      {
        set_time_limit(0); 

        $sql = 'select 
            email,ip_country
            from customers
            where flag = 0 and order_total= 0';
            $result = DB::query(DATABASE::SELECT, $sql  )->execute('slave');
            $res_arr=array();
             foreach ($result as $r_value) {
                
                    $re=array();
                    $re['email']=$r_value['email'];
                    $re['country']=$r_value['ip_country'];
                    $res_arr[]=$re;
                
            }
            $str='';
            $str.="\xEF\xBB\xBF" .'Email,Country'."\n";
            foreach ($res_arr as $value) {
                $str.=$value['email'].','.$value['country']."\n";
            }
            
            error_reporting(E_ALL);
            date_default_timezone_set('America/Chicago');
            header("Content-type:text/csv");   
            header("Content-Disposition:attachment;filename=none.csv");   
             
            echo $str;
            
                
      }
	  
	  
	//获取下个月
	function getNextMonthDays($date){
		$timestamp=strtotime($date);
		$arr=getdate($timestamp);
		if($arr['mon'] == 12){
			$year=$arr['year']+1;
			$month=$arr['mon'] -11;
			$firstday=$year.'-0'.$month.'-01';
			$lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
		}else{
			$firstday=date('Y-m-01',strtotime($arr['year'].'-'.(date('m',$timestamp)+1).'-01'));
			$lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
		}
		return array($firstday,$lastday);
	}
	  


    //2016、3、14 新vip制度
    public function action_newvip(){
		/*
			$kai=$this->getNextMonthDays("2015-11-01");
			$page = Arr::get($_GET, 'page', 1);
            $sql = array();
            
			//设置默认
			$start="2015-01-01";
			$end="2015-02-01";
			if($page>=2 && $page<=12){
				$page_r=$page-1;
				$i=0+$page_r;
				$j=$page_r+1;
				$kai_start=$this->getNextMonthDays("2015-".$i."-01");
				$kai_end=$this->getNextMonthDays("2015-".$j."-01");
				$start=$kai_start[0];
				$end=$kai_end[0];
			}else{
				$start="2015-01-01";
				$end="2015-02-01";
			}
			*/
			$file = '';
			$sql = array();
			$start="2015-01-01";
			$end="2015-12-31";
            if ($start)
            {
                $file .= "-from-$start";
                $sql[] .= 'verify_date >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $sql[] .= 'verify_date < ' . strtotime($end);
            }
			
			//SELECT customer_id,sum(amount/rate) as sum_amount FROM `orders_order` where payment_status="verify_pass" and is_active=1 and verify_date BETWEEN unix_timestamp('2015-01-01') AND unix_timestamp('2015-02-01') GROUP BY customer_id HAVING(sum_amount >= 199) ORDER BY customer_id
			$result = DB::query(Database::SELECT, 'SELECT id,customer_id,email,sum(amount/rate) as sum_amount FROM `orders_order` where payment_status="verify_pass" and refund_status<>"refund" and is_active=1 and '.implode(' AND ',$sql).' GROUP BY customer_id HAVING(sum_amount >= 199) ORDER BY customer_id')->execute('slave')->as_array();
			echo "总数为".count($result);
			//$result = DB::query(Database::SELECT, 'SELECT a.email as email,sum(a.count) as count FROM (select email,amount * rate count FROM `orders_order` where payment_status="verify_pass" and is_active=1 and '.implode(' AND ',$sql).' ORDER BY id ) as a where a.count >= 199  group by a.email ')->execute('slave')->as_array();
			//查询这段时间的新vip用户
            $user_new=array();
			$data['is_vip']=1;
			$data['vip_start']=time();
			$data['vip_end']=strtotime(date('Y',time())+1 .'-'.date('m-d H:i:s'));
			foreach($result as $k=>$v){
				if($v['customer_id'] && $v['sum_amount']>=199){
					//echo "ok";
					DB::update('accounts_customers')->set($data)->where('id', '=', $v['customer_id'])->execute();
				}
			}
			echo "ok";
        exit;
        
    }
	
	
	/**
     * 消费会员
     * add 2016-03-22
     */
	public function action_newvip1()
    {
		//获取当前的月份
		$month=date('m');
		$day=date('d');

		//获取去年这个时候的月份
		$lastyear=strtotime('last year');
		//去年这个时候的时间
		$last=date('Y-m-d',$lastyear);
		$page = Arr::get($_GET, 'page', 1);
        $limit =1000;
		//获取消费会员开始时间
		/*
		if($day<8){
			//本月
			$start_vip=mktime(0, 0 , 0,date("m"),1,date("Y"))+7*3600*24;
		}else{
			//下个月份
			$start_vip=mktime(0, 0 , 0,date("m")+1,1,date("Y"))+7*3600*24;
		}
		*/
		$startvip=strtotime('2015-01-01 00:00:00');
		
		$sql = array();
		$file = '';
		$up="";
		$up1="";

		$result = DB::query(Database::SELECT, 'SELECT customer_id,email,sum(amount/rate) as sum_amount FROM `orders_order` where payment_status="verify_pass" and refund_status<>"refund" and is_active=1 and verify_date>'.$startvip.' GROUP BY customer_id HAVING(sum_amount >= 199) ORDER BY customer_id limit '.$limit.' offset '.($page - 1) * $limit.' ')->execute('slave')->as_array();
		foreach($result as $k=>$v){
			if($v['customer_id'])
			{
				$vip_ok=DB::query(Database::SELECT, 'SELECT id,ordernum,verify_date FROM `orders_order` where customer_id='.$v['customer_id'].' and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 ORDER BY id desc limit 1')->execute('slave')->current();
				//去年下单时间
				if($vip_ok['verify_date']>strtotime('2016-01-01 00:00:00')){
					$last_time=strtotime(date('Y',$vip_ok['verify_date'])-1 .'-'.date('m-d H:i:s',$vip_ok['verify_date']));
					$result1 = DB::query(Database::SELECT, 'SELECT id,customer_id,email,sum(amount/rate) as sum_amount FROM `orders_order` where customer_id='.$v['customer_id'].' and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 and verify_date > '. $last_time .' and  verify_date <= '. $vip_ok['verify_date'] .'')->execute('slave')->current();
					//获取用户vip时间(和用户最终下单时间比较)
					if($result1['sum_amount']>=199){
						echo "123";
						$data['is_vip']=2;
						$data['vip_start']=$vip_ok['verify_date'];
						$data['vip_end']=strtotime(date('Y',$vip_ok['verify_date'])+1 .'-'.date('m-d H:i:s',$vip_ok['verify_date']));
							$up .=$v['customer_id']."<br/>";
							DB::update('accounts_customers')->set($data)->where('id', '=', $v['customer_id'])->execute();
					}
				}
			}
		}
		
		
		
		/*
		foreach($result as $k=>$v){
			if($v['customer_id'])
			{
				$vip_ok=DB::query(Database::SELECT, 'SELECT id,ordernum,verify_date FROM `orders_order` where customer_id='.$v['customer_id'].' and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 ORDER BY id desc limit 1')->execute('slave')->current();
				//去年下单时间
				if($vip_ok['verify_date']>strtotime('2016-01-01 00:00:00')){
					$last_time=strtotime(date('Y',$vip_ok['verify_date'])-1 .'-'.date('m-d H:i:s',$vip_ok['verify_date']));
					$result1 = DB::query(Database::SELECT, 'SELECT id,customer_id,verify_date,email,sum(amount/rate) as sum_amount FROM `orders_order` where customer_id='.$v['customer_id'].' and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 and verify_date > '. $last_time .' and  verify_date <= '. $vip_ok['verify_date'] .'')->execute('slave')->current();
					//获取用户vip时间(和用户最终下单时间比较1)
					if($result1['sum_amount']>=199){
						$data['is_vip']=2;
						$data['vip_start']=$result1['verify_date'];
						$data['vip_end']=strtotime(date('Y',$result1['verify_date'])+1 .'-'.date('m-d H:i:s',$result1['verify_date']));
						$up .=$v['customer_id']."<br/>";
						DB::update('accounts_customers')->set($data)->where('id', '=', $v['customer_id'])->execute();
						//$newvip_id=DB::query(Database::SELECT, 'SELECT id,firstname,lastname,email,is_vip,vip_start,vip_end FROM `customers` where id='.$v['customer_id'].' ')->execute('slave')->current();
						/*
						if($newvip_id['vip_start'] != $result1['verify_date']){
							$mail_params=array();
							//$mail_params['email']=$newvip_id['email'];
							$mail_params['email']='674514904@qq.com';
							$mail_params['firstname'] = $newvip_id['firstname'].$newvip_id['lastname'];
							$mail_params['startdate'] = date('Y-m-d', $newvip_id['vip_start']);
							$mail_params['enddate'] = date('Y-m-d', $newvip_id['vip_end']);
							$mail_params['amount'] = "$".$result1['sum_amount'];
							Mail::SendTemplateMail('NEWVIP', $mail_params['email'], $mail_params);
							exit;
						}
						
					}
				}
			}
		}
		
		$over_time=DB::query(Database::SELECT, 'SELECT id,email,is_vip,vip_end FROM `customers` where is_vip>=1 and vip_end<='.time())->execute('slave')->as_array();
		foreach($over_time as $k1=>$v1){
			if($v1['is_vip']>=1){
				$up1 .=$v1['email']."<br/>";
				DB::update('accounts_customers')->set(array('is_vip'=>0))->where('id', '=', $v1['id'])->execute();
			}
		}
		*/
		
		header("Content-type: text/html; charset=utf-8"); 
		echo "此次更新的用户有(再次下单)<br/>".$up."<br/>";
		//echo "此次会员到期的用户有(到期时间小于当前时间就属于过期)<br/>".$up1."<br/>";
		
		echo '<script type="text/javascript">
                setTimeout("pagerefresh()",5000);
                setTimeout("logout()",6000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '");
                }
                function logout()
                {
                    parent.window.opener = null;
                    parent.window.open("", "_self");
                    parent.window.close();
                }
            </script>';
		
        exit;
    }
	
	
	/**
	*	wp vip发邮件
	* 	add 2016.5.10
	*
	**/
	public function action_wpvipsendemail()
	{
		$vipuserarr=DB::query(Database::SELECT, 'SELECT id,firstname,lastname,email,is_vip,vip_start,vip_end FROM `customers` where is_vip=2 ')->execute('slave')->as_array();
		foreach($vipuserarr as $k=>$v){
			if($v['is_vip']>0){
				$vip_ok=DB::query(Database::SELECT, 'SELECT id,ordernum,verify_date FROM `orders_order` where customer_id='.$v['id'].' and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 ORDER BY id desc limit 1')->execute('slave')->current();
				$last_time=strtotime(date('Y',$vip_ok['verify_date'])-1 .'-'.date('m-d H:i:s',$vip_ok['verify_date']));
				$sum_amount=DB::query(Database::SELECT, 'SELECT email,sum(amount/rate) as sum_amount FROM `orders_order` where customer_id='.$v['id'].' and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 and verify_date>'.$last_time.' ')->execute('slave')->as_array();
				foreach($sum_amount as $k1=>$v1){
					if($v1['sum_amount']>0){
						if($v['vip_start'] != $vip_ok['verify_date']){
							$mail_params=array();
							$mail_params['email']=$v['email'];
							$mail_params['firstname'] = $v['firstname'].$v['lastname'];
							$mail_params['startdate'] = date('Y-m-d', $v['vip_start']);
							$mail_params['enddate'] = date('Y',$vip_ok['verify_date'])+1 .'-'.date('m-d',$vip_ok['verify_date']);
							$mail_params['amount'] = "$".$v1['sum_amount'];
							Mail::SendTemplateMail('NEWVIP', $mail_params['email'], $mail_params);
						}
					}
				}
			}
		}
	}
	
	/**
	 * 导出所有会员列表
	 * add 2016-03-22
	*/
	public function action_getvipall()
	{
		$sql = array();
		$file = '';
		$start = Arr::get($_POST, 'start', NULL);
		$end = Arr::get($_POST, 'end', NULL);
		
		if ($start)
		{
			$file .= "-from-$start";
			$sql[] .= 'vip_start >= ' . strtotime($start);
		}

		if ($end)
		{
			$file .= "-to-$end";
			$sql[] .= 'vip_start < ' . strtotime($end);
		}
		if($start || $end){
			$customers = DB::query(DATABASE::SELECT, 'SELECT email,created,is_vip,vip_start,vip_end,users_admin,users_update,users_admin_main FROM customers WHERE is_vip>0 and '.implode(' AND ',$sql).' ORDER BY id')->execute('slave')->as_array();
		}else{
			$customers = DB::query(DATABASE::SELECT, 'SELECT email,created,is_vip,vip_start,vip_end,users_admin,users_update,users_admin_main FROM customers WHERE is_vip>0 ORDER BY id')->execute('slave')->as_array();
		}
		
		$startvip=strtotime('2015-01-01 00:00:00');
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="vip_customers.csv"');
        echo "email,created,vip_start,vip_end,ordernum,amount,orders_amount,users_admin,users_update\n";
		if(count($customers)>0){
			
		
		foreach($customers as $k=>$v){
			$o=0;
			$orders=DB::query(DATABASE::SELECT, 'SELECT ordernum,amount / rate as amount FROM orders WHERE email="'.$v['email'].'" and verify_date>="'.$startvip.'" and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 ORDER BY verify_date')->execute('slave')->as_array();
			foreach($orders as $k1=>$v1){
				$num="";
				$o+=$v1['amount'];
				//获取刚好满足199美元的订单
				if($o>199){
					$ordernum_vip=$orders[$k1];
					break;
				}
			}
			//开始导表
			echo $v['email'], ',';
			echo '"' . date('Y-m-d', $v['created']) . '"', ',';
			echo '"' . date('Y-m-d', $v['vip_start']) . '"', ',';
			echo '"' . date('Y-m-d', $v['vip_end']) . '"', ',';
			echo '"'.$ordernum_vip['ordernum'].'"', ',';
			echo '"'.$ordernum_vip['amount'].'"', ',';
			//历史消费总金额
			$orders1=DB::query(DATABASE::SELECT, 'SELECT sum(amount/rate) as amount1 FROM orders WHERE email="'.$v['email'].'" and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 ORDER BY verify_date')->execute('slave')->as_array();
			echo '"'.$orders1[0]['amount1'].'"', ',';
			$users_email = DB::select('name')->from('auth_user')->where('id','=',$v['users_admin'])->where('created', '>', 0)->execute('slave')->get('name');
			echo $users_email, ',';
			if($v['users_update']){
					echo '"' . date('Y-m-d', $v['users_update']) . '"', ',' , PHP_EOL;;
				}else{
					echo "0",',' , PHP_EOL;;
				}
		}
		}else{
			echo "没有数据!";
		}
		
	}
	
	
	/**
     * 按具体时间导出vip用户表
     * add 2016-03-22
     */
	public function action_getnewvip()
	{
		if($_POST){
			/*
			$sql = array();
            $file = '';
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
			
            if ($start)
            {
                $file .= "-from-$start";
                $sql[] .= 'vip_start >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $sql[] .= 'vip_start < ' . strtotime($end);
            }
			var_dump($sql);
			exit;
			$result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`customers`.`id`) AS num FROM `customers` WHERE `customers`.site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave');
			*/
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="vip_customers.csv"');
			echo "email,vip_start,vip_end\n";
			$vip_type = Arr::get($_POST, 'vip_type', NULL);
			if($vip_type=='6'){
				$i='6';
			}else if($vip_type=='3'){
				$i='3';
			}else if($vip_type=='1'){
				$i='1';
			}
			$time=time();
			$end_time=strtotime(''.$i.' month',time());
			$customers = DB::query(DATABASE::SELECT, 'SELECT id,email,vip_start,vip_end FROM customers WHERE is_vip>0 and vip_end>='.$time.' and vip_end<'.$end_time.' ORDER BY id')->execute('slave')->as_array();
			if(count($customers)>0){
				foreach($customers as $k=>$v){
					//开始导表
					echo $v['email'], ',';
					echo '"' . date('Y-m-d', $v['vip_start']) . '"', ',';
					echo '"' . date('Y-m-d', $v['vip_end']) . '"', ',' , PHP_EOL;;
				}
			}else{
				echo "没有满足的数据";
			}
		}
		
	}
	
	/**
     * 导出所有vip用户
     * add 2016-03-22
     */
	public function action_getvipallone()
	{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="vip_customers.csv"');
		echo "email,is_vip,vip_start,vip_end,users_admin,users_admin_main,users_update\n";
		$result = DB::query(Database::SELECT, 'select email,is_vip,vip_start,vip_end,users_admin,users_admin_main,users_update from `customers` where is_vip>0')->execute('slave')->as_array();
		if(count($result)>0){
			foreach($result as $k1=>$v1){
				//开始导表
				echo $v1['email'], ',';
				echo $v1['is_vip'], ',';
				echo date('Y-m-d', $v1['vip_start']), ',';
				echo date('Y-m-d', $v1['vip_end']), ',';
				$users_email = DB::select('name')->from('auth_user')->where('id','=',$v1['users_admin'])->where('created', '>', 0)->execute('slave')->get('name');
				echo $users_email, ',';
				echo $v1['users_admin_main']?$v1['users_admin_main']:' ', ',';
				if($v1['users_update']){
					echo '"' . date('Y-m-d', $v1['users_update']) . '"', ',' , PHP_EOL;;
				}else{
					echo "0",',' , PHP_EOL;;
				}
				
			}
		}
	}
	
	
	/**
     * 导出有效的vip用户
     * add 2016-03-22
     */
	public function action_getvipallone1()
	{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="vip_customers.csv"');
		echo "email,is_vip,vip_start,vip_end,users_admin,users_admin_main,users_update\n";
		$result = DB::query(Database::SELECT, 'select email,is_vip,vip_start,vip_end,users_admin,users_admin_main,users_update from `customers` where is_vip>0 and vip_end>'.time().' ')->execute('slave')->as_array();
		if(count($result)>0){
			foreach($result as $k1=>$v1){
				//开始导表
				echo $v1['email'], ',';
				echo $v1['is_vip'], ',';
				echo date('Y-m-d', $v1['vip_start']), ',';
				echo date('Y-m-d', $v1['vip_end']), ',';
				$users_email = DB::select('name')->from('auth_user')->where('id','=',$v1['users_admin'])->where('created', '>', 0)->execute('slave')->get('name');
				echo $users_email, ',';
				echo $v1['users_admin_main']?$v1['users_admin_main']:' ', ',';
				if($v1['users_update']){
					echo '"' . date('Y-m-d', $v1['users_update']) . '"', ',' , PHP_EOL;;
				}else{
					echo "0",',' , PHP_EOL;;
				}
			}
		}
	}
	
	
	/**
     * 设置用户admin
     * add 2016-03-22
     */
	public function action_user_admin()
	{
        if ($_POST)
        {
			//获取用户邮箱
            $emailArr = Arr::get($_POST, 'emailARR', '');
            $user_email = Arr::get($_POST, 'user_email', '');
			//获取负责人id
			$user_id = DB::select('id')->from('auth_user')->where('email','=',$user_email)->where('created', '>', 0)->execute('slave')->get('id');
            if (!$emailArr)
            {
                Message::set('Email cannot be empty!', 'error');
                $this->request->redirect('/admin/site/customer/list');
            }
			if (!$user_id)
            {
                Message::set('admin(负责人)不存在 请重新输入!', 'error');
                $this->request->redirect('/admin/site/customer/list');
            }
            $emails = explode("\n", $emailArr);
			//获取主管邮箱
			$users_admin_main = User::instance()->logged_in();

            foreach ($emails as $email)
            {
				//获取客户id
                $customer_id = Customer::instance()->is_register(trim($email));
                if ($customer_id)
                {
                    $customer = Customer::instance($customer_id);
					$customer_admin=$customer->get('users_admin');
					if(!$customer_admin){
						$insert = array('users_admin' => $user_id, 'users_admin_main' => $users_admin_main['name']);
						DB::update('accounts_customers')->set(array('users_admin' => $user_id,'users_admin_main' => $users_admin_main['name'],'users_update' => time()))->where('id', '=', $customer_id)->execute();
					}else{
						DB::update('accounts_customers')->set(array('users_admin' => $user_id,'users_admin_main' => $users_admin_main['name'],'users_update' => time()))->where('id', '=', $customer_id)->execute();
					}
                }
            }
            Message::set('user_admin success!', 'success');
            $this->request->redirect('/admin/site/customer/list');
        }
	}
	
	
	/**
     * 按具体时间导出用户表
     * add 2016-03-24
     */
	public function action_getemailorder()
	{
		if($_POST){
			$sql = array();
            $file = '';
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
            $emailARR = Arr::get($_POST, 'emailARR', NULL);
			if (!$emailARR)
            {
                Message::set('Email cannot be empty!', 'error');
                $this->request->redirect('/admin/site/customer/list');
            }
            $emails = explode("\n", $emailARR);
			
            if ($start)
            {
                $file .= "-from-$start";
                $sql[] .= 'verify_date >= ' . strtotime($start);
            }else{
				$start="2015-01-01";
				$sql[] .= 'verify_date >= ' . strtotime($start);
			}

            if ($end)
            {
                $file .= "-to-$end";
                $sql[] .= 'verify_date < ' . strtotime($end);
            }else{
				$end="2015-12-31";
				$sql[] .= 'verify_date < ' . strtotime($end);
			}
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="vip_customers.csv"');
			echo "email,amount,rate,payment_status,count,verify_date\n";
				foreach($emails as $k=>$v){
				$result = DB::query(Database::SELECT, 'select email,amount,rate,payment_status,amount / rate count,verify_date FROM `orders_order` where email = "'.$v.'" and payment_status="verify_pass" and is_active=1 and '.implode(' AND ',$sql).' ')->execute('slave')->as_array();
					if(count($result)>0){
						foreach($result as $k1=>$v1){
						//开始导表
						echo $v1['email'], ',';
						echo $v1['amount'], ',';
						echo $v1['rate'], ',';
						echo $v1['payment_status'], ',';
						echo $v1['count'], ',';
						if($v1['users_update']){
								echo '"' . date('Y-m-d', $v1['users_update']) . '"', ',' , PHP_EOL;;
							}else{
								echo "0",',' , PHP_EOL;;
							}
						}
					}
				
				}
		}
	}
	
	public function action_get1emailorder()
	{
		if($_POST){
			$sql = array();
			$start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
			$file = '';
			if ($start)
            {
                $file .= "-from-$start";
                $sql[] .= 'verify_date >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $sql[] .= 'verify_date < ' . strtotime($end);
            }
			
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="user_orders.csv"');
			echo "订单号,email,amount,payment_status,verify_date\n";
			
			$result = DB::query(Database::SELECT, 'select ordernum,email,sum(amount/rate) as amount1,payment_status,verify_date FROM `orders_order` where payment_status="verify_pass" and is_active=1 and '.implode(' AND ',$sql).'  GROUP BY email ORDER BY email')->execute('slave')->as_array();
			if(count($result)>0){
					foreach($result as $k1=>$v1){
					//开始导表
					echo $v1['ordernum'], ',';
					echo $v1['email'], ',';
					echo $v1['amount1'], ',';
					echo $v1['payment_status'], ',';
					echo '"' . date('Y-m-d', $v1['verify_date']) . '"', ',' , PHP_EOL;;
					}
				}
		}
	}
	
	
	//获取会员已经分配admin的订单
	public function action_getadminorder()
	{
		if($_POST){
			$sql = array();
			$start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);
			
			if ($start)
            {
                $sql[] .= 'o.verify_date >= ' . strtotime($start);
            }

            if ($end)
            {
                $sql[] .= 'o.verify_date < ' . strtotime($end);
            }
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="admin_orders.csv"');
			echo "最终admin,email,最终admin时间,订单成功时间,订单号,payment_status,amount\n";
			
			$result = DB::query(Database::SELECT, 'select o.ordernum,o.email,c.users_update,o.amount / o.rate count,c.users_admin,o.payment_status,o.verify_date FROM `orders_order` o  LEFT JOIN customers c ON o.customer_id=c.id where o.payment_status="verify_pass" and c.users_admin>0 and o.is_active=1 and '.implode(' AND ',$sql).'  ORDER BY email')->execute('slave')->as_array();
			if(count($result)>0){
					foreach($result as $k1=>$v1){
					//开始导表
						if($v1['verify_date'] >= $v1['users_update']){
							$users_email = DB::select('name')->from('auth_user')->where('id','=',$v1['users_admin'])->where('created', '>', 0)->execute('slave')->get('name');
							echo $users_email, ',';
							echo $v1['email'], ',';
							echo date('Y-m-d', $v1['users_update']), ',';
							echo date('Y-m-d', $v1['verify_date']), ',';
							echo $v1['ordernum'], ',';
							echo $v1['payment_status'], ',';
							echo $v1['count'], ',', PHP_EOL;;
						
						}
					}
				}
		}
	}

    //用户批量加flag=3的标记 by xuli 20160712
    public function action_import_flag(){
        if($_POST){
            $emailArr = Arr::get($_POST, 'EmalARR', '');
            if(!$emailArr){
                Message::set('Email cannot be empty!', 'error');
                $this->request->redirect('/admin/site/customer/list');
            }
            $emails = explode("\n", $emailArr);
            $emails_err="";
            $email_count=0;
            foreach ($emails as $email) {
                $customer_id = Customer::instance()->is_register(trim($email));
                if ($customer_id) {
                    $customer = Customer::instance($customer_id);
                    $flag=$customer->get('flag');
                    if($flag!=3) {
                        $update = DB::update('accounts_customers')->set(array('flag' => 3))->where('id', '=', $customer_id)->execute();
                        if($update == 0){
                            $emails_err=$emails_err.$email.";";
                        } else if($update == 1) {
                            $email_count = $email_count+1;
                        }
                    }else{
                        $email_count = $email_count+1;
                    }
                }
            }
            if(strlen($emails_err)==0) {
                Message::set('Update flag success!'.$email_count.'条数据', 'success');
                $this->request->redirect('/admin/site/customer/list');
            } else {
                Message::set('Update flag failed!失败的Email:'.$emails_err, 'success');
                $this->request->redirect('/admin/site/customer/list');
            }
        }
    }

    //新开发批发客批量录入 by xuli 20160718
    function action_import_coustomers_flag(){
        if($_POST) {
            $emailArr = Arr::get($_POST, 'EmalARR', '');
            if (!$emailArr) {
                Message::set('Email cannot be empty!', 'error');
                $this->request->redirect('/admin/site/customer/list');
            }

            $emails = explode("\n", $emailArr);
            $email_count=0;
            $email_errcount=0;
            $email_erremail="";

            foreach ($emails as $email) {
                // 验证email格式
                if (!Validate::email($email))
                {
                    if(isset($email) && (!empty($email))) {
                        $email_errcount = $email_errcount + 1;
                        $email_erremail .= $email . ";";
                    }
                } else {
                    // 判断客户是否存在
                    $customer = ORM::factory('customer')
                        ->where('email', '=', $email)
                        ->find();
                    $customer->loaded() ? $customer_id = $customer->id : $customer_id = 0;
                    if (!$customer_id) {
                        //新开发批发客录入Choies，标记flag=4,等客户注册之后，自动匹配为flag=3
                        $sql = "insert into customers (`email`, `flag`)
                        values (" . "'" . $email . "'" . ",4)";
                        $bool = Database::instance('default')->query(DATABASE::INSERT, $sql, false);
                        if ($bool) {
                            $email_count = $email_count + 1;
                        } else {
                            $email_errcount = $email_errcount + 1;
                            $email_erremail .= $email . ";";
                        }
                    } else {
                        $email_errcount = $email_errcount + 1;
                        $email_erremail .= $email . ";";
                    }
                }
            }

            if($email_errcount==0){
                Message::set('新开发批发客导入成功!'.$email_count.'条数据', 'success');
                $this->request->redirect('/admin/site/customer/list');
            }else{
                Message::set('新开发批发客导入失败!成功导入'.$email_count.'条，导入失败'.$email_errcount.'条。失败的Email:'.$email_erremail, 'error');
                $this->request->redirect('/admin/site/customer/list');
            }
        }
    }


    public function action_add_cart()
    {
        $to_date=time();
        $from_date=time()-3600*24*15;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="productspecific.csv"');
        echo "sku,add_qty\n";
        //查找15天内下心愿单的信息
        $sql = 'select item_id,count(id) as con from carts_cartitem where created<'.$to_date.' and created>='.$from_date.' and is_cart = 1 group by item_id order by con desc limit 0,300';

        $result = DB::query(DATABASE::SELECT, $sql)->execute('slave')->as_array();
        foreach ($result as $key => $value) 
        {
            $sku = Product::instance($value['item_id'])->get('sku');
            echo '"'.$sku.'"'.',';
            echo '"'.$value['con'].'"'.',';
            echo PHP_EOL;
        }
    }


}
