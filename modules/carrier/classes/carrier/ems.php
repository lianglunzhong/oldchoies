<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Carrier Ems
 * @category	Carrier
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Carrier_Ems extends Carrier
{

        public function get_price($carrier_param = array( ))
        {
                $weight = $carrier_param['weight'];
                $shipping_address = $carrier_param['shipping_address'];
                $country = $shipping_address['country'];
                $area_key = $this->get_area($country);
                $weight_key = $this->get_weight($weight);
                if($area_key && $weight_key)
                {
                        $first_price = $this->_config['price'][$area_key][1];
                        $additional_price = $this->_config['price'][$area_key][2] * ($weight_key - 1);
                        $price = $first_price + $additional_price;
                        if($price)
                        {
                                $price = round($price * 0.42, 2) + 1.5;
                                return $price;
                        }
                        else
                        {
                                return FALSE;
                        }
                }
                else
                {
                        return FALSE;
                }
        }

        public function get_area($country)
        {
                if( ! $this->_config['area']) return FALSE;
                foreach( $this->_config['area'] as $key => $area )
                {
                        if(in_array($country, $area)) return $key;
                }

                return FALSE;
        }

        public function get_weight($weight)
        {
                if($weight > 500)
                {
                        $remainder = $weight % 500;
                        $level = intval($weight / 500);

                        return $remainder ? ($level + 1) : $level;
                }
                else
                {
                        return 1;
                }
        }

}
