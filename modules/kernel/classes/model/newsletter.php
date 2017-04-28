<?php defined('SYSPATH') or die('No direct script access.');

class Model_Newsletter extends ORM {

    protected $_table_name = 'accounts_newsletters';
    protected $_filters = array(
            TRUE => array('trim' => NULL)
    );
    protected $_rules = array
        (
        'email'				=> array
        (
                'not_empty'			=> NULL,
                'max_length'		=> array(255),
                'validate::email'	=> NULL,
        ),
        'firstname'			=> array
        (
                'max_length'		=> array(255),
        ),
        'lastname'			=> array
        (
                'max_length'		=> array(255),
        ),
        'gender'			=> array
        (
                'max_length'		=> array(255),
        ),
        'zip'			=> array
        (
                'max_length'		=> array(255),
        ),
        'occupation'			=> array
        (
                'max_length'		=> array(255),
        ),
        'country'			=> array
        (
                'max_length'		=> array(255),
        ),
        'birthday'			=> array
        (
                'max_length'		=> array(255),
        ),
    );

}
