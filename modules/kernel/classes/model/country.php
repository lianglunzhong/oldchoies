<?php defined('SYSPATH') or die('No direct script access.');

class Model_country extends ORM
{

    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'site_id' => array
        (
            'not_empty'	=> NULL,
        ),
        'country_id' => array
        (
            'not_empty' => NULL,
        ),
        'name' => array
        (
            'not_empty'	=> NULL,
            'min_length' => array(1),
            'max_length' => array(255),
        ),
        'isocode' => array
        (
            'not_empty'	=> NULL,
            'min_length' => array(1),
            'max_length' => array(255),
        ),
        'is_active' => array
        (
            'not_empty'	=> NULL,
        ),
    );

}
