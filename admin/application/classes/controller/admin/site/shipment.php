<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Shipment extends Controller_Admin_Site
{

    private function construct()
    {
        $id = $this->request->param('id');
        $data = DB::select()->from('orders_ordershipments')
            ->where('id', '=', $id)
            ->execute('slave')
            ->current();
        if (!$data['id'])
        {
            message::set(__('Shipment not exists.'), 'error');
            Request::instance()->redirect('/admin/site/shipment/list');
        }
        return $data;
    }

    public function action_edit()
    {
        $data = $this->construct();
        if ($_POST)
        {
            $_url = '/admin/site/shipment/edit/' . $data['id'];
            $updated = FALSE;
            //TODO validate post data
            $post = Validate::factory($_POST)
                ->filter(TRUE, 'trim')
                ->filter('tracking_link', 'trim')
                ->filter('tracking_code', 'trim')
                ->filter('ship_date', 'trim');
            if ($post->check())
            {
                $shipment_data = array();
                $shipment_data['tracking_link'] = $post['tracking_link'];
                $shipment_data['tracking_code'] = $post['tracking_code'];
                $shipment_data['ship_date'] = $post['ship_date'] ? strtotime($post['ship_date']) : '';
                $updated = Shipment::instance()->update_shipment($data['id'], $shipment_data);
            }
            if ($updated)
            {
                Message::set(__('Update shipment success.'));
            }
            else
            {
                Message::set(__('Update shipment failed.'), 'error');
            }
            $_save = Arr::get($_POST, '_save', '');
            if ($_save)
                $_url = '/admin/site/shipment/list';
            $this->request->redirect($_url);
        }
        $shippeditems = Shipment::instance()->get_shipmentitems($data['id']);
        $content = View::factory('admin/site/shipment_edit')
            ->set('data', $data)
            ->set('orderitems', $shippeditems)
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
    }

    public function action_list()
    {
        $content = View::factory('admin/site/shipment_list')
            ->render();
        $this->request->response = View::factory('admin/template')->set('content', $content)->render();
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
                //TODO add filter items
                if ($item->data)
                {
                    if ($item->field == 'ship_date')
                    {
                        $_filter_sql[] = $item->field . "='" . strtotime($item->data) . "'";
                        continue;
                    }
                    $_filter_sql[] = $item->field . "='" . $item->data . "'";
                }
            }
            if (!empty($_filter_sql))
                $filter_sql = implode(' AND ', $_filter_sql);
        }

        $result = DB::query(DATABASE::SELECT, 'SELECT COUNT(`order_shipments`.`id`) AS num FROM `orders_ordershipments` WHERE '
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

        $result = DB::query(DATABASE::SELECT, 'SELECT `order_shipments`.* FROM `orders_ordershipments` WHERE '
                . $filter_sql . ' ORDER BY ' . $sidx . ' ' . $sord . ' LIMIT ' . $limit . ' OFFSET ' . $start)->execute('slave');
        $responce = array();
        $responce['page'] = $page;
        $responce['total'] = $total_pages;
        $responce['records'] = $count;

        $order_status = Order::instance()->get_orderstatus();
        $k = 0;
        foreach ($result as $value)
        {
            $responce['rows'][$k]['id'] = $value['id'];
            $responce['rows'][$k]['cell'] = array(
                $value['id'],
                $value['order_id'],
                $value['ordernum'],
                $value['tracking_link'],
                $value['tracking_code'],
                $value['ship_date'] ? date('Y-m-d', $value['ship_date']) : '',
                date('Y-m-d H:i:s', $value['created']),
            );
            $k++;
        }
        echo json_encode($responce);
    }

}