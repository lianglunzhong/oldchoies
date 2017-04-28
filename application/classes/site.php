<?php

defined('SYSPATH') or die('No direct script access.');

class Site
{

    public static $instances;
    private $data;

    public static function & instance($id = 0, $domain = NULL)
    {
        if (!isset(self::$instances[$id]))
        {
            $class = __CLASS__;
            self::$instances[$id] = new $class($id, $domain);
        }
        return self::$instances[$id];
    }

    public function __construct($id = 0, $domain)
    {
        $this->_load($id, $domain);
    }

    public function _load($id = 0, $domain)
    {
        $key = "2333site_new122/" . $id . '/' . $domain;
        $cache = Cache::instance('memcache');

        if (!($data = $cache->get($key, array())))
        {
            if (!$id)
            {
                $data = DB::select()->from('core_sites')->where('domain', '=', $domain)->execute()->current();
            }
            else
            {

                $data = DB::select()->from('core_sites')->where('id', '=', $id)->execute()->current();
            }
            if ($data)
                $cache->set($key, $data);
        }
        $this->data = $data;
    }

    public function get($key = NULL)
    {
        if (empty($key))
        {
            return $this->data;
        }
        return isset($this->data[$key]) ? $this->data[$key] : '';
    }

    public function id()
    {
        if (!Session::instance()->get('SITE_ID', NULL))
        {
            return $this->data['id'];
        }
        else
        {
            return Session::instance()->get('SITE_ID');
        }
    }

    public function route()
    {
        //set docs
        $docs = $this->docs();

        foreach ($docs as $doc)
        {
            Route::set($doc['name'], '(<language>/)<link>', array('link' => $doc['link'], 'language' => '[\w-]+'))
                    ->defaults(array(
                        'controller' => 'site',
                        'action' => 'doc'
                    ));
        }
                
        // product
        Route::set('product', $this->data['product'] . '/<id>', array('link' => '[\w-]+')
                )
                ->defaults(array(
                    'controller' => 'site',
                    'action' => 'product',
                ));
        Route::set('product', '(<language>/)' . $this->data['product'] . '/<id>', array('link' => '[\w-]+', 'language' => '^[a-z]{2}+')
                )
                ->defaults(array(
                    'controller' => 'site',
                    'action' => 'product',
                ));

        // catalog url: catalog_link
        $cache = Cache::instance('memcache');
        $cache_key = "catalog_route12";

        if( ! ($catalogs = $cache->get($cache_key)))
        {
        $catalogs = DB::select('id', 'link')->from('products_category')->where('visibility', '=', 1)->where('link', '!=', ' ')->execute()->as_array();
            $cache->set($cache_key, $catalogs, 1800);
        }
        
        /*$catalogs = DB::select('id', 'link')->from('products_category')->where('site_id', '=', $this->data['id'])->where('visibility', '=', 1)->execute();*/
        foreach ($catalogs as $catalog)
        {
            Route::set('catalog/' . $catalog['id'], '<id>(/<link>(/<price>(/<filter>)))', array('id' => $catalog['link'], 'link' => '[\w-]+', 'price' => '[\w-]+', 'filter' => '[\w-]+'))
                    ->defaults(array(
                        'controller' => 'site',
                        'action' => 'catalog'
                    ));
            Route::set('catalog/' . $catalog['id'] . '-1', '<id>(/<link>(/<price>(/<filter>)))', array('id' => $catalog['link'] . '-c-' . $catalog['id'], 'link' => '[\w-]+', 'price' => '[\w-]+', 'filter' => '[\w-]+'))
                    ->defaults(array(
                        'controller' => 'site',
                        'action' => 'catalog'
                    ));
            Route::set('catalog/' . $catalog['id'], '(<language>/)<id>(/<link>(/<price>(/<filter>)))', array('id' => $catalog['link'], 'link' => '[\w-]+', 'price' => '[\w-]+', 'filter' => '[\w-]+', 'language' => '^[a-z]{2}+'))
                    ->defaults(array(
                        'controller' => 'site',
                        'action' => 'catalog'
                    ));
            Route::set('catalog/' . $catalog['id'] . '-1', '(<language>/)<id>(/<link>(/<price>(/<filter>)))', array('id' => $catalog['link'] . '-c-' . $catalog['id'], 'link' => '[\w-]+', 'price' => '[\w-]+', 'filter' => '[\w-]+', 'language' => '^[a-z]{2}+'))
                    ->defaults(array(
                        'controller' => 'site',
                        'action' => 'catalog'
                    ));
        }
        $languages = Kohana::config('sites.language');
        foreach ($languages as $lang)
        {
            Route::set($lang, '<language>')
                    ->defaults(array(
                        'controller' => 'site',
                        'action' => 'view'
                    ));
        }

        // catalog hierarchy tree
        //TODO
        Route::set('catalog_left', 'catalog/catalog_left/(<parent_id>/(<depth>))', array('parent_id' => '\d+', 'depth' => '\d+'))->defaults(array('controller' => 'catalog', 'action' => 'catalog_left'));

        // API ROUTE
        Route::set('api', 'api/<controller>/<action>(/<id>)')->defaults(array('directory' => 'api',));
    }

    public function set_route()
    {
        $pages = ORM::factory('page')
                ->where('site_id', '=', $this->get('id'))
                ->find_all();
        foreach ($pages as $page)
        {
            Route::set("route-{$page->name}", '<url>', array('url' => $page->url))
                    ->defaults(array(
                        'controller' => 'site',
                        'action' => 'page'
                    ));
        }
    }

    public function root_catalogs()
    {
        $cache = Cache::instance();
        $key = $this->data['id'] . '/root';

        if (!($data = $cache->get($key)))
        {
            $result = DB::select('id')->from('products_category')
                            ->and_where('parent_id', '=', 0)
                            ->and_where('visibility', '=', '1')
                            ->order_by('position')
                            ->order_by('id')
                            ->execute()->as_array();
            $data = array();
            foreach ($result as $item)
            {
                $data[] = $item['id'];
            }

            $cache->set($key, $data);
        }

        return $data;
    }

    public function docs()
    {
        $cache = Cache::instance('memcache');
        $key = $this->get('id') . '/docs1';

        if (!($data = $cache->get($key)))
        {

            $data = DB::select('name', 'link')->from('core_docs')
                            ->where('is_active', '=', '1')
                            ->execute()->as_array();
            $cache->set($key, $data);
        }
        return $data;
    }

    public function sets()
    {
        $data = DB::select('id', 'name')->from('sets')
                        ->where('site_id', '=', $this->data['id'])
                        ->execute()->as_array('id');
        return $data;
    }

    public function default_currency()
    {
        $currencies = explode(',', $this->data['currency']);
        if (isset($currencies[0]) AND $currencies[0])
        {
            return $currencies[0];
        }
        else
        {
            return 'USD';
        }
    }

    public function currency()
    {
        $session = Session::instance();
        $currency = array();
        $currency['name'] = $session->get('currency_name');
        if (isset($currency['name']) AND $currency['name'])
        {
            $currency['code'] = $session->get('currency_code');
            $currency['rate'] = $session->get('currency_rate');
        }
        else
        {
            $currency = $this->currency_get($this->default_currency());
        }

        return $currency;
    }

        public function currencies($now_currrency = '')
    {
        $currencies = array( );
        $currency_names = explode(',', $this->data['currency']);
        if($now_currrency)
        {
            //if USD get static
            if($now_currrency == 'USD')
            {
                $currencies = Kohana::config('currency.USD');
            }
            else
            {
                //set currency memcache
                $cache_key = 'site_currency11_' . $now_currrency;
                $cache_content = Cache::instance('memcache')->get($cache_key);
                if (strlen($cache_content) > 50)
                {
                    $currencies = unserialize($cache_content);
                }
                else
                {
                    $currencies = DB::select()->from('core_currencies')->where('name', '=', $now_currrency)->execute()->current();
                    Cache::instance('memcache')->set($cache_key, serialize($currencies), 86400);
                }
            }
            return $currencies;
        }
        else
        {
            //set currency memcache
            $key = '12site_currencyallarraychoies';
            $cache = Cache::instance('memcache');
            if (!($data = $cache->get($key)))
            {
                $data = DB::select()->from('core_currencies')->where('name', 'IN', $currency_names)->execute()->as_array();
                $cache->set($key, $data, 86400);
            }
            
            foreach( $data as $currency )
            {
                    $currencies[$currency['name']] = $currency;
            }
            return $currencies;
        }
    }

        public function currenciesforfeed($now_currrency = '')
    {
        $currencies = array( );
        $currency_names = explode(',', $this->data['currency']);
        if($now_currrency)
        {
            //if USD get static
            if($now_currrency == 'USD')
            {
                $currencies = Kohana::config('currency.USD');
            }
            else
            {

                $currencies = DB::select()->from('core_currencies')->where('name', '=', $now_currrency)->execute()->current();

            }
            return $currencies;
        }
        else
        {
            $data = DB::select()->from('core_currencies')->where('name', 'IN', $currency_names)->execute();
            foreach( $data as $currency )
            {
                    $currencies[$currency['name']] = $currency;
            }
            return $currencies;
        }
    }

    /*
    public function currencies($now_currrency = '')
        {
                $currencies = array( );
                $currency_names = explode(',', $this->data['currency']);
                if($now_currrency)
                {
                    $currencies = DB::select()->from('core_currencies')->where('name', '=', $now_currrency)->execute()->current();
                    return $currencies;
                }
                else
                {
                    $data = DB::select()->from('core_currencies')->where('name', 'IN', $currency_names)->execute();
                    foreach( $data as $currency )
                    {
                            $currencies[$currency['name']] = $currency;
                    }
                    return $currencies;
                }
        }
     */

    public function currency_set($name)
    {
        $session = Session::instance();
        $currency = $this->currency_get($name);

        if (isset($currency['name']) AND $currency['name'])
        {
            $session->set('currency_name', $currency['name']);
            $session->set('currency_code', $currency['code']);
            $session->set('currency_rate', $currency['rate']);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function currency_get($name)
    {
        $currency = array();
        $data = Site::instance()->currencies($name);
        if ($data['rate'])
        {
            $currency['name'] = $name;
            $currency['rate'] = $data['rate'];
            $currency['code'] = $data['code'];

            return $currency;
        }
        else
        {
            return $this->currency_get('USD');
        }
    }

    public function price($price_exchange, $type = NULL, $currency_exchange = NULL, $currency_view = NULL, $format = 2, $fill_zero = 1)
    {
        if (!$currency_exchange)
        {
            $currency_exchange = $this->default_currency();
        }
        $currency_exchange = Site::instance()->currencies($currency_exchange);
        

        $price_usd = $price_exchange / $currency_exchange['rate'];

        if ($currency_view)
        {
            $currency = $currency_view;
        }
        else
        {
            $currency = $this->currency();
        }

        //currency JPY must be integer
        if($currency['name'] == 'JPY' || $currency['name'] == 'TWD')
        {
            $price = round($price_usd * $currency['rate']);
            $fill_zero = 0;
        }
        else
        {
            $price = round($price_usd * $currency['rate'], $format);
        }

        switch ($type)
        {
            case 'name_view':
                $price_str = $currency['name'] . $price;
                break;
            case 'code_view':
                $price_str = $currency['code'] . $price;
                break;
            default:
                $price_str = $price;
                break;
        }

        if ($fill_zero)
        {
            $price_str = Toolkit::fill_zero($price_str, $format);
        }

        return $price_str;
    }

    public function countries($lang = '')
    {
        $result = DB::select('name', 'isocode')
            ->from('core_country')
            // ->where('site_id', '=', $this->data['id'])
            ->and_where('is_active', '=', 1)
            ->order_by('name', 'ASC')
            ->execute()->as_array();
        if($lang)
        {
            $lang_countries = Kohana::config('countries.' . $lang);
            foreach($result as $key => $r)
            {
                if(isset($lang_countries[$r['isocode']]))
                {
                    $r['name'] = $lang_countries[$r['isocode']];
                    $result[$key] = $r;
                }
            }

        }
        return $result;
    }

    public function countries_top($lang = '')
    {
        $result = DB::select('name', 'isocode')
            ->from('core_country')
            ->and_where('is_active', '=', 1)
            ->and_where('position','<',10)
            ->order_by('name', 'ASC')
            ->execute()->as_array();
        if($lang)
        {
            $lang_countries = Kohana::config('countries.' . $lang);
            foreach($result as $key => $r)
            {
                if(isset($lang_countries[$r['isocode']]))
                {
                    $r['name'] = $lang_countries[$r['isocode']];
                    $result[$key] = $r;
                }
            }

        }
        return $result;
    }

    public function carriers($isocode = FALSE)
    {
        $result = DB::select()
                        ->from('core_carriers')
                        ->and_where('isocode', 'in', array('0', $isocode))
                        ->order_by('position')
                        ->order_by('isocode', 'ASC')
                        ->execute()->as_array();

        $carriers = array();
        foreach ($result as $key => $value)
        {
            $carriers[$value['carrier']] = $value;
        }

        return $carriers;
    }

    public function get_specific_group_id($specific_name)
    {
        $specifics = kohana::config('sites.' . Site::instance()->get('id') . '.specific_groups');
        if (isset($specifics[$specific_name]))
        {
            return $specifics[$specific_name];
        }
        return 0;
    }

    public function products($_offset = 0, $_limit = NULL, $_orderby = NULL, $_desc = NULL)
    {
        $_limit ? $limit = $_limit : $limit = $this->data['per_page'];
        $limit_sql = ' LIMIT ' . $_offset . ',' . $limit;

        $_desc ? $desc = ' DESC' : $desc = ' ASC';

        $orderby_keys = array('hits', 'price', 'name', 'created');
        in_array($_orderby, $orderby_keys, TRUE) ? $orderby = $_orderby : $orderby = 'name';
        $orderby_sql = " ORDER BY " . $orderby . $desc;

        $result = DB::query(1, "SELECT id FROM products WHERE site_id = " . $this->data['id'] . $orderby_sql . $limit_sql)->execute();

        foreach ($result as $item)
        {
            $data[] = $item['id'];
        }
        return $data;
    }

    public function system_links()
    {
        $links = array('forum', '404', 'admin');

        $results = DB::query(1, 'SELECT id,link FROM docs WHERE site_id = ' . $this->data['id'])->execute()->as_array('id', 'link');

        $links = array_merge($links, $results);

        return $links;
    }

    public function domain()
    {
        $https = 'https://';
        // if ($this->get('ssl') == 1)
        // {
        //     $https = 'https://';
        // }
        // else
        // {
        //     $https = 'http://';
        // }

        $domain = $https . $this->get('domain');

        return $domain;
    }

    public function erp_domain()
    {
        return substr($this->get('domain'), 4);
    }

    public function erp_enabled()
    {
        return (bool) $this->get('erp_enabled');
    }

    public function tags_route()
    {
        $cats = DB::query(Database::SELECT, 'SELECT distinct catalog_id FROM labels WHERE site_id=' . Site::instance()->get('id') . ' AND is_active=1')
                ->execute()
                ->as_array();
        $num = 0;
        foreach ($cats as $cat)
        {
            $catalog = ORM::factory('catalog')
                    ->where('site_id', '=', Site::instance()->get('id'))
                    ->where('id', '=', $cat['catalog_id'])
                    ->find();
            if ($catalog->loaded())
            {
                Route::set($catalog->link . $num, 'tags/<link>', array('link' => $catalog->link))
                        ->defaults(array(
                            'controller' => 'tags',
                            'action' => 'catalog'
                        ));
            }
            $num++;
        }
        $cats = DB::query(Database::SELECT, 'SELECT distinct defined_catalog_link FROM labels WHERE site_id=' . Site::instance()->get('id') . ' AND is_active=1 AND defined_catalog<>\'null\' AND defined_catalog<>\'\'')
                ->execute()
                ->as_array();
        foreach ($cats as $cat)
        {
            Route::set(urlencode($cat['defined_catalog_link']), 'tags/<link>', array('link' => $cat['defined_catalog_link']))
                    ->defaults(array(
                        'controller' => 'tags',
                        'action' => 'defined_catalog'
                    ));
        }
        Route::set('tags', 'tags(/<link>)')
                ->defaults(array(
                    'controller' => 'tags',
                    'action' => 'index',
                ));
    }

    public function add_flow($cid = '', $type = '', $name = '')
    {
        if (!$cid OR !$type)
        {
            return false;
        }
        else
        {   
            $celebrity = DB::select('id')->from('celebrities_celebrits')->where('id', '=', $cid)->execute()->get('id');
            if($celebrity)
            {
                $fid = DB::select('id')->from('celebrities_flows')->where('celebrity_id', '=', $cid)->and_where('types', '=', $type)->and_where('name', '=', $name)->execute()->get('id');
                if ($fid)
                {
                    DB::query(Database::UPDATE, 'UPDATE celebrities_flows SET flow=flow+1 WHERE id=' . $fid)->execute();
                }
                /* else  #暂时注释
                {
                    $data = array(
                        'celebrity_id' => $cid,
                        'types' => $type,
                        'name' => $name,
                        'flow' => 1
                    );
                    DB::insert('celebrities_flows', array_keys($data))->values($data)->execute();
                }
                return false;*/
            }
            else
            {
              return false;  
            }
        }
    }

    public function add_clicks($type = '')
    {
        return true;
        $types = array('add_to_cart', 'cart_view', 'continues', 'checkout', 'ppec', 'cart_login', 'cart_checkout', 'proceed', 'globebill', 'ppjump', 'card_pay','cart_to_cookie','cookie_to_cart',);
        if (!in_array($type, $types))
        {
            return false;
        }
        else
        {
            $day = strtotime('midnight', time() + 28800) - 18000;
            $dayid = DB::select('id')->from('core_site_clicks')->where('day', '=', $day)->execute()->get('id');
            if ($dayid)
            {
                $result = DB::query(Database::UPDATE, 'UPDATE core_site_clicks SET `' . $type . '` = `' . $type . '` + 1 WHERE id = ' . $dayid)->execute();
            }
            else
            {
                $result = DB::query(Database::INSERT, 'INSERT INTO core_site_clicks (`day`,`add_to_cart`,`cart_view`,`continues`,`checkout`,`ppec`,`cart_login`,`cart_checkout`,`proceed`,`globebill`,`ppjump`,`card_pay`,`log`,`cart_to_cookie`,`cookie_to_cart`,`card_return`) values (' . $day . ', 0 ,0,0,0,0,0,0,0,0,0,0,"",0,0,0)')->execute();

            }

            if ($result)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    public function add_mobile_clicks($type = '')
    {
        $types = array('add_to_cart', 'cart_view', 'continue', 'checkout', 'ppec', 'cart_login', 'cart_checkout', 'proceed', 'globebill', 'ppjump');
        if (!in_array($type, $types))
        {
            return false;
        }
        else
        {
            $day = strtotime('midnight') - 18000;
            $dayid = DB::select('id')->from('site_mobile_clicks')->where('day', '=', $day)->execute()->get('id');
            if ($dayid)
            {
                $result = DB::query(Database::UPDATE, 'UPDATE site_mobile_clicks SET `' . $type . '` = `' . $type . '` + 1 WHERE id = ' . $dayid)->execute();
            }
            else
            {
                $result = DB::query(Database::INSERT, 'INSERT INTO site_mobile_clicks (`day`, `' . $type . '`) values (' . $day . ', 1)')->execute();
            }

            if ($result)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    
    public static function us_size($sizes = array(), $set_id = 0)
    {
        $data = array();
        $set_id = (int) $set_id;
        if(!empty($sizes) AND $set_id)
        {
            $sizeArr = array();
            $cmArr = array();
            switch($set_id)
            {
                case 9 :    //Dress
                case 14 :   //T-shirt
                case 15 :   //Shirt/Blouse
                    if(isset($sizes['bust']))
                    {
                        $sizeArr = $sizes['bust'];
                        $cmArr = array(
                            78.5,81,86,91,96,101,108.5
                        );
                    }
                    elseif(isset($sizes['waist']))
                    {
                        $sizeArr = $sizes['waist'];
                        $cmArr = array(
                            60.5,63,68,73,78,83,90.5
                        );
                    }
                    break;
                case 10:    //Shorts
                case 13:    //Pants
                case 20:    //Jeans
                case 12:    //Skirt
                case 474:   //Skirts
                    if(isset($sizes['waist']))
                    {
                        $sizeArr = $sizes['waist'];
                        $cmArr = array(
                            60.5,63,68,73,78,83,90.5
                        );
                    }
                    elseif(isset($sizes['hips']))
                    {
                        $sizeArr = $sizes['hips'];
                        $cmArr = array(
                            86,88.5,93.5,98.5,103.5,108.5,116
                        );
                    }
                    break;
            }
            foreach ($sizeArr as $a)
            {
                $cms = explode('-', str_replace('cm', '', $a));
                $cm = (float) $cms[count($cms) - 1];
                if ($cm)
                {
                    $us = 0;
                    foreach ($cmArr as $key => $b)
                    {
                        if ($cm < $b)
                        {
                            $us = ($key + 1) * 2;
                            break;
                        }
                    }
                    if ($us == 0)
                    {
                        $us = ($key + 2) * 2 . '+';
                    }
                    $data[] = $us;
                }
            }
        }
        return $data;
    }

    public static function version_file($file = "")
    {
        $domain = Arr::get($_SERVER, 'COFREE_DOMAIN', 'www.choies.com');
//        $https = Arr::get($_SERVER, 'HTTPS', 'off');
        if($domain == 'www.choies.com' )
        {
            $file_dir =  DOCROOT;
            $static_url = STATICURL;
            $url = '';
            if($file)
            {
                $info = pathinfo($file);
                $md5 = md5_file($file_dir . $file);
                $new_filename = $info['filename'] . '-' . $md5 . '.' . $info['extension'];
                $new_filedir = $file_dir . 'cdn' . '/' . $new_filename;
                if(!file_exists($new_filedir))
                {
                    copy($file_dir . $file, $new_filedir);
                }
                $url = $static_url . '/statics/' . $new_filename;
            }
        }
        else
        {
            if($file == '/assets/css/style.css')
            {
                $file = '/assets/css/style-https.css';
            }
            $url = $file;
        }
        return $url;
    }

    public function isblack()
    {
        $cache = Cache::instance('memcache');
        $key = "site_new1112/469/isblack";

        if( ! ($data = $cache->get($key))){
        $idarr = DB::select('product_id')
            ->from('products_categoryproduct')
            ->where('category_id', '=', 469)
            ->execute()
            ->as_array();  
            foreach($idarr as $v){
                $data[] = $v['product_id'];
            }

            $cache->set($key, $data, 3600);
       }

        return $data;     
    }

    public function registergift()
    {
        $cache_zhuceyouli_key = '12site_zhuceyouli_choies_123';
        $cacheins = Cache::instance('memcache');
        $skuarr = self::giftsku();
        $skustr = implode(',', $skuarr);
        $cache_zhuceyouli_content = $cacheins->get($cache_zhuceyouli_key);
        if(!empty($cache_zhuceyouli_content) AND !isset($_GET['cache']))
        {
           $free = $cache_zhuceyouli_content;
        }
        else
        {
            $skuarr1 = isset($skuarr[0]) ? $skuarr[0] : '';
            $skuarr2 = isset($skuarr[1]) ? $skuarr[1] : '';
            if($skuarr1 > $skuarr2)
            {
                $free = DB::query(Database::SELECT, 'select id,price,sku,type from products_product where id in ('. $skustr .') order by id desc')->execute('slave')->as_array();                
            }
            else
            {
                $free = DB::query(Database::SELECT, 'select id,price,sku,type from products_product where id in ('. $skustr .')')->execute('slave')->as_array();
            }
          $cacheins->set($cache_zhuceyouli_key, $free, 3600); //设置注册有礼的缓存
        }

        return $free;        
    }

    public function ready_shippeds($data_id)
    {
        $cache_ready_shippeds_key = 'site_ready_shippeds12_choies' . LANGUAGE . $data_id;
        $cacheins = Cache::instance('memcache');
        $cache_ready_shippeds_content = $cacheins->get($cache_ready_shippeds_key);
        if(!empty($cache_ready_shippeds_content) AND !isset($_GET['cache']))
        {
           $ready_shippeds = $cache_ready_shippeds_content;
        }else{
          $ready_shippeds = DB::query(Database::SELECT, 'select a.product_id from products_categoryproduct as a,products_product as b where a.category_id = '.$data_id.' and a.product_id = b.id and b.visibility = 1 and b.status = 1 order by a.id desc limit 9')->execute()->as_array();$cacheins->set($cache_ready_shippeds_key, $ready_shippeds, 3600); 
          //设置手机版推荐产品
        }

        return $ready_shippeds;        
    }

    //guo  add get all tag
    public static function getalltag($lang)
    {
        $data = array();

        $cache = Cache::instance('memcache');
        $key = "/tag1s121/".$lang;
        if( ! ($result = $cache->get($key)))
        {
            
            $result = DB::select()->from('products_tags')->order_by('position', 'DESC')
                    ->execute()->as_array();            

            $cache->set($key, $result, 7200);
        }

        $data = $result;

        return $data;
    }

    //guo add 12.22
    public function vipconfig()
    {
        $cache = Cache::instance('memcache');
        $key = "site_vipconfig";

        if( ! ($data = $cache->get($key))){
        $data = DB::select()
            ->from('core_vip_types')
            ->execute()
            ->as_array();  

            $cache->set($key, $data, 86400);
       }

        return $data;           
    }

    // add 404 error log --- sjm 2016-01-20
    public static function add_404_log()
    {
        $referrer = Request::$referrer;
        $uri = Request::instance()->uri;
        Kohana::$log->add('PAGE_404', 'URL:/' . $uri . ' | REF:' . $referrer);
    }

    public static function giftsku()
    {
        $cache = Cache::instance('memcache');
        $giftsku = $cache->get('giftsku');
        if(!is_array($giftsku) || !$giftsku)
        {
            $giftsku = kohana::config('sites.giftsku');
        }
        return $giftsku;
    }

    public static function googletransapi($blank='en',$target='',$words)
    {
        $key = kohana::config('sites.googlekey'); 
        $key = $key[0];

        $sysParams['key'] = $key;
        $sysParams['source'] = $blank;
        $sysParams['target'] = strtolower($target);
        $sysParams['q'] = $words;

        $requestUrl="https://www.googleapis.com/language/translate/v2?".http_build_query($sysParams);

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $requestUrl );
        curl_setopt ( $ch, CURLOPT_FAILONERROR, false );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_TIMEOUT,5);
        //以post请求发送
/*        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $sysParams );*/
        $words = curl_exec ( $ch );
//        kohana::$log->add('transcategory1',$target.'||'.$words);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($statusCode == 200)
        {
            return $words;  
        }
        else
        {
            return 1;
        }
    }

    public static function transCategory($target='',$category_id)
    {
        $key = 'category'.$target.$category_id;
        $data = Cache::instance('memcache')->get($key);
        if(!empty($newrepla) && count($newrepla)>10)
        {
            $return = $data;
        }
        else
        {
            $exist = DB::select('name', 'meta_title', 'meta_keywords', 'meta_description')->from('products_transcategory')
                ->where('category_id', '=', $category_id)
                ->where('lang','=',$target)
                ->execute()
                ->current();
            if($exist)
            {
                $return = $exist;
            }
            else
            {
                $data = DB::select('name', 'meta_title', 'meta_keywords', 'meta_description')->from('products_category')
                    ->where('id', '=', $category_id)
                    ->execute()
                    ->current();

                $strepla = implode('+', $data);

                $words = Site::googletransapi($blank = 'en', $target, $strepla);
                if ($words != 1) {
                    $words = json_decode($words);
                    $words = $words->data->translations[0]->translatedText;
                    $res = explode('+', $words);

                    $set['name'] = $res[0];
                    $set['meta_title'] = (isset($res[1]) and !empty($res[1]))?$res[1]:'';
                    $set['meta_keywords'] = (isset($res[2]) and !empty($res[2]))?$res[2]:'';
                    $set['meta_description'] = (isset($res[3]) and !empty($res[3]))?$res[3]:'';
                    $set['category_id'] = $category_id;
                    $set['lang'] = $target;
                    DB::insert('products_transcategory', array_keys($set))->values($set)->execute();

                    $return = $set;
                }
                else
                {
                    $return = $data;
                }
            }
            Cache::instance('memcache')->set($key, $return, 86400 * 20);
        }
        return $return;
    }
}
