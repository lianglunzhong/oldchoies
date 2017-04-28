<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Carrier Default
 * @category	Carrier
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Carrier_Default extends Carrier
{

        public function get_price($carrier_param = array( ))
        {
                $weight = $carrier_param['weight'];
                $shipping_address = $carrier_param['shipping_address'];
                $interval = unserialize($this->_carrier['interval']);
                foreach( $interval as $key => $value )
                {
                        $interval_now = explode('-', $key);
                        if($interval_now[1] == 'N')
                        {
                                if($weight >= $interval_now[0])
                                {
                                        $price = $value;
                                        break;
                                }
                        }
                        else
                        {
                                if($weight >= $interval_now[0] && $weight < $interval_now[1])
                                {
                                        $price = $value;
                                        break;
                                }
                        }
                }

                return isset($price) ? $price : FALSE;
        }

}
