<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Tikcet Model
 *
 * @package   Tickets
 * @author    ruan.chao@ketai-inc.com
 * @copyright © 2011 Cofree Development Group
 * @version   SVN: $Id: ticket.php 753 2011-03-23 08:26:43Z ruan.chao $
 */

class Model_Ticket extends ORM{
	protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array
        (
            'ticketID' => array(
                'not_empty'	=> NULL,
            ),
            'site_id' => array(
                'not_empty'	=> NULL,
            ),
        	'topic_id' => array(
                'not_empty'	=> NULL,
            ),
            
            'first_name' => array(
                'not_empty'	=> NULL,
            ),
            'last_name' => array(
                'not_empty'	=> NULL,
            ),
        	'email' => array(
                'not_empty'	=> NULL,
                'max_length' => array(60),
            ),
            'priority_id' => array(
                'not_empty'	=> NULL,
            ),
            
            'subject' => array(
                'not_empty'	=> NULL,
            ),
        );
}
