<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Ticket extends Controller
{
// judge the privileges for each page
    public function before()
    {
        parent::before();
        $access=true;
        if(Session::instance()->get('ticket_role')=='')
        	$access=false;
        $url=url::current();
       	//the access to ticket list page
       	if(strpos($url,'ticket/list'))
       	{	
       		if(Session::instance()->get("ticket_role")=='User'&&strpos($url,'user_id='.Session::instance()->get('user_id'))===false)
       		{
       			$access=false;
       		}
       	}
       	//the access to ticket detail page
        if(strpos($url, 'ticket/detail'))
        {
        	if(Session::instance()->get("ticket_role")=='User')
        	{
        		$id = $this->request->param('id');
        		$ticket=Ticket::instance()->get_details_by_ticketID($id);
        		if($ticket[0]['user_id']!=Session::instance()->get('user_id'))
        		{
        			$access=false;
        		}
        	}
        }
       	if(strpos($url, '/role/')||strpos($url, '/manger/')||strpos($url, '/template/')||strpos($url, '/topic/')||strpos($url, '/site/'))
       	{
       		if(Session::instance()->get("ticket_role")=='User')
       			$access=false;
       		elseif(Session::instance()->get("ticket_role")=='Manager')
       		{
       			if(strpos($url, 'role/default_topic')||strpos($url, 'role/edit'))
       			{
       				$id = $this->request->param('id');
       				$supervisor=ticket::instance()->get_supervisor($id);
       				if($supervisor!=0&&$supervisor!=Session::instance()->get('user_id'))
       					$access=false;
       			}
       		}      		
       	}
       	
       	if(strpos($url, '/blacklist/'))
       	{
       		if(Session::instance()->get("ticket_role")!='Admin')
       			$access=false;
       	}
        
        if (!$access)
        {
        	Message::set("You have no permission to access this page!");
            if(isset($_SERVER['HTTP_REFERER']))
        		$this->request->redirect($_SERVER['HTTP_REFERER']);
        	else 
        		$this->request->redirect('/admin/sys/site/list');
        }
    }
}
