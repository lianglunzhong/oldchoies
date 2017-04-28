<?php
defined('SYSPATH') or die('No direct script access.');

class Superdeal
{
	private static $instances;
    private $data;
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
        $this->data = NULL;
        //$this->_load($id);
    }

	public function getStock($id) {
        $arr = file($_SERVER['COFREE_DATA_DIR'].'/sd.txt');
        foreach ($arr as $v) {
            if (preg_match('/' . $id . '/', $v)) {
                $pro = unserialize($v);
                break;
            }
        }
		return $pro['stock'];
    }

	public function reduceStock($id,$quantity) {
        $arr = file($_SERVER['COFREE_DATA_DIR'].'/sd.txt');
        foreach ($arr as $k => $v) {
            if (preg_match('/' . $id . '/', $v)) {
                $pro = unserialize($v);
                $pro['stock'] = $pro['stock'] - $quantity;
                $arr[$k] = serialize($pro)."\n";
            }
        }
        file_put_contents($_SERVER['COFREE_DATA_DIR'].'/sd.txt', join('', $arr), LOCK_EX);
    }
}