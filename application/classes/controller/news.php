<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller
{

	public function action_list()
	{
		Cookie::set('views', 'true');

		$site_id = Site::instance()->get('id');
		$count = ORM::factory('new')
				->where('site_id', '=', $site_id)
				->count_all();

		$pagination = Pagination::factory(
				array(
					'current_page' => array( 'source' => 'query_string', 'key' => 'page' ),
					'total_items' => $count,
					'item_per_page' => 10,
					'view' => 'pagination/basic',
					'auto_hide' => 'FALSE',
				)
		);
		$page_view = $pagination->render();

		$data = ORM::factory('new')
				->where('site_id', '=', $site_id)
				->order_by('id', 'DESC')
				->find_all($pagination->items_per_page, $pagination->offset);

		$this->request->response = View::factory('/news_list')
				->set('data', $data)
				->set('page_view', $page_view)->render();
	}

	public function action_details()
	{
		$views = Cookie::get('views');
		$news_id = $this->request->param('id');
		$news = ORM::factory('new')->where('id', '=', $news_id)->find();
		if($views == true)
		{
			$news->times = $news->times + 1;
			$news->save();
			Cookie::delete('views');
		}
		$content = $news->content;

		$ipage = $_GET["ipage"] ? intval($_GET["ipage"]) : 1;

		$CP = new Page();

		$CP->pagestr = $content;

		$CP->cut_str();

		$page = $CP->pagearr[$ipage - 1];
		//  echo $CP->pagearr[$ipage-1]."<hr/>";

		$show = $CP->show_prv_next();
		//   echo $CP->show_prv_next();

		$this->request->response = View::factory('/news_details')
				->set('news', $news)
				->set('page', $page)
				->set('show', $show)
				->render();
	}
	
	public function action_sitemap()
    {
        $site = Site::instance();
        $site_id = $site->get('id');

        // FIXME get protocol from db.
        $protocol = 'https';
        $domain = $site->get('domain');
        
        $content_data['url_base'] = $protocol.'://'.$domain;
        $route_type = $site->get('route_type');
        
        //echo kohana::debug($route_type);die;
        switch( $route_type )
        {
	        case 2:
	            $content_data['product_link_template'] = $protocol.'://'.$domain.'/'.$site->get('product').'/{link}';
	            $content_data['catalog_link_template'] = $protocol.'://'.$domain.'/{link}';
	            break;
	        default:
	            $content_data['product_link_template'] = $protocol.'://'.$domain.'/'.$site->get('product').'/{id}';
	            $content_data['catalog_link_template'] = $protocol.'://'.$domain.'/'.$site->get('catalog').'/{id}';
	            break;
        }

        $content_data['catalogs'] = ORM::factory('catalog')->where('visibility','=',1)
			            ->and_where('site_id','=',$site_id)->order_by('id','asc')
			            ->find_all();
        $content_data['products'] = ORM::factory('product')->where('visibility','=',1)
			            ->and_where('site_id','=',$site_id)
			            ->find_all();

    	$filename = 'sitemap.xml';
        header("Content-type:text/xml");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        echo View::factory('/doc/sitemap',$content_data);
    }

    public function action_sendmail()
    {
        // unpaid mail send
        $key = 0;
        $webemail = Site::instance()->get('email');
        $dateto = time() - 1 * 86400;  //1天触发未支付邮件
        $datefrom = $dateto - 7 * 86400;
        $result = DB::query(DATABASE::SELECT, 'SELECT id,`email`,`shipping_firstname`,`ordernum`,`currency`,`amount`, `created`, `amount_shipping`,`shipping_firstname`,`shipping_lastname`,`shipping_address`,`shipping_city`,`shipping_state`,`shipping_zip`,`shipping_country`,`shipping_phone` FROM `orders_order`  
                            WHERE payment_status = "new" AND is_active = 1 AND created BETWEEN ' . $datefrom . ' AND ' . $dateto)
                ->execute();
        foreach ($result as $o)
        {
            if ($key > 20)
                break;
            $sendlog = DB::select('id')
                            ->from('core_mail_logs')
                            ->where('type', '=', 1)
                            ->where('table', '=', 1)
                            ->where('table_id', '=', $o['id'])
                            ->execute()->current();
            if (empty($sendlog))
            {
                $check = substr($o['email'], strpos($o['email'], '@') + 1);
                if (!empty($check) && !checkdnsrr($check))
                {
                    $insert = array(
                        'type' => 1,
                        'table' => 1,
                        'table_id' => $o['id'],
                        'email' => $o['email'],
                        'status' => 0,
                        'send_date' => time()
                    );
                    DB::insert('core_mail_logs', array_keys($insert))->values($insert)->execute();
                    $key++;
                    continue;
                }
                $mail_params = array();
                $mail_params['email'] = $o['email'];
                $mail_params['firstname'] = $o['shipping_firstname'];
                $mail_params['order_num'] = $o['ordernum'];
                $mail_params['created'] = date('Y-m-d H:i:s', $o['created']);
                $mail_params['ship_method'] = $o['amount_shipping'] ? 'Express Shipping ($' . Site::instance()->price($o['amount_shipping']) . ')' : 'Free Shipping ($0)';
                $mail_params['ship_address'] = $o['shipping_firstname'] . ' ' . $o['shipping_lastname'] . ';' . $o['shipping_phone'] . ';' . $o['shipping_address'] . ' ' . $o['shipping_city'] . ', ' . $o['shipping_state'] . ' ' . $o['shipping_country'] . ' ' . $o['shipping_zip'];
                $mail_params['amount'] = $o['currency'] . Site::instance()->price($o['amount']);
                if ($mail_params['email'] != "")
                {
                    $send = Mail::SendTemplateMail('UNPAID_MAIL', $mail_params['email'], $mail_params);
                    $insert = array(
                        'type' => 1,
                        'table' => 1,
                        'table_id' => $o['id'],
                        'send_date' => time()
                    );
                    if (!$send)
                    {
                        $insert['status'] = 0;
                    }
                    DB::insert('core_mail_logs', array_keys($insert))->values($insert)->execute();
                    $key++;
                }
            }
        }
        
        // birth mail send
        /*$key = 0;
        $tomorrow = date("n-j", strtotime("+1 day"));
        $lastweek = date("n-j", strtotime("+1 week"));
        if (strtotime($tomorrow) > strtotime('12-25'))
        {
            $sql = 'SELECT id, email, birthday FROM customers 
                        WHERE (birth BETWEEN "' . $tomorrow . '" AND "12-31" OR birth BETWEEN "1-1" AND "' . $lastweek . '") AND vip_level > 0';
        }
        else
        {
            $sql = 'SELECT id, email, birthday FROM customers 
                        WHERE birth BETWEEN "' . $tomorrow . '" AND "' . $lastweek . '" AND vip_level > 0 LIMIT 0, 10';
        }
        $births = DB::query(Database::SELECT, $sql)->execute('slave');
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
                    $check = substr($customer['email'], strpos($customer['email'], '@') + 1);
                    if (!empty($check) && !checkdnsrr($check))
                    {
                        $insert = array(
                            'type' => 2,
                            'table' => 2,
                            'table_id' => $customer['id'],
                            'email' => $customer['email'],
                            'status' => 0,
                            'send_date' => time()
                        );
                        DB::insert('mail_logs', array_keys($insert))->values($insert)->execute();
                        $key++;
                        continue;
                    }
                    Customer::instance($customer['id'])->add_point(array('amount' => $points, 'type' => 'birthday', 'status' => 'activated'));
                    $mail_params['points'] = $points;
                    $mail_params['email'] = $customer['email'];
                    $send = Mail::SendTemplateMail('VIP BIRTHDAY GIFT', $mail_params['email'], $mail_params);
                    $insert = array(
                        'type' => 2,
                        'table' => 2,
                        'table_id' => $customer['id'],
                        'send_date' => time()
                    );
                    if (!$send)
                    {
                        $insert['status'] = 0;
                    }
                    DB::insert('mail_logs', array_keys($insert))->values($insert)->execute();
                }
            }
        }*/

        // coupon mail send
        $key = 0;
        $from = time();
        $to = $from + 3600*24*3;
        $sql = "select C.id,M.email,C.code,M.firstname,C.expired    
                        from carts_coupons C , carts_customercoupons L , accounts_customers M 
                        where C.id=L.coupon_id and L.customer_id=M.id and C.expired>".$from." and C.expired<".$to." and C.code like \"SIGNUP15OFF%\" and C.used=0 and C.is_mailed=0
                        group by L.customer_id
                        limit 0, 10";
        $result = DB::query(DATABASE::SELECT, $sql)->execute('slave');
        foreach ($result as $value)
        {
            $check = substr($value['email'], strpos($value['email'], '@') + 1);
            if (!empty($check) && !checkdnsrr($check))
            {
                DB::query(DATABASE::UPDATE, "update carts_coupons set is_mailed=1 where id=" . $value['id'])->execute();
                $insert = array(
                    'type' => 4,
                    'table' => 4,
                    'table_id' => $value['id'],
                    'email' => $value['email'],
                    'status' => 0,
                    'send_date' => time()
                );
                DB::insert('core_mail_logs', array_keys($insert))->values($insert)->execute();
                continue;
            }
            $mail_params = array();
            $mail_params['firstname'] = isset($value['firstname']) ? $value['firstname'] : "";
            $mail_params['coupon_code'] = $value['code'];
            $day = ceil(($value['expired'] - time()) / (3600 * 24));
            $mail_params['day'] = $day;
            $mail = $value['email'];
            $send = Mail::SendTemplateMail('15 OFF CODE REMINDING', $mail, $mail_params);
            DB::query(DATABASE::UPDATE, "update carts_coupons set is_mailed=1 where id=" . $value['id'])->execute();
            $insert = array(
                'type' => 4,
                'table' => 4,
                'table_id' => $value['id'],
                'send_date' => time()
            );
            if (!$send)
            {
                $insert['status'] = 0;
            }
            DB::insert('core_mail_logs', array_keys($insert))->values($insert)->execute();
        }
        
        // wishlist mail send
/*        $key = 0;
        $date_from = time() - 7 * 86400;
        $result = DB::query(DATABASE::SELECT, 'SELECT DISTINCT w.customer_id FROM wishlists w LEFT JOIN products p ON w.product_id = p.id 
                        WHERE w.site_id = 1 AND w.is_mailed = 0 AND w.created <= ' . $date_from . ' AND p.visibility = 1 AND p.status = 1 AND p.stock <> 0 LIMIT 0, 5')->execute('slave')->as_array();
        foreach ($result as $val)
        {
            $wishlists = DB::query(DATABASE::SELECT, 'SELECT w.product_id, p.name, p.link, p.configs FROM wishlists w LEFT JOIN products p ON w.product_id = p.id 
                                WHERE w.customer_id = ' . $val['customer_id'] . ' AND w.is_mailed = 0 AND p.visibility = 1 AND p.status = 1 AND p.stock <> 0')
                            ->execute('slave')->as_array();
            $rcpt = Customer::instance($val['customer_id'])->get('email');
            if ($rcpt AND !empty($wishlists))
            {
                $check = substr($rcpt, strpos($rcpt, '@') + 1);
                if (!empty($check) && !checkdnsrr($check))
                {
                    $update = DB::update('wishlists')->set(array('is_mailed' => 1))->where('site_id', '=', 1)->where('customer_id', '=', $val['customer_id'])->execute();
                    $insert = array(
                        'type' => 5,
                        'table' => 2,
                        'table_id' => $val['customer_id'],
                        'email' => $rcpt,
                        'status' => 0,
                        'send_date' => time()
                    );
                    DB::insert('mail_logs', array_keys($insert))->values($insert)->execute();
                    continue;
                }
                $from = $webemail;
                $subject = "See What's In Your Wishlists?";
                $body = View::factory('/customer/mail_wishlist')->set('wishlists', $wishlists);
                $send = Mail::Send($rcpt, $from, $subject, $body);
                $update = DB::update('wishlists')->set(array('is_mailed' => 1))->where('site_id', '=', 1)->where('customer_id', '=', $val['customer_id'])->execute();
                $insert = array(
                    'type' => 5,
                    'table' => 2,
                    'table_id' => $val['customer_id'],
                    'send_date' => time()
                );
                if (!$send)
                {
                    $insert['status'] = 0;
                }
                DB::insert('mail_logs', array_keys($insert))->values($insert)->execute();
            }
        }*/

        echo date('Y-m-d H:i:s');

        echo '<script type="text/javascript">
                window.setInterval(pagerefresh, 10000);
                window.setInterval(logout, 11000);
                function pagerefresh() 
                { 
                    window.open("/news/sendmail"); 
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

    public function action_sendmail1()
    {
        $i=1;
        $time=time();
		$end_time=strtotime(''.$i.' month',time());
		$customers = DB::query(DATABASE::SELECT, 'SELECT id,email,vip_start,vip_end FROM accounts_customers WHERE vip_level>=0 and is_vip>0 and vip_end>='.$time.' and vip_end<'.$end_time.' ORDER BY id')->execute('slave')->as_array();
		if(count($customers)>0){
				foreach($customers as $k=>$v){
					if($i==1){
						$vip_ok=DB::query(Database::SELECT, 'SELECT id,ordernum,verify_date FROM `orders_order` where customer_id='.$v['id'].' and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 ORDER BY id desc limit 1')->execute('slave')->current();
						$last_time=strtotime(date('Y',$vip_ok['verify_date'])-1 .'-'.date('m-d H:i:s',$vip_ok['verify_date']));
						$result1 = DB::query(Database::SELECT, 'SELECT id,customer_id,email,sum(amount/rate) as sum_amount FROM `orders_order` where customer_id='.$v['id'].' and payment_status="verify_pass" and refund_status<>"refund" and is_active=1 and verify_date > '. $last_time .' and  verify_date <= '. $vip_ok['verify_date'] .'')->execute('slave')->current();
						$newvip_id=DB::query(Database::SELECT, 'SELECT id,firstname,lastname,email,is_vip,vip_start,vip_end FROM `accounts_customers` where id='.$v['id'].' ')->execute('slave')->current();
						$mail_params=array();
						//var_dump($newvip_id['email']);
						$mail_params['email']=$newvip_id['email'];
						//$mail_params['email']="674514904@qq.com";
						$mail_params['firstname'] = $newvip_id['firstname'].$newvip_id['lastname'];
						$mail_params['startdate'] = date('Y-m-d', $newvip_id['vip_start']);
						$mail_params['enddate'] = date('Y-m-d', $newvip_id['vip_end']);
						$mail_params['amount'] = $result1['sum_amount'];
						Mail::SendTemplateMail('ENDVIP', $mail_params['email'], $mail_params);
						DB::update('accounts_customers')->set(array('vip_level'=>-1))->where('id', '=', $v['id'])->execute();
					}
				}
			}
		exit;
    }

    public function action_cart()
    {
        echo '<script type="text/javascript">
                window.setInterval(pagerefresh, 3000);
                window.setInterval(logout, 3000);
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
    }

    public function action_shuiail()
    {
        $ordernum = '10896501340';
        $order_id = Order::get_from_ordernum($ordernum);
        if($order_id)
        {
            $order = Order::instance($order_id)->get();
            $trans_id = DB::select('trans_id')->from('orders_orderpayments')->where('order_id', '=', $order_id)->execute()->get('trans_id');
            $succeed = 525;
            $post_var = "order_num=" . $order['ordernum']
                . "&order_amount=" . $order['amount']
                . "&order_currency=" . $order['currency']
                . "&card_num=4263982640269299"
                . "&card_type=1"
                . "&card_cvv=111"
                . "&card_exp_month=12"
                . "&card_exp_year=15"
                . "&card_inssue=" . $order['cc_issue']
                . "&card_valid_month=12"
                . "&card_valid_year=15"
                . "&billing_firstname=" . $order['shipping_firstname']
                . "&billing_lastname=" . $order['shipping_lastname']
                . "&billing_address=" . $order['shipping_address']
                . "&billing_zip=" . $order['shipping_zip']
                . "&billing_city=" . $order['shipping_city']
                . "&billing_state=" . $order['shipping_state']
                . "&billing_country=" . $order['shipping_country']
                . "&billing_telephone=" . $order['shipping_phone']
                . "&billing_ip_address=" . long2ip($order['ip'])
                . "&billing_email=" . $order['email']
                . "&shipping_firstname=" . $order['shipping_firstname']
                . "&shipping_lastname=" . $order['shipping_lastname']
                . "&shipping_address=" . $order['shipping_address']
                . "&shipping_zip=" . $order['shipping_zip']
                . "&shipping_city=" . $order['shipping_city']
                . "&shipping_state=" . $order['shipping_state']
                . "&shipping_country=" . $order['shipping_country']
                . "&shipping_telephone=" . $order['shipping_phone']
                . '&trans_id=' . $trans_id
                . "&site_id=" . Site::instance()->get('cc_payment_id')
                . "&secure_code=" . Site::instance()->get('cc_secure_code')
                . "&status=" . $succeed;
            $result = Toolkit::curl_pay('http://local.shuiail.com/globebill', $post_var);
            // $result = unserialize(stripcslashes($result));
            print_r($result);
        }
        
    }

    public function action_test_es()
    {
        $c = curl_init('http://192.168.186.157:9200');
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $page = curl_exec($c);
        curl_close($c);
        echo $page;
        exit;
    }


    public function action_add_all_elastic()
    {
        if(LANGUAGE)
        {
            $lang_table = '_' . LANGUAGE;
        }
        else
        {
            $lang_table = '';
        }
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $page = Arr::get($_GET, 'page', 1);
        $limit = 1000;
        $products = DB::select('id', 'name', 'link', 'sku', 'visibility', 'status', 'description', 'keywords', 'price', 'display_date', 'hits', 'has_pick', 'filter_attributes', 'default_catalog', 'position', 'attributes')
            ->from('products' . $lang_table)
            ->where('visibility', '=', 1)
            ->where('status', '=', 1)
            ->order_by('id', 'desc')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->execute('slave')->as_array();
        if(!LANGUAGE)
        {
            $catalog_config = Kohana::config('filter.colors');
            foreach($products as $key => $p)
            {
                $attributes = unserialize($p['attributes']);
                if(!empty($attributes['Size']))
                {
                    $attr_size = array();
                    if(strpos($p['attributes'], 'EUR') !== FALSE)
                    {
                        foreach($attributes['Size'] as $attr)
                        {
                            $attribute = explode('/', $attr);
                            if(!empty($attribute[2]))
                            {
                                $attr_size[] = preg_replace('/[A-Z]+/i', '', $attribute[2]);
                            }
                        }
                    }
                    if(empty($attr_size))
                        $attr_size = $attributes['Size'];
                    $products[$key]['size_value'] = implode(' ', $attr_size);
                    $attr_size = str_replace(' ', '', $attr_size);
                    $attr_string = 'size' . implode(' size', $attr_size);
                    $products[$key]['attributes'] = $attr_string;
                    $p_color = '';
                    foreach($catalog_config as $color)
                    {
                        $color = strtolower($color);
                        if(strpos($p['filter_attributes'], $color) !== FALSE)
                        {
                            $p_color = $color;
                            break;
                        }
                    }
                }
                $products[$key]['color_value'] = $p_color;
                $products[$key]['price'] = round($products[$key]['price'], 2);
                $products[$key]['default_catalog'] .= ',';
                $products[$key]['pro_price'] = round($products[$key]['price'], 2);
                $products[$key]['has_promotion'] = 0;
                $cover_image = Product::instance($p['id'])->cover_image();
                $products[$key]['cover_image'] = serialize($cover_image);
                $products[$key]['has_promotion'] = 0;

                $languages = Kohana::config('sites.language');
                foreach($languages as $language)
                {
                    if($language == 'en' || !$language)
                        continue;
                    $products[$key]['name_' . $language] = $products[$key]['name'];
                    $products[$key]['description_' . $language] = $products[$key]['description'];
                    $products[$key]['keywords_' . $language] = $products[$key]['keywords'];
                }
            }
            if(!empty($products))
            {
                $responses = $elastic->create_index($products);

                echo date('Y-m-d H:i:s');
                print_r($responses);
            }
        }
        else
        {
            echo LANGUAGE . ":<br>\n";
            $product_l = array();
            foreach($products as $key => $p)
            {
                $product_l['name_' . LANGUAGE] = $products[$key]['name'];
                $product_l['description_' . LANGUAGE] = $products[$key]['description'];
                $product_l['keywords_' . LANGUAGE] = $products[$key]['keywords'];
                $res = $elastic->update(array('id' => $p['id']), $product_l);
                echo $p['id'] . '-' . $res . "<br>\n";
            }
        }

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
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

    public function action_add_catalog_elastic()
    {
        $page = Arr::get($_GET, 'page', 1);
        $limit = 3000;
        $start = ($page - 1) * $limit;
        $result = DB::query(Database::SELECT, 'SELECT C.product_id, C.catalog_id 
            FROM products_categoryproduct C LEFT JOIN products_product P ON C.product_id = P.id 
            RIGHT JOIN catalogs A ON C.catalog_id = A.id
            WHERE P.visibility = 1 AND P.status = 1 AND A.visibility = 1
            ORDER BY product_id LIMIT ' . $start . ', ' . $limit)->execute();
        $product_catalogs = array();
        foreach($result as $res)
        {
            if(isset($product_catalogs[$res['product_id']]))
            {
                $product_catalogs[$res['product_id']] .= ' ' . $res['catalog_id'];
            }
            else
            {
                $product_catalogs[$res['product_id']] = '' . $res['catalog_id'];
            }
        }
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        foreach($product_catalogs as $product_id => $catalogs)
        {
            $response = $elastic->update(array('id' => $product_id), array('default_catalog' => $catalogs));
            echo $product_id . '---' . $response . "<br>\n";
        }

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
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

    public function action_update_elastic()
    {
        $page = Arr::get($_GET, 'page', 1);
        $limit = 1000;
        $products = DB::select('id', 'price')
            ->from('products_product')
            ->where('visibility', '=', 1)
            ->where('status', '=', 1)
            ->order_by('id', 'desc')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->execute('slave')->as_array();
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $catalog_config = Kohana::config('filter.colors');
        foreach($products as $key => $p)
        {
            $p_color = '';
            foreach($catalog_config as $color)
            {
                $color = strtolower($color);
                if(strpos($p['filter_attributes'], $color) !== FALSE)
                {
                    $p_color = $color;
                    break;
                }
            }

            $response = $elastic->update(array('id' => $p['id']), array('color_value' => $p_color));
            echo $p['id'] . '---' . '"' . $p_color . '"' . '---' . $response . "<br>\n";
        }

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
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

    public function action_init_elastic_price()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $filter = array('term' => array('has_promotion' => 1));
        $promotion_elastic = $elastic->search('', array(), 5000, 0, $filter);
        if(!empty($promotion_elastic['hits']['hits']))
        {
            foreach($promotion_elastic['hits']['hits'] as $pro)
            {
                $res = $elastic->do_update($pro['_index'], $pro['_type'], $pro['_id'], array('has_promotion' => 0, 'price' => $pro['_source']['pro_price']));
                if(empty($res['error']))
                {
                    echo $pro['_source']['id'] . "<br>\n";
                }
            }
        }
        exit;
    }

    public function action_update_elastic_price()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $spromotions = DB::query(Database::SELECT, 'SELECT S.product_id, S.price, P.price AS p_price FROM spromotions S 
            LEFT JOIN products P ON S.product_id = P.id
            WHERE S.type <> 0 AND S.expired > ' . time() . ' AND P.visibility = 1 AND P.status = 1')
            ->execute('slave')->as_array();
        $responses = '';
        foreach($spromotions as $spromotion)
        {
            if($spromotion['price'] >= $spromotion['p_price'])
                continue;
            $update = array(
                'price' => round($spromotion['price'], 2),
                'has_promotion' => 1,
            );

            $response = $elastic->update(array('id' => $spromotion['product_id']), $update);
            $responses .= $spromotion['product_id'] . '-' . $response . "<br>\n";

            $cache_key = '1/product_price/' . $spromotion['product_id'] . '/0';
            Cache::instance('memcache')->set($cache_key, $spromotion['price'], 7200);
        }
        echo $responses;exit;
    }

    public function action_catalog_do_filter()
    {
        if($_REQUEST)
        {
            $catalog_id = Arr::get($_REQUEST, 'catalog_id', 0);
            $type = Arr::get($_REQUEST, 'type', '');
            $value = Arr::get($_REQUEST, 'value', '');
            $current_url = Arr::get($_REQUEST, 'current_url', '');
            /* START get url $_GET params */
            $url_params = parse_url($current_url);
            $gets = array();
            $need_page = Arr::get($_REQUEST, 'need_page', 0);
            if(!empty($url_params['query']))
            {
                if($need_page || $type == 'init')
                    $get_page = true;
                else
                    $get_page = false;
                $get_array = explode('&', $url_params['query']);
                foreach($get_array as $get_val)
                {
                    $get_val_array = explode('=', $get_val);
                    if(count($get_val_array) == 2)
                    {
                        if($get_val_array[0] == 'page' && !$get_page)
                            continue;
                        $gets[$get_val_array[0]] = $get_val_array[1];
                    }
                }
            }

            /* END get url $_GET params */

            $url_path = str_replace(LANGPATH, '', $url_params['path']);
                
            //init filters
            $filters = array(
                'term' => array(
                    'visibility' => 1,
                    'status' => 1,
                ),
                'match' => array(),
                'range' => array(),
            );
            $filter_param = array(
                'size' => 'all',
                'price' => 'all',
                'color' => '',
            );
            $url_array = explode('/', $url_path);
            if(isset($url_array[2]) && $url_array[2]) // size
            {
                if($url_array[2] != 'all')
                    $filters['match']['attributes'] = 'size' . $url_array[2];
                $filter_param['size'] = $url_array[2];
            }
            if(isset($url_array[3]) && $url_array[3]) // price
            {
                if($url_array[3] != 'all')
                    $filters['range']['price'] = explode('-', $url_array[3]);
                if(isset($filters['range']['price'][1]))
                {
                    $filters['range']['price'][1] -= 0.01;
                }
                $filter_param['price'] = $url_array[3];
            }
            if(isset($url_array[4]) && $url_array[4]) // color
            {
                $colors = explode('_', $url_array[4]);
                if(count($colors) == 2 && $colors[0] == 'color')
                {
                    $filters['term']['color_value'] = $colors[1];
                    $filter_param['color'] = 'color_' . $colors[1];
                }
            }

            /* START set new filters */
            if($type == '' AND $value == '')
            {
                $filters = array(
                    'term' => array(
                        'visibility' => 1,
                        'status' => 1,
                    ),
                );
                $filter_param = array();
            }
            elseif($type == 'size')
            {
                if(!$value)
                {
                    unset($filters['match']['attributes']);
                    $filter_param['size'] = 'all';
                }
                else
                {
                    $filters['match']['attributes'] = 'size'.$value;
                    $filter_param['size'] = $value;
                }
                
            }
            elseif($type == 'price')
            {
                if(!$value)
                {
                    unset($filters['range']['price']);
                    $filter_param['price'] = 'all';
                }
                else
                {
                    $filters['range']['price'] = explode('-', $value);
                    if(isset($filters['range']['price'][1]))
                    {
                        $filters['range']['price'][1] -= 0.01;
                    }
                    $filter_param['price'] = $value;
                }
            }
            elseif($type == 'color')
            {
                if(!$value)
                {
                    unset($filters['term']['color_value']);
                    unset($filter_param['color']);
                }
                else
                {
                    $filters['term']['color_value'] = $value;
                    $filter_param['color'] = 'color_' . $value;
                }
            }
            /* END set new filters */
            $is_mobile = Session::instance()->get('is_mobile');
            $size = Arr::get($_REQUEST, 'limit', 20);
            $show_size = 20;
            $product_ids = array();
            $product_infos = array();
            $type_array = array('size', 'color', 'price');
            if($catalog_id && $current_url)
            {
                // judge if init
                if(empty($filters['term']['color_value']) && empty($filters['match']) && empty($filters['range']) && empty($gets['pick']) && empty($gets['sort']))
                {
                    $all_products = $this->catalog_all_products($catalog_id);
                    $count_products = count($all_products);
                    
                    if(isset($_REQUEST['page']))
                    {
                        $page = (int) $_REQUEST['page'];
                        $gets['page'] = $page;
                    }
                    else
                        $page = Arr::get($gets, 'page', 1);
                    $from = $size * ($page - 1);
                    $show_to = $from + $show_size;
                    for($i = $from;$i < $from + $size;$i ++)
                    {
                        if(isset($all_products[$i]))
                        {
                            $product_ids[] = $all_products[$i];
                            if($i < $show_to)
                            {
                                $product_ins = Product::instance($all_products[$i], LANGUAGE);
                                $cover_image = Product::instance($all_products[$i])->cover_image();
                                $mark = '';
                                $product_infos[] = array(
                                    'product_href' => $product_ins->permalink(),
                                    'product_id' => $all_products[$i],
                                    'image_src' => $is_mobile ? Image::link($cover_image, 4) : Image::link($cover_image, 1),
                                    'image_alt' => 'Fashion '.$product_ins->get('name'),
                                    'product_title' => $product_ins->get('name'),
                                    'price_old' => Site::instance()->price($product_ins->get('price'), 'code_view'),
                                    'price_new' => Site::instance()->price($product_ins->price(), 'code_view'),
                                    'has_pick' => $product_ins->get('has_pick'),
                                    'mark' => $mark,
                                );
                            }
                        }
                    }

                }
                else
                {
                    $elastic_type = 'product';
                    $elastic_index = 'basic_new';
                    $elastic = Elastic::instance($elastic_type, $elastic_index);
                    $posterity = Catalog::instance($catalog_id)->posterity();
                    $catalog_ids = $catalog_id . ' ' . implode(' ', $posterity);
                    if(isset($_REQUEST['page']))
                    {
                        $page = (int) $_REQUEST['page'];
                        $gets['page'] = $page;
                    }
                    else
                        $page = Arr::get($gets, 'page', 1);
                    $from = $size * ($page - 1);
                    $order_by = array();
                    $pick = Arr::get($gets, 'pick', 0);
                    if($pick)
                        $order_by['has_pick'] = 'desc';
                    $sort = Arr::get($gets, 'sort', 0);
                    $sorts = Kohana::config('catalog.sorts');
                    if(isset($sorts[$sort]['field']) && isset($sorts[$sort]['queue']))
                        $order_by[$sorts[$sort]['field']] = $sorts[$sort]['queue'];
                    $search_res = $elastic->search($catalog_ids, array('default_catalog'), $size, $from, $filters, $order_by);
                    $count_products = isset($search_res['hits']['total']) ? $search_res['hits']['total'] : 0;
                    if(!empty($search_res['hits']['hits']))
                    {
                        $s_row = 0;
                        foreach ($search_res['hits']['hits'] as $item)
                        {
                            $product_ids[] = $item['_source']['id'];
                            if($s_row < $show_size)
                            {
                                $cover_image = unserialize($item['_source']['cover_image']);
                                $mark = '';
                                $product_infos[] = array(
                                    'product_href' => LANGPATH . '/product/' . $item['_source']['link'] . '_p' . $item['_source']['id'],
                                    'product_id' => $item['_source']['id'],
                                    'image_src' => $is_mobile ? Image::link($cover_image, 4) : Image::link($cover_image, 1),
                                    'image_alt' => 'Fashion '.$item['_source']['name'],
                                    'product_title' => $item['_source']['name'],
                                    'price_old' => Site::instance()->price($item['_source']['pro_price'], 'code_view'),
                                    'price_new' => Site::instance()->price($item['_source']['price'], 'code_view'),
                                    'has_pick' => $item['_source']['has_pick'],
                                    'mark' => $mark,
                                );
                            }
                            $s_row ++;
                        }
                    }
                }
                
                // set filter url
                $path_add = '';
                if(isset($filter_param['color']) && $filter_param['color'])
                {
                    $path_add = implode('/', $filter_param);
                }
                elseif(isset($filter_param['price']) && $filter_param['price'] != 'all')
                {
                    $path_add = implode('/', $filter_param);
                }
                elseif(isset($filter_param['size']) && $filter_param['size'] != 'all')
                {
                    $path_add = $filter_param['size'];
                }

                $path_array = explode('/', $url_path);
                $base_path = LANGPATH . '/' . $path_array[1];
                if($path_add)
                    $url_params['path'] = $base_path . '/' . $path_add;
                else
                    $url_params['path'] = $base_path;
                $put_url = $url_params['scheme'] . '://' . $url_params['host'] . $url_params['path'];
                if(!empty($gets))
                {
                    $get_array = array();
                    foreach($gets as $get_name => $get_val)
                    {
                        $get_array[] = $get_name . '=' . $get_val;
                    }
                    $get_url = '?' . implode('&', $get_array);
                    $put_url .= $get_url;
                }

                // get pagination
                if($count_products > $size)
                {
                    $_GET = $gets; // set $_GET for pagination
                    $pagination = Pagination::factory(array(
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items' => $count_products,
                        'items_per_page' => $size,
                        'view' => '/pagination_r'));
                    $pagination_fr = $pagination->render();
                }
                else
                {
                    $pagination_fr = '';
                }

                $filter_bar = array();
                if(isset($filter_param['size']) && $filter_param['size'] != 'all')
                {
                    if($filter_param['size'] == 'ONESIZE')
                        $filter_title = 'ONE SIZE';
                    else
                        $filter_title = $filter_param['size'];
                    $filter_bar['size'] = array(
                        'value' => $filter_param['size'],
                        'title' => $filter_title,
                    );
                }
                if(isset($filter_param['color']) && $filter_param['color'])
                {
                    $filter_value = str_replace('color_', '', $filter_param['color']);
                    $filter_bar['color'] = array(
                        'value' => $filter_value,
                        'title' => $filter_value,
                    );
                }
                $filter_price_config = Kohana::config('filter.price');
                if(isset($filter_param['price']) && $filter_param['price'] != 'all')
                {
                    if(in_array($filter_param['price'], $filter_price_config['values']))
                    {
                        $key = array_keys($filter_price_config['values'], $filter_param['price']);
                        $filter_title = $filter_price_config['keys'][$key[0]];
                    }
                    else
                    {
                        $filter_title = '$' . str_replace('-', ' - $', $filter_param['price']);
                    }
                    $filter_bar['price'] = array(
                        'value' => $filter_param['price'],
                        'title' => $filter_title,
                    );
                }

                $data = array(
                    'product_ids' => implode(',', $product_ids),
                    'product_infos' => $product_infos,
                    'filter_bar' => $filter_bar,
                    'put_url' => $put_url,
                    'pagination' => $pagination_fr,
                );

                echo json_encode($data);
                
            }
        }
        exit;
    }

}
