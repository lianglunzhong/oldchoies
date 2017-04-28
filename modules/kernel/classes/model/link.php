<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */

class Model_Link extends ORM {

    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'name' => array(
            'not_empty' => NULL,
        ),
        'email' => array(
            'not_empty' => NULL,
            'max_length' => array(127),
            'validate::email' => NULL,
        ),
	'subject' => array(
            'not_empty' => NULL,
        ),
	'message' => array(
            'not_empty' => NULL,
        ),
        'is_valid' => array(
            'digit' => NULL,
        ),
        'site_id' => array(
            'digit' => NULL,
        ),
        'level' => array(
            'digit' => NULL,
        ),
    );
}