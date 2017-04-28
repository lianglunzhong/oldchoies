<?php
/**
 * Description of file
 *
 * @package
 * @author    FangHao
 * @copyright    © 2010 Cofree Development Group
 */

//Define mime type
if( ! function_exists('mime_content_type'))
{

	function mime_content_type($filename)
	{

		$mime_types = array(
			'txt' => 'text/plain',
			'htm' => 'text/html',
			'html' => 'text/html',
			'php' => 'text/html',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',
			'swf' => 'application/x-shockwave-flash',
			'flv' => 'video/x-flv',
			// images
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',
			// archives
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'exe' => 'application/x-msdownload',
			'msi' => 'application/x-msdownload',
			'cab' => 'application/vnd.ms-cab-compressed',
			// audio/video
			'mp3' => 'audio/mpeg',
			'qt' => 'video/quicktime',
			'mov' => 'video/quicktime',
			// adobe
			'pdf' => 'application/pdf',
			'psd' => 'image/vnd.adobe.photoshop',
			'ai' => 'application/postscript',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript',
			// ms office
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint',
			// open office
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);

		$ext = strtolower(array_pop(explode('.', $filename)));
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
function image_resize($srcFile, $toW, $toH, $toFile="", $need_watermark)
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
/*        
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
 */
        $ftoW = $toW;
        $ftoH = $ftoW * ($srcH / $srcW);
        if($srcW > $toW || $srcH > $toH)
        {
                if(function_exists("imagecreatetruecolor"))
                {
                        @$ni = ImageCreateTrueColor($ftoW, $ftoH);
                        if($ni)
                        {
                                ImageCopyResampled($ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH);
                        }
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

                if($need_watermark == 1)
                {
                        watermark($ni);
                }

                if(function_exists('imagejpeg'))
                {
                        ImageJpeg($ni, $toFile);
                }
                else
                {
                        ImagePNG($ni, $toFile);
                }
                ImageDestroy($ni);
        }
        else
        {
                if($need_watermark == 1)
                {
                        watermark($im);
                }

                if(function_exists('imagejpeg'))
                {
                        ImageJpeg($im, $toFile, 100);
                }
                else
                {
                        ImagePNG($im, $toFile, 100);
                }
        }
        ImageDestroy($im);
}

require 'inc_config.php';
$file = $resource_dir.DIRECTORY_SEPARATOR.$site_id.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$_GET['name'];

if(file_exists($file))
{
    send_modification_header(filemtime($file));
	$mime_type = @mime_content_type(basename($_GET['name']));
    header('Content-type: '.$mime_type);
    echo file_get_contents($file);
}
else
{
    header("HTTP/1.1 404 Not Found");
    exit;
}

