<?php defined('SYSPATH') or die('No direct script access.');

class Group
{

	private static $instances;
	private $data;
	private $site_id;

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
		$this->site_id = Site::instance()->get('id');
		$this->data = NULL;
		$this->_load($id);
	}

	public function _load($id)
	{
		if(!$id)
		{
			return FALSE;
		}

		$cache = Cache::instance();
		$key = $this->site_id."/group/".$id;
		if( ! ($data = $cache->get($key)))
		{
			$data = array( );
			$result = DB::select()->from('groups')
					->where('id', '=', $id)
					->execute()->current();

			if($result['id'] !== NULL)
			{
				$data['id'] = $result['id'];
                $data['name'] = $result['name'];
                $data['type'] = $result['type'];
				$data['description'] = $result['description'];

				$cache->set($key, $data);
			}
		}
		if(count($data))
		{
			$this->data = $data;
		}
	}

	public function get($key = NULL)
	{
		if(empty($key))
		{
			return $this->data;
		}

		return isset($this->data[$key]) ? $this->data[$key] : '';
	}

	public function topics($magic_param = NULL,$_offset = NULL,$_limit = NULL,$_sticky = 1)
	{
        $this->get('id') ? $where_group = " AND group_id = '".$this->get('id')."' " : $where_group = '';
        $_sticky ? $order_sticky = ' sticky DESC,' : $order_sticky = ' last_post DESC,';

        $magic_filter = ''; 
        if($magic_param)
        {
            if($magic_param == 'unreplied')
            {
                $magic_filter = " AND top_post = last_post ";
            }
            else
            {
                $magic_filter = " AND product_id = '".$magic_param."'";
            }
        }

		$_limit ? $limit = ' LIMIT '.($_offset ? $_offset.',' : '').$_limit : $limit = '';

		$results = DB::query(1,"SELECT id FROM topics WHERE site_id = '".$this->site_id."' ".$where_group.$magic_filter." ORDER BY ".$order_sticky." last_post DESC ".$limit)->execute();
		$data = array();
		foreach($results as $re)
		{
			$data[] = $re['id'];
		}

		return $data;
	}

	public function count_topics($magic_param = NULL)
	{
        $this->get('id') ? $where_group = " AND group_id = '".$this->get('id')."' " : $where_group = '';
        
        $magic_filter = ''; 
        if($magic_param)
        {
            if($magic_param == 'unreplied')
            {
                $magic_filter = " AND top_post = last_post ";
            }
            else
            {
                $magic_filter = " AND product_id = '".$magic_param."'";
            }
        }

		$data = DB::query(1,"SELECT count(id) AS count FROM topics WHERE site_id = '".$this->site_id."' ".$where_group.$magic_filter.";")->execute()->current();

		return $data['count'];
	}

	public function permalink($product_id = NULL)
	{
		if(!$this->get('id'))
        {
            return array();
        }
		return ($this->get('id') == Site::instance()->get_specific_group_id('product') AND $product_id) ? '/forum/product/'.$product_id : '/forum/'.$this->get('id');
    }

    public function get_by_type($type_id)
    {
        $results = DB::query(1,"SELECT id FROM groups WHERE type = '".$type_id."' AND site_id = '".$this->site_id."' AND id NOT IN('1','3','6') ORDER BY position")->execute();
        $data = array();
        foreach($results as $re)
        {
            $data[] = $re['id'];
        }
        return $data;
    }

}
