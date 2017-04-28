<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Attribute extends Controller_Admin_Site {

    public $site_id;

    public function action_list()
    {
        $this->site_id = 1;

        $count = ORM::factory('attribute')
            ->count_all();

        $pagination = Pagination::factory(
            array(
                'current_page' => array( 'source' => 'query_string' , 'key' => 'page'),
                'total_items' => $count,
                'item_per_page' => 40,
                'view' => 'pagination/basic',
                'auto_hide' => 'FALSE',
            )
        );
        $page_view = $pagination->render();

        $data = ORM::factory('attribute')
            ->where('site_id','=',$this->site_id)
            ->find_all($pagination->items_per_page,$pagination->offset);

        $content = View::factory('admin/site/attribute_list')
            ->set('data',$data)
            ->set('page_view',$page_view)->render();

        // $this->request->response = $template;
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_add()
    {
        $this->site_id = 1;

        if($_POST)
        {
            $data = $_POST;
            $items = array();

            foreach($_POST['item_name'] as $key=>$item)
            {
                $items = array(
                    'name' => $_POST['item_name'][$key],
                    'image' => $_POST['item_image'][$key],
                );
            }
            $data['items'] = serialize($items);
            $data['site_id'] = $this->site_id;

            $attribute = ORM::factory('attribute')->values($data);
            if($attribute->check())
            {
                $attribute->save();
                message::set('添加产品规格成功'); 
                Request::instance()->redirect('admin/site/attribute/list');
            }
            else
            {
                message::set('添加产品规格出错，请重试'.kohana::debug($attribute->validate()->errors())); 
                Request::instance()->redirect('admin/site/attribute/add');
            }
        }

        $content = View::factory('admin/site/attribute_add')->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        $this->site_id = 1;
        $attribute = ORM::factory('attribute')        
            ->where('site_id', '=', $this->site_id)
            ->where('id','=',$id)
            ->find();
        if(!$attribute->loaded())
        {
            message::set('产品规格不存在'); 
            Request::instance()->redirect('admin/site/attribute/list');
        }

        $data = $attribute->as_array();
        $data['items'] = unserialize($data['items']);

        $content = View::factory('admin/site/attribute_edit')->set('data',$data)->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $attribute = ORM::factory('attribute',$id)->delete(); 
        message::set('删除产品规格'); 
        Request::instance()->redirect('admin/site/attribute/list');
    }
} 
