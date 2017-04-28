<?php defined('SYSPATH') or die('No direct script access.');
class Model_Ticket_site extends ORM{
	  protected $_has_many = array(
        'customers' =>	array(
            'model' => 'customer'
        ),
        'products' =>	array(
            'model' => 'product'
        ),
    );

    // Validate
    protected $_filters = array(
        TRUE => array('trim' => NULL), 
        'line_id' => array('trim' => NULL), 
    );
    protected $_rules = array
        (
            'domain' => array(
                'not_empty'	=> NULL,
                'max_length' => array(255),
            ),
            'ticket_email' => array(
                'not_empty'	=> NULL,
                'max_length' => array(255),
            ),
            'ticket_center' => array(
                'not_empty'	=> NULL,
                'max_length' => array(255),
            ),
            'is_active' => array(
				'not_empty' => NULL
			)
        );
}