<?php
/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */
//定义mime_content_type开始（以防服务器没有mime_content_type函数支持）
if( ! function_exists('mime_content_type'))
{

        function mime_content_type($ext)
        {

                $mime_types = array(
                    'png' => 'image/png',
                    'jpe' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'jpg' => 'image/jpeg',
                    'gif' => 'image/gif',
                    'bmp' => 'image/bmp',
                    'ico' => 'image/vnd.microsoft.icon',
                );

                if(array_key_exists($ext, $mime_types))
                {
                        return $mime_types[$ext];
                }
                elseif(function_exists('finfo_open'))
                {
                        $finfo = finfo_open(FILEINFO_MIME);
                        $mimetype = finfo_file($finfo, $filename);
                        finfo_close($finfo);
                        return $mimetype;
                }
                else
                {
                        return 'application/octet-stream';
                }
        }

}

//定义mime_content_type结束
//<===============定义图片resize函数开始
function image_resize($srcFile, $toW, $toH, $toFile="")
{
        if($toFile == "")
        {
                $toFile = $srcFile;
        }
        $info = "";
        $data = GetImageSize($srcFile, $info);
        switch( $data[2] )
        {
                case 1:
                        if( ! function_exists("imagecreatefromgif"))
                        {
                                echo "你的GD库不能使用GIF格式的图片，请使用Jpeg或PNG格式！<a href='javascript:go(-1);'>返回</a>";
                                exit();
                        }
                        $im = ImageCreateFromGIF($srcFile);
                        break;
                case 2:
                        if( ! function_exists("imagecreatefromjpeg"))
                        {
                                echo "你的GD库不能使用jpeg格式的图片，请使用其它格式的图片！<a href='javascript:go(-1);'>返回</a>";
                                exit();
                        }
                        $im = ImageCreateFromJpeg($srcFile);
                        break;
                case 3:
                        $im = ImageCreateFromPNG($srcFile);
                        break;
        }
        $srcW = ImageSX($im);
        $srcH = ImageSY($im);
        $toWH = $toW / $toH;
        $srcWH = $srcW / $srcH;
        if($toWH <= $srcWH)
        {
                $ftoW = $toW;
                $ftoH = $ftoW * ($srcH / $srcW);
        }
        else
        {
                $ftoH = $toH;
                $ftoW = $ftoH * ($srcW / $srcH);
        }
        if($srcW > $toW || $srcH > $toH)
        {
                if(function_exists("imagecreatetruecolor"))
                {
                        @$ni = ImageCreateTrueColor($ftoW, $ftoH);
                        if($ni) ImageCopyResampled($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
                        else
                        {
                                $ni = ImageCreate($ftoW, $ftoH);
                                ImageCopyResized($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
                        }
                }
                else
                {
                        $ni = ImageCreate($ftoW, $ftoH);
                        ImageCopyResized($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
                }
                if(function_exists('imagejpeg')) ImageJpeg($ni, $toFile);
                else ImagePNG($ni, $toFile);
                ImageDestroy($ni);
        }else
        {
                copy($srcFile, $toFile);
        }
        ImageDestroy($im);
}

//定义图片resize函数结束=============>

$file = $_GET['file'];
$file_data = explode('.', $file);
$fid = $file_data[0];
$ext = isset($file_data[1]) ? $file_data[1] : 'jpg';
require 'inc_config.php';

if( ! isset($admin_image_sizes[$_GET['size']]))
{
        header("HTTP/1.1 404 Not Found");
        exit;
}
$file = $resource_dir.DIRECTORY_SEPARATOR.$site_id.DIRECTORY_SEPARATOR.'thumbnails'.DIRECTORY_SEPARATOR.$fid.'_'.$_GET['size'].'.'.$ext;
if( ! file_exists($file))
{
        $src_file = $resource_dir.DIRECTORY_SEPARATOR.$site_id.DIRECTORY_SEPARATOR.'pimages'.DIRECTORY_SEPARATOR.$fid.'.'.$ext;

        if( ! file_exists($src_file))
        {
                header("HTTP/1.1 404 Not Found");
                exit;
        }
        else
        {
                image_resize($src_file, $admin_image_sizes[$_GET['size']][0], $admin_image_sizes[$_GET['size']][1], $file);
        }
}
if(file_exists($file))
{
        send_modification_header(filemtime($file));
        $mime_type = @mime_content_type($ext);
        header('Content-type: '.$mime_type);
        echo file_get_contents($file);
}
else
{
        header("HTTP/1.1 404 Not Found");
        exit;
}

