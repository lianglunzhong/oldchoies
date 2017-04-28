<?php defined('SYSPATH') or die('No direct script access.');

class Option
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
		$key = $this->site_id."/option/".$id;
		$data = array( );
		if( ! ($data = $cache->get($key)))
		{
			$data = array( );
			$result = DB::select()->from('options')
					->where('id', '=', $id)
					->execute()->current();
			if($result['id'] !== NULL)
			{
				$data['id'] = $result['id'];
				$data['label'] = $result['label'];
				$data['position'] = $result['position'];
				$data['default'] = $result['default'];
				$data['attribute_id'] = $result['attribute_id'];
				$data['keywords'] = $result['keywords'];
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

    public static function complements($_options = array())
    {
        if(!$_options) return array();
        
        $option_ids = implode($_options,',');
        $result = DB::query(Database::SELECT,'SELECT attribute_id FROM options WHERE id IN ('.$option_ids.') ')->execute();
        $attribute_ids = array();
        foreach($result as $item)
        {
            $attribute_ids[] = $item['attribute_id'];
        }
        $attribute_ids = implode($attribute_ids,',');
        $result = DB::query(Database::SELECT,'SELECT id FROM options WHERE attribute_id IN ('.$attribute_ids.') AND id NOT IN ('.$option_ids.')')->execute();
        $data = array();
        foreach($result as $item)
        {
            $data[] = $item['id'];
        }
        return $data;
    }

    public function get_associated_products($_limit = 1,$_offset = 0)
    {
        if(empty($this->data['id']))
        {
            return array();
        }

        $results = DB::select('product_id')
            ->from('product_options')
            ->where('option_id','=',$this->data['id']);
        if($_limit > 0)
        {
            $results = $results->limit($_limit)->offset($_offset);
        }

        $results = $results->execute();

        $data = array();
        foreach($results as $re)
        {
            $data[] = $re['product_id'];
        }

        return $data;
    }

    public function delete()
    {
        if(empty($this->data['id']))
        {
            return FALSE;
        }

        DB::delete('options')
            ->where('id','=',$this->data['id'])
            ->execute();
        return TRUE;
    }
}
