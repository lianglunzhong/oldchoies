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
    1 => array(
        'thumbnail_sizes' => array(
            0 => array(91, 91),
            1 => array(400, 400),
            2 => array(800, 800),
            3 => array(140, 140),
            4 => array(100, 100),
        ),
        'group_types' => array(
            0 => 'Forum Boards',
            1 => 'Interest Groups',
            2 => 'Other Features'
        ),
        'specific_groups' => array(
            'product' => 1,
            'unreplied' => 2,
            'latest' => 3,
        ),
        'language' => array(
            'en',
            'es',
            'de',
            'fr',
        ),
        'languageupdate' => array(
            //'en',
            'es',
            'de',
            'fr',
        ),
        'googlekey'=>array(
            'AIzaSyCkkN2KK4sVqxAtUa6_GQcHUq13IAyssuo'
        ),
    ),
);
