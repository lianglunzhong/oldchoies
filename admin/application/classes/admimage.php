<?php
class Admimage
{
    //生成后台图片链接,$image应是一个数组('id','suffix')
    public static function link($site_id,$image,$size)
    {
        return 'pimages.php?id='.$image['id'].'&size='.$size.'&ext='.$image['suffix'];
    }
}
