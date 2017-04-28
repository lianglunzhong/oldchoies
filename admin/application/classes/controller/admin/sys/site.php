<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Sys_Site extends Controller_Admin_Site
{

    public function action_list()
    {
        $content_data['redirect'] = Arr::get($_REQUEST,'redirect',0);
        $content = View::factory('admin/sys/site_list',$content_data)->render();
        $this->request->response = View::factory('admin/template')
            ->set('content',$content)->render();
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
        $site = ORM::factory('site');
        if($_POST)
        {
            $data['domain'] = Arr::get($_POST,'domain','');
            $data['email'] = Arr::get($_POST,'email','');
            $data['route_type'] = Arr::get($_POST,'route_type','2');
            $data['product'] = Arr::get($_POST,'product','product');
            $data['catalog'] = Arr::get($_POST,'catalog','catalog');
            $data['suffix'] = Arr::get($_POST,'suffix','');
            //TODO 
            $data['language'] = Arr::get($_POST,'lang','en');
            $data['per_page'] = Arr::get($_POST.'per_page',10);
            $site->values($_POST);

            if($site->check())
            {
                $site->save();
                Message::set('Site basic information saved successfully.');
                $this->request->redirect('/admin/sys/site/list');
            }
            else
            {
                Message::set('Please check your input.','error');
            }        
        }

        $content = View::factory('admin/sys/site_add')->render();
        $this->request->response = View::factory('admin/template')
            ->set('content',$content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        $site = ORM::factory('site',$id);
        if(!$site->loaded())
        {
            message::set('产品规格不存在');
            Request::instance()->redirect('admin/site/site/list');
        }

        if($_POST)
        {
            $site->values($_POST);
            if($site->check())
            { //print_r($_POST);exit;
            $site->save();
            message::set('站点修改成功');
            Request::instance()->redirect('admin/sys/site/list/');
            }else
            {
                message::set('站点修改错误');
                Request::instance()->redirect('admin/sys/site/edit/'.$id);
            }
        }

        $content = View::factory('admin/sys/site_edit')->set('data',$site)->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $site = ORM::factory('site')
            ->where('id','=',$id)
            ->where('is_active','=',1)
            ->find();
        if($site->loaded())
        {
            $site->is_active = 0;
            $site->save();
            message::set('删除站点成功');
            Request::instance()->redirect('admin/sys/site/list');
        }else
        {
            message::set('删除产品规格'.kohana::debug($site->validate()->errors()));
            Request::instance()->redirect('admin/sys/site/list');
        }
    }

    public function action_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction

        //filter
        $filters = Arr::get($_REQUEST, 'filters', array( ));

        if($filters)
        {
            $filters = json_decode($filters);
        }

        if(!$sidx) $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if($totalrows) $limit = $totalrows;

        $filter_sql = "";

        if($filters)
        {
            foreach( $filters->rules as $item )
            {
                $filter_sql .= " AND ".$item->field."='".$item->data."'";
            }
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`sites`.`id`) AS num FROM `sites` WHERE 1=1'.$filter_sql)->execute();

        $count = $result[0]['num'];
        $total_pages = 0;

        if($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if($page > $total_pages) $page = $total_pages;
        if($limit < 0) $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if($start < 0) $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT `sites`.* FROM `sites` WHERE 1=1'
            .$filter_sql.' ORDER BY '.$sidx.' '.$sord.' LIMIT '.$limit.' OFFSET '.$start)
            ->execute();
        $responce = array( );
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $k = 0;
        foreach( $result as $customer )
        {
            $responce['rows'][$k]['id'] = $customer['id'];
            $responce['rows'][$k]['cell'] = array(
                $customer['id'],
                $customer['domain'],
                $customer['lang'],
                '1',
            );
            $k++;
        }
        echo json_encode($responce);
    }

    public function action_go()
    {
        $id = $this->request->param('id');
        $site = ORM::factory('site',$id);
        if(!$redirect = Arr::get($_REQUEST,'redirect',0) OR !Toolkit::is_our_url($redirect))
        {
            $redirect = '';
        }
        if($site->loaded())
        {
            Session::instance()->set('SITE_ID',$id); 
            //TODO 

            $this->request->redirect($redirect ? $redirect : '/admin/site/product/list');
        }
        else
        {
            message::set(__('site_does_not_exist'),'error');
            $this->request->redirect('/admin/sys/site/list?redirect='.$redirect);
        }
    }
} 
