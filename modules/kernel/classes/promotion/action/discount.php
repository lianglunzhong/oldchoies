<?php defined('SYSPATH') or die('No direct script access.');

class Promotion_Action_Discount
{
    public function apply($cart,$promotion_id)
    {
        $cpromo = ORM::factory('cpromotion',$promotion_id);
        $actions = unserialize($cpromo->actions);

        $restrictions  = unserialize($cpromo->restrictions);
        if($details = explode(':',$actions['details']))
        {
            if($details[0] == 'rate')
            {
                //分类/产品限制
                $other_amount = 0;
                $saving = $cart['amount']['coupon_save'] + $cart['amount']['point'];
                if(isset($restrictions['restrict_catalog']))
                {
                        $rate_amount = 0;
                        $catalogs = explode(',', $restrictions['restrict_catalog']);
                        $catalogs_in = '0';
                        foreach ($catalogs as $c)
                        {
                            $posterity_ids = array();
                            $posterity_ids = Catalog::instance($c)->posterity();
                            $posterity_ids[] = $c;
                            $catalogs_in = $catalogs_in . ',' . implode(',', $posterity_ids);
                        }
                        foreach($cart['products'] as $product)
                        {
                                $has = DB::query(Database::SELECT, 'SELECT id FROM products_categoryproduct WHERE product_id = ' . $product['id'] . ' AND category_id IN (' . $catalogs_in . ')')->execute()->get('id');
                                if($has)
                                {
                                        $rate_amount += $product['price'] * $product['quantity'];
                                }
                                else
                                {
                                        $other_amount += $product['price'] * $product['quantity'];
                                }
                        }
                        $cart_total = round($rate_amount * $details[1] / 100, 2) + $other_amount - $saving;
                }
                elseif(isset($restrictions['restrict_product']))
                {
                        $rate_amount = 0;
                        $products = explode(',', $restrictions['restrict_product']);
                        foreach($cart['products'] as $product)
                        {
                                $product_sku = Product::instance($product['id'])->get('sku');
                                if(in_array($product_sku, $products))
                                {
                                        $rate_amount += $product['price'] * $product['quantity'];
                                }
                                else
                                {
                                        $other_amount += $product['price'] * $product['quantity'];
                                }
                        }
                        $cart_total = round($rate_amount * $details[1] / 100, 2) + $other_amount - $saving;
                }
                else
                {
                        $cart_total = round($cart['amount']['items'] * $details[1] / 100, 2) - $saving;
                }
                if($cart_total >= 0)
                {
                    $cart['amount']['save'] += $cart['amount']['total'] - $cart_total;
                    $cart['temp']['promotion_logs_should_be'][$cpromo->id] = array(
                        'id' => $cpromo->id,
                        'method' => 'rate',
                        'save' => $cart['amount']['items'] - $cart_total,
                        'value' => $details[1].'%',
                        'log' => $cpromo->name.': '.(100 - $details[1]).'% off',
                        'restrictions' => $cpromo->restrictions
                    );
                    $cart['amount']['total'] = $cart_total + $cart['amount']['shipping'];
                }
            }
            elseif($details[0] == 'reduce')
            {
                $cart_total  = $cart['amount']['total'] - $details[1];
                if($details[1] > 0 AND $cart_total >= 0)
                {
                    $cart['amount']['save'] += $details[1];
                    $cart['amount']['total'] = $cart_total;
                    $cart['temp']['promotion_logs_should_be'][$cpromo->id] = array(
                        'id' => $cpromo->id,
                        'method' => 'rate',
                        'save' => $details[1],
                        'value' => $details[1],
                        'log' => $cpromo->name.': '.Site::instance()->price($details[1], 'code_view').' off'
                    );
                }
            }
        }
        return $cart;
    }
}
