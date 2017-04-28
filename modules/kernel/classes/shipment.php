<?php defined('SYSPATH') or die('No direct script access.');

class Shipment
{
    public static $instances;
    private $site_id;
    private $data;

    public static function & instance($id = 0)
    {
        if(!isset(self::$instances[$id]))
        {
            $class = __CLASS__;
            self::$instances[$id] = new $class($id);
        }
        return self::$instances[$id];
    }

    public function __construct($id)
    {
        $this->site_id = Site::instance()->get('id');
        $this->data = NULL;
        $this->_load($id);
    }

    /**
     * Get order details.
     * @param  int $id
     * @return array
     */
    public function _load($id)
    {
        if(!$id)
        {
            return FALSE;
        }

        $data = array( );
        $result = DB::select()->from('orders_ordershipments')
            ->where('id', '=', $id)
            ->execute()
            ->current();

        $this->data = $result;
    }

    /**
     * Get shipment value by key. If key is NULL, return order details array.
     * @param string $key
     * @return string|array
     */
    public function get($key = NULL)
    {
        if(empty($key))
        {
            return $this->data;
        }
        else
        {
            return isset($this->data[$key]) ? $this->data[$key] : '';
        }
    }

    /**
     * Get shipment items by shipment id.
     * @param int $shipment_id Shipment id.
     * @return array.
     */
    public function get_shipmentitems($shipment_id)
    {
        $items = DB::select()->from('orders_ordershipmentitems')->where('shipment_id', '=', $shipment_id)->execute();
        return $items;
    }

    /**
     * Update shipment tracking link, tracking code, ship date.
     * @param int $shipment_id Shipment id.
     * @param array $data Shippment array.
     * <code>
     * $data = array(
     *   'tracking_link' => 'http://track_link.com',
     *   'tracking_code' => 'TRACKING CODE',
     *   'ship_date' => 1287723600,//timestamp
     * )
     * </code>
     * @return bool
     */
    public function update_shipment($shipment_id, $data)
    {
        if(!$data)
        {
            return FALSE;
        }
        $updated = DB::update('orders_ordershipments')->set($data)->set(array('updated'=>time()))->where('id', '=', $shipment_id)->execute();
        if($updated)
        {
            $order = DB::select('order_id')->from('orders_ordershipments')->where('id', '=', $shipment_id)->execute()->current();
            if ($order['order_id'])
            {
                $order_data = array();
                $order_data['shipping_status'] = 'shipped';//TODO shipped, partial_shipped.
                $order_data['shipping_url'] = $data['tracking_link'];
                $order_data['shipping_code'] = $data['tracking_code'];
                $order_data['shipping_date'] = $data['ship_date'];
                $order_updated = Order::instance()->add_shipment($order['order_id'], $order_data);
            }
        }
        return $updated;
    }

}
