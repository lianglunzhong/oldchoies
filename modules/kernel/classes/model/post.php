<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */

class Model_Post extends ORM {

    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'site_id' => array(
            'not_empty' => NULL,
        ),
        'user_id' => array(
            'not_empty' => NULL,
        ),
		'content' => array(
            'not_empty' => NULL,
        ),
		'pub_time' => array(
            'not_empty' => NULL,
        ),
    );
}