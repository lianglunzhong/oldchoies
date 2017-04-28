<?php
defined('SYSPATH') OR die('No direct script access.');

class Controller_admin_site_links extends Controller_Admin_Site
{
    public function action_list()
    {
        $content = View::factory('admin/site/link_list')->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');

        $link = ORM::factory('link',$id);
        if($link->loaded())
        {
            if($_POST)
            {
                $data['name'] = Arr::get($_POST,'name','');
                $data['email'] = Arr::get($_POST,'email','');
                $data['subject'] = Arr::get($_POST,'subject','');
                $data['message'] = htmlspecialchars(Arr::get($_POST,'message',''));
                $data['is_valid'] = Arr::get($_POST,'is_valid',0);
                $data['level'] = Arr::get($_POST,'level',3);
                $link->values($data);
                if($link->check())
                {
                    $link->save();
                    Message::set(__('link_edit_success'));
                }
                else
                {
                    Message::set(__('link_data_error'),'error');
                }
                $this->request->redirect('admin/site/links/edit/'.$link->id);
            }
            $content_data['link'] = $link;
            $content = View::factory('admin/site/link_edit',$content_data)->render();
            $this->request->response = View::factory('admin/template')->set('content',$content)->render();
        }
        else
        {
            Message::set(__('link_does_not_exist'),'error');
            $this->request->redirect('/admin/site/links/list');
        }
    }

    public function action_delete()
    {
        $id = $this->request->param('id');

        $links = ORM::factory('link',$id);

        if($links->loaded())
        {
            $links->delete($id);
            Message::set(__('link_delete_success'));
        }
        else
        {
            Message::set(__('link_does_not_exist'),'error');
        }
        $this->request->redirect('/admin/site/links/list');
    }

    public function action_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array( ));

        if($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";

        if($filters)
        {
            foreach( $filters->rules as $item )
            {
                $filter_sql .= " AND ".$item->field."='".$item->data."'";
            }
        }

        if( ! $sidx) $sidx = 1;

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if($totalrows) $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM links WHERE site_id='.$this->site_id.$filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if($page > $total_pages) $page = $total_pages;
		if($limit < 0) $limit = 0;

		$start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if($start < 0) $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM links WHERE site_id='.$this->site_id.' '.
            $filter_sql.' order by '.$sidx.' '.$sord.' limit '.$limit.' offset '.$start)->execute('slave');

        $response = array( );
		$response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach( $result as $review )
        {
            $response['rows'][$i]['id'] = $review['id'];
            $response['rows'][$i]['cell'] = array(
                $review['id'],
                $review['name'],
                $review['email'],
                $review['subject'],
                $review['message'],
                $review['is_valid']? 'Yes' : 'No',
                $review['level'],
            );
            $i++;
        }
        echo json_encode($response);
    }

}

