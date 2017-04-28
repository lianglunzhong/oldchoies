<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_ERP extends Controller
{
    public function action_api()
    {
        if ($_POST)
        {
            $server = Arr::get($_POST, 'server_url', NULL);
            $qs = array(
                'domain' => Arr::get($_POST, 'domain', NULL), 
                'option' => Arr::get($_POST, 'option', NULL), 
                'params' => Arr::get($_POST, 'param', NULL), 
            );

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $server."?".http_build_query($qs), 
                CURLOPT_RETURNTRANSFER => TRUE, 
            ));

            $response = curl_exec($ch);
            if (curl_errno($ch))
                die(curl_error($ch));

            die($response);
        }

        $this->request->response = View::factory('/admin/site/erp_api')
            ->render();
    }

    public function action_item_id()
    {
        if (!$_FILES)
        {
            $this->request->response = 
                View::factory("/admin/site/erp_item_id")->render();
            return TRUE;
        }

        $site_id = intval(Arr::get($_POST, 'site_id', 0));
        if (!$site_id)
            die("Invalid Site ID\n");

        $sku2id = array();
        $fp = fopen($_FILES['csv_file']['tmp_name'], "r");
        if (!$fp)
            die("Failed to open csv file\n");

        while ($line = fgets($fp))
        {
            list($item_id, $sku) = explode(',', trim($line));
            if ($slash_pos = strpos($sku, '/'))
                $sku = substr($sku, 0, $slash_pos);
            $sku2id[$sku] = $item_id;
        }
        fclose($fp);

        $products = DB::select('id', 'sku')
            ->from('products_product')
            ->where('site_id', '=', $site_id)
            ->execute();
        $changed = 0;
        $total = 0;
        foreach ($products as $product)
        {
            $total++;
            if (array_key_exists($product['sku'], $sku2id))
            {
                $changed += DB::update('products')
                    ->set(array('erp_item_id' => $sku2id[$product['sku']]))
                    ->where('id', '=', $product['id'])
                    ->execute();
            }
        }

        echo "$total processed, $changed changed\n";
    }

    public function action_daemon()
    {
        $site = Site::instance(0, 'www.ezclickoptical.com');
        ERP::do_task();
    }

    public function action_temp()
    {
        $site = Site::instance(0, 'www.ezclickoptical.com');
        $order = new Order(688);
        if (!$order->get('id'))
            die('order not found');
        ERP::order_gl($order);
    }

    public function action_verify()
    {
        $this->request->response = View::factory('/admin/site/erp_verify')
            ->render();
    }

    public function action_proxy()
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => 'http://www.ezclickoptical.com/payment/status_return', 
            CURLOPT_RETURNTRANSFER => TRUE, 
            CURLOPT_TIMEOUT => 30, 
            CURLOPT_POST => TRUE, 
            CURLOPT_POSTFIELDS => $_POST, 
        ));

        echo curl_exec($ch);
    }
}
