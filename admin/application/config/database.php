<?php
defined('SYSPATH') OR die('No direct access allowed.');

$config = array
    (
    'default' => array
        (
        'type' => 'mysql',
        'connection' => array(
            /**
             * The following options are available for MySQL:
             *
             * string   hostname
             * string   username
             * string   password
             * boolean  persistent
             * string   database
             *
             * Ports and sockets may be appended to the hostname.
             */
            'hostname' => $_SERVER['COFREE_DB_HOST'],
            'username' => $_SERVER['COFREE_DB_USER'],
            'password' => $_SERVER['COFREE_DB_PASS'],
            'persistent' => FALSE,
            'database' => $_SERVER['COFREE_DB_NAME'],
        ),
        'table_prefix' => '',
        'charset' => 'utf8',
        'caching' => FALSE,
        'profiling' => FALSE,
    ),
    'slave' => array(
        'type' => 'mysql',
        'connection' => array(
            // 'hostname' => $_SERVER['COFREE_DB_HOST'],
            // 'username' => $_SERVER['COFREE_DB_USER'],
            // 'password' => $_SERVER['COFREE_DB_PASS'],
            // 'persistent' => FALSE,
            'database' => $_SERVER['COFREE_DB_NAME'],
            'hostname' => $_SERVER['COFREE_DB_HOST_S'],
            'username' => $_SERVER['COFREE_DB_USER_S'],
            'password' => $_SERVER['COFREE_DB_PASS_S'],
            'persistent' => FALSE,
            'database' => $_SERVER['COFREE_DB_NAME_S'],
        ),
        'table_prefix' => '',
        'charset' => 'utf8',
        'caching' => FALSE,
        'profiling' => TRUE,
    ),
);


// 正品线
$config[0] = $config[1]  = $config[4] = $config[5] = $config['default'];


return $config;

