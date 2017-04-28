<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Manage
 * @category	Liabrary
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
class Manage
{

    public static function add_product_update_log($product_id, $user_id, $action)
    {
        $data = array(
            'product_id' => $product_id,
            'user_id' => $user_id,
            'action' => $action,
            'created' => time(),
            'updated' => time()
        );

        $product_update_log = ORM::factory('manage_product_update_log');
        $product_update_log->values($data);
        $product_update_log->save();
    }

    public static function add_product_update_top_log($product_id, $catalog_id,$user_id, $action)
    {
        $data = array(
            'product_id' => $product_id,
            'catalog_id' => $catalog_id,
            'user_id' => $user_id,
            'action' => $action,
            'created' => time(),
            'updated' => time()
        );

        $product_update_log = ORM::factory('manage_product_update_top_log');
        $product_update_log->values($data);
        $product_update_log->save();
    }


}
