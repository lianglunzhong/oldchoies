<?php defined('SYSPATH') or die('No direct script access.');

class Model_Roletask extends ORM {

    // Validate
    protected $_filters = array(
	TRUE => array('trim' => NULL)
    );
    protected $_rules = array(
	'role_id' => array
	    (
	    'not_empty' => NULL,
	    'max_length' => array(255),
	),
	'role_task' => array
	    (
	    'not_empty' => NULL
	),
    );

}
