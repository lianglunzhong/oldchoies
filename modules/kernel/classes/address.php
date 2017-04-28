<?php
defined('SYSPATH') or die('No direct script access.');

class Address
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
		// $this->site_id = Site::instance()->get('id');
		$this->_load($id);
	}

	public function _load($id)
	{
		if( ! $id) return FALSE;
		$result = ORM::factory('address')
				->where('id', '=', $id)
				->find()->as_array();

		$this->data = $result ? $result : array( );
	}

	public function get($key = NULL)
	{
		if(empty($key))
		{
			return $this->data;
		}
		else
		{
			return isset($this->data[$key]) ? $this->data[$key] : '';
		}
	}

	public function set($data)
	{
		if( ! $data) return FALSE;
		if(isset($this->data['id']))
		{
			$address = ORM::factory('address', $this->data['id'])->values($data);
			if($address->loaded())
			{
				if($address->check())
				{
					
					if($address->save())
					{
						$this->_load($this->data['id']);
						return TRUE;
					}
				}
			}
			return FALSE;
		}
		else
		{
			$address = ORM::factory('address');
			$address->values($data);
			if($address->check())
			{
				// $address->site_id = $this->site_id;
				if($address->save())
				{
					return TRUE;
				}
			}
			return FALSE;
		}
	}

	public function delete()
	{
		if($this->data['id'])
		{
			DB::delete('accounts_address')->where('id', '=', $this->data['id'])->execute();
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}
