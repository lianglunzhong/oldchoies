<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_activity extends Controller_Webpage
{
    public function action_flash_sale()
    {

        $flash_sale = DB::select('id', 'template', 'image_src', 'meta_title', 'meta_keywords', 'meta_description')->from('products_category')->where('name', '=', 'flash sale')->execute()->current();
//        $time = time();
//        $daily = DB::query(Database::SELECT, 'SELECT c.product_id, s.price, s.catalog, s.expired 
//            FROM products_categoryproduct c LEFT JOIN spromotions s ON c.product_id=s.product_id
//            WHERE c.catalog_id=' . $flash_sale['id'] . ' AND s.expired + 36000 - unix_timestamp() BETWEEN 0 AND 86400 ORDER BY c.position')
//                ->execute()->as_array();
        try {
            /*$weekly = DB::query(Database::SELECT, 'SELECT c.product_id, c.category_id,s.price, s.expired
            FROM products_categoryproduct c LEFT JOIN carts_spromotions s ON c.product_id=s.product_id
            WHERE c.category_id=' . $flash_sale['id'] . ' AND s.type = 6  AND  s.expired - unix_timestamp() BETWEEN 50400 AND 691200  ORDER BY c.position DESC, s.expired')
                ->execute()->as_array();*/
            $weekly = DB::query(Database::SELECT, 'SELECT s.product_id, s.price, s.expired FROM carts_spromotions as s where s.type = 6 And s.expired >unix_timestamp() ORDER BY s.expired')
                ->execute()->as_array();
        }catch (Exception $e){
            $weekly = array();
        }
        $products = array();
        foreach($weekly as $p)
        {
            $products[] = $p['product_id'];
        }
        $review_statistics = array();
        if(!empty($weekly))
        {
//            $result = DB::select('product_id', 'rating', 'quantity')->from('review_statistics')->where('product_id', 'IN', $products)->execute();
//            foreach($result as $r)
//            {
//                $review_statistics[$r['product_id']] = array('rating' => $r['rating'], 'quantity' => $r['quantity']);
//            }
        }
        if($this->language)
        {
            $banner = DB::select('image_src', 'image_link', 'image_alt','pimage_src')->from('products_category')->where('id', '=', $flash_sale['id'])->execute()->current();
                $result = DB::select()->from('banners_banner')
                    ->where('type', '=', 'side')
                    ->where('visibility', '=', 1)
                    ->where('lang', '=', $this->language)
                    ->order_by('position', 'ASC')
                    ->order_by('id', 'DESC')
                    ->execute()->as_array();
        }
        else
        {
            $banner = DB::select('image_src', 'image_link', 'image_alt','pimage_src')->from('products_category')->where('id', '=', $flash_sale['id'])->execute()->current();
                $result = DB::select()->from('banners_banner')
                    ->where('type', '=', 'side')
                    ->where('visibility', '=', 1)
                    ->where('lang', '=', '')
                    ->order_by('position', 'ASC')
                    ->order_by('id', 'DESC')
                    ->execute()->as_array();
        }



        $usds = array('usd2', 'usd-9', 'usd-13', 'usd-16', 'usd20', 'usd30');
        $usdsArr = array();
        foreach($usds as $u)
        {
            $catalog_id = DB::select('id')->from('products_category')->where('link', '=', $u)->execute()->get('id');
            if(!$catalog_id)
                continue;
            $products = DB::query(Database::SELECT, 'SELECT P.id FROM products_categoryproduct C LEFT JOIN products_product P ON C.product_id = P.id WHERE C.category_id = ' . $catalog_id . ' AND P.visibility = 1 ORDER BY P.status DESC, C.position DESC, P.position DESC LIMIT 0, 6')->execute()->as_array();

            $usdsArr[$u] = $products;
        }
/*        echo '<pre>';
        print_r($usdsArr);
        die;*/
        //title
        $lang=LANGUAGE;
        $seoinfo=array(
                "de"=>array("title"=>"Flash Sale"),
                "es"=>array("title"=>"Flash Sale"),
                "fr"=>array("title"=>"Vente Flash"),
                "ru"=>array("title"=>"FLASH SALE"),
                );
        if($lang!=""){
            $this->template->title = $seoinfo[$lang]['title'];
        }else{
            $this->template->title = "Flash Sale";
        }
        $this->template->content = View::factory('/activity'.LANGPATH.'/flash_sale')
//            ->set('daily', $daily)
            ->set('weekly', $weekly)
            ->set('flash_sale', $flash_sale)
            ->set('banner', $banner)
            ->set('index_banners', $result)
            ->set('usdsArr', $usdsArr)
            ->set('review_statistics', $review_statistics);
    }

    public function action_flash_sale11()
    {

        $flash_sale = DB::select('id', 'template', 'image_src', 'meta_title', 'meta_keywords', 'meta_description')->from('products_category')->where('name', '=', 'flash sale')->execute()->current();
        $time = time();
//        $daily = DB::query(Database::SELECT, 'SELECT c.product_id, s.price, s.catalog, s.expired 
//            FROM products_categoryproduct c LEFT JOIN spromotions s ON c.product_id=s.product_id
//            WHERE c.catalog_id=' . $flash_sale['id'] . ' AND s.expired + 36000 - unix_timestamp() BETWEEN 0 AND 86400 ORDER BY c.position')
//                ->execute()->as_array();
        $weekly = DB::query(Database::SELECT, 'SELECT c.product_id, s.price, s.category, s.expired 
            FROM products_categoryproduct c LEFT JOIN spromotions s ON c.product_id=s.product_id 
            WHERE c.category_id=' . $flash_sale['id'] . ' AND s.type = 6 AND s.expired - unix_timestamp() BETWEEN 50400 AND 691200 ORDER BY c.position DESC, s.expired')
                ->execute()->as_array();
        $products = array();
        foreach($weekly as $p)
        {
            $products[] = $p['product_id'];
        }
        if(!empty($weekly))
        {
            $result = DB::select('product_id', 'rating', 'quantity')->from('review_statistics')->where('product_id', 'IN', $products)->execute();
            $review_statistics = array();
            foreach($result as $r)
            {
                $review_statistics[$r['product_id']] = array('rating' => $r['rating'], 'quantity' => $r['quantity']);
            }
        }
        if($this->language)
        {
            $banner = DB::select('image_src', 'image_link', 'image_alt')->from('products_category')->where('id', '=', $flash_sale['id'])->execute()->current();
                $result = DB::select()->from('banners_banner')
                    ->where('type', '=', 'side')
                    ->where('visibility', '=', 1)
                    ->where('lang', '=', $this->language)
                    ->order_by('position', 'ASC')
                    ->order_by('id', 'DESC')
                    ->execute()->as_array();
        }
        else
        {
            $banner = DB::select('image_src', 'image_link', 'image_alt')->from('products_category')->where('id', '=', $flash_sale['id'])->execute()->current();
                $result = DB::select()->from('banners_banner')
                    ->where('type', '=', 'side')
                    ->where('visibility', '=', 1)
                    ->where('lang', '=', '')
                    ->order_by('position', 'ASC')
                    ->order_by('id', 'DESC')
                    ->execute()->as_array();
        }



        $usds = array('usd2', 'usd-9', 'usd-13', 'usd-16', 'usd20', 'usd30');
        $usdsArr = array();
        foreach($usds as $u)
        {
            $catalog_id = DB::select('id')->from('products_category')->where('link', '=', $u)->execute()->get('id');
            if(!$catalog_id)
                continue;
            $products = DB::query(Database::SELECT, 'SELECT P.id FROM products_categoryproduct C LEFT JOIN products P ON C.product_id = P.id WHERE C.category_id = ' . $catalog_id . ' AND P.visibility = 1 ORDER BY P.status DESC, C.position DESC, P.position DESC LIMIT 0, 6')->execute()->as_array();

            $usdsArr[$u] = $products;
        }
/*        echo '<pre>';
        print_r($usdsArr);
        die;*/

        $this->template->content = View::factory('/activity'.LANGPATH.'/flash_sale11')
//            ->set('daily', $daily)
            ->set('weekly', $weekly)
            ->set('flash_sale', $flash_sale)
            ->set('banner', $banner)
            ->set('index_banners', $result)
            ->set('usdsArr', $usdsArr)
            ->set('review_statistics', $review_statistics);
    }

    public function action_guotest()
    {

$this->template->content = View::factory('/activity'.LANGPATH.'/addfile');

    }

    public function action_so_many_ways_to_style_swimwear()
    {

$this->template->content = View::factory('/activity'.LANGPATH.'/swimsuit');

    }

    public function action_love_wins()
    {

        $this->template->content = View::factory('/activity'.LANGPATH.'/lovewins');
    }

    public function action_docsend()
    {

        $maxsize = 2 * 1024 * 1024;
        $rela = array('gif','jpg','png','bmp','doc','xls','txt','rar','ppt','pdf');
        if($_POST){
                $username = strip_tags($_POST['name']);
                $email = $_POST['email'];    
                $qt = $_POST['qt'];  
                if($qt == 2){
                    $toemail = 'zoe@choies.com';      
                }elseif($qt == 4){
                      $toemail = 'tracking@choies.com';
                }elseif($qt ==5){
                      $toemail = 'complaint@choies.com';
                }else{
                    $toemail = 'service@choies.com';
                }
                $order = strip_tags($_POST['order']);    
                $message = strip_tags($_POST['message']);      
                $filename = $_FILES['btn_file']['name'];
                $info = pathinfo($filename); 

            if(!in_array($info['extension'],$rela)){
              message::set(__('file_not'));
              $this->request->redirect(LANGPATH . '/contact-us');
                return false;
            }elseif($_FILES['btn_file']['size'] > $maxsize){
              message::set(__('file_not'));
              $this->request->redirect(LANGPATH . '/contact-us');
                return false;
            }elseif($_FILES['btn_file']['error'] != 0){
              message::set(__('file_not'));
              $this->request->redirect(LANGPATH . '/contact-us');
                return false;
            }else{

            $dir =  DOCROOT.'uploads/1/userfiles/';
            $round = rand(1,999999);
            $f = $round . $_FILES['btn_file']['name'];
            $fi  =md5($f).$_FILES['btn_file']['name'];
            $filename = $dir . $fi; 
            $domain = BASEURL; 
            $fileaname = $domain .'/uploads/1/userfiles/'.$fi;
            $fileaname = '<a href= "'. $fileaname .'" target="_blank">attachement</a>';   
            $copy = copy($_FILES['btn_file']['tmp_name'], $filename);
            unlink($_FILES['btn_file']['tmp_name']);
                               $email_params = array(
                                'username' => $username,
                                'email' => $email,
                                'order_num' => $order,
                                'message' => $message,
                                'fileaname' => $fileaname,
                                'toemail' => $toemail,
                                );
            Mail::Sendcontact($email_params['toemail'],$email_params);
            }
              message::set(__('file_ok'));
              $this->request->redirect(LANGPATH . '/contact-us');
        }else{
             $this->request->redirect(LANGPATH . '/contact-us');
        }
    }


    public function action_party_wear()
    {
        $products = array();
        $products[] = array(
            'CABE3009',
            'CABE1002',
            'CABE2003',
            'CABE2008',
            'CABE2006',
            'CABE2011'
        );
        $products[] = array(
            'CDXF1076',
            'ABXF0175',
            'ASXF0825',
            'CB1357472792',
            'MUWC0046',
            'CDWC2361',
            'CB1357175194',
            'ABSM0007',
            'CB1357371392',
            'ASZY0300',
        );
        $products[] = array(
            'CTDL3376',
            'CKDL3781',
            'AGZY1099',
            'JNSM0017',
            'ABXF0175',
            'CDSM0058',
            'JNSM0040',
            'ASMX1907',
            'CJXF0352',
            'CKSM0004',
            'AGZY1099',
            'ABMX0258',
            'CDXZ0129',
            'ASMX1908',
        );
        $products[] = array(
            'CDXF0128',
            'AGZY0889',
            'ABXF0175',
            'ASZY0300',
            'ABMX0258',
            'CDWC2288',
            'AGZY0889',
            'ABMX0258',
            'ASMX1907',
        );
        $products[] = array(
            'CDSM0025',
            'ABMX0258',
            'ASZY0301',
            'CB1357174794',
            'CDZY2197',
            'CDZY1366',
            'ABXF0175',
            'CB1357174794',
            'DB1357406591',
            'ASMX1908',
            'CDWC2456',
            'AGZY0889',
            'ABZY0695',
            'ASZY1668',
            'CDZY2126',
            'CDZY0781',
            'ASMX1893',
            'ABSM0001',
            'ASMX1907',
            'CDWC2275',
        );
        $products[] = array(
            'AHXF0397',
            'CTZY0533',
            'CLWC3058',
            'ABSM0018',
            'ASXF0823',
            'AHXF0396',
            'CDXF0964',
            'CB1357175094',
            'ASZY0883',
            'ATZY1491',
            'AGZY0889',
            'ABMX0258',
            'AHXF0397',
            'CDZY1722',
            'ATZY1491',
            'AGZY1102',
            'JNSM0088',
            'ABXF0174',
            'DB1357406591',
            'ASZY0496',
            'AHXF0396',
            'CTZY1789',
            'CHWC2948',
            'ATXF0690',
            'ASMX1960',
            'AGZY1102',
            'ABZY0695',
        );
        foreach ($products as $key1 => $product)
        {
            foreach ($product as $key2 => $sku)
            {
                $pid = Product::get_productId_by_sku($sku);
                if ($pid)
                    $products[$key1][$key2] = $pid;
                else
                    $products[$key1][$key2] = 0;
            }
        }
//        print_r($products);exit;
        $this->template->content = View::factory('/activity'.LANGPATH.'/party_wear')->set('products', $products);
    }

    public function action_update_questionnaire()
    {
        $customer_id = Customer::logged_in();
        if ($customer_id)
        {
            $has_submit = DB::query(Database::SELECT, 'SELECT DISTINCT id FROM giveaway_questions WHERE created > ' . strtotime('2014-3-2') . ' AND user_id=' . $customer_id . ' ORDER BY created DESC')->execute()->get('id');
            if ($has_submit)
            {
                $this->request->redirect(LANGPATH . '/activity/update_success');
            }
        }
        if ($_POST)
        {
            if (!$customer_id)
            {
                Message::set(__('need_log_in'), 'notice');
                $this->request->redirect(URL::current(TRUE) . '#step1');
            }

            $data = array();
            $data['q1'] = $_POST['q1'];
            $data['q2'] = $_POST['q2'];
            $q3 = Arr::get($_POST, 'q3', '');
            if (!$q3)
                $q3 = Arr::get($_POST, 'q3-1', '');
            if (!$q3)
            {
                Message::set(__('post_data_failed'), 'error');
                $this->request->redirect(URL::current(TRUE) . '#step1');
            }
            $data['q3'] = $q3;
            $data['q4'] = Arr::get($_POST, 'q4', '');
            ;
            $q5_1 = Arr::get($_POST, 'q5_1', '');
            $q5_2 = Arr::get($_POST, 'q5_2', '');
            $q5_3 = Arr::get($_POST, 'q5_3', '');
            $q5_4 = Arr::get($_POST, 'q5_4', '');
            $q5_5 = Arr::get($_POST, 'q5_5', '');
            $data['q5'] = $q5_1 . ',' . $q5_2 . ',' . $q5_3 . ',' . $q5_4 . ',' . $q5_5;
            $q6_1 = Arr::get($_POST, 'q6_1', '');
            $q6_2 = Arr::get($_POST, 'q6_2', '');
            $q6_3 = Arr::get($_POST, 'q6_3', '');
            $data['q6'] = $q6_1 . ',' . $q6_2 . ',' . $q6_3;
            $q7 = Arr::get($_POST, 'q7', array());
            $q7_1 = Arr::get($_POST, 'q7-1', '');
            $q7[] = $q7_1;
            if (empty($q7))
            {
                Message::set(__('post_data_failed'), 'error');
                $this->request->redirect(URL::current(TRUE) . '#step1');
            }
            $data['q7'] = '';
            $data['q7'] = implode(',', $q7);
            $data['q8'] = $_POST['q8'];
            $q9 = Arr::get($_POST, 'q9', array());
            $q9_1 = Arr::get($_POST, 'q9-1', '');
            $q9[] = $q9_1;
            if (empty($q9))
            {
                Message::set(__('post_data_failed'), 'error');
                $this->request->redirect(URL::current(TRUE) . '#step1');
            }
            $data['q9'] = '';
            $data['q9'] = implode(',', $q9);
            $data['q10'] = $_POST['q10'];
            $data['user_id'] = $customer_id;
            $data['created'] = time();
            $data['ip'] = ip2long(Request::$client_ip);
            $result = DB::insert('giveaway_questions', array_keys($data))->values($data)->execute();
            if ($result)
            {
                $insert = array('customer_id' => $customer_id, 'coupon_id' => 66988);
                DB::insert('carts_customercoupons', array_keys($insert))->values($insert)->execute();
                $rcpt = $email;
                $from = Site::instance()->get('email');
                $subject = 'Choies Gift Code for Your Questionnaire!';
                $body = '
<div>
Dear Choieser,<br/>
Thanks so much for submitting Choies Website Update Survey.<br/>
Here is the 20% OFF gift code for you: <span  style="color:red;">WERXDG0034ER</span>.<br/>
This code can be used to shop sitewide at Choies.com.<br/>
And please use this code before the end of the coming April.<br/>
Thanks again and please take care!<br/>
<br/>
Best Regards,<br/>
Choies Team<br/>
</div>
                                        ';
                Mail::Send($rcpt, $from, $subject, $body);
                $this->request->redirect(LANGPATH . '/activity/update_success');
            }
            else
            {
                Message::set(__('post_data_error'), 'error');
                $this->request->redirect(URL::current(TRUE) . '#step1');
            }
        }
        $this->template->title = '2014 Choies website update survey';
        $this->template->keywords = 'Choies site update survey, Look, Outfit, Choies Coats, Jackets, Shoes, Bags';
        $this->template->description = "Choies is a latest high street fashion shopping website offering limited-time sale events with quality products in women's and men's fashion, jewelry and accessories, beauty products. Choies offers discounts of 50 to 60% off retail prices. Choies is free to join and registration takes only seconds.";
        $this->template->content = View::factory('/activity'.LANGPATH.'/update_questionnaire');
    }

    public function action_update_success()
    {
        $this->template->content = View::factory('/activity'.LANGPATH.'/update_success');
    }
    
    public function action_pastel_hues()
    {
        $this->template->content = View::factory('/activity'.LANGPATH.'/pastel_hues');
    }
    
    public function action_catalog()
    {
        $link = $this->request->param('id');
        $catalog_id = DB::select('id')->from('products_category')->where('link', '=', $link)->execute()->get('id');
        if(!$catalog_id)
            $this->request->redirect(LANGPATH . '/404');
        $this->request->redirect(LANGPATH . '/' . $link . '-c-' . $catalog_id);
        $cache_key = 'site_activity_catalog_' . $catalog_id . $this->language;
        $cache_content = Cache::instance('memcache')->get($cache_key);
        if (strlen($cache_content) > 100 AND !isset($_GET['cache']))
        {
            echo $cache_content;
            exit;
        }
        else
        {
            $catalog = Catalog::instance($catalog_id, LANGUAGE);
            $count_products = $catalog->count_products();
            $pagination = Pagination::factory(array(
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items' => $count_products,
                        'items_per_page' => 99,
                        'view' => '/pagination_r'));
            $products = $catalog->products($pagination->offset, $pagination->items_per_page);
            $this->template->content = View::factory('/activity'.LANGPATH.'/catalog')->set('products', $products)->set('catalog', $catalog)->set('pagination', $pagination);
            Cache::instance('memcache')->set($cache_key, $this->template, 3600);
        }
    }
    
    public function action_marketing_survey()
    {
        $this->template->title = "2014 Choies website marketing strategy research survey";
        $this->template->keywords = "Choies site marketing research survey, free shipping, deal, coupon, Look, Outfit, Choies Coats, Jackets, Shoes, Bags, Fashion, High Street";
        $this->template->description = "Choies is a latest high street fashion shopping website offering limited-time sale events with quality products in women's and men's fashion, clothing, jewelry and accessories, beauty products. Choies offers discounts of 50 to 60% off retail prices. Choies is free to join and registration takes only seconds.";
        $customer_id = Customer::logged_in();
        $this->template->content = View::factory('/activity'.LANGPATH.'/marketing_survey');
    }
    public function action_marketing_survey_questions()
    {
        $this->template->title = "2014 Choies website marketing strategy research survey";
        $this->template->keywords = "Choies site marketing research survey, free shipping, deal, coupon, Look, Outfit, Choies Coats, Jackets, Shoes, Bags, Fashion, High Street";
        $this->template->description = "Choies is a latest high street fashion shopping website offering limited-time sale events with quality products in women's and men's fashion, clothing, jewelry and accessories, beauty products. Choies offers discounts of 50 to 60% off retail prices. Choies is free to join and registration takes only seconds.";
        $customer_id = Customer::logged_in();
        if ($customer_id)
        {
            $has_submit = DB::query(Database::SELECT, 'SELECT DISTINCT id FROM giveaway_questions WHERE created > ' . strtotime('2014-7-8') . ' AND user_id=' . $customer_id . ' ORDER BY created DESC')->execute()->get('id');
            if ($has_submit)
            {
                $this->request->redirect(LANGPATH . '/activity/ms_success2');
            }else{
                $this->request->redirect(LANGPATH . '/activity/ms_success3');
            }
            if ($_POST)
            {
            $data = array();
            foreach ($_POST as $key => $val)
            {
                if (is_array($val)&&$key!="other")
                {
                    $data[$key] = implode(',', $val);
                }elseif($key!="other"){
                    $data[$key] = $val;
                }
            }
            foreach ($_POST['other'] as $key => $val)
            {
                if ($val&&$val!="( Maximum 50 characters )")
                {
                    $data[$key] .= ',other:' . $val;
                }
            }
            $data['user_id'] = $customer_id;
            $data['created'] = time();
            $data['ip'] = ip2long(Request::$client_ip);
            $result = DB::insert('giveaway_questions', array_keys($data))->values($data)->execute();
            $rcpt = Customer::instance($customer_id)->get('email');
            $from = Site::instance()->get('email');
            $subject = '15% Off Gift Code from Choies.com!';
            $body = '
<div>
Dear Choieser,<br/>
Thanks so much for submitting Choies Marketing Strategies Survey!<br/>
Here is the 15% OFF gift code for you: <span style="color:red;">CHOIESMSS0035ER</span>.<br/>
This code can only be applied to products with no discount.<br/>
And please use this code before August 8th.<br/>
Thanks again and please take care!<br/>
<br/>
Best Regards,<br/>
Choies Team<br/>
</div>
                                        ';
            Mail::Send($rcpt, $from, $subject, $body);
            if ($result)
            {
                    $this->request->redirect(LANGPATH . '/activity/ms_success1');
            }
            else
            {
                Message::set(__('post_data_error'), 'error');
                $this->request->redirect(URL::current(TRUE));
            }
        }else{
            $this->template->content = View::factory('/activity'.LANGPATH.'/marketing_survey_questions');
        }
        }else{
            $this->request->redirect('activity/marketing_survey');
        }
    }
    public function action_ms_success1()
    {
        $this->template->title = "2014 Choies website marketing strategy research survey";
        $this->template->keywords = "Choies site marketing research survey, free shipping, deal, coupon, Look, Outfit, Choies Coats, Jackets, Shoes, Bags, Fashion, High Street";
        $this->template->description = "Choies is a latest high street fashion shopping website offering limited-time sale events with quality products in women's and men's fashion, clothing, jewelry and accessories, beauty products. Choies offers discounts of 50 to 60% off retail prices. Choies is free to join and registration takes only seconds.";
        $customer_id = Customer::logged_in();
        if ($customer_id)
        {
            $has_submit = DB::query(Database::SELECT, 'SELECT DISTINCT id FROM giveaway_questions WHERE created > ' . strtotime('2014-7-8') . ' AND user_id=' . $customer_id . ' ORDER BY created DESC')->execute()->get('id');
            if ($has_submit)
            {
                $this->template->content = View::factory('/activity'.LANGPATH.'/ms_success1');
            }else{
                $this->request->redirect('activity/marketing_survey');
            }
        }else{
                $this->request->redirect('activity/marketing_survey');
        }     
    }
    public function action_ms_success2()
    {
        $this->template->title = "2014 Choies website marketing strategy research survey";
        $this->template->keywords = "Choies site marketing research survey, free shipping, deal, coupon, Look, Outfit, Choies Coats, Jackets, Shoes, Bags, Fashion, High Street";
        $this->template->description = "Choies is a latest high street fashion shopping website offering limited-time sale events with quality products in women's and men's fashion, clothing, jewelry and accessories, beauty products. Choies offers discounts of 50 to 60% off retail prices. Choies is free to join and registration takes only seconds.";
        $customer_id = Customer::logged_in();
        if ($customer_id)
        {
            $has_submit = DB::query(Database::SELECT, 'SELECT DISTINCT id FROM giveaway_questions WHERE created > ' . strtotime('2014-7-8') . ' AND user_id=' . $customer_id . ' ORDER BY created DESC')->execute()->get('id');
            if ($has_submit)
            {
                $this->template->content = View::factory('/activity'.LANGPATH.'/ms_success2');
            }else{
                $this->request->redirect('activity/marketing_survey');
            }
        }else{
                $this->request->redirect('activity/marketing_survey');
        } 
    }
    public function action_ms_success3(){
        $this->template->content = View::factory('/activity'.LANGPATH.'/ms_success3');
    }
    public function action_only_florals(){
        $this->template->content = View::factory('/activity'.LANGPATH.'/only_florals');
    }
    public function action_classic_white_shirt(){
        $this->template->content = View::factory('/activity'.LANGPATH.'/classic_white_shirt');
    }
    public function action_marketing_survey_result(){
        $this->template->content = View::factory('/activity'.LANGPATH.'/marketing_survey_result');
    }

    public function action_stripes_collection()
    {
        $this->template->content = View::factory('/activity'.LANGPATH.'/stripes_collection');
    }

    public function action_kimono_style_vote()
    {
        $date = strtotime('2014-07-01');
        $user_id = Customer::logged_in();
        $has = DB::select('sku')->from('giveaway')->where('user_id', '=', $user_id)->where('created', '>', $date)->execute()->get('sku');
        $sum = 1;
        $percents = array();
        if($_POST)
        {
            if(!$user_id)
            {
                Message::set('Please Sign In First', 'notice');
            }
            elseif($has)
            {
                Message::set('You have already submitted before!', 'notice');
            }
            else
            {
                $vote_style = Arr::get($_POST, 'vote_style', array());
                $sku = isset($vote_style[0]) ? $vote_style[0] : '';
                if(!$sku)
                {
                    Message::set('You must vote one style you like most', 'error');
                    $this->request->redirect('/activity/kimono_style_vote#step2');
                }
                $urls = Arr::get($_POST, 'urls', array());
                $data = array(
                    'user_id' => $user_id,
                    'created' => time(),
                    'ip' => ip2long(Request::$client_ip),
                    'sku' => $sku,
                    'comments' => implode(',', $urls)
                );
                $insert = DB::insert('giveaway', array_keys($data))->values($data)->execute();
                if($insert)
                    Message::set('You have successfully submitted', 'success');
                $this->request->redirect('/activity/kimono_style_vote#go2step2');
            }
        }
        if($has)
        {
            $percents = array(
                1 => 0,2 => 0,3 => 0,4 => 0,5 => 0,6 => 0,7 => 0,8 => 0,
            );
            $result = DB::select('sku')->from('giveaway')->where('created', '>', $date)->execute();
            $sum = 0;
            foreach($result as $r)
            {
                if(isset($percents[$r['sku']]))
                    $percents[$r['sku']] ++;
                $sum ++;
            }
        }
        $this->template->title = 'Enter Choies Kimono Event Win $100';
        $this->template->keywords = 'Choies Kimonos, kimono jacket, Trend, Look, Outfit, Choies Coats, Jackets, Shoes, Skirts, Bags';
        $this->template->description = "Hottest trend 2014 summer, kimono style. Enter Choies Vote & Share Event, Win $100. Plus Buy One Kimono, Get the Second, Half Price. Only One Week! Hurry Up";
        $this->template->content = View::factory('/activity'.LANGPATH.'/kimono')
            ->set('user_id', $user_id)
            ->set('has', $has)
            ->set('sum', $sum)
            ->set('percents', $percents);
    }

    public function action_kimonos_collection()
    {
        $this->template->title = "2014 summer kimono style";
        $this->template->keywords = "Choies Kimonos, kimono jacket, Trend, Look, Outfit, Choies Coats, Jackets, Shoes, Skirts, Bags";
        $this->template->description = "Choies is a latest high street fashion shopping website offering limited-time sale events with quality products in women's and men's fashion, jewelry and accessories, beauty products. Choies offers discounts of 50 to 60% off retail prices. Choies is free to join and registration takes only seconds.";
        $this->template->content = View::factory('/activity'.LANGPATH.'/kimonos_collection');
    }

    public function action_skirt_looks()
    {
        if(LANGUAGE === 'de'){
            $this->template->title = "Röcke Looks | Fashion Röcke für Herbst | CHOiES";
            $this->template->description = "Entdecken Sie die neuesten Röcke Looks bei CHOiES. Wir bieten eine Reihe von qualitativ hochwertigen Damenröcken, einschließlich Maxi, Midi, Mini, Bleistift, Skater, Kariertr, Plissierte, A-Linie Röcke und mehr.";
        }elseif(LANGUAGE === 'es'){
            $this->template->title = "Las faldas de Moda | Faldas de moda para el otoño | CHOIES";
            $this->template->description = "Buscar las faldas de la ultima moda en CHOIES. Ofrecemos una variedad de faldas de mujeres incluyendo  maxi, midi, mini, tubo, skater, de cuadros, plisada, Forma de A y más.";
        }elseif(LANGUAGE === 'fr'){
            $this->template->title = "Looks de Jupe | Looks de Jupe D'Automne Fashion | CHOiES";
            $this->template->description = "Découvrez dernière Looks de Jupe en CHOiES. Nous offrons une gamme de jupes de femmes de haute qualité, y compris maxi, mi-longue, mini, fourreau, Patineuse, Carreaux écossais, plissé, jupes a-line et plus.";            
        }elseif(LANGUAGE === 'ru'){
            $this->template->title = "Парад Юбок | Осенняя Мода Парада Юбок | CHOiES";
            $this->template->description = "Найти для себя самую последнюю стиль юбки на CHOiES.Мы предлагаем высококачественные женские юбки в том числе макси, миди, мини, карандаш, фигурист, плед, плиссированные, а-шрифт юбки и многие друге.";            
        }else{
            $this->template->title = "Skirt looks |  Autumn Fashion Skirt Looks | CHOiES";
            $this->template->keywords = "A line Skirts, Midi Skirts, Mini Skirts, Floral Print Skirts, Pleated Skirts";
            $this->template->description = "Discover latest skirt looks at CHOiES. We offer a range of high-quality women's skirts including maxi, midi, mini, pencil, skater, plaid, pleated, a-line skirts and more.";
        }
        $c_id = array(31718,30994,30006,30033,31726,29138,28555,27225,29593,30287,26439,30955,30704,30198,30669,20750,23596,12044,24948,27043,23738,24493,25184,24168,25545,21407,25754,23693,26050,28961,
            19663,19646,13655,16669,29121,29112);
        $looks = DB::select()->from('celebrity_images')->where('id', 'in', $c_id)->order_by('id', 'DESC')->execute();
        $data = array();
        foreach ($looks as $value) {
            $product = Product::instance($value['product_id'],$this->language);
            $data[] = array(
                "image" => STATICURL."/simg/".$value['image'],
                "product_url" => $product->permalink(),
                "link_sku" => $value['link_sku'],
            );
        }
        $this->template->content = View::factory('/activity'.LANGPATH.'/skirt_looks')
            ->set('data', $data);
    }

    public function action_ajax_skirt_looks(){
        $skus = Arr::get($_POST, 'skus', 0);
        $skus = explode(",", trim($skus));
        $lang = Arr::get($_GET, 'lang', 0);
        $n = 0;
        $skudata = array();
        foreach ($skus as $sku) {
            $pro_id = Product::get_productId_by_sku(trim($sku));
            if($lang){
                 $link_pro = Product::instance($pro_id,$lang);
            }else{
                $link_pro = Product::instance($pro_id);
            }
            if (!$link_pro->get('visibility')){
                continue;
            }
            if ($n > 4){
                break;
            }
            $n++;
            $sku_link = $link_pro->permalink();
            $product_name = $link_pro->get('name');
            $img_src = Image::link($link_pro->cover_image(), 3);
            $wishlist[] = $pro_id;

            $orig_price = round($link_pro->get('price'), 2);
            $price = round($link_pro->price(), 2);
            if ($orig_price > $price){
                $orig_price = Site::instance()->price($orig_price, 'code_view');
                $curr_price = Site::instance()->price($price, 'code_view');
            }else{
                $orig_price = False;
                $curr_price = Site::instance()->price($link_pro->get('price'), 'code_view');
            }
            $instock = 1;
            $stock = $link_pro->get('stock');
            $stocks = array();
            $pro_stocks = array();
            if (!$link_pro->get('status') OR ($stock == 0 AND $stock != -99)){
                $instock = 0;
            }elseif ($stock == -1){
                $stocks = DB::select()->from('products_productitem')->where('product_id', '=', $pro_id)->where('stock', '>', 0)->execute()->as_array();
                if (count($stocks) == 0)
                    $instock = 0;
                else{
                    foreach ($stocks as $s){
                        $pro_stocks[$s['attributes']] = $s['stock'];
                    }
                }
            }
            $tmp = array();
        if($lang == '0'){
            if($instock){
                $options = '<p class="select">Size:<select name="size['.$n.']" class="size_select">';
                $is_onesize = 0;
                $set = $link_pro->get('set_id');
                if(!empty($pro_stocks)){
                    $options .= '<option>Select Size</option>';
                    foreach($pro_stocks as $size => $p){
                        $sizeval = $size;
                        if($set == 2){
                            $sizeArr = explode('/', $size);
                            $sizeval = $sizeArr[2];
                        }
                        $options.='<option value="'.str_replace('EUR', '', $sizeval).'" >'.$sizeval.'<span class="red">(Only '.$p.'  left)</span></option>';
                    }
                }else{
                    $attributes = $link_pro->get('attributes');
                    if (isset($attributes['Size'])){
                        if(count($attributes['Size']) == 1)
                            $is_onesize = 1;
                        else
                            $options .= '<option>Select Size</option>';
                        foreach ($attributes['Size'] as $size){
                            $sizeval = $size;
                            if($set == 2){
                                $sizeArr = explode('/', $size);
                                $sizeval = $sizeArr[2];
                            }
                            $options.='<option value="'.str_replace('EUR', '', $sizeval).'" >'.$sizeval.'</option>';
                        }
                    }else{
                        $is_onesize = 1;
                        if (isset($pro_stocks['one size'])){
                            $options.='<option value="one size" title="'.$pro_stocks['one size'].'">One size</option>';
                        }else{
                            $options.='<option value="one size" >One size</option>';
                        }
                    }
                }
                if($is_onesize){
                    $hidden = '<input type="hidden" class="size_input" name="size'.$n.'" value="1" />';
                }else{
                    $hidden = '<input type="hidden" class="size_input" name="size'.$n.'" value="" />';
                }
                $options.='</select>'.$hidden.'</p><p class="select">QTY: <input type="text" class="text" name="qty['.$n.']" value="1" /></p>';
            }else{
                $options = '<p class="select">QTY: <input type="text" class="text" name="qty['.$n.']" value="1" /></p><span class="outstock">out of stock</span>';
            }
        }elseif($lang == 'es'){
            if($instock){
                $options = '<p class="select">Tallas:<select name="size['.$n.']" class="size_select">';
                $is_onesize = 0;
                $set = $link_pro->get('set_id');
                if(!empty($pro_stocks)){
                    $options .= '<option>Elegir Talla</option>';
                    foreach($pro_stocks as $size => $p){
                        $sizeval = $size;
                        if($set == 2){
                            $sizeArr = explode('/', $size);
                            $sizeval = $sizeArr[2];
                        }
                        $options.='<option value="'.str_replace('EUR', '', $sizeval).'" >'.$sizeval.'<span class="red">(Only '.$p.'  left)</span></option>';
                    }
                }else{
                    $attributes = $link_pro->get('attributes');
                    if (isset($attributes['Size'])){
                        if(count($attributes['Size']) == 1)
                            $is_onesize = 1;
                        else
                            $options .= '<option>Elegir Talla</option>';
                        foreach ($attributes['Size'] as $size){
                            $sizeval = $size;
                            if($set == 2){
                                $sizeArr = explode('/', $size);
                                $sizeval = $sizeArr[2];
                            }
                            $sizeSmall = str_replace(array('One size', 'one size', 'One Size'), 'talla única', $sizeval);
                            $options.='<option value="'.str_replace('EUR', '', $sizeval).'" >'.$sizeSmall.'</option>';
                        }
                    }else{
                        $is_onesize = 1;
                        if (isset($pro_stocks['one size'])){
                            $options.='<option value="one size" title="'.$pro_stocks['one size'].'">One size</option>';
                        }else{
                            $options.='<option value="one size" >talla única</option>';
                        }
                    }
                }
                if($is_onesize){
                    $hidden = '<input type="hidden" class="size_input" name="size'.$n.'" value="1" />';
                }else{
                    $hidden = '<input type="hidden" class="size_input" name="size'.$n.'" value="" />';
                }
                $options.='</select>'.$hidden.'</p><p class="select">CANTIDAD: <input type="text" class="text" name="qty['.$n.']" value="1" /></p>';
            }else{
                $options = '<p class="select">CANTIDAD: <input type="text" class="text" name="qty['.$n.']" value="1" /></p><span class="outstock">out of stock</span>';
            }
        }elseif($lang == 'fr'){
            if($instock){
                $options = '<p class="select">Taille:<select name="size['.$n.']" class="size_select">';
                $is_onesize = 0;
                $set = $link_pro->get('set_id');
                if(!empty($pro_stocks)){
                    $options .= '<option>Sélectionner une taille</option>';
                    foreach($pro_stocks as $size => $p){
                        $sizeval = $size;
                        if($set == 2){
                            $sizeArr = explode('/', $size);
                            $sizeval = $sizeArr[2];
                        }
                        $options.='<option value="'.str_replace('EUR', '', $sizeval).'" >'.$sizeval.'<span class="red">(Only '.$p.'  left)</span></option>';
                    }
                }else{
                    $attributes = $link_pro->get('attributes');
                    if (isset($attributes['Size'])){
                        if(count($attributes['Size']) == 1)
                            $is_onesize = 1;
                        else
                            $options .= '<option>Sélectionner une taille</option>';
                        foreach ($attributes['Size'] as $size){
                            $sizeval = $size;
                            if($set == 2){
                                $sizeArr = explode('/', $size);
                                $sizeval = $sizeArr[2];
                            }
                            $sizeSmall = str_replace(array('One size', 'one size', 'One Size'), 'taille unique', $sizeval);
                            $options.='<option value="'.str_replace('EUR', '', $sizeval).'" >'.$sizeSmall.'</option>';
                        }
                    }else{
                        $is_onesize = 1;
                        if (isset($pro_stocks['one size'])){
                            $options.='<option value="one size" title="'.$pro_stocks['one size'].'">taille unique</option>';
                        }else{
                            $options.='<option value="one size" >taille unique</option>';
                        }
                    }
                }
                if($is_onesize){
                    $hidden = '<input type="hidden" class="size_input" name="size'.$n.'" value="1" />';
                }else{
                    $hidden = '<input type="hidden" class="size_input" name="size'.$n.'" value="" />';
                }
                $options.='</select>'.$hidden.'</p><p class="select">Qté: <input type="text" class="text" name="qty['.$n.']" value="1" /></p>';
            }else{
                $options = '<p class="select">Qté: <input type="text" class="text" name="qty['.$n.']" value="1" /></p><span class="outstock">out of stock</span>';
            }
        }elseif($lang == 'ru'){
            if($instock){
                $options = '<p class="select">Размер:<select name="size['.$n.']" class="size_select">';
                $is_onesize = 0;
                $set = $link_pro->get('set_id');
                if(!empty($pro_stocks)){
                    $options .= '<option>выбрать размер</option>';
                    foreach($pro_stocks as $size => $p){
                        $sizeval = $size;
                        if($set == 2){
                            $sizeArr = explode('/', $size);
                            $sizeval = $sizeArr[2];
                        }
                        $options.='<option value="'.str_replace('EUR', '', $sizeval).'" >'.$sizeval.'<span class="red">(Only '.$p.'  left)</span></option>';
                    }
                }else{
                    $attributes = $link_pro->get('attributes');
                    if (isset($attributes['Size'])){
                        if(count($attributes['Size']) == 1)
                            $is_onesize = 1;
                        else
                            $options .= '<option>выбрать размер</option>';
                        foreach ($attributes['Size'] as $size){
                            $sizeval = $size;
                            if($set == 2){
                                $sizeArr = explode('/', $size);
                                $sizeval = $sizeArr[2];
                            }
                            $sizeSmall = str_replace(array('One size', 'one size', 'One Size'), 'только один размер', $sizeval);
                            $options.='<option value="'.str_replace('EUR', '', $sizeval).'" >'.$sizeSmall.'</option>';
                        }
                    }else{
                        $is_onesize = 1;
                        if (isset($pro_stocks['one size'])){
                            $options.='<option value="one size" title="'.$pro_stocks['one size'].'">только один размер</option>';
                        }else{
                            $options.='<option value="one size" >только один размер</option>';
                        }
                    }
                }
                if($is_onesize){
                    $hidden = '<input type="hidden" class="size_input" name="size'.$n.'" value="1" />';
                }else{
                    $hidden = '<input type="hidden" class="size_input" name="size'.$n.'" value="" />';
                }
                $options.='</select>'.$hidden.'</p><p class="select">Количество: <input type="text" class="text" name="qty['.$n.']" value="1" /></p>';
            }else{
                $options = '<p class="select">Количество: <input type="text" class="text" name="qty['.$n.']" value="1" /></p><span class="outstock">out of stock</span>';
            }
        }elseif($lang == 'de'){
            if($instock){
                $options = '<p class="select">Größe:<select name="size['.$n.']" class="size_select">';
                $is_onesize = 0;
                $set = $link_pro->get('set_id');
                if(!empty($pro_stocks)){
                    $options .= '<option>Größe Wählen</option>';
                    foreach($pro_stocks as $size => $p){
                        $sizeval = $size;
                        if($set == 2){
                            $sizeArr = explode('/', $size);
                            $sizeval = $sizeArr[2];
                        }
                        $options.='<option value="'.str_replace('EUR', '', $sizeval).'" >'.$sizeval.'<span class="red">(Only '.$p.'  left)</span></option>';
                    }
                }else{
                    $attributes = $link_pro->get('attributes');
                    if (isset($attributes['Size'])){
                        if(count($attributes['Size']) == 1)
                            $is_onesize = 1;
                        else
                            $options .= '<option>Größe Wählen</option>';
                        foreach ($attributes['Size'] as $size){
                            $sizeval = $size;
                            if($set == 2){
                                $sizeArr = explode('/', $size);
                                $sizeval = $sizeArr[2];
                            }
                            $sizeSmall = str_replace(array('One size', 'one size', 'One Size'), 'Eine Größe', $sizeval);
                            $options.='<option value="'.str_replace('EUR', '', $sizeval).'" >'.$sizeSmall.'</option>';
                        }
                    }else{
                        $is_onesize = 1;
                        if (isset($pro_stocks['one size'])){
                            $options.='<option value="one size" title="'.$pro_stocks['one size'].'">Eine Größe</option>';
                        }else{
                            $options.='<option value="one size" >Eine Größe</option>';
                        }
                    }
                }
                if($is_onesize){
                    $hidden = '<input type="hidden" class="size_input" name="size'.$n.'" value="1" />';
                }else{
                    $hidden = '<input type="hidden" class="size_input" name="size'.$n.'" value="" />';
                }
                $options.='</select>'.$hidden.'</p><p class="select">Menge: <input type="text" class="text" name="qty['.$n.']" value="1" /></p>';
            }else{
                $options = '<p class="select">Menge: <input type="text" class="text" name="qty['.$n.']" value="1" /></p><span class="outstock">out of stock</span>';
            }           
        }

            $skudata[] = array(
                'n'=>$n,
                'product_id'=>$pro_id,
                'sku_link'=>$sku_link,
                'img_src'=>$img_src,
                'product_name'=>$product_name,
                'orig_price'=>$orig_price,
                'curr_price'=>$curr_price,
                'options'=>$options,
            );
        }
        echo json_encode($skudata);
        exit;
    }

    public function action_tropical_designs()
    {
        $this->template->content = View::factory('/activity'.LANGPATH.'/tropical_designs');
    }

    public function action_thanksgiving_looks()
    {
        $this->template->title = "What to wear for Thanksgiving Occasions?";
        $this->template->keywords = "Thanksgiving Outfits,Family Gathering,Party Out,Warm Things";
        $this->template->description = "Guidelines for 2014 Thanksgiving Outfits：Create different Looks on the Way Back Home, enjoy Family Gathering, and Party Out with friends.";
        $c_id_1 = array(22065,20004,22073,22070,22090,21995,22102,22095,);
        $c_id_2 = array(20323,19794,21280,21006,19400,22075,20536,20214,);
        $c_id_3 = array(21953,19777,21751,19973,15547,15463,16405,10909,);
        $looks_1 = DB::select()->from('celebrity_images')->where('id', 'in', $c_id_1)->execute();
        $data_1 = array();
        foreach ($looks_1 as $value) {
            $product = Product::instance($value['product_id']);
            $data_1[] = array(
                "image" => STATICURL."/simg/".$value['image'],
                "product_url" => $product->permalink(),
                "link_sku" => $value['link_sku'],
            );
        }
        $looks_2 = DB::select()->from('celebrity_images')->where('id', 'in', $c_id_2)->execute();
        $data_2 = array();
        foreach ($looks_2 as $value) {
            $product = Product::instance($value['product_id']);
            $data_2[] = array(
                "image" => "http://img.choies.com/simages/".$value['image'],
                "product_url" => $product->permalink(),
                "link_sku" => $value['link_sku'],
            );
        }
        $looks_3 = DB::select()->from('celebrity_images')->where('id', 'in', $c_id_3)->execute();
        $data_3 = array();
        foreach ($looks_3 as $value) {
            $product = Product::instance($value['product_id']);
            $data_3[] = array(
                "image" => "http://img.choies.com/simages/".$value['image'],
                "product_url" => $product->permalink(),
                "link_sku" => $value['link_sku'],
            );
        }
        $this->template->content = View::factory('/activity'.LANGPATH.'/thanksgiving_looks')
            ->set('data_1', $data_1)->set('data_2', $data_2)->set('data_3', $data_3);
    }

    public function action_black_friday_daily_deal()
    {
        $from = time();
        $to = $from  - 36000;
        $end_day = '2014-11-27';
        $expired_time = time();
        $nows = DB::query(Database::SELECT, 'SELECT product_id, price, created, expired FROM spromotions WHERE `type` = -1 AND expired > ' . $expired_time . ' ORDER BY created ASC LIMIT 0, 4')->execute()->as_array();
        $ends = DB::query(Database::SELECT, 'SELECT product_id, price, created, expired FROM spromotions WHERE `type` = -1 AND expired < ' . $expired_time . ' ORDER BY created DESC LIMIT 0, 3')->execute()->as_array();
        $this->template->content = View::factory('/activity'.LANGPATH.'/black_friday_daily_deal')
            ->set('nows', $nows)
            ->set('ends', $ends)
            ->set('end_day', $end_day);
    }

    public function action_quick_response_code()
    {
        $code_id = 332388;
        $customer_id = Customer::logged_in();
        if($customer_id)
        {
            $has_code = DB::select('id')->from('carts_customercoupons')->where('coupon_id', '=', $code_id)->where('customer_id', '=', $customer_id)->execute()->get('id');
            if(!$has_code)
            {
                $insert = array('customer_id' => $customer_id, 'coupon_id' => $code_id);
                DB::insert('carts_customercoupons', array_keys($insert))->values($insert)->execute();
            }
        }
        $this->template->content = View::factory('/activity'.LANGPATH.'/quick_response_code')->set('customer_id', $customer_id);
    }


    /*
        暂时隐藏该活动，修改URL,已跟运营沟通
    */
      public function action_back_to_school666()
    {
                //产品排序
        $get = Arr::get($_GET, 'type', 0);
        if(empty($get)){
            $get = 709;
        }

                $sort_key = (int) Arr::get($_GET, 'sort', 0);
                $sorts = Kohana::config('catalog.sorts');
                $sortcolor = Kohana::config('catalog.colors');
                    $orderby = $sorts[$sort_key]['field'];
                    $queue = $sorts[$sort_key]['queue'];

        $limit_key = (int) Arr::get($_GET, 'limit', 1);
        $limits = Kohana::config('catalog.limits');
        $limit = $limits[$limit_key];
         $easy1 = $get;
        $custom_filter = array();
        
          // $easy1 = DB::select('id', 'template', 'image_src', 'meta_title', 'meta_keywords', 'meta_description')->from('products_category')->where('name', '=', 'Dresses')->execute()->current();
        $catalog = Catalog::instance($easy1, LANGUAGE);
        $count_products = $catalog->count_products();
            $pagination = Pagination::factory(array(
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items' => $count_products,
                        'items_per_page' => 100,
                        'view' => '/pagination_1'));
        // $time = time();  
          // $weekly1 = DB::query(Database::SELECT, 'SELECT c.product_id
          // FROM products p INNER JOIN products_categoryproduct c ON p.id = c.product_id
 // WHERE c.catalog_id =' . $easy1['id'] .'  AND p.visibility = 1 AND p.status = 1 AND p.stock <> 0
 // ORDER BY   c.position DESC , p.created DESC , p.hits DESC')
                 // ->execute()->as_array();
$products = $catalog->products($pagination->offset, $pagination->items_per_page, $orderby, $queue, $custom_filter);
        

        // $products = array();

            // $products = $weekly1;
        // $con = count($weekly1);

        // for($i = 0 ;$i<100 ;$i++){
            // $weekly2[$i]['product_id']=$weekly1[$i];
        // }



        
        $customer_id = Customer::logged_in();
                    if($customer_id){
                        $wishlists = DB::select('product_id')->from('accounts_wishlists')->where('customer_id', '=', $customer_id)->where('product_id', 'IN', $products)->execute()->as_array();
                    }else{
                        $wishlists = array();
                    }
        
        $this->template->content = View::factory('/activity'.LANGPATH.'/homecome')
             ->set('pagination1', $pagination->render())
            ->set('products', $products)
            ->set('easy1', $easy1)
            ->set('customer_id', $customer_id)
            ->set('wishlists', $wishlists);
    }

    public function action_christmas_shopping_guide()
    {
        $this->template->content = View::factory('/activity'.LANGPATH.'/christmas_shopping_guide');
    }

    public function action_c_xmas_giveaway()
    {
        $created = strtotime('2014-12-22');
        if ($_POST)
        {
            $customer_id = Customer::logged_in();
            if ($customer_id)
            {
                $data['user_id'] = $customer_id;
                $ip = ip2long(Request::$client_ip);
                $has_submit = DB::query(Database::SELECT, 'SELECT DISTINCT id FROM giveaway WHERE created > ' . $created . ' AND ip=' . $ip . ' ORDER BY created DESC')->execute()->get('id');
                if ($has_submit)
                {
                    Message::set(__('have_submit'));
                    $this->request->redirect(URL::current(TRUE));
                }
                $data['ip'] = $ip;
                $data['firstname'] = Arr::get($_POST, 'name', '');
                $sku = trim(Arr::get($_POST, 'sku', ''));
                $skuArr = array();
                if ($sku)
                {
                    $data['sku'] = $sku;
                    $data['comments'] = Arr::get($_POST, 'comments', '');
                    $url = Arr::get($_POST, 'url', '');
                    if ($data['comments'] AND $url)
                    {
                        $urls = array();
                        $urls[] = $url;
                        $urls1 = Arr::get($_POST, 'urls', array());
                        foreach ($urls1 as $u)
                        {
                            if (trim($u))
                                $urls[] = trim($u);
                        }
                        $data['urls'] = serialize($urls);
                        $data['created'] = time();
                        $insert = DB::insert('giveaway', array_keys($data))->values($data)->execute();
                        if ($insert)
                        {
                            Message::set(__('have_submit'));
                            $this->request->redirect(URL::current(TRUE) . '#step5');
                        }
                        else
                        {
                            Message::set('Your submission failed!');
                            $this->request->redirect(URL::current(TRUE));
                        }
                    }
                    else
                    {
                        Message::set('Please write down the comment AND url!');
                        $this->request->redirect(URL::current(TRUE) . '#step4');
                    }
                }
                else
                {
                    Message::set('Please write down the correct SKU!');
                    $this->request->redirect(URL::current(TRUE) . '#step3');
                }
            }
            else
            {
                Message::set(__('need_log_in'));
                $this->request->redirect(URL::current(TRUE));
            }
        }
        $step = '';
        $page = Arr::get($_GET, 'page', 0);
        if ($page > 0)
            $step = 5;

        $comments = DB::select()->from('giveaway')->where('created', '>', $created)->and_where('urls', '<>', '')->order_by('id', 'desc')->execute()->as_array();
        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => count($comments),
                'items_per_page' => 10,
                'view' => '/pagination_r'));
        $comments = $comments ? array_slice($comments, $pagination->offset, $pagination->items_per_page) : array();
        echo View::factory('/activity'.LANGPATH.'/xmas_giveaway')
            ->set('comments', $comments)
            ->set('pagination', $pagination->render())
            ->set('step', $step);
        exit;
    }

    public function action_new_year_slogan_wanted()
    {
        $created = strtotime('2014-12-28');
        if ($_POST)
        {
            $customer_id = Customer::logged_in();
            if ($customer_id)
            {
                $data['user_id'] = $customer_id;
                $ip = ip2long(Request::$client_ip);
                $has_submit = DB::query(Database::SELECT, 'SELECT DISTINCT id FROM giveaway WHERE created > ' . $created . ' AND ip=' . $ip . ' ORDER BY created DESC')->execute()->get('id');
                if ($has_submit)
                {
                    Message::set(__('have_submit'));
                    $this->request->redirect(URL::current(TRUE));
                }
                $data['ip'] = $ip;
                $data['firstname'] = Arr::get($_POST, 'name', '');
                $data['comments'] = Arr::get($_POST, 'comments', '');
                if ($data['comments'])
                {
                    $data['created'] = time();
                    $insert = DB::insert('giveaway', array_keys($data))->values($data)->execute();
                    if ($insert)
                    {
                        Message::set(__('have_submit'));
                        $this->request->redirect(URL::current(TRUE) . '#step5');
                    }
                    else
                    {
                        Message::set('Your submission failed!');
                        $this->request->redirect(URL::current(TRUE));
                    }
                }
                else
                {
                    Message::set('Please write down the comment AND url!');
                    $this->request->redirect(URL::current(TRUE) . '#step4');
                }
            }
            else
            {
                Message::set(__('need_log_in'));
                $this->request->redirect(URL::current(TRUE));
            }
        }
        $step = '';
        $page = Arr::get($_GET, 'page', 0);
        if ($page > 0)
            $step = 5;

        $comments = DB::select()->from('giveaway')->where('created', '>', $created)->and_where('sku', 'IS', NULL)->order_by('id', 'desc')->execute()->as_array();
        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => count($comments),
                'items_per_page' => 10,
                'view' => '/pagination'));
        $comments = $comments ? array_slice($comments, $pagination->offset, $pagination->items_per_page) : array();
        echo View::factory('/activity'.LANGPATH.'/new_year_slogan_wanted')
            ->set('comments', $comments)
            ->set('pagination', $pagination->render())
            ->set('step', $step);
        exit;
    }

    public function action_vote_for_annual_best_design()
    {
        $time = strtotime('2015-2-9');
        $index = 1;
        $count = 59;
        $success = 0;
        $step = '';
        $skuArr = array(
'DRES1027A134A',
'COAT1113A202A',
'CZZY4701',
'CSZY0868',
'CIZY4394',
'CCPC0140',
'CRWC4533',
'CJZY4795',
'CDZY2855',
'CSZY4476',
'CDZY4383',
'CPZY2683',
'CSZY4372',
'CSZY4748',
'CDXF2595',
'CPXF2255',
'CCYY1193',
'CTWC3747',
'CSXZ0237',
'CKYY1131',
'CK024749',
'CKDL3780',
'JHDL0008',
'AB060389',
'AHZY2615',
'ASMX1041',
'ASMX0986',
'ASMX2112',
        );
        $page = Arr::get($_GET, 'page', 0);
        if ($page > 0)
            $step = 5;

        $name = Arr::get($_REQUEST, 'name', '');
        $sku = Arr::get($_REQUEST, 'sku', '');
        $get = '';
        if($name && $sku)
        {
            $get = '?data=name__' . $name . '|sku__' . $sku;
            $_POST['name'] = $name;
            $_POST['sku'] = $sku;
        }

        if ($_POST)
        {
            if (!$customer_id = Customer::logged_in())
            {
                Message::set(__('need_log_in'), 'notice');
                $this->request->redirect(LANGPATH . '/customer/login' . $get);
            }
            $has_submit = DB::query(Database::SELECT, 'SELECT DISTINCT id FROM giveaway WHERE urls="" AND created > ' . $time . ' AND user_id=' . $customer_id . ' ORDER BY created DESC')->execute()->get('id');
            if ($has_submit)
            {
                Message::set(__('have_submit'), 'notice');
                $this->request->redirect(URL::current(FALSE) . '#step1');
            }

            $data = array();
            $data['firstname'] = Arr::get($_POST, 'name', '');
            if (!$data['firstname'])
            {
                Message::set(__('input_empty'), 'error');
                $this->request->redirect(URL::current(FALSE) . '#step1');
            }
            $data['sku'] = Arr::get($_POST, 'sku', '');
            $data['user_id'] = $customer_id;
            $data['created'] = time();
            $result = DB::insert('giveaway', array_keys($data))->values($data)->execute();
            $step = 3;
            if ($result)
            {
                Message::set(__('have_submit'));
                $this->request->redirect(URL::current(FALSE) . '#step3');
            }
            else
            {
                Message::set('Your submission failed!', 'error');
                $this->request->redirect(URL::current(FALSE) . '#step1');
            }
        }

        $comments = DB::select()->from('giveaway')->where('urls', '=', '')->and_where('created', '>', $time)->order_by('created', 'desc')->execute()->as_array();
        $count = count($comments);
        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => $count,
                'items_per_page' => 10,
                'view' => '/pagination'));
        $comments = $comments ? array_slice($comments, $pagination->offset, $pagination->items_per_page) : array();
        $result = DB::select('sku')->from('giveaway')->where('created', '>', $time)->where('urls', '=', '')->execute();
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

        echo View::factory('/activity'.LANGPATH.'/vote_for_the_best_design')
            ->set('skuArr', $skuArr)
            ->set('comments', $comments)
            ->set('count', $count)
            ->set('votes', $votes)
            ->set('pagination', $pagination->render())
            ->set('step', $step);
        exit;
    }

     public function action_model_vote()
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
        $customer_id = Customer::logged_in();
       if($_POST)
        {
            if (!$customer_id = Customer::logged_in())
            {
                Message::set(__('need_log_in'), 'notice');
                $this->request->redirect(LANGPATH . '/customer/login?redirect='.LANGPATH.'/activity/model_vote');
            }
            for($i = 1 ; $i<61;$i++){
                $ios = 'voteadd'.$i;
                if($_POST[$ios]){
                  $arr[] = $_POST[$ios].'';   
                }

               
            }       

            if(empty($arr)){
                Message::set(__('need_select'), 'notice');
                $this->request->redirect(LANGPATH.'/activity/model_vote');              
            }
            
            $brr = implode(',',$arr);
            $data =array();
            $data['user_id'] = $customer_id;
            $data['created'] = time();
            $data['sku'] = $brr;

            $data['comments'] = Arr::get($_POST, 'comment', '');
            if($data['comments'] === 'Leave your comment...'){
                $data['comments'] = '';
            }
            $data['firstname'] = Customer::instance($customer_id)->get('firstname');
            $result = DB::insert('giveaway', array_keys($data))->values($data)->execute();
            if($result){
                $this->request->redirect(LANGPATH . '/activity/getcode');
            }
        

            
        }
        if($customer_id){
            $cu = array();
       foreach($skuArr as $s)
        {
            $cu[$s] = 0;
        } 
 $has_submit = DB::query(Database::SELECT, 'SELECT sku FROM giveaway WHERE  user_id=' . $customer_id)->execute('slave')->as_array();   

        foreach($has_submit as $ro){
            $skuss = explode(',', $ro['sku']);
            foreach($skuss as $sku)
            {
                $sku = trim($sku);
                if(in_array($sku, $skuArr))
                    $cu[$sku] = 1;
            }
        }   
     }



        $result = DB::select('sku')->from('giveaway')->where('created', '>', $time)->where('urls', '=', '')->execute()->as_array();

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
        $this->template->title = 'HOW TO WIN $100 GIFT CARD?';
        $this->template->description = 'Vote To Get Rewarded! $10 For Each Participant，$100 For One Lucky Guy.';
        $this->template->og_image = 'http://cloud.choies.com/assets/images/activity/vote12.jpg';

        $this->template->content = View::factory('/activity'.LANGPATH.'/activity_vote')
        ->set('skuArr', $skuArr)
        ->set('votes', $votes)
        ->set('cu', $cu);
    //    ->set('a',$a);
    }

    public function action_getcode()
    {
       $this->template->content = View::factory('/activity'.LANGPATH.'/getcode');
    }

    public function action_vip_exclusive()
    {
        $skuArr = array(
'CAA0UY',
'CYA7FL',
'CXA970',
'CXA84K',
'CXA7D8',
'CXA8U7',
'CYA75A',
'CPA7W3',
'CYA30L',
'CYA3WA',
'CYA30U',
'CXA6AZ',
'SWIM0508B036X',
'SWIM0722B038A',
'CXA8FT',
'PAA8K4',
'CXA8PG',
'CPA893',
'CXA95G',
'CXA8L0',
'CAA8JT',
'CXA8UE',
'CPA82U',
'CXA8PM',
'CXA97K',
'CXA8PV',
'CPA88K',
'CXA8KR',
'CXA7US',
'CXA6B1',
'CPA8DE',
'CXA6AY',
'CXA8X2',
'CXA8KM',
'CPA8DF',
'PXA94E',
'CXA8KZ',
'CXA8U4',
'CPA8DC',
'CXA95A',
'CXA8XA',
'CXA8XG',
'CXA8PU',
'CXA8KY',
'CXA8FQ',
'CXA8X5',
'PAA9QN',
'PYA8NF',
);
    //title
    $lang=LANGUAGE;
    $seoinfo=array(
            "de"=>array("title"=>"VIP Exklusiv"),
            "es"=>array("title"=>"Vip Exclusivo "),
            "fr"=>array("title"=>"Exclusivement pour VIP "),
            "ru"=>array("title"=>"Vip Исключительное"),
            );
    if($lang!=""){
        $this->template->title = $seoinfo[$lang]['title'];
    }else{
        $this->template->title = "Vip Exclusive";
    }
    $this->template->content = View::factory('/activity'.LANGPATH.'/vip')
    ->set('skuArr', $skuArr);        
    }

    public function action_black_plaid_print_organza_skater_maxi_dress_p45933()
    {

    $this->template->content = View::factory('/activity'.LANGPATH.'/china');
    }


    /* 以下内容为抽奖内容 Add Time 2015.10.27*/
    //抽奖页面
    public function action_luck_draw()
    {
        echo View::factory('/activity'.LANGPATH.'/luck_draw');exit;
    }   
    
    //执行抽奖
    public function action_chkdraw()
    {
        if($_POST)
        {
            $customer_id = Arr::get($_POST, 'customer_id');
            if($customer_id)
            {                
                $res = array();
                $draw_state = Customer::instance($customer_id)->get('draw_state');//查询用户抽奖状态
                if($draw_state == 1){
                    echo trim('nochange');exit;
                }
                //查询参与奖项
                $draw_row = DB::query(Database::SELECT, 'select draw_name,probability,coupon_id from customer_bability order by id desc')->execute()->as_array();
                if(count($draw_row)>=1){
                    $i=1;
                    foreach ($draw_row as $key => $val) {
                        $arr[$i] = $val['probability'];
                        $i++;
                    }
                    $rid = $this->get_rand($arr); //根据概率获取奖项id
                    $res['yes'] = $draw_row[$rid-1]['coupon_id']; //折扣券ID
                    echo $res['yes'];exit;
                }
            }
        }
    }

    //发放奖项
    public function action_senddraw()
    {
        $coupon_id = Arr::get($_POST, 'coupon_id');
        $customer_id = Arr::get($_POST, 'customer_id');
        if(!$customer_id){
            $customer_id = Customer::logged_in();
        }
        //更改当前用户抽奖状态
        $upstate = DB::query(Database::UPDATE, 'UPDATE accounts_customers set draw_state = 1 where id = "'.$customer_id.'"')->execute();
        if($coupon_id == 0){echo 'success';exit;}
        if($upstate){
            $email = Customer::instance($customer_id)->get('email');
            //将中得折扣券奖项录入coupons表与customer_draw表
            $coupon_arr = array(
                    'customer_id' => $customer_id,
                    'coupon_id'   => $coupon_id
            );
            $draw_name = DB::query(Database::SELECT, 'select draw_name from customer_bability where coupon_id = "'.$coupon_id.'"')->execute()->current();
            if($draw_name){
                DB::insert('customer_coupons', array_keys($coupon_arr))->values($coupon_arr)->execute();
                DB::query(Database::INSERT, 'insert into customer_draw(email,draw_name,created)values("'.$email.'","'.$draw_name['draw_name'].'",now())')->execute();
                echo 'success';exit;
            }else echo 'error';exit;
        }else echo 'update error';
    }
    
    public function action_chkmail()
    {
        if($_POST)
        {
            $email = Arr::get($_POST, 'email');
            $email_state = DB::query(Database::SELECT, 'select email from customers where email = "'.$email.'"')->execute()->current();
            echo $email_state ? trim('isset') : trim('error');exit;
        }
    }
    
    function get_rand($proArr) {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        return $result;
    }

    //11-11
    public function action_singles_day_sale()
    {
        $cate_id = Arr::get($_POST, 'data_id');
        $lan = Arr::get($_POST, 'lan');
        $getchache =  '';
        $ajax_state = false;
        if(!empty($cate_id)){
            $ajax_state = true;
            $cateArr = Kohana::config('11_11.'.$cate_id );
        }else{
            $cateArr = Kohana::config('11_11.1' );
        }
		if(!empty($lan)){
			$lan=$lan;
		}else{
			$lan=LANGUAGE;
		}
        $data=array();
        //guo add 11.11
        if(empty($cate_id)){
            $cate_id = 1;
        }
                $currency_now = Site::instance()->currency();
                 $cache_key = 'site_activity_choies_' .$lan.'_'.$cate_id.'_'.$currency_now['name'];
                 $cache_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_key);
                 $cache_content = Cache::instance('memcache')->get($cache_key);
                 if (isset($cache_content) AND !isset($_GET['cache'])){
                            $data = $cache_content;
                    }else{
        foreach($cateArr as $k=>$v){
            $product_id = DB::query(Database::SELECT, 'select id FROM products where sku = "'.$v['sku'].'"')->execute()->current();
            $cover_image = Product::instance($product_id['id'],$lan)->cover_image();
            $image=Image::link($cover_image, 1);
            $product_inf = Product::instance($product_id['id'])->get();
            $plink = Product::instance($product_id['id'],$lan)->permalink();
            $orig_price = round($product_inf['price'], 2);
            $price = round(Product::instance($product_id['id'])->price(), 2);
            $orig_price=Site::instance()->price($orig_price, 'code_view');
            $price1=Site::instance()->price($product_inf['price'], 'code_view');
            $product_name = Product::instance($product_id['id'],$lan)->get('name');
            $discount_price = Site::instance()->price($v['discount_price'], 'code_view');
            $data[]=array(
                    'image'=>$image, 
                    'plink'=>$plink,
                    'orig_price'=>$orig_price,
                    'price'=>$price,
                    'price1'=>$price1,
                    'discount_price'=>$discount_price,
                    'name' => $product_name 
                );              
        }

             Cache::instance('memcache')->set($cache_key, $data, 7200);                            
                    }
        if($ajax_state){
            echo json_encode($data);exit;
        } 
        $this->template->title = 'Singles Day sale, Double 11 Shopping | CHOiES';
        $this->template->description = "Join in Singles Day Sale with the lowest price. CHOiES offers you women's Clothing, Dresses , Accessories & Shoes!";
        $this->template->content = View::factory('/activity'.LANGPATH.'/singles-day-sale')->set('data',$data);
    }

    public function action_testdefault()
    {


         // Site::instance()->isblack();       
        $cache = Cache::instance('memcache');
        $cache_key = "catalog_route1";

        if( ! ($catalogs = $cache->get($cache_key)))
        {
        $catalogs = DB::select('id', 'link')->from('products_category')->where('visibility', '=', 1)->execute()->as_array();
            $cache->set($cache_key, $catalogs, 1800);
        }
        echo '<pre>';
        print_r($catalogs);


        
    }

    //lottery
    public function action_lottery()
    {
        $step = '';
        $page = Arr::get($_GET, 'page', 0);
        if ($page > 0)
            $step = 5;
        $links = DB::query(Database::SELECT, 'select username,link,created FROM lottery where status=1 ORDER BY id DESC')->execute()->as_array();
        $data=array();
        foreach($links as $k=>$link){
            $data1=array();
            $data1['link']=unserialize($link['link']);
            $data1['created']=date("Y-m-d H:i:s",$link['created']);
            $data1['username']=$link['username'];
            $data[]=$data1;
        }
        $pag=count($data);
        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => $pag,
                'items_per_page' => 10,
                'view' => '/pagination'));
        $data = $data ? array_slice($data, $pagination->offset, $pagination->items_per_page) : array();
        $this->template->title = 'lottery';
        $this->template->description = "Join in Singles Day Sale with the lowest price. CHOiES offers you women's Clothing, Dresses , Accessories & Shoes!";
        $this->template->content = View::factory('/activity'.LANGPATH.'/lottery')->set('data',$data)->set('pagination', $pagination->render());
    }
    
    //保存lotterylink
    public function action_lotterylink(){
        $return = array();

        if (!($customer_id = Customer::logged_in()))
        {
            $return['success'] = -3;
            echo json_encode($return);
            exit;
        }
        else
        {
            $status = DB::query(Database::SELECT, 'select status FROM lottery where customer_id = "'.$customer_id.'"')->execute()->current();
            //判断用户玩的次数
            if($status['status']==1){
                $return['success'] = -1;
                echo json_encode($return);
                exit;
            }else{
                $username = Arr::get($_POST, 'name', '');
                $lotterylink = Arr::get($_POST, 'link', '');
                $preg=array();
                foreach($lotterylink as $k => $link1){
                    $link2=substr($link1,0,4);
                    if($link2=='http'){
                        $preg[]=$link1;
                    }else{
                        unset($lotterylink[$k]);
                    }
                }
                $lotterylink=array_filter($preg);
                //判断数组是否有重复值 合并
                $lotterylink=array_unique($lotterylink);
                if(empty($lotterylink)){
                    $return['success'] = -4;
                    echo json_encode($return);
                    exit;
                }
                $linklen=count($lotterylink);
                if($linklen<=10){
                    $data = array();
                    $data['customer_id'] = $customer_id;
                    $data['username'] = $username;
                    $data['link'] = serialize($lotterylink);//序列化把数组存到数据库
                    $data['created'] = time();
                    $data['status'] = 1;
                    $data['coupon'] = 0;
                    $lottery=DB::insert('lottery', array_keys($data))->values($data)->execute();
                    if ($lottery)
                    {
                        $coupon1 = DB::query(Database::SELECT, 'select coupon FROM lottery where customer_id = "'.$customer_id.'"')->execute()->current();
                        
                        if($coupon1['coupon']==0){
                            $coupon_code = 'LUCKYFAN5' . $customer_id;
                            $coupons = DB::query(Database::SELECT, 'select code FROM coupons where code = "'.$coupon_code.'"')->execute()->current();
                            if($coupons['code']){
                                $return['success'] = 12;
                                exit;
                            }else{
                                $coupon = array(
                                // 'site_id' => $this->site_id,
                                'code' => $coupon_code,
                                'value' => 5,
                                'type' => 1,
                                'limit' => 1,
                                'used' => 0,
                                'created' => time(),
                                'expired' => time() + 30 * 86400,
                                'on_show' => 0,
                                'deleted' => 0,
                                'usedfor' => 1,
                                'effective_limit' => 0
								// 'target'=>'global'
                            );
                            $insert = DB::insert('carts_coupons', array_keys($coupon))->values($coupon)->execute();
                            
                            if ($insert)
                            {
                                $c_coupon = array(
                                    'customer_id' => $customer_id,
                                    'coupon_id' => $insert[0],
                                    'deleted' => 0
                                    // 'site_id' => $this->site_id
                                );
                                $ok=DB::insert('carts_customercoupons', array_keys($c_coupon))->values($c_coupon)->execute();
                                DB::update('lottery')->set(array('coupon' => 1))->where('customer_id', '=', $customer_id)->execute();
                            }
                            if($ok){
                                $return['success'] = 1;
                            }else{
                                $return['success'] = 11;
                            }
                            }
                        
                        
                    }
                    else
                    {
                        $return['success'] = 0;
                    }
                }else{
                    $return['success'] = -2;
                    echo json_encode($return);
                    exit;
                }
                
                
            }
            
        }
        echo json_encode($return);
        exit;
        
        }

    }

    public function action_blackfriday()
    {
        $blackarr = array
('SH0076' => array('id' => 51788, 'sku' => 'SH0076', 'name' => 'Black Suedette Pointed Laced Back Over The Knee Flat Boots', 'de_name' => 'Schwarze Veloursleder spitze Rücken über das Knie Flache Stiefel', 'es_name' => 'Botas Planas De Gamuza Con Cordónes Negro', 'fr_name' => 'Bottes Plates En Suédé Pointues à Lacets Noires', 'ru_name' => 'Черные Остроносые Сапоги', 'link' => 'black-suede-pointed-laced-back-over-the-knee-flat-boots', 'attributes' => 'a:1:{s:4:"Size";a:8:{i:0;s:26:"US4/UK2-UK2.5/EUR35/22.5cm";i:1;s:24:"US5/UK3-UK3.5/EUR36/23cm";i:2;s:26:"US6/UK4-UK4.5/EUR37/23.5cm";i:3;s:24:"US7/UK5-UK5.5/EUR38/24cm";i:4;s:26:"US8/UK6-UK6.5/EUR39/24.5cm";i:5;s:24:"US9/UK7-UK7.5/EUR40/25cm";i:6;s:27:"US10/UK8-UK8.5/EUR41/25.5cm";i:7;s:25:"US11/UK9-UK9.5/EUR42/26cm";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/255792.jpg'),
'SHOE1215A461B' => array('id' => 38723, 'sku' => 'SHOE1215A461B', 'name' => 'Gray Stretch Suede Laced Back Heeled Over the Knee Boots', 'de_name' => 'Graue Wildlederimitat Geschnürter Rücken hohe Absätze Über den Knie Stiefeln', 'es_name' => 'Botas De Tacón De Antelina Gris', 'fr_name' => 'Cuissardes Suédées à Talons Avec Lacets Grises', 'ru_name' => 'Серые Замшевые Сапоги Выше Колена', 'link' => 'gray-over-the-knee-boots-stretch-suede-laced-back-high-heels', 'attributes' => 'a:1:{s:4:"Size";a:7:{i:0;s:26:"US4/UK2-UK2.5/EUR35/22.5cm";i:1;s:24:"US5/UK3-UK3.5/EUR36/23cm";i:2;s:26:"US6/UK4-UK4.5/EUR37/23.5cm";i:3;s:24:"US7/UK5-UK5.5/EUR38/24cm";i:4;s:26:"US8/UK6-UK6.5/EUR39/24.5cm";i:5;s:24:"US9/UK7-UK7.5/EUR40/25cm";i:6;s:27:"US10/UK8-UK8.5/EUR41/25.5cm";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/192387.jpg'),
'CCDL4194' => array('id' => 19148, 'sku' => 'CCDL4194', 'name' => 'Shearling Lapel Biker Coat', 'de_name' => 'Lammfell Revers Radfahrer Mantel', 'es_name' => 'Chaqueta Con Las Solapas De Piel De Oveja', 'fr_name' => 'Blouson De Motard à Revers En Imitation Peau De Mouton', 'ru_name' => 'Байкеры-Куртка Из Барашка С Отворотом', 'link' => 'shearling-lapel-biker-coat', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/155138.jpg'),
'CAA01P' => array('id' => 56632, 'sku' => 'CAA01P', 'name' => 'White PU Lapel Long Sleeve Slim Coat', 'de_name' => 'Weiße PU Revers Lange Ärmel Enger Jacke', 'es_name' => 'Chaqueta Manga Larga Con Panel De PU Blanca', 'fr_name' => 'Manteau Mince Empiècement En PU Manches Longues Blanc', 'ru_name' => 'Белое PU Отложной Вороник Нижнее Пальто С Длинным Рукавом', 'link' => 'white-pu-lapel-long-sleeve-slim-coat', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/281221.jpg'),
'CCYY0859' => array('id' => 26087, 'sku' => 'CCYY0859', 'name' => 'Black Hooded Longline Coat with Belt', 'de_name' => 'Schwarz Kapuzenlongline Mantel mit Gürtel', 'es_name' => 'Chaqueta Palangre Con Cinturón Y Con Capucha En Negro', 'fr_name' => 'Manteau Long à Capuche Avec Ceinture Noir', 'ru_name' => 'Черная Худи-Куртка С Поясом', 'link' => 'black-hooded-longline-coat-with-belt', 'attributes' => 'a:1:{s:4:"Size";a:2:{i:0;s:1:"M";i:1;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/151117.jpg'),
'CW0123' => array('id' => 56240, 'sku' => 'CW0123', 'name' => 'Black Double Breasted Plain Woolen Cape', 'de_name' => 'Schwarzes Zweireihig Cape', 'es_name' => 'Capa Lisa Doble Botonadura Negro', 'fr_name' => 'Cape Unie Croisé Noire ', 'ru_name' => 'Чёрная Двубортная Крылатка', 'link' => 'black-double-breasted-plain-cape', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/278905.jpg'),
'CWA356' => array('id' => 59608, 'sku' => 'CWA356', 'name' => 'Camel Drape Open Front Belted Waist Plain Trench Coat', 'de_name' => 'Kamelfarben Drapierte Geöffnete Vorderseite Taillengürtel Einfarbiges Trenchcoat', 'es_name' => 'Gabardina Liso Con Cinturón Color Camello', 'fr_name' => 'Trench Coat Uni Drapé Ouvert Sur Le Devant Ceinture Tressé Brun Clair', 'ru_name' => 'Верблюжее Открытый Назад Пыльник С Поясом', 'link' => 'camel-drape-open-front-belted-waist-plain-trench-coat', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/297970.jpg'),
'CWA359' => array('id' => 59605, 'sku' => 'CWA359', 'name' => 'Burgundy Lapel PU Panel Open Front Coat', 'de_name' => 'Burgunderrote Revers PU Gespleisste Offene Vorderseite Jacke', 'es_name' => 'Abrigo Dcon Solapas Con Panel De PU Color Vino', 'fr_name' => 'Manteau à Revers Panneau En PU Ouvert Sur Le Devant Bordeaux', 'ru_name' => 'Вино-красное Отложной Воротник PU Открытый Назад Пальто', 'link' => 'burgundy-lapel-pu-panel-open-front-coat', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/297981.jpg'),
'CW0113' => array('id' => 55915, 'sku' => 'CW0113', 'name' => 'Black Lapel Buckle Belt Hem PU Biker Jacket', 'de_name' => 'Schwarze-Revers Schnalle Stulpe PU Bikerjacke', 'es_name' => 'Chaqueta De PU Con Solapas Negro', 'fr_name' => 'Veste Motard Cuff En PU Boucle Empiècement Noir', 'ru_name' => 'Чёрный Отложной Вороник PU Пиджак', 'link' => 'black-lapel-buckle-belt-hem-pu-biker-jacket', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/289575.jpg'),
'CZZY4701' => array('id' => 32259, 'sku' => 'CZZY4701', 'name' => 'Black Wool Blend Cape Coat', 'de_name' => 'Schwarz Fledermaus Deckmantel', 'es_name' => 'Chaqueta Estilo Capa En Negro', 'fr_name' => 'Manteau Cape Noir', 'ru_name' => 'Черная Куртка', 'link' => 'black-bat-cape-coat', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/176301.jpg'),
'PYA2P1' => array('id' => 59219, 'sku' => 'PYA2P1', 'name' => 'Black Suedette Pleated Skirt', 'de_name' => 'Schwarzer Wildlederimitat Faltenrock', 'es_name' => 'Falda Plisada Antelina Negra', 'fr_name' => 'Jupe Plissée En Suédine Noire', 'ru_name' => 'Чёрная Замшевая Юбка', 'link' => 'black-suedette-pleated-skirt', 'attributes' => 'a:1:{s:4:"Size";a:2:{i:0;s:1:"S";i:1;s:1:"M";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/295917.jpg'),
'PYA2P2' => array('id' => 59218, 'sku' => 'PYA2P2', 'name' => 'Brown Suedette Pleated Skirt', 'de_name' => 'Brauner Wildlederimitat Faltenrock', 'es_name' => 'Falda Plisada Antelina Marrón', 'fr_name' => 'Jupe Plissée En Suédine Brune', 'ru_name' => 'КоричневаяЗамшевая Юбка', 'link' => 'brown-suedette-pleated-skirt', 'attributes' => 'a:1:{s:4:"Size";a:2:{i:0;s:1:"S";i:1;s:1:"M";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/295923.jpg'),
'CYA2P3' => array('id' => 59217, 'sku' => 'CYA2P3', 'name' => 'Black Contrast Ripe Banana Print Crop Sweatshirt', 'de_name' => 'Schwarzes Kontrast Reife Banane Druck Kurz Geschnittenes Sweatshirt', 'es_name' => 'Sudadera Corta Estampado De Banana Negra', 'fr_name' => 'Sweat-Shirt Court Imprimé Banane Contrastant Noir', 'ru_name' => 'Чёрная Толстовка С Рисунком Ванана', 'link' => 'black-contrast-ripe-banana-print-crop-sweatshirt', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/295924.jpg'),
'CYA2P4' => array('id' => 59216, 'sku' => 'CYA2P4', 'name' => 'Black Suedette Tassel Detail Plain Top', 'de_name' => 'Schwarzes Wildlederimitat Quasten Details Einfarbiges Oberteil', 'es_name' => 'Top Liso Antelina Detalle De Flecos Negro', 'fr_name' => 'Top Uni En Suédine Frange Détaillé Noir', 'ru_name' => 'Чёрный Замшевый Топ С Махрами', 'link' => 'black-suedette-tassel-detail-plain-top', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/295928.jpg'),
'CYA2P5' => array('id' => 59215, 'sku' => 'CYA2P5', 'name' => 'Lavender Suedette Tassel Detail Plain Top', 'de_name' => 'Lavendel Wildlederimitat Quasten Details Einfarbiges Oberteil', 'es_name' => 'Top Liso Antelina Detalle De Flecos Violeta', 'fr_name' => 'Top Uni En Suédine Frange Détaillé Lavande', 'ru_name' => 'Лаванда Замшевый Топ С Махрами', 'link' => 'lavender-suedette-tassel-detail-plain-top', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/295936.jpg'),
'CYA2P6' => array('id' => 59214, 'sku' => 'CYA2P6', 'name' => 'Apricot Suedette Tassel Detail Plain Top', 'de_name' => 'Aprikose Wildlederimitat Quasten Details Einfarbiges Oberteil', 'es_name' => 'Top Liso Antelina Detalle De Flecos Color De Albaricoque', 'fr_name' => 'Top Uni En Suédine Frange Détaillé Abricot ', 'ru_name' => 'Абрикосовый Замшевый Топ С Махрами', 'link' => 'apricot-suedette-tassel-detail-plain-top', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/295937.jpg'),
'CYA29J' => array('id' => 58815, 'sku' => 'CYA29J', 'name' => 'Purple Plunge Halter Ruched Mesh Panel Dress', 'de_name' => 'Lila Tief V Neckholder Rüschen Netz Verziertes Kleid', 'es_name' => 'Vestido Con Panel De Malla Escote Profundo Halter Fruncido Violeta', 'fr_name' => 'Robe à Décolleté Plongeant Panneau En Tulle Froncé Pourpre', 'ru_name' => 'Фиолетовое Глубокий V-образный Вырез Платье', 'link' => 'purple-plunge-halter-ruched-mesh-panel-dress', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/294297.jpg'),
'TWOP0717B082W' => array('id' => 49424, 'sku' => 'TWOP0717B082W', 'name' => 'Black Tile Print Short Sleeve Crop Top And Shorts', 'de_name' => 'Schwarzes Kachel Druck kurze Ärmel Bauchfreies Oberteil und Shorts', 'es_name' => 'Top Corto Manga Corta Estampado De Teja Negro Con Shorts', 'fr_name' => 'Top Court Imprimé Tuile Manche Courte Et Short Noir', 'ru_name' => 'Черный Топ С Коротким Рукавом И Шорты', 'link' => 'black-tile-print-short-sleeve-crop-top-and-shorts', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/267771.jpg'),
'CA0086' => array('id' => 50736, 'sku' => 'CA0086', 'name' => 'Green Lapel Long Sleeve Trench Coat', 'de_name' => 'Grüner Revers Lange Ärmel Trenchcoat', 'es_name' => 'Chaqueta Manga Larga Con Solapas Verde', 'fr_name' => 'Trench-Coat à Revers Manche Longue Vert ', 'ru_name' => 'Зеленая Тренч-Куртка', 'link' => 'green-lapel-long-sleeve-trench-coat', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/251073.jpg'),
'DRES1217A014P' => array('id' => 38969, 'sku' => 'DRES1217A014P', 'name' => 'Gray Short Sleeve Open Belly Dress', 'de_name' => 'Graues Kurzarm Offener Bauch Kleid', 'es_name' => 'Vestido Manga Corta Gris', 'fr_name' => 'Robe Manches Courtes à Ventre Ouvert -Gris', 'ru_name' => 'Серое Платье С Коротким Рукавом', 'link' => 'gray-short-sleeve-cut-out-slim-cut-dress', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/245186.jpg'),
'CW0093' => array('id' => 54789, 'sku' => 'CW0093', 'name' => 'Blue And White Stripe Mesh Panel Long Sleeve T-shirt', 'de_name' => 'Blaues und Weißes Streifen Netz Gespleisstes Langarm T-shirt', 'es_name' => 'Camiseta Manga Larga Con Panel De Malla A Rayas Azul Y Blanco', 'fr_name' => 'Blue And White Stripe Mesh Panel Long Sleeve T-shirt', 'ru_name' => 'Синяя И Белая Полосчатая Тенниска С Длинным Рукавом', 'link' => 'blue-and-white-stripe-mesh-panel-long-sleeve-t-shirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/274988.jpg'),
'PW0005' => array('id' => 53206, 'sku' => 'PW0005', 'name' => 'Red Split Side Zip Back Plain Pencil Skirt', 'de_name' => 'Roter Spaltung Seite Reißverschluss Rücken Bleistiftrock', 'es_name' => 'Falda Tubo Con Cremallera Rojo', 'fr_name' => 'Jupe Crayon Couleur Uni Zippée Avec Fente Sur Le Côté Rouge', 'ru_name' => 'Красная Юбка-карандаш С Разрезом С Молнием', 'link' => 'red-split-side-zip-back-plain-pencil-skirt', 'attributes' => 'a:1:{s:4:"Size";a:6:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";i:4;s:2:"12";i:5;s:2:"14";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/262637.jpg'),
'CW0012' => array('id' => 52830, 'sku' => 'CW0012', 'name' => 'Brown Suedette Split Front Pencil Skirt', 'de_name' => 'Brauner Suedette Spaltung Rücken Bleistiftrock', 'es_name' => 'Falda Tubo De Gamuza Marrón', 'fr_name' => 'Jupe Crayon Fendue En Suédé Brune', 'ru_name' => 'Коричневая Замшевая Карандаш-Юбка', 'link' => 'brown-suedette-split-front-pencil-skirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/260836.jpg'),
'BREA0323B010W' => array('id' => 41493, 'sku' => 'BREA0323B010W', 'name' => 'White V-neck Crochet Lace Scallop Hem Cami Crop Top', 'de_name' => 'Weißes Spaghetti Gurt Häkelnspitze Bauchfreies Trägertop', 'es_name' => 'Camisola De Encaje Cróche Blanco', 'fr_name' => 'Haut Court En Dentelle Crochetée à Bretelles -Blanc', 'ru_name' => 'Белая Кружевная Майка', 'link' => 'white-spaghetti-strap-lace-crochet-cropped-vest', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/247124.jpg'),
'CW0092' => array('id' => 54788, 'sku' => 'CW0092', 'name' => 'Black Lace Up Front Long Sleeve Knitted Bodysuit', 'de_name' => 'Schwarzer Schnürung vorne Langarm Gestrickter Bodysuit', 'es_name' => 'Body De Punto Manga Larga Con Cordónes Negro', 'fr_name' => 'Combinaison En Tricot Avec Laçage Sur Le Devant Manches Longues Noire ', 'ru_name' => 'Чёрная Вязаная Боди С Длинным Рукавом', 'link' => 'black-lace-up-front-long-sleeve-knitted-bodysuit', 'attributes' => 'a:1:{s:4:"Size";a:5:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";i:4;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/271062.jpg'),
'DRES0407B020W' => array('id' => 42106, 'sku' => 'DRES0407B020W', 'name' => 'White Cut Out Cold Shoulder Lace Trumpet Sleeve Spaghetti Strap Dress', 'de_name' => 'Weißes Ausgeschnittenes Kalte Schulter Spitze Trompete Ärmel Spaghetti Bügel Kleid', 'es_name' => 'Vestido Con Hombro Abierto Blanco', 'fr_name' => 'Robe à Bretelles Manches Trompette Épaules Dénudées -Blanc', 'ru_name' => 'Белое Кружевное Платье С Рукавом', 'link' => 'white-cut-out-cold-shoulder-lace-trumpet-sleeve-spaghetti-strap-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:2:"XS";i:1;s:1:"S";i:2;s:1:"M";i:3;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/245148.jpg'),
'VEST0731B094W' => array('id' => 50315, 'sku' => 'VEST0731B094W', 'name' => 'Black Spaghetti Strap V-neck Ruffle Wrap Cami', 'de_name' => 'Schwarzes Spaghettiträgern V-Ausschnitt Rüschen Wickel Trägertop', 'es_name' => 'Camisola Cruzada Cuello De Pico Correas De Espagueti Negro', 'fr_name' => 'Caraco Portefeuille Plissé Col V à Bretelle Noir', 'ru_name' => 'Черная Майка С Оборками', 'link' => 'black-spaghetti-strap-v-neck-ruffle-wrap-cami', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/248911.jpg'),
'SKIR0323B011W' => array('id' => 41494, 'sku' => 'SKIR0323B011W', 'name' => 'Black Polka Dot Sheer Midi Skater Skirt With Lining', 'de_name' => 'Schwarzer Tupfen Transparenter Midi Skater Rock mit Futter', 'es_name' => 'Falda Skater A Media Pierna A Lunares Con Forro Negro', 'fr_name' => 'Robe Patineuse à Pois Avec Doublure -Noir', 'ru_name' => 'Черное Миди Скейт-Юбка С Рисунком Горошков', 'link' => 'black-polka-dot-sheer-midi-skater-skirt-with-lining', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/208894.jpg'),
'TWOP0611B072W' => array('id' => 44757, 'sku' => 'TWOP0611B072W', 'name' => 'Purple Tile Print Short Sleeve Crop Top With Shorts', 'de_name' => 'Lila Fliese Druck kurze Ärmel Bauchfreies Oberteil mit Shorts', 'es_name' => 'Top Corto Manga Corta Estampado De porcelana Violeta Con Shorts', 'fr_name' => 'Top Imprimé Tuile Manche Courte Et Short -Violet', 'ru_name' => 'Фиолетовый Топ И Шорты', 'link' => 'purple-tile-print-short-sleeve-crop-top-with-shorts', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/222610.jpg'),
'DRES0609B071W' => array('id' => 44560, 'sku' => 'DRES0609B071W', 'name' => 'Royal Blue Cut Out Cold Shoulder Lace Trumpet Sleeve Spaghetti Strap Dress', 'de_name' => 'Königsblaues Cut Out Kalte Schulter Spitze Trompete Ärmeln Spaghetti Gurt Kleid', 'es_name' => 'Vestido Con Correas De Espagueti Hombro Abierta Manga Acampanada Azul Real', 'fr_name' => 'Robe Épaule Dénudée à Bretelle -Bleu Roi', 'ru_name' => 'Синее Кружевное Платье', 'link' => 'royal-blue-cut-out-cold-shoulder-lace-trumpet-sleeve-spaghetti-strap-dress', 'attributes' => 'a:1:{s:4:"Size";a:2:{i:0;s:1:"S";i:1;s:1:"M";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/221588.jpg'),
'CTGP0012' => array('id' => 28381, 'sku' => 'CTGP0012', 'name' => 'Monochrome Stripe Short Sleeve Crop Top', 'de_name' => 'Monochromes Streifen Kurzarm Bauchfreies Oberteil', 'es_name' => 'Top Corto Manga Corta A Raya Monocroma', 'fr_name' => 'Top Court à Rayures Manches Courtes -Monochrome', 'ru_name' => 'Монохромный Полосатый Топ С Коротким Рукавом', 'link' => 'black-stripe-loose-t-shirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/141899.jpg'),
'CW0051' => array('id' => 53469, 'sku' => 'CW0051', 'name' => 'White V-neck Applique Trims Flare Sleeve Dress', 'de_name' => 'Hellrosa V-Ausschnitt Spitze Blumen Verziertes Kleid', 'es_name' => 'Vestido Floral De Encaje Rosado Claro', 'fr_name' => 'Robe Bord Floral En Dentelle Col V Rose Pâle', 'ru_name' => 'Светло-розовое V-образный Вырез Кружевное Цветочное Платье', 'link' => 'white-v-neck-applique-trims-flare-sleeve-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/264225.jpg'),
'DRES0703B078W' => array('id' => 46748, 'sku' => 'DRES0703B078W', 'name' => 'Hot Pink Oversize Pom Pom Chiffon Poncho Cover Up Dress', 'de_name' => 'Heißes Rosa Übergrößes Pom Pom Chiffon Poncho Cover Up  Kleid', 'es_name' => 'Vestido Estilo Poncho de pompónes Rosa Intensa', 'fr_name' => 'Robe Tunique Poncho Large En Mousseline Avec Pompons Rose', 'ru_name' => 'Розовое Шифоновое Платье', 'link' => 'hot-pink-oversize-pom-pom-chiffon-poncho-cover-up-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/257064.jpg'),
'DRES0428B051W' => array('id' => 42647, 'sku' => 'DRES0428B051W', 'name' => 'Gray Hi-lo Twist Back Slit Side Sleeveless Dress', 'de_name' => 'Graues Hoch-Tief Twist Rücken Seitlicher Schlitz Ärmelloses Kleid', 'es_name' => 'Vestido Sin Manga Con Una Abertura Del Lado Gris', 'fr_name' => 'Robe Dos Torsadé Sans Manches Avec Fente Sur Le Côté -Gris', 'ru_name' => 'Серое Платье Без Рукава', 'link' => 'gray-hi-lo-twist-back-slit-side-sleeveless-dress', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/211323.jpg'),
'CW0107' => array('id' => 55911, 'sku' => 'CW0107', 'name' => 'White Pointed Collar Dip Back Semi-sheer Boyfriend Shirt', 'de_name' => 'Weißes spitzer Kragen Längerer Rückseite Halbtransparentes Freund Hemd', 'es_name' => 'Camisa Semi-Transparente Blanco', 'fr_name' => 'Chemise Boyfriend Dos Semi-Transparent Col Plongeant Pointu Blanc', 'ru_name' => 'Белая Рубашка С Острым Вороником', 'link' => 'white-pointed-collar-dip-back-semi-sheer-boyfriend-shirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/276798.jpg'),
'DRES0618B075W' => array('id' => 45376, 'sku' => 'DRES0618B075W', 'name' => 'Black Short Sleeve Open Belly Dress', 'de_name' => 'Schwarzes kurze Ärmeln Offener Bauch Kleid', 'es_name' => 'Vestido Manga Corta Negro', 'fr_name' => 'Robe Ventre Ouvert Manche Courte -Noir', 'ru_name' => 'Черное Платье С Коротким Рукавом', 'link' => 'black-short-sleeve-open-belly-dress', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/225501.jpg'),
'SKIR0327B015W' => array('id' => 41856, 'sku' => 'SKIR0327B015W', 'name' => 'White High Waist Split Wrap Maxi Skirt', 'de_name' => 'Weißer Hohe Taille Schlitz Wickeln Maxi Rock', 'es_name' => 'Falda Maxi Talle Alto Blanco', 'fr_name' => 'Maxi Jupe Taille Haute à Fente -Blanc', 'ru_name' => 'Белая Макси Юбка С Высокой Талией', 'link' => 'white-high-waist-slit-wrap-skirt', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/244556.jpg'),
'CW0003' => array('id' => 53138, 'sku' => 'CW0003', 'name' => 'White Keyhole Back Tie Cuff Ruched Blouse', 'de_name' => 'Weiße Schlüsselloch Rücken Schnür Stulpe Rüschen Bluse', 'es_name' => 'Blusa Espalda Con Agujero Lazo Puño Blanco', 'fr_name' => 'Blouse Plissée Manchette Nouée Blanche', 'ru_name' => 'Белая Блузка С Тройником С Манжетфми Оборков', 'link' => 'white-keyhole-back-tie-cuff-ruched-blouse', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/262547.jpg'),
'CTGP0025' => array('id' => 35338, 'sku' => 'CTGP0025', 'name' => 'Monochrome Halter Stripe Cut Away Wrap Crop Top', 'de_name' => 'Monochromes Wickeln Spaghetti Gurt Streifen Bauchfreies Oberteil', 'es_name' => 'Top Corto Con Correas De Espaguetis Monocromo', 'fr_name' => 'Top Court à Rayures Avec Bretelles -Monochrome', 'ru_name' => 'Монохромный Полсатый Топ', 'link' => 'black-and-white-stripe-crop-top', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/175647.jpg'),
'DRES0618B074W' => array('id' => 45375, 'sku' => 'DRES0618B074W', 'name' => 'White Short Sleeve Open Belly Dress', 'de_name' => 'Weißes kurze Ärmeln Offener Bauch Kleid', 'es_name' => 'Vestido Manga Corta Blanco', 'fr_name' => 'Robe Ventre Ouvert Manche Courte -Blanc ', 'ru_name' => 'Белое Платье С Коротким Рукавом', 'link' => 'white-short-sleeve-open-belly-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:2:"XS";i:1;s:1:"S";i:2;s:1:"M";i:3;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/225502.jpg'),
'DRES0803B098W' => array('id' => 53666, 'sku' => 'DRES0803B098W', 'name' => 'White Plunge Neck Sheer Embroidery 3/4 Sleeve Prom Dress', 'de_name' => 'Weißes Tief V Ausschnitt Transparent Stickerei Perle Taille Maxi Kleid', 'es_name' => 'Vestido Largo Bordado Con Joya Blanco', 'fr_name' => 'Robe Longue Décolletée Brodée Taille Ornée De Joyau Blanche', 'ru_name' => 'Белое Глубокий V-образный Вырез Макси Платье С Драгоценными Каменями', 'link' => 'white-plunge-neck-sheer-embroidery-3-4-sleeve-prom-dress', 'attributes' => 'a:1:{s:4:"Size";a:5:{i:0;s:1:"2";i:1;s:1:"4";i:2;s:1:"6";i:3;s:1:"8";i:4;s:2:"10";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/265298.jpg'),
'DRES0703B077W' => array('id' => 46747, 'sku' => 'DRES0703B077W', 'name' => 'Light Pink Oversize Pom Pom Chiffon Poncho Cover Up Dress', 'de_name' => 'Hellrosa Übergrößes Pom Pom Chiffon Poncho Cover Up Kleid', 'es_name' => 'Vestido Estilo Poncho de pompónes Rosa Claro', 'fr_name' => 'Robe Tunique Poncho Large En Mousseline Avec Pompons Rose Pâle', 'ru_name' => 'Светло-Розовое Шифоновое Платье', 'link' => 'light-pink-oversize-pom-pom-chiffon-poncho-cover-up-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/264438.jpg'),
'CW0002' => array('id' => 53137, 'sku' => 'CW0002', 'name' => 'Fire Brick Keyhole Back Tie Cuff Ruched Blouse', 'de_name' => 'Braune Schlüsselloch Rücken Schnür Stulpe Rüschen Bluse', 'es_name' => 'Blusa Espalda Con Agujero Lazo Puño Marrón', 'fr_name' => 'Blouse Plissée Manchette Nouée Brune', 'ru_name' => 'Серая Блузка С Тройником С Манжетфми Оборков', 'link' => 'fire-brick-keyhole-back-tie-cuff-ruched-blouse', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/281839.jpg'),
'BLOU1217A013P' => array('id' => 38970, 'sku' => 'BLOU1217A013P', 'name' => 'Floral Off Shoulder Flare Sleeve Chiffon Blouse', 'de_name' => 'Blumen Schulterfreie Aufflackernhülse Chiffon Bluse', 'es_name' => 'Blusa De Gasa Hombro Descubierto Floral Mangas Acampanadas', 'fr_name' => 'Blouse En Mousseline Imprimée Floral Épaules Dénudées Manches Volantées', 'ru_name' => 'Шифоновая Блузка С Рисунком Цветов', 'link' => 'multicolor-floral-off-shoulder-batwing-sleeve-blouse', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/195161.jpg'),
'CW0037' => array('id' => 53460, 'sku' => 'CW0037', 'name' => 'Gray Multi Ways Twist Detail Open Back Bodysuit', 'de_name' => 'Grauer Mehr Wege Twist Details Geöffnetee Rücken Bodysuit', 'es_name' => 'Corsé Detalle Torcido Espalda Abierta Gris', 'fr_name' => 'Combinaison Dos Ouvert Détail Torsade Grise', 'ru_name' => 'Серая Оголяющая Спину Многофосонная Боди С Бантом', 'link' => 'gray-multi-ways-twist-detail-open-back-bodysuit', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/264327.jpg'),
'CW0039' => array('id' => 53462, 'sku' => 'CW0039', 'name' => 'Black Plunge Neck Backless Lined Lace Split Maxi Dress', 'de_name' => 'Schwarzes Tief V Ausschnitt Rückenfreies Gefütterte Spitze Spaltung Maxikleid', 'es_name' => 'Vestido Largo De Encaje Sin Espalda Negro', 'fr_name' => 'Robe Longue Fendue En Dentelle Décolletée Dos Nu Avec Doublure Noire', 'ru_name' => 'Чёрное Глубокий V-образный Вырез Платье С Разрезом Без Спиной', 'link' => 'black-plunge-neck-backless-lined-lace-split-maxi-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/264285.jpg'),
'DRES0511B065W' => array('id' => 43532, 'sku' => 'DRES0511B065W', 'name' => 'Monochrome Stripe Slit Side Sleeveless Maxi Dress', 'de_name' => 'Monochromes Streifen Druck Ärmelloses Seitlicher Schlitz Maxikleid', 'es_name' => 'Vestido Largo Sin Manga A Rayas Monocromas', 'fr_name' => 'Maxi Robe Fendue à Rayures Sans Manche -Monochrome', 'ru_name' => 'Монохромное Полосатое Макси Платье Без Рукава', 'link' => 'monochrome-stripe-slit-side-sleeveless-maxi-dress', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/242740.jpg'),
'CW0040' => array('id' => 53463, 'sku' => 'CW0040', 'name' => 'White Plunge Neck Backless Lined Lace Split Maxi Dress', 'de_name' => 'Weißes Tief V Ausschnitt Rückenfreies Gefütterte Spitze Spaltung Maxikleid', 'es_name' => 'Vestido Largo De Encaje Sin Espalda Blanco', 'fr_name' => 'Robe Longue Fendue En Dentelle Décolletée Dos Nu Avec Doublure Blanche', 'ru_name' => 'Белое Глубокий V-образный Вырез Платье С Разрезом Без Спиной', 'link' => 'white-plunge-neck-backless-lined-lace-split-maxi-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/264299.jpg'),
'BREA0408B023W' => array('id' => 41685, 'sku' => 'BREA0408B023W', 'name' => 'White Button Front Lace Soft Triangle Bra', 'de_name' => 'Weißer Spaghetti Gurt Knopf Vorderseite Spitze BH', 'es_name' => 'Sujetador De Encaje Con Correa De Espaguetis Blanco', 'fr_name' => 'Soutien-Gorge En Dentelle à Bretelles Avec Boutons -Blanc', 'ru_name' => 'Белый Кружевной Бюстгальтер', 'link' => 'white-spaghetti-strap-lace-bra', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:2:"XS";i:1;s:1:"S";i:2;s:1:"M";i:3;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/244914.jpg'),
'CW0027' => array('id' => 53458, 'sku' => 'CW0027', 'name' => 'White Crochet Trims Flare Sleeve Crop Top', 'de_name' => 'Weißes Häkeln Verziertes Trompete Ärmel Bauchfreies Oberteil', 'es_name' => 'Top Corto Manga Acampanada Adorno De Croché Blanco', 'fr_name' => 'Top Court Bordure En Crochet Manche Évasée Blanc', 'ru_name' => 'Белая Вязальная Кофта С Рукавом', 'link' => 'white-crochet-trims-flare-sleeve-crop-top', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/264338.jpg'),
'CW0068' => array('id' => 54906, 'sku' => 'CW0068', 'name' => 'Monochrome Striped Short Sleeve Shift Dress', 'de_name' => 'Monochromes Gestreiftes Kurze Ärmel Etuikleid', 'es_name' => 'Vestido Suelto Manga Corta A Rayas Monocromático', 'fr_name' => 'Monochrome Striped Short Sleeve Shift Dress', 'ru_name' => 'Чёрно-белое Полосчатое Рубашка Платье С Коротким Рукавом', 'link' => 'monochrome-striped-short-sleeve-shift-dress-1', 'attributes' => 'a:1:{s:4:"Size";a:5:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";i:4;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/271708.jpg'),
'PW0048' => array('id' => 53478, 'sku' => 'PW0048', 'name' => 'Fushia High Waist Plain Slit Side Lined Maxi Skirt', 'de_name' => 'Lila Hohe Taille Schlitz Seite Maxirock', 'es_name' => 'Falda Larga Talle Alto Con Abertura Del Lado Violeta', 'fr_name' => 'Jupe Longue Couleur Uni Taille Haute Avec Fente Sur Le Côté Violette', 'ru_name' => 'Фиолетовая Высоко-поясная Макси Юбка С Разрезом Сбоку', 'link' => 'purple-high-waist-plain-slit-side-lined-maxi-skirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/292688.jpg'),
'CW0095' => array('id' => 54791, 'sku' => 'CW0095', 'name' => 'White High Neck Cut Out Detail Belle Sleeve Dress', 'de_name' => 'Weißes Hoher Ausschnitt Cut Out Detail  Kleid', 'es_name' => 'Vestido Cuello Alto Detalle De Abertura Blanco', 'fr_name' => 'White High Neck Cut Out Detail Belle Sleeve Dress', 'ru_name' => 'Белое Высоко-вороник Платье С Разрезом', 'link' => 'white-high-neck-cut-out-detail-belle-sleeve-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/271045.jpg'),
'CW0086' => array('id' => 53205, 'sku' => 'CW0086', 'name' => 'Color Block Folk Print Lace Up Open Back Maxi Dress', 'de_name' => 'Farbblock Blumen Schnüren Vorne Trompete Ärmel Maxikleid', 'es_name' => 'Vestido Largo Manga Acampanada Con Cordónes Floral Color Bloque', 'fr_name' => 'Robe Longue Motif Floral Manche Évasée à Lacets Effet Bloc De Couleur', 'ru_name' => ' Макси Платье С Мозаичном Рисунком С Рупорным Рукавом', 'link' => 'color-block-folk-print-lace-up-open-back-maxi-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/262641.jpg'),
'CWA1ZM' => array('id' => 58427, 'sku' => 'CWA1ZM', 'name' => 'Black Collarless Asymmetric Fluffy Faux Fur Coat', 'de_name' => 'Schwarze Kragenlose Asymmetrische Flaumige Kunstpelz Jacke', 'es_name' => 'Abrigo De Pelo Sintético Mullido Asimétrico Negro', 'fr_name' => 'Manteau En Faux Cuir Asymétrique Duveteux Sans Col Noir', 'ru_name' => 'Чёрное Асимметричное Пальто Исскуственного Меха Без Воротника', 'link' => 'black-collarless-asymmetric-fluffy-faux-fur-coat', 'attributes' => 'a:1:{s:4:"Size";a:5:{i:0;s:2:"XS";i:1;s:1:"S";i:2;s:1:"M";i:3;s:1:"L";i:4;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/303674.jpg'),
'TSHI0114B050P' => array('id' => 40221, 'sku' => 'TSHI0114B050P', 'name' => 'Monochrome Stripe Short Sleeve Dipped Hem T-shirt', 'de_name' => 'Schwarzes und Weißes Streifen Kurzarm T-Shirt', 'es_name' => 'Camiseta Manga Corta A Rayas Negro Y Blanco', 'fr_name' => 'T-Shirt Manches Courtes à Rayures Blanches Et Noires', 'ru_name' => 'Черная И Белая Полосатая Футболка С Коротким Рукавом', 'link' => 'black-and-white-stripes-short-sleeve-t-shirt', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/283328.jpg'),
'CW0069' => array('id' => 53777, 'sku' => 'CW0069', 'name' => 'Monochrome Stripe Wrap Cut Out Back Bodycon Dress', 'de_name' => 'Monochromes Streifen Wickel Rückenausschnitt Figurbetontes Kleid', 'es_name' => 'Vestido Ajustado Espalda Con Abertura A Rayas Monocromáticas', 'fr_name' => 'Robe Moulante à Rayures Dos Découpé Monochrome', 'ru_name' => 'Чёрно-белое Полосчатое Нижнее Платье С Разрезом Спины', 'link' => 'monochrome-stripe-wrap-cut-out-back-bodycon-dress', 'attributes' => 'a:1:{s:4:"Size";a:5:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";i:4;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/265834.jpg'),
'CWA2BV' => array('id' => 58844, 'sku' => 'CWA2BV', 'name' => 'Rose Patch Elbow Sequin Detail Long Sleeve Waterfall Cardigan', 'de_name' => 'Rose Flecken Ellenbogen Pailletten Detail Langarm Wasserfall Strickjacke', 'es_name' => 'Cardigan Detalle De Lentejuela Delantera Forma De Cascada Color Rosa', 'fr_name' => 'Cardigan à Drapé Effet Cascade Manches Longues Avec Empiècement Rose', 'ru_name' => 'Розовый Блесткий Кардиган С Длинным Рукавом', 'link' => 'rose-patch-elbow-sequin-detail-long-sleeve-waterfall-cardigan', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/297179.jpg'),
'PW0041' => array('id' => 53477, 'sku' => 'PW0041', 'name' => 'Gray Suedette Split Front Pencil Skirt', 'de_name' => 'Grauer Wildlederimitat Spaltung Vorderseite Bleistiftrock', 'es_name' => 'Falda Tubo De Gamuza Gris', 'fr_name' => 'Jupe Crayon Couleur Uni En Suédé Grise', 'ru_name' => 'Серая Замшевая Юбка-карандаш С Разрезом', 'link' => 'gray-suedette-split-front-pencil-skirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/264180.jpg'),
'DRES0408B026W' => array('id' => 42156, 'sku' => 'DRES0408B026W', 'name' => 'Beige Bow Embellished Back Two-layer Spaghetti Strap Dress', 'de_name' => 'Aprikose Schleife Verschönertes Rücken Zweischichtiges Spaghetti Bügel Kleid', 'es_name' => 'Vestido Con Correas De Espaguetis De Color Albaricoque', 'fr_name' => 'Robe à Bretelles Avec Double Superposition Et Nœud Au Dos -Abricot ', 'ru_name' => 'Абрикосовое Платье', 'link' => 'beige-bow-embellished-back-two-layer-spaghetti-strap-dress', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/209144.jpg'),
'CROP0128B079P' => array('id' => 41386, 'sku' => 'CROP0128B079P', 'name' => 'White High Neck Long Sleeve Cropped T-shirt', 'de_name' => 'Weißes Hoher Kragen Langarm Bauchfreies T-Shirt', 'es_name' => 'Camiseta Corta Cuello Alto Blanco', 'fr_name' => 'T-Shirt Court Col Haut Manches Longues -Blanc', 'ru_name' => '', 'link' => 'white-high-neck-long-sleeve-cropped-t-shirt', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/205986.jpg'),
'DRES0413B102P' => array('id' => 41855, 'sku' => 'DRES0413B102P', 'name' => 'Monochrome Stripe Open Belly Dress', 'de_name' => 'Monochromes Streifen Offener Bauch Kleid', 'es_name' => 'Vesitdo A Raya Monocroma', 'fr_name' => 'Robe à Rayures Avec Ventre Ouvert -Monochrome', 'ru_name' => 'Монохромное Полосатое Платье', 'link' => 'black-and-white-stripe-cut-out-dress', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/244905.jpg'),
'CW0023' => array('id' => 53199, 'sku' => 'CW0023', 'name' => 'Light Khaki Lace Panel Flare Sleeve Draped Back Dress', 'de_name' => 'Hell Khaki Spitze Gespleisstes Trompete Ärmel Drapierter Rücken Kleid', 'es_name' => 'Vestido Con Panel De Encaje Manga Acampanada Caqui Claro', 'fr_name' => 'Robe Empiècement Dentelle Manche Évasée Dos Drapée Kaki Claire', 'ru_name' => 'Светло-хаки  Кружевное Платье С Рупорным Рукавом', 'link' => 'light-khaki-lace-panel-flare-sleeve-draped-back-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/286085.jpg'),
'BLOU0407B021W' => array('id' => 41981, 'sku' => 'BLOU0407B021W', 'name' => 'Pale Turquoise Off Shoulder Bubble Sleeve Blouse', 'de_name' => 'Türkis Schulterfreie Blase Ärmel Bluse', 'es_name' => 'Blusa Hombro Descubierto De Color Turquesa', 'fr_name' => 'Blouse Manches Bouffantes Épaules Dénudées -Turquoise', 'ru_name' => 'Блузка С Рукавом С Открытыми Плечами', 'link' => 'pale-turquoise-off-shoulder-bubble-sleeve-blouse', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/243117.jpg'),
'CW0099' => array('id' => 55765, 'sku' => 'CW0099', 'name' => 'Dark Gray Suedette Laser Cut Tasseled Hem Vest', 'de_name' => 'Dunkelgraue Wildlederimitat Laser Geschnittene Quasten Saum Weste', 'es_name' => 'Chaleco De Antelina De Flecos Gris Oscuro', 'fr_name' => 'Gilet En Suédine Ourlet Gland Découpé Laser Gris Foncé ', 'ru_name' => 'Темно-серая Замшевая Майка С Махрами', 'link' => 'dark-gray-suedette-laser-cut-tasseled-hem-vest', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/275976.jpg'),
'PW0049' => array('id' => 53479, 'sku' => 'PW0049', 'name' => 'Blue High Waist Plain Slit Side Lined Maxi Skirt', 'de_name' => 'Blauer Hohe Taille Schlitz Seite Maxirock', 'es_name' => 'Falda Larga Talle Alto Con Abertura Del Lado Azul', 'fr_name' => 'Jupe Longue Couleur Uni Taille Haute Avec Fente Sur Le Côté Bleue', 'ru_name' => 'Синяя Высоко-поясная Макси Юбка С Разрезом Сбоку', 'link' => 'blue-high-waist-plain-slit-side-lined-maxi-skirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"6";i:1;s:1:"8";i:2;s:2:"10";i:3;s:2:"12";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/264178.jpg'),
'VEST0422B045W' => array('id' => 42360, 'sku' => 'VEST0422B045W', 'name' => 'White Strappy Back Lattice Fringe Tassel Vest', 'de_name' => 'Weiße Rückenfreie mit Franse Quaste Gitter Weste', 'es_name' => 'Chaleco Con Flecos Sin Espalda Blanca', 'fr_name' => 'Débardeur à Glands Dos Nu -Blanc', 'ru_name' => 'Белая Майка С Кистями С Открытой Спиной', 'link' => 'white-strappy-back-lattice-fringe-tassel-vest', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/210054.jpg'),
'PW0066' => array('id' => 54684, 'sku' => 'PW0066', 'name' => 'Red Bowknot Waist Pleat Detail Skater Skirt', 'de_name' => 'Roter Schleife Taille Faltendetail Skater Rock', 'es_name' => 'Falda Skater Detalle De Pliegue Con Pajarita Rojo', 'fr_name' => 'Red Bowknot Waist Pleat Detail Skater Skirt', 'ru_name' => 'Красная Юбка С Бантом С Поясом', 'link' => 'red-bowknot-waist-pleat-detail-skater-skirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/300598.jpg'),
'SKIR0409B031W' => array('id' => 41982, 'sku' => 'SKIR0409B031W', 'name' => 'Yellow Bowknot Front Pleat Midi Skirt', 'de_name' => 'Orange Schleife Vorderseite Faltenmidirock', 'es_name' => 'Falda A Media Pierna Con Pajarita Naranjada', 'fr_name' => 'Jupe Mi-Longue Plissée Avec Nœud Papillon -Orange ', 'ru_name' => 'Оранжевая Миди Юбка С Бантом', 'link' => 'orange-front-bowknot-pleat-midi-skirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/208310.jpg'),
'PW0009' => array('id' => 53208, 'sku' => 'PW0009', 'name' => 'Black Textured PU Asymmetric Fringed Skirt', 'de_name' => 'Schwarzer Strukturierter PU Asymmetrischer Fransen Rock', 'es_name' => 'Falda Asimétrica Texturada PU De Flecos Negro', 'fr_name' => 'Jupe Asymétrique Frangée En PU Texturée Noire', 'ru_name' => 'Чёрная Блесткая PU Асимметричная Юбка С Бахромой', 'link' => 'black-textured-pu-asymmetric-fringed-skirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/262623.jpg'),
'VEST0717B080W' => array('id' => 48580, 'sku' => 'VEST0717B080W', 'name' => 'Black Wrap Spaghetti Strap Cross Back Bodysuit', 'de_name' => 'Schwarzer Wickeln Spaghettiträgern Kreuz Rücken Strampler', 'es_name' => 'Corsé Correas De Espagueti Espalda Cruzada Negro', 'fr_name' => 'Combinaison Portefeuille Dos Croisé à Bretelle Noire', 'ru_name' => 'Черное Боди', 'link' => 'black-wrap-spaghetti-strap-cross-back-bodysuit', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/240159.jpg'),
'TWOP0426B300A' => array('id' => 42394, 'sku' => 'TWOP0426B300A', 'name' => 'Blue Tile Print Short Sleeve Crop Top And Shorts', 'de_name' => 'Blaues Fliese Druck Kurzarm Bauchfreies Oberteil mit Shorts', 'es_name' => 'Top Corto Manga Corta Estampado De porcelana Azul', 'fr_name' => 'Top Imprimé Tuile Manches Courtes Avec Short -Bleu', 'ru_name' => 'Синий Топ С Коротким Рукавом И Шорты', 'link' => 'blue-tile-print-short-sleeve-crop-top-with-shorts', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/247107.jpg'),
'VEST0421B268A' => array('id' => 42089, 'sku' => 'VEST0421B268A', 'name' => 'White Wrap Spaghetti Strap Cross Back Bodysuit', 'de_name' => 'Weiß Wickeln Spaghetti Bügel Kreuz Rücken Bodysuit', 'es_name' => 'Corsé Espalda Abierta Blanca', 'fr_name' => 'Combinaison à Bretelles Croisées Au Dos -Blanc', 'ru_name' => 'White Wrap Spaghetti Strap Cross Back Bodysuit ', 'link' => 'white-wrap-spaghetti-strap-cross-back-bodysuit', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/240177.jpg'),
'CW0083' => array('id' => 53143, 'sku' => 'CW0083', 'name' => 'Gray Wrap Front Long Sleeve Plain Bodysuit', 'de_name' => 'Grauer Wickel Vorderseite Langarm Bodysuit', 'es_name' => 'Corsé Manga Larga Delantera Cruzada Gris', 'fr_name' => 'Combinaison Couleur Uni Manche Longue Grise', 'ru_name' => 'Серая Сиамская Боди С Длинным Рукавом ', 'link' => 'gray-wrap-front-long-sleeve-plain-bodysuit', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/262530.jpg'),
'CDGP0031' => array('id' => 33676, 'sku' => 'CDGP0031', 'name' => 'Choies Design Stripe Bodycon Off Shoulder Dress With Long Sleeves', 'de_name' => 'Choies Design Streifen Figurbetontes Schulterfreies Kleid', 'es_name' => 'Vestido Ajustado De Hombro Descubierto A Rayas De Choies Diseño', 'fr_name' => 'Robe Moulante à Rayures Avec Épaules Dénudées Choies', 'ru_name' => 'Choies Design Полосатое Облегающее Платье С Длинным Рукавом', 'link' => 'choies-design-stripe-bodycon-off-shoulder-dress-with-long-sleeves', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/168062.jpg'),
'TWOP0122B209A' => array('id' => 40063, 'sku' => 'TWOP0122B209A', 'name' => 'Monochrome Chevron Print Crop Top And High Waist Shorts', 'de_name' => 'Monochromes Zickzack Druck Bauchfreies Oberteil und Hohe Taille Shorts', 'es_name' => 'Top Corto Monocromo Con Pantalones Cortos Talle Alto', 'fr_name' => 'Top Court Imprimé Chevron Et Short Taille Haute -Monochrome', 'ru_name' => 'Монохромный Топ И Шорты', 'link' => 'black-wave-print-crop-top-and-high-waist-shorts-two-piece-suit', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/245129.jpg'),
'CDZY2855' => array('id' => 22102, 'sku' => 'CDZY2855', 'name' => 'White Splash Print Shirt Collar Maxi Dress', 'de_name' => 'Weißes Spritzer Druck Hemdkragen Maxikleid', 'es_name' => 'Vestido Maxi Estampado Blanco', 'fr_name' => 'Maxi Robe Imprimée Éclaboussure Col Chemise -Blanc', 'ru_name' => 'Белое Макси Платье С Синим Рисунком', 'link' => 'choies-limited-edition-let-s-wander-maxi-dress', 'attributes' => 'a:1:{s:4:"Size";a:5:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";i:4;s:3:"XXL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/245131.jpg'),
'CWA1EM' => array('id' => 57919, 'sku' => 'CWA1EM', 'name' => 'Beige Suedette Laser Cut Asymmetric Fringed Cape', 'de_name' => 'Beige Wildlederimitat Laser Geschnittener Asymmetrischer Fransen Cape', 'es_name' => 'Capa Asimétrica Antelina De Flecos Laser Corte Beige', 'fr_name' => 'Cape Frangé Asymétrique En Suédine Beige', 'ru_name' => 'Бежевая Замшевая Асимметричная Шаль', 'link' => 'beige-floral-cut-out-asymmetric-fringe-tasseled-kimono', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/288392.jpg'),
'SKIR0122B204A' => array('id' => 40058, 'sku' => 'SKIR0122B204A', 'name' => 'Peach Pink High Waist Midi Skater Skirt', 'de_name' => 'Pfirsichrosa Hohe Taille Midi Skater Rock', 'es_name' => 'Falda Skater A Media Pierna Talle Alto Rosado', 'fr_name' => 'Jupe Patineuse Taille Haute -Pêche', 'ru_name' => 'Розовая Миди Скейт-Юбка', 'link' => 'peach-pink-high-waist-midi-skirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/244537.jpg'),
'CSZY4476' => array('id' => 30481, 'sku' => 'CSZY4476', 'name' => 'Rosey Brown Crochet Lace Panel Long Sleeve Blouse', 'de_name' => 'Rosey Braune Häkelspitze Gespleisste Langarm Bluse', 'es_name' => 'Blusa Manga Larga Con Panel De Encaje Rosa Gris', 'fr_name' => 'Blouse Manches Longues à Panneau En Dentelle Crochetée -Rose Foncé', 'ru_name' => 'Розово-Коричневая Кружевная Блузка С Длинным Рукавом', 'link' => 'bisque-lace-panel-blouse', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/245195.jpg'),
'CWA1EK' => array('id' => 57921, 'sku' => 'CWA1EK', 'name' => 'Brown Suedette Laser Cut Asymmetric Fringed Cape', 'de_name' => 'Brauner Wildlederimitat Laser Geschnittener Asymmetrischer Fransen Cape', 'es_name' => 'Capa Asimétrica Antelina De Flecos Laser Cortemarrón', 'fr_name' => 'Cape Frangé Asymétrique En Suédine Brune', 'ru_name' => 'Коричневая Замшевая Асимметричная Шаль', 'link' => 'coffee-floral-cut-out-asymmetric-fringe-tasseled-kimono', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/288370.jpg'),
'CKYY1128' => array('id' => 27077, 'sku' => 'CKYY1128', 'name' => 'Black Sakura Print High Waist Pleated Midi Skater Skirt', 'de_name' => 'Schwarzer Kirschblüte Druck Seide Midi Skater Rock', 'es_name' => 'Falda Skater A Media Pierna Estampado Ed Sakura Negra', 'fr_name' => 'Jupe Mi-Longue Patineuse Soyeuse Imprimée Sakura -Noir', 'ru_name' => 'Черная Миди Скейт-Юбка С Рисунком Сакур', 'link' => 'black-sakura-skater-skirt-with-pleat', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/211853.jpg'),
'CIZY4394' => array('id' => 29456, 'sku' => 'CIZY4394', 'name' => 'White Floral Print Long Sleeve Romper Playsuit', 'de_name' => 'Blumendruck Lange Ärmeln Romper Overall', 'es_name' => 'Mono Corto De Manga Larga Floral', 'fr_name' => 'Combishort Imprimé Fleurs Manches Longues', 'ru_name' => 'Комбинезон С Рисунком Цветов С Длинным Рукавом Подсолнечников', 'link' => 'floral-print-long-sleeves-romper-playsuit', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/247120.jpg'),
'CDXF2595' => array('id' => 27944, 'sku' => 'CDXF2595', 'name' => 'Black Sheer Panel Shift Dress', 'de_name' => 'Schwarzes Transparent Gespleisstes Etuikleid', 'es_name' => 'Vestido Recto Con Panel Transparente Negro', 'fr_name' => 'Robe Droite Avec Panneau Transparent -Noir', 'ru_name' => 'Черное Платье', 'link' => 'black-shift-dress-with-contrast-mesh-panel', 'attributes' => 'a:1:{s:4:"Size";a:6:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";i:4;s:3:"XXL";i:5;s:4:"XXXL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/118341.jpg'),
'CDZY4383' => array('id' => 29413, 'sku' => 'CDZY4383', 'name' => 'White Slit Sleeve Chiffon Hi-Lo Dress', 'de_name' => 'Weißes Rutsch Ärmel Chiffon Hoch-Niedrig Kleid', 'es_name' => 'Vestido De Gasa Estilo Alto-Bajo Blanco', 'fr_name' => 'Robe Asymétrique En Mousseline Manches Fendue -Blanc', 'ru_name' => 'Белое Шифоновое Платье', 'link' => 'white-chiffon-shift-dress-with-slip-sleeves', 'attributes' => 'a:1:{s:4:"Size";a:5:{i:0;s:2:"XS";i:1;s:1:"S";i:2;s:1:"M";i:3;s:1:"L";i:4;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/228761.jpg'),
'CPZY2683' => array('id' => 21262, 'sku' => 'CPZY2683', 'name' => 'Black Plunge Neck Long Sleeve Romper Playsuit', 'de_name' => 'Schwarzer Tief V Langarm Romper Overall', 'es_name' => 'Mono Corto Manga Larga Escote Pronunciado Negro', 'fr_name' => 'Combishort Col V Manches Courtes -Noir', 'ru_name' => 'Черный Комбинезон С Длинным Рукавом', 'link' => 'black-long-sleeves-playsuit', 'attributes' => 'a:1:{s:4:"Size";a:6:{i:0;s:2:"XS";i:1;s:1:"S";i:2;s:1:"M";i:3;s:1:"L";i:4;s:2:"XL";i:5;s:3:"XXL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/245105.jpg'),
'CPXF2255' => array('id' => 24812, 'sku' => 'CPXF2255', 'name' => 'Black Skinny Ripped Distressed Jeans', 'de_name' => 'Schwarze Enge Zerrissene Jeans mit Distressed-Stil', 'es_name' => 'Vaqueros Con Rasgón Negro', 'fr_name' => 'Jean Skinny Déchiré -Noir', 'ru_name' => 'Черные Тонкие Джинсы', 'link' => 'black-skinny-jeans-with-ripped-leg', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/140594.jpg'),
'CSPY0884' => array('id' => 29344, 'sku' => 'CSPY0884', 'name' => 'Light Blue Stripe Tie Waist Peplum Blouse', 'de_name' => 'Hellblaue Streifen Schnürung Taille Schößchen Bluse', 'es_name' => 'Blusa Sobrefalda A Raya Azul Claro', 'fr_name' => 'Blouse Péplum à Rayures Avec Cordon à La Taille -Bleu Clair', 'ru_name' => 'Светло-Синяя Полосатая Блузка', 'link' => 'light-blue-stripe-peplum-blouse', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/213427.jpg'),
'DRES0506B201K' => array('id' => 42921, 'sku' => 'DRES0506B201K', 'name' => 'White Floral Print Cut Away Midi Bodycon Dress', 'de_name' => 'Weißes Retro Blumen Weggeschnittenes Midi Figurbetontes Kleid', 'es_name' => 'Vestido Ajustado A Media Pierna Floral Retro Blanco', 'fr_name' => 'Robe Moulante Découpée Imprimée Floral -Blanc', 'ru_name' => 'Белое Облегающее Платье С Рисунком Цветов', 'link' => 'white-retro-floral-cut-away-midi-bodycon-dress', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/243678.jpg'),
'CIZY4413' => array('id' => 29812, 'sku' => 'CIZY4413', 'name' => 'White Floral Print Wrap Front Sleeveless Romper Playsuit', 'de_name' => 'Fleld Tage Blumendruck Ärmellos Romper Overall', 'es_name' => 'Mono Corto Sin Mangas Floral', 'fr_name' => 'Combishort à Imprimé Floral Sans Manches', 'ru_name' => 'Комбинезон С Рисунком Цветов Без Рукава', 'link' => 'fleld-days-floral-print-sleeveless-romper-playsuit', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/206716.jpg'),
'CK0805' => array('id' => 54089, 'sku' => 'CK0805', 'name' => 'Monochrome Stripe Pu Panel Open Front Coat', 'de_name' => 'Monochrome Streifen PU Gespleisste Geöffnete Vorderseite Jacke', 'es_name' => 'Chaqueta Con Panel De PU A Rayas Monocromático', 'fr_name' => 'Manteau Rayures Monochrome Pu Panneau', 'ru_name' => 'Чёрно-белое Полосчатое Пальто С Разрезом Вперёд', 'link' => 'monochrome-stripe-pu-panel-open-front-coat', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/267628.jpg'),
'CSZY4748' => array('id' => 31922, 'sku' => 'CSZY4748', 'name' => 'White Twist Front Long Sleeves Crop Top', 'de_name' => 'Weißes verdrehter Vorderseite Lange Ärmel Bauchfreies Oberteil', 'es_name' => 'Top Corto Manga Larga La Parte Delantero Retorcido Blanco', 'fr_name' => 'Top Torsadé à l\'Avant Manches Courtes -Blanc', 'ru_name' => 'Белый Топ С Длинным Рукавом', 'link' => 'white-cross-long-sleeves-blouse', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/286749.jpg'),
'CK0018' => array('id' => 50771, 'sku' => 'CK0018', 'name' => 'Pink Open Back Two-layer Scallop Trims Blouse', 'de_name' => 'Rosa Geöffneter Rücken Zweischicht Jakobsmuschel Bluse', 'es_name' => 'Blusa Doble Capa Espalda Abierta Rosado', 'fr_name' => 'Blouse Double Superposition Dos Ouvert Bord Festonné Rose Pâle ', 'ru_name' => 'Розовая Блузка', 'link' => 'pink-open-back-two-layer-scallop-trims-blouse', 'attributes' => 'a:1:{s:4:"Size";a:5:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";i:4;s:3:"XXL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/251122.jpg'),
'CSZY0868' => array('id' => 13742, 'sku' => 'CSZY0868', 'name' => 'White Crochet Lace Panel Blouse', 'de_name' => 'Weiße Bluse Mit Geschnürtern auf den Schultern', 'es_name' => 'Blusa Blanca En Hueco Hombro', 'fr_name' => 'Blouse Blanche Avec Épaules En Dentelle', 'ru_name' => 'Белая Блузка С Кружевом', 'link' => 'white-blouse-in-lack-on-shoulders', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/188866.jpg'),
'CDZY4591' => array('id' => 31427, 'sku' => 'CDZY4591', 'name' => 'Blue Stripe 3/4 Sleeve Elastic Waist Silky Maxi Dress', 'de_name' => 'Blaues Streifen 3/4 Ärmel Elastische Taille Seidiges Maxi Kleid', 'es_name' => 'Vestido Maxi Cintura Elastica De Manga 3/4 Azul', 'fr_name' => 'Maxi Robe Soyeuse à Rayures Taille Élastique Manches 3/4 -Bleu', 'ru_name' => 'Синее Полосатое Макси Платье С Рукавом 3/4', 'link' => 'choies-limited-edition-blue-stripe-long-sleeves-maxi-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/246992.jpg'),
'CR040966' => array('id' => 33361, 'sku' => 'CR040966', 'name' => 'Grey Loose Longline Sweatshirt', 'de_name' => 'Grau Locker Longline Sweatshirt', 'es_name' => 'Sudadera Larga Holgado En Gris', 'fr_name' => 'Sweat Lâche à Manches Longues Gris', 'ru_name' => 'Серая Длинная Толстовка', 'link' => 'grey-loose-longline-sweatshirt', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/165017.jpg'),
'TSHI0420B100Z' => array('id' => 42086, 'sku' => 'TSHI0420B100Z', 'name' => 'Monochrome Striped T-shirt With Drop Sleeve', 'de_name' => 'Monochrom Gestreiftes T-Shirt mit Tropfen Ärmel', 'es_name' => 'Camiseta A Raya Monocromo', 'fr_name' => 'T-Shirt à Rayures Manches Longues -Monochrome', 'ru_name' => 'Монохромная Полосатая Футболка С Рукавом', 'link' => 'monochrome-striped-t-shirt-with-drop-sleeve', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/208789.jpg'),
'DRES0409B248A' => array('id' => 41863, 'sku' => 'DRES0409B248A', 'name' => 'Blue Oversize Pom Pom Chiffon Poncho Cover Up Dress', 'de_name' => 'Blaues Übergrößes Umhang Chiffon Kleid', 'es_name' => 'Vestido De Gasa Azul', 'fr_name' => 'Robe Cape En Mousseline -Bleu', 'ru_name' => 'Синее Шифоновое Платье', 'link' => 'blue-oversize-pom-pom-cloak-chiffon-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/207779.jpg'),
'CA0402' => array('id' => 53610, 'sku' => 'CA0402', 'name' => 'Golden Sequined Tulle Panel Cap Sleeve Homecoming Dress', 'de_name' => 'Goldenes Pailletten Tüll Gespleisstes Kurzarm Ballkleid', 'es_name' => 'Vestido De Fiesta Manga Corta Con Panel Tul De Lentejuela Dorado', 'fr_name' => 'Robe De Bal Manche Courte Détail Tulle Et Sequin Doré', 'ru_name' => 'Золотой Блесткий Смокинг С Коротким Рукавом', 'link' => 'golden-sequined-tulle-panel-cap-sleeve-homecoming-dress', 'attributes' => 'a:1:{s:4:"Size";a:5:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";i:4;s:3:"XXL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/265189.jpg'),
'CDWC4069' => array('id' => 27542, 'sku' => 'CDWC4069', 'name' => 'Black Sheer Insert Hi Lo Skater Dress', 'de_name' => 'Netzeinsatz Hi Lo Tailliertes Kleid in Schwarz', 'es_name' => 'Vestido Alto-Bajo Con Aplicación De Malla En Negro', 'fr_name' => 'Robe à Ourlet Asymétrique En Tulle Noire', 'ru_name' => 'Черное Платье С Талией Hi Lo С Сеткой', 'link' => 'mesh-insert-hi-lo-waisted-dress-in-black', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/142034.jpg'),
'CCPC0140' => array('id' => 31729, 'sku' => 'CCPC0140', 'name' => 'Navy Zipper Detail Asymmetric PU Trim Waterfall Coat', 'de_name' => 'Marineblauer Asymmetrischer PU Trimm Wasserfall Mantel mit Reißverschluss Detail', 'es_name' => 'Chaqueta Asimétrica Detalle De Cremallera Azul Marino', 'fr_name' => 'Manteau Asymétrique Effet Cascade Avec Bordures En PU -Bleu Marine', 'ru_name' => 'Темно-Синяя PU Куртка', 'link' => 'asymmetric-layered-coat-with-zipper-detail', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/166743.jpg'),
'DRES0706B221R' => array('id' => 47614, 'sku' => 'DRES0706B221R', 'name' => 'Black Hi Lo Open Back Vest Maxi Dress', 'de_name' => 'Schwarzes Hi Lo Geöffneter Rücken Weste Maxikleid', 'es_name' => 'Vestido Largo Espalda Abierta Negro', 'fr_name' => 'Robe Débardeur Longue Dos Ouvert Asymétrique Noire', 'ru_name' => 'Черное Макси Платье', 'link' => 'black-hi-lo-open-back-vest-maxi-dress', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/236461.jpg'),
'CDXF2238' => array('id' => 24722, 'sku' => 'CDXF2238', 'name' => 'Black Fierce Seal Print Short Sleeve T-shirt Dress', 'de_name' => 'Schwarzes Heftiger Seehund Druck Kurzarm T-Shirt Kleid', 'es_name' => 'Vestido Manga Corta Estampado De Sello Negro', 'fr_name' => 'Robe T-Shirt Imprimée Sceau Féroce Manches Courtes -Noir', 'ru_name' => 'Черное Платье С Коротким Рукавом', 'link' => 'monster-pattern-shift-jersey-dress', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"M";i:1;s:1:"L";i:2;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/102784.jpg'),
'TSHI1010A052C' => array('id' => 34433, 'sku' => 'TSHI1010A052C', 'name' => 'Black Off Shoulder Tight Long Sleeve T-shirt', 'de_name' => 'Schwarz Schulterfrei Eng T-Shirt', 'es_name' => 'Camiseta Ajustada De Hombro Descubierto En Negro', 'fr_name' => 'T-Shirt Noir à Épaules Dénudées Et Manches Longues ', 'ru_name' => 'Черная Футболка С Открытыми Плечами', 'link' => 'black-off-shoulder-tight-long-sleeve-t-shirt', 'attributes' => 'a:1:{s:4:"Size";a:6:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";i:4;s:3:"XXL";i:5;s:4:"XXXL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/271039.jpg'),
'SKIR1118A477E' => array('id' => 37731, 'sku' => 'SKIR1118A477E', 'name' => 'Orange Pu Split Back Pencil Skirt', 'de_name' => 'Roter Pu Spaltung Rücken Bleistiftrock', 'es_name' => 'Falda Tubo PU Rojo', 'fr_name' => 'Jupe Fourreau En PU Rouge Avec Fente', 'ru_name' => 'Оранжевая PU Карандаш-Юбка', 'link' => 'red-pu-split-back-pencil-skirt', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/187606.jpg'),
'CDWC4070' => array('id' => 27543, 'sku' => 'CDWC4070', 'name' => 'Pink Sheer Insert Hi Lo Skater Dress', 'de_name' => 'Lachsfarbend Transparent Hi Lo Skater Kleid', 'es_name' => 'Vestido Con Aplicación De Malla Bajo Asimétrico En Rosa', 'fr_name' => 'Robe à Ourlet Asymétrique En Tulle rose', 'ru_name' => 'Бежевое Платье С Талией Hi Lo С Сеткой', 'link' => 'mesh-insert-hi-lo-waisted-dress-in-beige', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/300094.jpg'),
'CA0848' => array('id' => 56485, 'sku' => 'CA0848', 'name' => 'Camel Suedette Cut Away Multi Strap Tied Crop Top', 'de_name' => 'Kamelfarben Wildlederimitat Weggeschnittenes Multi Gurt Bauchfreies Obeteil', 'es_name' => 'Top Corto Antelina Con Lazo Color Camello', 'fr_name' => 'Top Court En Suédine Ajouré Avec Bretelles à Nouer Multiples Brun Clair', 'ru_name' => 'Верблюжий Замшевый Топ С Перевязами', 'link' => 'camel-suedette-cut-away-multi-strap-tied-crop-top', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/280240.jpg'),
'CS110104' => array('id' => 33809, 'sku' => 'CS110104', 'name' => 'Sky Blue Stripe Pointed Collar Roll-up Sleeve Shirt', 'de_name' => 'Himmelblaue Streifen spitzer Kragen aufrollbare Ärmel Bluse', 'es_name' => 'Camisa A Rayas Azules', 'fr_name' => 'Chemisier à Rayures Col Pointu Manches Roulées -Bleu Ciel', 'ru_name' => 'Синяя Полосатая Рубашка', 'link' => 'sky-blue-stripe-long-sleeve-shirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/174509.jpg'),
'CDDL3097' => array('id' => 12523, 'sku' => 'CDDL3097', 'name' => 'Black Centralizing Lace Long Sleeve Bodycon Dress', 'de_name' => 'Schwarzes Zentralisierung Spitze Langarm Figurbetontes Kleid', 'es_name' => 'Vestido Ajustado Manga Larga De Encaje Negro', 'fr_name' => 'Robe Moulante Manches Longues à Panneau En Dentelle -Noir', 'ru_name' => 'Черное Облегающее Платье С Длинным Рукавом', 'link' => 'bodycon-pencil-dress-contrast-lace-panel', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/211597.jpg'),
'DRES0508B224K' => array('id' => 43116, 'sku' => 'DRES0508B224K', 'name' => 'Monochrome Stripe Short Sleeve Shift Dress', 'de_name' => 'Monochromes Streifen Kurze Ärmel Etuikleid', 'es_name' => 'Vestido Recto Manga Corta A Rayas Monocromas', 'fr_name' => 'Robe Droite à Rayures Manches Courtes -Monochrome', 'ru_name' => 'Монохромное Полосатое Платье С Коротким Рукавом', 'link' => 'monochrome-stripe-short-sleeve-shift-dress', 'attributes' => 'a:1:{s:4:"Size";a:5:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";i:4;s:3:"XXL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/214283.jpg'),
'CSPY0559' => array('id' => 27975, 'sku' => 'CSPY0559', 'name' => 'White Ruffle Sleeve Chiffon Shirt', 'de_name' => 'Weißes Lotus Blatt Ärmeln Chiffon Hemd', 'es_name' => 'Camisa De Gasa Con Hoja De Loto En Blanco', 'fr_name' => 'Chemisier En Mousseline à Manches En Volants Blanc', 'ru_name' => 'Белая Шифоновая Рубашка С Рукавом Волн', 'link' => 'white-lotus-leaf-sleeve-chiffon-shirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/213425.jpg'),
'CDZY4082' => array('id' => 26706, 'sku' => 'CDZY4082', 'name' => 'Black Maid Collar Short Sleeve Chiffon Dress', 'de_name' => 'Schwarzes Mädchen Kragen Kurzarm Chiffon Kleid', 'es_name' => 'Vestido De Gasa Manga Corta Negra', 'fr_name' => 'Robe En Mousseline Col Contrastant -Noir', 'ru_name' => 'Черное Шифоновое Платье С Коротким Рукавом', 'link' => 'cute-dress-with-white-collar', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/276088.jpg'),
'CDZY4429' => array('id' => 29964, 'sku' => 'CDZY4429', 'name' => 'Gray Warp Hi-lo Ruched Asymmetric Long Sleeves Dress', 'de_name' => 'Graues Hoch-Tief Rüschen Asymmetrisches lange Ärmel Kleid', 'es_name' => 'Vestido Manga Larga Asimétrica Fruncido Gris', 'fr_name' => 'Robe Asymétrique Manches Longues -Gris', 'ru_name' => 'Серое Платье С Длинным Рукавом', 'link' => 'gray-warp-high-low-long-sleeves-bodycon-dress', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/245197.jpg'),
'CDXF2596' => array('id' => 27945, 'sku' => 'CDXF2596', 'name' => 'Navy Sheer Panel Shift Dress', 'de_name' => 'Marineblaues Transparentes Gespleisstes Etuikleid', 'es_name' => 'Vestido Recto Panel Transparente Azul Marino', 'fr_name' => 'Robe Droite Avec Panneau Transparent -Bleu Marine', 'ru_name' => 'Темно-Синее Платье', 'link' => 'purple-shift-dress-with-contrast-mesh-panel', 'attributes' => 'a:1:{s:4:"Size";a:6:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";i:4;s:3:"XXL";i:5;s:4:"XXXL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/216668.jpg'),
'SKIR1213A856K' => array('id' => 38924, 'sku' => 'SKIR1213A856K', 'name' => 'Black High Waist Midi Woolen Blend Skater Skirt', 'de_name' => 'Schwarzer Hohe Taille Midi Wolle Skater Rock', 'es_name' => 'Falda Skater Mezcla De Lana Talle Alto Negro', 'fr_name' => 'Jupe Patineuse En Laine Mélangée Taille Haute -Noir', 'ru_name' => 'Черное Миди Скейт-Платье С Высокой Талией', 'link' => 'black-high-waist-midi-woolen-skater-skirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/209255.jpg'),
'CA0639' => array('id' => 54667, 'sku' => 'CA0639', 'name' => 'Black Floral Rib Detail Bomber Jacket', 'de_name' => 'Schwarze Blumen Details Bomberjacke', 'es_name' => 'Cazadora Detalle De Cordoncillo Floral Negro', 'fr_name' => 'Black Floral Rib Detail Bomber Jacket', 'ru_name' => 'Чёрный Цветочный Пиджак', 'link' => 'black-floral-rib-detail-bomber-jacket', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/270410.jpg'),
'CIWC4493' => array('id' => 30517, 'sku' => 'CIWC4493', 'name' => 'Multicolor Floral Print Lace Hem Tie Waist Romper Playsuit', 'de_name' => 'Multi Farbe Blumendruck Romper Overall mit Spitze Rand und geschnürter Taille', 'es_name' => 'Mono Corto Floral Con Lazo De La Cintura', 'fr_name' => 'Combishort Imprimé Floral à Ourlet En Dentelle Avec Cordon -Multicolore', 'ru_name' => 'Комбинезон С Рисунком Цветов', 'link' => 'floral-print-cami-romper-playsuit-with-lace-hem-and-tie-waist', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/244899.jpg'),
'CDZY3233' => array('id' => 24065, 'sku' => 'CDZY3233', 'name' => 'White Stripe T-shirt Dress with Lion Print', 'de_name' => 'Weißes Streifen T-Shirt Kleid mit Löwe Druck', 'es_name' => 'Vestido A Raya Estampado De Léon Blanco', 'fr_name' => 'Robe T-Shirt à Rayure Avec Imprimé Lion -Blanc', 'ru_name' => 'Белое Полосатое Платье С Рисунком Льва', 'link' => 'white-stripe-jersey-dress-with-lion-print', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"One size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/99548.jpg'),
'CK031528' => array('id' => 32771, 'sku' => 'CK031528', 'name' => 'Purple Pleated Mini Skirt', 'de_name' => 'Lila Plissiert Minirock', 'es_name' => 'Mini Falda Con Pliegues En Violeta', 'fr_name' => 'Mini Jupe Plissée Violette', 'ru_name' => 'Фиолетовая Плиссированная Миди Юбка', 'link' => 'purple-pleated-mini-skirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:2:"XS";i:1;s:1:"S";i:2;s:1:"M";i:3;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/289715.jpg'),
'VEST0617B414C' => array('id' => 45303, 'sku' => 'VEST0617B414C', 'name' => 'Gray Spaghetti Strap V-neck Ruffle Wrap Cami', 'de_name' => 'Graues Spaghetti Strap V-Ausschnitt Rüschen Wickel Trägertop', 'es_name' => 'Camisola Cuello De Pico Con Volantes Gris', 'fr_name' => 'Caraco Plissé Col V à Bretelle -Gris', 'ru_name' => 'Серая Майка', 'link' => 'gray-spaghetti-strap-v-neck-ruffle-wrap-cami', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/225032.jpg'),
'DRES1027A136A' => array('id' => 35690, 'sku' => 'DRES1027A136A', 'name' => 'Green Yellow Cut Away Pleated Maxi Dress', 'de_name' => 'Grün Gelb Weggeschnittenes Plissiertes Maxikleid', 'es_name' => 'Vestido Maxi Plisado Amarillo', 'fr_name' => 'Robe Jaune à Plis', 'ru_name' => 'Желтое Плиссированное Макси Платье', 'link' => 'lucifer-yellow-pleated-maxi-dress', 'attributes' => 'a:1:{s:4:"Size";a:1:{i:0;s:8:"one size";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/243304.jpg'),
'CW0044' => array('id' => 52831, 'sku' => 'CW0044', 'name' => 'Black Button Front Lace Soft Triangle Bra', 'de_name' => 'Schwarzer Knopf Spitze Triangel BH', 'es_name' => 'Sujetador Triangular De Encaje Negro', 'fr_name' => 'Soutien-Gorge Triangle En Dentelle Boutonné Noir', 'ru_name' => 'Черные Кнопки На Передней Кружевной Бюстгальтер Треугольник', 'link' => 'black-button-front-lace-soft-triangle-bra', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"8";i:3;s:2:"10";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/260838.jpg'),
'CWA35E' => array('id' => 59600, 'sku' => 'CWA35E', 'name' => 'Color Block Chevron Print Scoop Neck 3/4 Sleeve Dress', 'de_name' => 'Farbblock ZickzackDruck Runder Halsausschnitt 3/4 Ärmel Kleid', 'es_name' => 'Vestido Estampado De Chevron Con Manga 3/4 Color Bloque', 'fr_name' => 'Robe Imprimé Chevron à Encolure Dégagée Manches 3/4 Block De Couleur', 'ru_name' => 'Цвет-блочное  Шеврон Печати Совок Шеи 3/4 Рукавом Платье', 'link' => 'color-block-chevron-print-scoop-neck-3-4-sleeve-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/302897.jpg'),
'COAT1113A202A' => array('id' => 37331, 'sku' => 'COAT1113A202A', 'name' => 'White Faux Fur Beaded Panel Coat', 'de_name' => 'Weiße Kunstpelz Perlen Gespleisste Jacke', 'es_name' => 'Chaqueta De Pelo Sintético Blanco', 'fr_name' => 'Veate En Fausse Fourrure Avec Panneau Orné De Perles -Blanc', 'ru_name' => 'Белая Куртка Из Искусственного Меха', 'link' => 'white-faux-fur-beaded-coat', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/283191.jpg'),
'CSPY0558' => array('id' => 27974, 'sku' => 'CSPY0558', 'name' => 'Pink Ruffle Sleeve Chiffon Shirt', 'de_name' => 'Rosa Lotus Blatt Ärmeln Chiffon Hemd', 'es_name' => 'Camisa De Gasa Con Hoja De Loto En Rosa', 'fr_name' => 'Chemisier En Mousseline Manches Volantées -Rose Pâle', 'ru_name' => 'Розовая Шифоновая Рубашка С Рукавом Волн', 'link' => 'pink-lotus-leaf-sleeve-chiffon-shirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/142092.jpg'),
'DRES0320B729K' => array('id' => 40977, 'sku' => 'DRES0320B729K', 'name' => 'White Strapless Sweetheart Crochet Lace Dress', 'de_name' => 'Weißes Rückenfreies Lange Ärmel Spitze Ausgestelltes Kleid', 'es_name' => 'Vestido De Encaje Manga Larga Sin Espalda Blanca', 'fr_name' => 'Robe Évasée En Dentelle Dos Nu Manches Longues -Blanc', 'ru_name' => 'Белое Кружевное Платье С Длинным Рукавом', 'link' => 'white-backless-long-sleeve-lace-flared-dress', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/226154.jpg'),
'JUMP0304B649E' => array('id' => 40409, 'sku' => 'JUMP0304B649E', 'name' => 'Black Keyhole Back Elastic Waist Romper Playsuit', 'de_name' => 'Schwarze Neckholder Damen Overall', 'es_name' => 'Mono Corto Cuello Halter Negro', 'fr_name' => 'Combinaison à Bretelles -Noir', 'ru_name' => 'Черный Комбинезон', 'link' => 'black-halter-neck-romper-playsuit', 'attributes' => 'a:1:{s:4:"Size";a:3:{i:0;s:1:"M";i:1;s:1:"L";i:2;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/200697.jpg'),
'TSHI1010A053C' => array('id' => 34434, 'sku' => 'TSHI1010A053C', 'name' => 'White Off Shoulder Tight Long Sleeve T-shirt', 'de_name' => 'Weiß Schulterfrei Eng T-Shirt', 'es_name' => 'Camiseta blanca hombro descubierto', 'fr_name' => 'T-Shirt à Épaules Dénudées Avec Manches Longues Blanc', 'ru_name' => 'Белая Футболка С Открытыми Плечами', 'link' => 'white-off-shoulder-tight-long-sleeve-t-shirt', 'attributes' => 'a:1:{s:4:"Size";a:4:{i:0;s:1:"S";i:1;s:1:"M";i:2;s:1:"L";i:3;s:2:"XL";}}', 'brief' => '', 'description' => '', 'keywords' => '', 'cover_image' => 'http://d1cr7zfsu1b8qs.cloudfront.net/pimg/270/170634.jpg'),
);//end blackarr

        $cache = Cache::instance('memcache');
        $key = "/args_promotions/";
        if( ! ($outsku = $cache->get($key))){
        $outsku = DB::select('args')->from('promotions')->where('id', '=', 41)->execute()->get('args');
        $cache->set($key, $outsku, 1200);
        }

        $outsku = explode("\n",$outsku);
        $i = 0;
        foreach($blackarr as $k=>$v)
        {
            if($i<=99){
                if(in_array($k,$outsku)){
                    unset($blackarr[$k]);
                }else{
                    $i++;                     
                }
               
            }else{
                unset($blackarr[$k]);
            }

        }
    
    $price = array('SH0076' =>array('103.99','73.99', '73.99' ),
'SHOE1215A461B' =>array('104.99','73.99', '73.99' ),
'CCDL4194' =>array('75.99','43.99', '43.99' ),
'CAA01P' =>array('35.99','20.99', '20.99' ),
'CCYY0859' =>array('37.99','21.99', '21.99' ),
'CW0123' =>array('61.99','35.99', '35.99' ),
'CWA356' =>array('59.99','37.99', '37.99' ),
'CWA359' =>array('38.99','24.99', '24.99' ),
'CW0113' =>array('68.99','39.99', '39.99' ),
'CZZY4701' =>array('44.99','25.99', '25.99' ),
'PYA2P1' =>array('12.99','3.99', '3.99' ),
'PYA2P2' =>array('12.99','3.99', '3.99' ),
'CYA2P3' =>array('16.99','5.99', '5.99' ),
'CYA2P4' =>array('11.99','3.99', '3.99' ),
'CYA2P5' =>array('11.99','3.99', '3.99' ),
'CYA2P6' =>array('11.99','3.99', '3.99' ),
'CYA29J' =>array('18.99','5.99', '5.99' ),
'TWOP0717B082W' =>array('25.99','13.99', '13.99' ),
'CA0086' =>array('39.99','22.99', '22.99' ),
'DRES1217A014P' =>array('17.99','7.99', '7.99' ),
'CW0093' =>array('29.99','17.99', '17.99' ),
'PW0005' =>array('32.99','19.99', '19.99' ),
'CW0012' =>array('27.99','16.99', '16.99' ),
'BREA0323B010W' =>array('17.99','6.99', '6.99' ),
'CW0092' =>array('19.99','11.99', '11.99' ),
'DRES0407B020W' =>array('18.99','10.99', '10.99' ),
'VEST0731B094W' =>array('18.99','9.99', '9.99' ),
'SKIR0323B011W' =>array('26.99','15.99', '15.99' ),
'TWOP0611B072W' =>array('25.99','12.99', '12.99' ),
'DRES0609B071W' =>array('18.99','8.99', '8.99' ),
'CTGP0012' =>array('14.99','7.99', '7.99' ),
'CW0051' =>array('29.99','17.99', '17.99' ),
'DRES0703B078W' =>array('23.99','10.99', '10.99' ),
'DRES0428B051W' =>array('17.99','9.99', '9.99' ),
'CW0107' =>array('21.99','12.99', '12.99' ),
'DRES0618B075W' =>array('16.99','8.99', '8.99' ),
'SKIR0327B015W' =>array('19.99','11.99', '11.99' ),
'CW0003' =>array('20.99','11.99', '11.99' ),
'CTGP0025' =>array('12.99','7.99', '7.99' ),
'DRES0618B074W' =>array('16.99','9.99', '9.99' ),
'DRES0803B098W' =>array('44.99','26.99', '26.99' ),
'DRES0703B077W' =>array('23.99','12.99', '12.99' ),
'CW0002' =>array('21.99','12.99', '12.99' ),
'BLOU1217A013P' =>array('17.99','10.99', '10.99' ),
'CW0037' =>array('24.99','14.99', '14.99' ),
'CW0039' =>array('36.99','22.99', '22.99' ),
'DRES0511B065W' =>array('21.99','11.99', '11.99' ),
'CW0040' =>array('36.99','22.99', '22.99' ),
'BREA0408B023W' =>array('12.99','5.99', '5.99' ),
'CW0027' =>array('21.99','13.99', '13.99' ),
'CW0068' =>array('23.99','13.99', '13.99' ),
'PW0048' =>array('26.99','16.99', '16.99' ),
'CW0095' =>array('29.99','17.99', '17.99' ),
'CW0086' =>array('38.99','22.99', '22.99' ),
'CWA1ZM' =>array('31.99','19.99', '19.99' ),
'TSHI0114B050P' =>array('20.99','8.99', '8.99' ),
'CW0069' =>array('18.99','10.99', '10.99' ),
'CWA2BV' =>array('24.99','14.99', '14.99' ),
'PW0041' =>array('27.99','16.99', '16.99' ),
'DRES0408B026W' =>array('22.99','10.99', '10.99' ),
'CROP0128B079P' =>array('13.99','7.99', '7.99' ),
'DRES0413B102P' =>array('21.99','10.99', '10.99' ),
'CW0023' =>array('22.99','14.99', '14.99' ),
'BLOU0407B021W' =>array('13.99','7.99', '7.99' ),
'CW0099' =>array('23.99','13.99', '13.99' ),
'PW0049' =>array('26.99','15.99', '15.99' ),
'VEST0422B045W' =>array('18.99','8.99', '8.99' ),
'PW0066' =>array('21.99','12.99', '12.99' ),
'SKIR0409B031W' =>array('26.99','15.99', '15.99' ),
'PW0009' =>array('30.99','18.99', '18.99' ),
'VEST0717B080W' =>array('11.99','6.99', '6.99' ),
'TWOP0426B300A' =>array('23.99','12.99', '12.99' ),
'VEST0421B268A' =>array('9.99','6.99', '6.99' ),
'CW0083' =>array('17.99','10.99', '10.99' ),
'CDGP0031' =>array('31.99','11.99', '11.99' ),
'TWOP0122B209A' =>array('27.99','5.99', '5.99' ),
'CDZY2855' =>array('97.99','37.99', '37.99' ),
'CWA1EM' =>array('32.99','18.99', '18.99' ),
'SKIR0122B204A' =>array('20.99','11.99', '11.99' ),
'CSZY4476' =>array('17.99','10.99', '10.99' ),
'CWA1EK' =>array('31.99','18.99', '18.99' ),
'CKYY1128' =>array('28.99','14.99', '14.99' ),
'CIZY4394' =>array('34.99','11.99', '11.99' ),
'CDXF2595' =>array('16.99','9.99', '9.99' ),
'CDZY4383' =>array('21.99','12.99', '12.99' ),
'CPZY2683' =>array('22.99','13.99', '13.99' ),
'CPXF2255' =>array('29.99','16.99', '16.99' ),
'CSPY0884' =>array('13.99','7.99', '7.99' ),
'DRES0506B201K' =>array('24.99','10.99', '10.99' ),
'CIZY4413' =>array('25.99','9.99', '9.99' ),
'CK0805' =>array('20.99','11.99', '11.99' ),
'CSZY4748' =>array('20.99','11.99', '11.99' ),
'CK0018' =>array('11.99','6.99', '6.99' ),
'CSZY0868' =>array('19.99','11.99', '11.99' ),
'CDZY4591' =>array('79.99','31.99', '31.99' ),
'CR040966' =>array('27.99','15.99', '15.99' ),
'TSHI0420B100Z' =>array('26.99','8.99', '8.99' ),
'DRES0409B248A' =>array('18.99','12.99', '12.99' ),
'CA0402' =>array('65.99','44.99', '44.99' ),
'CDWC4069' =>array('19.99','9.99', '9.99' ),
'CCPC0140' =>array('49.99','28.99', '28.99' ),
'DRES0706B221R' =>array('23.99','8.99', '8.99' ),
'CDXF2238' =>array('18.99','9.99', '9.99' ),
'TSHI1010A052C' =>array('14.99','7.99', '7.99' ),
'SKIR1118A477E' =>array('22.99','13.99', '13.99' ),
'CDWC4070' =>array('19.99','9.99', '9.99' ),
'CA0848' =>array('14.99','5.99', '5.99' ),
'CS110104' =>array('16.99','9.99', '9.99' ),
'CDDL3097' =>array('53.99','36.99', '36.99' ),
'DRES0508B224K' =>array('14.99','7.99', '7.99' ),
'CSPY0559' =>array('15.99','8.99', '8.99' ),
'CDZY4082' =>array('19.99','10.99', '10.99' ),
'CDZY4429' =>array('26.99','12.99', '12.99' ),
'CDXF2596' =>array('19.99','8.99', '8.99' ),
'SKIR1213A856K' =>array('33.99','17.99', '17.99' ),
'CA0639' =>array('24.99','14.99', '14.99' ),
'CIWC4493' =>array('19.99','8.99', '8.99' ),
'CDZY3233' =>array('21.35','14.99', '14.99' ),
'CK031528' =>array('22.99','12.99', '12.99' ),
'VEST0617B414C' =>array('18.99','9.99', '9.99' ),
'DRES1027A136A' =>array('26.99','17.99', '17.99' ),
'CW0044' =>array('12.99','5.99', '5.99' ),
'CWA35E' =>array('22.99','12.99', '12.99' ),
'COAT1113A202A' =>array('67.99','38.99', '38.99' ),
'CSPY0558' =>array('15.99','9.99', '9.99' ),
'DRES0320B729K' =>array('35.99','13.99', '13.99' ),
'JUMP0304B649E' =>array('15.99','8.99', '8.99' ),
'TSHI1010A053C' =>array('14.99','7.99', '7.99' ),
);

        $this->template->content = View::factory('/activity'.LANGPATH.'/blackfriday')->set('blackarr',$blackarr)->set('blackprice',$price);
    }

    public function action_holiday_gift_guide()
    {
        $this->template->content = View::factory('/activity'.LANGPATH.'/holidaygift')->set('blackarr',$blackarr)->set('blackprice',$price);
    }

    public function action_giveaway()
    {
        $this->template->content = View::factory('/activity'.LANGPATH.'/giveaway')->set('blackarr',$blackarr)->set('blackprice',$price);
    }

    public function action_testmemcache()
    {
                $cache = Cache::instance('memcache');
        $key = 'spromotion_62943';
        $val = $cache->get($key);
        echo '<pre>';
        print_r($val);
        exit;
    }

    public function action_index_test()
    {

        // if (Arr::get($_SERVER, 'HTTPS', 'off') == 'on')
        // {
        //     $redirects = isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : '';
        //     Request::Instance()->redirect(URL::site($uri . $redirects, 'http'));
        // }
        // If is mobile
        $is_mobile = Session::instance()->get('is_mobile');
        $mobile_key = $is_mobile ? 'mobile_' : '';

        $cid = (int) Arr::get($_GET, 'cid', 0);
        // if ($cid)
        // {
        //     Site::instance()->add_flow($cid, 'index', '');
        // }
        // elseif ($cidb = (int) Arr::get($_GET, 'cidb', 0))
        // {
        //     Site::instance()->add_flow($cidb, 'banner', '');
        // }

        $index_close_flg = Session::instance()->get('index_close_flg');
        if($index_close_flg){
            $index_close_show = TRUE;
        }else{
            $index_close_show = FALSE;
        }
        $cache_key = $mobile_key . 'site_index_test' . $this->language;
        $cacheins = Cache::instance('memcache');
        $cache_content = $cacheins->get($cache_key);
        if (strlen($cache_content) > 100 AND !isset($_GET['cache']))
        {
            $this->template = $cache_content;
        }
        else
        {
            $cache_banner_key = 'site_bannerindex_choies' .$this->language;
            $cache_banner_content = $cacheins->get($cache_banner_key);

            if(!empty($cache_banner_content) AND !isset($_GET['cache']))
            {
               $result = $cache_banner_content;
            }
            else
            {

                if($this->language)
                {
                    $result = DB::select()->from('banners_banner')
                        ->where('visibility', '=', 1)
                        ->where('lang', '=', $this->language)
                        ->order_by('position', 'ASC')
                        ->order_by('id', 'DESC')
                        ->execute()->as_array();
                }
                else
                {
                    $result = DB::select()->from('banners_banner')
                        ->where('visibility', '=', 1)
                        ->where('lang', '=', '')
                        ->order_by('position', 'ASC')
                        ->order_by('id', 'DESC')
                        ->execute()->as_array();
                }

                $cacheins->set($cache_banner_key, $result, 1800);
            }

            $cache_zhuceyouli_key = 'site_zhuceyouli_choies' .$this->language;
            $cache_zhuceyouli_content = $cacheins->get($cache_zhuceyouli_key);
            if(!empty($cache_zhuceyouli_content) AND !isset($_GET['cache']))
            {
               $free = $cache_zhuceyouli_content;
            }else{
              $free = DB::query(Database::SELECT, 'select id,price,sku from products where sku in("BA0844","SW0102") order by id asc')->execute()->as_array();  
              $cacheins->set($cache_zhuceyouli_key, $free, 3600); //设置注册有礼的缓存
            }
            
            $banners = array();
            $index_banners = array();
            foreach ($result as $val)
            {
                if ($val['type'] == '')
                {
                    $banners[] = $val;
                }
                elseif ($val['type'] == 'index')
                {
                    $index_banners[] = $val;
                }
            }
            
            $buyers_sku = DB::select('map')->from('banners')->where('type', '=', 'buyers_show')->execute()->get('map');

            $this->template->content = View::factory('/activity'.LANGPATH.'/index_test')
                ->set('free',$free)
                ->set('banners', $banners)
                ->set('index_banners', $index_banners)
                ->set('index_close_show',$index_close_show)
                ->set('buyers_sku', $buyers_sku)
                ->set('is_mobile', $is_mobile);
            $this->template->type = 'home';
            Cache::instance('memcache')->set($cache_key, $this->template, 3600);
        }
    }
	
	/**
     * 积分兑换活动页面
     * add 2016-01-12
     */
    public function action_points_redeem_coupons()
    {
        $data=array();
        //把points配置文件输出到页面
        $points = Kohana::config('points.points');
        $points_pc = Kohana::config('points.points_pc');
        $points_m = Kohana::config('points.points_m');

        //获取用户积分
        $customer = Customer::logged_in();
        $user_points=Customer::instance($customer)->points();

        $data['points']=$points;
        $data['points_pc']=$points_pc;
        $data['points_m']=$points_m;
        $data['user_points']=$user_points;
      
        $keyhots  = 'site_points_redeem_coupons';
        $cache = Cache::instance('memcache');
        if (!($hots = $cache->get($keyhots)))
        {
            $hots = DB::query(Database::SELECT, 'SELECT product_id FROM products_categoryproduct WHERE category_id = 32 ORDER BY position DESC LIMIT 0, 28')->execute()->as_array();
            $cache->set($keyhots, $hots, 86400 * 7);
        }

        $this->template->title = 'points';
        $this->template->description = "Join in Singles Day Sale with the lowest price. CHOiES offers you women's Clothing, Dresses , Accessories & Shoes!";
        $this->template->content = View::factory('/activity'.LANGPATH.'/points_redeem_coupons')
            ->set('data',$data)
            ->set('hots',$hots);
    }

    public function action_choies_questionnaire201603()
    {
        $customer_id = Customer::logged_in();
        if ($customer_id)
        {
            $has_submit = DB::query(Database::SELECT, 'SELECT DISTINCT id FROM giveaway_questions WHERE created > ' . strtotime('2016-2-25') . ' AND user_id=' . $customer_id . ' ORDER BY created DESC')->execute()->get('id');
            if ($has_submit)
            {
                $this->request->redirect('/activity/survey_success');
            }
        }

        if($_POST)
        {
            if (!$customer_id)
            {
                Message::set(__('need_log_in'), 'notice');
                $this->request->redirect(URL::current(TRUE));
            }

            $data = array();
            foreach($_POST as $key => $value)
            {
                $_POST[$key] = Arr::get($_POST, $key, '');
            }

            foreach($_POST as $key => $value)
            {
                $data[$key] = substr($value,0,1);
            }
            $data['user_id'] = $customer_id;
            $data['created'] = time();
            $data['ip'] = ip2long(Request::$client_ip);
            $result = DB::insert('giveaway_questions', array_keys($data))->values($data)->execute();

            if($result)
            {
                $insert = array('customer_id' => $customer_id, 'coupon_id' => 907463);
                DB::insert('carts_customercoupons', array_keys($insert))->values($insert)->execute();

                $mail_params = array();
                $mail_params['email'] = Customer::instance($customer_id)->get('email');
                Mail::SendTemplateMail('QUESTIONNAIRE', $mail_params['email'], $mail_params);
                $this->request->redirect(LANGPATH . '/activity/survey_success');
            }
            else
            {
                Message::set(__('post_data_error'), 'error');
                $this->request->redirect(URL::current(TRUE));
            }


        }
        
        $this->template->title = '2016 Choies Survey';
        $this->template->keywords = 'Choies site update survey, Look, Outfit, Choies Coats, Jackets, Shoes, Bags';
        $this->template->description = "Take 2016 Choies Survey，Win $100 Gift Card + 20% Off Coupon Code.";
        $this->template->content = View::factory('/activity'.LANGPATH.'/choies_questionnaire201603');
    }

    public function action_survey_success()
    {
        $this->template->content = View::factory('/activity'.LANGPATH.'/survey_success');
    }

    public function action_ajax_survey()
    {
        if($_POST)
        {
            $spanname = Arr::get($_POST,'spanname','');
            $checkedvalue = Arr::get($_POST,'checkedvalue','');
            $checkedvalue = substr($checkedvalue,0,1);
         Kohana_Cookie::set($spanname,$checkedvalue,3600*96);
            echo json_encode(1);
            die;
        }
    }

    public function action_Copyright_Infringement_Notice()
    {
        $this->template->content = View::factory('/activity'.LANGPATH.'/model');
    }

    public function action_how_to_wear_bomber_jacket()
    {
        $this->request->redirect(LANGPATH.'/bomber-jackets-c-300');
    }

    public function action_special()
    {
        $gets = array(
            'page' => (int) Arr::get($_GET, 'page', 0),
            'limit' => (int) Arr::get($_GET, 'limit', 0),
            'sort' => (int) Arr::get($_GET, 'sort', 0),
            'pick' => (int) Arr::get($_GET, 'pick', 0),
        );
        $cache_key = '1234new_activity_'.implode('_', $gets);
        $cache_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_key);
        $cache_content = Cache::instance('memcache')->get($cache_key);

        if (strlen($cache_content) > 100 AND !isset($_GET['cache']))
        {
            $this->template = $cache_content;
        }
        else
        {
            $proids = array(
                        1260,
                        2225,
                        2259,
                        6286,
                        6348,
                        8772,
                        9428,
                        10125,
                        11140,
                        11277,
                        13566,
                        15803,
                        15805,
                        15816,
                        15889,
                        16095,
                        18169,
                        18247,
                        18248,
                        18286,
                        18303,
                        18356,
                        18647,
                        18825,
                        18943,
                        19190,
                        19191,
                        20077,
                        20503,
                        20742,
                        21504,
                        21877,
                        21879,
                        22059,
                        22326,
                        22328,
                        23009,
                        23836,
                        24812,
                        25342,
                        25343,
                        27393,
                        27536,
                        28022,
                        28282,
                        29164,
                        29292,
                        29675,
                        29740,
                        29750,
                        29756,
                        29757,
                        29957,
                        30008,
                        30258,
                        30371,
                        30373,
                        30943,
                        31744,
                        31752,
                        31753,
                        31897,
                        32197,
                        32201,
                        32202,
                        32204,
                        32393,
                        32394,
                        32397,
                        32487,
                        32776,
                        33498,
                        33802,
                        33888,
                        34144,
                        34146,
                        34196,
                        34347,
                        34387,
                        34698,
                        34861,
                        34916,
                        35005,
                        35180,
                        35338,
                        35467,
                        35579,
                        35868,
                        36055,
                        36374,
                        36378,
                        36441,
                        36475,
                        37000,
                        37015,
                        37023,
                        37078,
                        37079,
                        37412,
                        37465,
                        37466,
                        37478,
                        37726,
                        37865,
                        37869,
                        37887,
                        37899,
                        37967,
                        37972,
                        38003,
                        38009,
                        38233,
                        38234,
                        38296,
                        38347,
                        38365,
                        38403,
                        38544,
                        38723,
                        38865,
                        39082,
                        39088,
                        39413,
                        39442,
                        39509,
                        39518,
                        39588,
                        39920,
                        39923,
                        40315,
                        40443,
                        40535,
                        40717,
                        40764,
                        40766,
                        40829,
                        40894,
                        40940,
                        40975,
                        41167,
                        41290,
                        41292,
                        41293,
                        41553,
                        41554,
                        41594,
                        41868,
                        41886,
                        42106,
                        42206,
                        42207,
                        42350,
                        42442,
                        42478,
                        42482,
                        42665,
                        42667,
                        42670,
                        42740,
                        42842,
                        43116,
                        43338,
                        43472,
                        43505,
                        43528,
                        43535,
                        43617,
                        43784,
                        44045,
                        44149,
                        44527,
                        44540,
                        44705,
                        44832,
                        44833,
                        44926,
                        45091,
                        45142,
                        45195,
                        45610,
                        45960,
                        46142,
                        46386,
                        46411,
                        46524,
                        46639,
                        46666,
                        46690,
                        46691,
                        46694,
                        46695,
                        46777,
                        46843,
                        46998,
                        47011,
                        47114,
                        47154,
                        47211,
                        47604,
                        47612,
                        47680,
                        47779,
                        47831,
                        47867,
                        48081,
                        48262,
                        48293,
                        48549,
                        48615,
                        48678,
                        48874,
                        48889,
                        48891,
                        48957,
                        49222,
                        49240,
                        49306,
                        49615,
                        49633,
                        49708,
                        49722,
                        49767,
                        50207,
                        50232,
                        50241,
                        50432,
                        50598,
                        50744,
                        50844,
                        50964,
                        51289,
                        51312,
                        51786,
                        51971,
                        52019,
                        52096,
                        52192,
                        52407,
                        52534,
                        52623,
                        52657,
                        52785,
                        52832,
                        52842,
                        52873,
                        52965,
                        52995,
                        53000,
                        53137,
                        53138,
                        53142,
                        53197,
                        53201,
                        53206,
                        53208,
                        53218,
                        53457,
                        53462,
                        53463,
                        53465,
                        53478,
                        53479,
                        53605,
                        53631,
                        53664,
                        53670,
                        53686,
                        53777,
                        54022,
                        54105,
                        54254,
                        54267,
                        54302,
                        54304,
                        54309,
                        54326,
                        54329,
                        54330,
                        54341,
                        54356,
                        54764,
                        54788,
                        54794,
                        54868,
                        54874,
                        55043,
                        55044,
                        55045,
                        55047,
                        55055,
                        55144,
                        55153,
                        55322,
                        55335,
                        55388,
                        55444,
                        55446,
                        55455,
                        55536,
                        55657,
                        55846,
                        55878,
                        55884,
                        55908,
                        55914,
                        55946,
                        56236,
                        56239,
                        56300,
                        56301,
                        56383,
                        56647,
                        56672,
                        56674,
                        56675,
                        56678,
                        56679,
                        56719,
                        56817,
                        56860,
                        57025,
                        57031,
                        57175,
                        57238,
                        57293,
                        57353,
                        57495,
                        57546,
                        57740,
                        57750,
                        57751,
                        57752,
                        57773,
                        57774,
                        57776,
                        57911,
                        57980,
                        58006,
                        58007,
                        58063,
                        58285,
                        58286,
                        58287,
                        58298,
                        58302,
                        58469,
                        58481,
                        58483,
                        58528,
                        58612,
                        58625,
                        58632,
                        58641,
                        58642,
                        58710,
                        58712,
                        58716,
                        58811,
                        58816,
                        58933,
                        58961,
                        58964,
                        58966,
                        58983,
                        59006,
                        59044,
                        59225,
                        59274,
                        59281,
                        59313,
                        59314,
                        59319,
                        59339,
                        59340,
                        59483,
                        59486,
                        59541,
                        59545,
                        59548,
                        59598,
                        59600,
                        59669,
                        59674,
                        59701,
                        59728,
                        59731,
                        59787,
                        59829,
                        59831,
                        59846,
                        59932,
                        59979,
                        59982,
                        59984,
                        59985,
                        60284,
                        60285,
                        60339,
                        60393,
                        60399,
                        60401,
                        60402,
                        60403,
                        60583,
                        60584,
                        60640,
                        60784,
                        60806,
                        60811,
                        60886,
                        60948,
                        60952,
                        60998,
                        61003,
                        61058,
                        61078,
                        61085,
                        61086,
                        61089,
                        61102,
                        61204,
                        61215,
                        61267,
                        61426,
                        61474,
                        61476,
                        61477,
                        61479,
                        61511,
                        61674,
                        61687,
                        61689,
                        61693,
                        61698,
                        61743,
                        61744,
                        61803,
                        61891,
                        61975,
                        62094,
                        62097,
                        62130,
                        62133,
                        62220,
                        62221,
                        62361,
                        62453,
                        62521,
                        62659,
                        62726,
                        62802,
                        62947,
                        62967,
                        63308,
                        63383,
                        63384,
                        63389,
                        63390,
                        63405,
                        63406,
                        63441,
                        63442,
                        63465,
                        63470,
                        63480,
                        63481,
                        63514,
                        63515,
                        63522,
                        63740,
                        63753,
                        63761,
                        63765,
                        63989,
                );
            $count = count($proids);
            $pagination = Pagination::factory(array(
                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                    'total_items' => $count,
                    'items_per_page' => 48,
                    'view' => '/pagination_r'));
            $product = DB::select('link','id')->from('products_product')
                ->where('id', 'in', $proids)
                ->limit($pagination->items_per_page)
                ->offset($pagination->offset)
                ->order_by('position', 'asc')
                ->execute('slave')
                ->as_array();
            $this->template->content = View::factory('/activity'.LANGPATH.'/blackfriday1')
                ->set('product', $product)
                ->set('pagination', $pagination->render());
        }
        Cache::instance('memcache')->set($cache_key, $this->template, 86400*7);
    }

}
