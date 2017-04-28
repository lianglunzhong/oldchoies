<?php

defined('SYSPATH') or die('No direct script access.');

class api
{
	public static function send_wait_email($items,$order_id,$days)
	{
		$itemarr = explode(',',$items);
    
        $order = Order::instance($order_id);

        // unset($itemarr[0]);

        //ws-api baodeng start
        if(empty($itemarr)){
            $itemarr[]=$items;
        }
        //ws-api baodeng finish
        $item = '';
        $item_skus='';

        foreach($itemarr as $k=>$v){
            $result = $order->get_item($v);
            $item .= $result['name'] .' '.$result['attributes'] .' '. $result['sku'] .' $'. round($result['price'],2) .'   '.$result['quantity'];
            $item_skus.=$result['sku'].';';
        }

        
        $data['email'] = $order->get('email');
        // $data['email'] ="2546763702@qq.com";
        $firstname = $order->get('shipping_firstname');  
        $email_params = array(
                    'firstname' => $firstname,
                    'email' => $data['email'],
                    'order_num' => $order->get('ordernum'),
                    'waiting' =>$days,
                    'item' =>$item
        );

        
// var_dump($email_params);
// return false;

       $r= Mail::SendTemplateMail('NEWSPAPER', $email_params['email'], $email_params);

       // if(empty($r)){
       //      return false;
       // }else{
            $comment = '发送报等邮件,报等天数：'.$days.'天'.$item_skus;
            $order->add_history(array(
                'order_status' => 'send baodeng',
                'message' => $comment,
            ));
            return true;
       // }
	}

    public static function send_birthday_email()
    {
        set_time_limit(0);
        $today = date('Y-m-d');
        $temp = explode('-', $today);
        $birth = array($temp['1'],$temp['2']);
        $birthday = implode('-', $birth);

        

        try
                {
                    $user = DB::select('email','firstname')->from('accounts_customers')
                        ->where('birth','!=', '')
                        ->and_where('birth','=', $birthday)
                        ->execute('slave');
                      foreach($user as $v){
                                $mail_params['firstname'] = $v['firstname'];
                                $mail_params['email'] = $v['email'];
// var_dump($mail_params);
                        Mail::SendTemplateMail('BIRTHDAY', $mail_params['email'], $mail_params);
                      
                      }

                }
        catch( Database_Exception $e )
        {
            echo $e->getMessage();
        }
    }

    public static function import_product_info($data)
    { 
        $res=array();
        $res['flag']=0;
        $res['mes']='';
        $res['id']=0;
        $res['type']='';

        try
        {
            if (!$data['sku'])
            {
                $res['mes']='empty sku';
                return $res;
            }
            
            $data = Security::xss_clean($data);

            $product = array();

            $obj = ORM::factory("product")
                ->where('sku', '=', $data['sku'])
                ->find();
            if ($obj->loaded())
            {
                $res['type']='update';
                $res['id']=$obj->id;
            }
            else
            {
                $res['type']='insert';

                //link,此处link不允许update修改
                $name_link = strtolower(preg_replace('/[^\w\b]+/', '-', trim($data['name'])));
                $link = $name_link;
                $duplicated_num = 1;
                while ($duplicated_num > 0)
                {
                    $obj = ORM::factory('product')
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
//                $product['created'] = date('Y-m-d H:i:s');
                $product['created'] = time();
                $product['visibility']=0;
            }
   
            $product['name'] = $data['name'];
            $product['description'] = str_replace("\n", '<br>', $data['description']);
            $product['brief'] = $data['brief'];
            
            $product['sku'] = $data['sku'];
            
            $product['market_price'] = $data['market_price'];
            $product['cost'] = $data['cost'];
            $product['total_cost'] = $data['total_cost'];
            $product['taobao_url']=$data['taobao_url'];
            $product['factory']=$data['factory'];
            $product['source']=$data['source'];
            $product['store']=$data['store'];
            $product['cn_name']=$data['cn_name'];
            $product['offline_sku']=$data['offline_sku'];
            $product['offline_factory']=$data['offline_factory'];
            if($res['type'] =='insert')
            {   
                $product['price'] = $data['price'];
                $product['visibility'] = $data['visibility'];
                $product['filter_attributes']=$data['filter_attributes'];  
                $product['display_date'] = time();              
            }


            $data['set_id']=trim($data['set_id']);
            $data['set_label']=strtolower($data['set_id']);
            $data['set_label']=preg_replace('/[^a-zA-Z0-9]+/','_',$data['set_label']);

            $set = ORM::factory("set")
                ->where("label", "=", $data['set_label'])
                ->find();
            if ($set->loaded())
                $product['set_id'] = $set->id;
            else
            {
                unset($set);
                $set['name'] = $data['set_id'];
                $set["label"] = $data['set_label'];
                $new_set = ORM::factory("set")->values($set)->save();
                if ($new_set->loaded())
                    $product['set_id'] = $new_set->id;
                else
                {
                    $res['mes']="Fail: Can't get set id.";
                    return $res;
                }
            }

            $attributes = array();
            $attributes_value = explode("#", $data['attributes']);
            $attributes['Size'] = $attributes_value;
            
            $product['type'] = 3;
            $product['attributes'] = serialize($attributes);

            $item_value = explode("#", $data['item']);

            $product['updated'] = time();
            if($product['source'] == '采购')
            {
                $product['stock'] = -99;
            }else{
                $product['stock'] = -1;
            }

            $product['status'] = 1;
            

            $admin = DB::select('id')
            ->from('auth_user')
            ->where('email', '=', $data['admin'])
            ->execute('slave')
            ->current();
            if(empty($admin['id']))
            {
                $res['mes']="Fail: Can't get admin.";
                return $res;
            }
            $product['admin_id'] = $admin['id'];
            $product['offline_picker_id'] = $admin['id'];
            if($res['type'] =='insert')
            {  

                //insert,此处加判断
                if($p = ORM::factory("product")->values($product)->save())
                {
                    $res['id']=$p->id;
                    $res['flag']=1;
                }
                else
                {
                    $res['mes']='insert failed';
                }

            }
            if($res['type']=='update')
            {
                unset($product['status']);
                unset($product['visibility']);
                $update=DB::update('products_product')->set($product)->where('sku', '=', $product['sku'])->execute();
                $res['flag']=1;
                #return $res;

            }

            //filter
            $filters = explode(';',$data['filter_attributes']);
            $proid = $res['id']?$res['id']:Product::get_productId_by_sku($product['sku']);
            $check_filter = DB::select()->from('products_productfilter')
                ->where('product_id','=',$proid)
                ->execute('slave')
                ->as_array();

            if($check_filter and !empty($check_filter))
            {
                foreach ($check_filter as $value)
                {
                    DB::delete('products_productfilter')->where('id','=',$value['id'])->execute();
                }
            }
            foreach ($filters as $value)
            {
                $filter = DB::select()->from('products_filter')
                    ->where('options','=',$value)
                    ->execute('slave')->current();

                if($filter and !empty($filter) )
                {

                    DB::insert('products_productfilter',array('options','filter_id','product_id'))
                        ->values(array($filter['options'],$filter['id'],$proid))
                        ->execute();
                }

            }

            $proid = Product::get_productId_by_sku($product['sku']);

            foreach ($item_value as $key => $value) 
            {
                $itemattr = explode('!',$value);
                $sql = DB::select('id')
                        ->from('products_productitem')
                        ->where('product_id', '=', $proid)
                        ->and_where('attribute', '=', $itemattr[1])
                        ->execute('slave')
                        ->current();
                if($sql)
                {
                    $up = array(
                            'sku' =>$itemattr[0],
                            'status' =>1,
//                            'stock' => $itemattr[2],
                            'stock' => '9999',
                        );

                    DB::update('products_productitem')->set($up)->where('id', '=', $sql['id'])->execute();
                }
                else
                {

                    DB::insert('products_productitem', array('product_id', 'attribute', 'status','sku','stock'))
                        ->values(array($proid,$itemattr[1],1,$itemattr[0],'9999'))
                        ->execute();
                }
            }

            return $res;
            
            
        }
        catch (Exception $e)
        {
            $res['mes'] = " Fail: " . $e->getMessage();
            return $res;
        }

        
    }

    public static function download_image($img_url,$image_id)
    {
        //返回值
        $res=array();
        $res['flag']=0;
        $res['mes']='';

        $save_path='/home/choies/s3fs/uploads/pimages/'; //抓取图片的保存地址
        #$save_path='/home/choies/project/uploads/'; //抓取图片的保存地址

        $img_size_min=0;  //图片文件大小限制,此处为最小值,单位为字节
        $img_size_max=10000000;  //图片文件大小限制,此处为最小值,单位为字节

        //抓取图片
        $img_data = self::dfopen($img_url."?type=1&yes=ok");

        $img_save_need=0;   //保存文件条件

        //数据校验
        if ( strlen($img_data) > $img_size_min )   //文件大于最小限制
        {
            if ( strlen($img_data) > $img_size_min ) //文件小于最大限制
            {
                $img_save_need=1;   
            }
            else
            {
                $res['mes']='img save failed :size more then normal';
            }
        }
        else
        {
            $res['mes']='img save failed :size less then normal';        
        }

        //保存图片
        if($img_save_need==1)
        {
            $img_save = file_put_contents($save_path.$image_id.'.jpg', $img_data); 
            $res['flag']=1;
            

        }

        return $res;
        

    }

        //fsockopen读取
    public static function dfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) 
    {
        $return = '';
        $matches = parse_url($url);
        $host = $matches['host'];
        $path = $matches['path'] ? $matches['path'].(isset($matches['query']) && $matches['query'] ? '?'.$matches['query'] : '') : '/';
        $port = !empty($matches['port']) ? $matches['port'] : 80;

        if($post) {
            $out = "POST $path HTTP/1.0\r\n";
            $out .= "Accept: */*\r\n";
            //$out .= "Referer: $boardurl\r\n";
            $out .= "Accept-Language: zh-cn\r\n";
            $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
            $out .= "Host: $host\r\n";
            $out .= 'Content-Length: '.strlen($post)."\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Cache-Control: no-cache\r\n";
            $out .= "Cookie: $cookie\r\n\r\n";
            $out .= $post;
        } else {
            $out = "GET $path HTTP/1.0\r\n";
            $out .= "Accept: */*\r\n";
            //$out .= "Referer: $boardurl\r\n";
            $out .= "Accept-Language: zh-cn\r\n";
            $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Cookie: $cookie\r\n\r\n";
        }

        if(function_exists('fsockopen')) {
            $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
        } elseif (function_exists('pfsockopen')) {
            $fp = @pfsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
        } else {
            $fp = false;
        }

        if(!$fp) {
            return '';
        } else {
            stream_set_blocking($fp, $block);
            stream_set_timeout($fp, $timeout);
            @fwrite($fp, $out);
            $status = stream_get_meta_data($fp);
            if(!$status['timed_out']) {
                while (!feof($fp)) {
                    if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
                        break;
                    }
                }

                $stop = false;
                while(!feof($fp) && !$stop) {
                    $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                    $return .= $data;
                    if($limit) {
                        $limit -= strlen($data);
                        $stop = $limit <= 0;
                    }
                }
            }
            @fclose($fp);
            return $return;
        }
    }

    public static function checkSize($product)
    {
	    $size = explode('#',$product['attributes']);
	    $items = explode('#',$product['item']);
        $itemSize = array();
	    foreach ($items as $item)
        {
            $data = explode('!',$item);
            if(!in_array($data[1],$size))
            {
                return false;
            }

            if(in_array($data[1],$itemSize))
            {
                return false;
            }
            else
            {
                $itemSize[] = $data[1];
            }
        }
        return true;
    }
}