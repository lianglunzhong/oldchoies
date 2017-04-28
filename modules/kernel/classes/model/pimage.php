<?php
/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */
defined('SYSPATH') or die('No direct script access.');

class Model_Pimage extends ORM {
	protected $_table_name = 'product_images';

    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'file_name' => array(
            'not_empty' => NULL,
            'max_length' => array(255),
        ),
    );

    protected $_belongs_to = array('product' => array());

}