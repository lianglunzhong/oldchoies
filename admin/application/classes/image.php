<?php
defined('SYSPATH') or die('No direct script access.');

class Image
{

    public static function upload($site_id = 0, $p_obj_id = null, $p_id = null, $return = FALSE)
    {
        $source_file = isset($_GET['qqfile']) ? $_GET['qqfile'] : (isset($_FILES['qqfile']) ? $_FILES['qqfile']['name'] : '');

        if($source_file)
        {
            $request_folder = str_replace('/', '', $_REQUEST['folder']);
            if($p_obj_id == null)
            {
                if($request_folder == 'site_image')
                {
                    $target_path = kohana::config('upload.resource_dir').DIRECTORY_SEPARATOR.$site_id.DIRECTORY_SEPARATOR.'simages';
                }
                else
                {
                    $target_path = str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].kohana::config('upload.temp_folder'));
                }
            }
            else
            {
                $target_path = kohana::config('upload.resource_dir').DIRECTORY_SEPARATOR.$site_id.DIRECTORY_SEPARATOR.'pimages';
            }

            if($target_path == '' OR ! kohana::config('upload.'.$request_folder))
            {
                $response['error'] = "Server error. Upload directory isn't writable.";
                echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
            }

            if( ! ($size = self::qqfileupload_get_size()))
            {
                $response['error'] = 'File is empty.';
                echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
            }

            $max_size = kohana::config('upload.'.$request_folder.'.max_size');
            if($size > $max_size)
            {
                $response['error'] = 'File is too large.';
                echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
            }

            $file_parts = pathinfo($source_file);

            $filetypes = kohana::config('upload.'.$request_folder.'.filetypes');
            $ext = strtolower($file_parts['extension']);

            if(in_array($ext, $filetypes))
            {
                //生成随机文件名，存在临时文件夹:
                if($p_obj_id == null)
                {
                    //TODO 
                    $char_pool = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    do
                    {
                        $file_name = substr(str_shuffle($char_pool), 0, 10).'.'.$ext;
                    }
                    while( file_exists($target_path.'/'.$file_name) );

                    $target_file = $target_path.'/'.$file_name;
                    $upload_result = self::qqfileupload_save($target_file);
                    //for Controller_Admin_Site_Image:
                    if($return)
                    {
                        return $upload_result ? $file_name : FALSE;
                    }
                }

                //替换现有图片:
                elseif($p_id != null)
                {
                    $image = ORM::factory('image', $p_id);
                    if($image->loaded() AND $image->obj_id == $p_obj_id)
                    {
                        $file_name = $p_id.'.'.$ext;
                        $target_file = $target_path.'/'.$file_name;

                        $upload_result = self::qqfileupload_save($target_file);

                        self::clear_cache($p_id);
                    }
                }
                //给对象新增图片:
                else
                {
                    $p_type = kohana::config('upload.'.$request_folder.'.type');
                    if($p_type != '' AND $image_id = self::set('new_upload', $p_type, $site_id, $p_obj_id))
                    {
                        $upload_result = TRUE;
                        $file_name = $image_id.'.'.$ext;
                        $response['file_id'] = $image_id;
                    }
                    else
                    {
                        $upload_result = FALSE;
                    }
                }

                if($upload_result)
                {
                    $response['success'] = 'true';
                    $response['filename'] = $file_name;
                }
                else
                {
                    $response['error'] = '图片比例不是3/4，请重新上传';
                }
            }
            else
            {
                $response['error'] = 'File has an invalid extension, it should be one of '.implode(',', $filetypes).'.';
            }
        }
        else
        {
            $response['error'] = 'No files were uploaded.';
        }
        echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
    }

    public static function upload1($site_id = 0, $p_obj_id = null, $p_id = null, $return = FALSE)
    {
        $source_file = isset($_GET['qqfile']) ? $_GET['qqfile'] : (isset($_FILES['file_phone']) ? $_FILES['file_phone']['name'] : '');

        if($source_file)
        {
            $request_folder = 'site_image';
            if($p_obj_id == null)
            {
                if($request_folder == 'site_image')
                {

                    $target_path = kohana::config('upload.resource_dir').DIRECTORY_SEPARATOR.$site_id.DIRECTORY_SEPARATOR.'simages';

                }
                else
                {
                    $target_path = str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].kohana::config('upload.temp_folder'));
                }
            }
            else
            {
                $target_path = kohana::config('upload.resource_dir').DIRECTORY_SEPARATOR.$site_id.DIRECTORY_SEPARATOR.'pimages';
            }

            if($target_path == '' OR ! kohana::config('upload.'.$request_folder))
            {
                $response['error'] = "Server error. Upload directory isn't writable.";
                echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
            }

            if( ! ($size = self::qqfileupload_get_size()))
            {
                $response['error'] = 'File is empty.';
                echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
            }

            $max_size = kohana::config('upload.'.$request_folder.'.max_size');
            if($size > $max_size)
            {
                $response['error'] = 'File is too large.';
                echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
            }

            $file_parts = pathinfo($source_file);

            $filetypes = kohana::config('upload.'.$request_folder.'.filetypes');
            $ext = strtolower($file_parts['extension']);

            if(in_array($ext, $filetypes))
            {
                //生成随机文件名，存在临时文件夹:
                if($p_obj_id == null)
                {
                    //TODO 
                    $char_pool = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    do
                    {
                        $file_name = substr(str_shuffle($char_pool), 0, 10).'.'.$ext;
                    }
                    while( file_exists($target_path.'/'.$file_name) );

                    $target_file = $target_path.'/'.$file_name;
                    $upload_result = self::qqfileupload_save1($target_file);
                    //for Controller_Admin_Site_Image:
                    if($return)
                    {
                        return $upload_result ? $file_name : FALSE;
                    }
                }

                //替换现有图片:
                elseif($p_id != null)
                {
                    $image = ORM::factory('image', $p_id);
                    if($image->loaded() AND $image->obj_id == $p_obj_id)
                    {
                        $file_name = $p_id.'.'.$ext;
                        $target_file = $target_path.'/'.$file_name;

                        $upload_result = self::qqfileupload_save($target_file);

                        self::clear_cache($p_id);
                    }
                }
                //给对象新增图片:
                else
                {
                    $p_type = kohana::config('upload.'.$request_folder.'.type');
                    if($p_type != '' AND $image_id = self::set('new_upload', $p_type, $site_id, $p_obj_id))
                    {
                        $upload_result = TRUE;
                        $file_name = $image_id.'.'.$ext;
                        $response['file_id'] = $image_id;
                    }
                    else
                    {
                        $upload_result = FALSE;
                    }
                }

                if($upload_result)
                {
                    $response['success'] = 'true';
                    $response['filename'] = $file_name;
                }
                else
                {
                    $response['error'] = 'Could not save uploaded file.The upload was cancelled, or server error encountered';
                }
            }
            else
            {
                $response['error'] = 'File has an invalid extension, it should be one of '.implode(',', $filetypes).'.';
            }
        }
        else
        {
            $response['error'] = 'No files were uploaded.';
        }
        echo htmlspecialchars(json_encode($response), ENT_NOQUOTES);
    }

    public static function set($p_file, $p_type, $p_site_id, $p_obj_id=0)
    {
        // type image,product,system
        $image = ORM::factory('image');
        $image->type = $p_type;
        $image->site_id = $p_site_id;
        $image->obj_id = $p_obj_id;

        $file_parts = pathinfo($p_file == 'new_upload' ? (isset($_GET['qqfile']) ? $_GET['qqfile'] : (isset($_FILES['qqfile']) ? $_FILES['qqfile']['name'] : '')) : $p_file);
        $image->suffix = strtolower($file_parts['extension']);

        $sitedir = kohana::config('upload.resource_dir').DIRECTORY_SEPARATOR.$p_site_id.DIRECTORY_SEPARATOR;

        $uploaddir = $sitedir.'pimages';
        if( ! is_dir($sitedir))
        {
            mkdir($sitedir);
            mkdir($uploaddir);
            mkdir($sitedir.'simages'.DIRECTORY_SEPARATOR);
            mkdir($sitedir.'thumbnails'.DIRECTORY_SEPARATOR);
        }

        $image->save();
        Session::instance()->set('b2b_sync_sku', Product::instance($image->obj_id)->get('sku'));
        $file_name = $image->id.".".$image->suffix;
        $uploadfile = $uploaddir.DIRECTORY_SEPARATOR.$file_name;

        if($p_file == 'new_upload')
        {
            $moved = self::qqfileupload_save($uploadfile);
        }
        else
        {
            $moved = copy($p_file, $uploadfile);
        }

        if($moved)
        {
            $fileearr = getimagesize($uploadfile);
            $bilv = $fileearr[0] / $fileearr[1];
            if($bilv == 0.75)
            {       
                return $image->id;
            }
            else
            {
                if(file_exists($uploadfile))
                {
                    //删除上传的图片
                    self::delete($image->id);
                }
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

    public static function get_by_product_id($product_id)
    {
        $images = ORM::factory('image')->where('obj_id', '=', $product_id)->and_where('type', '=', kohana::config('upload.product_image.type'))->find_all();
        $data = array( );
        foreach( $images as $image )
        {
            $data[$image->id] = Image::get($image);
        }

        return $data;
    }

    /**
     * 	获得一个图片的完整链接，包含http://
     * @param array $imagte 包含图片id,图片后缀的数组
     * @param int $size 图片尺码
     * @return string 图片地址
     */
    public static function link($image, $size)
    {
        $site_id = Site::instance()->get('id');
        if( ! is_array($image) OR $image['id'] == '')
        {

            $image = array(
                'id' => 0,
                'suffix' => 'jpg',
                'status' => 0,
            );
        }

       // if (Arr::get($_SERVER, 'HTTPS', 'off') == 'on')
       // {
       //         return 'https://'.Site::instance()->get('domain').'/pimages/'.$image['id'].'/'.$size.'.'.$image['suffix'];
       // }
       // else
       // {
       //         return 'http://'.Site::instance()->get('domain').'/pimages/'.$image['id'].'/'.$size.'.'.$image['suffix'];
       // }
        $sizeArr = array(
            1 => 270, 2 => 420, 3 => 75, 7 => 192
        );
        if(array_key_exists($size, $sizeArr))
        {
            $img_size = $sizeArr[$size];
            $img_no = ($image['id'] % 3) + 1;
            return STATICURL.'/pimg/' . $img_size . '/' . $image['id'] . '.' . $image['suffix'];
        }
        elseif($size == 9)
        {
            return STATICURL.'/pimg/o/' . $image['id'] . '.' . $image['suffix'];
        }
        // if($image['status'] == 1)
        //     return 'http://img.choies.com/pimages1/'.$image['id'].'/'.$size.'.'.$image['suffix'];
        // else
        //     return 'http://img.choies.com/pimages/'.$image['id'].'/'.$size.'.'.$image['suffix'];
    }


    //guo add get feedlink
    public static function linkfeed($image, $size)
    {
        $site_id = Site::instance()->get('id');
        if( ! is_array($image) OR $image['id'] == '')
        {

            $image = array(
                'id' => 0,
                'suffix' => 'jpg',
                'status' => 0,
            );
        }

       // if (Arr::get($_SERVER, 'HTTPS', 'off') == 'on')
       // {
       //         return 'https://'.Site::instance()->get('domain').'/pimages/'.$image['id'].'/'.$size.'.'.$image['suffix'];
       // }
       // else
       // {
       //         return 'http://'.Site::instance()->get('domain').'/pimages/'.$image['id'].'/'.$size.'.'.$image['suffix'];
       // }
        $sizeArr = array(
            1 => 270, 2 => 420, 3 => 75, 7 => 192
        );
        if(array_key_exists($size, $sizeArr))
        {
            $img_size = $sizeArr[$size];
            $img_no = ($image['id'] % 3) + 1;
            return STATICURL.'/feedimage/' . $img_size . '/' . $image['id'] . '.' . $image['suffix'];
        }
        elseif($size == 9)
        {
            return STATICURL.'/feedimage/' . $image['id'] . '.' . $image['suffix'];
        }
        // if($image['status'] == 1)
        //     return 'http://img.choies.com/pimages1/'.$image['id'].'/'.$size.'.'.$image['suffix'];
        // else
        //     return 'http://img.choies.com/pimages/'.$image['id'].'/'.$size.'.'.$image['suffix'];
    }

    public static function get($image)
    {
        //TODO $path
        $path = 'product_images';
        if($image->loaded())
        {
            return $path.DIRECTORY_SEPARATOR.$image->id.'.'.$image->suffix;
        }
        else
        {
            // no image
            return $path.DIRECTORY_SEPARATOR.'no_image'.'.'.'jpg';
        }
    }

    public static function get_by_id($id)
    {
        $image = ORM::factory('image', $id);
        return Image::get($image);
    }

    /** guo add **/
    public static function getjdpic($image)
    {
        $img = $image['id'] . '.' . $image['suffix'];
        $path = '@/home/data/www/htdocs/clothes/uploads/1/pimages/'.$img;
        
         return $path;    
    }

    /**
     * 	从数据库与文件系统中删除一个图片。
     * @param int $id 图片ID
     * @return bool
     */
    public static function delete($id)
    {
        $image = ORM::factory('image', $id);
        if($image->loaded())
        {
            $dir = kohana::config('upload.resource_dir').DIRECTORY_SEPARATOR.$image->site_id.DIRECTORY_SEPARATOR.'pimages';
            if($dir == '')
            {
                return FALSE;
            }
            $file_name = $image->id.".".$image->suffix;
            $file = $dir.'/'.$file_name;

            if(file_exists($file))
            {
                unlink($file);
            }

            $sizes = array(
                1,2,3,4,5,6,7,8,9,99
            );
            $dir1 = kohana::config('upload.resource_dir').DIRECTORY_SEPARATOR.$image->site_id.DIRECTORY_SEPARATOR.'thumbnails';
            foreach($sizes as $i)
            {
                $file_name = $image->id."_".$i.".".$image->suffix;
                $file = $dir1.'/'.$file_name;
                if(file_exists($file))
                {
                    unlink($file);
                }   
            }

            $dir2 = kohana::config('upload.resource_dir').DIRECTORY_SEPARATOR.$image->site_id.DIRECTORY_SEPARATOR.'thumbnails1';
            foreach($sizes as $i)
            {
                $file_name = $image->id."_".$i.".".$image->suffix;
                $file = $dir2.'/'.$file_name;
                if(file_exists($file))
                {
                    unlink($file);
                }   
            }

            self::clear_cache($image->id);

            $image->delete($id);
            Session::instance()->set('b2b_sync_sku', Product::instance($image->obj_id)->get('sku'));
            return TRUE;
        }
        return FALSE;
    }

    /**
     * 删除某图片的缓存
     * @param <type> $id  图片id
     */
    public static function clear_cache($id)
    {
        $image = ORM::factory('image', $id);
        if( ! $image->loaded())
        {
            return FALSE;
        }
        $sizes = kohana::config('sites.'.$image->site_id.'.thumbnail_sizes');
        $sizes[99] = array( 120, 120 );
        $pimages_dir = kohana::config('upload.resource_dir').DIRECTORY_SEPARATOR.$image->site_id.DIRECTORY_SEPARATOR.'pimages';
        foreach( $sizes as $key => $size )
        {
            $file = $pimages_dir.DIRECTORY_SEPARATOR.$image->id.'_'.$key.'.'.$image->suffix;
            if(file_exists($file))
            {
                unlink($file);
            }
        }
    }

    public static function qqfileupload_save($path)
    {
        if(isset($_GET['qqfile']))
        {
            $input = fopen("php://input", "r");
            $temp = tmpfile();
            $realSize = stream_copy_to_stream($input, $temp);
            fclose($input);

            $target = fopen($path, "w");
            fseek($temp, 0, SEEK_SET);
            stream_copy_to_stream($temp, $target);
            fclose($target);

            return true;
        }
        elseif(isset($_FILES['qqfile']))
        {
            if( ! move_uploaded_file($_FILES['qqfile']['tmp_name'], $path))
            {
                return false;
            }
            return true;
        }
        return FALSE;
    }

    public static function qqfileupload_save1($path)
    {
        if(isset($_GET['file_phone']))
        {
            $input = fopen("php://input", "r");
            $temp = tmpfile();
            $realSize = stream_copy_to_stream($input, $temp);
            fclose($input);

            $target = fopen($path, "w");
            fseek($temp, 0, SEEK_SET);
            stream_copy_to_stream($temp, $target);
            fclose($target);

            return true;
        }
        elseif(isset($_FILES['file_phone']))
        {
            if( ! move_uploaded_file($_FILES['file_phone']['tmp_name'], $path))
            {
                return false;
            }
            return true;
        }
        return FALSE;
    }

    public static function qqfileupload_get_size()
    {
        if(isset($_GET['qqfile']))
        {
            if(isset($_SERVER["CONTENT_LENGTH"]))
            {
                return (int) $_SERVER["CONTENT_LENGTH"];
            }
        }
        elseif(isset($_FILES['qqfile']))
        {
            return $_FILES['qqfile']['size'];
        }
        return FALSE;
    }

    public static function qqfileupload_get_size1()
    {
        if(isset($_GET['file_phone']))
        {
            if(isset($_SERVER["CONTENT_LENGTH"]))
            {
                return (int) $_SERVER["CONTENT_LENGTH"];
            }
        }
        elseif(isset($_FILES['file_phone']))
        {
            return $_FILES['file_phone']['size'];
        }
        return FALSE;
    }

    //$style,1为文字,2为图片
    public static function make_watermark($url, $img, $font, $style)
    {
        //die(realpath($img));
        $im = Watermark::instance($url, $font, $style)->setImg($img); //true时显示图片
        return $im;
    }

    //图片尺寸配置 --- sjm 2016-01-07
    public static function size_array()
    {
        $sizeArr = array(
            1 => 270, 2 => 420, 3 => 75, 7 => 192, 4 => 200,
        );
        return $sizeArr;
    }

}
