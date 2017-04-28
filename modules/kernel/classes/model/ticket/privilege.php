<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Tikcet Talk Model
 *
 * @package   Tickets
 * @author    shi.chen@cofreeonline.com
 * @copyright © 2011 Cofree Development Group
 * @version   SVN: $Id: talk.php 585 2011-03-16 08:13:50Z shi.chen $
 */

class Model_Ticket_privilege extends ORM{
	protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array
        (
            'user_id' => array(
                'not_empty'	=> NULL,
            ),
            'code' => array(
                'not_empty'	=> NULL,
            )
        );
}
