<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Tikcet Talk Model
 *
 * @package   Tickets
 * @author    shi.chen@cofreeonline.com
 * @copyright © 2011 Cofree Development Group
 * @version   SVN: $Id: talk.php 585 2011-03-16 08:13:50Z shi.chen $
 */

class Model_Ticket_user extends ORM{
	protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array
        (
            'is_active' => array(
                'not_empty'	=> NULL,
            ),
            'user_id' => array(
                'not_empty'	=> NULL,
            ),
            'nickname' => array(
                'not_empty'	=> NULL,
                'max_length' => array(255),
            ),
        	'role' => array(
                'not_empty'	=> NULL,
                'max_length' => array(30),
            ),
        );
}
