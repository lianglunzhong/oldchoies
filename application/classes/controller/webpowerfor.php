<?php

defined('SYSPATH') or die('No direct script access.');


class Controller_Webpowerfor extends Controller_Webpage
{
    protected $path = '/home/choies/project/www.choies.com/googleproduct/';//feed文件路径
    //google product 定时导出
    public function action_mihqtgylls($lang='')
    {
        if(!$lang)
        {
            exit();
        }
        $lang = strtoupper($lang);
        ignore_user_abort(true);
        set_time_limit(0);
        $arr = DB::query(Database::SELECT, "SELECT * FROM core_pla where country = '$lang' and status =1  ")->execute('slave')->current();
        if ($arr)
        {
            $feed =  $arr['feed'];
            $file = ($lang == 'US') ? $feed : $feed . '.' .strtolower($lang);
            $filename = "choies_googleshopping_feed." . $file . ".txt";
            $fileurls = $this->path . $filename;

            if (file_exists($fileurls)) {
                @unlink($fileurls);
            }
            $this->daochutxtforsize($lang,$filename);
        }
        die;
    }

    public function daochutxtforsize($k,$filename)
    {
        $arr = DB::query(Database::SELECT, "SELECT * FROM core_pla where country= '$k' and status=1 and type=0")->execute('slave')->current();

        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
 


        $set_names = Kohana::config('googlefeed.set_name');
        //Itemlist
        if ($k == "DE")
        {
            $head_gooproductinfo = array('ID','item_group_id', 'Titel', 'Beschreibung ', 'Benutzerdefiniertes Label 0', 'Benutzerdefiniertes Label 1','Benutzerdefiniertes Label 2','Benutzerdefiniertes Label 3','Benutzerdefiniertes Label 4', 'Google Produktkategorie', 'Produkttyp','promotion_id', 'Link', 'Bildlink', 'Zustand', 'Verfügbarkeit', 'Preis', 'Marke', 'Geschlecht', 'Versand', 'Altersgruppe', 'Farbe', 'Größe', 'MPN');
        }
        elseif ($k == "ES")
        {
            $head_gooproductinfo = array('id','item_group_id', 'título', 'descripción', 'etiqueta personalizada 0', 'etiqueta personalizada 1','etiqueta personalizada 2','etiqueta personalizada 3','etiqueta personalizada 4', 'categoría en google product', 'categoría','promotion_id', 'enlace', 'enlace imagen', 'estado', 'disponibilidad', 'precio', 'marca', 'sexo', 'envío', 'edad', 'color', 'talla', 'mpn');
        }
        elseif ($k == "FR")
        {
            $head_gooproductinfo = array("identifiant",'item_group_id', "titre", "description", "Étiquette personnalisée 0", "Étiquette personnalisée 1","Étiquette personnalisée 2","Étiquette personnalisée 3","Étiquette personnalisée 4", "catégorie de produits Google", "catégorie",'promotion_id', "lien", "lien image", "état", "disponibilité", "prix", "marque", "sexe", "livraison", "tranche d'âge", "couleur", "taille", "référence fabricant");
        }
        elseif ($k == "RU")
        {
            $head_gooproductinfo = array("id", "название", "описание","custom_label_0", "custom_label_1", "custom_label_2", "custom_label_3", "custom_label_4", "категория продукта google", "тип товара", "ссылка", "ссылка на изображение", "состояние", "наличие", "Цена", "марка", "пол", "доставка", "возрастная группа", "цвет", "размер", "код производителя");
        }
        elseif ($k == "AU")
        {
            $head_gooproductinfo = array('id','item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        }
        elseif ($k == "UK")
        {
            $head_gooproductinfo = array('id','item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        }
        elseif ($k == "CA")
        {    
            $head_gooproductinfo = array('id','item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        }
        else
        {
            $head_gooproductinfo = array('id','item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        }


        $open = fopen($this->path . $filename, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);

        
        //todo 统计订单过去2个月的产品数据
        $time = strtotime('-2month');
        $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM orders_orderitem where created > '. $time . ' group by product_id order by co desc  ')->execute('slave')->as_array();
         foreach($attr as $v){
              $count[$v['product_id']]= $v['co'];
          }

        $products = DB::query(DATABASE::SELECT, "select * from products_product where  visibility=1 and status=1  order by created DESC")
            ->execute('slave')
            ->as_array();

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

        foreach ($products as $product)
        {
            $sizearr = unserialize($product['attributes']);
            if(empty($sizearr))
            {
                continue;
            }
            foreach($sizearr['Size'] as $ksize=>$sizechima)
            {
            if($product['set_id'] != 618)
            {
            if(!in_array($product['sku'],$check))
            {
            $data = array();
            if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK" && $k!="CA")
            {
                    
                $product_instance = Product::instance($product['id'], strtolower($k));
            }
            else
            {
                $product_instance = Product::instance($product['id']);

            }

            $imageURL = Image::link($product_instance->cover_image(), 10);
            $plink = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            $product_catalog = Product::instance($product['id'])->default_catalog();
            if ($set_name)
            {

                if ($k == "EN" || $k =="AU" || $k =="UK" || $k =="CA")
                {       
                    if(strpos($product['name'],'Kimono') != false)
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    }
                    else
                    {
                        if(isset($set_names["US"][$set_name]))
                        {
                            $product_type = $set_names["US"][$set_name];
                        }
                        else
                        {
                            $product_type = $set_name;
                        }   
                    }        
                }
                else
                {       
                    if(strpos($product['name'],'Kimono') != false)
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    }
                    else
                    {
                        if(isset($set_names[$k][$set_name]))
                        {
                            $product_type = $set_names[$k][$set_name];
                        }
                        else
                        {
                            $product_type = $set_name;
                        }
                    }         
                }
            }
            //id
            $size=strstr($sizechima,'/',true);
            if($size)
            {
                $sizechima=$size;
            }
            $data[] = $product['sku'].'-'.$sizechima.'-'.$arr['uid'];

            //item_group_id
            $data[] = $product['sku'];

            //title
            if(empty($product['pla_name']))
            {
                if($k == "FR")
                {
                    $proname = stripslashes($product['name']);
                    $data[] = "choies ".$proname; 
                }
                else
                {
                    if($k == 'US' || $k == 'UK' || $k == 'CA' || $k == 'CH' || $k == 'AU')
                    {
                        $data[] = $product['name']; 
                    }
                    else
                    {
                        $proname = str_replace('"','',$product['name']);
                        $data[] = "Choies ".$proname;        
                    }
                }
            }
            else
            {
                $data[] = $product['pla_name'];  
            }
           
            //description
            if ($k == "US" || $k == "EN" || $k =="AU" || $k =="UK" || $k =="CA")
            {
                $des = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
                $data[] = $product['name']. ' ' .$des ;
            }
            else
            {
                $detail = array();
                $filter_sorts = array();
                $small_filter = array();
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
                            {
                                $filter_sorts[strtoupper($sort['sort'])] = $attr;
//                                $sattr = DB::query(Database::SELECT, 'SELECT s.' . strtolower($k) . ' AS small FROM attributes_small s LEFT JOIN attributes a ON s.attribute_id = a.id WHERE a.name = "' . $attr . '"')->execute()->get('small');
//                                $small_filter[$attr] = $sattr;
                            }
                        }
                    }
                }
                //BEGIN小语种取details
                $sortArr_en = Kohana::config('sorts.en');
                $sortArr_small = Kohana::config('sorts.' . strtolower($k));
                if (!empty($filter_sorts))
                {
                    foreach ($filter_sorts as $name => $sort)
                    {
                        $en_name = strtolower($name);
                        if (in_array($en_name, $sortArr_en))
                        {
                            $small_key = array_keys($sortArr_en, $en_name);
                            $small_name = $sortArr_small[$small_key[0]];
                        }
                        else
                            $small_name = $name;
                        //$detail[] = ucfirst($small_filter[strtolower($sort)]);
                    }
                }
                $details = implode(" ", $detail);
                $details = str_replace("&nbsp;", "", $details);
                $details = $details ? strip_tags($details) : "default";
                $brief = strip_tags($product['brief']);
                $brief = str_replace('&nbsp;','',$brief);
                $brief = trim(strip_tags(str_replace(PHP_EOL, '', $brief)));
                    //END小语种取details
                if($k == 'FR'){
                  $descrip  = strip_tags($product['description']);
                  $descrip = stripslashes($descrip);
                }else{
                 $descrip  = strip_tags($product['description']); 
                 $descrip = stripslashes($descrip);
                }
                $proname1 = str_replace('"','',$product['name']);
                $descrip = str_replace('&nbsp;','',$descrip);
                $descrip = trim(strip_tags(str_replace(PHP_EOL, '', $descrip)));
                
                $descrip = str_replace("; ",";",$descrip); 

                $data[] = $proname1 . ' ' . $descrip . ' ' . $details . ' ' . $brief;
            }

                $custom_label = $arr['custom_label'];

                //custom_label_0 分类
                if(strpos($product['name'],'Kimono') != false)
                {
                    $str= 'Kimono';
                }
                else
                {
                    $str = $set_name;
                }
                $data[] = $str .'-'. $custom_label;

                //custom_label_1 2个月内上架的新品sku，显示固定值New arrival,其他显示not new arrival
                if($product['created']>strtotime('-2month'))
                {
                    $str = 'New arrival';
                }else{
                    $str = 'not new arrival';
                }
                $data[] = $str .'-'. $custom_label;

                //custom_label_2  1个月内上架，并且销量≥1的有销售的sku显示固定值 New best,其他sku显示not new best，
                if($product['created']>strtotime('-1month') and array_key_exists($product['id'],$count) and $count[$product['id']]>=1)
                {
                    $str = 'New best';
                }else{
                    $str = 'not new best';
                }
                $data[] = $str .'-'. $custom_label;

                //custom_label_3 2个月销售≥60的sku显示固定值 top seller 其他为not top seller
                if(!empty($count) and array_key_exists($product['id'],$count) and $count[$product['id']]>=60)
                {
                    $str = 'top seller';
                }
                else
                {
                    $str = 'not top seller';
                }
                $data[] = $str .'-'. $custom_label;

                //custom_label_4 价格范围
                if ($k == 'DE' || $k == "ES" || $k == "FR") {
                    $currency = Site::instance()->currencies("EUR");
                    $b = number_format($product_instance->price() * $currency['rate'], 2);
                    $str = $this->get_priceround($b);
                } elseif ($k == 'AU') {
                    $currency = Site::instance()->currencies("AUD");
                    $b = number_format($product_instance->price() * $currency['rate'], 2);
                    $str = $this->get_priceround($b);
                } elseif ($k == 'UK') {
                    $currency = Site::instance()->currencies("GBP");
                    $b = number_format($product_instance->price() * $currency['rate'], 2);
                    $str = $this->get_priceround($b);
                } elseif ($k == 'CA') {
                    $currency = Site::instance()->currencies("CAD");
                    $b = number_format($product_instance->price() * $currency['rate'], 2);
                    $str = $this->get_priceround($b);
                } else {
                    $b = number_format($product_instance->price(), 2);
                    $str = $this->get_priceround($b);
                }
                $data[] = $str .'-'. $custom_label;

            //google_product_category
            $data[] = $product_type;

            //product_type
            $data[] = $product_type;

            //promotion_id
            $data[]=$arr['promotion'];

            //link,image_link,condition,availability,price,brand,gender,tax
            //link
            $linkget = ($lang='')?'':'?lang='.$lang;

            if ($k == "DE")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neu";
                $data[] = $product['status'] == 1 ? "auf Lager" : "ausverkauft";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "Damen";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "ES")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "nuevo";
                $data[] = $product['status'] == 1 ? "en stock" : "fuera de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "mujer";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "FR")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neuf";
                $data[] = $product['status'] == 1 ? "en stock" : "en rupture de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "femme";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "RU")
            {
                $currency = Site::instance()->currencies("RUB");
                $data[] = $plink . "?currency=rub";
                $data[] = $imageURL;
                $data[] = "новый";
                $data[] = $product['status'] == 1 ? "в наличии" : "нет в наличии";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " RUB";
                $data[] = "Choies";
                $data[] = "женский";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " RUB";
            }
            elseif ($k == "AU")
            {           
                $currency = Site::instance()->currencies("AUD");
                $data[] = $plink . "?currency=aud";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " AUD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                //$data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " AUD";
            }
            elseif ($k == "UK")
            {
                $currency = Site::instance()->currencies("GBP");
                $data[] = $plink . "?currency=gbp";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " GBP";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = "GB::0:";
                //$data[] = "GB:::" . number_format($product['extra_fee'], 2) . " GBP";
            }
            elseif ($k == "CA")
            {
                $currency = Site::instance()->currencies("CAD");
                $data[] = $plink . "?currency=cad";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " CAD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                //$data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " CAD";
            }
            else
            {
                $data[] = $plink.$linkget;
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price(), 2) . " USD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
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
            $attributes = $product_instance->get("attributes");
            if (!empty($attributes['Size']))
            {
                $size = implode(",", $attributes['Size']);
            }            
            if ($k == "EN")
            {
                $data[] = "Adult";
                $data[] = $color;
                $data[] = $size;
            }
            elseif ($k == "DE")
            {
                $data[] = "Erwachsene";
                $data[] = $color;
                $data[] = $sizechima;
            }
            elseif ($k == "ES")
            {
                $data[] = "adultos";
                $data[] = $color;
                $data[] = $sizechima;
            }
            elseif ($k == "FR")
            {
                $data[] = "Adulte";
                $data[] = $color;
                $data[] = $sizechima;
            }
            elseif ($k == "RU")
            {
                $data[] = "взрослые";
                $data[] = $color;
                $data[] = $size;
            }
            else
            {
                $data[] = "Adult";
                $data[] = $color;
                $data[] = $sizechima;
            }
            $data[] = "Choies";
              //title、description默认内容写在前面或后面的判断
                $explode= explode('=',$arr['position']);
                $explode1=explode('-',$explode[0]); 
                $explode2=explode('-',$explode[1]); 
                $title=explode('++++',$arr['title']);
                $description=explode('++++',$arr['description']);
    
                if($explode1[0]){$data[2]=$title[0].' '.$data[2];}
                if($explode1[1]){$data[2].=' '.$title[1];}
                if($explode2[0]){$data[3]=$description[0].' '.$data[3];}
                if($explode2[1]){$data[3].=' '.$description[1];}
            //custom_label_0 1 2 3 4
                $color=$data[5];//color
                $catalog=$data[4];//分类
                $sell=$data[7];//爆款
                $price=$data[8];//价格
                $custom_label=$data[6];//自定义
             /*   if($arr[0]['custom_label_0']=='1'){
                    $data[4]=$color;//$data[4]对应custom_label_0
                }else if($arr[0]['custom_label_0']=='2'){
                    $data[4]=$catalog;
                }else if($arr[0]['custom_label_0']=='3'){
                    $data[4]=$price;
                }else if($arr[0]['custom_label_0']=='4'){
                    $data[4]=$sell;
                }else if($arr[0]['custom_label_0']=='5'){
                    $data[4]=$custom_label;
                }*/
                //custom_label_0 1 2 3 4 数据调换位置
               /* for($i=0;$i<5;$i++){
                    if($arr[0]["custom_label_{$i}"]=='1'){
                        $data[$i+4]=$color;
                    }else if($arr[0]["custom_label_{$i}"]=='2'){
                        $data[$i+4]=$catalog;
                    }else if($arr[0]["custom_label_{$i}"]=='3'){
                        $data[$i+4]=$price;
                    }else if($arr[0]["custom_label_{$i}"]=='4'){
                        $data[$i+4]=$sell;
                    }else if($arr[0]["custom_label_{$i}"]=='5'){
                        $data[$i+4]=$custom_label;
                    }

                }*/
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

    public function get_priceround($b){
        $brr = array('0-9.9','10-19.9','20-29.9','30-39.9','40-59.9','60-99.9','100');
        if($b <= 9.9){
            return $brr[0];
        }elseif(9.9 < $b and $b <=19.9){
            return $brr[1];
        }elseif(20 < $b and $b <=29.9){
            return  $brr[2];
        }elseif($b >30 and $b <=39.9){
            return  $brr[3];
        }elseif(40 < $b and $b <=59.9){
            return $brr[4];
        }elseif(60 < $b and $b <=99.9){
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