<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Sys extends Controller 
{
    public function before()
    {
        $user = User::instance()->logged_in();
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

        $role = ORM::factory('role',$user['role_id']);
        $tasks = $role->tasks();

        if(!isset($tasks[$key]) OR !$tasks[$key])
        {
//            $this->request->redirect('/admin/sys/role/404');
        }
    }
} 
