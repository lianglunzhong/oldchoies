<?php

defined('SYSPATH') OR die('No direct access allowed.');

return array(
    'sorts' => array(
        '0' => array(
            'name' => "Default",
            'field' => 'position',
            'queue' => 'desc'
        ),
        '1' => array(
            'name'  => "What's New",
            'field' => 'display_date',
            'queue' => 'desc'
        ),
        '2'     => array(
            'name'  => 'Best Seller',
            'field' => 'hits',
            'queue' => 'desc'
        ),
        '3'     => array(
            'name'  => 'Price: Low To High',
            'field' => 'price',
            'queue' => 'asc'
        ),
        '4'     => array(
            'name'   => 'Price: High To Low',
            'field'  => 'price',
            'queue'  => 'desc'
        ),
    ),
    'limits' => array(
        '1'      => 100,
        '2'      => 32,
        '3'      => 48,
    ),
    'colors' => array(
        '','Pink','Red','Purple','Brown','Black','Beige','Orange','Blue','Gray','White','Yellow','Green','Multi'
    )
//    'colors' => array(
//        "1"  => "beige",
//        "2"  => "black",
//        "3"  => "blue",
//        "4"  => "brown",
//        "5"  => "gray",
//        "6"  => "green",
//        "7"  => "pink",
//        "8"  => "orange",
//        "9"  => "purple",
//        "10" => "red",
//        "11" => "white",
//        "12" => "yellow",
//        "13" => "animal",
//        "14" => "bronze",
//        "15" => "floral",
////        "16" => "gold",
//        "17" => "metallic",
//        "18" => "multi",
//        "19" => "plaid",
///        "20" => "silver",
//        "21" => "stripe"
//    )
);
