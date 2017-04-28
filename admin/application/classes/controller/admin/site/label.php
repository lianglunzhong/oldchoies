<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Label extends Controller_Admin_Site
{

    public function action_list()
    {
        $content = View::factory('admin/site/label_list')
            ->render();
        $this->request->response = View::factory('admin/template')
                ->set('content', $content)->render();
    }

    public function action_setting()
    {
        if ($_POST)
        {
            $_POST = Security::xss_clean($_POST);
            $label = ORM::factory("labelmeta", $_POST['id']);
            unset($_POST['id']);
            $label->values($_POST)
                ->save();
            Message::set("Update general setting successfully!");
        }
        $label = ORM::factory("labelmeta")
            ->where('site_id', '=', $this->site_id)
            ->find();
        if ($label->loaded())
        {
            $content = View::factory('admin/site/label_setting')
                ->set("label", $label)
                ->render();
            $this->request->response = View::factory('admin/template')
                    ->set('content', $content)->render();
        }
        else
        {
            ORM::factory("labelmeta")->values(array("site_id" => $this->site_id))->save();
            $this->request->redirect('admin/site/label/setting');
        }
    }

    //for Add Niche-Catalog
    public function action_add()
    {
        if ($_POST)
        {
            $_POST = Security::xss_clean($_POST);
            $result = $this->execute_add($_POST, 'catalog');
            if ($result === true)
                Message::set('Add label successfully!', 'success');
            else
                Message::set($result, 'error');
        }
        $template = '<a onclick="set_catalog({id});return false;" id="catalog_{id}" href="#" title="select catalog">{name}</a>';
        $data['catalog_tree'] = Controller_Admin_Site_Catalog::get_left_tree($this->site_id, $template);
        $content = View::factory('admin/site/label_add', $data)
            ->render();
        $this->request->response = View::factory('admin/template')
                ->set('content', $content)->render();
    }

    public function action_delete()
    {
        if ($_POST)
        {
            if (!empty($_POST['labels']))
            {
                foreach ($_POST['labels'] as $id)
                {
                    ORM::factory('label', $id)->delete();
                }
                message::set('delete label successfully!');
            }
            else
            {
                message::set('Please select the label you want to delete first.', 'error');
            }
        }
        $this->request->redirect('/admin/site/label/list');
    }

    //Add Niche-Related
    public function action_add_related()
    {
        if ($_POST)
        {
            $_POST = Security::xss_clean($_POST);
            $result = $this->execute_add($_POST, 'related');
            if ($result === true)
                Message::set('Add label successfully!', 'success');
            else
                Message::set($result, 'error');
        }
        $catalogs = DB::select('defined_catalog')
            ->from('labels')
            ->where('site_id', '=', $this->site_id)
            ->where('is_active', '=', 1)
            ->distinct(true)
            ->execute('slave')
            ->as_array();
        $content = View::factory('admin/site/label_add_related')
            ->set('catalogs', $catalogs)
            ->render();
        $this->request->response = View::factory('admin/template')
                ->set('content', $content)->render();
    }

    public function action_active()
    {
        DB::query(Database::UPDATE, 'update `labels` set `is_active`= NOT `is_active` where `id`=' . $_POST['id'])
            ->execute();
    }

    public function action_data()
    {
        //TODO fixed the post
        $page = Arr::get($_REQUEST, 'page', 0); // get the requested page
        $limit = Arr::get($_REQUEST, 'rows', 0); // get how many rows we want to have into the grid
        $sidx = Arr::get($_REQUEST, 'sidx', 0); // get index row - i.e. user click to sort
        $sord = Arr::get($_REQUEST, 'sord', 0); // get the direction
        //filter
        $filters = Arr::get($_REQUEST, 'filters', array());

        if ($filters)
        {
            $filters = json_decode($filters);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $filter_sql = "1";
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if ($item->field == 'created')
                {
                    $date = explode(' to ', $item->data);
                    $count = count($date);
                    $from = strtotime($date[0]);
                    if ($count == 1)
                    {
                        $to = strtotime($date[0] . ' +1 day -1 second');
                    }
                    else
                    {
                        $to = strtotime($date[1] . ' +1 day -1 second');
                    }
                    $_filter_sql[] = $item->field . " between " . $from . " and " . $to;
                }
                //TODO add filter items
                elseif ($item->field == 'niche' || $item->field == 'url')
                {
                    $_filter_sql[] = $item->field . " like '%" . $item->data . "%'";
                }
                else
                {
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }
        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`labels`.`id`) AS num FROM `labels` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql)->execute('slave');
        $count = $result[0]['num'];
        $total_pages = 0;
        if ($count > 0)
        {
            $total_pages = ceil($count / $limit);
        }

        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;
        $result = DB::query(DATABASE::SELECT, 'SELECT `labels`.* FROM `labels` WHERE site_id=' . $this->site_id . ' AND '
                . $filter_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;
        $cats = ORM::factory('catalog')
            ->where('site_id', '=', $this->site_id)
            ->find_all();
        $catalogs = array();
        foreach ($cats as $cat)
            $catalogs[$cat->id] = $cat->name;
        foreach ($result as $value)
        {
            //$this->iconv_array($value);
            $response['rows'][] = array(
                'id' => $value['id'],
                'cell' => array(
                    '',
                    $value['id'],
                    date('Y-m-d H:i', $value['created']),
                    $value['niche'],
                    $value['url'],
                    $value['catalog_id'] != '' && $value['catalog_id'] != 0 && isset($catalogs[$value['catalog_id']]) ? $catalogs[$value['catalog_id']] : '',
                    $value['defined_catalog'],
                    $value['display_number'],
                    $value['local'],
                    $value['global'],
                    $value['competition'],
                    $value['is_active'] == 1 ? 'Yes' : 'No'
                )
            );
        }
        echo json_encode($response);
    }

    public function action_edit()
    {
        $id = $this->request->param('id');
        $label = ORM::factory('label')
            ->where('id', '=', $id)
            ->find();
        if (!$label->loaded())
        {
            Message::set('No such Label.', 'error');
            $this->request->redirect('/admin/site/label/list');
        }
        if (isset($_POST['skus']))
        {
            $skus = Arr::get($_POST, 'skus', '');
            $skus = explode(',', $skus);
            if (!empty($skus))
            {
                $product_ids = array();
                foreach ($skus as $sku)
                {
                    $product = ORM::factory('product')
                        ->where('sku', '=', trim($sku))
                        ->where('visibility', '=', 1)
                        ->where('site_id', '=', $this->site_id)
                        ->find();
                    if ($product->loaded())
                        $product_ids[] = $product->id;
                }
                $product_ids = implode(',', $product_ids);
                $label->product_ids = $product_ids;
                $label->save();
                Message::set('Replace Products Success.');
            }
            else
            {
                Message::set('Fail', 'error');
            }
            $this->request->redirect('/admin/site/label/edit/' . $label->id);
        }

        if ($_POST)
        {
            $label->values(array(
                'product_ids' => Arr::get($_POST, 'product_ids', ''),
                'global' => Arr::get($_POST, 'global', ''),
                'local' => Arr::get($_POST, 'local', ''),
                'competition' => Arr::get($_POST, 'competition', ''),
                'description' => Arr::get($_POST, 'description', ''),
                'display_number' => Arr::get($_POST, 'display_number', ''),
                'meta_title' => Arr::get($_POST, 'meta_title', ''),
                'meta_description' => Arr::get($_POST, 'meta_description', ''),
                'meta_keywords' => Arr::get($_POST, 'meta_keywords', '')
            ));
            if ($label->check())
            {
                $label->save();
                message::set('Edit document successfully');
            }
            $this->request->redirect('/admin/site/label/edit/' . $label->id);
        }
        $selected_sku = '';
        if ($label->product_ids != '')
        {
            $product_ids = explode(',', $label->product_ids);
            foreach ($product_ids as $key => $id)
            {
                $product = ORM::factory('product', $id);
                if ($product->loaded())
                    $skus[] = $product->sku;
            }
            $selected_sku = implode(',', $skus);
        }

        $content = View::factory('admin/site/label_edit', array('label' => $label, 'selected_sku' => $selected_sku))
            ->render();
        $this->request->response = View::factory('admin/template')
                ->set('content', $content)->render();
    }

    public function action_bulk_upload()
    {
        if ($_POST)
        {
            if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv"))
                Message::set("Only csv file type is allowed!");
            else
            {
                $handle = fopen($_FILES["file"]["tmp_name"], "r");
                $row = 1;
                $column = array();
                $error = array();
                while ($data = fgetcsv($handle))
                {
                    if ($row == 1)
                        $column = $data;
                    else
                    {
                        for ($i = 0; $i < count($data); $i++)
                            $post[$column[$i]] = $data[$i];
                        $post = Security::xss_clean($post);
                        $result = $this->execute_add($post, $_POST['style']);
                        if ($result !== true)
                            $error[] = "Add " . Arr::get($post, 'niche', '') . " row " . $row . " fail:" . $result;
                    }
                    $row++;
                }
                if (count($error) > 0)
                    Message::set(implode(".<br/>", $error), 'error');
                else
                    Message::set('Bulk upload successfully!');
            }
        }
        $content = View::factory('admin/site/label_bulk_upload')
            ->render();
        $this->request->response = View::factory('admin/template')
                ->set('content', $content)->render();
    }

    public function execute_add($data, $type)
    {
        $data['url'] = preg_replace('/&|\#|\?|\%| |\//', '-', $data['url']);
        $label = ORM::factory('label')
            ->where('url', '=', $data['url'])
            ->where('site_id', '=', $this->site_id)
            ->find();
        if ($label->loaded())
        {
            return "Duplicate label url";
        }
        else
        {
            if (Arr::get($data, 'display_number', 30) == '')
                $data['display_number'] = 30;
            //set displayed products info
            switch ($type)
            {
                case 'catalog':
                    if ($data['catalog_id'] == '')
                        return 'The Catalog shouldn\'t be null';
                    if (Arr::get($data, 'random', 1) == 1)
                    {
                        $products = DB::query(Database::SELECT, "SELECT p.id FROM products p 
						LEFT JOIN catalog_products c 
						ON p.id=c.product_id 
						WHERE c.catalog_id=" . $data['catalog_id'] . " AND p.visibility=1 AND p.site_id=" . $this->site_id)
                            ->execute('slave')
                            ->as_array();
                        $product_num = count($products) < Arr::get($data, 'display_number', 30) ? count($products) : Arr::get($data, 'display_number', 30);
                        if ($product_num == 0)
                            return 'No product in this catalog.';
                        $rand_id = array_rand($products, $product_num);
                        $product = array();
                        foreach ($rand_id as $id)
                            $product[] = $products[$id]['id'];
                        $data['product_ids'] = implode(',', $product);
                    }
                    break;
                case 'related':
                    if ($data['defined_catalog'] == '')
                        return 'The Defined_Catalog shouldn\'t be null';
                    $data['defined_catalog_link'] = preg_replace('/&|\#|\?|\%| |\//', '-', $data['defined_catalog']);
                    $label = ORM::factory("label")
                        ->where('defined_catalog_link', '=', $data['defined_catalog_link'])
                        ->where('defined_catalog', '<>', $data['defined_catalog'])
                        ->find();
                    if ($label->loaded())
                    {
                        return "Duplicate catalog url";
                    }

                    $products = DB::query(DATABASE::SELECT, "SELECT p.id,MATCH(p.name,p.sku,p.keywords) AGAINST('" . $data['niche'] . "') AS score FROM products p 
					            WHERE MATCH (p.name,p.sku,p.keywords) AGAINST ('" . $data['niche'] . "' IN BOOLEAN MODE)
					            AND p.visibility = 1 AND p.site_id = " . $this->site_id . " ORDER BY score DESC limit 0," . Arr::get($data, 'display_number', 30))->execute('slave');
                    $product = array();
                    if (count($products) > 0)
                    {
                        foreach ($products as $pro)
                            $product[] = $pro['id'];
                        shuffle($product);
                    }
                    else
                    {
                        $products = ORM::factory('product')
                            ->where('site_id', '=', $this->site_id)
                            ->where('visibility', '=', 1)
                            ->order_by(DB::expr('RAND()'))
                            ->limit(Arr::get($data, 'display_number', 30))
                            ->find_all();
                        foreach ($products as $pro)
                            $product[] = $pro->id;
                    }
                    $data['product_ids'] = implode(',', $product);
                    break;
            }
            $new_label = ORM::factory('label');
            $data['site_id'] = $this->site_id;
            $data['created'] = time();
            $new_label->values($data);
            if ($new_label->check())
            {
                $new_label->save();
                return true;
            }
            return "Add label fail";
        }
    }

}

?>