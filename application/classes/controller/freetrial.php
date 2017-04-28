<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Freetrial extends Controller_Webpage
{

    public function action_add()
    {
        $lang = LANGPATH;
        $redirect = '/activity/flash_sale';
        $do_redirect = $lang.$redirect;
        Request::instance()->redirect($do_redirect);

        $show_success = 0;
        if($_POST)
        {
            $comment = Arr::get($_POST, 'comment', '');
            if($comment)
            {
                $show_success = 1;
            }
        }
        $freetrials = DB::select()->from('freetrial_configs')->order_by('id', 'desc')->execute()->current();
        $products = explode(',', $freetrials['products']);
        $chances = explode(',', $freetrials['chances']);
        $timeto = strtotime($freetrials['endtime'] . ' - 1 month');
        $quantitys = array();
        foreach($products as $pid)
        {
            $q = DB::select(DB::expr('COUNT(product_id) AS count'))->from('freetrials')->where('product_id', '=', $pid)->execute()->get('count');
            $quantitys[$pid] = $q;
        }
        
        if($freetrials['winners'])
            $winners = explode("\n", $freetrials['winners']);
        else
        {
            $f_winners = DB::select('winners')
                ->from('freetrial_configs')
                ->where('winners', '<>', '')
                ->order_by('id', 'desc')
                ->execute()
                ->get('winners');
            $winners = explode("\n", $f_winners);
        }
        $width = array(34, 35, 36);
        $reports = DB::select()->from('freetrial_reports')
                // ->where('site_id', '=', $this->site_id)
                ->order_by('id', 'desc')
                ->limit(3)
                ->execute()->as_array();
        $this->template->content = View::factory('/freebie/freetrial')
            ->set('products', $products)
            ->set('chances', $chances)
            ->set('timeto', $timeto)
            ->set('show_success', $show_success)
            ->set('quantitys', $quantitys)
            ->set('winners', $winners)
            ->set('width', $width)
            ->set('reports', $reports);
    }

    public function action_facebook_share()
    {
        $result = DB::select('products')->from('freetrial_configs')->order_by('id', 'desc')->execute()->get('products');
        $products = explode(',', $result);
        $facebook = new facebook();
        $action = Arr::get($_POST, 'action', 0);
        $result = array();
        $customer_id = Customer::logged_in();
        if($action == 1)
        {
            $product_id = Arr::get($_POST, 'goods_id', 0);
            $has = DB::select('id')->from('freetrials')
                ->where('customer_id', '=', $customer_id)
                ->and_where('product_id', '=', $product_id)
                ->execute()->get('id');
            if($has)
                $result['status'] = 2;
            else
                $result['status'] = 1;
        }
        elseif($action == 2)
        {
            $product_id = Arr::get($_POST, 'goods_id', 0);
            $message = Arr::get($_POST, 'message', '');
            $uid = $facebook->getUser();
            if(!$uid OR !$customer_id)
            {
                $result['status'] = 1;
                $result['message'] = 'Login error,please try again.';
            }
            else
            {
                $fql = 'SELECT uid,page_id FROM page_fan WHERE page_id =277865785629162 and uid=' . $uid;
                $param = array(
                    'method' => 'fql.query',
                    'query' => $fql,
                    'callback' => ''
                );
                $fqlResult = $facebook->api($param);
                if (empty($fqlResult))
                {
                    $result['status'] = 2;
                    $result['message'] = 'You have to like first(Step 1).';
                }
                elseif(!in_array($product_id, $products))
                {
                    $result['status'] = 3;
                    $result['message'] = 'This product does not exist.';
                }
                else
                {
                    $attachment = array(
                        'message' => $message,
                        'name' => 'Choies Free Trial',
                        'caption' => "Choies Free Trial",
                        'link' => BASEURL.'/freetrial/add?fbshare',
                        'description' => 'Complete 2 tasks and then have a chance to get the free trial',
                        'picture' => BASEURL.'/cimages/freetrial.jpg',
                    );
                    $feed = $facebook->api('/me/feed/', 'post', $attachment);
                    if(!empty($feed))
                    {
                        $insert = array(
                            'customer_id' => $customer_id,
                            'email' => Customer::instance($customer_id)->get('email'),
                            'product_id' => $product_id,
                            'message' => $message,
                            'created' => time(),
                            // 'site_id' => $this->site_id
                        );
                        $r = DB::insert('freetrials', array_keys($insert))->values($insert)->execute();
                        $result['status'] = 4;
                    }
                    else
                    {
                        $result['status'] = 5;
                        $result['message'] = 'Oops,an error has been occured,please try again.';
                    }
                }
            }
            
        }
        else
        {
            
        }
        echo json_encode($result);
        exit;
    }

    public function action_reports()
    {
        $id = $this->request->param('id');
        if($id)
        {
            $report = DB::select()->from('freetrial_reports')->where('id', '=', $id)->execute()->current();
            $this->template->content = View::factory(
 '/freebie/freetrial_reports_detail')->set('report', $report);
        }
        else
        {
            $count = DB::select(DB::expr('COUNT(*) AS count'))->from('freetrial_reports')->where('site_id', '=', $this->site_id)->execute()->get('count');
            $pagination = Pagination::factory(array(
                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                    'total_items' => $count,
                    'items_per_page' => 9,
                    'view' => '/pagination'));
            $reports = DB::select()->from('freetrial_reports')
                    // ->where('site_id', '=', $this->site_id)
                    ->order_by('id', 'desc')
                    ->limit($pagination->items_per_page)
                    ->offset($pagination->offset)
                    ->execute()->as_array();
            $this->template->content = View::factory(
 '/freebie/freetrial_reports_list')
                ->set('reports', $reports)
                ->set('pagination', $pagination->render());
        }
    }
}

