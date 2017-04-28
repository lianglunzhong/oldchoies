<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Customer extends ORM
{
	protected $_table_name = 'accounts_customers';
	// Validate
	protected $_filters = array(
		TRUE => array( 'trim' => NULL )
	);
	protected $_rules = array(
		// 'site_id' => array(
		// 	'not_empty' => NULL,
		// ),
		'email' => array(
			'not_empty' => NULL,
		),
		'firstname' => array(
//			'not_empty' => NULL,
//			'min_length' => array( 1 ),
			'max_length' => array( 255 ),
		),
		'lastname' => array(
//			'not_empty' => NULL,
//			'min_length' => array( 1 ),
			'max_length' => array( 255 ),
		),
		'password' => array(
			'not_empty' => NULL,
			'min_length' => array( 5 ),
			'max_length' => array( 255 ),
		),
	);
     protected $_has_many = array(
        'wishlists' => array('model' => 'accounts_wishlists'),
        'addresses' => array('model' => 'accounts_address'),
    );
    
}
