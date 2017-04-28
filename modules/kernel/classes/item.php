<?php
defined('SYSPATH') or die('No direct script access.');

class Item
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
        if (!$id)
            return FALSE;
        $cache = Cache::instance('memcache');
        $key = "/item/".$id;
        if( ! ($data = $cache->get($key)))
        {
            $result = DB::select()->from('products_productitem')
                    ->where('id', '=', $id)
                    ->execute()->current();
            $data = $result;
            $cache->set($key, $data, 7200);
        }
        $this->data = $data;

    }

    /**
     * 获取产品ITEM的基本数据
     * @param string $key 数据名称。
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

    public static function get_itemId_by_sku($sku)
    {
        $cache = Cache::instance('memcache');
        $cache_key = "item_sku/".$sku;

        if( ! ($item_id = $cache->get($cache_key)))
        {
            $result = DB::select('id')->from('products_productitem')
                ->where('sku', '=', $sku)
                ->execute('slave');

            if($result)
                $item_id = $result[0]['id'];
            else
                $item_id = 0;
            $cache->set($cache_key, $item_id, 3600);
        }
        return $item_id;
    }











}
