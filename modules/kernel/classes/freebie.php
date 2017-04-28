<?php

defined('SYSPATH') or die('No direct script access.');

class Freebie
{

        private static $instances;
        private $data;

        public static function &instance($id = 0)
        {
                if (!isset(self::$instances[$id]))
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
                if (!$id)
                        return FALSE;

                $freebies = ORM::factory('freebie', $id);
                $data = array();
                if ($freebies->loaded())
                {
                        $data = $freebies->as_array();
                }
                $this->data = $data;
        }

        public function set($data)
        {
                $freebie = ORM::factory('freebie');
                $freebie->email = $data['email'];
                $freebie->sku = $data['sku'];
                $freebie->product_id = $data['product_id'];
                $freebie->date_time = $data['date_time'];
                $freebie->ip = $data['ip'];
                try
                {
                        $freebie->save();
                        return intval($freebie->id);
                }
                catch (Exception $e)
                {
                        return FALSE;
                }
        }

        public function get_amont_byid()
        {
                $freebies = DB::query(1, "SELECT id FROM freebies order by id desc limit 1")->execute()->current();
//        echo kohana::debug($freebies['id']);exit;
                $amount = $freebies['id'] * 2;
                return $amount;
        }

        /**
         * 得到当前用户的SKU的数量 
         */
        public static function get_amont_bysku($sku = NULL, $id = 9999999, $now = NULL)
        {
                if ($now == NULL)
                        $now = date('Y-m-d');
                $freebies = DB::query(1, "SELECT count(id) as amount FROM freebies where sku = '$sku' and id <=  $id and date_time = '$now'")->execute()->current();
                return $freebies['amount'];
        }

        //检测email是否存在
        public static function check_email($email, $sku, $range = 999, $date = NULL)
        {
                $tag = true;
                if ($date == NULL)
                {
                        $str = date('Y-m-d');
                        $freebies = DB::query(1, "SELECT (id) FROM freebies where sku = '$sku' and email = '$email' and date_time = '$str'")->execute()->current();
                        if (!empty($freebies['id']))
                                $amount = self::get_amont_bysku($sku, $freebies['id'], $str);
                        
                        if ($amount > 0 && $amount < $range)
                        {
                                $tag = false;
                        }
                }
                else
                {
                        foreach ($date as $times)
                        {
                                $freebies = DB::query(1, "SELECT (id) FROM freebies where sku = '$sku' and email = '$email' and date_time = '$times'")->execute()->current();
                                if (!empty($freebies['id']))
                                {
//                                        if ($str == date('Y-m-d'))
//                                        {
//                                                $tag = false;
//                                                break;
//                                        }
//                                        else
//                                        {
//                                                $amount = self::get_amont_bysku($sku, $freebies['id'], $str);
//                                                if ($amount > 0 && $amount < $range)
//                                                {
//                                                        $tag = false;
//                                                        break;
//                                                }
//                                        }
                                        $tag = false;
                                        break;
                                }
                        }
                }

                return $tag;
        }

}