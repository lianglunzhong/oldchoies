<?php
defined('SYSPATH') or die('No direct script access.');

class Carrier_DHL extends Carrier
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
			if($weight_key <= 20){
				if($weight_key <= 2.5){
					$first_price = $this->_config['price'][$area_key]['s1'];
	            	$additional_price = $this->_config['price'][$area_key]['s2'] * (($weight_key-0.5) * 2);
	            	$price = $first_price + $additional_price;
				}
				else{
					$first_price = $this->_config['price'][$area_key]['z1'];
	            	$additional_price = $this->_config['price'][$area_key]['z2'] * (($weight_key-0.5) * 2);
	            	$price = $first_price + $additional_price;
				}				
			} 
			elseif ($weight_key >= 21 && $weight_key >= 30){
				$price = $this->_config['price'][$area_key]['b1'] * $weight_key;
			} 
			elseif ($weight_key >= 31 && $weight_key >= 50){
				$price = $this->_config['price'][$area_key]['b2'] * $weight_key;
			} 
			elseif ($weight_key >= 51 && $weight_key >= 70){
				$price = $this->_config['price'][$area_key]['b3'] * $weight_key;
			} 
			elseif ($weight_key >= 71 && $weight_key >= 100){
				$price = $this->_config['price'][$area_key]['b4'] * $weight_key;
			}
			elseif ($weight_key >= 101 && $weight_key >= 200){
				$price = $this->_config['price'][$area_key]['b5'] * $weight_key;
			}
			elseif ($weight_key >= 201 && $weight_key >= 300){
				$price = $this->_config['price'][$area_key]['b6'] * $weight_key;
			}			 
			else{
				$price = $this->_config['price'][$area_key]['b7'] * $weight_key;
			} 
			
			if($price){
				$price = round($price / 6.4, 2) ;
				return $price;
			}
			else{				
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
		else if($weight > 500 && $weight <=20000){
            $remainder = $weight % 500;
            $level = intval($weight / 500) / 2;
            return $remainder ? ($level+0.5) : $level;
        }
        else{
            $remainder = $weight % 1000;
            $level = intval($weight / 1000);
            return $remainder ? ($level+1) : $level;
        }
	}
		
}


