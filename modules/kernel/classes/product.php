<?php
defined('SYSPATH') or die('No direct script access.');

class Product
{

    protected static $instances;
    protected static $instances1;
    protected $data;
    protected $site_id;
    protected $lang;
    protected $lang_table;

    public static function & instance($id = 0, $lang = '')
    {
        if($lang)
        {
            if( ! isset(self::$instances1[$id]))
            {
                $class = __CLASS__;
                self::$instances1[$id] = new $class($id, $lang);
            }
            return self::$instances1[$id];
        }
        else
        {
            if (!isset(self::$instances[$id]))
            {
                $class = __CLASS__;
                self::$instances[$id] = new $class($id, $lang);
            }
            return self::$instances[$id];
        }
    }

    public function __construct($id, $lang)
    {
        $this->site_id = Site::instance()->get('id');
        $check = array('es','de','fr');
        if($lang and !in_array($lang,$check))
        {
            $lang = '';
        }
        $this->lang = $lang;
        $this->lang_table = ($lang === 'en' OR $lang === '') ? '' : '_' . $lang;
        $this->data = NULL;
        $this->_load($id);
    }

    public function _load($id)
    {
        if( ! $id)
        {
            return FALSE;
        }

        $cache = Cache::instance('memcache');
		$key = "/productcache/".$id.'/'.$this->lang;

        $data = ($cache->get($key));
        if(!is_array($data))
        {
            $data = unserialize($data);
        }

        if( ! ($data))
        {
            $data = array( );
            $result = DB::select()->from('products_product')
                    ->where('id', '=', $id)
                    ->execute()->current();
            if($result['id'] !== NULL)
            {
                $data = $result;
                $data['discount_price'] = $data['price'];
                $data['configs'] = $result['configs'] != '' ? unserialize($result['configs']) : '';
                //For simple-config product
                $res = DB::select('attribute','stock','status')->from('products_productitem')->where('product_id','=',$id)->and_where('status','=',1)->execute('slave')->as_array();
                $size = array();
                $stock = $result['stock'];
                $status = 0;
                $instock = 0;
                foreach ($res as $r)
                {
                    $size[] = $r['attribute'];
                    $instock = ($r['stock']>0)?++$instock:$instock;
                    $status = ($r['status']==1)?++$status:$status;//item有上架，则$data['status']为1
                }
//                $res = DB::select()->from('products_productfilter')->where('product_id','=',$id)->execute()->as_array();
                $result = DB::query(Database::SELECT,'SELECT f.options FROM	products_productfilter AS pf LEFT JOIN products_filter AS f ON  f.id =pf.filter_id WHERE pf.product_id = '.$id)->execute()->as_array();
                $filter = '';
                foreach ($result as $res){
                    $filter .= $res['options'].';';
                }
                $filter = trim($filter,';');

                //小语种name description brief
                if($this->lang)
                {
                    if(  $trans = $this->productTransName($id) or $trans = $this->productTrans($id,$this->lang))
                    {
                        if(!empty($trans['name']))
                        {
                            $data['name'] = $trans['name'];
                        }
                        if(!empty($trans['description']))
                        {
                            $data['description'] = $trans['description'];
                        }

                        if(!empty($trans['brief']))
                        {
                            $data['brief'] = $trans['brief'];
                        }
                    }
                }



                $data['attributes'] = array("Size"=>$size);
                $data['stock'] = $stock; //是否有库存限制，-99没有库存限制，-1，有库存限制
                $data['instock'] = $instock; //是否有库存
                $data['status'] = $status;          //产品是否上架
                $data['filter_attributes'] = $filter;
                $cache->set($key, $data, 7200);//
            }
        }
        if(count($data))
        {
            $this->data = $data;
        }
    }

    /**
     * 获取产品的基本数据
     * @param string $key 数据名称。
     * @return <type> 如果给出$key，则返回$key指定的数据内容(String Or Integer..)。如不填，则返回产品的所有基本数据(Array)。
     */
    public function get($key = NULL)
    {
        //配置产品无下列键值，返回其默认简单产品的相应键值
        $no_configurable_keys = array( 'price', 'market_price', 'weight', 'stock' );

        if(empty($key))
        {
            $data = $this->data;

            if($this->data['type'] == 1)
            {
                foreach( $no_configurable_keys as $key )
                {
                    $data[$key] = Product::instance($this->default_item())->get($key);
                }
            }

            return $data;
        }

        if($this->data['type'] == 1 AND in_array($key, $no_configurable_keys))
        {
            return Product::instance($this->default_item())->get($key);
        }

        return isset($this->data[$key]) ? $this->data[$key] : '';
    }

    public static function get_productId_by_sku($sku)
    {
        $cache = Cache::instance('memcache');
        $cache_key = "product_sku/".$sku;
        if( ! ($product_id = $cache->get($cache_key)))
        {
            $result = ORM::factory("product")
                ->where("sku", "=", $sku)
                ->find();
            if($result->loaded())
                $product_id = $result->id;
            else
                $product_id = 0;
            $cache->set($cache_key, $product_id, 3600);
        }

        return $product_id;
    }

    public function previous_item_link()
    {
        $sku = $this->data['sku'];
        $code = explode('-', $sku);
        $code = $code[0];
        $result = ORM::factory("product" )
            ->where("sku", "NOT LIKE", $code + "%")
            ->where("id", "<", $this->data["id"])
            ->where("link", "<>", "no-link")
            ->order_by("id", "DESC")
            ->find();
        if($result->loaded()) return $result->link == "no-link" ? $this->data['link'] : $result->link;
        else return $this->data['link'];
    }

    public function next_item_link()
    {
        $sku = $this->data['sku'];
        $code = explode('-', $sku);
        $code = $code[0];
        $result = ORM::factory("product" )
            ->where("sku", "NOT LIKE", $code + "%")
            ->where("id", ">", $this->data["id"])
            ->where("link", "<>", "no-link")
            ->order_by("id", "ASC")
            ->find();
        if($result->loaded()) return $result->link == "no-link" ? $this->data['link'] : $result->link;
        else return $this->data['link'];
    }

    /**
     * 获得产品类型所包含的属性（以及它们针对本产品的选项或值），包括可配置或非可配置属性。
     * 如果是配置产品，在调用此方法之后还需调用associated_products()来获得其所辖的简单产品（以及各自对应的“可配置”属性值）
     * @return array
     */
    public function set_data()
    {
        $option_data = Set::instance($this->data['set_id'])->structure();

        $product_options = $this->options();

        foreach( $option_data as $attribute_id => $attribute )
        {
            /**
             * attribute字段解释
             *
             * scope的含义:
             * 0=>前台显示（不影响任何因素，仅供浏览，可以是选择项或文本）,
              1=>用于区分简单产品的“可配置”属性（对应不同的SKU，并可能影响价格，必须是选择项）,
              2=>前台顾客输入（不影响任何因素，仅保存在订单中作为发货参考，如眼镜配方的度数，可以是选择项或文本，可有默认值）
             *
             * type的含义:
             * 0=>下拉选项
             * 1=>单选按钮
             * 2=>单行文本框
             * 3=>多行文本框
             */
            if(isset($attribute['type']) and $attribute['type'] > 1)
            {
                $value = NULL;
                $value_result = DB::query(1, "SELECT value FROM product_attribute_values WHERE product_id = '".$this->data['id']."' AND attribute_id = '".$attribute_id."';")->execute()->as_array();
                if(count($value_result))
                {
                    $value = $value_result[0]['value'];
                }
                $option_data[$attribute_id]['value'] = $value;
            }
            elseif(isset($attribute['type']) and $attribute['type'] <= 1)
            {
                $selected_option_id = -1; //被该产品选中的option id
                $value = NULL; //被该产品选中的option label
                foreach( $attribute['options'] as $key => $opt )
                {
                    if(in_array($opt['id'], $product_options))
                    {
                        $selected_option_id = $opt['id'];
                        $value = $opt['label'];
                        break;
                    }
                }
                $option_data[$attribute_id]['selected_option_id'] = $selected_option_id;
                $option_data[$attribute_id]['value'] = $value;
            }
        }
        return $option_data;
    }

    /**
     * TODO 此方法貌似用不上……整理代码的时候再看是否需要删除
     * @return <type>
     */
    public function attributes()
    {
        $cache = Cache::instance('memcache');
        $key = $this->site_id."/product/".$this->data['id'].'/attributes';
        if( ! ($data = $cache->get($key)))
        {
            $result = DB::select('attribute_id')->from('set_attributes')
                ->where('set_id', '=', $this->data['set_id'])
                ->execute();

            $data = array( );
            foreach( $result as $attribute )
            {
                $data[] = $attribute['attribute_id'];
            }

            $cache->set($key, $data, 600);
        }

        return $data;
    }

    /**
     * 返回该产品所选中的所有option的id
     * @return <type>
     */
    public function options()
    {
        $cache = Cache::instance('memcache');
        $key = $this->site_id."/product/".$this->data['id'].'/attributes'.$this->lang;

        if(  ($data = $cache->get($key)))
        {

            $result = DB::select('option_id')->from('product_options')
                ->where('product_id', '=', $this->data['id'])
                ->execute();

            $data = array( );
            foreach( $result as $option )
            {
                $data[] = $option['option_id'];
            }

            $cache->set($key, $data, 600);
        }

        return $data;
    }

    /**
     * 返回产品的完整链接地址，包含当前协议('http://'或'https://')
     * @return string
     */
    public function permalink()
    {
        $cache = Cache::instance('memcache');
        $key = $this->site_id."/product/".$this->data['id'].'/permalink'.$this->lang;

        if( ! ($data = $cache->get($key)))
        {

            $site = Site::instance();
            $route_type = $site->get('route_type');

            $data = "";
            // FIXME get protocol from db.
            $protocol = 'https';
            $lang = '';
            if($this->lang)
            {
                $lang = '/'.$this->lang;
            }
            switch( $route_type )
            {
                case 1:
                case 2:
                    $data = $protocol.'://'.$site->get('domain') . $lang .'/'.$site->get('product').'/'.$this->data['link'] . '_p' . $this->data['id'];
                    break;
                default:
                    $data = $protocol.'://'.$site->get('domain').$lang.'/'.$site->get('product').'/'.$this->data['id'];
                    break;
            }

            $cache->set($key, $data, 10);
        }
        return $data;
    }

    /**
     * 返回配置产品下的简单产品及其option映射关系
     * @return array 产品id为key，产品选中的可配置option ids为value。
     */
    public function associated_products_options()
    {
        //如果是配置产品，获得其简单产品与属性值的映射：
        if($this->data['type'] == 1)
        {
            //获得可配置属性的列表
            $configurable_options = array( );
            $configurable_attributes = $this->data['configs']['configurable_attributes'] != '' ? $this->data['configs']['configurable_attributes'] : array( );
            $set = Set::instance($this->data['set_id'])->structure();
            foreach( $set as $attr )
            {
                if(in_array($attr['id'], $configurable_attributes))
                {
                    foreach( $attr['options'] as $opt )
                    {
                        $configurable_options[$opt['id']] = $attr['id'];
                    }
                }
            }
            //获得简单产品
            $associated_products_result = $this->items();
            $associated_products = array( );
            $used_option_ids = array( );
            //遍历简单产品，与属性值进行匹配
            foreach( $associated_products_result as $pro_id )
            {
                $attr_opt = array( );
                $opts = Product::instance($pro_id)->options();
                foreach( $opts as $opt )
                {
                    if(isset($configurable_options[$opt]))
                    {
                        $attr_opt[$configurable_options[$opt]] = $opt;
                    }
                }
                //对简单产品的可配置属性列表 与 复杂产品的可配置属性列表 进行比较，如果一致就把它算进去，否则摒弃之
                $diff = array_diff_key(array_flip($configurable_attributes), $attr_opt);
                if( ! count($diff))
                {
                    //先对option id进行排序，然后用'_'连接成字符串，以保证key的唯一性
                    asort($attr_opt);
                    //					$associated_products[implode('_', $attr_opt)] = $pro_id;
                    $associated_products[$pro_id] = array_values($attr_opt);
                }
            }
            return $associated_products;
        }
    }

    /**
     * 产品的默认所属分类
     * @return integer 分类id
     */
    public function default_catalog($on_menu=1)
    {
        
        $cache = Cache::instance('memcache');
        $key = $this->site_id."/product/".$this->data['id'].'/default_catalog';

        if( ! ($cata_id = $cache->get($key))){
        //TODO
        $cata_id = 0;
        if( ! empty($this->data['default_catalog']))
        {
            return $this->data['default_catalog'];
        }
        if(!empty($this->data['id']))
        {
            $cata = DB::query(Database::SELECT, 'SELECT cp.category_id FROM products_categoryproduct cp LEFT JOIN products_category ca ON (cp.category_id = ca.id) WHERE cp.product_id = '.$this->data['id'].' AND ca.visibility = 1 '.( ! is_null($on_menu) ? "AND ca.on_menu=$on_menu" : '').' LIMIT 1')->execute()->as_array();
        }
        if(empty($cata))
        {
            return 0;
        }
        if(count($cata))
        {
            $cata_id = $cata[0]['category_id'];
            $cache->set($key, $cata_id, 86400);
        }
        else
        {
            //如果是简单产品，则找它所属的配置产品，取得配置产品所属分类
            if($this->data['type'] == 0)
            {
                $configured_product = DB::query(1, 'SELECT group_id FROM pgroups WHERE product_id = '.$this->data['id'].' LIMIT 1')->execute()->as_array();
                if(count($configured_product))
                {
                    if(!empty($this->data['id']))
                    {
                        $cata = DB::query(1, 'SELECT cp.category_id FROM products_categoryproduct cp LEFT JOIN products_category ca ON (cp.category_id = ca.id) WHERE cp.product_id = '.$this->data['id'].' AND ca.visibility = 1 AND ca.on_menu = 1 LIMIT 1')->execute()->as_array();
                    }
                    if(count($cata))
                    {
                        $cata_id = $cata[0]['catalog_id'];
                        $cache->set($key, $cata_id, 86400);
                    }
                }
            }
        }
        
        }
        return $cata_id;
    }


    public function all_catalog($on_menu=0)
    {

        $cache = Cache::instance('memcache');
        $key = $this->site_id."/product/".$this->data['id'].'/all_catalog';
        if( ! ($cata_id = $cache->get($key)))
        {
        //TODO
        $cata_id = 0;

        $cata = DB::query(Database::SELECT, 'SELECT cp.category_id FROM products_categoryproduct cp LEFT JOIN products_category ca ON (cp.category_id = ca.id) WHERE cp.product_id = '.$this->data['id'].' AND ca.visibility = 1 '.( ! is_null($on_menu) ? "AND ca.on_menu=$on_menu" : '').'')->execute('slave')->as_array();
        //guo add
            if(count($cata))
            {
                if(count($cata) ==1)
                {
                    $cata_id = $cata[0]['catalog_id'];
                }
                else
                {
                    foreach($cata as $v)
                    {
                        $a[] = $v['catalog_id'];
                    }
                    $cata_id = $a;            
                }

            }
            else
            {
                //如果是简单产品，则找它所属的配置产品，取得配置产品所属分类
                if($this->data['type'] == 0)
                {
                    $configured_product = DB::query(1, 'SELECT group_id FROM pgroups WHERE product_id = '.$this->data['id'].' LIMIT 1')->execute()->as_array();
                    if(count($configured_product))
                    {
                        $cata = DB::query(1, 'SELECT cp.category_id FROM products_categoryproduct cp LEFT JOIN products_category ca ON (cp.category_id = ca.id) WHERE cp.product_id = '.$this->data['id'].' AND ca.visibility = 1 AND ca.on_menu = 1 LIMIT 1')->execute()->as_array();
                        if(count($cata))
                        {
                            $cata_id = $cata[0]['catalog_id'];
                        }
                    }
                }
            }
        }
        return $cata_id;


    }

    /**
     * 获得产品的默认图片
     * @return array  数据结构：array(id=>1,suffix=>'jpg')。如无默认图片，则返回FALSE。
     */
    public function cover_image()
    {   
        if(!is_array($this->data['configs']))
        {
            $this->data['configs'] = unserialize($this->data['configs']);
        }
        if(is_array($this->data['configs']) AND isset($this->data['configs']['default_image']) AND $this->data['configs']['default_image'] != '')
        {
            $cache = Cache::instance('memcache');
            $image_id = $this->data['configs']['default_image'];
            $cache_key = 'site_image_' . $image_id;
            if(!($image = $cache->get($cache_key)))
            {
                $image = DB::select('id', 'product_id', 'type', 'suffix', 'status')->from('products_productimage')->where('id', '=', $image_id)->execute()->current();
                $cache->set($cache_key, $image, 21600);
            }
            if(!empty($image) AND isset($image['product_id']) == $this->data['id'] AND $image['type'] == kohana::config('upload.product_image.type'))
            {
                $data['id'] = $image['id'];
                $data['suffix'] = $image['suffix'];
                $data['status'] = $image['status'];
                return $data;
            }
        }
        $data = $this->images();
        // var_dump($data = $this->images());die;

        if( ! $data AND $this->data['type'] == 1)
        {
            return Product::instance($this->default_item())->cover_image();
        }

        return isset($data[0]) ? $data[0] : FALSE;
    }

    /**
     * 获得产品图片列表
     *
     * @return <type> array((id,suffix),(id,suffix)......) 二维数组
     */
    public function images()
    {
        $cache = Cache::instance('memcache');
        $product_id = '';
        if(isset($this->data['id'])){
            $product_id = $this->data['id'];
        }
        $cache_key = 'prodct_images_' .$product_id;
        $data = $cache->get($cache_key);
        if(!is_array($data))
        {
            $data = unserialize($data);
        }
        //添加一个小时memcache
        if(! $data)
        {
            $data = DB::query(1, "SELECT id,suffix,status FROM products_productimage WHERE type = '".kohana::config('upload.product_image.type')."' AND product_id = '".$product_id."';")->execute()->as_array();
            $cache->set($cache_key, $data, 3600);
        }
        
        //按后台设置排序
        if(is_array($this->data['configs']) AND isset($this->data['configs']['images_order']) AND $this->data['configs']['images_order'] != '')
        {
            $orders = explode(",", $this->data['configs']['images_order']);
            $temp = array( );
            $data_append = array( );
            if(!empty($data))
            {
                foreach( $data as $d )
                {
                    if(in_array($d['id'], $orders)) $temp[$d['id']] = $d;
                    else $data_append[] = $d;
                }
            }
            $data = array( );
            foreach( $orders as $order )
            {
                if(isset($temp[$order])) $data[] = $temp[$order];
            }
            $data = array_merge($data, $data_append);
        }
        //将默认图片移动到数组的首端
        if(is_array($this->data['configs']) AND isset($this->data['configs']['default_image']) AND $this->data['configs']['default_image'] != '')
        {
            foreach( $data as $key => $img )
            {
                if($img['id'] == $this->data['configs']['default_image'] AND $key != 0)
                {
                    $data[$key] = $data[0];
                    $data[0] = $img;
                    break;
                }
            }
        }
        //如果简单产品没有图片，返回一张默认图片：
        $product_type = '';
        if(isset($this->data['type']))
        {
           $product_type =  $this->data['type'];
        }
        if( ! count($data) AND $product_type != 1)
        {
            $data[0] = array(
                'id' => 0,
                'suffix' => 'jpg'
            );
        }
        return $data;
    }

    /**
     * 获得用于产品详情页显示的“相关产品”
     * @return array 一维数组，key无意义，value为产品id(integer)
     */
    public function related_products()
    {
        $data = array( );
        // add Similar Styles products
        $similar_id = DB::select('id')->from('products_category')->where('link', '=', 'similar-styles')->execute()->get('id');
        if($similar_id)
        {
            $similar = DB::query(1, 'SELECT DISTINCT p.product_id FROM products_categoryproduct p LEFT JOIN products_category c ON p.category_id = c.id WHERE c.id = ' . $similar_id . ' ORDER BY p.position DESC')->execute();
            
            $num = 1;
            foreach($similar as $s)
            {
                if($num > 2)
                    break;
                $pid = $this->visibility($s['product_id']);
                if($pid)
                {
                    $data[] = $pid;
                    $num ++;
                }
            }
        }

/*        $result = DB::query(1, "SELECT DISTINCT related_product_id FROM products_relatedproduct WHERE product_id = '".$this->data['id']."';")->execute();
        foreach( $result as $re )
        {
            $data[] = $this->visibility($re['related_product_id']);
        }*/
        return $data;
    }

    public function visibility($id)
    {
        $visible = DB::select('visibility')->from('products' . $this->lang_table)->where('id', '=', $id)->execute();
        foreach( $visible as $v )
        {
            if($v['visibility'] == 1)
            {
                return $id;
            }
        }
    }

    /**
     *  获得复杂产品的默认/主要简单产品
     * @return integer  产品id。如无符合条件的简单产品，则返回FALSE
     */
    public function default_item()
    {
        if($this->data['type'] == 0)
        {
            return $this->data['id']; //TODO is this (no returning false) OK?;
        }
        else
        {
            if( ! empty($this->data['configs']['default_item']))
            {
                return $this->data['configs']['default_item'];
            }
            else
            {
                $data = $this->items();
                return isset($data[0]) ? $data[0] : FALSE;
            }
        }
    }

    /**
     *  获得复杂产品所包含的简单产品
     * @return array 一维数组，key无意义，value为产品id(integer)
     */
    public function items()
    {
        if($this->data['type'] == 1)
        {
            $results = DB::query(1, "SELECT product_id FROM pgroups WHERE group_id = '".$this->data['id']."';")->execute();
        }
        elseif($this->data['type'] == 2)
        {
            $results = DB::query(1, "SELECT product_id FROM ppackages WHERE package_id = '".$this->data['id']."';")->execute();
        }
        if($results)
        {
            $data = array( );
            foreach( $results as $re )
            {
                $data[] = $re['product_id'];
            }
            return $data;
        }
        return FALSE;
    }

    /**
     * 获得（某配置产品下的）某个简单产品的配置属性
     * @param integer $simple_product_id 配置产品下的简单产品id
     * @return array 一维关联数组，key为属性名，value为属性值
     */
    public function configured_attributes($simple_product_id = NULL)
    {
        $type = $this->data['type'];
        $options = ($type == 1 AND $simple_product_id) ? Product::instance($simple_product_id)->options() : $this->options();
        $configured_options = array( );
        foreach( $options as $opt_id )
        {
            $opt = Option::instance($opt_id);
            $attr = Attribute::instance($opt->get('attribute_id'))->get();
            if($attr['scope'] == 1 AND ($type != 1 OR in_array($attr['id'], $this->data['configs']['configurable_attributes'])))
            {
                $configured_options[$attr['label']] = $opt->get('label');
            }
        }
        if($type != 1 OR count($configured_options) == count($this->data['configs']['configurable_attributes']))
        {
            return $configured_options;
        }
        else
        {
            return array( );
        }
    }

    /**
     * 搜索产品
     * @param string $keywords 关键字
     * @param integer $_offset 偏移量
     * @param integer $_limit 结果条数
     * @return array  一维数组，key无意义，value为产品id(integer)
     */
    /*
      public static function search($keywords, $_offset = NULL, $_limit = NULL)
      {
      $limit = '';
      if($_limit > 0)
      {
      $limit = ' LIMIT '.($_offset ? $_offset.',' : '').$_limit;
      }
      $result = DB::query(1, "SELECT id FROM products WHERE sku LIKE '%".$keywords."%' OR name LIKE '%".$keywords."%' ".$limit)->execute();

      $data = array( );
      foreach( $result as $re )
      {
      $data[] = $re['id'];
      }

      return $data;
      }
     */

    /**
     * 返回搜索某关键词的结果总数，用于分页
     * @param sting $keywords 关键词
     * @return integer 结果总数
     */
    /*
      public static function search_count($keywords)
      {
      $result = DB::query(1, "SELECT count(id) as count FROM products WHERE sku LIKE '%".$keywords."%' OR name LIKE '%".$keywords."%'")->execute()->current();
      return $result['count'];
      }
     */
    public function price($quantity = 1)
    {   
        $customer = Session::instance()->get('user');
        if(isset($customer['id']) AND $customer['id'] != 0)
            $user_id = $customer['id'];
        else
            $user_id = 0;
        $key = '331/12product_price1233/' . $this->data['id'] . '/'.$user_id;
        $cache = Cache::instance('memcache');
//        if (!($price = $cache->get($key)))
       if (true)
        {
            $price = $this->data['price'];
            if($this->data['type'] == 1)
            {
                return Product::instance($this->default_item())->price();
            }

            //TODO configurable products has no rules by their own, should it be
            //the default_item's rules?
            if($quantity > 1 AND ! empty($this->data['configs']['bulk_rules']))
            {
                $rules = $this->data['configs']['bulk_rules'];
                $close_num = 0;
                foreach( $rules as $bulk_num => $bulk_price )
                {
                    if($bulk_num > $quantity)
                    {
                        break;
                    }
                    if($rules[$bulk_num] > 0)
                    {
                        $close_num = $bulk_num;
                    }
                }
                if($close_num)
                {
                    $price = $rules[$close_num];
                }
            }
            
            //special promotion

            /* new spromotion memcache --- sjm add 2015-12-14 */
            $sprice = 0;
            $spromotion_key = 'spromotion_' . $this->data['id'];
            $spromotion_data = $cache->get($spromotion_key);
            try 
            {
                $spromotion_data = unserialize($spromotion_data);
            }
            catch (Exception $e)
            {
            }
            if(!empty($spromotion_data) && is_array($spromotion_data))
            {
                foreach($spromotion_data as $s_type => $s_data)
                {
                    if($s_type != 0 && $s_data['created'] < time() && $s_data['expired'] >= time() && $s_data['price']>0)
                    {
                        $sprice = $s_data['price'];
                        break;
                    }
                }
            }
            else
            {

                $spromotion = DB::select('price', 'product_id', 'type', 'created', 'expired')
                    ->from('carts_spromotions')
                    ->where('product_id', '=', $this->data['id'])
                    ->where('type', '<>', 0)
                    ->where('expired', '>', time())
                    ->order_by('type')
                    ->execute()
                    ->current();
                $spromotion_data[$spromotion['type']] = array('price' => $spromotion['price'], 'created' => $spromotion['created'], 'expired' => $spromotion['expired']);
                $cache->set($spromotion_key, $spromotion_data);
                $sprice = $spromotion['price'];

            }
            /* new spromotion memcache --- sjm add 2015-12-14 */

            if($sprice)
            {
                // $cache->set($key, $sprice, 3600);
                return round($sprice, 2);
            }
            
            //TODO if it is a invisible simple product under a package or sth., it
            //should use the promotion rules of its father product. Coz it itself
            //may be invisible and belongs to no catalog / no corresponding promotion rule.
            //$promotion_id = $this->promotion();
            //$promotion_id = 0;
            $cache_key = 'promotions_product';
            $promotions = $cache->get($cache_key);
            $data = (isset($promotions) and !empty($promotions))?$promotions:'';

            try{
                $promotions = unserialize($promotions);
            }catch (Exception $e)
            {
            }
            if (empty($promotions))
            {
                $promotions = DB::select('id', 'filter', 'from_date', 'to_date')
                    ->from('carts_promotions')
                    ->and_where('is_active', '=', 1)
                    ->and_where('from_date', '<=', time())
                    ->and_where('to_date', '>=', time())
                    ->order_by('from_date', 'desc')
                    ->execute()
                    ->as_array();

                $cache->set($cache_key, $promotions, 0);
            }
            /* 批量购买无打折 */
            $quan = 100000;
            if( ! empty($this->data['configs']['bulk_rules']))
            {
                $key = 0;
                foreach( $this->data['configs']['bulk_rules'] as $q => $prices )
                {
                    $key ++;
                    if($key == 4 and $prices > 0)
                    {
                        $quan = $q;
                        break;
                    }
                }
            }
            if($promotions)
            {
                foreach( $promotions as $promotion )
                {
                    if($promotion['from_date'] > time() || $promotion['to_date'] < time())
                        continue;
                    /* 判断是否为双倍积分 */
        //            if($promotion['id'] == 27) continue;
                    /* if($quantity > 1 AND !empty($this->data['configs']['bulk_rules']))
                      continue; */
                    if($quantity >= $quan) continue;
                    if(FALSE !== ($tmp = Promotion::instance($promotion['id'])->apply_product($this->data['id'], $price)))
                    {
                        $price = $tmp;
                        break;
                    }
                }
            }

            $cache->set($key, $price, 4);//3600
        }

        return round($price, 2);
    }

    public function set($data = array( ))
    {
        $product = ORM::factory('product' )
            ->where('id', '=', $this->get('id'))
            ->find();
        if( ! $product)
        {
            return FALSE;
        }

        $product->values($data);
        $ret = $product->save();
        if($ret)
        {
            $this->data = array_merge((array) $this->data, $data);
        }

        return $ret;
    }

    public function set_basic($p_data, $product_id = NULL)
    {
        $data = array( );
        $data['set_id'] = Arr::get($p_data, 'set_id', 0);
        $data['type'] = Arr::get($p_data, 'type', 0);
        $data['site_id'] = Arr::get($p_data, 'site_id', 0);
        $data['pla_name'] = Arr::get($p_data, 'pla_name', 0);
        $data['store'] = Arr::get($p_data, 'store', 0);
        
        $data['name'] = htmlspecialchars(Arr::get($p_data, 'name', NULL));
        $data['sku'] = htmlspecialchars(Arr::get($p_data, 'sku', NULL));
        $data['link'] = strtolower(preg_replace('/&|\#|\?|\%| |\//', '-', Arr::get($p_data, 'link', '')));
        $data['visibility'] = Arr::get($p_data, 'visibility', 0);
        $data['status'] = Arr::get($p_data, 'status', 0);

        $data['price'] = Arr::get($p_data, 'price', 0);
        $data['market_price'] = Arr::get($p_data, 'market_price', 0);
        $data['cost'] = Arr::get($p_data, 'cost', 0);
        $data['total_cost'] = Arr::get($p_data, 'total_cost', 0);
        $data['extra_fee'] = Arr::get($p_data, 'extra_fee', 0);

        $data['weight'] = Arr::get($p_data, 'weight', 0);
        $data['size'] = Arr::get($p_data, 'size', 0);
        $data['stock'] = Arr::get($p_data, 'stock', -99);

        $data['description'] = Arr::get($p_data, 'description', NULL);
        $data['brief'] = Arr::get($p_data, 'brief', NULL);
        $data['specification'] = Arr::get($p_data, 'specification', NULL);
        $data['factory'] = Arr::get($p_data, 'factory', '');
        $data['offline_factory'] = Arr::get($p_data, 'offline_factory', '');
        $data['offline_sku'] = Arr::get($p_data, 'offline_sku', '');

        $data['level'] = Arr::get($p_data, 'level', NULL);
        $data['design'] = Arr::get($p_data, 'design', NULL);
        $data['style'] = Arr::get($p_data, 'style', NULL);
        $data['optimization'] = Arr::get($p_data, 'optimization', NULL);

        if(Arr::get($p_data, 'accessories', NULL)) $data['accessories'] = Arr::get($p_data, 'accessories', NULL);
        if( ! $product_id)
        {
            $data['created'] = time();
        }
        $data['updated'] = time();

        $data['meta_title'] = htmlspecialchars(Arr::get($p_data, 'meta_title', NULL));
        $data['meta_keywords'] = htmlspecialchars(Arr::get($p_data, 'meta_keywords', NULL));
        $data['meta_description'] = htmlspecialchars(Arr::get($p_data, 'meta_description', NULL));
        $data['default_catalog'] = Arr::get($_POST, 'default_catalog', 0);

        $data['configs'] = Arr::get($p_data, 'configs', array( ));

        $bulk_num = Arr::get($p_data, 'bulk_num', array( ));
        $bulk_price = Arr::get($p_data, 'bulk_price', array( ));
        $bulk_rules = array( );
        foreach( $bulk_num as $key => $num )
        {
            $num = intVal($num);
            if($num > 1 AND ! empty($bulk_price[$key]))
            {
                $bulk_rules[$num] = $bulk_price[$key];
            }
        }
        if( ! empty($bulk_rules))
        {
            ksort($bulk_rules);
            $data['configs']['bulk_rules'] = $bulk_rules;
        }
        elseif( ! empty($data['configs']['bulk_rules']))
        {
            unset($data['configs']['bulk_rules']);
        }

        if( ! empty($data['configs']))
        {
            $data['configs'] = serialize($data['configs']);
        }
        else
        {
            $data['configs'] = '';
        }
        //Add attributes for simple-config product
        if($data['type'] == 3 && isset($p_data['attributes']))
        {
            $attributes = Arr::get($p_data, 'attributes', array( ));
            if( ! empty($attributes)) $data['attributes'] = serialize($attributes);
            else $data['attributes'] = '';
        }

        //add supplier for simple product 2013-1-30 sjm
        $data['taobao_url'] = Arr::get($p_data, 'taobao_url', '');
        $query = parse_url($data['taobao_url'], PHP_URL_QUERY);
        parse_str( $query , $GET);
        if (isset($GET['id']))
                $data['taobao_id'] = $GET['id'];
        elseif (isset($GET['default_item_id']))
                $data['taobao_id'] = $GET['default_item_id'];
        else
                $data['taobao_id'] = '';

        $data['presell'] = Arr::get($p_data, 'presell', 0);
        $data['presell_message'] = Arr::get($p_data, 'presell_message', '');
        $data['keywords'] = Arr::get($p_data, 'keywords', '');
        $data['position'] = Arr::get($p_data, 'position', 0);
        $data['source'] = Arr::get($p_data, 'source', '');
        $data['offline_picker'] = Arr::get($p_data, 'offline_picker', '');

        $product = ORM::factory('product', $product_id);
        $same_url_product = ORM::factory('product' )->where('link', '=', $data['link'])->find();
        $same_sku_product = ORM::factory('product' )->where('sku', '=', $data['sku'])->find();
        if((($data['link'] == 'no-link' AND $data['visibility'] == 0) or ( ! $same_url_product->loaded() OR $same_url_product->id == $product_id)) AND ( ! $same_sku_product->loaded() OR $same_sku_product->id == $product_id))
        {
            $product->values($data);
            if($product->check())
            {
                $product->save();
                if (!$this->lang)
                {
                    $languages = Kohana::config('sites.' . $this->site_id . '.language');
                    $unset = array(
                        'name', 'brief', 'description', 'meta_title', 'meta_keywords', 'meta_description', 'keywords', 'presell_message', ''
                    );
                    foreach ($unset as $u)
                    {
                        if (isset($data[$u]))
                            unset($data[$u]);
                    }
                    foreach($languages as $l)
                    {
                        if($l === 'en')
                            continue;
                        $product1 = ORM::factory('product', $product_id);
                        if($product1->id)
                        {
                            $product1->values($data);
                            $product1->save();
                        }
                        else
                        {
                            $data['id'] = $product->id;
                            $product1 = ORM::factory('product');
                            $product1->values($data);
                            $product1->save();
                        }
                    }
                }
                
                return $product->id;
            }
            else
            {
                Message::set(__('product_data_error'), 'error');
            }
        }
        else
        {
            Message::set(__('product_data_duplicated'), 'error');
        }
        return FALSE;
    }

    public function add_images($product_id, $data)
    {
        $product_orm = ORM::factory('product' , $product_id);
        if( ! $product_orm->loaded())
        {
            return FALSE;
        }

        $images = Arr::get($data, 'images', '');
        $images = $images == '' ? array( ) : explode(',', $images);
        $images_removed = Arr::get($data, 'images_removed', '');
        $images_removed = $images_removed == '' ? array( ) : explode(',', $images_removed);
        $images_default = Arr::get($data, 'images_default', '');
        foreach( $images as $image_name )
        {
            $temp_path = $_SERVER['DOCUMENT_ROOT'].kohana::config('upload.temp_folder').'/'.$image_name;
            if( ! in_array($image_name, $images_removed))
            {
                $img_id = Image::set($temp_path, kohana::config('upload.product_image.type'), $this->site_id, $product_orm->id);
                if($images_default == $image_name AND $img_id)
                {
                    $product_configs = $product_orm->configs != '' ? unserialize($product_orm->configs) : array( );
                    $product_configs['default_image'] = $img_id;
                    $product_orm->configs = serialize($product_configs);
                    $product_orm->save();
                }
            }
            else
            {
                if(file_exists($temp_path))
                {
                    unlink($temp_path);
                }
            }
        }
        return $product_orm->configs;
    }

    public function edit_images($product_id, $data)
    {
        //处理删除的图片
        $images_removed = Arr::get($data, 'images_removed', '');
        $images_removed = $images_removed == '' ? array( ) : explode(',', $images_removed);
        foreach( $images_removed as $image_id )
        {
            $image = ORM::factory('image', $image_id);
            if($image->loaded() AND $image->type == kohana::config('upload.product_image.type') AND $image->product_id == $product_id)
            {
                Image::delete($image_id);
            }
        }
        //处理设为默认的图片
        $images_default = Arr::get($data, 'images_default', '');
        if($images_default != '')
        {
            $image = ORM::factory('image', $images_default);
            if($image->loaded() AND $image->type == kohana::config('upload.product_image.type') AND $image->product_id == $product_id)
            {
                $product = ORM::factory('product' , $product_id);
                if( ! $product->loaded())
                {
                    return FALSE;
                }
                $product_configs = $product->configs != '' ? unserialize($product->configs) : array( );
                $product_configs['default_image'] = $images_default;
                $product->configs = serialize($product_configs);
                $product->save();
            }
        }
        $images_order = Arr::get($data, 'images_order', '');
        if($images_order != '')
        {
            $product = ORM::factory('product', $product_id);
            if( ! $product->loaded())
            {
                return FALSE;
            }
            $product_configs = $product->configs != '' ? unserialize($product->configs) : array( );
            $product_configs['images_order'] = $images_order;
            $product->configs = serialize($product_configs);
            $product->save();
            return $product->configs;
        }
    }

    public function add_associated_products($product_id, $data)
    {
        $product = ORM::factory('product', $product_id);
        if( ! $product->loaded())
        {
            return FALSE;
        }
        $url_used_count = 0;

        $default_item = Arr::get($data, 'default_item', 0);
        $associated_products = Arr::get($data, 'associated', array( ));
        foreach( $associated_products as $key => $gdata )
        {
            $same_product = ORM::factory('product' )->where('sku', '=', Arr::get($gdata, 'sku', null))->find();
            if($same_product->loaded())
            {
                $url_used_count ++;
                continue;
            }
            // $gdata['site_id'] = $this->site_id;
            $gdata['type'] = 0;
            $gdata['visibility'] = 0;
            $gdata['link'] = 'no-link';
            $gdata['set_id'] = $product->set_id;
            $gdata['status'] = $product->status;
            $good_id = Product::instance()->set_basic($gdata);

            // add good options
            $goptions = Arr::get($gdata, 'options', array( ));
            if(isset($data['option_id']))
            {
                $goptions = array_merge($goptions, $data['option_id']);
            }
            Product::instance()->add_attributes($good_id, array(
                'option_id' => $goptions,
                'attributes' => Arr::get($data, 'attributes', array( ))
            ));

            //add pgroups record
            DB::insert('pgroups', array( 'group_id', 'product_id' ))->values(array( $product->id, $good_id ))->execute();

            if($default_item < 0 AND ($key * -1) == $default_item)
            {
                $product_configs = $product->configs != '' ? unserialize($product->configs) : array( );
                $product_configs['default_item'] = $good_id;
                $product->configs = serialize($product_configs);
                $product->save();
            }
        }
        $message = '';
        if($url_used_count)
        {
            $message = '批量生成的关联产品中，有'.$url_used_count.'个包含了重复的SKU，因此这'.$url_used_count.'个产品没有生成。';
        }
        return $message;
    }

    public function add_attributes($product_id, $data)
    {
        $product = ORM::factory('product', $product_id);
        if( ! $product->loaded())
        {
            return FALSE;
        }

        // add options relationships
        $option_ids = Arr::get($data, 'option_id', array( ));
        foreach( $option_ids as $option_id )
        {
            $option = ORM::factory('option', $option_id);
            if($option_id != '' AND $option->loaded())
            {
                $product->add('options', $option);
            }
        }

        //add attribute input values
        $input_attributes = Arr::get($data, 'attributes', array( ));
        foreach( $input_attributes as $attribute_id => $value )
        {
            $input_attribute = ORM::factory('attribute', $attribute_id);
            if($value != '' AND $input_attribute->loaded())
            {
                DB::query(Database::INSERT, "INSERT INTO product_attribute_values (product_id,attribute_id,value) values('".$product_id."','".$attribute_id."','".htmlspecialchars($value)."')")->execute();
            }
        }

        $this->set_keywords($product_id, $data);
    }

    public function edit_attributes($original_product, $data)
    {
        $product = ORM::factory('product' , $original_product['id']);
        if( ! $product->loaded())
        {
            return FALSE;
        }

        $option_ids = Arr::get($data, 'option_id', array( ));
        //TODO 判断是否有些必填的attribute没有填写  （本CLASS内所有涉及option存取的地方都要加上这个机制）
        //$original_products 里面已经有足够的option信息可供判断，不用再调ORM->has()之类的了！//okay I'm aware
        // -------------------> 避免同一attribute的两个option同时被添加！//done
        $deleted_options = array( );
        foreach( $option_ids as $attr_id => $option_id )
        {
            if( ! isset($original_product['attributes'][$attr_id]['selected_option_id']) OR $original_product['attributes'][$attr_id]['selected_option_id'] != $option_id)
            {
                $option = ORM::factory('option', $option_id);
                if($option_id != '' AND $option->loaded())
                {
                    $product->add('options', $option);
                }
                if(isset($original_product['attributes'][$attr_id]['selected_option_id']))
                {
                    $deleted_options[] = $original_product['attributes'][$attr_id]['selected_option_id'];
                }
            }
        }
        DB::query(4, "DELETE FROM product_options WHERE product_id = '".$original_product['id']."' AND option_id IN ('".implode("','", $deleted_options)."');")->execute();

        //add attribute input values
        $input_attributes = Arr::get($data, 'attributes', array( ));
        foreach( $input_attributes as $attribute_id => $value )
        {
            $input_attribute = ORM::factory('attribute', $attribute_id);
            if($input_attribute->loaded())
            {
                $has_it = $product->has('attributes', $input_attribute);
                if($has_it)
                {
                    if($value != '')
                    {
                        DB::query(Database::UPDATE, "UPDATE product_attribute_values set value = '".htmlspecialchars($value)."' WHERE product_id = '".$product->id."' AND attribute_id = '".$attribute_id."';")->execute();
                    }
                    else
                    {
                        DB::query(Database::DELETE, "DELETE FROM product_attribute_values WHERE product_id = '".$product->id."' AND attribute_id = '".$attribute_id."';")->execute();
                    }
                }
                elseif($value != '')
                {
                    DB::query(Database::INSERT, "INSERT INTO product_attribute_values (product_id,attribute_id,value) values('".$product->id."','".$attribute_id."','".htmlspecialchars($value)."')")->execute();
                }
            }
        }

        $this->set_keywords($original_product['id'], $data);
    }

    public function set_keywords($product_id, $data)
    {
        $product = ORM::factory('product' , $product_id);
        if( ! $product->loaded())
        {
            return FALSE;
        }

        $keywords = array( );

        $option_ids = Arr::get($data, 'option_id', array( ));
        foreach( $option_ids as $option_id )
        {
            $option = ORM::factory('option', $option_id);
            $keywords[] = $option->label;
        }

        $product->keywords = implode(' ', $keywords);
        $product->save();
    }

    public function add_related_products($product_id, $data)
    {
        $product_ids = Arr::get($data, 'product_ids', '');
        $product_ids = $product_ids == '' ? array( ) : explode(',', $product_ids);
        foreach( $product_ids as $related_product_id )
        {
            $related_product = ORM::factory('product' , $related_product_id);
            if($related_product->loaded())
            {
                DB::query(Database::INSERT, "INSERT INTO products_relatedproduct(product_id,related_product_id) values ('".$product_id."','".$related_product_id."')")->execute();
            }
        }
    }

    public function edit_related_products($original_product, $product_ids)
    {
        $product_ids = explode(',', $product_ids);
        foreach( $product_ids as $related_product_id )
        {
            $related_product = ORM::factory('product', $related_product_id);
            if($related_product->loaded() AND ! in_array($related_product_id, $original_product['related_products']))
            {
                DB::query(Database::INSERT, "INSERT INTO products_relatedproduct (product_id,related_product_id) values ('".$original_product['id']."','".$related_product_id."')")->execute();
            }
        }
        //清理删除掉的相关产品
        $deleted_related = array( );
        foreach( $original_product['related_products'] as $id )
        {
            if( ! in_array($id, $product_ids))
            {
                $deleted_related[] = $id;
            }
        }
        DB::query(4, "DELETE FROM products_relatedproduct WHERE product_id = '".$original_product['id']."' AND related_product_id IN ('".implode("','", $deleted_related)."');")->execute();
    }

    public function promotion()
    {
        $product_id = $this->data['id'];
        // get filters
        $now = time();
        $promotions = DB::select('filter', 'id')
            ->from('carts_promotions')
            ->and_where_open()
            ->where('from_date', '<=', $now)
            ->where('from_date', '!=', 0)
            ->or_where('from_date', '=', 0)
            ->and_where_close()
            ->and_where_open()
            ->where('to_date', '>=', $now)
            ->where('to_date', '!=', 0)
            ->or_where('to_date', '=', 0)
            ->and_where_close()
            ->execute();

        foreach( $promotions as $key => $promotion )
        {
            $filter = DB::select()->from('filters')
                    ->where('id', '=', $promotion['filter'])
                    ->execute()->current();

            // catalogs
            //TODO all products
            $catalog_ids = $filter['catalogs'] ? explode(',', $filter['catalogs']) : array( );
            $data = array( );
            foreach( $catalog_ids as $catalog_id )
            {
                $children = Catalog::instance($catalog_id)->children();
                $data = array_unique(array_merge($data, array( $catalog_id ), $children));
            }
            if($data)
            {
                //TODO check product in the catalogs

                $sql_catalog_ids_join = " LEFT JOIN products_categoryproduct
                    ON products_product.id= products_categoryproduct.product_id ";
                $sql_catalog_ids_where = " WHERE products_categoryproduct.category_id IN (".implode($data, ',').")
                    AND products_product.visibility = 1
                    AND products_product.id = ".$product_id;
            }
            else
            {
                $sql_catalog_ids_join = "";
                $sql_catalog_ids_where = " WHERE products_product.visibility = 1
                AND products_product.id = ".$product_id;
            }

            // sets
            $set_ids = $filter['sets'] ? $filter['sets'] : NULL;
            if($set_ids AND in_array($this->get('set_id'), explode(',', $filter['set_ids'])))
            {
                continue;
            }
            $option_ids = $filter['options'] ? explode(',', $filter['options']) : NULL;

            if($filter['sets'])
            {
                $sql_sets = " AND products.set_id IN (".$filter['sets'].")";
            }
            else
            {
                $sql_sets = "";
            }

            //options
            if($filter['options'] AND $filter['sets'])
            {
                $set_ids = $filter['sets'] ? explode(',', $filter['sets']) : array( );
                $option_ids = $filter['options'] ? explode(',', $filter['options']) : array( );

                $tmp = array( );
                foreach( $set_ids as $set_id )
                {
                    $result = DB::query(Database::SELECT, 'SELECT options.id FROM options
                        LEFT JOIN set_attributes
                        ON set_attributes.attribute_id=options.attribute_id
                        WHERE set_attributes.set_id ='.$set_id)->execute();
                    foreach( $result as $item )
                    {
                        $set_options[] = $item['id'];
                    }

                    if($intersect = array_intersect($set_options, $option_ids))
                    {
                        $tmp = array_merge($tmp, $set_options);
                    }
                }

                $sql_option_ids = array( );
                foreach( $tmp as $item )
                {
                    if( ! in_array($item, $option_ids))
                    {
                        $sql_option_ids[] = $item;
                    }
                }

                $sql_option_ids = implode(array_unique($sql_option_ids), ',');

                $sql_option_ids_join = " LEFT JOIN product_options
                    ON product_options.product_id = products.id ";
                $sql_option_ids_where = " AND product_options.option_id NOT IN(".$sql_option_ids.")";
            }
            else
            {
                $sql_option_ids_join = "";
                $sql_option_ids_where = "";
            }

            // price
            if($filter['price_upper'])
            {
                $sql_price_upper = " AND products.price <".$filter['price_upper'];
            }
            else
            {
                $sql_price_upper = "";
            }

            if($filter['price_lower'])
            {
                $sql_price_lower = " AND products.price >".$filter['price_lower'];
            }
            else
            {
                $sql_price_lower = "";
            }

            $order_sql = ' ORDER BY created DESC';
            $limit_sql = '';

            /*
              if($filter['hot'] > 0)
              {
              $order_sql = ' ORDER BY hits DESC';
              $limit_sql = ' LIMIT '.$filter['hot'];
              }
              elseif($filter['hot'] < 0)
              {
              $order_sql = ' ORDER BY hits ASC';
              $limit_sql = ' LIMIT '.abs($filter['hot']);
              }

              if($filter['new'] > 0)
              {
              $order_sql = ' ORDER BY created DESC';
              $limit_sql = ' LIMIT '.$filter['new'];
              }
              elseif($filter['new'] < 0)
              {
              $order_sql = ' ORDER BY created ASC';
              $limit_sql = ' LIMIT '.abs($filter['new']);
              }
             */



            $sql = "SELECT products.id FROM products ".$sql_catalog_ids_join.
                $sql_option_ids_join.
                $sql_catalog_ids_where.
                $sql_option_ids_where.
                $sql_price_lower.
                $sql_price_upper.
                $sql_sets.
                $order_sql.
                $limit_sql;

            $result = DB::query(Database::SELECT, $sql)->execute()->current();


            if($result['id'])
            {
                return $promotion['id'];
            }
        }

        return NULL;
    }

    public function package_rules_validation($data)
    {
        $rules = $data['packaged'];

        $min_sum = $max_sum = 0;
        if(isset($rules['total']) AND isset($rules['min']) AND isset($rules['max']))
        {
            foreach( $rules['min'] as $key => $min )
            {
                if( ! $rules['max'][$key] OR $rules['max'][$key] < $min)
                {
                    return 'invalid_package_quantities';
                }
                $min_sum += $min;
                $max_sum += $rules['max'][$key];
            }
            if($min_sum > $rules['total'])
            {
                return 'invalid_package_min_summary';
            }
            elseif($max_sum < $rules['total'])
            {
                return 'invalid_package_max_summary';
            }
        }
        /* allow empty package
          else
          {
          return 'invalid_package_total_quantity';
          } */
        return TRUE;
    }

    public function set_package($product_id, $data)
    {
        $product = ORM::factory('product' , $product_id);
        if( ! $product->loaded())
        {
            return FALSE;
        }

        $goods = $data['packaged_ids'] ? explode(',', $data['packaged_ids']) : array( );

        $original_packaged_ids = Db::query(Database::SELECT, "SELECT product_id FROM ppackages WHERE package_id = $product_id")->execute()->as_array('product_id', 'product_id');

        $added = array_diff($goods, $original_packaged_ids);
        foreach( $added as $id )
        {
            $good = Product::instance($id);
            if($good->get('id') AND $good->get('type') != 2)
            {
                DB::query(Database::INSERT, "INSERT INTO ppackages(package_id,product_id) values($product_id,$id)")->execute();
            }
        }

        $deleted = array_diff($original_packaged_ids, $goods);
        if($deleted)
        {
            DB::delete('ppackages')->where('package_id', '=', $product_id)->and_where('product_id', 'in', $deleted)->execute();
        }
    }

    /*
     * e.g. Product::instance($product_id)->set_view_history()  to add a product
     * to the view history
     * Be sure to call it before any output is sent to the browser.
     */

    public function set_view_history()
    {
        if( ! $this->data['id'])
        {
            return FALSE;
        }

        $history_max = 10;

        if($history = array_reverse($this->get_view_history()))
        {
            $idx = array_search($this->data['id'], $history);
            if($idx === FALSE)
            {
                if(count($history) >= $history_max)
                {
                    unset($history[0]);
                }
            }
            else
            {
                unset($history[$idx]);
            }
        }

        $history[] = $this->data['id'];

        Cookie::set('_vh', implode(',', array_reverse($history)));
    }

    public function get_view_history()
    {
        $history = Cookie::get('_vh', '');
        $history = $history ? explode(',', $history) : array( );

        return $history;
    }
    
    public function clear_view_history()
    {
            Cookie::set('_vh', '');
    }

    public function set_catalogs($pid, $catalogs, $is_new = NULL)
    {
        if( ! $is_new)
        {
            $old_catalogs = DB::select('category_id')
                ->from('products_categoryproduct')
                ->where('product_id', '=', $pid)
                ->execute()
                ->as_array('category_id', 'category_id');
            $added = array_diff($catalogs, $old_catalogs);
            $deleted = array_diff($old_catalogs, $catalogs);
        }
        else
        {
            $added = $catalogs;
            $deleted = array( );
        }

        foreach( $added as $cata_id )
        {
            DB::query(Database::INSERT, "INSERT INTO products_categoryproduct (category_id,product_id,position)values($cata_id,$pid,0)")->execute();
        }

        if($deleted)
        {
            DB::query(Database::DELETE, "DELETE FROM products_categoryproduct WHERE product_id = $pid AND category_id IN (".implode(',', $deleted).") ")->execute();
        }
    }

    //todo
    public function hit($quantity)
    {
        
    }

    public function get_catalogs($_limit)
    {
        if( ! $this->data['id'])
        {
            return FALSE;
        }

        if($_limit)
        {
            $limit = ' LIMIT 0,'.$_limit;
        }

        $product_catalogs = DB::query(Database::SELECT, 'SELECT catalog_id FROM products_categoryproduct as cp LEFT JOIN products_category as c ON (c.id = cp.catalog_id) WHERE cp.product_id = '.$this->data['id'].' AND c.visibility = 1 '.$limit)->execute()->as_array('catalog_id', 'catalog_id');

        return $product_catalogs;
    }

    public function hits_inc($delta=1)
    {
        return DB::query(Database::UPDATE, "UPDATE products_product SET hits=hits+$delta WHERE id=".$this->get('id'))
                ->execute();
    }

    public function hits_dec($delta=1)
    {
        return DB::query(Database::UPDATE, "UPDATE products_product SET hits=hits-$delta WHERE id=".$this->get('id'))
                ->execute();
    }

    public function product_time()
    {
        $date_first = '1293619832';
        $date_last = '1305800409';
        $date_first_result = DB::query(DATABASE::SELECT, 'SELECT * FROM products_product ORDER BY created ASC LIMIT 0, 1')->execute();
        $date_last_result = DB::query(DATABASE::SELECT, 'SELECT * FROM products_product ORDER BY created DESC LIMIT 0, 1')->execute();
        foreach( $date_first_result as $value )
        {
            $date_first = $value['created'];
        }
        foreach( $date_last_result as $value )
        {
            $date_last = $value['created'];
        }
        $time_new = date("Y-m", $date_last);
        $time_old = date("Y-m", $date_first);
        $year_new = date("Y", $date_last);
        $year_old = date("Y", $date_first);
        $month_new = date("m", $date_last);
        $month_old = date("m", $date_first);
        $data = array( );
        if($year_new == $year_old)
        {
            for( $m = $month_old * 1; $m <= $month_new; $m ++  )
            {
                $m > 9 ? $data[] = $year_old.$m : $data[] = $year_old.'0'.$m;
            }
            return $data;
        }
        else
        {
            $k = ($year_new - $year_old) * 12 + ($month_new - $month_old);
            $m = $month_old * 1;
            for( $i = 0; $i <= $k; $i ++  )
            {
                $m > 9 ? $time = $year_old.$m : $time = $year_old.'0'.$m;
                if(substr($time, 4) > 12)
                {
                    $m = 1;
                    $year_old += 1;
                    $time = $time = $year_old.'0'.$m;
                    $data[] = $time;
                }
                else
                {
                    $data[] = $time;
                }
                $m ++;
            }
            return $data;
        }
    }

    public function reviews()
    {
        return DB::select()
                ->from('product_reviews')
                ->where('product_id', '=', $this->get('id'))
                ->execute();
    }

    public static function hot_products($limit = 5)
    {
        $hot_id = DB::select('id')
            ->from('products')
            ->order_by('hits', 'DESC')
            ->limit($limit)
            ->execute();
        foreach( $hot_id as $id )
        {
            $products[] = new Product($id);
        }

        return $products;
    }

    public function review_grade()
    {
        $grade = DB::select(DB::expr('AVG(grade) AS `grade`'))
            ->from('product_reviews')
            ->where('product_id', '=', $this->get('id'))
            ->execute()
            ->get('grade');

        return $grade ? intval($grade) : 3;
    }

    public function products_related($limit=NULL)
    {
        $products_id = DB::select('related_product_id')
            ->from('products_relatedproduct')
            ->where('product_id', '=', $this->get('id'))
            ->execute();

        $related_products = array( );
        foreach( $products_id as $product_id )
        {
            $product = new Product($product_id);
            if( ! $product->get('id') || ! $product->get('visibility'))
            {
                continue;
            }

            $related_products[] = $product;
            if($limit && count($related_products) >= $limit) break;
        }

        return $related_products;
    }

    //get product of menu1 menu2 menu3 menu4
    public static function menu_products()
    {
        $catalogs = ORM::factory('catalog')
            ->where('link', 'like', 'menu%')
            ->where('on_menu', '=', 0)
            ->where('visibility', '=', 0)
            ->order_by('link')
            ->find_all();
        if(count($catalogs) > 0)
        {
            foreach( $catalogs as $catalog )
            {
                $menu_products[$catalog->name] = array( );
                $products = DB::select()
                    ->from('products_categoryproduct')
                    ->where('category_id', '=', $catalog->id)
                    ->where('product_id', '<>', 0)
                    ->execute()
                    ->as_array();
                if(count($products) > 0)
                {
                    foreach( $products as $product )
                    {
                        $menu_products[$catalog->name][] = $product['product_id'];
                    }
                }
            }
            return $menu_products;
        }
        else
        {
            return array( );
        }
    }
    
    public function daily_clicks()
    {
            $today = strtotime('midnight') - 18000;
            $id = DB::select('id')->from('products_daily')->where('day', '=', $today)->and_where('product_id', '=', $this->get('id'))->execute()->get('id');
            if($id)
            {
                    return DB::query(Database::UPDATE, 'UPDATE products_daily SET clicks = clicks + 1 WHERE id = '.$id)->execute();
            }
            else
            {
                    $data = array(
                        'day' => $today,
                        'product_id' => $this->get('id'),
                        'clicks' => 1
                    );
                    return DB::insert('products_daily', array_keys($data))->values($data)->execute();
            }
    }
    
    public function daily_quick_clicks()
    {
            $today = strtotime('midnight') - 18000;
            $id = DB::select('id')->from('products_daily')->where('day', '=', $today)->and_where('product_id', '=', $this->get('id'))->execute()->get('id');
            if($id)
            {
                    return DB::query(Database::UPDATE, 'UPDATE products_daily SET quick_clicks = quick_clicks + 1 WHERE id = '.$id)->execute();
            }
            else
            {
                    $data = array(
                        'day' => $today,
                        'product_id' => $this->get('id'),
                        'quick_clicks' => 1
                    );
                    return DB::insert('products_daily', array_keys($data))->values($data)->execute();
            }
    }
    
    public function daily_add_times()
    {
            $today = strtotime('midnight') - 18000;
            $id = DB::select('id')->from('products_daily')->where('day', '=', $today)->and_where('product_id', '=', $this->get('id'))->execute()->get('id');
            if($id)
            {
                    return DB::query(Database::UPDATE, 'UPDATE products_daily SET add_times = add_times + 1 WHERE id = '.$id)->execute();
            }
            else
            {
                    $data = array(
                        'day' => $today,
                        'product_id' => $this->get('id'),
                        'add_times' => 1
                    );
                    return DB::insert('products_daily', array_keys($data))->values($data)->execute();
            }
    }
    
    public function daily_hits($delta=1)
    {
            $today = strtotime('midnight') - 18000;
            $id = DB::select('id')->from('products_daily')->where('day', '=', $today)->and_where('product_id', '=', $this->get('id'))->execute()->get('id');
            if($id)
            {
                    return DB::query(Database::UPDATE, 'UPDATE products_daily SET hits = hits + '.$delta.' WHERE id = '.$id)->execute();
            }
            else
            {
                    $data = array(
                        'day' => $today,
                        'product_id' => $this->get('id'),
                        'hits' => $delta
                    );
                    return DB::insert('products_daily', array_keys($data))->values($data)->execute();
            }
    }

    public function tags()
    {
        $cache = Cache::instance('memcache');
        $key = "/productv/".$this->data['id'].'/tags';
        if( ! ($data = $cache->get($key)))
        {
            $result = DB::select('tag_id')->from('products_tagproduct')
                ->where('product_id', '=', $this->data['id'])
                ->execute();

            $data = array( );
            foreach( $result as $tag )
            {
                $data[] = $tag['tag_id'];
            }

            $cache->set($key, $data, 3600);
        }

        return $data;
    }

    // get attributes size --- sjm 2016-01-27
    public function get_attributes()
    {
        $return_data = array();
        $attributes = $this->data['attributes'];
        if (!empty($attributes))
        {
            /*if (isset($attributes['Size']) OR isset($attributes['size']))
            {
                $one_size = 0;
                $attr_sizes = isset($attributes['Size']) ? $attributes['Size'] : $attributes['size'];
                if (count($attr_sizes) == 1 && isset($attr_sizes[0]) && $attr_sizes[0] == 'one size')
                    $one_size = 1;
                if($one_size)
                {
                    $return_data = array('one size');
                }
                else
                {
                    $return_data = $attr_sizes;
                }
            }*/
            if (isset($attributes[0]))
            {
                $one_size = 0;
                $attribute = $attributes[0]['options'];
                $attr_sizes = explode(',', $attribute);
                if (count($attr_sizes) == 1 && isset($attr_sizes[0]) && $attr_sizes[0] == 'one size')
                    $one_size = 1;
                if($one_size)
                {
                    $return_data = array('one size');
                }
                else
                {
                    $return_data = $attr_sizes;
                }
            }
        }
        return $return_data;
    }

    //get product stocks --- sjm 2016-01-27
    public function get_stocks()
    {
        if($this->data['stock'] == -1)
        {
//            $data = array();
//            $attributes = $this->get_attributes();
            $stocks = DB::select()->from('products_productitem')
                ->where('product_id', '=', $this->data['id'])
                ->execute();
//            foreach($attributes as $attribute)
//            {
//                $data[$attribute] = 0;
//                foreach($stocks as $stock)
//                {
//                    if(trim($stock['attribute']) == trim($attribute) OR strpos($stock['attributes'], $attribute) !== false)
//                    {
//                        $data[$attribute] = $stock['stocks'];
//                        break;
//                    }
//                }
//            }
            return $stocks;
        }
        else
        {
            return array();
        }
    }
//改版前小语种name
    public function transname()
    {
        $cache = Cache::instance('memcache');
        $key = "/product/".$this->data['id'].'/trans'.$this->lang;

        if( ! ($data = $cache->get($key)))
        {
            $result = DB::select('trans_de','trans_es','trans_fr')->from('trans')
                ->where('product_id', '=', $this->data['id'])
                ->execute('slave')->as_array();

            if(isset($result[0]['trans_'.$this->lang]) && !empty($result[0]['trans_'.$this->lang]))
            {
                $name = $result[0]['trans_'.$this->lang];
                $cache->set($key, $name, 86400 * 20);
                return $name;
            }
            else
            {
                $cache->set($key, $this->data['name'], 86400 * 20);
                return $this->data['name'];
            }
        }
        return $data;
    }
    //改版后小语种产品name，brief, description
    public function productTransName($id)
    {
        $cache = Cache::instance('memcache');
        $key = "/product/translate/".$this->lang.'/'.$id;
        if( ! ($data = $cache->get($key)))
        {
            $check = array('es','de','fr');
            if(in_array($this->lang,$check))
            {
                $table = $this->lang;
            }else{
                return false;
            }
            $res = DB::select()->from('products_trans_' . $table)
                ->where('product_id', '=', $id)
                ->execute('slave')
                ->current();
            if ($res)
            {
                $cache->set($key,$res,86400 * 20);
                return $res;
            } else {
                return false;
            }
        }
        return $data;
    }

    public function productTrans($id,$lang)
    {
        $check = array('es','de','fr');
        if(!in_array($lang,$check))
        {
            return false;
        }
        $product = DB::select('name','description','brief')->from('products_product')
            ->where('id','=',$id)
            ->execute('slave')
            ->current();
        $table = 'products_trans_'.$lang;
        $trans = DB::select()->from($table)
            ->where('product_id','=',$id)
            ->execute('slave')
            ->as_array();
        $data = array();
        foreach ($product as $key => $str)
        {
            $str = strip_tags($str);
            $str = str_replace("\\",'',$str);
            $res = Site::googletransapi($blank='en',$target=$lang,$str);
            if($res != 1) {
                $words1 = json_decode($res);
                $data[$key] = $words1->data->translations[0]->translatedText;
            }
        }
        if(!empty($data))
        {
            $data['product_id'] = $id;
            if($trans)
            {
                DB::update($table)->where('product_id','=',$id)->set($data)->execute();
            }else{
                DB::insert($table,array_keys($data))->values($data)->execute();
            }
            return $data;
        }else{
            return false;
        }

    }

    public function get_attr()
    {
        $cache = Cache::instance('memcache');
        $key = "/productv/".$this->data['id'].'/attr';
        if(  ($data = $cache->get($key)))
        {
            $filters = DB::query(DATABASE::SELECT, 'SELECT DISTINCT filter_id FROM products_productfilter WHERE product_id = '.$this->data['id'])->execute('slave')->as_array();
            $data = array();
            if($filters)
            {
                $filt = '(';
                foreach ($filters as $key => $value) 
                {
                    $filt .= $value['filter_id'].','; 
                }
                $filt = substr($filt,0,-1);
                $filt = $filt.')';
                $filter_sort = DB::query(DATABASE::SELECT, 'SELECT name,options FROM products_filter WHERE id in '.$filt)->execute('slave')->as_array();
                foreach ($filter_sort as $key => $value) 
                {
                    $keys = strtoupper($value['name']);
                    $values = strtolower($value['options']);
                    $data[$keys] = $values;
                }
            }
            else
            {
                $data = array(1);
            }

            $cache->set($key, $data, 3600);            
        }
        return $data;
    }

    public function allitem()
    {
        $array = array();
        $cache = Cache::instance('memcache');
        $key = "1/productitem/".$this->data['id'];
        if( ! ($data = $cache->get($key)))
        {
            $items = DB::select()->from('products_productitem')
                ->where('product_id', '=', $this->data['id'])
                ->and_where('status', '=', 1)
                ->execute('slave')->as_array();
            foreach ($items as $key => $value) 
            {
                $array[$value['id']] = $value['attribute'];
            }

            $data = $array;
            $cache->set($key, $data, 3600); 
        }

        return $data;
    }

    public function allCategory()
    {
        $cache = Cache::instance('memcache');
        $key = "allcategory".$this->data['id'];
        if(!($data = $cache->get($key)))
        {
            $category = DB::select()->from('products_categoryproduct')->where('product_id','=',$this->data['id'])->execute()->as_array();
            foreach ($category as $key => $value)
            {
                $res = DB::select()->from('products_category')->where('id','=',$value['category_id'])->where('visibility','=',1)->execute()->current();
                if(!$res)
                {
                    unset($category[$key]);
                }
            }
            $return = '';
            foreach ($category as $value)
            {
                $return .= $value['category_id'].' ';
            }
            $data = $return;
            $cache->set($key, $return, 3600);
        }
        return $data;
    }

    //返回产品尺码（主要是为了处理鞋子尺码，根据ip返回对应国家的鞋子尺码）, 返回数组 array(sku => size)
    public function checkSize()
    {
        $items = DB::select()->from('products_productitem')
            ->where('product_id', '=', $this->data['id'])
            ->order_by('sku')
            ->execute('slave')
            ->as_array();
        $data = array();
        //判断是否是鞋子
        if (isset($items[0]['attribute']) and strpos($items[0]['attribute'], 'US') !== FALSE)
        {
            // include the php script
            $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
            // 获取国家代码
            $country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
            if ($country_code == 'US')
            {
                $index = 0;
                $country = 'US';
            }
            elseif ($country_code == 'GB' OR $country_code == 'UK')
            {
                $index = 1;
                $country = 'UK';
            }
            else
            {
                $index = 2;
                $country = '';
            }
            foreach($items as $item)
            {
                $size = explode('/',$item['attribute']);
                if(isset($size[$index]))
                {
                    $data[$item['sku']] = $country . preg_replace('/[A-Z]+/i', '', $size[$index]);
                }
            }
        }else{
            foreach($items as $item)
            {
                $data[$item['sku']] = $item['attribute'];
            }
        }
        return $data;

    }
}
