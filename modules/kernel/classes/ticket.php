<?php
defined('SYSPATH') or die('No direct script access.');
class Ticket
{
    private static $instances;
    private $data;
    private $site_id;
    private $id;

    public static function & instance($id = 0)
    {
        if( ! isset(self::$instances[$id]))
        {
            $class = __CLASS__;
            self::$instances[$id] = new $class($id);
        }
        return self::$instances[$id];
    }

    public function __construct($id)
    {
        $this->id = $id;
        $this->site_id = Site::instance()->get('id');
        $this->data = NULL;
        $this->_load($id);
    }
    
    public function _load($id)
    {
        if( ! $id)
        {
            return FALSE;
        }

        $result = DB::select()->from('tickets')
            ->where('id', '=', $id)
            ->execute()->current();

        $this->data = $result;
    }
    
	public function get($key = NULL)
    {
        if(empty($key))
        {
            return $this->data;
        }
        return isset($this->data[$key]) ? $this->data[$key] : '';
    }
    
    /* Helper used to create a new ticket*/
    public function create_ticket($ticket)
    {
    	$post_value=implode('',$ticket);
    	if(Session::instance()->get('submit_value','')==md5($post_value))
    		return;
    	else 
    		Session::instance()->set('submit_value', md5($post_value));
    	$ticket=Security::xss_clean($ticket);
    	$ticket["email"]=trim($ticket["email"]);
    	$priority=DB::select('priority_id')
    	->from('ticket_topics')
    	->where('id','=',$ticket['topic_id'])
    	->execute()
    	->as_array();
    	$user_id=isset($_SESSION['user_id'])?$_SESSION['user_id']:'';
    	$data=$ticket;
    	$data['ticketID']=$this->create_ticketID($ticket['site_id']);
    	$data['line_id']=ORM::factory("ticket_site",$ticket['site_id'])->line_id;
    	$data['priority_id']=$priority[0]['priority_id'];
    	if(!isset($_SESSION['user_id']))
    		$data['ip_address']=sprintf("%u", ip2long(Request::$client_ip));
    	$data['status']=isset($_SESSION['user_id'])?'Open':'New';
    	$data['created']=time();
    	$data['updated']=time();
    	unset($data['content']);
    	unset($data['file']);
	    DB::insert('tickets', array_keys($data))
	        ->values(array_values($data))
	        ->execute();
        $this->add_message($data['ticketID'],$ticket['content'],false);
        $this->assign_ticket($data['ticketID'],$user_id);
        if($user_id=="")
			$this->ticket_sendmail('TICKET_CREATE',$data['ticketID']);
		else
			$this->ticket_sendmail('TICKET_OPEN',$data['ticketID']); 
    }
    
    public function inactive_ticket($ticketID)
    {
    	DB::update('tickets')
    		->set(array('is_active'=>0))
    		->where('ticketID','=',$ticketID)
    		->execute();
    }
    
    public function reactive_ticket($ticketID)
    {
    	DB::update('tickets')
    		->set(array('is_active'=>1))
    		->where('ticketID','=',$ticketID)
    		->execute();
    }
    
    public function delete_ticket($ticketID)
    {
    	//delete data in database
    	$tables=DB::select('TABLE_NAME')->from('information_schema.COLUMNS')
            		->where('COLUMN_NAME','=','ticketID')
            		->execute();
        if(!empty($tables))
        {
            foreach ($tables as $table)
            {
            	try {
            		DB::delete(Arr::get($table,'TABLE_NAME',''))->where('ticketID','=',$ticketID)->execute();	            				
            	} catch (Exception $e) {
            	}							
            }
        }
        //delete attachment
        $path=Kohana::config('ticket.attachment.path').'/'.$ticketID;
        if(is_dir($path))
        	$this->deldir($path);
    }
    
    
	function deldir($dir) 
	{
		$dh=opendir($dir);
		while ($file=readdir($dh))
		{
			if($file!="." && $file!="..")
			{
			    $fullpath=$dir."/".$file;
			    if(!is_dir($fullpath))
			    {
			    	unlink($fullpath);
			    }
			    else
			    {
			    	$this->deldir($fullpath);
			    }
		    }
		}
		closedir($dh);
		try {
			if(rmdir($dir))
			{
				return true;
			}
			else
			{
				return false;
			}
		} catch (Exception $e) {
		}
	}
    /* Helper admin and customer to add message
     * @$flag when it's create ticket, $flag=false, when reply true.
     * 
     */
    public function add_message($ticketID,$content,$flag=true)
    {
    	$data=array(
        	'ticketID'=>$ticketID,
        	'message'=>$content,
        	'ip_address'=>sprintf("%u", ip2long(Request::$client_ip)),
        	'created'=>time(),
        	'updated'=>time(),
        	'user_id'=>isset($_SESSION['user_id'])?$_SESSION['user_id']:''
        );
    	$message=Security::xss_clean($data);
    	if($flag)
    	{
    		$update_data['updated']=time();
    		$update_data['status']=isset($_SESSION['user_id'])?'Answered':'New';
    		if(!isset($_SESSION['user_id']))
    			$update_data['ip_address']=sprintf("%u", ip2long(Request::$client_ip));
    		DB::update('tickets')
        	->set($update_data)
        	->where('ticketID','=',$ticketID)
        	->execute();
        	if(isset($_SESSION['user_id']))
        		$this->ticket_sendmail('TICKET_UPDATED',$data['ticketID']);
    	}
    	$cd=DB::insert('ticket_messages', array_keys($message))
        ->values(array_values($message))
        ->execute();
        $message_id=$cd[0];
       	if(Session::instance()->get('folderID')!=null)
       		$this->add_attachment($ticketID,$message_id);
    } 
    
    /* Admin add note for each ticket*/
    public function add_note($ticketID,$content)
    {
    	$note=DB::select('note')
    				->from('tickets')
    				->where('ticketID','=',$ticketID)
    				->execute()
    				->as_array();    	
    	$content=Security::xss_clean($content);
    	$time='['.date('Y-m-d H:i', time()).']';
		$note=$time.$content.'&nbsp;&nbsp;&nbsp;'.$note[0]['note'];
    	DB::update('tickets')
    		->set(array('note'=>$note))
    		->where('ticketID','=',$ticketID)
    		->execute();
    }
    
    /*save attachment to temp folder before user submite all form*/
    public function move_attachment_2_temp()
    {
    	if((isset($_GET['qqfile']) || isset($_FILES['qqfile']))&&Session::instance()->get('folderID',0)==0)
    	{
	       Session::instance()->set('folderID',date('Ymd').'/'.Text::random('alnum', 8));
	       $fulldir=Kohana::config('ticket.attachment.tempath').'/'.Session::instance()->get('folderID',null);
	       if(!is_dir($fulldir))
	        	mkdir($fulldir,0777,true);  
    	}
    	if(isset($_GET['qqfile']))
        {
	    	$filename=$_GET['qqfile'];
	        $input = fopen("php://input", "r");
	        $temp = tmpfile();
	        $realsize = stream_copy_to_stream($input, $temp);
	        fclose($input);  
	        $target = fopen($fulldir.'/'.$filename, "w");
	        fseek($temp, 0, SEEK_SET);
	        stream_copy_to_stream($temp, $target);
	        fclose($target);
	        return true;
        }
        elseif(isset($_FILES['qqfile'])) 
        {
        	if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $fulldir.'/'.$_FILES['qqfile']['name'])){
                return false;
            }
            return true;
        }
    	
//    	
//    	$filename=$_GET['qqfile'];
//        $input = fopen("php://input", "r");
//        $temp = tmpfile();
//        $realsize = stream_copy_to_stream($input, $temp);
//        fclose($input);        
//        if ($realsize != (int)$_SERVER["CONTENT_LENGTH"]){
//            return false;
//        }
//        if(Session::instance()->get('folderID')==null)
//        {
//        	Session::instance()->set('folderID',date('Ymd').'/'.Text::random('alnum', 8));
//        }
//        $tempath=Kohana::config('ticket.attachment.tempath');
//        $fulldir=$tempath.'/'.Session::instance()->get('folderID',null);
//        if(!is_dir($fulldir))
//        mkdir($fulldir,0777,true);    
//        $target = fopen($fulldir.'/'.$filename, "w");
//        fseek($temp, 0, SEEK_SET);
//        stream_copy_to_stream($temp, $target);
//        fclose($target);
//        return true;
    }
    
    /*save temp folder after user submite all form*/
    public function add_attachment($ticketID,$message_id)
    {
    	$fulldir=Kohana::config('ticket.attachment.tempath').'/'.Session::instance()->get('folderID',null);
    	$attachment=array(
    				'ticketID'=>$ticketID,
    				'ticket_message_id'=>$message_id
    	); 
    	$path=Kohana::config('ticket.attachment.path').'/'.$ticketID.'/'.$message_id;
    	if ($handle = opendir($fulldir)){   
			while (false !== ($file = readdir($handle)))  
			{
				if($file!="." && $file!=".."&&$file!='Thumbs.db')
				{
					$attachment['attach_name']=$file;
					$attachment['attach_size']=filesize($fulldir.'/'.$file);
					DB::insert('ticket_attaches', array_keys($attachment))
			        ->values(array_values($attachment))
			        ->execute();
			        if(!is_dir($path))
       	 				mkdir($path,0777,true); 
       	 			rename($fulldir.'/'.$file,$path.'/'.$file);
       	 			try {
       	 				unlink($fulldir.'/'.$file);
       	 			} catch (Exception $e) {
       	 			}       	 			
				}			
			}		
    	}
    	closedir($handle);
    	try {
			rmdir($fulldir);
		} catch (Exception $e) {
		}	
    	Session::instance()->delete('folderID');
    }
        
    public function assign_ticket($ticketID,$user_id='')
    {
    	if($user_id=='')
    	{
    		$ticket=ORM::factory('ticket')
    					->where('ticketID','=',$ticketID)
    					->find();
    		$code=$ticket->line_id.'-'.$ticket->site_id.'-'.$ticket->topic_id;
    		$default=ORM::factory('ticket_defaultowner')
    					->where('code','=',$code)
    					->find_all();
    		$user_list=array();
    		foreach ($default as $value)
				$user_list[]= $value->user_id;
			if(!empty($user_list))
			{
				DB::update('tickets')
	    		->set(array('user_id'=>$user_list[rand(0,count($user_list)-1)]))
	    		->where('ticketID','=',$ticketID)
	    		->execute();
			}
			else
			{
				$default=ORM::factory('ticket_privilege')
    					->where('code','=',$code)
    					->find_all();
    			$user_list=array();
    			foreach ($default as $value)
					$user_list[]= $value->user_id;
				if(!empty($user_list))
				{
					DB::update('tickets')
		    		->set(array('user_id'=>$user_list[rand(0,count($user_list)-1)]))
		    		->where('ticketID','=',$ticketID)
		    		->execute();
				}
				else 
				{
					return;
				}
			}		
    	}
    	else
    	{
    		DB::update('tickets')
    		->set(array('user_id'=>$user_id))
    		->where('ticketID','=',$ticketID)
    		->execute();
    	}
    }
    
    /*Prepare data of ticket detail page for both customer and our stuff*/
	public function prepare_data_for_detail($id,$email='')
	{
		$data=array();
		$tickethelper=Ticket::instance();
		$details=$tickethelper->get_details_by_ticketID($id,$email);
		if($details!=1)
		{
			$data['site']=$tickethelper->get_ticket_site_name($details[0]['site_id']);
			$data['topic']=$tickethelper->get_ticket_topic($details[0]['topic_id']);
			if($details[0]['user_id']!='0')
				$data['nickname']=$tickethelper->get_ticket_user_name($details[0]['user_id']);
			else 
				$data['nickname']="Not Assign Yet";
			$data['detail']=$details[0];
			return $data;
		}
		else
			return 1;
	}
	
	public function prepare_data_for_message($id)
	{
		$count=DB::query(Database::SELECT, 'select count(user_id) as num from ticket_messages
					where ticketID='.$id)
					->execute();
		$count=$count[0]['num'];			
		$pagination = Pagination::factory(
            array(
                'current_page' => array( 'source' => 'query_string' , 'key' => 'page'),
                'total_items' => $count,
                'items_per_page' => 10,
                'view' => 'pagination/basic',
                'auto_hide' => 'FALSE',
            )
        );
        $page_view = $pagination->render();
		$messages=DB::select('message','created','user_id','id')
					->from('ticket_messages')
					->where('ticketID','=',$id)
					->order_by('created','DESC')
					->limit($pagination->items_per_page)
            		->offset($pagination->offset)
					->execute()
					->as_array();
		return array(empty($messages) ? 1 : $messages,$page_view);
	}  
    
	public function prepare_data_for_attach($id)
	{
		$attaches=DB::select('ticket_message_id','attach_name','attach_size')
					->from('ticket_attaches')
					->where('ticketID','=',$id)
					->execute()
					->as_array();
		return $attaches;
	}
	
    /* Helper used to generate ticket IDs */
    public function create_ticketID($site_id=1)
    {
        // year(2)+month(2)+day(2)
    	$tiecktID = date('ymd', time());
        // line id(2)
        $line_id = ORM::factory("ticket_site",$site_id)->line_id;
        $tiecktID.= str_pad($line_id, 2, "0", STR_PAD_LEFT);
        // site id(2)
        $tiecktID.= str_pad($site_id, 2, "0", STR_PAD_LEFT);
        // rand number(4)
        $len = Kohana::config('ticket.ticket_randnumber');
    	mt_srand ((double) microtime() * 1000000);
        $start = str_pad(1, $len, "0", STR_PAD_RIGHT);
        $end   = str_pad(9, $len, "9", STR_PAD_RIGHT);
        $tiecktID.= mt_rand($start, $end);
        $arr=DB::select()
        ->from('tickets')
        ->where('ticketID','=',$tiecktID)
        ->execute()
		->as_array();
        if(empty($arr))
        	return $tiecktID; 
        else        
           	$this->create_ticketID($site_id);	
    }
    
    public function get_template($id='')
    {
    	$sql=$id==''?1:'id='.$id.'';
    	$result=DB::query(DATABASE::SELECT,'select id,tpl_name,tpl_content from ticket_templates where '.$sql)
    	->execute()
    	->as_array();
    	if($id=='')
        	return $result;
        else
        	return empty($result) ? '' : $result[0]['tpl_content'];
    }
    
    public function get_ticket_user_name($id='')    
    {
    	$sql=$id==''?1:'user_id='.$id.'';
    	$result=DB::query(DATABASE::SELECT,'select user_id,nickname from ticket_users where '.$sql)
    	->execute()
    	->as_array();
    	if($id=='')
        	return $result;
        else if(empty($result))
        	return 1; 
        else 
        	return $result[0]['nickname'];
    }
    
    public function get_user_names_by_privilege()
    {
    	$arr_user=array();
		if(Session::instance()->get("ticket_role")=="Admin")
		{
			$users=ORM::factory("ticket_user")
					->where('is_active','=',1)
					->find_all();
			foreach ($users as $value)
				$arr_user[$value->user_id]=USER::instance($value->user_id)->get("name");
		}
		elseif (Session::instance()->get("ticket_role")=="Manager")
		{
			$users=ORM::factory("ticket_user")
					->where('is_active','=',1)
					->where("supervisor_id","=",Session::instance()->get("user_id"))
					->find_all();
			foreach ($users as $value)
				$arr_user[$value->user_id]=USER::instance($value->user_id)->get("name");
		}
		else 
			$arr_user[Session::instance()->get("user_id")]=USER::instance(Session::instance()->get("user_id"))->get("name");
		return $arr_user;
    }
    
    public function get_ticket_topic($id='',$active=true)    
    {	
    	$sql=$id==''?1:'id='.$id.'';
    	if($active)
    		$sql_active="is_active=1";
    	else 
    		$sql_active=1;  
    	$result=DB::query(DATABASE::SELECT,'select id,topic,for_customer from ticket_topics where '.$sql_active.' and '.$sql)
    	->execute()
    	->as_array();
         if($id=='')
        	return $result;
        else
        	return empty($result) ? 1 : $result[0]['topic'];
    }
    
    public function get_ticket_line_name($id='')
    {
    	$sql=$id==''?1:'id='.$id.'';
    	$result=DB::query(Database::SELECT, 'select id,name from `ticket_lines` where is_active=1 and '.$sql)
		->execute()
		->as_array();
		if($id=='')
        	return $result;
        else
        	return empty($result) ? 1 : $result[0]['topic'];
    }
    
    public function get_ticket_site_by_domain($domain)
    {
    	$sql=$domain==''?1:'domain=\''.$domain.'\'';
    	$result=DB::query(DATABASE::SELECT,'select id,domain from ticket_sites where is_active=1 and '.$sql)
    	->execute()
    	->as_array();
    	 if($domain=='')
        	return $result;
        else
        	return empty($result) ? '' : $result[0]['id'];
    }
    
    public function get_ticket_site_name($id='',$active=true)    
    {
    	$sql=$id==''?1:'id='.$id.'';
    	if($active)
    		$sql_active="is_active=1";
    	else 
    		$sql_active=1;    	
    	$result=DB::query(DATABASE::SELECT,'select id,domain from ticket_sites where '.$sql_active.' and '.$sql.' order by domain')
    	->execute()
    	->as_array();
        if($id=='')
        	return $result;
        else
        	return empty($result) ? 1 : $result[0]['domain'];
    }
    
 	public function get_ticket_status()    
    {
    	$result = DB::query(DATABASE::SELECT,'select DISTINCT status from tickets')
    				->execute()
    				->as_array();
        return empty($result) ? 1 : $result;
    }
    
    public function get_ticket_number($sql=array())
    {
    	if(empty($sql))
    		$str=1;
    	else 
    		$str=implode(" AND ",$sql);
    	$result=DB::query(DATABASE::SELECT,'select count(id) as num from tickets where '.$str)
    	->execute();
    	return $result[0]['num'];
    }
    
    public function get_details_by_ticketID($ticketID,$email='')
    {
    	$sql=$email==''?'ticketID=\''.$ticketID.'\'':'ticketID=\''.$ticketID.'\' and email=\''.$email.'\'';
    	$result = array();
    	$result =DB::query(DATABASE::SELECT, 'select * from tickets where '.$sql)
	            ->execute()
	            ->as_array();
         return empty($result) ? 1 : $result;
    }
    
    // Get ticket list by customer email
    public function get_tickets_by_email($orderby, $sort, $site_id, $email, $status='new')
    {
    	$count = ORM::factory('ticket')
    		->and_where('status', '=', $status)
            ->and_where('email' , '=' , $email)            
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
        $data = DB::select('t.id', 't.ticketID', 't.email', 't.subject', 't.status', 't.created', 'talk.talk', 'attach.attach_name')
        	->from(array('tickets', 't'))
        	->join(array('ticket_topics', 'talk'), 'left')
        	->on('t.talk_id', '=', 'talk.id')
        	->join(array('ticket_attaches', 'attach'), 'left')
        	->on('t.id', '=', 'attach.ticket_id')
        	->where('t.email', '=', $email)
        	->and_where('t.status', '=', $status)
        	->group_by('t.ticketID')
        	->order_by('t.'.$orderby , $sort)
        	->limit($pagination->items_per_page)
            ->offset($pagination->offset)/*->find_all()*/
            ->execute()
            ->as_array();
        	//print_r($data);exit;
        return array($count, $data, $page_view);
    }
    
    // edit the ticket info
    public function edit_ticket($data)
    {
    	if(isset($data['sendmail']))
    	{
    		$is_sendmail=$data['sendmail'];
    		unset($data['sendmail']);
    	}
    	$data=Security::xss_clean($data);
    	$data["email"]=trim($data["email"]);
    	if(isset($data['istop']))
    		$data['istop']=1;
    	else 
    		$data['istop']=0;
    	$id=$data['ticketID'];    	
    	$updated = DB::update('tickets')
	    	->set($data)
	    	->where('ticketID', '=', $id)
	    	->execute();
	    if($data['status']=='Closed'&&isset($is_sendmail))
	    {
	    	$this->ticket_sendmail('TICKET_RESOLVED', $id);
	    }
	   	return $updated;
    }
    
    public function get_ticket_center_by_site_id($id)
    {
    	$site=ORM::factory("ticket_site",$id)->ticket_center; 	
    	return $site!=""?$site:Kohana::config('ticket.domain');
    }
    
    public function ticket_sendmail($type,$ticketID)
    {
    	$data=$this->get_details_by_ticketID($ticketID);
    	$data=$data[0];
    	$mail_params['name']=$data['first_name'].' '.$data['last_name'];
    	$mail_params['firstname']=$data['first_name'];
    	$mail_params['email']=$data['email'];
    	$mail_params['phone']=$data['phone'].'-'.$data['phone_ext'];
    	$mail_params['order_num']=$data['order_no'];
    	$mail_params['topic']=$this->get_ticket_topic($data['topic_id']);
    	$mail_params['subject']=$data['subject'];
    	$mail_params['ticketID']=$data['ticketID'];
    	$mail_params['site_domain']=$this->get_ticket_site_name($data['site_id']);
    	$mail_params['ticket_link']=$this->get_ticket_center_by_site_id($data['site_id']).'/ticket/detail?e='.$data['email'].'&&t='.$data['ticketID'];
    	$mail_params['rate_link']=$this->get_ticket_center_by_site_id($data['site_id']).'/rate/rate_us?id='.$data['ticketID'];
    	$from=orm::factory("ticket_site",$data['site_id']);
    	if($from->loaded())
    	{
    		$from=$from->as_array();
    		$from=$from['ticket_email'];
    		if($from=='')
    			$from='customerservice@tickets-service.com';
    	}
    	else 
    		$from='customerservice@tickets-service.com';
        Mail::SendTemplateMail($type, $data['email'], $mail_params,$from,false,true);	
    }
    
    public function get_nickname_by_userID($id)
    {
    	$nickname=orm::factory('ticket_user')
	    		->where('user_id','=',$id)
	    		->find()
	    		->nickname;
	   	return $nickname;
    }
    
    public function get_role_by_userID($id)
    {
    	return orm::factory('ticket_user')
    			->where('user_id','=',$id)
    			->find()
    			->role;
    }
    
    public function get_subordinate_by_managerID($id)
    {
    	$subordinates=orm::factory('ticket_user')
	    		->where('supervisor_id','=',$id)
	    		->where('is_active','=',1)
	    		->find_all();
	    return $subordinates;
    }
    
    public function get_supervisor($id)
    {
    	$supervisor=orm::factory('ticket_user')
			    		->where('user_id','=',$id)
			    		->where('is_active','=',1)
			    		->find()
			    		->as_array();
		return $supervisor['supervisor_id'];
    }
    
    public function default_topic_update($data)
    {
    	orm::factory('ticket_defaultowner')
    	 ->where('user_id','=',$data['user_id'])
    	 ->delete_all();
    	$value['user_id']=$data['user_id'];
    	if(!empty($data['code']))
    	{
	       	foreach($data['code'] as $v)
	    	{
	    	 	$value['code']=$v;
	    	 	$t=ORM::factory('ticket_defaultowner')->values($value);
	    	 	if($t->check())
	            {
	            	$t->save();
	            }
	    	}
    	}
    }
    
    public function line_update($data)
    {
    	$data=Security::xss_clean($data);
    	if($data['id']!="")
    	{
    		$t=ORM::factory('ticket_line')->where("id","=",$data['id'])->find();
    		unset($data['id']);
    		$t->values($data);
    		if($t->check())
    		{
    			$t->save();
    			Message::set("Edit line successfully");
    		}
    	}
    	else
    	{
    		$t=ORM::factory('ticket_line');
    		$t->values($data);
    		if($t->check())
    		{
    			$t->save();
    			Message::set("Add line successfully");
    		}
    	}
    }
    
    
    public function blacklist_update($data)
    {
    	$data=Security::xss_clean($data);
    	if($data['id']!="")
    	{
    		$t=ORM::factory('ticket_blacklist')
    				->where('domain','=',$data['domain'])
    				->where('id','<>',$data['id'])
    				->find();
    		if($t->loaded())
    		{
    			Message::set("This have been added before.");
    			return false;
    		}
    		$t=ORM::factory('ticket_blacklist',$data['id']);
    		unset($data['id']);
    		$t->values($data);
    		if($t->check())
    		{
       			$t->save();
    			Message::set("Edit site successfully");
    		}
    	}
    	else
    	{
    	   $t=ORM::factory('ticket_blacklist')
    				->where('domain','=',$data['domain'])
    				->find();
    		if($t->loaded())
    		{
    			Message::set("This have been added before.");
    			return false;
    		}
    		$t=ORM::factory('ticket_blacklist');
    		$t->values($data);
    		if($t->check())
    		{
    			$t->save();
    			Message::set("Add site successfully");
    		}
    	}
    }
    
    public function site_update($data)
    {
    	$data=Security::xss_clean($data);
    	if($data['id']!="")
    	{
    		$t=ORM::factory('ticket_site')->where("id","=",$data['id'])->find();
    		unset($data['id']);
    		$t->values($data);
    		if($t->check())
    		{
       			$t->save();
    			Message::set("Edit site successfully");
    		}
    	}
    	else
    	{
    		$t=ORM::factory('ticket_site');
    		$t->values($data);
    		if($t->check())
    		{
    			$t->save();
    			Message::set("Add site successfully");
    		}
    	}
    }
    
//    public function get_ticket_count_by_role($role)
//    {
//    	$count=array();
//    	$id=Session::instance()->get("user_id");
//    	switch ($role)
//    	{
//    		case 'User':
//    			$i=DB::query(Database::SELECT, "SELECT COUNT(`tickets`.`id`) AS num FROM `tickets` WHERE `status`='New' AND `user_id`=".$id)->execute()->as_array();
//    			$count["new"]=$i[0]['num'];
//    			$i=DB::query(Database::SELECT, "SELECT COUNT(`tickets`.`id`) AS num FROM `tickets` WHERE `status`='Overdue' AND `user_id`=".$id)->execute()->as_array();
//    			$count["overdue"]=$i[0]['num'];
//    			$i=DB::query(Database::SELECT, "SELECT COUNT(`tickets`.`id`) AS num FROM `tickets` WHERE `status`='Answered' AND `user_id`=".$id)->execute()->as_array();
//    	}
//    }
    
    public function privilege_update($data)
    {
    	$original=orm::factory('ticket_privilege')
					->where('user_id','=',$data['user_id'])
					->find_all();
		$org_code=array();
		foreach ($original as $v)
			$org_code[]=$v->code;
		$topics=Ticket::instance()->get_ticket_topic();
    	if($data['line']=='all')
    	{
    		//If select all lines, delete all privilege for this user first
    		$lines=ticket::instance()->get_ticket_line_name();
    		orm::factory('ticket_privilege')
			    	 ->where('user_id','=',$data['user_id'])
			    	 ->delete_all();
	    	foreach($lines as $line)
	    	{
	    		$sites=orm::factory('ticket_site')
	    				->where('line_id','=',$line['id'])
	    				->find_all();
	    		foreach($sites as $site)
	    		{
	    			foreach($topics as $topic)
	    				$data['code'][]=$line['id'].'-'.$site->id.'-'.$topic['id'];
	    		}
	    	}
    	}
    	elseif($data['site']=='all')
    	{
    			//if select all sites of a line, delete all the privilege of this line of this user first 
    		orm::factory('ticket_privilege')
			    	->where('user_id','=',$data['user_id'])
			    	->where('code','like',$data['line'].'-%')
			    	->delete_all();
    		$sites=orm::factory('ticket_site')
	    				->where('line_id','=',$data['line'])
	    				->find_all();
	    	foreach($sites as $site)
	    	{
	    		foreach($topics as $topic)
	    			$data['code'][]=$data['line'].'-'.$site->id.'-'.$topic['id'];
	    	}
    	}
    	else
    	{
    		orm::factory('ticket_privilege')
			     ->where('user_id','=',$data['user_id'])
			     ->where('code','like',$data['line'].'-'.$data['site'].'-%')
			     ->delete_all();
			if(!isset($data['code']))
			    $data['code']=array();
    	}
	    $value['user_id']=$data['user_id'];
    		foreach($data['code'] as $v)
		    {
		    	$value['code']=$v;
		    	$t=ORM::factory('ticket_privilege')->values($value);
		    	if($t->check())
		        {
		            $t->save();
		        }
		   	}
    	$final=orm::factory('ticket_privilege')
					 ->where('user_id','=',$data['user_id'])
					 ->find_all();		
		$fin_code=array();
		foreach ($final as $v)
			$fin_code[]=$v->code;
		$diff=array_diff($org_code,$fin_code);
	    if(!empty($diff))
	    {
	    	foreach ($diff as $code)
	    	{
	    	 	DB::query(Database::DELETE, 'DELETE t1 FROM ticket_defaultowners t1 LEFT JOIN ticket_users t2 ON t1.user_id=t2.user_id 
	    	 	WHERE t2.supervisor_id='.$data['user_id'].' 
	    	 	AND t1.code=\''.$code.'\'')
	    	 	->execute();
	    	}
	    }
    }
    
    public function rate_us($data)
    {
    	$data=Security::xss_clean($data);
        $tpl = ORM::factory('ticket_rate')->values($data);
        if($tpl->check())
        {
            $tpl->save();
        }
    }
    
    public function role_add($data)
    {
    	$data = Security::xss_clean($data);
		$data['created'] = time();
		if(!isset($data['supervisor_id']))
			$data['supervisor_id']=$data['user_id'];
        $tpl = ORM::factory('ticket_user')->values($data);
        if($tpl->check())
        {
            $tpl->save();
            message::set('Add customer specialist successful!');
        }
        else
        {
            message::set('Error occur when add customer specialist '.kohana::debug($tpl->validate()->errors()));
        }
    }
    
    public function bulk_upload()
    {
    	if(!isset($_FILES)||($_FILES["file"]["type"]!="application/vnd.ms-excel"&&$_FILES["file"]["type"]!="text/csv"))
				return "Only csv file type is allowed!";
			$handle = fopen($_FILES["file"]["tmp_name"] ,"r");
			$row=1;
			$column=array();
			$error=array();
			while($data = fgetcsv($handle))
			{
				if($row==1)
					$column=$data;
				else 
				{
					for ($i=0;$i<count($data);$i++)
						$post[$column[$i]]=$data[$i];
					$diff=array_diff_assoc($post,array_filter($post));
					$allowed=array("order_no"=>"");//defind which columns allowed to be null
					$diff=array_diff_assoc($diff,$allowed);
					if(count($diff)==0)
					{
						try {
							$this->create_ticket($post);
						} catch (Exception $e) {
							$error[]="Upload row No. ".$row." faild:".$e->getMessage();
						}						
					}
					else 
						$error[]="Upload row No. ".$row." faild: Please fill the columns required.";
				}
				$row++;
			}
			return count($error)>0?implode(".<br/>",$error)."<br/>Other rows have been uploaded.":'';
    }
    
  /**
  * 
  * statistic ticket count
  * @param  $parameter array
  * @param  $from time
  * @param  $to time
  */     
    public function general_statistic(array $parameter,$from,$to)
    {
    	$sql="SELECT COUNT(id) AS num FROM tickets WHERE is_active = 1 AND ";
    	$parameter[]=" updated between ".$from." and ".$to;
    	$sql.=implode(" AND ",$parameter);
    	if(Session::instance()->get("ticket_role")=="User")
    		$sql.=(" AND user_id=".Session::instance()->get("user_id"));
    	elseif (Session::instance()->get("ticket_role")=="Manager")
    	{
    		$subs=$this->get_subordinate_by_managerID(Session::instance()->get("user_id"));
    		foreach($subs as $sub)
    			$user[]=$sub->user_id;
    		$sql=$sql." AND (user_id=".implode(" OR user_id=", $user).")";
    	}
    	$result=DB::query(Database::SELECT, $sql)->execute()->as_array();
    	return $result[0]['num'];
    }
    
    public function get_ticket_privileged_line()
    {
    	if(Session::instance()->get('ticket_role')=='')
    		return array();
    	$lines=$this->get_ticket_line_name();
    	foreach($lines as $l)
			$lines_all[$l["id"]]=$l["name"];
		$lines=array();
		if(Session::instance()->get('ticket_role')=="Admin")
			$lines=$lines_all;
    	if(Session::instance()->get('ticket_role')=="Manager")
    	{
    		$default=orm::factory('ticket_privilege')
				->where('user_id','=',Session::instance()->get('user_id'))
				->find_all();
			//print_r($default->as_array());exit;
			foreach ($default as $code)
			{
				$line_code=explode("-",$code->code);
				if(isset($lines_all[$line_code[0]]))
					$lines[$line_code[0]]=$lines_all[$line_code[0]];
			}	
    	}
    	elseif(Session::instance()->get('ticket_role')=="User")
    	{
    		$default=orm::factory('ticket_defaultowner')
				->where('user_id','=',Session::instance()->get('user_id'))
				->find_all();
			foreach ($default as $code)
			{
				$line_code=explode("-",$code->code);
				if(isset($lines_all[$line_code[0]]))
					$lines[$line_code[0]]=$lines_all[$line_code[0]];
			}	
    	}
    	return $lines;   		
    }
    
    
    
//    public function general_statistic($range=array(),$condition=array())
//    {
//    	$sql="SELECT COUNT(id) FROM tickets AS num WHERE is_active = 1";
//    	$cond[]=empty($range)?" AND 1":" updated between ".$range[0]." and ".$range[1];
//    	foreach($condition as $value)
//    		$cond[]=$value;
//    	$sql.=implode(" AND ",$cond);
//    	if(Session::instance()->get("ticket_role")=="User")
//    	{
//    		$sql.=(" AND user_id=".Session::instance()->get("user_id"));
//    	}
//    	elseif (Session::instance()->get("ticket_role")=="Manager")
//    	{
//    		$subs=$this->get_subordinate_by_managerID(Session::instance()->get("user_id"));
//    		foreach($subs as $sub)
//    			$user[]=$sub->user_id;
//    		$sql=$sql." AND (user_id=".implode(" OR user_id=", $user[]).")";
//    	}
//    	$result=DB::query(Database::SELECT, $sql)->execute()->as_array();
//    	return $result[0]['num'];
//    }
}