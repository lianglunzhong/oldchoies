<?php defined('SYSPATH') or die('No direct script access.');

class Promotion_Condition_Sum
{
    public function check($cart,$promotion_id)
    {
        $cpromo = ORM::factory('cpromotion',$promotion_id);
        $cond = explode(':',$cpromo->conditions);
        
        //start 分类/产品限制
        $restrictions  = unserialize($cpromo->restrictions);
        if(isset($restrictions['restrict_catalog']) AND isset($cond[1]))
        {
                $catalog_amount = 0;
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
                        $has = DB::query(Database::SELECT, 'SELECT id FROM products_categoryproduct WHERE deleted = 0 and product_id = ' . $product['id'] . ' AND category_id IN (' . $catalogs_in . ')')->execute()->get('id');
                        if ($has)
                        {
                                $catalog_amount += $product['price'] * $product['quantity'];
                        }
                }
                if($catalog_amount >= $cond[1])
                {
                        return TRUE;
                }
                else
                {
                        return FALSE;
                }
        }
        elseif(isset($restrictions['restrict_product']) AND isset($cond[1]))
        {
                $product_amount = 0;
                $products = explode(',', $restrictions['restrict_product']);
                foreach($cart['products'] as $product)
                {
                        $product_sku = Product::instance($product['id'])->get('sku');
                        if(in_array($product_sku, $products))
                        {
                                $product_amount += $product['price'] * $product['quantity'];
                        }
                }
                if($product_amount >= $cond[1])
                {
                        return TRUE;
                }
                else
                {
                        return FALSE;
                }
        }
        //end 分类/产品限制
        
        if(isset($cond[1]) AND $cart['amount']['total'] >= $cond[1])
        {
            return TRUE;
        }
        return FALSE;
    }
}
