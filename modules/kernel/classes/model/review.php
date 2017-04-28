<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Review model
 *
 * @package Model
 * @author FangHao
 * @copyright © Cofree Development
 */
class Model_Review extends ORM {
			
	protected $_filters = array(
		TRUE => array('trim' => NULL)
	);
	protected $_rules = array
	(
		'product_id'			=> array
		(
			'not_empty'			=> NULL,
		),
		'user_id'			=> array
		(
			'not_empty'			=> NULL,
		),
        'content'			=> array
		(
			'not_empty'			=> NULL,
		),
        'reply'			=> array
		(
			'max_length' => array(65535),
        ),
        'time'			=> array
		(
			'not_empty'			=> NULL,
        ),
        'site_id'			=> array
		(
			'not_empty'			=> NULL,
		),
	);
	
}


