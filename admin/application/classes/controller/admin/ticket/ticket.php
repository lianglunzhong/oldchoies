<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Ticket module of cola end
 *
 * @package   Tickets
 * @author    shi.chen@ketai-inc.com
 * @copyright © 2011 Cofree Development Group
 * @version   SVN: $Id: ticket.php 862 2011-03-28 09:56:39Z shi.chen $
 */

class Controller_Admin_Ticket_Ticket extends Controller_Admin_Ticket
{
	public function action_list()
	{
		$content = View::factory('admin/ticket/ticket_list')
            ->render();       
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}
	public function action_new()
	{
		if($_POST)
		{
			Ticket::instance()->create_ticket($_POST);
			message::set("Ticket created!");
        	$this->request->redirect('admin/ticket/ticket/list?user_id='.Session::instance()->get('user_id'));
		}
		Session::instance()->delete('folderID');
//		$countries=DB::query(Database::SELECT, 'SELECT DISTINCT name, isocode FROM countries ORDER BY name')
//					->execute()
//					->as_array();
		$lines=ticket::instance()->get_ticket_privileged_line();
		$topics=Ticket::instance()->get_ticket_topic();
		$templates=array();
		foreach ($topics as $value)
		{
			$t=DB::select("id","tpl_name")
				->from("ticket_templates")
				->where("is_active","=",1)
				->and_where("topic_id","=",$value['id'])
				->execute()
				->as_array();
			$cate=array();
			$cate['cate']=$value['topic'];
			foreach ($t as $v)
				$cate['tpl'][$v['id']]=$v['tpl_name'];
			$templates[]=$cate;
		}
		$content = View::factory('admin/ticket/ticket_new')
			->set('lines',$lines)
//			->set('countries',$countries)
			->set('topics',$topics)
			->set('templates',$templates)
            ->render();      
		$this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}
	
	public function action_detail()
	{
		$id = $this->request->param('id');
		$data=Ticket::instance()->prepare_data_for_detail($id);
		$messages=Ticket::instance()->prepare_data_for_message($id);
		$attaches=Ticket::instance()->prepare_data_for_attach($id);
		$templates=array();
		$result=Ticket::instance()->get_ticket_topic();
		if($data!=1)
		{
			foreach ($result as $value)
			{
				$t=DB::select("id","tpl_name")
					->from("ticket_templates")
					->where("is_active","=",1)
					->and_where("topic_id","=",$value['id'])
					->execute()
					->as_array();
				$cate=array();
				$cate['cate']=$value['topic'];
				foreach ($t as $v)
					$cate['tpl'][$v['id']]=$v['tpl_name'];
				$templates[]=$cate;
			}
			$topic_id=$data['detail']['topic_id'];
			$topics=Ticket::instance()->get_ticket_topic();
			$topic_customer=ORM::factory("ticket_topic",$topic_id)->for_customer;
			$priority=Kohana::config('ticket.priority');
			$status=Kohana::config('ticket.status');
			$classifications=Kohana::config('ticket.classification');
			$emailnum=DB::query(Database::SELECT, 'select count(id) as num from tickets 
						where email=\''.$data['detail']['email'].'\'')
						->execute()
						->as_array();
			$emailnum=$emailnum[0]['num'];
			$users=ticket::instance()->get_ticket_user_name();
			$countries=DB::query(Database::SELECT, 'SELECT DISTINCT name, isocode FROM countries ORDER BY name')
				->execute()
				->as_array();
			$content = View::factory('admin/ticket/ticket_detail')
			->set('data',$data)
			->set('messages',$messages[0])
			->set('page_view',$messages[1])
			->set('attaches',$attaches)
			->set('templates',$templates)
			->set('topics',$topics)
			->set('priority',$priority)
			->set('status',$status)
			->set('classifications',$classifications)
			->set('emailnum',$emailnum)
			->set('users',$users)
			->set('countries',$countries)
			->set('topic_customer',$topic_customer)
            ->render();      
			$this->request->response = View::factory('admin/template')->set('content',$content)->render();
		}
		else 
		{
			message::set('This ticket doesn\'t exist or has been deleted.');
            Request::instance()->redirect('/admin/ticket/ticket/list');
		}
	}
	
	public function action_search()
	{
		if(isset($_POST['search'])&&$_POST['search']!='')
		{
			$append_sql='';
			if(!empty($_GET))
			{
			$append_sql=' AND ';
			foreach ($_GET as $key=>$value)
			{
				if($key=="status"&&$value=="pending")
				{
					$append_sql.="(t1.status='New' OR t1.status='Overdue') AND ";
				}
				elseif($key=="user_id")
				{
					$append_sql.=("t1.user_id=".$value." AND ");
				}
				else
					$append_sql.=("t1.".$key.'=\''.$value.'\' AND ');
			}
			$append_sql.= 1;
			}
			$data=DB::query(Database::SELECT, 'SELECT t1.ticketID,t1.subject,t2.message,t1.note FROM tickets t1 JOIN ticket_messages t2 
												ON t1.ticketID=t2.ticketID
												WHERE (binary t1.subject like \'%'.$_POST['search'].'%\' 
												OR binary t1.note like \'%'.$_POST['search'].'%\' 
												OR binary t2.message like \'%'.$_POST['search'].'%\' 
												OR binary t1.subject like \'%'.$_POST['search'].'%\')'.$append_sql)
				  									->execute()->as_array();
			$ticketID=array();
			$filter=array();
			foreach($data as $key=>$value)
			{
				if(!in_array($value['ticketID'],$ticketID))
				{
					$ticketID[]=$value['ticketID'];
					foreach($value as $k=>$v)
					{
						if($k!='ticketID'&&count(explode($_POST['search'],$v))>0)
						{
							$str=str_replace($_POST['search'],'<font color="red">'.$_POST['search'].'</font>',$v);
							$data[$key][$k]=$str;
						}
					}
					$filter[]=$data[$key];
				}
			}
			$content = View::factory('admin/ticket/ticket_search')
			->set('data',$filter)
            ->render();      
			$this->request->response = View::factory('admin/template')->set('content',$content)->render();
			
		}
		else
		{
			Message::set("Please enter the keyword!");
			$ref=$_SERVER['HTTP_REFERER'];
			$urls=parse_url($ref);
			$append=isset($urls['query'])?"?".$urls['query']:"";
			$this->request->redirect('admin/ticket/ticket/list/'.$append);
		}
	}
	
	public function action_edit()
	{
		if($_POST)
		{
			$ticket=Ticket::instance()->get_details_by_ticketID($_POST['ticketID']);
			if($ticket[0]['user_id']!=$_POST['user_id'])
				$redirect_url='admin/ticket/ticket/list?user_id='.Session::instance()->get('user_id');
			else
				$redirect_url='admin/ticket/ticket/detail/'.$_POST['ticketID'];
			$_POST['updated']=time();
			Ticket::instance()->edit_ticket($_POST);
			Message::set("Ticket Edit Successful.");
			$this->request->redirect($redirect_url);
		}
	}
	
	public function action_addmessage()
	{
		if($_POST)
		{
			Ticket::instance()->add_message($_POST['ticketID'],$_POST['content']);
			Message::set("Reply Successful.");
			Request::instance()->redirect('/admin/ticket/ticket/detail/'.$_POST['ticketID']);
		}
	}
	
	public function action_addnote()
	{
		if($_POST)
		{
			Ticket::instance()->add_note($_POST['ticketID'],$_POST['content']);
			Message::set("Add note Successful.");
			Request::instance()->redirect('/admin/ticket/ticket/detail/'.$_POST['ticketID']);
		}
	}
	
	public function action_data()
	{
		//TODO fixed the post
		$page = Arr::get($_REQUEST, 'page', 0); // get the requested page
		$limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
		$sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
		$sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
		$append_sql='';
		if(!empty($_GET))
		{
			$append_sql=' AND ';
			foreach ($_GET as $key=>$value)
			{
				if($key=="status"&&$value=="pending")
				{
					$append_sql.="(status='New' OR status='Overdue') AND ";
				}
				elseif($key=="user_id")
				{
					$append_sql.=("user_id=".$value." AND ");
				}
				else
					$append_sql.=($key.'=\''.$value.'\' AND ');
			}
			$append_sql.= 1;
		}
		//filter
		$filters = Arr::get($_REQUEST, 'filters', array( ));

		if($filters)
		{
			$filters = json_decode($filters);
		}

		if( ! $sidx) $sidx = 1;

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

		if($totalrows) $limit = $totalrows;

		$filter_sql = "1";
		if($filters)
		{
			foreach( $filters->rules as $item )
			{
				//TODO add filter items
				if($item->field == 'created'||$item->field == 'updated')
				{
					$date = explode(' to ', $item->data);
					$count = count($date);
					$from = strtotime($date[0]);
					if($count == 1)
					{
						$to = strtotime($date[0].' +1 day -1 second');
					}
					else
					{
						$to = strtotime($date[1].' +1 day -1 second');
					}
					$_filter_sql[] = $item->field." between ".$from." and ".$to;
				}
				else if($item->field == 'user_id')
				{
					if($item->data=="Not Assign")
					{
						$_filter_sql[]="user_id=0";
					}
					else 
					{
						$result=DB::select('user_id')
								->from('ticket_users')
								->where('nickname','=',$item->data)
								->execute();
						if(!empty($result))
						{
							foreach ($result as $value)
								$sql[]="user_id='".$value['user_id']."'";
							if(isset($sql))
								$_filter_sql[]='('.implode(' OR ', $sql).')';
						}
					}

				}
				else
				{
					$_filter_sql[] = $item->field."='".$item->data."'";
				}
			}
			if( ! empty($_filter_sql)) $filter_sql = implode(' AND ', $_filter_sql);
		}
		$active=isset($_GET['is_active'])?'':' AND is_active=1 ';
		$result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`tickets`.`id`) AS num FROM `tickets` WHERE '
				.$filter_sql.$append_sql.$active)->execute();
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
		$result = DB::query(DATABASE::SELECT, 'SELECT `tickets`.* FROM `tickets` WHERE '
				.$filter_sql.$append_sql.$active.' ORDER BY istop DESC,'.$sidx.' '.$sord.' LIMIT '.$limit.' OFFSET '.$start)->execute();
		$response = array();
		$response['page'] = $page;
		$response['total'] = $total_pages;
		$response['records'] = $count;
		$ticketinfo=Ticket::instance();
		$users=$ticketinfo->get_ticket_user_name();
		$topices=$ticketinfo->get_ticket_topic('',false);
		$sites=$ticketinfo->get_ticket_site_name('',false);
		$lines=ticket::instance()->get_ticket_line_name();
		$user=array();
		$topic=array();
		$site=array();
		$line=array();
		$priority=Kohana::config('ticket.priority');
		foreach ($users as $value)
			$user[$value['user_id']]=$value['nickname'];
		foreach ($topices as $value)
			$topic[$value['id']]=$value['topic'];
		foreach ($sites as $value)
			$site[$value['id']]=$value['domain'];
		foreach ($lines as $value)
			$line[$value['id']]=$value['name'];
		foreach( $result as $value )
		{
			//$this->iconv_array($value);
			$response['rows'][] = array(
				'id' => $value['id'],
				'cell' => array(
					$value['user_id']=='0'?'Not Assign':(isset($user[$value['user_id']])?$user[$value['user_id']]:$value['user_id']),
					isset($line[$value['line_id']])?$line[$value['line_id']]:$value['line_id'],
					isset($site[$value['site_id']])?str_replace('www.', '', $site[$value['site_id']]):$value['site_id'],
					$value['ticketID'],
					$value['email'],
					isset($topic[$value['topic_id']])?$topic[$value['topic_id']]:$topic['topic_id'],
					$value['subject'],
					$value['classification'],
					$priority[$value['priority_id']]['status'],
					$value['status'],
					date('Y-m-d H:i', $value['updated']),
					'<label title="'.preg_replace('/\[2.*?-.*?\]/is',' ',str_ireplace("\n"," ",str_ireplace("\r\n"," ",(strip_tags($value['note'],""))))).'">'.preg_replace('/\[2.*?-.*?\]/is',' ',str_ireplace("\n"," ",str_ireplace("\r\n"," ",(strip_tags($value['note'],""))))).'</label>',
					$value['istop']
				)
			);
		}
    	echo json_encode($response);
	}
	
	public function action_active()
	{
		if(isset($_POST['inactive']))
		{
			Ticket::instance()->inactive_ticket($_POST['ticketID']);
			Message::set("Make Ticket inactive Successful.");
			Request::instance()->redirect('/admin/ticket/ticket/detail/'.$_POST['ticketID']);
		}
		elseif (isset($_POST['reactive']))
		{
			Ticket::instance()->reactive_ticket($_POST['ticketID']);
			Message::set("Activate Ticket Successful.");
			Request::instance()->redirect('/admin/ticket/ticket/detail/'.$_POST['ticketID']);
		}
	}

	public function action_delete()
	{
		Ticket::instance()->delete_ticket($_POST['ticketID']);
		Message::set("Delete Ticket Successful.");
		Request::instance()->redirect('/admin/ticket/ticket/list?is_active=0');
	}
		
	public function action_upload_file()
	{
		if(Ticket::instance()->move_attachment_2_temp())
			echo htmlspecialchars(json_encode(array('success'=>true)), ENT_NOQUOTES);
	}
	
	/*Ajax get template content*/
	public function action_get_template()
	{
		$id = $this->request->param('id');
		$content=Ticket::instance()->get_template($id);
		echo $content;
	}
	
	public function action_set_overdue()
	{
		if(isset($_POST['overdue']))
		{
			$time=time()-Kohana::config('ticket.overdue')*60*60;
			DB::query(Database::UPDATE, "UPDATE tickets SET tickets.status='Overdue' 
										WHERE updated <= ".$time." 
										AND (tickets.status='Answered' Or tickets.status='Open')")
					->execute();
			Message::set("Set the status successfully");
			Request::instance()->redirect("/admin/ticket/ticket/list");
		}
	}
	
	public function action_bulk_upload()
	{
		if($_POST)
		{
			if(($message=Ticket::instance()->bulk_upload())!="")
			{
				Message::set($message,"error");
				Request::instance()->redirect('/admin/ticket/ticket/bulk_upload');
			}
			else 
			{
				Message::set("Bulk upload tickets successfully");
				Request::instance()->redirect('/admin/ticket/ticket/list');
			}
		}
		$content = View::factory('admin/ticket/bulk_upload')
            ->render();       
        $this->request->response = View::factory('admin/template')->set('content',$content)->render();
	}
	
	/**
	 * Ajax get site information by line ID
	 *
	 * @param  <string> $id
	 * @return  <string>
	 */
	public function action_get_site($id)
	{
		$sites=orm::factory('ticket_site')
				->where('line_id','=',$id)
				->where('is_active','=','1')
				->find_all();
		$str='';
		if(!empty($sites))
		{
			if(isset($_GET['q']))
				$str='<option value="all">Select All Site</option>';
			else 
				$str='<option value="">Select a Site</option>';
			foreach($sites as $site)
			{
				$str.='<option value="'.$site->id.'">'.$site->domain.'</option>';
			}
		}
		echo $str;
		return;
	}
	
	public function action_get_site_by_privilege($id)
	{
		if(Session::instance()->get('ticket_role')=="Admin")
		{
			$this->action_get_site($id);
			return;
		}
		$sites=orm::factory('ticket_site')
				->where('line_id','=',$id)
				->where('is_active','=','1')
				->find_all();
		$site=array();
		foreach ($sites as $value)
			$site[$value->id]=$value->domain;
		if (Session::instance()->get('ticket_role')=="Manager")
		{
			$privilege=orm::factory('ticket_privilege')
						->where('code','like',$id.'-%')
						->where('user_id','=',Session::instance()->get('user_id'))
						->find_all();
		}
		else
		{
			$privilege=orm::factory('ticket_defaultowner')
						->where('code','like',$id.'-%')
						->where('user_id','=',Session::instance()->get('user_id'))
						->find_all();
		}
		$s=array();
		foreach ($privilege as $value)
		{
			$value=explode("-",$value->code);
			if($id==$value[0]&&isset($site[$value[1]]))
				$s[$value[1]]=$site[$value[1]];
		}
		$str='';
		foreach($s as $key=>$value)
			{
				$str.='<option value="'.$key.'">'.$value.'</option>';
			}
		echo $str;
		return;
	}
}