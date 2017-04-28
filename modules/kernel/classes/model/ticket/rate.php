<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Tikcet Template Model
 *
 * @package   Tickets
 * @author    shi.chen@cofreeonline.com
 * @copyright © 2011 Cofree Development Group
 * @version   SVN: $Id: template.php 585 2011-03-16 08:13:50Z shi.chen $
 */

class Model_Ticket_rate extends ORM{
	protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array
        (
            'proficiency' => array(
                'not_empty'	=> NULL,
            ),
            'politeness' => array(
                'not_empty'	=> NULL,
            ),
            'comment' => array(
                'not_empty'	=> NULL,
            ),
        	'ticketID' => array(
                'not_empty'	=> NULL,
            ),
        );
}
