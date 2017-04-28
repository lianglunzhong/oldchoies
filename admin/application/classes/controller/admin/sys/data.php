<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Sys_Data extends Controller_Admin_Sys
{
    public function action_index()
    {
    
    }

    public function action_product()
    {
        // URL: http://admin.local/admin/sys/data/product?action=catalog_id&site_id=1
        
        $action = Arr::get($_GET,'action','none');
        $site_id = Arr::get($_GET,'site_id',0);

        if(intval($site_id) == 0) exit;

        echo 'site ID :'.$site_id.'<br/>';
        echo 'action: '.$action.'<br/>';

        if($action == 'catalog_id' )
        {
            $products = ORM::factory('product')
                ->where('site_id','=',$site_id)
                ->find_all();

            foreach($products as $product)
            {
                echo $product->sku."\t ".$product->catalog_id."<br/>"; 
                $result = DB::select('catalog_id')
                    ->from('catalog_products')
                    ->where('product_id','=',$product->id)
                    ->execute()
                    ->current();
                if($result['catalog_id'])
                {
                    $product->catalog_id = $result['catalog_id'];
                    $product->save();
                }
            }
            
        }
    }
}


