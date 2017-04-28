<?php

defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Site_Feedback extends Controller_Admin_Site
{

    public function action_price_match()
    {
        $total = DB::select()
            ->from('price_matches')
            ->where('site_id', '=', Site::instance()->get('id'))
            ->execute('slave')
            ->count();

        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => $total,
                'items_per_page' => 20,
                'view' => 'pagination/basic',
                'auto_hide' => TRUE,
            ));

        $pager = $pagination->render();

        $price_matches = DB::select()
            ->from('price_matches')
            ->where('site_id', '=', Site::instance()->get('id'))
            ->offset($pagination->offset)
            ->limit($pagination->items_per_page)
            ->order_by('id', 'DESC')
            ->execute('slave')
            ->as_array();

        $content = View::factory('admin/site/price_match')
            ->set('price_matches', $price_matches)
            ->set('pager', $pager)
            ->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_error_report()
    {
        $total = DB::select()
            ->from('error_reports')
            ->where('site_id', '=', Site::instance()->get('id'))
            ->execute('slave')
            ->count();

        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => $total,
                'items_per_page' => 20,
                'view' => 'pagination/basic',
                'auto_hide' => TRUE,
            ));

        $pager = $pagination->render();

        $error_reports = DB::select()
            ->from('error_reports')
            ->where('site_id', '=', Site::instance()->get('id'))
            ->offset($pagination->offset)
            ->limit($pagination->items_per_page)
            ->order_by('id', 'DESC')
            ->execute('slave')
            ->as_array();

        $content = View::factory('admin/site/error_report')
            ->set('error_reports', $error_reports)
            ->set('pager', $pager)
            ->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }

    public function action_list()
    {
        $content = View::factory('admin/site/feedback_list')
            ->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
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

        $filter_sql = "1";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if ($item->field == 'time')
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
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM feedbacks WHERE site_id=' . $this->site_id . ' AND ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM feedbacks WHERE site_id=' . $this->site_id . ' AND ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $review)
        {
            $response['rows'][$i]['id'] = $review['id'];
            $response['rows'][$i]['cell'] = array(
                '',
                $review['id'],
                $review['email'],
                $review['what_like'],
                $review['do_better'],
                $review['content'],
                date('Y-m-d', $review['time']),
                $review['sent']
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_mail()
    {
        if ($_POST)
        {
            $sendto = 'feedback@choies.com';
            $ids = Arr::get($_POST, 'ids', array());
            foreach ($ids as $id)
            {
                $feedback = DB::select()->from('feedbacks')->where('id', '=', $id)->execute('slave')->current();
                $rcpt = $sendto;
                $from = $feedback['email'];
                $subject = 'Choies Feedback';
                $body = 'What like:<br>' . $feedback['what_like'] . 'Do Better:<br>' . $feedback['do_better'] . 'Question:<br>' . $feedback['content'];
                $sent = Mail::Send($rcpt, $from, $subject, $body);
                if ($sent)
                {
                    DB::update('feedbacks')->set(array('sent' => 1))->where('id', '=', $id)->execute();
                }
            }
            Message::set('Send emails success');
        }
        $this->request->redirect('/admin/site/feedback/list');
    }

    public function action_delete()
    {
        if ($_POST)
        {
            $ids = Arr::get($_POST, 'ids', array());
            $sql = implode(',', $ids);
            $result = DB::query(Database::DELETE, 'DELETE FROM feedbacks WHERE id IN(' . $sql . ')')->execute();
            if ($result)
                Message::set('Delete feedbacks success');
            else
                Message::set('Delete feedbacks failed');
        }
        $id = $this->request->param('id');
        if ($id)
        {
            $result = DB::query(Database::DELETE, 'DELETE FROM feedbacks WHERE id =' . $id)->execute();
            if ($result)
                Message::set('Delete feedbacks success');
            else
                Message::set('Delete feedbacks failed');
        }
        $this->request->redirect('/admin/site/feedback/list');
    }

    public function action_giveaway()
    {
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);

            $file = 'giveaway';
            $_sql = array();
            if ($start)
            {
                $file .= "-from-$start";
                $_sql[] = ' created >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $_sql[] = ' created < ' . strtotime($end);
            }
            $sql = implode(' AND ', $_sql);
            $giveaways = DB::query(Database::SELECT, 'SELECT * FROM `giveaway` WHERE ' . $sql)
                ->execute('slave');

            header("Content-type:application/vnd.ms-excel; charset=UTF-8");
            header('Content-Disposition: attachment; filename=' . $file . '.csv');
            echo "\xEF\xBB\xBF" . "User,Ip,Comments,Sku,Created,Firstname,Urls\n";
            foreach ($giveaways as $giveaway)
            {
                echo '"' . Customer::instance($giveaway['user_id'])->get('email') . '",';
                echo '"' . long2ip($giveaway['ip']) . '",';
                echo '"' . $giveaway['comments'] . '",';
                echo '"' . $giveaway['sku'] . '",';
                echo '"' . date('Y-m-d', $giveaway['created']) . '",';
                echo '"' . $giveaway['firstname'] . '",';
                if(strpos($giveaway['urls'], 'a:') !== False)
                {
                    $urls = unserialize($giveaway['urls']);
                    if (!empty($urls))
                    {
                        foreach ($urls as $url)
                        {
                            echo '"' . $url . '",';
                        }
                    }
                }
                else
                {
                    echo '"' . $giveaway['urls'] . '",';
                }
                echo "\n";
            }
        }
    }
	
		//activi lottery 用户导表/kai
	public function action_lottery()
    {
        if ($_POST)
        {
            $start = Arr::get($_POST, 'start', NULL);
            $end = Arr::get($_POST, 'end', NULL);


            $file = 'lottery';
            $_sql = array();
            if ($start)
            {
                $file .= "-from-$start";
                $_sql[] = ' created >= ' . strtotime($start);
            }

            if ($end)
            {
                $file .= "-to-$end";
                $_sql[] = ' created < ' . strtotime($end);
            }
            $sql = implode(' AND ', $_sql);
            $lotterys = DB::query(Database::SELECT, 'SELECT username,customer_id,link,created FROM `lottery` WHERE ' . $sql)
                ->execute('slave')->as_array();
            header("Content-type:application/vnd.ms-excel; charset=UTF-8");
            header('Content-Disposition: attachment; filename=' . $file . '.csv');
            echo "\xEF\xBB\xBF" . "email,username,created,link\n";
            foreach ($lotterys as $lottery)
            {
				$links=unserialize($lottery['link']);
                echo '"' . Customer::instance($lottery['customer_id'])->get('email') . '",';
				echo '"' .$lottery['username'] . '",';
                echo '"' . date('Y-m-d', $lottery['created']) . '",';
				foreach($links as $k => $link){
					echo '"'.$link.'",';
				}
                echo "\n";
            }
        }
    }
	
	

}
