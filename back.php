<?php
//暂时不需要的代码存放文件
class Back
{
    //tagtoo
    public function action_tagtoo_product()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $fileurl = "/home/choies/project/www.choies.com/googleproduct/tagtoo_product.xml";
        if (!file_exists($fileurl))
        {
            self::xmldata3($fileurl);
        }
        else
        {
            self::xmldata3($fileurl);
        }

    }
    //tagtoo
    public function xmldata3($fileurl)
    {
        ini_set('memory_limit', '512M');
        $fileurl = "/home/data/www/htdocs/clothes/googleproduct/tagtoo_product.xml";

        $data_array1 = array(
            array(
                'title' => "CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes",
                'link' => BASEURL,
                'description' => "Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!",
            ),
        );
        $cate_wrong = array('éï¿½','éï¿½', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo');
        $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products_product where visibility=1 and status=1 and stock!=0')->execute('slave');
        $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');

        $data_array3 = array();
        $j = 0;
        foreach ($products as $product)
        {
            if(!in_array($product['sku'],$brr))
            {
                $image_url = '';
                $product_instance = Product::instance($product['id']);
                $image_url = Image::linkfeed($product_instance->cover_image(), 9);
                if (!$image_url)
                    Image::link($product_instance->cover_image(), 9);

                $description = strip_tags($product['description']);
                $description = str_replace('&nbsp', ' ', $description);
                $description = str_replace($cate_wrong, '', $description);

                $category = $product_instance->default_catalog();
                $category = Catalog::instance($category)->get("name");
                $category = str_replace('&', ' and ', $category);

                $price = round($product['price'], 2);
                $link = $product_instance->permalink();
                $data_array3[$j]['g:id'] = $product['id'];
                $data_array3[$j]['g:title'] = $product['name'];
                $data_array3[$j]['g:description'] = $description;
                $data_array3[$j]['g:link'] = $link;
                $data_array3[$j]['g:image_link'] = $image_url;
                $data_array3[$j]['g:brand'] = 'Choies';
                $data_array3[$j]['g:condition'] = 'new';
                $data_array3[$j]['g:availability'] = 'in stock';
                $data_array3[$j]['g:price'] = $price.' USD';
                $data_array3[$j]['g:shipping']['g:country'] = 'US';
                $data_array3[$j]['g:shipping']['g:service'] = 'Standard';
                $data_array3[$j]['g:shipping']['g:price'] = '0 USD';
                $data_array3[$j]['g:google_product_category'] = $category;
                $j++;
            }
        }


        $xml = new XMLWriter();
        $xml->openUri($fileurl);
        $xml->setIndentString('  ');
        $xml->setIndent(true);
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('rss');
        $xml->writeAttribute('xmlns:g',"http://base.google.com/ns/1.0");
        $xml->writeAttribute('version',"2.0");
        $xml->startElement('channel');



        foreach($data_array1 as $data)
        {
            if (is_array($data))
            {
                foreach ($data as $key => $row)
                {
                    $xml->startElement($key);
                    $xml->text($row);   //  设置内容
                    $xml->endElement(); // $key
                }
            }
        }

        foreach ($data_array3 as $data)
        {
            $xml->startElement('item');
            if (is_array($data))
            {
                foreach ($data as $key => $row)
                {
                    $xml->startElement($key);
                    if(is_array($row))
                    {
                        foreach ($row as $key => $rows)
                        {
                            $xml->startElement($key);
                            $xml->text($rows);
                            $xml->endElement();
                        }
                    }
                    else
                    {
                        $xml->text($row);   //  设置内容
                    }

                    $xml->endElement(); // $key
                }
            }
            $xml->endElement();         //  item
        }

        $xml->endElement(); //  article
        $xml->endDocument();
        $xml->flush();
        echo "success".'<br />';
        die;
    }

    //获取产品历史订单数据
     public function action_olddata()
     {

         $skus = array('SHA10W','SHA6G9','ASMX2036');
         $file = fopen('/home/choies/project/www.choies.com/olddata.csv','w');
 //        $file = fopen('olddata.csv','w');
         $n = 0;
         foreach ($skus as $sku)
         {
             $pro = DB::select('id')->from('products_product')
                 ->where('sku','=',$sku)
                 ->execute()
                 ->current();

             $items = DB::select()->from('orders_orderitem')
                 ->where('product_id','=',$pro)
                 ->execute()
                 ->as_array();

             foreach ($items as $item)
             {
                 $order =  DB::select()->from('orders_order')
                     ->where('id','=',$item['order_id'])
                     ->where('payment_status','=','verify_pass')
                     ->execute()
                     ->current();
                 $country = DB::select('name')->from('core_country')
                     ->where('isocode','=',$order['shipping_country'])
                     ->execute()
                     ->current();

                 if(!$order)
                 {
                     continue;
                 }

                 $n = $n +1;
                 $data[] = $sku;
                 $data[] = date('Y-m-d H:i:s', $order['created']);
                 $data[] = $item['quantity'];
                 $data[] = $item['price'];
                 $data[] = $country['name'];
                 $str = implode(',',$data);
                 fwrite($file, $str . PHP_EOL);
                 $data = array();
             }
         }
         fclose($file);
         echo $n.'<br>';
         echo 'success';
         die;
     }

    //风控漏单、跑数据
    public function action_update_fengkong()
    {
        $file = fopen('/home/choies/project/www.choies.com/fengkong.csv','r');
        $n = 0;
        $m = 0;
        while ($data = fgetcsv($file)) {
            $ordernum = $data[0];
            $txn_id = $data[1];
            $order = DB::select()->from('orders_order')->where('ordernum', '=', $ordernum)->execute()->current();
            $post_var = "order_num=" . $order['ordernum']
                . "&order_amount=" . $order['amount']
                . "&order_currency=" . $order['currency']
                . "&card_num=" . $order['cc_num']
                . "&card_type=" . $order['cc_type']
                . "&card_cvv=" . $order['cc_cvv']
                . "&card_exp_month=" . $order['cc_exp_month']
                . "&card_exp_year=" . $order['cc_exp_year']
                . "&card_inssue=" . $order['cc_issue']
                . "&card_valid_month=" . $order['cc_valid_month']
                . "&card_valid_year=" . $order['cc_valid_year']
                . "&billing_firstname=" . $order['billing_firstname']
                . "&billing_lastname=" . $order['billing_lastname']
                . "&billing_address=" . $order['billing_address']
                . "&billing_zip=" . $order['billing_zip']
                . "&billing_city=" . $order['billing_city']
                . "&billing_state=" . $order['billing_state']
                . "&billing_country=" . $order['billing_country']
                . "&billing_telephone=" . ''
                . "&billing_ip_address=" . long2ip($order['ip'])
                . "&billing_email=" . $order['email']
                . "&shipping_firstname=" . $order['shipping_firstname']
                . "&shipping_lastname=" . $order['shipping_lastname']
                . "&shipping_address=" . $order['shipping_address']
                . "&shipping_zip=" . $order['shipping_zip']
                . "&shipping_city=" . $order['shipping_city']
                . "&shipping_state=" . $order['shipping_state']
                . "&shipping_country=" . $order['shipping_country']
                . "&shipping_telephone=" . $order['shipping_phone']
                . '&trans_id=' . $txn_id
                . '&payer_email=' . $order['email']
                . '&receiver_email=' . $order['email']
                . "&site_id=" . Site::instance()->get('cc_payment_id')
                . "&secure_code=" . Site::instance()->get('cc_secure_code');
            $result = Toolkit::curl_pay_fk('http://manage.choiesriskcontrol.com/pp', $post_var);
            if($result)
            {
                $n =$n+1;
                echo $ordernum.':success';
                echo '<br>';
            }
            $m = $m+1;
        }
        echo '<hr>';
        echo 'success:'.$n;
        echo '<br>';
        echo 'total:'.$m;
    }

    public function action_fb_product_fr(){
        header("Content-type: text/xml");
        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">
    <channel>
        <title>CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes</title>
        <link>".BASEURL."</link>
        <description>Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!</description>";
        $cate_wrong = array('é”›ï¿½','é”›ï¿½', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo','&eacute','&Eacute','&agrave','&Agrave');

        $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products_fr where visibility=1 and status=1 and stock!=0')->execute('slave');
        $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');
        foreach($products as $product){
            if(!in_array($product['sku'],$brr)){
                $image_url = '';
                $product_instance = Product::instance($product['id'],LANGUAGE);
                $image_url = Image::link($product_instance->cover_image(), 9);
                if (!$image_url)
                    Image::link($product_instance->cover_image(), 9);

                $description = strip_tags($product['description']);
                $description = str_replace('&nbsp', ' ', $description);
                $proname = str_replace($cate_wrong, '', $product['name']);

                $description = str_replace($cate_wrong, '', $description);

                $category = $product_instance->default_catalog();
                $category = Catalog::instance($category)->get("name");
                $category = str_replace('&', ' and ', $category);

                $price = round($product['price'], 2);
                $link = $product_instance->permalink();

                $content .= '
    <item>
        <g:id><![CDATA['.$product['id'].']]></g:id>
        <g:title><![CDATA['.$proname.']]></g:title>
        <g:description><![CDATA['.$description.']]></g:description>
        <g:link><![CDATA['.$link.'?utm_source=facebook&amp;utm_medium=dpa&amp;utm_campaign=product&amp;currency=eur]]></g:link>
        <g:image_link><![CDATA['.$image_url.']]></g:image_link>
        <g:brand><![CDATA['.'Choies'.']]></g:brand>
        <g:condition><![CDATA[new]]></g:condition>
        <g:availability><![CDATA[in stock]]></g:availability>
        <g:price><![CDATA['.$price.' EUR'.']]></g:price>
        <g:shipping>
            <g:country><![CDATA[FR]]></g:country>
            <g:service><![CDATA[Standard]]></g:service>
            <g:price><![CDATA[0 EUR]]></g:price>
        </g:shipping>
        <g:google_product_category><![CDATA['.$category.']]></g:google_product_category>
    </item>';
            }
        }

        $content .= '
    </channel>
</rss>';
        echo $content;
        exit();
    }

    public function action_fb_product_de(){
        header("Content-type: text/xml");
        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">
    <channel>
        <title>CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes</title>
        <link>".BASEURL."</link>
        <description>Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!</description>";
        $cate_wrong = array('é”›ï¿½','é”›ï¿½', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo','&eacute','&Eacute','&agrave','&Agrave');

        $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products_de where visibility=1 and status=1 and stock!=0')->execute('slave');
        $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');
        foreach($products as $product){
            if(!in_array($product['sku'],$brr)){
                $image_url = '';
                $product_instance = Product::instance($product['id'],LANGUAGE);
                $image_url = Image::link($product_instance->cover_image(), 9);
                if (!$image_url)
                    Image::link($product_instance->cover_image(), 9);

                $description = strip_tags($product['description']);
                $description = str_replace('&nbsp', ' ', $description);
                $proname = str_replace($cate_wrong, '', $product['name']);

                $description = str_replace($cate_wrong, '', $description);

                $category = $product_instance->default_catalog();
                $category = Catalog::instance($category)->get("name");
                $category = str_replace('&', ' and ', $category);

                $price = round($product['price'], 2);
                $link = $product_instance->permalink();

                $content .= '
    <item>
        <g:id><![CDATA['.$product['id'].']]></g:id>
        <g:title><![CDATA['.$proname.']]></g:title>
        <g:description><![CDATA['.$description.']]></g:description>
        <g:link><![CDATA['.$link.'?utm_source=facebook&amp;utm_medium=dpa&amp;utm_campaign=product&amp;currency=eur]]></g:link>
        <g:image_link><![CDATA['.$image_url.']]></g:image_link>
        <g:brand><![CDATA['.'Choies'.']]></g:brand>
        <g:condition><![CDATA[new]]></g:condition>
        <g:availability><![CDATA[in stock]]></g:availability>
        <g:price><![CDATA['.$price.' EUR'.']]></g:price>
        <g:shipping>
            <g:country><![CDATA[FR]]></g:country>
            <g:service><![CDATA[Standard]]></g:service>
            <g:price><![CDATA[0 EUR]]></g:price>
        </g:shipping>
        <g:google_product_category><![CDATA['.$category.']]></g:google_product_category>
    </item>';
            }
        }

        $content .= '
    </channel>
</rss>';
        echo $content;
        exit();
    }

    public function action_fb_product_es(){
        header("Content-type: text/xml");
        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">
    <channel>
        <title>CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes</title>
        <link>".BASEURL."</link>
        <description>Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!</description>";
        $cate_wrong = array('é”›ï¿½','é”›ï¿½', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo','&eacute','&Eacute','&agrave','&Agrave');

        $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products_es where visibility=1 and status=1 and stock!=0')->execute('slave');
        $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');
        foreach($products as $product){
            if(!in_array($product['sku'],$brr)){
                $image_url = '';
                $product_instance = Product::instance($product['id'],LANGUAGE);
                $image_url = Image::link($product_instance->cover_image(), 9);
                if (!$image_url)
                    Image::link($product_instance->cover_image(), 9);

                $description = strip_tags($product['description']);
                $description = str_replace('&nbsp', ' ', $description);
                $proname = str_replace($cate_wrong, '', $product['name']);

                $description = str_replace($cate_wrong, '', $description);

                $category = $product_instance->default_catalog();
                $category = Catalog::instance($category)->get("name");
                $category = str_replace('&', ' and ', $category);

                $price = round($product['price'], 2);
                $link = $product_instance->permalink();

                $content .= '
    <item>
        <g:id><![CDATA['.$product['id'].']]></g:id>
        <g:title><![CDATA['.$proname.']]></g:title>
        <g:description><![CDATA['.$description.']]></g:description>
        <g:link><![CDATA['.$link.'?utm_source=facebook&amp;utm_medium=dpa&amp;utm_campaign=product&amp;currency=eur]]></g:link>
        <g:image_link><![CDATA['.$image_url.']]></g:image_link>
        <g:brand><![CDATA['.'Choies'.']]></g:brand>
        <g:condition><![CDATA[new]]></g:condition>
        <g:availability><![CDATA[in stock]]></g:availability>
        <g:price><![CDATA['.$price.' EUR'.']]></g:price>
        <g:shipping>
            <g:country><![CDATA[FR]]></g:country>
            <g:service><![CDATA[Standard]]></g:service>
            <g:price><![CDATA[0 EUR]]></g:price>
        </g:shipping>
        <g:google_product_category><![CDATA['.$category.']]></g:google_product_category>
    </item>';
            }
        }

        $content .= '
    </channel>
</rss>';
        echo $content;
        exit();
    }

    public function action_fb_kyproduct(){
        header("Content-type: text/xml");
        $content = "<?xml version=\"1.0\"?>
<rss xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">
    <channel>
        <title>CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes</title>
        <link>".BASEURL."</link>
        <description>Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!</description>";
        $cate_wrong = array('é”›ï¿½','é”›ï¿½', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo');

        $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products_product where visibility=1 and status=1 and stock!=0')->execute('slave');
        $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');
        foreach($products as $product){
            if(!in_array($product['sku'],$brr)){
                $image_url = '';
                $product_instance = Product::instance($product['id']);
                $image_url = Image::linkfeed($product_instance->cover_image(), 9);
                if (!$image_url)
                    Image::link($product_instance->cover_image(), 9);

                $description = strip_tags($product['description']);
                $description = str_replace('&nbsp', ' ', $description);
                $description = str_replace($cate_wrong, '', $description);

                $category = $product_instance->default_catalog();
                $category = Catalog::instance($category)->get("name");
                $category = str_replace('&', ' and ', $category);

                $price = round($product['price'], 2);
                $link = $product_instance->permalink();

                $content .= '
    <item>
        <g:id>'.$product['id'].'</g:id>
        <g:title>'.$product['name'].'</g:title>
        <g:description>'.$description.'</g:description>
        <g:link>'.$link.'?utm_source=facebook&amp;utm_medium=dpaky&amp;utm_campaign=product</g:link>
        <g:image_link>'.$image_url.'</g:image_link>
        <g:brand>'.'Choies'.'</g:brand>
        <g:condition>new</g:condition>
        <g:availability>in stock</g:availability>
        <g:price>'.$price.' USD'.'</g:price>
        <g:shipping>
            <g:country>US</g:country>
            <g:service>Standard</g:service>
            <g:price>0 USD</g:price>
        </g:shipping>
        <g:google_product_category>'.$category.'</g:google_product_category>
    </item>';
            }
        }

        $content .= '
    </channel>
</rss>';
        echo $content;
        exit();
    }



    public function action_copy_image()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $filedir = "/home/data/www/htdocs/clothes/uploads/1/pimages/";
        $todir = "/home/data/www/htdocs/clothes/uploads/1/feedimage/";
        $products = DB::query(DATABASE::SELECT, "select id from products_product  where  visibility=1 and status=1 order by created DESC")->execute('slave');
        foreach ($products as $product)
        {
            $product_instance = Product::instance($product['id']);
            $imageid = $product_instance->cover_image();
            $imageurl = $imageid['id'].'.'.$imageid['suffix'];
            $fileurl = $filedir.$imageurl;
            $tourl = $todir.$imageurl;
            if(file_exists($fileurl)){
                $copy = copy($fileurl, $tourl);
                echo $product['id'] . ' success<br>';
            }
        }
    }

    public  function action_get_bai_image()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $dir = "/home/data/www/htdocs/clothes/uploads/1/feedimage/";
        $products = DB::query(DATABASE::SELECT, "select id from products_product  where  visibility=1 and status=1 order by created DESC")->execute('slave');
        foreach ($products as $product)
        {
            $product_instance = Product::instance($product['id']);
            $imageid = $product_instance->cover_image();
            $imageurl = $imageid['id'].'.'.$imageid['suffix'];
            $fileurl = $dir.$imageurl;
            if(file_exists($fileurl)){
                self::imagewhite($fileurl);
            }

        }

    }

    public static function imagewhite($file)
    {
        //源图的路径，可以是本地文件，也可以是远程图片
        $src_path = $file;
        //最终保存图片的宽
        $width = 600;
        //最终保存图片的高
        $height = 600;

        //源图对象
        $src_image = imagecreatefromstring(file_get_contents($src_path));
        $src_width = imagesx($src_image);
        $src_height = imagesy($src_image);
        if($src_width == 600){
            //生成等比例的缩略图
            $tmp_image_width = 0;
            $tmp_image_height = 0;
            if ($src_width / $src_height >= $width / $height) {
                $tmp_image_width = $width;
                $tmp_image_height = round($tmp_image_width * $src_height / $src_width);
            } else {
                $tmp_image_height = $height;
                $tmp_image_width = round($tmp_image_height * $src_width / $src_height);
            }

            $tmpImage = imagecreatetruecolor($tmp_image_width, $tmp_image_height);
            imagecopyresampled($tmpImage, $src_image, 0, 0, 0, 0, $tmp_image_width, $tmp_image_height, $src_width, $src_height);

            //添加白边
            $final_image = imagecreatetruecolor($width, $height);
            $color = imagecolorallocate($final_image, 255, 255, 255);
            imagefill($final_image, 0, 0, $color);

            $x = round(($width - $tmp_image_width) / 2);
            $y = round(($height - $tmp_image_height) / 2);

            imagecopy($final_image, $tmpImage, $x, $y, 0, 0, $tmp_image_width, $tmp_image_height);

            //输出图片
            /*header('Content-Type: image/jpeg');*/
            imagejpeg($final_image,$file);

        }

    }

    //-----------------
    public function action_currency_list(){
        $data=array();
        $currenciesarr = DB::query(DATABASE::SELECT, 'SELECT name,fname,code,rate FROM core_currencies')->execute()->as_array();

        foreach($currenciesarr as $k=>$v){
            $data[$v['name']]=$v;
        }
        echo json_encode($data);
        exit;
    }
    public function action_cityads(){
        exit;
        //$click_id = Arr::get($_REQUEST, 'click_id', '');
        $status = Arr::get($_REQUEST, 'status', '');
        $token = Arr::get($_REQUEST, 'pkey', '');
        if($token!="m4eK5gu9TLUZOS3sGi75"){
            exit;
        }
        switch ($status)
        {
            case "new":
                $payment_status="'new'";
                $refund_status="";
                $status="new";
                break;
            case "done":
                $payment_status="'verify_pass','success'";
                $refund_status="";
                $status="done";
                break;
            case "cancel":
                $payment_status="'cancel'";
                $refund_status="'refund'";
                $status="cancel";
                break;
            default:
                $payment_status="'new','verify_pass','success','cancel'";
                $refund_status="'refund','partial_refund'";
                $status="all";
        }
        if($payment_status){
            $xml_date='<items>';
            if($refund_status){
                $refund=" OR O.`refund_status` in (".$refund_status.")";
            }else{
                $refund="";
            }
            $orders = DB::query(DATABASE::SELECT, "select O.*,C.`click_id` FROM cityads C left join `orders` O on C.`order_id`=O.`id` WHERE O.`payment_status` in (".$payment_status.")".$refund)->execute('slave');
            if($orders->count()>0){
                foreach ($orders as $order) {
                    if($order['refund_status']){
                        $order_statu="cancel";
                    }elseif($order['payment_status']=="new"){
                        $order_statu="new";
                    }elseif(in_array($order['payment_status'], array('verify_pass','success'))){
                        $order_statu="done";
                    }else{
                        $order_statu="";
                    }
                    $xml_date .='
                                <item> 
                                <order_id>'.$order["ordernum"].'</order_id> 
                                <click_id>'.$order["click_id"].'</click_id>
                                <status>'.$order_statu.'</status>
                                <date>'.$order["created"].'</date> 
                                <order_total>'.number_format(round($order["amount"], 2),2).'</order_total> 
                                <coupon>'.$order["coupon"].'</coupon> 
                                <discount>'.number_format(round($order["amount_coupon"], 2),2).'</discount> 
                                <currency>'.$order["currency"].'</currency> 
                                <payment_method>cash</payment_method> 
                                <customer_type>new</customer_type>
                                <basket> ';
                    $products=Order::instance($order["id"])->products();
                    foreach ($products as $product) {
                        $catalog=Set::instance(Product::instance($product['product_id'])->get("set_id"))->get('name');
                        $xml_date.='
                                <product> 
                                <pid>'.$product['sku'].'</pid> 
                                <pc>'.$catalog.'</pc> 
                                <pn>'.$product['name'].'</pn> 
                                <up>'.number_format(round($product['price'], 2),2).'</up> 
                                <qty>'.$product['quantity'].'</qty> 
                                </product>';
                    }
                    $xml_date.=' 
                                </basket> 
                                </item>';

                }
                $xml_date.='</items>';
                header("Content-type: text/xml");
                echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                echo $xml_date;
                exit;
            }else{
                exit;
            }
        }else{
            exit;
        }
    }

    public function action_validate()
    {
        $type = Arr::get($_REQUEST, 'type', '');
        $return = False;
        if($type)
        {
            switch($type)
            {
                case 'country':
                    $country = trim(Arr::get($_REQUEST, 'country', ''));
                    if($country)
                        $return = True;
                    else
                        $return = False;
                    break;
                case 'state':
                    $country = trim(Arr::get($_REQUEST, 'state', ''));
                    if($country)
                        $return = True;
                    else
                        $return = False;
                default:
                    break;
            }
        }
        echo json_encode($return);
        exit;
    }

    public function action_product()
    {
        $id = Arr::get($_REQUEST, 'id', '');
        if ($id)
        {
            $product_id = trim($id);
        }
        else
        {
            $sku = Arr::get($_REQUEST, 'sku', '');
            $sku = htmlspecialchars_decode(trim($sku));
            $link = mysql_connect($_SERVER['COFREE_DB_HOST_S'] . ':' . $_SERVER['COFREE_DB_PORT_S'], $_SERVER['COFREE_DB_USER_S'], $_SERVER['COFREE_DB_PASS_S']) OR die(mysql_error());
            $sku = mysql_real_escape_string($sku);
            $product_id = Product::get_productId_by_sku($sku);
        }
        $product = array();
        if ($product_id)
        {
            $product = DB::query(DATABASE::SELECT, 'SELECT id, name, sku, price, visibility, status, brief, attributes, weight, set_id, total_cost FROM products_product WHERE id = ' . $product_id)->execute('slave')->current();
            $cover_image = Product::instance($product_id)->cover_image();
            $product['set_name'] = Set::instance($product['set_id'])->get('name');
            $product['cover_image'] = $cover_image['id'];
            $product['image_suffix'] = $cover_image['suffix'];
        }
        echo json_encode($product);
        exit;
    }

    public function action_make_orders()
    {
        if($_POST)
        {
            $quantity = Arr::get($_POST, 'quantity', 0);
            if($quantity)
            {
                $order_instocks = array(
                    'ordernum' => Arr::get($_POST, 'ordernum', 0),
                    'sku' => Arr::get($_POST, 'sku', 0),
                    'quantity' => 1,
                    'attributes' => Arr::get($_POST, 'attributes', 0),
                    'created' => Arr::get($_POST, 'created', 0),
                    'cost' => Arr::get($_POST, 'cost', 0),
                );
                for($i = 1;$i <= $quantity;$i ++)
                {
                    $insert = DB::insert('order_instocks', array_keys($order_instocks))->values($order_instocks)->execute();
                }
                if($insert)
                    echo 'success';
                else
                    echo 'error';
            }
            else
            {
                echo 'error';
            }
        }
        exit;
    }

    public function action_set()
    {
        $id = Arr::get($_REQUEST, 'id', '');
        $data = array();
        if ($id)
        {
            $set_id = trim($id);
            if ($set_id)
            {
                $data = DB::query(DATABASE::SELECT, 'SELECT name, brief, label FROM products_set WHERE id = ' . $set_id)->execute('slave')->current();
            }

        }
        echo json_encode($data);
        exit;
    }

    public function action_image()
    {
        $data = array();
        $sku = Arr::get($_REQUEST, 'sku', '');
        $product_id = Product::get_productId_by_sku($sku);
        if($product_id)
        {
            $images = Product::instance($product_id)->images();
            foreach($images as $image)
            {
                $data[] = 'http://img.choies.com/uploads/1/pimages/' . $image['id'] . '.' . $image['suffix'];
            }
        }
        echo json_encode($data);
        exit;
    }

    //erp 从erp抓图（某些老产品少图，通过此接口抓图）
    public function action_item()
    {
        $id = Arr::get($_REQUEST, 'id', '');
        if ($id)
        {
            $product_id = trim($id);
        }
        else
        {
            $sku = Arr::get($_REQUEST, 'sku', '');
            $sku = htmlspecialchars_decode(trim($sku));
            $link = mysql_connect($_SERVER['COFREE_DB_HOST_S'] . ':' . $_SERVER['COFREE_DB_PORT_S'], $_SERVER['COFREE_DB_USER_S'], $_SERVER['COFREE_DB_PASS_S']) OR die(mysql_error());
            $sku = mysql_real_escape_string($sku);
            $product_id = Product::get_productId_by_sku($sku);
        }
        $product = array();
        if ($product_id)
        {
            $products = DB::query(DATABASE::SELECT, 'SELECT id, name, sku, price, visibility, status, stock, configs, attributes, factory, offline_factory, taobao_url, total_cost, offline_sku, set_id FROM products_product WHERE id = ' . $product_id)->execute('slave')->current();
            $image_url = '';
            $pimages = DB::select('id', 'suffix')->from('products_productimage')->where('obj_id', '=', $product_id)->execute('slave')->as_array();
            $images = unserialize($products['configs']);
            if (isset($images['default_image']))
            {
                foreach($pimages as $pimage)
                {
                    if($pimage['id'] == $images['default_image'])
                        $image_url = STATICURL.'/pimg/o/' . $images['default_image'] . '.jpg';
                }

            }
            if (!$image_url)
                $image_url = STATICURL.'/pimg/o/' . $pimages[0]['id'] . '.'.$pimages[0]['suffix'];

            $images = array();
            foreach($pimages as $img)
            {
                $images[] = STATICURL.'/pimg/o/' . $img['id'] . '.' . $img['suffix'];
            }
            $pstocks = array();
            $on_stock = $products['visibility'] && $products['status'];
            if ($on_stock && $products['stock'] = -1)
            {
                $stocks = DB::select('attribute', 'stock')->from('products_productitem')->where('product_id', '=', $product_id)->where('stock', '>', 0)->execute('slave')->as_array();
                if (!empty($stocks))
                {
                    foreach ($stocks as $stock)
                    {
                        $pstocks[$stock['attribute']] = $stock['stock'];
                    }
                }
            }

            $factory = trim($products['factory']) ? trim($products['factory']) : $products['offline_factory'];

            $attributes = unserialize($products['attributes']);
            $sizes = array();
            if (isset($attributes['Size']))
            {
                $sizes = $attributes['Size'];
            }
            elseif (isset($attributes['size']))
            {
                $sizes = $attributes['size'];
            }
            foreach ($sizes as $size)
            {
                $sizename = $size;
                if (strpos($size, 'EUR') !== False)
                {
                    $sizename = substr($size, strpos($size, 'EUR') + 3, 2);
                }
                $stock = DB::query(Database::SELECT, 'SELECT SUM(quantity) as stock FROM order_instocks WHERE sku = "' . $products['sku'] . '" AND status = 0 AND attributes = "Size:' . $sizename . ';"')->execute('slave')->get('stock');
                $set = Set::instance($products['set_id'])->get('name');
                $product[] = array(
                    'id' => $products['id'],
                    'sku' => $products['sku'],
                    'price' => $products['price'],
                    'total_cost' => $products['total_cost'],
                    'size' => $sizename,
                    'name' => $products['name'],
                    'set' => $set,
                    'on_stock' => $on_stock ? 1 : 0,
                    'stock' => (int) $stock,
                    'image_url' => $image_url,
                    'factory' => $factory,
                    'taobao_url' => $products['taobao_url'],
                    'offline_sku' => $products['offline_sku'],
                    'link' => Product::instance($products['id'])->permalink(),
                    'price_now' => Site::instance()->price(Product::instance($products['id'])->price()),
                    'images' => $images,
                );
            }
        }

        echo json_encode($product);
        exit;
    }

    public function action_itemlist()
    {
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
        $date_visible = strtotime('2015-09-01');
        $page = (int) $page;
        if (!$page)
            $page = 1;
        $products = DB::query(Database::SELECT, 'SELECT id, name, sku, price, visibility, status, stock, configs, attributes, factory, offline_factory, taobao_url, total_cost, offline_sku, set_id, weight, cn_name, admin, created
        FROM products_product ORDER BY id DESC  LIMIT ' . ($page - 1) * $limit . ', ' . $limit)->execute('slave');
        $product = array();
        foreach($products as $p)
        {
            if($p['visibility'] == 0 AND $p['created'] < $date_visible)
                continue;
            $image_url = '';
            $images = unserialize($p['configs']);
            if (isset($images['default_image']))
            {
                $image_url = STATICURL.'/pimg/o/' . $images['default_image'] . '.jpg';
            }
            else
            {
                $pimages = DB::select('id', 'suffix')->from('images')->where('obj_id', '=', $p['id'])->execute('slave')->current();
                if (!empty($pimages))
                    $image_url =  STATICURL.'/pimg/o/' . $pimages['id'] . '.'.$pimages['suffix'];

            }

            $pstocks = array();
            $on_stock = $p['visibility'] && $p['status'];
            if ($on_stock && $p['stocks'] = -1)
            {
                $stocks = DB::select('attribute', 'stock')->from('products_productitem')->where('product_id', '=', $p['id'])->where('stock', '>', 0)->execute('slave')->as_array();
                if (!empty($stocks))
                {
                    foreach ($stocks as $stock)
                    {
                        $pstocks[$stock['attribute']] = $stock['stock'];
                    }
                }
            }
            $set = Set::instance($p['set_id'])->get('name');
            $factory = trim($p['factory']) ? trim($p['factory']) : $p['offline_factory'];
            $link = Product::instance($p['id'])->permalink();

            $admin_email = User::instance($p['admin'])->get('email');
            if(!$p['attributes'])
            {
                $product[] = array(
                    'id' => $p['id'],
                    'sku' => $p['sku'],
                    'price' => $p['price'],
                    'total_cost' => $p['total_cost'],
                    'size' => '',
                    'color' => '',
                    'name' => $p['name'],
                    'set' => $set,
                    'on_stock' => $on_stock ? 1 : 0,
                    'stock' => -1,
                    'image_url' => $image_url,
                    'factory' => $factory,
                    'taobao_url' => $p['taobao_url'],
                    'offline_sku' => $p['offline_sku'],
                    'link' => $link,
                    'weight' => $p['weight'],
                    'cn_name' => $p['cn_name'],
                    'weight' => $p['weight'],
                    'admin_email' => $admin_email,

                );
            }
            else
            {
                $attributes = unserialize($p['attributes']);
                $sizes = array();
                if (isset($attributes['Size']))
                {
                    $sizes = $attributes['Size'];
                }
                elseif (isset($attributes['size']))
                {
                    $sizes = $attributes['size'];
                }
                foreach ($sizes as $size)
                {
                    $sizename = $size;
                    if (strpos($size, 'EUR') !== False)
                    {
                        $sizename = substr($size, strpos($size, 'EUR') + 3, 2);
                    }
                    $stock = DB::query(Database::SELECT, 'SELECT SUM(quantity) as stock FROM order_instocks WHERE sku = "' . $p['sku'] . '" AND status = 0 AND attributes = "Size:' . $size . ';"')->execute('slave')->get('stock');
                    $product[] = array(
                        'id' => $p['id'],
                        'sku' => $p['sku'],
                        'price' => $p['price'],
                        'total_cost' => $p['total_cost'],
                        'size' => $sizename,
                        'color' => '',
                        'name' => $p['name'],
                        'set' => $set,
                        'on_stock' => $on_stock ? 1 : 0,
                        'stock' => (int) $stock,
                        'image_url' => $image_url,
                        'factory' => $factory,
                        'taobao_url' => $p['taobao_url'],
                        'offline_sku' => $p['offline_sku'],
                        'link' => $link,
                        'cn_name' => $p['cn_name'],
                        'weight' => $p['weight'],
                        'admin_email' => $admin_email,
                    );
                }
            }
        }

        echo json_encode($product);
        exit;
    }


    public function action_order()
    {
        $ordernum = isset($_REQUEST['ordernum']) ? $_REQUEST['ordernum'] : '';
        $ordernum = htmlspecialchars_decode(trim($ordernum));
        $link = mysql_connect($_SERVER['COFREE_DB_HOST_S'] . ':' . $_SERVER['COFREE_DB_PORT_S'], $_SERVER['COFREE_DB_USER_S'], $_SERVER['COFREE_DB_PASS_S']) OR die(mysql_error());
        $ordernum = mysql_real_escape_string($ordernum);
        if ($ordernum)
        {
            $o = DB::query(Database::SELECT, 'SELECT o.id,o.payment_status,o.verify_date,o.ordernum,o.email,o.customer_id,o.currency,o.amount,o.amount_products,o.amount_shipping,o.amount_coupon,o.amount_payment,o.ip,o.transaction_id,o.rate,
                o.shipping_firstname,o.shipping_lastname,o.shipping_address,o.shipping_city,o.shipping_state,o.shipping_country,o.shipping_zip,o.shipping_phone,o.billing_firstname,o.billing_lastname,o.billing_address,o.billing_city,o.billing_zip,o.billing_phone,o.billing_state,o.billing_country,o.shipping_status,o.created,o.updated,o.payment_method,o.order_insurance,o.shipping_weight,o.order_from
                FROM orders_order o WHERE o.is_active = 1 AND o.ordernum = ' . $ordernum)
                ->execute('slave')->current();
            $items = array();
            $itemArr = DB::query(Database::SELECT, 'SELECT sku, quantity, price, attributes,product_id,created,status FROM orders_orderitem WHERE order_id = ' . $o['id'])->execute('slave');
            $remark = array();
            $remarks = DB::select('remark')->from('orders_orderremarks')->WHERE('order_id', '=', $o['id'])->execute('slave');
            foreach($remarks as $r)
            {
                $remark[] = $r['remark'];
            }
            foreach ($itemArr as $i)
            {
                $items[] = array(
                    'sku' => $i['sku'],
                    'attributes' => $i['attributes'],
                    'quantity' => $i['quantity'],
                    'price' => $i['price'],
                    'product_id' => $i['product_id'],
                    'created' => date('Y-m-d H:i:s', $i['created']),
                    'status' => $i['status']
                );
            }
            $data = array(
                'id' => $o['id'],
                'payment_status' => $o['payment_status'],
                'date_purchased' => date('Y-m-d H:i:s', $o['verify_date']),
                'is_active' => '1 ',
                'ordernum' => $o['ordernum'],
                'email' => $o['email'],
                'customer_id' => $o['customer_id'],
                'currency' => $o['currency'],
                'amount' => $o['amount'],
                'amount_products' => $o['amount_products'],
                'amount_shipping' => $o['amount_shipping'],
                'amount_coupon' => $o['amount_coupon'],
                'amount_payment' => $o['amount_payment'],
                'ip_address' => long2ip($o['ip']),
                'trans_id' => $o['transaction_id'],
                'rate' => $o['rate'],
                'remark' => implode('|', $remark),
                'shipping_firstname' => $o['shipping_firstname'],
                'shipping_lastname' => $o['shipping_lastname'],
                'shipping_address' => $o['shipping_address'],
                'shipping_city' => $o['shipping_city'],
                'shipping_state' => $o['shipping_state'],
                'shipping_country' => $o['shipping_country'],
                'shipping_zip' => $o['shipping_zip'],
                'shipping_phone' => $o['shipping_phone'],
                'shipping_status' => $o['shipping_status'],
                'created' => date('Y-m-d H:i:s', $o['created']),
                'updated' => date('Y-m-d H:i:s', $o['updated']),
                'shipping_weight' => $o['shipping_weight'],
                'order_from' => $o['order_from'],
                'payment_method' => $o['payment_method'],
                'order_insurance' => $o['order_insurance'],
                'billing_firstname' => $o['billing_firstname'],
                'billing_lastname' => $o['billing_lastname'],
                'billing_address' => $o['billing_address'],
                'billing_city' => $o['billing_city'],
                'billing_state' => $o['billing_state'],
                'billing_country' => $o['billing_country'],
                'billing_zip' => $o['billing_zip'],
                'billing_phone' => $o['billing_phone'],
                'orderitems' => $items,
            );
        }
        echo json_encode($data);
        exit;
    }

    public function action_orderlist()
    {
        $data = array();
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
        $page = (int) $page;
        if (!$page)
            $page = 1;
        $orders = DB::query(Database::SELECT, 'SELECT o.id,o.payment_status,o.verify_date,o.ordernum,o.email,o.customer_id,o.currency,o.amount,o.amount_products,o.amount_shipping,o.amount_coupon,o.amount_payment,o.ip,
                o.shipping_firstname,o.shipping_lastname,o.shipping_address,o.shipping_city,o.shipping_state,o.shipping_country,o.shipping_zip,o.shipping_phone,o.billing_firstname,o.billing_lastname,o.billing_address,o.billing_city,o.billing_zip,o.billing_phone,o.billing_state,o.billing_country,o.shipping_status,o.created,o.updated,o.payment_method,o.order_insurance,o.shipping_weight,o.order_from
                FROM orders_order o WHERE o.is_active = 1 AND o.payment_status = "verify_pass" GROUP BY o.id ORDER BY o.id limit  ' . ($page - 1) * $limit . ', ' . $limit)
            ->execute('slave');
        foreach ($orders as $o)
        {
            $items = array();
            $itemArr = DB::query(Database::SELECT, 'SELECT sku, quantity, price, attributes,product_id,created,status FROM orders_orderitem WHERE order_id = ' . $o['id'])->execute('slave');
            $remark = array();
            $remarks = DB::select('remark')->from('orders_orderremarks')->WHERE('order_id', '=', $o['id'])->execute('slave');
            foreach($remarks as $r)
            {
                $remark[] = $r['remark'];
            }
            foreach ($itemArr as $i)
            {
                $items[] = array(
                    'sku' => $i['sku'],
                    'attributes' => $i['attributes'],
                    'quantity' => $i['quantity'],
                    'price' => $i['price'],
                    'product_id' => $i['product_id'],
                    'created' => date('Y-m-d H:i:s', $i['created']),
                    'status' => $i['status']
                );
            }
            $data[] = array(
                'id' => $o['id'],
                'payment_status' => $o['payment_status'],
                'date_purchased' => date('Y-m-d H:i:s', $o['verify_date']),
                'is_active' => '1 ',
                'ordernum' => $o['ordernum'],
                'email' => $o['email'],
                'customer_id' => $o['customer_id'],
                'currency' => $o['currency'],
                'amount' => $o['amount'],
                'amount_products' => $o['amount_products'],
                'amount_shipping' => $o['amount_shipping'],
                'amount_coupon' => $o['amount_coupon'],
                'amount_payment' => $o['amount_payment'],
                'ip_address' => long2ip($o['ip']),
                'remark' => implode('|', $remark),
                'shipping_firstname' => $o['shipping_firstname'],
                'shipping_lastname' => $o['shipping_lastname'],
                'shipping_address' => $o['shipping_address'],
                'shipping_city' => $o['shipping_city'],
                'shipping_state' => $o['shipping_state'],
                'shipping_country' => $o['shipping_country'],
                'shipping_zip' => $o['shipping_zip'],
                'shipping_phone' => $o['shipping_phone'],
                'shipping_status' => $o['shipping_status'],
                'created' => date('Y-m-d H:i:s', $o['created']),
                'updated' => date('Y-m-d H:i:s', $o['updated']),
                'shipping_weight' => $o['shipping_weight'],
                'order_from' => $o['order_from'],
                'payment_method' => $o['payment_method'],
                'order_insurance' => $o['order_insurance'],
                'billing_firstname' => $o['billing_firstname'],
                'billing_lastname' => $o['billing_lastname'],
                'billing_address' => $o['billing_address'],
                'billing_city' => $o['billing_city'],
                'billing_state' => $o['billing_state'],
                'billing_country' => $o['billing_country'],
                'billing_zip' => $o['billing_zip'],
                'billing_phone' => $o['billing_phone'],
                'orderitems' => $items,
            );
        }
        echo json_encode($data);
        exit;
    }
}
