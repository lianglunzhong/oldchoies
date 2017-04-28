<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Banner extends Controller_Admin_Site
{

    public function action_list()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = $this->request->param('id');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        $banners = DB::query(Database::SELECT, 'SELECT * FROM banners WHERE type="" AND lang="'.$lang.'" ORDER BY position ASC, id DESC')->execute('slave')->as_array();
        $content = View::factory('admin/site/banner_list')->set('banners', $banners)->set('lang', $lang)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_add()
    {
        if ($_POST)
        {   
            $data = array();
            $data['link'] = $_POST['link'];
            $imageArr = explode(',', $_POST['image_src']);
            $imagesRemove = explode(',', $_POST['images_removed']);
            foreach ($imagesRemove as $image)
            {
                if ($image && file_exists($dir . $image))
                {
                    unlink($dir . $image);
                    DB::delete('site_images')->where('filename', '=', $image)->execute();
                }
            }

            foreach ($imageArr as $key => $image)
            {
                if (in_array($image, $imagesRemove))
                {
                    unset($imageArr[$key]);
                }
            }

            if (!$data['link'] || empty($imageArr))
            {
                Message::set(__('Parameter Error'), 'error');
                Request::instance()->redirect('admin/site/banner/add');
            }
            $data['image'] = $imageArr[0];
            $data['alt'] = Arr::get($_POST, 'alt', '');
            $data['title'] = Arr::get($_POST, 'title', '');
            $data['map'] = Arr::get($_POST, 'map', '');
            $data['visibility'] = Arr::get($_POST, 'visibility', 1);
            $data['position'] = Arr::get($_POST, 'position', 0);
            $data['lang'] = Arr::get($_POST, 'lang', '');
            $data['site_id'] = $this->site_id;
            $result = DB::insert('banners', array_keys($data))->values($data)->execute();
            if ($result)
            {
                Message::set(__('Add banner success!'), 'success');
                Request::instance()->redirect('admin/site/banner/edit/' . $result[0]);
            }
            else
            {
                Message::set(__('Add banner faild!'), 'error');
                Request::instance()->redirect('admin/site/banner/add');
            }
        }

        $content = View::factory('admin/site/banner_add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        if ($_POST)
        {
            $data = array();
            $data['link'] = $_POST['link'];
            require 'inc_config.php';
            $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
            $images_removed = Arr::get($_POST, 'images_removed', '');
            $imagesRemove = explode(',', $images_removed);
            $image_src = Arr::get($_POST, 'image_src', '');
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
            foreach ($imageArr as $key => $image)
            {
                if (in_array($image, $imagesRemove))
                {
                    unset($imageArr[$key]);
                }
            }
            if (!$data['link'])
            {
                Message::set(__('Parameter Error'), 'error');
                Request::instance()->redirect('admin/site/banner/edit/' . $id);
            }
            if (!empty($imageArr))
            {
                $result = DB::select('image')->from('banners')->where('id', '=', $id)->and_where('site_id', '=', $this->site_id)->execute('slave')->current();
                if (file_exists($dir . $result['image']) AND !is_dir($dir . $result['image']))
                {
                    unlink($dir . $result['image']);
                    DB::delete('site_images')->where('filename', '=', $result['image'])->execute();
                }

                $data['image'] = $imageArr[0];
            }
            $data['alt'] = Arr::get($_POST, 'alt', '');
            $data['title'] = Arr::get($_POST, 'title', '');
            $data['map'] = Arr::get($_POST, 'map', '');
            $data['visibility'] = Arr::get($_POST, 'visibility', 1);
            $data['position'] = Arr::get($_POST, 'position', 0);
            $data['lang'] = Arr::get($_POST, 'lang', '');
            $data['site_id'] = $this->site_id;
            $result = DB::update('banners')->set($data)->where('id', '=', $id)->execute();
            if ($result)
            {
                Message::set(__('Edit banner success!'), 'success');
                Request::instance()->redirect('admin/site/banner/edit/' . $id);
            }
        }

        $banner = DB::select()->from('banners')->where('id', '=', $id)->and_where('site_id', '=', $this->site_id)->execute('slave')->current();
        $content_data['banner'] = $banner;
        $content = View::factory('admin/site/banner_edit', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        require 'inc_config.php';
        $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
        $id = $this->request->param('id');
        $result = DB::select('image')->from('banners')->where('id', '=', $id)->execute('slave')->current();
        $image = $result['image'];
        if ($result)
        {
            if ($image && file_exists($dir . $image))
            {
                unlink($dir . $image);
                DB::delete('site_images')->where('filename', '=', $image)->execute();
            }
            $delete = DB::delete('banners')->where('id', '=', $id)->execute();
            if ($delete)
            {
                message::set(__('Delete banner success'), 'success');
                Request::instance()->redirect('admin/site/banner/list');
            }
        }
        else
        {
            message::set(__('Banner not exist'), 'error');
            Request::instance()->redirect('admin/site/banner/list');
        }
    }

    public function action_index()
    {
        //guo  set memcache
        $cache = Cache::instance('memcache');
        $indexsku = $cache->get('indexsku',array());

        $giftsku = $cache->get('giftsku',array()); 
        if(!empty($indexsku) && is_array($indexsku))
        {
            $cache->set('indexsku',$indexsku,30*86400);
        }

        if(!empty($giftsku) && is_array($giftsku))
        {
            $cache->set('giftsku',$giftsku,30*86400);
        }
        
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = $this->request->param('id');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        $banners = DB::query(Database::SELECT, 'SELECT * FROM banners WHERE type="index" AND lang="'.$lang.'" ORDER BY position ASC')->execute('slave')->as_array();
        $buyers_show = DB::query(Database::SELECT, 'SELECT * FROM banners WHERE type="buyers_show" AND lang="'.$lang.'" ORDER BY position ASC')->execute('slave')->as_array();
        $apparel = DB::query(Database::SELECT, 'SELECT * FROM banners WHERE type IN ("apparel", "activity", "product", "activities", "freetrial", "accessory") AND lang="'.$lang.'" ORDER BY position ASC')->execute('slave')->as_array();
        $banners1 = DB::query(Database::SELECT, 'SELECT * FROM banners WHERE type="index1" AND lang="'.$lang.'" ORDER BY position ASC')->execute('slave')->as_array();
        $banners2 = DB::query(Database::SELECT, 'SELECT * FROM banners WHERE type="newindex" AND lang="'.$lang.'" ORDER BY position ASC')->execute('slave')->as_array();
        $content = View::factory('admin/site/banner_index_list')
            ->set('banners', $banners)
            ->set('banners1', $banners1)
            ->set('banners2', $banners2)
            ->set('buyers_show', $buyers_show)
            ->set('apparel', $apparel)
            ->set('lang', $lang)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }
	
    public function action_side()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = $this->request->param('id');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        $banners = DB::query(Database::SELECT, 'SELECT * FROM banners WHERE type="side" AND lang="'.$lang.'" ORDER BY position ASC')->execute('slave')->as_array();
        $content = View::factory('admin/site/banner_side_list')
            ->set('banners', $banners)
            ->set('lang', $lang)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_phoneindex()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = $this->request->param('id');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
        $banners = DB::query(Database::SELECT, 'SELECT * FROM banners WHERE type="phone" AND lang="'.$lang.'" ORDER BY position ASC')->execute('slave')->as_array();
        $phonebanners = DB::query(Database::SELECT, 'SELECT * FROM banners WHERE type="phonecatalog" AND lang="'.$lang.'" ORDER BY position ASC')->execute('slave')->as_array();

        $content = View::factory('admin/site/banner_phoneindex_list')
            ->set('banners', $banners)
            ->set('phonebanners', $phonebanners)
            ->set('lang', $lang)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_index_edit()
    {
        $id = $this->request->param('id');
        if ($_POST)
        {
            require 'inc_config.php';
            if($_POST['type'] == 'newindex' || $_POST['type'] == 'phonecatalog')
            {
                $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;   
            }
            else
            {
                $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR;                
            }

            $copy = 0;
            if($_POST['type'] == 'buyers_show')
            {
                $file = $_FILES['file'];
                if ($file['tmp_name'])
                {
                    $img = $dir . $file['name'];
                    if (file_exists($img))
                        unlink($img);
                    $copy = copy($file['tmp_name'], $img);
                    unlink($file['tmp_name']);
                }
                $data['map'] = trim(Arr::get($_POST, 'map', ''));
                $image_delete = trim(Arr::get($_POST, 'image_delete', ''));
                $deletes = explode("\n", $image_delete);
				
                foreach($deletes as $d)
                {
                    $sku = trim($d);
                    if($sku)
                    {
                        $img = $dir . $sku . '.jpg';
                        if(file_exists($img))
                            unlink($img);
                    }
                }
            }
            else
            {
                $typearr = array('index1','index2','index3');
                if(!in_array($_POST['type'],$typearr))
                {
                    $filename = Arr::get($_POST, 'filename', '');
                    $fileArr = explode('.', $filename);
                    $v = strpos($filename, '_v');
                    if($v === False)
                    {
                        $v = strpos($filename, '.');
                    }
                    $filename1 = substr($filename, 0, $v);
                    $filename1 .= '_v' . time() . '.' . $fileArr[1];
                    $file = $_FILES['file'];
                    if ($file['tmp_name'])
                    {
                        $img = $dir . $filename;
                        if (file_exists($img))
                            unlink($img);
                        $img1 = $dir . $filename1;
                        $copy = copy($file['tmp_name'], $img1);
                        unlink($file['tmp_name']);
                    }                    
                }

                $data = array();
                if($_POST['type'] == 'index1')
                {
                   $data['linkarray'] = Arr::get($_POST, 'link', ''); 
                   $data['linkarray'] = trim($data['linkarray']);               
                }
                else
                {
                   $data['link'] = Arr::get($_POST, 'link', ''); 
                }
                
                if(!in_array($_POST['type'],$typearr))
                {
                    $data['image'] = $filename1;
                }
            }
            $data['alt'] = Arr::get($_POST, 'alt', '');
            $data['title'] = Arr::get($_POST, 'title', '');
			$data['type'] = Arr::get($_POST, 'type', '');
            $data['visibility'] = Arr::get($_POST, 'visibility', 1);
            $data['position'] = Arr::get($_POST, 'position', 0);
            $data['site_id'] = $this->site_id;
            $result = DB::update('banners')->set($data)->where('id', '=', $id)->execute();
            if ($result OR $copy)
            {
                Message::set(__('Edit banner success!'), 'success');
                Request::instance()->redirect('admin/site/banner/index_edit/' . $id);
            }
        }

        $banner = DB::select()->from('banners')->where('id', '=', $id)->and_where('site_id', '=', $this->site_id)->execute('slave')->current();

/*        $maparray = array(
                'temp03.jpg',
                'temp043.jpg',
                'temp05.jpg',
                'temp06.jpg',
                'temp07.jpg',
                'temp07.jpg',
                'temp05.jpg',
                'temp06.jpg',
            );

        $maparray = serialize($maparray);*/

        $content_data['banner'] = $banner;
        $content = View::factory('admin/site/banner_index_edit', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }
	
    public function action_for()
    {
		$data['type'] = 'side';
		for($i = 570; $i<628;$i++){			
			  $result = DB::update('banners')->set($data)->where('id', '=', $i)->execute();		
		}
    }
	
    public function action_side_edit()
    {
        $id = $this->request->param('id');
        if ($_POST)
        {
			
            require 'inc_config.php';
            $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
            $copy = 0;
            if($_POST['type'] == 'buyers_show')
            {
                $file = $_FILES['file'];
                if ($file['tmp_name'])
                {
                    $img = $dir . $file['name'];
                    if (file_exists($img))
                        unlink($img);
                    $copy = copy($file['tmp_name'], $img);
                    unlink($file['tmp_name']);
                }
                $data['map'] = trim(Arr::get($_POST, 'map', ''));
                $image_delete = trim(Arr::get($_POST, 'image_delete', ''));
                $deletes = explode("\n", $image_delete);
                foreach($deletes as $d)
                {
                    $sku = trim($d);
                    if($sku)
                    {
                        $img = $dir . $sku . '.jpg';
                        if(file_exists($img))
                            unlink($img);
                    }
                }
            }
            else
            {
                $filename = Arr::get($_POST, 'filename', '');
                $fileArr = explode('.', $filename);
                $v = strpos($filename, '_v');
                if($v === False)
                {
                    $v = strpos($filename, '.');
                }
                $filename1 = substr($filename, 0, $v);
                $filename1 .= '_v' . time() . '.' . $fileArr[1];

                $file = $_FILES['file'];
                if ($file['tmp_name'])
                {
                    $img = $dir . $filename;
                    if (file_exists($img))
                        unlink($img);
                    $img1 = $dir . $filename1;
                    $copy = copy($file['tmp_name'], $img1);
                    unlink($file['tmp_name']);
                }
                $data = array();
                $data['link'] = $_POST['link'];
                $data['image'] = $filename1;
            }
            $data['alt'] = Arr::get($_POST, 'alt', '');
            $data['title'] = Arr::get($_POST, 'title', '');
			$data['type'] = Arr::get($_POST, 'type', '');
            $data['visibility'] = Arr::get($_POST, 'visibility', 1);
            $data['position'] = Arr::get($_POST, 'position', 0);
            $data['site_id'] = $this->site_id;
            $result = DB::update('banners')->set($data)->where('id', '=', $id)->execute();
            if ($result OR $copy)
            {
                Message::set(__('Edit banner success!'), 'success');
                Request::instance()->redirect('admin/site/banner/side_edit/' . $id);
            }
        }

        $banner = DB::select()->from('banners')->where('id', '=', $id)->and_where('site_id', '=', $this->site_id)->execute('slave')->current();
        $content_data['banner'] = $banner;
        $content = View::factory('admin/site/banner_side_edit', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }
	
	//cologs添加marks标识库
    public function action_cologs_edit(){
        if ($_POST)
        {
            $marks = Arr::get($_POST, 'sex', 0);
            $cologs = Arr::get($_POST, 'sku', '');
            $del = Arr::get($_POST, 'del', '');
            $cologs = explode("\n", $cologs);

            if($del=='del'){
                //删除操作
                $delcologs = Arr::get($_POST, 'delsku', '');
                $delskuArr = explode("\n", $delcologs);
                
                $result = DB::select('id')
                ->from('products_category')
                ->where('id', 'IN', $delskuArr)
                ->execute('slave')
                ->as_array();
                    $products = array();
                    $del = array();
            
                    foreach ($result as $cologs)
                    {
                                $result = DB::query(Database::UPDATE, 'UPDATE marks SET mark_name = "" WHERE catalog_id = ' . $cologs['id'])->execute();
                                $del[] += $cologs['id'];
                    }
            //配置文件
            $content = Kohana::config('marks.marks' );
            $content = View::factory('admin/site/banner_cologs_edit',$content)->set('content', $content)->set('del',$del)->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();

            }else{
                //添加操作
                
                $result = DB::select('id')
                ->from('products_category')
                ->where('id', 'IN', $cologs)
                ->execute('slave')
                ->as_array();

            $products = array();
            $update = array();
            $add = array();
            
            foreach ($result as $cologs)
            {
                if(DB::query(Database::SELECT, 'select id from marks where catalog_id = '.$cologs['id'])->execute('slave')->current()){
                        $result = DB::query(Database::UPDATE, 'UPDATE marks SET mark_name = "' . $marks . '" WHERE catalog_id = ' . $cologs['id'])->execute();
                        $update[] += $cologs['id'];
                }else{
                     DB::query(Database::INSERT,'INSERT INTO marks(catalog_id,mark_name,created) values('.$cologs['id'].',"'.$marks.'",'.time().')')->execute();
                        $add[] += $cologs['id'];
                }
            }
            //配置文件
            $content = Kohana::config('marks.marks' );
            $content = View::factory('admin/site/banner_cologs_edit',$content)->set('content', $content)->set('update',$update)->set('add',$add)->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();

            }
            
            
        }
        else
        {
            //配置文件
            $content = Kohana::config('marks.marks' );
            $content = View::factory('admin/site/banner_cologs_edit',$content)->set('content', $content)->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
        
    }

    //product添加marks标识库
    public function action_products_edit(){
        if ($_POST)
        {
            $marks = Arr::get($_POST, 'sex', 0);
            $SKUs = Arr::get($_POST, 'sku', '');
            $del = Arr::get($_POST, 'del', '');
            $skuArr = explode("\n", $SKUs);
            
            if($del=='del'){

                //删除操作
                $delsku = Arr::get($_POST, 'delsku', '');
                $delskuArr = explode("\n", $delsku);
                
                $result = DB::select('id')
                ->from('products_product')
                ->where('sku', 'IN', $delskuArr)
                ->execute('slave')
                ->as_array();
                    $products = array();
                    $del = array();
            
                    foreach ($result as $product)
                    {
                                $result = DB::query(Database::UPDATE, 'UPDATE marks SET mark_name = "" WHERE product_id = ' . $product['id'])->execute();
                                $del[] += $product['id'];
                    }
            //配置文件
            $content = Kohana::config('marks.marks' );
            $content = View::factory('admin/site/banner_products_edit',$content)->set('content', $content)->set('del',$del)->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();

            }else{
                //添加操作
                $result = DB::select('id','sku')
                ->from('products_product')
                ->where('sku', 'IN', $skuArr)
                ->execute('slave')
                ->as_array();
            $products = array();
            $update = array();
            $add = array();
            
            foreach ($result as $product)
            {
                if(DB::query(Database::SELECT, 'select id from marks where product_id = '.$product['id'])->execute('slave')->current()){
                        $result = DB::query(Database::UPDATE, 'UPDATE marks SET mark_name = "' . $marks . '",sku="'.$product['sku'].'" WHERE product_id = ' . $product['id'])->execute();
                        $update[] += $product['id'];
                }else{
                     DB::query(Database::INSERT,'INSERT INTO marks(product_id,mark_name,sku,created) values('.$product['id'].',"'.$marks.'","'.$product['sku'].'",'.time().')')->execute();
                        $add[] += $product['id'];
                }
            }
            //配置文件
            $content = Kohana::config('marks.marks' );
            $content = View::factory('admin/site/banner_products_edit',$content)->set('content', $content)->set('update',$update)->set('add',$add)->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();

            }
            
            
        }
        else
        {
            //配置文件
            $content = Kohana::config('marks.marks' );
            $content = View::factory('admin/site/banner_products_edit',$content)->set('content', $content)->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
        
    }



    //product表格显示
    public function action_data()
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

        //var_dump($filters);
        //exit;
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                $filter_sql .=$item->field . "='" . $item->data . "'";
            }
        }

        
        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
        if($filter_sql){
             $result = DB::query(Database::SELECT, 'SELECT count(id) FROM marks WHERE '.$filter_sql)->execute('slave')->current();
        }else{
             $result = DB::query(Database::SELECT, 'SELECT count(id) FROM marks')->execute('slave')->current();
        }
       
        $count = $result['count(id)'];

        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;
        if($filter_sql){
            $result = DB::query(DATABASE::SELECT, 'SELECT * FROM marks WHERE  ' .
                $filter_sql . ' and product_id > 0 ' . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        }else{
            $result = DB::query(DATABASE::SELECT, 'SELECT * FROM marks where product_id > 0 ' . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        }
        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;
        $i = 0;

        foreach ($result as $review)
        {
            $response['rows'][$i]['id'] = $review['id'];
            $review['sku']=DB::select('sku')->from('products_product')->where('id', '=', $review['product_id'])->execute()->get('sku');
            $response['rows'][$i]['cell'] = array(
                $review['id'],
                $review['product_id'],
                $review['sku'],
                $review['mark_name'],
                date('Y-m-d', $review['created']),
            );
            $i++;
        }

        echo json_encode($response);
    }

    //cologs分类表格显示
    public function action_data1()
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

        //var_dump($filters);
        //exit;
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                $filter_sql .=$item->field . "='" . $item->data . "'";
            }
        }

        
        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
        if($filter_sql){
             $result = DB::query(Database::SELECT, 'SELECT count(id) FROM marks WHERE '.$filter_sql)->execute('slave')->current();
        }else{
             $result = DB::query(Database::SELECT, 'SELECT count(id) FROM marks')->execute('slave')->current();
        }
       
        $count = $result['count(id)'];

        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;
        if($filter_sql){
            $result = DB::query(DATABASE::SELECT, 'SELECT * FROM marks WHERE  ' .
                $filter_sql . ' and catalog_id > 0 ' . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        }else{
            $result = DB::query(DATABASE::SELECT, 'SELECT * FROM marks where catalog_id > 0 ' . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        }
        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;

        foreach ($result as $review)
        {
            $response['rows'][$i]['id'] = $review['id'];
            $review['sku']=DB::select('sku')->from('products_product')->where('id', '=', $review['product_id'])->execute()->get('sku');
            $response['rows'][$i]['cell'] = array(
                $review['id'],
                $review['catalog_id'],
                $review['mark_name'],
                date('Y-m-d', $review['created']),
            );
            $i++;
        }

        echo json_encode($response);
    }

    public function action_ajaximg()
    {
        $id = $_POST['hiddenid'];
        if ($_POST)
        {
            require 'inc_config.php';
            $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;

            $copy = 0;

            $isgoimg = substr($_POST['isgoimg'],3,2);

            $file = $_FILES['btn_file'];
            if ($file['tmp_name'])
            {
                $filename = $file['name'];
                $fileArr = explode('.', $filename);
                $v = strpos($filename, '_v');
                if($v === False)
                {
                    $v = strpos($filename, '.');
                }
                $filename1 = substr($filename, 0, $v);
                $filename1 .= '_v' . time() . '.' . $fileArr[1];

                $img = $dir . $file['name'];
                if (file_exists($img))
                    unlink($img);
                $img1 = $dir . $filename1;
                $copy = copy($file['tmp_name'], $img1);
                unlink($file['tmp_name']);
            }

            $banner = DB::select()->from('banners')->where('id', '=', $id)->execute('slave')->get('map');

            $data['map'] = unserialize($banner);
            $yimg = $data['map'][$isgoimg];
            //删除 修改前的图片
            $img = $dir . $yimg;
            if (file_exists($img))
                unlink($img);
            $data['map'][$isgoimg] = $filename1;
            $data['map'] = serialize($data['map']);


            $data['alt'] = Arr::get($_POST, 'alt', '');
            $data['title'] = Arr::get($_POST, 'title', '');
            $data['type'] = Arr::get($_POST, 'type', '');
            $data['visibility'] = Arr::get($_POST, 'visibility', 1);
            $data['position'] = Arr::get($_POST, 'position', 0);
            $data['site_id'] = $this->site_id;
            $result = DB::update('banners')->set($data)->where('id', '=', $id)->execute();
            if ($result OR $copy)
            {
                echo $filename1;
                die;
            }
        }
    }
	
	

}

?>