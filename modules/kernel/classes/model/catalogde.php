<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Catalogde extends ORM
{
        protected $_table_name = 'catalogs_de';
        protected $_filters = array(
            TRUE => array( 'trim' => NULL )
        );
        protected $_rules = array
            (
            'name' => array(
                'not_empty' => NULL,
                'max_length' => array( 255 ),
            ),
            'link' => array(
                'not_empty' => NULL,
                'max_length' => array( 255 ),
            ),
            'image_src' => array(
                'max_length' => array( 255 ),
            ),
            'image_link' => array(
                'max_length' => array( 255 ),
            ),
            'image_alt' => array(
                'max_length' => array( 255 ),
            ),
            'meta_title' => array(
                'max_length' => array( 65535 ),
            ),
            'meta_keyword' => array(
                'max_length' => array( 65535 ),
            ),
            'meta_description' => array(
                'max_length' => array( 65535 ),
            ),
            'description' => array(
                'max_length' => array( 65535 ),
            ),
            'parent_id' => array(
                'not_empty' => NULL,
            ),
        );
        protected $_has_many = array(
            'products' => array( 'model' => 'product', 'through' => 'catalog_products' )
        );

}

