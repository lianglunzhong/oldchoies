<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Data extends Controller_Admin_Site
{

    public function action_export()
    {
        
    }

    public function action_upload_products()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        while ($data = fgetcsv($handle))
        {
            if ($row == 1)
            {
                try
                {
                    for ($i = 12; $i < count($data); $i++)
                        $attributes_key[$i] = str_ireplace("Attribute:", "", $data[$i]);
                    $row++;
                    continue;
                }
                catch (Exception $e)
                {
                    die("Read Column Fail.");
                }
            }
            try
            {
                if (!$data[5])
                    continue;
                // $data = Security::xss_clean($data);
                $name_link = strtolower(preg_replace('/[^\w\b]+/', '-', trim($data[1])));
                $link = $name_link;
                $duplicated_num = 1;
                while ($duplicated_num > 0)
                {
                    $obj = ORM::factory('product')
                        ->where('site_id', '=', $this->site_id)
                        ->where('link', '=', $link)
                        ->find();
                    if ($obj->loaded())
                    {
                        $link = $name_link . '-' . $duplicated_num;
                        $duplicated_num++;
                    }
                    else
                    {
                        $duplicated_num = 0;
                    }
                }
                $product = array();
                $product['link'] = $link;
                $product['site_id'] = $this->site_id;
                $product['name'] = $data[1];
                $product['description'] = str_replace("\n", '<br>', $data[3]);
                $product['brief'] = $data[4];
                $obj = ORM::factory("product")
                    ->where('site_id', '=', $this->site_id)
                    ->where('sku', '=', $data[5])
                    ->find();
                if ($obj->loaded())
                {
                    $error[] = "Add Row " . $row . " Fail: Duplicate SKU.";
                    $row++;
                    continue;
                }
                $product['sku'] = $data[5];
                $product['price'] = $data[6];
                $product['market_price'] = $data[7];
                $product['cost'] = $data[8];
                $product['total_cost'] = $data[11];
                $product['visibility'] = $data[9];
                $product['weight'] = $data[10];
                $set = ORM::factory("set")
                    ->where("name", "=", trim($data[0]))
                    ->where("site_id", "=", $this->site_id)
                    ->find();
                if ($set->loaded())
                    $product['set_id'] = $set->id;
                else
                {
                    unset($set);
                    $set['name'] = $set["label"] = trim($data[0]);
                    $set['site_id'] = $this->site_id;
                    $new_set = ORM::factory("set")->values($set)->save();
                    if ($new_set->loaded())
                        $product['set_id'] = $new_set->id;
                    else
                    {
                        $error[] = "Add Row " . $row . " Fail: Can't get set id.";
                        $row++;
                        continue;
                    }
                }
                $attributes = array();
                for ($i = 12; $i < count($data); $i++)
                {
                    if ($data[$i] != '' && $data[$i] != 'Default')
                    {
                        $attributes_value = explode("#", $data[$i]);
                        $attributes[$attributes_key[$i]] = $attributes_value;
                    }
                }
                $product['type'] = 3;
                $product['attributes'] = serialize($attributes);
                $product['items'] = $product['attributes'];
                $product['created'] = time();
                $product['display_date'] = time();
                $product['stock'] = -99;
                $product['status'] = 1;
                $product['admin'] = Session::instance()->get('user_id');
                if($p = ORM::factory("product")->values($product)->save())
                {
                    $product['id'] = $p->id;
                    foreach ($languages as $l)
                    {
                        if ($l === 'en')
                            continue;
                        ORM::factory("product".$l)->values($product)->save();
                    }
                }
                // add manage log
                $product_id = ORM::factory('product')->where('sku', '=', $product['sku'])->find();
                Manage::add_product_update_log($product_id->id, Session::instance()->get('user_id'), '新品上架');
                
                // set elastic
                // foreach ($languages as $l)
                // {
                //     if($l == 'en')
                //         $l = '';
                //     Product::bulk_elastic('id', array($product_id), $l);
                // }
                
                $row++;
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            die(implode("<br/>", $error));
        else
            die("Upload " . $row . " products successfully.");
    }

    public function action_import()
    {
        $action = Arr::get($_GET, 'action', NULL);
        $f = Arr::get($_GET, 'f', NULL);
        if ($f === NULL)
        {
            echo 'no file import';
            exit;
        }
        $path = '/tmp/data/import/';
        //$path='D:/xampp/htdocs/code/cola/trunk/admin/tmp/data/import/';
        if (is_dir($path . $f))
        {
            if ($handle = opendir($path . $f))
            {
                while (false !== ($file = readdir($handle)))
                {
                    if ($file != "." && $file != ".." && $file != 'Thumbs.db')
                    {
                        $files[] = $file;
                    }
                }
            }
        }
        else
        {
            $files[] = $f;
        }
        foreach ($files as $file)
        {
            echo 'Start to handle file ' . $file . '<br/>';
            $site = Site::instance();
            $set_label = preg_replace('/\.[a-zA-Z]+$/', '', $file);
            $set_orm = ORM::factory('set')->where('label', '=', $set_label)->and_where('site_id', '=', $site->get('id'))->find();
            if (!$set_orm->loaded())
            {
                echo 'no set loaded' . '<br/>';
                continue;
            }
            $set = Set::instance($set_orm->id);

            //$filename = DOCROOT."data/import/".$file;
            if (is_dir($path . $f))
                $filename = $path . $f . '/' . $file;
            else
                $filename = $path . $file;
            $handle = fopen($filename, 'r');

            if ($handle === FALSE)
            {
                echo 'read file failure' . '<br/>';
                continue;
            }
            $index = 1;
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                if ($index == 1)
                {
                    $index = 0;
                    continue;
                }

                $obj = ORM::factory('product')->where('site_id', '=', $site->get('id'))->where('sku', '=', $row[1])->find();
                if ($obj->loaded())
                {
                    echo 'same sku ' . $row[1] . "<br/>";
                    continue;
                }

                $product = Product::instance();
                $data = array();
                $data['set_id'] = $set->get('id');
                $data['type'] = 0;
                $data['site_id'] = Site::instance()->get('id');
                $data['name'] = $row[0];
                $data['sku'] = $row[1];

                $name_link = strtolower(preg_replace('/[^\w\b]+/', '-', $row[0]));
                $link = $name_link;
                $duplicated_num = 1;
                while ($duplicated_num > 0)
                {
                    $obj = ORM::factory('product')->where('site_id', '=', $site->get('id'))->where('link', '=', $link)->find();
                    if ($obj->loaded())
                    {
                        $link = $name_link . '-' . $duplicated_num;
                        $duplicated_num++;
                    }
                    else
                    {
                        $duplicated_num = 0;
                    }
                }

                $data['link'] = $link;
                $data['visibility'] = 0;
                $data['status'] = 1;
                $data['price'] = $row[2];
                $data['market_price'] = $row[3];
                $data['cost'] = $row[4];

                $data['weight'] = $row[5];
                $data['stock'] = $row[6];

                $data['brief'] = $row[7];
                $data['description'] = $row[8];

                $data['created'] = time();

                $data['meta_title'] = NULL;
                $data['meta_keywords'] = NULL;
                $data['meta_description'] = NULL;

                $i = 8;
                $attributes = $set->attributes();
                $attrs = array();
                $opts = array();

                foreach ($attributes as $attribute_id)
                {
                    $i++;
                    $attribute = ORM::factory('attribute')->where('site_id', '=', $site->get('id'))->where('id', '=', $attribute_id)->find();
                    if ($attribute->type <= 1)
                    {
                        $option = ORM::factory('option')
                                ->where('attribute_id', '=', $attribute->id)
                                ->where('site_id', '=', $site->get('id'))->where('label', '=', $row[$i])->find();
                        $opts[] = $option->id;
                        unset($option);
                    }
                    else
                    {
                        $attrs[$attribute->id] = $row[$i];
                    }
                }
                $data['option_id'] = $opts;
                $data['attributes'] = $attrs;

                if ($action == 's')
                {
                    $id = $product->set_basic($data);
                    $product->add_attributes($id, $data);
                    //echo $product->get('sku')." saved <br/>";
                }
            }
            echo ($action == 's' ? 'Import ' : 'Validation ') . $file . ' complete.<br/><br/>';
        }
    }

    public function action_sku()
    {
        //$filename = DOCROOT."data/import/".$file;
        $filename = "/tmp/data/sku.csv";
        $handle = fopen($filename, 'r');
        $site = Site::instance();

        if ($handle === FALSE)
        {
            echo 'read file failure';
            exit;
        }
        $index = 1;
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if ($index == 1)
            {
                $index = 0;
                continue;
            }
            $old = $row[0];
            $sku = $row[1];
            $product = ORM::factory('product')
                ->where('site_id', '=', $site->get('id'))
                ->where('sku', '=', $old)
                ->find();
            if ($product->loaded())
            {
                echo $old . ' ===> ' . $sku . "<br/>";
                $product->sku = $sku;
                $product->save();
            }
        }
    }

    //在原有图片id的基础上重名名产品图片  
    public function action_rename()
    {
        set_time_limit(0);
        $site_id = Site::instance()->get('id');
        $path = $_SERVER['COFREE_UPLOAD_DIR'] . '/4/pimages';
        $fso = opendir($path);
        $all_count = 0;
        $success_num = 0;
        $not_preg = array();
        while ($flist = readdir($fso))
        {
            if ($flist != '.' AND $flist != '..')
            {
                $a = explode(".", $flist);
                $image_name = $a[0];

                $preg = '/^\d{0,11}$/';
                if (preg_match($preg, $image_name))
                {
                    $all_count++;

                    $result = DB::select('obj_id')->from('images')
                            ->where('id', '=', $a[0])
                            ->where('site_id', '=', '4')
                            ->execute('slave')->current();

                    $product = Product::instance($result['obj_id']);
                    if ($p_sku = $product->get('sku'))
                    {
                        $catalog = Catalog::instance($product->default_catalog());
                        $p_link = $catalog->get('link');

                        $rs = strtolower(trim(substr(strrchr($flist, '.'), 1)));    //获得扩展名
                        $sql_image_name = $p_link . '-' . $p_sku . '-' . $image_name;


                        if (copy($path . '/' . $flist, $path . '/' . $sql_image_name . '.' . $rs))
                        {
                            $success_num++;
                            DB::update('images')
                                ->set(array('image_name' => $sql_image_name))
                                ->where('id', '=', $image_name)
                                ->execute();
                        }
                        else
                        {
                            continue;
                        }
                    }
                    else
                    {
                        continue;
                    }
                    if ($all_count % 200 == 0)
                    {
                        sleep(1);
                    }
                }
                else
                {
                    continue;
                }
            }
        }
        echo '共有' . $all_count . '个需要修改的图片' . ',已修改成功' . $success_num . '个<br/><br/><br/>';
    }

    public function action_images()
    {
        $path = $_SERVER['COFREE_IMG_DIR'];
        $skus = scandir($path);
        $site = Site::instance();
        //Image::set($p_file, $p_type, $p_site_id, $p_obj_id=0);
        $sizes = array(
            1,2,3,7
        );

        $save = Arr::get($_GET, 's', 1);
        foreach ($skus as $sku)
        {
            echo $sku . "<br/>";
            if ($sku == '.' OR $sku == '..' OR !is_dir($path . DIRECTORY_SEPARATOR . $sku))
                continue;

            $result = DB::select('id')->from('products_product')
                    ->where('sku', '=', $sku)
                    ->where('site_id', '=', $site->get('id'))
                    ->execute('slave')->current();
            if (isset($result['id']) AND $result['id'])
            {
                $has_image = DB::select('id')->from('images')->where('obj_id', '=', $result['id'])->execute('slave')->get('id');
                if($has_image)
                {
                    echo 'Already has images<br>';
                }
                else
                {
                    $product = Product::instance($result['id']);
                    $sku_data = scandir($path . DIRECTORY_SEPARATOR . $sku);
                    rsort($sku_data);
                    $images = array();
                    foreach ($sku_data as $image)
                    {
    //                                        $image = iconv('gbk', 'utf-8', $image);
                        if ($image == '.' OR $image == '..')
                            continue;
                        $pattern = '/(\.jpg)|(\.JPG)$/';
                        if (preg_match($pattern, $image))
                        {
                            $images[] = $image;
                            $imageArr = explode('.', $image);
                            $suffix = $imageArr[1];
                            if ($save)
                            {
                                $image_handle = $path . DIRECTORY_SEPARATOR . $sku . DIRECTORY_SEPARATOR . $image;
                                if (is_file($image_handle))
                                {
                                    $image_id = Image::set($image_handle, 1, $site->get('id'), $product->get('id'));
                                    foreach($sizes as $s)
                                    {
                                        $link = 'http://' . $_SERVER['HTTP_HOST'] . '/pimages1/' . $image_id . '/' . $s . '.' . $suffix;
                                        echo '<img src="' . $link . '" width="100px" />';
                                    }
                                    DB::update('images')->set(array('status' => 1))->where('id', '=', $image_id)->execute();
                                    echo '<br>';
                                }
                                echo '<br>';
    //                            @unlink($image_handle);
                            }
                        }
                    }
                }
//                echo $sku."<br/>";
//                echo kohana::debug($images);
                if ($save)
                {
//                    @unlink($path.DIRECTORY_SEPARATOR.$sku);
                }
            }
        }
    }

    public function action_export_image()
    {
        echo 'export image<br/>';
        $site_id = Site::instance()->get('id');
        $limit = 10000;
        $offset = Arr::get($_GET, 'offset', 0);
        $offset = $limit * $offset;
        $to_path = '/home/data/images/' . $site_id . '/';

        if (!is_dir($to_path))
        {
            mkdir($to_path);
        }

        $products = ORM::factory('product')->where('site_id', '=', $site_id)
                ->limit($limit)->offset($offset)->find_all();

        foreach ($products as $obj)
        {
            $product = Product::instance($obj->id);
            $images = $product->images();

            foreach ($images as $index => $image)
            {
                $to = $to_path . $obj->sku;
                if (!is_dir($to))
                {
                    echo $to;
                    mkdir($to);
                }
                $to = $to . '/' . $index . '.' . $image['suffix'];
                $from = '/home/data/www/uploads/' . $site_id . '/pimages/' . $image['id'] . '/' . $image[''];
                copy($from, $to);
            }
        }
    }

    public function action_attribute_to_desc()
    {
        $offset = Arr::get($_GET, 'offset', 0);
        $site_id = Site::instance()->get('id');
        $products = ORM::factory('product')->where('site_id', '=', $site_id)->offset($offset)->limit(200)->find_all();
        foreach ($products as $obj)
        {
            $product = Product::instance($obj->id);
            $attributes = $product->set_data();

            $output = '<p>';
            $details = array();
            foreach ($attributes as $attribute)
            {
                if ($attribute['value'] !== NULL AND $attribute['value'] != '')
                {
                    $details[] = $attribute;
                }
            }
            foreach ($details as $detail)
            {
                $output .='<strong>' . $detail['label'] . '</strong>: ' . ($detail['type'] != 3 ? $detail['value'] . '<br />' : '<br />' . nl2br($detail['value']));
            }
            if (isset($crumbs[1]) AND $crumbs[1]['id'] == 44)
            {
                $output .='<a class="picDesc" href="/faq" target="_blank" rel="nofollow" title="Enter to view a general comparison between our HID flashlights"><img src="/images/comparison.jpg" alt="Enter to view a general comparison between our HID flashlights" /></a>';
            }
            $output .='</p>';
            echo $output;
            $obj->description .= $output;
            $obj->save();
        }

        if ($offset < 9)
            $this->request->redirect('/admin/site/data/attribute_to_desc?offset=' . (++$offset));
    }

    public function action_upload_simple_products()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $catalogs = array();
        while ($data = fgetcsv($handle))
        {
            if ($row == 1)
            {
                if (count($data) != 8)
                    die("Read Column Fail.");
                $row++;
                continue;
            }
            try
            {
                // $data = Security::xss_clean($data);
                $name_link = strtolower(preg_replace('/[^\w\b]+/', '-', trim($data[1])));
                $link = $name_link;
                $duplicated_num = 1;
                while ($duplicated_num > 0)
                {
                    $obj = ORM::factory('product')
                        ->where('site_id', '=', $this->site_id)
                        ->where('link', '=', $link)
                        ->find();
                    if ($obj->loaded())
                    {
                        $link = $name_link . '-' . $duplicated_num;
                        $duplicated_num++;
                    }
                    else
                    {
                        $duplicated_num = 0;
                    }
                }
                $product['link'] = $link;
                $product['site_id'] = $this->site_id;
                $product['name'] = $data[1];
                $product['description'] = str_replace("\n", '<br>', $data[3]);
                $product['market_price'] = $data[4];
                $obj = ORM::factory("product")
                    ->where('site_id', '=', $this->site_id)
                    ->where('sku', '=', $data[2])
                    ->find();
                if ($obj->loaded())
                {
                    $error[] = "Add Row " . $row . " Fail: Duplicate SKU : " . $data[2];
                    $row++;
                    continue;
                }
                $product['sku'] = $data[2];
                $product['price'] = $data[5];
                $product['cost'] = $data[6];
                $product['total_cost'] = 0;
                $product['visibility'] = 0;
                $product['weight'] = 1000;
                $set = ORM::factory("set")
                    ->where("name", "=", 'Occasion Dresses')
                    ->where("site_id", "=", $this->site_id)
                    ->find();
                if ($set->loaded())
                    $product['set_id'] = $set->id;
                else
                {
                    $set = 0;
                }

                $product['type'] = 0;
                $product['created'] = time();
                $product['stock'] = -99;
                $product['status'] = 1;
                $product['admin'] = Session::instance()->get('user_id');
                ORM::factory("product")->values($product)->save();
                // add manage log
                $product_id = ORM::factory('product')->where('sku', '=', $product['sku'])->find();
                Manage::add_product_update_log($product_id->id, Session::instance()->get('user_id'), '新品上架');

                // add attribute
                $attribute = ORM::factory('attribute')->where('label', '=', 'fabric')->find();
                $fabrics = explode(',', $data[7]);
                $fabric = $fabrics[0];
                $product_attribute = array('product_id' => $product_id, 'attribute_id' => $attribute->id, 'value' => $fabric);
                DB::insert('product_attribute_values', array_keys($product_attribute))->values($product_attribute)->execute();
                $catalogs[ucwords($data[0])][] = $product_id->id;
                $row++;
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        foreach ($catalogs as $ca_name => $ca_product)
        {
            $catalog = ORM::factory('catalog')->where('name', '=', $ca_name)->find();
            if ($catalog->loaded())
            {
                $position = DB::query(Database::SELECT, 'SELECT MAX(position) AS p FROM catalog_products WHERE catalog_id = ' . $catalog->id)->execute('slave')->get('p');
                foreach ($ca_product as $pid)
                {
                    $position++;
                    DB::insert('catalog_products', array('catalog_id', 'product_id', 'position'))
                        ->values(array($catalog->id, $pid, $position))
                        ->execute();
                }
            }
        }

        if (isset($error))
            die(implode("<br/>", $error));
        else
            die("Upload " . $row . " products successfully.");
    }

    public function action_red_people()
    {
        if(!empty($_POST['from']))
        {
            $from = strtotime($_POST['from']);
            $to = empty($_POST['to']) ? time() : ( strtotime($_POST['to']) + 86399 ) ;
        }else{
            $from = time()-86400*7;
            $to = time();
        }
        //echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        $data = $ids = array();
        $admin_ids = DB::query(Database::SELECT, 'select count(id) num,admin from celebrits where is_able=1 group by admin order by num desc')->execute('slave');
        
        //++++ admin 数据 ++++
        foreach ($admin_ids as $val)  //+++admin
        {
            $id = $val['admin'];
            $ids[] = $id;
            $eve1 = DB::query(Database::SELECT,'select count(id) num from celebrits where is_able=1 and level=1 and admin="'.$id.'" ')->execute('slave');
            $eve2 = DB::query(Database::SELECT,'select count(id) num from celebrits where is_able=1 and level=2 and admin="'.$id.'" ')->execute('slave');
            $eve3 = DB::query(Database::SELECT,'select count(id) num from celebrits where is_able=1 and level=3 and admin="'.$id.'" ')->execute('slave');   
            $new = DB::query(Database::SELECT,'select count(id) num from celebrits where is_able=1 and created<"'.$to.'" and created>"'.$from
                                    .'" and admin='.$id)->execute('slave');
            
//          $show_cost = DB::select('fee')->from('celebrity_fees')->where('admin','=',$id)->where('created','between',array($from,$to))->execute();
//          $temp_cost = 0;
//          foreach($show_cost as $cost_val)
//          {
//              $temp_cost += $cost_val['fee'];
//          }
            $show_cost = DB::select(DB::expr('sum(fee) showfee'))->from('celebrity_fees')->where('admin','=',$id)
                                    ->where('created','between',array($from,$to))->execute('slave')->current();
            $temp_cost = $show_cost['showfee'] ? $show_cost['showfee'] : 0;
                                    
            $data[$id] = array(
                        'admin' => User::instance($val['admin'])->get('name'),
                        'eve_all' => $val['num'],
                        'new' => $new[0]['num'],
                        'eve1' => $eve1[0]['num'],
                        'eve2' => $eve2[0]['num'],
                        'eve3' => $eve3[0]['num'],
                        'order' => 0,
                        'cost' => 0,
                        'ship_num' => 0,
                        'ship_per' => 0 ,
                        'show_cost' => $temp_cost,
                        'show_num' => 0,
                        'show_per' => 0,
                );
        }
        
        //+++++ items 数据 ++++
        $sql_item = 'SELECT celebrits.id,celebrits.admin,celebrits.email,orders.ordernum,orders.created,orders.shipping_status,
                order_items.sku, order_items.quantity,order_items.item_id
                FROM `celebrits`,orders,order_items 
                WHERE celebrits.email=orders.email AND orders.id=order_items.order_id AND 
                orders.payment_status="verify_pass" AND order_items.status != "cancel" 
                AND orders.created>"'.$from.'" AND orders.created<"'.$to.'"';
        $items = DB::query(Database::SELECT, $sql_item)->execute('slave')->as_array();
        foreach( $items as $item_val )
        {
            $id = $item_val['admin'];
            if(in_array($id, $ids))
            {
                //$data[$id]['cost'] +=  $item_val['cost']*$item_val['quantity'] ;
                $cost_pro = DB::select('total_cost')->from('products_product')->where('id','=',$item_val['item_id'])->execute('slave')->current();
                $data[$id]['cost'] +=  ( $cost_pro['total_cost']*$item_val['quantity'] );
            }           
        }
        
        //+++++ orders 数据 +++++
        $sql_order = 'SELECT celebrits.id,celebrits.admin,celebrits.email,orders.ordernum,orders.created,orders.shipping_status
                FROM `celebrits`,orders 
                WHERE celebrits.email=orders.email AND 
                orders.payment_status="verify_pass"  
                AND orders.created>"'.$from.'" AND orders.created<"'.$to.'"';
        $orders = DB::query(Database::SELECT, $sql_order)->execute('slave')->as_array();
        foreach( $orders as $order_val )
        {
            $id = $order_val['admin'];
            if(in_array($id, $ids))
            {
                $data[$id]['order'] += 1 ;
                if($order_val['shipping_status'] == 'shipped')
                {
                    $data[$id]['ship_num'] += 1;
                }
                $show = DB::select()->from('celebrities_celebrityorder')->where('ordernum','=',$order_val['ordernum'])->execute('slave')->current();
                if($show)
                {
                    $data[$id]['show_num'] += 1;
                }
            }
        }
        
        foreach($ids as $id_val)
        {
            $data[$id_val]['ship_per'] = empty($data[$id_val]['order']) ? 0 : $data[$id_val]['ship_num']/$data[$id_val]['order'];
            $data[$id_val]['show_per'] = empty($data[$id_val]['order']) ? 0 : $data[$id_val]['show_num']/$data[$id_val]['order'];
        }
        
        $content = View::factory('admin/site/compute_red')->set('data',$data)->set('from',$from)->set('to',$to)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }


    public function action_refund()
    {
        $content = View::factory('admin/site/affair_refund');
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }
    
    public function action_refund_data()
    {
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 1); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array( ));
        $filters = $filters ? json_decode($filters) : array();
        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
        if($totalrows) $limit = $totalrows;

        $filter_sql = "1";
        if ($filters) 
        {
            foreach ($filters->rules as $item) 
            {
                if ( $item->field == 'created' ) 
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1) {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    } else {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = 't.'.$item->field . " between " . $from . " and " . $to;
                } 
                else if ($item->field == 'ordernum') 
                {
                    $_filter_sql[] = 'o.'.$item->field . "='" . $item->data . "'";
                } 
                else {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql)) $filter_sql = implode(' AND ', $_filter_sql);
        }

        $sql = 'select count(id) num from (
                    select t.id from order_payments t left join orders o on t.order_id=o.id
                      where t.payment_status in("partial_refund","refund") and t.amount>0.1 and o.created>'.strtotime('2014-08-01').'
                      and '.$filter_sql.'
                  ) op';
//      $sql = 'select count(id) num from (
//                  select t.id from order_payments t left join orders o on t.order_id=o.id
//                    where t.payment_status in("partial_refund","refund") and t.payment_method!="CreditPay" and t.amount!=0 and o.created>'.strtotime('2013-08-01').'
//                    and '.$filter_sql.'
//                ) op';
        $result = DB::query(DATABASE::SELECT, $sql)->execute('slave');
        
        $count = $result[0]['num'];
        $total_pages = 0;
        if($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }
        if($page > $total_pages) $page = $total_pages;
        if($limit < 0) $limit = 0;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if($start < 0) $start = 0;
             
        $sql = 'select o.created o_created,o.shipping_date,o.id, o.ordernum, o.shipping_status,o.payment_method payment_method,t.created, t.currency, t.amount, t.trans_id 
                  from order_payments t left join orders o on t.order_id=o.id 
                    where  (t.payment_status="partial_refund" or t.payment_status="refund")  and t.amount>0.1 and o.created>'.strtotime('2014-08-01').'
                    and '.$filter_sql.' ORDER BY '.$sidx.' '.$sord.' LIMIT '.$limit.' OFFSET '.$start;
//      $sql = 'select o.id, o.ordernum, o.shipping_status,o.payment_method payment_method,t.created, t.currency, t.amount, t.trans_id
//                from order_payments t left join orders o on t.order_id=o.id
//                  where  (t.payment_status="partial_refund" or t.payment_status="refund")  and t.payment_method!="CreditPay" and t.amount!=0 and o.created>'.strtotime('2013-08-01').'
//                  and '.$filter_sql.' ORDER BY '.$sidx.' '.$sord.' LIMIT '.$limit.' OFFSET '.$start;
        $result = DB::query(DATABASE::SELECT, $sql)->execute('slave');
        
        $response = array( );
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i=1;
        foreach( $result as $value )
        {
            // $id_pp = DB::select()->from('orders_orderpayments')->where('order_id','=',$value['id'])->where('payment_method','=','PPJump')
                // ->where('payment_status','=','refund')->execute('slave')->current();
            $stack = DB::select('tracking_code')->from('orders_ordershipments')->where('order_id','=',$value['id'])->execute('slave')->current();
            $print_time = DB::query(DATABASE::SELECT,"select `print_time` from `order_purchase` where order_id=".$value['id']." limit 1")->execute('slave')->get('print_time');
            $response['rows'][] = array(
                'id' => $i++,
                'cell' => array(
                0,
                $value['id'],
                $value['ordernum'],
                //isset($id_pp) ? $id_pp['trans_id'] : '',
                $value['o_created'] ? date('Y-m-d H:i', $value['o_created']) : '',//订单生成时间
                $print_time ? date('Y-m-d H:i', $print_time) : '',//订单ship time
                $value['created'] ? date('Y-m-d H:i', $value['created']) : '',
                $value['currency'] ? $value['currency'] : 'USD',
                $value['amount'] ? number_format($value['amount'],2) : 0,
                $value['payment_method'],
                $value['shipping_status'],
                isset($stack['tracking_code'])?$stack['tracking_code']:"",
            ));
        }
        echo json_encode($response);
    }

    public function action_exprotcsv()
    {
        ob_end_clean();
        ob_start();
        //header("Content-Type: application/vnd.ms-excel; charset=UTF-8");   
        header('Content-Type: application/vnd.ms-excel');
        header("Pragma: public");   
        header("Expires: 0");   
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition: attachment; filename=order_'.date('Y-m-d',time()).'.xls');
        header("Content-Transfer-Encoding: binary ");

        
        $buffer = $_POST['csvBuffer'];
        //$buffer=iconv("utf-8", "gbk", $buffer);
        try{
            echo $buffer;
        }catch(Exception $e){
            echo 'Sorry, Server is too busy, please try again later,THX.';
        }
    }

}
