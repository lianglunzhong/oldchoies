<?php
/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */
defined('SYSPATH') or die('No direct script access.');

class Model_Cpromotion extends ORM
{

	protected $_table_name = 'carts_cpromotions';
	protected $_filters = array(
		TRUE => array( 'trim' => NULL )
	);

	protected $_rules = array
		(
		'name' => array(
			'not_empty' => NULL,
			'max_length' => array( 255 ),
		),
		'site_id' => array(
			'not_empty' => NULL
		),
		'conditions' => array(
			'not_empty' => NULL
		),
		'from_date' => array(
			'not_empty' => NULL
		),
		'to_date' => array(
			'not_empty' => NULL
		),
		'brief' => array(
			'max_length' => array(65535)
		),
		'actions' => array(
			'not_empty' => NULL
		)
	);
}

