<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Sys_Line extends Controller_Admin_Site
{
    public function action_list()
    {
        $count = ORM::factory('line')
            ->where('is_active' , '=' , 1)
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

        $data = ORM::factory('line')
            ->where('is_active' , '=' , 1)
            ->order_by('id' , 'ASC')
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)->find_all();

        $content = View::factory('admin/sys/line_list')
            ->set('data',$data)
            ->set('count',$count)
            ->set('page_view',$page_view)->render();

        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_add()
    {
        if($_POST)
        {
            $data = $_POST;

            $line = ORM::factory('line')->values($data);
            if($line->check())
            {
                $line->save();
                message::set('添加产品线成功');
                Request::instance()->redirect('/admin/sys/line/list');
            }
            else
            {
                message::set('添加产品线出错，请重试'.kohana::debug($line->validate()->errors()));
                Request::instance()->redirect('/admin/sys/line/list');
            }
        }

        //        $content = View::factory('admin/sys/line_add')->render();
        //        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_edit()
    {

        $id = $this->request->param('id');
        //        $line = ORM::factory('line',$id);
        $line = ORM::factory('line')
            ->where('id' , '=' , $id)
            ->where('is_active' , '=' , 1)
            ->find();
        if(!$line->loaded())
        {
            message::set('产品线不存在或者已经被删除');
            Request::instance()->redirect('/admin/sys/line/list');
        }

        if($_POST)
        {
            $line->values($_POST);
            if($line->check())
            {
                $line->save();
                message::set('产品线修改成功');
                Request::instance()->redirect('/admin/sys/line/list/');
            }else
            {
                message::set('产品线修改错误');
                Request::instance()->redirect('/admin/sys/line/edit/'.$id);
            }
        }

        $content = View::factory('admin/sys/line_edit')
            ->set('id' , $id)
            ->set('name' , $line->name)
            ->set('brief' , $line->brief)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)
            ->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $line = ORM::factory('line')
            ->where('id' , '=' , $id)
            ->where('is_active' , '=' , 1)
            ->find();
        if($line->loaded())
        {
            $line->is_active = 0;
            $line->save();
            message::set('产品线删除成功');
            Request::instance()->redirect('/admin/sys/line/list');
        }else
        {
            message::set('没有这条产品线或者已经被删除');
            Request::instance()->redirect('/admin/sys/line/list');
        }
    }
}
