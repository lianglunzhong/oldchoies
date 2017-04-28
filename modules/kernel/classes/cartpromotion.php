<?php
defined('SYSPATH') or die('No direct script access.');

class Cartpromotion
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
        $this->_load($id);
    }

    public function _load($id)
    {
        if (!$id)
        {
            return FALSE;
        }
        $promotion = ORM::factory('cpromotion', $id);
        if ($promotion->loaded())
        {
            $this->data = $promotion->as_array();
        }
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

    public function set($c_data, $cpromotion_id = NULL)
    {
        $data['site_id'] = Arr::get($c_data, 'site_id', 0);
        $data['name'] = Arr::get($c_data, 'name', '');
        $data['brief'] = Arr::get($c_data, 'brief', '');
        $data['from_date'] = strtotime(Arr::get($c_data, 'from_date', date('d/m/Y')));
        $data['to_date'] = strtotime(Arr::get($c_data, 'to_date', date('d/m/Y', strtotime('+1 month'))));
        $data['priority'] = Arr::get($c_data,'priority',0);
        $data['stop_further_rules'] = Arr::get($c_data,'stop_further_rules',0);
        $data['celebrity_avoid'] = Arr::get($c_data,'celebrity_avoid',0);
        
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        foreach($languages as $l)
        {
            $data[$l] = Arr::get($c_data, $l, 0);
        }
        
        //start 分类/产品限制
        $is_restrict = Arr::get($c_data, 'is_restrict', 0);
        if($is_restrict)
        {
                $restrictArr = array();
                $restrictions = Arr::get($c_data, 'restrictions', '');
                if($restrictions == 'restrict_catalog')
                {
                        $restrict = Arr::get($c_data, 'restrict_catalog', '');
                        if($restrict)
                        $restrictArr[$restrictions] = $restrict;
                }
                elseif($restrictions == 'restrict_product')
                {
                        $restrict = Arr::get($c_data, 'restrict_product', '');
                        if($restrict)
                        $restrictArr[$restrictions] = $restrict;
                }
        
                if(!empty($restrictArr))
                        $data['restrictions'] = serialize($restrictArr);
        }
        //end 分类/产品限制

        switch( $c_data['conditions'] )
        {
        case 'whatever':
            $data['conditions'] = 'whatever';
            break;
        case 'sum':
            $data['conditions'] = 'sum:'.(Arr::get($c_data, 'sum', 0));
            break;
        case 'quantity':
            $data['conditions'] = 'quantity:'.(Arr::get($c_data, 'quantity', 1));
            break;
        default:
            $message = '操作失败：请指定一个促销条件！';
            return $message;
        }

        $promotion_method = Arr::get($c_data, 'promotion_method', '');
        switch( $promotion_method )
        {
        case 'discount':
            $data['actions']['action'] = 'discount';
            if(isset($c_data['rate']))
            {
                $data['actions']['details'] = 'rate:'.($c_data['rate'] == '' ? 100 : $c_data['rate']);
            }
            elseif(isset($c_data['reduce']))
            {
                $data['actions']['details'] = 'reduce:'.($c_data['reduce'] == '' ? 0 : $c_data['reduce']);
            }
            else
            {
                $message = '操作失败，请提供一种打折方式。';
                return $message;
            }
            $data['actions'] = serialize($data['actions']);
            break;

        case 'largess':
            $data['actions']['action'] = 'largess';
            $data['actions']['details']['max_sum_quantity'] = Arr::get($c_data, 'largess_sum_quantity', 1);
            foreach( $c_data['largess']['SKU'] as $key => $sku )
            {
                $product = ORM::factory('product')
                    ->and_where('SKU','=',$sku)
                    ->find();
                if($product->loaded())
                {
                    $data['actions']['details']['largesses'][] = array(
                        'SKU' => $sku,
                        'id' => $product->id,
                        'price' => $c_data['largess']['price'][$key],
                        'max_quantity' => $c_data['largess']['quantity'][$key]
                    );
                }
                else
                {
                    return '请检查赠品的SKU确保正确';
                }
            }
            $data['actions'] = serialize($data['actions']);
            break;

        case 'freeshipping':
            $data['actions']['action'] = 'freeshipping';
            $data['actions'] = serialize($data['actions']);
            break;
        case 'secondhalf':
            $data['actions']['action'] = 'secondhalf';
            $data['actions'] = serialize($data['actions']);
            break;
        case 'bundle':
            $data['actions']['action'] = 'bundle';
            $ishave = 0;
            if(isset($c_data['bundleprice']))
            {
                $data['actions']['bundleprice'] = 'amt:'.($c_data['bundleprice'] == '' ? 0 : $c_data['bundleprice']);
                $ishave = 1;
            }
            if(isset($c_data['bundlenum']))
            {
                $data['actions']['bundlenum'] = 'sum:'.($c_data['bundlenum'] == '' ? 0 : $c_data['bundlenum']);
                $ishave = 1;
            }

            if(!$ishave)
            {
                $message = '操作失败，请提供一种打折方式。';
                return $message;           
            }
            $data['actions'] = serialize($data['actions']);
            break;
        default:
            $message = '操作失败，请提供至少一种促销方式。';
            return $message;
        }

        $data['admin'] = Arr::get($c_data, 'admin', '');
        $cart_promotion = ORM::factory('cpromotion', $cpromotion_id);
        $cart_promotion->values($data);
        if($cart_promotion->check())
        {
            $cart_promotion->save();
            return intval($cart_promotion->id);
        }
        else
        {
            $message = '操作失败，请检查你填写的数据是否完整。';
            return $message;
        }
    }

    public function price($cart_price)
    {
        $price = $cart_price;
        return $price;
    }

}

