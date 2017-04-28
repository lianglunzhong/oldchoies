<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Addmoney extends Controller_Admin_Site
{

    public function action_export()
    {
        
    }

    public function action_optionfly()
    {
        $file = fopen('http://www.boncyboutique.com/images/size.csv', 'r');
        if ($file)
        {
            echo "读取到文件";
        }
        $count = 0;
        $a = 0;
        while ($data = fgetcsv($file))
        {    //每次读取CSV里面的一行内容   
            $a++;
            echo $a . '<br/>';
            $count++;
            if ($count == 1)
            {
                continue;
            }
            echo kohana::debug($data);
            $data[2] = iconv('GBK', 'UTF-8', $data[2]);
            $option = Option::instance($data[0]);
            $update = DB::update('options')
                ->set(array('keywords' => $data[2]))
                ->where('id', '=', $data[0])
                ->execute();
            if ($update)
            {
                echo '更新成功';
            }
            else
            {
                echo '更新失败';
            }
            foreach ($option as $k)
            {
                echo $k . '<br/>';
            }
            echo kohana::debug($option);
        }
        fclose($file);
    }

    public function action_status()
    {
        $product = DB::update('products')
            ->set(array('status' => '0'))
            ->where('site_id', '=', '4')
            ->where('sku', '=', 'WDSSD0028')
            ->execute();
        echo kohana::debug($product);
        exit;
    }

    public function action_option()
    {
        $file = fopen('F:/size.csv', 'r');
        $count = 0;
        while ($data = fgetcsv($file))
        {    //每次读取CSV里面的一行内容   
            $count++;
            if ($count == 1)
            {
                continue;
            }
//		   print_r($data);
            //此为一个数组，要获得每一个数据，访问数组下标即可
            $goods_list[] = $data;
        }
//		print_r($goods_list);
        fclose($file);
    }

    public function action_edit()
    {
        $option_id = array('1070', '1071', '1072', '1073', '1074', '1075');
        $product_sku = array('WDS010083', 'WDS010258', 'WDS010265', 'WDS010267', 'WDS010023', 'WDS010260', 'WDS010030', 'WDS010033', 'WDS010043', 'WDS010046'
            , 'WDS010057', 'WDS010068', 'WDS010069', 'WDS010078', 'WDS010081', 'WDS010087', 'WDS010088', 'WDS010090', 'WDS010095', 'WDS010096'
            , 'WDS010099', 'WDS010100', 'WDS010101', 'WDS010102', 'WDS010103', 'WDS010104', 'WDS010112', 'WDS010118', 'WDS010126', 'WDS010128'
            , 'WDS010133', 'WDS010144', 'WDS010151', 'WDS010152', 'WDS010157', 'WDS010165', 'WDS010178', 'WDS010184', 'WDS010199', 'WDS010201'
            , 'WDS010205', 'WDS010208', 'WDS010209', 'WDS010216', 'WDS010272', 'WDS010278', 'WDS010287', 'WDS010299', 'WDS010393', 'WDS010388'
            , 'WDS010383', 'WDS010382', 'WDS010365', 'WDS010359', 'WDS010358', 'WDS010315', 'WDS010314', 'WDS010354', 'WDS010353', 'WDS010352'
            , 'WDS010330', 'WDS010327', 'WDS010321', 'WDS010318', 'WDS010316', 'WDS010309', 'WDS010413', 'WDS010418', 'WDS010425', 'WDS010432'
            , 'WDS010435', 'WDS010445', 'WDS010333', 'WDS010547', 'WDS010548', 'WDS010549', 'WDS010550', 'WDS010551', 'WDS010552', 'WDS010553'
            , 'WDS010554', 'WDS010555', 'WDS010556', 'WDS010557', 'WDS010558', 'WDS010559', 'WDS010560', 'WDS010561', 'WDS010562', 'WDS010563'
            , 'WDS010564', 'WDS030104', 'WDS030105', 'WDS030106', 'WDS030107', 'WDS030108', 'WDS030109', 'WDS030110', 'WDS030111', 'WDS030112'
            , 'WDS030113', 'WDS030114', 'WDS030115', 'WDS030116', 'WDS030117', 'WDS030118', 'WDS030119', 'WDS030120', 'WDS030121', 'WDS030122'
            , 'WDS030123', 'WDS030124', 'WDS030125', 'WDS030126', 'WDS030127', 'WDS030128', 'WDS030129', 'WDS030130', 'WDS030131', 'WDS030132'
            , 'WDS030133', 'WDS030134', 'WDS030135', 'WDS030136', 'WDS030137', 'WDS030138', 'WDS030139', 'WDS030140', 'WDS030141', 'WDS030071'
            , 'WDS030061', 'WDS030060', 'WDS030059', 'WDS030056', 'WDS030055', 'WDS030043', 'WDS030036', 'WDS030032', 'WDS030028', 'WDS030025'
            , 'WDS030002', 'WDS020396', 'WDS020462', 'WDS020458', 'WDS020457', 'WDS020455', 'WDS020454', 'WDS020450', 'WDS020447', 'WDS020443'
            , 'WDS020439', 'WDS020432', 'WDS020431', 'WDS020429', 'WDS020428', 'WDS020427', 'WDS020417', 'WDS020414', 'WDS020395', 'WDS020407'
            , 'WDS020404', 'WDS020402', 'WDS020401', 'WDS020392', 'WDS020321', 'WDS020301', 'WDS020369', 'WDS020352', 'WDS020377', 'WDS020040'
            , 'WDS020020', 'WDS020018', 'WDS020019', 'WDS020474', 'WDS020475', 'WDS020476', 'WDS020477', 'WDS020478', 'WDS020479', 'WDS020480'
            , 'WDS020481', 'WDS020482', 'WDS020483', 'WDS020465', 'WDS020466', 'WDS020467', 'WDS020468', 'WDS020469', 'WDS020470', 'WDS020471'
            , 'WDS020472', 'WDS020473', 'WDS020464', 'WDS020081', 'WDS020342', 'WDS020072', 'WDS020067', 'WDS020060', 'WDS020056', 'WDS020054'
            , 'WDS020052', 'WDS050034', 'WDS050032', 'WDS050030', 'WDS050028', 'WDS050014', 'WDS050006', 'WDS020077');
        $count = 0;
        $false = 0;
        foreach ($product_sku as $key => $sku)
        {
            $item = array();
            $pro_id = Product::get_productId_by_sku($sku);
            if ($pro_id)
            {
                $pro_price = DB::select('price')
                    ->from('products_product')
                    ->where('id', '=', $pro_id)
                    ->where('site_id', '=', '4')
                    ->execute('slave')
                    ->current();
                $pro_price = $pro_price['price'];
//                 echo kohana::debug($pro_price);
                $item = DB::query(Database::SELECT, 'select id from products where site_id=4 and sku like "' . $sku . '_%" ')->execute('slave')->as_array();
                foreach ($item as $simple)
                {
                    $options = DB::query(Database::SELECT, 'select option_id from product_options where product_id = ' . $simple['id'])->execute('slave')->as_array();

                    $o_id_all = array();
                    foreach ($options as $key => $o_id)
                    {
                        $o_id_all[$key] = $o_id['option_id'];
                    }
//                      echo kohana::debug(array_intersect($option_id,$o_id_all));
                    if (array_intersect($option_id, $o_id_all))
                    {
//                              $price = DB::query(Database::SELECT,'select price from products where id = '.$simple['id'])->execute()->as_array();

                        $price = $pro_price + 9.99;
//                              echo kohana::debug($price); exit;
                        $updated = DB::update('products')
                            ->set(array('price' => $price))
                            ->where('id', '=', $simple['id'])
                            ->and_where('site_id', '=', '4')
                            ->execute();
                        if ($updated)
                        {
                            $count++;
                        }
                        else
                        {
                            echo $sku . '<br/>';
                            $false++;
                        }
                    }
                    else
                    {
                        continue;
                    }
                }
            }
            else
            {
                continue;
            }
        }
        echo '成功：' . $count . '<br/> 失败：' . $false;
    }

    public function action_link1()
    {
//        $select = DB::query(Database::SELECT,'select id, link from catalogs where site_id=4 and link = "dresses-under-100/wedding-dresses-under-100" ')->execute()->as_array();
//        echo kohana::debug($select); exit;
        $updated = DB::update('catalogs')
            ->set(array('link' => 'dresses-under-100/prom-dresses-under-100'))
            ->where('link', '=', 'dresses-under-100-prom-dresses-under-100')
            ->and_where('site_id', '=', '4')
            ->execute();
        if ($updated)
        {
            echo '成功';
        }else
            echo '失败';
    }

    public function action_link2()
    {
//        $select = DB::query(Database::SELECT,'select id, link from catalogs where site_id=4 and link = "dresses-under-100/wedding-dresses-under-100" ')->execute()->as_array();
//        echo kohana::debug($select); exit;
        $updated = DB::update('catalogs')
            ->set(array('link' => 'dresses-under-100/bridesmaid-dresses-under-100'))
            ->where('link', '=', 'dresses-under-100-bridesmaid-dresses-under-100')
            ->and_where('site_id', '=', '4')
            ->execute();
        if ($updated)
        {
            echo '成功';
        }else
            echo '失败';
    }

    public function action_link3()
    {
//        $select = DB::query(Database::SELECT,'select id, link from catalogs where site_id=4 and link = "dresses-under-100/wedding-dresses-under-100" ')->execute()->as_array();
//        echo kohana::debug($select); exit;
        $updated = DB::update('catalogs')
            ->set(array('link' => 'dresses-under-100/cocktail-dresses-under-100'))
            ->where('link', '=', 'dresses-under-100-cocktail-dresses-under-100')
            ->and_where('site_id', '=', '4')
            ->execute();
        if ($updated)
        {
            echo '成功';
        }else
            echo '失败';
    }

    public function action_link4()
    {
//        $select = DB::query(Database::SELECT,'select id, link from catalogs where site_id=4 and link = "dresses-under-100/wedding-dresses-under-100" ')->execute()->as_array();
//        echo kohana::debug($select); exit;
        $updated = DB::update('catalogs')
            ->set(array('link' => 'dresses-under-100/wedding-dresses-under-100'))
            ->where('link', '=', 'dresses-under-100-wedding-dresses-under-100')
            ->and_where('site_id', '=', '4')
            ->execute();
        if ($updated)
        {
            echo '成功';
        }else
            echo '失败';
    }

}

?>
