<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Import extends Controller_Admin_Site
{
    public $site_id;

    function action_options(){
          $file = '/tmp/data/import/'.$this->site_id.'/options.csv';
          if(($handle = fopen($file,"r"))!== FALSE){
                while(($data = fgetcsv($handle, 100, ","))!==FALSE){
                      $options = ORM::factory('option');
                      $options->label = $data[0];
                      $options->position = $data[1];
                      $options->default = $data[2];
                      $options->site_id = $this->site_id;
                      $attribute = ORM::factory('attribute')->where('name','=',json_decode($data[3]))->where('site_id','=',$this->site_id)->find();
                      $options->attribute_id = $attribute->id;
                      $options->save();
                }
                echo "import success!";
                fclose($handle);
          }else{
                echo 'no such file!';
          }
    }

    public function action_catalog()
    {
        $file = '/tmp/data/import/'.$this->site_id.'/catalog.csv';

        if (($handle = fopen($file, "r")) !== FALSE) 
        {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                $catalog = ORM::factory('catalog');
                $catalog->site_id = $this->site_id;
                $catalog->oid = $data[1];
                $catalog->name = $data[2];
                $catalog->link = $data[3];
                //TODO 
                $catalog->parent_id = $data[4];
                $catalog->description = $data[5];
                $catalog->meta_title = $data[6];        
                $catalog->meta_keywords = $data[7];        
                $catalog->meta_description = $data[8];        
                $catalog->brief = $data[9];        
                $catalog->visibility = $data[10];        
                $catalog->template = $data[11];        
                $catalog->orderby = $data[12];
                $catalog->save();
            }
            echo "import success!";
            fclose($handle);
            //TODO
            //unlink($path);
        }
        else
        {
            echo 'no catalog file';
        }
    }

    public function action_catalog_relation()
    {
        $catalogs = ORM::factory('catalog')
            ->where('site_id','=',$this->site_id)
            ->find_all();

        foreach($catalogs as $catalog)
        {
            $obj = ORM::factory('catalog',$catalog->id);
            $parent = ORM::factory('catalog') 
                ->where('site_id', '=', $this->site_id)
                ->where('oid','=',$obj->parent_id)
                ->find();

            if($parent->loaded())
            {
                $obj->parent_id = $parent->id;
                echo 'updated '.$obj->name." 's parent :".$parent->name."<br/>";  
            }
            else
            {
                $obj->parent_id = 0;
                echo 'updated '.$obj->name." 's parent :NULL<br/>";  
            }
            $obj->save();
        }
        echo "import success!";
    }

    public function action_product()
    {
        $result = ORM::factory('catalog')
            ->where('site_id','=',$this->site_id)
            ->find_all();

        $catalogs = array();
        foreach($result as $catalog)
        {
            $catalogs[$catalog->oid] = $catalog->id;
        }

        $file = '/tmp/data/import/'.$this->site_id.'/product.csv';

        if (($handle = fopen($file, "r")) !== FALSE) 
        {
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) 
            {
              $product = ORM::factory('product');

              if($data[15] == 1) {
                    $s = json_decode($data[22]);
                    $at_arr = array();
                    foreach($s as $ss=>$bb) {
                        $atrrrr = ORM::factory('attribute')->where('name','=',$ss)->and_where('site_id','=',$this->site_id)->and_where('type','=',0)->find();
                        if($atrrrr->loaded()){
                          $at_arr[] = (int)$atrrrr->id;
                        }
                    }
                    $datas = array('configurable_attributes' => $at_arr);
                    $configs = is_array($datas)?serialize($datas):' ';
                    $product->configs = $configs;
                }
                
                $product->site_id = $this->site_id;
                $product->oid = $data[0];        
                $product->name = $data[1];        
                $product->sku = $data[2];        
                $product->link = $data[3];        
                $product->price = $data[4];        
                $product->market_price = $data[5];        
                $product->cost = $data[6];
                $product->weight = $data[7];        
                $product->stock = $data[8];
                $product->brief = $data[9];
                $product->description = $data[10];
                $product->meta_title = $data[11];
                $product->meta_keywords = $data[12];
                $product->meta_description = $data[13];
                // update set 
                if($data[14])
                {
                    $set = ORM::factory('set')
                        ->where('label','=',$data[14])
                        ->where('site_id','=',$this->site_id)
                        ->find();
                    if($set->loaded())
                    {
                        $product->set_id = $set->id;
                    }
                    else
                    {
                        $product->set_id = 0;
                    }
                }
                else
                {
                    $product->set_id = 0;
                }
                $product->type = $data[15];
                $product->visibility = $data[16];        
                $product->status = $data[17];        
                $product->freeshipping = $data[18];        

                if($data[19])
                {
                    $product->default_catalog = $catalogs[$data[19]];        
                }
                else
                {
                    //TODO 1
                    $product->default_catalog = 0;
                }
                $product->images = $data[20];        
                //TODO get catalogs
                $catalog_data = json_decode($data[21]);

                $product->created = time();
                $product->updated = time();
                $product->save();
                if($catalog_data)
                {

                    // update catalog
                    foreach($catalog_data as $catalog_oid)
                    {
                        Db::insert('catalog_products', array('catalog_id','product_id'))
                            ->values(array($catalogs[$catalog_oid], $product->id))
                            ->execute(); 
                    }
                }

                // update attributes
                $attribute_data = json_decode($data[22]);
                foreach($attribute_data as $key=>$value)
                {
                    if(! $value)
                    {
                        continue; 
                    }

                    $attribute = ORM::factory('attribute') 
                        ->where('site_id','=',$this->site_id)
                        ->where('name','=',$key)
                        ->find();
                    if($attribute->loaded())
                    {
                        if($attribute->type <= 1)     
                        {
                            // insert option 
                            echo 'insert option'.$value;
                            // get option id
                            $option = ORM::factory('option')
                                ->where('site_id','=',$this->site_id)
                                ->where('label','=',$value)
                                ->find();
                            if($option->loaded())
                            {
                                Db::insert('product_options',array('product_id', 'option_id'))
                                    ->values(array($product->id,$option->id))
                                    ->execute();
                            }
                        }
                        else
                        {
                            // insert value 
                            Db::insert('product_attribute_values',array('product_id', 'attribute_id', 'value'))
                                ->values(array($product->id,$attribute->id,$value))
                                ->execute();
                        }
                    }
                }
            }
            echo "import success!";
            fclose($handle);
            //TODO
            //unlink($path);
        }
        else
        {
            echo 'no product file';
        }
        echo View::factory('profiler/stats');
    }

    public function action_config()
    {
        $products = ORM::factory('product')
            ->where('site_id', '=', $this->site_id)
            ->where('type', '=', 1)
            ->find_all();

        $data = array('configurable_attributes' => array(283));
        foreach($products as $product)
        {
            echo $product->id."<br/>";
            $product->configs = serialize($data);
            $product->save();
        }
        
    }

    public function action_groups()
    {
        $file = '/tmp/data/import/'.$this->site_id.'/group.csv';
        if (($handle = fopen($file, "r")) !== FALSE) 
        {
            while (($data = fgetcsv($handle, 100, ",")) !== FALSE) 
            {
                $product_oid = $data[0];
                $product = ORM::factory('product')->where('oid', '=', $product_oid)->and_where('site_id','=',$this->site_id)->find();
                echo $product->id."<br/>";
                $group_oids = json_decode($data[1]);
                if($group_oids)
                {
                    foreach($group_oids as $group_oid) 
                    {
                        $item = ORM::factory('product')->where('oid', '=', $group_oid)->and_where('site_id','=',$this->site_id)->find();
                        Db::insert('pgroups',array('group_id', 'product_id'))->values(array($product->id,$item->id))->execute();
                    }
                }
            }
            echo "import success!";
            fclose($handle);
            //TODO
            //unlink($path);
        }
        else
        {
            echo 'no catalog file';
        }
    }

    public function action_set_attributes(){
          $file = '/tmp/data/import/'.$this->site_id.'/set_attributes.csv';
          if(($handle = fopen($file,'r'))!== FALSE){
                while(($data = fgetcsv($handle,100,',')) !== FALSE){
                      $attribute = ORM::factory('attribute')->where('name','=',json_decode($data[0]))->where('site_id','=',$this->site_id)->find();
                      $set = ORM::factory('set')->where('name','=',json_decode($data[1]))->where('site_id','=',$this->site_id)->find();
                      Db::insert('set_attributes',array('attribute_id', 'set_id','position'))->values(array($attribute->id,$set->id,$data[2]))->execute();
                }
                echo "import success!";
                fclose($handle);
          }
    }
}
