<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Image extends Controller_Admin_Site
{

    public function action_list()
    {
        $data=ORM::factory('image')
            ->find_all();

        $content=View::factory('admin/site/image_list')
            ->set('data',$data)
            ->set('which','sites_list')
            ->render();

        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_add()
    {
        $content=View::factory('admin/site/image_list')
            ->set('which','site_add')
            ->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_do_add_site()
    {
        $ip=sprintf("%u",ip2long($_POST['ip']));
        $is_active=$_POST['is_active'];
        $image=ORM::factory('image');
        $image->ip=$ip;
        $image->is_active=$is_active;
        $image->save();

        if($image->saved())
        {
            message::set('Successfully added!');
            Request::instance()->redirect('/admin/site/image/list');
        }
    }

    public function action_pass_current()
    {
        echo 'pass_current';
    }

    public function action_pass_modify()
    {
        echo 'pass_modify';
    }

    public function action_delete_sites($id = null)
    {
        $ids='';
        $ids= $id ? (array)$id : $_POST['site_id'];
        $query=DB::delete('images')->where('id','in',$ids);

        if($query->execute())
        {
            Request::instance()->redirect('/admin/site/image/list');
        }
    }

    public function action_modify_site($id)
    {
        // TODO error
        $data = ORM::factory('image')
            ->where('id','=',$id)
            ->find_all();

        $content = View::factory('admin/site/image_list')
            ->set('data',$data)
            ->set('which','site_modify')
            ->render();

        $this->request->response=View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_do_modify_site()
    {
        $id=$_POST['id'];
        $ip=sprintf("%u",ip2long($_POST['ip']));
        $is_active=$_POST['is_active'];
        $image=ORM::factory('image',$id);
        $image->ip=$ip;
        $image->is_active=$is_active;
        $image->save();
        
        if($image->saved())
        {
            message::set('Successfully saved!');
            Request::instance()->redirect('/admin/site/image/list');
        }
    }
    
    public function action_embed_manager()
    {
        if((isset($_GET['qqfile']) OR isset($_FILES['qqfile'])) AND ($response = self::save()))
        {
            $response['success'] = 'true';
            $response['file_url'] = '/file.php?path=simages&name='.$response['filename'];//TODO https
            echo htmlspecialchars(json_encode($response),ENT_NOQUOTES);
            exit;
        }

        $count = ORM::factory('simage')->where('site_id','=',$this->site_id)->count_all();
        $limit = 12;//TODO config
        $pagination = Pagination::factory(array(
            'current_page' => array('source' => 'query_string', 'key' => 'page'),
            'total_items' => $count,
            'items_per_page' => $limit,
            'view' => 'pagination/basic',
            'auto_hide' => FALSE)
        );

        $content['images'] = ORM::factory('simage')->where('site_id','=',$this->site_id)->order_by('time','desc')->limit($pagination->items_per_page)->offset($pagination->offset)->find_all();
        $content['pagination'] = $pagination->render();
        $this->request->response = View::factory('admin/site/image_manager',$content)->render();
    }

    public function action_do_delete()
    {
        $id = $this->request->param('id');
        $simage = ORM::factory('simage',$id);
        if($simage->loaded())
        {
            $file = kohana::config('upload.resource_dir').DIRECTORY_SEPARATOR.$this->site_id.DIRECTORY_SEPARATOR.'simages'.DIRECTORY_SEPARATOR.$simage->filename;
            if(file_exists($file))
            {
                unlink($file);
            }
            $simage->delete($id);
        }
        return 1;
    }

    public static function save()
    {
        if(isset($_GET['qqfile']) OR isset($_FILES['qqfile']))
        {
            $user_id = Session::instance()->get('user_id');
            $site_id = Site::instance()->get('id');
            if($user_id AND $file_name = Image::upload($site_id,NULL,NULL,TRUE))
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

    public function action_thumbnails1()
    {
        $sizes = array(
            1,2,3,7
        );
        $images = DB::query(Database::SELECT, 'SELECT i.id, i.suffix FROM images i LEFT JOIN products p ON i.obj_id = p.id WHERE p.visibility = 1 AND i.status = 0 ORDER BY i.id LIMIT 0, 50')->execute('slave');
        foreach($images as $i)
        {
            foreach($sizes as $s)
            {
                $link = 'http://' . $_SERVER['HTTP_HOST'] . '/pimages1/' . $i['id'] . '/' . $s . '.' . $i['suffix'];
                echo '<img src="' . $link . '" width="100px" />';
            }
            echo '<br>';
            DB::update('images')->set(array('status' => 1))->where('id', '=', $i['id'])->execute();
        }
        echo '<script type="text/javascript">
                    window.setInterval(pagerefresh, 180000);
                    function pagerefresh() 
                    { 
                        window.location.reload();
                    }     
            </script>';
        exit;
    }

    public function action_delete_thumb()
    {
        $imagedir = kohana::config('upload.resource_dir') . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR;
        // $sizeArr = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 99, 100);
        $sizeArr = array(7);
        if ($_POST)
        {
            if (!$_POST['SKUARR'])
            {
                Message::set('请输入产品的sku', 'notice');
                $this->request->redirect('/admin/site/image/delete_thumb');
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
                    $img = $imagedir . 'thumbnails1' . DIRECTORY_SEPARATOR . $image['id'] . '_' . $size . '.' . $image['suffix'];
                    if (file_exists($img))
                        unlink($img);
                    $link = 'http://' . $_SERVER['HTTP_HOST'] . '/pimages1/' . $image['id'] . '/' . $size . '.' . $image['suffix'];
                    echo '<img src="' . $link . '" width="100px" />';
                }
                echo '<br>';
            }

        }
        echo '
<form method="post" action="">
SKU:<br/>
<textarea name="SKUARR" cols="40" rows="20"></textarea><br/>
<input type="submit" value="Submit" />
</form>                        
';
        exit;
    }

    public function action_product_configs_check()
    {
        $languages = Kohana::config('sites.'.$this->site_id.'.language');
        foreach($languages as $lang)
        {
            if($lang == 'en')
                continue;
            $update = DB::query(Database::UPDATE, 'UPDATE products_' . $lang . ' d, products p SET d.configs = p.configs WHERE d.id = p.id AND d.visibility = 1 AND d.configs != p.configs')->execute();
            if($update)
            {
                echo 'products_' . $lang . ':';
                var_dump($update);
                echo '<br>';
            }
        }
    }

}
