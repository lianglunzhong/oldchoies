<?php defined('SYSPATH') or die('No direct script access.');

class Promotion_Action_Freeshipping
{
    public function apply($cart,$promotion_id)
    {
        if($cart['amount']['shipping'] > 0)
        {
            $att = $cart['shipping_address']['shipping_country'];
            if(in_array($att,array('US','TW','HK')))
            {
                $cpromo = ORM::factory('cpromotion',$promotion_id);
                $cart['amount']['total'] -= $cart['amount']['shipping'];
                $cart['temp']['promotion_logs_should_be'][$cpromo->id] = array(
                    'id' => $cpromo->id,
                    'method' => 'freeshipping',
                    'save' => $cart['amount']['shipping'],
                    'log' => $cpromo->name.': Free Shipping'
                );
                $cart['amount']['shipping'] = 0;                
            }
        }
        return $cart;
    }
}
