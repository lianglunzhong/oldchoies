<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Sharewin extends Controller_Webpage
{

        public function action_add()
        {
                $show_success = 0;
                if($_POST)
                {
                        $comment = Arr::get($_POST, 'comment', '');
                        if($comment)
                        {
                                $show_success = 1;
                        }
                }
                $freetrials = DB::select()->from('share_win_configs')->order_by('id', 'desc')->execute()->current();
                $products = explode(',', $freetrials['products']);
                $chances = explode(',', $freetrials['chances']);
                $timeto = strtotime($freetrials['endtime'] . ' - 1 month');
                $quantitys = array();
                foreach($products as $pid)
                {
                        $q = DB::select(DB::expr('COUNT(product_id) AS count'))->from('share_win')->where('product_id', '=', $pid)->execute()->get('count');
                        $quantitys[$pid] = $q;
                }
                
                if($freetrials['winners'])
                        $winners = explode("\n", $freetrials['winners']);
                else
                {
                        $f_winners = DB::select('winners')
                                ->from('share_win_configs')
                                ->where('winners', '<>', '')
                                ->order_by('id', 'desc')
                                ->execute()
                                ->get('winners');
                        $winners = explode("\n", $f_winners);
                }
                $width = array(34, 35, 36);
                $reports = DB::select()->from('share_win_reports')
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

        public function action_index()
        {
            $this->request->redirect(LANGPATH . '/freetrial/add');
                date_default_timezone_set("Asia/Shanghai"); 
                $week = date('w');
                if($week<=2){
                    $next_week=time();
                    $last_week=strtotime(date("Y-m-d",strtotime('-1 week this tuesday')));
                }else{
                    $next_week=strtotime(date("Y-m-d",strtotime('+1 week last tuesday')));
                    $last_week=strtotime(date("Y-m-d",strtotime('-1 week this tuesday')));
                }
                if($week==2&&date("H")>=16){
                    $next_week=strtotime(date("Y-m-d",strtotime('+1 week last tuesday')));
                    $last_week=strtotime(date("Y-m-d",time()));
                }
                $winners_list = DB::query(DATABASE::SELECT, 'SELECT * FROM `share_win_configs` WHERE site_id=' . $this->site_id . ' and id!=1 order by id desc ')->execute('slave')->count();
                $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => $winners_list,
                'items_per_page' => 8,
                'view' => '/pagination_saw'));
                $config_results = DB::query(DATABASE::SELECT, 'SELECT * FROM `share_win_configs` WHERE site_id=' . $this->site_id . ' and id!=1 order by id desc LIMIT ' . $pagination->items_per_page . ' OFFSET ' . $pagination->offset)->execute('slave');
                $products=DB::query(DATABASE::SELECT,"select `product_id`,count(*) as qty FROM share_win where `site_id`=1 and (`created`>=".$last_week." and `created`<".$next_week.")  GROUP BY `product_id` ORDER BY qty DESC limit 0,10")->execute();
                $allproducts=DB::query(DATABASE::SELECT,"select `product_id`,count(*) as qty FROM share_win where `site_id`=1 GROUP BY `product_id` ORDER BY qty DESC limit 0,10")->execute();
                $this->template->content = View::factory('/sharewin/share_and_win')
                    ->set('products', $products)
                    ->set('allproducts', $allproducts)
                    ->set('config_results',$config_results)
                    ->set('pagination', $pagination->render());
        }

        public function action_facebook_share()
        {
                $facebook = new facebook();
                $action = Arr::get($_POST, 'action', 0);
                $result = array();
                $customer_id = Customer::logged_in();
                if($action == 1)
                {
                        $product_id = Arr::get($_POST, 'goods_id', 0);
                        $has = DB::select('id')->from('share_win')
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
                        $product=Product::instance($product_id);
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
                                else
                                {
                                        $attachment = array(
                                            'message' => $message,
                                            'name' => $product->get('name'),
                                            'caption' => $product->get('name'),
                                            'link' => BASEURL . '/sharewin/index',
                                            'description' => 'Complete 2 tasks and then have a chance to get the free',
                                            'picture' => BASEURL . '/images/share_01.jpg',
                                        );
                                        $feed = $facebook->api('/me/feed/', 'post', $attachment);
                                        if(!empty($feed))
                                        {
                                                $insert = array(
                                                        'customer_id' => $customer_id,
                                                        'email' => Customer::instance($customer_id)->get('email'),
                                                        'product_id' => $product_id,
                                                        'fb_id'=>$uid,
                                                        'message' => $message,
                                                        'created' => time(),
                                                        'site_id' => $this->site_id
                                                );
                                                $r = DB::insert('share_win', array_keys($insert))->values($insert)->execute();
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
                        $report = DB::select()->from('share_win_reports')->where('id', '=', $id)->execute()->current();
                        $this->template->content = View::factory('/freebie/reports_detail')->set('report', $report);
                }
                else
                {
                        $count = DB::select(DB::expr('COUNT(*) AS count'))->from('share_win_reports')->where('site_id', '=', $this->site_id)->execute()->get('count');
                        $pagination = Pagination::factory(array(
                                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                                    'total_items' => $count,
                                    'items_per_page' => 9,
                                    'view' => '/pagination'));
                        $reports = DB::select()->from('share_win_reports')
                                        ->where('site_id', '=', $this->site_id)
                                        ->order_by('id', 'desc')
                                        ->limit($pagination->items_per_page)
                                        ->offset($pagination->offset)
                                        ->execute()->as_array();
                        $this->template->content = View::factory('/share_win/reports_list')
                                ->set('reports', $reports)
                                ->set('pagination', $pagination->render());
                }
        }
}

