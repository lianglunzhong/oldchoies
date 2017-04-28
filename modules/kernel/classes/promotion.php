<?php

defined('SYSPATH') or die('No direct script access.');

class Promotion
{

        private static $instances;
        public $data;
        private $site_id;

        public static function & instance($id = 0)
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
                {
                        return FALSE;
                }

                //guo add cache
                $cache = Cache::instance('memcache');
                $key = 'promotions_product';
                $data = $cache->get($key);

                try{
                    $data = unserialize($data);
                }catch (Exception $e)
                {
                }
                if( ! $data OR (!empty($data) AND empty($data[0]['filter'])))
                {
                    $promotion = ORM::factory('promotion', $id);
                    if ($promotion->loaded())
                    {
                        $this->data = $promotion->as_array();
                    }

                }
                else
                {
                    $arr = array();
                    foreach($data as $kpromotion=>$vpromotion){
                        if($vpromotion['id'] == $id){
                            $arr = $data[$kpromotion];
                            break;
                        }
                    }
                    
                    if(empty($arr)){
                        $promotion = ORM::factory('promotion', $id);
                        if ($promotion->loaded())
                        {
                            $this->data = $promotion->as_array();
                        }
                    }else{
                            $this->data = $arr; 
                    }
                    
                }

        }

        public function get($key = NULL)
        {
                if (empty($key))
                {
                        return $this->data;
                }
                else
                {
                        return isset($this->data[$key]) ? $this->data[$key] : '';
                }
        }

        public function set($p_data, $promotion_id = NULL)
        {
                $data['name'] = htmlspecialchars(Arr::get($p_data, 'catalog_name', ''));
                $data['brief'] = htmlspecialchars(Arr::get($p_data, 'brief', ''));
                $data['is_active'] = Arr::get($p_data, 'is_active', 1);

                $data['from_date'] = strtotime(Arr::get($p_data, 'from_date', date('d/m/Y')));
                $data['to_date'] = strtotime(Arr::get($p_data, 'to_date', date('d/m/Y')));

                $data['site_id'] = $p_data['site_id'];

                if (isset($p_data['rate']))
                {
                        $data['actions'] = 'rate:' . ($p_data['rate'] == '' ? 100 : $p_data['rate']);
                }
                elseif (isset($p_data['reduce']))
                {
                        $data['actions'] = 'reduce:' . ($p_data['reduce'] == '' ? 0 : $p_data['reduce']);
                }
                elseif (isset($p_data['equal']))
                {
                        $data['actions'] = 'equal:' . ($p_data['equal'] == '' ? 100000 : $p_data['equal']);
                }
                elseif (isset($p_data['points']))
                {
                        $data['actions'] = 'points:' . ($p_data['points'] == '' ? 1 : $p_data['points']);
                }
                else
                {
                        //TODO
                        return 'need_promotion_method';
                }

                $promotion = ORM::factory('promotion', $promotion_id);

                $p_data['condition']['site_id'] = $p_data['site_id'];
                $data['filter'] = filter::set($p_data['condition'], $promotion_id ? $promotion->filter : NULL);
                
                $data['admin'] = Session::instance()->get('user_id');

                $promotion->values($data);
                if ($data['filter'] !== FALSE)
                {
                        $promotion->save();
                        return intval($promotion->id);
                }
                else
                {
                        return 'promotion_data_error';
                }
        }

        public function products()
        {
                return Filter::instance($this->data['filter'])->products();
        }

        public function apply_product($product_id, $price = NULL)
        {

                $product = Product::instance($product_id);

                if (!$product->get('id'))
                {
                        return FALSE;
                }

                if (!$price)
                {
                        $price = $product->get('price');
                }

                if (Filter::instance($this->data['filter'])->check_product($product_id))
                {
                        $original_price = $price;
                        if(isset($this->data['actions']))
                        {
                           $actions = explode(":", $this->data['actions']); 
                        }
                        else
                        {
                            $actions = array();
                        }

                        if (isset($actions[0]) AND $actions[0] == 'equal')
                        {
                                $price = $actions[1];
                        }
                        else if (isset($actions[0]) AND $actions[0] == 'rate')
                        {
                                $price = $price * (int) $actions[1] * 0.01;
                        }
                        else if (isset($actions[0]) AND $actions[0] == 'reduce')
                        {
                                $price = $price - $actions[1];
                        }
                        else if (isset($actions[0]) AND $actions[0] == 'points')
                        {
                                $price = $price;
                        }

                        return $price >= 0 ? $price : $original_price;
                }
                else
                {
                        return FALSE;
                }
        }

        public function apply_cart($cart)
        {
                //if cart is empty, do not apply any promotion rule
                if (!$cart['quantity'])
                {
                        return $cart;
                }

                if (!empty($cart['largess_delete']))
                {
                        $cart = $this->delete_cart_largess($cart);
                }

                $cpromotions = ORM::factory('cpromotion')
                        ->and_where('is_active', '=', 1)
                        ->and_where('from_date', '<=', time())
                        ->and_where('to_date', '>=', time())
                        ->order_by('priority')
                        ->find_all();

                $cart['temp'] = array(
                    'largesses_for_choosing' => array(),
                    'largesses_already_chosen' => empty($cart['largesses']) ? array() : $cart['largesses'],
                    'largesses_should_be' => array(),
                    'promotion_logs_should_be' => array()
                );

                foreach ($cpromotions as $cpromo)
                {
                        //红人过滤
                        if ($cpromo->celebrity_avoid)
                        {
                                $customer_id = Customer::logged_in();
                                if($customer_id AND Customer::instance($customer_id)->is_celebrity())
                                        return FALSE;
                        }
                        
                        $cond = explode(':', $cpromo->conditions);

                        if ($condition_instance = Toolkit::get_instance('Promotion_Condition_' . $cond[0]) AND $condition_instance->check($cart, $cpromo->id))
                        {
                                if (isset($cond[1]) AND $cond[1] == '' AND $cpromo->brief == 'special')
                                {
                                        $action_instance = Toolkit::get_instance('Promotion_Action_Special');
                                        if (!($cart = $action_instance->apply($cart, $cpromo->id)))
                                        {
                                                return FALSE;
                                        }
                                }
                                else
                                {
                                        $actions = unserialize($cpromo->actions);
                                        if ($action_instance = Toolkit::get_instance('Promotion_Action_' . $actions['action']))
                                        {
                                                if (!($cart = $action_instance->apply($cart, $cpromo->id)))
                                                {
                                                        return FALSE;
                                                }
                                        }
                                }
                        }
                        if ($cpromo->stop_further_rules OR isset($action_instance))
                        {
                                break;
                        }
                }

                if (!empty($cart['largess_add']))
                {
                        unset($cart['largess_add']);
                }

                $cart['largesses'] = $cart['temp']['largesses_should_be'];
                $cart['largesses_for_choosing'] = $cart['temp']['largesses_for_choosing'];
                $cart['promotion_logs']['cart'] = $cart['temp']['promotion_logs_should_be'];

                unset($cart['temp']);

                return $cart;
        }

        private function delete_cart_largess($cart)
        {
                if (!empty($cart['largesses'][$cart['largess_delete']]))
                {
                        unset($cart['largesses'][$cart['largess_delete']]);
                }
                if (!empty($cart['promotion_logs']['cart']))
                {
                        foreach ($cart['promotion_logs']['cart'] as $promotion_id => $log)
                        {
                                if (!empty($log['largesses']) AND !empty($log['largesses'][$cart['largess_delete']]))
                                {
                                        unset($cart['promotion_logs']['cart'][$promotion_id]['largesses'][$cart['largess_delete']]);
                                        if (empty($cart['promotion_logs']['cart'][$promotion_id]['largesses']))
                                        {
                                                unset($cart['promotion_logs']['cart'][$promotion_id]);
                                        }
                                }
                        }
                }
                unset($cart['largess_delete']);
                return $cart;
        }

}
