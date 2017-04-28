<?php defined('SYSPATH') or die('No direct script access.');

class Apisession
{
    public static $instances;
    private $site_id;
    private $data;

    public static function & instance($id = 0)
    {
        if(!isset(self::$instances[$id]))
        {
            $class = __CLASS__;
            self::$instances[$id] = new $class($id);
        }
        return self::$instances[$id];
    }

    public function _construct($id)               //++++++__改为_
    {
        $this->site_id = Site::instance()->get('id');
        $this->data = NULL;
        $this->_load($id);
    }

    /**
     * Get order details.
     * @param  int $id
     * @return array
     */
    public function _load($id)
    {
        if(!$id)
        {
            return FALSE;
        }

        $data = array( );
        $result = DB::select()->from('api_sessions')
            ->where('id', '=', $id)
            ->execute()
            ->current();

        $this->data = $result;
    }

    /**
     * Get shipment value by key. If key is NULL, return order details array.
     * @param string $key
     * @return string|array
     */
    public function getSessionByToken($token = NULL)
    {
        
        	$item = DB::select()->from('api_sessions')->where('token','=',$token)->execute()->current();
            
            return $item;
        
    }
    
/**
     * Get session by email. 
     * @param string $email
     * @return 
     */
    public function getSessionByMail($email = NULL)
    {
        
        	$item = DB::select()->from('api_sessions')->where('email','=',$email)->execute()->current();
        	
            return $item;
        
    }
	
    /**
     * 
     * remove expired session
     */
    public function removeExpiredSession(){
    	$now = new DateTime();
    	date_modify($now,"-1 day");
    	DB::delete('api_sessions')->where('login_time', '<=', $now->format('Y-m-d H:i:s'))->execute();
    }
    
	public function set($data)
	{
		
		if( ! $data) return FALSE;

		if($this->data['id'])
		{
			
		}
		else
		{
			
			$session = ORM::factory('api_session');			
			$data['site_id'] = Site::instance()->get('id');
			$data['token'] = md5(($data['email'].time()));
			$session->values($data);
			if($session->check())
			{				
				$session->save();
				return $data['token'];
			}
			else
			{
				return FALSE;
			}
		}
	}

}
