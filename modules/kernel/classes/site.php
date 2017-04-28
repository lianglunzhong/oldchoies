<?php
defined('SYSPATH') or die('No direct script access.');

class Site
{

        public static $instances;
        private $data;

        public static function & instance($id = 0, $domain = NULL)
        {
                if( ! isset(self::$instances[$id]))
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
                $key = "site/".$id.'/'.$domain;
                $cache = Cache::instance();

                if( ! ($data = $cache->get($key, array( ))))
                {
                        if( ! $id)
                        {
                                $data = DB::select()->from('core_sites')->where('domain', '=', $domain)->execute()->current();
                        }
                        else
                        {
                                $data = DB::select()->from('core_sites')->where('id', '=', $id)->execute()->current();
                        }
                        if($data) $cache->set($key, $data);
                }
                $this->data = $data;
        }

        public function get($key = NULL)
        {
                if(empty($key))
                {
                        return $this->data;
                }
                return isset($this->data[$key]) ? $this->data[$key] : '';
        }

        public function id()
        {
                if( ! Session::instance()->get('SITE_ID', NULL))
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

                foreach( $docs as $doc )
                {
                        Route::set($doc['name'], '<link>', array( 'link' => $doc['link'] ))
                            ->defaults(array(
                                'controller' => 'site',
                                'action' => 'doc'
                            ));
                }

                switch( $this->data['route_type'] )
                {
                        case 1:
                                // product
                                Route::set('product', $this->data['product'].'/<id>', array( 'link' => '[\w-]+' )
                                    )
                                    ->defaults(array(
                                        'controller' => 'site',
                                        'action' => 'product',
                                    ));

                                // catalog
                                Route::set('catalog', $this->data['catalog'].'/<id>', array( 'id' => '[\w-]+' )
                                    )
                                    ->defaults(array(
                                        'controller' => 'site',
                                        'action' => 'catalog',
                                    ));
                                break;

                        case 2:
                                // product
                                Route::set('product', $this->data['product'].'/<id>', array( 'link' => '[\w-]+' )
                                    )
                                    ->defaults(array(
                                        'controller' => 'site',
                                        'action' => 'product',
                                    ));

                                // catalog url: catalog_link
                                $catalogs = DB::select('id', 'link')->from('products_category')->where('site_id', '=', $this->data['id'])->where('visibility', '=', 1)->execute();
                                foreach( $catalogs as $catalog )
                                {
                                        Route::set('catalog/'.$catalog['id'], '<id>(/<link>)', array( 'id' => $catalog['link'], 'link' => '[\w-]+' ))
                                            ->defaults(array(
                                                'controller' => 'site',
                                                'action' => 'catalog'
                                            ));
                                }
                                break;

                        default:
                                // product
                                Route::set('product', $this->data['product'].'/<id>', array( 'id' => '\d+' )
                                    )
                                    ->defaults(array(
                                        'controller' => 'site',
                                        'action' => 'product',
                                    ));

                                // catalog
                                Route::set('catalog', $this->data['catalog'].'/<id>', array( 'id' => '\d+' )
                                    )
                                    ->defaults(array(
                                        'controller' => 'site',
                                        'action' => 'catalog',
                                    ));
                                break;
                }

                // catalog hierarchy tree
                //TODO
                Route::set('catalog_left', 'catalog/catalog_left/(<parent_id>/(<depth>))', array( 'parent_id' => '\d+', 'depth' => '\d+' ))->defaults(array( 'controller' => 'catalog', 'action' => 'catalog_left' ));

                // API ROUTE
                Route::set('api', 'api/<controller>/<action>(/<id>)')->defaults(array( 'directory' => 'api', ));
        }

        public function set_route()
        {
                $pages = ORM::factory('page')
                    ->where('site_id', '=', $this->get('id'))
                    ->find_all();
                foreach( $pages as $page )
                {
                        Route::set("route-{$page->name}", '<url>', array( 'url' => $page->url ))
                            ->defaults(array(
                                'controller' => 'site',
                                'action' => 'page'
                            ));
                }
        }

        public function root_catalogs()
        {
                $cache = Cache::instance();
                $key = $this->data['id'].'/root';

                if( ! ($data = $cache->get($key)))
                {
                        $result = DB::select('id')->from('products_category')
                                ->where('site_id', '=', $this->data['id'])
                                ->and_where('parent_id', '=', 0)
                                ->and_where('visibility', '=', '1')
                                ->order_by('position')
                                ->order_by('id')
                                ->execute()->as_array();
                        $data = array( );
                        foreach( $result as $item )
                        {
                                $data[] = $item['id'];
                        }

                        $cache->set($key, $data);
                }

                return $data;
        }

        public function docs()
        {
                $cache = Cache::instance();
                $key = $this->get('id').'/docs';

                if( ! ($data = $cache->get($key)))
                {
                        $data = DB::select('name', 'link')->from('docs')
                                ->where('site_id', '=', $this->data['id'])
                                ->and_where('is_active', '=', '1')
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
                if(isset($currencies[0]) AND $currencies[0])
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
                $currency = array( );
                $currency['name'] = $session->get('currency_name');
                if(isset($currency['name']) AND $currency['name'])
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
                    $currencies = DB::select()->from('currencies')->where('name', '=', $now_currrency)->execute()->current();
                    return $currencies;
                }
                else
                {
                    $data = DB::select()->from('currencies')->where('name', 'IN', $currency_names)->execute();
                    foreach( $data as $currency )
                    {
                            $currencies[$currency['name']] = $currency;
                    }
                    return $currencies;
                }
        }

        public function currency_set($name)
        {
                $session = Session::instance();
                $currency = $this->currency_get($name);

                if(isset($currency['name']) AND $currency['name'])
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
                $currency = array( );
                $data = Site::instance()->currencies($name);
                if($data['rate'])
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
                if( ! $currency_exchange)
                {
                        $currency_exchange = $this->default_currency();
                }
                $currency_exchange = Site::instance()->currencies($currency_exchange);

                $price_usd = $price_exchange / $currency_exchange['rate'];

                if($currency_view)
                {
                        $currency = $currency_view;
                }
                else
                {
                        $currency = $this->currency();
                }
                $price = round($price_usd * $currency['rate'], $format);

                switch( $type )
                {
                        case 'name_view':
                                $price_str = $currency['name'].$price;
                                break;
                        case 'code_view':
                                $price_str = $currency['code'].$price;
                                break;
                        default:
                                $price_str = $price;
                                break;
                }

                if($fill_zero)
                {
                        $price_str = Toolkit::fill_zero($price_str, $format);
                }

                return $price_str;
        }

        public function countries()
        {
                $result = DB::select('name', 'isocode')
                        ->from('countries')
                        ->where('site_id', '=', $this->data['id'])
                        ->and_where('is_active', '=', 1)
                        ->order_by('position', 'ASC')
                        ->execute()->as_array();
                return $result;
        }

        public function carriers($isocode = FALSE)
        {
                $result = DB::select()
                        ->from('core_carriers')
                        ->where('site_id', '=', $this->data['id'])
                        ->and_where('isocode', 'in', array( '0', $isocode ))
                        ->order_by('position')
                        ->order_by('isocode', 'ASC')
                        ->execute()->as_array();

                $carriers = array( );
                foreach( $result as $key => $value )
                {
                        $carriers[$value['carrier']] = $value;
                }

                return $carriers;
        }

        public function get_specific_group_id($specific_name)
        {
                $specifics = kohana::config('sites.'.Site::instance()->get('id').'.specific_groups');
                if(isset($specifics[$specific_name]))
                {
                        return $specifics[$specific_name];
                }
                return 0;
        }

        public function products($_offset = 0, $_limit = NULL, $_orderby = NULL, $_desc = NULL)
        {
                $_limit ? $limit = $_limit : $limit = $this->data['per_page'];
                $limit_sql = ' LIMIT '.$_offset.','.$limit;

                $_desc ? $desc = ' DESC' : $desc = ' ASC';

                $orderby_keys = array( 'hits', 'price', 'name', 'created' );
                in_array($_orderby, $orderby_keys, TRUE) ? $orderby = $_orderby : $orderby = 'name';
                $orderby_sql = " ORDER BY ".$orderby.$desc;

                $result = DB::query(1, "SELECT id FROM products WHERE site_id = ".$this->data['id'].$orderby_sql.$limit_sql)->execute();

                foreach( $result as $item )
                {
                        $data[] = $item['id'];
                }
                return $data;
        }

        public function system_links()
        {
                $links = array( 'forum', '404', 'admin' );

                $results = DB::query(1, 'SELECT id,link FROM docs WHERE site_id = '.$this->data['id'])->execute()->as_array('id', 'link');

                $links = array_merge($links, $results);

                return $links;
        }

        public function domain()
        {
                $https = '';
                if($this->get('ssl') == 1)
                {
                        $https = 'https://';
                }
                else
                {
                        $https = 'http://';
                }

                $domain = $https.$this->get('domain');

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
                $cats = DB::query(Database::SELECT, 'SELECT distinct catalog_id FROM labels WHERE site_id='.Site::instance()->get('id').' AND is_active=1')
                    ->execute()
                    ->as_array();
                $num = 0;
                foreach( $cats as $cat )
                {
                        $catalog = ORM::factory('catalog')
                            ->where('site_id', '=', Site::instance()->get('id'))
                            ->where('id', '=', $cat['catalog_id'])
                            ->find();
                        if($catalog->loaded())
                        {
                                Route::set($catalog->link.$num, 'tags/<link>', array( 'link' => $catalog->link ))
                                    ->defaults(array(
                                        'controller' => 'tags',
                                        'action' => 'catalog'
                                    ));
                        }
                        $num ++;
                }
                $cats = DB::query(Database::SELECT, 'SELECT distinct defined_catalog_link FROM labels WHERE site_id='.Site::instance()->get('id').' AND is_active=1 AND defined_catalog<>\'null\' AND defined_catalog<>\'\'')
                    ->execute()
                    ->as_array();
                foreach( $cats as $cat )
                {
                        Route::set(urlencode($cat['defined_catalog_link']), 'tags/<link>', array( 'link' => $cat['defined_catalog_link'] ))
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
                if(!$cid OR !$type)
                {
                        return false;
                }
                else {
                    $celebrity = DB::select('id')->from('celebrities_celebrits')->where('id', '=', $cid)->execute()->get('id');
                    if ($celebrity) {
                        $fid = DB::select('id')->from('celebrities_flows')->where('celebrity_id', '=', $cid)->and_where('types', '=', $type)->and_where('name', '=', $name)->execute()->get('id');
                        if ($fid) {
                            DB::query(Database::UPDATE, 'UPDATE celebrities_flows SET flow=flow+1 WHERE id=' . $fid)->execute();
                        } else {
                            $data = array(
                                'celebrity_id' => $cid,
                                'types' => $type,
                                'name' => $name,
                                'flow' => 1
                            );
                            DB::insert('celebrities_flows', array_keys($data))->values($data)->execute();
                        }
                        return false;
                    }
                    else
                    {
                        return false;
                    }
                }
        }
        public function add_clicks($type = '')
        {
                $types = array('continue','checkout','ppec','ppjump','globebill');
                if(!in_array($type, $types))
                {
                        return false;
                }
                else
                {
                        $result = DB::query(Database::UPDATE, 'UPDATE sites SET `'.$type.'` = `'.$type.'` + 1 WHERE id = '.$this->data['id'])->execute();
                        if($result)
                        {
                                return true;
                        }
                        else
                        {
                                return false;
                        }
                }
        }

}