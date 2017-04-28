<?php
defined('SYSPATH') or die('No direct script access.');

class Tag
{

    protected static $instances;
    protected static $instances1;
    protected $data;
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
        $result = DB::select()->from('products_tags' . $this->lang_table)
                ->where('id', '=', $id)
                ->execute()->current();

            $data = $result;

        $this->data = $data;
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

            $cache->set($key, $result, 7200);
        }

        $data = $result;

        return $data;
    }


}
