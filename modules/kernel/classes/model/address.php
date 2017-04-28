<?php defined('SYSPATH') or die('No direct script access.');
/**
 *address
 *
 * @package Model
 * @author ding.wang
 * @copyright © Cofree Development
 */
class Model_Address extends ORM {
	
	protected $_table_name = 'accounts_address';		
	// Relationships
	protected $_has_many = array(
		// forum
		'topics' 	=>	array(
			'model' 	=> 'topic'
		),
		'posts'		=>	array(
			'model' 	=> 'post'
		),
		'favorites' =>	array(
			'model' 	=> 'favorite'
		),
		'messages' 	=>	array(
			'model' 	=> 'message'
		),
		'friends' 	=>	array(
			'model'		=> 'user'
		),
		'groups' 	=> array(
			'model' 	=> 'group', 
			'through' 	=> 'groups_users'
		),
		'collections' 	=> array(
			'model' 	=> 'collection', 
		),
		// auth
		'user_tokens' => array(
			'model' 	=> 'user_token'
		),
		'roles' 	=> array(
			'model' 	=> 'role', 
			'through' 	=> 'roles_users'
		),
	);
	
	protected $_filters = array(
		TRUE => array('trim' => NULL)
	);
	protected $_rules = array
	(
		'firstname'			=> array
		(
			'not_empty'			=> NULL,
			'max_length'		=> array(255),
		),
		'lastname'			=> array
		(
			'not_empty'			=> NULL,
			'max_length'		=> array(255),
		),
        'address'			=> array
		(
			'not_empty'			=> NULL,
			'max_length'		=> array(255),
		),
        'city'			=> array
		(
			'not_empty'			=> NULL,
			'max_length'		=> array(255),
		),
        'zip'			=> array
		(
			'not_empty'			=> NULL,
			'max_length'		=> array(255),
		),
        'state'			=> array
		(
			'not_empty'			=> NULL,
			'max_length'		=> array(255),
		),
        'country'			=> array
		(
			'not_empty'			=> NULL,
			'max_length'		=> array(255),
		),
        'phone'			=> array
		(
			'not_empty'			=> NULL,
			'max_length'		=> array(255),
		),
        'other_phone'			=> array
		(
			'max_length'		=> array(255),
		),
	);
	
}

