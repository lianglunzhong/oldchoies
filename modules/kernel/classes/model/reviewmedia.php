<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Review_video model
 *
 * @package Model
 * @author QinChong
 * @copyright © Cofree Development
 */
class Model_Reviewmedia extends ORM {
	
	protected $_ignored_columns = array('remarks');
	protected $_table_name = 'review_media';

	protected $_filters = array(
		TRUE => array('trim' => NULL)
	);
	protected $_rules = array
	(
		'product_id'			=> array
		(
			'not_empty'			=> NULL,
		),
		'type'			=> array
		(
			'not_empty'			=> NULL,
		),
		'customer_id'			=> array
		(
			'not_empty'			=> NULL,
		),
        'caption'			=> array
		(
			'not_empty'			=> NULL,
		),
        'url_add'			=> array
		(
			'not_empty'			=> NULL,
		),
        'checked'			=> array
		(
			'not_empty' => NULL,
        ),
        'created'			=> array
		(
			'not_empty'			=> NULL,
        ),
	);
	
}


