<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Manage_Summary extends Controller_Admin_Site
{

    public function action_index()
    {
        $content = View::factory('admin/manage/summary')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

}

