<?php

defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Site_Wishlist extends Controller_Admin_Site
{

    public function action_list()
    {
        $content = View::factory('admin/site/wishlist_list')
            ->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
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
                elseif ($item->field == 'sku')
                {
                    $product_id = Product::get_productId_by_sku($item->data);
                    $_filter_sql[] = "W.product_id = '" . $product_id . "'";
                }
                elseif ($item->field == 'customer')
                {
                    $customer_id = DB::select('id')->from('accounts_customers')->where('email', '=', $item->data)->execute('slave')->get('id');
                    $_filter_sql[] = "W.customer_id = '" . $customer_id . "'";
                }
                else
                {
                    $_filter_sql[] = "W." . $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        if (!$sidx)
            $sidx = 1;

        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;

        if ($totalrows)
            $limit = $totalrows;
        $count = DB::query(Database::SELECT, 'SELECT count(W.id) AS count FROM wishlists W LEFT JOIN products P ON W.product_id = P.id WHERE W.site_id=' . $this->site_id . ' AND P.visibility = 1 AND P.status = 1 AND ' . $filter_sql)->execute('slave')->get('count');
        $total_pages = ceil($count / $limit);
        if ($page > $total_pages)
            $page = $total_pages;
        if ($limit < 0)
            $limit = 0;
        $start = $limit * $page - $limit; // do not put $limit*($page - 1)
        if ($start < 0)
            $start = 0;

        $result = DB::query(DATABASE::SELECT, 'SELECT * FROM wishlists W LEFT JOIN products P ON W.product_id = P.id WHERE W.site_id=' . $this->site_id . ' AND P.visibility = 1 AND P.status = 1 AND ' .
                $filter_sql . ' order by W.' . $sidx . ' ' . $sord . ' limit ' . $limit . ' offset ' . $start)->execute('slave');

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
                Customer::instance($data['customer_id'])->get('email'),
                Product::instance($data['product_id'])->get('sku'),
                date('Y-m-d', $data['created']),
            );
            $i++;
        }
        echo json_encode($response);
    }

    public function action_export()
    {
        if (!$_POST)
        {
            die('invalid request');
        }

        $date = strtotime(Arr::get($_POST, 'start', 0));
        $date_end = Arr::get($_POST, 'end', 0);

        if ($date_end)
        {
            $file_name = "wishlist-" . date('Y-m-d', $date) . '_' . $date_end . ".csv";
            $date_end = strtotime($date_end);
        }
        else
        {
            $file_name = "wishlist-" . date('Y-m-d', $date) . ".csv";
            $date_end = $date + 86400;
        }

        header("Content-type:application/vnd.ms-excel; charset=UTF-8");
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        echo "\xEF\xBB\xBF" . "Email,SKU,Created\n";
        $conditions = array(
            "P.visibility = 1",
            "P.status = 1",
            "W.created >= $date",
            "W.created < $date_end",
        );

        $where_clause = implode(' AND ', $conditions);

        $result = DB::query(Database::SELECT, 'SELECT P.sku, C.email, W.created FROM wishlists W LEFT JOIN products P ON W.product_id = P.id RIGHT JOIN customers C ON W.customer_id = C.id WHERE ' . $where_clause)->execute('slave');

        foreach ($result as $data)
        {
            echo $data['email'] . ',';
            echo $data['sku'] . ',';
            echo date('Y-m-d', $data['created']) . ',';
            echo "\n";
        }
    }

    public function action_delete()
    {
        if ($_POST)
        {
            $ids = Arr::get($_POST, 'ids', array());
            $sql = implode(',', $ids);
            $result = DB::query(Database::DELETE, 'DELETE FROM feedbacks WHERE id IN(' . $sql . ')')->execute();
            if ($result)
                Message::set('Delete feedbacks success');
            else
                Message::set('Delete feedbacks failed');
        }
        $id = $this->request->param('id');
        if ($id)
        {
            $result = DB::query(Database::DELETE, 'DELETE FROM feedbacks WHERE id =' . $id)->execute();
            if ($result)
                Message::set('Delete feedbacks success');
            else
                Message::set('Delete feedbacks failed');
        }
        $this->request->redirect('/admin/site/feedback/list');
    }

}
