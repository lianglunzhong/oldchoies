<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Drive Payment
 * @category   Payment
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
abstract class Payment {

	/**
	 * @var   Kohana_Cache instances
	 */
	public static $instances = array();

	/**
	 *
	 * @param   string   the name of the cache group to use [Optional]
	 * @return  Kohana_Cache
	 * @throws  Kohana_Cache_Exception
	 */
	public static function instance($method)
	{

		if (isset(Payment::$instances[$method]))
		{
			// Return the current group if initiated already
			return Payment::$instances[$method];
		}

		$config = Kohana::config('payments');

		if ( ! $config->offsetExists($method)) exit;

		$config = $config->get($method);

		$payment_class = 'Payment_'.$config['driver'];

		Payment::$instances[$method] = new $payment_class($config);

		// Return the instance
		return Payment::$instances[$method];
	}

	/**
	 * @var  Kohana_Config
	 */
	protected $_config;

	/**
	 * Ensures singleton pattern is observed, loads the default expiry
	 * 
	 * @param  array     configuration
	 */
	protected function __construct($config)
	{
		$this->_config = $config;
	}

	abstract public function pay($order, $data = NULL);

	public function log($data)
	{
		$log = ORM::factory('orderpayment');
		$log->values($data);
		$log->save();
		if($log->saved())
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}

	}

}
// End Payment