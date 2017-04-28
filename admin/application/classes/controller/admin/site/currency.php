<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Currency extends Controller_Admin_Site
{

    public function action_list()
    {
        $data = array();

        $content = View::factory('admin/site/currency_list')
            ->set('data',$data)->render();

        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_add()
    {
        if($_POST)
        {
            $data = $_POST;
            $items = array();
            foreach($_POST['item_name'] as $key=>$item)
            {
                $items[] = array(
                    'name' => $_POST['item_name'][$key],
                    'image' => $_POST['item_image'][$key],
                );
            }

            $data['items'] = serialize($items);
            $data['site_id'] = $this->site_id;

            $currency = ORM::factory('currency')->values($data);

            if($currency->check())
            {
                $currency->save();
                message::set('添加产品规格成功'); 
                Request::instance()->redirect('/admin/site/currency/list');
            }
            else
            {
                message::set('添加产品规格出错，请重试'.kohana::debug($currency->validate()->errors())); 
                Request::instance()->redirect('/admin/site/currency/add');
            }
        }

        $content = View::factory('admin/site/currency_add')->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
    }

} 
