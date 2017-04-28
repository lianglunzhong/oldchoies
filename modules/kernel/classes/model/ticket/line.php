<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Ticket_Line extends ORM
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
			'max_length' => array( 1000 ),
		),
		'is_active' => array(
			'not_empty' => NULL,
		)
	);

}

