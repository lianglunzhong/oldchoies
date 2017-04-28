<?php defined('SYSPATH') or die('No direct script access.');

class Model_Attribute extends ORM {
    protected $_table_name = 'products_productattribute';
    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'site_id' => array(
            'not_empty' => NULL,
        ),
        'name' => array(
            'not_empty' => NULL,
            'max_length' => array(255),
        ),
        'label' => array(
            'not_empty' => NULL,
            'max_length' => array(255),
        ),
        'brief' => array(
            'max_length' => array(65535),
        ),
        'scope' => array(
            'not_empty' => NULL,
        ),
		'type' => array(
            'not_empty' => NULL,
        ),
        'required' => array(
            'not_empty' => NULL,
        ),
        'promo' => array(
            'not_empty' => NULL,
        ),
        'view' => array(
            'not_empty' => NULL,
        ),
		'default_value'=>array(
			 'max_length' => array(65535)
		)
    );

    protected $_has_many = array(
        'options' => array('model' => 'option'),
        'sets' => array('model' => 'set' , 'through' => 'set_attributes')
    );

}

