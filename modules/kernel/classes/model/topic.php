<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */

class Model_Topic extends ORM {

    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'site_id' => array(
            'not_empty' => NULL,
        ),
        'group_id' => array(
            'not_empty' => NULL,
        ),
		'product_id' => array(
            'digit' => NULL,
        ),
		'subject' => array(
            'not_empty' => NULL,
        ),
		'top_post' => array(
            'not_empty' => NULL,
        ),
		'last_post' => array(
            'not_empty' => NULL,
        ),
		'views' => array(
            'digit' => NULL,
        ),
		'sticky' => array(
            'digit' => NULL,
        ),
		'locked' => array(
            'digit' => NULL,
        ),
    );

    protected $_has_many = array(
        'posts' => array('model' => 'post','through'=>'topic_posts' ),
    );

	protected $_belongs_to = array('group' => array());

}