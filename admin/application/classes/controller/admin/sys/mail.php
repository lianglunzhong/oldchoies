<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Sys_Mail extends Controller_Admin_Site
{
    public function action_list()
    {
        $docs = ORM::factory('doc')  
            ->where('site_id','=',$this->site_id)
            ->find_all();
        //TODO add order by
    }

    public function action_edit()
    {
        $id = $this->request->param('id'); 
        $doc = ORM::factory('doc',$id);
        if(!$doc->loaded())
        {
            Message::set('error');
            $this->request->redirect('/admin/sys/mail/list');
        }
    }

    public function action_export()
    {
    
    }
} 
