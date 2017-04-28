<?php
defined('SYSPATH') OR die('No direct access allowed.');
// 数据库连接配置文件

return array(
    'default' => array(
        'type' => 'mysqli',
        'connection' => array(
            'hostname' => $_SERVER['COFREE_DB_HOST'],
            'username' => $_SERVER['COFREE_DB_USER'],
            'password' => $_SERVER['COFREE_DB_PASS'],
            'persistent' => FALSE,
            'database' => $_SERVER['COFREE_DB_NAME'],
        ),
        'table_prefix' => '',
        'charset' => 'utf8',
        'caching' => FALSE,
        'profiling' => TRUE,
    ),
    'slave' => array(
        'type' => 'mysqli',
        'connection' => array(
            'hostname' => $_SERVER['COFREE_DB_HOST_S'] . ':' . $_SERVER['COFREE_DB_PORT_S'],
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
