<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Orderprocurement extends Controller_Admin_Site
{

    private $attr = array(
        'S' => 'Size:S;',
        'M' => 'Size:M;',
        'L' => 'Size:L;',
        'XL' => 'Size:XL;',
        'XS' => 'Size:XS;',
        'XXS' => 'Size:XXS;',
        '35' => 'Size:US4/UK2-UK2.5/EUR35/22.5cm;',
        '36' => 'Size:US5/UK3-UK3.5/EUR36/23cm;',
        '37' => 'Size:US6/UK4-UK4.5/EUR37/23.5cm;',
        '38' => 'Size:US7/UK5-UK5.5/EUR38/24cm;',
        '39' => 'Size:US8/UK6-UK6.5/EUR39/24.5cm;',
        '40' => 'Size:US9/UK7-UK7.5/EUR40/25cm;',
        '41' => 'Size:US10/UK8-UK8.5/EUR41/25.5cm;'
    );

    public function action_list()
    {
        $content = View::factory('admin/site/orderprocurement_list')->render();
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
                    $filter_sql .= " AND " . $item->field . " between " . $from . " and " . $to;
                }
                elseif ($item->field == 'name' OR $item->field == 'wangwang' OR $item->field == 'remark')
                {
                    $filter_sql .= " AND " . $item->field . " LIKE '%" . $item->data . "%'";
                }
                else
                {
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
                }
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
//                $limit = 20;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM order_procurements WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM order_procurements WHERE site_id=' . $this->site_id . ' ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $array)
        {
            $response['rows'][$i]['id'] = $array['id'];
            $response['rows'][$i]['cell'] = array(
                $array['id'],
                $array['ordernum'],
                $array['sku'],
                $array['quantity'],
                $array['attributes'],
                $array['price'],
                date('Y-m-d', $array['created']),
                $array['type'],
                $array['name'],
                $array['wangwang'],
                $array['remark'],
                $array['cn_carrier'],
                $array['cn_tracking_code'],
                $array['confirm'],
                $array['purchase_id'],
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_edit()
    {
        if ($_POST)
        {
            if (!isset($_POST['id']) OR !$_POST['id'])
            {
                Message::set('Edit Failed', 'error');
                echo '<script language="javascript">top.location.replace("http://' . $_SERVER['HTTP_HOST'] . '/admin/site/orderprocurement/list");</script>';
                exit;
            }
            $update = $_POST;
            $p_id = $update['id'];
            unset($update['id']);
            $update['order_id'] = Order::get_from_ordernum($update['ordernum']);
            if (!$update['order_id'])
                $update['order_id'] = 0;
            $result = DB::update('order_procurements')->set($update)->where('id', '=', $p_id)->execute();
            if ($result)
            {
                Message::set('Edit success', 'success');
                echo "Edit success";
                //echo '<script language="javascript">top.location.replace("http://' . $_SERVER['HTTP_HOST'] . '/admin/site/orderprocurement/list");</script>';
                exit;
            }
            else
            {
                Message::set('Edit Failed', 'error');
                echo "Edit Failed!";
                //echo '<script language="javascript">top.location.replace("http://' . $_SERVER['HTTP_HOST'] . '/admin/site/orderprocurement/list");</script>';
                exit;
            }
        }
        $id = $this->request->param('id');
        $data = DB::select('id', 'ordernum', 'sku', 'quantity', 'attributes', 'price', 'name', 'wangwang', 'type', 'remark','cn_carrier','cn_tracking_code')->from('order_procurements')->where('id', '=', $id)->execute('slave')->current();
        $this->request->response = View::factory('admin/site/orderprocurement_edit')
            ->set('procurement', $data)
            ->render();
    }

    public function action_upload()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        while ($data = fgetcsv($handle))
        {
            if ($row == 1)
            {
                $date = $data[10] ? strtotime($data[10]) : strtotime(date('Y-m-d'));
                $row++;
                continue;
            }
            try
            {
                if (!$data[2])
                    continue;
                if ($data[3] < 1)
                    $data[3] = 1;
                $array = array();
                $array['purchase_id'] = $data[0];
                $array['ordernum'] = $data[1];
                if (strpos($array['ordernum'], 'chictipia') === 0)
                {
                    $array['order_id'] = 0;
                }
                else
                    $array['order_id'] = Order::get_from_ordernum(trim($data[1]));
                $array['sku'] = $data[2];
                $array['quantity'] = $data[3];
                $array['attributes'] = $data[4];
                $array['price'] = $data[5] / $data[3];
                $array['name'] = iconv('GB2312', 'UTF-8', $data[6]);
                $array['wangwang'] = iconv('GB2312', 'UTF-8', $data[7]);
                $array['type'] = iconv('GB2312', 'UTF-8', $data[8]);
                $array['remark'] = iconv('GB2312', 'UTF-8', $data[9]);
                $array['created'] = $date;
                $result1 = DB::insert('order_procurements', array_keys($array))->values($array)->execute();
                if (!$result1)
                {
                    $error[] = "Add order procurements " . $array['email'] . " Fail.";
                }
                elseif ($array['type'] != '备货' OR $array['type'] != '缺货')
                {
                    $result2 = DB::select('sku', 'quantity', 'attributes', 'price')
                        ->from('orders_orderitem')
                        ->where('order_id', '=', $array['order_id'])
                        ->and_where('sku', '=', $array['sku']);
                    if ($array['attributes'])
                    {
                        $result2 = $result2->and_where('attributes', 'like', '%' . $array['attributes'] . '%');
                    }
                    else
                    {
                        $result2 = $result2->and_where('attributes', '=', '');
                    }
                    $result2 = $result2->execute('slave')->current();
                    if (!$result2)
                    {
                        $order = DB::select('sku', 'quantity', 'attributes', 'price')
                            ->from('orders_orderitem')
                            ->where('order_id', '=', $array['order_id'])
                            ->and_where('sku', '=', $array['sku'])
                            ->execute('slave')
                            ->current();
                        $data = array();
                        $data['ordernum'] = $array['ordernum'];
                        $data['p_sku'] = $array['sku'];
                        $data['p_attributes'] = $array['attributes'];
                        $data['p_quantity'] = $array['quantity'];
                        $data['p_price'] = $array['price'];
                        $data['remark'] = $array['remark'];
                        $data['sku'] = $order['sku'];
                        $data['attributes'] = $order['attributes'];
                        $data['quantity'] = $order['quantity'];
                        $data['price'] = $order['price'];
                        $checks[] = $data;
                    }
                }

                $row++;
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        $num = $row - count($error) - 1;
        echo "Upload " . $num . " order procurements successfully.<br>";
        echo 'Check with order items:' . '<br>';
        if (!empty($checks))
        {
            echo '<table cellspacing="1" cellpadding="1" border="1">';
            echo '<tr><td>Ordernum</td><td>Procurement Sku</td><td>Procurement Attributes</td><td>Procurement Quantity</td><td>Procurement Price</td><td>Remark</td><td>Sku</td><td>Attributes</td><td>Quantity</td><td>Price</td></tr>';
            foreach ($checks as $check)
            {
                echo '<tr>';
                echo '<td>' . $check['ordernum'] . '</td>';
                echo '<td>' . $check['p_sku'] . '</td>';
                echo '<td>' . $check['p_attributes'] . '</td>';
                echo '<td>' . $check['p_quantity'] . '</td>';
                echo '<td>' . $check['p_price'] . '</td>';
                echo '<td>' . $check['remark'] . '</td>';
                echo '<td>' . $check['sku'] . '</td>';
                echo '<td>' . $check['attributes'] . '</td>';
                echo '<td>' . $check['quantity'] . '</td>';
                echo '<td>' . $check['price'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        exit;
    }

    public function action_export()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'start', 0));
//                $date += 28800; /* 8 hours */		
        // 添加更新结束时间
        $date_end = Arr::get($_POST, 'end', 0);

        if ($date_end)
        {
            $file_name = "orderprocurements-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
//			$date_end += 28800;
        }
        else
        {
            $file_name = "orderprocurements-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "订单号,Sku,数量,Attribute,Cost(RMB),Price,Order Cost,Coupon Code,Order Price,Created,类型,采购产品名称,旺旺户名,备注\n";
        $result = DB::query(DATABASE::SELECT, 'SELECT order_procurements.*,orders.coupon_code FROM order_procurements LEFT JOIN orders ON order_procurements.order_id=orders.id WHERE order_procurements.site_id=' . $this->site_id . ' AND order_procurements.created >= ' . $date . ' AND order_procurements.created < ' . $date_end)->execute('slave')->as_array();
        $order_cost = 0;
        foreach ($result as $key => $procurement)
        {
            $ordernum = $procurement['ordernum'];
            $coupon = $procurement['coupon_code'];
            $order_price = Order::instance($procurement['order_id'])->get('amount');
            if ($key > 0)
            {
                if ($procurement['ordernum'] == $result[$key - 1]['ordernum'])
                {
                    $ordernum = '';
                    $coupon = '';
                    $order_price = '';
                }
            }
            $price = DB::select('price')->from('orders_orderitem')
                    ->where('sku', '=', $procurement['sku'])
                    ->and_where('order_id', '=', $procurement['order_id'])
                    ->execute('slave')->get('price');

            $order_cost += $procurement['price'];
            echo $ordernum . ',';
            echo $procurement['sku'] . ',';
            echo $procurement['quantity'] . ',';
            echo $procurement['attributes'] . ',';
            echo $procurement['price'] . ',';
            echo $price . ',';
            if ($key < count($result))
            {
                if ($procurement['ordernum'] != $result[$key + 1]['ordernum'])
                {
                    echo $order_cost . ',';
                    $order_cost = 0;
                }
                else
                {
                    echo ',';
                }
            }
            echo $coupon . ',';
            echo $order_price . ',';
            echo date('Y-m-d', $procurement['created']) . ',';
            echo $procurement['type'] . ',';
            echo $procurement['name'] . ',';
            echo $procurement['wangwang'] . ',';
            echo $procurement['remark'] . ',';
            echo "\n";
        }
    }

    public function action_sub_check()
    {
        $date = strtotime(Arr::get($_POST, 'start', 0));
        if ($date)
        {
            // 添加更新结束时间
            $date_end = Arr::get($_POST, 'end', 0);

            if ($date_end)
            {
                $date_end = strtotime($date_end);
            }
            else
            {
                $date_end = $date + 86400;
            }
            $data = array();
            $result = DB::query(DATABASE::SELECT, 'SELECT orders.id, orders.shipping_date, orders.ordernum, order_items.sku, order_items.quantity, order_items.attributes, order_items.price FROM order_items LEFT JOIN orders ON order_items.order_id = orders.id WHERE orders.site_id=' . $this->site_id . ' AND orders.shipping_status="shipped" AND orders.shipping_date >= ' . $date . ' AND orders.shipping_date < ' . $date_end)->execute('slave');
            foreach ($result as $order)
            {
                $procurement = DB::select('sku', 'quantity', 'attributes', 'price')
                    ->from('order_procurements')
                    ->where('ordernum', '=', $order['ordernum'])
                    ->and_where('sku', '=', $order['sku'])
                    ->and_where('attributes', '=', $order['attributes'])
                    ->execute('slave')
                    ->current();
                if ($procurement)
                {
                    continue;
                }
                else
                {
                    $array['ordernum'] = $order['ordernum'];
                    $array['sku'] = $order['sku'];
                    $array['attributes'] = $order['attributes'];
                    $array['quantity'] = $order['quantity'];
                    $array['price'] = $order['price'];
                    $array['p_sku'] = $procurement['sku'];
                    $array['p_attributes'] = $procurement['attributes'];
                    $array['p_quantity'] = $procurement['quantity'];
                    $array['p_price'] = $procurement['price'];
                    $array['ship_date'] = date('Y-m-d', $order['shipping_date']);
                    $data[] = $array;
                }
            }

            $content = View::factory('admin/site/orderprocurement_subcheck')
                ->set('data', $data)
                ->set('date', $date)
                ->set('date_end', $date_end)
                ->render();
            $this->request->response = View::factory('admin/template')->set('content', $content)->render();
        }
    }

    public function action_instock_data()
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
                    $filter_sql .= " AND " . $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
                }
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
//                $limit = 20;

        $ordernum = Arr::get($_REQUEST, 'orderno', '');
        if($ordernum)
        {
            $filter_sql .= " AND ordernum = '" . $ordernum . "'";
        }

        $result = DB::query(Database::SELECT, 'SELECT count(id) AS count FROM order_instocks WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
        $count = $result['count'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM order_instocks WHERE site_id=' . $this->site_id .
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
                0,
                $data['id'],
                date('Y-m-d H:i:s', $data['created']),
                $data['ordernum'],
                $data['sku'],
                $data['quantity'],
                $data['attributes'],
                $data['cost'],
                $data['status'],
                $data['outstock_id'],
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_instock_edit()
    {
        if ($_POST)
        {
            if (!$_POST['id'])
            {
                Message::set('edit instock product error', 'error');
                echo '<script language="javascript">top.location.replace("http://' . $_SERVER['HTTP_HOST'] . '/admin/site/orderprocurement/outstock");</script>';
                exit;
            }
            $data['ordernum'] = Arr::get($_POST, 'ordernum', '');
            $data['sku'] = Arr::get($_POST, 'sku', '');
            $data['quantity'] = Arr::get($_POST, 'quantity', 1);
            if ($data['quantity'] < 1)
                $data['quantity'] = 1;
            $data['attributes'] = Arr::get($_POST, 'attributes', '');
            $data['outstock'] = Arr::get($_POST, 'outstock', 0);
            $data['cost'] = Arr::get($_POST, 'cost', 0);
            $result = DB::update('order_instocks')->set($data)->where('id', '=', $_POST['id'])->execute();
            if ($result)
            {
                Message::set('edit instock product success', 'success');
                echo '<script language="javascript">top.location.replace("http://' . $_SERVER['HTTP_HOST'] . '/admin/site/orderprocurement/outstock");</script>';
                exit;
            }
        }
        $id = $this->request->param('id');
        $data = DB::select('id', 'ordernum', 'sku', 'quantity', 'attributes', 'outstock','cost')->from('order_instocks')->where('id', '=', $id)->execute('slave')->current();
        $this->request->response = View::factory('admin/site/orderprocurement_instock_edit')
            ->set('instock', $data)
            ->render();
    }

    public function action_outstock_edit()
    {
        if ($_POST)
        {
            if (!$_POST['id'])
            {
                Message::set('edit outstock product error', 'error');
                echo '<script language="javascript">top.location.replace("http://' . $_SERVER['HTTP_HOST'] . '/admin/site/orderprocurement/outstock");</script>';
                exit;
            }
            $outstock = DB::select('sku', 'quantity', 'attributes')->from('order_outstocks')->where('id', '=', $_POST['id'])->execute('slave')->current();
            DB::query(Database::UPDATE, 'UPDATE order_instocks SET outstock = outstock-' . $outstock['quantity'] . ' WHERE sku="' . $outstock['sku'] . '" AND attributes="' . $outstock['attributes'] . '" AND quantity-outstock >' . $outstock['quantity'])->execute();
            $data['ordernum'] = Arr::get($_POST, 'ordernum', '');
            $data['sku'] = Arr::get($_POST, 'sku', '');
            $data['quantity'] = Arr::get($_POST, 'quantity', 1);
            if ($data['quantity'] < 1)
                $data['quantity'] = 1;
            $data['attributes'] = Arr::get($_POST, 'attributes', '');
            $result = DB::update('order_outstocks')->set($data)->where('id', '=', $_POST['id'])->execute();
            if ($result)
            {
                DB::query(Database::UPDATE, 'UPDATE order_instocks SET outstock = outstock+' . $data['quantity'] . ' WHERE sku="' . $data['sku'] . '" AND attributes="' . $data['attributes'] . '" AND quantity-outstock >' . $data['quantity'])->execute();
                Message::set('edit outstock product success', 'success');
                echo '<script language="javascript">top.location.replace("http://' . $_SERVER['HTTP_HOST'] . '/admin/site/orderprocurement/outstock");</script>';
                exit;
            }
        }
        $id = $this->request->param('id');
        $data = DB::select('id', 'ordernum', 'sku', 'quantity', 'attributes','cost')->from('order_outstocks')->where('id', '=', $id)->execute('slave')->current();
        $this->request->response = View::factory('admin/site/orderprocurement_outstock_edit')
            ->set('instock', $data)
            ->render();
    }

    public function action_instock_delete()
    {
        $id = $this->request->param('id');
        $delete = DB::delete('order_instocks')->where('id', '=', $id)->execute();
        if ($delete)
        {
            message::set(__('Delete instock product success'), 'success');
            Request::instance()->redirect('admin/site/orderprocurement/outstock');
        }
        else
        {
            message::set(__('instock product not exist'), 'error');
            Request::instance()->redirect('admin/site/orderprocurement/outstock');
        }
    }

    public function action_outstock_delete()
    {
        $id = $this->request->param('id');
        $delete = DB::delete('order_outstocks')->where('id', '=', $id)->execute();
        if ($delete)
        {
            message::set(__('Delete instock product success'), 'success');
            Request::instance()->redirect('admin/site/orderprocurement/outstock');
        }
        else
        {
            message::set(__('instock product not exist'), 'error');
            Request::instance()->redirect('admin/site/orderprocurement/outstock');
        }
    }

    public function action_instock_confirm()
    {
        if ($_POST)
        {
            $ids = Arr::get($_POST, 'ids', array());
            if (empty($ids))
            {
                Message::set('Your Selected Is Empty');
                $this->request->redirect('admin/site/orderprocurement/instock');
            }
            else
            {
                $attributes = $this->attr;
                foreach ($ids as $id)
                {
                    $data = DB::select('ordernum', 'sku', 'quantity', 'attributes')->from('order_procurements')->where('id', '=', $id)->execute('slave')->current();
                    if ($data)
                    {
                        $resutl = DB::update('order_procurements')->set(array('instock' => $data['quantity']))->where('id', '=', $id)->execute();
                        if ($resutl)
                        {
                            if (array_key_exists(strtoupper($data['attributes']), $attributes))
                                $data['attributes'] = $attributes[strtoupper($data['attributes'])];
                            $data['created'] = time();
                            $data['site_id'] = 1;
                            DB::insert('order_instocks', array_keys($data))->values($data)->execute();
                        }
                    }
                }
            }
        }
        Message::set('Order Product IN Stock Success');
        $this->request->redirect('admin/site/orderprocurement/instock');
    }

    public function action_bulk_instock()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $error = array();
        while ($data = fgetcsv($handle))
        {
            if ($data[2] < 1 OR $data[0] OR $data[5]=='' OR (!is_numeric($data[5])) )
                continue;
            if (strpos($data[3], 'one') != false)
            {
                $attr = 'one size';
            }
            else
            {
                $attr = str_replace('Size:', '', trim($data[3]));
                $attr = str_replace(';', '', $attr);
                $attr = trim($attr);
            }

            //check product attributes
            $p_info = DB::select('id', 'set_id', 'attributes')->from('products_product')->where('sku', '=', trim($data[1]))->execute('slave')->current();
            if(!$p_info['set_id'] == 2) //if shoes
            {
                $p_attributes = unserialize($p_info['attributes']);
                $sizes = array();
                if(isset($p_attributes['Size']))
                {
                    $sizes = $p_attributes['Size'];
                }
                elseif(isset($p_attributes['size']))
                {
                    $sizes = $p_attributes['size'];
                }
                if(!in_array($attr, $sizes))
                {
                    $row++;
                    $no_attr[] = $data;
                    continue;
                }
            }
            

            $attribute = 'Size:' . $attr . ';';
            if ($data[4])
            {
                $attr = str_replace('Color:', '', trim($data[4]));
                $attr = str_replace(';', '', $attr);
                $attr = trim($attr);
                if(!$p_info['set_id'] == 2)
                {
                    $colors = array();
                    if(isset($p_attributes['Color']))
                    {
                        $colors = $p_attributes['Color'];
                    }
                    elseif(isset($p_attributes['color']))
                    {
                        $colors = $p_attributes['color'];
                    }
                    if(!in_array($attr, $colors))
                    {
                        $row++;
                        $no_attr[] = $data;
                        continue;
                    }
                }

                $attribute .= 'Color:' . $attr . ';';
            }

            try
            {
                $array = array();
                $array['ordernum'] = trim($data[0]);
                $array['sku'] = trim($data[1]);
                $array['quantity'] = 1;
                $array['attributes'] = $attribute;
                $array['site_id'] = $this->site_id;
                $array['created'] = time();
                $array['status'] = 0;
                $array['cost'] = $data[5];
                for ($i=0; $i < $data[2]; $i++) {  
                    $result1 = DB::insert('order_instocks', array_keys($array))->values($array)->execute();
                }
                $row++;

                if (!$result1)
                {
                    $error[] = $data;
                }
            }
            catch (Exception $e)
            {
                $row++;
            }
        }
        $num = $row - count($error) - 1;
        echo "In stock " . $num . " order products successfully.<br>";
        if (!empty($error))
        {
            echo 'Failure as follows:' . '<br>';
            echo '<table cellspacing="1" cellpadding="1" border="1">';
            echo '<tr><td>Sku</td><td>Quantity</td><td>Attributes</td><td>Price</td></tr>';
            foreach ($error as $err)
            {
                echo '<tr>';
                echo '<td>' . $err[1] . '</td>';
                echo '<td>' . $err[2] . '</td>';
                echo '<td>' . $err[3] . '</td>';
                echo '<td>' . $err[5] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }else{
            $log = "admin:".Session::instance()->get('user_id')."date:".date('Y-m-d H:i:s',time());
            kohana_log::instance()->add('批量入库', $log);
        }
        if(!empty($no_attr))
        {
            echo count($no_attr) . ' records do not have attributes(产品表里找不到对应的attributes):' . '<br>';
            echo '<table cellspacing="0" cellpadding="0" border="1">';
            echo '<tr><td>Sku</td><td>Quantity</td><td>Attributes</td><td>Price</td></tr>';
            foreach ($no_attr as $err)
            {
                echo '<tr>';
                echo '<td>' . $err[1] . '</td>';
                echo '<td>' . $err[2] . '</td>';
                echo '<td>' . $err[3] . '</td>';
                echo '<td>' . $err[5] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        exit;
    }

    public function action_instock_confirm_data()
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
                    $filter_sql .= " AND " . $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
                }
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
//                $limit = 20;

        $count = DB::query(Database::SELECT, 'SELECT count(id) AS count FROM order_procurements WHERE quantity != instock AND type NOT IN ("缺货", "库存") AND site_id = ' . $this->site_id . $filter_sql)->execute('slave')->get('count');
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM order_procurements WHERE quantity != instock AND type NOT IN ("缺货", "库存") AND site_id = ' . $this->site_id .
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
                0,
                $data['id'],
                date('Y-m-d', $data['created']),
                $data['ordernum'],
                $data['sku'],
                $data['quantity'],
                $data['attributes'],
                $data['price'],
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_outstock()
    {
        $content = View::factory('admin/site/orderprocurement_outstock')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_explode_instock()
    {
        $submit = $_REQUEST['submit'];
        //echo $submit;
        //$return = DB::select('id','created','ordernum','sku','quantity','attributes','cost')->from('order_instocks')->where('status', '=', 0)->execute('slave')->as_array();
        $return = DB::query(Database::SELECT, 'SELECT id,created,ordernum,sku,quantity, attributes,cost FROM order_instocks WHERE status= 0 order by id desc')->execute('slave')->as_array();
            $title=array('id','created','ordernum','sku','qty','attibutes','cost');
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header('Content-Disposition: attachment; filename=instock' . date('Y-m-d', time()) . '.xls');
            header("Content-Transfer-Encoding: binary ");
            echo iconv('utf-8','gbk',implode("\t",$title)),"\n";
            foreach($return as $key=>$value){
                $value['created'] = date('Y-m-d', $value['created']);
                echo iconv('utf-8','gbk',implode("\t",$value)),"\n";    
        }
    }

    public function action_outstock_data()
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
                    $filter_sql .= " AND " . $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
                }
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
//                $limit = 20;

        $ordernum = Arr::get($_REQUEST, 'orderno', '');
        if($ordernum)
        {
            $filter_sql .= " AND ordernum = '" . $ordernum . "'";
        }

        $result = DB::query(Database::SELECT, 'SELECT count(id) AS count FROM order_outstocks WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
        $count = $result['count'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM order_outstocks WHERE site_id=' . $this->site_id .
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
                $data['id'],
                date('Y-m-d H:i:s', $data['created']),
                $data['ordernum'],
                $data['sku'],
                $data['quantity'],
                $data['attributes'],
                $data['cost'],
                $data['instock_id'],
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_bulk_outstock()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $error = array();
        while ($data = fgetcsv($handle))
        {
            if ($data[2] < 1)
                continue;

            if (strpos($data[3], 'one') != false)
            {
                $attr = 'one size';
            }
            else
            {
                $attr = str_replace('Size:', '', trim($data[3]));
                $attr = str_replace(';', '', $attr);
                $attr = trim($attr);
            }
            $attribute = 'Size:' . $attr . ';';
            if ($data[4])
            {
                $attr = str_replace('Color:', '', trim($data[4]));
                $attr = str_replace(';', '', $attr);
                $attr = trim($attr);
                $attribute .= 'Color:' . $attr . ';';
            }

            try
            {
                $array = array();
                $array['ordernum'] = trim($data[0]);
                $array['sku'] = trim($data[1]);
                $array['quantity'] = $data[2];
                $array['attributes'] = $attribute;
                $array['site_id'] = $this->site_id;
                $array['created'] = time();
                $result1 = DB::insert('order_outstocks', array_keys($array))->values($array)->execute();
                if ($result1)
                {
                    if ($data[0])
                    {
                        $result2 = DB::query(Database::SELECT, "SELECT id FROM order_procurements 
                                                        WHERE is_outstock = 0 AND ordernum = '$data[0]' AND sku = '$data[1]' AND attributes = '$data[3]' ORDER BY id DESC")
                                ->execute('slave')->current();
                        if ($result2)
                        {
                            DB::update('order_procurements')->set(array('is_outstock' => 1))->where('id', '=', $result2['id'])->execute();
                        }
                    }
                    $result = DB::query(Database::SELECT, "SELECT id,sku,quantity,attributes,outstock FROM order_instocks 
                                                        WHERE quantity > outstock AND sku = '$data[1]' AND attributes = '$data[3]' ORDER BY id DESC")
                            ->execute('slave')->as_array();
                    if (empty($result))
                    {
                        $result = DB::query(Database::SELECT, "SELECT id,sku,quantity,attributes,outstock FROM order_instocks 
                                                        WHERE quantity > outstock AND sku = '$data[1]' AND attributes = '$data[3]' ORDER BY id DESC")
                                ->execute('slave')->as_array();
                    }
                    if (!empty($result))
                    {
                        $quantity = $data[2];
                        foreach ($result as $p)
                        {
                            if ($quantity == 0)
                                break;
                            if ($p['quantity'] - $p['outstock'] <= $quantity)
                            {
                                $result = DB::update('order_instocks')->set(array('outstock' => $p['quantity']))->where('id', '=', $p['id'])->execute();
                                $quantity -= $p['quantity'];
                            }
                            else
                            {
                                DB::update('order_instocks')->set(array('outstock' => $quantity + $p['outstock']))->where('id', '=', $p['id'])->execute();
                                break;
                            }
                        }
                        DB::update('order_procurements')
                            ->set(array('is_outstock' => '1'))
                            ->where('ordernum', '=', $data[0])
                            ->and_where('sku', '=', $data[1])
                            ->and_where('attributes', '=', $data[3])
                            ->execute();
                    }
                    $row++;
                }
                else
                {
                    $error[] = $data;
                }
            }
            catch (Exception $e)
            {
                $row++;
            }
        }
        $num = $row - count($error) - 1;
        echo "Out stock " . $num . " order products successfully.<br>";
        if (!empty($error))
        {
            echo 'Errors:<br>';
            print_r($error);
        }
        exit;
    }

    public function action_up_setid()
    {
        $result = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sku FROM order_instocks WHERE status=0 AND site_id=' . $this->site_id .
                 ' group by sku,attributes')->execute()->as_array();

        foreach($result as $v){
        $a = DB::query(DATABASE::UPDATE, "UPDATE order_instocks oi left join products p on oi.sku=p.sku SET oi.set_id = p.set_id where p.sku = '{$v['sku']}' and oi.set_id =0")->execute(); 
          }
        $this->request->redirect('/admin/site/orderprocurement/stock');
    }

    public function action_stock()
    {
        $content = View::factory('admin/site/orderprocurement_stock')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_stock_data()
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
        $have_quantity = 0;
        
        if ($filters)
        {
            foreach ($filters->rules as $item)
            {
                if ($item->field == 'quantity')
                {
                    $have_quantity = $item->data;
                }
                elseif ($item->field == 'attributes')
                {
                    $filter_sql .= " AND " . $item->field . " LIKE '%" . $item->data . "%'";
                }
                else
                {
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
                }
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
//                $limit = 20;

        //$result = DB::query(Database::SELECT, 'SELECT count(DISTINCT sku,attributes) AS count FROM order_instocks WHERE quantity > outstock AND site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
        $result = DB::query(Database::SELECT, 'SELECT count(DISTINCT sku,attributes) AS count FROM order_instocks WHERE status=0 AND site_id=' . $this->site_id . $filter_sql)->execute()->current();
        $count = $result['count'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

//        $result = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sku,attributes FROM order_instocks WHERE quantity > outstock AND site_id=' . $this->site_id .
//                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');
        $result = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sku,attributes,sum(quantity) qty,sum(cost) cost,set_id FROM order_instocks WHERE status=0 AND site_id=' . $this->site_id .
                $filter_sql . ' group by sku,attributes ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute();
        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $key => $data)
        {
//            $attributes = str_replace(';', '', $data['attributes']);
//            $in_count = DB::query(Database::SELECT, 'SELECT sum(quantity) AS sum FROM order_instocks WHERE sku="' . $data['sku'] . '" AND attributes LIKE "%' . $attributes . '%"')->execute('slave')->get('sum');
//            $out_count = DB::query(Database::SELECT, 'SELECT sum(quantity) AS sum FROM order_outstocks WHERE sku="' . $data['sku'] . '" AND attributes LIKE "%' . $attributes . '%"')->execute('slave')->get('sum');
//            $stock_count = $in_count - $out_count;
//            if ($have_quantity)
//            {
//                if ($stock_count == 0)
//                    continue;
//            }
//            $cost = DB::select(DB::expr('SUM(price) / SUM(quantity) AS cost'))->from('order_costs')->where('sku', '=', $data['sku'])->execute('slave')->get('cost');
//            if (!$cost)
//                $cost = DB::select('total_cost')->from('products_product')->where('sku', '=', $data['sku'])->execute('slave')->get('total_cost');
//            $cost = round($cost, 2);
             $set = ORM::factory('set', $data['set_id']);
               $response['userdata']['sets'][$data['set_id']] = $set->name ? $set->name : '无';           
            $response['rows'][$i]['id'] = $key;
            $response['rows'][$i]['cell'] = array(
                $key + 1,
                $data['sku'],
                $data['attributes'],
//                $in_count - $out_count,
//                $cost
                $data['qty'],
                $data['cost'],
                $data['set_id'],
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_stock_export()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="stocks.csv"');
        echo "SKU,Attributes,Quantity,Cost,Admin,Set\n";

        $result = DB::query(DATABASE::SELECT, 'SELECT DISTINCT order_instocks.sku,order_instocks.attributes,order_instocks.set_id,products.total_cost,products.admin FROM order_instocks,products WHERE order_instocks.sku=products.sku AND order_instocks.status = 0 AND order_instocks.site_id=' . $this->site_id)->execute('slave');

        $userArr = DB::select('id', 'name')->from('auth_user')->execute('slave')->as_array();
        $users = array();
        foreach ($userArr as $user)
        {
            $users[$user['id']] = $user['name'];
        }
        foreach ($result as $key => $data)
        {
//            $in_count = DB::query(Database::SELECT, 'SELECT sum(quantity) AS sum FROM order_instocks WHERE sku="' . $data['sku'] . '" AND attributes LIKE "%' . $data['attributes'] . '%"')->execute('slave')->get('sum');
//            $out_count = DB::query(Database::SELECT, 'SELECT sum(quantity) AS sum FROM order_outstocks WHERE sku="' . $data['sku'] . '" AND attributes LIKE "%' . $data['attributes'] . '%"')->execute('slave')->get('sum');
//            $stock_count = $in_count - $out_count;
           $set = ORM::factory('set', $data['set_id']);
           $s = $set->name ? $set->name : '无';
            $stock_count = DB::query(Database::SELECT, 'SELECT sum(quantity) AS sum FROM order_instocks WHERE `status`=0 and sku="' . $data['sku'] . '" AND attributes LIKE "%' . $data['attributes'] . '%"')->execute('slave')->get('sum');
            $stock_count = $stock_count ? $stock_count : 0;
            if ($stock_count == 0)
                continue;
            echo trim($data['sku']) . ',';
            echo $data['attributes'] . ',';
            echo $stock_count . ',';
            echo $data['total_cost'] . ',';           
            echo isset($users[$data['admin']]) ? $users[$data['admin']]. ',' : ',';
            echo $s . ',';
            echo PHP_EOL;
        }
    }

    public function action_stock_check()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $instock = array();
        $outstock = array();
        while ($data = fgetcsv($handle))
        {
            if (!is_numeric($data[2]) OR $data[2] < 0)
                continue;
            if (strpos($data[3], 'one') != false)
            {
                $attr = 'one size';
            }
            else
            {
                $attr = str_replace('Size:', '', trim($data[3]));
                $attr = str_replace(';', '', $attr);
                $attr = trim($attr);
            }

            $attribute = 'Size:' . $attr . ';';
            if ($data[4])
            {
                $attr = str_replace('Color:', '', trim($data[4]));
                $attr = str_replace(';', '', $attr);
                $attr = trim($attr);
                $attribute .= 'Color:' . $attr . ';';
            }

            $array = array();
//            $array['ordernum'] = trim($data[0]);
            $array['ordernum'] = 'Inventory';
            $array['sku'] = trim($data[1]);
            $array['quantity'] = 1;
            $qty = $data[2];
//            $array['quantity'] = $data[2];
            $array['attributes'] = $attribute;
            $array['site_id'] = $this->site_id;
            $array['created'] = time();
            
            /*cost*/
            $cost = DB::query(Database::SELECT, "SELECT cost FROM order_instocks WHERE sku='".$array['sku']."' AND trim(`attributes`)='".trim($attribute)."' order by created desc limit 1")->execute('slave')->get('cost');
            if((!$cost) || $cost==0){
                $cost = DB::query(Database::SELECT, "select total_cost from products where sku='".$array['sku']."' ")->execute('slave')->get('total_cost');
                if(!$cost){
                    $cost = 0;
                }
            }
            $array['cost'] = $cost;

//            $in_count = DB::query(Database::SELECT, 'SELECT sum(quantity) AS sum FROM order_instocks WHERE sku="' . $array['sku'] . '" AND attributes LIKE "%' . $attribute . '%"')->execute('slave')->get('sum');
//            $out_count = DB::query(Database::SELECT, 'SELECT sum(quantity) AS sum FROM order_outstocks WHERE sku="' . $array['sku'] . '" AND attributes LIKE "%' . $attribute . '%"')->execute('slave')->get('sum');
//            $stock_count = (int) ($in_count - $out_count);
            $stock_count = DB::query(Database::SELECT, 'SELECT sum(quantity) AS sum FROM order_instocks WHERE `status`=0 and sku="' . $array['sku'] . '" AND attributes LIKE "%' . $attribute . '%"')->execute('slave')->get('sum');
            $stock_count = $stock_count?$stock_count:0;
            
            //if ($array['quantity'] > $stock_count)
            if($qty > $stock_count)
            {
//                $array['quantity'] -= $stock_count;
                $qty = $qty - $stock_count;
//                $result1 = DB::insert('order_instocks', array_keys($array))->values($array)->execute();
//                if ($result1)
//                    $instock[] = $array;
                $array['status'] = 0;
                for ($i=0; $i < $qty; $i++) {
                    $result1 = DB::insert('order_instocks', array_keys($array))->values($array)->execute();
                    if($result1){
                        $instock[] = $array;
                    }
                }
            }
            //elseif ($array['quantity'] < $stock_count)
            elseif($qty < $stock_count)   
            {
//                $array['quantity'] = $stock_count - $array['quantity'];
//                $result2 = DB::insert('order_outstocks', array_keys($array))->values($array)->execute();
//                if ($result2)
//                    $outstock[] = $array;
                $qty = $stock_count-$qty;
                for ($i=0; $i < $qty; $i++) { 
                    $result2 = DB::insert('order_outstocks', array_keys($array))->values($array)->execute();
                    if($result2){
                        $in_id = DB::query(Database::SELECT, 'SELECT id FROM order_instocks WHERE `status`=0 and sku="' . $array['sku'] . '" AND attributes LIKE "%' . $attribute . '%" limit 1')->execute('slave')->get('id');
                        if($in_id){
                            DB::query(DATABASE::UPDATE,"update `order_instocks` set `status`=1,`outstock_id`=".$result2[0]." where id=".$in_id)->execute();
                            DB::query(DATABASE::UPDATE,"update `order_outstocks` set `instock_id`=".$in_id." where id=".$result2[0])->execute();
                        }
                        $outstock[] = $array;
                    }
                }
            }
            // $log .= "admin:".$session = Session::instance()->get('user_id')."\n\r".serialize($array);
            // kohana_log::instance()->add('Inventory', $log);

            $row++;
        }
        if (!empty($instock))
        {
            echo 'Instock Products:' . '<br>';
            echo '<table cellspacing="1" cellpadding="1" border="1">';
            echo '<tr><td>Sku</td><td>Quantity</td><td>Attributes</td></tr>';
            foreach ($instock as $err)
            {
                echo '<tr>';
                echo '<td>' . $err['sku'] . '</td>';
                echo '<td>' . $err['quantity'] . '</td>';
                echo '<td>' . $err['attributes'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        if (!empty($outstock))
        {
            echo 'Outstock Products:' . '<br>';
            echo '<table cellspacing="1" cellpadding="1" border="1">';
            echo '<tr><td>Sku</td><td>Quantity</td><td>Attributes</td></tr>';
            foreach ($outstock as $err)
            {
                echo '<tr>';
                echo '<td>' . $err['sku'] . '</td>';
                echo '<td>' . $err['quantity'] . '</td>';
                echo '<td>' . $err['attributes'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        if (empty($instock) AND empty($outstock))
        {
            echo '导入库存与实际库存表一致，无出入库操作';
        }
        exit;
    }

    public function action_cost()
    {
        $content = View::factory('admin/site/orderprocurement_cost')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_cost_data()
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
                if ($item->field == 'date')
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
                    $filter_sql .= " AND " . $item->field . " between " . $from . " and " . $to;
                }
                else
                {
                    $filter_sql .= " AND " . $item->field . "='" . $item->data . "'";
                }
            }
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
//                $limit = 20;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM order_costs WHERE site_id=' . $this->site_id . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM order_costs WHERE site_id=' . $this->site_id . ' ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $array)
        {
            $response['rows'][$i]['id'] = $array['id'];
            $response['rows'][$i]['cell'] = array(
                $array['id'],
                date('Y-m-d', $array['date']),
                $array['sku'],
                $array['price'],
                $array['type'],
                $array['remark'],
                $array['quantity'],
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_cost_upload()
    {
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        $sku1 = '';
        $date1 = time();
        while ($data = fgetcsv($handle))
        {
            if ($row == 1)
            {
                $row++;
                continue;
            }
            try
            {
                $array = array();
                $sku = $data[1] ? trim($data[1]) : $sku1;
                $product_id = Product::get_productId_by_sku($sku);
                $date = $data[0] ? strtotime($data[0]) : $date1;
                if ($product_id)
                {
                    $array['sku'] = $sku;
                    $array['date'] = $date;
                    $array['price'] = $data[2];
                    $array['quantity'] = $data[3];
                    $array['site_id'] = $this->site_id;
                    $array['type'] = 1;
                    if ($array['price'] AND $array['quantity'] AND $array['date'])
                    {
                        DB::insert('order_costs', array_keys($array))->values($array)->execute();
                        $row++;
                        $sku1 = $sku;
                        $date1 = $date;
                    }
                }
                elseif ($data[1])
                {
                    $type = iconv('GB2312', 'UTF-8', $data[4]);
                    $array['remark'] = iconv('GB2312', 'UTF-8', $data[1]);
                    $array['date'] = $date;
                    $array['price'] = $data[2];
                    $array['quantity'] = $data[3];
                    $array['site_id'] = $this->site_id;
                    if ($type == '采购')
                    {
                        $array['type'] = 1;
                    }
                    else
                    {
                        $array['type'] = 2;
                    }

                    if ($array['remark'] AND $array['price'])
                    {
                        DB::insert('order_costs', array_keys($array))->values($array)->execute();
                        $row++;
                        $date1 = $date;
                    }
                }
            }
            catch (Exception $e)
            {
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        $num = $row - count($error) - 1;
        echo "Upload " . $num . " order procurements successfully.<br>";
    }

    public function action_update_track(){
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream"))
            die("Only csv file type is allowed!");
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        while ($data = fgetcsv($handle)) {
            if($row==1){
                $row++;
                continue;
            }
            $ordernum = trim((string)$data[0]);
            $sku = $data[1]?trim($data[1]):"";
            $qty = $data[2]?trim($data[2]):"";
            $size = $data[3]?trim($data[3]):"";
            $purchase_id = $data[6]?trim($data[6]):"";

            if($sku==""||$qty==""||$size==""||$purchase_id==""){
                $row++;
                continue;
            }

            $cn_carrier = $data[4]?iconv('GB2312', 'UTF-8', $data[4]):"";
            $cn_tracking_code = $data[5]?iconv('GB2312', 'UTF-8', trim(str_replace("'","",$data[5]))):"";
            try{
                $do = DB::query(DATABASE::UPDATE,"update order_procurements set cn_carrier='".mysql_real_escape_string($cn_carrier)."',cn_tracking_code='".mysql_real_escape_string($cn_tracking_code)."' 
                where purchase_id=".$purchase_id." and ordernum='".$ordernum."' and sku='".$sku."' and quantity=".$qty." and trim(`attributes`)='".$size."'")->execute();
                $row++;
            }
            catch(Exception $e){
                $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                $row++;
            }
        }
        if (isset($error))
            echo(implode("<br/>", $error));
        echo '<br/>';
        $num = $row - count($error) - 1;
        echo "Upload " . $num . " order procurements successfully.<br>";
    }

    public function action_stock_init(){
        if (!isset($_FILES) || ($_FILES["file"]["type"] != "application/vnd.ms-excel" && $_FILES["file"]["type"] != "text/csv" && $_FILES['file']['type'] != "text/comma-separated-values" && $_FILES['file']['type'] != "application/octet-stream" && $_FILES['file']['type'] != "application/oct-stream")){
            die("Only csv file type is allowed!");
        }
        $handle = fopen($_FILES["file"]["tmp_name"], "r");
        $row = 1;
        while ($data = fgetcsv($handle)){
            if( $row == 1 or $data[2] <=0 ){
                $row++;
                continue;
            }
            for ($i=0; $i < $data[2]; $i++) { 
                try{
                    DB::query(DATABASE::INSERT,"insert into order_instocks (`sku`,`quantity`,`attributes`,`created`,`site_id`,`cost`,`status`) 
                        value ('".$data[0]."',1,'".$data[1]."',".time().",".$this->site_id.",".$data[3].",0)")->execute();
                }catch(Exception $e){
                    $error[] = "Add Row " . $row . " Fail: " . $e->getMessage();
                }
            }
            $row++;
        }
        if (isset($error)){
            echo(implode("<br/>", $error));
        }else{
            echo "success";
        }
        exit;
    }

    public function action_sku_stock_export(){
        $skus = Arr::get($_POST, 'SKUARR', '');
        if (!$skus)
        {
            echo 'Sku cannot be empty';
            exit;
        }
        else
        {
            echo '<table cellspacing="0" cellpadding="0" border="0">';
            echo '<tr><td width="100px">SKU</td><td width="100px">Attributes</td><td width="100px">数量</td></tr>';
            $skuArr = explode("\n", $skus);
            foreach($skuArr as $sku)
            {
                $sku = trim($sku);
                if($sku){
                    $qtys = DB::query(DATABASE::SELECT, 'select sku, attributes, SUM(quantity) AS qty
                        from order_instocks
                        where sku="'.$sku.'" and status=0 GROUP BY attributes')->execute('slave')->as_array();
                    foreach($qtys as $q)
                    {
                        echo '<tr><td>' . $sku . '</td><td>' . $q['attributes'] . '</td><td>' . $q['qty']. '</td></tr>';
                    }
                }
            }
            echo '</table>';
        }
    }

    public function action_do_out_stock(){
        $ids = Arr::get($_POST, 'ids', '');
        $error = array();
        foreach ($ids as $id) {
            //确认未出库
            $status = DB::query(DATABASE::SELECT,"select * from `order_instocks` where id=".$id)->execute('slave');
            if($status && $status[0]['status'] ==0){
                //insert order_outsotck
                $outstock = DB::insert('order_outstocks', array('ordernum','sku','quantity','attributes','created','site_id','instock_id','cost'))
                    ->values(array($status[0]['ordernum'],$status[0]['sku'],$status[0]['quantity'],$status[0]['attributes'],time(),$status[0]['site_id'],$status[0]['id'],$status[0]['cost'],))->execute();
                //update order_instock
                $instock = DB::update('order_instocks')->set(array('status'=>1,'outstock_id'=>$outstock[0]))->where('id', '=', $id)->execute();
                if ( $outstock && $instock ) {
                    echo "ID:".$id."=>COST:".$status[0]['cost']."--SUCCESS!<br>";
                }else{
                    $error[] = $id;
                }
            }else{
                $error[] = $id;
                continue;
            }
        }
        if(count($error)>0){
            foreach ($error as $e) {
                echo "Error:".$e."<br>";
            }
        }
    }

    //sjm add 2015-01-13
    public function action_check_inventory()
    {
        $content = View::factory('admin/site/orderprocurement_check_inventory')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_monthly_inventory()
    {
        $content = View::factory('admin/site/orderprocurement_monthly_inventory')->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_monthly_inventory_data()
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
                
                if ($item->field == 'attributes')
                {
                    $filter_sqls[] = $item->field . " LIKE '%" . $item->data . "%'";
                }
                else
                {
                    $filter_sqls[] = $item->field . "='" . $item->data . "'";
                }
            }
        }

        if(!empty($filter_sqls))
            $filter_sql = ' WHERE ' . implode(" AND ", $filter_sqls);

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
//                $limit = 20;

        $result = DB::query(Database::SELECT, 'SELECT count(id) FROM checks_inventories ' . $filter_sql)->execute('slave')->current();
        $count = $result['count(id)'];
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM checks_inventories ' .
                $filter_sql . ' order by ' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

        $response = array();
        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        $i = 0;
        foreach ($result as $array)
        {
            $response['rows'][$i]['id'] = $array['id'];
            $response['rows'][$i]['cell'] = array(
                $array['id'],
                $array['sku'],
                $array['attributes'],
                $array['month'],
                $array['first'],
                $array['first_cost'],
                $array['instock'],
                $array['instock_cost'],
                $array['outstock'],
                $array['outstock_cost'],
                $array['end'],
                $array['end_cost'],
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_monthly_inventory_export()
    {
        if($_POST)
        {
            $month = Arr::get($_POST, 'month', '');
            if($month)
            {
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="Monthly_inventory-' . $month . '.csv"');
                echo "\xEF\xBB\xBF" . "Sku,Attributes,Month,初期库存,初期成本,入库数量,入库成本,出库数量,出库成本,期末库存,期末成本\n";
                $result = DB::query(Database::SELECT, 'SELECT * FROM checks_inventories WHERE month = "' . $month . '"')->execute('slave');
                foreach($result as $data)
                {
                    echo '"' . $data['sku'] . '",';
                    echo '"' . $data['attributes'] . '",';
                    echo '"' . $data['month'] . '",';
                    echo '"' . $data['first'] . '",';
                    echo '"' . $data['first_cost'] . '",';
                    echo '"' . $data['instock'] . '",';
                    echo '"' . $data['instock_cost'] . '",';
                    echo '"' . $data['outstock'] . '",';
                    echo '"' . $data['outstock_cost'] . '",';
                    echo '"' . $data['end'] . '",';
                    echo '"' . $data['end_cost'] . '",';
                    echo PHP_EOL;
                }
            }
        }
    }

    public function action_inventory_do()
    {
        $month_get = trim(Arr::get($_REQUEST, 'm', ''));
        $sku = trim(Arr::get($_REQUEST, 'sku', ''));
        if($month_get AND $sku)
        {
            $attributes = Arr::get($_REQUEST, 'attributes', '');
            if($attributes)
            {
                if(strpos($attributes, 'Size') === False)
                {
                    $attributes = 'Size:' . $attributes . ';';
                }
                $sql = ' AND attributes = "' . $attributes . '"';
            }
            else
                $sql = '';
            $max_month = DB::select(DB::expr('MAX(month) AS max_month'))->from('checks_inventories')->execute('slave')->get('max_month');
            $month = $month_get . '01';
            $max_month .= '01';
            while($month <= $max_month)
            {
                echo $month . '<br>';
                $from = strtotime($month);
                $before_month = date('Ym', $from - 1);
                $to = strtotime(date('Y-m-d', $from) . ' + 1 month') - 1;
                $products = DB::query(Database::SELECT, 'SELECT DISTINCT sku, attributes FROM order_instocks WHERE sku = "' . $sku . '" ' . $sql . ' ORDER BY sku')->execute('slave')->as_array();
                $instocks = array();
                $instock_costs = array();
                $result = DB::query(Database::SELECT, 'SELECT sku, attributes, SUM(quantity) AS qty, SUM(cost) AS costs FROM order_instocks WHERE created BETWEEN ' . $from . ' AND ' . $to . ' AND sku = "' . $sku . '" ' . $sql . ' GROUP BY sku, attributes')->execute('slave');
                foreach($result as $value)
                {
                    if(strpos(strtolower($value['attributes']), 'one') !== False)
                        $value['attributes'] = 'Size:one size;';
                    $value['sku'] = strtoupper($value['sku']);
                    $key = trim($value['sku']) . '-' . trim($value['attributes']);
                    $instocks[$key] = $value['qty'];
                    $instock_costs[$key] = $value['costs'];
                }
                $outstocks = array();
                $outstock_costs = array();
                $result1 = DB::query(Database::SELECT, 'SELECT sku, attributes, SUM(quantity) AS qty, SUM(cost) AS costs FROM order_outstocks WHERE created BETWEEN ' . $from . ' AND ' . $to . ' AND sku = "' . $sku . '" ' . $sql . ' GROUP BY sku, attributes')->execute('slave');
                foreach($result1 as $value)
                {
                    if(strpos(strtolower($value['attributes']), 'one') !== False)
                        $value['attributes'] = 'Size:one size;';
                    $value['sku'] = strtoupper($value['sku']);
                    $key = trim($value['sku']) . '-' . trim($value['attributes']);
                    $outstocks[$key] = $value['qty'];
                    $outstock_costs[$key] = $value['costs'];
                }
                foreach($products as $num => $p)
                {
                    $firsts = DB::query(Database::SELECT, 'SELECT end, end_cost FROM checks_inventories WHERE sku = "' . $p['sku'] . '" AND attributes = "' . $p['attributes'] . '" AND month = "' . $before_month . '"')->execute('slave')->current();
                    if(empty($first))
                    {
                        $first = 0;
                        $first_cost = 0;
                    }
                    else
                    {
                        $first = $firsts['end'];
                        $first_cost = $firsts['end_cost'];
                    }
                    if(strpos(strtolower($p['attributes']), 'one') !== False)
                        $p['attributes'] = 'Size:one size;';
                    $p['sku'] = strtoupper($p['sku']);
                    $key = trim($p['sku']) . '-' . trim($p['attributes']);
                    $instock = 0;
                    $outstock = 0;
                    $instock_cost = 0;
                    $outstock_cost = 0;
                    if(isset($instocks[$key]))
                    {
                        $instock = $instocks[$key];
                        $instock_cost = $instock_costs[$key];
                    }
                    if(isset($outstocks[$key]))
                    {
                        $outstock = $outstocks[$key];
                        $outstock_cost = $outstock_costs[$key];
                    }
                    $end = $first + $instock - $outstock;
                    $end_cost = $first_cost + $instock_cost - $outstock_cost;
                    $product_id = Product::get_productId_by_sku($p['sku']);
                    if(!$product_id)
                        $product_id = 0;
                    $update_month = date('Ym', $from);
                    $update = array(
                        'product_id' => $product_id,
                        'sku' => $p['sku'],
                        'attributes' => $p['attributes'],
                        'month' => $update_month,
                        'first' => $first,
                        'instock' => $instock,
                        'instock_cost' => $instock_cost,
                        'outstock' => $outstock,
                        'outstock_cost' => $outstock_cost,
                        'end' => $end,
                        'first_cost' => $first_cost,
                        'end_cost' => $end_cost,
                    );
                    $check_id = DB::select('id')->from('checks_inventories')
                    ->where('month', '=', $update_month)
                    ->where('product_id', '=', $product_id)
                    ->where('attributes', '=', $p['attributes'])
                    ->execute('slave')->get('id');
                    if($check_id)
                    {
                        DB::update('checks_inventories')->set($update)->where('id', '=', $check_id)->execute();
                        echo $num . '--' . json_encode($update) . ' UPDATE SUCCESS!<br>';
                    }
                }
                $str = strtotime($month . ' + 1 month');
                $month = date('Ymd', $str);
            }
        }
        elseif($month_get)
        {
            $has = DB::select('id')->from('checks_inventories')->where('month', '=', $month_get)->execute('slave')->as_array();
            if(!$has)
            {
                $from = strtotime($month_get . '01');
                $before_month = date('Ym', $from - 1);
                $to = strtotime(date('Y-m-d', $from) . ' + 1 month') - 1;
                $products = DB::query(Database::SELECT, 'SELECT DISTINCT sku, attributes FROM order_instocks ORDER BY sku')->execute('slave')->as_array();
                $instocks = array();
                $instock_costs = array();
                $result = DB::query(Database::SELECT, 'SELECT sku, attributes, SUM(quantity) AS qty, SUM(cost) AS costs FROM order_instocks WHERE created BETWEEN ' . $from . ' AND ' . $to . ' GROUP BY sku, attributes')->execute('slave');
                foreach($result as $value)
                {
                    if(strpos(strtolower($value['attributes']), 'one') !== False)
                        $value['attributes'] = 'Size:one size;';
                    $value['sku'] = strtoupper($value['sku']);
                    $key = trim($value['sku']) . '-' . trim($value['attributes']);
                    $instocks[$key] = $value['qty'];
                    $instock_costs[$key] = $value['costs'];
                }
                $outstocks = array();
                $outstock_costs = array();
                $result1 = DB::query(Database::SELECT, 'SELECT sku, attributes, SUM(quantity) AS qty, SUM(cost) AS costs FROM order_outstocks WHERE created BETWEEN ' . $from . ' AND ' . $to . ' GROUP BY sku, attributes')->execute('slave');
                foreach($result1 as $value)
                {
                    if(strpos(strtolower($value['attributes']), 'one') !== False)
                        $value['attributes'] = 'Size:one size;';
                    $value['sku'] = strtoupper($value['sku']);
                    $key = trim($value['sku']) . '-' . trim($value['attributes']);
                    $outstocks[$key] = $value['qty'];
                    $outstock_costs[$key] = $value['costs'];
                }
                foreach($products as $num => $p)
                {
                    $firsts = DB::query(Database::SELECT, 'SELECT end, end_cost FROM checks_inventories WHERE sku = "' . $p['sku'] . '" AND attributes = "' . $p['attributes'] . '" AND month = "' . $before_month . '"')->execute('slave')->current();
                    if(empty($firsts))
                    {
                        $first = 0;
                        $first_cost = 0;
                    }
                    else
                    {
                        $first = $firsts['end'];
                        $first_cost = $firsts['end_cost'];
                    }
                    if(strpos(strtolower($p['attributes']), 'one') !== False)
                        $p['attributes'] = 'Size:one size;';
                    $p['sku'] = strtoupper($p['sku']);
                    $key = trim($p['sku']) . '-' . trim($p['attributes']);
                    $instock = 0;
                    $outstock = 0;
                    $instock_cost = 0;
                    $outstock_cost = 0;
                    if(isset($instocks[$key]))
                    {
                        $instock = $instocks[$key];
                        $instock_cost = $instock_costs[$key];
                    }
                    if(isset($outstocks[$key]))
                    {
                        $outstock = $outstocks[$key];
                        $outstock_cost = $outstock_costs[$key];
                    }
                    $end = $first + $instock - $outstock;
                    $end_cost = $first_cost + $instock_cost - $outstock_cost;
                    $product_id = Product::get_productId_by_sku($p['sku']);
                    if(!$product_id)
                        $product_id = 0;
                    $insert = array(
                        'product_id' => $product_id,
                        'sku' => $p['sku'],
                        'attributes' => $p['attributes'],
                        'month' => $month_get,
                        'first' => $first,
                        'instock' => $instock,
                        'instock_cost' => $instock_cost,
                        'outstock' => $outstock,
                        'outstock_cost' => $outstock_cost,
                        'end' => $end,
                        'first_cost' => $first_cost,
                        'end_cost' => $end_cost,
                    );
                    $res = DB::insert('checks_inventories', array_keys($insert))->values($insert)->execute();
                    if($res)
                        echo $num . '--' . json_encode($insert) . ' ADD SUCCESS!<br>';
                }
            }
        }
    }

    public function action_inventory_search_html()
    {
        $from = Arr::get($_REQUEST, 'from', NULL);
        if (!$from)
        {
            die('invalid request');
        }
        $to = Arr::get($_REQUEST, 'to', NULL);
        echo '<h3>时点库存明细: From ' . $from . ' To ' . $to . '</h3>';
        $sql = '';
        if ($to)
        {
            $sql = ' created >= ' . strtotime($from) . ' AND created < ' . strtotime($to);
        }
        else
        {
            $to = strtotime($from) + 86400;
            $sql = ' created >= ' . strtotime($from) . ' AND created < ' . $to;
        }
        $month = date('Ym', strtotime($from));
        $instocks = array();
        $result = DB::query(Database::SELECT, 'SELECT sku, attributes, quantity, ordernum, FROM_UNIXTIME(created) AS created, cost FROM order_instocks WHERE ' . $sql . ' ORDER BY created, sku, attributes')->execute('slave')->as_array();
        foreach($result as $value)
        {
            $value['sku'] = strtoupper($value['sku']);
            $key = trim($value['sku']) . '-' . trim($value['attributes']);
            $instocks[$key][] = $value;
        }
        $outstocks = array();
        $result = DB::query(Database::SELECT, 'SELECT sku, attributes, quantity, ordernum, FROM_UNIXTIME(created) AS created, cost FROM order_outstocks WHERE ' . $sql . ' ORDER BY created, sku, attributes')->execute('slave')->as_array();
        foreach($result as $value)
        {
            $value['sku'] = strtoupper($value['sku']);
            $key = trim($value['sku']) . '-' . trim($value['attributes']);
            $outstocks[$key][] = $value;
        }

        $from1 = strtotime($month . '01');
        $to1 = strtotime($from) - 1;
        $instocks_first = array();
        $instocks_cost = array();
        $result = DB::query(Database::SELECT, 'SELECT sku, attributes, SUM(quantity) AS qty, SUM(cost) AS t_cost FROM order_instocks WHERE created BETWEEN ' . $from1 . ' AND ' . $to1 . ' GROUP BY sku, attributes')->execute('slave');
        foreach($result as $value)
        {
            $key = trim($value['sku']) . '-' . trim($value['attributes']);
            $instocks_first[$key] = $value['qty'];
            $instocks_cost[$key] = $value['t_cost'];
        }
        $outstocks_first = array();
        $outstocks_cost = array();
        $result1 = DB::query(Database::SELECT, 'SELECT sku, attributes, SUM(quantity) AS qty, SUM(cost) AS t_cost FROM order_outstocks WHERE created BETWEEN ' . $from1 . ' AND ' . $to1 . ' GROUP BY sku, attributes')->execute('slave');
        foreach($result1 as $value)
        {
            $value['sku'] = strtoupper($value['sku']);
            $key = trim($value['sku']) . '-' . trim($value['attributes']);
            $outstocks_first[$key] = $value['qty'];
            $outstocks_cost[$key] = $value['t_cost'];
        }

        echo '<table cellspacing="1" cellpadding="1" border="1">';
        echo '<tbody>';
        echo '<tr><td>SKU</td><td>Attributes</td><td>Date</td><td>期初/末数量</td><td>期初/末成本</td><td>入库数量</td><td>入库成本</td><td>出库数量</td><td>出库成本</td><td>Ordernum</td></tr>';
        $inventories = DB::select(DB::expr('sku, attributes, first, end, instock_cost, outstock_cost, first_cost, end_cost'))->from('checks_inventories')->where('month', '=', $month)->execute('slave')->as_array();
        foreach($inventories as $data)
        {
            $data['sku'] = strtoupper($data['sku']);
            $stock = $data['first'];
            $cost = $data['first_cost'];
            $key1 = trim($data['sku']) . '-' . trim($data['attributes']);
            if(isset($instocks_first[$key1]))
                $stock += $instocks_first[$key1];
            if(isset($outstocks_first[$key1]))
                $stock -= $outstocks_first[$key1];

            if(isset($instocks_cost[$key1]))
                $cost += $instocks_cost[$key1];
            if(isset($outstocks_first[$key1]))
                $cost -= $outstocks_first[$key1];

            echo '<tr><td>' . $data['sku'] . '</td><td>' . $data['attributes'] . '</td><td>初期</td><td>' . $stock . '</td><td>' . $cost . '</td><td></td><td></td><td></td><td></td><td></td></tr>';
            if(isset($instocks[$key1]))
            {
                foreach($instocks[$key1] as $ins)
                {
                    $stock += $ins['quantity'];
                    $cost += $ins['cost'];
                    echo '<tr><td></td><td></td><td>' . $ins['created'] . '</td><td></td><td></td><td>' . $ins['quantity'] . '</td><td>' . $ins['cost'] . '</td><td></td><td></td><td>' . $ins['ordernum'] . '</td></tr>';
                }
            }
            if(isset($outstocks[$key1]))
            {
                foreach($outstocks[$key1] as $outs)
                {
                    $stock -= $outs['quantity'];
                    $cost -= $outs['cost'];
                    echo '<tr><td></td><td></td><td>' . $outs['created'] . '</td><td></td><td></td><td></td><td></td><td>' . $outs['quantity'] . '</td><td>' . $outs['cost'] . '</td><td>' . $outs['ordernum'] . '</td></tr>';
                }
            }
            echo '<tr><td></td><td></td><td>期末</td><td>' . $stock . '</td><td>' . $cost . '</td><td></td><td></td><td></td><td></td><td></td></tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

    public function action_inventory_search()
    {
        $from = Arr::get($_REQUEST, 'from', NULL);
        if (!$from)
        {
            die('invalid request');
        }
        $to = Arr::get($_REQUEST, 'to', NULL);
        $sql = '';
        $filename = 'inventory';
        if ($to)
        {
            $filename .= "from-$from-to-$to";
            $sql = ' created >= ' . strtotime($from) . ' AND created < ' . strtotime($to);
        }
        else
        {
            $filename .= "from-$from";
            $to = strtotime($from) + 86400;
            $sql = ' created >= ' . strtotime($from) . ' AND created < ' . $to;
        }
        $month = date('Ym', strtotime($from));
        $instocks = array();
        $result = DB::query(Database::SELECT, 'SELECT sku, attributes, quantity, ordernum, FROM_UNIXTIME(created) AS created, cost FROM order_instocks WHERE ' . $sql . ' ORDER BY created, sku, attributes')->execute('slave')->as_array();
        foreach($result as $value)
        {
            $value['sku'] = strtoupper($value['sku']);
            $key = trim($value['sku']) . '-' . trim($value['attributes']);
            $instocks[$key][] = $value;
        }
        $outstocks = array();
        $result = DB::query(Database::SELECT, 'SELECT sku, attributes, quantity, ordernum, FROM_UNIXTIME(created) AS created, cost FROM order_outstocks WHERE ' . $sql . ' ORDER BY created, sku, attributes')->execute('slave')->as_array();
        foreach($result as $value)
        {
            $value['sku'] = strtoupper($value['sku']);
            $key = trim($value['sku']) . '-' . trim($value['attributes']);
            $outstocks[$key][] = $value;
        }

        $from1 = strtotime($month . '01');
        $to1 = strtotime($from) - 1;
        $instocks_first = array();
        $instocks_cost = array();
        $result = DB::query(Database::SELECT, 'SELECT sku, attributes, SUM(quantity) AS qty, SUM(cost) AS t_cost FROM order_instocks WHERE created BETWEEN ' . $from1 . ' AND ' . $to1 . ' GROUP BY sku, attributes')->execute('slave');
        foreach($result as $value)
        {
            $key = trim($value['sku']) . '-' . trim($value['attributes']);
            $instocks_first[$key] = $value['qty'];
            $instocks_cost[$key] = $value['t_cost'];
        }
        $outstocks_first = array();
        $outstocks_cost = array();
        $result1 = DB::query(Database::SELECT, 'SELECT sku, attributes, SUM(quantity) AS qty, SUM(cost) AS t_cost FROM order_outstocks WHERE created BETWEEN ' . $from1 . ' AND ' . $to1 . ' GROUP BY sku, attributes')->execute('slave');
        foreach($result1 as $value)
        {
            $value['sku'] = strtoupper($value['sku']);
            $key = trim($value['sku']) . '-' . trim($value['attributes']);
            $outstocks_first[$key] = $value['qty'];
            $outstocks_cost[$key] = $value['t_cost'];
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Products-' . $filename . '.csv"');
        echo "\xEF\xBB\xBF" . "SKU,Attributes,Date,期初/末数量,期初/末成本,入库数量,入库成本,出库数量,出库成本,Ordernum\n";
        $inventories = DB::select(DB::expr('sku, attributes, first, end, instock_cost, outstock_cost, first_cost, end_cost'))->from('checks_inventories')->where('month', '=', $month)->execute('slave')->as_array();
        foreach($inventories as $data)
        {
            $data['sku'] = strtoupper($data['sku']);
            $stock = $data['first'];
            $cost = $data['first_cost'];
            $key1 = trim($data['sku']) . '-' . trim($data['attributes']);
            if(isset($instocks_first[$key1]))
                $stock += $instocks_first[$key1];
            if(isset($outstocks_first[$key1]))
                $stock -= $outstocks_first[$key1];

            if(isset($instocks_cost[$key1]))
                $cost += $instocks_cost[$key1];
            if(isset($outstocks_first[$key1]))
                $cost -= $outstocks_first[$key1];

            echo $data['sku'] . ',' . $data['attributes'] . ',初期,' . $stock . ',' . $cost . ',,,,,,';
            echo PHP_EOL;
            if(isset($instocks[$key1]))
            {
                foreach($instocks[$key1] as $ins)
                {
                    $stock += $ins['quantity'];
                    $cost += $ins['cost'];
                    echo ',,' . $ins['created'] . ',,,' . $ins['quantity'] . ',' . $ins['cost'] . ',,,' . $ins['ordernum'] . ',';
                    echo PHP_EOL;
                }
            }
            if(isset($outstocks[$key1]))
            {
                foreach($outstocks[$key1] as $outs)
                {
                    $stock -= $outs['quantity'];
                    $cost -= $outs['cost'];
                    echo ',,' . $outs['created'] . ',,,,,' . $outs['quantity'] . ',' . $outs['cost'] . ',' . $outs['ordernum'] . ',';
                    echo PHP_EOL;
                }
            }
            echo ',,期末,' . $stock . ',' . $cost . ',,,,,,';
            echo PHP_EOL;
        }
    }

    public function action_inventory_check_error()
    {
        $today = time();
        $month = date('Ym');
        $last_month = date('Ym', strtotime('midnight - 1 month'));
        $inventorys = array();
        $result = DB::select(DB::expr('sku, attributes, end'))->from('checks_inventories')->where('month', '=', $last_month)->execute('slave')->as_array();
        foreach($result as $value)
        {
            $value['sku'] = strtoupper($value['sku']);
            $key = trim($value['sku']) . '-' . trim($value['attributes']);
            $inventorys[$key] = $value['end'];
        }

        $from = strtotime($month . '01');
        $to = $today;
        $instocks = array();
        $result = DB::query(Database::SELECT, 'SELECT sku, attributes, SUM(quantity) AS qty FROM order_instocks WHERE created BETWEEN ' . $from . ' AND ' . $to . ' GROUP BY sku, attributes')->execute('slave');
        foreach($result as $value)
        {
            $value['sku'] = strtoupper($value['sku']);
            $key1 = trim($value['sku']) . '-' . trim($value['attributes']);
            $instocks[$key1] = $value['qty'];
        }
        $outstocks = array();
        $result1 = DB::query(Database::SELECT, 'SELECT sku, attributes, SUM(quantity) AS qty FROM order_outstocks WHERE created BETWEEN ' . $from . ' AND ' . $to . ' GROUP BY sku, attributes')->execute('slave');
        foreach($result1 as $value)
        {
            $value['sku'] = strtoupper($value['sku']);
            $key2 = trim($value['sku']) . '-' . trim($value['attributes']);
            $outstocks[$key2] = $value['qty'];
        }

        foreach($inventorys as $key => $val)
        {
            if(isset($instocks[$key]))
                $val += $instocks[$key];
            if(isset($outstocks[$key]))
                $val -= $outstocks[$key];
            $inventorys[$key] = $val;
        }

        echo '<table cellspacing="1" cellpadding="1" border="1">';
        echo '<tbody>';
        echo '<tr><td>SKU</td><td>Attributes</td><td>此刻期末库存</td><td>此刻库存数量</td></tr>';
        $stocks = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sku, attributes, sum(quantity) qty FROM order_instocks WHERE status=0 GROUP BY sku,attributes ')->execute();
        foreach($stocks as $stock)
        {
            $stock['sku'] = strtoupper($stock['sku']);
            $key = trim($stock['sku']) . '-' . trim($stock['attributes']);
            if(isset($inventorys[$key]))
            {
                if($inventorys[$key] != $stock['qty'] OR $inventorys[$key] < 0 OR $stock['qty'] < 0)
                {
                    echo '<tr><td>' . $stock['sku'] . '</td><td>' . $stock['attributes'] . '</td><td>' . $inventorys[$key] . '</td><td>' . $stock['qty'] . '</td></tr>';
                }
            }
            // else
            // {
            //     echo '<tr><td>' . $stock['sku'] . '</td><td>' . $stock['attributes'] . '</td><td></td><td>' . $stock['qty'] . '</td></tr>';
            // }
        }
        echo '</tbody>';
        echo '</table>';
    }

}

?>