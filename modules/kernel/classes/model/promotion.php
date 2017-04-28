<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Promotion extends ORM
{

	protected $_table_name = 'carts_promotions';
	protected $_filters = array(
		TRUE => array( 'trim' => NULL )
	);
//    protected $_rules = array
//        (
//            'email'				=> array
//            (
//                'not_empty'			=> NULL,
//                'max_length'		=> array(127),
//                'validate::email'	=> NULL,
//            ),
//        );
	protected $_rules = array
		(
		'name' => array(
			'not_empty' => NULL,
			'max_length' => array( 255 ),
		),
		'site_id' => array(
			'not_empty' => NULL
		),
		'filter' => array(
			'not_empty' => NULL
		),
		'from_date' => array(
			'not_empty' => NULL
		),
		'to_date' => array(
			'not_empty' => NULL
		),
		'is_active' => array(
			'not_empty' => NULL
		),
		'brief' => array(
			'not_empty' => NULL
		),
		'actions' => array(
			'not_empty' => NULL
		)
	);
}

