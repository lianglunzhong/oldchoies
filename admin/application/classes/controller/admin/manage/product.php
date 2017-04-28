<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Manage_Product extends Controller_Admin_Site
{

    public function action_all()
    {
        $catalogs = ORM::factory('catalog')->where('site_id', '=', 1)->find_all();
        $content = View::factory('admin/manage/product/all')->set('catalogs', $catalogs)->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_update_log()
    {
//        $update_logs = ORM::factory('manage_product_update_log')->find_all();
//        $content = View::factory('admin/manage/product/update_log')->set('update_logs', $update_logs)->render();
        $content = View::factory('admin/manage/product/update_log_1')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_update_top_log()
    {
        $content = View::factory('admin/manage/product/update_top_log')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_update_log_data()
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
            $key = 0;
            $and = " WHERE ";
            foreach ($filters->rules as $item)
            {
                if ($key)
                    $and = " AND ";
                if ($item->field == 'product_id')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $filter_sql .= $and . $item->field . "='" . $product_id . "'";
                }
                elseif ($item->field == 'created')
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
                    $filter_sql .= $and . $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'user_id')
                {
                    $user_id = DB::select('id')->from('auth_user')->where('name', '=', $item->data)->execute('slave')->current();
                    $filter_sql .= $and . $item->field . "='" . $user_id['id'] . "'";
                }
                else
                {
                    $filter_sql .= $and . $item->field . "='" . $item->data . "'";
                }
                $key++;
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM manage_product_update_logs ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM manage_product_update_logs ' .
                        $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $data)
        {
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                date('Y-m-d H:i:s', $data['created']),
                Product::instance($data['product_id'])->get('sku'),
                Catalog::instance(Product::instance($data['product_id'])->default_catalog())->get('name'),
                $data['action'],
                User::instance($data['user_id'])->get('name'),
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_update_top_log_data()
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
            $key = 0;
            $and = " WHERE ";
            foreach ($filters->rules as $item)
            {
                if ($key)
                    $and = " AND ";
                if ($item->field == 'product_id')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $filter_sql .= $and . $item->field . "='" . $product_id . "'";
                }
                elseif ($item->field == 'created')
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
                    $filter_sql .= $and . $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'user_id')
                {
                    $user_id = DB::select('id')->from('auth_user')->where('name', '=', $item->data)->execute('slave')->current();
                    $filter_sql .= $and . $item->field . "='" . $user_id['id'] . "'";
                }
                else
                {
                    $filter_sql .= $and . $item->field . "='" . $item->data . "'";
                }
                $key++;
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM manage_product_update_top_logs ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM manage_product_update_top_logs ' .
                        $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $data)
        {
            $response['rows'][$i]['id'] = $data['id'];
            $response['rows'][$i]['cell'] = array(
                date('Y-m-d H:i:s', $data['created']),
                Product::instance($data['product_id'])->get('sku'),
                Catalog::instance($data['catalog_id'])->get('name'),
                $data['action'],
                User::instance($data['user_id'])->get('name'),
            );
            $i++;
        }
        echo json_encode($response);
    }

    // 批量输入sku导出产品上下架记录(新品上架和最后一次下架)
    public function action_export_stock_data()
    {
        if($_POST)
        {
            $string = Arr::get($_POST, 'skus', '');
            $skus = explode("\n", $string);
            $products = DB::select('id', 'sku')->from('products_product')->where('sku', 'in', $skus)->execute('slave');
            $product_ids = array();
            $product_data = array();
            foreach($products as $product)
            {
                $product_ids[] = $product['id'];
                $product_data[$product['id']] = $product['sku'];
            }
            $manage_products = DB::select('product_id', 'user_id', 'action', 'created')
                ->from('manage_product_update_logs')
                ->where('product_id', 'IN', $product_ids)
                ->order_by('product_id')
                ->execute('slave');
            $export = array(
                'product_id' => 0,
                'data' => array(),
            );
            $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
            $users = array();
            foreach ($userArr as $user)
            {
                $users[$user['id']] = $user['name'];
            }
            $file = 'visibility';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="Products-' . $file . '.csv"');
            echo "\xEF\xBB\xBF" . "SKU,上架,上架时间,上架人,下架,下架时间,上架人\n";
            foreach($manage_products as $m_product)
            {
                if($m_product['product_id'] != $export['product_id'] && $export['product_id'] != 0)
                {
                    echo $export['data']['sku'] . ',';
                    if(isset($export['data']['new']))
                    {
                        echo '新品上架,';
                        echo date('Y-m-d H:i:s', $export['data']['new_date']) . ',';
                        echo $export['data']['new_user'] . ',';
                    }
                    if(isset($export['data']['out']))
                    {
                        echo '产品下架,';
                        echo date('Y-m-d H:i:s', $export['data']['out_date']) . ',';
                        echo $export['data']['out_user'] . ',';
                    }
                    echo PHP_EOL;
                    $export['data'] = array();
                }
                $export['product_id'] = $m_product['product_id'];
                $export['data']['sku'] = $product_data[$m_product['product_id']];
                if($m_product['action'] == '新品上架')
                {
                    $export['data']['new'] = 1;
                    $export['data']['new_date'] = $m_product['created'];
                    $export['data']['new_user'] = $users[$m_product['user_id']];
                }
                if($m_product['action'] == '产品下架')
                {
                    $export['data']['out'] = 1;
                    $export['data']['out_date'] = $m_product['created'];
                    $export['data']['out_user'] = $users[$m_product['user_id']];
                }
            }
            if(!empty($export['data']))
            {
                echo $export['data']['sku'] . ',';
                if(isset($export['data']['new']))
                {
                    echo '新品上架,';
                    echo date('Y-m-d H:i:s', $export['data']['new_date']) . ',';
                    echo $export['data']['new_user'] . ',';
                }
                if(isset($export['data']['out']))
                {
                    echo '产品下架,';
                    echo date('Y-m-d H:i:s', $export['data']['out_date']) . ',';
                    echo $export['data']['out_user'] . ',';
                }
                echo PHP_EOL;
                $export['product_id'] = $m_product['product_id'];
                $export['data'] = array();
            }
        }
        else
        {
            echo '
                <form method="post" action="">
                Skus:<br/>
                <textarea name="skus" cols="40" rows="20"></textarea><br/>
                <input type="submit" value="Submit" />
                </form>                        
            ';
        }
    }

}

