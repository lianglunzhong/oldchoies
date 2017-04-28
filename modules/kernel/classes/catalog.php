<?php

defined('SYSPATH') or die('No direct script access.');

class Catalog
{

    private static $instances;
    private static $instances1;
    private $data;
    private $site_id;
    private $lang;
    private $lang_table;

    public static function &instance($id = 0, $lang = '')
    {
        if($lang)
        {
            if( ! isset(self::$instances1[$id]))
            {
                $class = __CLASS__;
                self::$instances1[$id] = new $class($id, $lang);
            }
            return self::$instances1[$id];
        }
        else
        {
            if (!isset(self::$instances[$id]))
            {
                $class = __CLASS__;
                self::$instances[$id] = new $class($id, $lang);
            }
            return self::$instances[$id];
         }
    }

    public function __construct($id, $lang)
    {
        $this->site_id = Site::instance()->get('id');
        $this->lang = $lang;
        $this->lang_table = ($lang === 'en' OR $lang === '') ? '' : '_' . $lang;
        $this->_load($id);
    }

    public function _load($id)
    {
        if (!$id)
            return FALSE;
        $cache = Cache::instance('memcache');
        $key = $this->site_id."/catalog/".$id."/".$this->lang;
        if( ! ($data = $cache->get($key)))
        {
            $catalog = ORM::factory('catalog', $id);
            $data = array();
            if ($catalog->loaded())
            {
                $data = $catalog->as_array();
                $cache->set($key, $data, 7200);
            }
        }
        $this->data = $data;
    }

    public function loadByLink($link, $id = 0)
    {
        if (!$link)
            return false;
        $this->data = DB::select()->from('products_category')
                ->where('link', '=', $link)->execute()->current();
        return self::$instances[$id];
    }

    /**
     * 获取Catalog的基本数据
     * @param <type> $key 数据名称。
     * @return <type> 如果给出$key，则返回$key指定的数据内容(String Or Integer..)。如不填，则返回产品的所有基本数据(Array)。
     */
    public function get($key = NULL)
    {
        if (empty($key))
        {
            return $this->data;
        }
        else
        {
            return isset($this->data[$key]) ? $this->data[$key] : NULL;
        }
    }

    public function permalink()
    {

        $data = '';
        $route_type = Site::instance()->get('route_type');
        if(LANGUAGE)
            $langurl =  LANGUAGE . '/';
        else
            $langurl = '';
        switch ($route_type)
        {
            default :
                $data = URL::base(FALSE, TRUE) . $langurl . Site::instance()->get('catalog') . '/' . $this->data['id'];
                break;

            case 1 :
                $data = URL::base(FALSE, TRUE) . $langurl . Site::instance()->get('catalog') . '/' . $this->data['id'];
                break;

            case 2 :
                $data = url::base(FALSE, TRUE) . $langurl . $this->data['link'] . '-c-' . $this->data['id'];
                break;
        }
        return $data;
    }

    /**
     * 返回分类的面包屑导航数据
     * @return array 按辈份高->低排序下标0->n，是以array('id','name','link')为单元的多维数组
     */
    public function crumbs()
    {
        if(isset($this->data['id']))
        {
            $key = Site::instance()->get('id') . '/catalog/' . $this->data['id'] . '/crumb'.$this->lang;
            $cache = Cache::instance('memcache');
            if (!($data = $cache->get($key)))
            {
                $data = array();
                $ancestors = array_reverse($this->ancestor());
                foreach ($ancestors as $parent_id)
                {
                    $data[] = array(
                        'id' => $parent_id,
                        'name' => Catalog::instance($parent_id, $this->lang)->get('name'),
                        'link' => Catalog::instance($parent_id, $this->lang)->permalink()
                    );
                }
    //最后附加自身：
                $data[] = array(
                    'id' => $this->data['id'],
                    'name' => $this->data['name'],
                    'link' => $this->permalink(),
                );

                $cache->set($key, $data, 600);
            }
            return $data;            
        }
    }

    //返回英文的面包屑，用于壹玛仕调用
    public function crumbs2()
    {
        $key = Site::instance()->get('id') . '/catalog/' . $this->data['id'] . '/crumb2'.$this->lang ;
        $cache = Cache::instance('memcache');
        if (!($data = $cache->get($key)))
        {
            $data = array();
            $ancestors = array_reverse($this->ancestor());
            foreach ($ancestors as $parent_id)
            {
                $data[] = array(
                    'id' => $parent_id,
                    'name' => Catalog::instance($parent_id)->get('name'),
                    'link' => Catalog::instance($parent_id)->permalink()
                );
            }

//最后附加自身：
            $data[] = array(
                'id' => $this->data['id'],
                'name' => Catalog::instance($this->data['id'])->get('name'),
                'link' => Catalog::instance($this->data['id'])->permalink()
            );

            $cache->set($key, $data, 600);
        }
        return $data;
    }

    /**
     * 返回该分类的祖先分类
     * @return array
     */
    public function ancestor()
    {
        $data = array();
        $parent_id = $this->get('parent_id');
        $i = 10;
        while (1)
        {
            $i++;
            if ($i < 0)
                break;
            if ($parent_id != 0)
            {
                $data[] = $parent_id;
                $parent_id = Catalog::instance($parent_id)->get('parent_id');
            }
            else
            {
                break;
            }
        }

        return $data;
    }

    /**
     * 返回该分类的孩子分类
     * @param bool $is_filter 为TRUE则选出条件分类，否则选出实际分类
     * @return array
     */
    public function children($is_filter = 'all', $only_visible = TRUE)
    {
        $key = Site::instance()->get('id') . '/catalog/' . $this->data['id'] . '/children';
        $cache = Cache::instance('memcache');

        if (!($data = $cache->get($key)))
        {
            $result = DB::select('id')->from('products_category')
                ->and_where('parent_id', '=', $this->data['id']);

            if (!$is_filter)
            {
                $result = $result->and_where('is_filter', '=', '0');
            }
            elseif ($is_filter AND $is_filter != 'all')
            {
                $result = $result->and_where('is_filter', '!=', '0');
            }

            if ($only_visible)
            {
                $result = $result->and_where('visibility', '=', '1');
            }

            $result = $result->order_by('position', 'desc')->order_by('id')->execute('slave');

            $data = array();
            foreach ($result as $item)
            {
                $data[] = $item['id'];
            }

            $cache->set($key, $data, 1200);
        }
        return $data;
    }

    /**
     * Get posterity ids recursive
     *
     * @param $id
     * @return array
     */
    public function posterity($is_filter = FALSE, $only_visible = TRUE)
    {
        $data = array();
        $childrens = self::children($is_filter, $only_visible);
        $data = $childrens;

        foreach ($childrens as $children)
        {
            $data = array_merge($data, Catalog::instance($children)->posterity($is_filter, $only_visible));
        }
        return $data;
    }

    public function custom_filter_sql($data)
    {
//TODO options searching within simple products in each configurable product
//options keywords
        $sql = array(
            'search' => ' ',
            'option_ids' => ' ',
            'options_join' => ' ',
            'price_range' => ' ',
            'attribute_value' => ' ',
            'attribute_value_join' => ' ',
            'sql' => ' ',
        );

        if (!$data)
        {
            return $sql;
        }

        if (!empty($data['options']) AND count($data['options']))
        {


            foreach ($data['options'] as $attr_id => $opt_ids)
            {
                $sql['options_join'] .= ' LEFT JOIN product_options po_' . $attr_id . ' ON (po_' . $attr_id . '.product_id = products.id) ';
                $sql['option_ids'] .= ' AND po_' . $attr_id . '.option_id IN (' . implode(',', $opt_ids) . ') ';
            }
        }

        if (!empty($data['price_range']) AND count($data['price_range']) == 2)
        {
            if ($data['price_range'][0] == -1)
            {
                $sql['price_range'] = " AND products.price <= '" . $data['price_range'][1] . "' ";
            }
            elseif ($data['price_range'][1] == -1)
            {
                $sql['price_range'] = " AND products.price > '" . $data['price_range'][0] . "' ";
            }
            else
            {
                $sql['price_range'] = " AND products.price > '" . $data['price_range'][0] . "' AND products.price <= '" . $data['price_range'][1] . "' ";
            }
        }


        if (isset($data['keywords']) AND $data['keywords'] != '')
        {
            $sql['search'] = " AND MATCH (products.name,products.sku,products.keywords) AGAINST ('" . $data['keywords'] . "' IN BOOLEAN MODE) ";
        }

        if (isset($data['filter_attirbutes']) AND $data['filter_attirbutes'] != '')
        {
            $join_key = 0;
            foreach ($data['filter_attirbutes'] as $f)
            {
                $join_key ++;
                $sql['attribute_value_join'] .= " INNER JOIN  `product_attribute_values` a$join_key ON ( products.`id` = a$join_key.`product_id` ) ";
                $sql['search'] .= " AND a$join_key.`attribute_id` IN ( $f )";
            }
        }

        if (isset($data['attribute_value']) AND $data['attribute_value']['value'] != '')
        {

            $sql['attribute_value_join'] .= ' LEFT JOIN product_attribute_values ON product_attribute_values.product_id = products.id ';
            $value_sql = array();
            foreach ($data['attribute_value']['value'] as $value)
            {
                $value_sql[] = "product_attribute_values.value LIKE('%" . $value . "%')";
            }
            $value_sql = '(' . implode(' OR ', $value_sql) . ')';
            $sql['attribute_value'] = " AND product_attribute_values.attribute_id = " . $data['attribute_value']['attribute_id'] . " AND " . $value_sql;
        }

        // custom sql
        if (isset($data['sql']) AND $data['sql'] != '')
        {
            $sql['sql'] = $data['sql'];
        }

        return $sql;
    }

    public function all_products($_orderby = NULL, $_desc = NULL)
    {

        if (!$this->get('id'))
            return array();

        $orderby_keys = array('hits', 'price', 'name', 'created', 'position', 'has_pick');
        if (in_array($_orderby, $orderby_keys, TRUE))
        {
            if ($_orderby == 'position')
            {
                $orderby = 'products_categoryproduct.position DESC, products_product.position';
            }
            else
                $orderby = $_orderby;
        }
        else
        {
            $orderby = 'products_product.name';
        }
        
        if($orderby)
            $orderby_sql = " ORDER BY  field(".$this->data['id'].",products_categoryproduct.category_id ) DESC," . $orderby . ' ' . $_desc . ", products_product.display_date DESC";
        else
            $orderby_sql = " ORDER BY  field(".$this->data['id']."products_categoryproduct.category_id ) DESC,products_product.display_date DESC";

        if ($this->data['is_filter'])
        {
            return $this->filter_products($limit_sql, $orderby_sql, $custom_filter);
        }
        else
        {
            return $this->basic_all_products($orderby_sql, $_orderby, $_desc);
        }
    }

    //guo add 11.11
    public function getpostsql()
    {
        $posterity_ids = $this->posterity();
        if(!empty($posterity_ids))
            $posterity_sql = $this->data['id'] . ',' . implode(',', $posterity_ids);
        else
            $posterity_sql = $this->data['id'];     
            
        return  $posterity_sql;
    }

    public function basic_all_products($orderby_sql, $_orderby, $_desc)
    {

//get product ids
        $data = array();

//get basic catalog products
        $posterity_ids = $this->posterity();
        $posterity_ids[] = $this->data['id'];
        $posterity_sql = implode(',', $posterity_ids);

        if (empty($posterity_sql))
            return array();

        if (!$this->data['on_menu']){
        $orderby_sql = str_replace('products_categoryproduct.position', 'products_categoryproduct.positiontwo', $orderby_sql);        
        }

//        $result = DB::query(Database::SELECT, 'SELECT  products_product.id,
//                    products_product.status,
//                    products_categoryproduct.position as category_position,
//                    products_product.position,
//                    products_categoryproduct.positiontwo,
//                    products_product.display_date,
//                     products_categoryproduct.category_id
//                    FROM products_product
//                    LEFT JOIN products_categoryproduct ON products_categoryproduct.product_id=products_product.id
//                    WHERE products_categoryproduct.category_id IN (' . $posterity_sql . ')
//                    AND products_product.visibility = 1
//                    AND products_product.status = 1
//                    group by products_product.id,products_categoryproduct.category_id
//                     ' . $orderby_sql)
//            ->execute('slave')->as_array();

        #todo 如果有置顶产品,先查出置顶产品,再按时间查出其他产品（包括子分类下的产品）
        #todo 如果没有置顶产品,按时间查出产品（包括子分类下的产品）
        $result = DB::query(Database::SELECT,'SELECT DISTINCT
                c.product_id
            FROM
                products_categoryproduct c
            LEFT JOIN products_product p ON c.product_id = p.id
            WHERE
                c.category_id = '.$this->data['id'].'
            AND (c.position > 0 or c.positiontwo > 0)
            AND p. STATUS = 1
            AND p.visibility = 1
            ORDER BY
                c.position DESC,
                c.positiontwo DESC
                ')->execute('slave')
            ->as_array();

        if($result and !empty($result))
        {
            $check = '';
            foreach ($result as $value)
            {
                $check .= $value['product_id'].',';
            }
            $check = trim($check,',');

            $result2 = DB::query(Database::SELECT,'SELECT DISTINCT
                    c.product_id
                FROM
                    products_product p
                LEFT JOIN products_categoryproduct c ON c.product_id = p.id
                WHERE
                    p. STATUS = 1
                AND p.visibility = 1
                AND c.category_id IN ('.$posterity_sql.')
                AND c.product_id NOT IN ('.$check.')
                ORDER BY
                p.display_date DESC
                ')->execute('slave')
                ->as_array();

            $result = array_merge($result,$result2);
        }else{
            $result = DB::query(Database::SELECT,'SELECT DISTINCT
                    c.product_id
                FROM
                    products_product p
                LEFT JOIN products_categoryproduct c ON c.product_id = p.id
                WHERE
                    p. STATUS = 1
                AND p.visibility = 1
                AND c.category_id IN ('.$posterity_sql.')
                ORDER BY
                p.display_date DESC
                ')->execute('slave')
                ->as_array();
        }

//按价格排序时考虑促销价格
        if ($_orderby === 'price' AND count($result) > 0)
        {
            foreach ($result as $key => $item)
            {
                $results[$key]['id'] = $item['product_id'];
            }
            foreach ($results as $key => $item)
            {
                $product = Product::instance($item['id']);
                $price[$key] = $product->price();
                $results[$key]['price'] = $price[$key];
            }
            $_desc == 'desc' ? array_multisort($price, SORT_DESC, $results) : array_multisort($price, SORT_ASC, $results);
            foreach ($results as $item)
            {
                $data[] = $item['id'];
            }
        }
        else
        {
            foreach ($result as $item)
            {
                $data[] = $item['product_id'];
            }
        }

        return $data;
    }

    public function products($_offset = NULL, $_limit = NULL, $_orderby = NULL, $_desc = NULL, $custom_filter = NULL)
    {
        if (!$this->get('id'))
            return array();

        $limit_sql = ($_offset !== NULL AND $_limit !== NULL) ? ' LIMIT ' . $_offset . ',' . $_limit : '';

        $orderby_keys = array('hits', 'price', 'name', 'created', 'position', 'has_pick');
//                $orderby = in_array($_orderby, $orderby_keys, TRUE) ? 'products.' . $_orderby : 'products.name';
        if (in_array($_orderby, $orderby_keys, TRUE))
        {
            if ($_orderby == 'position')
            {
                $orderby = 'products_categoryproduct.position DESC, products_categoryproduct.position';
            }
            else
                $orderby = $_orderby;
        }
        else
        {
            $orderby = 'products_product.name';
        }
        
        if($orderby)
            $orderby_sql = " ORDER BY products_product.status DESC, " . $orderby . ' ' . $_desc . ", products_product.display_date DESC";
        else
            $orderby_sql = " ORDER BY products_product.status DESC, products_product.display_date DESC";

        if ($this->data['is_filter'])
        {
            return $this->filter_products($limit_sql, $orderby_sql, $custom_filter);
        }
        else
        {
            return $this->basic_products($limit_sql, $orderby_sql, $custom_filter, $_orderby, $_desc);
        }
    }

    public function basic_products($limit_sql, $orderby_sql, $custom_filter, $_orderby, $_desc)
    {
//get product ids
        $data = array();
        $custom_filter_sql = $this->custom_filter_sql($custom_filter);

//get basic catalog products
        $posterity_ids = $this->posterity();
        $posterity_ids[] = $this->data['id'];
        $posterity_sql = implode(',', $posterity_ids);

        if (empty($posterity_sql))
            return array();

        if (!$this->data['on_menu']){
        $orderby_sql = str_replace('products_categoryproduct.position', 'products_categoryproduct.positiontwo', $orderby_sql);        
        }

        $result = DB::query(Database::SELECT, 'SELECT distinct products_product.id,products_product.status,products_product.name,products_product.display_date FROM products_product
            LEFT JOIN products_categoryproduct ON products_categoryproduct.product_id=products_product.id ' .
                $custom_filter_sql['options_join'] . $custom_filter_sql['attribute_value_join'] .
                'WHERE products_categoryproduct.product_id=products_product.id
            AND products_categoryproduct.category_id IN (' . $posterity_sql . ')
            AND products_product.visibility = 1 AND products_product.status = 1
            ' . $custom_filter_sql['price_range'] . $custom_filter_sql['option_ids'] . $custom_filter_sql['search'] . $custom_filter_sql['attribute_value'] . $custom_filter_sql['sql'] .
                $orderby_sql . $limit_sql)
            ->execute();

//按价格排序时考虑促销价格
        if ($_orderby === 'price' AND count($result) > 0)
        {
            foreach ($result as $key => $item)
            {
                $results[$key]['id'] = $item['id'];
            }
            foreach ($results as $key => $item)
            {
                $product = Product::instance($item['id']);
                $price[$key] = $product->price();
                $results[$key]['price'] = $price[$key];
            }
            $_desc == 'desc' ? array_multisort($price, SORT_DESC, $results) : array_multisort($price, SORT_ASC, $results);
            foreach ($results as $item)
            {
                $data[] = $item['id'];
            }
        }
        else
        {
            foreach ($result as $item)
            {
                $data[] = $item['id'];
            }
        }
        return $data;
    }

    public function filter_products($limit_sql, $orderby_sql, $custom_filter)
    {
        $filter = DB::select()->from('filters')
                ->where('id', '=', $this->data['is_filter'])
                ->execute()->current();
        print_r($filter);exit;

        $custom_filter_sql = $this->custom_filter_sql($custom_filter);

        $set_ids = $filter['sets'] ? $filter['sets'] : NULL;
        $option_ids = $filter['options'] ? explode(',', $filter['options']) : NULL;

        if ($filter['price_upper'])
        {
            $sql_price_upper = " AND products.price <" . $filter['price_upper'];
        }
        else
        {
            $sql_price_upper = "";
        }

        if ($filter['price_lower'])
        {
            $sql_price_lower = " AND products.price >" . $filter['price_lower'];
        }
        else
        {
            $sql_price_lower = "";
        }

//set
        if ($filter['sets'])
        {
            $sql_sets = " AND products.set_id IN (" . $filter['sets'] . ")";
        }
        else
        {
            $sql_sets = "";
        }

        if ($filter['options'] AND $filter['sets'])
        {
            $set_ids = $filter['sets'] ? explode(',', $filter['sets']) : array();
            $option_ids = $filter['options'] ? explode(',', $filter['options']) : array();

            $sql_option_ids = array();
            foreach ($set_ids as $set_id)
            {
                $intersect_options = array();
                $set_options = array();
                $result = DB::query(Database::SELECT, 'SELECT options.id FROM options
                    LEFT JOIN set_attributes
                    ON set_attributes.attribute_id=options.attribute_id
                    WHERE set_attributes.set_id =' . $set_id)->execute();
                foreach ($result as $item)
                {
                    $set_options[] = $item['id'];
                }

                $intersect_options = array_intersect($set_options, $option_ids);
                $sql_option_ids = array_merge($sql_option_ids, $intersect_options);
            }

            if ($sql_option_ids)
            {
                $sql_option_ids = implode(array_unique($sql_option_ids), ',');

                $sql_option_ids_join = " LEFT JOIN product_options
                    ON product_options.product_id = products_product.id ";
                $sql_option_ids_where = " AND product_options.option_id IN(" . $sql_option_ids . ")";
            }
        }
        else
        {
            $sql_option_ids_join = "";
            $sql_option_ids_where = "";
        }

//catalog_ids
        $sql_catalog_ids_join = '';
        $sql_catalog_ids_where = '';
        if ($this->data['parent_id'])
        {
            $posterity_ids = Catalog::instance($this->data['parent_id'])->posterity();
            $posterity_ids[] = $this->data['parent_id'];

            $sql_catalog_ids_join = " LEFT JOIN products_categoryproduct
                ON products_product.id= products_categoryproduct.product_id ";
            $sql_catalog_ids_where = " AND products_categoryproduct.catalog_id IN (" . implode($posterity_ids, ',') . ") ";
        }

        $sql = "SELECT distinct products.id FROM products_product " . $sql_catalog_ids_join .
            $sql_option_ids_join .
            $custom_filter_sql['options_join'] . $custom_filter_sql['attribute_value_join'] .
            ' WHERE products.visibility = 1 ' .
            $sql_catalog_ids_where .
            $sql_sets .
            $sql_option_ids_where .
            $custom_filter_sql['price_range'] . $custom_filter_sql['option_ids'] . $custom_filter_sql['search'] . $custom_filter_sql['attribute_value'] .
            $sql_price_lower .
            $sql_price_upper .
            $sql_sets .
            $orderby_sql .
            $limit_sql;
        $result = DB::query(Database::SELECT, $sql)->execute();

        $data = array();
        foreach ($result as $item)
        {
            $data[] = $item['id'];
        }

        return $data;
    }

    public function basic_count_products($custom_filter)
    {
        $custom_filter_sql = $this->custom_filter_sql($custom_filter);
//get basic catalog products
        $posterity_ids = $this->posterity();
        $posterity_ids[] = $this->data['id'];
        $posterity_sql = implode(',', $posterity_ids);

        $sql = 'SELECT count(distinct products.id) as num FROM products
            LEFT JOIN catalog_products ON catalog_products.product_id=products.id' .
            $custom_filter_sql['options_join'] . $custom_filter_sql['attribute_value_join'] .
            'WHERE catalog_products.catalog_id IN (' . $posterity_sql . ')
            AND products.visibility = 1 AND status = 1
            ' . $custom_filter_sql['price_range'] . $custom_filter_sql['option_ids'] . $custom_filter_sql['search'] . $custom_filter_sql['attribute_value'] . $custom_filter_sql['sql'];

        $result = DB::query(Database::SELECT, $sql)->execute()->current();

        return $result['num'];
    }

    public function filter_count_products($custom_filter)
    {
        $filter = DB::select()->from('filters')
                ->where('id', '=', $this->data['is_filter'])
                ->execute()->current();

        $custom_filter_sql = $this->custom_filter_sql($custom_filter);

        $set_ids = $filter['sets'] ? $filter['sets'] : NULL;
        $option_ids = $filter['options'] ? explode(',', $filter['options']) : NULL;

        if ($filter['price_upper'])
        {
            $sql_price_upper = " AND products.price <" . $filter['price_upper'];
        }
        else
        {
            $sql_price_upper = "";
        }

        if ($filter['price_lower'])
        {
            $sql_price_lower = " AND products.price >" . $filter['price_lower'];
        }
        else
        {
            $sql_price_lower = "";
        }

//set
        if ($filter['sets'])
        {
            $sql_sets = " AND products.set_id IN (" . $filter['sets'] . ")";
        }
        else
        {
            $sql_sets = "";
        }

//options
        if ($filter['options'] AND $filter['sets'])
        {
            $set_ids = $filter['sets'] ? explode(',', $filter['sets']) : array();
            $option_ids = $filter['options'] ? explode(',', $filter['options']) : array();

            $sql_option_ids = array();
            foreach ($set_ids as $set_id)
            {
                $intersect_options = array();
                $set_options = array();
                $result = DB::query(Database::SELECT, 'SELECT options.id FROM options
                    LEFT JOIN set_attributes
                    ON set_attributes.attribute_id=options.attribute_id
                    WHERE set_attributes.set_id =' . $set_id)->execute();
                foreach ($result as $item)
                {
                    $set_options[] = $item['id'];
                }

                $intersect_options = array_intersect($set_options, $option_ids);
                $sql_option_ids = array_merge($sql_option_ids, $intersect_options);
            }

            if ($sql_option_ids)
            {
                $sql_option_ids = implode(array_unique($sql_option_ids), ',');

                $sql_option_ids_join = " LEFT JOIN product_options
                    ON product_options.product_id = products.id ";
                $sql_option_ids_where = " AND product_options.option_id IN(" . $sql_option_ids . ")";
            }
        }
        else
        {
            $sql_option_ids_join = "";
            $sql_option_ids_where = "";
        }

//catalog_ids
        $sql_catalog_ids_join = '';
        $sql_catalog_ids_where = '';
        if ($this->data['parent_id'])
        {
            $posterity_ids = Catalog::instance($this->data['parent_id'])->posterity();
            $posterity_ids[] = $this->data['parent_id'];

            $sql_catalog_ids_join = " LEFT JOIN catalog_products
                ON products_product.id= catalog_products.product_id ";
            $sql_catalog_ids_where = " AND catalog_products.catalog_id IN (" . implode($posterity_ids, ',') . ") ";
        }

        $sql = "SELECT count(distinct products.id) as num FROM products " . $sql_catalog_ids_join .
            $sql_option_ids_join .
            $custom_filter_sql['options_join'] . $custom_filter_sql['attribute_value_join'] .
            ' WHERE products.visibility = 1 ' .
            $sql_catalog_ids_where .
            $sql_option_ids_where .
            $custom_filter_sql['price_range'] . $custom_filter_sql['option_ids'] . $custom_filter_sql['search'] . $custom_filter_sql['attribute_value'] .
            $sql_price_lower .
            $sql_price_upper .
            $sql_sets;
        $result = DB::query(Database::SELECT, $sql)->execute()->current();

        return $result['num'];
    }

    public function count_products($custom_filter = NULL)
    {
        if (!$this->data['is_filter'])
        {
            return $this->basic_count_products($custom_filter);
        }
        else
        {
            return $this->filter_count_products($custom_filter);
        }
    }

    /**
     * Get catalogs hierarchy recursive
     *
     * @param int $parent_id default 0
     * @param int $depth default 1
     * @return array
     */
    public function catalog_tree($parent_id = 0, $depth = 1)
    {
        $catalogs_data = array();
//TODO
        $catalogs = ORM::factory('catalog')->where('parent_id', '=', $parent_id)->where('visibility', '=', 1)->find_all();
        foreach ($catalogs as $catalog)
        {
            $catalog_data = array();
            $catalog_data = $catalog->as_array();
            if ($depth > 1)
            {
                $catalog_children = self::catalog_tree($catalog->id, $depth - 1);
                $catalog_data['children'] = $catalog_children;
            }
            else
            {
                $catalog_data['children'] = array();
            }
            $catalogs_data[] = $catalog_data;
        }
        return $catalogs_data;
    }

    public function set_basic($c_data, $cata_id = NULL)
    {
        $data['conditional'] = Arr::get($c_data, 'conditional', FALSE);
        $data['name'] = htmlspecialchars(Arr::get($c_data, 'catalog_name', ''));
        $data['link'] = strtolower(preg_replace('/&|\#|\?|\%| |\//', '-', Arr::get($c_data, 'link', '')));
        $data['parent_id'] = Arr::get($c_data, 'parent_id', 0);
        $data['description'] = Arr::get($c_data, 'description', '');
        $data['site_id'] = Arr::get($c_data, 'site_id', 0);

        if (in_array($data['link'], Site::instance()->system_links()))
        {
            return __('duplicated_url');
        }

        $data['orderby'] = Arr::get($c_data, 'orderby', 'hits');
        $data['desc'] = Arr::get($c_data, 'desc', 'desc') != 'desc' ? 'asc' : 'desc';
        $orderby_keys = array('hits', 'price', 'name', 'created');
        $data['orderby'] = in_array($data['orderby'], $orderby_keys) ? $data['orderby'] : 'hits';

        $data['visibility'] = Arr::get($c_data, 'catalog_visibility', 1);
        $data['stereotyped'] = Arr::get($c_data, 'stereotyped_m', 0);
        $data['on_menu'] = Arr::get($c_data, 'on_menu', 1);
        $data['searchable_attributes'] = implode(',', Arr::get($c_data, 'searchable_attributes', array()));
        $data['template'] = Arr::get($c_data, 'template', '');

        $data['recommended_products'] = Arr::get($c_data, 'recommended_products', '');

        $price_ranges = explode(',', Arr::get($c_data, 'price_ranges', ''));
        sort($price_ranges);
        foreach ($price_ranges as $k => $v)
        {
            if (floatval($v) <= 0)
            {
                unset($price_ranges[$k]);
            }
            else
            {
                $price_ranges[$k] = floatval($v);
            }
        }
        $data['price_ranges'] = implode(',', $price_ranges);

        $data['meta_title'] = htmlspecialchars(Arr::get($c_data, 'meta_title', ''));
        $data['meta_keywords'] = htmlspecialchars(Arr::get($c_data, 'meta_keywords', ''));
        $data['meta_description'] = htmlspecialchars(Arr::get($c_data, 'meta_description', ''));

        $data['image_src'] = Arr::get($c_data, 'image_src', '');
        $data['image_link'] = Arr::get($c_data, 'image_link', '');
        $data['image_alt'] = htmlspecialchars(Arr::get($c_data, 'image_alt', ''));
        $data['image_map'] = Arr::get($c_data, 'image_map', '');

        $images = Arr::get($c_data, 'image_bak', '');
        $images = $images ? explode(',', $images) : array();
        $removed_images = array();
        $dir = kohana::debug('upload.resource_dir') . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
        foreach ($images as $file_name)
        {
            if ($file_name AND $file_name != $data['image_src'])
            {
                $removed_images[] = $file_name;
                if (file_exists($dir . $file_name))
                {
                    unlink($dir . $file_name);
                }
            }
        }
        if ($removed_images)
        {
            DB::delete('site_images')->where('filename', 'in', $removed_images)->execute();
        }

        $catalog = ORM::factory('catalog', $cata_id);
        $same_url_catalog = ORM::factory('catalog')
            ->where('link', '=', $data['link'])
            ->find();
        if ($same_url_catalog->loaded() AND (!$cata_id OR $same_url_catalog->id != $cata_id))
        {
            $message = '操作失败: 已有相同URL的分类"' . $same_url_catalog->name . '"存在，如想修改那个分类，请<a href="/admin/site/catalog/edit/' . $same_url_catalog->id . '">点击这里</a>。';
            return $message;
        }
        if ($data['conditional'])
        {
            $c_data['condition']['catalogs'][] = $data['parent_id'];
            $c_data['condition']['site_id'] = $data['site_id'];
            $data['is_filter'] = filter::set($c_data['condition'], $cata_id ? $catalog->is_filter : NULL);
            if (!$data['is_filter'])
            {
                $message = '操作失败: 未能保存过滤器。';
                return $message;
            }
        }

        // add is_brand
        $data['is_brand'] = Arr::get($c_data, 'is_brand', 0);
        $data['position'] = Arr::get($c_data, 'position', 0);

        $catalog->values($data);

        if ($catalog->check())
        {
            $catalog->save();

            $products = Arr::get($c_data, 'product_ids', '');
            Catalog::instance()->set_products($catalog->id, explode(',', $products), $cata_id ? NULL : 'new');
            $product_ids = Catalog::instance($catalog->id)->products();

            if (count($product_ids))
            {
                $sets = DB::query(1, "SELECT DISTINCT set_id FROM products WHERE id IN (" . implode(',', $product_ids) . ')')->execute()->as_array('set_id', 'set_id');
                $catalog->sets = implode(',', $sets);
                $catalog->save();
            }

            return intval($catalog->id);
        }
        else
        {
            $message = '操作失败: 数据未能通过验证。';
            return $message;
        }
    }

    public function set_products($catalog_id, $products, $is_new = NULL)
    {
        DB::delete('catalog_products')
            ->where('catalog_id', '=', $catalog_id)
            ->execute();

        foreach ($products as $idx => $pid)
        {
            DB::insert('catalog_products', array('catalog_id', 'product_id', 'position'))
                ->values(array($catalog_id, $pid, 0))
                ->execute();
        }
    }

    public function add_products($catalog_id, $products, $is_new = NULL)
    {
        $result = DB::select()->from('catalog_products')
            ->where('catalog_id', '=', $catalog_id)
            ->execute()
            ->as_array();
        foreach ($result as $id)
        {
            $product[] = $id['product_id'];
        }
        foreach ($products as $idx => $pid)
        {
            if (!in_array($pid, $product))
            {
                DB::insert('catalog_products', array('catalog_id', 'product_id', 'position'))
                    ->values(array($catalog_id, $pid, 0))
                    ->execute();
            }
        }
    }

    public function delete($id)
    {
        
    }

    public function get_tree()
    {
        $data = array();
        $children = $this->children();
        $children = array_flip($children);

        $data[$this->get('id')] = $children;

        foreach ($children as $key => $child)
        {
            $data[$this->get('id')][$key] = Catalog::instance($key)->get_tree();
        }

        return $data;
    }

    public function price_ranges()
    {
        $price_ranges = array();

        $price_ranges_tmp = !empty($this->data['price_ranges']) ? explode(',', $this->data['price_ranges']) : array();

        $start = -1;

        foreach ($price_ranges_tmp as $key => $end)
        {
            $price_ranges[$key + 1] = array($start, $end);
            $start = $end;
        }
        if ($start > 0)
        {
            $price_ranges[] = array($start, -1);
        }

        return $price_ranges;
    }

    public function is_level_1()
    {
        return $this->level() == 1;
    }

    public function is_level_2()
    {
        return $this->level() == 2;
    }

    public function level()
    {
        $children_id = DB::select('id')
            ->from('products_category')
            ->where('parent_id', '=', $this->get('id'))
            ->execute();
        $max_level = 0;
        foreach ($children_id as $child_id)
        {
            $child = new Catalog($child_id);
            $child_level = $child->level();
            if ($child_level > $max_level)
                $max_level = $child_level;
        }

        return $max_level + 1;
    }

    public function breadcrumb()
    {
        $breadcrumb = array(array(
                'name' => $this->get('name'),
                'link' => $this->get('link'),
            ));

        $parent = new Catalog($this->get('parent_id'));
        if ($parent->get('id'))
        {
            $breadcrumb = array_merge($parent->breadcrumb(), $breadcrumb);
        }

        return $breadcrumb;
    }

    public static function menu_tree($root = 0, $depth = 1, $on_menu = 1)
    {
        if ($depth <= 0)
            return array();

        $children = DB::select(DB::expr('id, name, link'))
            ->from('products_category')
            ->where('parent_id', '=', $root)
            ->where('visibility', '=', 1)
            ->where('on_menu', '=', $on_menu)
            ->execute();

        $catalog_tree = array();
        foreach ($children as $child)
        {
            $child['children'] = self::menu_tree($child['id'], $depth - 1);
            $catalog_tree[] = $child;
        }

        return $catalog_tree;
    }

    public function recommend_products($limit = NULL)
    {
        $products_id = explode(',', $this->get('recommended_products'));
        $products = array();
        foreach ($products_id as $idx => $product_id)
        {
            if ($limit && $idx == $limit)
                break;
            $products[] = new Product($product_id);
        }

        return $products;
    }

    public function cover_image()
    {
        if ($this->get('image_src'))
            return "/simages/" . $this->get('image_src');

        $product = $this->products(0, 1);
        if ($product)
        {
            $product = new Product($product[0]);
            $product_image = Image::link($product->cover_image(), 3);
            return $product_image;
        }

        return '';
    }

}
