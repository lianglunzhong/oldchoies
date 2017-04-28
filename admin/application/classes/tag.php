<?php
defined('SYSPATH') or die('No direct script access.');

class Tag
{

    protected static $instances;
    protected static $instances1;
    protected $data;
    protected $site_id;
    protected $lang;
    protected $lang_table;

    public static function & instance($id = 0, $lang = '')
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
        $this->data = NULL;
        $this->_load($id);
    }

    public function _load($id)
    {
        if( ! $id)
        {
            return FALSE;
        }

        $data = array( );
        $result = DB::select()->from('products' . $this->lang_table)
                ->where('site_id', '=', $this->site_id)
                ->where('id', '=', $id)
                ->execute()->current();

        if($result['id'] !== NULL)
        {
            $data = $result;
            $data['discount_price'] = $data['price'];
            $data['configs'] = $result['configs'] != '' ? unserialize($result['configs']) : '';
            //For simple-config product
            $data['attributes'] = strpos($result['attributes'], 'a:1:{') !== FALSE ? unserialize($result['attributes']) : array( );
        }

        $this->data = $data;
    }

    /**
     * 获取产品的基本数据
     * @param string $key 数据名称。
     * @return <type> 如果给出$key，则返回$key指定的数据内容(String Or Integer..)。如不填，则返回产品的所有基本数据(Array)。
     */
    public function get($key = NULL)
    {
        //配置产品无下列键值，返回其默认简单产品的相应键值
        $no_configurable_keys = array( 'price', 'market_price', 'weight', 'stock' );

        if(empty($key))
        {
            $data = $this->data;

            if($this->data['type'] == 1)
            {
                foreach( $no_configurable_keys as $key )
                {
                    $data[$key] = Product::instance($this->default_item())->get($key);
                }
            }

            return $data;
        }

        if($this->data['type'] == 1 AND in_array($key, $no_configurable_keys))
        {
            return Product::instance($this->default_item())->get($key);
        }

        return isset($this->data[$key]) ? $this->data[$key] : '';
    }

    //guo  add get all tag
    public static function getalltag($lang)
    {
        $data = array();

        $cache = Cache::instance('memcache');
        $key = "/tags/".$lang;
        if( ! ($result = $cache->get($key)))
        {
            if(!$lang){
            $result = DB::select()->from('products_tags')->order_by('position', 'DESC')
                    ->execute()->as_array();            
            }else{
            $result = DB::select()->from('products_tags'.'_'.$lang)->order_by('position', 'DESC')
                    ->execute()->as_array();               
            }

            $cache->set($key, $result, 60);
        }

        $data = $result;

        return $data;
    }

    public function set_products($catalog_id, $products, $is_new = NULL)
    {
        DB::delete('tag_product')
            ->where('tag_id', '=', $catalog_id)
            ->execute();

        foreach ($products as $idx => $pid)
        {
            DB::insert('tag_product', array('tag_id', 'product_id', 'position'))
                ->values(array($catalog_id, $pid, 0))
                ->execute();
        }
    }

    public function add_products($catalog_id, $products, $is_new = NULL)
    {
        $result = DB::select()->from('tag_product')
            ->where('tag_id', '=', $catalog_id)
            ->execute()
            ->as_array();

        $product =array();
        if($result){

            foreach ($result as $id)
            {
                $product[] = $id['product_id'];
            }            
        }


        foreach ($products as $idx => $pid)
        {
            if(!empty($product)){
                if (!in_array($pid, $product))
                {
                    DB::insert('tag_product', array('tag_id', 'product_id', 'position'))
                        ->values(array($catalog_id, $pid, 0))
                        ->execute();
                }                
            }else{
                //目录为空
                    DB::insert('tag_product', array('tag_id', 'product_id', 'position'))
                        ->values(array($catalog_id, $pid, 0))
                        ->execute();                
            }

        }
    }

    public static function getallsku($id)
    {
        $result = DB::query(Database::SELECT, 'SELECT distinct products.id FROM products
        LEFT JOIN tag_product ON tag_product.product_id=products.id WHERE tag_id ='.$id)
        ->execute();

        $data = array();
        foreach ($result as $item)
        {
            $data[] = $item['id'];
        }

        return $data;
    }

    public static function deleteallsku($id)
    {
        $result = DB::delete('tag_product')->where('tag_id','=',$id)->execute();

        return true;
    }

}
