<?php defined('SYSPATH') or die('No direct script access.');

class Model_Option extends ORM {

    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'site_id' => array(
            'not_empty' => NULL,
        ),
        'label' => array(
            'not_empty' => NULL,
            'max_length' => array(255),
        ),
    );

    protected $_belongs_to = array('attribute' => array());

}

