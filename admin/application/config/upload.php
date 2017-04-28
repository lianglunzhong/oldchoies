<?php
defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 处理上传文件的参数
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */
return array(
    'temp_folder' => '/media/upload_tmp',
    'resource_dir' => $_SERVER['COFREE_UPLOAD_DIR'],
    'product_image' => array(
        //'target_folder'=>'/uploads/product_images',
        'filetypes' => array(
            'jpg',
            'jpeg',
            'gif',
            'png',
        ),
        'max_size' => 2094152, //2M
        'type' => 1,
    ),
    'site_image' => array(
        'filetypes' => array(
            'jpg',
            'jpeg',
            'gif',
            'png',
        ),
        'max_size' => 2094152, //2M
    ),
    'image_types' => array(
        1 => 'product_image'
    )
);
