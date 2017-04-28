<?php
defined('SYSPATH') OR die('No direct access allowed.');
/**
 * config external sites
 *
 * @package
 * @author    Vincent
 * @copyright    © 2011 Cofree Development Group
 */
return array(
	'geartaker' => array(
		'driver' => 'geartaker',
		'database' => array( ),
	),
	'glassesshop' => array(
		'driver' => 'glassesshop',
		'database' => array
			(
			'type' => 'mysql',
			'connection' => array(
				'hostname' => $_SERVER['COFREE_DB_HOST'],
				'username' => $_SERVER['COFREE_DB_USER'],
				'password' => $_SERVER['COFREE_DB_PASS'],
				'persistent' => FALSE,
				'database' => 'gsorder',
			),
			'table_prefix' => 'gls_',
			'charset' => 'utf8',
			'caching' => FALSE,
			'profiling' => FALSE,
		),
	),
	'boncyboutique' => array(
		'driver' => 'boncyboutique',
		'database' => array( ),
	)
);
