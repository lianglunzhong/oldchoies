<?php

defined('SYSPATH') or die('No direct script access.');

class Order
{

    private static $instances;
    private $data;
    private $site_id;
    private $id;

    public static function instance($id = 0)
    {
        if (!isset(self::$instances[$id]))
        {
            self::$instances[$id] = new self($id);
        }

        return self::$instances[$id];
    }

    public function __construct($id)
    {
        $this->id = $id;
        $this->site_id = Site::instance()->get('id');
        $this->data = NULL;
        $this->_load();
    }

    private function _load()
    {
        if (!$this->id)
            return FALSE;
        $result = DB::select()->from('orders_order')
                ->where('id', '=', $this->id)
                ->execute()->current();

        $this->data = $result;
    }

    // Used
    public static function create_ordernum()
    {
        $order_num = (time() - 1278000000) . str_pad(mt_rand(1, 9999), 4, '0')
            . Site::instance()->get('cc_payment_id');
        kohana_log::instance()->add('order_num:', $order_num);
        return $order_num;
    }

    // get a order by ordernum
    // return order_id
    public static function get_from_ordernum($ordernum)
    {
        if (!$ordernum)
        {
            return FALSE;
        }

        return DB::select('id')
                ->from('orders_order')
                ->where('ordernum', '=', $ordernum)
                ->execute()
                ->get('id');
    }

    public static function init()
    {
        $order = ORM::factory('order');
        // $order->site_id = Site::instance()->get('id');
        $order->created = time();
//		$order->ordernum = self::create_ordernum();
        // initial payment information
        $order->amount_payment = 0;
        $order->payment_status = 'new';
        $order->transaction_id = 0;
        // set shipping information
        $order->shipping_status = 'new_s';
        // $order->is_active = 1;
        // $order->is_marked = 0;
        // $order->is_verified = 0;
        // $order->is_pre_order = 0;
        // $order->unprint_mail_flg = 0;
        // $order->facebook_cpc = 0;
        // $order->deleted = 0;
        $order->save();
        
//		$order->ordernum = str_pad($order->id, 7, '0')
//			.Site::instance()->get('cc_payment_id');        
        $order->ordernum = (string) ($order->id + 1000000) . (string) (Site::instance()->get('cc_payment_id') + 2);
        if(!$order->ordernum)
        {
            kohana::$log->add('order/set','创建订单时，无ordernum');
            Request::Instance()->redirect(BASEURL);
        }
        $order->save();
        return $order->id;
    }

    public static function is_paid($status)
    {
        return !in_array($status, array('new', 'failed', 'partial_paid'));
    }

    public function set($data = array())
    {
        $order = ORM::factory('order')
            ->where('id', '=', $this->get('id'))
            ->find();
        if (!$order)
        {
            return FALSE;
        }

        $order->values($data);
        $ret = $order->save();
        if ($ret)
        {
            $this->data = array_merge((array) $this->data, $data);
        }

        return $ret;
    }

    // Used
    public function get($key = NULL)
    {
        if (is_null($key))
        {
            return $this->data;
        }
        else
        {
            return isset($this->data[$key]) ? $this->data[$key] : NULL;
        }
    }

    public function set_products($products = array())
    {
        if (!is_array($products))
        {
            return FALSE;
        }

        $this->clean_products();

        foreach ($products as $key => $product)
        {
            if (!$this->add_product($product, $key))
            {
                // FIXME roll back
                return FALSE;
            }
        }

        return TRUE;
    }

    public function set_largesses($largesses = array())
    {
        // return largesses
        if (!$largesses)
        {
            //get order largesses structure
            $largesses = unserialize($this->data['largesses']);
            return $largesses;
        }

        // clean largesses
        $this->clean_largesses();

        //set order largesses
        foreach ($largesses as $key => $largess)
        {
            switch ($largess['type'])
            {
                case 0:
                    // simple product
                    // add attributes
                    $attributes = '';
                    foreach (Arr::get($largess, 'attributes', array()) as $attr_key => $attr_value)
                    {
                        $attributes.=$attr_key . ": " . $attr_value . ";";
                    }
                    $this->set_item($largess['id'], $largess['id'], $key, $largess['quantity'], $largess['price'], 1, $attributes);
                    break;
                case 1:
                    // config product
                    Product::instance($largess['id'])->hit($largess['quantity']);
                    $this->set_item($largess['items'][0], $largess['id'], $key, $largess['quantity'], $largess['price'], 1);
                    break;
                case 3:
                    // simple config product
                    // add attributes
                    $attributes = '';
                    foreach ($largess['attributes'] as $attr_key => $attr_value)
                    {
                        if ($attr_key == 'Size' AND Product::instance($largess['id'])->get('set_id') == 2)
                        {
                            $attr_value = preg_replace('/[A-Z]+/i', '', $attr_value);
                            // Shoes Edit Europen Size
                            if (strpos($attr_value, '-') !== False) // UK
                            {
                                $attr = explode('-', $attr_value);
                                $attr_value = round($attr[0] + 33);
                            }
                            elseif ($attr_value >= 4 AND $attr_value <= 14) // US
                                $attr_value = $attr_value + 31;
                            elseif ($attr_value >= 22.5 AND $attr_value <= 27.5) // CM
                                $attr_value = $attr_value * 2 - 10;
                        }
                        $attributes.=$attr_key . ": " . $attr_value . ";";
                    }
                    $this->set_item($largess['id'], $largess['id'], $key, $largess['quantity'], $largess['price'], 1, $attributes);
                    break;
                default:
                    break;
            }
        }
    }

    public function clean_largesses()
    {
        //get original largesses
        if ($this->data['largesses'])
        {
            $original_largesses = array();
        }
        else
        {
            $original_largesses = serialize($this->data['largesses']);
        }

        //reduce config and package product's hits
        foreach ($original_largesses as $item)
        {
            if ($item['type'] == 0)
            {

                Product::instance($item['id'])->hit(0 - $item['quantity']);
            }
        }

        // remove orderitems
        DB::delete('orders_orderitem')->where('order_id', '=', $this->data['id'])->where('is_gift', '=', '1')->execute();

        // reduce the items
        $items = Cart::items($original_largesses);

        foreach ($items as $id => $item)
        {
            Product::instance($id)->hit(-$item);
        }
    }

    public function set_item($item_id, $product_id, $key, $quantity, $price = NULL, $is_gift = 0, $attributes = '')
    {
        $item = Product::instance($item_id);
        if ($item->get('id'))
        {
            $item_data = array();
            $item_data['product_id'] = $product_id;
            $item_data['order_id'] = $this->data['id'];
            $item_data['key'] = $key;
            // $item_data['site_id'] = $this->site_id;
            $item_data['item_id'] = $item_id;
            $item_data['name'] = $item->get('name');
            $item_data['sku'] = $item->get('sku');
            $item_data['link'] = $item->permalink();
            $item_data['price'] = isset($price) ? $price : $item->price($quantity);
            $item_data['cost'] = $item->get('cost');
            $item_data['weight'] = $item->get('weight');
            $item_data['quantity'] = $quantity;
            $item_data['created'] = time();
            $item_data['is_gift'] = $is_gift;
            $item_data['attributes'] = $attributes;
            DB::insert('orders_orderitem', array_keys($item_data))->values($item_data)->execute();

            //add items hits
            $product = ORM::factory('product', $item_id);
            $product->hits += $quantity;
            $product->save();
            return TRUE;
        }
        return FALSE;
    }

    public function clean_creditcard($order_id)
    {
        $values = array(
            'cc_num' => '',
            'cc_type' => '',
            'cc_cvv' => '',
            'cc_exp_month' => '',
            'cc_exp_year' => '',
            'cc_issue' => '',
            'cc_valid_month' => '',
            'cc_valid_year' => '',
        );
        $updated = DB::update('orders_order')
            ->set($values)
            ->where('id', '=', $order_id)
            ->execute();
        if ($updated)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    // get a full detailed order
    public function detail()
    {
        return array(
            'basic' => $this->basic(),
            'products' => $this->products(),
            'payments' => $this->payments(),
            'shipments' => $this->shipments(),
            'remarks' => $this->remarks(),
            'histories' => $this->histories(),
        );
    }

    // get order basic information
    public function basic()
    {
        return DB::select()
                ->from('orders_order')
                ->where('id', '=', $this->id)
                ->execute()
                ->current();
    }

    // set order basic information
    public function update_basic($update)
    {
        $orig = $this->basic();

        $update['updated'] = time();
        $ret = DB::update('orders_order')
            ->set($update)
            ->where('id', '=', $this->id)
            ->execute();
        if ($ret)
        {
            // record change to order history
            $message = array();
            $updated = array_diff_assoc($update, $orig);
            foreach ($updated as $k => $u)
            {
                if ($k == 'updated' || $k == 'products')
                    continue;

                $message[] = "update $k from $orig[$k] to $u";
            }

            $message = implode('<br />', $message);
            if (!empty($message))
            {
                $this->add_history(array(
                    'order_status' => 'update basic',
                    'message' => $message,
                ));
            }
        }

        return $ret;
    }

    // get all payment records
    public function payments()
    {
        return DB::select()
                ->from('orders_orderpayments')
                ->where('order_id', '=', $this->id)
                ->order_by('created', 'DESC')
                ->execute()
                ->as_array();
    }

    // add a payment record
    public function add_payment($payment)
    {
        if (!$this->id)
        {
            return FALSE;
        }

        $payment += array(
            // 'site_id' => $this->site_id,
            'order_id' => $this->id,
            'customer_id' => 0,
            'created' => time(),
            'ip' => sprintf("%u", ip2long(Request::$client_ip)),
        );

        return DB::insert('orders_orderpayments', array_keys($payment))
                ->values(array_values($payment))
                ->execute();
    }

    // get all remark records
    public function remarks()
    {
        return DB::select()
                ->from('orders_orderremarks')
                ->where('order_id', '=', $this->id)
                ->order_by('created', 'DESC')
                ->execute()
                ->as_array();
    }

    // insert a remark
    public function add_remark($remark)
    {
        if (!$this->id)
        {
            return FALSE;
        }

        $remark += array(
            // 'site_id' => $this->site_id,
            'order_id' => $this->id,
            'admin_id' => Session::instance()->get('user_id', 0),
            'remark' => '',
            'created' => time(),
            'ip' => sprintf("%u", ip2long(Request::$client_ip)),
        );

        return DB::insert('orders_orderremarks', array_keys($remark))
                ->values(array_values($remark))
                ->execute();
    }

    // get all history records
    public function histories()
    {
        return DB::select()
                ->from('orders_orderhistories')
                ->where('order_id', '=', $this->id)
                ->order_by('created', 'DESC')
                ->execute()
                ->as_array();
    }

    // insert a history
    public function add_history($history)
    {
        if (!$this->id)
        {
            return FALSE;
        }

        /*$user_id = isset(Session::instance()->get('user_id')) ? Session::instance()->get('user_id') : 1;*/
        $history += array(
            // 'site_id' => $this->site_id,
            'order_id' => $this->id,
            'admin_id' => Session::instance()->get('user_id'),
            'created' => time(),
        );

        return DB::insert('orders_orderhistories', array_keys($history))
                ->values(array_values($history))
                ->execute();
    }

    // get all products
    public function products()
    {
        $products = DB::select()
            ->from('orders_orderitem')
            ->where('order_id', '=', $this->id)
            ->execute()
            ->as_array();
        if ($products)
        {
            foreach ($products as $key => &$product)
            {
                if ($product['customize'])
                {
                    $product['customize'] = unserialize($product['customize']);
                }
            }
        }

        return $products ? $products : array();
    }

    public function goodsInfo()
    {
        $products = DB::query(Database::SELECT,"SELECT p.id,p.name,p.description FROM `orders_orderitem` o LEFT JOIN products_product p on o.product_id = p.id where o.order_id=".$this->id." GROUP BY p.id")->execute()->as_array();
        $info['name'] = '';
        $info['desc'] = '';
        foreach ($products as $product)
        {
            $info['name'] .= $product['name'].'|';
            $info['desc'] .= $product['description'].'|';
        }
        $info['name'] = trim($info['name'],'|');
        $info['desc'] = trim($info['desc'],'|');
        return $info;
    }
    // get all products
    public function products_c()
    {

        $products = DB::query(Database::SELECT,'select oi.* from orders_orderitem oi left join products_product p on p.id = oi.product_id where oi.order_id ='.$this->id. ' and p.visibility >0 and p.status>0 ')->execute()->as_array();

        if ($products)
        {
            foreach ($products as $key => &$product)
            {
                if ($product['customize'])
                {
                    $product['customize'] = unserialize($product['customize']);
                }
            }
        }

        return $products ? $products : array();
    }

    // get all order items.
    public function getitems()
    {
        $orderitems = DB::select()
            ->from('orders_orderitem')
            ->where('order_id', '=', $this->id)
            ->execute();
        return $orderitems;
    }

    // get all order items.
    public function orderitems()
    {
        $orderitems = DB::select()
            ->from('orders_orderitem')
            ->where('order_id', '=', $this->id)
            ->execute();

        $ois = array();
        foreach ($orderitems as $v)
        {
            if (isset($ois[$v['item_id']]))
            {
                $ois[$v['item_id']] += $v['quantity'];
            }
            else
            {
                $ois[$v['item_id']] = $v['quantity'];
            }
        }

        return $ois;
    }

    // get an order item by product key and item_id
    public function orderitem($product_key, $item_id)
    {
        return DB::select()
                ->from('orders_orderitem')
                ->where('order_id', '=', $this->id)
                ->where('key', '=', $product_key)
                ->where('item_id', '=', $item_id)
                ->execute()
                ->current();
    }

    // delete a product by key
    public function delete_product($key)
    {
        $products = unserialize($this->get('products'));
        if (!array_key_exists($key, $products))
        {
            return FALSE;
        }

        unset($products[$key]);
        if ($this->update_basic(array('products' => serialize($products))))
        {
            $this->add_history(array(
                'order_status' => 'delete product',
                'message' => "key = $key",
            ));
            // delete orders_orderitem
            return DB::delete('orders_orderitem')
                    ->where('order_id', '=', $this->id)
                    ->where('key', '=', $key)
                    ->execute();
        }

        return FALSE;
    }

    // get all shipment records
    public function shipments()
    {
        $shipments = DB::select()
            ->from('orders_ordershipments')
            ->where('order_id', '=', $this->id)
            ->order_by('created', 'DESC')
            ->execute()
            ->as_array();
        if (!$shipments)
        {
            return $shipments;
        }

        // get items information for each shipment record
        foreach ($shipments as &$shipment)
        {
            $shipment['items'] = DB::select()
                ->from('orders_ordershipmentitems')
                ->where('shipment_id', '=', $shipment['id'])
                ->execute()
                ->as_array();
        }

        return $shipments;
    }

    // add a shipment record
    public function add_shipment($shipment, $items)
    {
        if (!$this->id || !$items)
        {
            return FALSE;
        }

        $shipment += array(
            'admin_id' => 0,
            // 'site_id' => $this->site_id,
            'order_id' => $this->id,
            'ordernum' => $this->get('ordernum'),
            'created' => time(),
            'admin_id' => 1,
        );

        // insert shipment information to order_shipments
        $shipment_id = DB::insert('orders_ordershipments', array_keys($shipment))
            ->values(array_values($shipment))->execute();

        if (!$shipment_id)
        {
            return FALSE;
        }

        $shipment_id = $shipment_id[0];

        // insert shipment items
        foreach ($items as $item)
        {
            $item += array(
                'order_id' => $this->id,
                'shipment_id' => $shipment_id,
            );

            $success = DB::insert('orders_ordershipmentitems', array_keys($item))
                ->values(array_values($item))
                ->execute();
            // update order items status = 'shipped'
            DB::update('orders_orderitem')->set(array('status' => 'shipped', 'tracking_number' => time()))->where('product_id', '=', $item['item_id'])->where('order_id', '=', $this->id)->execute();
            if (!$success)
            {
                // roll back
                DB::delete('orders_ordershipmentitems')
                    ->where('shipment_id', '=', $shipment_id)
                    ->execute();

                DB::delete('orders_ordershipments')
                    ->where('id', '=', $shipment_id)
                    ->execute();

                return FALSE;
            }
        }

        return TRUE;
    }

    public function add_product($product, $key = null)
    {
        if (!$key)
            $key = "${product['id']}_${product['type']}_" . md5(serialize($product['items'])) . (isset($product['attributes']) ? '_' . md5(serialize($product['attributes'])) : '');
        $products = empty($this->data['products']) ? array() : unserialize($this->data['products']);

        if (array_key_exists($key, $products))
        {
            $products[$key]['quantity'] += $product['quantity'];
        }
        else
        {
            $products[$key] = $product;
        }

        // save updated products data
        if (!$this->set(array('products' => serialize($products))))
        {
            return FALSE;
        }

        // set product items
        $this->clean_items($key);
        switch ($product['type'])
        {
            case 0: // simple
                $attribute = '';
                foreach (Arr::get($product, 'attributes', array()) as $attr_key => $attr_value)
                {
                    $attribute.=$attr_key . ": " . $attr_value . ";";
                }
                $this->add_item(array(
                    'key' => $key,
                    'product_id' => $product['id'],
                    'item_id' => $product['items'][0],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'customize' => isset($product['customize']) ? serialize($product['customize']) : NULL,
                    'customize_type' => isset($product['customize_type']) ? $product['customize_type'] : 'none',
                    'attributes' => $attribute,
                    'original_price'=>Product::instance($product['id'])->get('price'),//guo 记录当时产品原价
                ));
                break;
            default:
                $this->add_item(array(
                    'key' => $key,
                    'product_id' => $product['id'],
                    'item_id' => $product['items'][0],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'customize' => isset($product['customize']) ? serialize($product['customize']) : NULL,
                    'customize_type' => isset($product['customize_type']) ? $product['customize_type'] : 'none',
                    'original_price'=>Product::instance($product['id'])->get('price'),//guo 记录当时产品原价
                ));
                break;
            case 1: // config
                $this->add_item(array(
                    'key' => $key,
                    'product_id' => $product['id'],
                    'item_id' => $product['items'][0],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'customize' => isset($product['customize']) ? serialize($product['customize']) : NULL,
                    'customize_type' => isset($product['customize_type']) ? $product['customize_type'] : 'none',
                    'original_price'=>Product::instance($product['id'])->get('price'),//guo 记录当时产品原价
                ));
                break;
            case 2: // package
                foreach ($product[$key]['items'] as $item)
                {
                    $this->add_item(array(
                        'key' => $key,
                        'product_id' => $product['id'],
                        'item_id' => $product['items'][0],
                        'price' => $product['price'] / $item['quantity'],
                        'quantity' => $item['quantity'] * $product['quantity'],
                        'original_price'=>Product::instance($product['id'])->get('price'),//guo 记录当时产品原价
                    ));
                }
                break;
            case 3: // simple-config
                $attribute = '';
                foreach (Arr::get($product, 'attributes', array()) as $attr_key => $attr_value)
                {
                    if ($attr_key == 'Size' AND Product::instance($product['id'])->get('set_id') == 2)
                    {
                        // Shoes Edit Europen Size
                        $attr_value = strtoupper($attr_value);
                        if (strpos($attr_value, 'UK') !== False) // UK
                        {
                            $attr_value = str_replace('UK', '', $attr_value);
                            $attr = explode('-', $attr_value);
                            $attr_value = round($attr[0] + 33);
                        }
                        elseif (strpos($attr_value, 'US') !== False) // US
                        {
                            $attr_value = str_replace('US', '', $attr_value);
                            $attr_value = $attr_value + 31;
                        }
                        elseif (strpos($attr_value, 'CM') !== False) // CM
                        {
                            $attr_value = str_replace('CM', '', $attr_value);
                            $attr_value = $attr_value * 2 - 10;
                        }
                    }
                    $attribute.=$attr_key . ": " . $attr_value . ";";
                }
                $this->add_item(array(
                    'key' => $key,
                    'product_id' => $product['id'],
                    'item_id' => $product['items'][0],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'customize' => isset($product['customize']) ? serialize($product['customize']) : NULL,
                    'customize_type' => isset($product['customize_type']) ? $product['customize_type'] : 'none',
                    'attributes' => $attribute,
                    'original_price'=>Product::instance($product['id'])->get('price'),//guo 记录当时产品原价
                ));
                break;
            case 4: // coupon item
              $attribute =  'Size: one size;';
                $this->add_item(array(
                    'key' => $key,
                    'product_id' => $product['id'],
                    'item_id' => $product['items'][0],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'customize' => isset($product['customize']) ? serialize($product['customize']) : NULL,
                    'customize_type' => isset($product['customize_type']) ? $product['customize_type'] : 'none',
                    'is_gift' => 1,
                    'attributes' => $attribute,
                    'original_price'=>Product::instance($product['id'])->get('price'),//guo 记录当时产品原价
                ));
        }

        Product::instance($product['id'])->hits_inc();
        return TRUE;
    }

    // delete all items for a specific product
    public function clean_items($key)
    {
        return DB::delete('orders_orderitem')
                ->where('order_id', '=', $this->id)
                ->where('key', '=', $key)
                ->execute();
    }

    public function clean_products()
    {
        $this->set(array('products' => ''));
        return DB::delete('orders_orderitem')
                ->where('order_id', '=', $this->id)
                ->execute();
    }

    public function get_item($id)
    {
        $item = DB::select()
            ->from('orders_orderitem')
            ->where('id', '=', $id)
            ->execute()
            ->current();
        $product_id = $item['product_id'];
        $product = DB::select('sku','name')->from('products_product')->where('id', '=', $product_id)->execute()->current();
        $item['sku'] = $product['sku'];
        $item['name'] = $product['name'];
        
        if (!$item)
            return $item;

        $item['customize'] = unserialize($item['customize']);
        return $item;
    }

    public function add_item($item)
    {
        $product = Product::instance($item['item_id']);
        $itemsku = Item::instance($item['item_id']);
        if (!$product)
            return FALSE;

        $item += array(
            // 'site_id' => $this->site_id,
            'order_id' => $this->id,
            'name' => $product->get('name'),
            'sku' => $itemsku->get('sku'),
            'link' => $product->permalink(),
            'price' => $product->price(Arr::get($item, 'quantity', 1)),
            'cost' => $product->get('cost'),
            'weight' => $product->get('weight'),
            'created' => time(),
            'customize' => NULL,
            'status' => 'new',
        );

        if (!$item['customize'])
        {
            $exist = DB::select('id', 'quantity')
                ->from('orders_orderitem')
                ->where('order_id', '=', $this->id)
                ->where('product_id', '=', $item['product_id'])
                ->where('price', '=', $item['price'])
                ->where('customize', 'IS', NULL)
                ->where('status', '=', $item['status'])
                ->where('attributes', isset($item['attributes']) ? '=' : 'IS', Arr::get($item, 'attributes', NULL))
                ->execute()
                ->current();

            if ($exist)
            {
                $ret = $this->update_item($exist['id'], array('quantity' => $exist['quantity'] + $item['quantity']));
                if (!$ret)
                    return $ret;

                return array('UPDATE', $exist['id']);
            }
        }

        $ret = DB::insert('orders_orderitem', array_keys($item))
            ->values($item)
            ->execute();
        if (!$ret)
            return $ret;

        return array('CREATE', $ret[0]);
    }

    public function insert_item($item)
    {
        $product = Product::instance($item['item_id']);
        if (!$product)
            return FALSE;

        $item += array(
            // 'site_id' => $this->site_id,
            'order_id' => $this->id,
            'name' => $product->get('name'),
            'sku' => $product->get('sku'),
            'link' => $product->permalink(),
            'price' => $product->price(Arr::get($item, 'quantity', 1)),
            'cost' => $product->get('cost'),
            'weight' => $product->get('weight'),
            'created' => time(),
            'customize' => NULL,
            'status' => 'new',
        );

        return DB::insert('orders_orderitem', array_keys($item))
                ->values($item)
                ->execute();
    }

    public function update_item($id, $data)
    {
        return DB::update('orders_orderitem')
                ->set($data)
                ->where('id', '=', $id)
                ->execute();
    }

    public function delete_item($id)
    {
        return DB::delete('orders_orderitem')
                ->where('id', '=', $id)
                ->execute();
    }

    public function cancel_item($id, $qty)
    {
        $item = $this->get_item($id);
        if ($item['status'] == 'shipped')
        {
            $new_item = $item;
            unset($new_item['id']);
            $new_item['quantity'] = (-1) * $qty;
            $new_item['status'] = 'return';
            return $this->insert_item($new_item);
        }
        else if ($item['status'] == 'new')
        {
            if ($item['quantity'] > $qty)
            {
                $new_item = $item;
                unset($new_item['id']);
                $new_item['quantity'] = (-1) * $qty;
                $new_item['status'] = 'cancel';
                $this->update_item($id, array('quantity' => $item['quantity'] - $qty));
                return $this->inert_item($new_item);
            }

            return $this->update_item($id, array('status' => 'cancel'));
        }

        return FALSE;
    }

    public function go_to_cancel()
    {
        $customer_id = Customer::logged_in();
        $order_customer = $this->get('customer_id');
        if ($customer_id !== $order_customer)
        {
            return false;
        }
        $payment_status = $this->get('payment_status');
        if ($payment_status == 'success' AND !$payment_status == 'verify_pass')
        {
            return false;
        }
        else
        {
            $this->set(array('is_active' => 0));
            $items = $this->getitems();
            foreach ($items as $item)
            {
                $this->cancel_item($item['id'], $item['quantity']);
            }
            $points = $this->get('points');
            Customer::instance($customer_id)->point_inc($points);
            return true;
        }
    }

    public function ship_item($id, $qty)
    {
        $item = $this->get_item($id);
        if ($qty < $item['quantity'])
        {
            // insert a line with status 'new'
            $new_item = $item;
            unset($new_item['id']);
            $new_item['quantity'] = $item['quantity'] - $qty;
            $this->insert_item($new_item);
            $this->update_item($id, array('quantity' => $qty));
        }

        $this->update_item($id, array('status' => 'shipped', 'tracking_number' => time()));
        $message = 'update item shipped';
        $this->add_history(array(
            'order_status' => 'update item',
            'message' => $message,
        ));
    }

    public function return_item($id)
    {
        $this->update_item($id, array('status' => 'returned'));
    }

    public function product_amount()
    {
        $amount = 0.0;
        $products = $this->products();

        foreach ($products as $product)
        {
            if ($product['status'] == 'cancel')
                continue;

            if ($product['status'] == 'return')
                $amount -= $product['price'] * $product['quantity'];
            else
                $amount += $product['price'] * $product['quantity'];
        }

        //TODO
        if (!$this->get('rate'))
            return $amount;

        return $amount * $this->get('rate');
    }

    public function amount()
    {
        return (float) $this->product_amount()
            + (float) $this->get('amount_shipping')
            + (float) $this->get('amount_drop_shipping');
    }

    public function update_amount()
    {
        $amount = (float) $this->amount();
        if (!$this->set(array('amount' => $amount)))
            return FALSE;

        if ((float) ($this->get('amount_payment')) > 0
            && ($amount - (float) $this->get('amount_payment')) > 0.00001)
        {
            $this->set(array('payment_status' => 'partial_paid'));
            if (Site::instance()->erp_enabled())
            {
                ERP::update_order_task($this->get());
            }
        }

        return TRUE;
    }

    public function erp_synced()
    {
        return $this->get('erp_header_id');
    }

    public function is_verified()
    {
        return $this->get('is_verified') == 1;
    }

    public function havecopy()
    {
        $ordernum = $this->data['ordernum'].'c'.$this->data['id'];
        $result = DB::select('id')->from('orders_order')
            ->where('ordernum', '=', $ordernum)
            ->execute('slave')->get('id');

        return $result;
    }

}
