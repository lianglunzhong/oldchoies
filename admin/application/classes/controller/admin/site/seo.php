<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Seo extends Controller_Admin_Site {

    public function action_basic() 
    {
        $seo = ORM::factory('site')
                ->where('id','=',$this->site_id)
                ->where('is_active','=',1)
                ->find();

        if(!$seo->loaded()) 
        {
            message::set('不存在此站点');
            exit;
        }

        if($_POST) 
        {
            $data = $_POST;
            $seo->values($data);
            if($seo->check()) 
            {
                $seo->save();
                message::set('seo修改成功');
                Request::instance()->redirect('/admin/site/seo/edit');
            }
            else 
            {
                message::set('seo修改不成功'.kohana::debug($seo->validate()->errors()));
                Request::instance()->redirect('/admin/site/seo/edit');
            }
        }
        else 
        {
            $data = $seo->as_array();
        }

        $content = View::factory('admin/site/seo')->set('data' , $data)->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_robots() 
    {
        $robots = ORM::factory('site')
                ->where('id','=',$this->site_id)
                ->where('is_active','=',1)
                ->find();

        if(!$robots->loaded()) 
        {
            message::set('不存在此站点');
            exit;
        }

        if($_POST) 
        {
            $data = $_POST;
            $robots->values($data);
            if($robots->check()) 
            {
                $robots->save();
                message::set('robots修改成功');
                Request::instance()->redirect('admin/site/robots/edit');
            }
            else
            {
                message::set('robots修改不成功'.kohana::debug($robots->validate()->errors()));
                Request::instance()->redirect('/admin/site/robots/edit');
            }
        }
        
        $content = View::factory('admin/site/robots')->set('data' , $robots)->render();
        $this->request->response = View::factory('/admin/template')->set('content',$content)->render();
    }
}
