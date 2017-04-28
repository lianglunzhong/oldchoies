<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Site extends ORM
{

	// Relationships
	protected $_has_many = array(
		'customers' => array(
			'model' => 'customer'
		),
		'products' => array(
			'model' => 'product'
		),
	);
	// Validate
	protected $_filters = array(
		TRUE => array( 'trim' => NULL ),
		'line_id' => array( 'trim' => NULL ),
	);
	protected $_rules = array
		(
		'domain' => array(
			'not_empty' => NULL,
			'max_length' => array( 255 ),
		),
		'email' => array(
			'not_empty' => NULL,
			'max_length' => array( 255 ),
			'validate::email' => NULL,
		),
		'meta_title' => array(
			'max_length' => array( 255 ),
		),
		'meta_keywords' => array(
			'max_length' => array( 355 ),
		),
		'meta_description' => array(
			'max_length' => array( 65535 ),
		),
		'route_type' => array(
			'not_empty' => NULL,
		),
		'ssl' => array(
			'not_empty' => NULL,
		),
		'product' => array(
			'max_length' => array( 32 ),
		),
		'catalog' => array(
			'max_length' => array( 32 ),
		),
		'suffix' => array(
			'max_length' => array( 32 ),
		),
		'stat_code' => array(
			'max_length' => array( 65535 ),
		),
		'robots' => array(
			'max_length' => array( 255 ),
		),
		'per_page' => array(
			'not_empty' => NULL,
			'min_length' => array( 1 ),
			'max_length' => array( 32 ),
		),
		'forum_moderators' => array(
			'max_length' => array( 65535 )
		),
	);

}

