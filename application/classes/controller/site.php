<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Site extends Controller_Webpage
{

    public function action_view()
    {
        // If uri not language redirect 404
        // var_dump(Site::instance()->get('domain'));die;
        // var_dump($_SERVER);die;
        $uri = Request::Instance()->uri;
        if($uri != $this->language)
        {
            Request::Instance()->redirect('/');
        }

        if (Arr::get($_SERVER, 'HTTPS', 'off') == 'off')
        {
            $redirects = isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : '';
            Request::Instance()->redirect(URL::site($uri . $redirects, 'https'));
        }        
        $cid = (int) Arr::get($_GET, 'cid', 0);
        if ($cid)
        {
            Site::instance()->add_flow($cid, 'index', '');
        }
        elseif ($cidb = (int) Arr::get($_GET, 'cidb', 0))
        {
            Site::instance()->add_flow($cidb, 'banner', '');
        }

        $index_close_flg = Session::instance()->get('index_close_flg');
        if($index_close_flg){
            $index_close_show = TRUE;
        }else{
            $index_close_show = FALSE;
        }

        // is_mobile add mobile_key --- sjm 2015-12-15
        $mobile_key = $this->is_mobile ? 'mobile_' : '';
        
        // $cache_key = $mobile_key . 'site_index_choies' . $this->language;
        $cache_key = $mobile_key . 'site_index_choies';
        $cacheins = Cache::instance('memcache');
        $cache_content = $cacheins->get($cache_key);
        if (strlen($cache_content) > 100 AND !isset($_GET['cache']))
        {
            $this->template = $cache_content;
        }
        else
        {
            // $cache_banner_key = '3301site_bannerindex_choies' .$this->language;
            $cache_banner_key = '3301site_bannerindex_choies';
            $cache_banner_content = $cacheins->get($cache_banner_key);
            // var_dump($cache_banner_content);die;

            if(!empty($cache_banner_content) AND !isset($_GET['cache']))
            // if(0)
            {
               if(!is_array($cache_banner_content))
               {    
                    $result = unserialize($cache_banner_content);
               }else{
                    $result = $cache_banner_content;
               }
            }
            else
            {

            if($this->language)
            {
                $result = DB::select()->from('banners_banner')
                    ->where('visibility', '=', 1)
                    // ->where('lang', '=', $this->language)
                    ->where('lang', '=', '')
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

            #newindex类型单独查询
            $newindex_banners = array();
            $cache_newindex_key = '1site_newindex_choies';
            $cachein = Cache::instance('memcache');
            $cache_newindex_content = $cachein->get($cache_newindex_key);
            if($cache_newindex_content and !is_array($cache_newindex_content))
            {
                $cache_newindex_content = unserialize($cache_newindex_content);
            }
            if (isset($cache_newindex_content) AND !isset($_GET['cache'])){
                $newindex_banners = $cache_newindex_content;
            }else{
               $newindex_banners = DB::select()->from('banners_banner')->where('type', '=', 'newindex')->where('visibility', '=', 1)->where('lang', '=', '')->order_by('position', 'ASC')->execute()->as_array();
               $cachein->set($cache_newindex_key,$newindex_banners, 3600);
            }
            // echo 1111;
            // var_dump($newindex_banners);die;

            $banners = array();
            $index_banners = array();
            $index1_banners = array();
            $index6_banners = array();
            $index8_banners = array();
            $index12_banners = array();
            // $newindex_banners = array();
            $phone_banners = array();
            $phonecatalog_banners = array();

            if($result)
            {
                foreach ($result as $val)
                if($val['type'] == '')
                {
                    $banners[] = $val;
                }
                elseif ($val['type'] == 'index')
                {
                    $index_banners[] = $val;
                }
                elseif ($val['type'] == 'index1')
                {
                    $index1_banners[] = $val;
                }
                elseif ($val['type'] == 'index6')
                {
                    $index6_banners[] = $val;
                }
                elseif ($val['type'] == 'index8')
                {
                    $index8_banners[] = $val;
                }
                elseif ($val['type'] == 'index12')
                {
                    $index12_banners[] = $val;
                }
                // elseif ($val['type'] == 'newindex')
                // {
                //     $newindex_banners[] = $val;
                // }
                elseif ($val['type'] == 'phone')
                {
                    $phone_banners[] = $val;
                }
                elseif ($val['type'] == 'phonecatalog')
                {
                    $phonecatalog_banners[] = $val;
                }
            }

            $buyers_sku = array();
            // var_dump($banners);die;
            $this->template->content = View::factory('/index')
                ->set('banners', $banners)
                ->set('index_banners', $index_banners)
                ->set('index1_banners', $index1_banners)
                ->set('index6_banners', $index6_banners)
                ->set('index8_banners', $index8_banners)
                ->set('index12_banners', $index12_banners)
                ->set('newindex_banners', $newindex_banners)
                ->set('phone_banners', $phone_banners)
                ->set('phonecatalog_banners', $phonecatalog_banners)
                ->set('index_close_show',$index_close_show)
                ->set('buyers_sku', $buyers_sku)
                ->set('is_mobile', $this->is_mobile)
                ->set('user_device', $this->user_device);
            $this->template->type = 'home';
            Cache::instance('memcache')->set($cache_key, $this->template, 3600);
        }
    }

    public function action_catalog()
    {
        $link = $this->request->param('id');
        if(strpos($link, '-c-') === False AND $link != 'daily-new')
        {
            $catalog = ORM::factory('catalog')
                ->where('link', '=', $link)
                ->where('visibility', '=', 1)
                ->find();
            $this->request->redirect(LANGPATH . '/' . $link . '-c-' . $catalog->id);
        }
        if($this->request->param('link') == 'all' AND $this->request->param('price') == 'all' AND !$this->request->param('filter'))
        {
            $this->request->redirect(LANGPATH . '/' . $link);
        }
        elseif($this->request->param('link') == 'all' AND !$this->request->param('price'))
        {
            $this->request->redirect(LANGPATH . '/' . $link);
        }
        $gets = array(
            'page' => (int) Arr::get($_GET, 'page', 0),
            'limit' => (int) Arr::get($_GET, 'limit', 0),
            'sort' => (int) Arr::get($_GET, 'sort', 0),
            'pick' => (int) Arr::get($_GET, 'pick', 0),
        );

        if(isset($_GET['currency'])){
            $currency = strtoupper(trim($_GET['currency']));
            if(Site::instance()->get('currency') != '' AND
             array_search($currency, explode(',', Site::instance()->get('currency'))) !== FALSE){
                Site::instance()->currency_set($currency);
            }
        }

        // is_mobile add mobile_key --- sjm 2015-12-15
        $mobile_key = $this->is_mobile ? 'mobile_' : '';

        $cache_key = $mobile_key . "catalog_new_" . Request::instance()->uri() . '_' . implode('_', $gets)  . "_" . LANGUAGE;
        $cache_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_key);
        $cache_content = Cache::instance('memcache')->get($cache_key);

        if(strlen($cache_content) > 100 AND !isset($_GET['cache']))
        {
            $this->template = $cache_content;
        }
        else
        {
            if(strpos($link, '-c-') !== False)
            {
                $linkArr = explode('-c-', $link);
                $cid = $linkArr[1];
                $catalog = ORM::factory('catalog')
                    ->where('id', '=', $cid)
                    ->where('visibility', '=', 1)
                    ->find();
            }
            else
            {
                 $catalog = ORM::factory('catalog')
                    ->where('link', '=', $link)
                    ->where('visibility', '=', 1)
                    ->find();
            }


            // 2-15  分类最新产品修改成按周  ---wkf
            $uri1 = $this->request->uri();
            if(strpos($uri1,"week1") || strpos($uri1,"week2") || strpos($uri1,"month")){
                
            }else if (!$catalog->loaded()){
                header('HTTP/1.1 301 Moved Permanently');//发出301头部 
                header('Location:'.BASEURL);
                die;
            }

                $custom_filter = array();
                $catalog = Catalog::instance($catalog->id,LANGUAGE);
                $crumbs = $catalog->crumbs();
                $cid = (int) Arr::get($_GET, 'cid', 0);
                if ($cid)
                {
                    Site::instance()->add_flow($cid, 'catalog', $catalog->get('name'));
                }

                $catalog_link = $catalog->get('link');
                $products = array();
                //产品排序
                if ($catalog_link == 'daily-new')
                {
                    $is_daily_new = 1; //判断是否为新品，新品不用ES
                    $sort_key = (int) Arr::get($_GET, 'sort', 0);
                    $sorts = Kohana::config('catalog.sorts');
                    $sortcolor = Kohana::config('catalog.colors');
                    if (isset($_GET['pick']))
                    {
                        $orderby = 'has_pick';
                        $queue = 'desc';
                    }
                    else
                    {
                        if ($crumbs[0]['name'] == 'Outlet' OR $catalog_link == 'fake-cc-sweatshirt')
                        {
                            $best_sellers = $sorts[1];
                            $sorts[1] = $sorts[2];
                            $sorts[2] = $best_sellers;
                        }
                        elseif ($catalog_link == 'wigs')
                        {
                            $sorts[1] = array('name' => " ", 'field' => 'created', 'queue' => 'ASC');
                        }
                        $orderby = $sorts[$sort_key]['field'];
                        $queue = $sorts[$sort_key]['queue'];
                    }

                    $uriArr=array();
                    $uri = $this->request->uri();
                    $uriArr = explode('/', $uri);
                    if(empty($uriArr[2]))
                    {
                        $uriArr[2] = 'week2';
                    }
                    
                    $allowarr = array("week1","week2","month");
                    if(!in_array($uriArr[2],$allowarr) || isset($uriArr[3])){
                        Site::add_404_log();
                        Request::Instance()->redirect(LANGPATH.'/404');
                    }

                    if($uriArr[2]=='week1')
                    {
                        $to = strtotime("-7 day");;
                        $from = strtotime('-14 day');
                    }
                    elseif($uriArr[2]=='week2')
                    {
                        $to = time();
                        $from = strtotime("-7 day");
                    }
                    elseif($uriArr[2]=='month')
                    {
                        $to = strtotime('-14 day');
                        $from = strtotime('-30 day');
                    }
                    
                    //产品过滤
                    $sql = '';
                    $join_sql = '';
                    $join_key = 0;
                    $paramprice = $this->request->param('price');
                    $priceFilter = explode('-', $paramprice);
                    if (isset($priceFilter[0]) AND isset($priceFilter[1]))
                    {
                        $pricefrom = (int) $priceFilter[0];
                        $priceto = (int) $priceFilter[1];
                        $custom_filter['price_range'][] = $pricefrom;
                        $custom_filter['price_range'][] = $priceto;
                    }
                    $filter = $this->request->param('filter');
                    $matchsql = array();
                    if($filter)
                    {
                        $custom_filter['filter_attirbutes'] = array();
                        $filters = explode('__', $filter);
                        foreach ($filters as $f)
                        {
                            $f = mysql_real_escape_string($f);
                            $fil = explode('_', $f);
                                if(isset($fil[1]))
                                {
                                    $fil[1] = strtolower($fil[1]);
                                    if(!is_numeric($fil[1]))
                                    {
                                        $label = str_replace(' ', '-', $fil[1]);
                                        $attr_id = DB::select('id')->from('attributes')->where('label', '=', $label)->execute()->get('id');
                                        $fil[1] = (int) $attr_id;
                                    }
                                    $custom_filter['filter_attirbutes'][] = $fil[1];
                                    $join_key ++;
                                    $join_sql .= " INNER JOIN  `product_attribute_values` a$join_key ON ( p.`id` = a$join_key.`product_id` ) ";
                                    $matchsql[] = "a$join_key.`attribute_id` IN ( $fil[1] )";
                                }
                        }
                        $sql .= " AND (" . implode(' ', $matchsql) . ") ";
                    }
                    
                    //新品总数sql查询
                    $count_products = DB::query(Database::SELECT, 'SELECT COUNT(p.id) as count FROM products_product p ' . $join_sql . ' WHERE p.visibility = 1 AND p.status=1 AND p.stock <> 0 AND p.display_date >= ' . $from . ' AND p.display_date < ' . $to . $sql)
                            ->execute()->get('count');

                    //产品显示个数
                    $limit_key = (int) Arr::get($_GET, 'limit', 3);
                    $limits = Kohana::config('catalog.limits');
                    $limit = $limits[$limit_key];

                    $pagination = Pagination::factory(array(
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items' => $count_products,
                        'items_per_page' => $limit,
                        'view' => LANGPATH.'/pagination_r'));
                    $pagination_fr = $pagination->render();

                    //新品sql查询
                    $new_range = ' limit ' . $pagination->offset . ',' . $pagination->items_per_page;
                    $all_products3 = DB::query(Database::SELECT, 'SELECT p.id FROM products_product p ' . $join_sql . ' WHERE p.visibility = 1 AND p.status=1 AND p.stock <> 0 AND p.display_date >= ' . $from . ' AND p.display_date < ' . $to . $sql . ' ORDER BY p.display_date DESC, ' . $orderby . ' ' . $queue . ', id DESC ' . $new_range)->execute()->as_array();

                    foreach ($all_products3 as $product)
                    {
                        $products[] = $product['id'];
                    }
                }
                else
                {
                    $is_daily_new = 0;
                    $pagination_fr = '';
                }


                
                
                if(isset($pricefrom) AND isset($priceto))
                {
                    $custom_filter['price_range'][0] = $pricefrom;
                    $custom_filter['price_range'][1] = $priceto;
                }

                $customer_id = Customer::logged_in();
                //Same Paragraph
                $flash_sale_key = 'flash_sales_products';
                if (!$flash_sales = Cache::instance('memcache')->get($flash_sale_key))
                {
                    $flash_sales = array();
                    $flashs = DB::select('product_id')->from('carts_spromotions')->where('type', '=', 6)->where('expired', '>', time())->execute()->as_array();
                    foreach($flashs as $flash)
                    {
                        $flash_sales[] = $flash['product_id'];
                    }
                    Cache::instance('memcache')->set($flash_sale_key, $flash_sales, 7200);
                }

                $mata_title = array();

                if ($catalog_link == 'weekly-new' OR $catalog_link == 'daily-new')
                {
                    $template = DB::select('meta_title', 'meta_keywords', 'meta_description')->from('products_category')
                        ->where('link', '=', 'new-in')
                        ->execute()
                        ->current();
                    if(LANGUAGE)
                    {
                        $template = Site::transCategory(LANGUAGE,$catalog->get('id'));
                    }

                    $this->template->title = implode(' ', $mata_title) . ' ' . $template['meta_title'];
                    $this->template->keywords = $template['meta_keywords'];
                    $this->template->description = $template['meta_description'];
                }
                else
                {
                    //分类页title随筛选改变
                    $title_filter=array();
                    $title_filters="";
                    if(isset($custom_filters['color'])){
                        $title_filter[]=DB::select('name')->from('attributes')->where('id', '=', $custom_filters['color'])->execute()->get('name');
                    }
                    if(isset($custom_filters['Material'])){
                        $title_filter[]=DB::select('name')->from('attributes')->where('id', '=', $custom_filters['Material'])->execute()->get('name');
                    }
                    $meta_title = $catalog->get('meta_title');
                    $meta_keywords = $catalog->get('meta_keywords');
                    $meta_description = $catalog->get('meta_description');
                    if(LANGUAGE)
                    {
                        $template = Site::transCategory(LANGUAGE,$catalog->get('id'));
                        $meta_title = $template['meta_title'];
                        $meta_keywords = $template['meta_keywords'];
                        $meta_description = $template['meta_description'];
                    }
                    $title_filters=implode(" ", $title_filter);
                    $this->template->title = $title_filters.implode(' ', $mata_title) . ' ' . $meta_title;
                    $this->template->keywords = $meta_keywords;
                    $this->template->description = $meta_description;
                }

                if(isset($crumbs[0]['id']) && $crumbs[0]['id'] == 53)
                    $is_shoes = 1;
                else
                    $is_shoes = 0;

                $sort_key = (int) Arr::get($_GET, 'sort', 0);
                $sorts = Kohana::config('catalog.sorts');
                $sortcolor = Kohana::config('catalog.colors');

                $limit_key = (int) Arr::get($_GET, 'limit', 3);
                $limits = Kohana::config('catalog.limits');
                $limit = $limits[$limit_key];

                $filter = array();
                $filter['size'] = $this->request->param('link');
                $filter['price'] = $this->request->param('price');
                $filter['color'] = $this->request->param('filter');


                $usdarr = array('usd2'=>array('$1.9','usd2'),'usd-9'=>array('$9.9','usd-9'),'usd-13'=>array('$13.9','usd-13'),'usd-16'=>array('$16.9','usd-16'),'usd20'=>array('$19.9','usd20'),'usd30'=>array('$29.9','usd30'));

                $tearr = array('rompers-playsuits');
                //小语种分类名翻译
                if(!empty(LANGUAGE) and LANGUAGE!= 'en')
                {
                    foreach ($crumbs as $key => $v)
                    {
                        $data = site::transCategory(LANGUAGE,$v['id']);
                        $crumbs[$key]['name'] = $data['name'];
                    }
                }
                $bannermap = array('summer-pretty-sale','kimonos-croptops','midi-skirt');
                $show_ship_tip = 1;
                $this->template->type = 'category';
                $this->template->content = View::factory('/catalog_1')
                    ->set('usdarr',$usdarr)
                    ->set('bannermap',$bannermap)
                    ->set('catalog', $catalog)
                    ->set('crumbs', $crumbs)
                    ->set('products', $products)
                    ->set('sorts', $sorts)
                    ->set('sortcolor', $sortcolor)
                    ->set('sort_now', $sort_key)
                    ->set('limit', $limit)
                    ->set('custom_filter', $custom_filter)
                    ->set('now_filters', $filter)
                    ->set('customer_id', $customer_id)
                    ->set('flash_sales', $flash_sales)
                    ->set('pagination', $pagination_fr)
                    ->set('show_ship_tip', $show_ship_tip)
                    ->set('is_mobile', $this->is_mobile)
                    ->set('is_shoes', $is_shoes)
                    ->set('is_daily_new', $is_daily_new);

            Cache::instance('memcache')->set($cache_key, $this->template, 7200);
        }
    }
    
    /* small language catalog action */
    public function action_catalog1()
    {
        // if (Arr::get($_SERVER, 'HTTPS', 'off') == 'on')
        // {
        //     $redirects = isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : '';
        //     Request::Instance()->redirect(URL::site(Request::Instance()->uri . $redirects, 'https'));
        // }
        $link = $this->request->param('id');
        if(strpos($link, '-c-') === False AND $link != 'daily-new')
        {
            $catalog = ORM::factory('catalog')
                ->where('link', '=', $link)
                // ->where('site_id', '=', $this->site_id)
                ->where('visibility', '=', 1)
                ->find();
            $this->request->redirect(LANGPATH . '/' . $link . '-c-' . $catalog->id);
        }
        if($this->request->param('link') == 'all' AND $this->request->param('price') == 'all' AND !$this->request->param('filter'))
        {
            $this->request->redirect(LANGPATH . '/' . $link);
        }
        elseif($this->request->param('link') == 'all' AND !$this->request->param('price'))
        {
            $this->request->redirect(LANGPATH . '/' . $link);
        }
        $gets = array(
            'page' => (int) Arr::get($_GET, 'page', 0),
            'limit' => (int) Arr::get($_GET, 'limit', 0),
            'sort' => (int) Arr::get($_GET, 'sort', 0),
            'pick' => (int) Arr::get($_GET, 'pick', 0),
        );

        if(isset($_GET['currency'])){
            $currency = strtoupper(trim($_GET['currency']));
            if(Site::instance()->get('currency') != '' AND
             array_search($currency, explode(',', Site::instance()->get('currency'))) !== FALSE){
                Site::instance()->currency_set($currency);
            }
        }

        $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
        $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
        $country_area = 'EUR';
        if($country_code == 'US')
        {
            $country_area = 'US';
        }
        elseif($country_code == 'GB' OR $country_code == 'UK')
        {
            $country_area = 'UK';
        }

        // is_mobile add mobile_key --- sjm 2015-12-15
        $mobile_key = $this->is_mobile ? 'mobile_' : '';

        $cache_key = $mobile_key . "catalog_new_" . Request::instance()->uri() . '_' . implode('_', $gets)  . "_" . $country_area;
        $cache_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_key);
        $cache_content = Cache::instance('memcache')->get($cache_key);

        if (strlen($cache_content) > 100 AND !isset($_GET['cache']))
        {
            $this->template = $cache_content;
        }
        else
        {
            if(strpos($link, '-c-') !== False)
            {
                $linkArr = explode('-c-', $link);
                $cid = $linkArr[1];
                $catalog = ORM::factory('catalog')
                    ->where('id', '=', $cid)
                    // ->where('site_id', '=', $this->site_id)
                    ->where('visibility', '=', 1)
                    ->find();
            }
            else
            {
                 $catalog = ORM::factory('catalog' )
                    ->where('link', '=', $link)
                    // ->where('site_id', '=', $this->site_id)
                    ->where('visibility', '=', 1)
                    ->find();
            }
            $editor_pick = ORM::factory('catalog')
                // ->where('site_id', '=', $this->site_id)
                ->where('link', '=', 'editor-s-pick')
                ->find();


            // 2-15  分类最新产品修改成按周  ---wkf
            $uriArr1=array();
            $uri1 = $this->request->uri();
            if(strpos($uri1,"week1") || strpos($uri1,"week2") || strpos($uri1,"month")){
                
            }else if (!$catalog->loaded()){
                $the_url = isset($_SERVER['HTTP_HOST']) ? 'https://'.$_SERVER['HTTP_HOST'] : BASEURL . '/';
                $the_url1 = $the_url.LANGPATH;
                header('HTTP/1.1 301 Moved Permanently');//发出301头部 
                header('Location:'.$the_url1);
                die;
            }

            $custom_filter = array();
            if ($catalog->parent_id == $editor_pick->id)
            {
                $this->template->content = View::factory( '/activity/' . $catalog->link)->set('catalog', Catalog::instance($catalog->id));
            }
            else
            {
                $catalog = Catalog::instance($catalog->id, LANGUAGE);
                $crumbs = $catalog->crumbs();
                $cid = (int) Arr::get($_GET, 'cid', 0);
                if ($cid)
                {
                    Site::instance()->add_flow($cid, 'catalog', $catalog->get('name'));
                }

                $catalog_link = $catalog->get('link');
                $products = array();
                //产品排序
                if ($catalog_link == 'daily-new')
                {
                    $is_daily_new = 1; //判断是否为新品，新品不用ES
                    $sort_key = (int) Arr::get($_GET, 'sort', 0);
                    $sorts = Kohana::config('catalog.sorts');
                    $sortcolor = Kohana::config('catalog.colors');
                    if (isset($_GET['pick']))
                    {
                        $orderby = 'has_pick';
                        $queue = 'desc';
                    }
                    else
                    {
                        if ($crumbs[0]['name'] == 'Outlet' OR $catalog_link == 'fake-cc-sweatshirt')
                        {
                            $best_sellers = $sorts[1];
                            $sorts[1] = $sorts[2];
                            $sorts[2] = $best_sellers;
                        }
                        elseif ($catalog_link == 'wigs')
                        {
                            $sorts[1] = array('name' => " ", 'field' => 'created', 'queue' => 'ASC');
                        }
                        $orderby = $sorts[$sort_key]['field'];
                        $queue = $sorts[$sort_key]['queue'];
                    }
                
                    $uriArr=array();
                    $uri = $this->request->uri();
                    $uri = str_replace(LANGUAGE . '/', '', $uri);
                    $uriArr = explode('/', $uri);
                    if(empty($uriArr[1]))
                    {
                        Site::add_404_log();
                        $this->request->redirect(LANGPATH . '/404');
                    }
                    $today = strtotime('midnight') - 50400;
                    
                    $allowarr = array("week1","week2","month");
                    if(!in_array($uriArr[1],$allowarr) || isset($uriArr[2])){
                        Site::add_404_log();
                        Request::Instance()->redirect('404');
                    }

                    if($uriArr[1]=='week1')
                    {
                        if (!isset($uriArr[0]))
                            $to = $today + 86400;
                        else
                            $to = strtotime("-7 day");;
                        $from = strtotime('-14 day');
                    }
                    elseif($uriArr[1]=='week2')
                    {
                        $to = $today;
                        $from = strtotime("-7 day");
                    }
                    elseif($uriArr[1]=='month')
                    {
                        if (!isset($uriArr[0]))
                            $to = $today + 86400;
                        else
                            $to = strtotime('-14 day');
                        $from = strtotime('-30 day');
                    }
                    /*
                    $count_products = DB::query(Database::SELECT, 'SELECT COUNT(p.id) as count FROM products p ' . $join_sql . ' WHERE p.visibility = 1 AND p.status=1 AND p.stock <> 0 AND p.display_date >= ' . $from . ' AND p.display_date < ' . $to . $sql)
                             ->execute()->get('count');
                    $count_products = (int) $count_products;
                    */
                    
                    //产品过滤
                    $sql = '';
                    $join_sql = '';
                    $join_key = 0;
                    $paramprice = $this->request->param('price');
                    $priceFilter = explode('-', $paramprice);
                    if (isset($priceFilter[0]) AND isset($priceFilter[1]))
                    {
                        $pricefrom = (int) $priceFilter[0];
                        $priceto = (int) $priceFilter[1];
                        $custom_filter['price_range'][] = $pricefrom;
                        $custom_filter['price_range'][] = $priceto;
                    }
                    $filter = $this->request->param('filter');
                    $matchsql = array();
                    if($filter)
                    {
                        $custom_filter['filter_attirbutes'] = array();
                        $filters = explode('__', $filter);
                        foreach ($filters as $f)
                        {
                            $f = mysql_real_escape_string($f);
                            $fil = explode('_', $f);
                                if(isset($fil[1]))
                                {
                                    $fil[1] = strtolower($fil[1]);
                                    if(!is_numeric($fil[1]))
                                    {
                                        $label = str_replace(' ', '-', $fil[1]);
                                        $attr_id = DB::select('id')->from('attributes')->where('label', '=', $label)->execute()->get('id');
                                        $fil[1] = (int) $attr_id;
                                    }
                                    $custom_filter['filter_attirbutes'][] = $fil[1];
                                    $join_key ++;
                                    $join_sql .= " INNER JOIN  `product_attribute_values` a$join_key ON ( p.`id` = a$join_key.`product_id` ) ";
                                    $matchsql[] = "a$join_key.`attribute_id` IN ( $fil[1] )";
                                }
                        }
                        $sql .= " AND (" . implode(' ', $matchsql) . ") ";
                    }
                    
                    //catalog 1000
                    $cache_count_products_key = '56site_catalog_choies_newin' .LANGUAGE.'/'.$uriArr[1];
                    $cache_count_products_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_count_products_key);
                    $cache_count_products_value = Cache::instance('memcache')->get($cache_count_products_key);
                    if (isset($cache_count_products_value) AND !isset($_GET['cache']))
                    {
                        $count_products = $cache_count_products_value;
                    }
                    else
                    {
                        $catalog_instance = Catalog::instance($uriArr[1]);
                        //$postersql = $catalog_instance->getpostsql();
                        $count_products = DB::query(Database::SELECT, 'SELECT COUNT(p.id) as count FROM products p ' . $join_sql . ' WHERE p.visibility = 1 AND p.status=1 AND p.stock <> 0 AND p.display_date >= ' . $from . ' AND p.display_date < ' . $to . $sql)
                            ->execute()->get('count');

                        Cache::instance('memcache')->set($cache_count_products_key, $count_products, 3600);                            
                    }

                    //产品显示个数
                    $limit_key = (int) Arr::get($_GET, 'limit', 3);
                    $limits = Kohana::config('catalog.limits');
                    $limit = $limits[$limit_key];

                    $pagination = Pagination::factory(array(
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items' => $count_products,
                        'items_per_page' => $limit,
                        'view' => '/pagination_r'));
                    $pagination_fr = $pagination->render();
                    $uriArr=array();
                    $uri = $this->request->uri();
                    $uri = substr($uri, strpos($uri, '/') + 1);
                    $uriArr = explode('/', $uri);
                    $today = time();
                    
                    if(!isset($uriArr[1]))
                    {
                       $uriArr[1] = 'week2';
                    }

                    if($uriArr[1]=='week1')
                    {
                        if (!isset($uriArr[0]))
                            $to = $today + 86400;
                        else
                            $to = strtotime("-7 day");;
                        $from = strtotime('-14 day');
                    }
                    elseif($uriArr[1]=='week2')
                    {
                        $to = $today;
                        $from = strtotime("-7 day");
                    }
                    elseif($uriArr[1]=='month')
                    {
                        if (!isset($uriArr[0]))
                            $to = $today + 86400;
                        else
                            $to = strtotime('-14 day');
                        $from = strtotime('-30 day');
                    }

                    $new_range = ' limit ' . $pagination->offset . ',' . $pagination->items_per_page;

                    $cache_count_products1_key = 'site1_catalog_choies_newin' .LANGUAGE.'/'.$uriArr[1].$new_range;
                    $cache_count_products1_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_count_products1_key);
                    $cache_count_products1_value = Cache::instance('memcache')->get($cache_count_products1_key);
                    if (isset($cache_count_products1_value) AND !isset($_GET['cache']))
                    {
                        $all_products3 = $cache_count_products1_value;
                    }
                    else
                    {
                        //$catalog_instance = Catalog::instance($uriArr[0]);
                        $all_products3 = DB::query(Database::SELECT, 'SELECT p.id FROM products p ' . $join_sql . ' WHERE p.visibility = 1 AND p.status=1 AND p.stock <> 0 AND p.display_date >= ' . $from . ' AND p.display_date < ' . $to . $sql . ' ORDER BY p.display_date DESC, ' . $orderby . ' ' . $queue . ', id DESC ' . $new_range)
                            ->execute()->as_array();

                        Cache::instance('memcache')->set($cache_count_products1_key, $all_products3, 3600);                            
                    }

                    foreach ($all_products3 as $product)
                    {
                        $products[] = $product['id'];
                    }
                }
                else
                {
                    $is_daily_new = 0;
                    $pagination_fr = '';
                }

                $_top_sellers = array();
                $new_date = 0;
                if($link != 'daily-new' AND $link != 'top-sellers' AND $link != 'outlet')
                {
                    //top sellers
                    $_top_sellers = DB::select('product_id')->from('products_categoryproduct')->where('category_id', '=', 32)->execute()->as_array();
                    $new_date = 86400 * 14;
                }
                $top_sellers = array();
                $top = 0;
                
                $new_arrvals = array();
                $new = 0;
                
                
                if(isset($pricefrom) AND isset($priceto))
                {
                    $custom_filter['price_range'][0] = $pricefrom;
                    $custom_filter['price_range'][1] = $priceto;
                }

                $customer_id = Customer::logged_in();
                //Same Paragraph
                $flash_sale_key = 'flash_sales_products';
                if (!$flash_sales = Cache::instance('memcache')->get($flash_sale_key))
                {
                    $flash_sales = array();
                    $flashs = DB::select('product_id')->from('carts_spromotions')->where('type', '=', 6)->where('expired', '>', time())->execute()->as_array();
                    foreach($flashs as $flash)
                    {
                        $flash_sales[] = $flash['product_id'];
                    }
                    Cache::instance('memcache')->set($flash_sale_key, $flash_sales, 7200);
                }

                $mata_title = array();
                $children = array();
                $childrens = array();
                if ($catalog_link == 'weekly-new' OR $catalog_link == 'daily-new')
                {
                    $template = DB::select('meta_title', 'meta_keywords', 'meta_description')->from('products_category')->where('link', '=', 'new-in')->execute()->current();
                    $this->template->title = implode(' ', $mata_title) . ' ' . $template['meta_title'];
                    $this->template->keywords = $template['meta_keywords'];
                    $this->template->description = $template['meta_description'];
                }
                else
                {
                    //分类页title随筛选改变
                    $title_filter=array();
                    $title_filters="";
                    if(isset($custom_filters['color'])){
                        $title_filter[]=DB::select('name')->from('attributes')->where('id', '=', $custom_filters['color'])->execute()->get('name');
                    }
                    if(isset($custom_filters['Material'])){
                        $title_filter[]=DB::select('name')->from('attributes')->where('id', '=', $custom_filters['Material'])->execute()->get('name');
                    }
                    $title_filters=implode(" ", $title_filter);
                    $this->template->title = $title_filters.implode(' ', $mata_title) . ' ' . $catalog->get('meta_title');
                    $this->template->keywords = $catalog->get('meta_keywords');
                    $this->template->description = $catalog->get('meta_description');

                    $cata_id = $catalog->get('id');
                    $parent_id = DB::select('parent_id')->from('products_category')->where('id', '=', $cata_id)->execute('slave')->get('parent_id');
                    $children = DB::select('id', 'name', 'link')->from('products_category')
                            ->where('site_id', '=', 1)
                            ->where('visibility', '=', 1)
                            ->where('on_menu', '=', 1)
                            ->where('parent_id', '=', $cata_id)
                            ->order_by('position', 'desc')
                            ->execute('slave')->as_array();
                    if (empty($children))
                    {
                        if ($parent_id == 0)
                        {
                            $children[] = array(
                                'id' => $cata_id,
                                'name' => Catalog::instance($cata_id)->get('name'),
                                'link' => Catalog::instance($cata_id)->get('link')
                            );
                        }
                        else
                        {
                            $children = DB::select('id', 'name', 'link')->from('products_category')
                                    ->where('site_id', '=', 1)
                                    ->where('visibility', '=', 1)
                                    ->where('on_menu', '=', 1)
                                    ->where('parent_id', '=', $cata_id)
                                    ->order_by('position', 'desc')
                                    ->execute('slave')->as_array();
                            $parent[] = array(
                                'id' => $parent_id,
                                'name' => Catalog::instance($parent_id)->get('name'),
                                'link' => Catalog::instance($parent_id)->get('link')
                            );
                            $children = array_merge($parent, $children);
                        }
                    }
                    else
                    {
                        $parent[] = array(
                            'id' => $cata_id,
                            'name' => Catalog::instance($cata_id)->get('name'),
                            'link' => Catalog::instance($cata_id)->get('link')
                        );
                        $children = array_merge($parent, $children);
                    }
                }

                if(isset($crumbs[0]['id']) && $crumbs[0]['id'] == 53)
                    $is_shoes = 1;
                else
                    $is_shoes = 0;

                $sort_key = (int) Arr::get($_GET, 'sort', 0);
                $sorts = Kohana::config('catalog.sorts');
                $sortcolor = Kohana::config('catalog.colors');

                $limit_key = (int) Arr::get($_GET, 'limit', 3);
                $limits = Kohana::config('catalog.limits');
                $limit = $limits[$limit_key];

                $filter = array();
                $filter['size'] = $this->request->param('link');
                $filter['price'] = $this->request->param('price');
                $filter['color'] = $this->request->param('filter');


                $usdarr = array('usd2'=>array('$1.9','usd2'),'usd-9'=>array('$9.9','usd-9'),'usd-13'=>array('$13.9','usd-13'),'usd-16'=>array('$16.9','usd-16'),'usd20'=>array('$19.9','usd20'),'usd30'=>array('$29.9','usd30'));

                $tearr = array('rompers-playsuits');

                $bannermap = array('summer-pretty-sale','kimonos-croptops','midi-skirt');

                $repla = array();
                $newrepla = array();
                $newrepla['lang'] = '';
                $langs = array('de','fr');
                if(in_array(LANGUAGE,$langs))
                {
                    $lang = trim(LANGUAGE);
                    $trans_body_key = '6trans_body_catalog_'.LANGUAGE.$catalog->get('id');
                    $newrepla = Cache::instance('memcache')->get($trans_body_key);

                    if(!empty($newrepla) && count($newrepla)>10)
                    {
                        $newrepla = $newrepla;
                    }
                    else
                    {
                        if(!empty($children))
                        {
                            foreach($children as $c)
                            {
                                $repla[$c['name']] = $c['name'];
                            }
                        }

                        $repla1 = array(
                            'crumbs_first'=>'Home',
                            'crumbs_second'=>'crumbs_second',
                            'crumbs_third'=>'crumbs_third',
                            'crumbs_fourth'=>'catalog_name',
                            'crumbs_fifth'=>'price',
                            'crumbs_sixth'=>'Size',
                            'crumbs_seventh'=>'Size Guide',
                            'crumbs_eighth'=>"select size",
                            'crumbs_ninth'=>'Qty',
                            'crumbs_tenth'=>'ADD TO BAG',
                            'crumbs_eleventh'=>'wishlist',
                            'details_first'=>'details',
                            'details_second'=>'details_second',
                            'details_third'=>'details_third',
                            'details_fourth'=>'details_fourth',
                            'details_fifth'=>'details_fifth',
                            'details_sixth'=>'DELIVERY',
                            'footer_first'=>'You May Also Like',
                            'footer_second'=>'FLASH SALE',
                            'footer_third'=>'new in',
                            'footer_fourth'=>'top sellers',
                            'footer_fifth'=>'recently viewed',
                            'footer_ninth'=>'buys show',
                        );

                        $repla = array_merge($repla1,$repla);
                        $strepla = implode('+',$repla);

                        $words = Site::googletransapi($blank='en',$target=$lang,$strepla);
                        if($words != 1)
                        {
                            $words = json_decode($words);
                            $words = $words->data->translations[0]->translatedText;
                            $replarr = explode('+', $words);
                            $i = 0;

                            foreach($repla as $key => $value) 
                            {
                                if(isset($replarr[$i]))
                                {
                                    $newrepla[$key] = $replarr[$i];                         
                                }
                                else
                                {
                                    $newrepla[$key] = $value;                  
                                }
                                $i++;
                            }
                            $newrepla['lang'] = $lang;                          
                        }

                        if(!empty($newrepla) && count($newrepla)>10)
                        {
                            Cache::instance('memcache')->set($trans_body_key, $newrepla, 86400*20);                            
                        }

                    }
                }
                $show_ship_tip = 1;
                $this->template->type = 'category';
                $this->template->content = View::factory('/catalog_1')
                    ->set('usdarr',$usdarr)
                    ->set('bannermap',$bannermap)
                    ->set('catalog', $catalog)
                    ->set('crumbs', $crumbs)
                    ->set('products', $products)
                    ->set('sorts', $sorts)
                    ->set('sortcolor', $sortcolor)
                    ->set('sort_now', $sort_key)
                    ->set('limit', $limit)
                    ->set('custom_filter', $custom_filter)
                    ->set('now_filters', $filter)
                    ->set('customer_id', $customer_id)
                    ->set('flash_sales', $flash_sales)
                    ->set('pagination', $pagination_fr)
                    ->set('show_ship_tip', $show_ship_tip)
                    ->set('is_mobile', $this->is_mobile)
                    ->set('is_shoes', $is_shoes)
                    ->set('children', $children)
                    ->set('childrens', $childrens)
                    ->set('repla',$newrepla)
                    ->set('is_daily_new', $is_daily_new);
            }
            Cache::instance('memcache')->set($cache_key, $this->template, 7200);
        }
    }

    public function action_product()
    {

        $link = $this->request->param('id');

        if(isset($_GET['currency']))
        {
            $currency = strtoupper(trim($_GET['currency']));
            if(Site::instance()->get('currency') != '' AND array_search($currency, explode(',', Site::instance()->get('currency'))) !== FALSE)
            {
                Site::instance()->currency_set($currency);
                Cookie::set('cookie_currency',$currency,5184000);//60 days expire
            }
        }


        $change_countries = array('CA', 'AU');
        if (isset($_GET['url_from']))
        {
            $currency = substr($_GET['url_from'], 0, 2);
            if ($currency == 'UK')
                Site::instance()->currency_set('GBP');
            elseif (in_array($currency, $change_countries))
                Site::instance()->currency_set('USD');
        }

        $change_lang = array('de', 'fr');
        if (isset($_GET['lang']) && in_array($_GET['lang'],$change_lang))
        {
            $currency = $_GET['lang'];
            if($currency == 'de')
            {
                Cookie::set('cookie_currency','EUR',5184000);//60 days expire
            }
            elseif($currency == 'fr')
            {
                Cookie::set('cookie_currency','EUR',5184000);//60 days expire
            }
            else
            {
            }
        }

        //guo add for  ga  9.23
        $cid = (int) Arr::get($_GET, 'cid', 0);
        if($cid == '8331molly')
        {
           SetCookie('8331molly', 1, time()+ 24*3600, '/'); 
        }

        // is_mobile add mobile_key --- sjm 2015-12-15
        $mobile_key = $this->is_mobile ? 'mobile_' : '';

        $cache_key = $mobile_key . "products112_" . Request::instance()->uri() . "_" . $this->site_id;
        if (isset($_GET['lang']) && in_array($_GET['lang'],$change_lang))
        {
            $cache_key = $cache_key.'_'. $_GET['lang'];  
        }
        $cache_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_key);
        $cache_content = Cache::instance('memcache')->get($cache_key);

//        if (strlen($cache_content) > 100 AND !isset($_GET['cache']))
//        {
//            $this->template = $cache_content;
//        }
//        else
        {
            $product_id = 0;
            if(strpos($link, '_') !== FALSE)
            {
                $linkArr = explode('_', $link);
                $pid = $linkArr[count($linkArr) - 1];
                if(strpos($pid, 'p') !== FALSE)
                {
                    $product_id = (int) substr($pid, 1, strlen($pid) - 1);
                }
            }
            
            if($product_id)
            {
                $product =  DB::select()
                    ->from('products_product')
                    ->where('id', '=', $product_id)
//                    ->where('visibility', '=', 1)
                    ->where('deleted','=',0)
                    ->execute();
            }
            else
            {
                $product =  DB::select()
                    ->from('products_product')
                    ->where('link', '=', $link)
//                    ->where('visibility', '=', 1)
                    ->where('deleted','=',0)
                    ->execute();
            }
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            if (toolkit::is_our_url($referer))
            {
                $parse = parse_url($referer);
                $parsepath = isset($parse['path']) ? $parse['path'] : '';
                if($parsepath)
                {
                    $link = substr($parsepath, 1, strlen($parsepath));
                    $current_catalog = DB::select('id')->from('products_category')->where('link', '=', $link)->where('deleted','=',0)->execute()->get('id');
                }
                else
                {
                    $current_catalog = 0;              
                }

            }
            else
            {
                $current_catalog = 0;
            }
//            $product = Product::instance($product->get('id'),LANGUAGE);
            if (!$product->get('visibility'))
            {
                if($product_id)
                {
                    $pid = $product_id;
                }
                else
                {
                    $productinfo = DB::select('id')->from('products_product')->where('link', '=', $link)->where('deleted','=',0)->execute('slave')->current();
                    $pid = $productinfo['id'];
                }
                $product = Product::instance($pid,LANGUAGE);
                $current_catalog = $product->default_catalog();

                $the_url = BASEURL;
                if(!$current_catalog)
                {
                    $the_url1 = $the_url.LANGPATH;
                }
                else
                {
                    $relink = Catalog::instance($current_catalog)->permalink();
                    $the_url1 = $relink;
                }

                    header('HTTP/1.1 301 Moved Permanently');//发出301头部
                    header('Location:'.$the_url1);
                    die;
            }
            $product = Product::instance($product->get('id'),LANGUAGE);
            $status = $product->get('status');
             if ($cid)
             {
                 Site::instance()->add_flow($cid, 'product', $product->get('sku'));
             }


            //update click rate
           /*     DB::query(Database::UPDATE, 'UPDATE products SET clicks = clicks + 1 WHERE id = ' . $product->get('id'))->execute();*/
                $product->daily_clicks();
            $this->template->title = $product->get('name') . ' | ' . 'Choies';
            $this->template->keywords = $product->get('name');
            $this->template->description = 'Shop for  the ' . $product->get('name') . ' online now.Choies.com offer the latest fashion  women ' . Set::instance($product->get('set_id'))->get('name') . ' at cheap prices with free shipping.';

            $this->template->fb_sku = $product->get('id');
            $this->template->fb_catalog = $product->get('set_id');

            $celebrity_images = DB::select()->from('products_celebrityimages')->where('product_id', '=', $product->get('id'))->where('type','in',array(1,3))->where('deleted','=',0)->order_by('position')->execute()->as_array();
            $link_images = DB::select()->from('products_celebrityimages')->where('product_id', '=', $product->get('id'))->where('type','in',array(2,3))->where('deleted','=',0)->order_by('position')->execute()->as_array();
            //filter attributes
            $filter_sorts = $product->get_attr();
            if(isset($filter_sorts[0]) &&  $filter_sorts[0] == 1)
            {
                $filter_sorts = array();

            }
            if ($product->get('type') == 0)  //type 0 simple product
            {
                $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
                // 获取国家代码 
                $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);

                $attributes = $product->set_data();
                $color = $fabric = array();
                $fabricName = '';
                $size = array();
                $delivery_time = '';
                if (isset($attributes[3]))
                {
                    $fabricArr = kohana::config('prdress.fabric');
                    $fabricName = $attributes[3]['value'];
                    $fabriclink = str_replace(' ', '-', strtolower($attributes[3]['value']));
                    if($fabriclink)
                        $fabric = $fabricArr[$fabriclink];
                    $size = kohana::config('prdress.size');
                    $delivery_time = kohana::config('prdress.delivery_time');
                }
                $this->template->content = View::factory('/product_prdress')
                    ->set('product', $product)
                    ->set('current_catalog', $current_catalog)
                    ->set('fabric', $fabric)
                    ->set('fabricName', $fabricName)
                    ->set('size', $size)
                    ->set('delivery_time', $delivery_time)
                    ->set('celebrity_images', $celebrity_images)
                    ->set('country_code', $country_code)
                    ->set('filter_sorts', $filter_sorts);
            }
            elseif ($product->get('type') == 3)  //type 3 simple config product
            {
                $items= DB::select()->from('products_productitem')->where('product_id', '=', $product->get('id'))->order_by('sku')->execute('slave')->as_array();

                $item_status = array();
                $item_stock = array();
                if (!empty($items))
                {

                    foreach ($items as $item)
                    {
                        $item_status[$item['sku']] = $item['status'];
                        $item_stock[$item['sku']] = $item['stock'];
                    }
                    $item_size = $product->checkSize();
                }
                else
                {//没有数据，给默认值
                    $item_size = array('');
                }

                $product_id = $product->get('id');

                $related_products = array();
                $flash_sales = DB::query(Database::SELECT, 'SELECT c.product_id, s.price FROM products_categoryproduct c LEFT JOIN carts_spromotions s ON c.product_id=s.product_id
                    WHERE c.deleted = 0 AND s.deleted = 0 AND c.category_id = 290 AND s.type = 6 AND CAST(s.expired as SIGNED) - unix_timestamp() BETWEEN 50400 AND 691200 ORDER BY c.position DESC, s.expired LIMIT 0, 7')
                    ->execute()->as_array();
                if(empty($flash_sales))
                {
                    $related_products = Product::instance($product_id)->related_products();
                }


                if($product->get('brand_id'))
                {
                    $brand_id = $product->get('brand_id');
                    $brands = DB::select('id', 'name')->from('products_brands')->where('id', '=', $brand_id)->execute()->current();
                }
                else
                {
                    $brands = array();
                }

                $this->template->type = 'product';
                $this->template->og_image = Image::link($product->cover_image(), 1);

                //产品的tag
                $tags = $product->tags();

                //VIP TYPES 
                $vipconfig = Site::instance()->vipconfig();
                //胸衣产品id
                $bar_ids= array(
                    61062,61061,61060,61059,61058,61057,61079,61080,61077,61078,46943,46942,46941,46940,46939,46696,46695,46694,46693,46692,46691,46690,46689,40885,40884,40888,40887,40886
                );

                // vip spromotions memcache get --- sjm 2015-12-15          获取促销价     
                
                $vip_promotion_price = 0;
                $spromotion_key = 'spromotion121233_' . $product->get('id');
                $spromotion_data = Cache::instance('memcache')->get($spromotion_key);
                try 
                {
                    $spromotion_data = unserialize($spromotion_data);
                }
                catch (Exception $e)
                {
                }
                if(!empty($spromotion_data) && is_array($spromotion_data))
                {
                    foreach($spromotion_data as $s_type =>$s_data)
                    {
                        if(isset($s_type) && $s_type == 0 && $s_data['created'] < time() && $s_data['expired'] > time())
                        {
                            $vip_promotion_price = $s_data['price'];
                            break;
                        }
                    }
                }

                # 同款不同色
                $colorproduct = array();
                $color = DB::select()->from('products_colorproduct')->where('product_id','=',$product->get('id'))->execute('slave')->current();
                if($color)
                {
                    $colors = DB::select()->from('products_colorproduct')
                        ->where('group','=',$color['group'])
                        ->where('product_id','!=',$product->get('id'))
                        ->execute('slave')
                        ->as_array();
                    foreach ($colors as $value)
                    {
                        $checkProduct = Product::instance($value['product_id']);
                        $status = $checkProduct->get('status');
                        $visibility = $checkProduct->get('visibility');
                        if($status and $visibility)
                        {
                            $colorproduct[] = $value['product_id'];
                        }
                    }

                }

                $instock = $product->get('instock');

                $show_ship_tip = 1;
                $this->template->content = View::factory('/product')
                    ->set('tags',$tags)
                    ->set('vipconfig',$vipconfig)
                    ->set('bar_ids',$bar_ids)
                    ->set('product', $product)
                    ->set('current_catalog', $current_catalog)
                    ->set('celebrity_images', $celebrity_images)
                    ->set('link_images', $link_images)
                    ->set('stocks', $item_stock)//item库存
                    ->set('status', $status)//是否上架
                    ->set('instock', $instock)//是否有库存
                    ->set('item_status', $item_status)//item上下架
                    ->set('item_size', $item_size)//item上下架
                    ->set('filter_sorts', $filter_sorts)
                    ->set('flash_sales', $flash_sales)
                    ->set('related_products', $related_products)
                    ->set('brands', $brands)
                    ->set('show_ship_tip', $show_ship_tip)
                    ->set('vip_promotion_price', $vip_promotion_price)
                    ->set('colorproduct', $colorproduct)
                    ->set('is_mobile', $this->is_mobile);
            }

            Cache::instance('memcache')->set($cache_key, $this->template, 10);//7200
        }
    }

    /* small language product action */
    public function action_product1()
    {
        // if (Arr::get($_SERVER, 'HTTPS', 'off') == 'on')
        // {
        //     $redirects = isset($_GET['redirect']) ? '?redirect=' . $_GET['redirect'] : '';
        //     Request::Instance()->redirect(URL::site(Request::Instance()->uri . $redirects, 'https'));
        // }
        $link = $this->request->param('id');
        
        if(isset($_GET['currency'])){
            $currency = strtoupper(trim($_GET['currency']));
            if(Site::instance()->get('currency') != '' AND
             array_search($currency, explode(',', Site::instance()->get('currency'))) !== FALSE){
                Site::instance()->currency_set($currency);
                Cookie::set('cookie_currency',$currency,5184000);//60 days expire
            }
        }

        $change_countries = array('CA', 'AU');
        if (isset($_GET['url_from']))
        {
            $currency = substr($_GET['url_from'], 0, 2);
            if ($currency == 'UK')
                Site::instance()->currency_set('GBP');
            elseif (in_array($currency, $change_countries))
                Site::instance()->currency_set('USD');
        }

        //guo add for  ga  9.23
        $cid = (int) Arr::get($_GET, 'cid', 0);
        if($cid == '8331molly')
        {
           SetCookie('8331molly', 1, time()+ 24*3600, '/'); 
        }

        // is_mobile add mobile_key --- sjm 2015-12-15
        $mobile_key = $this->is_mobile ? 'mobile_' : '';

        $cache_key = $mobile_key . "products1_" . Request::instance()->uri() . "_" . $this->site_id;
        $cache_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_key);
        $cache_content = Cache::instance('memcache')->get($cache_key);
        if (strlen($cache_content) > 100 AND !isset($_GET['cache']))
        {
            $this->template = $cache_content;
        }
        else
        {   
            $product_id = 0;
            if(strpos($link, '_') !== FALSE)
            {
                $linkArr = explode('_', $link);
                $pid = $linkArr[count($linkArr) - 1];
                if(strpos($pid, 'p') !== FALSE)
                {
                    $product_id = (int) substr($pid, 1, strlen($pid) - 1);
                }
            }

            $has_des = 1;
            $prodes = '';
            
            if($product_id)
            {
                $product =DB::select()->from('products_product_' . $this->language)
                    ->where('id', '=', $product_id)
                    ->where('visibility', '=', 1)
                    ->where('deleted', '=', '0')
                    ->execute();
                if(empty($product->description)){
                    
                    $has_des = 0;
                    $pro = Product::instance($product_id,LANGUAGE);
                    $prodes = $pro->get('description');
                }
            }
            else
            {
                $product = DB::select()
                    ->from('products_product_' . $this->language)
                    ->where('link', '=', $link)
                    ->where('visibility', '=', 1)
                    ->where('deletted', '=', '0')
                    ->execute();
            }
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            if (toolkit::is_our_url($referer))
            {
                $parse = parse_url($referer);
                $link = substr($parse['path'], 1, strlen($parse['path']));
                $current_catalog = DB::select('id')->from('products_category')->where('link', '=', $link)->where('deleted','=',0)->execute()->get('id');
            }
            else
            {
                $current_catalog = 0;
            }


            if (!$product->get('status'))
            {
                $link = $this->request->param('id');
                if($product_id)
                {
                    $pid = $product_id;
                }
                else
                {
                    $productinfo = DB::select('id')->from('products_'.$this->language)->where('link', '=', $link)->where('site_id', '=', $this->site_id)->execute('slave')->current();
                    $pid = $productinfo['id'];
                }
                $product = Product::instance($pid,LANGUAGE);
                $current_catalog = $product->default_catalog();
                $the_url = BASEURL . '/';
                if(!$current_catalog)
                {
                    $the_url1 = $the_url.LANGPATH;
                }
                else
                {
                    $relink = Catalog::instance($current_catalog,$this->language)->permalink();
                    if($relink)
                    {
                        $the_url1 = $relink;
                    }
                    else
                    {
                        $the_url1 = $the_url.LANGPATH;
                    }               
                }

                    header('HTTP/1.1 301 Moved Permanently');//发出301头部 
                    header('Location:'.$the_url1);
                    die;
/*                Site::add_404_log();
                $this->request->redirect(LANGPATH . '/404');*/
            }

            Product::instance($product->get('id'))->set_view_history();

            if ($cid)
            {
                Site::instance()->add_flow($cid, 'product', $product->get('sku'));
            }
            //update click rate
//                DB::query(Database::UPDATE, 'UPDATE products SET clicks = clicks + 1 WHERE id = ' . $product->get('id'))->execute();
//                $product->daily_clicks();
            $this->template->title = $product->get('name') . ' | ' . 'Choies';
            $this->template->keywords = $product->get('name');
            //$this->template->description = 'Shop for the ' . $product->name . ' online now.Choies.com offer the latest fashion  women ' . Set::instance($product->set_id)->get('name') . ' at cheap prices with free shipping.';
            $setsLang = kohana::config('sets.'.LANGUAGE);
            $setlang=Set::instance($product->get('set_id'))->get('name');
            $setlangs = isset($setsLang[$setlang]) ? $setsLang[$setlang] : $setlang;
            if($setlangs)
            {
                if(LANGUAGE=='de'){
                    $this->template->description = 'Kaufen Sie ' . $product->get('name') . ' jetzt online. Choies.com bietet die neuesten Fashion Damen ' . $setlangs .' zu günstigen Preisen mit kostenlosem Versand.';
                }elseif(LANGUAGE=='es'){
                    $this->template->description = 'Compra ' . $product->get('name') . ' online ahora, choies.com ofrece ' . $setlangs . ' de la última moda de mujeres en precio bajo con envío gratis.';
                }elseif(LANGUAGE=='fr'){
                    $this->template->description = 'Achetez ' . $product->get('name') . ' maintenant en ligne, Choies.com offrir femmes les dernières ' . $setlangs . ' de la mode à bas prix avec livraison gratuite.';
                }elseif(LANGUAGE=='ru'){
                    $this->template->description = 'Продать для ' . $product->get('name') . ' онлайн now.Choies.com предложить последние модные женские ' . $setlangs . ' по низким ценам с бесплатной доставкой.';
                }
            }
            $this->template->fb_sku = $product->get('id');
            $this->template->fb_catalog = $product->get('set_id');

            $celebrity_images = DB::select()->from('products_celebrityimages')->where('product_id', '=', $product->get('id'))->where('type','in',array(1,3))->where('deleted','=',0)->order_by('position')->execute()->as_array();
            $link_images = DB::select()->from('products_celebrityimages')->where('product_id', '=', $product->get('id'))->where('type','in',array(2,3))->where('deleted','=',0)->order_by('position')->execute()->as_array();
            //filter attributes
            $filter_sorts = array();
            $small_filter = array();
            $filter_attributes = explode(';', $product->get("filter_attributes"));
//            //暂未修改
//            $filter_attributes = ORM::factory('attribute')->where('product_id','=',$product->get('id'))->find()->as_array();
            if (!empty($filter_attributes))
            {
                $filter_sqls = array();
                foreach ($filter_attributes as $key => $filter)
                {
                    if ($filter)
                        $filter_sqls[] = '"' . $filter . '"';
                    else
                        unset($filter_attributes[$key]);
                }
                $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM products_categorysorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                if (!empty($sorts))
                {
                    foreach ($sorts as $sort)
                    {
                        if(array_key_exists($sort['sort'], $filter_attributes))
                            continue;
                        $attr = '';
                        $attributes = explode(',', strtolower($sort['attributes']));
                        foreach($filter_attributes as $key => $attribute)
                        {
                            $attribute = strtolower($attribute);
                            if(in_array($attribute, $attributes))
                            {
                                $attr = $attribute;
                                unset($filter_attributes[$key]);
                                break;
                            }
                        }
                        if($attr)
                        {
                            $filter_sorts[strtoupper($sort['sort'])] = $attr;

                        }
                    }
                }
            }
            if ($product->get("type") == 0)  //type 0 simple product
            {
                // include the php script  
                $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
                // 获取国家代码 
                $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);

               // $attributes = Product::instance($product->get('id'))->set_data();
                $attributes= DB::select()->from('products_productattribute')->where('product_id', '=', $product->get('id'))->execute()->as_array();
                $color = $fabric = array();
                $fabricName = '';
                $size = array();
                $delivery_time = '';
                if (isset($attributes[3]))
                {
                    $fabricArr = kohana::config('prdress.fabric');
                    $fabricName = $attributes[3]['value'];
                    $fabriclink = str_replace(' ', '-', strtolower($attributes[3]['value']));
                    if($fabriclink)
                        $fabric = $fabricArr[$fabriclink];
                    $size = kohana::config('prdress.size');
                    $delivery_time = kohana::config('prdress.delivery_time');
                }
                $this->template->content = View::factory('/product_prdress')
                    ->set('product', $product)
                    ->set('has', $has_des)
                    ->set('prodes', $prodes)
                    ->set('current_catalog', $current_catalog)
                    ->set('fabric', $fabric)
                    ->set('fabricName', $fabricName)
                    ->set('size', $size)
                    ->set('delivery_time', $delivery_time)
                    ->set('celebrity_images', $celebrity_images)
                    ->set('country_code', $country_code)
                    ->set('filter_sorts', $filter_sorts);
                  //  ->set('small_filter', $small_filter);
            }
            elseif ($product->get("type") == 3)  //type 3 simple config product
            {
               // $attributes = unserialize($product->get('attributes'));
                $attributes= DB::select()->from('products_productattribute')->where('product_id', '=', $product->get('id'))->execute()->as_array();
                if (isset($attributes[0]['options']) )
                {
                    $one_size = 0;
                    $attr_sizes = $attributes[0]['options'];
                    $is = 0;                            
                        //判断attributes

                        if(strpos($attr_sizes, 'US') !== FALSE)
                        {
                            $is = 1;
                        }                       

                    if (count($attr_sizes) == 1 && isset($attr_sizes) && $attr_sizes == 'one size')
                        $one_size = 1;
                }
                $attSize = array();
                $attColor = array();
                if (!empty($attributes))
                {
                    if ($one_size)
                    {
                        $attSize[] = 'one size';
                    }
                    elseif ($is)
                    {
                        // include the php script  
                        $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
                        // 获取国家代码 
                        $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
                        if ($country_code == 'US')
                        {
                            $index = 0;
                            $country = 'US';
                        }
                        elseif ($country_code == 'GB' OR $country_code == 'UK')
                        {
                            $index = 1;
                            $country = 'UK';
                        }
                        else
                        {
//                                        $countries = $gi->GEOIP_COUNTRY_CODE_TO_NUMBER;
//                                        $continents = $gi->GEOIP_CONTINENT_CODES;
//                                        $continent = $continents[$countries[$country_code]];
                            $index = 2;
                            $country = '';
                        }
                        $attribute = explode(',', $attr_sizes);
                        $country="US";$index=0;
                        foreach($attribute as $v) {
                            $attri = explode('/', $v);
                            $attSize[] = $country . preg_replace('/[A-Z]+/i', '', $attri[$index]);
                        }
                    }
                    else
                    {
                        $attSize = $attr_sizes;
                    }
                }
                else
                {
                    $attSize[] = 'one size';
                }
                if (isset($attributes['Color']) OR isset($attributes['color']))
                {
                    $attColor = isset($attributes['Color']) ? $attributes['Color'] : $attributes['color'];
                }
                $attributess = array(
                    'size' => $attSize,
                    'color' => $attColor,
                    'type' => isset($attributes['Type']) ? $attributes['Type'] : array()
                );

                $product_id = $product->get('id');
            //    $videos = DB::select(DB::expr('DISTINCT url_add'))->from('review_media')->where('product_id', '=', $product_id)->execute()->as_array();

                $stocks = array();
                if($product->get('stock') == -1)
                {
                    if($product->get('set_id') == 2)
                    {
                        foreach($attSize as $size)
                        {
                            $stock = DB::select('stocks')->from('products_stocks')
                                ->where('product_id', '=', $product_id)
                                ->where('attributes', 'LIKE', '%' . $size . '%')
                                ->execute()->get('stocks');
                            if($stock > 0)
                                $stocks[$size] = $stock;
                        }
                    }
                    else
                    {
                        foreach($attSize as $size)
                        {
                            $stock = DB::select('stocks')->from('products_stocks')
                                ->where('product_id', '=', $product_id)
                                ->where('attributes', '=', $size)
                                ->execute()->get('stocks');
                            if($stock > 0)
                                $stocks[$size] = $stock;
                        }
                    }
                }

                $related_products = array();
               /* $flash_sales = DB::query(Database::SELECT, 'SELECT c.product_id, s.price FROM proudcts_categoryproduct c LEFT JOIN carts_spromotions s ON c.product_id=s.product_id
                    WHERE c.category_id = 290 AND s.type = 6 AND s.expired - unix_timestamp() BETWEEN 50400 AND 691200 WHERE deleted = 0 ORDER BY c.position DESC, s.expired LIMIT 0, 7')
                    ->execute()->as_array();*/
              /*  if(empty($flash_sales))
                {
                    $related_products = Product::instance($product_id)->related_products();
                }*/

             //   $set_brief = Set::instance($product->get('set_id'))->get('brief');
                $brand_id = Product::instance($product_id)->get('brand_id');
                if($brand_id)
                {
                    $brands = DB::select('id', 'name')->from('products_brands')->where('id', '=', $brand_id)->execute()->current();
                }
                else
                {
                    $brands = array();
                }

                $this->template->type = 'product';
            //    $this->template->og_image = Image::link(Product::instance($product->id)->cover_image(), 1);

                //产品的tag
                $tags = Product::instance($product->get('id'))->tags();

                //VIP TYPES 
                $vipconfig = Site::instance()->vipconfig();

                $product_ins = Product::instance($product->get('id'), LANGUAGE);

                // vip spromotions memcache get --- sjm 2015-12-15
                $vip_promotion_price = 0;
                $spromotion_key = 'spromotion_' . $product_ins->get('id');
                $spromotion_data = Cache::instance('memcache')->get($spromotion_key);
                try 
                {
                    $spromotion_data = unserialize($spromotion_data);
                }
                catch (Exception $e)
                {
                }
                if(!empty($spromotion_data) && is_array($spromotion_data))
                {
                    foreach($spromotion_data as $s_type => $s_data)
                    {
                        if($s_type == 0 && $s_data['created'] < time() && $s_data['expired'] > time())
                        {
                            $vip_promotion_price = $s_data['price'];
                            break;
                        }
                    }
                }

                $repla = array();
                $newrepla = array();
                $newrepla['lang'] = '';
                $langs = array('de','fr');
                if(in_array(LANGUAGE,$langs))
                {
                    $lang = trim(LANGUAGE);
                    $trans_body_key = 'trans_body_product_'.LANGUAGE.$product_ins->get('id');
                    $newrepla = Cache::instance('memcache')->get($trans_body_key);
                    if(!empty($newrepla) && count($newrepla)>10)
                    {
                        $newrepla = $newrepla;
                    }
                    else
                    {
                        //面包屑
                        if (!$current_catalog)
                            $current_catalog = $product_ins->default_catalog();

                        $cataname = Catalog::instance($current_catalog)->get("name");
                        $crumbs = Catalog::instance($current_catalog)->crumbs();

                        if(!empty($crumbs))
                        {
                            foreach($crumbs as $crumb)
                            {
                                $repla[$crumb['name']] = $crumb['name'];
                            }
                        }

                        //DETAIL
                        if(!empty($filter_sorts))
                        {
                            foreach($filter_sorts as $name => $sort)
                            {
                                $repla[$name]=$name;
                                $repla[$sort]=$sort;
                            }
                        }

                        //description brief
                        $repla['description'] = $product_ins->get('description');
                        $repla['brief'] = $product_ins->get('brief');

                        $repla1 = array(
                            'crumbs_first'=>'Home',
                            'crumbs_second'=>'crumbs_second',
                            'crumbs_third'=>'crumbs_third',
                            'crumbs_fourth'=>$product_ins->get('name'),
                            'crumbs_eleventh'=>'wishlist',
                            'details_first'=>'details',
                            'details_sixth'=>'DELIVERY',
                        );

                        $repla = array_merge($repla1,$repla);
                        $strepla = implode('+',$repla);

                        $words = Site::googletransapi($blank='en',$target=$lang,$strepla);
                        if($words != 1)
                        {
                            $words = json_decode($words);
                            $words = $words->data->translations[0]->translatedText;
                            $replarr = explode('+', $words);
                            $i = 0;

                            foreach($repla as $key => $value) 
                            {
                                if(isset($replarr[$i]))
                                {
                                    $newrepla[$key] = $replarr[$i];                         
                                }
                                else
                                {
                                    $newrepla[$key] = $value;                  
                                }
                                $i++;
                            }
                            $newrepla['lang'] = $lang;                          
                        }
                        if(!empty($newrepla) && count($newrepla)>10)
                        {
                            Cache::instance('memcache')->set($trans_body_key, $newrepla, 86400*20);                            
                        }
                    }
                    $this->template->head_footer = array();
                    $this->template->head_footer['head_first'] = $product_ins->transname();
                }

                
                $show_ship_tip = 1;
                $this->template->content = View::factory('/product')
                    ->set('product', $product)
                    ->set('tags',$tags)
                    ->set('vipconfig',$vipconfig)
                    ->set('product', $product_ins)
                    ->set('has', $has_des)
                    ->set('prodes', $prodes)
                    ->set('current_catalog', $current_catalog)
                    ->set('celebrity_images', $celebrity_images)
                    ->set('link_images', $link_images)
                    ->set('attributes', $attributess)
                    ->set('stocks', $stocks)
              //      ->set('videos', $videos)
                    ->set('filter_sorts', $filter_sorts)
                  //  ->set('small_filter', $small_filter)
                 //   ->set('reviews', $reviews)
                //    ->set('reviews_data', $reviews_data)
                 //   ->set('flash_sales', $flash_sales)
                 //   ->set('related_products', $related_products)
                    ->set('brands', $brands)
                    ->set('show_ship_tip', $show_ship_tip)
                    ->set('vip_promotion_price', $vip_promotion_price)
                    ->set('repla',$newrepla)
                    ->set('is_mobile', $this->is_mobile);
            }

            Cache::instance('memcache')->set($cache_key, $this->template, 7200);
        }
    }
    
    public function action_ajax_search()
    {
        $q = Arr::get($_GET, 'q', '');
        $q = trim(mysql_real_escape_string($q));
        if (!$q)
            return;

        $res = DB::select('words', 'amount')->from('searchwords1')->where('words', 'like', $q . '%')->where('amount', '>', 5)->order_by('amount', 'DESC')->limit(10)->execute();
        $result = array();
        if ($res)
        {
            foreach ($res as $val)
            {
                if (strpos(strtolower($val['words']), $q) !== false)
                {
                    array_push($result, array(
                        "name" => $val['words'],
                        "to" => $val['amount'],
                    ));
                }
            }
        }
        echo json_encode($result);
        exit;
    }

    public function action_search()
    {
        $q = $this->request->param('q');
        if ($q == '')
        {
            $this->request->redirect(LANGPATH . '/');
        }
        if (strlen($q) > 100)
        {
            $q = substr($q, 0, 100);
        }
        $q = str_replace(array('_', '%20'), ' ', $q);

        $catalog_join = '';
        $catalog_in = '';
        $catalog_id = (int) Arr::get($_GET, 'cataid', 0);
        if ($catalog_id)
        {
            //TODO check if it is a legal catalog for searching
            $catalog = Catalog::instance($catalog_id, $this->language);
            if ($catalog->get('id') AND $catalog->get('visibility'))
            {
                $posterity_ids = $catalog->posterity();
                $posterity_ids[] = $catalog_id;
                $posterity_sql = implode(',', $posterity_ids);
                $catalog_join = ' LEFT JOIN products_categoryproduct cp on (cp.product_id = p.id) ';
                $catalog_in = ' AND cp.category_id IN (' . $posterity_sql . ') ';
            }
        }

        //TODO 防注入
        $link = mysql_connect($_SERVER['COFREE_DB_HOST'], $_SERVER['COFREE_DB_USER'], $_SERVER['COFREE_DB_PASS']) OR die(mysql_error());
        $keywords = trim(mysql_real_escape_string($q));
        // echo $keywords;exit;
        $result = DB::query(DATABASE::SELECT, "SELECT id,amount FROM core_searchwords
            WHERE words='" . $keywords . "'")->execute()->current();
        if ($result['id'])
        {
            $amount = $result['amount'] + 1;
            DB::update('core_searchwords')->set(array('amount' => $amount))->where('id', '=', $result['id'])->execute();
        }
        else
        {
            DB::insert('core_searchwords', array('words', 'amount'))
                ->values(array($keywords, 1))
                ->execute();
        }

        //产品过滤
        $sql = '';
        $pricefrom = (int) Arr::get($_GET, 'pricefrom', 0);
        $priceto = (int) Arr::get($_GET, 'priceto', 0);
        if ($pricefrom AND $priceto)
        {
            $custom_filter['price_range'][0] = $pricefrom;
            $custom_filter['price_range'][1] = $priceto;
            $sql .= " AND p.price > " . $pricefrom . " AND p.price <= " . $priceto;
        }
        $color = (int) Arr::get($_GET, 'color', 0);
        if (isset($_GET['color']))
        {
            $filtercolors = Kohana::config('catalog.colors');
            $custom_filter['filter_attirbutes'][] = $filtercolors[$color];
            $sql .= " AND MATCH (p.filter_attributes) AGAINST ('\"" . $filtercolors[$color] . "\"' IN BOOLEAN MODE) ";
        }
        
/*        if(LANGUAGE != '')
        {
            $sql .= " AND p.status = 1 ";
        }*/

        $limit_key = (int) Arr::get($_GET, 'limit', 3);
        $limits = Kohana::config('catalog.limits');
        $limit = $limits[$limit_key];
        
        //language product table set
        $lang_table = $this->language ? '_' . $this->language : '';
        if($this->language)
        {
            $keywords = htmlentities($keywords);
        }
        
        if(strlen($keywords) == 2)
        {
            $result = DB::query(DATABASE::SELECT, "SELECT count(p.id) as num FROM products_product p " . $catalog_join . "
                WHERE name LIKE '%".$keywords."%' " . $sql . $catalog_in . "
                AND p.visibility = 1 AND p.status = 1")->execute()->current();
        }
        elseif(strlen($keywords) == 1)
        {
            // $result = DB::query(DATABASE::SELECT, "SELECT count(p.id) as num FROM products" . $lang_table . " p " . $catalog_join . "
            //     WHERE name LIKE '% ".$keywords." %' " . $sql . $catalog_in . "
            //     AND p.visibility = 1 AND p.site_id = " . $this->site_id)->execute()->current();
            $result['num'] = 0;
        }
        else
        {
            $result = DB::query(DATABASE::SELECT, "SELECT count(p.id) as num FROM products_product p " . $catalog_join . "
                WHERE MATCH (p.name,p.description,p.sku,p.keywords) AGAINST ('" . $keywords . "' IN BOOLEAN MODE) " . $sql . $catalog_in . "
                AND p.visibility = 1 AND p.status = 1")->execute()->current();
        }
        $count = $result['num'];

        $pagination = Pagination::factory(array(
            'current_page' => array('source' => 'query_string', 'key' => 'page'),
            'total_items' => $count,
            'items_per_page' => $limit,
            'view' => '/pagination_r'));

        //产品排序
        $sort_key = isset($_GET['sort']) ? $_GET['sort'] : 0;
        $sort_key = (int) $sort_key;
        $sorts = Kohana::config('catalog.sorts');
        $sortcolor = Kohana::config('catalog.colors');
        if (!$sort_key)
        {
            $orderby = 'score';
            $queue = 'desc';
        }
        else
        {
            if (isset($_GET['pick']))
            {
                $orderby = 'p.has_pick';
                $queue = 'desc';
            }
            else
            {
                $orderby = 'p.' . $sorts[$sort_key]['field'];
                $queue = $sorts[$sort_key]['queue'];
            }
        }

        if(strlen($keywords) == 2)
        {
           $result = DB::query(DATABASE::SELECT, "SELECT p.id, p.visibility AS score FROM products_product p " . $catalog_join . "
                        WHERE p.name LIKE '%".$keywords."%'" . $sql . $catalog_in . "
                        AND p.visibility = 1 AND p.status = 1 ORDER BY p.status DESC,
                        " . $orderby . " " . $queue . ", p.id DESC limit " . $pagination->offset . "," . $pagination->items_per_page)
                ->execute();
        }
        elseif(strlen($keywords) == 1)
        {
            // $result = DB::query(DATABASE::SELECT, "SELECT p.id FROM products" . $lang_table . " p " . $catalog_join . "
            //             WHERE p.name LIKE '% ".$keywords." %'" . $sql . $catalog_in . "
            //             AND p.visibility = 1 AND p.site_id = " . $this->site_id . " ORDER BY p.status DESC,
            //             " . $orderby . " " . $queue . ", p.id DESC limit " . $pagination->offset . "," . $pagination->items_per_page)
            //     ->execute();
            $result = array();
        }
        else
        {
            $result = DB::query(DATABASE::SELECT, "SELECT p.id,MATCH(p.name,p.description,p.sku,p.keywords) AGAINST('" . $keywords . "') AS score FROM products_product p " . $catalog_join . "
                        WHERE MATCH (p.name,p.description,p.sku,p.keywords) AGAINST ('" . $keywords . "' IN BOOLEAN MODE) " . $sql . $catalog_in . "
                        AND p.visibility = 1 AND p.status = 1 ORDER BY p.status DESC,
                        " . $orderby . " " . $queue . ", p.id DESC limit " . $pagination->offset . "," . $pagination->items_per_page)
                ->execute();
        }

        $product_ids = array();
        foreach ($result as $item)
        {
            $product_ids[] = $item['id'];
        }

        $catalogs = ORM::factory('catalog')
            ->where('visibility', '=', 1)
            ->where('on_menu', '=', 1)
            ->where('parent_id', '=', 0)
            ->find_all();
        $show_ship_tip = 1;
        if($show_ship_tip)
        {
            $cache = Cache::instance('memcache');
            $ready_key = 'ready_shippeds';
            if(!$ready_shippeds = $cache->get($ready_key))
            {
                $ready_shippeds = DB::select('product_id')->from('products_categoryproduct')->where('category_id', '=', 395)->execute()->as_array();
                $cache->set($ready_key, $ready_shippeds, 86400);
            }
        }
        else
            $ready_shippeds = array();

        if($count > $limit)
        {
            $pagination_div = $pagination->render();
        }
        else
        {
            $pagination_div = '';
        }

        $this->template->title = 'Choies: Search For ' . $keywords;
        $this->template->content = View::factory('/search')
            ->set('keywords', $q)
            ->set('products', $product_ids)
            ->set('pagination', $pagination_div)
            ->set('catalogs', $catalogs)
            ->set('sorts', $sorts)
            ->set('sortcolor', $sortcolor)
            ->set('sort_now', $sort_key)
            ->set('show_ship_tip', $show_ship_tip)
            ->set('ready_shippeds', $ready_shippeds);
    }

    /* Elasticsearch --- sjm 2016-02-18 */
    public function action_search_es()
    {
        $q = $this->request->param('q');
        if ($q == '')
        {
            $this->request->redirect(LANGPATH . '/');
        }
        if (strlen($q) > 100)
        {
            $q = substr($q, 0, 100);
        }
        $q = str_replace(array('_', '%20'), ' ', $q);

        $catalog_join = '';
        $catalog_in = '';
        $catalog_id = (int) Arr::get($_GET, 'cataid', 0);
        if ($catalog_id)
        {
            //TODO check if it is a legal catalog for searching
            $catalog = Catalog::instance($catalog_id, $this->language);
            if ($catalog->get('id') AND $catalog->get('visibility'))
            {
                $posterity_ids = $catalog->posterity();
                $posterity_ids[] = $catalog_id;
                $posterity_sql = implode(',', $posterity_ids);
                $catalog_join = ' LEFT JOIN products_categoryproduct cp on (cp.product_id = p.id) ';
                $catalog_in = ' AND cp.catalog_id IN (' . $posterity_sql . ') ';
            }
        }

        //TODO 防注入
        $link = mysql_connect($_SERVER['COFREE_DB_HOST'], $_SERVER['COFREE_DB_USER'], $_SERVER['COFREE_DB_PASS']) OR die(mysql_error());
        $keywords = trim(mysql_real_escape_string($q));
        // echo $keywords;exit;
        $result = DB::query(DATABASE::SELECT, "SELECT id,amount FROM core_searchwords
            WHERE words='" . $keywords . "'")->execute()->current();
        if ($result['id'])
        {
            $amount = $result['amount'] + 1;
            DB::update('core_searchwords')->set(array('amount' => $amount))->where('id', '=', $result['id'])->execute();
        }
        else
        {
            DB::insert('core_searchwords', array('words','amount'))
                ->values(array($keywords, 1))
                ->execute();
        }

        //产品过滤
        $pricefrom = (int) Arr::get($_GET, 'pricefrom', 0);
        $priceto = (int) Arr::get($_GET, 'priceto', 0);
        if ($pricefrom AND $priceto)
        {
            $custom_filter['price_range'][0] = $pricefrom;
            $custom_filter['price_range'][1] = $priceto;
            $sql .= " AND p.price > " . $pricefrom . " AND p.price <= " . $priceto;
        }
        $filter = array(
            'term' => array(
                'visibility' => 1,
                'status' => 1,
            )
        );
        $color = (int) Arr::get($_GET, 'color', 0);
        if (isset($_GET['color']))
        {
            $filtercolors = Kohana::config('catalog.colors');
            $color_value = $filtercolors[$color];
            $filter['term']['color_value'] = strtolower($color_value);
        }
        
        /*if(LANGUAGE != '')
        {
            $sql .= " AND p.status = 1 ";
        }*/

        $limit_key = (int) Arr::get($_GET, 'limit', 3);
        $limits = Kohana::config('catalog.limits');
        $limit = $limits[$limit_key];
        
        //language product table set
        $lang_table = $this->language ? '_' . $this->language : '';
        if($this->language)
        {
            $keywords = htmlentities($keywords);
        }

        $elastic_type = 'product';
        $elastic_index = 'basic';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $sorts = array('id' => 'desc');

        $language_key = LANGUAGE ? '_' . LANGUAGE : '';
        $search_fields = array('name' . $language_key, 'sku', 'description' . $language_key, 'keywords' . $language_key);

        $counts = $elastic->search($keywords, $search_fields, 1, 0, $filter);
        if(isset($counts['hits']['total']))
        {
            $count = $counts['hits']['total'];
        }
        else
        {
            $count = 0;
        }
        $pagination = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items' => $count,
                'items_per_page' => $limit,
                'view' => '/pagination_r'));

        //产品排序
        $sort_key = isset($_GET['sort']) ? $_GET['sort'] : 0;
        $sort_key = (int) $sort_key;
        $sorts = Kohana::config('catalog.sorts');
        $sortcolor = Kohana::config('catalog.colors');
        $order_by = array();
        if (isset($_GET['pick']))
        {
            $order_by['has_pick'] = 'desc';
        }
        if($sort_key)
        {
            $order_by[$sorts[$sort_key]['field']] = $sorts[$sort_key]['queue'];
        }
        
        $search_res = $elastic->search($keywords, $search_fields, $pagination->items_per_page, $pagination->offset, $filter, $order_by);
        $product_ids = array();
        if(!empty($search_res['hits']['hits']))
        foreach ($search_res['hits']['hits'] as $item)
        {
            $product_ids[] = $item['_source']['id'];
        }

        $catalogs = ORM::factory('catalog')
            ->where('visibility', '=', 1)
            ->where('on_menu', '=', 1)
            ->where('parent_id', '=', 0)
            ->find_all();
        $show_ship_tip = 1;
        if($show_ship_tip)
        {
            $cache = Cache::instance('memcache');
            $ready_key = 'ready_shippeds';
            if(!$ready_shippeds = $cache->get($ready_key))
            {
                $ready_shippeds = DB::select('product_id')->from('products_categoryproduct')->where('category_id', '=', 395)->execute()->as_array();
                $cache->set($ready_key, $ready_shippeds, 86400);
            }
        }
        else
            $ready_shippeds = array();

        if($count > $limit)
        {
            $pagination_div = $pagination->render();
        }
        else
        {
            $pagination_div = '';
        }
    
        $this->template->title = 'Choies: Search For ' . $keywords;
        $this->template->content = View::factory('/search')
            ->set('keywords', $q)
            ->set('products', $product_ids)
            ->set('pagination', $pagination_div)
            ->set('catalogs', $catalogs)
            ->set('sorts', $sorts)
            ->set('sortcolor', $sortcolor)
            ->set('sort_now', $sort_key)
            ->set('show_ship_tip', $show_ship_tip)
            ->set('ready_shippeds', $ready_shippeds);
    }

    public function action_sitemap()
    {
        //TODO
        $this->request->response = '';
    }

    public function action_doc()
    {
        $link = $this->request->param('link');
        // echo $link;die;
        try
        {
/*            $tstr = strtotime('midnight');
            $tstr1 = $tstr + 24 * 3600;
            $timeout = $tstr1 - time();

            $ip = self::get_client_ip();

           // $result = 0;
            $cacheins = Cache::instance('memcache');
            $cache_key = 'site_doc_choies' . $ip;
            $cache_content = $cacheins->get($cache_key);
            if($cache_content >=10){
                die;
            }
         //   echo $cache_content;
            if($cache_content){
                $val = $cache_content +1;
            }else{
                $val = 1;
            }

            $cacheins->set($cache_key, $val, $timeout);*/

            $doc = ORM::factory('doc')
                // ->where('site_id', '=', $this->site_id)
                ->where('link', '=', $link)
                ->find();
            $this->template->title = $doc->meta_title;
            $this->template->keywords = $doc->meta_keywords;
            $this->template->description = $doc->meta_description;

            if($this->language)
            {
                $result = DB::select()->from('banners_banner')
                    // ->where('site_id', '=', $this->site_id)
                    ->where('visibility', '=', 1)
                    ->where('type', '=', 'side')
                    ->where('lang', '=', $this->language)
                    ->order_by('position', 'ASC')
                    ->order_by('id', 'DESC')
                    ->execute()->as_array();
            }
            else
            {
                $result = DB::select()->from('banners_banner')
                    // ->where('site_id', '=', $this->site_id)
                    ->where('visibility', '=', 1)
                    ->where('type', '=', 'side')
                    ->where('lang', '=', '')
                    ->order_by('position', 'ASC')
                    ->order_by('id', 'DESC')
                    ->execute()->as_array();
            }

            $index_banners = array();
            foreach($result as $val)
            {
                $index_banners[] = $val;                
            }
            if ($doc->content == '')
            {
                if($link=='rate-order-win-100'){
                    $lang=LANGUAGE;
                    $seoinfo=array(
                            "de"=>array("title"=>"Rezensieren, um $100 zu Gewinnen"),
                            "es"=>array("title"=>"Calificalo para Ganar $100"),
                            "fr"=>array("title"=>"Noter et Gagner $100"),
                            "ru"=>array("title"=>"Ставки И Выиграть $100"),
                            );
                    if($lang!=""){
                        $this->template->title = $seoinfo[$lang]['title'];
                    }else{
                        $this->template->title = "Rate & Win $100";
                    }
                }
                $this->template->type = 'docpage';
                if (empty(LANGUAGE))
                {
                    $lang = 'en';
                }else{
                    $lang = LANGUAGE;
                }

                $this->template->content = View::factory('/doc/'.$lang .'/'. $link)->set('index_banners', $index_banners);
            }
            else
            {
                if (empty(LANGUAGE))
                {
                    $lang = 'en';
                }else{
                    $lang = LANGUAGE;
                }
                $replacement['site'] = str_replace('www.', '', Site::instance()->get('domain'));
                $replacement['email'] = Site::instance()->get('email');
                $replacement['ticket'] = Site::instance()->get('ticket_center');
                $data['name'] = $doc->name;
                $data['content'] = self::CompileTemplate($doc->content, $replacement);
                $template = View::factory('/doc/'.$lang.'/doc')
                    ->set('doc', $data)->set('index_banners', $index_banners);
                $this->template->type = 'docpage';
                $this->template->content = $template;
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            Site::add_404_log();
            $this->request->redirect(LANGPATH . '/404');
        }
    }

    public static  function get_client_ip() {
            $ip = $_SERVER['REMOTE_ADDR'];
            if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
                foreach ($matches[0] AS $xip) {
                    if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                        $ip = $xip;
                        break;
                    }
                }
            }
            return $ip;
        }
    public function action_docsend()
    {
        $maxsize = 2 * 1024 * 1024;
        $rela = array('gif','jpg','png','bmp','doc','xls','txt','rar','ppt','pdf');
        if($_POST){

            $istoo = Kohana_Cookie::get("docsend");
            if($istoo >=5){
                $this->request->redirect(LANGPATH . '/contact-us');
            }

                $username = strip_tags($_POST['name']);
                $email = $_POST['email'];   
             if($email == 'sample@email.tst'){
                   $this->request->redirect(LANGPATH . '/contact-us'); 
                }

                $qt = $_POST['qt'];  
                $lang = LANGUAGE;
                if($qt == 2){
                    $toemail = 'zoe@choies.com';      
                }elseif($qt == 4 and empty($lang)){
                      $toemail = 'tracking@choies.com';
                }elseif($qt ==5 and empty($lang)){
                      $toemail = 'complaint@choies.com';
                }else{
                    if($lang && $lang != 'de' && $lang != 'fr'){
                      $toemail = 'service_'.$lang.'@choies.com';  
                  }else{
                    $toemail = 'service@choies.com';
                  }
                }
                $order = Arr::get($_POST,'order',0);
                $order = strip_tags($order); 
                $message = strip_tags($_POST['message']);   
                $fileaname = '';   

            if($_FILES['btn_file']['error'] ==0){
                  $filename = $_FILES['btn_file']['name'];
                $info = pathinfo($filename);     
            if(!in_array($info['extension'],$rela)){
              message::set(__('file_not'),'error');
              $this->request->redirect(LANGPATH . '/contact-us');
                return false;
            }elseif($_FILES['btn_file']['size'] > $maxsize){
              message::set(__('file_not'),'error');
              $this->request->redirect(LANGPATH . '/contact-us');
                return false;
            }elseif($_FILES['btn_file']['error'] != 0){
              message::set(__('file_not'),'error');
              $this->request->redirect(LANGPATH . '/contact-us');
                return false;
            }  
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
          }     

            //设置截止时间
			$kai='';
			$session = Session::instance();
			if(!$session->get('docsend_end')){
				$session->set('docsend_end',time()+300);
			}
			if(!$session->get('docsend_sum')){
				$session->set('docsend_sum',0);
			}
			
			
			
			if(time()<$session->get('docsend_end')){
				$docsend_sum=$session->get('docsend_sum');
				$docsend_sum=$docsend_sum+1;
				$session->set('docsend_sum',$docsend_sum);
				if($session->get('docsend_sum')<3){
					$kai=1;
					}else{
						$kai=0;
						echo "<script>alert('Sorry but please submit no more than twice in an hour.');window.history.go(-1);</script>";
						exit;
					}
			}else{
				//过一个小时候客户又来提交
				$session->set('docsend_end',time()+300);
				$session->set('docsend_sum',1);
				$kai=1;
			}
			if($kai==1){
				$email_params = array(
					'username' => $username,
					'email' => $email,
					'order_num' => $order,
					'message' => $message,
					'fileaname' => $fileaname,
					'toemail' => $toemail,
				);
				Mail::Sendcontact($email_params['toemail'],$email_params);
				$tstr = strtotime('midnight');
				$tstr1 = $tstr + 24 * 3600;
				$timeout = $tstr1 - time();
				if($istoo){     
					$istoo += 1;
					SetCookie('docsend', $istoo, time()+ $timeout, '/');
				}else{
					SetCookie('docsend', 1, time()+ $timeout, '/');
				}
				message::set(__('file_ok'));
				$this->request->redirect(LANGPATH . '/contact-us');
			}else{
				echo "<script>alert('Sorry but please submit no more than twice in an hour.');window.history.go(-1);</script>";
				exit;
			}
        }else{
             $this->request->redirect(LANGPATH . '/contact-us');
        }
    }



    //for searching auto-complete
    public function action_keywords()
    {
        $keywords = Arr::get($_REQUEST, 'term', 0);
        //TODO check config: using autocomplete or not
        if (!$keywords)
        {
            exit;
        }

        //TODO optimize the result
        $catalog_keywords = DB::query(1, "SELECT id,name FROM catalogs WHERE name LIKE '%" . $keywords . "%' limit 0,10")->execute()->as_array('id', 'name');
        $product_keywords = DB::query(1, "SELECT id,name FROM products WHERE name LIKE '%" . $keywords . "%' limit 0,10")->execute()->as_array('id', 'name');

        $re = array();
        $cata_num = 0;

        if (count($catalog_keywords) + count($product_keywords) > 10)
        {
            if (count($product_keywords) < 5)
            {
                $cata_num = min(10 - count($product_keywords), count($catalog_keywords));
            }
            elseif (count($catalog_keywords) > 5)
            {
                $cata_num = 5;
            }
        }
        $cata_num = $cata_num ? $cata_num : count($catalog_keywords);
        $pro_num = min(10 - count($catalog_keywords), count($product_keywords));

        $re = array_merge(array_slice($catalog_keywords, 0, $cata_num), array_slice($product_keywords, 0, $pro_num));

        foreach ($re as $k => $v)
        {
            $re[$k] = htmlspecialchars_decode($v);
        }
        echo json_encode($re);
    }

    public function action_price()
    {
        $amount_left = (float) $_POST['amount_left'];
        $points = (int) $_POST['points'];

        $site = Site::instance();
        $amount_point = $site->price($points * 0.01, NULL, 'USD', $site->currency_get($site->default_currency()));
        $amount_left -= $amount_point;
        if ($amount_left < 0)
            $amount_left = 0;

        echo $site->price($amount_left, 'code_view');
        exit;
    }

    public function action_404()
    {
        $referer = (isset($_SERVER['HTTP_REFERER']) AND toolkit::is_our_url($_SERVER['HTTP_REFERER'])) ?
            $_SERVER['HTTP_REFERER'] : NULL;
        $this->request->status = 404;
        // $ip = ip2long($this->GetIP());
        // $code = DB::select('code')->from('carts_coupons')->where('ip', '=', $ip)->where('limit', '>', 0)->where('expired', '>', time())->execute()->get('code');
        // if(!$code)
        // {
        //     $max_id = DB::select(DB::expr('MAX(id) AS max_id'))->from('carts_coupons')->execute()->get('max_id');
        //     $max_id ++;
        //     $coupon_code = '40420OFF' . $max_id;
        //     $coupon = array(
        //         'site_id' => $this->site_id,
        //         'code' => $coupon_code,
        //         'value' => 20,
        //         'type' => 1,
        //         'limit' => 1,
        //         'used' => 0,
        //         'created' => time(),
        //         'expired' => time() + 30 * 86400,
        //         'ip' => $ip
        //     );
        //     $insert = DB::insert('carts_coupons', array_keys($coupon))->values($coupon)->execute();
        //     if ($insert)
        //         $code = $coupon_code;
        //     else
        //         $code = '';
        // }
        $code = '40420OFF';
        $this->template->type = '404page';
        $this->template->content = View::factory('404'.LANGPATH.'/404')
            ->set('referer', $referer)
            ->set('code', $code);
    }
    
    public function action_404_mail()
    {
        if($_POST)
        {
            $email = Arr::get($_POST, 'email', '');
            if(!$email OR !preg_match("/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i",$email))
            {
                Message::set(__('email_address_invalid'), 'error');
            }
            else
            {
                $code = Arr::get($_POST, 'code', '');
                if($code)
                {
                    $mail_params['email'] = $email;
                    $mail_params['coupon_code'] = $code;
                    $send = Mail::SendTemplateMail('404 CODE', $mail_params['email'], $mail_params);
                    if($send)
                    {
                        Message::set(__('have_submit'), 'success');
                    }
                }
            }
        }
        $this->request->redirect(LANGPATH . '/404');
    }

    protected static function CompileTemplate($template, $context)
    {
        $keys = array();
        foreach (array_keys($context) as $key)
            $keys[] = '{' . $key . '}';

        return str_replace($keys, array_values($context), $template);
    }    

    public function action_lookbook()
    {
        $id = $this->request->param('id');
        if ($id)
        {
            if (strpos($id, '-'))
            {
                $ids = explode('-', $id);
                $c_images = DB::select()->from('products_celebrityimages')->where('id', '=', $ids[0])->where('type','in',array(1,3))->execute()->current();
                if ($c_images)
                {
                    $count = DB::select(DB::expr('COUNT(*) AS count'))->from('celebrities_lookbook_reviews')->where('lookbook_id', '=', $ids[0])->and_where('types', '=', 1)->execute()->get('count');
                    $pagination = Pagination::factory(array(
                            'current_page' => array('source' => 'query_string', 'key' => 'page'),
                            'total_items' => $count,
                            'items_per_page' => 3,
                            'view' => '/pagination'));
                    $reviews = DB::select()->from('celebrities_lookbook_reviews')
                            ->where('lookbook_id', '=', $ids[0])
                            ->and_where('types', '=', 1)
                            ->order_by('id', 'desc')
                            ->limit($pagination->items_per_page)
                            ->offset($pagination->offset)
                            ->execute()->as_array();

                    if(!empty($reviews))
                    {
                        if(isset($reviews[0]['product_id']))
                        {

                            $pname = Product::instance($reviews[0]['product_id'])->get('name');                            
                        }
                        else
                        {
                            $pname = '';                            
                        }
                    }
                    else
                    {
                        $pname = '';
                    }
                    $this->template->title = "Looks of $pname | Choies Street Fashion";
                    $this->template->keywords = '';
                    $this->template->description = "It's amazing to see Stars with $pname in Choies. Come here to find the suitable one for you!";
                    $this->template->content = View::factory('/lookbooks_product1')
                        ->set('pagination', $pagination->render())
                        ->set('c_images', $c_images)
                        ->set('reviews', $reviews)
                        ->set('type', 1);
                }
                else
                {
                    Site::add_404_log();
                    $this->request->redirect('/404');
                }
            }
            else
            {
                //$lookbook = DB::select()->from('lookbooks')->where('id', '=', $id)->execute()->current();
                if (0)
                {
                    $count = DB::select(DB::expr('COUNT(*) AS count'))->from('celebrities_lookbook_reviews')->where('lookbook_id', '=', $id)->where('types', '=', 0)->execute()->get('count');
                    $pagination = Pagination::factory(array(
                            'current_page' => array('source' => 'query_string', 'key' => 'page'),
                            'total_items' => $count,
                            'items_per_page' => 3,
                            'view' => '/pagination'));
                    $reviews = DB::select()->from('celebrities_lookbook_reviews')
                            ->where('lookbook_id', '=', $id)
                            ->where('types', '=', 0)
                            ->order_by('id', 'desc')
                            ->limit($pagination->items_per_page)
                            ->offset($pagination->offset)
                            ->execute()->as_array();
                    $images = unserialize($lookbook['images']);
                    $pname = '';
                    foreach ($images as $pid => $image)
                    {
                        if ($pid == 'main')
                            continue;
                        $pname = Product::instance(Product::get_productId_by_sku($pid),LANGUAGE)->get('name');
                    }
                    $this->template->title = "Looks of $pname | Choies Street Fashion";
                    $this->template->keywords = '';
                    $this->template->description = "It's amazing to see Stars with $pname in Choies. Come here to find the suitable one for you!";
                    $this->template->content = View::factory('/lookbooks_product')
                        ->set('lookbook', $lookbook)
                        ->set('reviews', $reviews)
                        ->set('pagination', $pagination->render())
                        ->set('type', 0);
                }
                else
                {
                    Site::add_404_log();
                    $this->request->redirect(LANGPATH . '/404');
                }
            }
        }
        else
        {

        $gets = array(
            'page' => (int) Arr::get($_GET, 'page', 0),
        );
        $mobile_key = $this->is_mobile ? 'mobile_' : '';

        $cache_key = $mobile_key . "lookbook_new1_" . Request::instance()->uri() . '_' . implode('_', $gets);
        $cache_key = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $cache_key);
        $cache_content = Cache::instance('memcache')->get($cache_key);
            if (strlen($cache_content) > 100 AND !isset($_GET['cache']))
            {
                $this->template = $cache_content;
            }
            else
            {
                $count = DB::query(Database::SELECT, 'SELECT COUNT(DISTINCT product_id) AS count FROM products_celebrityimages WHERE type in (1,3) and is_show = 1')->execute()->get('count');
                
                    $pagination = Pagination::factory(array(
                            'current_page' => array('source' => 'query_string', 'key' => 'page'),
                            'total_items' => $count,
                            'items_per_page' => 32,
                            'view' => '/pagination_r'));      
            $c_images = DB::query(Database::SELECT, 'SELECT DISTINCT product_id FROM products_celebrityimages WHERE type in (1,3) and is_show = 1 ORDER BY id DESC LIMIT ' .$pagination->offset . ',' . $pagination->items_per_page)->execute()->as_array();
                
                        $arr = array();
                $customer_id = Customer::logged_in();
                foreach($c_images as $k=>$v){
            $c_images[$k]['wish'] = DB::query(Database::SELECT, 'SELECT count(product_id) as wish FROM accounts_wishlists WHERE product_id = '.$v['product_id'] . ' group by product_id')->execute()->current();
                    array_push($arr,$v['product_id']);
                }
                
             if($customer_id && count($arr) > 0){
                $wishlists = DB::select('product_id')->from('accounts_wishlists')->where('customer_id', '=', $customer_id)->where('product_id', 'IN', $arr)->execute()->as_array();
             }else{
                 $wishlists = array();
             }          

                
                $lookbooks = array();
                $arrays = array_merge($c_images, $lookbooks);

                 $lang=LANGUAGE;
                $seoinfo=array(
                        "de"=>array("title"=>"Lookbook"),
                        "es"=>array("title"=>"Lookbook"),
                        "fr"=>array("title"=>"Lookbook"),
                        "ru"=>array("title"=>"Лукбук"),
                        );
                if($lang!=""){
                    $this->template->title = $seoinfo[$lang]['title'];
                }else{
                    $this->template->title = "Lookbook";
                }
                $this->template->keywords = '';
                $this->template->description = "Choies show the most popular fashion Looks for users,it's a good way to follow Stars and find hot clothes easily.";
                $this->template->content = View::factory('/lookbooks_catalog')
                    ->set('lookbooks', $arrays)
                    ->set('wishlists', $wishlists)
                    ->set('pagination', $pagination->render())
                    ->set('count', $count);
                Cache::instance('memcache')->set($cache_key, $this->template, 7200);
            }
        }
    }

    public function action_lookbook_ajax()
    {
        if ($_POST)
        {
            $index = Arr::get($_POST, 'index', 0);
            $lang = Arr::get($_GET, 'lang', "");
            if (!$index)
                exit;
            $limit = $index * 20;
            $lookbookArr = array();
            $c_images = DB::query(Database::SELECT, 'SELECT DISTINCT product_id FROM celebrity_images WHERE type IN(1, 3) ORDER BY id DESC LIMIT ' . $limit . ', 20')->execute()->as_array();
            $j = 0;
            foreach ($c_images as $p)
            {
                if(Product::instance($p['product_id'])->get('set_id') == 502)
                    continue;
                $c = DB::select('id', 'image')->from('products_celebrityimages')->where('product_id', '=', $p['product_id'])->where('type','in',array(1,3))->order_by('position')->execute()->current();
                $lookbookArr[$j]['id'] = $c['id'] . '-' . '1';
                $lookbookArr[$j]['title'] = Product::instance($p['product_id'],$lang)->get('name');
                $lookbookArr[$j]['images'] = array(
                    'main' => $c['image']
                );
                $j++;
            }
//          $lookbooks = DB::query(Database::SELECT, 'SELECT id, title, images FROM lookbooks WHERE visibility=1  ORDER BY id DESC LIMIT ' . $limit . ', 20')->execute()->as_array();
//          $j = 0;
//          foreach($lookbooks as $lookbook)
//          {
//                  $lookbookArr[$j] = $lookbook;
//                  $lookbookArr[$j]['images'] = unserialize($lookbook['images']);
//                  $j++;
//          }
            echo json_encode($lookbookArr);
            exit;
        }
    }

    public function action_lookbook_review()
    {
        if ($_POST)
        {
            $data['lookbook_id'] = Arr::get($_POST, 'lookbook_id', 0);
            $data['user_id'] = Arr::get($_POST, 'customer_id', $customer_id = Customer::logged_in());
            $data['content'] = Security::xss_clean(Arr::get($_POST, 'content', ''));
            $data['star'] = Arr::get($_POST, 'star', 5);
            $data['types'] = Arr::get($_POST, 'type', 0);
            $data['created'] = time();
            $data['site_id'] = $this->site_id;
            if ($data['content'])
            {
                $result = DB::insert('celebrities_lookbook_reviews', array_keys($data))->values($data)->execute();
                if ($result)
                {
                    Message::set(__('review_add_success'), 'success');
                }
                else
                {
                    Message::set(__('post_data_error'), 'error');
                }
            }
            else
            {
                Message::set(__('post_data_error'), 'error');
            }
            if ($data['type'])
                $this->request->redirect(LANGPATH . '/lookbook/' . $data['lookbook_id'] . '-1');
            else
                $this->request->redirect(LANGPATH . '/lookbook/' . $data['lookbook_id']);
        }
        else
        {
            $this->request->redirect(LANGPATH . '/lookbook');
        }
    }

    function action_trends()
    {
        $this->request->redirect(BASEURL);
        $this->template->content = View::factory('/trends');
    }

    function action_ajax_product()
    {
        if ($_POST)
        {
            $id = Arr::get($_POST, 'id', 0);
            if (!$id)
            {
                exit;
            }
            else
            {
                $lang = Arr::get($_REQUEST, 'lang', '');
                if(empty($lang)){
                    $lang = 'en';
                }
                //guo jiajia 16.1.15 增加管控
                $langarr = array('en','de','es','fr','ru');
                if(!in_array($lang,$langarr))
                {
                    exit;
                }
                if($lang == 'en')
                {
                   $product = Product::instance($id); 
                }
                else
                {
                   $product = Product::instance($id, $lang);
                }
                
                $product->set_view_history();
                if($id){
                $current_catalog = $product->default_catalog();
                $cataname = Catalog::instance($current_catalog)->get("name");                    
                }
                $data = array();
                $data['catalog'] = $cataname;
                $data['name'] = $product->get('name');
                $data['sku'] = $product->get('sku');
                $data['status'] = $product->get('status');
                $data['type'] = $product->get('type');

                $attr_sizes = DB::select()->from('products_productitem')->where('product_id', '=', $product->get('id'))->and_where('status','=',1)->execute()->as_array();

                $set_id = $product->get('set_id');
                $data['link'] = $product->permalink();
                $price = $product->price();
                $s_price = $product->get('price');
                $data['price'] = Site::instance()->price($price, 'code_view');
                if ($s_price > $price){
                    $data['s_price'] = Site::instance()->price($s_price, 'code_view');
                    $data['rate'] = round((($s_price-$price)/$s_price)*100);
                }
                else{
                    $data['s_price'] = '';
                }
                $data['keywords'] = $product->get('keywords');
                $brief = $product->get('brief');
                
                $showinch=array(
                    7,8,9,10,11,12,13,14,15,16,20,280,375,472,537,538,539,549,550,551,552,553,554,557,558,559,560,561,562,693
                );
                
                if(in_array($set_id, $showinch))
                {
                    $breifs=explode(';', $brief);
                    foreach($breifs as $b)
                    {
                        $colon = strpos($b, ':');
                        $sizename = substr($b, 0, $colon);
                        $sizename = str_replace(array("\n", "<p>"), array(""), $sizename);
                        $sizebrief = substr($b, $colon + 1);
                        $briefsArr[trim($sizename)] = $sizebrief;
                    }
                    $str = array();
                    $newstr = array();

                    $data['brief'] = '';
                }
                else
                {
                    $data['brief'] = str_replace(';', '<br>', $brief);
                }
                $data['lang']=$lang;
                if($data['lang']=='es' || $data['lang']=='de'){
                    $data['brief'] = str_replace(';', '<br>', $brief);
                }
                $description = $product->get('description');
                $data['description'] = str_replace(';', '<br>', $description);
                $data['images'] = $product->images();
                $data['stock'] = $product->get('stock');

                $models = '';
                if($product->get('model_size'))
                {
                    $models .= 'Model Wears: ' . $product->get('model_size') . '<br><br>';
                }
                $model_id = $product->get('model_id');
                if($model_id)
                {
                    $modelArr = DB::select()->from('models')->where('id', '=', $model_id)->execute()->current();
                    if(!empty($modelArr))
                    {
                        $models .= 'Model Profile:<br>';
                    }
                    $models .= 'Name:' . $modelArr['name'] . '<br>';
                    $ft = 0.0328084;
                    $in = 0.3937008;
                    $height_ft = round($modelArr['height'] * $ft, 1);
                    $height_ft = str_replace(".", "'", $height_ft);
                    $height_ft .= '"';
                    $bust_in = round($modelArr['bust'] * $in, 1);
                    $waist_in = round($modelArr['waist'] * $in, 1);
                    $hip_in = round($modelArr['hip'] * $in, 1);
                    $models .= 'Height: ' . $height_ft .' | Bust: ' . $bust_in . ' | Waist: ' . $waist_in . ' | Hip: ' . $hip_in . '<br>';
                    $models .= 'Height: ' . $modelArr['height'] . ' cm | Bust: ' . $modelArr['bust'] . ' cm | Waist: ' . $modelArr['waist'] . ' cm | Hip: ' . $modelArr['hip'] . ' cm' . '<br>';
                }
                $data['models']=$models;
                $onesize = Kohana::config('lang.'.$lang.'.lang.onesize');
                $attribute = '<div class="drop-down select-down " id="select_size"><div class="drop-down-hd JS-show1"><span id="size-val">SELECT SIZE</span><i class="fa fa-caret-down flr"></i></div><ul class="drop-down-list JS-showcon1" style="display:none;">';
                if ($data['stock'] == -1)
                {
                    $product_stocks = $product->get_stocks();
                    $a = 0;
                    $one_size = 0;
                    if (!empty($attr_sizes))
                    {
                        if (isset($attributes[0]['attribute']) )
                        {
                            $attr_sizes = $attributes[0]['attribute'];
                                //判断attributes
                                if(strpos($attr_sizes, 'US') !== FALSE)
                                {
                                    $a = 1;
                                }
                            if (count($attr_sizes) == 1 && isset($attr_sizes) && $attr_sizes == 'one size')
                                $one_size = 1;
                        }
                        $stock_num = 0;

                        $data['w']=$attr_sizes;
                        $data['f']=$a;
                        if ($one_size)
                        {
                            $stocks = 0;
                            if(is_array($attr_sizes))
                            {
                               $stocks = $size['stock']; 
                            }
                            $size = trim($$attr_sizes['attribute']);
                            if($stocks > 0)
                            {
                                $stock_num ++;
                                $attribute .= '<li class="drop-down-option" id="one size" data-attr="one size"><a href="javascript:void(0);"  title="'.$stocks.'">'.$onesize.'</a></li>';
                            }
                            else
                                $attribute .= '<li class="drop-down-option disable hide" id="one size"  disabled="disabled"><a href="javascript:void(0);"  title="0">'.$onesize.'</a></li>';
                        }
                        elseif ($a)
                        {
                            $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
                            // 获取国家代码 
                            $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
                            if ($country_code == 'US')
                            {
                                $index = 0;
                                $country = 'US';
                            }
                            elseif ($country_code == 'GB' OR $country_code == 'UK')
                            {
                                $index = 1;
                                $country = 'UK';
                            }
                            else
                            {
                                $index = 2;
                                $country = '';
                            }

                            foreach ($attr_sizes as $size)
                            {
                                $stocks = 0;
                                if(is_array($size))
                                {
                                   $stocks = $size['stock']; 
                                }
                                $size = trim($size['attribute']);
                                if($size=='M' || $size=='S' || $size=='L' || $size=='XL' || $size=='XXL' || $size=='XXXL')
                                {
                                    $value=$size;
                                }
                                elseif($size != 'one size')
                                {
                                    if(strpos($size,'/') !== FALSE)
                                    {
                                       $att = explode('/', $size);
                                       $value = $country . preg_replace('/[A-Z]+/i', '', $att[$index]); 
                                    }
                                    else
                                    {
                                        $value = $size;
                                    }
                                                                        
                                    $value = str_replace('one size',$onesize, $value);
                                }
                                else
                                {
                                    $value=$size;
                                    $value = str_replace('one size',$onesize, $value); 
                                }

                                
                                if($stocks > 0)
                                {
                                    $stock_num ++;
                                    $attribute .= '<li class="drop-down-option" id="' . $value . '" data-attr="' . $value . '"><a href="javascript:void(0);"  title="'.$stocks.'"> ' . $value .' </a></li>';
                                }
                                else
                                {
                                    $attribute .= '<li id="' . $value . '" class="drop-down-option disable hide" disabled="disabled"><a href="javascript:void(0);"  title="0">' . $value .' </a></li>';
                                }
                            }
                        }
                        else
                        {
                            foreach ($attr_sizes as $size)
                            {
                                $stocks = 0;
                                if(is_array($size))
                                {
                                   $stocks = $size['stock']; 
                                }
                                $size = trim($size['attribute']);
                                
                                if($stocks > 0)
                                {
                                    $stock_num ++;
                                    $attribute .= '<li class="drop-down-option" id="' . $size . '" data-attr="' . $size . '"><a href="javascript:void(0);"  title="'.$stocks.'">' . $size .' </a></li>';
                                }
                                else
                                {
                                    $attribute .= '<li id="' . $size . '" class="drop-down-option disable hide"><a href="javascript:void(0);"> ' . $size .' </a></li>';
                                }
                            }
                        }
                    }
                    else
                    {
                        $attribute .= '<li class="drop-down-option" id="one size"><a  href="javascript:void(0);">'.$onesize.'</a></li>';
                    }
                }
                else
                {
                    if (!empty($attr_sizes))
                    {
                        $one_size = 0;
                        $is = 0;                        
                        //判断attributes
                        if (isset($attributes[0]['attribute']) )
                        {
                            $attr_sizes = $attributes[0]['attribute'];
                                //判断attributes
                                if(strpos($attr_sizes, 'US') !== FALSE)
                                {
                                    $a = 1;
                                }
                            if (count($attr_sizes) == 1 && isset($attr_sizes) && $attr_sizes == 'one size')
                                $one_size = 1;
                        }
                        if ($one_size)
                        {
                            $attribute .= '<li class="drop-down-option" id="one size"  data-attr="one size"><a href="javascript:void(0);">one size</a></li>';
                        }
                        elseif ($is)
                        {
                            $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
                            // 获取国家代码 
                            $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
                            if ($country_code == 'US')
                            {
                                $index = 0;
                                $country = 'US';
                            }
                            elseif ($country_code == 'GB' OR $country_code == 'UK')
                            {
                                $index = 1;
                                $country = 'UK';
                            }
                            else
                            {
                                $index = 2;
                                $country = '';
                            }
                            foreach ($attr_sizes as $size)
                            {
                                $size = trim($size['attribute']);
                                $att = explode('/', $size);
                                $value = $country . preg_replace('/[A-Z]+/i', '', $att[$index]);
                                $attribute .= '<li class="drop-down-option" id="' . $value . '" data-attr="' . $value . '"><a href="javascript:void(0);"> ' . $value .' </a></li>';
                            }
                        }
                        else
                        {
                            foreach ($attr_sizes as $size)
                            {
                                $size = trim($size['attribute']);
                                $attribute .= '<li class="drop-down-option" id="' . $size . '" data-attr="' . $size . '"><a href="javascript:void(0);"> ' . $size .' </a></li>';
                            }
                        }
                    }
                    else
                    {
                        $attribute .= '<li class="drop-down-option" id="one size" data-attr="one size"><a href="javascript:void(0);">one size</a></li>';
                    }
                }

                $attribute .= '</ul></div>';
                $data['attributeSize'] = $attribute;
                $data['attributePhone'] = str_replace('JS-show', '', $attribute);
                
                if($data['stock'] == -1)
                {
                    if(isset($stock_num) && !$stock_num)
                    {
                        $data['stock'] = 0;   
                    }
                }

                $attribute = '';
                if (isset($attributes['Color']) OR isset($attributes['color']))
                {
                    $attColor = isset($attributes['Color']) ? $attributes['Color'] : $attributes['color'];
                    foreach ($attColor as $color)
                    {
                        $attribute .= '<input type="button" class="btn-size-normal on-border JS-show" id="' . $color . '" value="' . $color . '">';
                    }
                }
                $data['attributeColor'] = $attribute;
                $attribute = '';
                if (isset($attributes['Type']) OR isset($attributes['type']))
                {
                    $attType = isset($attributes['Type']) ? $attributes['Type'] : $attributes['type'];
                    foreach ($attType as $type)
                    {
                        $attribute .= '<input type="button" class="btn-size-normal on-border JS-show" id="' . $type . '" value="' . $type . '">';
                    }
                }
                $data['attributeType'] = $attribute;
                
                echo json_encode($data);
                exit;
            }
        }
    }
    
    function action_ajax_product1()
    {
        if ($_REQUEST)
        {
            $id = Arr::get($_REQUEST, 'id', 0);
            if (!$id)
            {
                exit;
            }
            else
            {
                $product = Product::instance($id);
                $product->set_view_history();
                $data = array();
                $data['name'] = $product->get('name');
                $data['sku'] = $product->get('sku');
                $data['status'] = $product->get('status');
                $data['type'] = $product->get('type');
                $data['link'] = $product->permalink();
                //VIP TYPES  guo 3.25
                $vipconfig = Site::instance()->vipconfig();

                $session = Session::instance();
                $usersession = $session->get('user', '');
				$is_vip['is_vip']="";
				if($usersession){
					//获取is_vip
					$is_vip=DB::query(Database::SELECT, 'SELECT is_vip FROM `accounts_customers` where id='.$usersession['id'].' ')->execute('slave')->current();
				}
				
                $vip_promotion_price = 0;
                $spromotion_key = 'spromotion_' . $id;
                $spromotion_data = Cache::instance('memcache')->get($spromotion_key);
                try 
                {
                    $spromotion_data = unserialize($spromotion_data);
                }
                catch (Exception $e)
                {
                }
                if(!empty($spromotion_data) && is_array($spromotion_data))
                {
                    foreach($spromotion_data as $s_type => $s_data)
                    {
                        if($s_type == 0 && $s_data['created'] < time() && $s_data['expired'] > time())
                        {
                            $vip_promotion_price = $s_data['price'];
                            break;
                        }
                    }
                }

				
                if(!empty($usersession) && isset($is_vip['is_vip']))
                {
                    $is_vip = $is_vip['is_vip'];
                }
                else
                {
                    $is_vip = '';
                }
				
				
                if($is_vip){
                   $vip = $vipconfig[4]; 
                }else{
                    $vip = $vipconfig[0]; 
                }
				
                $price = $product->price();
                $s_price = $product->get('price');

                $vip_price = round($s_price * $vip['discount'], 2);
				
                if ($vip_price < $price)
                {
                    $price = $vip_price; 
                }

                if($vip_promotion_price && $vip_promotion_price < $price && $is_vip)
                {
                    $price = $vip_promotion_price;
                }

                $data['price'] = Site::instance()->price($price, 'code_view');

                if ($s_price > $price)
                    $data['s_price'] = Site::instance()->price($s_price, 'code_view');
                else
                    $data['s_price'] = '';
                $data['keywords'] = $product->get('keywords');
                $brief = $product->get('brief');
                $data['brief'] = str_replace(';', '<br>', $brief);
                $description = $product->get('description');
                $data['description'] = str_replace(';', '<br>', $description);
                $data['images'] = $product->images();
                $data['stock'] = $product->get('stock');


                $attributes= DB::select('attribute')->from('products_productitem')->where('product_id', '=', $product->get('id'))->execute()->as_array();

                $attr_sizes = array();
                $attribute = '';
                if ($data['stock'] == -1)
                {
                    if (!empty($attributes))
                    {
                        $one_size = 0;
                        $is = 0;
                        if (isset($attributes) )
                        {
                            $attr_sizes =  $attributes;
                            //判断attributes
                            foreach($attr_sizes as $v)
                            {
                                if(strpos($v['attribute'], 'US') !== FALSE)
                                {                         
                                    $is = 1;
                                }                       
                            }
                            if (count($attr_sizes) == 1 && isset($attr_sizes[0]['attribute']) && $attr_sizes[0]['attribute'] == 'one size')
                                $one_size = 1;
                        }
                        $stock_num = 0;
                        if ($one_size)
                        {
                            $stocks = DB::select('stock')->from('products_productitem')
                                ->where('product_id', '=', $id)
                                ->where('attribute', '=', 'one size')
                                ->execute()->get('stock');
                            if($stocks > 0)
                            {
                                $stock_num ++;
                                $attribute = '<li class="btn-size-normal on-border JS-show" id="one size" title="'.$stocks.'"><span>one size</span></li>';
                            }
                            else
                                $attribute = '<li class="btn-size-normal on-border JS-show" id="one size" title="0" class="disable hide" disabled="disabled"><span>one size</span></li>';
                        }
                        elseif ($is)
                        {
                            $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
                            // 获取国家代码 
                            $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
                            if ($country_code == 'US')
                            {
                                $index = 0;
                                $country = 'US';
                            }
                            elseif ($country_code == 'GB' OR $country_code == 'UK')
                            {
                                $index = 1;
                                $country = 'UK';
                            }
                            else
                            {
                                $index = 2;
                                $country = '';
                            }
                            foreach ($attr_sizes as $size)
                            {
                                $size = trim($size['attribute']);
                                $stocks = DB::select('stock')->from('products_productitem')
                                    ->where('product_id', '=', $id)
                                    ->where('attribute', '=', $size)
                                    ->execute()->get('stock');
                                $att = explode('/', $size);
                                $value = $country . preg_replace('/[A-Z]+/i', '', $att[$index]);
                                if($stocks > 0)
                                {
                                    $stock_num ++;
                                    $attribute .= '<li class="btn-size-normal on-border JS-show" id="' . $value . '" title="'.$stocks.'" data-attr="' . $value . '"><span> ' . $value .' </span></li>';
                                }
                                else
                                {
                                    $attribute .= '<li id="' . $value . '" title="0" class="disable hide" disabled="disabled" data-attr="' . $value . '"><span> ' . $value .' </span></li>';
                                }
                            }
                        }
                        else
                        {
                            foreach ($attr_sizes as $size)
                            {
                                $size = trim($size['attribute']);
                                $stocks = DB::select('stock')->from('products_productitem')
                                    ->where('product_id', '=', $id)
                                    ->where('attribute', '=', $size)
                                    ->execute()->get('stock');
                                if($stocks > 0)
                                {
                                    $stock_num ++;
                                    $attribute .= '<li class="btn-size-normal on-border JS-show" id="' . $size . '" title="' . $stocks . '" data-attr="' . $size . '"><span> ' . $size .' </span></li>';
                                }
                                else
                                {
                                    $attribute .= '<li id="' . $size . '" class="disable hide" data-attr="' . $size . '"><span> ' . $size .' </span></li>';
                                }
                            }
                        }
                    }
                    else
                    {
                        $attribute = '<li class="btn-size-normal on-border JS-show" id="one size"><span>one size</span></li>';
                    }
                }
                else
                {
                    if (!empty($attributes))
                    {
                        $one_size=0;
                        $is = 0;
                        if (isset($attributes))
                        {

                            $attr_sizes =  $attributes;

                            //判断attributes
                            foreach($attr_sizes as $v)
                            {
                                if(strpos($v['attribute'], 'US') !== FALSE)
                                {                         
                                    $is = 1;
                                }                       
                            }
                            if (count($attr_sizes) == 1 && isset($attr_sizes[0]['attribute']) && $attr_sizes[0]['attribute'] == 'one size')
                                $one_size = 1;
                        }

                        if ($one_size)
                        {
                            $attribute = '<li class="btn-size-normal on-border JS-show" id="one size"><span>one size</span></li>';
                        }
                        elseif ($is)
                        {
                            $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
                            // 获取国家代码 
                            $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
                            if ($country_code == 'US')
                            {
                                $index = 0;
                                $country = 'US';
                            }
                            elseif ($country_code == 'GB' OR $country_code == 'UK')
                            {
                                $index = 1;
                                $country = 'UK';
                            }
                            else
                            {
                                $index = 2;
                                $country = '';
                            }
                            foreach ($attr_sizes as $size)
                            {
                                $size = trim($size['attribute']);
                                $att = explode('/', $size);
                                $value = $country . preg_replace('/[A-Z]+/i', '', $att[$index]);
                                $attribute .= '<li class="btn-size-normal on-border JS-show" id="' . $value . '" data-attr="' . $value . '"><span> ' . $value .' </span></li>';
                            }
                        }
                        else
                        {
                            foreach ($attr_sizes as $size)
                            {
                                $size = trim($size['attribute']);
                                $attribute .= '<li class="btn-size-normal on-border JS-show" id="' . $size . '" data-attr="' . $size . '"><span> ' . $size .' </span></li>';
                            }
                        }
                    }
                    else
                    {
                        $attribute = '<li class="btn-size-normal on-border JS-show" id="one size"><span>one size</span></li>';
                    }
                }
                
                $data['attributeSize'] = $attribute;
                $data['attributePhone'] = str_replace('JS-show', '', $attribute);

                if($data['stock'] == -1 AND !$stock_num)
                    $data['status'] = 0;

                $attribute = '';
//                if (isset($attributes['Color']) OR isset($attributes['color']))
//                {
//                    $attColor = isset($attributes['Color']) ? $attributes['Color'] : $attributes['color'];
//                    foreach ($attColor as $color)
//                    {
//                        $attribute .= '<li class="btn-size-normal on-border JS-show" id="' . $color . '"><span> ' . $color .' </span></li>';
//                    }
//                }
                $data['attributeColor'] = $attribute;
                $attribute = '';
//                if (isset($attributes['Type']) OR isset($attributes['type']))
//                {
//                    $attType = isset($attributes['Type']) ? $attributes['Type'] : $attributes['type'];
//                    foreach ($attType as $type)
//                    {
//                        $attribute .= '<li class="btn-size-normal on-border JS-show" id="' . $type . '"><span> ' . $type .' </span></li>';
//                    }
//                }
                $data['attributeType'] = $attribute;
                $data['total_price'] = site::instance()->price($price);
                $data['points'] = $price;
                echo json_encode($data);
                exit;
            }
        }
    }

    public function action_ajax_recent_view()
    {
        $lang = LANGUAGE;
        $recent = '';
        $history = Cookie::get('_vh', '');
        if ($history)
        {
            $num = 1;
            $view_history = explode(',', $history);
            foreach ($view_history as $id)
            {
                if ($num > 7)
                    break;
                $recent .= '<li class="rec-item">';
                $recent .= '<a href="' . Product::instance($id, $lang)->permalink() . '"><img src="' . Image::link(Product::instance($id)->cover_image(), 7) . '" alt="" id="' .Product::instance($id)->get('sku'). '" class="product-recentlyviewed" /></a>';
                $recent .= '<p class="price fix">';
                $recent .= '<b>' . Site::instance()->price(Product::instance($id)->price(), 'code_view') . '</b>';
                $recent .= '</p></li>';
                $num++;
            }
        }
        echo json_encode($recent);
        exit;
    }

    public function action_ajax_currency()
    {
        $name = Arr::get($_POST, 'currency', 0);
        if(Site::instance()->get('currency') != '' AND array_search($name, explode(',', Site::instance()->get('currency'))) !== FALSE)
        {
                Site::instance()->currency_set($name);
                Cookie::set('cookie_currency',$name,5184000);//60 days expire
        }
        echo json_encode(1);
        exit;
    }

    public function action_ajax_product_same()
    {
        $lang = Arr::get($_GET, 'lang', '');
        $return = '';
        $product_id = Arr::get($_REQUEST, 'product_id', 0);
        if($product_id)
        {
            $color_id = DB::select('color_id')->from('catalog_colors')->where('product_id', '=', $product_id)->execute()->get('color_id');
            if($color_id)
            {
                $sames = DB::select('product_id')->from('catalog_colors')->where('color_id', '=', $color_id)->where('product_id', '<>', $product_id)->execute();
                foreach($sames as $s)
                {
                    $visibility = Product::instance($s['product_id'])->get('visibility');
                    $status = Product::instance($s['product_id'])->get('status');
                    if($visibility) 
                    {
                        if($status){
                        $image = Product::instance($s['product_id'])->cover_image();
                        $return .= '<li><a class="current-color" href="' . Product::instance($s['product_id'], $lang)->permalink() . '" title="' . Product::instance($s['product_id'], $lang)->get('name') . '"><img width="50" src="' . Image::link($image, 3) . '" /></a></li>&nbsp;';                         
                        }/*else{
                        $image = Product::instance($s['product_id'])->cover_image();
                        $return .= '<li><div class="color-empty"><span>Out of Stock</span></div><a class="current-color" href="' . Product::instance($s['product_id'], $lang)->permalink() . '" title="' . Product::instance($s['product_id'], $lang)->get('name') . '"><img width="50" src="' . Image::link($image, 3) . '" /></a></li>&nbsp;';   

                        }*/

                    }    
                        
                }
                $return =$return;
            }
        }
        echo json_encode($return);
        exit;
    }

    function GetIP()
    {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return($ip);
    }

    public function action_createcode()
    {
        //通知浏览器将要输出PNG图片 
        Header("Content-type: image/PNG");
        //准备好随机数发生器种子
        srand((double) microtime() * 1000000);
        //准备图片的相关参数   
        $im = imagecreate(100, 30);
        $green = ImageColorAllocate($im, 80, 128, 18);  //RGB黑色标识符 
        $blue = ImageColorAllocate($im, 237, 247, 255); //RGB灰色标识符 
        //开始作图     
        imagefill($im, 0, 0, $blue);
        while (($randval = rand() % 100000) < 10000);
        {
            Session::instance()->set('indentifycode', $randval);
            //将四位整数验证码绘入图片
            imagestring($im, 10, 25, 8, $randval, $green);
        }
        //加入干扰象素    
//                for ($i = 0; $i < 200; $i++)
//                {
//                        $randcolor = ImageColorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
//                        imagesetpixel($im, rand() % 70, rand() % 30, $randcolor);
//                }
        //输出验证图片 
        ImagePNG($im);
        //销毁图像标识符 
        ImageDestroy($im);
        exit;
    }

    public function action_change_country()
    {
        if($_POST)
        {
            $lang_close = Arr::get($_POST, 'lang_close', 0);
            if($lang_close)
            {
                SetCookie('lang_close', 1, time() + 90 * 24 * 3600, '/');
            }
            else
            {
                $lang_code = Arr::get($_POST, 'lang_code', '');
                $currency_code = Arr::get($_POST, 'currency_code', '');
                $remember = Arr::get($_POST, 'remember', '');
                if($lang_code)
                {
                    if($remember)
                    {
                        SetCookie('lang_cookie', $lang_code . '-' . $currency_code, time() + 90 * 24 * 3600, '/');
                    }
                    else
                    {
                        Session::instance()->set('lang_session', $lang_code . '-' . $currency_code);
                    }
                    Site::instance()->currency_set($currency_code);
                    $request = Arr::get($_POST, 'request', '');
                    if(strpos($request, '?') !== FALSE)
                    {
                        $request .= '&ip=1';
                    }
                    else
                    {
                        $request .= '?ip=1';
                    }
                    $this->request->redirect('/' . $lang_code . $request);
                }
            }
        }
        exit;
    }

    public function action_hide_banner(){
        $is_banner=Session::instance()->get('is_banner');
        if($is_banner==1){
            Session::instance()->set('is_banner',0);
        }
        echo json_encode($is_banner);
        exit;
    }

    public function action_emarsysdata(){
        $page = Arr::get($_REQUEST, 'page', '');
        $sku = Arr::get($_POST, 'sku', 0);
        $lang = Arr::get($_POST, 'lang', "");
        if($sku){
            $data=array();
            $skus=explode(",", $sku);
            $skus=array_filter($skus);
            foreach($skus as $value){
                $pid=Product::instance()->get_productId_by_sku($value);
                if($pid){
                    $data[$value]['price']=Site::instance()->price(Product::instance($pid)->price(), 'code_view');
                    $data[$value]['link']=Product::instance($pid,$lang)->permalink();
                    $data[$value]['name']=Product::instance($pid,$lang)->get('name');
                    $data[$value]['realprice']=number_format(Product::instance($pid,$lang)->get('price'), 2);
                    $data[$value]['product_id']=$pid;
                    if(Product::instance($pid,$lang)->get('visibility')==1&&Product::instance($pid,$lang)->get('status')==1){
                       $data[$value]['show']=1;  
                   }else{
                        $data[$value]['show']=0;
                   }
                    
                }

                if($page == 'product' || $page == 'flash'){
                    $data[$value]['cover_image'] = Image::link(Product::instance($pid)->cover_image(), 7);
                }

                if($page == 'flash'){
                    $data[$value]['name'] = Product::instance($pid,$lang)->get('name');
                }
            }
            echo json_encode($data);
            exit;
        }else{
            exit;
        }
    }

    public function action_ajax_index(){
        Session::instance()->set('index_close_flg',TRUE);
        exit;
    }

    //获取tab页面切换
    public function action_ajax_accept(){
        $data=array();
        $data_id=Arr::get($_POST, 'data_id', '');
        $lan=Arr::get($_POST, 'lan', '');
        if($data_id){
            //select a.product_id from products_categoryproduct as a,products as b where a.catalog_id = 45 and a.product_id = b.id and b.visibility = 1 and b.status = 1 order by a.id desc limit 12
            $ready_shippeds = Site::instance()->ready_shippeds($data_id);
            foreach($ready_shippeds as $v){
                $product_id=$v['product_id'];
                $cover_image = Product::instance($product_id)->cover_image();
                $image=Image::link($cover_image, 1);
                $product_inf = Product::instance($product_id)->get();
                $plink = Product::instance($product_id,$lan)->permalink();
                $orig_price = round($product_inf['price'], 2);
                $price = round(Product::instance($product_id,$lan)->price(), 2);
                $orig_price=Site::instance()->price($orig_price, 'code_view');
                $price1=Site::instance()->price($product_inf['price'], 'code_view');
                $data[]=array(
                    'image'=>$image,
                    'plink'=>$plink,
                    'orig_price'=>$orig_price,
                    'price'=>$price,
                    'price1'=>$price1,
                ); 
            }
            echo json_encode($data);
            exit;
        }
    }
}