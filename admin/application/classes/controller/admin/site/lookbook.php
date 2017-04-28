<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Lookbook extends Controller_Admin_Site
{

    public function action_list()
    {
        $content = View::factory('admin/site/lookbook_list')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_data()
    {
        $page = $_REQUEST['page']; // get the requested page
        $limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
        $sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
        $sord = $_REQUEST['sord']; // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        $filter_sql = "";

        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM lookbooks WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM lookbooks WHERE site_id=' . $this->site_id . ' ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $review)
        {
            $response['rows'][$i]['id'] = $review['id'];
            $response['rows'][$i]['cell'] = array(
                $review['id'],
                $review['title'],
                date('Y-m-d', $review['created']),
                $review['visibility'] ? 'Yes' : 'No',
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_add()
    {
        if ($_POST)
        {
            require 'inc_config.php';
            $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
            $images_removed = Arr::get($_POST, 'images_removed', '');
            $imagesRemove = explode(',', $images_removed);
            $image_src = Arr::get($_POST, 'image_src', '');
            foreach ($imagesRemove as $image)
            {
                if ($image && file_exists($dir . $image))
                {
                    unlink($dir . $image);
                    DB::delete('site_images')->where('filename', '=', $image)->execute();
                }
            }
            $lookbook = $_POST['lookbook'];
            $product_sku = Arr::get($_POST, 'product_sku', array());
            $imageArr = explode(',', $image_src);
            foreach ($imageArr as $key => $image)
            {
                if (in_array($image, $imagesRemove))
                {
                    unset($imageArr[$key]);
                    unset($product_sku[$key]);
                }
            }
            $lookbook_images = array();
            if (count($product_sku) < count($imageArr))
            {
                $lookbook_images['main'] = $imageArr[0];
                foreach ($product_sku as $key => $sku)
                {
                    $lookbook_images[$sku] = $imageArr[$key + 1];
                }
            }
            else
            {

                foreach ($product_sku as $key => $sku)
                {

                    $lookbook_images[$sku] = $imageArr[$key];
                }
            }
            $lookbook['images'] = serialize($lookbook_images);
            $lookbook['created'] = time();
            $lookbook['site_id'] = $this->site_id;
            $result = DB::insert('lookbooks', array_keys($lookbook))->values($lookbook)->execute();
            if ($result)
            {
                Message::set(__('Add lookbook success!'), 'success');
                Request::instance()->redirect('admin/site/lookbook/list');
            }
        }

        $content = View::factory('admin/site/lookbook_add')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        if ($_POST)
        {
            require 'inc_config.php';
            $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
            $images_removed = Arr::get($_POST, 'images_removed', '');
            $imagesRemove = explode(',', $images_removed);
            $image_src = Arr::get($_POST, 'image_src', '');
            foreach ($imagesRemove as $image)
            {
                $image_src = str_replace($image, '', $image_src);
                if ($image && file_exists($dir . $image))
                {
                    unlink($dir . $image);
                    DB::delete('site_images')->where('filename', '=', $image)->execute();
                }
            }
            $result = DB::select('images')->from('lookbooks')->where('id', '=', $id)->and_where('site_id', '=', $this->site_id)->execute('slave')->current();
            $imagesArr = $images = unserialize($result['images']);
            $lookbook = $_POST['lookbook'];
            $product_sku = Arr::get($_POST, 'product_sku', array());
            $imageArr = explode(',', $image_src);
            foreach ($imageArr as $key => $image)
            {
                if (in_array($image, $imagesRemove))
                {
                    unset($imageArr[$key]);
                    unset($product_sku[$key]);
                }
            }
            if (count($product_sku) > count($imageArr))
            {
                foreach ($imageArr as $key => $image)
                {
                    $imageArr[$key + 1] = $imageArr[$key];
                }
                $imageArr[0] = $imagesArr['main'];
            }
            $lookbook_images = array();
            $lookbook_images['main'] = $imageArr[0];
            if (!empty($imageArr))
            {
                foreach ($product_sku as $key => $sku)
                {
                    $imagesArr[$sku] = $imageArr[$key];
                }
            }
            foreach ($images as $key => $image)
            {
                if ($image != $imagesArr[$key])
                {
                    if ($image && file_exists($dir . $image))
                    {
                        unlink($dir . $image);
                        DB::delete('site_images')->where('filename', '=', $image)->execute();
                    }
                }
            }
            $lookbook['images'] = serialize($imagesArr);
            $lookbook['created'] = time();
            $lookbook['site_id'] = $this->site_id;
            $result = DB::update('lookbooks')->set($lookbook)->where('id', '=', $id)->execute();
            if ($result)
            {
                Message::set(__('Edit lookbook success!'), 'success');
                Request::instance()->redirect('admin/site/lookbook/list');
            }
        }

        $lookbook = DB::select()->from('lookbooks')->where('id', '=', $id)->and_where('site_id', '=', $this->site_id)->execute('slave')->current();
        $content_data['lookbook'] = $lookbook;
        $content = View::factory('admin/site/lookbook_edit', $content_data)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_delete()
    {
        require 'inc_config.php';
        $dir = $resource_dir . DIRECTORY_SEPARATOR . $this->site_id . DIRECTORY_SEPARATOR . 'simages' . DIRECTORY_SEPARATOR;
        $id = $this->request->param('id');
        $result = DB::select('images')->from('lookbooks')->where('id', '=', $id)->execute('slave')->current();
        if ($result)
        {
            $images = unserialize($result['images']);
            foreach ($images as $image)
            {
                if ($image && file_exists($dir . $image))
                {
                    unlink($dir . $image);
                    DB::delete('site_images')->where('filename', '=', $image)->execute();
                }
            }
            $delete = DB::delete('lookbooks')->where('id', '=', $id)->execute();
            if ($delete)
            {
                message::set(__('Delete loobook success'), 'success');
                Request::instance()->redirect('admin/site/lookbook/list');
            }
        }
        else
        {
            message::set(__('Lookbook not exist'), 'error');
            Request::instance()->redirect('admin/site/lookbook/list');
        }
    }

    public function action_test_es()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $keywords = isset($_GET['q']) ? $_GET['q'] : 'dress';
        $search_res = $elastic->search($keywords, array('name', 'sku', 'description', 'keywords'));
        print_r($search_res);
        exit;
    }

    public function action_test_memcache()
    {
        $key = Arr::get($_GET, 'key', '');
        $data = Cache::instance('memcache')->get($key);
        var_dump($data);
        exit;
    }

}

?>