<?php defined('SYSPATH') or die('No direct script access.');

class Roleupdate
{
	private static $instances;
	private $user_id;
 	public static function & instance($user_id = 0)
    {
        if( ! isset(self::$instances[$user_id]))
        {
            $class = __CLASS__;
            self::$instances[$user_id] = new $class($user_id);
        }
        return self::$instances[$user_id];
    }
    
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }
    
    public function update_role($role)
    {
    	$user=ORM::factory('ticket_user');
    	$user->role=$role;
    	$user->where('user_id','=',$this->user_id)->save_all();
    }
    
    public function update_supervisor($id=0)
    {
    	$user=ORM::factory('ticket_user');
    	$user->supervisor_id=$id;
    	$user->where('user_id','=',$this->user_id)->save_all();
    }
    
    public function update_default_topic_owner($id=0)
    {
    	if($id==0)
    	ORM::factory('ticket_defaultowner')
    		->where('user_id','=',$this->user_id)
    		->delete_all();
    	else
    	{
    		ORM::factory('ticket_defaultowner')
    			->where('user_id','=',$id)
    			->delete_all();
	    	$owner=ORM::factory('ticket_defaultowner');
	    	$owner->user_id=$id;
	    	$owner->where('user_id','=',$this->user_id)->save_all();
    	}
    }
    
    public function update_privilege($id=0)
    {
    	if($id==0)
    	ORM::factory('ticket_privilege')
    		->where('user_id','=',$this->user_id)
    		->delete_all();
    	else 
    	{
    		$privilege=ORM::factory('ticket_privilege');
	    	$privilege->user_id=$id;
	    	$privilege->where('user_id','=',$this->user_id)->save_all();
    	}
    }
    
    public function update_subordinate_supervisor($id=0)
    {
    	$user=ORM::factory('ticket_user');
	    $user->supervisor_id=$id;
	    $user->where('supervisor_id','=',$this->user_id)->where('role','=','User')->save_all();
    }
    
    public function update_subordinate_default_topic($id=0)
    {
    	$user=ORM::factory('ticket_user')
    		->where('supervisor_id','=',$this->user_id)
    		->find_all();
    	foreach ($user as $v)
    	{

    	   	if($id==0)
	    		ORM::factory('ticket_defaultowner')
	    			->where('user_id','=',$v->user_id)
	    			->delete_all();
    	}
    }
    
    public function update_active($flag=1)
    {
    	$user=ORM::factory('ticket_user');
		$user->is_active=$flag;
		$user->where('user_id','=',$this->user_id)->save_all();
		if($flag==0)
		{
			$this->update_ticket_assign(0);
			$this->update_subordinate_default_topic();
			$this->update_subordinate_supervisor();
		}
    }
    
    Public function update_ticket_assign($id=0)
    {
    	$ticket=ORM::factory('ticket');
		$ticket->user_id=$id;
		$ticket->where('user_id','=',$this->user_id)->where('status','<>','Closed')->save_all();
    }
}
