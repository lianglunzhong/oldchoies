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
    //'temp_folder'=>'/uploads/temp',
    'resource_dir' => 'upload',
    'product_image' => array(
        //'target_folder'=>'/uploads/product_images',
        'filetypes' => array(
            'jpg',
            'jpeg',
            'gif',
            'png',
        ),
        'type' => 1
    ),
    'image_types' => array(
        1 => 'product_image'
    )
);
