<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Ticket_Blacklist extends ORM
{

	protected $_filters = array(
		TRUE => array( 'trim' => NULL )
	);
	protected $_rules = array
		(
		'domain' => array(
			'not_empty' => NULL,
			'max_length' => array( 255 ),
		)
	);

}

