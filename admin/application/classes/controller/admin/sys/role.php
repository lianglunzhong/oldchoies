<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Sys_Role extends Controller_Admin_Sys
{
    public function action_list()
    {
        $content = View::factory('admin/sys/role_list')->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_404()
    {
        message::set('No Permission');
        $content = '';
        $this->request->response = View::factory('admin/template')
            ->set('content',$content)->render();
    }

    public function action_add()
    {
        //添加不同role 需要传递页面元素为parent_id
        if($_POST)
        {
            $_POST['tasks'] = serialize(array());
            $role =  ORM::factory('role');
            $role->values($_POST);

            if($role->check())
            {
                $role->save();
                message::set('add role success');
            }
            else
            {
                message::set('error');
            }
            Request::instance()->redirect('/admin/sys/role/list');
        }
        $content = View::factory('admin/sys/role_add')->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        $role = ORM::factory('role',$id);

        if(!$role->loaded())
        {
            message::set('no role found!');
            Request::instance()->redirect('/admin/sys/role/list');
        }

        $lines = $role->lines();

        if($_POST)
        {
            $data['name'] = Arr::get($_POST, 'name', '');
            $data['brief'] = Arr::get($_POST, 'brief', '');
            if($id == 1)
            {
                $data['parent_id'] = 0;
            }
            else
            {
                $data['parent_id'] = Arr::get($_POST, 'parent_id', '');
            }
            $data['tasks'] = Arr::get($_POST,'tasks',array());
            $data['tasks'] = serialize($data['tasks']);
            $data['lines'] = Arr::get($_POST,'lines',array());
            
            $data['views'] = Arr::get($_POST,'views',array());
            $data['views'] = serialize($data['views']);
            $data['edits'] = Arr::get($_POST,'edits',array());
            $data['edits'] = serialize($data['edits']);
            $data['lines'] = Arr::get($_POST,'lines',array());

            $role->values($data);
            if($role->check())
            {
                $role->save();
                message::set('role saved');
                Request::instance()->redirect('/admin/sys/role/edit/'.$id);
            }

        }

        $content = View::factory('admin/sys/role_edit')
            ->set('data',$role)
            ->set('role', $role->as_array())
            ->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_delete($id)
    {
        //todo delete
        $id = $this->request->param('id');
        $role = Acl::instance()->role_delete($id);
        if($role)
        {
            message::set('delete role success');
        }
        else
        {
            message::set('error');
        }

        Request::instance()->redirect('/admin/sys/role/list');
    }

}
