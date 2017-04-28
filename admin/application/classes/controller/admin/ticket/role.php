<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Ticket_role extends Controller_Admin_Ticket
{
	public function action_list()
	{
		$user_list=DB::query(Database::SELECT, 'SELECT u.id,u.name FROM users u WHERE u.id NOT IN(SELECT t.user_id FROM ticket_users t)')
					->execute()
					->as_array();
		$sub_list=array();						
		$subordinates=orm::factory('ticket_user')
	    		->where('supervisor_id','=',Session::instance()->get('user_id'))
	    		->find_all();
		foreach ($subordinates as $sub)
		{
			$sub_list[]=$sub->user_id;
		}
		$managers=orm::factory('ticket_user')
					->where('role','=','Manager')
					->find_all()
					->as_array('user_id','nickname');
		$users=orm::factory('ticket_user')
						->order_by('is_active','DESC')
						->order_by('role')
						->order_by('supervisor_id')
						->find_all();
		$content = View::factory('admin/ticket/role_list')
			->set('user_list',$user_list)
			->set('users',$users)
			->set('managers',$managers)
			->set('sub_list',$sub_list)
            ->render(); 
		$this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}
	
	public function action_add()
	{
		if($_POST)
		{
		    Ticket::instance()->role_add($_POST);
		    $this->request->redirect('/admin/ticket/role/list');
		}
	}
	
	public function action_edit()
	{
		$user_id = $this->request->param('id');
		$data=ORM::factory('ticket_user')
						->where('user_id','=',$user_id)
						->find();
		if(!$data->loaded())
		{
			message::set('No such user!');
            Request::instance()->redirect('/admin/ticket/role/list');	 
		}
		if($_POST)
		{
			$helper=Roleupdate::instance($user_id);
			if(isset($_POST['supervisor_id'])&&$_POST['supervisor_id']!=''&&$_POST['supervisor_id']!=$data->supervisor_id)
		    {
		    	echo 'supervisor_id';
			    $helper->update_supervisor($_POST['supervisor_id']);
			    $helper->update_default_topic_owner();
		    }
		    if(isset($_POST['role'])&&$_POST['role']!=$data->role)
		    {
		    	echo 'role';
		    	$helper->update_role($_POST['role']);//change role to Manager/User
		    	$helper->update_supervisor($user_id);
		    	$helper->update_default_topic_owner();//set the default topic which belonged to this user to null 
		    	$helper->update_privilege();//set the privilege which belonged to this user to null 
		    	$helper->update_subordinate_supervisor();//release the subordinate of this user 
		    	$helper->update_subordinate_default_topic();//set the default topic which belonged to the subordinate of this user to null 
		    }
		    if(isset($_POST['is_active'])&&$_POST['is_active']!=$data->is_active)
		    {
		    	echo 'is_active';
		    	$helper->update_active($_POST['is_active']);
		    }
		    if(isset($_POST['replace'])&&$_POST['replace']!=''&&$_POST['replace']!=$data->user_id)
		    {
		    	echo 'replace';
		    	if($data->role=='Manager')
		    	{
			    	$ticket_user=ORM::factory('ticket_user');
			    	$ticket_user->role='Manager';
			    	$ticket_user->supervisor_id=$_POST['replace'];
			    	$ticket_user->where('user_id','=',$_POST['replace'])->save_all();
			    	$helper->update_privilege($_POST['replace']);
			    	$helper->update_subordinate_supervisor($_POST['replace']);
		    	}
		    	else 
		    	{
		    		$helper->update_supervisor($_POST['replace']);
		    		$ticket_user=ORM::factory('ticket_user');
			    	$ticket_user->supervisor_id=$data->supervisor_id;
			    	$ticket_user->where('user_id','=',$_POST['replace'])->save_all();
		    	}
		    	$helper->update_default_topic_owner($_POST['replace']);
		    	$helper->update_ticket_assign($_POST['replace']);
		    	$helper->update_active(0);
		    }
		    if(isset($_POST['nickname'])&&$_POST['nickname']!=$data->nickname)
		    {
		    	echo 'nickname';
		    	$user=ORM::factory('ticket_user')
		    			->where('user_id','=',$user_id)
		    			->find();
		    	$user->nickname=$_POST['nickname'];
		    	$user->save();	
		    }
		    message::set('Edit user successful!');
            Request::instance()->redirect('/admin/ticket/role/edit/'.$user_id);		    
		}

		$manager_list=orm::factory('ticket_user')
						->where('role','=','Manager')
						->where('is_active','=',1)
						->find_all()
						->as_array('user_id','nickname');
		$user_info=ORM::factory('user')
						->where('id','=',$user_id)
						->find();
		$user_list=orm::factory('ticket_user')
					->where('role','=','User')
					->where('is_active','=',1)
					->find_all();
		$content = View::factory('admin/ticket/role_edit')
			->set('data',$data)
			->set('manager_list',$manager_list)
			->set('user_info',$user_info)
			->set('user_list',$user_list)
            ->render();  
		$this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}
	
	public function action_default_topic()
	{
		$id = $this->request->param('id');
		$data=ORM::factory('ticket_user')
						->where('user_id','=',$id)
						->find();
		if(!$data->loaded())
		{
			message::set('No such user!');
            Request::instance()->redirect('/admin/ticket/manager/list');	 
		}
		if($_POST)
		{
			$data=$_POST;
			$data['user_id']=$id;
			Ticket::instance()->default_topic_update($data);
			message::set('Modified default topic for user successful!');
            Request::instance()->redirect('/admin/ticket/role/default_topic/'.$id);
		}
		$sites=ORM::factory('ticket_site')
				->find_all()
				->as_array('id','domain');
		$lines=ORM::factory('ticket_line')
				->find_all()
				->as_array('id','name');
		$topics=DB::select('id','topic')
					->from('ticket_topics')
					->execute()
					->as_array('id','topic');
		if(Ticket::instance()->get_role_by_userID($id)=='User')
		{
			$data=orm::factory('ticket_user')
							->where('user_id','=',$id)
							->find()
							->as_array();
			$manager=$data['supervisor_id'];
		}
		else 
			$manager=$id;
		$privilege=orm::factory('ticket_privilege')
					->where('user_id','=',$manager)
					->order_by('code')
					->find_all();
		$pvl=array();
		foreach($privilege as $v)
		{
			$pvl[]=$v->code;
		}
		$default=orm::factory('ticket_defaultowner')
				->where('user_id','=',$id)
				->find_all()
				->as_array();
		$d=array();
		foreach($default as $v)
		{
			$d[]=$v->code;
		}
		$content = View::factory('admin/ticket/role_default_topic')
			->set('user_id',$id)
			->set('nickname',Ticket::instance()->get_ticket_user_name($id))
			->set('sites',$sites)
			->set('lines',$lines)
			->set('topics',$topics)
			->set('privilege',$pvl)
			->set('default',$d)
            ->render();  
		$this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}
}