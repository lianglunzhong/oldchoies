<?php defined('SYSPATH') or die('No direct script access.');

class Model_Set extends ORM
{
    protected $_table_name = 'products_set';
    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'site_id' => array
        (
            'not_empty'	=> NULL,
        ),
        'name' => array
        (
            'not_empty' => NULL,
            'min_length' => array(1),
            'max_length' => array(255),
        ),
        'label' => array
        (
            'not_empty' => NULL,
            'max_length' => array(255),
        ),
    );

    protected $_has_many = array(
        'attributes' => array(
            'model' => 'attribute' ,
            'through' => 'set_attributes'
        ),
        'products' => array(
            'model' => 'product'
        )
    );

}
