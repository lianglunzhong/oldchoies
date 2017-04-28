<?php defined('SYSPATH') or die('No direct script access.');

class Model_Productde extends ORM {

    protected $_table_name = 'products_de';
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
        'sku' => array(
            'not_empty' => NULL,
            'max_length' => array(255),
        ),
        'link' => array(
            'max_length' => array(255),
        ),
        'visibility' => array(
            'not_empty' => NULL,
        ),
        'status' => array(
            'not_empty' => NULL,
        ),
        'price' => array(
            'not_empty' => NULL,
        ),
        'market_price' => array(
            'max_length' => array(65535),
        ),
        'cost' => array(
            'max_length' => array(65535),
        ),
        'total_cost' => array(
            'max_length' => array(65535),
        ),
        'stock' => array(
            'numeric' => NULL,
        ),
        'weight' => array(
            'numeric' => NULL,
        ),
        'brief' => array(
            'max_length' => array(65535),
        ),
        'description' => array(
            'max_length' => array(65535),
        ),
        'meta_title' => array(
            'max_length' => array(65535),
        ),
        'meta_keywords' => array(
            'max_length' => array(65535),
        ),
        'meta_description' => array(
            'max_length' => array(65535),
        ),
        'keywords' => array(
            'max_length' => array(65535)
        )
    );

    protected $_has_many = array(
        'options' => array('model' => 'option' , 'through' => 'product_options'),
		'attributes'=> array('model'=>'attribute','through'=>'product_attribute_values')
    );

	protected $_belongs_to = array('catalog' => array());

}

