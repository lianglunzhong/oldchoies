<?php

defined('SYSPATH') or die('No direct script access.');

class Promotion_Condition_Whatever
{

    public function check($cart, $promotion_id)
    {
        $cpromo = ORM::factory('cpromotion', $promotion_id);

        //start 分类/产品限制
        $restrictions = unserialize($cpromo->restrictions);
        if (isset($restrictions['restrict_catalog']))
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
            foreach ($cart['products'] as $product)
            {
                $has = DB::query(Database::SELECT, 'SELECT id FROM products_categoryproduct WHERE product_id = ' . $product['id'] . ' AND category_id IN (' . $catalogs_in . ')')->execute()->get('id');
                if ($has)
                {
                    $catalog_amount = 1;
                    break;
                }
            }
            if ($catalog_amount)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        elseif (isset($restrictions['restrict_product']))
        {
            $product_amount = 0;
            $products = explode(',', $restrictions['restrict_product']);
            foreach ($cart['products'] as $product)
            {
                $product_sku = Product::instance($product['id'])->get('sku');
                if (in_array($product_sku, $products))
                {
                    $product_amount = 1;
                    break;
                }
            }
            if ($product_amount)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        //end 分类/产品限制

        return TRUE;
    }

}
