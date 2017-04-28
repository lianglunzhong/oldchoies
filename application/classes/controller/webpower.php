<?php

defined('SYSPATH') or die('No direct script access.');


class Controller_Webpower extends Controller_Webpage
{
    protected $path = '/home/choies/project/www.choies.com/googleproduct/';//feed文件路径
    protected $export_path = '/home/choies/project/www.choies.com/Export/';//导出文件路径
    static protected $export_path1 = '/home/choies/project/www.choies.com/Export/';//feed文件路径，静态方法使用
//    protected $path = '';//feed文件路径
//    protected $export_path = '';//导出文件路径
//    static protected $export_path1 = '';

    //google product 定时导出
    public function action_mihqtgylls($country)
    {

        if(!$country)
        {
            exit();
        }
        ignore_user_abort(true);
        set_time_limit(0);

        $file = ($country == "US") ?'':'.'.strtolower($country);
        $filename = "choies_googleshopping_feed".$file.".txt";
        $fileurl = $this->path . $filename;
        if (file_exists($fileurl))
        {
            @unlink($fileurl);
        }
        $this->daochutxtforsize($country,$filename);

        echo "<br />suceess";
        exit;
    }

    public function action_datafeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $datafeed = $this->export_path . "datafeed.csv";
        if (file_exists($datafeed))
        {
            @unlink($datafeed);
        }
        self::datafeed();

        echo "<br />suceess";
        exit;
    }
//fackbook feed
    public function action_fb_product()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $fileurl = "/home/choies/project/www.choies.com/googleproduct/fb_product.xml";
        if (!file_exists($fileurl))
        {
            self::xmldata1($fileurl);
        }
        else
        {
            self::xmldata1($fileurl);
        }

    }

    public static function xmldata1($fileurl)
    {
        ini_set('memory_limit', '512M');

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
                $data_array3[$j]['g:link'] = $link.'?utm_source=facebook&amp;utm_medium=dpa&amp;utm_campaign=product';
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

    public function action_pfeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurl = $this->export_path . "PolyvoreFeed.txt";

        if (file_exists($fileurl)) {
            @unlink($fileurl);
        }
        $this->polyvorefeed();
    }

    public function polyvorefeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $head_gooproductinfo = array('Polyvore', 'title', 'brand', 'url', 'cpc_tracking_url', 'imgurl', 'price', 'sale_price', 'currency', 'description', 'color', 'sizes', 'tags', 'subject', 'category');


        $file_name = $this->export_path."PolyvoreFeed.txt";
        $open = fopen($file_name, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);

        //只取这些set下的产品
        $set_ids = '"7","8","9","10","11","12","13","14","15","16","20","280","396","375","472","473","395","500","475","498","499","497"';
        $products = DB::query(DATABASE::SELECT, 'select `id`,`sku`,`name`,`description`,`set_id` from products_product where  visibility=1 and status=1 order by created DESC')->execute('slave');
        $colors = '"4","5","6","7","8","9","10","11","12","13","14","15","16","17"';
        $exclude_skus = array("CC014914", "CC031525", "CCJJ0827", "CCPY1484", "CD080275", "CDJJ0812", "CDPY0418", "CDYP0794", "CDYP0795", "CDZY2418", "CDZY2427", "CDZY4788", "CGZW0001", "CLWC4167", "COAT1113A184A", "COAT1113A188A", "COAT1121A411D", "COAT1121A412D", "CPWC2535", "CPWC2970", "CPWC2981", "CR014888", "CR031745", "CR031746", "CR051025", "CR051029", "CR051135", "CR051136", "CR051139", "CR051140", "CRJJ0639", "CRJJ0682", "CRJJ0723", "CRJJ0763", "CRJJ0789", "CRJJ0796", "CRJJ0822", "CRJJ0823", "CRJJ0824", "CRJJ0828", "CRJJ0829", "CRJJ0833", "CRPC0040", "CRPC0041", "CRPC0043", "CRPC0044", "CRPY0863", "CRPY1181", "CRWC0006", "CRWC0010", "CRWC4624", "CRWC4625", "CRWC4626", "CRWC4627", "CRWC4628", "CRWC4692", "CRWC4693", "CRWC4694", "CRYP0618", "CRYP0619", "CRYP0620", "CRYP0623", "CRYP0624", "CRYP0625", "CRYP0628", "CRYP0629", "CRYP0631", "CRYP0632", "CRYP0649", "CRYP0650", "CRYP0796", "CRYP0880", "CRYP0884", "CRYP0991", "CRYP0998", "CRYY0011", "CRYY0176", "CRYY0178", "CRYY0179", "CRYY0181", "CRYY0211", "CRYY0214", "CRYY0220", "CRYY0222", "CRYY0225", "CRYY0227", "CRZY2690", "CRZY3437", "CRZY3439", "CRZY4487", "CRZY4488", "CRZY4489", "CRZY4490", "CRZY4493", "CRZY4496", "CRZY4674", "CRZY4675", "CRZY4676", "CRZY4679", "CRZY4765", "CRZY4767", "CRZY4770", "CRZY4771", "CRZY4773", "CSDL0425", "CSGZ0005", "CSSM0010", "CSWC0593", "CSXF0710", "CSXR0060", "CSXR0062", "CSXZ0164", "CSZY1062", "CSZY1215", "CSZY3203", "CT051180", "CTPY0174", "CTPY0175", "CTSM0412", "CTSM0413", "CTSM0417", "CTWC2666", "CTXF2037", "CTXF2388", "CTXF2431", "CTXF2439", "CTXF2508", "CTYP0027", "CTYP0170", "CTYP0898", "CTYY0428", "CTYY0429", "CTYY0617", "CTYY0888", "CTZY2068", "CTZY2230", "CTZY3099", "CTZY3126", "CTZY4015", "CTZY4016", "CTZY4017", "CVZY0992", "CVZY4031", "CVZY4707", "CWXR0309", "CWZY2363", "CWZY3424", "CWZY3426", "DRES1022A113E", "DRES1107A279C", "HOOD100814E008", "HOOD100814E011", "HOOD100814E013", "HOOD1011A054D", "HOOD1020A103K", "HOOD1020A104K", "HOOD1020A105K", "HOOD1029A209E", "HOOD1031A228E", "HOOD1031A229E", "HOOD1103A260E", "HOOD1103A261E", "HOOD1103A265E", "HOOD1104A219D", "HOOD1104A220D", "HOOD1105A316E", "HOOD1105A317E", "HOOD1118A488E", "HOOD1118A489E", "HOOD1121A410D", "HOOD1124A530E", "HOOD1125A371B", "HOOD1125A372B", "HOOD1203A403B", "HOOD1203A408B", "HOOD1203A409B", "HOOD1203A411B", "HOOD1203A632E", "HOOD1203A689G", "HOOD1206A777K", "SKIR1015A067A", "SWEA100714A026", "SWEA100714A027", "TSHI1031A001P", "TSHI1111A002P", "TSHI1129A674K", "TSHI1129A675K", "TWOP1013A039G", "TWOP1024A160E", "TWOP1208A677E", "SWEA1216A500D", "DRES1210A783K", "TSHI1210A782K", "TSHI1210A781K", "HOOD1203A404B");
        foreach ($products as $product)
        {
            if (!in_array($product['sku'], $exclude_skus))
            {
                $data = array();
                $product_instance = Product::instance($product['id']);
                $imageURL = Image::link($product_instance->cover_image(), 10); //

                $link = $product_instance->permalink();
                $set_name = Set::instance($product['set_id'])->get('name');
                $p_price = $product_instance->get('price');
                $price = $product_instance->price();
                $crumbs = Catalog::instance($product_instance->default_catalog())->crumbs();
                $tag = array();

                if(!empty($crumbs))
                {
                    foreach ($crumbs as $crumb):
                        if ($crumb['id'])
                        {
                            $tag[] = $crumb['name'];
                        }
                    endforeach;
                }
                if (!empty($tag))
                {
                    $tags = implode(",", $tag);
                }
                else
                {
                    $tags = "";
                }
                if (!empty($tag) && $tag[0] != "Men's Collection")
                {

                    $size = "";
                    $attributes = $product_instance->get("attributes");
                    if (!empty($attributes['Size']))
                    {
                        $size = implode(",", $attributes['Size']);
                    }
                    //$attribute_color=DB::query(DATABASE::SELECT,'select A.`label` from `product_attribute_values` PV left join `attributes` A on PV.`attribute_id`=A.`id` where PV.`product_id`='.$product['id'].' and  PV.`attribute_id` in ('.$colors.')')->execute('slave')->get('label');
                    //filter attributes
                    $filter_sorts = array();
                    $filter_attributes = explode(';', $product_instance->get('filter_attributes'));
                    if (!empty($filter_attributes))
                    {
                        $filter_sqls = array();
                        foreach ($filter_attributes as $key => $filter)
                        {
                            if ($filter)
                                $filter_sqls[] = '"' . $filter . '"';
                            else
                                unset($filter_attributes[$key]);
                        }
                        $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                        $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM products_categorysorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                        if (!empty($sorts))
                        {
                            foreach ($sorts as $sort)
                            {
                                if (array_key_exists($sort['sort'], $filter_attributes))
                                    continue;
                                $attr = '';
                                $attributes = explode(',', strtolower($sort['attributes']));
                                foreach ($filter_attributes as $key => $attribute)
                                {
                                    $attribute = strtolower($attribute);
                                    if (in_array($attribute, $attributes))
                                    {
                                        $attr = $attribute;
                                        unset($filter_attributes[$key]);
                                        break;
                                    }
                                }
                                if ($attr)
                                    $filter_sorts[strtoupper($sort['sort'])] = $attr;
                            }
                        }
                    }
                    if (!empty($filter_sorts))
                    {
                        foreach ($filter_sorts as $name => $sort)
                        {
                            if ($name == "color" || $name == "Color" || $name == "COLOR")
                            {
                                $attribute_color = $sort;
                                break;
                            }
                        }
                    }
                    //filter attributes
                    $data[] = "Choies";
                    $data[] = "Choies " . $product['name'];
                    $data[] = "Choies";
                    $data[] = $link;
                    $data[] = $link . "?utm_source=polyvore&utm_medium=cpc&trackid=skinnyjeansABC123&keyword=" . $set_name;
                    $data[] = $imageURL;
                    $data[] = number_format($p_price, 2);
                    if ($p_price > $price)
                    {
                        $data[] = number_format($price, 2);
                    }
                    else
                    {
                        $data[] = "";
                    }
                    $data[] = "USD";
                    $data[] = "Choies " . $product['name'];
                    $data[] = $attribute_color ? $attribute_color : "as photo";
                    $data[] = $size;
                    $data[] = $tags;
                    $data[] = "Women";
                    $data[] = "clothing";
                    $str = implode("\t", $data);
                    fwrite($open, $str . PHP_EOL);
                }
            }
        }
        $re = fclose($open);
        echo "success";
        exit;
    }

    //  US UK ES DE FR CA
    //  新增 HK TW CH DK SE NO CL SG AR BE IE，使用相同字段; 其中CL使用ES产品信息，使用自己的货币; BE IE使用US产品信息,使用ES货币，其他都是使用US产品信息 自己的货币
    public function daochutxtforsize($country,$filename)
    {
        $country = strtoupper($country);
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $pla = DB::select('promotion')->from('core_pla')->where('type', '=', 1)->where('country', '=', $country)->execute('slave')->current();
        $local_directory = $this->path;

        $set_names = Kohana::config('googlefeed.set_name');
        $samll_set_names = Kohana::config('googlefeed.samll_set');
        $new_countrys =  array('HK', 'TW' , 'CH', 'DK', 'SE', 'NO', 'CL', 'SG', 'AR', 'BE' ,'IE');
        $use_US_info =  array("US","AU","UK",'HK',"CA", 'TW' , 'CH', 'DK', 'SE', 'NO', 'SG', 'AR', 'BE' ,'IE');
        //Itemlist
        if ($country == "DE") {
            $head_gooproductinfo = array('ID', 'item_group_id', 'Titel', 'Beschreibung ', 'Benutzerdefiniertes Label 0', 'Benutzerdefiniertes Label 1', 'Benutzerdefiniertes Label 2', 'Benutzerdefiniertes Label 3', 'Benutzerdefiniertes Label 4', 'Google Produktkategorie', 'Produkttyp', 'promotion_id', 'Link', 'Bildlink', 'Zustand', 'Verfügbarkeit', 'Preis', 'Marke', 'Geschlecht', 'Versand', 'Altersgruppe', 'Farbe', 'Größe', 'MPN');
        } elseif ($country == "ES") {
            $head_gooproductinfo = array('id', 'item_group_id', 'título', 'descripción', 'etiqueta personalizada 0', 'etiqueta personalizada 1', 'etiqueta personalizada 2', 'etiqueta personalizada 3', 'etiqueta personalizada 4', 'categoría en google product', 'categoría', 'promotion_id', 'enlace', 'enlace imagen', 'estado', 'disponibilidad', 'precio', 'marca', 'sexo', 'envío', 'edad', 'color', 'talla', 'mpn');
        } elseif ($country == "FR") {
            $head_gooproductinfo = array("identifiant", 'item_group_id', "titre", "description", "Étiquette personnalisée 0", "Étiquette personnalisée 1", "Étiquette personnalisée 2", "Étiquette personnalisée 3", "Étiquette personnalisée 4", "catégorie de produits Google", "catégorie", 'promotion_id', "lien", "lien image", "état", "disponibilité", "prix", "marque", "sexe", "livraison", "tranche d'âge", "couleur", "taille", "référence fabricant");
        } elseif ($country == "RU") {
            $head_gooproductinfo = array("id", "название", "описание", "custom_label_0", "custom_label_1", "custom_label_2", "custom_label_3", "custom_label_4", "категория продукта google", "тип товара", "ссылка", "ссылка на изображение", "состояние", "наличие", "Цена", "марка", "пол", "доставка", "возрастная группа", "цвет", "размер", "код производителя");
        } elseif ($country == "AU") {
            $head_gooproductinfo = array('id', 'item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        } elseif ($country == "UK") {
            $head_gooproductinfo = array('id', 'item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        } elseif (in_array($country,$new_countrys)) {
            $head_gooproductinfo = array('id', 'item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'age_group', 'color', 'size', 'mpn');
        } else{
            $head_gooproductinfo = array('id', 'item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        }


        $open = fopen($local_directory . $filename, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);

        /**用于取订单表order_items中订单创建时间离现在在时间了少于15天的数据，
         * 并根据产品编号订单，对每个产品的订单数据进行统计**/
        $time = strtotime('-2month');
        $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM orders_orderitem where created > ' . $time . ' group by product_id order by co desc  ')->execute('slave')->as_array();
        foreach ($attr as $v) {
            $count[$v['product_id']] = $v['co'];
        }


        $products = DB::query(DATABASE::SELECT, "select * from products_product  where visibility=1 and status=1 order by created DESC")->execute('slave')->as_array();

        //颜色数据 优先products_productfilter中的数据，没有则用产品表filter_attribute字段
        $filters = DB::query(DATABASE::SELECT,"SELECT p.product_id as id,p.options as color FROM `products_productfilter` p LEFT JOIN products_filter f on f.id=p.filter_id where f.name='COLOR' ORDER by p.product_id ")->execute('slave')->as_array();

        $elsefilters = DB::query(DATABASE::SELECT,"SELECT product_id from ( SELECT p.id as product_id,f.id as filter_procuct_id FROM products_product p LEFT JOIN products_productfilter f on f.product_id = p.id where p.visibility=1 and p.status=1 ) a where a.filter_procuct_id is null ")->execute('slave')->as_array();
        $colors = array();
        $else = array();
        foreach ($filters as $filter)
        {
            $colors[$filter['id']] = $filter['color'];
        }
        foreach ($elsefilters as $value)
        {
            $else[] = $value['product_id'];
        }

        $product_type = "";
        $check = Kohana::config('googlefeed.notsku');

        foreach ($products as $product) {
            $sizearr = unserialize($product['attributes']);
            if (empty($sizearr)) {
                continue;
            }
            foreach ($sizearr['Size'] as $ksize => $sizechima) {
                if ($product['set_id'] != 618 && $sizechima) {
                    if (!in_array($product['sku'], $check)) {
                        $data = array();
                        if(in_array($country,$use_US_info))
                        {
                            $k = 'US';
                        }elseif($country == 'CL'){
                            $k = 'ES';
                        }else{
                            $k = $country;
                        }
                        $product_instance_data = Product::instance($product['id'], strtolower($k))->get();
                        $product_instance = Product::instance($product['id'], strtolower($k));

                        $imageURL = Image::link($product_instance->cover_image(), 10);
                        $plink = $product_instance->permalink();
                        $set_name = Set::instance($product['set_id'])->get('name');
                        $product_catalog = $product_instance->default_catalog();
                        $cataname = Catalog::instance($product_catalog)->get("name");
                        if ($set_name) {
                            if ($country == 'US')
                            {
                                $product_type = $set_names["US"][$set_name];
                            }else{
                                if(array_key_exists($set_name,$samll_set_names))
                                {
                                    $product_type = $samll_set_names[$set_name];
                                }else{
                                    $product_type = $set_name;
                                }
                            }
                        }

                        //id
                        if(in_array($country,array('DE',"FR","ES",'HK','TW','CH','BE','IE','DK','SE','NO','CL','SG','AR'))){

                            $data[] = $product['sku'] . '-' . $sizechima . '-' . $country;
                        } else {
                            $data[] = $product['sku'] . '-' . $country . '-' . $sizechima;
                        }

                        //item_group_id
                        $data[] = $product['sku'];

                        //title
                        if (empty($product['pla_name'])) {
                            if ($country == "FR") {
                                $proname = stripslashes($product_instance_data['name']);
                                $data[] = "choies " . $proname;
                            } else {
                                if (in_array($country,$use_US_info)) {
                                    $data[] = $product_instance_data['name'];
                                } else {
                                    $str = "Choies " . $product_instance_data['name'];
                                    $str = str_replace(["\r","\n",'"'], '', $str);
                                    $data[] = $str;
                                }
                            }
                        } else {
                            $data[] = $product['pla_name'];
                        }

                        //description
                        if (in_array($country,$use_US_info)) {
                            $des = trim(strip_tags(str_replace(["\r","\n"], '', $product_instance_data['description'])));
                            $str = $product_instance_data['name'] . ' ' . $des;
                            $str = preg_replace ( "/\s(?=\s)/","\\1", $str );//字符串中连续多个的空格，只保留一个
                            $data[] = $str;
                        } else {
                            $brief = strip_tags($product_instance_data['brief']);
                            $brief = str_replace('&nbsp;', '', $brief);
                            $brief = trim(strip_tags(str_replace(["\r","\n"], '', $brief)));
                            $brief = preg_replace ( "/\s(?=\s)/","\\1", $brief );
                            //END小语种取details
                            if ($country == 'FR') {
                                $descrip = strip_tags($product_instance_data['description']);
                                $descrip = stripslashes($descrip);
                            } else {
                                $descrip = strip_tags($product_instance_data['description']);
                                $descrip = stripslashes($descrip);
                            }
                            $proname1 = str_replace(["\r","\n",'"'], '', $product_instance_data['name']);
                            $descrip = str_replace('&nbsp;', '', $descrip);
                            $descrip = trim(strip_tags(str_replace(["\r","\n"], '', $descrip)));

                            $descrip = str_replace("; ", ";", $descrip);
                            $descrip = preg_replace ( "/\s(?=\s)/","\\1", $descrip );
                            $data[] = $proname1 . ' ' . $descrip  . ' ' . $brief;

                        }

                        //custom_label_0 分类
                        $data[] = $set_name;

                        //custom_label_1 2个月内上架的新品sku，显示固定值New arrival,其他显示not new arrival
                        if($product['created']>strtotime('-2month'))
                        {
                            $data[] = 'New arrival';
                        }else{
                            $data[] = 'not new arrival';
                        }

                        $use_US_sellInfo =  array("US", "AU", 'HK', 'TW' , 'CH', 'DK', 'SE', 'NO', 'SG', 'AR', 'BE' ,'IE');
                        //custom_label_2 2个月销售≥60的sku显示固定值 top seller 其他为not top seller
                        //小语种，1个月内上架，并且在其国家销量≥1的sku显示固定值 New best,其他sku显示not new best，
                        if(in_array($country,$use_US_sellInfo) )
                        {
                            if(!empty($count) and array_key_exists($product['id'],$count) and $count[$product['id']]>=1)
                            {
                                $data[] = 'New best';
                            }
                            else
                            {
                                $data[] = 'not new best';
                            }

                        }else{
                            if($product['created']>strtotime('-1month'))
                            {
                                $total = DB::query('select',"SELECT count(i.id)  from orders_orderitem i LEFT JOIN orders_order o ON o.id=i.order_id where product_id='{$product['id']}' and o.shipping_country='$k'")->execute('slave');

                                if($total>=1)
                                {
                                    $data[] = 'New best';
                                }else{
                                    $data[] = 'not new best';
                                }
                            }else{
                                $data[] = 'not new best';
                            }
                        }

                        //custom_label_3
                        if(in_array($country,$use_US_sellInfo))
                        {
                            if(!empty($count) and array_key_exists($product['id'],$count) and $count[$product['id']]>=60)
                            {
                                $data[] = 'top seller';
                            }
                            else
                            {
                                $data[] = 'not top seller';
                            }
                        }else{
                            if($product['created']>strtotime('-2month'))
                            {
                                $total = DB::query('select',"SELECT count(i.id) total from orders_orderitem i LEFT JOIN orders_order o ON o.id=i.order_id where product_id='{$product['id']}' and o.shipping_country='$k'")->execute('slave');
                                if($total>=10)
                                {
                                    $data[] = 'top seller';
                                }else{
                                    $data[] = 'not top seller';
                                }
                            }else{
                                $data[] = 'not top seller';
                            }
                        }

                        //label4
//                        $currencies1 = array('DE' , "ES" ,"FR",'BE', 'IE');//使用EUR汇率的国家
//                        $currencies2 = array(
//                            'AU' => 'AUD',
//                            'UK' => 'GBP',
//                            'CA' => 'CAD',
//                            'HK' => 'HKD',
//                            'TW' => 'TWD',
//                            'CH' => 'CHF',
//                            'DK' => 'DKK',
//                            'SE' => 'SEK',
//                            'NO' => 'NOK',
//                            'CL' => 'CLP',
//                            'SG' => 'SGD',
//                            'AR' => 'AED',
//                        );
//                        if (array_key_exists($country ,$currencies1)) {
//                            $currency = Site::instance()->currencies("EUR");
//                        } elseif (array_key_exists($country,$currencies2)) {
//                            $currency = Site::instance()->currencies($currencies2[$country]);
//                        }
//                        $rate = (isset($currency) and isset($currency['rate']))?$currency['rate']:1;
                        $b = number_format($product_instance->price(), 2);
                        $data[] = $this->get_priceround($b);

                        $data[] = $product_type;
                        $data[] = $product_type;
                        //promotion_id
                        if (isset($pla) && !empty($pla)) {
                            $data[] = $pla['promotion'];
                        } else {
                            $data[] = '';
                        }


                        $new_country =  array(
                            'HK' => 'HKD',
                            'TW' => 'TWD',
                            'CH' => 'CHF',
                            'DK' => 'DKK',
                            'SE' => 'SEK',
                            'NO' => 'NOK',
                            'SG' => 'SGD',
                            'AR' => 'AED',
                        );
                        if ($country == "DE") {
                            $currency = Site::instance()->currencies("EUR");
                            $data[] = $plink . "?currency=eur";
                            $data[] = $imageURL;
                            $data[] = "neu";
                            $data[] = $product['status']  ? "auf Lager" : "ausverkauft";
                            $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                            $data[] = "Choies";
                            $data[] = "Damen";
                            $data[] = $country . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
                        } elseif ($country == "ES") {
                            $currency = Site::instance()->currencies("EUR");
                            $data[] = $plink . "?currency=eur";
                            $data[] = $imageURL;
                            $data[] = "nuevo";
                            $data[] = $product['status']  ? "en stock" : "fuera de stock";
                            $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                            $data[] = "Choies";
                            $data[] = "mujer";
                            $data[] = $country . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
                        } elseif ($country == "FR") {
                            $currency = Site::instance()->currencies("EUR");
                            $data[] = $plink . "?currency=eur";
                            $data[] = $imageURL;
                            $data[] = "neuf";
                            $data[] = $product['status']  ? "en stock" : "en rupture de stock";
                            $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                            $data[] = "Choies";
                            $data[] = "femme";
                            $data[] = $country . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
                        } elseif ($country == "RU") {

                            $currency = Site::instance()->currencies("RUB");
                            $data[] = $plink . "?currency=rub";
                            $data[] = $imageURL;
                            $data[] = "новый";
                            $data[] = $product['status']  ? "в наличии" : "нет в наличии";
                            $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " RUB";
                            $data[] = "Choies";
                            $data[] = "женский";
                            $data[] = $country . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " RUB";
                        } elseif ($country == "AU") {
                            $currency = Site::instance()->currencies("AUD");
                            $data[] = $plink . "?currency=aud";
                            $data[] = $imageURL;
                            $data[] = "new";
                            $data[] = $product['status'] ? "in stock" : "out of stock";
                            $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " AUD";
                            $data[] = "Choies";
                            $data[] = "female";
                            $data[] = $country . "::0:";

                        } elseif ($country == "UK") {
                            $currency = Site::instance()->currencies("GBP");
                            $data[] = $plink . "?currency=gbp";
                            $data[] = $imageURL;
                            $data[] = "new";
                            $data[] = $product['status']  ? "in stock" : "out of stock";
                            $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " GBP";
                            $data[] = "Choies";
                            $data[] = "female";
                            $data[] = "GB::0:";

                        } elseif ($country == "CA") {
                            $currency = Site::instance()->currencies("CAD");
                            $data[] = $plink . "?currency=cad";
                            $data[] = $imageURL;
                            $data[] = "new";
                            $data[] = $product['status']  ? "in stock" : "out of stock";
                            $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " CAD";
                            $data[] = "Choies";
                            $data[] = "female";
                            $data[] = $country . "::0:";

                        } elseif(array_key_exists($country,$new_country)){
                            $currency = Site::instance()->currencies($new_country[$country]);
                            $data[] = $plink;
                            $data[] = $imageURL;
                            $data[] = "new";
                            $data[] = $product['status']  ? "in stock" : "out of stock";
                            $data[] = number_format($product_instance->price() * $currency['rate'], 2) . $new_country[$country];
                            $data[] = "Choies";
                            $data[] = "female";

                        } elseif($country == 'BE' or $country == 'IE'){
                            $currency = Site::instance()->currencies("EUR");
                            $data[] = $plink;
                            $data[] = $imageURL;
                            $data[] = "new";
                            $data[] = $product['status']  ? "in stock" : "out of stock";
                            $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                            $data[] = "Choies";
                            $data[] = "female";

                        } elseif ($country == "CL") {
                            $currency = Site::instance()->currencies("CLP");
                            $data[] = $plink . "?currency=eur";
                            $data[] = $imageURL;
                            $data[] = "nuevo";
                            $data[] = $product['status'] ? "en stock" : "fuera de stock";
                            $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " CLP";
                            $data[] = "Choies";
                            $data[] = "mujer";
                        }else{
                            $data[] = $plink;
                            $data[] = $imageURL;
                            $data[] = "new";
                            $data[] = $product['status']  ? "in stock" : "out of stock";
                            $data[] = number_format($product_instance->price(), 2) . " USD";
                            $data[] = "Choies";
                            $data[] = "female";
                            $data[] = $country . "::0:";
                        }


                        if(array_key_exists($product['id'],$colors))
                        {
                            $color = $colors[$product['id']];
                        }elseif (in_array($product['id'],$else)){
                            $crr = explode(';', $product['filter_attributes']);
                            if (!empty($crr[0]))
                            {
                                $color = $crr[0];
                            } else {
                                $color = 'white';
                            }
                        }else{
                            $color = 'white';
                        }
                        $size = "see site";
                        $attributes = $product_instance_data["attributes"];
                        if (!empty($attributes['Size'])) {
                            $size = implode(",", $attributes['Size']);
                        }
                        if ($country == "EN") {
                            $data[] = "Adult";
                            $data[] = $color;
                            $data[] = $size;
                        } elseif ($country == "DE") {
                            $data[] = "Erwachsene";
                            $data[] = $color;
                            $data[] = $sizechima;
                        } elseif ($country == "ES") {
                            $data[] = "adultos";
                            $data[] = $color;
                            $data[] = $sizechima;
                        } elseif ($country == "FR") {
                            $data[] = "Adulte";
                            $data[] = $color;
                            $data[] = $sizechima;
                        } elseif ($country == "RU") {
                            $data[] = "взрослые";
                            $data[] = $color;
                            $data[] = $size;
                        } elseif(in_array($country,$use_US_info)) {
                            $data[] = "Adult";
                            $data[] = $color;
                            $data[] = $sizechima;
                        }elseif($country == 'CL'){
                            $data[] = "adultos";
                            $data[] = $color;
                            $data[] = $sizechima;
                        }else{
                            $data[] = "Adult";
                            $data[] = $color;
                            $data[] = $sizechima;
                        }
                        $data[] = "Choies";
                        $data = $this->check($data);
                        $str = implode("\t", $data);
                        fwrite($open, $str . PHP_EOL);
                    }  //end sku guolv
                }  //end set 618
            }  //end foreach
        }
        $re = fclose($open);
        echo "pla success";
    }

    public static function datafeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $set_names = array(
            "EN" => array("Shoes" => "Apparel & Accessories > Shoes",
                "Bralets" => "Apparel & Accessories > Clothing > Underwear & Socks > Bras",
                "Neck" => "Apparel & Accessories > Jewelry > Necklaces",
                "Hair Accessories" => "Apparel & Accessories > Clothing Accessories > Hair Accessories",
                "Bags" => "Apparel & Accessories > Handbags",
                "Mens T-Shirts & Tanks" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Hair Extensions" => "Apparel & Accessories > Costumes & Accessories > Wigs",
                "Purses" => "Apparel & Accessories > Handbags",
                "Camis & Tanks" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Crop Tops & Bralets" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Socks & Tights" => "Apparel & Accessories > Clothing > Underwear & Socks > Socks",
                "Blazers" => "Apparel & Accessories > Clothing > Suits",
                "Overalls" => "Apparel & Accessories > Clothing > Shirts & Tops > Sweaters & Cardigans",
                "Eye Masks" => "Health & Beauty > Personal Care > Sleeping Aids > Sleep Masks",
                "Coats & Jackets" => "Apparel & Accessories > Clothing > Outerwear > Coats & Jackets",
                "Mens Jumpers & Cardigans" => "Apparel & Accessories > Clothing > Shirts & Tops > Sweaters & Cardigans",
                "Jumpers & Pullovers" => "Apparel & Accessories > Clothing > Shirts & Tops > Sweaters & Cardigans",
                "Mens Hoodies & Sweatshirts" => "Apparel & Accessories > Clothing > Shirts & Tops > Sweatshirts",
                "Mens Coats & Jackets" => "Apparel & Accessories > Clothing > Outerwear > Coats & Jackets",
                "Platforms" => "Apparel & Accessories > Shoes",
                "Dresses" => "Apparel & Accessories > Clothing > Dresses",
                "Shorts" => "Apparel & Accessories > Clothing > Shorts",
                "Cardigans" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Skirts" => "Apparel & Accessories > Clothing > Skirts",
                "Pants" => "Apparel & Accessories > Clothing > Pants",
                "Blouses & Shirts" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "T-Shirts" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Knit Vests" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Bracelets & Bangles" => "Apparel & Accessories > Jewelry > Bracelets",
                "Rings" => "Apparel & Accessories > Jewelry > Rings",
                "Belts" => "Apparel & Accessories > Clothing Accessories > Belts",
                "Jeans" => "Apparel & Accessories > Clothing > Pants",
                "Hats & Caps" => "Apparel & Accessories > Clothing Accessories > Hats",
                "Sunglasses" => "Apparel & Accessories > Clothing Accessories > Sunglasses",
                "Earrings" => "Apparel & Accessories > Jewelry > Earrings",
                "Waistcoats" => "Apparel & Accessories > Clothing > Outerwear > Coats & Jackets > Overcoats",
                "Brooch" => "Apparel & Accessories > Jewelry > Brooches & Lapel Pins",
                "Scarves & Snoods" => "Apparel & Accessories > Clothing Accessories > Scarves & Shawls",
                "Rompers & Playsuits" => "Apparel & Accessories > Clothing > One-pieces > Jumpsuits & Rompers",
                "Wigs" => "Apparel & Accessories > Costumes & Accessories > Wigs",
                "Gloves" => "Apparel & Accessories > Clothing Accessories > Gloves & Mittens > Gloves",
                "Jumpsuits&Playsuits" => "Apparel & Accessories > Clothing > One-pieces > Jumpsuits & Rompers",
                "Boots" => "Apparel & Accessories > Shoes",
                "Sandals" => "Apparel & Accessories > Shoes",
                "Flats" => "Apparel & Accessories > Shoes",
                "Sneakers & Athletic Shoes" => "Apparel & Accessories > Shoes",
                "Heels" => "Apparel & Accessories > Shoes",
                "Wedges" => "Apparel & Accessories > Shoes",
                "Jumpsuits" => "Apparel & Accessories > Clothing > One-pieces > Jumpsuits",
                "Hoodies & Sweatshirts" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Watch" => "Apparel & Accessories > Jewelry > Watches",
                "Occasion Dresses" => "Apparel & Accessories > Clothing > Dresses > Day Dresses",
                "Swimwear" => "Apparel & Accessories > Clothing > Swimwear",
                "Jumpsuits & Playsuits" => "Apparel & Accessories > Clothing > One-pieces > Jumpsuits & Rompers",
                "Jumpsuits/Playsuits" => "Apparel & Accessories > Clothing > One-pieces > Jumpsuits & Rompers",
                "ELF SACK" => "Apparel & Accessories > Clothing > Skirts",
                "Nails" => "Hardware > Hardware Accessories > Nails",
                "AIMER" => "Apparel & Accessories > Clothing > Swimwear",
                "Corset" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Two-piece suits" => "Apparel & Accessories > Clothing > Suits",
                "Celebona" => "Apparel & Accessories > Clothing > Skirts",
                "Kimonos" => "Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos",
                "Sivanna" => "Health & Beauty > Personal Care > Cosmetics > Makeup",
                "LEMONPAIER" => "Apparel & Accessories > Clothing Accessories > Scarves & Shawls",
                "Sleepwear" => "Apparel & Accessories > Clothing > Sleepwear & Loungewear",
                "Leggings" => "Apparel & Accessories > Clothing > Pants",
                "Menswear" => "Apparel & Accessories > Clothing > Outerwear",
                "Scarves" => "Apparel & Accessories > Clothing Accessories > Scarves & Shawls",
                "Skirts" => "Apparel & Accessories > Clothing > Skirts",
                "Dress-tops" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Anklets" => "Apparel & Accessories > Jewelry > Anklets",
                "Body Harness" => "Apparel & Accessories > Jewelry > Body Jewelry",
                "Mens Shirts" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Mens Pants & Jeans" => "Apparel & Accessories > Clothing > Pants",
                "Skorts" => "Apparel & Accessories > Clothing > Skorts",
                "Mens Shorts" => "Apparel & Accessories > Clothing > Shorts",
                "Free Bracelets" => "Apparel & Accessories > Jewelry > Bracelets",
                "Bodysuits" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Three-piece suits" => "Apparel & Accessories > Clothing > Suits",
                "HOME DECOR" => "Home & Garden > Decor",
            ),
        );
        $filename = self::$export_path1."datafeed.csv";
        $outstream_itemlist = fopen($filename, 'w');
        $head_itemlist = array("SKU", "Name", "URL to product", "Price", "Retail Price", "product_type", "URL to image", "URL to image", "Commission", "Category", "SubCategory", "Description", "SearchTerms", "Status", "Your MerchantID", "Custom 1", "Custom 2", "Custom 3", "Custom 4", "Custom 5", "Manufacturer", "PartNumber", "MerchantCategory", "MerchantSubcategory", "Short Description", "ISBN", "UPC", "CrossSell", "MerchantGroup", "MerchantSubgroup", "CompatibleWith", "CompareTo", "QuantityDiscount", "Bestseller", "AddToCartURL", "ReviewsRSSURL", "Option1", "Option2", "Option3", "Option4", "Option5", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse");
        fputcsv($outstream_itemlist, $head_itemlist);
        $outstream = fopen($filename, 'a');
        $products = DB::query(DATABASE::SELECT, "select `id`,`sku`,`name`,`description` from products_product where  visibility=1 and status=1 order by created DESC")->execute('slave');
        foreach ($products as $product)
        {
            $data = array();
            $product_type = "";
            $product_instance = Product::instance($product['id']);
            $imageURL = Image::link($product_instance->cover_image(), 10);
            $link = $product_instance->permalink();
            $set_name = Set::instance($product_instance->get('set_id'))->get('name');
            $price = $product_instance->price();
            $default_catalog = $product_instance->default_catalog();
            $product_type = isset($set_names[$set_name]) ? $set_names[$set_name] : '';
            if ($default_catalog)
            {
                $catalog = Catalog::instance($default_catalog)->get('name');
            }
            else
            {
                $catalog = "";
            }
            $data[] = $product['sku'];
            $data[] = $product['name'];
            $data[] = $link;
            $data[] = number_format($price, 2);
            if ($product_instance->get('price') > $price)
            {
                $data[] = number_format($product_instance->get('price'), 2);
            }
            else
            {
                $data[] = number_format($price, 2);
            }
            $data[] = $product_type ? $product_type : "";
            $data[] = $imageURL;
            $data[] = $imageURL;
            $data[] = number_format(($price * 0.1), 2);
            $data[] = "8";
            $data[] = "59";
            $data[] = trim(strip_tags(str_replace(["\r","\n"], '', $product['description'])));
            $data[] = "LatestFashion, street fashion, woman fashion, shoes, clothing, clothes, apparels, jewelry, fashion accessory, new arrival, high heels, deal, discount, clearance, promotion, shopping, free shipping, bags, handbags, sunglasses, leggingsng";
            $data[] = "instock";
            $data[] = "41271";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "Choies";
            $data[] = "";
            $data[] = "Fashion";
            $data[] = "Clothing";
            $data[] = $catalog; //catalog
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "contact us";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            fputcsv($outstream, $data);
        }
        fclose($outstream_itemlist);
        echo "success";
    }

    public function get_priceround($b){
        $brr = array('0-9.9','10-19.9','20-29.9','30-39.9','40-59.9','60-99.9','100');
        if($b < 10){
            return $brr[0];
        }elseif(10 < $b and $b <20){
            return $brr[1];
        }elseif(20 < $b and $b <30){
            return  $brr[2];
        }elseif($b >30 and $b <40){
            return  $brr[3];
        }elseif(40 < $b and $b <60){
            return $brr[4];
        }elseif(60 < $b and $b <100){
            return  $brr[5];
        }elseif($b >=100){
            return $brr[6];
        }
    }

    public function check($data=array())
    {
        if(!empty($data))
        {
            foreach ($data as $key=>$value)
            {
                $data[$key] = str_replace(["\r","\n"], '', $value);
            }
        }
        return $data;
    }
}