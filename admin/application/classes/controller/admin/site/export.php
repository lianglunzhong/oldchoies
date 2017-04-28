<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Export extends Controller_Admin_Site
{

    public function action_catalog()
    {
        $catalogs = ORM::factory('catalog')
            ->where('site_id', '=', $this->site_id)
            ->where('is_filter', '=', 0)
            ->find_all();

        $filename = 'catalog.csv';

        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        $outstream = fopen("php://output", 'w');

        foreach ($catalogs as $catalog)
        {
            $data = array();
            $data[] = '1000';
            $data[] = $catalog->id;
            $data[] = $catalog->name;
            $data[] = $catalog->link;
            $data[] = $catalog->parent_id;
            $data[] = $catalog->description;
            $data[] = $catalog->meta_title;
            $data[] = $catalog->meta_keywords;
            $data[] = $catalog->meta_description;
            $data[] = $catalog->brief;
            // site_id
            $data[] = $catalog->visibility;
            $data[] = $catalog->template;
            $data[] = $catalog->orderby;
            fputcsv($outstream, $data);
        }
        fclose($outstream);
        exit;
    }

    public function action_product()
    {
        $products = ORM::factory('product')
            ->where('site_id', '=', $this->site_id)
            ->find_all();

        $filename = 'product.csv';
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        $outstream = fopen("php://output", 'w');

        foreach ($products as $product)
        {
            $data = array();
            $data[] = $product->id;
            $data[] = $product->name;
            $data[] = $product->sku;
            $data[] = $product->link;
            $data[] = $product->price;
            $data[] = $product->market_price;
            $data[] = $product->cost;
            $data[] = $product->weight;
            $data[] = $product->stock;
            $data[] = $product->brief;
            $data[] = $product->description;
            $data[] = $product->meta_title;
            $data[] = $product->meta_keywords;
            $data[] = $product->meta_description;
            //set_id
            $set = ORM::factory('set', $product->set_id);
            if ($set->loaded())
            {
                $data[] = $set->label;
            }
            else
            {
                $data[] = 0;
            }
            $data[] = $product->type;
            $data[] = $product->visibility;
            $data[] = $product->status;
            $data[] = $product->freeshipping;
            $data[] = $product->images;
            $data[] = $product->default_catalog;
            // get catalogs
            $result = Db::select('catalog_id')->from('catalog_products')->where('product_id', '=', $product->id)->execute('slave');
            $catalogs = array();
            foreach ($result as $item)
            {
                $catalogs[] = $item['catalog_id'];
            }
            if ($catalogs)
            {
                $data[] = json_encode($catalogs);
            }
            else
            {
                $data[] = '';
            }

            $product_obj = Product::instance($product->id);
            $attributes = array();
            foreach ($product_obj->set_data() as $item)
            {
                $attributes[$item['name']] = $item['value'];
            }
            $data[] = json_encode($attributes);
            fputcsv($outstream, $data);
        }
        fclose($outstream);
        exit;
    }

    public function action_groups()
    {

        $products = ORM::factory('product')
            ->where('site_id', '=', $this->site_id)
            ->where('type', '=', 1)
            ->find_all();

        $filename = 'group.csv';
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        $outstream = fopen("php://output", 'w');

        foreach ($products as $product)
        {
            $data = array();
            $groups = array();
            $result = Db::select('product_id')->from('pgroups')->where('group_id', '=', $product->id)->execute('slave');
            if ($result)
            {
                foreach ($result as $item)
                {
                    $groups[] = $item['product_id'];
                }
            }

            $data[] = $product->id;
            $data[] = json_encode($groups);
            fputcsv($outstream, $data);
        }
        fclose($outstream);
        exit;
    }

    function action_options()
    {
        $options = ORM::factory('option')->where('site_id', '=', $this->site_id)->find_all();
        $filename = 'options.csv';
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        $outstream = fopen("php://output", 'w');

        foreach ($options as $option)
        {
            $data = array();
            $data[] = $option->label;
            $data[] = $option->position;
            $data[] = $option->default;
            $data[] = json_encode(Attribute::instance($option->attribute_id)->get('name'));
            ;
            fputcsv($outstream, $data);
        }
        fclose($outstream);
        exit;
    }

    function action_set_attributes()
    {
        $attributes = ORM::factory('attribute')->where('site_id', '=', $this->site_id)->find_all();

        $filename = 'set_attributes.csv';
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        $outstream = fopen("php://output", 'w');

        foreach ($attributes as $attribute)
        {
            $data = array();
            $data[] = json_encode($attribute->name);
            $set_attribute = DB::query(Database::SELECT, 'SELECT * FROM set_attributes WHERE attribute_id = ' . $attribute->id . ' limit 1')->execute('slave')->as_array();
            if (count($set_attribute))
            {
                $data[] = json_encode(Set::instance($set_attribute[0]['set_id'])->get('name'));
                $data[] = $set_attribute[0]['position'];
            }
            fputcsv($outstream, $data);
        }
        fclose($outstream);
        exit;
    }

    public function action_order()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $countries = Site::instance()->countries();
        $orders = Arr::get($_POST, 'orders', array());
        foreach ($orders as $key => $order)
        {
            $payment_status = Order::instance(Order::get_from_ordernum($order))->get('payment_status');
            if ($payment_status != 'verify_pass')
            {
                unset($orders[$key]);
            }
        }
        $orderSql = implode(',', $orders);
        $file_name = 'order_' . substr($orderSql, 0, 11) . '-' . substr($orderSql, -11, 11) . '.csv';

        header("Content-type:text/csv");
        //header('Content-Disposition: attachment; filename="orders-'.date('Y-m-d', $date).'.csv"');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "Order No.,Transaction Id,Is Gift,SKU,Description,Set,Qty,Weight,Attributes,Country Code,Country,Remark,Shipping Method,Shipment Status,name,address,city,state,zip,phone,mobile,Shipping amount,Dropshipping,Amount,Currency,USD,Point,Verify Date,IP,Email,Name,Payment Status,Sale Price,Subtotal,Orig Price,Cost,Orig Amount,Coupon,Time\n";

        $conditions = array(
            "is_active = 1",
            "site_id=" . Site::instance()->get('id'),
            "payment_status  = 'verify_pass'",
            "ordernum IN (" . $orderSql . ")",
        );

        $where_clause = implode(' AND ', $conditions);
        $ids = DB::query(Database::SELECT, "SELECT id FROM orders WHERE $where_clause ORDER BY verify_date")
            ->execute('slave');
        $site = Site::instance();

        foreach ($ids as $id)
        {
            $order = new Order($id['id']);
            $remarks = $order->remarks();
            $remarkss = '';
            if (!empty($remarks))
            {
                foreach ($remarks as $orderremark)
                {
                    $remark = array();
                    $user = new User($orderremark['admin_id']);
                    $remark['remark'] = $orderremark['remark'];
                    $remark['admin'] = $user->get('name');
                    $remarkss .= $remark['remark'] . ' - ' . $remark['admin'] . ',';
                }
                $data[$id['id']]['remarks'] = $remarkss;
                $remarkss = substr($remarkss, 0, strlen($remarkss) - 1);
//                            $remarkss = iconv("UTF-8","GB2312//IGNORE",$remarkss);
            }

            $shipping_country_code = $order->get('shipping_country');
            foreach ($countries as $country)
            {
                if ($country['isocode'] == $shipping_country_code)
                {
                    $shipping_country = $country['name'];
                    break;
                }
            }
            $products = $order->products();
            foreach ($products as $key => $orderitem)
            {
                if ($orderitem['status'] == 'cancel')
                {
                    continue;
                }
                $product = new Product($orderitem['item_id']);
                echo $order->get('ordernum') . ',';
                echo "'" . $order->get('transaction_id') . ',';
                echo $orderitem['is_gift'] ? 'Yes,' : 'No,';
                echo $orderitem['sku'] . ',';
                $set = Product::instance($orderitem['product_id'])->get('set_id');
                $description = $orderitem['quantity'] . ' ' . Set::instance($set)->get('name');
                echo $description . ',';
                $set = DB::query(Database::SELECT, 'SELECT sets.name FROM products LEFT JOIN sets ON products.set_id=sets.id WHERE products.id = ' . $orderitem['product_id'])->execute('slave')->current();
                echo $set['name'] . ',';
                echo $orderitem['quantity'] . ',';

                if ($product->get('id'))
                {
                    echo $product->get('weight') . ',';
                }
                else
                {
                    echo ",";
                }

                echo '"' . $orderitem['attributes'] . '",';
                echo '"' . $shipping_country_code . '",';
                echo $shipping_country . ',';
                echo!$key ? '"' . $remarkss . '",' : ",";
                echo $order->get('shipping_method') . ',';
                echo $order->get('shipping_status') . ',';
                echo '"' . $order->get('shipping_firstname') . ' ' . $order->get('shipping_lastname') . '",';
                echo '"' . $order->get('shipping_address') . '",';
                echo '"' . $order->get('shipping_city') . '",';
                echo '"' . $order->get('shipping_state') . '",';
                echo '"' . $order->get('shipping_zip') . '",';
                echo '"' . $order->get('shipping_phone') . '",';
                echo '"' . $order->get('shipping_mobile') . '",';
                echo $order->get('amount_shipping') . ',';
                echo ($order->get('drop_shipping') ? 'Yes' : 'No') . ',';
                echo $order->get('amount') . ',';
                echo $order->get('currency') . ',';
                echo $site->price($order->get('amount'), NULL, $order->get('currency'), $site->currency_get('USD')) . ',';
                echo $order->get('point') . ',';
                echo date('Y-m-d H:i:s', $order->get('verify_date')) . ',';
                echo long2ip($order->get('ip')) . ',';
                echo $order->get('email') . ',';
                echo '"' . $orderitem['name'] . '",';
                echo $order->get('payment_status') . ',';
                echo $orderitem['price'] . ',';
                echo ($orderitem['quantity'] * $orderitem['price']) . ',';

                if ($product->get('id'))
                {
                    echo $product->get('price') . ',';
                    echo $product->get('cost') . ',';
                }
                else
                {
                    echo ",";
                    echo ",";
                }

                echo ($order->get('amount_products') + $order->get('amount_shipping')) . ',';
                echo $order->get('coupon_code') . ',';
                echo date('Y-m-d', $order->get('created'));
                echo "\n";
            }
        }
    }

    public function action_fedex_order()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $orders = Arr::get($_POST, 'orders', array());
        if (empty($orders))
        {
            die('orders cannot be empty');
        }
        $countries = Site::instance()->countries();
        $count_items = 0;
        foreach ($orders as $key => $order)
        {
            $result = DB::query(1, 'SELECT count(id) AS count FROM order_items WHERE order_id = ' . Order::get_from_ordernum($order))->execute('slave')->current();
            if ($result['count'] > $count_items)
                $count_items = $result['count'];
//                        $payment_status = Order::instance(Order::get_from_ordernum($order))->get('payment_status');
//                        if($payment_status != 'verify_pass')
//                        {
//                                unset($orders[$key]);
//                        }
        }
        $product_code = '';
        $product_ch = '';
        for ($i = 1; $i <= $count_items; $i++)
        {
            $product_code.= '" 79-' . $i . '"," 81-' . $i . '"," 1030-' . $i . '"," 82-' . $i . '"," 80-' . $i . '"," 414-' . $i . '",';
            $product_ch .= '海关报关品名,商品编码,申报价值(产品单价),产品申报数量,产地,度量单位,';
        }
        $orderSql = implode(',', $orders);
        $file_name = 'order_' . substr($orderSql, 0, 11) . '-' . substr($orderSql, -11, 11) . '.csv';

        header("Content-type:text/csv");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "必须为20,订单号,运费支付（1为寄件方）,关税支付（1为寄件方，2为收件方）,打印发票（Y为打印发票）,销售条款,ETD,出口目的（4为样品，3为礼物）,加拿大专用,收件人公司名,收件人姓名,联系地址 1 ,联系地址 2 ,城市,邮编,电话,收件人国家代码,服务方式 (IP为1，IE为3),包装方式 （自已包装为1，防水袋为2）,包裹数,总重量(这个收件人所有包裹),收款单号,重量单位,货币,$product_ch\n";
        echo '0,1,23,70,113,72,2806,2397,1958,11,12,13,14,15,17,18,50,1274,1273,116,21,25,75,68,' . $product_code . "\n";

        $conditions = array(
            "is_active = 1",
            "site_id=" . Site::instance()->get('id'),
            "payment_status  = 'verify_pass'",
            "ordernum IN (" . $orderSql . ")",
        );

        $where_clause = implode(' AND ', $conditions);
        $ids = DB::query(Database::SELECT, "SELECT id FROM orders WHERE $where_clause ORDER BY verify_date")
            ->execute('slave');
        $site = Site::instance();

        foreach ($ids as $id)
        {
            $order = new Order($id['id']);
            echo '20,';
            echo '"' . $order->get('ordernum') . '",';
            echo '1,1,"Y",1,"Y",4,"OTH","",';
            echo '"' . $order->get('shipping_firstname') . ' ' . $order->get('shipping_lastname') . '",';
            $address = explode(',', $order->get('shipping_address'));
            echo '"' . $address[0] . '",';
            echo isset($address[1]) ? '"' . $address[1] . '",' : '"",';
            echo '"' . $order->get('shipping_city') . '",';
            echo "'" . $order->get('shipping_zip') . ",";
            echo '"' . $order->get('shipping_phone') . '",';
            echo '"' . $order->get('shipping_country') . '",';
            echo '1,2,"","","","KGS",';
            echo '"USD",';
//                        echo '"' . $order->get('currency') . '",';
            $products = $order->products();
            foreach ($products as $key => $orderitem)
            {
                $set_name = Set::instance(Product::instance($orderitem['product_id'])->get('set_id'))->get('name');
                echo '"' . 'Women ' . $set_name . '",';
                echo '"' . $orderitem['sku'] . '",';
                echo '"",';
                echo $orderitem['quantity'] > 0 ? '"' . $orderitem['quantity'] . '",' : '"1",';
                echo '"CN",';
                echo '"PCS",';
            }
            echo "\n";
        }
    }

}
