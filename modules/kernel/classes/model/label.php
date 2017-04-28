<?php defined('SYSPATH') or die('No direct script access.');

class Model_label extends ORM
{

    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'niche' => array
        (
            'not_empty' => NULL,
        ),
        'url' => array
        (
            'not_empty'	=> NULL,
        )
    );

}
