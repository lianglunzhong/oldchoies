<?php defined('SYSPATH') or die('No direct script access.');

class Filter
{
    private static $instances;
    public $data;
    private $site_id;

    public static function & instance($id = 0)
    {
        if( ! isset(self::$instances[$id]))
        {
            $class = __CLASS__;
            self::$instances[$id] = new $class($id);
        }
        return self::$instances[$id];
    }

    public function __construct($id)
    {
        $this->site_id = Site::instance()->get('id');
        $this->_load($id);
    }

    public function _load($id)
    {
        if(!$id)
        {
            return FALSE;
        }
        //TODO
        //add memcache 30 days --- sjm 2015-12-17
        $cache = Cache::instance('memcache');
        $cache_key = 'filters_' . $id;
        if(!$filter_data = $cache->get($cache_key))
        {
            $filter = ORM::factory('filter',$id);

            if($filter->loaded())
            {
                $filter_data = $filter->as_array();
            }
            else
            {
                $filter_data = array();
            }
//            kohana::$log->add('filter_data',json_encode($filter_data));
            $cache->set($cache_key, $filter_data, 30 * 86400);
        }
        $this->data = $filter_data;

    }

    public function get($key = NULL)
    {
        if(empty($key))
        {
            return $this->data;
        }
        else
        {
            return isset($this->data[$key]) ? $this->data[$key] : '';
        }
    }

    public static function set($conditions, $filter_id = null)
    {
        $catalogs = Arr::get($conditions, 'catalogs', array( ));
        $options = Arr::get($conditions, 'options', array( ));
        $sets = Arr::get($conditions, 'sets', array( ));
        $attributes = Arr::get($conditions, 'attributes', array( ));
        $price_upper = Arr::get($conditions, 'price_upper', 0);
        $price_lower = Arr::get($conditions, 'price_lower', 0);

        $filter = ORM::factory('filter', $filter_id);

        if(count($catalogs))
        {
            $filter->catalogs = implode(',', $catalogs);
        }
        else
        {
            $filter->catalogs = 0;
        }

        if(count($sets))
        {
            $filter->sets = implode(',', $sets);
        }
        else
        {
            $filter->sets = 0;
        }

        if(count($options))
        {
            $filter->options = implode(',', $options);
        }
        else
        {
            $filter->options = 0;
        }

        if(count($attributes))
        {
            foreach( $attributes as $key => $attr )
            {
                if($attr[0] == '' AND $attr[1] == '')
                {
                    unset($attributes[$key]);
                }
                $attributes[$key] = htmlspecialchars($attr);
            }
            $filter->attributes = serialize($attributes);
        }
        else
        {
            $filter->attributes = '';
        }


        $filter->price_upper = $price_upper;
        $filter->price_lower = $price_lower;
        $filter->site_id = Arr::get($conditions, 'site_id', 0);

        if($filter->save())
        {
            return $filter->id;
        }
        else
        {
            return false;
        }
    }

    public function products($_offset = NULL, $_limit = NULL, $_orderby = NULL, $_desc= NULL)
    {

        $limit_sql = '';
        if($_offset !== NULL AND $_limit !== NULL)
        {
            $limit_sql = ' LIMIT '.$_offset.','.$_limit;
        }

        $_desc == 'desc' ? $desc = ' DESC' : $desc = ' ASC';

        $orderby_keys = array('hits','price','name','created');
        in_array($_orderby,$orderby_keys,TRUE) ? $orderby = $_orderby : $orderby = 'name';
        $orderby_sql = "ORDER BY ".$orderby.$desc;

        $catalog_ids = $this->data['catalogs'] ? explode(',',$this->data['category']) : array();
        $set_ids = $this->data['sets'] ? $this->data['set'] : array();
        $option_ids = $this->data['options'] ? explode(',',$this->data['options']) : array(); 

        if($this->data['price_upper'])
        {
            $sql_price_upper = " AND products.price <".$this->data['price_upper'];
        }
        else
        {
            $sql_price_upper = "";
        }

        if($this->data['price_lower'])
        {
            $sql_price_lower = " AND products.price >".$this->data['price_lower']; 
        }
        else
        {
            $sql_price_lower = "";
        }

        //set
        if($this->data['sets'])
        {
            $sql_sets = " AND products.set_id IN (".$this->data['sets'].")";
        }
        else
        {
            $sql_sets = "";
        }

        //options 
        if($this->data['options'] AND $this->data['sets'])
        {
            $option_ids = explode(',',$this->data['options']);
            $sql_option_ids = Option::complements($option_ids);
            $sql_option_ids = implode($sql_option_ids,',');

            $sql_option_ids_join = " LEFT JOIN product_options 
                ON product_options.product_id = products.id ";
            $sql_option_ids_where = " AND product_options.option_id NOT IN(".$sql_option_ids.")";
        }
        else
        {
            $sql_option_ids_join = "";
            $sql_option_ids_where = "";
        }

        //catalog_ids
        $catalog_ids = $this->data['catalogs'] ? explode(',',$this->data['catalogs']) : array();
        $data = array();
        foreach($catalog_ids as $catalog_id)
        {
            $children = Catalog::instance($catalog_id)->children();
            $data  = array_unique(array_merge($data,array($catalog_id),$children));
        }
        if($data)
        {
            $sql_catalog_ids_join = " LEFT JOIN products_categoryproduct 
                ON products_product.id= products_categoryproduct.product_id ";
            $sql_catalog_ids_where = " WHERE products_categoryproduct.category_id IN (".implode($data,',').") 
                AND products_product.visibility = 1 ";
        }
        else
        {   $sql_catalog_ids_join = "";
        $sql_catalog_ids_where = " WHERE products_product.visibility = 1 ";
        }

        $sql = "SELECT products_product.id FROM products_product ".$sql_catalog_ids_join.
            $sql_option_ids_join.
            $sql_catalog_ids_where.
            $sql_option_ids_where.
            $sql_price_lower.
            $sql_price_upper.
            $sql_sets.
            " GROUP BY products.id ".
            $orderby_sql.
            $limit_sql; 

        $result = DB::query(Database::SELECT,$sql)->execute();

        $data = array();
        foreach($result as $item)
        {
            $data[] = $item['id'];
        }
        return $data;
    }

    /**
     * check whether a product is under this filter, if so ,return TRUE, 
     * otherwise return FALSE
     */
    public function check_product($product_id)
    {

        if(empty($this->data['id']))
        {
            return FALSE;
        }

        $product = Product::instance($product_id);

        if($this->data['set'])
        {
            $sets = explode(',',$this->data['set']);

            if(FALSE === array_search($product->get('set_id'),$sets))
            {
                return FALSE;
            }
        }

        if($this->data['price_upper'] AND ($product->get('price') > $this->data['price_upper']))
        {
            return FALSE;
        }

        if($this->data['price_lower'] AND ($product->get('price') < $this->data['price_lower']))
        {
            return FALSE;
        }

        //TODO save product_catalogs in product-instance for multiple 
        //promotion checking
        if($this->data['category'])
        {

            $catalogs = explode(',',$this->data['category']);

            $cache = Cache::instance('memcache');
            $cache_key = 'product_catalogs_' . $product_id;
            if( ! ($product_catalogs = $cache->get($cache_key)))
            {
                $product_catalogs = DB::query(Database::SELECT,"SELECT category_id FROM products_categoryproduct WHERE product_id = ".$product_id)->execute()->as_array('category_id','category_id');
                $cache->set($cache_key, $product_catalogs, 3600);
            }

            $product_catalog_ancestors = $product_catalogs;
            $find = FALSE;
            foreach($product_catalogs as $catalog_id)
            {
                if(array_intersect($catalogs,$product_catalog_ancestors))
                {
                    $find = TRUE;
                    break;
                }

                $product_catalog_ancestors = array_unique(array_merge($product_catalog_ancestors,Catalog::instance($catalog_id)->ancestor()));
            }

            if(!$find AND array_intersect($catalogs,$product_catalog_ancestors))
            {
                $find = TRUE;
            }

            if(!$find)
            {
                return FALSE;
            }
        }

        //TODO save complement_options in product-instance for multiple 
        //promotion checking
//        if($this->data['options'] AND $this->data['set'])
//        {
//            $option_ids = explode(',',$this->data['options']);
//            $complement_option_ids = Option::complements($option_ids);
//            if(array_intersect($complement_option_ids,$product->options()))
//            {
//                return FALSE;
//            }
//        }

        return TRUE;
    }

}
