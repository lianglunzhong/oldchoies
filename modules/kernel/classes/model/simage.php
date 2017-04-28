<?php
/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */
defined('SYSPATH') or die('No direct script access.');

class Model_Simage extends ORM {
	protected $_table_name = 'site_images';

    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );

    protected $_rules = array(
        'file_name' => array(
            'not_empty' => NULL,
            'max_length' => array(255),
        ),
    );
}

