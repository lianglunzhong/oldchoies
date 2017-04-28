<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Template module of ticket
 *
 * @package   Tickets
 * @author    ruan.chao@ketai-inc.com
 * @copyright © 2011 Cofree Development Group
 * @version   SVN: $Id: template.php 832 2011-03-25 07:03:24Z shi.chen $
 */

class Controller_Admin_Ticket_Template extends Controller_Admin_Ticket
{
	public function action_list()
    {
        $count = ORM::factory('ticket_template')
            //->where('is_active' , '=' , 1)
            ->count_all();

        $pagination = Pagination::factory(
            array(
                'current_page' => array( 'source' => 'query_string' , 'key' => 'page'),
                'total_items' => $count,
                //'item_per_page' => 40,
                'view' => 'pagination/basic',
                'auto_hide' => 'FALSE',
            )
        );
        $page_view = $pagination->render();

        $data = ORM::factory('ticket_template')
            //->where('is_active' , '=' , 1)
            ->order_by('id' , 'ASC')
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)->find_all();
        $topics=Ticket::instance()->get_ticket_topic();
        $topicinfo=array();
        foreach ($topics as $topic)
        { 
			$topicinfo[$topic['id']]= $topic['topic'];       	
        }
        $content = View::factory('admin/ticket/template_list')
            ->set('data',$data)
            ->set('count',$count)
            ->set('topic',$topicinfo)
            ->set('page_view',$page_view)->render();

        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_add()
    {
        if($_POST)
        {
            $data = Security::xss_clean($_POST);
			$data['created'] = time();
            $tpl = ORM::factory('ticket_template')->values($data);
            if($tpl->check())
            {
                $tpl->save();
                message::set('添加ticket模板成功');
                Request::instance()->redirect('/admin/ticket/template/list');
            }
            else
            {
                message::set('添加ticket模板出错，请重试'.kohana::debug($tpl->validate()->errors()));
                Request::instance()->redirect('/admin/ticket/template/list');
            }
        }
        $topics=Ticket::instance()->get_ticket_topic();
        $content = View::factory('admin/ticket/template_add')
        ->set('topics' , $topics)
        ->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)
            ->render();
    }

    public function action_edit()
    {

        $id = $this->request->param('id');
        //        $tpl = ORM::factory('line',$id);
        $template = ORM::factory('ticket_template')
            ->where('id' , '=' , $id)
            //->where('is_active' , '=' , 1)
            ->find();
        if(!$template->loaded())
        {
            message::set('ticket模板不存在或者已经被删除');
            Request::instance()->redirect('/admin/ticket/template/list');
        }

        if($_POST)
        {
            $template->values(Security::xss_clean($_POST));
            if($template->check())
            {
                $template->updated = time();
            	$template->save();
                message::set('ticket模板修改成功');
                Request::instance()->redirect('/admin/ticket/template/list/');
            }else
            {
                message::set('ticket模板修改错误');
                Request::instance()->redirect('/admin/ticket/template/edit/'.$id);
            }
        }
		$topics=Ticket::instance()->get_ticket_topic();
        //$priority_list = Kohana::config('ticket.priority');
        $content = View::factory('admin/ticket/template_edit')
            ->set('id' , $id)
            ->set('tpl_name' , $template->tpl_name)
            ->set('tpl_content' , $template->tpl_content)
            ->set('is_active' , $template->is_active)
            ->set('topic_id' , $template->topic_id)
            ->set('topics' , $topics)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)
            ->render();
    }

    public function action_delete()
    {
        $id = $this->request->param('id');
        $template = ORM::factory('ticket_template')
            ->where('id' , '=' , $id)
            //->where('is_active' , '=' , 1)
            ->find();
        if($template->loaded())
        {
            //$template->is_active = 0;
            $template->delete();
            message::set('ticket模板删除成功');
            Request::instance()->redirect('/admin/ticket/template/list');
        }else
        {
            message::set('没有这条ticket模板或者已经被删除');
            Request::instance()->redirect('/admin/ticket/template/list');
        }
    }
}