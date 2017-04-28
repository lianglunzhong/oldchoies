<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Product extends Controller_Admin_Site
{

    public function action_list()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }

        // 产品统计 for last week
        $last_week = strtotime('midnight') - 604800 + 86400;
        $dates = array();
        for ($i = 0; $i < 7; $i++)
        {
            $midnight = $last_week + $i * 86400;
            $dates[] = date('Y-m-d', $midnight);
        }

        $cache = Cache::instance('memcache');
        $key = "admin_products_statistics";
        if( ! ($products_statistics = $cache->get($key)))
        {
            $products_statistics = array(
                'today_display_count' => array(),
                'today_nosale_count' => array(),
                'today_invisible_count' => array(),
                'visible_sale_count' => array(),
                'today_orderitem_count'=> array()
            );

            for ($i = 0; $i < 7; $i++)
            {
                $midnight = $last_week + $i * 86400;
                $next_day = $midnight + 86400;

                $today_display_count = DB::query(Database::SELECT, "SELECT COUNT(id) AS count FROM `products_product`
                                            WHERE status=1 AND visibility=1 AND site_id =" . $this->site_id . " AND display_date >= " . $midnight . " AND display_date < " . $next_day)
                    ->execute('slave')->get('count');

                $today_nosale_count = DB::query(Database::SELECT, "SELECT COUNT(id) AS count FROM `products_product`
                                            WHERE status=0 AND site_id =" . $this->site_id . " AND updated >= " . $midnight . " AND updated < " . $next_day)
                    ->execute('slave')->get('count');

                $today_invisible_count = DB::query(Database::SELECT, "SELECT COUNT(id) AS count FROM `products_product`
                                            WHERE visibility=0 AND site_id =" . $this->site_id . " AND updated >= " . $midnight . " AND updated < " . $next_day)
                    ->execute('slave')->get('count');

                $visible_sale_count = DB::query(Database::SELECT, "SELECT COUNT(id) AS count FROM `products_product`
                                            WHERE status=1 AND visibility=1 AND site_id =" . $this->site_id . " AND updated < " . $next_day)
                    ->execute('slave')->get('count');

                $today_orderitem_count = DB::query(Database::SELECT, "SELECT IFNULL(sum(i.quantity),0) AS count FROM `orders_orderitem` i INNER JOIN `orders` o ON i.order_id=o.id
                                            WHERE o.payment_status='verify_pass' AND o.is_active=1 AND o.site_id =" . $this->site_id . "  AND o.created >= " . $midnight . " AND o.created < " . $next_day)
                ->execute('slave')->get('count');

                $products_statistics['today_display_count'][date('Y-m-d', $midnight)] = $today_display_count;
                $products_statistics['today_nosale_count'][date('Y-m-d', $midnight)] = $today_nosale_count;
                $products_statistics['today_invisible_count'][date('Y-m-d', $midnight)] = $today_invisible_count;
                $products_statistics['visible_sale_count'][date('Y-m-d', $midnight)] = $visible_sale_count;
                $products_statistics['today_orderitem_count'][date('Y-m-d', $midnight)] = $today_orderitem_count;
            }
            $cache->set($key, $products_statistics, 600);
        }

        $content = View::factory('admin/site/product_list')
//                        ->set('times', $times)
            ->set('languages', $languages)
            ->set('lang', $lang)
            ->set('dates', $dates)
            ->set('products_statistics', $products_statistics)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    //jdzs api
    public function action_jdzs()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $jdarr = array("99"=>"75061124","104"=>"75061124","414"=>"75061269","628"=>"75061266","45"=>"75061946","624"=>"75061946","117"=>"75061946","47"=>"75061946","627"=>"75061982","606"=>"75061946","230"=>"75062149","102"=>"75062147","245"=>"75062147","244"=>"75061247","618"=>"75061246","617"=>"75061245","618"=>"75061246","321"=>"75061243","620"=>"75061243","622"=>"75061243","616"=>"75061241","205"=>"75061240","377"=>"75061236","207"=>"75061236","209"=>"75061236","211"=>"75061236","504"=>"75061236","203"=>"75061236","204"=>"75061236","456"=>"75061236","51"=>"75061949","538"=>"75061949","106"=>"75061139","233"=>"75061139","49"=>"75061139","232"=>"75061139","629"=>"75062306","177"=>"75062306","54"=>"75062247","647"=>"75061517","67"=>"75061517","646"=>"75061517","645"=>"75061518","57"=>"75061518","55"=>"75061513","59"=>"75061510","58"=>"75061507","639"=>"75062007","63"=>"75062013","640"=>"75062019","62"=>"75062017","643"=>"75062177","644"=>"75061986","635"=>"75061045","151"=>"75061051","53"=>"75061051","636"=>"75061051","650"=>"75061052","150"=>"75061052");

        if($_POST){
            $SKUARR = Arr::get($_POST, 'SKUARR', '');
             $pro = explode("\n", $SKUARR);
        foreach($pro as $v){
         $id = Product::get_productId_by_sku($v);
         $product_instance = Product::instance($id);//
         $current_catalog = $product_instance->default_catalog();
         $cataname = Catalog::instance($current_catalog)->get('name');
         $cataname = "1x".$cataname;
         $cataid = $jdarr[$current_catalog];
         if(!isset($cataid)){
            message::set('存在JD没有的分类，请重试');
            Request::instance()->redirect('admin/site/product/list'); 
         }
         $des = $product_instance->get("description");
         $des =strip_tags($des);
         $netweight = $product_instance->get("weight");
         $netweight = intval($netweight);
         $price = $product_instance->price();
         $price = $price * 100;
         $product_name = $product_instance->get('name');
         $keywords  = explode(" ",$product_name);
         $cover = $product_instance->cover_image();
         $pic = Image::getjdpic($cover);

         if(empty($netweight)){
            $netweight = 0.2;
         }
         $netweight = round($netweight,2);
         $weight = $netweight + 0.05;
         $weight = round($weight,2);

        $sysParams["app_key"]="7D089C1025554F4776CF0A255ED2C6F1";
        $sysParams["access_token"]="ac49fb1b-dbf1-4630-a95d-fc3f765939ab";
        $sysParams["app_secret"]="4a17ed6d05f649c79da44e69165bf01e";
        $sysParams["method"]="jingdong.ept.warecenter.ware.add";
        $sysParams["v"]="2.0";
        $sysParams["timestamp"]=date("Y-m-d H:i:s");

        $bussinessParames["categoryId"]=$cataid;
        $bussinessParames["rfId"]=$product_instance->get("sku");
        $bussinessParames["itemNum"]=$product_instance->get("sku");
        $bussinessParames["brandId"]="59";
        $bussinessParames["deliveryDays"]="7";
        $bussinessParames["description"]=$des;
        $bussinessParames["keywords"]=$keywords[0].$keywords[1].$keywords[2];
        $bussinessParames["netWeight"]=$netweight;
        $bussinessParames["packInfo"]=$cataname;
        $bussinessParames["packHeight"]="10";
        $bussinessParames["packLong"]="30";
        $bussinessParames["packWide"]="25";
        $bussinessParames["stock"]="0";
        $bussinessParames["netWeight"]=$netweight;
        $bussinessParames["SupplyPrice"]=$price;
        $bussinessParames["title"]=$product_name;
        $bussinessParames["transportId"]="113";
        $bussinessParames["wareStatus"]="1";
        $bussinessParames["weight"]=$weight;
/*        echo '<pre>';
        print_r($bussinessParames);
        die;*/

      foreach($bussinessParames as $key => $value){
       // $bussinessParames[$key] = urlencode($value); 不是中文所以不需要转码
        $bussinessParames[$key] = $value;
       }   
   //     $apiParams["360buy_param_json"]= urldecode(json_encode($bussinessParames));
        $apiParams["360buy_param_json"]= json_encode($bussinessParames);
        $tmpApiParams=array_merge($sysParams, $apiParams);
        ksort($tmpApiParams);

         $stringToBeSigned = $sysParams["app_secret"];

         foreach ($tmpApiParams as $k => $v){
             $stringToBeSigned .= "$k$v";
         }
         unset($k, $v);

         $stringToBeSigned .= $sysParams["app_secret"];
        $sign=strtoupper(md5($stringToBeSigned));

        $sysParams["sign"]=$sign;
        $apiParams["imgByte"]=self::getbyte($pic);
    $requestUrl="https://api.jd.com/routerjson?".http_build_query($sysParams);
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $requestUrl );
    curl_setopt ( $ch, CURLOPT_FAILONERROR, false );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    //以post请求发送
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $apiParams );
    $reponse = curl_exec ( $ch );
    print $reponse;
    echo $v.'success<br>';
            }
        echo '<script>alert("操作成功")</script>';
         Request::instance()->redirect('admin/site/product/list');   
        }
    }

    public static function getbyte($pic)
    {
        $file = $pic;
        if (substr($file, 0, 1) == '@') {
            $file = substr($file, 1);
            $file = base64_encode(file_get_contents($file));
        }

        return $file;
    }

    public function action_presell()
    {
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=presell-product.csv');  
        echo "\xEF\xBB\xBF" . "sku,预售状态,预售到期时间,预售文案\n";  
 $result = DB::query(DATABASE::SELECT, "SELECT sku,presell,presell_message from products where presell>0")->execute()->as_array();
            foreach($result as $v){
                echo $v['sku'] . ',';
                echo $v['presell'] >0 ? '预售' . ',' : '非预售' . ',' ;
                echo date('Y-m-d H:i:s', $v['presell']) . ',';
                echo $v['presell_message'] . ',';
                echo "\n";

            }
    }


    public function action_add()
    {
        if ($_POST)
        {
            // set type adn set_id
            $session = Session::instance();
            $type = Arr::get($_POST, 'type', 0);
            $set_id = Arr::get($_POST, 'set_id', 0);

            $session->set('product_type', $type);
            $session->set('product_set_id', $set_id);

            //TODO
            switch ($type)
            {

                case 1:
                    //配置产品需设置过滤属性
                    $this->request->redirect('/admin/site/product/config_attributes');
                    break;

                case 2:
                    //组合产品不需设置过滤属性，跳过case1那一步
                    $this->request->redirect('/admin/site/product/add_package');
                    break;

                case 3:
                    //simple config product
                    $this->request->redirect('/admin/site/product/add_simple_config');
                    break;

                default:
                    //simple product
                    $this->request->redirect('/admin/site/product/add_simple');
                    break;
            }
        }

        //TODO 
        $site = Site::instance();
        $sets = ORM::factory('set')->where('site_id', '=', $site->get('id'))->find_all();
        $content = View::factory('admin/site/product_add')
            ->set('sets', $sets)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }


    #产品信息条件导出 2015-08-31 Ma/kai
    public function action_prolist_yy()
    {
        
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=presell-product.csv');  
        echo "\xEF\xBB\xBF" . "sku,name,price,msrp,sizes,link,color,style,description\n";
 
 $row1 = DB::query(Database::SELECT, 'select id,sku,name,description,price as msrp,attributes,link,style,filter_attributes from products where site_id=1 and visibility=1 and status=1 order by created DESC ')->execute('slave')->as_array();
 foreach($row1 as $row){
     
     if(isset($row['id']) && !empty($row['id'])){//
            //促销价格
            $price_price= Product::instance($row['id'])->price();
                #尺码
                
                if($row['attributes']){
                    #监控错误
                    try {
                        $size = unserialize($row['attributes']);
                        if(isset($size['Size'])){
                            $sizeNew = implode('|', $size['Size']);
                        }else{
                            $sizeNew = '';
                        }
                    }catch (Exception $e) {
                        $sizeNew = $row['attributes'];
                    }
                }else{
                    $sizeNew = '';
                }
                
                if(strpos('SILHOUETTE', $row['style'])){
                    $style1 = 'SILHOUETTE';
                }else if(strpos('SLEEVE LENGTH', $row['style'])){
                    $style1 = 'SLEEVE LENGTH';
                }else{
                    $style1 = 'NECKLINE';
                }
                if($row['link']){
                    $link = 'http://www.choies.com/product/' . $row['link'];
                }else{
                    $link = '';
                }
                $row['name'] == '' ? '' : $row['name'];
                $row['msrp'] == '' ? '' : $row['msrp'];
                $color_style = explode(';', $row['filter_attributes']);
                $description = strip_tags($row['description']);
                echo $row['sku'].',';

                echo $row['name'],',';
                
                echo $row['msrp'] . ',';
                echo $price_price . ',';
                echo $sizeNew . ',';
                //echo $row['images_url'] . ',';
                echo $link . ',';
                echo $color_style[0] . ',';
                echo $style1 . ',';
                echo $description, ',';
                echo "\n";
            }
            }
        
        

    }


    /*
    public function action_prolist_yy()
    {
        if(isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0)
        {
            $rela = array('csv','xlsx');
            $filename = $_FILES['excel_file']['name'];
            $info = pathinfo($filename);
            if(in_array($info['extension'], $rela))
            {
                #执行文件上传
                $filedir = str_replace('admin//', '', DOCROOT.'/uploads/1/userfiles/');//上传文件目录,DOCROOT地址为后台目录，故删除目录中admin
                $newName = $_FILES['excel_file']['name'];//文件重命名
                $filePath = $filedir . $newName;
                $upload = move_uploaded_file($_FILES['excel_file']['tmp_name'], $filePath);//移动文件至指定目录
                if($upload)
                {
                    $file_path = str_replace('admin//', '', DOCROOT.'/uploads/1/userfiles/'.$_FILES['excel_file']['name']);
                    if(file_exists($file_path))
                    {
                        #引入PHPExcel插件读取excel表格
                        require 'PHPExcel.php';
                        require 'PHPExcel/Reader/Excel2007.php';
                        $PHPReader = new PHPExcel_Reader_Excel2007();
                        $PHPExcel = $PHPReader->load($file_path);
                        $currentSheet = $PHPExcel->getSheet(0);
                        $allColumn = $currentSheet->getHighestColumn();
                        $allRow = $currentSheet->getHighestRow();
                        for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
                            for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                                $address = $currentColumn . $currentRow;
                                $arr[$currentRow][$currentColumn] = $currentSheet->getCell($address)->getValue();
                            }
                        }
                        set_time_limit(0);
                        unset($arr[1]);rsort($arr);
                        header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
                        header('Content-type:application/vnd.ms-excel');//输出的类型
                        header('Content-Disposition: attachment; filename="productlist.csv"'); //下载显示
                        echo iconv("UTF-8", "GBK//IGNORE",'name,desc,price,msrp,currency,sizes,category,images_url,gender,brand,product_url,ean,internal_id,fabric,color,pattern,style,occasion'."\r\n\r\n");
                        foreach ($arr as $k=>$v) 
                        {
                            if($k<800){#分段读取数组进行导出
                            $name = $v['A'];        $desc = $v['B'];        $price = $v['C'];   $msrp = $v['D'];    $currency = $v['E'];    $size = $v['F'];
                            $category = $v['G'];    $images_url = $v['H'];  $gender = $v['I'];  $brand = $v['J'];   $product_url = $v['K']; $ean = $v['L']; 
                            $internal_id = $v['M']; $fabric = $v['N'];      $color = $v['O'];   $pattern = $v['P'];  $style = $v['Q'];      $occasion = $v['R'];
                            $row = DB::query(Database::SELECT, 'select id,name,description,price as msrp,attributes,link,style,filter_attributes from products where sku = "'.$internal_id.'"')->execute()->current();
                            if(isset($row['id']) && !empty($row['id'])){
                                $price_row = DB::query(Database::SELECT, 'select price from spromotions where product_id = "'.$row['id'].'"')->execute()->current();
                                if(!isset($price_row['price']) || empty($price_row['price'])) {
                                    $price_price = '';
                                } else {
                                    $price_price = $price_row['price'];
                                }
                            } else {
                                $price_price = '';
                            }
                            
                            #尺码
                            if(!empty($row['attributes'])){
                                #监控错误
                                try {
                                    $size = unserialize($row['attributes']);
                                    if(isset($size['Size'])){
                                        $sizeNew = implode('|', $size['Size']);
                                    }else{
                                        $sizeNew = '';
                                    }
                                }catch (Exception $e) {
                                    $sizeNew = $row['attributes'];
                                }
                            }else{
                                $sizeNew = '';
                            }
                            if($images_url == ''){
                                #产品图片
                                $product_instance = Product::instance($row['id']);
                                $images_url = Image::link($product_instance->cover_image(), 9);
                            }
                            if(strpos('SILHOUETTE', $row['style'])){
                                $style1 = 'SILHOUETTE';
                            }else if(strpos('SLEEVE LENGTH', $row['style'])){
                                $style1 = 'SLEEVE LENGTH';
                            }else{
                                $style1 = 'NECKLINE';
                            }
                            if($row['link']){
                                $link = 'http://www.choies.com/product/' . $row['link'];
                            }else{
                                $link = '';
                            }
                            $row['name'] == '' ? '' : $row['name'];
                            $row['msrp'] == '' ? '' : $row['msrp'];
                            $color_style = explode(';', $row['filter_attributes']);
                            $description = '';
                            echo iconv("UTF-8", "GBK//IGNORE", ($row['name'].','.$description.','.$row['msrp'].','.$price_price.',,'.$sizeNew.','.$category.','.$images_url.',,,'.$link.',,'.$internal_id.',MATERIAL,'.$color_style[0].',PATTERN TYPE,'.$style1.',,')."\r\n");
                        }  
                        } 
                    }
                }
            }
        }else{
            Message::set('请选择文件', 'error');
            $this->request->redirect('/admin/site/product/list');
        }
    }*/


    public function action_add_simple()
    {
        if ($_POST)
        {
            $data = $_POST['product'];
            $data['site_id'] = $this->site_id;
            $product_id = Product::instance()->set_basic($data);
            if (FALSE !== $product_id)
            {
                //add images
                Product::instance()->add_images($product_id, $_POST);
                //add attributes
                Product::instance()->add_attributes($product_id, $_POST);
                //相关产品
                Product::instance()->add_related_products($product_id, $_POST);
                //catalogs
                $product_catalogs = Arr::get($_POST, 'product_catalogs', array());
                Product::instance()->set_catalogs($product_id, $product_catalogs, TRUE);

                Message::set('Product added successfully!');
                $this->request->redirect('/admin/site/product/edit/' . $product_id);
            }
            else
            {
                $this->request->redirect('/admin/site/product/add');
            }
        }

        $session = Session::instance();
        $type = $session->get('product_type');
        $set_id = $session->get('product_set_id');

        $set = ORM::factory('set', $set_id);
        $attributes = $set->attributes->find_all();

        $name_template = '<input type="checkbox" id="catalog_check_{id}" name="product_catalogs[]" value="{id}"/><label for="catalog_check_{id}">{name}</label>';
        $catalog_checkboxes_tree = Controller_Admin_Site_Catalog::get_left_tree($this->site_id, $name_template, $conditional_name_str = null, $lang = '', $on_menu = 1);

        $content = View::factory('admin/site/product_add_simple')
            ->set('type', $type)
            ->set('set_id', $set_id)
            ->set('attributes', $attributes)
            ->set('catalog_checkboxes_tree', $catalog_checkboxes_tree)
            ->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_add_simple_config()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        $unset = array(
            'name', 'brief', 'description', 'meta_title', 'meta_keywords', 'meta_description', 'keywords', ''
        );
        if ($_POST)
        {
            $data = Security::xss_clean($_POST['product']);
            $data['site_id'] = $this->site_id;

            $product_id = Product::instance()->set_basic($data);
            if (FALSE !== $product_id)
            {
                //add language data
                $update = array();
                foreach($unset as $u)
                {
                    if(isset($data[$u]))
                        $update[$u] = $data[$u];
                }
                $update['attributes'] = serialize($data['attributes']);

                //add images
                $result_images = Product::instance()->add_images($product_id, $_POST);
                $update['configs'] = $result_images;

                foreach ($languages as $l)
                {
                    if ($l === 'en')
                        continue;
                    DB::update('products_' . $l)->set($update)->where('id', '=', $product_id)->execute();
                }
                
                //相关产品
                Product::instance()->add_related_products($product_id, $_POST);
                //catalogs
                $product_catalogs = Arr::get($_POST, 'product_catalogs', array());
                Product::instance()->set_catalogs($product_id, $product_catalogs, TRUE);
                // add manage log
                Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '新品上架');

                Message::set('Product added successfully!');
                $this->request->redirect('/admin/site/product/edit/' . $product_id);
            }
            else
            {
                $this->request->redirect('/admin/site/product/add');
            }
        }

        $session = Session::instance();
        $type = $session->get('product_type');
        $set_id = $session->get('product_set_id');
        $name_template = '<input type="checkbox" id="catalog_check_{id}" name="product_catalogs[]" value="{id}"/><label for="catalog_check_{id}">{name}</label>';
        $catalog_checkboxes_tree = Controller_Admin_Site_Catalog::get_left_tree($this->site_id, $name_template, NULL, '', 1);

        $content = View::factory('admin/site/product_add_simple_config')
            ->set('type', $type)
            ->set('set_id', $set_id)
            ->set('catalog_checkboxes_tree', $catalog_checkboxes_tree)
            ->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_add_config()
    {
        if ($_POST)
        {
            $data = $_POST['product'];
            $data['configs']['configurable_attributes'] = explode(',', Arr::get($_POST['product'], 'configurable_attributes', '')); //TODO: 在这里再验证一遍attrs是否可过滤，是否属于当前set？
            if ($data['type'] != 1 OR !count($data['configs']))
            {
                message::set('请重新选择产品类型。', 'notice');
                $this->request->redirect('/admin/site/product/add');
            }
            $data['site_id'] = $this->site_id;

            $product_id = Product::instance()->set_basic($data);

            if (FALSE !== $product_id)
            {
                //add images
                Product::instance()->add_images($product_id, $_POST);
                //新建的关联产品：
                $message = Product::instance()->add_associated_products($product_id, $_POST);
                //通过产品列表勾选添加的关联产品：
                $associated_ids = Arr::get($_POST, 'associated_ids', '');
                $associated_ids = $associated_ids == '' ? array() : explode(',', $associated_ids);
                foreach ($associated_ids as $id)
                {
                    //TODO 是否需要再检查一遍每个简单产品是否符合属性过滤的条件
                    DB::insert('pgroups', array('group_id', 'product_id'))->values(array($product_id, $id))->execute();
                }
                $default_item = Arr::get($_POST, 'default_item', 0);
                if ($default_item AND array_search($default_item, $associated_ids) !== FALSE)
                {
                    $product = ORM::factory('product', $product_id);
                    $product_configs = $product->configs != '' ? unserialize($product->configs) : array();
                    $product_configs['default_item'] = $default_item;
                    $product->configs = serialize($product_configs);
                    $product->save();
                }
                //add attribute input values
                Product::instance()->add_attributes($product_id, $_POST);
                //相关产品
                Product::instance()->add_related_products($product_id, $_POST);
                //catalogs
                $product_catalogs = Arr::get($_POST, 'product_catalogs', array());
                Product::instance()->set_catalogs($product_id, $product_catalogs, TRUE);

                message::set('成功添加了配置产品。' . ($message != '' ? $message : ''), ($message != '' ? 'notice' : 'success'));
                $this->request->redirect('/admin/site/product/edit/' . $product_id);
            }
            else
            {
                $this->request->redirect('/admin/site/product/add');
            }
        }

        $session = Session::instance();
        $content_data['type'] = $session->get('product_type');
        $content_data['set_id'] = $session->get('product_set_id');
        $content_data['p_attrs'] = $session->get('product_p_attrs'); //TODO: 要不要再检查一遍attrs是否过滤属性
        if (!$content_data['type'] OR !$content_data['set_id'] OR $content_data['type'] != 1)
        {
            message::set('请先选择产品类型。', 'notice');
            $this->request->redirect('/admin/site/product/add');
        }
        if (!$content_data['p_attrs'] OR !count($content_data['p_attrs']))
        {
            message::set('请先选择过滤属性。', 'notice');
            $this->request->redirect('/admin/site/product/config_attributes');
        }

        $set = ORM::factory('set', $content_data['set_id']);
        $content_data['attributes'] = $set->attributes->find_all();

        $name_template = '<input type="checkbox" id="catalog_check_{id}" name="product_catalogs[]" value="{id}"/><label for="catalog_check_{id}">{name}</label>';
        $content_data['catalog_checkboxes_tree'] = Controller_Admin_Site_Catalog::get_left_tree($this->site_id, $name_template);

        $content = View::factory('admin/site/product_add_config', $content_data)->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_config_attributes()
    {
        if ($_POST)
        {
            $data['set_id'] = Arr::get($_POST, 'set_id', 0);
            $data['type'] = Arr::get($_POST, 'type', 0);

            $session = Session::instance();
            $p_attrs = Arr::get($_POST, 'p_attrs', NULL);
            if (is_array($p_attrs) AND count($p_attrs))
            {
                $session->set('product_p_attrs', $p_attrs);
                $this->request->redirect('/admin/site/product/add_config');
            }
            else
            {
                message::set('未选择过滤产品属性，不能添加这个类型的配置产品', 'notice');
                $this->request->redirect('/admin/site/product/config_attributes');
            }
        }

        $session = Session::instance();
        $type = $session->get('product_type');
        $set_id = $session->get('product_set_id');

        $set = ORM::factory('set', $set_id);
        $attributes = $set->attributes->where('scope', '=', 1)->and_where('type', 'in', DB::expr("('0','1')"))->find_all();
        if (!count($attributes) AND $type == 1)
        {
            message::set('该产品类型无过滤属性，不能添加这个类型的配置产品', 'notice');
            $this->request->redirect('/admin/site/product/add');
        }

        $content = View::factory('admin/site/product_config_attributes')
            ->set('type', $type)
            ->set('set_id', $set_id)
            ->set('attributes', $attributes)
            ->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_add_package()
    {
        if ($_POST)
        {
            $message = Product::instance()->package_rules_validation($_POST);
            if ($message !== TRUE)
            {
                Message::set($message, 'error');
                $this->request->redirect('/admin/site/product/add_package');
            }

            $data = $_POST['product'];
            $data['site_id'] = $this->site_id;
            $data['type'] = 2;
            $data['configs']['quantity'] = $_POST['packaged'];
            $product_id = Product::instance()->set_basic($data);
            if (FALSE !== $product_id)
            {
                //add images
                Product::instance()->add_images($product_id, $_POST);
                //packaged products
                Product::instance()->set_package($product_id, $_POST);
                //相关产品
                Product::instance()->add_related_products($product_id, $_POST);
                //catalogs
                $product_catalogs = Arr::get($_POST, 'product_catalogs', array());
                Product::instance()->set_catalogs($product_id, $product_catalogs, TRUE);

                Message::set('product_added');
                $this->request->redirect('/admin/site/product/edit/' . $product_id);
            }
            else
            {
                $this->request->redirect('/admin/site/product/add_package');
            }
        }

        $name_template = '<input type="checkbox" id="catalog_check_{id}" name="product_catalogs[]" value="{id}"/><label for="catalog_check_{id}">{name}</label>';
        $content_data['catalog_checkboxes_tree'] = Controller_Admin_Site_Catalog::get_left_tree($this->site_id, $name_template);

        $content = View::factory('admin/site/product_add_package', $content_data)
            ->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        if(!$lang)
        {
            $user_id = Session::instance()->get('user_id');
            $users = User::instance($user_id)->get();
            if($users['role_id'] == 8)
            {
                $this->request->redirect(URL::current(TRUE) . '?lang=' . $users['lang']);
            }
        }
        $id = $this->request->param('id');
        if (!($product = self::detail($id, $lang)))
        {
            message::set('请提供正确的产品ID！', 'notice');
            $this->request->redirect('/admin/site/product/list');
        }
        $product['images'] = Product::instance($id)->images();
        switch ($product['type'])
        {
            case 3:
                self::edit_simple_config($product);
                break;
            case 2:
                self::edit_package($product);
                break;
            case 1:
                self::edit_config($product);
                break;
            case 0:
            default:
                self::edit_simple($product);
        }
    }
    
    //同步brief--这个方法是单个同步
    public function action_sync_brief(){
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $product_id =$_GET['id'];
        $brief = DB::query(Database::SELECT, 'select brief from products where id='.$product_id)->execute()->get('brief');
        foreach($languages as $l){
            if($l === 'en')
                continue;
            DB::query(Database::UPDATE, "UPDATE products_$l SET brief = '$brief' WHERE id = " . $product_id)->execute();
        }
        $this->request->redirect('/admin/site/product/edit/' . $product_id);
    }
    //同步所有商品的brief和description和keywords
    public function action_all_brief(){
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        foreach($languages as $l){
            if($l === 'en')
                continue;
            DB::query(Database::UPDATE, "UPDATE products_$l t inner join products p on t.id=p.id SET t.brief = p.brief,t.description = p.description,t.keywords = p.keywords WHERE p.brief!=t.brief or t.description != p.description")->execute();
        }
        Message::set('同步小语种产品描述成功!');
        $this->request->redirect('/admin/site/product/list');
    }

    public function edit_package($original_product)
    {
        if ($_POST)
        {
            $message = Product::instance()->package_rules_validation($_POST);
            if ($message !== TRUE)
            {
                Message::set($message, 'error');
                $this->request->redirect('/admin/site/product/edit/' . $original_product['id']);
            }

            $data = $_POST['product'];
            $data['site_id'] = $this->site_id;
            $data['type'] = 2;
            $data['configs'] = $original_product['configs'];
            $data['configs']['quantity'] = $_POST['packaged'];
            $product_id = Product::instance()->set_basic($data, $original_product['id']);
            if (FALSE !== $product_id)
            {
                //images
                Product::instance()->edit_images($product_id, $_POST);
                //packaged products
                Product::instance()->set_package($product_id, $_POST);
                //相关产品
                Product::instance()->edit_related_products($original_product, Arr::get($_POST, 'product_ids', ''));
                //catalogs
                $product_catalogs = Arr::get($_POST, 'product_catalogs', array());
                Product::instance()->set_catalogs($product_id, $product_catalogs);

                Message::set('product_changed');
                $this->request->redirect('/admin/site/product/edit/' . $product_id);
            }
            else
            {
                $this->request->redirect('/admin/site/product/edit/' . $original_product['id']);
            }
        }

        $content_data['product'] = $original_product;

        $name_template = '<input type="checkbox" id="catalog_check_{id}" name="product_catalogs[]" value="{id}"/><label for="catalog_check_{id}">{name}</label>';
        $content_data['catalog_checkboxes_tree'] = Controller_Admin_Site_Catalog::get_left_tree($this->site_id, $name_template);

        $content_data['catalogs'] = DB::select('catalog_id')
            ->from('catalog_products')
            ->where('product_id', '=', $original_product['id'])
            ->execute('slave')
            ->as_array('catalog_id', 'catalog_id');

        $content = View::factory('admin/site/product_edit_package', $content_data)
            ->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function edit_config($original_product)
    {
        if ($_POST)
        {
            $data = $_POST['product'];
            $data['type'] = $original_product['type'];
            $data['site_id'] = $this->site_id;
            $data['set_id'] = $original_product['set_id'];
            $data['configs'] = $original_product['configs'];
            $product_id = Product::instance()->set_basic($data, $original_product['id']);

            if (FALSE !== $product_id)
            {

                Product::instance()->edit_images($product_id, $_POST);

                // add goods
                $message = Product::instance()->add_associated_products($product_id, $_POST);
                //通过产品列表勾选添加的关联产品：
                $associated_ids = Arr::get($_POST, 'associated_ids', '');
                $associated_ids = $associated_ids == '' ? array() : explode(',', $associated_ids);
                $original_ids = array_keys($original_product['associated_products']);
                $removed_associated = array_diff($original_ids, $associated_ids);
                if (count($removed_associated))
                {
                    //TODO
                    DB::query(4, 'DELETE FROM pgroups WHERE group_id = ' . $product_id . ' AND product_id IN (' . implode(',', $removed_associated) . ');')->execute();
                }
                $added_associated = array_diff($associated_ids, $original_ids);
                foreach ($added_associated as $id)
                {
                    //TODO 是否需要再检查一遍每个简单产品是否符合属性过滤的条件
                    DB::insert('pgroups', array('group_id', 'product_id'))->values(array($product_id, $id))->execute();
                }
                $default_item = Arr::get($_POST, 'default_item', '');
                if ($default_item > 0)
                {
                    if (array_search($default_item, $associated_ids) === FALSE)
                    {
                        $default_item = 0;
                    }
                    if (!isset($original_product['configs']['default_item']) OR $original_product['configs']['default_item'] !== $default_item)
                    {
                        $product = ORM::factory('product', $product_id);
                        $product_configs = $product->configs != '' ? unserialize($product->configs) : array();
                        $product_configs['default_item'] = $default_item;
                        $product->configs = serialize($product_configs);
                        $product->save();
                    }
                }
                // add options relationships
                Product::instance()->edit_attributes($original_product, $_POST);
                //相关产品
                Product::instance()->edit_related_products($original_product, Arr::get($_POST, 'product_ids', ''));
                //catalogs
                $product_catalogs = Arr::get($_POST, 'product_catalogs', array());
                Product::instance()->set_catalogs($product_id, $product_catalogs);
                //edit associated
                if (Arr::get($_POST, 'for_all', '') == 1)
                {
                    foreach ($associated_ids as $id)
                    {
                        //婚纱站修改 大码产品在原价基础上加$9.99
                        if (Site::instance()->get('id') == '4')
                        {
                            $product = DB::select('option_id')
                                ->from('product_options')
                                ->where('product_id', '=', $id)
                                ->execute('slave')
                                ->as_array();

                            $big_size = array('1070', '1071', '1072', '1073', '1074', '1075');  //需要加收钱的大码属性id
                            foreach ($product as $value)
                            {
                                $option_arr[] = $value['option_id'];
                            }
                            if (array_intersect($big_size, $option_arr))
                            {
                                $associated_data['price'] = $data['price'] + 9.99;
                            }
                            else
                            {
                                $associated_data['price'] = $data['price'];
                            }
                            $associated_data['name'] = $data['name'];  //婚纱站 支持对产品名称的修改 并同步到相关的简单产品
                        }
                        else
                        {
                            $associated_data['price'] = $data['price'];
                        }
                        $associated_data['market_price'] = $data['market_price'];
                        $associated_data['cost'] = $data['cost'];
                        $associated_data['weight'] = $data['weight'];
                        ORM::factory('product', $id)
                            ->values($associated_data)
                            ->save();
                    }
                }
                message::set('成功修改了配置产品。' . ($message != '' ? $message : ''), ($message != '' ? 'notice' : 'success'));
                $this->request->redirect('/admin/site/product/edit/' . $product_id);
            }
            else
            {
                $this->request->redirect('/admin/site/product/edit/' . $original_product['id']);
            }
        }

        //选择最大的SKU编号，为自动编号准备
        $associated_skus = ORM::factory("product")
            ->where("sku", "like", $original_product['sku'] . "%")
            ->order_by("sku", "DESC")
            ->find_all();
        foreach ($associated_skus as $associated_sku)
        {
            //echo $associated_sku->sku;
            $associated_sku = explode('-', $associated_sku->sku);
            if (is_numeric($associated_sku[count($associated_sku) - 1]))
                $number[] = $associated_sku[count($associated_sku) - 1];
        }
        if (isset($number))
        {
            rsort($number);
            $max_associated_sku = $number[0];
        }
        else
            $max_associated_sku = 0;
        $content_data['max_associated_sku'] = $max_associated_sku;
        $content_data['product'] = $original_product;

        $name_template = '<input type="checkbox" id="catalog_check_{id}" name="product_catalogs[]" value="{id}"/><label for="catalog_check_{id}">{name}</label>';
        $content_data['catalog_checkboxes_tree'] = Controller_Admin_Site_Catalog::get_left_tree($this->site_id, $name_template);

        $content_data['catalogs'] = DB::select('catalog_id')
            ->from('catalog_products')
            ->where('product_id', '=', $original_product['id'])
            ->execute('slave')
            ->as_array('catalog_id', 'catalog_id');

        $content = View::factory('admin/site/product_edit_config', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function edit_simple($original_product)
    {
        if ($_POST)
        {
            $data = $_POST['product'];
            $data['type'] = $original_product['type'];
            $data['site_id'] = $this->site_id;
            $data['set_id'] = $original_product['set_id'];
            $data['configs'] = $original_product['configs'];

            $product_id = Product::instance()->set_basic($data, $original_product['id']);

            if ($original_product['visibility'] != $data['visibility'] AND $data['visibility'] == 1)
            {
                DB::update('products')->set(array('display_date' => time()))->where('id', '=', $product_id)->execute();
            }

            if (FALSE !== $product_id)
            {
                //处理删除的图片
                Product::instance()->edit_images($product_id, $_POST);
                // add options relationships
                Product::instance()->edit_attributes($original_product, $_POST);
                //相关产品
                Product::instance()->edit_related_products($original_product, Arr::get($_POST, 'product_ids', ''));
                //catalogs
                $product_catalogs = Arr::get($_POST, 'product_catalogs', array());
                Product::instance()->set_catalogs($product_id, $product_catalogs);

                // add manage log
                if ($original_product['status'] != $data['status'])
                {
                    if ($data['status'] == 1)
                    {
                        Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '产品上架');
                    }
                    else
                    {
                        Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '产品下架');
                    }
                }

                if ($original_product['visibility'] != $data['visibility'])
                {
                    if ($data['visibility'] == 1)
                    {
                        Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '产品显示');
                    }
                    else
                    {
                        Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '产品隐藏');
                    }
                }

                if ($original_product['price'] != $data['price'])
                {
                    Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '价格修改:' . $original_product['price'] . ' to ' . $data['price']);
                }

                //celebrity images
                if (isset($_POST['image_src1']) OR isset($_POST['images_removed1']) OR isset($_POST['images_removed2']))
                {
                    require 'inc_config.php';
                    $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
                    $images_removed = Arr::get($_POST, 'images_removed1', '');
                    $imagesRemove = explode(',', $images_removed);
                    $image_src = Arr::get($_POST, 'image_src1', '');
                    $imagesRemove2 = explode(',', $_POST['images_removed2']);
                    foreach ($imagesRemove2 as $image)
                    {
                        $image_src = str_replace($image, '', $image_src);
                        if ($image && file_exists($dir . $image))
                        {
                            unlink($dir . $image);
                            DB::delete('site_images')->where('filename', '=', $image)->execute();
                        }
                        DB::delete('celebrity_images')->where('image', '=', $image)->execute();
                    }

                    foreach ($imagesRemove as $image)
                    {
                        $image_src = str_replace($image, '', $image_src);
                        if ($image && file_exists($dir . $image))
                        {
                            unlink($dir . $image);
                            DB::delete('site_images')->where('filename', '=', $image)->execute();
                        }
                    }
                    $imageArr = explode(',', $image_src);
                    $c_images = array(
                        'product_id' => $product_id,
                        'image' => '',
                        'position' => 0,
                        'site_id' => $this->site_id,
                        'admin' => Session::instance()->get('user_id'),
                        'created' => time()
                    );
                    $positions = Arr::get($_POST, 'position', array());
                    if (!empty($imageArr))
                    {
                        foreach ($imageArr as $key => $image)
                        {
                            if ($image)
                            {
                                $c_images['image'] = $image;
                                DB::insert('celebrity_images', array_keys($c_images))->values($c_images)->execute();
                            }
                            DB::update('products')->set(array('has_pick' => 1))->where('id', '=', $product_id)->execute();
                        }
                    }

                    if (!empty($positions))
                    {
                        foreach ($positions as $key => $image)
                        {
                            DB::update('celebrity_images')->set(array('position' => $key))->where('image', '=', $image)->execute();
                        }
                    }

                    $c_count = DB::query(Database::SELECT, 'SELECT COUNT(id) AS count FROM celebrity_images WHERE product_id=' . $product_id)->execute('slave')->get('count');
                    if (!$c_count)
                    {
                        DB::update('products')->set(array('has_pick' => 0))->where('id', '=', $product_id)->execute();
                    }
                }

                message::set('修改产品成功。');
                $this->request->redirect('/admin/site/product/edit/' . $product_id);
            }
            else
            {
                $this->request->redirect('/admin/site/product/edit/' . $original_product['id']);
            }
        }

        $name_template = '<input type="checkbox" id="catalog_check_{id}" name="product_catalogs[]" value="{id}"/><label for="catalog_check_{id}">{name}</label>';
        $content_data['catalog_checkboxes_tree'] = Controller_Admin_Site_Catalog::get_left_tree($this->site_id, $name_template);

        $content_data['celebrity_images'] = DB::select()->from('celebrity_images')->where('product_id', '=', $original_product['id'])->order_by('position')->execute('slave')->as_array();

        $content_data['catalogs'] = DB::select('catalog_id')
            ->from('catalog_products')
            ->where('product_id', '=', $original_product['id'])
            ->execute('slave')
            ->as_array('catalog_id', 'catalog_id');

        $content_data['product'] = $original_product;
        $content = View::factory('admin/site/product_edit_simple', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function edit_simple_config($original_product)
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        if ($_POST)
        {  
            $data = $_POST['product'];
            $data['type'] = $original_product['type'];
            $data['site_id'] = $this->site_id;
            $data['set_id'] = $original_product['set_id'];
            $data['configs'] = $original_product['configs'];
            $data['presell'] = $data['presell'] ? strtotime($data['presell']) : 0;
            if(isset($data['attributes']['Size']))
            {
                if($data['set_id'] == 2)
                {
                    $attributes = array();
                    $sortArr = array('34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48');
                    foreach($data['attributes']['Size'] as $key => $s)
                    {
                        $eur = substr($s, strpos($s, 'EUR') + 3, 2);
                        $key1 = array_search($eur, $sortArr) - 1;
                        $attributes[$key1] = $s;
                    }
                    ksort($attributes);
                    if(!empty($attributes))
                        $data['attributes']['Size'] = $attributes;
                }
                else
                {
                    $attributes = array();
                    $sortArr = array('XXXS', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '2XL', 'XXXL', '3XL', 'XXXXL', '4XL', 'XXXXXL', '5XL');
                    foreach($sortArr as $s)
                    {
                        if(in_array($s, $data['attributes']['Size']))
                        {
                            $attributes[] = $s;
                        }
                    }
                    if(!empty($attributes))
                        $data['attributes']['Size'] = $attributes;
                }
            }
            if($lang)
            {
                $smallkeys = array(
                        'name', 'brief', 'description', 'meta_title', 'meta_keywords', 'meta_description', 'keywords', 'presell_message','extra_fee'
                    );
                $data1 = array();
                foreach($smallkeys as $k)
                {
                    $data1[$k] = $data[$k];
                }
                $result = DB::update('products_' . $lang)->set($data1)->where('id', '=', $original_product['id'])->execute();
                $product_id = $original_product['id'];
            }
            else
            {
                $product_id = Product::instance($original_product['id'])->set_basic($data, $original_product['id']);
            }

            //if no_limit_stock == 1 update items
            if($data['no_limit_stock'] == 1)
            {
                DB::query(Database::UPDATE, 'UPDATE products SET items = attributes WHERE id = ' . $product_id)->execute();
            }

            $small_update = array();

            $small_update['visibility'] = $data['visibility'];
            $small_update['status'] = $data['status'];
            $small_update['attributes'] = serialize($data['attributes']);
            if ($original_product['visibility'] != $data['visibility'] AND $data['visibility'] == 1)
            {
                $update = array('display_date' => time());
                DB::update('products')->set($update)->where('id', '=', $product_id)->execute();
                $small_update = array_merge($small_update, $update);
            }

            $need_catalog = 0;

            if (FALSE !== $product_id)
            {
                //处理删除的图片
                $return_configs = Product::instance()->edit_images($product_id, $_POST);
                $small_update['configs'] = $return_configs;

                $images = Product::instance($product_id)->images();
                if(!empty($images))
                {
                    $this->add_thumb($images);
                }

                //相关产品
                Product::instance()->edit_related_products($original_product, Arr::get($_POST, 'product_ids', ''));
                //catalogs
                $product_catalogs = Arr::get($_POST, 'product_catalogs', array());
                $catalog_no_menue = DB::query(Database::SELECT, 'SELECT P.catalog_id 
                    FROM catalog_products P LEFT JOIN catalogs C ON P.catalog_id = C.id 
                    WHERE P.product_id = ' . $product_id . ' AND C.on_menu = 0 AND C.parent_id = 0')
                    ->execute('slave')->as_array();
                foreach($catalog_no_menue as $c)
                {
                    if(!in_array($c['catalog_id'], $product_catalogs))
                    {
                        $product_catalogs[] = $c['catalog_id'];
                    }
                }
                Product::instance()->set_catalogs($product_id, $product_catalogs);
                // add manage log
                if ($original_product['status'] != $data['status'])
                {
                    if ($data['status'] == 1)
                    {
                        Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '产品上架');
                        //上架产品，修改elastic catalog
                        $need_catalog = 1;
                    }
                    else
                    {
                        Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '产品下架');
                    }
                }

                if ($original_product['visibility'] != $data['visibility'])
                {
                    if ($data['visibility'] == 1)
                    {
                        Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '产品显示');
                        //显示产品，修改elastic catalog
                        $need_catalog = 1;
                    }
                    else
                    {
                        Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '产品隐藏');
                    }
                }

                if ($original_product['price'] != $data['price'])
                {
                    Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '价格修改:' . $original_product['price'] . ' to ' . $data['price']);
                    //产品操作日志 zpz 20160125
                    operlog::add($product_id,'price_update',$data['price'],Session::instance()->get('user_id'));
                }

                //celebrity images
                if (isset($_POST['image_src1']) OR isset($_POST['images_removed1']) OR isset($_POST['images_removed2']))
                {
                    require 'inc_config.php';
                    $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
                    $images_removed = Arr::get($_POST, 'images_removed1', '');
                    $imagesRemove = explode(',', $images_removed);
                    $image_src = Arr::get($_POST, 'image_src1', '');
                    $imagesRemove2 = explode(',', $_POST['images_removed2']);
                    $type = Arr::get($_POST, 'type', array());
                    $linksku = Arr::get($_POST, 'linksku', array());
                    $celebrity_ids = Arr::get($_POST, 'celebrity_ids', array());

                    foreach ($imagesRemove2 as $image)
                    {
                        $image_src = str_replace($image, '', $image_src);
                        if ($image && file_exists($dir . $image))
                        {
                            unlink($dir . $image);
                            DB::delete('site_images')->where('filename', '=', $image)->execute();
                        }
                        DB::delete('celebrity_images')->where('image', '=', $image)->execute();
                    }

                    foreach ($imagesRemove as $image)
                    {
                        $image_src = str_replace($image, '', $image_src);
                        if ($image && file_exists($dir . $image))
                        {
                            unlink($dir . $image);
                            DB::delete('site_images')->where('filename', '=', $image)->execute();
                        }
                    }
                    $imageArr = explode(',', $image_src);
                    $c_images = array(
                        'product_id' => $product_id,
                        'image' => '',
                        'position' => 0,
                        'site_id' => $this->site_id,
                        'admin' => Session::instance()->get('user_id'),
                        'created' => time()
                    );
                    $positions = Arr::get($_POST, 'position', array());
                    if (!empty($imageArr))
                    {
                        foreach ($imageArr as $key => $image)
                        {
                            if ($image)
                            {
                                $c_images['type'] = $type[$image];
                                $c_images['image'] = $image;
                                $c_images['link_sku'] = $linksku[$image];
                                DB::insert('celebrity_images', array_keys($c_images))->values($c_images)->execute();
                            }
                            $update = array('has_pick' => 1,'has_link'=>1);
                            DB::update('products')->set($update)->where('id', '=', $product_id)->execute();
                            $small_update = array_merge($small_update, $update);
                        }
                    }

                    if (!empty($positions))
                    {
                        foreach ($positions as $key => $image)
                        {
                            $tmp_celebrits_id=empty($celebrity_ids[$image])?0:$celebrity_ids[$image];

                            DB::update('celebrity_images')->set(array('position' => $key,'type'=>$type[$image],'link_sku'=>$linksku[$image],'celebrits_id'=>$tmp_celebrits_id,))->where('image', '=', $image)->execute();
                        }
                    }

                    $c_count = DB::query(Database::SELECT, 'SELECT COUNT(id) AS count FROM celebrity_images WHERE product_id=' . $product_id.' and type in (1,3)')->execute()->get('count');
                    if (!$c_count)
                    {
                        $update = array('has_pick' => 0);
                        DB::update('products')->set($update)->where('id', '=', $product_id)->execute();
                        $small_update = array_merge($small_update, $update);
                    }
                    $cl_count = DB::query(Database::SELECT, 'SELECT COUNT(id) AS count FROM celebrity_images WHERE product_id='.$product_id.' and type in (2,3)')->execute()->get('count');
                    if (!$cl_count){
                        $update = array('has_link'=>0);
                        DB::update('products')->set($update)->where('id', '=', $product_id)->execute();
                        $small_update = array_merge($small_update, $update);
                    }
                }

                //product sorts edit
                $filter_attributes = Arr::get($_POST, 'filter_attributes', '');
                $remove_attributes = Arr::get($_POST, 'remove_attributes', '');
                $filter_attr = explode(';', $filter_attributes);
                foreach ($filter_attr as $key => $filter)
                {
                    $filter_attr[$key] = strtolower($filter);
                }
                $reomve_attr = explode(';', $remove_attributes);
                foreach ($reomve_attr as $val)
                {
                    $has = array();
                    if ($val)
                    {
                        $has = array_keys($filter_attr, strtolower($val));
                        if (!empty($has))
                            unset($filter_attr[$has[0]]);
                    }
                }
                $filter_attributes = implode(';', $filter_attr);
                $update = array('filter_attributes' => $filter_attributes);
                $result = DB::update('products')->set($update)->where('id', '=', $product_id)->execute();
                /**
                *添加产品操作日志
                *zpz
                *20160125
                */
                if (strtolower($original_product['filter_attributes']) != $filter_attributes){
                    operlog::add($product_id,'filter_attr_update',$filter_attributes,Session::instance()->get('user_id', 0));
                }
                //操作日志end
                $small_update = array_merge($small_update, $update);
                if($result)
                {
                    $update = array('oid' => 0);
                    DB::update('products')->set($update)->where('id', '=', $product_id)->execute();
                    $small_update = array_merge($small_update, $update);
                }
                if(!empty($small_update))
                {
                    foreach ($languages as $l)
                    {
                        if ($l === 'en')
                            continue;
                        DB::update('products_' . $l)->set($small_update)->where('id', '=', $product_id)->execute();
                    }
                }
                if($data['no_limit_stock'] == 0)
                {
                    $stocks = Arr::get($_POST, 'stocks', array());
                    foreach ($stocks as $attr => $stock)
                    {
                        if ($stock !== '')
                        {
                            $has = DB::select('id')->from('products_stocks')->where('product_id', '=', $product_id)->where('attributes', '=', $attr)->where('site_id', '=', $this->site_id)->execute()->get('id');
                            if ($has)
                                DB::update('products_stocks')->set(array('stocks' => $stock))->where('id', '=', $has)->execute();
                            else
                            {
                                $array = array(
                                    'product_id' => $product_id,
                                    'attributes' => $attr,
                                    'stocks' => $stock,
                                    'site_id' => $this->site_id
                                );
                                DB::insert('products_stocks', array_keys($array))->values($array)->execute();
                            }
                            $item_stocks = array();
                            $result = DB::select('attributes', 'stocks')->from('products_stocks')->where('product_id', '=', $product_id)->execute();
                            foreach($result as $r)
                            {
                                $item_stocks[$r['attributes']] = $r['stocks'];
                            }
                            DB::update('products')->set(array('items' => serialize($item_stocks)))->where('id', '=', $product_id)->execute();
                        }
                    }
                }

                //update memecache
                $cache = Cache::instance('memcache');
                foreach ($languages as $l)
                {
                    if ($l === 'en')
                    {
                        $key = "/product1/".$product_id;
                        $lang_table = '';
                    }
                    else
                    {
                        $key = "/product1/".$product_id.$l;
                        $lang_table = '_' . $l;
                    }
                    $data = array( );
                    $result = DB::select()->from('products' . $lang_table)
                            ->where('id', '=', $product_id)
                            ->execute()->current();

                    if($result['id'] !== NULL)
                    {
                        $data = $result;
                        $data['discount_price'] = $data['price'];
                        $data['configs'] = $result['configs'] != '' ? unserialize($result['configs']) : '';
                        //For simple-config product
                        $data['attributes'] = strpos($result['attributes'], 'a:1:{') !== FALSE ? unserialize($result['attributes']) : array( );
                        $cache->set($key, $data, 7200);
                    }
                }

                //set elastic
                
                // 显示产品更新elastic产品的分类
                Product::bulk_elastic('id', array($product_id), '', $need_catalog);

                message::set('修改产品成功。');
                $this->request->redirect('/admin/site/product/edit/' . $product_id . '?lang=' . $lang);
            }
            else
            {
                $this->request->redirect('/admin/site/product/edit/' . $original_product['id'] . '?lang=' . $lang);
            }
        }

        $name_template = '<input type="checkbox" id="catalog_check_{id}" name="product_catalogs[]" value="{id}"/><label for="catalog_check_{id}">{name}</label>';
        $content_data['catalog_checkboxes_tree'] = Controller_Admin_Site_Catalog::get_left_tree($this->site_id, $name_template, NULL, '', 1);

        $content_data['catalogs'] = DB::select('catalog_id')
            ->from('catalog_products')
            ->where('product_id', '=', $original_product['id'])
            ->execute('slave')
            ->as_array('catalog_id', 'catalog_id');

        $content_data['celebrity_images'] = DB::select()->from('celebrity_images')->where('product_id', '=', $original_product['id'])->order_by('position')->execute('slave')->as_array();

        $content_data['product'] = $original_product;

        $result = DB::select('attributes', 'stocks')->from('products_stocks')->where('product_id', '=', $original_product['id'])->execute();
        $product_stocks = array();
        foreach ($result as $val)
        {
            $product_stocks[$val['attributes']] = $val['stocks'];
        }
        $content_data['products_stocks'] = $product_stocks;
        //产品操作历史 zpz 20160125
        $content_data['oper_histories'] = operlog::select($original_product['id']);

        $content = View::factory('admin/site/product_edit_simple_config', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function add_thumb($images)
    {
        if(!empty($images))
        {
            set_time_limit(0);
            require 'class.jy_image.php';
            $resource_dir = $_SERVER['COFREE_UPLOAD_DIR'];

            $sizes1 = array(
                1 => array(320, 320, 0), // catalog
                2 => array(560, 560, 0), // product
                3 => array(100, 100, 0), // small
                7 => array(256, 256, 0), // lookbook
            );

            foreach($images as $image)
            {
                foreach($sizes1 as $size => $value)
                {
                    $file = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'thumbnails1' . DIRECTORY_SEPARATOR . $image['id'] . '_' . $size . '.' . $image['suffix'];
                    if (!file_exists($file))
                    {
                        $src_file = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'pimages' . DIRECTORY_SEPARATOR . $image['id'] . '.' . $image['suffix'];
                        if (!file_exists($src_file))
                        {
                            continue;
                        }
                        else
                        {
                            if($_SERVER['REMOTE_ADDR'] != '127.0.0.1')
                            {
                                $jy_image = new jy_image;
                                $x = $value[0];
                                $x = $x * 0.75;
                                $y = $value[1];
                                // echo $x . '-' . $y;exit;
                                $jy_image->output_image($src_file,$file,$x,$y);
                            }
                        }
                    }
                }
            }
        }
    }

    public function action_delete()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        $user_id = Session::instance()->get('user_id');
        $users = User::instance($user_id)->get();
        if ($users['role_id'] == 8)
        {
            Message::set('Dont have permission to delete this!', 'notice');
            $this->request->redirect('/admin/site/product/list');
        }
        $id = $this->request->param('id');

        $product = Product::instance($id);

        if ($product->get('id'))
        {
            $imagedir = kohana::config('upload.resource_dir') . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR;
            $sizeArr = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 99, 100);
            foreach ($product->images() as $image)
            {
                foreach ($sizeArr as $size)
                {
                    $img = $imagedir . 'thumbnails' . DIRECTORY_SEPARATOR . $image['id'] . '_' . $size . '.' . $image['suffix'];
                    if (file_exists($img))
                        unlink($img);
                }
                $simage = $imagedir . 'pimages' . DIRECTORY_SEPARATOR . $image['id'] . '.' . $image['suffix'];
                if (file_exists($simage))
                    unlink($simage);
                Image::delete($image['id']);
            }

            DB::delete('catalog_products')->where('product_id', '=', $id)->execute();

            if ($product->get('type') == 1)
            {
                // delete associate simple products
                DB::query(Database::DELETE, "DELETE FROM products WHERE id IN 
                    (SELECT product_id FROM pgroups WHERE group_id = $id)")
                    ->execute();
                DB::delete('pgroups')->where('group_id', '=', $id)->execute();
            }
            elseif ($product->get('type') == 2)
            {
                DB::delete('ppackages')->where('package_id', '=', $id)->execute();
            }
            else
            {
                DB::delete('pgroups')->where('product_id', '=', $id)->execute();
                DB::delete('ppackages')->where('product_id', '=', $id)->execute();
            }

            $topics = Group::instance()->topics($id);
            if ($topics)
            {
                $posts = DB::select('post_id')->from('topic_posts')->where('topic_id', 'in', $topics)->execute('slave')->as_array('post_id', 'post_id');
                DB::delete('posts')->where('id', 'in', $posts)->execute();
                DB::delete('topic_posts')->where('topic_id', 'in', $topics)->execute();
                DB::delete('topics')->where('id', 'in', $topics)->execute();
            }

            DB::delete('product_attribute_values')->where('product_id', '=', $id)->execute();
            DB::delete('product_options')->where('product_id', '=', $id)->execute();

            DB::delete('related_products')->where('product_id', '=', $id)->or_where('related_product_id', '=', $id)->execute();

            $reviews = Review::instance($id)->get();
            if ($reviews)
            {
                DB::delete('reviews')->where('product_id', '=', $id)->execute();
            }

            //finally, hoo!
            Kohana_log::instance()->add('Product_delete', 'SKU:' . Product::instance($id)->get('sku') . '-UER:' . $user_id);
            DB::delete('products')->where('id', '=', $id)->execute();
            $languages = Kohana::config('sites.'.$this->site_id.'.language');
            foreach ($languages as $l)
            {
                if ($l === 'en')
                    continue;
                DB::delete('products_' . $l)->where('id', '=', $id)->execute();
            }

            Message::set('product_deleted');
        }
        else
        {
            Message::set('product_does_not_exist');
        }

        $this->request->redirect('/admin/site/product/list');
    }

    public function action_image_upload($product_id = null)
    {
        image::upload($this->site_id, $product_id);
    }

    /**
     *  用于各种产品修改页面。一次性获得所需产品数据。
     * @param <type> $product_id
     * @return <type>
     */
    public function detail($product_id, $lang = '')
    {
        $product_obj = Product::instance($product_id, $lang);
        $product = $product_obj->get();
        if ($product !== NULl)
        {
            if ($product['type'] != 3)
                $product['attributes'] = $product_obj->set_data();

            if ($product['type'] == 1)
            {
                $associated_products = $product_obj->associated_products_options();
                $product['associated_products'] = array();
                foreach ($associated_products as $p_id => $options)
                {
                    foreach ($options as $opt_id)
                    {
                        $product['associated_products'][$p_id]['options'][Option::instance($opt_id)->get('attribute_id')] = $opt_id;
                    }
                }
            }
            elseif ($product['type'] == 2)
            {
                $product['packaged_products'] = $product_obj->items();
            }

            $product['related_products'] = $product_obj->related_products();
            return $product;
        }
        return FALSE;
    }

    public function action_data()
    {

        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        $lang_table = $lang ? '_' . $lang : '';
        $in_catalog = false;

        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                $item_data = trim($item->data);
                if ($item->field == 'id' AND !isset($_REQUEST['id_for_search']))
                {
                    $in_catalog = $item_data;
                }
                elseif (in_array($item->field, array('name', 'sku')))
                {
                    $filter_sql .= " AND " . $item->field . " LIKE '%" . $item_data . "%'";
                }
                elseif ($item->field == 'admin')
                {
                    $user = ORM::factory('user')->where('name', '=', $item_data)->find();
                    $filter_sql .= " AND " . $item->field . "='" . $user->id . "'";
                }
                elseif ($item->field == 'created')
                {
                    $date = explode(' to ', $item_data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $filter_sql .= " AND " . $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'presell')
                {
                    if($item_data == 0)
                    {
                        $filter_sql .= " AND " . $item->field . "=0";
                    }
                    else
                    {
                        $filter_sql .= " AND " . $item->field . ">0";
                    }
                }
                else
                {
                    //TODO add filter items
                    $filter_sql .= " AND " . $item->field . "='" . $item_data . "'";
                }
            }
        }
        $no_records = false;
        if ($in_catalog !== false)
        {
            if ($in_catalog == 2)
            {
                $selected_ids = Arr::get($_REQUEST, 'selected', '');
                $selected_ids = explode(',', $selected_ids);
                if (count($selected_ids))
                {
                    $product_ids = array();
                    foreach ($selected_ids as $selected_id)
                    {
                        $product_ids[] = "'" . $selected_id . "'";
                    }
                    $filter_sql .= " AND id IN (" . implode(',', $product_ids) . ')';
                }
                else
                {
                    $no_records = true;
                }
            }
            elseif ($in_catalog == 0 OR $in_catalog == 1)
            {
                $catalog_id = $this->request->param('id');
                $products = DB::select('related_product_id')->from('related_products')->where('product_id', '=', $catalog_id)->execute('slave');
                $product_ids = array();
                foreach ($products as $product)
                {
                    $product_ids[] = "'" . $product['related_product_id'] . "'";
                }
                if (count($product_ids))
                {
                    $filter_sql .= " AND id " . ($in_catalog == 0 ? 'NOT IN (' : 'IN (') . implode(',', $product_ids) . ')';
                }
                elseif ($in_catalog == 1)
                {
                    $no_records = true;
                }
            }
        }

        //用于配置产品的增改
        if (isset($_REQUEST['usefor']))
        {
            if ($_REQUEST['usefor'] == 'configurable_products')
            {
                $filter_sql = " AND type = 0 AND set_id = '" . $_REQUEST['set_id'] . "' " . $filter_sql;
            }
            elseif ($_REQUEST['usefor'] == 'packaged_products')
            {
                $filter_sql = " AND type != 2 " . $filter_sql;
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

//                $limit = 50;
        if ($no_records)
        {
            $count = 0;
        }
        else
        {
            $result = DB::query(Database::SELECT, 'SELECT count(id) FROM products' . $lang_table . ' WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
            $count = $result['count(id)'];
        }

        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }
        else
        {
            $total_pages = 0;
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        if ($no_records)
        {
            $result = array();
        }
        else
        {
            $result = DB::query(DATABASE::SELECT, 'SELECT * FROM products' . $lang_table . ' WHERE site_id=' . $this->site_id . ' ' .
                    $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');
        }

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        $response['userdata']['sets'] = array();
        //用于配置产品的增改
        if (isset($_REQUEST['usefor']) AND $_REQUEST['usefor'] == 'configurable_products')
        {
            $configurable_options = array();
            $configurable_option_names = array();
            $configurable_attribute_names = array();
            $configurable_attributes = (!isset($_REQUEST['configurable_attributes']) OR $_REQUEST['configurable_attributes'] == '') ? array() : explode(',', $_REQUEST['configurable_attributes']);
            foreach ($configurable_attributes as $attr_id)
            {
                $opts = Attribute::instance($attr_id)->options();
                $configurable_attribute_names[$attr_id] = Attribute::instance($attr_id)->get('name');
                foreach ($opts as $opt)
                {
                    $configurable_options[$attr_id][] = $opt['id'];
                    $configurable_option_names[$opt['id']] = $opt['label'];
                }
            }
        }

        foreach ($result as $product)
        {
            $response['rows'][$i]['id'] = $product['id'];
            if (!(isset($_REQUEST['usefor']) AND $_REQUEST['usefor'] == 'configurable_products'))
            {
                $set = ORM::factory('set', $product['set_id']);
                $response['userdata']['sets'][$product['set_id']] = $set->name ? $set->name : '无';
                $offline_picker=$product['offline_picker']>0?user::instance($product['offline_picker'])->get('name'):'no';
                $response['rows'][$i]['cell'] = array(
                    $product['id'],
                    $product['name'],
                    $product['type'],
                    $product['set_id'],
                    $product['sku'],
                    $product['price'],
                    date('Y-m-d', $product['created']),
                    $product['stock'],
                    $product['visibility'],
                    $product['status'],
                    $offline_picker,
                    $product['hits'],
                    $product['quick_clicks'],
                    $product['add_times'],
                    $product['presell'],
                    user::instance($product['admin'])->get('name'),
                    $product['source'],
                    $product['position'],
                    $product['level'],
                    $product['design'],
                    $product['style'],
                    $product['optimization'],
                );
            }
            else
            {
                $options = Product::instance($product['id'])->options();
                $attr_opts = array();
                $attr_opt_names = array();
                $for_choosing = 0;
                foreach ($configurable_attributes as $attr_id)
                {
                    $intersect = array_intersect($configurable_options[$attr_id], $options);
                    if (count($intersect))
                    {
                        $opt_id = current($intersect);
                        $attr_opts[] = 'attr_' . $attr_id . '__' . $opt_id;
                        $attr_opt_names[$opt_id] = $configurable_attribute_names[$attr_id] . ' : ' . $configurable_option_names[$opt_id];
                    }
                }
                if (count($attr_opts) == count($configurable_attributes))
                {
                    $for_choosing = 1;
                }
                sort($attr_opts);
                ksort($attr_opt_names);
                $response['rows'][$i]['cell'] = array(
                    $product['id'],
                    implode('&nbsp;&nbsp;', $attr_opt_names),
                    $product['name'],
                    $product['sku'],
                    $product['price'],
                    $product['stock'],
                    $product['visibility'],
                    $product['status'],
                    $for_choosing,
                    implode('-', $attr_opts),
                );
            }
            $i++;
        }
        echo json_encode($response);
    }

    function action_import_basic()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        $unset = array(
            'name', 'description', 'meta_title', 'meta_keywords', 'meta_description', 'keywords', ''
        );
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $basics = array();
        $head = array();
        $amount = 0;
        $success = '';
        while ($data = fgetcsv($handle))
        {
            foreach ($data as $key => $val)
            {
                $val = str_replace('', "\n", $val);
                $data[$key] = iconv('gbk', 'utf-8', $val);
//                                $data[$key] = iconv('gbk', 'utf-8', $val);
            }

            if ($row == 1)
            {
                foreach ($data as $val)
                {
                    $head[] = strtolower(trim($val));
                }
            }
            else
            {
                $basic = array();
                foreach ($data as $key => $value)
                {
                    if (!$key OR $value == '')
                        continue;
                    if ($head[$key] == 'taobao_url')
                    {
                        $query = parse_url($value, PHP_URL_QUERY);
                        parse_str($query, $GET);
                        if (isset($GET['id']))
                            $basic['taobao_id'] = $GET['id'];
                        elseif (isset($GET['default_item_id']))
                            $basic['taobao_id'] = $GET['default_item_id'];
                        else
                            $basic['taobao_id'] = '';
                        $basic[$head[$key]] = $value;
                    }
                    elseif ($head[$key] == 'admin')
                    {
                        $admin = DB::select('id')->from('auth_user')->where('name', '=', $value)->execute('slave')->get('id');
                        $basic[$head[$key]] = $admin;
                    }
                    elseif ($head[$key] == 'attributes')
                    {
                        $attributes = array();
                        $attributes['Size'] = explode("#", $value);
                        $basic[$head[$key]] = serialize($attributes);
                    }
                    elseif ($head[$key] == 'filter_attributes')
                    {
                        $basic[$head[$key]] = $value;
                        $basic['oid'] = 0;
                    }
                    elseif ($head[$key] == 'presell' OR $head[$key] == 'display_date')
                    {
                        $basic[$head[$key]] = strtotime($value);
                    }
                    else
                        $basic[$head[$key]] = $value;
                }
                $sku = trim($data[0]);
                $product_id = Product::get_productId_by_sku($sku);
                if ($product_id AND !empty($basic))
                {
                    $product = ORM::factory('product', $product_id);
                    $product->values($basic);
                    $columns = array_keys($product->list_columns());
                    $check_columns = 1;
                    foreach ($basic as $key => $val)
                    {
                        if (!in_array($key, $columns))
                        {
                            $check_columns = 0;
                            break;
                        }
                    }
                    if ($check_columns && !empty($basic))
                    {   
                        $success .= $sku . '<br>';
                        $result = DB::update('products')->set($basic)->where('id', '=', $product_id)->execute();
                        //操作记录
                        if(isset($basic['filter_attributes'])) 
                        {
                            operlog::add($product_id,'filter_attr_update',$basic['filter_attributes'],Session::instance()->get('user_id', 0));
                        }    
                        if(isset($basic['price']))
                        {
                            operlog::add($product_id,'price_update',$basic['price'],Session::instance()->get('user_id')); 
                        }
                        //if stock != -1 update items
                        if(isset($basic['stock']) AND $basic['stock'] != -1)
                        {
                            DB::query(Database::UPDATE, 'UPDATE products SET items = attributes WHERE id = ' . $product_id)->execute();
                        }
                        if ($result)
                        {
                            foreach ($unset as $u)
                            {
                                if (isset($basic[$u]))
                                    unset($basic[$u]);
                            }
                            $amount++;
                            if(!empty($basic))
                            {
                                foreach ($languages as $l)
                                {
                                    if ($l === 'en')
                                        continue;
                                    DB::update('products_' . $l)->set($basic)->where('id', '=', $product_id)->execute();
                                }
                            }

                            //set elastic
                            $need_elastic = 0;
                            $elastic_keys = array('name', 'sku', 'visibility', 'status', 'description', 'keywords', 'price', 'display_date', 'hits', 'has_pick', 'filter_attributes', 'position', 'attributes');
                            $array_keys = array_keys($basic);
                            foreach($array_keys as $key)
                            {
                                if(in_array($key, $elastic_keys))
                                {
                                    $need_elastic = 1;
                                    break;
                                }
                            }
                            if($need_elastic)
                            {
                                Product::bulk_elastic('id', array($product_id));
                            }
                        }
                    }
                }
            }
            $row++;
        }
        if($success)
        {
            Kohana_log::instance()->add('upload product basic-' . Session::instance()->get('user_id'), implode(',', $head) . ': ' . str_replace('<br>', ',', $success));
        }
        echo $amount . ' products basics import successfully:<br>';
        echo $success;
    }

    //guo  copyimage
    public function action_copy_image()
    {
        ignore_user_abort(true);
        set_time_limit(0); 
        ini_set('memory_limit', '512M');
        $filedir = "/home/data/www/htdocs/clothes/uploads/1/pimages/";
        $todir = "/home/data/www/htdocs/clothes/uploads/1/feedimage/";
        $products = DB::query(DATABASE::SELECT, "select id from products  where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
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
        $products = DB::query(DATABASE::SELECT, "select id from products  where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
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


    public function action_small_import()
    {
        if ($_POST)
        {
            $languages = Kohana::config('sites.' . $this->site_id . '.language');
            $lang = Arr::get($_GET, 'lang');
            if (!in_array($lang, $languages))
            {
                $lang = '';
            }
            $content = Arr::get($_POST, 'content', '');
            if(!$content)
            {
                Message::set('Input Cannot Be Empty!', 'notice');
                $this->request->redirect('/admin/site/product/small_import?lang='.$lang);
            }
            if ($lang)
            {
                $lang_table = $lang ? '_' . $lang : '';
                $row = 1;
                $head = array();
                $amount = 0;
                $success = '';
                if(strpos($content, '<br />') !== false)
                    $array = explode('<br />', $content);
                else
                    $array = explode("\n", $content);
                
                foreach($array as $value)
                {
                    $value = str_replace(array('<p>', '</p>'), array('', ''), $value);
                    if(strpos($value, 'white-space:pre') !== false)
                        $data = explode('<span style="white-space:pre"> </span>', $value);
                    elseif(strpos($value, 'white-space: pre;') !== false)
                            $data = explode('<span style="white-space: pre;"> </span>', $value);
                    else
                        $data = explode('&nbsp;&nbsp;&nbsp;', $value);

                    foreach ($data as $key => $val)
                    {
                        $val = str_replace('', "\n", $val);
//                    $data[$key] = Security::xss_clean(iconv('gbk', 'utf-8', $val));
//                    $data[$key] = iconv('gbk', 'utf-8', $val);
                    }

                    if ($row == 1)
                    {
                        foreach ($data as $val)
                        {
                            $head[] = strtolower(preg_replace('#[^A-z0-9]#', '', trim($val)));
                        }
                    }
                    else
                    {
                        if(strpos($data[0],'<span>')){
                            $data[0]=str_replace(array('<span>','</span>'),array('',''),$data[0]);
                        }
                         $product_id = Product::get_productId_by_sku($data[0]);
                         $data1['name']=$data[1];
                         if($product_id){
                             $success .= $data[0] . '<br>';
                             $result = DB::update('products_' . $lang)->set($data1)->where('id', '=', $product_id)->execute();
                             if ($result)
                                    $amount++;
                         }
                        //$result = DB::update('products_' . $lang)->set($data1)->where('id', '=', $product_id)->execute();

                        //var_dump($sku);
                        /*
                        $sku1=explode('!', $sku);
                        echo $sku1[0];
                        echo $sku1[1];
                        $product_id = Product::get_productId_by_sku($sku1[0]);
                        
                        if ($product_id)
                        {
                            $product = ORM::factory('product' . $lang, $product_id);
                            $success .= $sku1[0] . '<br>';
                            if($name1=='name'){
                                $data1[$name1]=trim(str_replace("&nbsp;"," ",str_replace("&amp;nbsp;"," ",$sku1[1])));
                                $result = DB::update('products_' . $lang)->set($data1)->where('id', '=', $product_id)->execute();
                                if ($result)
                                    $amount++;
                            }
                            
                            
                                
                            /*
                            $product->values($basic);
                            $columns = array('name', 'brief', 'description', 'meta_title', 'meta_keywords', 'meta_description', 'keywords', 'presell_message');
                            $check_columns = 1;
                            foreach ($basic as $key => $val)
                            {
                                if (!in_array($key, $columns))
                                {
                                    $check_columns = 0;
                                    break;
                                }
                            }
                            if ($check_columns)
                            {
                                $success .= $sku . '<br>';
                                $result = DB::update('products_' . $lang)->set($basic)->where('id', '=', $product_id)->execute();
                                if ($result)
                                    $amount++;
                            }
                            
                        }
                        */
                        
                        
                    }
                    $row++;
                }
                echo $amount . ' products basics import successfully:<a href="/admin/site/product/small_import?lang='.$lang.'" style="color:red;">Back</a><br>';
                echo $success;
                exit;
            }
        }
        $content = View::factory('admin/site/product_small_import')
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    //导出产品
    public function action_products()
    {
        if ($_POST)
        {
            $from = Arr::get($_POST, 'from', NULL);
            if (!$from)
            {
                die('invalid request');
            }
            $to = Arr::get($_POST, 'to', NULL);

            $file = '';
            $sql = '';
            if ($to)
            {
                $file .= "from-$from-to-$to";
                $sql = ' AND display_date >= ' . strtotime($from) . ' AND display_date < ' . strtotime($to);
            }
            else
            {
                $file .= "-from-$from";
                $to = strtotime($from) + 86400;
                $sql = ' AND display_date >= ' . strtotime($from) . ' AND display_date < ' . $to;
            }
            $type = Arr::get($_POST, 'type', 0);

            switch ($type)
            {
                case 0:
                    break;
                case 1:
                    $sql .= ' AND visibility = 1';
                    break;
                case 2:
                    $sql .= ' AND status = 1 ';
                    break;
                case 3:
                    $sql .= ' AND visibility = 1 AND status = 1 ';
                    break;
            }
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="Products-' . $file . '.csv"');
            echo "\xEF\xBB\xBF" . "SKU,Name,Catalog,Created,Display Date,URL to product,Price,RMB Cost,Currency,URL to image,SearchTerms,Status,Category,Clicks,Sales,Description,Brief,Filter Attributes,Source,Factory,Offline_factory,Admin,Attributes\n";

            $products = DB::query(DATABASE::SELECT, 'SELECT * FROM products WHERE site_id=' . $this->site_id . ' ' . $sql . ' ORDER BY id')->execute('slave');
            $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
            $users = array();
            foreach ($userArr as $user)
            {
                $users[$user['id']] = $user['name'];
            }
            foreach ($products as $product)
            {
                echo $product['sku'], ',';
                echo '"' . trim(str_replace('"', '\"', $product['name'])) . '"', ',';
                $default_catalog = Product::instance($product['id'])->default_catalog();
                echo '"' . $default_catalog ? Catalog::instance($default_catalog)->get('name') : Set::instance(Product::instance($product['id'])->get('set_id'))->get('name') . '"', ',';
                echo '"' . date('Y-m-d', $product['created']) . '"', ',';
                echo '"' . date('Y-m-d', $product['display_date']) . '"', ',';
                echo '"' . Product::instance($product['id'])->permalink() . '"', ',';
                echo $product['price'], ',';
                echo $product['total_cost'], ',';
                echo 'US', ',';
                echo Image::link(Product::instance($product['id'])->cover_image(), 1), ',';
                echo '"' . trim(str_replace('"', '\"', $product['keywords'])) . '"', ',';
                echo $product['status'], ',';
                $catalog = DB::select('catalog_id')
                    ->from('catalog_products')
                    ->where('product_id', '=', $product['id'])
                    ->execute('slave')
                    ->get('catalog_id');
                echo '"' . str_replace('&amp;', '&', Catalog::instance($catalog)->get('name')) . '"', ',';
                echo '"' . $product['clicks'] . '"', ',';
                $orders = DB::query(Database::SELECT, 'SELECT COUNT(order_items.id) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id WHERE orders.payment_status="verify_pass" AND order_items.product_id=' . $product['id'])->execute('slave')->get('count');
                echo '"' . $orders . '"', ',';
                $description = strip_tags($product['description']);
                $description = preg_replace('/(&nbsp;)+/', ' ', $description);
                $description = str_replace(array('&amp;', '.'), array('&', ''), $description);
                $description = trim(preg_replace('/"|\n/', '', $description));
                $brief = $product['brief'];
                $brief = str_replace(array('<p>', '</p>'), array(';', ''), $brief);
                echo '"' . $description . '"', ',';
                echo '"' . $brief . '"', ',';
                echo '"' . $product['filter_attributes'] . '",';
                echo '"' . $product['source'] . '",';
                echo '"' . $product['factory'] . '",';
                echo '"' . $product['offline_factory'] . '",';
                echo '"' . $product['offline_picker'] . '",';
                echo isset($users[$product['admin']]) ? '"' . $users[$product['admin']] . '",' : ',';
                $attributes = '';
                $attr = unserialize($product['attributes']);
                if (!empty($attr))
                {
                    foreach ($attr as $name => $val)
                    {
                        $attributes .= $name . ':';
                        $attributes .= implode(';', $val) . ';';
                    }
                }
                echo '"' . $attributes . '"';
                echo PHP_EOL;
            }
        }
    }

    public function action_products_all()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Products.csv"');
        echo "SKU,Name,Set,Created,URL to product,Price,RMB Cost,Currency,URL to image,SearchTerms,Status,Category,Clicks,Description\n";

        $products = DB::query(DATABASE::SELECT, 'SELECT * FROM products WHERE site_id=' . $this->site_id . '  ORDER BY id')->execute('slave');
        foreach ($products as $product)
        {
            echo $product['sku'], ',';
            echo '"' . trim(str_replace('"', '\"', $product['name'])) . '"', ',';
            echo '"' . Set::instance($product['set_id'])->get('name') . '"', ',';
            echo '"' . date('Y-m-d', $product['created']) . '"', ',';
            echo '"' . Product::instance($product['id'])->permalink() . '"', ',';
            echo $product['price'], ',';
            echo $product['total_cost'], ',';
            echo 'US', ',';
            echo Image::link(Product::instance($product['id'])->cover_image(), 1), ',';
            echo '"' . trim(str_replace('"', '\"', $product['keywords'])) . '"', ',';
            echo $product['status'], ',';
            echo '"' . str_replace('&amp;', '&', Catalog::instance($product['default_catalog'])->get('name')) . '"', ',';
            echo '"' . $product['clicks'] . '"', ',';
//                        $orders = DB::query(Database::SELECT, 'SELECT COUNT(order_items.id) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id WHERE orders.payment_status="verify_pass" AND order_items.product_id=' . $product['id'])->execute('slave')->get('count');
//                        echo '"' . $orders . '"', ',';
            $description = strip_tags($product['description']);
            $description = preg_replace('/(&nbsp;)+/', ' ', $description);
            $description = str_replace('&amp;', '&', $description);
            $description = trim(preg_replace('/"|\n/', '', $description));
            echo '"' . $description . '"', PHP_EOL;
        }
    }

    public function action_export_outstock()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Products_outstock.csv"');
        echo "Created,SKU,Taobao Url\n";

        $products = DB::query(DATABASE::SELECT, 'SELECT created,sku,taobao_url FROM products WHERE site_id=' . $this->site_id . ' AND status=0 AND visibility=1 ORDER BY id')->execute('slave');
        foreach ($products as $product)
        {

            echo date('Y-m-d', $product['created']), ',';
            echo '"' . $product['sku'] . '"', ',';
            echo '"' . iconv('utf-8', 'gbk', $product['taobao_url']) . '"', PHP_EOL;
        }
    }

    public function action_double_price()
    {
        $fp = fopen('/tmp/skus.csv', 'r');
        $changed = 0;
        while ($sku = trim(fgets($fp)))
        {
            echo "$sku\n";
            $product = ORM::factory('product')
                ->where('site_id', '=', 1)
                ->where('sku', '=', $sku)
                ->find();
            if (!$product->loaded())
            {
                echo "not found: $sku\n";
                continue;
            }
            $product->price = number_format((float) $product->price * 2, 2);
            if (!empty($product->configs))
            {
                $configs = unserialize($product->configs);
                if (isset($configs['bulk_rules']))
                {
                    foreach ($configs['bulk_rules'] as &$rule)
                    {
                        if ($rule != -1)
                        {
                            $rule = number_format((float) $rule * 2, 2);
                        }
                    }

                    $product->configs = serialize($configs);
                }
            }

            if ($product->save())
                $changed++;
            else
                echo "failed to save: $sku\n";
        }

        echo "changed: $changed\n";
    }

    public function action_product_onstock()
    {
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        if ($_POST)
        {
            if (!$_POST['SKUARR'])
            {
                Message::set('请输入产品的sku', 'notice');
                $this->request->redirect('/admin/site/product/product_onstock');
            }
            $productArr = explode("\n", trim($_POST['SKUARR']));
            $sql = "";
            foreach ($productArr as $sku)
            {
                $sql .= "'" . trim($sku) . "',";
            }
            $sql = substr($sql, 0, strlen($sql) - 1);
            $result = DB::query(Database::UPDATE, 'UPDATE `products` SET `status` = 1 WHERE `status` = 0 AND `sku` IN (' . $sql . ')')->execute();
            if ($result)
            {
                foreach ($productArr as $sku)//批量下架记录LOG
                {
                    $product_id = Product::get_productId_by_sku($sku);
                    if($product_id){
                        Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '产品上架');
                    }
                }
                foreach($languages as $l)
                {
                    if($l === 'en')
                        continue;
                    DB::query(Database::UPDATE, 'UPDATE `products_' . $l . '` SET `status` = 1 WHERE `status` = 0 AND `sku` IN (' . $sql . ')')->execute();
                }

                //set elastic
                Product::bulk_elastic('sku', $productArr, '', 1);

                Message::set('批量产品上架成功', 'success');
                $this->request->redirect('/admin/site/product/product_onstock');
            }
            else
            {
                Message::set('批量产品上架错误', 'error');
                $this->request->redirect('/admin/site/product/product_onstock');
            }
        }
        $title = '上架';
        $content = View::factory('admin/site/product_stock')
            ->set('title', $title)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_product_outstock()
    {
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        if ($_POST)
        {
            if (!$_POST['SKUARR'])
            {
                Message::set('请输入产品的sku', 'notice');
                $this->request->redirect('/admin/site/product/product_outstock');
            }
            $productArr = explode("\n", trim($_POST['SKUARR']));
            $sql = "";
            foreach ($productArr as $sku)
            {
                $sql .= "'" . trim($sku) . "',";
            }
            $sql = substr($sql, 0, strlen($sql) - 1);
            $result = DB::query(Database::UPDATE, 'UPDATE `products` SET `status` = 0 WHERE `status` = 1 AND `sku` IN (' . $sql . ')')->execute();
            if ($result)
            {
                foreach ($productArr as $sku)//批量下架记录LOG
                {
                    $product_id = Product::get_productId_by_sku($sku);
                    if($product_id){
                        Manage::add_product_update_log($product_id, Session::instance()->get('user_id'), '产品下架');
                    }
                }
                foreach($languages as $l)
                {
                    if($l === 'en')
                        continue;
                    DB::query(Database::UPDATE, 'UPDATE `products_' . $l . '` SET `status` = 0 WHERE `status` = 1 AND `sku` IN (' . $sql . ')')->execute();
                }

                //set elastic
                Product::bulk_elastic('sku', $productArr);

                Message::set('批量产品下架成功', 'success');
                $this->request->redirect('/admin/site/product/product_outstock');
            }
            else
            {
                Message::set('批量产品下架错误', 'error');
                $this->request->redirect('/admin/site/product/product_outstock');
            }
        }
        $title = '下架';
        $content = View::factory('admin/site/product_stock')
            ->set('title', $title)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_product_visible()
    {
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        if ($_POST)
        {
            if (!$_POST['SKUARR'])
            {
                Message::set('请输入产品的sku', 'notice');
                $this->request->redirect('/admin/site/product/product_visible');
            }
            $productArr = explode("\n", trim($_POST['SKUARR']));
            $sql = "";
            foreach ($productArr as $sku)
            {
                $sql .= "'" . trim($sku) . "',";
            }
            $sql = substr($sql, 0, strlen($sql) - 1);
            $result = DB::query(Database::UPDATE, 'UPDATE `products` SET `visibility` = 1, `display_date` = ' . time() . ' WHERE `visibility` = 0 AND `sku` IN (' . $sql . ')')->execute();
            if ($result)
            {
                $logs = str_replace("\n", ",", $_POST['SKUARR']);
                Kohana_log::instance()->add('visibile', Session::instance()->get('user_id') . '-' . $logs);
                foreach($languages as $l)
                {
                    if($l === 'en')
                        continue;
                    DB::query(Database::UPDATE, 'UPDATE `products_' . $l . '` SET `visibility` = 1, `display_date` = ' . time() . ' WHERE `visibility` = 0 AND `sku` IN (' . $sql . ')')->execute();
                }

                //set elastic
                Product::bulk_elastic('sku', $productArr, '', 1);

                Message::set('批量产品显示成功', 'success');
                $this->request->redirect('/admin/site/product/product_visible');
            }
            else
            {
                Message::set('批量产品显示错误', 'error');
                $this->request->redirect('/admin/site/product/product_visible');
            }
        }
        $title = '显示';
        $content = View::factory('admin/site/product_stock')
            ->set('title', $title)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_product_invisible()
    {
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        if ($_POST)
        {
            if (!$_POST['SKUARR'])
            {
                Message::set('请输入产品的sku', 'notice');
                $this->request->redirect('/admin/site/product/product_invisible');
            }
            $productArr = explode("\n", trim($_POST['SKUARR']));
            $sql = "";
            foreach ($productArr as $sku)
            {
                $sql .= "'" . trim($sku) . "',";
            }
            $sql = substr($sql, 0, strlen($sql) - 1);
            $result = DB::query(Database::UPDATE, 'UPDATE `products` SET `visibility` = 0 WHERE `visibility` = 1 AND `sku` IN (' . $sql . ')')->execute();
            if ($result)
            {
                $logs = str_replace("\n", ",", $_POST['SKUARR']);
                Kohana_log::instance()->add('invisibile', Session::instance()->get('user_id') . '-' . $logs);
                foreach($languages as $l)
                {
                    if($l === 'en')
                        continue;
                    DB::query(Database::UPDATE, 'UPDATE `products_' . $l . '` SET `visibility` = 0 WHERE `visibility` = 1 AND `sku` IN (' . $sql . ')')->execute();
                }

                //set elastic
                Product::bulk_elastic('sku', $productArr);

                Message::set('批量产品隐藏成功', 'success');
                $this->request->redirect('/admin/site/product/product_invisible');
            }
            else
            {
                Message::set('批量产品隐藏错误', 'error');
                $this->request->redirect('/admin/site/product/product_invisible');
            }
        }
        $title = '隐藏';
        $content = View::factory('admin/site/product_stock')
            ->set('title', $title)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_upload_taobaoUrl()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        while ($data = fgetcsv($handle))
        {
            if (strtolower($data[0]) == 'sku')
                continue;
            try
            {
                $array = array();
                if ($data[2])
                {
                    $array['taobao_url'] = $data[2];
                    $query = parse_url($data[2], PHP_URL_QUERY);
                }
                else
                {
                    $array['taobao_url'] = $data[1];
                    $query = parse_url($data[1], PHP_URL_QUERY);
                }
                parse_str($query, $GET);
                if (isset($GET['id']))
                    $array['taobao_id'] = $GET['id'];
                elseif (isset($GET['default_item_id']))
                    $array['taobao_id'] = $GET['default_item_id'];
                else
                    $array['taobao_id'] = '';
                $result1 = DB::update('products')->set($array)->where('sku', '=', $data[0])->execute();
                $row++;

                if (!$result1)
                {
                    $error[] = $data;
                }
            }
            catch (Exception $e)
            {
                $row++;
            }
        }
        $num = $row - count($error) - 2;
        echo "In stock " . $num . " order products successfully.<br>";
        exit;
    }

    public function action_taobao()
    {
        if ($_POST)
        {
            $id = Arr::get($_POST, 'id', 0);
            if (!$id)
            {
                message::set('Edit taobao url false', 'error');
            }
            else
            {
                $data['taobao_url'] = Arr::get($_POST, 'url', '');
                $query = parse_url($data['taobao_url'], PHP_URL_QUERY);
                parse_str($query, $GET);
                if (isset($GET['id']))
                    $data['taobao_id'] = $GET['id'];
                elseif (isset($GET['default_item_id']))
                    $data['taobao_id'] = $GET['default_item_id'];
                else
                    $data['taobao_id'] = '';
                $result = DB::update('products')->set($data)->where('id', '=', $id)->execute();
                if ($result)
                {
                    message::set('Edit taobao url success', 'success');
                }
                else
                {
                    message::set('Edit taobao url false', 'error');
                }
            }
        }
        $admins = DB::query(Database::SELECT, 'SELECT DISTINCT admin FROM products WHERE admin > 100')->execute('slave')->as_array();
        $content = View::factory('admin/site/product_taobao')
            ->set('admins', $admins)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_taobao_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";
        $outstock = 0;
        $instock = 0;
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
//                                if($item->field == 'taobao_status')
//                                {
//                                        if($item->data == 0)
//                                        {
//                                                $outstock = 1;
//                                        }
//                                        elseif($item->data == 1)
//                                        {
//                                                $filter_sql .= " AND taobao_id = ''";
//                                        }
//                                        else
//                                        {
//                                                $instock = 1;
//                                        }
//                                }
                if ($item->field == 'admin')
                {
                    $user_id = DB::select('id')->from('auth_user')->where('name', '=', $item->data)->execute('slave')->get('id');
                    $filter_sql .= " AND " . $item->field . "='" . $user_id . "'";
                }
                else
                {
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
                }
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
        if ($outstock OR $instock)
            $limit = 100;
        else
            $limit = 20;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM products WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT id,sku,name,price,set_id,visibility,status,created,taobao_url,taobao_id,clicks,quick_clicks,add_times,admin FROM products WHERE site_id=' . $this->site_id .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

//                require $_SERVER['DOCUMENT_ROOT'] . '/application/classes/taobaoSdk/' . 'TopSdk.php';
//                $c = new TopClient;
//                $c->appkey = '21379024';
//                $c->secretKey = '2e52da2eb8a7aae697d56e0b2cf9501c';
//                $req = new ItemGetRequest;
//                $req->setFields("approve_status");
        $i = 0;
        foreach ($result as $data)
        {
//                        if($outstock AND !$data['taobao_id'])
//                        {
//                                continue;
//                        }
//                        $taobao_status = '';
//                        if ($data['taobao_id'])
//                        {
//                                $req->setNumIid($data['taobao_id']);
//                                $resp = $c->execute($req);
//                                $status = $resp->item->approve_status;
//                                if ($status == 'onsale')
//                                {
//                                        $taobao_status = 'instock';
//                                }
//                                else
//                                {
//                                        $taobao_status = 'outstock';
//                                }
//                        }
//                        if($outstock AND ($taobao_status == 'instock'))
//                        {
//                                continue;
//                        }
//                        elseif($instock AND ($taobao_status == 'outstock' OR $taobao_status == ''))
//                        {
//                                continue;
//                        }
            $celebrity_times = DB::query(Database::SELECT, 'SELECT COUNT(orders.id) AS count FROM orders
                                        LEFT JOIN order_items ON order_items.order_id = orders.id
                                        LEFT JOIN celebrits ON celebrits.email = orders.email
                                        WHERE celebrits.email = orders.email AND orders.payment_status="verify_pass" 
                                        AND order_items.product_id =' . $data['id'])
                    ->execute('slave')->get('count');
            $set = ORM::factory('set', $data['set_id']);
            $admin = User::instance($data['admin'])->get('name');
            $sales = DB::query(Database::SELECT, 'SELECT COUNT(order_items.id) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id WHERE orders.payment_status="verify_pass" AND order_items.product_id=' . $data['id'])->execute('slave')->get('count');
            $response['rows'][$i]['cell'] = array(
                $data['id'],
                $data['sku'],
                $data['name'],
                $data['price'],
                $set->name ? $set->name : '无',
                $data['visibility'],
                $data['status'],
                $data['clicks'],
                $data['quick_clicks'],
                $data['add_times'],
                $celebrity_times,
                date('Y-m-d', $data['created']),
                $sales,
                $admin,
                $data['taobao_url'],
//                            $taobao_status,
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_export_taobao()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'start', 0));
//                $date += 28800; /* 8 hours */     
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'end', 0);
        $admin = Arr::get($_POST, 'admin', '');

        if ($date_end)
        {
            $file_name = "products-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
//          $date_end += 28800;
        }
        else
        {
            $file_name = "products-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "SKU,Name,Price,Set,Visibility,Status,Clicks,Quick Clicks,Add Cart Times,Celebrity Times,Created,Sales,Admin,Taobao_url,Offline_picker\n";
        if ($admin == 'all')
        {
            $result = DB::query(DATABASE::SELECT, 'SELECT id,sku,name,price,set_id,visibility,status,clicks,quick_clicks,add_times,created,admin,taobao_url,offline_picker FROM products WHERE visibility=1 AND created >= ' . $date . ' AND created < ' . $date_end)->execute('slave')->as_array();
        }
        else
        {
            $result = DB::query(DATABASE::SELECT, 'SELECT id,sku,name,price,set_id,visibility,status,clicks,quick_clicks,add_times,created,admin,taobao_url,offline_picker FROM products WHERE visibility=1 AND admin = ' . $admin . ' AND created >= ' . $date . ' AND created < ' . $date_end)->execute('slave')->as_array();
        }

        foreach ($result as $product)
        {
            echo $product['sku'] . ',';
            echo $product['name'] . ',';
            echo $product['price'] . ',';
            echo Set::instance($product['set_id'])->get('name') . ',';
            echo $product['visibility'] . ',';
            echo $product['status'] . ',';
            echo $product['clicks'] . ',';
            echo $product['quick_clicks'] . ',';
            echo $product['add_times'] . ',';
            $celebrity_times = DB::query(Database::SELECT, 'SELECT COUNT(orders.id) AS count FROM orders
                                        LEFT JOIN order_items ON order_items.order_id = orders.id
                                        LEFT JOIN celebrits ON celebrits.email = orders.email
                                        WHERE celebrits.email = orders.email AND orders.payment_status="verify_pass" 
                                        AND order_items.product_id =' . $product['id'])
                    ->execute('slave')->get('count');
            echo $celebrity_times . ',';
            echo '"' . date('Y-m-d', $product['created']) . '",';
            $sales = DB::query(Database::SELECT, 'SELECT COUNT(order_items.id) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id WHERE orders.payment_status="verify_pass" AND order_items.product_id=' . $product['id'])->execute('slave')->get('count');
            echo '"' . $sales . '",';
            echo User::instance($product['admin'])->get('name') . ',';
            echo '"' . $product['taobao_url'] . '",';
            echo '"' . $product['offline_picker'] . '",';
            echo "\n";
        }
    }

    public function action_export_taobaourl()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'start', 0));
//                $date += 28800; /* 8 hours */     
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'end', 0);
        $admin = Arr::get($_POST, 'admin', '');

        if ($date_end)
        {
            $file_name = "TaobaoUrl-" . date('Y-m-d', $date) . '_' . $date_end;
            $date_end = strtotime($date_end);
//          $date_end += 28800;
        }
        else
        {
            $file_name = "TaobaoUrl-" . date('Y-m-d', $date);
            $date_end = $date + 86400;
        }

        header('Content-type: text/txt');
        header('Content-Disposition: attachment; filename=' . $file_name . '.txt');

        if ($admin == 'all')
        {
            $result = DB::query(DATABASE::SELECT, 'SELECT taobao_url FROM products WHERE visibility=1 AND created >= ' . $date . ' AND created < ' . $date_end)->execute('slave')->as_array();
        }
        else
        {
            $result = DB::query(DATABASE::SELECT, 'SELECT taobao_url FROM products WHERE visibility=1 AND admin = ' . $admin . ' AND created >= ' . $date . ' AND created < ' . $date_end)->execute('slave')->as_array();
        }
        foreach ($result as $product)
        {
            echo $product['taobao_url'];
            echo "\n";
        }
    }

    public function action_export_urlproduct()
    {
        $urls = Arr::get($_POST, 'urls', '');
        if (!$urls)
        {
            Message::set('Sku cannot be empty', 'error');
            $this->request->redirect('/admin/site/product/taobao');
        }
        else
        {
            echo '<table cellspacing="0" cellpadding="0" border="0">';
            echo '<tr><td width="100px">SKU</td><td width="100px">Clicks</td><td width="100px">Q_clicks</td><td width="100px">Celbrity Times</td><td width="100px">Sales</td><td>URL</td></tr>';
            $urlArr = explode("\n", $urls);
            foreach ($urlArr as $url)
            {
                $url = trim($url);
                if (strlen($url) < 20)
                    continue;
                $product = DB::select('id', 'sku', 'clicks', 'quick_clicks')->from('products_product')->where('taobao_url', '=', $url)->execute('slave')->as_array();
                foreach ($product as $p)
                {
                    $celebrity_times = DB::query(Database::SELECT, 'SELECT COUNT(orders.id) AS count FROM orders
                                        LEFT JOIN order_items ON order_items.order_id = orders.id
                                        LEFT JOIN celebrits ON celebrits.email = orders.email
                                        WHERE celebrits.email = orders.email AND orders.payment_status="verify_pass" 
                                        AND order_items.product_id =' . $p['id'])
                            ->execute('slave')->get('count');
                    $sales = DB::query(Database::SELECT, 'SELECT COUNT(order_items.id) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id WHERE orders.payment_status="verify_pass" AND order_items.product_id=' . $p['id'])->execute('slave')->get('count');
                    echo '<tr><td>' . $p['sku'] . '</td><td>' . $p['clicks'] . '</td><td>' . $p['quick_clicks'] . '</td><td>' . $celebrity_times . '</td><td>' . $sales . '</td><td>' . $url . '</td></tr>';
                }
            }
            echo '</table>';
        }
    }

    public function action_export_cost()
    {
        $skus = Arr::get($_POST, 'SKUARR', '');
        if (!$skus)
        {
            echo 'Sku cannot be empty';
            exit;
        }
        else
        {
            echo '<table cellspacing="0" cellpadding="0" border="0">';
            echo '<tr><td width="120px">SKU</td><td width="100px">原售价</td><td width="100px">现售价</td><td width="100px">美金成本</td><td width="100px">RMB成本</td><td width="100px">重量</td></tr>';
            $skuArr = explode("\n", $skus);
            foreach ($skuArr as $sku)
            {
                $sku = trim($sku);
                $id = Product::get_productId_by_sku($sku);
                echo '<tr><td>' . $sku . '</td><td>' . Product::instance($id)->get('price') . '</td><td>' . Product::instance($id)->price() . '</td><td>' . Product::instance($id)->get('cost') . '</td><td>' . Product::instance($id)->get('total_cost') . '</td><td>' . Product::instance($id)->get('weight') . '</td></tr>';
            }
            echo '</table>';
        }
    }

    public function action_export_thumb()
    {
        $skus = Arr::get($_POST, 'SKUARR', '');
        if (!$skus)
        {
            echo 'Sku cannot be empty';
            exit;
        }
        else
        {
            echo '<table cellspacing="0" cellpadding="0" border="0">';
            echo '<tr><td width="100px">SKU</td><td width="100px">缩略图</td><td width="100px">线下供货商</td><td width="100px">线下SKU</td><td width="100px">库存</td></tr>';
            $skuArr = explode("\n", $skus);
            foreach ($skuArr as $sku)
            {
                $sku = trim($sku);
                $id = Product::get_productId_by_sku($sku);
                $image = Product::instance($id)->cover_image();
                $imagelink = Image::link($image,3);
                $stock_attrs = DB::select(DB::expr('DISTINCT attributes'))->from('order_instocks')->where('sku', '=', $sku)->execute();
                $stock = 0;
                foreach($stock_attrs as $attr)
                {
                    $instock = DB::select(DB::expr('COUNT(id) AS count_id'))->from('order_instocks')->where('sku', '=', $sku)->where('attributes', '=', $attr['attributes'])->execute()->get('count_id');
                    $outstock = DB::select(DB::expr('COUNT(id) AS count_id'))->from('order_outstocks')->where('sku', '=', $sku)->where('attributes', '=', $attr['attributes'])->execute()->get('count_id');
                    if($instock > $outstock)
                    {
                        $stock = 1;
                        break;
                    }
                }
                echo '<tr><td>' . $sku . '</td><td><img src="' . $imagelink . '" /></td><td>' . Product::instance($id)->get('offline_factory') . '</td><td>' . Product::instance($id)->get('offline_sku') . '</td><td>' . $stock . '</td></tr>';
            }
            echo '</table>';
        }
    }

    public function action_delete_images()
    {
        $imagedir = kohana::config('upload.resource_dir') . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR;
        $sizeArr = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 99, 100);
        if ($_POST)
        {
            if (!$_POST['SKUARR'])
            {
                Message::set('请输入产品的sku', 'notice');
                $this->request->redirect('/admin/site/product/delete_images');
            }
            $productArr = explode("\n", $_POST['SKUARR']);
            $sql = "";
            foreach ($productArr as $sku)
            {
                $sql .= "'" . trim($sku) . "',";
            }
            $sql = substr($sql, 0, strlen($sql) - 1);
            $images = DB::query(Database::SELECT, 'SELECT images.id,images.suffix FROM images LEFT JOIN products ON products.id=images.obj_id WHERE products.sku IN (' . $sql . ')')->execute('slave');
            foreach ($images as $image)
            {
                foreach ($sizeArr as $size)
                {
                    $img = $imagedir . 'thumbnails' . DIRECTORY_SEPARATOR . $image['id'] . '_' . $size . '.' . $image['suffix'];
                    if (file_exists($img))
                        unlink($img);
                    $img = $imagedir . 'thumbnails1' . DIRECTORY_SEPARATOR . $image['id'] . '_' . $size . '.' . $image['suffix'];
                    if (file_exists($img))
                        unlink($img);
                }
                $simage = $imagedir . 'pimages' . DIRECTORY_SEPARATOR . $image['id'] . '.' . $image['suffix'];
                if (file_exists($simage))
                    unlink($simage);
                DB::delete('images')->where('id', '=', $image['id'])->execute();
            }
            Message::set('批量删除产品图片成功');
        }
        $title = '产品图片删除';
        $content = View::factory('admin/site/product_stock')
            ->set('title', $title)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_image_export()
    {
        require_once 'inc_config.php';
        if ($_POST)
        {
            $SKUs = Arr::get($_POST, 'SKUARR', array());
            $skuArr = explode("\n", $SKUs);
            $src_file = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'pimages' . DIRECTORY_SEPARATOR;

            $dir = 'product_images';
            if (!is_dir($dir))
            {
                mkdir($dir);
            }
            $handle = opendir($dir);
            if ($handle)
            {
                $file = readdir($handle);
                while ($file)
                {
                    if (is_dir($file))
                    {
                        @rmdir($dir . '/' . $file);
                    }
                    else
                    {
                        @unlink($dir . '/' . $file);
                    }
                    $file = readdir($handle);
                }
            }
            $images_dir = 'product_images/images' . $this->site_id . '_' . time();
            mkdir($images_dir, 0777);
            chmod($images_dir, 0777);
            foreach ($skuArr as $sku)
            {
                $mkdir = $images_dir . '/' . trim($sku);
                if(!file_exists($mkdir))
                {
                    mkdir($mkdir, 0777);
                    chmod($mkdir, 0777);
                }
                $images = Product::instance(Product::get_productId_by_sku(trim($sku)))->images();
                $haveimage = 0;
                foreach ($images as $key => $image)
                {
                    if ($image['id'] != 0)
                    {
                        $haveimage = 1;
                        if (file_exists($src_file . $image['id'] . '.' . $image['suffix']))
                            copy($src_file . $image['id'] . '.' . $image['suffix'], $images_dir . '/' . trim($sku) . '/' . $key . '.' . $image['suffix']);
                    }
                }
                if($haveimage)
                {
                    echo $sku . ' export images success<br>';                    
                }

            }
            exit;
        }

        $times = Product::instance()->product_time();
        $content = View::factory('admin/site/product_image_export')
            ->set('times', $times)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_weight_history()
    {
        $content = View::factory('admin/site/product_weight_history')
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_weight_history_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if ($item->field == 'admin')
                {
                    $user_id = DB::select('id')->from('auth_user')->where('name', '=', $item->data)->execute('slave')->get('id');
                    $filter_sql .= " AND p." . $item->field . "='" . $user_id . "'";
                }
                elseif ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $filter_sql .= " AND w." . $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'sku')
                {
                    $filter_sql .= " AND p." . $item->field . "='" . $item->data . "'";
                }
                else
                {
                    $filter_sql .= " AND w." . $item->field . "='" . $item->data . "'";
                }
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(w.id) as count FROM weight_histories w LEFT JOIN products p ON w.product_id=p.id WHERE w.site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
        $count = $result['count'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT w.*, p.sku,p.admin as padmin FROM weight_histories w LEFT JOIN products p ON w.product_id=p.id WHERE w.site_id=' . $this->site_id .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }

        $i = 0;
        foreach ($result as $data)
        {
            $response['rows'][$i]['cell'] = array(
                $data['id'],
                date('Y-m-d', $data['created']),
                $data['sku'],
                $data['old'],
                $data['new'],
                $users[$data['padmin']],
            );
            $i++;
        }
        echo json_encode($response);
    }
    public function action_product_taobao()
    {
        if ($_POST)
        {
            $type = Arr::get($_POST, 'type', 0);
            $sql = '';
            if ($type == 1){
                $sql = ' AND p.visibility = 1 AND p.status = 1';
                $result = DB::query(Database::SELECT, 'SELECT A.*,B.name AS picker_name
                    FROM(
                    SELECT p.sku, p.taobao_url, p.factory,p.display_date, s.name AS set_name, p.cost, p.total_cost, p.source, p.price, p.offline_factory, p.created, u.name AS u_name, p.offline_picker AS u_picker
                    FROM `products_product` p LEFT JOIN sets s ON p.set_id=s.id LEFT JOIN users u ON p.admin=u.id 
                    WHERE p.site_id=1 '.$sql.') A LEFT JOIN users B ON A.u_picker=B.id')
                ->execute('slave');
            }else{
                $result = DB::query(Database::SELECT, 'SELECT A.*,B.name AS picker_name
                    FROM(
                    SELECT p.sku, p.taobao_url, p.factory,p.display_date, s.name AS set_name, p.cost, p.total_cost, p.source, p.price, p.offline_factory, p.created, u.name AS u_name, p.offline_picker AS u_picker
                    FROM `products_product` p LEFT JOIN sets s ON p.set_id=s.id LEFT JOIN users u ON p.admin=u.id 
                    WHERE p.site_id=1) A LEFT JOIN users B ON A.u_picker=B.id')
                ->execute('slave');
            }
            ignore_user_abort(true);
            set_time_limit(0);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="Products_taobao.csv"');
//begin modify by L 2015-03-17
            echo "\xEF\xBB\xBF"."SKU,Taobao Url,Factory,Name,Cost,Total Cost,Source,Price,Offline Factory,Admin,Offline Picker,Created,Display_time\n";
            foreach ($result as $product)
            {
                echo $product['sku'], ',';
                echo '"'.$product['taobao_url'].'"', ',';
                echo '"'.str_replace("\n", " ", $product['factory']).'"', ',';
                echo $product['set_name'], ',';
                echo $product['cost'], ',';
                echo $product['total_cost'], ',';
                echo '"'.$product['source'].'"', ',';
                echo $product['price'], ',';
                echo '"'.str_replace("\n", " ", $product['offline_factory']).'"', ',';
                echo '"'.$product['u_name'].'"', ',';
                echo '"'.$product['picker_name'].'"', ',';
                echo date('Y-m-d H:i:s', $product['created']).'"', ',';
                echo date('Y-m-d H:i:s', $product['display_date']);
                echo PHP_EOL;
//end 2015-03-17
            }
        }
        else
        {
            echo
            '
<h3>导出产品采购信息</h3>
<form method="post">
<select name="type">
<option value="0">All product</option>
<option value="1">显示并上架</option>
</select>
<input type="submit" value="submit">
</form>    
';
        }
    }

    public function action_offline_export_sku()
    {
        if ($_POST)
        {
            $offline_factory = trim(Arr::get($_POST, 'offline_factory', ''));
            if (!$offline_factory)
                die('Input param error!');
            $result = DB::select('sku')->from('products_product')->where('offline_factory', '=', $offline_factory)->execute('slave');
            echo $offline_factory . ' SKUS:<br>';
            foreach ($result as $p)
            {
                echo $p['sku'] . '<br>';
            }
        }
    }

    public function action_stock_import()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $success = array();
        $error = array();
        $size = array(
            '35' => 'US4/UK2-UK2.5/EUR35/22.5cm',
            '36' => 'US5/UK3-UK3.5/EUR36/23cm',
            '37' => 'US6/UK4-UK4.5/EUR37/23.5cm',
            '38' => 'US7/UK5-UK5.5/EUR38/24cm',
            '39' => 'US8/UK6-UK6.5/EUR39/24.5cm',
            '40' => 'US9/UK7-UK7.5/EUR40/25cm',
            '41' => 'US10/UK8-UK8.5/EUR41/25.5cm'
        );
        $user_id = Session::instance()->get('user_id');
        $languages = Kohana::config('sites.' . $this->site_id . '.language');
        while ($data = fgetcsv($handle))
        {
            try
            {
                $data = Security::xss_clean($data);
                if ($data[0] == 'sku')
                {
                    $row++;
                    continue;
                }
                $sku = trim($data[0]);
                $product_id = Product::get_productId_by_sku($sku);
                if (!$product_id)
                    continue;
                $attr = trim($data[1]);
                $set = Product::instance($product_id)->get('set_id');
                if ($set == 2 AND array_key_exists($attr, $size))
                    $attribute = $size[$attr];
                else
                    $attribute = $attr;
                $attribute = str_replace('Size:', '', $attribute);
                $attribute = str_replace('size:', '', $attribute);
                $attribute = str_replace(';', '', $attribute);
                if(strpos($attribute, 'one') !== FALSE OR strpos($attribute, 'size') !== FALSE)
                    $attribute = 'one size';
                $attributes = Product::instance($product_id)->get('attributes');
                $sizeArr = array();
                if(isset($attributes['Size']))
                    $sizeArr = $attributes['Size'];
                elseif(isset($attributes['size']))
                    $sizeArr = $attributes['size'];
                if(!in_array($attribute, $sizeArr))
                {
                    $error[] = $sku . ' does not has Size: ' . $attribute;
                    continue;
                }
                $stocks = (int) trim($data[2]);
                $has = DB::select('id')->from('products_stocks')
                        ->where('site_id', '=', $this->site_id)
                        ->where('product_id', '=', $product_id)
                        ->where('attributes', '=', $attribute)
                        ->execute()->get('id');
                if ($has)
                {
                    $result = DB::update('products_stocks')->set(array('stocks' => $stocks))->where('id', '=', $has)->execute();
                }
                else
                {
                    $array = array(
                        'product_id' => $product_id,
                        'attributes' => $attribute,
                        'stocks' => $stocks,
                        'site_id' => $this->site_id,
//                        'admin' => $user_id
                    );
                    $result = DB::insert('products_stocks', array_keys($array))->values($array)->execute();
                }
                if ($result)
                {
                    $item_stocks = array();
                    $result = DB::select('attributes', 'stocks')->from('products_stocks')->where('product_id', '=', $product_id)->execute();
                    foreach($result as $r)
                    {
                        $item_stocks[$r['attributes']] = $r['stocks'];
                    }
                    DB::update('products')->set(array('stock' => -1, 'items' => serialize($item_stocks)))->where('id', '=', $product_id)->execute();
                    foreach($languages as $l)
                    {
                        if($l === 'en')
                            continue;
                        DB::update('products_' . $l)->set(array('stock' => -1))->where('id', '=', $product_id)->execute();
                    }
                    $success[] = "'$sku $attr' Add stocks Success";
                }
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        if (isset($success))
        {
            echo(implode("<br/>", $success));
        }
    }
    
    public function action_attribute_outstock()
    {
        echo '<table cellspacing="1" cellpadding="1" border="1">';
        echo '<tr><td width="100px">SKU</td><td width="100px">Admin</td><td width="100px">Source</td></tr>';
        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }
        $result = DB::query(DATABASE::SELECT, 'SELECT DISTINCT p.id, p.sku, p.admin,p.source FROM products_stocks s
            LEFT JOIN products p ON s.product_id = p.id WHERE p.stock = -1 AND p.visibility = 1 AND p.status = 1 AND s.stocks = 0')
            ->execute('slave')->as_array();

        foreach($result as $p)
        {
            $s_stock = DB::query(DATABASE::SELECT, 'SELECT SUM(stocks) as s_stock FROM products_stocks WHERE product_id = '.$p['id'])->execute('slave')->get('s_stock');
            if(!$s_stock)
            {
                $admin = isset($users[$p['admin']]) ? $users[$p['admin']] : '';
                echo '<tr><td>'.$p['sku'].'</td><td>'.$admin.'</td><td>'.$p['source'].'</td></tr>';
            }
        }
        echo '</table>';
    }

    public function action_no_sale()
    {
        $products = DB::select('id', 'sku', 'admin')
                ->from('products_product')
                ->where('visibility', '=', 1)
                ->where('status', '=', 1)
                ->where('stock', '<>', 0)
                ->execute('slave')->as_array();
        $_40 = time() - 40 * 86400;
        $sales = DB::query(DATABASE::SELECT, 'SELECT DISTINCT i.product_id FROM order_items i LEFT JOIN orders o ON i.order_id=o.id 
            WHERE i.status <> "cancel" AND o.payment_status = "verify_pass" AND o.is_active = 1 AND o.created >= ' . $_40)
                ->execute('slave')->as_array();
        $stocks = DB::select(DB::expr('DISTINCT sku'))
                ->from('order_instocks')
                ->where('site_id', '=', $this->site_id)
                ->where('status', '=', 0)
                ->execute('slave')->as_array();
        foreach ($products as $key => $p)
        {
            $pArr = array('product_id' => $p['id']);
            $skuArr = array('sku' => $p['sku']);
            if (in_array($pArr, $sales))
            {
                unset($products[$key]);
                continue;
            }
            elseif (in_array($skuArr, $stocks))
            {
                unset($products[$key]);
                continue;
            }
        }
        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Products_no_sale.csv"');
        echo "\xEF\xBB\xBF" . "SKU,Admin\n";
        foreach($products as $p)
        {
            echo $p['sku'] . ',';
            echo $users[$p['admin']] . ',';
            echo PHP_EOL;
        }
    }

    public function action_status_visibility()
    {
        $skus = Arr::get($_POST, 'SKUARR', '');
        if (!$skus)
        {
            echo 'Sku cannot be empty';
            exit;
        }
        else
        {
            echo '<table cellspacing="0" cellpadding="0" border="0">';
            echo '<tr><td width="100px">SKU</td><td width="100px">是否可见</td><td width="100px">是否在架</td></tr>';
            $skuArr = explode("\n", $skus);
            foreach ($skuArr as $sku)
            {
                $sku = trim($sku);
                $info = DB::query(DATABASE::SELECT,"SELECT `visibility`,`status` FROM `products_product` WHERE sku='".$sku."' limit 1")
                    ->execute('slave');
                $visibility = isset($info[0]['visibility'])?($info[0]['visibility']==1?"可见":"不可见"):"null";
                $status = isset($info[0]['status'])?($info[0]['status']==1?"上架":"下架"):"null";
                echo '<tr><td>' . $sku . '</td><td>' .$visibility. '</td><td>' .$status. '</td></tr>';
            }
            echo '</table>';
        }
    }

    public function action_products_offline(){
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="sku_offline.csv"');
        echo "SKU,OffLine,Admin,Factory\n";

        $products = DB::query(DATABASE::SELECT, "select p.sku,p.offline_factory,p.factory,u.name from products p 
            left join users u on p.admin=u.id where p.visibility=1 and p.status=1")->execute('slave');
        foreach ($products as $product)
        {
            echo $product['sku'], ',';
            echo '"' .$product['offline_factory']. '"', ',';
            echo '"' .$product['name']. '"', ',';
            echo '"' .$product['factory']. '"';
            echo PHP_EOL;
        }
    }

    public function action_special_bulk()
    {
        $file_types = array(
            "application/vnd.ms-excel",
            "text/csv",
            "application/csv",
            "text/comma-separated-values",
            "application/octet-stream",
            "application/oct-stream"
        );
        if (!isset($_FILES) || (!in_array($_FILES["file"]["type"], $file_types)))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $admin = Session::instance()->get('user_id');
        $success = array();
   //     $types = Kohana::config('promotion.types');
        while ($data = fgetcsv($handle))
        {

            try
            {
                if ($data[0] == 'SKU' OR $data[0] == 'sku')
                {
                    $row++;
                    continue;
                }
                $array = array();
                if ($data[0])
                {

                    $sku = $data[0];
                    $product_id = Product::get_productId_by_sku($sku);
                    if ($product_id)
                    {
                        $array['store'] = $data[1];


                        if ($array['store'])
                        {
                            $update = DB::update('products')->set($array)->where('id', '=', $product_id)->execute();
                            if ($update)
                                $success[] = $sku;
                        }

                    }
                    $row++;
                }
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        $successes = implode("<br/>", $success);
        die("Success skus:<br/>" . $successes);
    }

    public function action_importstore()
    {
        if ($_POST)
        {
            $offline_factory = trim(Arr::get($_POST, 'SKUARR', ''));
            $skuArr = explode("\n", $offline_factory);
             foreach ($skuArr as $sku){
            if (!$offline_factory)
                die('Input param error!');
            $result = DB::select('sku')->from('products_product')->where('store', '=', $sku)->execute('slave');
            echo $sku . ' SKUS:<br>';
            foreach ($result as $p)
            {
                echo $p['sku'] . '<br>';
            }
            echo '<br />';
        }
        }
    }

   public function action_upload_planame()
    {
        if ($_POST)
        {
            $Catanames = Arr::get($_POST, 'SKUARR', '');
            $Cata = explode("\n", $Catanames);

            foreach($Cata as $k=>$v){
                $arr[$k] =explode(',',$v);

            }

        foreach($arr as $v){
    $ret = DB::update('products')->set(array('pla_name' => $v[1]))
                                ->where('site_id','=',$this->site_id)
                                ->where('sku','=',$v[0])
                                ->execute();
        }
            if($ret){
                     message::set('批量操作成功');
                $this->request->redirect('/admin/site/product/list');              
            }
                 
        }
        else
        {
         $this->request->redirect('/admin/site/product/list');   
        }
    }

    //根据订单ordernum 批量导出 客户信息
   public function action_export_proname()
    {
        echo '<form style="margin:20px;" method="post" action="" target="_blank">
                    <textarea rows="20" cols="25" name="SKUARR"></textarea>
                    <input type="submit" value="导出" class="ui-button" style="padding:0 .5em">
                </form>';
        if($_POST)
        {
       $skus = Arr::get($_POST, 'SKUARR', '');
       $skuArr = explode("\n", $skus);
                 header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="customer.csv"');
            echo "\xEF\xBB\xBF" . "name,address,city,state,zip,country,phone,email,ordernum\n";

        $country = DB::query(DATABASE::SELECT,"SELECT name,isocode FROM countries")->execute('slave')->as_array();
        $arr = array();
        foreach($country as $v){
            $isocode = $v['isocode'];
            $arr[$isocode] = $v['name'];
        }

            foreach ($skuArr as $sku)
            {
                $info = DB::query(DATABASE::SELECT,"SELECT email,shipping_firstname,shipping_lastname,shipping_country,shipping_address,ordernum,shipping_state,shipping_city,shipping_phone,shipping_zip,ordernum FROM `orders_order` WHERE ordernum='".$sku."' limit 0,1")->execute('slave');
                    $add = str_replace(',', '' , $info[0]['shipping_address']);
                    $add = str_replace(PHP_EOL, '', $add);
                    $a = str_replace(',', '' , $info[0]['shipping_firstname']);
                    $a = str_replace(PHP_EOL, '', $a);
                    $b = str_replace(',', '' , $info[0]['shipping_lastname']);
                    $b = str_replace(PHP_EOL, '', $b);
                    $sta = str_replace(',', '' , $info[0]['shipping_state']);
                    $sta = str_replace(PHP_EOL, '', $sta);
                    $cit = str_replace(',', '' , $info[0]['shipping_city']);
                    $cit = str_replace(PHP_EOL, '', $cit);
                    $con = $info[0]['shipping_country'];
                    
                    echo $a.$b, ',';
                    echo $add, ',';
                    echo $cit. ',';
                    echo $sta, ',';
                    echo "'".$info[0]['shipping_zip'], ',';
                    echo $arr[$con], ',';
                    echo "'".$info[0]['shipping_phone'], ',';
                    echo $info[0]['email'], ',';       
                    echo $info[0]['ordernum'], ',';
                    echo "\n";

            }


        }

    }

    //根据订单ordernum 批量导出 客户信息
   public function action_export_profeed()
    {
        echo '<form style="margin:20px;" method="post" action="" target="_blank">
                    <textarea rows="20" cols="25" name="SKUARR"></textarea>
                    <input type="submit" value="导出" class="ui-button" style="padding:0 .5em">
                </form>';
        if($_POST)
        {
       $skus = Arr::get($_POST, 'SKUARR', '');
       $skuArr = explode("\n", $skus);
                 header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="customer.csv"');
            echo "\xEF\xBB\xBF" . "sku,imagelink,ProductLink,Name\n";


            foreach ($skuArr as $sku)
            {
                $proid = Product::get_productId_by_sku($sku);
                $product_instance = Product::instance($proid);
                $imageURL = Image::link($product_instance->cover_image(), 9);
                $plink = $product_instance->permalink();
                $name = $product_instance->get('name');
                    echo $sku, ',';
                    echo $imageURL, ',';
                    echo $plink. ',';
                    echo $name, ',';
                    echo "\n";

            }


        }

    }



    
    //批量导出产品原图链接
    public function action_image_link_export()
    {
        if($_POST)
        {
            $skus = trim(Arr::get($_POST, 'skus', ''));
            if($skus)
            {
                echo '<table>';
                $skuArr = explode("\n", $skus);
                foreach($skuArr as $sku)
                {
                    echo "<tr><td>" . $sku . "</td>";
                    $product_id = Product::get_productId_by_sku($sku);
                    $images = DB::select('id', 'suffix')->from('images')->where('site_id', '=', $this->site_id)->where('obj_id', '=', $product_id)->execute();
                    foreach($images as $image)
                    {
                         echo '<td><a target="_blank" href="'.STATICURL.'/pimg/o/'.$image['id'].'.'.$image['suffix'].'">'.STATICURL.'/pimg/o/'.$image['id'].'.'.$image['suffix'].'</a></td>';
                    }
                    echo '</tr>';
                }

                echo '</table>';
            }
        }
        else
        {
            echo '
<form method="post" action="">
Skus:<br>
<textarea name="skus" cols="40" rows="20"></textarea><br>
<input type="submit" value="Submit">
</form>
            ';
        }
        
    }

    public function action_from_id_export_products()
    {
        $skus = Arr::get($_POST, 'SKUARR', '');
        if (!$skus)
        {
            echo 'Sku cannot be empty';
            exit;
        }
        else
        {
            echo '<table cellspacing="0" cellpadding="0" border="0">';
            echo '<tr><td width="100px">id</td><td width="100px">sku</td></tr>';
            $skuArr = explode("\n", $skus);
            $id_sql = implode(',',$skuArr); 
            $info = DB::query(DATABASE::SELECT,"SELECT `id`,`sku` FROM `products_product` WHERE id in (".$id_sql.")")
                    ->execute('slave');
            foreach ($info as $value)
            {
                echo '<tr><td>' . $value['id'] . '</td><td>' .$value['sku']. '</td></tr>';
            }
            echo '</table>';
        }
    }

    public function action_visibility_update()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        foreach($languages as $lang)
        {
            if($lang == 'en')
                continue;
            echo $lang . ' products update visibility success:<br>';
            $result = DB::query(Database::SELECT, 'SELECT p.id, p.visibility AS visi, d.visibility AS s_visi FROM `products_product` p LEFT JOIN products_' . $lang . ' d ON p.id=d.id WHERE d.visibility != p.visibility')->execute('slave');
            foreach($result as $data)
            {
                $update = DB::update('products_' . $lang)->set(array('visibility' => $data['visi']))->where('id', '=', $data['id'])->execute();
                echo $data['id'] . ',';
            }
            echo '<br><br>';
        }
    }

    public function action_offline_picker()
    {
        if($_POST){
            $action = Arr::get($_POST, 'action', NULL);
            $start_date = Arr::get($_POST, 'start', NULL);
            $end_date = Arr::get($_POST, 'end', NULL);
            $d1= getdate();
            $firstday=$d1["year"]."-".$d1["mon"]."-1";
            $start = $start_date?strtotime($start_date):strtotime($firstday);
            $end = $end_date?strtotime($end_date):time();
            if($action==1){
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="picker_new_product.csv"');
                echo "选款人,时间内上新量,所有上新量(不按时间),在架数(不按时间)\n";

                $admins = DB::query(DATABASE::SELECT, "select DISTINCT(P.`offline_picker`) AS aid,u.`name` FROM products P 
                    LEFT JOIN users u ON P.`offline_picker`=u.id WHERE P.`offline_picker` IS NOT NULL and P.`offline_picker`!=0")->execute('slave');
                foreach ($admins as $admin)
                {
                    $count=DB::query(DATABASE::SELECT, "select `id` FROM products WHERE `offline_picker`=".$admin['aid']." and (`created`>=".$start." and `created`<".$end.")")->execute('slave')->count();
                    $allcount=DB::query(DATABASE::SELECT, "select `id` FROM products WHERE `offline_picker`=".$admin['aid'])->execute('slave')->count();
                    $instock=DB::query(DATABASE::SELECT, "select `id` FROM products WHERE `offline_picker`=".$admin['aid']." AND `visibility`=1 AND `STATUS`=1")->execute('slave')->count();
                    echo $admin['name'], ',';
                    echo $count, ',';
                    echo $allcount, ',';
                    echo $instock, ',';
                    echo PHP_EOL;
                }
            }elseif($action==2){
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="picker_order.csv"');
                echo "选款人,时间内销量,时间内Sku销售个数\n";
                //时间段内销售的产品ID
                $sale_products=DB::query(DATABASE::SELECT, "select DISTINCT(I.`product_id`),P.`sku`,P.`offline_picker` FROM order_items I LEFT JOIN orders O ON O.`id`=I.`order_id` LEFT JOIN `products` P ON I.`product_id`=P.id where O.`payment_status` in('verify_pass','success') and O.`verify_date`>=".$start." and O.`verify_date`<".$end)->execute('slave');
                $picker_products=array();
                foreach($sale_products as $sale_product){
                    if($sale_product['offline_picker']&&$sale_product['sku']){
                        $picker_products[$sale_product['offline_picker']][]=$sale_product['product_id'];
                    }
                }
                foreach($picker_products as $k=>$picker_product){
                    $qty=DB::query(DATABASE::SELECT, "select SUM(I.`quantity`) AS qty FROM order_items I LEFT JOIN orders O ON O.`id`=I.`order_id` LEFT JOIN `products` P ON I.`product_id`=P.id WHERE P.`offline_picker`=".$k." and O.`payment_status` in('verify_pass','success') and O.`verify_date`>=".$start." and O.`verify_date`<".$end)->execute('slave')->get('qty');
                    echo user::instance($k)->get('name'), ',';
                    echo $qty, ',';
                    echo count($picker_product), ',';
                    echo PHP_EOL;
                }
            }elseif($action==3){
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="picker_order_product.csv"');
                echo "选款人,时间内上新产品对应的总销量\n";
                $admins = DB::query(DATABASE::SELECT, "select DISTINCT(P.`offline_picker`) AS aid,u.`name` FROM products P 
                    LEFT JOIN users u ON P.offline_picker=u.id WHERE P.`offline_picker` IS NOT NULL and P.`offline_picker`!=0")->execute('slave');
                foreach ($admins as $admin) {
                    $qty=DB::query(DATABASE::SELECT, "select SUM(I.`quantity`) AS qty FROM order_items I LEFT JOIN `products` P ON I.`product_id`=P.id LEFT JOIN `orders` O ON I.`order_id`=O.id WHERE P.`offline_picker`=".$admin['aid']." and O.`payment_status` in('verify_pass','success') and P.`created`>=".$start." and P.`created`<".$end)->execute('slave')->get('qty');
                    $qty=$qty?$qty:0;
                    echo $admin['name'], ',';
                    echo $qty, ',';
                    echo PHP_EOL;
                }
            }
        }else{
            $content = View::factory('admin/site/product_picker')->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
    }

    public function action_product_attributes()
    {
        if ($_POST)
        {
            if (!$_POST['SKUARR'])
            {
                Message::set('请输入产品的sku', 'notice');
                $this->request->redirect('/admin/site/product/product_attributes');
            }
            $productArr = explode("\n", $_POST['SKUARR']);
            $products=array();
            foreach ($productArr as $sku)
            {
                $pid=Product::instance()->get_productId_by_sku(trim($sku));
                if($pid){
                    $products[]=$pid;
                }
            }
            $content = View::factory('admin/site/product_attributes')->set('products',$products)->render();
        }else{
            $content = View::factory('admin/site/product_attributes')->render(); 
        }
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }
    
    //导出包含所有sorts的产品表--by L 2015-04-10
    public function action_export_pro_sorts(){
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="pro_sorts.csv"');
        
        //获取要导出产品的数量,超过2000则进行分组
        $num_sql = 'select count(*) num from products p where ';
        if($from=strtotime($_POST['from'])){
            $num_sql .= " p.created > '$from'";
        }else {
            $num_sql .= " p.created > 0";
        }
        if($to=strtotime($_POST['to'])){
            $num_sql .= " and p.created < '$to'";
        }
        $num = DB::query(DATABASE::SELECT, $num_sql)->execute('slave')->get('num');
        $number = ceil($num/2000);
        
        //获取首字母大写的sorts数组
        $sorts=DB::query(DATABASE::SELECT, 'SELECT sort,group_concat(attributes) type FROM `catalog_sorts` group by sort')->execute('slave');
        $catalog_sorts = array();
        foreach($sorts as $key => $value){
            $catalog_sorts[$value['sort']] = explode(',',$value['type']);
        }
        foreach($catalog_sorts as $sort=>$content){
            foreach($content as $key=>$value){
                $catalog_sorts[$sort][$key] = ucwords(strtolower($value));
            }
        }
        
        $catalog_array = array();
        foreach($catalog_sorts as $key=>$value){
            $catalog_array[] = $key;
        }
        echo "\xEF\xBB\xBF" . "id,name,sku,set_name,default_catalog,catalog,".implode(',',$catalog_array)."\n";
        
        //进行分组导出
        for($i=0;$i<$number;$i++){
            $sql='SELECT p.id id,p.name name, p.sku sku, s.name set_name, c1.name default_catalog, GROUP_CONCAT( c2.name ) catalog, p.filter_attributes sorts
                    FROM products p
                    LEFT JOIN sets s ON p.set_id = s.id
                    LEFT JOIN catalogs c1 ON p.default_catalog = c1.id
                    LEFT JOIN catalog_products cp ON cp.product_id = p.id
                    LEFT JOIN catalogs c2 ON cp.catalog_id = c2.id where';
            //判断是否传递开始时间及结束时间
            if($from=strtotime($_POST['from'])){
                $sql .= " p.created > '$from'";
            }else {
                $sql .= " p.created > 0";
            }
            if($to=strtotime($_POST['to'])){
                $sql .= " and p.created < '$to'";
            }

            $sql.=" group by p.id limit ".(2000*$i).",2000";

            $products = DB::query(DATABASE::SELECT, $sql)->execute('slave')->as_array();
            //将sorts进行explode
            foreach($products as $key=>$value){
                $products[$key]['sorts'] = explode(';',$value['sorts']);
            }
            //判断sorts中的数据在$catalog_sorts内容中存在的值进行key=>value的赋值
            foreach($products as $key=>$value){
                foreach($value['sorts'] as $key2=>$value2){
                    foreach($catalog_sorts as $sort=>$content){
                        if(in_array(ucwords(strtolower($value2)), $content)){
                            $products[$key]['sorts'][$sort] = ucwords(strtolower($value2));
                        }
                    }
                }
            }
            //在product的二维上添加所有sort种类
            foreach($products as $key => $value){
                foreach($catalog_array as $value2){
                    $products[$key][$value2] ='';
                }
            }
            
            //将product三维中存在的数据赋值给二维,
            foreach($products as $key => $value){
                foreach($value['sorts'] as $key2=>$value2){
                    if(in_array($key2,$catalog_array)){
                        $products[$key][$key2]=$value2;
                    }
                }
                unset($products[$key][0]);
                unset($products[$key]['sorts']);
            }
            //输出
            foreach($products as $key => $column){
                foreach($column as $value){
                    echo '"'.$value.'"'.',';
                }
                echo PHP_EOL;
            }
            
        }
        
    }

    #品类经理批量入库操作
    public function action_catemanger()
    {        
        if($_POST)
        {
            $catemanger = Arr::get($_POST, 'catemanger', '');
            if(empty($catemanger))
            {
                message::set('清检查数据格式是否正确！');
                $this->request->redirect('/admin/site/product/list');             
            }
            $cate = explode("\n", $catemanger);;
            $cateArr = array();
            foreach ($cate as $k=>$v) {
                $cateArr[$k] = explode(',', trim($v));
            }
            #循环入库
            $state = false;
            foreach ($cateArr as $manger) 
            {
                $result = DB::update('sets')->set(array('catemanger' => $manger[1]))->where('name','=', $manger[0])->execute();
                $result ? $state = true : $state = false;
            }
            if($state){
                message::set('批量操作成功');
                $this->request->redirect('/admin/site/product/list');
            }else{
                message::set('批量操作成功');
                $this->request->redirect('/admin/site/product/list');
            }
        }        
    }

    #按需求导表 
    public function action_tborder(){
        set_time_limit(0);
/*        ini_set("memory_limit", "2048M");
        $file_types = array("application/vnd.ms-excel","text/csv","application/csv","text/comma-separated-values","application/octet-stream","application/oct-stream");
        if (!isset($_FILES) || (!in_array($_FILES["tb_file"]["type"], $file_types))) die("Only csv file type is allowed!");
        $handle = fopen($_FILES["tb_file"]["tmp_name"], "r");
        header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
        header('Content-type:application/vnd.ms-excel');//输出的类型
        header('Content-Disposition: attachment; filename="prolist_order.csv"'); //下载显示
        echo iconv("UTF-8", "GBK//IGNORE",'订单号,运单号,发货时间,投递时间,国家,系统'."\r\n");*/
        $i=0;
        while ($data = fgetcsv($handle))
        {
            $i++;
            try { 
                $ordernum = $data[0];  $trac = $data[1];  $system = $data[5];
                if($i>2000 && $i<=3000){
                    $sql = DB::query(Database::SELECT, 'select order_id,ship_date from order_shipments where tracking_code = "'.$data[1].'"')->execute()->current();
                    $sql1 = DB::query(Database::SELECT, 'select deliver_time,shipping_country from orders where id = "'.$sql['order_id'].'"')->execute()->current();
                    //$sql_row = DB::query(Database::SELECT, 'select a.ordernum,a.deliver_time,a.shipping_country,b.ship_date from orders as a,order_shipments as b where a.id = b.order_id and b.tracking_code = "'.$data[1].'"')->execute()->current();
                    $ship_date = date('Y-m-d', $sql['ship_date']);
                    $deliver_time = date('Y-m-d', $sql1['deliver_time']);
                    $shipp = $sql1['shipping_country'];
                    echo iconv("UTF-8", "GBK//IGNORE", ($ordernum.','.$trac.','.$ship_date.','.$deliver_time.','.$shipp.','.$system.',')."\r\n");
                }
            } catch (Exception $e) {
                
            }
        }
    }

    //根据sku查询文字描述
    public function action_getdesc(){
        
        if($_POST){
            $skus = Arr::get($_POST, 'SKUARR', '');
            $skuArr = explode("\n", $skus);
            foreach ($skuArr as $sku)
            {
                $row = DB::query(Database::SELECT, 'select description from products where sku = "'.$sku.'"')->execute()->current();
                $desc = explode('.', $row['description']);
                echo strip_tags($desc[0]) . '<br>';
            }
        }else{
            echo '<form style="margin:20px;" method="post" action="" target="_blank">
                    <textarea rows="20" cols="25" name="SKUARR"></textarea>
                    <input type="submit" value="导出" class="ui-button" style="padding:0 .5em">
                </form>';
        }
    }

    public function action_getdeliver()
    {
        if($_POST)
        {
            $skus = Arr::get($_POST, 'SKUARR', '');
            $skuArr = explode("\n", $skus);
            //header('Content-Type: application/vnd.ms-excel');
            //header('Content-Disposition: attachment; filename="customer.csv"');
            //echo "\xEF\xBB\xBF" . "订单号,运单号,发货时间,投递时间,系统\n";  
            foreach ($skuArr as $sku)
            {
                $info = DB::query(DATABASE::SELECT,"SELECT os.ordernum,os.ship_date,o.deliver_time FROM order_shipments os left join orders o on os.order_id = o.id WHERE os.tracking_code='".$sku."' limit 0,1")->execute('slave');
                // echo $info[0]['ordernum'], ',';
                // echo $sku, ',';
                echo date('Y-m-d', $info[0]['ship_date']) . '<br>';
                //echo date('Y-m-d', $info[0]['deliver_time']) . "<br>";
                //echo 'choies', ',';
                //echo "\n";
            }
        }else{
            echo '<form style="margin:20px;" method="post" action="" target="_blank">
                    <textarea rows="20" cols="25" name="SKUARR"></textarea>
                    <input type="submit" value="导出" class="ui-button" style="padding:0 .5em">
                </form>';
        }      
    }

    public function action_import_extra(){
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=customers.csv');  
        echo "\xEF\xBB\xBF" . "sku,keywords\n"; 
 $result = DB::query(DATABASE::SELECT, "SELECT sku,keywords from products where extra_fee>0")->execute(); 
          foreach($result as $v)
        {  

            echo $v['sku']. ',';
            echo $v['keywords']. ',';
            echo "\n";
        }
    }


    //抽奖：1.批量导出获奖者的报表 2015.10.23
    public function action_draw_userlist()
    {
        if($_POST)
        {
            $draw_from = strtotime(Arr::get($_POST, 'draw_from'));
            $draw_to = strtotime(Arr::get($_POST, 'draw_to'));
            $userlist = DB::query(Database::SELECT, 'select email,draw_name,created,ip,position,portion from customer_draw where created between "'.$draw_from.'" and "'.$draw_to.'"')->execute()->as_array();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="Drawlist.csv"');
            echo "User Email,Ip,Created Time,Prize\n";
            foreach ($userlist as $v) {
                echo $v['email'] . ",";
                echo $v['ip'] . ",";
                echo $v['created'] . ",";
                echo $v['prize'] . PHP_EOL;
            }
        }
    }
    
    //抽奖：2.后台增添假获奖者录入区域，可以控制具体位置 2015.10.23
    public function action_draw_position()
    {
         if($_POST)
         {
            $draw_arr = array(
                    'email' => Arr::get($_POST, 'email'),
                    'draw_name' => Arr::get($_POST, 'draw_name'),
                    'position'  => Arr::get($_POST, 'position'),
                    'created'   => strtotime(Arr::get($_POST, 'created')),
                    'ip'        => ip2long(Request::$client_ip)
            );
            $email_chk = DB::query(Database::SELECT, 'select email from customer_draw where email = "'.$draw_arr['email'].'"')->execute()->current();
            if($email_chk){
                Message::set('当前邮箱已存在，请不要重复录入哦');
                $this->request->redirect('admin/site/product/list');
            }
            $draw_in = DB::insert('customer_draw', array_keys($draw_arr))->values($draw_arr)->execute();
            if($draw_in){
                Message::set('添加成功');
                $this->request->redirect('admin/site/product/list');
            }else{
                Message::set('添加失败');
                $this->request->redirect('admin/site/product/list');
            }
         }
    }
    
    //抽奖：3. 抽奖参与奖项录入 2015.10.23
    public function action_draw_portion()
    {
        if($_POST)
        {
            $draw_arr = array(
                    'draw_name' => Arr::get($_POST, 'draw_name'),
                    'probability' => Arr::get($_POST, 'probability'),
                    'created'   => strtotime(Arr::get($_POST, 'created')),
                    'coupon_id' => Arr::get($_POST, 'coupon_id')
            );
            //检查折扣券是否存在
            if($draw_arr['coupon_id'] != '0'){
                $coupon_id = DB::query(Database::SELECT, 'select id from carts_coupons where id = "'.$draw_arr['coupon_id'].'"')->execute()->current();
                if(!$coupon_id){
                    Message::set('当前折扣券号不存在，请核对后再进行此操作','error');
                    $this->request->redirect('admin/site/product/list');
                }
            }           
            $draw_in = DB::insert('customer_bability', array_keys($draw_arr))->values($draw_arr)->execute();
            if($draw_in){
                Message::set('添加成功','success');
                $this->request->redirect('admin/site/product/list');
            }else{
                Message::set('添加失败','error');
                $this->request->redirect('admin/site/product/list');
            }
        }
    }
    
    //抽奖修改
    public function action_drawlist()
    {
        if($_POST)
        {
            //概率修改
            $id = Arr::get($_POST, 'id');
            $babil = Arr::get($_POST, 'babil');
            $edit_is = DB::query(Database::UPDATE, 'update customer_bability set probability = "'.$babil.'" where id = "'.$id.'"')->execute();exit;
        }
        $userlist = DB::query(Database::SELECT, 'select id,draw_name,probability,coupon_id,created from customer_bability order by id desc')->execute()->as_array();
        $userArr = array();
        foreach ($userlist as $v) 
        {
            $userArr[] = array(
                    'id' => $v['id'],
                    'draw_name'   => $v['draw_name'],
                    'probability' => $v['probability'],
                    'coupon_id'   => $v['coupon_id'],
                    'created'     => date('Y-m-d', $v['created'])
            );
        }
        echo json_encode($userArr);exit;
    }

    //数据导出
    public function action_dataout()
    {
        $row = DB::query(Database::SELECT, 'select description,sku from products order by id desc')->execute()->as_array();
        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename=productlist.csv');
        echo "\xEF\xBB\xBF" . "SKU,描述\n";
        foreach ($row as $v) {
            $add = str_replace(',', '' , $v['description']);
            $add = str_replace(PHP_EOL, '', $add);
            $html = strip_tags($add);
            echo $v['sku'] . ",";
            echo $html . "\n";
        }
    }

    //Guo 11.19 tag管理
    public function action_tag()
    {     
       $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        $cache = Arr::get($_GET, 'cache',0);
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        $tag = Tag::getalltag($lang);

        $content = View::factory('admin/site/product_tag')
//                        ->set('times', $times)
            ->set('languages', $languages)
            ->set('lang', $lang)
            ->set('tag',$tag)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_taglist()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = $this->request->param('id');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        if(!$lang){
          $banners = DB::query(Database::SELECT, 'SELECT * FROM tags ORDER BY position DESC, id DESC')->execute('slave')->as_array();            
        }else{
          $banners = DB::query(Database::SELECT, 'SELECT * FROM tags_'.$lang.' ORDER BY position DESC, id DESC')->execute('slave')->as_array();    
        }

        $content = View::factory('admin/site/tag_list')->set('tags', $banners)->set('lang', $lang)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();        
    }

    public function action_edittag()
    {
        $id = $this->request->param('id');
        $lang = Arr::get($_GET, 'lang', '');
        if ($_POST)
        {
            $lang = Arr::get($_GET, 'lang', '');
            $data = array();
            $data['link'] = $_POST['link'];

            if (!$data['link'])
            {
                Message::set(__('Parameter Error'), 'error');
                Request::instance()->redirect('admin/site/banner/edit/' . $id);
            }

            $data['name'] = $_POST['name'];
            $data['position'] = $_POST['position'];
            
            if($lang){
               $result = DB::update('products_tags_'.$lang)->set($data)->where('id', '=', $id)->execute();
            }else{
               $result = DB::update('products_tags')->set($data)->where('id', '=', $id)->execute();
            }
            
            if ($result)
            {
                Message::set('Edit tag success', 'success');
                if($lang){
                Request::instance()->redirect('admin/site/product/edittag/' . $id.'?lang='.$lang);
                }else{
                Request::instance()->redirect('admin/site/product/edittag/' . $id);    
                }
            }
        }
        if($lang){
          $banner = DB::select()->from('products_tags_'.$lang)->where('id', '=', $id)->execute('slave')->current();
        }else{
            $banner = DB::select()->from('products_tags')->where('id', '=', $id)->execute('slave')->current();
        }
        
        $content_data['banner'] = $banner;
        $content = View::factory('admin/site/tag_edit', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_addtag()
    {
        if ($_POST)
        {   


            $data['link'] = $_POST['link'];

            $lang = $_POST['lang'];
            if (!$data['link'])
            {
                Message::set(__('Parameter Error'), 'error');
                Request::instance()->redirect('admin/site/product/addtag');
            }
            $data['name'] = $_POST['name'];
            $data['position'] = $_POST['position'];
            if($lang){
               $result = DB::insert('products_tags_'.$lang, array_keys($data))->values($data)->execute();
            }else{
               $result = DB::insert('products_tags', array_keys($data))->values($data)->execute();
            }
            
            if ($result)
            {
                Message::set('Edit tag success', 'success');
                if($lang){
                Request::instance()->redirect('admin/site/product/taglist/'.$lang);    
                }else{
                Request::instance()->redirect('admin/site/product/taglist');                    
                }

            }
            else
            {
                Message::set('Edit tag faild', 'error');
                Request::instance()->redirect('admin/site/product/addtag');
            }
        }

        $content = View::factory('admin/site/tag_add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }
    
    
    
    //wkf    2.26  新建一个seo_edit 
    public function action_seo_edit()
    {
        //$lang = Arr::get($_GET, 'lang', '');
        $id = Arr::get($_GET, 'id', '');
        $lang = Arr::get($_GET, 'lang', '');
        
        if($id){
            if($lang=='en' || $lang==''){
                $result=DB::query(Database::SELECT, 'select id,meta_title,meta_keywords,meta_description from catalogs where id = '.$id)->execute('slave')->current();
            }else{
                $result=DB::query(Database::SELECT, 'select id,meta_title,meta_keywords,meta_description from catalogs_'.$lang.' where id = '.$id)->execute('slave')->current();
            }

        }else{
            echo "error";
            exit;
        }

        $content_data=array();
        $content = View::factory('admin/site/tag_seo_edit', $content_data)->set('result',$result)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }
    
    function action_seo_submit()
    {
        $data=array();
        $id = Arr::get($_POST, 'id', '');
        $lang = Arr::get($_GET, 'lang', '');
        if(!$lang){
            $lang = Arr::get($_POST, 'lang', '');
        }
        $data['meta_title'] = Arr::get($_POST, 'meta_title', '');
        $data['meta_keywords'] = Arr::get($_POST, 'meta_keywords', '');
        $data['meta_description'] = Arr::get($_POST, 'meta_description', '');
        
        if(count($data)>0)
        {
            
            if($lang=='en' || $lang==''){
                $result = DB::update('catalogs')->set($data)->where('id', '=', $id)->execute();
            }else{
                $result = DB::update('catalogs_'.$lang)->set($data)->where('id', '=', $id)->execute();
            }
            if ($result)
            {
                Message::set('Edit tag_seo_edit success', 'success');
                if($lang=='en' || $lang==''){
                    Request::instance()->redirect('admin/site/product/seo_edit?id=' . $id);
                }else{
                    Request::instance()->redirect('admin/site/product/seo_edit?id=' . $id.'&lang='.$lang);
                }
            }
        }
        exit;
    }

    function action_products_relate()
    {
        if ($_POST)
        {
            $catalog_id = Arr::get($_POST, 'tag_id', 0);
            $SKUs = Arr::get($_POST, 'SKUARR', '');
            $skuArr = explode("\n", $SKUs);
            $result = DB::select('id')
                ->from('products_product')
                ->where('sku', 'IN', $skuArr)
                ->execute('slave')
                ->as_array();
            $products = array();
            foreach ($result as $product)
            {
                $products[] = $product['id'];
            }
            if (!empty($products))
            {
                Tag::instance($catalog_id)->set_products($catalog_id, $products);
            }
            message::set('关联tag产品成功！');
            $this->request->redirect('/admin/site/product/tag');
        }
        else
        {
            $this->request->redirect('/admin/site/product/tag');
        }
    }

    function action_products_add()
    {
        if ($_POST)
        {
            $catalog_id = Arr::get($_POST, 'tag_id', 0);
            $SKUs = Arr::get($_POST, 'SKUARR1', '');
            $skuArr = explode("\n", $SKUs);
            $result = DB::select('id')
                ->from('products_product')
                ->where('sku', 'IN', $skuArr)
                ->execute('slave')
                ->as_array();
            $products = array();
            foreach ($result as $product)
            {
                $products[] = $product['id'];
            }
            if (!empty($products))
            {
                Tag::instance($catalog_id)->add_products($catalog_id, $products);
            }
            message::set('添加tag产品成功！');
            $this->request->redirect('/admin/site/product/tag');
        }
        else
        {
            $this->request->redirect('/admin/site/product/tag');
        }
    }

    function action_products_delete()
    {
        $id = $this->request->param('id');
        $dele = Tag::deleteallsku($id);
        if($dele){
            $this->request->redirect('/admin/site/product/tag');
        }
    }

    function action_look()
    {
        $id = $this->request->param('id');
        $skus = Tag::getallsku($id);

        if($skus){
            foreach($skus as $v){
                echo Product::instance($v)->get('sku');
                echo '<br>';
            }            
        }else{
            echo 'no result';
        }

    }
    
    /**
     * 获取product具体信息
     * @return doc表
     * add 2016-01-11
     */
    function action_export_productspecific()
    {
        if($from=strtotime($_POST['from'])){
            $where_sql .= " p.created > '$from'";
        }else {
            $where_sql .= " p.created > 0";
        }
        if($to=strtotime($_POST['to'])){
            $where_sql .= " and p.created < '$to'";
        }
        var_dump($where_sql);
        exit;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="productspecific.csv"');
        echo "Created,SKU,Taobao Url\n";

        $products = DB::query(DATABASE::SELECT, 'SELECT created,sku,taobao_url FROM products WHERE site_id=' . $this->site_id . ' AND status=0 AND visibility=1 ORDER BY id')->execute('slave');
        foreach ($products as $product)
        {

            echo date('Y-m-d', $product['created']), ',';
            echo '"' . $product['sku'] . '"', ',';
            echo '"' . iconv('utf-8', 'gbk', $product['taobao_url']) . '"', PHP_EOL;
        }
    }
    /**
    *输入sku,导出对应admin
    *return type--csv
    *zpz
    *20160121
    */

    public function action_export_admin_by_sku()
    {
        $skus = Arr::get($_POST, 'SKUARR', '');
        $skuArr = explode("\n", $skus);
        header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
        header('Content-type:application/vnd.ms-excel');//输出的类型
        header('Content-Disposition: attachment; filename="prolistinfo.csv"'); //下载显示
        echo iconv("UTF-8", "GBK//IGNORE",'SKU,Admin'."\r\n");

        foreach ($skuArr as $sku)
        {

            try {

                $res = DB::query(Database::SELECT, 'SELECT p.sku sku,u.name admin from products p left JOIN users u on p.admin=u.id where p.sku="'.$sku.'" limit 1 ')->execute()->current();
                
                if(!empty($res))
                {
                    echo iconv("UTF-8", "GBK//IGNORE", $res['sku'].",".$res['admin']."\r\n");
                }
                      
            }catch (Exception $e) {}
        }
    }

    public function action_getmemcacheuse()
    {
        $products = DB::query(DATABASE::SELECT, 'SELECT id FROM products WHERE visibility = 1 and status =1 ORDER BY id desc')->execute('slave');

        $total = 0;
        $cache = Cache::instance('memcache');
        foreach($products as $value)
        {
            $product_instance = Product::instance($value['id']);
            $memcachekey = 'products_product/'.$product_instance->get('link').'_p'.$value['id'].'_1';
            $memcachekey = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $memcachekey);
            $havecache = 0;
            
            $memcachevalue = $cache->get($memcachekey);
            if (!empty($memcachevalue))
            {
                $havecache = 1;
                $total += 1;
            }
            echo $value['id'].'------'.$product_instance->get('sku').'--------'.$havecache.'<br />';
        }

        $tbaifen = round($total/(count($products)) * 100,2);
        echo '产品页缓存比率'.$tbaifen.'%';
    }

    public function action_getcatalogmemcache()
    {
      $catalogs = DB::query(DATABASE::SELECT, 'SELECT id FROM catalogs WHERE visibility = 1 ORDER BY id desc')->execute('slave');  

        $total = 0;
        $cache = Cache::instance('memcache');
        $gets = array(
            'page' => (int) Arr::get($_GET, 'page', 0),
            'limit' => (int) Arr::get($_GET, 'limit', 0),
            'sort' => (int) Arr::get($_GET, 'sort', 0),
            'pick' => (int) Arr::get($_GET, 'pick', 0),
        );

        $country_area = Arr::get($_GET, 'area', 'US');

        foreach($catalogs as $value)
        {
            $catalog_instance = Catalog::instance($value['id']);
            $memcachekey = 'catalog_new1_'.$catalog_instance->get('link').'-c-'.$value['id'].'_' . implode('_', $gets)  . "_" . $country_area;
            $memcachekey = preg_replace('/[^A-Za-z0-9_\/\-]+/i', '', $memcachekey);

            $havecache = 0;
            
            $memcachevalue = $cache->get($memcachekey);
            if (!empty($memcachevalue))
            {
                $havecache = 1;
                $total += 1;
            }
            echo $value['id'].'------'.$catalog_instance->get('link').'-c-'.$value['id'].'--------'.$havecache.'<br />';
        }

        $tbaifen = round($total/(count($catalogs)) * 100,2);
        echo '分类页缓存比率'.$tbaifen.'%,国家为:'.$country_area;
    }

    public function action_product_stocks()
    {
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=product_stock.csv');  
        echo "\xEF\xBB\xBF" . "sku,attributes,stocks\n";  
 $result = DB::query(DATABASE::SELECT, "select p.sku,ps.attributes,ps.stocks from products_stocks ps INNER JOIN products p on ps.`product_id` = p.id and p.stock = -1")->execute();
 
        foreach($result as $v)
        {  
            echo $v['sku'] . ',';
            echo $v['attributes'] . ',';
            echo $v['stocks']. ',';
            echo "\n";
        }
    }

    public function action_product_stock_status()
    {
        error_reporting(E_ALL);
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=product_stock.csv');  
        echo "\xEF\xBB\xBF" . "sku,attributes,stocks\n";   
        $result = DB::query(DATABASE::SELECT, "select product_id,attributes,stocks from products_stocks where isdisplay = 0 and stocks !=0 order by id desc")->execute('slave')->as_array();
        foreach ($result as $key => $v) 
        {
            $proins = Product::instance($v['product_id']);
            $status = $proins->get('status');
            $stocks = $proins->get('stock'); 
            $sku = $proins->get('sku');

            if($stocks != -99 && $v['stocks'] > 0)
            {
                echo $sku . ',';
                echo $v['attributes'] . ',';
                echo $v['stocks']. ',';
                echo "\n";                  
            }

        }
    }

    public function action_export_productstatus()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=product_stock.csv'); 
        echo "\xEF\xBB\xBF" . "sku,attributes,stocks\n";
         $result = DB::query(DATABASE::SELECT, "SELECT DISTINCT product_id, stocks, attributes FROM products_stocks WHERE stocks !=0")->execute('slave')->as_array();
        
        $skus = array();
         foreach ($result as $key => $v) 
         {
            $proins = Product::instance($v['product_id']);
            $status = $proins->get('status');
            $sku = $proins->get('sku');
            $stocks = $proins->get('stock');
            $visibility = $proins->get('visibility'); 
            if(($status == 0 or $visibility == 0) && $stocks != -99)
            {
                if($sku && !in_array($sku, $skus))
                {
                    array_push($skus, $sku);                    
                }              
            }
         }

        if(!empty($skus))
        {
            $skus = implode($skus, ',');
            $url='http://erp.wxzeshang.com:8000/api/choies_get_item_qty/';
            $post_data=array('skus'=>$skus);
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data);
            $product_info = curl_exec ( $ch );
            curl_close($ch);

            $product_info = json_decode($product_info);

            foreach ($product_info as $key => $value) 
            {
                $sku1 = $key;
                foreach ($value as $key2 => $value2)
                {
                    echo '"'.$sku1.'"'.',';
                    echo '"'.$key2.'"'.',';
                    echo '"'.$value2.'"'.',';
                    echo "\n";     
                }
            }
        }


    }

    public function action_regist_sku()
    {
        $skus = Arr::get($_POST, 'prosku', '');
        $skuarr = explode(',',$skus);
        $newarr = array();
        foreach ($skuarr as $key => $value)
        {
            
            $product_id = Product::get_productId_by_sku($value);
            $proins = Product::instance($product_id);

            if(!$proins->get())
            {
               echo '部分SKU存在问题请检查';
               die;
            }

            $newarr[] = $product_id;

        }            
            
        $cache = Cache::instance('memcache');
        if(count($newarr) == 2)
        {

            $cache->set('giftsku',$newarr,30*86400);
            $skustr = implode(',', $newarr);
            if($newarr[0] > $newarr[1])
            {
                $free = DB::query(Database::SELECT, 'select id,price,sku,type from products where id in ('. $skustr .') order by id desc')->execute('slave')->as_array();                
            }
            else
            {
                $free = DB::query(Database::SELECT, 'select id,price,sku,type from products where id in ('. $skustr .')')->execute('slave')->as_array();
            }

            $cache_zhuceyouli_key = '12site_zhuceyouli_choies_123';
            $cache->set($cache_zhuceyouli_key, $free, 3600); 
            echo '设置成功';
        }
    }

    public function action_uploadsku()
    {
        header("content-type:text/html;charset=utf-8");
        $skus = Arr::get($_POST, 'SKUARR', ''); 
        $skuarr = explode("\n",$skus);
        if(count($skuarr) == 8)
        {
            foreach ($skuarr as $key => $value)
            {           
                $product_id = Product::get_productId_by_sku($value);
                $proins = Product::instance($product_id);

                if(!$proins->get())
                {
                   echo '部分SKU存在问题请检查';
                   die;
                }
            }  

            $cache = Cache::instance('memcache');
            $cache->set('indexsku',$skuarr,30*86400);
            $skuarr1 = $cache->get('indexsku');
            echo '<pre>';
            print_r($skuarr1);
            echo '成功修改手机版推荐产品';
        }
        else
        {
            echo 'sku个数错误';
        }
    }
    
    
    public function action_selectproduct()
    {
        header("Content-type: text/html; charset=utf-8"); 
        $page = Arr::get($_GET, 'page', 1);
        $limit = 2000;
        //->limit($limit)
            //->offset(($page - 1) * $limit)
        $product_id = DB::query(Database::SELECT, 'select i.id id,p.id product_id from images i LEFT JOIN products p on i.obj_id=p.id where p.visibility=1 order by p.id desc limit '.$limit.' offset '.($page - 1) * $limit.' ')->execute('slave')->as_array();
        foreach($product_id as $k=>$v){
            $data="";
            $file=$_SERVER['COFREE_UPLOAD_DIR']."/1/pimages/".$v['id'].".jpg";
            if(file_exists($file)){
                $aa=getimagesize($file);
                $weight=$aa["0"];////获取图片的宽
                $height=$aa["1"];///获取图片的高
                $b=3/4;
                $b1=$weight/$height;
                if($b1!=$b){
                    $data .=$v['product_id'];
                }
            }
        }
        echo $data."产品";
        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",5000);
                setTimeout("logout()",6000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '");
                }
                function logout()
                {
                    parent.window.opener = null;
                    parent.window.open("", "_self");
                    parent.window.close();
                }
            </script>';
        exit;
    }

    public function action_export_product_sorts(){
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="pro_sorts.csv"');
        
        //获取要导出产品的数量,超过2000则进行分组
        $num_sql = 'select count(*) num from products p where ';
        if($from=strtotime($_POST['from'])){
            $num_sql .= " p.created > '$from'";
        }else {
            $num_sql .= " p.created > 0";
        }
        if($to=strtotime($_POST['to'])){
            $num_sql .= " and p.created < '$to'";
        }
        $num = DB::query(DATABASE::SELECT, $num_sql)->execute('slave')->get('num');
        $number = ceil($num/2000);

        $catalogxin = array();            
        $sql1 = 'SELECT id,name from catalogs where on_menu = 1 and visibility = 1';
        $catalogs = DB::query(DATABASE::SELECT, $sql1)->execute('slave')->as_array();   
        foreach ($catalogs as $key => $value) 
        {
            $catalogxin[$value['id']] = $value['name'];
            # code...
        }
        echo "\xEF\xBB\xBF" . "id,name,sku,set_name,catalog\n";
        
        //进行分组导出
        for($i=0;$i<$number;$i++){
            $sql='SELECT p.id id,p.name name1, p.sku sku,ss.name,GROUP_CONCAT(c2.id ) catalog FROM products p LEFT JOIN sets ss on ss.id = p.set_id LEFT JOIN catalog_products cp ON cp.product_id = p.id LEFT JOIN catalogs c2 ON cp.catalog_id = c2.id  where';
            //判断是否传递开始时间及结束时间
            if($from=strtotime($_POST['from'])){
                $sql .= " p.created > '$from'";
            }else {
                $sql .= " p.created > 0";
            }
            if($to=strtotime($_POST['to'])){
                $sql .= " and p.created < '$to'";
            }


            $sql.=" group by p.id limit ".(2000*$i).",2000";

            $products = DB::query(DATABASE::SELECT, $sql)->execute('slave')->as_array();
            //输出
            foreach($products as $key => $column)
            {
                $cata = explode(',', $column['catalog']);
                echo '"'.$column['id'].'"'.',';
                echo '"'.$column['name1'].'"'.',';
                echo '"'.$column['sku'].'"'.',';
                echo '"'.$column['name'].'"'.',';

                $data1 = '';
                foreach ($cata as $key => $value)
                {
                    if(array_key_exists($value, $catalogxin))
                    {
                        if(empty($data1))
                        {
                           $data1 .= $catalogxin[$value]; 
                        }
                        else
                        {
                           $data1 .= ','.$catalogxin[$value];
                        }
                        
                    }
                }
                echo '"'.$data1.'"'.',';

                echo PHP_EOL;
            }
            
        }
        
    }

    public function action_export_productsmall()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="product.csv"');
        
        echo "\xEF\xBB\xBF" . "sku,name,create_time\n";
        
            $sql='SELECT sku,name,created from products where';
            //判断是否传递开始时间及结束时间

            $date = strtotime(Arr::get($_POST, 'from', 0));
            if(empty($date)){
                message::set('请输入开始日期','notice');
                Request::instance()->redirect('/admin/site/order/effect');
              
            }
            $sql .= " created > '$date'";
            $date_end = Arr::get($_POST, 'to', 0);
            if ($date_end)
            {
                $file_name = "product.csv";
                $date_end = strtotime($date_end);
            }
            else
            {
                $file_name = "product.csv";
                $date_end = $date + 86400;
            }

            $sql .= " and created < '$date_end'";

            $products = DB::query(DATABASE::SELECT, $sql)->execute('slave')->as_array();
            //输出
            foreach($products as $key => $column)
            {
                echo '"'.$column['sku'].'"'.',';
                echo '"'.$column['name'].'"'.',';
                echo '"'.date('Y-m-d', $column['created']).'"'.',';
                echo PHP_EOL;
            }
    }

    public function action_export_productpresell()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="product.csv"');
        
        echo "\xEF\xBB\xBF" . "sku,time\n";
        
            $sql='SELECT sku, presell FROM products WHERE presell != "" AND visibility =1 AND status =1';
            //判断是否传递开始时间及结束时间

            $products = DB::query(DATABASE::SELECT, $sql)->execute('slave')->as_array();
            //输出
            foreach($products as $key => $column)
            {
                echo '"'.$column['sku'].'"'.',';
                echo '"'.date('Y-m-d', $column['presell']).'"'.',';
                echo PHP_EOL;
            }
    }

    public function action_proinfo1()
    {
        header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
        header('Content-type:application/vnd.ms-excel');//输出的类型
        header('Content-Disposition: attachment; filename="prolistinfo1.csv"'); //下载显示
        echo iconv("UTF-8", "GBK//IGNORE",'SKU,Description,Size,Weight,Price_sample,Price_small,Price_large,Price_max,Detail,Images_Link'."\r\n");

            $size = $product_img = '';

//Option1 Name,Option1 Value,Option2 Name,Option2 Value,Variant SKU
                //产品名称/尺寸/重量/图片链接/批发价
          $products = DB::query(Database::SELECT, 'select id,set_id,sku,name,attributes,weight,total_cost,filter_attributes,price,brief,description,cost from products where status = 1 and visibility = 1 order by id desc')->execute('slave')->as_array();      
           

        foreach ($products as $product)
        {
            try{   
                $description = str_replace(';', '<br>', $product['description']);
                $$description = str_replace(',', '&nbsp;', $description);
                $description = str_replace(' ', '',  $description);
                $description = str_replace("\r\n", '&nbsp;', $description);
                $description = str_replace("\r", '&nbsp;', $description);
                $description = str_replace("\n", '&nbsp;', $description);
                $description = str_replace(",", '', $description);
                $brief = str_replace(';', '<br>', $product['brief']);
                $brief = str_replace(',', '&nbsp;', $brief);
                $brief = str_replace(' ', '',  $brief);
                $brief = str_replace("\r\n", '&nbsp;', $brief);
                $brief = str_replace("\r", '&nbsp;', $brief);
                $brief = str_replace("\n", '&nbsp;', $brief);

                $brief = $description.$brief;

                $attr = unserialize($product['attributes']);
                if(!empty($attr['Size']))
                {
                }

                //图片链接
                $product_instance = Product::instance($product['id']);
                $ImgArr = $product_instance->images();
                $img_arrs=array();
                if(!empty($ImgArr)){
                    foreach ($ImgArr as $image) {    
                        $img_arrs[]=Image::link($image, 9); 
                    }
                }

                $sprice = $product_instance->price();

                $str_1= $product['sku'].',';
                $str_1.=$product['name'].',';
                $str_1.=$attr['Size'][0].',';
                $str_1.= $product['weight'].',';
                $str_1.=$product['price'].',';
                $str_1.=$sprice.',';
                $str_1.=$product['cost'].',';
                $str_1.=round($product['cost']*6.559,2).',';
                $str_1.= $brief.',';
                $str_1.=$img_arrs[0]."\r\n";
                $c_size=count($attr['Size']);
                $c_img=count($img_arrs);
                $bigg=($c_size>$c_img)?$c_size:$c_img;
                for($i1=1;$i1<$bigg;$i1++){
                    $str_1.=',,';
                    if(!empty($attr['Size'][$i1])) $str_1.=$attr['Size'][$i1];
                    $str_1.=',,,,,,,';
                    if(!empty($img_arrs[$i1]))
                    $str_1.=$img_arrs[$i1];
                    $str_1.="\r\n";
                }


                
                echo iconv("UTF-8", "GBK//IGNORE", $str_1);
            }catch (Exception $e) {}
        }

        }

    public function action_productmusmet()
    {
        if ($_POST)
        {
            $skus = Arr::get($_POST, 'skus', 0);
            $skusarr = explode("\n", $skus);

            $from=strtotime('2016-06-13 00:00:00');
            $to=strtotime('2016-06-27 00:00:00');
            $daterange = " AND orders.created  between  '" . $from .  "' and  '" . $to ."'";
/*            ignore_user_abort(true);
            set_time_limit(0);*/
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="Products_500.csv"');
            echo "\xEF\xBB\xBF"."SKU,Set,06.27前两周销量,库存,SOURCE,Choies站上原价,Choies站上现价,Choies站上产品链接,产品描述,图片链接\n";
            foreach ($skusarr as $key => $value)
            {
                $product_id = Product::get_productId_by_sku($value);
                $product_instance=Product::instance($product_id);
                $product = Product::instance($product_id)->get();
                $set_name = Set::instance($product['set_id'])->get('name');//Set
                //06.27前两周销量(时间设定在变量$daterange)
                $sales = 0;
                if($product_id) {
                    $sales = DB::query(Database::SELECT, 'SELECT COUNT(order_items.id) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id WHERE orders.payment_status="verify_pass" AND order_items.product_id=' . $product_id . $daterange)->execute('slave')->get('count');
                }
                //库存
                $stocks=0;
                if($product_id) {
                    $stocks = DB::query(DATABASE::SELECT, "select ifnull(sum(ps.stocks),0) as stocks_sum from products_stocks ps LEFT JOIN products p on ps.`product_id` = p.id  WHERE p.id=" . $product_id)->execute()->get('stocks_sum');
                }
                $source = $product['source'];//SOURCE
                $price = $product['price'];//Choies站上原价
                $sprice = Product::instance($product_id)->price();//Choies站上现价
                $plink = $product_instance->permalink();//Choies站上产品链接
                $description = strip_tags($product['description']);//产品描述
                $description = preg_replace('/(&nbsp;)+/', ' ', $description);
                $description = str_replace('&amp;', '&', $description);
                $description = trim(preg_replace('/"|\n/', '', $description));
                //图片链接
                $images = DB::select('id', 'suffix')->from('images')->where('site_id', '=', $this->site_id)->where('obj_id', '=', $product_id)->execute();
                $imagestr="";
                foreach($images as $image){
                    $imagestr=$imagestr.STATICURL.'/pimg/o/'.$image['id'].'.'.$image['suffix'].';';
                }

                echo $value, ',';
                echo $set_name, ',';
                echo $sales, ',';
                echo $stocks, ',';
                echo $source, ',';
                echo $price, ',';
                echo $sprice, ',';
                echo $plink, ',';
                echo $description, ',';
                echo $imagestr, ',';
                echo "\n";
            }
            $sql = '';
        }
        else
        {
            echo
            '
    <h3>导出产品采购信息</h3>
    <form method="post">
        <textarea name="skus" cols="20" rows="20"></textarea>
    <input type="submit" value="submit">
    </form>    
';
        }
    }

    //产品信息批量导出 by xl 2016.7.12
    public function action_export_products_info(){
        $skus = Arr::get($_POST, 'SKUARR', '');
        if (!$skus)
        {
            echo 'Sku cannot be empty';
            exit;
        }
        else {
            $skuArr = explode("\n", $skus);
            header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
            header('Content-type:application/vnd.ms-excel');//输出的类型
            header('Content-Disposition: attachment; filename="prolistinfo1.csv"'); //下载显示
            echo iconv("UTF-8", "GBK//IGNORE",'SKU,Description,Size,Weight,Price_sample,Price_small,Price_large,Price_max,Detail,Images_Link'."\r\n");
            foreach ($skuArr as $sku)
            {
                $product_id = Product::get_productId_by_sku($sku);
                $product_instance=Product::instance($product_id);
                $product = Product::instance($product_id)->get();
                //产品描述
                $description = str_replace(';', '<br>', $product['description']);
                $description = str_replace(',', '&nbsp;', $description);
                $description = str_replace(' ', '',  $description);
                $description = str_replace("\r\n", '&nbsp;', $description);
                $description = str_replace("\r", '&nbsp;', $description);
                $description = str_replace("\n", '&nbsp;', $description);
                $description = str_replace(",", '', $description);
                //Detail
                $brief = str_replace(';', '<br>', $product['brief']);
                $brief = str_replace(',', '&nbsp;', $brief);
                $brief = str_replace(' ', '',  $brief);
                $brief = str_replace("\r\n", '&nbsp;', $brief);
                $brief = str_replace("\r", '&nbsp;', $brief);
                $brief = str_replace("\n", '&nbsp;', $brief);
                $brief = $description.$brief;
                //SIZE
                $attr_size ="";
                if(is_array($product['attributes']) && isset($product['attributes']['Size']))
                {
                    foreach($product['attributes']['Size'] as $attsize){
                        $attr_size .=$attsize."/";
                    }
                }
                //Choies站上原价
                $price = $product['price'];
                //Choies站上现价
                $sprice = Product::instance($product_id)->price();
                //成本
                $cost = $product['cost'];
                //RMB成本
                $cost_RMB = round($product['cost']*6.559,2);
                //Choies站上产品链接
                $plink = $product_instance->permalink();

                echo '"' .$product['sku']. '"', ',';
                echo '"' .$product['name']. '"', ',';
                echo '"' .$attr_size. '"', ',';
                echo '"' .$product['weight']. '"', ',';
                echo '"' .$price. '"', ',';
                echo '"' .$sprice. '"', ',';
                echo '"' .$cost. '"', ',';
                echo '"' .$cost_RMB. '"', ',';
                echo '"' .$brief. '"', ',';
                //图片链接
                $images = DB::select('id', 'suffix')->from('images')->where('site_id', '=', $this->site_id)->where('obj_id', '=', $product_id)->execute();
                $imagestr="";
                foreach($images as $image){
                    $imagestr=STATICURL.'/pimg/o/'.$image['id'].'.'.$image['suffix'];
                    echo '"' .$imagestr. '"', ',';
                }
                echo "\n";
            }
        }
    }

    public function action_export_products_brief()
    {
        if ($_POST)
        {
            $skus = Arr::get($_POST, 'skus', '');
            if (!$skus)
            {
                echo 'Sku cannot be empty';
                exit;
            }
            $skusarr = explode("\n", $skus);
            header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
            header('Content-type:application/vnd.ms-excel');//输出的类型
            header('Content-Disposition: attachment; filename="prolistinfo1.csv"'); //下载显示

            $bf = Arr::get($_POST, 'aaa', '1');
            if($bf == 1)
            {
                $export_field = 'description';
            }
            elseif($bf == 2)
            {
                $export_field = 'brief';               
            }
            else
            {

            }
            echo iconv("UTF-8", "GBK//IGNORE",'SKU,'.$export_field."\r\n");

            foreach ($skusarr as $sku)
            {
                $product_id = Product::get_productId_by_sku($sku);
                $product_instance=Product::instance($product_id);
                $product = Product::instance($product_id)->get();
                $description = strip_tags($product[$export_field]);//产品描述
                $description = preg_replace('/(&nbsp;)+/', ' ', $description);
                $description = str_replace('&amp;', '&', $description);
                $description = trim(preg_replace('/"|\n/', '', $description));
                echo '"' .$sku. '"', ',';
                echo '"' .$description. '"', ',';
                echo "\n";
            }
        }
        else
        {
            echo
            '
    <h3>导出产品描述信息</h3>
    <form method="post">
        <textarea name="skus" cols="20" rows="20"></textarea>
        <br />
    <input type="radio" name="aaa" value="1">导出description<input type="radio" name="aaa" value="2">导出brief
    <br />
    <input type="submit" value="submit">
    </form>    
';  
        }

    }

    public function action_bulk_es()
    {
        $page = Arr::get($_GET, 'page', 1);
        $limit = 1000;
        $result = DB::select('id')
            ->from('products_product')
            ->where('visibility', '=', 1)
            ->where('status', '=', 1)
            ->order_by('id', 'desc')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->execute('slave')->as_array();
/*        echo '<pre>';
        print_r($result);
        die;
        $ids = array();*/
        foreach ($result as $key => $value) 
        {
            $need_catalog = 1;
            Product::bulk_elastic('id', array($value['id']),$language = '',$need_catalog);
            # code...
        }
        
        //Product::bulk_elastic('id', array($ids),$need_catalog);

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '");
                }
                function logout()
                {
                    parent.window.opener = null;
                    parent.window.open("", "_self");
                    parent.window.close();
                }
            </script>';
        exit;
    }

    public function action_get_sku_images()
    {
        if($_POST)
        {
            $skus = Arr::get($_POST, 'skus', '');
            if (!$skus)
            {
                echo 'Sku cannot be empty';
                exit;
            }
            else {
                $skuArr = explode("\n", $skus);
                header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
                header('Content-type:application/vnd.ms-excel');//输出的类型
                header('Content-Disposition: attachment; filename="prolistinfo1.csv"'); //下载显示
                echo iconv("UTF-8", "GBK//IGNORE",'SKU,default_image_id,images_ids'."\r\n");
                foreach ($skuArr as $sku)
                {
                    $product_id = Product::get_productId_by_sku($sku);
                    if($product_id)
                    {
                        $product_instance=Product::instance($product_id);
                        $product = Product::instance($product_id)->get();           
                        $images_order = isset($product['configs']['images_order']) ? $product['configs']['images_order'] : '';
                        $default_image = isset($product['configs']['default_image']) ? $product['configs']['default_image'] : '';
                        if(strpos($images_order, 'undefined') !== FALSE)
                        {
                            $images = DB::query(Database::SELECT,"SELECT GROUP_CONCAT(id SEPARATOR '#') as ids FROM images WHERE type = 1 AND obj_id = '".$product_id."';")->execute('slave')->as_array();  
                            if(!empty($images[0]['ids']))
                            {
                               $images_order = $images[0]['ids'];
                            }                   
                        }
                        else
                        {
                            $images_order = str_replace(",", "#", $images_order);
                        }

                        echo '"' .$product['sku']. '"', ',';
                        echo '"' .$default_image. '"', ',';
                        echo '"' .$images_order. '"', ',';
                        echo "\n";                        
                    }

                }
            }              
        }
        else
        {
            echo
            '
    <h3>导出产品采购信息</h3>
    <form method="post">
        <textarea name="skus" cols="20" rows="20"></textarea>
    <input type="submit" value="submit">
    </form>    
';
        }

    }

    public function action_export_filter()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="product.csv"');
        
        echo "\xEF\xBB\xBF" . "sku,filter_attributes\n";
        
            $sql='SELECT sku, filter_attributes FROM products WHERE created >= 1472659200 AND visibility =1 AND status =1';
            //判断是否传递开始时间及结束时间

            $products = DB::query(DATABASE::SELECT, $sql)->execute('slave')->as_array();
            //输出
            foreach($products as $key => $column)
            {
                echo '"'.$column['sku'].'"'.',';
                echo '"'.$column['filter_attributes'].'"'.',';
                echo PHP_EOL;
            }
    }

    public function action_sourcexport()
    {
        if($_POST)
        {
            $skus = Arr::get($_POST, 'skus', '');
            if (!$skus)
            {
                echo 'Sku cannot be empty';
                exit;
            }
            else {
                $skuArr = explode("\n", $skus);
                header('Content-type:text/html;charset=GBK');//设定编码，防止js输出乱码。
                header('Content-type:application/vnd.ms-excel');//输出的类型
                header('Content-Disposition: attachment; filename="prolistinfo1.csv"'); //下载显示
                echo iconv("UTF-8", "GBK//IGNORE",'SKU,source'."\r\n");
                foreach ($skuArr as $sku)
                {
                    $product_id = Product::get_productId_by_sku($sku);
                    if($product_id)
                    {
                        $product_instance=Product::instance($product_id);
                        $product = Product::instance($product_id)->get();           
                        echo '"' .$product['sku']. '"', ',';
                        echo '"' .$product['source']. '"', ',';
                        echo "\n";                        
                    }

                }
            }              
        }
        else
        {
            echo
            '
    <h3>导出产品采购信息</h3>
    <form method="post">
        <textarea name="skus" cols="20" rows="20"></textarea>
    <input type="submit" value="submit">
    </form>    
';
        }

    }

    public function action_trans()
    {
        if($_POST)
        {
            $skus = Arr::get($_POST, 'skus', '');
            $lang = Arr::get($_POST, 'lang', ''); 
            if (!$skus)
            {
                echo 'Sku cannot be empty';
                exit;
            }
            else 
            {
                $skuArr = explode("\n", $skus);
                foreach ($skuArr as $key => $value) 
                {
                    $skuArr[$key] = "'".$value."'";
                }
                $strsku = implode(",", $skuArr);
                $strsku = '('.$strsku.')';
                $result = DB::query(Database::SELECT, 'SELECT id, name FROM products WHERE visibility = 1 AND status = 1 AND sku in '.$strsku)->execute('slave')->as_array();

                $name = '';
                foreach($result as $product)
                {
                    $name .= $product['name'].'+'; 
                }
                $name = substr($name, 0,-1);

                $proarr = DB::query(Database::SELECT, 'SELECT DISTINCT product_id FROM trans')->execute('slave')->as_array();
                $arr = array();
                foreach ($proarr as $key => $value) 
                {
                    array_push($arr, $value['product_id']);
                }

                $words1 = Product::googletransapi($blank='en',$target=$lang,$name);
                if($words1 != 1)
                //if(1)
                {
                    $words1 = json_decode($words1);
                    $words1 = $words1->data->translations[0]->translatedText;
                    $replarr1 = explode('+', $words1);

                    if($replarr1)
                    {
                        foreach ($result as $key => $value)
                        {
                            if(count($replarr1) == count($result))
                            {
                                #已存在，更新
                                if(in_array($value['id'], $arr))
                                {
                                    $update = DB::update('trans')->set(array('trans_'.$lang => $replarr1[$key]))->where('product_id', '=', $value['id'])->execute();
                                }
                                else
                                {
                                    $insert1 = array(
                                    'trans_'.$lang => $replarr1[$key],
                                    'product_id' => $value['id'],
                                    );
                                    DB::insert('trans', array_keys($insert1))->values($insert1)->execute();
                                }                        
                            }
                        }
                    }
                }

                $endtime = time();
                echo $endtime-$starttime;
            }              
        }
        else
        {
            echo
            '
    <h3>手动翻译sku产品</h3>
    <form method="post">
        <textarea name="skus" cols="20" rows="20"></textarea>
        <br />
        <select name="lang" required=TRUE>
            <option value="de">de</option>
            <option value="fr">fr</option>
        </select>
    <input type="submit" value="submit">
    </form>    
';
        }

    }


}