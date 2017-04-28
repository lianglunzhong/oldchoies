<?php defined('SYSPATH') or die('No direct script access.');

class Model_Image extends ORM {
    protected $_table_name = 'products_productimage';
    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'id' => array(
            'not_empty' => NULL,
        ),
		'site_id' => array(
            'not_empty' => NULL,
        ),
		'obj_id' => array(
            'not_empty' => NULL,
        ),
		'type' => array(
            'not_empty' => NULL,
        ),
		'suffix' => array(
            'not_empty' => NULL,
        ),
    );

}

