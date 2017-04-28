<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Drive Carrier
 * @category   Carrier
 * @author     Vincent
 * @copyright  (c) 2009-2012 Cofree
 */
abstract class Carrier
{

	/**
	 * @var   Kohana_Cache instances
	 */
	public static $instances = array( );

	/**
	 *
	 * @param   string   the name of the cache group to use [Optional]
	 * @return  Kohana_Cache
	 * @throws  Kohana_Cache_Exception
	 */
	public static function instance($carrier_id)
	{

		if(isset(Carrier::$instances[$carrier_id]))
		{
			// Return the current group if initiated already
			return Carrier::$instances[$carrier_id];
		}

		// Create a new cache type instance
		$carrier = DB::select()->from('core_carriers')
				->where('id', '=', $carrier_id)
				->execute()->current();
		if($carrier['formula'])
		{
			$carrier_class = 'Carrier_'.$carrier['formula'];
		}
		else
		{
			throw new Kohana_Exception('Carrier Set Error - Carrier_ID(:id)', array( ':id' => $carrier_id ));
		}
	
		Carrier::$instances[$carrier_id] = new $carrier_class($carrier);

		// Return the instance
		return Carrier::$instances[$carrier_id];
	}

	/**
	 * @var  Kohana_Config
	 */
	protected $_config;
	protected $_carrier;

	/**
	 * Ensures singleton pattern is observed, loads the default expiry
	 * 
	 * @param  array     configuration
	 */
	protected function __construct($carrier)
	{
		$this->_carrier = $carrier;
		$this->_config = Kohana::config(strtolower($carrier['formula']));
	}

	/**
	 * get shipping price
	 * @param	float	$weight
	 * @param	array	$shipping_address
	 */
	abstract public function get_price($carrier_param = array( ));

	/**
	 * get carrier detail
	 * @param	float	$weight
	 * @param	array	$shipping_address
	 * @return	array	$shipping
	 */
	public function get($params)
	{
		$carrier_param = array(
			'weight' => $params['weight'],
			'shipping_address' => $params['shipping_address'],
			'amount' => Arr::get($params, 'amount', array( ))
		);
		$shipping = array(
			'carrier' => $this->_carrier,
			'price' => self::instance($this->_carrier['id'])->get_price($carrier_param)
		);
		return $shipping;
	}

}

// End Site
