<?php
defined('SYSPATH') or die('No direct script access.');

class News
{

	private static $instances;
	private $site_id;
	private $data;

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
		if( ! $id) return FALSE;
		$result = ORM::factory('new')
				->where('id', '=', $id)
				->find()->as_array();

		$this->data = $result ? $result : array( );
	}

	public function get($key = NULL)
	{
		if(is_null($key))
		{
			return $this->data;
		}
		else
		{
			return isset($this->data[$key]) ? $this->data[$key] : NULL;
		}
	}

	public function set($data)
	{
		$news = ORM::factory('new');
		$news->values($data);
		if($news->check())
		{
			$news->save();
			if($news->saved())
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	public function update($data)
	{
		$news = ORM::factory('new')
				->where('id', '=', $this->data['id'])
				->find();
		if( ! ($news->loaded())) return FALSE;
		$news->values($data);
		if($news->check())
		{
			$news->save();
			if($news->saved())
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	public function delete()
	{
		$news = ORM::factory('new', $this->data['id']);
		if($news->loaded())
		{
			return $news->delete();
		}
		else
		{
			return FALSE;
		}
	}

}
