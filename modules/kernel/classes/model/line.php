<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Line extends ORM
{

	protected $_filters = array(
		TRUE => array( 'trim' => NULL )
	);
	protected $_rules = array
		(
		'name' => array(
			'not_empty' => NULL,
			'max_length' => array( 255 ),
		),
		'brief' => array(
			'not_empty' => NULL,
			'max_length' => array( 255 ),
		),
	);

}

