<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Doc extends Controller_Admin_Site
{

    public function action_list()
    {
        $template = View::factory('admin/template')->bind('content',$content)->render();

        $content = View::factory('admin/site_doc_list')
            ->bind('data',$data)
            ->bind('page_view',$page_view)
            ->render();

        $count = ORM::factory('doc')
            ->count_all();

        $pagination = Pagination::factory();

        $data = ORM::factory('doc')
            ->find_all($limit,$offset);

        $this->request->response = $template;
    }

    public function action_add()
    {
        if($_POST)
        {

        }

        $template = View::factory('admin/template')
            ->bind('content',$content)
            ->render();

        $content = View::factory('admin/site_doc_add')->render();
        $this->request->response = $template;
    }

    public function action_edit()
    {
        $id = 0;
        $doc = ORM::factory('doc')
            ->where('site_id','=',$this->site_id)
            ->where('id','=',$id)
            ->find();
        if($doc->loaded())
        {

        }

        if($_POST)
        {

        }

        $template = View::factory('admin/template')
            ->bind('content',$content)
            ->render();
        $content = View::factory('admin/site_doc_edit')
            ->bind('data',$data)
            ->render();
        $data = $doc; 

        $this->request->response = $template;
    }

    public function action_delete()
    {

    }
} 
