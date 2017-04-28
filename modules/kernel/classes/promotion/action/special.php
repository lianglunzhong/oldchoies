<?php

defined('SYSPATH') or die('No direct script access.');

class Promotion_Action_Special
{

        public function apply($cart, $promotion_id)
        {
                $cpromo = ORM::factory('cpromotion', $promotion_id);
                $save = 0;
                $rate = floor($cart['amount']['items'] / 100);
                switch ($rate)
                {
                        case 0 :
                                $next = '$20 OFF OVER $100';
                                break;
                        case 1 :
                                $save = 20;
                                $log = '$20 OFF OVER $100';
                                $next = '$50 OFF OVER $200';
                                break;
                        case 2 :
                                $save = 50;
                                $log = '$50 OFF OVER $200';
                                $next = '$100 OFF OVER $300';
                                break;
                        default :
                                $rate1 = floor(($cart['amount']['total'] / 300));
                                $save = $rate1 * 100;
                                $total = $rate1 * 300;
                                $log = '$' . $save . ' OFF OVER $' . $total;
                                $next = '$' . ($rate1 + 1) * 100 . ' OFF OVER $' . ($rate1 + 1) * 300;
                                break;
                }
                if($rate)
                {
                        Session::instance()->set('no_coupon', 1);
                        Session::instance()->delete('cart_coupon');
                }
                $cart_total = $cart['amount']['total'] - $save;
                $cart['amount']['save'] += $save;
                $cart['amount']['total'] = $cart_total;
                $cart['temp']['promotion_logs_should_be'][$cpromo->id] = array(
                    'id'     => $cpromo->id,
                    'method' => 'rate',
                    'save'   => $save,
                    'value'  => $save,
                    'log'    => $log,
                    'next'   => $next
                );
                return $cart;
        }

}
