<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Orderline extends Controller_Admin_Site
{
    public function action_list()
    {
        $orderlines = array();
        $site = Site::instance();

        $orderno_from = Arr::get($_POST, 'orderno_from', '');
        $orderno_to = Arr::get($_POST, 'orderno_to', '');
        $from = Arr::get($_POST, 'from', '');
        $to = Arr::get($_POST, 'to', '');
        $status = Arr::get($_POST, 'status', '');

        if ($orderno_from || $orderno_to)
            $sql = "SELECT oi.* FROM order_items oi"
                . " JOIN orders o ON oi.order_id = o.id";
        else
            $sql = "SELECT oi.* FROM order_items oi";
        $sql .= " WHERE oi.site_id = ".$site->get('id');

        if ($orderno_from)
            $sql .= " AND o.ordernum >= '$orderno_from'";
        if ($orderno_to)
            $sql .= " AND o.ordernum < '$orderno_to'";
        if ($status)
            $sql .= " AND oi.erp_line_status = '$status'";
        if ($from)
            $sql .= " AND oi.created >= ".strtotime($from);
        if ($to)
            $sql .= " AND oi.created < ".strtotime($to);

        $orderlines = DB::query(Database::SELECT, $sql)
            ->execute('slave');

        $content = View::factory('admin/site/orderline_list')
            ->set('orderlines', $orderlines)
            ->render();
        $this->request->response = View::factory('admin/template')
            ->set('content', $content)
            ->render();
    }
}
