<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Ticket module of cola end
 *
 * @package   Tickets
 * @author    shi.chen@ketai-inc.com
 * @copyright © 2011 Cofree Development Group
 * @version   SVN: $Id: ticket.php 862 2011-03-28 09:56:39Z shi.chen $
 */

class Controller_Admin_Ticket_manager extends Controller_Admin_Ticket
{
	public function action_list()
	{
		$managers=orm::factory('ticket_user')
				->where('role','=','Manager')
				->where('is_active','=','1')
				->find_all();
		$content=view::factory('admin/ticket/manager_list')
			->set('managers',$managers)
			->render();
		$this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}
	
	public function action_privilege()
	{
		$user_id = $this->request->param('id');
		if($_POST)
		{	
			$data=$_POST;
			$data['user_id']=$user_id;
			Ticket::instance()->privilege_update($data);
			message::set('Modified privilege successful!');
            Request::instance()->redirect('/admin/ticket/manager/privilege/'.$user_id);
		}
		$lines=ticket::instance()->get_ticket_line_name();
		$data=orm::factory('ticket_privilege')
				->where('user_id','=',$user_id)
				->find_all()
				->as_array();
		$c=array();
		foreach ($data as $v)
			$c[]=$v->code;
		$topics=Ticket::instance()->get_ticket_topic();
		$content=view::factory('admin/ticket/manager_privilege')
			->set('lines',$lines)
			->set('topics',$topics)
			->set('data',json_encode($c))
			->set('nickname',Ticket::instance()->get_ticket_user_name($user_id))
			->set('user_id',$user_id)
			->render();
		$this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}

}