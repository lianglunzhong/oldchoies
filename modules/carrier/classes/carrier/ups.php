<?php
defined('SYSPATH') or die('No direct script access.');

class Carrier_UPS extends Carrier
{
	public function get_price($carrier_param = array())
	{
        $weight = $carrier_param['weight'];                   
        $shipping_address = $carrier_param['shipping_address'];
        $country = $shipping_address['country'];   
                             		 
		$area_key = $this->get_area($country);
        $weight_key = $this->get_weight($weight);
        $price = '';
        
		if($area_key && $weight_key)
		{
			if($weight_key <= 20)
			{				
				$price = $this->_config['price'][$area_key]["$weight_key"];											
			}
			else
			{
				if($weight_key >= 21 && $weight_key <= 44){   
					$price = $this->_config['price'][$area_key]['a'] * $weight_key;
				}else if($weight_key >= 45 && $weight_key <= 70){
					$price = $this->_config['price'][$area_key]['b'] * $weight_key;
				}else if($weight_key >= 71 && $weight_key <= 99){
					$price = $this->_config['price'][$area_key]['c'] * $weight_key;
				}else if($weight_key >= 100 && $weight_key <= 299){
					$price = $this->_config['price'][$area_key]['d'] * $weight_key;
				}else if($weight_key >= 300 && $weight_key <= 499){
					$price = $this->_config['price'][$area_key]['e'] * $weight_key;
				}else if($weight_key >= 500 && $weight_key <= 999){
					$price = $this->_config['price'][$area_key]['f'] * $weight_key;
				}else{
					$price = $this->_config['price'][$area_key]['g'] * $weight_key;
				}			
			}
									
			if($price){
				$price = round($price / 6.4, 2);
				return $price;				
			}else{
				return FALSE;
			}
		}
		else{
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
		if($weight <= 500){ 
			return 0.5;  
		}	
		else if($weight > 500 && $weight <= 20000)
	    {
	    	$remainder = $weight % 500;
	    	$level = intval($weight / 500) / 2;	
	     	return $remainder ? ($level+0.5) : $level;
	    }	        
	    else{
	    	$remainder = $weight % 1000;
	        $level = intval($weight / 1000) ;
	        return $remainder ? ($level+1) : $level;    	    	
	    }
	}

}


