<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * newsletter
 *
 * @package Classes
 * @author zhu.youbing
 * @copyright © Cofree Development
 */
class Newsletter
{

	private static $instances;
	private $data;
	private $site_id;

	public static function & instance($id = 0)
	{
		if( ! isset(self::$instances))
		{
			$class = __CLASS__;
			self::$instances[$id] = new $class($id);
		}
		return self::$instances[$id];
	}

	public function __construct($id)
	{
		$this->site_id = Site::instance()->get('id');
		$this->_load($id);
	}

	private function _load($id)
	{
		if( ! $id) return FALSE;
		$result = ORM::factory('newsletter')
				->where('id', '=', $id)
				->find()->as_array();

		$this->data = $result ? $result : array( );
	}

	public function is_email($email)
	{
		$newsletter = ORM::factory('newsletter')
				->where('email', '=', $email)
				->find();

		$newsletter->loaded() ? $newsletter_id = $newsletter->id : $newsletter_id = 0;
		return $newsletter_id;
	}

	public function set($data)
	{
		$newsletter = ORM::factory('newsletter')->values($data);

		if($newsletter->check())
		{
			$newsletter->created = time();
			$newsletter->save();
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}
