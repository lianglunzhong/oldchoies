<?php defined('SYSPATH') or die('No direct script access.');

class Model_Mail extends ORM {
	protected $_table_name = 'core_mails';
    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        // 'site_id' => array('not_empty' => NULL),
        'type' => array('not_empty' => NULL),
        'title' => array('not_empty' => NULL),
    );
}

