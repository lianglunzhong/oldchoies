<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Multichannel extends Controller_Webpage
{
	//multichannel增加api，获取站点的简单产品信息
	public function action_product()
	{
		$site_id = Arr::get($_REQUEST , "site_id" , 0);
		$max_product_id = Arr::get($_REQUEST , "max_product_id" , 0);	//已经导入后台的最大product_id
		$max_id = Arr::get($_REQUEST , "max_id" , 0);	//前台设置，每次区间的最大值
		$flat_encryption = Arr::get($_REQUEST , "flat_encryption" , 0);
		$key = md5($site_id."multichannelfromcola#!".$max_product_id);	//加密
		if( ! $site_id OR $flat_encryption != $key)
		{
			exit;
		}
		// $domain = Site::instance($site_id)->get('domain');	//站点域名，图片url用到
		$domain = URLSTR;	//站点域名，图片url用到
		
		//获取站点所有的分类
		$sql = "select * from catalogs where site_id=".$site_id;
		$categories = DB::query(Database::SELECT, $sql)->execute();
		$category_info = array();
		if($categories)
		{
			foreach($categories as $category)
			{
				$category_info[$category['id']]['category_id'] = $category['id'];
				$category_info[$category['id']]['parent'] = $category['parent_id'];
				$category_info[$category['id']]['category_name'] = $category['name'];
			}
		}
		
			$sql = 'SELECT p.id,p.name,p.sku,p.description,p.default_catalog,i.id as img_id,i.suffix FROM products p join images i on p.id=i.obj_id';
			$sql .= ' WHERE p.status=1 and p.default_catalog>0 and p.type=0 and p.site_id='.$site_id.' and p.id>='.$max_product_id." and p.id<".$max_id;
			$sql .= ' and i.site_id='.$site_id.' order by p.id asc';
			$products = DB::query(DATABASE::SELECT, $sql)->execute();
			$product_info = array();
			if($products)
			{
				foreach($products as $product)
				{
					$product_info[$product['sku']]['category_id'] = $product['default_catalog'];
					$product_info[$product['sku']]['product_id'] = $product['id'];
					$product_info[$product['sku']]['sku'] = $product['sku'];
					$product_info[$product['sku']]['product_name'] = str_replace("'" , "&#039;" , $product['name']);
					$product_info[$product['sku']]['description'] = str_replace("'" , "&#039;" , $product['description']);
					if(isset($product_info[$product['sku']]['images']))
					{
						$product_info[$product['sku']]['images'] .= Image::link(array('id'=>$product['img_id'],'suffix'=>$product['suffix']), 2).'||';
					}
					else 
					{
						$product_info[$product['sku']]['images'] = Image::link(array('id'=>$product['img_id'],'suffix'=>$product['suffix']), 2).'||';
					}
				}
			}
			
			$product_info_final = array();
			if(count($product_info) > 0)
			{
				foreach($product_info as $product_info_key => $product_info_value)
				{
					$product_info_final[$product_info_key] = $product_info_value;
					$category_id = $product_info_value['category_id'];
					$path_array = array();
					if($category_info[$category_id]['parent'] > 0)
					{
						do{
							$path_array[] = $category_info[$category_id]['category_name'];
							$category_id = $category_info[$category_id]['parent'];	//echo $product_info_value['product_id']."--".$category_id."--".$category_info[$category_id]['category_name']."--".$category_id."<hr>";
						}while($category_info[$category_id]['parent'] > 0);
					} else {
						$path_array[] = $category_info[$category_id]['category_name'];
					}
					$product_info_final[$product_info_value['sku']]['path'] = implode(' -> ' , array_reverse($path_array));
					$features = Product::instance($product_info_value['product_id'])->set_data();
					$feature_info = array();
					if(count($features) > 0)
					{	
						foreach($features as $feature)
						{
							if(($feature['type'] == 0 OR $feature['type'] == 1) AND $feature['selected_option_id'] != -1)
							{
								$feature_info['feature_name'][] = $feature['label'];
								$feature_info['feature_value'][] = $feature['options'][$feature['selected_option_id']]['label'];
							}
							if($feature['type'] == 2 OR $feature['type'] == 3)
							{
								$feature_info['feature_name'][] = $feature['label'];
								$feature_info['feature_value'][] = $feature['value'];
							}
						}	
					}
					$product_info_final[$product_info_value['sku']]['features'] = (count($feature_info) > 0) ? serialize($feature_info) : "";
				}
			}
			if(count($product_info_final) > 0)
			{
				$txt = "";
				foreach($product_info_final as $p_info)
				{
					$txt .= $p_info['sku']."&%|*#";
					$txt .= $p_info['product_name']."&%|*#";
					$txt .= $p_info['description']."&%|*#";
					$txt .= $p_info['images']."&%|*#";
					$txt .= $p_info['features']."&%|*#";
					$txt .= $p_info['path']."&%|*#";
					$txt .= $p_info['category_id']."&%|*#";
					$txt .= $p_info['product_id']."|=+|";
				}
				echo $txt;
			}
	}
//	public function action_product()
//	{
//		$site_id = Arr::get($_REQUEST , "site_id" , 0);
//		$max_product_id = Arr::get($_REQUEST , "max_product_id" , 0);	//已经导入后台的最大product_id
//		$max_id = Arr::get($_REQUEST , "max_id" , 0);	//前台设置，每次区间的最大值
//		$flat_encryption = Arr::get($_REQUEST , "flat_encryption" , 0);
//		$key = md5($site_id."multichannelfromcola#!".$max_product_id);	//加密
//		if( ! $site_id OR $flat_encryption != $key)
//		{
////			echo $site_id."--".$max_product_id."--".$flat_encryption."--".$key;
//			exit;
//		}
//		$domain = URLSTR;	//站点域名，图片url用到
//		
//		//获取站点所有的分类
//		$sql = "select * from catalogs where site_id=".$site_id;
//		$categories = DB::query(Database::SELECT, $sql)->execute();
//		$category_info = array();
//		if($categories)
//		{
//			foreach($categories as $category)
//			{
//				$category_info[$category['id']]['category_id'] = $category['id'];
//				$category_info[$category['id']]['parent'] = $category['parent_id'];
//				$category_info[$category['id']]['category_name'] = $category['name'];
//			}
//		}
//		
//		//获取站点最大和最小product_id
//		$sql = "select min(id) as min , max(id) as max from products where site_id=".$site_id;
//		$mm_product_id = DB::query(Database::SELECT, $sql)->execute()->current();
//		$min_productid = $mm_product_id['min'];
//		$max_productid = ($max_id <= $mm_product_id['max']) ? $max : $mm_product_id['max'];
//		
//		$flag = true;
//		$bj = 1000;
//		$from = ($max_product_id > 0) ? $max_product_id : $min_productid;
//		while ($flag){
//			$to = $from + $bj;
//			$sql = 'SELECT p.id,p.name,p.sku,p.description,p.default_catalog,i.id as img_id,i.suffix FROM products p join images i on p.id=i.obj_id';
//			$sql .= ' WHERE p.status=1 and p.default_catalog>0 and p.type=0 and p.site_id='.$site_id.' and p.id>'.$from." and p.id<=".$to;
//			$sql .= ' and i.site_id='.$site_id.' order by p.id asc';
//			$products = DB::query(DATABASE::SELECT, $sql)->execute();
//			$product_info = array();
//			if($products)
//			{
//				foreach($products as $product)
//				{
//					$product_info[$product['sku']]['category_id'] = $product['default_catalog'];
//					$product_info[$product['sku']]['product_id'] = $product['id'];
//					$product_info[$product['sku']]['sku'] = $product['sku'];
//					$product_info[$product['sku']]['product_name'] = str_replace("'" , "&#039;" , $product['name']);
//					$product_info[$product['sku']]['description'] = str_replace("'" , "&#039;" , $product['description']);
//					if(isset($product_info[$product['sku']]['images']))
//					{
//						$product_info[$product['sku']]['images'] .= Image::link(array('id'=>$product['img_id'],'suffix'=>$product['suffix']), 2).'||';
//					}
//					else 
//					{
//						$product_info[$product['sku']]['images'] = Image::link(array('id'=>$product['img_id'],'suffix'=>$product['suffix']), 2).'||';
//					}
//				}
//			}
//			
//			$product_info_final = array();
//			if(count($product_info) > 0)
//			{
//				foreach($product_info as $product_info_key => $product_info_value)
//				{
//					$product_info_final[$product_info_key] = $product_info_value;
//					$category_id = $product_info_value['category_id'];
//					$path_array = array();
//					if($category_info[$category_id]['parent'] > 0)
//					{
//						do{
//							$path_array[] = $category_info[$category_id]['category_name'];
//							$category_id = $category_info[$category_id]['parent'];	//echo $product_info_value['product_id']."--".$category_id."--".$category_info[$category_id]['category_name']."--".$category_id."<hr>";
//						}while($category_info[$category_id]['parent'] > 0);
//					} else {
//						$path_array[] = $category_info[$category_id]['category_name'];
//					}
//					$product_info_final[$product_info_value['sku']]['path'] = implode(' -> ' , array_reverse($path_array));
//					$features = Product::instance($product_info_value['product_id'])->set_data();
//					$feature_info = array();
//					if(count($features) > 0)
//					{	
//						foreach($features as $feature)
//						{
//							if(($feature['type'] == 0 OR $feature['type'] == 1) AND $feature['selected_option_id'] != -1)
//							{
//								$feature_info['feature_name'][] = $feature['label'];
//								$feature_info['feature_value'][] = $feature['options'][$feature['selected_option_id']]['label'];
//							}
//							if($feature['type'] == 2 OR $feature['type'] == 3)
//							{
//								$feature_info['feature_name'][] = $feature['label'];
//								$feature_info['feature_value'][] = $feature['value'];
//							}
//						}	
//					}
//					$product_info_final[$product_info_value['sku']]['features'] = (count($feature_info) > 0) ? serialize($feature_info) : "";
//				}
//			}
//			if(count($product_info_final) > 0)
//			{
//				$txt = "";
//				foreach($product_info_final as $p_info)
//				{
//					$txt .= $p_info['sku']."&%|*#";
//					$txt .= $p_info['product_name']."&%|*#";
//					$txt .= $p_info['description']."&%|*#";
//					$txt .= $p_info['images']."&%|*#";
//					$txt .= $p_info['features']."&%|*#";
//					$txt .= $p_info['path']."&%|*#";
//					$txt .= $p_info['category_id']."&%|*#";
//					$txt .= $p_info['product_id']."|=+|";
//				}
//				echo $txt;
//			}
//			if ($to > $max_productid) $flag = false;
//			else $from = $to;
//		}
//	}
	
	//获取cola所有站点的id和域名
	public function action_sites()
	{
		$flat_encryption = Arr::get($_REQUEST , "flat_encryption" , 0);
		$key = md5("multichannelsitesfromcola#!");	//加密
		if($flat_encryption != $key)
		{
			exit;
		}
		$sites = DB::query(Database::SELECT, "select id,domain from sites where is_active='1' order by id")->execute();
		$site_array = array();
		foreach($sites as $site)
		{
			$site_array[$site['id']] = $site['domain'];
		}
		echo json_encode($site_array);
	}
	
	//获取站点的最大的product_id
	public function action_product_ids()
	{
		$site_id = Arr::get($_REQUEST , "site_id" , 0);
		$flat_encryption = Arr::get($_REQUEST , "flat_encryption" , 0);
		$key = md5($site_id."multichannelproductidsfromcola#!");	//加密
		if($flat_encryption != $key)
		{
			exit;
		}
		//获取站点最大和最小product_id
		$sql = "select min(id) as min , max(id) as max from products where site_id=".$site_id;
		$mm_product_id = DB::query(Database::SELECT, $sql)->execute()->current();
		$res = array( "product_id_min" => $mm_product_id['min'] , "product_id_max" => $mm_product_id['max']);
		echo json_encode($res);
	}
	
	public function action_test()
	{
		$sql = 'SELECT count(*) as total FROM products p';
		$sql .= ' WHERE p.status=1 and p.default_catalog>0 and p.type=0 and p.site_id=1';
		$res = DB::query(Database::SELECT, $sql)->execute()->current();
		echo $res['total'];
	}
}
