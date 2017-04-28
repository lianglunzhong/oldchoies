<?php
defined('SYSPATH') or die('No direct script access.');

class Model_carrier extends ORM
{

	// Validate
	protected $_filters = array(
		TRUE => array( 'trim' => NULL )
	);
	protected $_rules = array(
		'site_id' => array
			(
			'not_empty' => NULL,
		),
		'isocode' => array
			(
			'not_empty' => NULL,
		),
		'carrier' => array
			(
			'not_empty' => NULL,
		),
		'carrier_name' => array
			(
			'not_empty' => NULL,
		),
	);

}
