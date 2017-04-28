<?php

defined('SYSPATH') OR die('No direct access allowed.');
/**
 * config every sites(use site_id as key)
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */
return array(
    'images' => array(
        'dresses' => array('silhouette'),
        'shirt-blouse' => array('silhouette'),
        'skirts' => array('silhouette'),
        'skirt' => array('silhouette'),
        'shoes' => array('most popular'),
        'all' => array('pattern type'),
    ),
    'colors' => array(
        'White','Silver','Gray','Black','Pink','Red','Orange','Khaki','Beige','Yellow','Gold','Brown','Purple','Green','Blue','Multi'
    ),
	'product' => array(
        '6693','35050'
    ),
    'price' => array(
        'keys' => array(
            0 => '$0 - $20',
            1 => '$20 - $40',
            2 => '$40 - $60',
            3 => '$60 - $80',
            4 => '$80 - $100',
            5 => '$100 - $120',
            6 => '$120 +',
        ),
        'values' => array(
            0 => '0-20',
            1 => '20-40',
            2 => '40-60',
            3 => '60-80',
            4 => '80-100',
            5 => '100-120',
            6 => '120-1000',
        )
    ),
);