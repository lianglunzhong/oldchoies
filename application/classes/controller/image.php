<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Image extends Controller
{

        /**
         * $from_pic为base64_encode之后的图片地址
         *
         */
        private $image_class;

        public function __construct()
        {
                define("FILTER_IP", false); //是否过滤ip
                define("FONT", 'MONACO.TTF');
                define("TIME", 3600); //缓存1小时
                require_once(Kohana::find_file('classes', 'ThumbLib'));
                require_once(Kohana::find_file('classes', 'curl'));
                $this->image_class = image::instance();
        }

        public function action_resize($width, $height, $from_pic)
        {
                //$ip为ip2long之后的        
                $cc = new curl();
                $ip = sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
                if(FILTER_IP)
                {
                        $is_allowed_ip = $this->image_class->is_allowed($ip);
                }

                if((FILTER_IP && $is_allowed_ip) || ! FILTER_IP)
                {
                        //允许的ip，比如1040340550或者3359583509
                        $from_pic = trim(base64_decode($from_pic), '/');
                        $url_arr = parse_url($from_pic);
                        $host = $url_arr['host'];
                        $fullpath = $url_arr['path'];
                        $path = substr($url_arr['path'], 0, strrpos($fullpath, '/'));
                        $suffix = '_'.$width.'_'.$height; //图片大小后缀
                        $image_name = substr($fullpath, strrpos($fullpath, '/') + 1);
                        $image_name_resized = str_replace('.', '_'.$width.'_'.$height.'.', $image_name); //缩略后生成的小图            
                        if( ! is_dir('./media/images-service/'.$host.$path))
                        {
                                mkdir('./media/images-service/'.$host.$path, 777, true);
                        }
                        if(is_file('./media/images-service/'.$host.$path.'/'.$image_name))
                        {
                                //如果文件已经存在并且没有过期，则不重新curl到本地
                                $fileinfo = stat('./media/images-service/'.$host.$path.'/'.$image_name);
                                $last_modified = $fileinfo[9];
                                $now = time();
                                // die(date('Y-m-d H:i:s',$last_modified).'ff'.date('Y-m-d H:i:s'));
                                if($last_modified + TIME > $now)
                                {
                                        //die(date('Y-m-d H:i:s'));
                                        $img_real_path = './media/images-service/'.$host.$path.'/'.$image_name;
                                        //die($img_real_path);
                                }
                                else
                                {
                                        //下载大图到本地
                                        $img_real_path = $cc->download($img, $host.$path, $image_name);
                                }
                        }
                        else
                        {
                                //curl大图到本地
                                if( ! is_dir('./media/images-service/'.$host.$path))
                                {
                                        mkdir('./media/images-service/'.$host.$path, 777, true);
                                }
                                //下载大图到本地
                                $img_real_path = $cc->download($img, $host.$path, $image_name);
                        }
                        //$img_real_path=$cc->download($from_pic,$host.$path,$image_name);//下载大图到本地
                        if(is_file('./media/images-service/'.$host.$path.'/'.$image_name_resized))
                        {
                                //如果小图已经生成，并且未过期
                                $fileinfo = stat('./media/images-service/'.$host.$path.'/'.$image_name_resized);
                                $last_modified = $fileinfo[9];
                                $now = time();
                                // die(date('Y-m-d H:i:s',$last_modified).'ff'.date('Y-m-d H:i:s'));
                                if($last_modified + TIME > $now)
                                {
                                        //$img_real_path='./media/images-service/'.$host.$path.'/'.$image_name;
                                        //die($img_real_path);
                                        header('Content-type: image/jpeg');
                                        echo file_get_contents('./media/images-service/'.$host.$path.'/'.$image_name_resized);
                                        die();
                                }
                                else
                                {
                                        //否则删除过期图片
                                        unlink('./media/images-service/'.$host.$path.'/'.$image_name_resized);
                                }
                        }
                        try
                        {
                                $thumb = PhpThumbFactory::create('./media/images-service/'.$host.$path.'/'.$image_name);
                        }
                        catch( Exception $e )
                        {
                                die('Error handling your request.');
                        }
                        $thumb->resize($width, $height);
                        $thumb->save('./media/images-service/'.$host.$path.'/'.$image_name_resized); //生成小图到本地
                        $headers = 'Content-type: image/jpeg';
                        header($header);
                        $thumb->show(); //显示生成的小图**/
                }
                else
                {
                        //未被允许的ip
                        die('no access allowed.');
                }
        }

        /**
          @param $img 待加的原图
          @param $str 要加的水印文字，或者要加的水印图片
          @param $type 1为文字，2为图片
         */
        public function action_watermark($img, $str, $type=1)
        {
                //若为文字水印，$str为base64_encode加密过的要加水印的文字；若为图片水印，$str为水印图片的地址(相对于./media/image_services/logo/)
                $str = base64_decode($str);
                $cc = new curl();
                $img = base64_decode($img);
                $url_arr = parse_url($img);
                $host = $url_arr['host'];
                $fullpath = $url_arr['path'];
                $path = substr($url_arr['path'], 0, strrpos($fullpath, '/'));
                $image_name = substr($fullpath, strrpos($fullpath, '/') + 1);
                $image_name = str_replace('.', '_0'.'.', $image_name); //要加水印的原图
                if(is_file('./media/images-service/'.$host.$path.'/'.$image_name))
                {
                        //如果文件已经存在并且没有过期，则不重新curl到本地
                        $fileinfo = stat('./media/images-service/'.$host.$path.'/'.$image_name);
                        $last_modified = $fileinfo[9];
                        $now = time();
                        // die(date('Y-m-d H:i:s',$last_modified).'ff'.date('Y-m-d H:i:s'));
                        if($last_modified + TIME > $now)
                        {
                                //die(date('Y-m-d H:i:s'));
                                $img_real_path = './media/images-service/'.$host.$path.'/'.$image_name;
                                //die($img_real_path);
                        }
                        else
                        {
                                $img_real_path = $cc->download($img, $host.$path, $image_name); //下载大图到本地
                        }
                }
                else
                {
                        //否则，curl到本地
                        if( ! is_dir('./media/images-service/'.$host.$path))
                        {
                                mkdir('./media/images-service/'.$host.$path, 777, true);
                        }
                        $img_real_path = $cc->download($img, $host.$path, $image_name); //下载大图到本地
                }
                //die($img_real_path);
                //字体放在/media/fonts下,//水印图片放在/media/fonts下
                $im = $this->image_class->make_watermark($str, $img_real_path, FONT, $type); //生成文字水印
                //url调用示例：http://cola.local/image/watermark/aHR0cDovL2hvbWUucGhwY2hpbmEuY29tL2F0dGFjaG1lbnQvMjAxMDA2LzEzLzkxMzY0XzEyNzY0MTg2NzA4M1dMLnBuZw==/aGVsbG8gd29ybGQ=/1
                //image调用示例
                //http://cola.local/image/watermark/aHR0cDovL2hvbWUucGhwY2hpbmEuY29tL2F0dGFjaG1lbnQvMjAxMDA2LzEzLzkxMzY0XzEyNzY0MTg2NzA4M1dMLnBuZw==/MS5qcGc=/2
                header('Content-type: image/jpeg');
                imagepng($im);
        }

        public function action_microtime()
        {
                list($usec, $sec) = explode(" ", microtime());
                return ((float) $usec + (float) $sec);
        }

}
