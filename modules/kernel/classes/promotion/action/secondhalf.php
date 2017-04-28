<?php

defined('SYSPATH') or die('No direct script access.');

class Promotion_Action_Secondhalf
{

    public function apply($cart, $promotion_id)
    {
        $cpromo = ORM::factory('cpromotion', $promotion_id);
        $restrictions = unserialize($cpromo->restrictions);
        $catalogs = explode(',', $restrictions['restrict_catalog']);
        $catalog_products = array();
        $prices = array();
        $catalog_amount = 0;
        $save = 0;
        $next = '';
        foreach ($cart['products'] as $product)
        {
            $has = DB::select('id')->from('products_categoryproduct')
                    ->where('product_id', '=', $product['id'])
                    ->and_where('category_id', 'IN', $catalogs)
                    ->execute()->get('id');
            if ($has)
            {
                $catalog_amount += $product['quantity'];
                $catalog_products[] = $product;
                $prices[] = $product['price'];
            }
        }
        array_multisort($prices, SORT_ASC, $catalog_products);
        $times = floor($catalog_amount / 2);
        foreach ($catalog_products as $val)
        {
            if ($times >= $val['quantity'])
            {
                $save += round(($val['price'] / 2) * $val['quantity'], 2);
                $times -= $val['quantity'];
            }
            else
            {
                $save += round(($val['price'] / 2) * $times, 2);
                $times = 0;
            }
            if ($times == 0)
                break;
        }
//                echo $save;exit;
        $cart_total = $cart['amount']['total'] - $save;
        $cart['amount']['save'] += $save;
        $cart['amount']['total'] = $cart_total;
        $cart['temp']['promotion_logs_should_be'][$cpromo->id] = array(
            'id' => $cpromo->id,
            'method' => 'rate',
            'save' => $save,
            'value' => $save,
            'log' => $cpromo->name,
            'next' => $catalog_amount % 2 == 1 ? $cpromo->brief : ''
        );
        return $cart;
    }

}
