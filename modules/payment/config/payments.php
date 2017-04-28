<?php
defined('SYSPATH') or die('No direct script access.');
return array
(
	// Credit Card
	'CC' => array
	(
		'name' => 'CreditPay',
		'driver' => 'creditcard',
	),
	//PP Jump
	'PP' => array(
		'name' => 'PPJump',
		'driver' => 'ppjump',
	),
    //GC Jump
    'GC' => array(
		'name' => 'GlobalCollect',
		'driver' => 'globalcollect',
	),
	// PP Express
	'EC' => array(
		'name' => 'PPExpress',
		'driver' => 'ppec'
	),
	// PP Express
	'ECTEST' => array(
		'name' => 'PPExpress',
		'driver' => 'ppectest'
	),
	// PP Express
	'PPM' => array(
		'name' => 'PPMobile',
		'driver' => 'ppmobile'
	),
	//ThirdPartyPay
	'TPP' => array(
		'name' => 'ThirdPartyPay',
		'driver' => 'tpp'
	),
	'OC' => array(
		'name' => 'OceanPay',//类名
		'driver' => 'oceanpay'//文件名
	),
    //GLOBEBILL
    'GLOBEBILL' => array(
        'name'    => 'globebill',
        'driver'  => 'globebill',
        'product' => array(
            'url'      => 'https://pays.globebill.com/payment/Interface',
            'MerNo'    => '887026',
            'password' => '',
            'MD5key '  => 'n[sFdmid'
        ),
    ),
    'IPAY' =>array(
        'name' => 'Ipay',
        'driver' => 'ipay',
    ),
    'MASAPAY' =>array(
        'name' => 'Masapay',
        'driver' => 'Masapay',
    ),
);
