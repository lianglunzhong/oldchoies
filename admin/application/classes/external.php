<?php

abstract class External
{

	public static $instances = array( );

	public static function instance($site)
	{

		if(isset(External::$instances[$site]))
		{
			return External::$instances[$site];
		}

		$config = Kohana::config('external');
		if( ! $config->offsetExists($site)) exit;
		$config = $config->get($site);

		$external_class = 'External_'.$config['driver'];

		External::$instances[$site] = new $external_class($config);

		return External::$instances[$site];
	}

	abstract public function orders();

	abstract public function format($order);

	abstract public function detail($ordernum);
}
