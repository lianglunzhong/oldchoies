<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Talk module of cola end
 *
 * @package   Tickets
 * @author    ruan.chao@ketai-inc.com
 * @copyright © 2011 Cofree Development Group
 * @version   SVN: $Id: talk.php 832 2011-03-25 07:03:24Z shi.chen $
 */

class Controller_Admin_Ticket_Topic extends Controller_Admin_Ticket
{
    //public static $priority = array('low', 'medium', 'high', 'urgent', 'emergency');
	
	public function action_list()
    {

        $count = ORM::factory('ticket_topic')
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

        $data = ORM::factory('ticket_topic')
            //->where('is_active' , '=' , 1)
            ->order_by('id' , 'ASC')
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)->find_all();

        $priority_list = Kohana::config('ticket.priority');
//        foreach($data as $item)
//        {
//        	$item->priority = $priority_list[$item->priority_id];
//        }
        $content = View::factory('admin/ticket/topic_list')
            ->set('data',$data)
            ->set('count',$count)
            ->set('priority_list', $priority_list)
            ->set('page_view',$page_view)->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
    }

    public function action_add()
    {
        if($_POST)
        {
            $data = Security::xss_clean($_POST);
			$data['created'] = time();
            $topic = ORM::factory('ticket_topic')->values($data);
            if($topic->check())
            {
                $topic->save();
                message::set('添加Topic成功');
                Request::instance()->redirect('/admin/ticket/topic/list');
            }
            else
            {
                message::set('添加Topic出错，请重试');
                Request::instance()->redirect('/admin/ticket/topic/list');
            }
        }
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        $topic = ORM::factory('ticket_topic')
            ->where('id' , '=' , $id)
            ->order_by('for_customer')
            ->find();
        if(!$topic->loaded())
        {
            message::set('Topic不存在或者已经被删除');
            Request::instance()->redirect('/admin/ticket/topic/list');
        }

        if($_POST)
        {
            $topic->values(Security::xss_clean($_POST));
            if($topic->check())
            {
                $topic->updated = time();
            	$topic->save();
                message::set('Topic修改成功');
                Request::instance()->redirect('/admin/ticket/topic/list/');
            }else
            {
                message::set('Topic修改错误');
                Request::instance()->redirect('/admin/ticket/topic/edit/'.$id);
            }
        }		
        $priority_list = Kohana::config('ticket.priority');
        $content = View::factory('admin/ticket/topic_edit')
            ->set('id' , $id)
            ->set('topic' , $topic->topic)
            ->set('brief' , $topic->brief)
            ->set('priority_id' , $topic->priority_id)
            ->set('is_active' , $topic->is_active)
            ->set('for_customer',$topic->for_customer)
            ->set('priority_list', $priority_list)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content',$content)
            ->render();
    }

//    public function action_delete()
//    {
//        $id = $this->request->param('id');
//        $talk = ORM::factory('ticket_topic')
//            ->where('id' , '=' , $id)
//            //->where('is_active' , '=' , 1)
//            ->find();
//        if($talk->loaded())
//        {
//            //$talk->is_active = 0;
//            $talk->delete();
//            message::set('Topic删除成功');
//            Request::instance()->redirect('/admin/ticket/topic/list');
//        }else
//        {
//            message::set('没有这条Topic或者已经被删除');
//            Request::instance()->redirect('/admin/ticket/topic/list');
//        }
//    }
}