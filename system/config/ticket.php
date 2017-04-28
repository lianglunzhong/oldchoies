<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 处理ticket模块的配置
 *
 * @package   Tickets
 * @copyright © 2011 Cofree Development Group
 * @version   SVN: $Id: ticket.php 597 2011-03-16 09:46:06Z ruan.chao $
 */

return array(
	'priority' => array(
						array(
								'status'=>'low',
								'bgcolor'=>'#00FF00'
						), 
						array(
								'status'=>'medium', 
								'bgcolor'=>'#2EDF0E'
						), 
						array(
								'status'=>'high',
								'bgcolor'=>'#92982C'
						),
						array(
								'status'=>'urgent',
								'bgcolor'=>'#D36A3F'
						),
						array(
								'status'=>'emergency',
								'bgcolor'=>'#FF0000'
						)
				),
	'status'=> array('New','Answered','Overdue','Closed','Open'),
				
	'topic_has_order'=>array(),
	
	'signature'=>'{nickname}<br/>{site} Customer Service Department',

	// ticket overdue time, by hour
	'overdue' => 240,

	// upload attache
	'attachment' => array(
		'filetypes' => array('jpg', 'jpeg', 'gif', 'png', 'pdf','zip','rar','pdf'),
		'max_size'  => 4194304,//4M
		'tempath'=>$_SERVER['COFREE_SHARE_DIR'].'/ticket/temp',
		'path'=>$_SERVER['COFREE_SHARE_DIR'].'/ticket',
		'URL'=>$_SERVER['COFREE_SHARE_URL'].'/ticket'
//		'tempath'=>'D:\upload\ticket\temp',
//		'path'=>'D:\upload\ticket',
//		'URL'=>''
	),
	'domain'=>'http://www.tickets-service.com',
	'ticket_randnumber'=> 4,
	'classification'=>array('Potential Customer','Complaint Customer','VIP Customer','Blacklist Customer','Other Customer')
);
