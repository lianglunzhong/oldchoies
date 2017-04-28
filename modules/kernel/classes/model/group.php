<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */

class Model_Group extends ORM {

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
         'description' => array(
            'max_length' => array(65535),
        ),
    );

    protected $_has_many = array(
        'topics' => array('model' => 'topic' ),
    );

}