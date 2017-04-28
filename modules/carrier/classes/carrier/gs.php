<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Carrier Ems
 * @category	Carrier
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Carrier_Gs extends Carrier
{
	public function get_price($carrier_param = array())
	{
        $weight = $carrier_param['weight'];
        $shipping_address = $carrier_param['shipping_address'];
		$country = $shipping_address['country'];
        $carriers = $this->_config['country'];
        $price = '';
        foreach($carriers as $carrier)
        {
            if($carrier['iscode'] == $country)
            {
                $price = $carrier['shipping_fee'];
                return $price;
            }
        }
        if(!$price)
            return false;
	}

}
