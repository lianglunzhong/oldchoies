<?php
defined('SYSPATH') or die('No direct script access.');

class Carrier_Sf extends Carrier
{

	public function get_price($carrier_param = array())
	{
        $weight = $carrier_param['weight'];
        $shipping_address = $carrier_param['shipping_address'];
        $country = $shipping_address['country'];
              
        if($country == 'HK' || $country == 'TW')
        {
        	if($weight <= 1000)
        	{ 
        			$price = 5;
        			return $price;
        	}
        	else{
        		$remainder = $weight % 1000;
	    		$level = intval($weight / 1000);	
	     		$num = $remainder ? ($level+1) : $level;
	     		
	     		$price = ($num-1)+5;
	     		return $price;
        	}
        			 
        }
        else 
        {
        	return false;
        }
		
		
	}

}
