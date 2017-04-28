<?php
defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Site_Tools extends Controller_Admin_Site
{
    public function action_product_update()
    {
        ini_set("max_execution_time","0");
        set_time_limit(0);
        $folder = $_SERVER['DOCUMENT_ROOT'].'/media/upload_tmp/product_update_csv';
        if(!is_dir($folder))
        {
            exit;
        }
        $paths = scandir($folder);

        //如果出现超时情况，设置onebyone为1，每次只导一个并删除。
        $onebyone = Arr::get($_GET,'onebyone',0);
        $action = Arr::get($_GET,'action',NULL);

        foreach($paths as $path)
        {
            if($path[0] != '.' AND is_file($folder.'/'.$path) AND $handle = fopen($folder.'/'.$path,'r'))
            {
                echo 'FILE: '.$path.'<br />';
                $this->product_update($handle);
                if($onebyone)
                {
                    if($action == 's')
                    {
                        unlink($folder.'/'.$path);
                        echo '--&gt Delete: '.$path.'<br />';
                    }
                    exit;
                }
            }
        }
    }

    private function product_update($handle)
    {
        //若action=s 执行写入操作。否则仅仅验证。
        $action = Arr::get($_GET,'action',NULL);
        //若check_existing=0 不验证产品是否存在
        $check_existing = Arr::get($_GET,'check_existing',1);
        //若only_wholesale_price=1 仅处理形如price_3这样的字段，其余字段无视
        $only_wholesale_price = Arr::get($_GET,'only_wholesale_price',0);
        //unikey=sku或id的列序，如有时候sku不在第一列，可以省去手动调整的工作
        $uni_key = Arr::get($_GET,'unikey',0);

        $site_id = Site::instance()->get('id');

        $titles = fgetcsv($handle);
        $unikey = 'id';
        if(strtolower($titles[$uni_key]) == 'sku')
        {
            $unikey = 'sku';
        }
        elseif(strtolower($titles[$uni_key]) != 'id')
        {
            echo 'Error: `id` or `sku` should be first.<br />';
            return FALSE;
        }

        $bulk_keys = array();
        foreach($titles as $k => $v)
        {
            if(preg_match('/^price_(\d+)$/',$v,$match))
            {
                $bulk_keys[$match[1]] = $k;
            }
        }
        ksort($bulk_keys);
        if(empty($bulk_keys) AND $only_wholesale_price)
        {
            echo 'Error: no bulk_price found.<br />';
            return FALSE;
        }

        while($data = fgetcsv($handle))
        {
            $set = array();
            $same = 0;

            if(!empty($_GET['auto_link']) AND $_GET['auto_link'] == 1 AND ($name_key = array_search('name',$titles)) !== FALSE AND ($link_key = array_search('link',$titles)) !== FALSE)
            {
                if(empty($data[$link_key]))
                {
                    $data[$link_key] = strtolower(preg_replace('/[^\w\b]+/','-',$data[$name_key]));
                }
            }

            if($check_existing)
            {
                $result = DB::query(Database::SELECT,"SELECT id FROM products WHERE ".$unikey." = '".trim($data[$uni_key])."' AND site_id = $site_id")->execute('slave')->as_array();
                if(!$result)
                {
                    echo 'Error: '.implode(',',$data).' -- Product does not exist.<br />';
                    continue;
                }
            }

            if($bulk_keys)
            {
                $bulk_rules = array();
                foreach($bulk_keys as $num => $key)
                {
                    if(!empty($data[$key]))
                    {
                        $bulk_rules[$num] = trim($data[$key]);
                    }
                }
                if($bulk_rules)
                {
                    $result = DB::query(Database::SELECT,"SELECT configs FROM products WHERE ".$unikey." = '".trim($data[$uni_key])."' AND site_id = $site_id")->execute('slave');
                    if($result)
                    {
                        $configs = empty($result[0]['configs']) ? array() : unserialize($result[0]['configs']);
                        if($configs === FALSE OR !is_array($configs))
                        {
                            echo 'Error: '.implode(',',$data).' -- illegal_configs in DB: '.$result[0]['configs'].' -- has been dropped.<br />';
                            $configs = array();
                        }
                        $configs['bulk_rules'] = $bulk_rules;
                        $set[] = "`configs` = '".serialize($configs)."'";
                    }
                }
            }

            if(!$only_wholesale_price)
            {
                foreach($data as $k=>$v)
                {
                    if($k == $uni_key OR FALSE !== in_array($k,$bulk_keys))
                    {
                        continue;
                    }
                    if($titles[$k] == 'sku' OR $titles[$k] == 'link')
                    {
                        $same = DB::query(Database::SELECT,"SELECT id FROM products WHERE ".$unikey." != '".trim($data[$uni_key])."' AND ".$titles[$k]." = '".$data[$k]."' AND site_id = $site_id")->execute('slave')->as_array();
                        if($same)
                        {
                            echo 'Error: '.implode(',',$data).' -- Duplicated '.$titles[$k].' with id:'.$same[0]['id'].'<br />';
                            break;
                        }
                    }
                    $set[] = '`'.$titles[$k]."` = '".htmlspecialchars($v,ENT_QUOTES)."'";
                }
                if($same)
                {
                    continue;
                }
            }

            if($action == 's' AND !empty($set))
            {
                DB::query(Database::UPDATE,'UPDATE products SET '.implode(',',$set)." WHERE ".$unikey." = '".trim($data[$uni_key])."' AND site_id = $site_id")->execute();
                echo 'UPDATE products SET '.implode(',',$set)." WHERE ".$unikey." = '".trim($data[$uni_key])."' AND site_id = $site_id".'<br />';
            }
        }
        echo '--&gt; '.($action == 's' ? 'Update' : 'Validation').' complete.<br />';
    }

    public function action_generate_sitemap()
    {
        $site = Site::instance();
        $site_id = $site->get('id');

        // FIXME get protocol from db.
        $protocol = 'http';
        $domain = Arr::get($_GET,'domain','');
        if(!$domain)
        {
            $domain = $site->get('domain');
        }
        $content_data['url_base'] = $protocol.'://'.$domain;

        $route_type = $site->get('route_type');
        switch( $route_type )
        {
        case 2:
            $content_data['product_link_template'] = $protocol.'://'.$domain.'/'.$site->get('product').'/{link}';
            $content_data['catalog_link_template'] = $protocol.'://'.$domain.'/{link}';
            $content_data['tags_link_template'] = $protocol.'://'.$domain.'/tags/{link}';
            break;
        default:
            $content_data['product_link_template'] = $protocol.'://'.$domain.'/'.$site->get('product').'/{id}';
            $content_data['catalog_link_template'] = $protocol.'://'.$domain.'/'.$site->get('catalog').'/{id}';
            $content_data['tags_link_template'] = $protocol.'://'.$domain.'/tags/{link}';
            break;
        }

        $content_data['catalogs'] = ORM::factory('catalog')
            ->where('visibility','=',1)
            ->and_where('site_id','=',$site_id)
            ->find_all();
        $content_data['products'] = ORm::factory('product')
            ->where('visibility','=',1)
            ->and_where('status', '=', 1)
            ->and_where('site_id','=',$site_id)
            ->find_all();

        $tags = ORm::factory('label')
            ->where('site_id','=',$site_id)
            ->find_all();
        if($tags)
        {
            $content_data['tags'] = $tags;
        }
        else
        {
            $content_data['tags'] = array();
        }

        $filename = 'sitemap.xml';
        header("Content-type:text/xml");
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');

        echo View::factory('admin/site/sitemap',$content_data);
    }

    public function action_upload()
    {
        if ($_FILES)
        {
            $path = $_FILES['zipfile']['tmp_name'];
            $zip = new ZipArchive();
            if (!$zip->open($path))
            {
                die("failed to open zip file: $path\n");
            }

            $upload_path = DOCROOT . "media/upload_tmp/";
            if (!file_exists($upload_path))
            {
                mkdir($upload_path, 0755, TRUE) 
                    or die("failed to create upload dir: $upload_path\n");
            }

            if (!$zip->extractTo($upload_path))
            {
                die("failed to extract zip file to $upload_path\n");
            }

            // page redirection means success
            $this->request->redirect('/admin/site/tools/upload');
        }

        $this->request->response = <<<EOD
        <form method="post" enctype="multipart/form-data" action="">
            <input type="file" id="zipfile" name="zipfile" />
            <input type="submit" value="Upload!" />
        </form>
EOD;
    }
}
