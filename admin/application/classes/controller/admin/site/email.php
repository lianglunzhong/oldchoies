<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Email extends Controller_Admin_Site
{

    public function action_list()
    {
        $lang = $this->request->param('id');
        if($lang)
        {
            $mails = ORM::factory('mail')
                ->where('site_id', '=', $this->site_id)
                    ->where('lang', '=', $lang)
                ->order_by('id', 'desc')
                ->find_all();
        }
        else
        {
            $mails = ORM::factory('mail')
                ->where('site_id', '=', $this->site_id)
                ->where('lang', '=', '')
                ->order_by('id', 'desc')
                ->find_all();
        }

        $content = View::factory('admin/site/email_list')
                ->set('mails', $mails)
                ->set('lang', $lang)
                ->render();

        $this->request->response =
                View::factory('admin/template')
                ->set('content', $content)
                ->render();
    }

    public function action_add()
    {
        if ($_POST)
        {
            $mail = ORM::factory('mail')
                    ->where('type', '=', $_POST['type'])
                    ->where('site_id', '=', $this->site_id)
                    ->where('lang', '=', Arr::get($_POST, 'lang', ''))
                    ->find();
            if ($mail->loaded())
            {
                Message::set("Duplicate email type", 'error');
            }
            else
            {
                $new_mail = ORM::factory('mail');
                $new_mail->values(array(
                    'site_id' => $this->site_id,
                    'type' => Arr::get($_POST, 'type', ''),
                    'is_active' => Arr::get($_POST, 'is_active', 0),
                    'title' => Arr::get($_POST, 'title', ''),
                    'template' => Arr::get($_POST, 'template', ''),
                    'created_at' => time(),
                    'lang' => Arr::get($_POST, 'lang', '')
                ));

                if ($new_mail->check())
                {
                    $new_mail->save();
                    message::set('Add email successfully');
                    $this->request->redirect('/admin/site/email/list');
                }
                Message::set("Add email fail", 'error');
            }
        }

        $sql = 'select * from mails where site_id=0';
        $mail_templates = Database::instance('default')->query(Database::SELECT, $sql, 'Model_MAIL');
        $templates = array();
        foreach ($mail_templates as $mail_template)
            $templates[] = $mail_template->as_array();
        $content = View::factory('admin/site/email_add')
                ->set('templates', $templates)
                ->render();
        $this->request->response =
                View::factory('admin/template')
                ->set('content', $content)
                ->render();
    }

    public function action_delete($id)
    {
        if (ORM::factory('mail', $id)->delete())
        {
            message::set('delete email successfully');
        }
        else
        {
            message::set('delete email fail！', 'error');
        }

        $this->request->redirect('/admin/site/email/list');
    }

    public function action_toggle_active($id)
    {
        $mail = ORM::factory('mail', $id);
        $mail->loaded() or die('邮件模板不存在！');

        $mail->is_active = $mail->is_active ? 0 : 1;
        $mail->save();

        echo 'success';
    }

    public function action_duplicate()
    {
        $sql = 'select * from mails where site_id=0 order by id desc';
        $mails = Database::instance('default')->query(DATABASE::SELECT, $sql, 'Model_MAIL');
        foreach ($mails as $mail)
        {
            if (ORM::factory('mail')
                            ->where('type', '=', $mail->type)
                            ->where('site_id', '=', $this->site_id)
                            ->find()->loaded())
                continue;
            else
            {
                $new_mail = ORM::factory('mail');
                $new_mail->values(array(
                    'site_id' => $this->site_id,
                    'type' => $mail->type,
                    'is_active' => 1,
                    'title' => $mail->title,
                    'template' => $mail->template,
                    'created_at' => time(),
                ));

                if ($new_mail->check())
                {
                    $new_mail->save();
                }
            }
        }
        Message::set("Bulk copy successfully.");
        $this->request->redirect('/admin/site/email/list');
    }

    public function action_add_type()
    {
        if (isset($_POST['name']) && $_POST['name'] != null)
        {
            $type = ORM::factory('mail_type')
                    ->where('site_id', '=', $this->site_id)
                    ->and_where('name', '=', $_POST['name'])
                    ->find();
            if (!$type->loaded())
            {
                $new_type = ORM::factory('mail_type');
                $new_type->values(array(
                    'site_id' => $this->site_id,
                    'name' => Arr::get($_POST, 'name', ''),
                    'created_at' => time(),
                ));
                if ($new_type->check())
                {
                    $new_type->save() and die('{"result":"success","id":' . $new_type->id . ',"name":"' . $new_type->name . '"}');
                }
            }
        }
        die('{"result":"fail","message":"邮件类别已经存在或保存失败！"}');
    }

    public function action_template_edit($id)
    {
        $sql = 'select * from mails where id=' . $id;
        $mail = Database::instance('default')->query(DATABASE::SELECT, $sql, 'Model_MAIL')->current();
        if (!$mail->loaded())
        {
            message::set('邮件不存在或已被删除');
            $this->request->redirect('admin/site/email/template_list');
        }

        if ($_POST)
        {
            $sql = "update mails set is_active=" . Arr::get($_POST, 'is_active', 1) . ",title='" . Arr::get($_POST, 'title', '') . "',template='" . mysql_escape_string(Arr::get($_POST, 'template', '')) . "',updated_at='" . time() . "' where id=" . $id;
            Database::instance('default')->query(DATABASE::UPDATE, $sql, false);
            message::set('Add email template successfully');
            $this->request->redirect('/admin/site/email/template_list');
        }
        $content = View::factory('admin/site/email_template_edit')
                ->set('mail', $mail)
                ->render();
        $this->request->response =
                View::factory('admin/template')
                ->set('content', $content)
                ->render();
    }

    public function action_template_list()
    {
        $sql = 'select * from mails where site_id=0 order by id desc';
        $mails = Database::instance('default')->query(DATABASE::SELECT, $sql, 'Model_MAIL');
        $content = View::factory('admin/site/email_template_list')
                ->set('mails', $mails)
                ->render();

        $this->request->response =
                View::factory('admin/template')
                ->set('content', $content)
                ->render();
    }

    public function action_template_add()
    {
        if ($_POST)
        {
            if ($_POST['type'] == null)
            {
                Message::set('The mail type can\'t be null', 'error');
            }
            else
            {
                $_POST = Security::xss_clean($_POST);
                $sql = 'select count(*) as num from mails where site_id=0 and type=\'' . $_POST['type'] . '\'';
                $count = Database::instance('default')->query(DATABASE::SELECT, $sql, false)->current();
                if ($count['num'] == 0)
                {
                    $sql = "insert into mails (site_id,type,title,template,is_active,created_at,updated_at) values (0,'" . Arr::get($_POST, 'type', '') . "','" . Arr::get($_POST, 'title', '') . "','" . mysql_escape_string(Arr::get($_POST, 'template', '')) . "','" . Arr::get($_POST, 'is_active', 1) . "','" . time() . "','" . time() . "')";
                    $bool = Database::instance('default')->query(DATABASE::INSERT, $sql, false);
                    message::set('Add email template successfully');
                    $this->request->redirect('/admin/site/email/template_list');
                }
                else
                {
                    Message::set('Duplicate mail type', 'error');
                }
            }
        }

        $content = View::factory('admin/site/email_template_add')
                ->render();
        $this->request->response =
                View::factory('admin/template')
                ->set('content', $content)
                ->render();
    }

    public function action_template_delete($id)
    {
        $sql = 'delete from mails where id=' . $id;
        Database::instance('default')->query(DATABASE::DELETE, $sql, false);
        message::set('delete email template successfully');
        $this->request->redirect('/admin/site/email/template_list');
    }

    public function action_edit($id)
    {
        $mail = ORM::factory('mail')
                ->where('site_id', '=', $this->site_id)
                ->where('id', '=', $id)
                ->find();

        if (!$mail->loaded())
        {
            message::set('邮件不存在或已被删除');
            $this->request->redirect('admin/site/email/list');
        }

        if ($_POST)
        {
            $template = Arr::get($_POST, 'template', '');
            $template = str_replace(array('\"', "'"), array('"', "\'"), $template);
            $title = Arr::get($_POST, 'title', '');
            $title = str_replace("'", "\'", $title);
            $update_array = array(
                'is_active' => Arr::get($_POST, 'is_active', 0),
                'title' => $title,
                'template' => $template,
                'updated_at' => time(),
            );
            $mail->values($update_array);

            if ($mail->check())
            {
                $update_sql = ' site_id = ' . $this->site_id;
                foreach ($update_array as $key => $value) {
                    $update_sql .= ", " . $key . " = '" . $value . "'";
                }
                DB::query(Database::UPDATE, 'UPDATE mails SET ' . $update_sql . ' WHERE id = ' . $id)->execute();
                message::set('Edit email successfully');
            }

            $this->request->redirect('/admin/site/email/edit/' . $id);
        }

        $content = View::factory('admin/site/email_edit')
                ->set('mail', $mail)
                ->render();

        $this->request->response =
                View::factory('admin/template')
                ->set('content', $content)
                ->render();
    }

    public function action_send()
    {
        if ($_POST)
        {
            $rcpt = Arr::get($_POST, 'rcpt', '');
            $from = Arr::get($_POST, 'from', '');
            $subject = Arr::get($_POST, 'subject', '');
            $body = Arr::get($_POST, 'body', '');
//            if(strpos($rcpt, 'hotmail.com'))
            if (0)
            {
                if (Mail::SendSMTP($rcpt, $from, $subject, $body))
                {
                    message::set('邮件发送成功');
                }
                else
                {
                    message::set('邮件发送失败', 'error');
                }
            }
            else
            {
                if (Mail::Send($rcpt, $from, $subject, $body))
                {
                    message::set('邮件发送成功');
                }
                else
                {
                    message::set('邮件发送失败', 'error');
                }
            }

            $this->request->redirect('/admin/site/email/send');
        }

        $content = View::factory('admin/site/email_send')
                ->set('from', Site::instance()->get('email'))
                ->render();
        $this->request->response =
                View::factory('admin/template')
                ->set('content', $content)
                ->render();
    }

    public function action_logs()
    {
        $content = View::factory('admin/site/email_logs')->render();
        $this->request->response = View::factory('admin/template')
                ->set('content', $content)
                ->render();
    }

    public function action_logs_data()
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
                if ($item->field == 'send_date')
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
                    $_filter_sql[] = "`$item->field`" . " = '" . $item->data . "'";
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(id) AS num FROM `mail_logs` WHERE site_id = ' . $this->site_id . ' AND '
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

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM `mail_logs` WHERE site_id=' . $this->site_id . ' AND '
                        . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        $types = array(
            1 => 'unpaid', 2 => 'birth', 3 => 'vip', 4 => 'coupon', 5 => 'whishlist'
        );
        $tables = array(
            1 => 'order', 2 => 'customer', 3 => 'order_payments', 4 => 'coupon'
        );
        foreach ($result as $data)
        {
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                $types[$data['type']],
                date('Y-m-d H:i:s', $data['send_date']),
                $tables[$data['table']],
                $data['table_id'],
                $data['status'],
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_order_item_outstock()
    {
        if($_POST)
        {
            $data = array();
            $order_id = Arr::get($_POST, 'order_id', 0);
            $items = Arr::get($_POST, 'items', '');
            if($order_id AND $items)
            {
                $orderData = DB::select('ordernum', 'email', 'shipping_firstname', 'payment_status')->from('orders_order')->where('id', '=', $order_id)->execute('slave')->current();
                if($orderData['payment_status'] == 'success' OR $orderData['payment_status'] == 'verify_pass')
                {
                    $admin = User::instance(Session::instance()->get('user_id'))->get('name');
                    $itemsArr = explode(',', $items);
                    $updateItems = array();
                    foreach($itemsArr as $item_id)
                    {
                        $item_id = trim($item_id);
                        if($item_id)
                        {
                            $update = DB::update('orders_orderitem')->set(array('status' => 'cancel', 'erp_line_status' => '缺货-' . $admin))->where('id', '=', $item_id)->execute();
                            if($update)
                            {
                                $updateItems[] = DB::select('name', 'sku', 'price', 'attributes','quantity')->from('orders_orderitem')->where('id', '=', $item_id)->execute('slave')->current();
                            }
                        }
                    }
                    
                    if(!empty($updateItems))
                    {
                        $rcpt = $orderData['email'];
                        $rcpts = array($rcpt, 'service@choies.com');
                        $from = Site::instance()->get('email');
                        $subject = "Sorry dear, item you have ordered from Choies is not available now!";
                        $body = View::factory('/admin/site/order/item_outstock_mail')->set('orderData', $orderData)->set('updateItems', $updateItems);
                        $send = Mail::Send($rcpts, $from, $subject, $body);

                        $comment_skus='';

                        foreach ($updateItems as $k0 => $v0) {
                            $comment_skus.=$v0['sku'].';';
                        }
                        $order = Order::instance($order_id);
                        $order->add_history(array(
                            'order_status' => 'send baoque',
                            'message' => '报缺'.$comment_skus,
                        ));

                        $data['success'] = 1;
                        $data['message'] = 'Success!';
                    }
                    else
                    {
                        $data['success'] = 0;
                        $data['message'] = 'Failed!';
                    }
                }
                else
                {
                    $data['success'] = 0;
                    $data['message'] = 'This order payment status is not success!';
                }
            }
            else
            {
                $data['success'] = 0;
                $data['message'] = 'Failed!';
            }
            echo json_encode($data);
            exit;
        }
    }

}
