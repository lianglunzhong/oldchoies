<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Tikcet Template Model
 *
 * @package   Tickets
 * @author    shi.chen@cofreeonline.com
 * @copyright © 2011 Cofree Development Group
 * @version   SVN: $Id: template.php 585 2011-03-16 08:13:50Z shi.chen $
 */

class Model_Ticket_template extends ORM{
	protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array
        (
            'is_active' => array(
                'not_empty'	=> NULL,
            ),
             'topic_id' => array(
                'not_empty'	=> NULL,
            ),
            'tpl_name' => array(
                'not_empty'	=> NULL,
            	'max_length' => array(100),
            ),
        	'tpl_content' => array(
                'not_empty'	=> NULL,
            ),
        );
}
