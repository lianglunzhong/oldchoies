<?php
defined('SYSPATH') OR die('No direct access allowed.');

return array(
    // SYS START
    //role
    'role' => array(
        'add' => 'admin/sys/role/add',
        'edit' => 'admin/sys/role/edit',
        'list' => 'admin/sys/role/list',
        'delete' => 'admin/sys/role/delete',
    ),
    //site
    'site' => array(
        'add' => 'admin/sys/site/add',
        'edit' => 'admin/sys/site/edit',
        'list' => 'admin/sys/site/list',
        'delete' => 'admin/sys/site/delete',
        'data' => 'admin/sys/site/data',
    ),
    //user
    'user' => array(
        'add' => 'admin/sys/user/add',
        'edit' => 'admin/sys/user/edit',
        'list' => 'admin/sys/user/list',
        'delete' => 'admin/sys/user/delete',
    ),
    // SYS END
    // SITE START
    //product
    'product' => array(
        'add' => 'admin/site/product/add',
        'config_attributes' => 'admin/site/product/config_attributes',
        'add_simple' => 'admin/site/product/add_simple',
        'add_package' => 'admin/site/product/add_package',
        'add_config' => 'admin/site/product/add_config',
        'edit' => 'admin/site/product/edit',
        'list' => 'admin/site/product/list',
        'delete' => 'admin/site/product/delete',
    ),
    //catalog
    'catalog' => array(
        'add' => 'admin/site/catalog/add',
        'edit' => 'admin/site/catalog/edit',
        'list' => 'admin/site/catalog/list',
        'delete' => 'admin/site/catalog/delete',
        'list' => 'admin/site/catalog/list',
    ),
    //order
    'order' => array(
        'add' => 'admin/site/order/add',
        'edit' => 'admin/site/order/edit',
        'status' => 'admin/site/order/status',
        'refund' => 'admin/site/order/refund',
        'issue' => 'admin/site/order/issue',
        'remark' => 'admin/site/order/remark',
        'list' => 'admin/site/order/list',
        'delete' => 'admin/site/order/delete',
    ),
    //review
    'review' => array(
        'list' => 'admin/site/review/list',
        'edit' => 'admin/site/review/edit',
        'delete' => 'admin/site/review/delete',
    ),
    //customer
    'customer' => array(
        'list' => 'admin/site/customer/list',
        'edit' => 'admin/site/customer/edit',
    ),
    //forums
    'forums' => array(
        'list' => 'admin/site/group/list',
        'edit' => 'admin/site/group/edit',
        'delete' => 'admin/site/group/delete',
        'add' => 'admin/site/group/add',
    ),
    //promotion
    'promotion' => array(
        'list' => 'admin/site/promotion/list',
        'edit' => 'admin/site/promotion/edit',
        'delete' => 'admin/site/promotion/delete',
        'add' => 'admin/site/promotion/add',
        'cart_list' => 'admin/site/promotion/cart_list',
        'cart_add' => 'admin/site/promotion/cart_add',
        'cart_edit' => 'admin/site/promotion/cart_edit',
        'cart_delete' => 'admin/site/promotion/cart_delete',
        'coupon_list' => 'admin/site/promotion/coupon_list',
        'coupon_add' => 'admin/site/promotion/coupon_add',
        'coupon_edit' => 'admin/site/promotion/coupon_edit',
        'coupon_clear' => 'admin/site/promotion/coupon_clear',
        'coupon_del' => 'admin/site/promotion/coupon_del',
    ),
    //News
    'news' => array(
        'list' => 'admin/site/news/list',
        'edit' => 'admin/site/news/edit',
        'del' => 'admin/site/news/del',
        'add' => 'admin/site/news/add',
    ),
    //system
    'system_basic' => array(
        'index' => 'admin/site/basic/index',
        'seo' => 'admin/site/basic/seo',
        'payment' => 'admin/site/basic/payment',
        'currency' => 'admin/site/basic/currency',
    ),
    'system_email' => array(
        'list' => 'admin/site/email/list',
        'edit' => 'admin/site/email/edit',
        'setenable' => 'admin/site/email/setenable',
    ),
    'system_country' => array(
        'list' => 'admin/site/country/list',
        'edit' => 'admin/site/country/edit',
        'delete' => 'admin/site/country/delete',
        'removeup' => 'admin/site/country/removeup',
        'removedown' => 'admin/site/country/removedown',
    ),
    'system_carrier' => array(
        'united' => 'admin/site/carrier/united',
        'delete' => 'admin/site/carrier/delete',
        'default' => 'admin/site/carrier/default',
    ),
    'system_set' => array(
        'list' => 'admin/site/set/list',
        'add' => 'admin/site/set/add',
        'edit' => 'admin/site/set/edit',
        'delete' => 'admin/site/set/delete',
        'export' => 'admin/site/set/export',
    ),
    'system_attribute' => array(
        'list' => 'admin/site/attribute/list',
        'edit' => 'admin/site/attribute/edit',
        'delete' => 'admin/site/attribute/delete',
        'add' => 'admin/site/attribute/add',
    ),
    // SITE END
    // LINE START
    'line' => array(
        'list' => 'line/site/list',
    ),
);
