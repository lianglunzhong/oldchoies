<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Catalog extends Controller_Admin_Site
{

    public function action_list()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        // $name_template = '<a href="/admin/site/catalog/edit/{id}" title="点击修改">{name}</a> <a href="/admin/site/catalog/delete/{id}" class="delete_catalog" title="点击删除">X</a>';
        $name_template = '<a href="/admin/site/catalog/edit/{id}" title="点击修改">{name}</a> <a>&nbsp;</a>';
        $conditional_name_template = '<a href="/admin/site/catalog/edit/{id}" title="点击修改">[ {name} ]</a> <a href="/admin/site/catalog/delete/{id}" class="delete_catalog" title="点击删除">X</a>';
        $content_data['catalog_tree'] = self::get_left_tree($this->site_id, $name_template, $conditional_name_template, $lang);
        //		$content = View::factory('admin/site/catalog_list', $content_data)->render();
        //默认让它显示添加分类的界面吧：
        $content_data['product_ids'] = array();
        $content_data['is_conditional'] = FALSE;
        $catalog_opt_template = array(
            'name_box' => '
            <option value="{id}">{indentation}{name}</option>
            ',
            'indentation' => '&nbsp;|&nbsp;&nbsp;'
        );

        $content_data['searchable_attributes'] = ORM::factory('attribute')
            ->where('site_id', '=', $this->site_id)
            ->and_where('scope', '!=', 2)
            ->and_where('searchable', '=', 1)
            ->and_where('type', 'in', DB::expr("('0','1')"))
            ->find_all();
        $content_data['catalog_opt'] = self::tree_to_str(self::get_tree($this->site_id, $catalog_opt_template));
        $content = View::factory('admin/site/catalog_add', $content_data)->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_add()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        $content_data['is_conditional'] = $this->request->param('id') == 'conditional' ? true : false;
        if ($_POST)
        {
            $data = $_POST;
            $data['site_id'] = $this->site_id;
            $data['conditional'] = $content_data['is_conditional'];
            $catalog_id = Catalog::instance(0)->set_basic($data);

            if (!is_string($catalog_id))
            {
                foreach ($languages as $l)
                {
                    if ($l === 'en')
                        continue;
                    DB::query(Database::INSERT, 'INSERT INTO catalogs_' . $l . ' SELECT * FROM catalogs WHERE id = ' . $catalog_id)->execute();
                }
                message::set('添加商品分类成功。');
                Request::instance()->redirect('/admin/site/catalog/edit/' . $catalog_id);
            }
            else
            {
                message::set($catalog_id, 'error');
                Request::instance()->redirect('/admin/site/catalog/add' . ($content_data['is_conditional'] ? '/conditional' : ''));
            }
        }

        $catalog_opt_template = array(
            'name_box' => '
            <option value="{id}">{indentation}{name}</option>
            ',
            'indentation' => '&nbsp;|&nbsp;&nbsp;'
        );
        $content_data['catalog_opt'] = self::tree_to_str(self::get_tree($this->site_id, $catalog_opt_template));

        // $name_template = '<a href="/admin/site/catalog/edit/{id}" title="点击修改">{name}</a> <a href="/admin/site/catalog/delete/{id}" class="delete_catalog" title="点击删除">X</a>';
        $name_template = '<a href="/admin/site/catalog/edit/{id}" title="点击修改">{name}</a> <a>&nbsp;</a>';
        $conditional_name_template = '<a href="/admin/site/catalog/edit/{id}" title="点击修改">[ {name} ]</a> <a href="/admin/site/catalog/delete/{id}" class="delete_catalog" title="点击删除">X</a>';
        $content_data['catalog_tree'] = self::get_left_tree($this->site_id, $name_template, $conditional_name_template, $lang);

        if ($content_data['is_conditional'])
        {
            $content_data['sets'] = ORM::factory('set')
                ->where('site_id', '=', $this->site_id)
                ->find_all();
            $content_data['attributes'] = ORM::factory('attribute')
                ->where('site_id', '=', $this->site_id)
                ->and_where('scope', '!=', 2)
                ->and_where('type', 'in', DB::expr("('0','1','2')"))
                ->find_all();
        }
        else
        {
            $content_data['product_ids'] = array();
        }

        $content_data['searchable_attributes'] = ORM::factory('attribute')
            ->where('site_id', '=', $this->site_id)
            ->and_where('scope', '!=', 2)
            ->and_where('searchable', '=', 1)
            ->and_where('type', 'in', DB::expr("('0','1')"))
            ->find_all();

        $content = View::factory('admin/site/catalog_add', $content_data)->render();

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
        $lang_table = $lang ? '_' . $lang : '';
        $id = $this->request->param('id');
        $catalog = ORM::factory('catalog' . $lang)
            ->where('site_id', '=', $this->site_id)
            ->where('id', '=', $id)
            ->find();
        if (!$catalog->loaded())
        {
            message::set('catalog_does_not_exist', 'notice');
            Request::instance()->redirect('admin/site/catalog/list');
        }

        if ($_POST)
        {
            $post_lang = Arr::get($_POST, 'lang', '');
            if ($post_lang)
            {
                $data = array(
                    'name' => Arr::get($_POST, 'catalog_name', ''),
                    'image_src' => Arr::get($_POST, 'image_src', ''),
                    'pimage_src' => Arr::get($_POST, 'pimage_src', ''),
                    'image_link' => Arr::get($_POST, 'image_link', ''),
                    'image_alt' => Arr::get($_POST, 'image_alt', ''),
                    'image_map' => Arr::get($_POST, 'image_map', ''),
                    'pimage_map' => Arr::get($_POST, 'pimage_map', ''),
                    'link' => Arr::get($_POST, 'link', ''),
                    'visibility' => Arr::get($_POST, 'catalog_visibility', ''),
                    'meta_title' => htmlspecialchars(Arr::get($_POST, 'meta_title', '')),
                    'meta_keywords' => htmlspecialchars(Arr::get($_POST, 'meta_keywords', '')),
                    'meta_description' => htmlspecialchars(Arr::get($_POST, 'meta_description', '')),
                    'description' => htmlspecialchars(Arr::get($_POST, 'description', '')),
                );

                $hot_catalog = Arr::get($_POST, 'hot_catalog', '');
                $hotarr = explode("\n",$hot_catalog);
                $data['hot_catalog'] = serialize($hotarr);

                if($_FILES['file_phone']['error'] == 0){
                $a =  self::save($_FILES['file_phone']);
                $data['pimage_src'] = $a['filename'];
                }
                $images = Arr::get($_POST, 'image_bak', '');
                $images = $images ? explode(',', $images) : array();
                $removed_images = array();
                $dir = kohana::debug('upload.resource_dir') . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
                foreach ($images as $file_name)
                {
                    if ($file_name AND $file_name != $data['image_src'])
                    {
                        $removed_images[] = $file_name;
                        if (file_exists($dir . $file_name))
                        {
                            unlink($dir . $file_name);
                        }
                    }
                }
                if ($removed_images)
                {
                    DB::delete('site_images')->where('filename', 'in', $removed_images)->execute();
                }
                $update = DB::update('catalogs_' . $post_lang)->set($data)->where('id', '=', $id)->execute();
                if($update)
                    $catalog_id = 1;
                else
                    $catalog_id = 'False';
            }
            else
            {
                $data = $_POST;
                $data['site_id'] = $this->site_id;
                $data['conditional'] = $catalog->is_filter != 0 ? TRUE : FALSE;


                $hot_catalog = Arr::get($_POST, 'hot_catalog', '');
                $hotarr = explode("\n",$hot_catalog);
                $data['hot_catalog'] = serialize($hotarr);
                
                if($_FILES['file_phone']['error'] == 0){
                $a =  self::save($_FILES['file_phone']);
                $data['pimage_src'] = $a['filename'];
                }
                $catalog_id = Catalog::instance($id, $lang)->set_basic($data, $id);
            }

            if (!is_string($catalog_id))
            {
                if(!$lang)
                {
                    $data1['link'] = strtolower(preg_replace('/&|\#|\?|\%| |\//', '-', Arr::get($_POST, 'link', '')));
                    $data1['parent_id'] = Arr::get($_POST, 'parent_id', 0);

                    $data1['orderby'] = Arr::get($_POST, 'orderby', 'hits');
                    $data1['desc'] = Arr::get($_POST, 'desc', 'desc') != 'desc' ? 'asc' : 'desc';
                    $orderby_keys = array('hits', 'price', 'name', 'created');
                    $data1['orderby'] = in_array($data1['orderby'], $orderby_keys) ? $data1['orderby'] : 'hits';

                    $data1['visibility'] = Arr::get($_POST, 'catalog_visibility', 1);
                    $data1['stereotyped'] = Arr::get($_POST, 'stereotyped_m', 0);
                    $data1['on_menu'] = Arr::get($_POST, 'on_menu', 1);
                    $data1['searchable_attributes'] = implode(',', Arr::get($_POST, 'searchable_attributes', array()));

                    $data1['recommended_products'] = Arr::get($_POST, 'recommended_products', '');

                    $price_ranges = explode(',', Arr::get($_POST, 'price_ranges', ''));
                    sort($price_ranges);
                    foreach ($price_ranges as $k => $v)
                    {
                        if (floatval($v) <= 0)
                        {
                            unset($price_ranges[$k]);
                        }
                        else
                        {
                            $price_ranges[$k] = floatval($v);
                        }
                    }
                    $data1['price_ranges'] = implode(',', $price_ranges);
                    $data1['is_brand'] = Arr::get($_POST, 'is_brand', 0);
                    $data1['position'] = Arr::get($_POST, 'position', 0);
                    foreach ($languages as $l)
                    {
                        if ($l === 'en')
                            continue;
                        DB::update('catalogs_' . $l)->set($data1)->where('id', '=', $catalog_id)->execute();
                    }
                }
                message::set('修改商品分类成功。');
                Request::instance()->redirect('/admin/site/catalog/edit/' . $id . '?lang=' . $lang);
            }
            else
            {
                message::set($catalog_id, 'error');
                Request::instance()->redirect('/admin/site/catalog/edit/' . $id . '?lang=' . $lang);
            }
        }
        //判断是三级分类才出现选择是否显示套话
        $has_child = DB::select()->from('products_category')->where('parent_id', '=', $id)->execute('slave')->count();
        $content_data['show_stereotyped'] = FALSE;
        if ($this->site_id == 1 && $has_child == 0)
        {
            $content_data['show_stereotyped'] = TRUE;
        }

        $catalog_opt_template = array(
            'name_box' => '
            <option value="{id}">{indentation}{name}</option>
            ',
            'indentation' => '&nbsp;|&nbsp;&nbsp;'
        );
        $catalog_opt_array = self::get_tree($this->site_id, $catalog_opt_template, 0, 0, $lang);

        //TODO 排除所有条件分类
        //在分类树中删除当前分类的节点
        //以避免当前分类被修改为从属于自己或自己的后代(...乱了辈份可不好)
        $parents = self::get_parents($id);
        $node = &$catalog_opt_array;
        foreach ($parents as $node_id)
        {
            if ($node_id != $id)
            {
                $node = &$node[$node_id]['children'];
            }
        }
        unset($node[$id]);

        $content_data['catalog_opt'] = self::tree_to_str($catalog_opt_array);

        // $name_template = '<a href="/admin/site/catalog/edit/{id}" title="点击修改">{name}</a> <a href="/admin/site/catalog/delete/{id}" class="delete_catalog" title="点击删除">X</a>';
        $name_template = '<a href="/admin/site/catalog/edit/{id}" title="点击修改">{name}</a> <a>&nbsp;</a>';
        $conditional_name_template = '<a href="/admin/site/catalog/edit/{id}" title="点击修改">[ {name} ]</a> <a href="/admin/site/catalog/delete/{id}" class="delete_catalog" title="点击删除">X</a>';
        $content_data['catalog_tree'] = self::get_left_tree($this->site_id, $name_template, $conditional_name_template, $lang);

        $content_data['product_ids'] = array();
        if (!$catalog->is_filter AND !$lang)
        {
            $products = $catalog->products->find_all();
            foreach ($products as $product)
            {
                $content_data['product_ids'][] = $product->id;
            }
        }
        else
        {
            $content_data['sets'] = ORM::factory('set')
                ->where('site_id', '=', $this->site_id)
                ->find_all();
            $content_data['attributes'] = ORM::factory('attribute')
                ->where('site_id', '=', $this->site_id)
                ->and_where('scope', '!=', 2)
                ->and_where('type', 'in', DB::expr("('0','1','2')"))
                ->find_all();
            $content_data['filter'] = ORM::factory('filter', $catalog->is_filter);
        }

        $content_data['searchable_attributes'] = ORM::factory('attribute')
            ->where('site_id', '=', $this->site_id)
            ->and_where('scope', '!=', 2)
            ->and_where('searchable', '=', 1)
            ->and_where('type', 'in', DB::expr("('0','1')"))
            ->find_all();

        $content_data['catalog'] = $catalog;

        $content = View::factory('admin/site/catalog_edit', $content_data)->render();

        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public static function save()
    {
        if(isset($_FILES['file_phone']))
        {
            $user_id = Session::instance()->get('user_id');
            $site_id = Site::instance()->get('id');
            if($user_id AND $file_name = Image::upload1($site_id,NULL,NULL,TRUE))
            {
                $simage = ORM::factory('simage');
                $simage->site_id = $site_id;
                $simage->time = time();
                $simage->uploader = $user_id;
                $simage->filename = $file_name;
                $simage->save();
                return array('id'=>$simage->id,'filename'=>$file_name);
            }
        }
        return FALSE;
    }

   public  function action_products_zero12()
    {
        if ($_POST)
        {
            $Catanames = Arr::get($_POST, 'SKUARR4', '');
            $Cataid = Arr::get($_POST, 'catalog_id', '');
            $Cata = explode("\n", $Catanames);

            foreach($Cata as $k=>$v){
                $arr[$k] =explode(',',$v);

            }


        foreach($arr as $v){
            $proid = Product::get_productId_by_sku($v[0]);
            $po = 10000 - $v[1];
    $ret = DB::update('catalog_products')->set(array('position' => $po))
                                ->where('product_id','=',$proid)
                                ->where('catalog_id','=',$Cataid)
                                ->execute();
/*            $ret2 = DB::update('products')->set(array('position' => $po))
                                ->where('id','=',$proid)
                                ->execute();*/
        }
            if($ret){
                     message::set('批量操作成功');
                $this->request->redirect('/admin/site/catalog/edit/'.$Cataid);              
            }
                 
        }
        else
        {
         $this->request->redirect('/admin/site/catalog/list');   
        }
    }

   public  function action_products_zero13()
    {
        if ($_POST)
        {
            $Catanames = Arr::get($_POST, 'SKUARR5', '');
            $Cataid = Arr::get($_POST, 'catalog_id', '');
            $Cata = explode("\n", $Catanames);

            foreach($Cata as $k=>$v){
                $arr[$k] =explode(',',$v);

            }


        foreach($arr as $v){
            $proid = Product::get_productId_by_sku($v[0]);
            $po = 10000 - $v[1];
    $ret = DB::update('catalog_products')->set(array('positiontwo' => $po))
                                ->where('product_id','=',$proid)
                                ->where('catalog_id','=',$Cataid)
                                ->execute();

        }
            if($ret){
                     message::set('批量操作成功');
                $this->request->redirect('/admin/site/catalog/edit/'.$Cataid);              
            }
                 
        }
        else
        {
         $this->request->redirect('/admin/site/catalog/list');   
        }
    }
	
	
	
	//删除图片
	public function action_deleteimgmap()
	{
		if ($_GET)
        {
			$catalog_id = Arr::get($_GET, 'catalog_id', '');
			$lang = Arr::get($_GET, 'lang','en');
			if($lang=="de?lang=de"){
				$lang="de";
			}elseif($lang=="fr?lang=fr"){
				$lang="fr";
			}elseif($lang=="es?lang=es"){
				$lang="es";
			}else{
				$lang="en";
			}
			if($catalog_id){
				$data1=array();
				$data1['pimage_src']="";
				if($lang=="en"){
					$result=DB::update('catalogs')->set($data1)->where('id', '=', $catalog_id)->execute();
				}else{
					$result = DB::update('catalogs_' . $lang)->set($data1)->where('id', '=', $catalog_id)->execute();
				}
				if($result){
					message::set('删除成功!');
					 $this->request->redirect('/admin/site/catalog/edit/'.$catalog_id.'');   
				}else{
					$result=DB::update('catalogs')->set("")->where('id', '=', $catalog_id)->execute();
					message::set('删除失败!可能没有图片');
					 $this->request->redirect('/admin/site/catalog/edit/'.$catalog_id.'');  
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
            $this->request->redirect('/admin/site/catalog/list');
        }
        $id = $this->request->param('id');
        $children = DB::select('id')->from('products_category')->where('parent_id', '=', $id)->execute('slave')->as_array();
        if (count($children))
        {
            Message::set('Can not delete a catalog which has subcatalogs!', 'error');
            Request::instance()->redirect('admin/site/catalog/list');
        }

        $catalog = ORM::factory('catalog', $id);

        if ($catalog->loaded())
        {
            if (!$catalog->is_filter)
            {
                Db::delete('catalog_products')->where('catalog_id', '=', $id)->execute();
            }
            else
            {
                Db::delete('filters')->where('id', '=', $catalog->is_filter)->execute();
            }

            $catalog->delete($id);
            foreach ($languages as $l)
            {
                if ($l == 'en')
                    continue;
                DB::delete('catalogs_' . $l)->where('id', '=', $id)->execute();
            }
            message::set('The catalog has been deleted.');
        }
        Request::instance()->redirect('admin/site/catalog/list');
    }

    /**
     * TODO 方法已更改。需重新写这个注释
     * 此方法可返回（不限深度的）树状结构的“商品分类”数组。
     * @param int $site_id 站点id（因为是静态方法，所以不宜从$this->site_id读取）
     * @param array $template 商品分类的HTML代码模板。参数结构为：
     * 						array(
     * 							'name'=>'包含{name}标签的HTML代码段',			//这是“分类名称”自身的显示模板，例如:'【{name}】'
     * 							'prefix'=>'一段代码',		//是name的前缀，根据树枝的深度循环复制自身，用以达到缩进的树状显示效果，比如：'&nbsp;'
     * 							'whole'=>'包含{name}和{id}标签的HTML代码段'	//每个树枝公用的HTML代码模板，比如:'<option id="{id}">{name}</option>'
     * 						)
     * @param int $parent 父分类id，一般不需要提供此参数，默认为0（即取得0的后代树）
     * @param int $depth 请不要提供此参数，它只通过方法内部递归赋值
     * @return array 当提供了参数$template时，返回已“HTML化”的分类数组。否则，返回标准的“分类id=>分类名称”数组。
     */
    public static function get_tree($site_id, $template = array(), $parent = 0, $depth = 0, $lang = '', $on_menu = 0)
    {
        $lang_table = $lang ? '_' . $lang : '';
        $catalogs = array();
        
        if($on_menu){
        $children = DB::select(DB::expr('id,name,is_filter,parent_id,on_menu'))
            ->from('catalogs' . $lang_table)
            ->where('site_id', '=', $site_id)
            ->where('on_menu', '=', 1)
            ->and_where('parent_id', '=', $parent)
            ->execute('slave');
        }else{
     $children = DB::select(DB::expr('id,name,is_filter,parent_id,on_menu'))
            ->from('catalogs' . $lang_table)
            ->where('site_id', '=', $site_id)
            ->and_where('parent_id', '=', $parent)
            ->execute('slave');
        }
        
        if (isset($template['indentation']))
        {
            $indentation = str_repeat($template['indentation'], $depth);
        }
        $depth++;

        $children_keys = array();
        foreach ($children as $key => $child)
        {
            if ($child['is_filter'] != 0 AND (!isset($template['no_conditional']) OR $template['no_conditional'] == TRUE))
            {
                continue;
            }
            $children_keys[] = $key;
        }

        if (isset($template['last_name_box']))
        {
            $children_count = count($children_keys);
            $i = 0;
        }
        foreach ($children_keys as $key => $child_key)
        {
            $child = $children[$child_key];
            $conditional = $child['is_filter'] == 0 ? FALSE : TRUE;
            if (isset($template['name']) AND $depth > 0)
            {
                $name_str = $template['name'];
                if ($conditional AND isset($template['conditional_name']))
                {
                    $name_str = $template['conditional_name'];
                }
                $replace_name = str_replace('{name}', $child['name'], $name_str);
            }
            else
            {
                $replace_name = $child['name'];
            }

            if (isset($template['last_name_box']) AND $i == $children_count - 1)
            {
                $last_name_box = $template['last_name_box'];
                if ($conditional AND isset($template['last_conditional_name_box']))
                {
                    $last_name_box = $template['last_conditional_name_box'];
                }
                $replace_name = str_replace('{name}', $replace_name, $last_name_box);
                $replace_name = str_replace('{id}', $child['id'], $replace_name);
            }
            elseif (isset($template['name_box']))
            {
                $name_box = $template['name_box'];
                if ($conditional AND isset($template['conditional_name_box']))
                {
                    $name_box = $template['conditional_name_box'];
                }
                $replace_name = str_replace('{name}', $replace_name, $name_box);
                $replace_name = str_replace('{id}', $child['id'], $replace_name);
            }
            if (isset($template['indentation']))
            {
                $replace_name = str_replace('{indentation}', $indentation, $replace_name);
            }
            if (isset($template['last_name_box']))
                $i++;
            
            $_children = self::get_tree($site_id, $template, $child['id'], $depth, $lang, $on_menu);
            if($on_menu AND !$child['on_menu'])
            {
                $replace_name = str_replace('<li', '<li style="display:none;"', $replace_name);
                foreach($_children AS $cid => $c)
                {
                    $_children[$cid]['name'] = str_replace('<li', '<li style="display:none;"', $c['name']);
                }
            }

            if($child['on_menu'] AND !$on_menu)
            {
                $replace_name = str_replace('<li', '<li style="background:red;"', $replace_name);
            }
                
            $catalogs[$child['id']]['name'] = $replace_name;
            $catalogs[$child['id']]['children'] = $_children;
        }
        return $catalogs;
    }

    /**
     * TODO 方法已更改。需重新写这个注释
     * 此方法将“商品分类”的树状数组各节点的'name'值连接到一起，成为一个字符串
     * @param array $tree “商品分类”的树状数组
     * @param string $str 请不要提供此参数，它只通过方法内部递归赋值
     * @return string  返回所有商品分类集合而成的字符串
     */
    public static function tree_to_str($tree, $template = array(), $str = '', $is_last = true, $depth = 0)
    {
        $depth++;
        $count = count($tree);
        if (!$is_last AND $count AND $depth > 1 AND isset($template['parent_box_open']))
        {
            $str .= $template['parent_box_open'];
        }
        elseif ($is_last AND $count AND $depth > 1 AND isset($template['parent_box_last_open']))
        {
            $str .= $template['parent_box_last_open'];
        }
        $i = 0;
        $is_last = false;
        //guo 9.14
        if(isset($tree)){
        foreach ($tree as $id => $branch)
        {
            if ($i == $count - 1)
            {
                $is_last = true;
            }
            $str = self::tree_to_str($branch['children'], $template, $str . $branch['name'], $is_last, $depth);
            $i++;
        }
    }
        if ($count AND $depth > 1 AND isset($template['parent_box_close']))
        {
            $str .= $template['parent_box_close'];
        }
        return $str;
    }

    /**
     * 返回所给分类的所有祖先分类的id
     * @param int $child_id 分类ID
     * @return array 返回$child_id分类的所有祖先分类的id（不包括家族最顶端的'0'），数组内数据排列方向为：长辈->晚辈
     */
    public static function get_parents($child_id)
    {
        $parents[] = $child_id;
        $parent_id = $child_id;
        while ($parent_id != 0)
        {
            $catalog_parent = DB::select('parent_id')
                ->from('products_category')
                ->where('id', '=', $parent_id)
                ->execute('slave');
            $parent_id = $catalog_parent[0]['parent_id'];
            if ($parent_id != 0)
            {
                $parents[] = $parent_id;
            }
        }
        return array_reverse($parents);
    }

    public static function get_left_tree($site_id, $name_str, $conditional_name_str = null, $lang = '', $on_menu = 0)
    {
        $catalog_tree_template = array(
            'name_box' => '<li class="catalog_tree_name">' . $name_str . '</li>',
            'last_name_box' => '<li class="catalog_tree_name catalog_tree_last_name">' . $name_str . '</li>',
            'no_conditional' => TRUE
        );
        if ($conditional_name_str !== null)
        {
            $catalog_tree_template['no_conditional'] = FALSE;
            $catalog_tree_template['conditional_name_box'] = '<li class="catalog_tree_name catelog_tree_conditional_name">' . $conditional_name_str . '</li>';
            $catalog_tree_template['last_conditional_name_box'] = '<li class="catalog_tree_name catalog_tree_last_name catelog_tree_conditional_name">' . $conditional_name_str . '</li>';
        }
        $catalog_str_template = array(
            'parent_box_open' => '<li class="catalog_tree_children"><ol>',
            'parent_box_last_open' => '<li class="catalog_tree_children catalog_tree_last_children"><ol>',
            'parent_box_close' => '</ol></li>'
        );
        return '<ul id="catalog_tree">' . self::tree_to_str(self::get_tree($site_id, $catalog_tree_template, 0, 0, $lang, $on_menu), $catalog_str_template) . '</ul>';
    }

    public function action_ajax_products()
    {

        $in_catalog = false;

        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            //魔术引号
            if (function_exists('get_magic_quotes_gpc') AND get_magic_quotes_gpc())
            {
                $filters = stripslashes($filters);
            }
            $filters = json_decode($filters);
        }

        $filter_sql = "";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if ($item->field == 'id' AND !isset($_REQUEST['id_for_search']))
                {
                    $in_catalog = $item->data;
                }
                elseif (in_array($item->field, array('name', 'sku')))
                {
                    $filter_sql .= " AND " . $item->field . " LIKE '%" . $item->data . "%'";
                }
                else
                {
                    //TODO add filter items
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
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
                $products = DB::select('product_id')
                    ->from('catalog_products')
                    ->where('catalog_id', '=', $catalog_id)
                    ->order_by('position', 'ASC')
                    ->execute('slave');
                $product_ids = array();
                foreach ($products as $product)
                {
                    $product_ids[] = "'" . $product['product_id'] . "'";
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

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        if ($no_records)
        {
            $count = 0;
        }
        else
        {
            $result = DB::query(Database::SELECT, 'SELECT count(id) FROM products WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
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
            if ($in_catalog == 1)
            {
                $result = DB::query(Database::SELECT, "SELECT p.* FROM products p JOIN catalog_products rel ON p.id = rel.product_id WHERE p.site_id = " . $this->site_id . " AND rel.catalog_id = $catalog_id ORDER BY rel.position LIMIT $limit OFFSET $start")->execute('slave');
            }
            else
            {
                $result = DB::query(DATABASE::SELECT, 'SELECT * FROM products WHERE site_id=' . $this->site_id . ' ' .
                        $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');
            }
        }

        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $i = 0;
        $responce['userdata']['sets'] = array();
        foreach ($result as $product)
        {
            $set = ORM::factory('set', $product['set_id']);
            $responce['userdata']['sets'][$product['set_id']] = $set->name ? $set->name : '无';
            $responce['rows'][$i]['id'] = $product['id'];
            $responce['rows'][$i]['cell'] = array(
                $product['id'],
                $product['name'],
                $product['type'],
                $product['set_id'],
                $product['sku'],
                $product['price'],
                $product['stock'],
                $product['visibility'],
                $product['status'],
            );
            $i++;
        }
        echo json_encode($responce);
    }

    public function action_export()
    {
        $catalogs = $this->request->param('id');
        $subcatalog = Arr::get($_GET, 'sub', 0);
        $cids = array();
        if ($catalogs == 'roots')
        {
            $cids = DB::select('id')->from('products_category')
                    ->where('site_id', '=', $this->site_id)
                    ->and_where('parent_id', '=', 0)
                    ->and_where('is_filter', '=', '0') // real catalog
                    ->execute('slave')->as_array('id', 'id');
        }
        elseif ($subcatalog)
        {
            $pids = explode('-', $catalogs);
            foreach ($pids as $pid)
            {
                $tmp = DB::select('id')->from('products_category')
                        ->where('site_id', '=', $this->site_id)
                        ->and_where('parent_id', '=', $pid)
                        ->and_where('is_filter', '=', '0') // real catalog
                        ->execute('slave')->as_array('id', 'id');
                if ($tmp)
                {
                    $cids = array_merge($cids, $tmp);
                }
            }
        }
        else
        {
            $cids = explode('-', $catalogs);
        }


        $filename = $catalogs . '.csv';

        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        $fp = fopen('php://output', 'w');
        fputcsv($fp, array('catalog', 'id', 'sku', 'name', 'link', 'price', 'cost', 'market price', 'weight', 'description', 'set'));
        foreach ($cids as $cid)
        {
            $cname = htmlspecialchars_decode(Catalog::instance($cid)->get('name'));

            if (!empty($cname))
            {
                $posterity_ids = Catalog::instance($cid)->posterity(FALSE, FALSE);
                $posterity_ids[] = $cid;
                $posterity_sql = implode("','", $posterity_ids);

                $result = DB::query(Database::SELECT, 'SELECT distinct p.id,p.sku,p.name,p.link,p.price,p.cost,p.market_price,p.weight,p.description,p.set_id FROM products p 
                    LEFT JOIN catalog_products ON catalog_products.product_id=p.id ' .
                            "WHERE catalog_products.catalog_id IN ('" . $posterity_sql . "')
                    AND p.site_id =" . $this->site_id)
                        ->execute('slave')->as_array();
                foreach ($result as $key => $product)
                {
                    $product['name'] = htmlspecialchars_decode($product['name']);
                    $product['set_id'] = Set::instance($product['set_id'])->get('brief');
                    fputcsv($fp, array_merge(array($cname), $product));
                }
            }
        }
    }

    function action_products_relate()
    {
        if ($_POST)
        {
            $catalog_id = Arr::get($_POST, 'catalog_id', 0);
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
                Catalog::instance($catalog_id)->set_products($catalog_id, $products);
            }
            message::set('关联分类产品成功！');
            $this->request->redirect('/admin/site/catalog/edit/' . $catalog_id);
        }
        else
        {
            $this->request->redirect('/admin/site/catalog/list');
        }
    }

    function action_products_add()
    {
        if ($_POST)
        {
            $catalog_id = Arr::get($_POST, 'catalog_id', 0);
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
                Catalog::instance($catalog_id)->add_products($catalog_id, $products);
            }
            message::set('添加分类产品成功！');
            $this->request->redirect('/admin/site/catalog/edit/' . $catalog_id);
        }
        else
        {
            $this->request->redirect('/admin/site/catalog/list');
        }
    }

    function action_cata_basic()
    {
        if ($_POST)
        {
            $Catanames = Arr::get($_POST, 'SKUARR', '');
            $Cata = explode("\n", $Catanames);
$languages = Kohana::config('sites.'.$this->site_id.'.language');

        foreach($languages as $l){
            if($l == 'en'){
    $ret = DB::update('catalogs')->set(array('on_menu' => 1))
                                ->where('site_id','=',$this->site_id)
                                ->where('link', 'IN', $Cata)
                                ->execute();
            }else{
             $ret = DB::update('catalogs_'.$l)->set(array('on_menu' => 1))
                                ->where('site_id','=',$this->site_id)
                                ->where('link', 'IN', $Cata)
                                ->execute();
            }

        }


                message::set('批量操作成功');
                $this->request->redirect('/admin/site/catalog/list');
    
            
          
        }
        else
        {
         $this->request->redirect('/admin/site/catalog/list');   
        }
    }

    function action_products_top()
    {
        if ($_POST)
        {
            $catalog_id = Arr::get($_POST, 'catalog_id', 0);
            $SKUs = Arr::get($_POST, 'SKUARR2', '');
            if (!$SKUs)
            {
                message::set('SKU不可为空！', 'notice');
                $this->request->redirect('/admin/site/catalog/edit/' . $catalog_id);
            }
            $posterity = Catalog::instance($catalog_id)->posterity();
            $posterity[] = $catalog_id;
            $postSql = implode(',', $posterity);
            $skuArr = explode("\n", $SKUs);
            $result = DB::select('id')
                    ->from('products_product')
                    ->where('sku', 'IN', $skuArr)
                    ->execute('slave')
                    ->as_array();
            foreach ($result as $product)
            {
                $rs = DB::update('catalog_products')
                        ->set(array('position' => 1))
                        ->where('product_id', '=', $product['id'])
                        ->and_where('catalog_id', 'IN', $posterity)
                        ->execute();
                if ($rs)
                {
                    Manage::add_product_update_top_log($product['id'], $catalog_id, Session::instance()->get('user_id'), '产品置顶');
                }
            }
            message::set('分类产品置顶成功！');
            
            $this->request->redirect('/admin/site/catalog/edit/' . $catalog_id);
        }
        else
        {
            $this->request->redirect('/admin/site/catalog/list');
        }
    }

    public function action_products_zero()
    {
        if ($_POST)
        {
            $catalog_id = Arr::get($_POST, 'catalog_id', 0);
            $SKUs = Arr::get($_POST, 'SKUARR3', '');
            if (!$SKUs)
            {
                message::set('SKU不可为空！', 'notice');
                $this->request->redirect('/admin/site/catalog/edit/' . $catalog_id);
            }
            $posterity = Catalog::instance($catalog_id)->posterity();
            $posterity[] = $catalog_id;
            $skuArr = explode("\n", $SKUs);
            $result = DB::select('id')
                ->from('products_product')
                ->where('sku', 'IN', $skuArr)
                ->execute('slave')
                ->as_array();
            $key = 1;
            foreach ($result as $product)
            {
                $update = DB::update('catalog_products')
                    ->set(array('position' => 0))
                    ->where('product_id', '=', $product['id'])
                    ->and_where('catalog_id', 'IN', $posterity)
                    ->execute();

                $ret2 = DB::update('products')->set(array('position' => 0))
                                ->where('id','=',$product['id'])
                                ->execute();

                Manage::add_product_update_top_log($product['id'],$catalog_id,Session::instance()->get('user_id'), '取消置顶');    
                $key++;
            }
            message::set('分类Position置零成功！');
            $this->request->redirect('/admin/site/catalog/edit/' . $catalog_id);
        }
        else
        {
            $this->request->redirect('/admin/site/catalog/list');
        }
    }

    public function action_export_products()
    {
        $id = $this->request->param('id');
        $products = Catalog::instance($id)->products();
        $cname = Catalog::instance($id)->get('name');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Products-' . $cname . '.csv"');
        echo "SKU,Name,Catalog,Created,URL to product,Price,RMB Cost,Currency,URL to image,SearchTerms,Status,Category,Clicks,Sales,Description,Attributes,Admin\n";

        foreach ($products as $pid)
        {
            $product = Product::instance($pid)->get();
            echo $product['sku'], ',';
            echo '"' . trim(str_replace('"', '\"', $product['name'])) . '"', ',';
            echo '"' . $cname . '"', ',';
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
            $orders = DB::query(Database::SELECT, 'SELECT COUNT(order_items.id) AS count FROM order_items LEFT JOIN orders ON order_items.order_id=orders.id WHERE orders.payment_status="verify_pass" AND order_items.product_id=' . $product['id'])->execute('slave')->get('count');
            echo '"' . $orders . '"', ',';
            $description = strip_tags($product['description']);
            $description = preg_replace('/(&nbsp;)+/', ' ', $description);
            $description = str_replace('&amp;', '&', $description);
            $description = trim(preg_replace('/"|\n/', '', $description));
            echo '"' . $description . '"', ',';
            $attributes = '';
            foreach ($product['attributes'] as $name => $val)
            {
                $attributes .= $name . ':';
                $attributes .= implode(';', $val) . ';';
            }
            echo '"' . $attributes . '"',',';
            if(is_numeric($product['admin'])) {
                $admin=User::instance($product['admin'])->get('name');
            }else{
                $admin="";
            }
            echo '"'.$admin.'"';
            echo PHP_EOL;
        }
    }

    public function action_sorts()
    {
        $content = View::factory('admin/site/catalog_sorts')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_sorts_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                //TODO add filter items
                // TODO optimize name filter.
                if ($item->field == 'created')
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
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
//                                elseif($item->field == 'catalog')
//                                {
//                                        $catalog_id = DB::select('id')->from('products_category')->where('name', '=', $item->data)->execute()->get('id');
//                                        $_filter_sql[] = "catalog_id='".$catalog_id."'";
//                                }
                elseif ($item->field == 'attributes')
                {
                    $_filter_sql[] = "attributes LIKE '%" . $item->data . "%'";
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(`id`) AS count FROM `catalog_sorts` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave')->get('count');
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM `catalog_sorts` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            $catalog = Catalog::instance($data['catalog_id'])->get('name');
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                $catalog,
                $data['sort'],
                $data['attributes']
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_sorts_add()
    {
        if ($_POST)
        {
            $catalog = Arr::get($_POST, 'catalog', '');
            $catalog = htmlspecialchars($catalog);
            $catalog_id = DB::select('id')->from('products_category')->where('name', '=', trim($catalog))->execute('slave')->get('id');
            if (!$catalog_id)
            {
                Message::set('Catalog not exist!', 'error');
            }
            else
            {
                $data['catalog_id'] = $catalog_id;
                $sort = Arr::get($_POST, 'sort', '');
                $attributes = Arr::get($_POST, 'attributes', '');
                if (!$sort OR !$attributes)
                    Message::set('Input param error!', 'error');
                else
                {
                    $attributes = trim($attributes);
                    $attributes = str_replace("\n", "\t", $attributes);
                    $attributes = str_replace("\t", ",", $attributes);
                    $data['sort'] = ucfirst($sort);
                    $data['attributes'] = $attributes;
                    $data['site_id'] = $this->site_id;
                    $insert = DB::insert('catalog_sorts', array_keys($data))->values($data)->execute();
                    if ($insert)
                        Message::set('Add catalog sort success!', 'success');
                    else
                        Message::set('Add catalog sort failed!', 'error');
                }
            }
            $this->request->redirect('admin/site/catalog/sorts');
        }
    }

    public function action_sorts_edit()
    {
        if ($_POST)
        {
            $success = '';
            $id = Arr::get($_POST, 'id', 0);
            if (!$id)
            {
                $success = 'Data not exist!';
            }
            else
            {
                $catalog = Arr::get($_POST, 'catalog', '');
                $catalog_id = DB::query(Database::SELECT, 'SELECT id FROM catalogs WHERE name = "' . $catalog . '"')->execute('slave')->get('id');
                if (!$catalog_id)
                {
                    $success = 'Catalog not exist!';
                }
                else
                {
                    $data['catalog_id'] = $catalog_id;
                    $sort = Arr::get($_POST, 'sort', '');
                    $attributes = Arr::get($_POST, 'attributes', '');
                    if (!$sort OR !$attributes)
                        $success = 'Input param error!';
                    else
                    {
                        $attributes = trim($attributes);
                        $attributes = str_replace("\n", "\t", $attributes);
                        $attributes = str_replace("\t", ",", $attributes);
                        $data['sort'] = ucfirst($sort);
                        $data['attributes'] = $attributes;
                        $data['site_id'] = $this->site_id;
                        $update = DB::update('catalog_sorts')->set($data)->where('id', '=', $id)->execute();
                        if ($update)
                            $success = 'success';
                        else
                            $success = 'Update catalog sort failed!';
                    }
                }
            }
            echo json_encode($success);
            exit;
        }
    }

    public function action_sorts_ajaxdata()
    {
        if ($_POST)
        {
            $id = Arr::get($_POST, 'id', 0);
            if ($id)
            {
                $data = DB::select()->from('catalog_sorts')->where('id', '=', $id)->execute('slave')->current();
                $data['catalog'] = Catalog::instance($data['catalog_id'])->get('name');
                $data['attributes'] = str_replace(',', "\n", $data['attributes']);
                echo json_encode($data);
                exit;
            }
        }
    }

    public function action_sorts_delete()
    {
        $id = $this->request->param('id');
        if (!$id)
        {
            Message::set('Data not exists!', 'error');
        }
        else
        {
            $delete = DB::delete('catalog_sorts')->where('id', '=', $id)->execute();
            if ($delete)
                Message::set('Delete catalog sort success!', 'success');
            else
                Message::set('Delete catalog sort failed!', 'error');
        }
        $this->request->redirect('admin/site/catalog/sorts');
    }

    public function action_sorts_import()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $success = array();
        $error = array();
        $catalog_bak = 0;
        while ($data = fgetcsv($handle))
        {
            if ($data[0] == 'catalog')
            {
                $row++;
                continue;
            }
            try
            {
                if (!$data[0])
                    $catalog_id = $catalog_bak;
                else
                {
                    $catalog = htmlspecialchars(trim($data[0]));
                    $catalog_id = DB::query(Database::SELECT, 'SELECT id FROM catalogs WHERE name = "' . $catalog . '"')->execute('slave')->get('id');
                }
                if (!$catalog_id OR !$data[1] OR !$data[2])
                    continue;
                $catalog_bak = $catalog_id;
                $array = array(
                    'catalog_id' => $catalog_id,
                    'sort' => trim($data[1])
                );
                $attributes = array();
                for ($i = 2; $i <= count($data) - 1; $i++)
                {
                    if ($data[$i])
                        $attributes[] = trim($data[$i]);
                }
                if (empty($attributes))
                    continue;
                $array['attributes'] = implode(',', $attributes);
                $array['site_id'] = $this->site_id;
                $insert = DB::insert('catalog_sorts', array_keys($array))->values($array)->execute();
                if ($insert)
                    $success[] = "Add Row " . $row . " Success";
                $row++;
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        echo implode('<br>', $success);
        echo '<br><br>';
        echo implode('<br>', $error);
    }
    
    function action_import_basic()
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
            if (!$content)
            {
                Message::set('Input Cannot Be Empty!', 'notice');
                $this->request->redirect('/admin/site/catalog/list?lang=' . $lang);
            }
            if ($lang)
            {
                $lang_table = $lang ? '_' . $lang : '';
                $row = 1;
                $head = array();
                $amount = 0;
                $success = '';
                if (strpos($content, '<br />') !== false)
                    $array = explode('<br />', $content);
                else
                    $array = explode("\n", $content);
                foreach ($array as $value)
                {
                    $value = str_replace(array('<p>', '</p>'), array('', ''), $value);
                    if (strpos($value, 'white-space:pre') !== false)
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
                        $basic = array();
                        foreach ($data as $key => $value)
                        {
                            $value = trim($value);
                            if (!$key OR $value == '')
                                continue;
                            $basic[$head[$key]] = $value;
                        }
                        $name = trim($data[0]);
                        $catalog_id = DB::select('id')->from('products_category')->where('name', '=', $name)->execute('slave')->get('id');
                        if ($catalog_id AND !empty($basic))
                        {
                            $catalog = ORM::factory('catalog' . $lang, $catalog_id);
                            $catalog->values($basic);
                            $columns = array_keys($catalog->list_columns());
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
                                $success .= $name . '<br>';
                                $result = DB::update('catalogs' . $lang_table)->set($basic)->where('id', '=', $catalog_id)->execute();
                                if ($result)
                                    $amount++;
                            }
                        }
                    }
                    $row++;
                }
                echo $amount . ' catalogs basics import successfully:<a href="/admin/site/catalog/add?lang='.$lang.'" style="color:red;">Back</a><br>';
                echo $success;
            }
        }
    }

    public function action_colors()
    {
        if($_POST)
        {
            $color_id = Arr::get($_POST, 'color_id', 0);
            $skus = Arr::get($_POST, 'skus', '');
            $skuArr = explode("\n", $skus);
            if(!$color_id)
            {
                $max_id = DB::select(DB::expr('MAX(color_id) AS max_id'))->from('catalog_colors')->execute('slave')->get('max_id');
                $max_id = (int) $max_id;
                $color_id = $max_id + 1;
            }

            $error = array();

            $insert = array(
                'color_id' => $color_id,
                'product_id' => 0,
                'site_id' => $this->site_id,
            );
            foreach($skuArr as $sku)
            {
                $sku = trim($sku);
                $product_id = Product::get_productId_by_sku($sku);
                $has = DB::select('id')->from('catalog_colors')->where('product_id', '=', $product_id)->execute('slave')->get('id');
                if($has)
                {
                    $error[] = $sku;
                }
                else
                {
                    $insert['product_id'] = $product_id;
                    DB::insert('catalog_colors', array_keys($insert))->values($insert)->execute();
                }
            }
            if(!empty($error))
            {
                Message::set(implode($error) . ' exist', 'error');
            }
            else
            {
                Message::set('Add all sku success', 'success');
            }
        }
        $content = View::factory('admin/site/catalog_colors')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_colors_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        $order_sql = '';
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                // TODO optimize name filter.
                if ($item->field == 'sku')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $_filter_sql[] = "product_id='" . $product_id . "'";
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $count = DB::query(DATABASE::SELECT, 'SELECT COUNT(id) AS count FROM `catalog_colors` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave')->get('count');
        $total_pages = 0;
        $limit = 20;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM `catalog_colors` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' GROUP BY id ' . $order_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach ($result as $data)
        {
            $sku = Product::instance($data['product_id'])->get('sku');
            $responce['rows'][$k]['id'] = $data['id'];
            $responce['rows'][$k]['cell'] = array(
                $data['id'],
                $data['color_id'],
                $sku,
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_colors_delete()
    {
        $id = $this->request->param('id');
        if (!$id)
        {
            Message::set('Data not exists!', 'error');
        }
        else
        {
            $delete = DB::delete('catalog_colors')->where('id', '=', $id)->execute();
            if ($delete)
                Message::set('Delete catalog colors product success!', 'success');
            else
                Message::set('Delete catalog colors product failed!', 'error');
        }
        $this->request->redirect('admin/site/catalog/colors');
    }

    public function action_colors_bulk()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 0;
        $success = array();
        $error = array();
        $max_id = DB::select(DB::expr('MAX(color_id) AS max_id'))->from('catalog_colors')->execute('slave')->get('max_id');
        $max_id = (int) $max_id;
        $color_id = $max_id + 1;
        $error_skus = array();
        while ($data = fgetcsv($handle))
        {
            if (!$data[0])
            {
                $row++;
                continue;
            }
            try
            {
                $num = 0;
                $insert = array();
                foreach($data as $sku)
                {
                    $sku = trim($sku);
                    $product_id = Product::get_productId_by_sku($sku);
                    if($product_id)
                    {
                        $has = DB::select('id')->from('catalog_colors')->where('product_id', '=', $product_id)->execute()->get('id');
                        if(!$has)
                            $insert[] = $product_id;
                    }
                    else
                    {
                        $error_skus[] = $sku;
                    }
                    $num ++;
                }
                if(!empty($insert))
                {
                    $array = array(
                        'color_id' => $color_id,
                        'product_id' => 0,
                        'site_id' => $this->site_id,
                    );
                    foreach($insert as $product)
                    {
                        $array['product_id'] = $product;
                        DB::insert('catalog_colors', array_keys($array))->values($array)->execute();
                        $success[] = $product;
                    }
                    $success[] = '<br>';
                    $color_id ++;
                }
                $row++;
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        echo ' ' . implode(' ', $success);
        echo '<br><br>';
        echo implode('<br>', $error);
        echo '<br><br>';
        if(!empty($error_skus))
            echo implode(',', $error_skus) . ' do not exists';
    }

    public function action_brands_list()
    {
        if($_POST)
        {
            $name = trim(Arr::get($_POST, 'name', ''));
            $brief = trim(Arr::get($_POST, 'brief', ''));
            if(!$name)
            {
                Message::set('Post data error!', 'error');
            }
            else
            {
                $label = strtolower($name);
                $has = DB::select('id')->from('products_brands')->where('label', '=', $label)->execute('slave')->get('id');
                if($has)
                {
                    Message::set('This brand is already exists!', 'error');
                }
                else
                {
                    $data = array(
                        'name' => $name,
                        'label' => $label,
                        'brief' => $brief,
                    );
                    DB::insert('products_brands', array_keys($data))->values($data)->execute();
                    Message::set('Add brand success', 'success');
                }
            }
        }
        $brands = DB::select()->from('products_brands')->order_by('id', 'DESC')->execute('slave')->as_array();
        $content_data['brands'] = $brands;
        $content = View::factory('admin/site/catalog_brands_list', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    //导入csv写好的程序哈
    public function action_brandcsv()
    {
        $name = Arr::get($_POST, 'file', '');
        $arr = explode("\n", $name);
        foreach($arr as $value)
        {
            $data = explode(",",$value);
            $label = strtolower($data[0]);
            $has = DB::select('id')->from('products_brands')->where('label', '=', $label)->execute('slave')->get('id');
            if(!$has)
            {
                $array = array(
                    'name' => $data[0],
                    'label' => strtolower($data[0]),
                    'brief' => $data[1],
                );
                $add = DB::insert('products_brands', array_keys($array))->values($array)->execute();
                $success[] = $data[0];                        
            }

        }

        $successes = implode("<br/>", $success);
        die("Success skus:<br/>" . $successes);
    }

    public function action_productinfo()
    {
        $type = Arr::get($_GET,'type',1);

        if($type == 1)
        {
            $can = 'factory';
        }
        else
        {
            $can = 'offline_factory';            
        }
        header("Content-type:text/html;charset=utf-8");
        $brandarr = DB::query(Database::SELECT, "SELECT id,name,brief FROM brands where brief !=''")->execute('slave')->as_array();

        foreach($brandarr as $keyb=>$valueb)
        {
            $factory = $valueb['brief'];
            $productarr = DB::query(Database::SELECT, "SELECT id,sku FROM products where '".$can . "' ='".$factory . "' and `visibility` = 1 and `status` = 1 and brand_id ='' order by id desc")->execute('slave')->as_array();
            if($productarr)
            {
                foreach($productarr as $brand =>$value)
                {
                    $update['brand_id'] = $valueb['id'];
                   DB::update('products')->set($update)->where('id', '=', $value['id'])->execute();
                }
            }

        }
    }

    public function action_daochubrand()
    {
        $productarr = DB::query(Database::SELECT, "SELECT id,sku,brand_id FROM products where brand_id !=''")->execute('slave')->as_array();
        foreach ($productarr as $key => $value) {
            echo $value['id'].','.$value['brand_id'];
            echo '<br />';
        }
    }

    public function action_uploadbrand()
    {
        if($_POST)
        {
            echo '<pre>';
            $tt = Arr::get($_POST,'title','');
            $ttarr = explode("\n",$tt);

            foreach($ttarr as $key=> $value)
            {
                $vs = explode(",",$value);
                $update['brand_id'] = $vs[1];
                DB::update('products')->set($update)->where('id', '=', $vs[0])->execute();
            }
        }
        else
        {
        echo '<form style="margin:20px;" method="post" action="" target="_blank">
                    <textarea rows="20" cols="25" name="title"></textarea>
                    <input type="submit" value="导入" class="ui-button" style="padding:0 .5em">
                </form>';
        }
    }

    public function action_brands_edit()
    {
        if($_POST)
        {
            $id = Arr::get($_POST, 'brand_id', 0);
            if(!$id)
            {
                message::set('Post data error!', 'error');
            }
            else
            {
                $name = trim(Arr::get($_POST, 'brand_name', ''));
                $brief = trim(Arr::get($_POST, 'brand_brief', ''));
                if(!$name)
                {
                    Message::set('Post data error!', 'error');
                }
                else
                {
                    $label = strtolower($name);
                    $data = array(
                        'name' => $name,
                        'label' => $label,
                        'brief' => $brief,
                    );
                    DB::update('products_brands')->set($data)->where('id', '=', $id)->execute();
                    Message::set('Edit brand success', 'success');
                }
            }
        }
        $this->request->redirect('/admin/site/catalog/brands_list');
    }

    public function action_brand_delete()
    {
        $id = $this->request->param('id');
        if($id)
        {
            DB::delete('products_brands')->where('id', '=', $id)->execute();
            Message::set('Delete brand success');
        }
        else
        {
            Message::set('Param error!', 'error');
        }
        $this->request->redirect('/admin/site/catalog/brands_list');
    }

    public function action_delete_products()
    {
        $id = $this->request->param('id');
        if($id)
        {
            $deletes = array();
            $catalog_products = DB::select('product_id')->from('catalog_products')->where('catalog_id', '=', $id)->execute();
            foreach($catalog_products as $product)
            {
                $deletes[] = $product['product_id'];
            }
            DB::delete('catalog_products')->where('catalog_id', '=', $id)->execute();
            Catalog::elastic_product($id, array(), $deletes);
            Message::set('Delete all products success');

        }
        else
        {
            Message::set('delete false!', 'error');
        }
        $this->request->redirect('/admin/site/catalog/edit/'.$id);
    }

    public function action_catalogdelete_products()
    {
        $id = $this->request->param('id');
        $menu = Catalog::instance($id)->get('on_menu');

        if($menu)
        {
            $data['position'] = 0;
            DB::update('catalog_products')->set($data)->where('catalog_id', '=', $id)->execute();
            Message::set('update products success');
        }
        else
        {
            $data['positiontwo'] = 0;
            DB::update('catalog_products')->set($data)->where('catalog_id', '=', $id)->execute();
            Message::set('update products success');
        }
        $this->request->redirect('/admin/site/catalog/edit/'.$id);
    }

    public function action_output_customer()
      {
            $sql = 'select 
            email,ip_country
            from customers
            where flag= 0
            ';
            $result = DB::query(DATABASE::SELECT, $sql  )->execute('slave');
            $res_arr=array();
             foreach ($result as $r_value) {
                
                    $re=array();
                    $re['email']=$r_value['email'];
                    $re['country']=$r_value['ip_country'];
                    $res_arr[]=$re;
                
            }
            $str='';
            $str.="\xEF\xBB\xBF" .'Email,Country'."\n";
            foreach ($res_arr as $value) {
                $str.=$value['email'].','.$value['country']."\n";
            }
            
            error_reporting(E_ALL);
            date_default_timezone_set('America/Chicago');
            header("Content-type:text/csv");   
            header("Content-Disposition:attachment;filename=none.csv");   
             
            echo $str;
      }

      public function action_output_catalogs_data()
      {
            // $sql = 'select  id,
            // name,link,on_menu
            // from catalogs
            // ';

            $sql='select a.id id,a.name name,a.link link,a.on_menu on_menu,b.name parent_name from catalogs a left join catalogs b on a.parent_id=b.id';
            $result = DB::query(DATABASE::SELECT, $sql  )->execute('slave');
            $res_arr=array();
             foreach ($result as $r_value) {
                
                    $re=array();
                    $re['name']=$r_value['name'];
                    $re['link']='http://www.choies.com/'.$r_value['link'].'-c-'.$r_value['id'];
                    $re['on_menu']=$r_value['on_menu'];
                    $re['parent_name']=$r_value['parent_name'];
                    $res_arr[]=$re;
                
            }
            $str='';
            $str.="\xEF\xBB\xBF" .'Name,Link,On_menu,Parent_Catalog'."\n";
            foreach ($res_arr as $value) {
                $str.=$value['name'].','.$value['link'].','.$value['on_menu'].','.$value['parent_name']."\n";
            }
            
            error_reporting(E_ALL);
            date_default_timezone_set('America/Chicago');
            header("Content-type:text/csv");   
            header("Content-Disposition:attachment;filename=none.csv");   
             
            echo $str;

      }

    public function action_exprotcsv()
    {
        ob_end_clean();
        ob_start();
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition: attachment; filename=Celebrity_' . date('Y-m-d', time()) . '.xls');
        header("Content-Transfer-Encoding: binary ");

        $buffer = $_POST['csvBuffer'];
        $buffer = iconv("utf-8", "gbk", $buffer);
        try
        {
            echo $buffer;
        }
        catch (Exception $e)
        {
            echo 'Sorry, Server is too busy, please try again later,THX.';
        }
    }


}
