<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Line extends Controller 
{
    public $line_id;
    public function before()
    {
        $uri = $this->request->uri();
        $data = explode('/',$uri);
        if(count($data) > 3)
        {
            $key = implode('/',array_slice($data,0,4));
        }
        else
        {
            $key = $uri; 
        }

        //get role and check
        $role = ORM::factory('role',$user->role_id);
        if($role->lines)
        {
            $line_ids = explode(',',$role->lines);
        }
        //TODO check lines

        $tasks = $role->tasks();

        if(!isset($tasks[$key]) OR !$tasks[$key])
        {
//            Message::set(__('No Permission'));
//            $this->request->redirect('/admin/sys/site/list');
        }
    }
} 
