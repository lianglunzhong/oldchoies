<?php defined('SYSPATH') or die('No direct script access.');

class Model_docar extends ORM
{

    protected $_table_name = 'docs_ar';
    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'name' => array
        (
            'not_empty' => NULL,
        ),
        'link' => array
        (
            'not_empty' => NULL,
        )
    );

}
