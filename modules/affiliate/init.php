<?php 

if (!Kohana::config('affiliate.enabled'))
{
    return;
}

function affiliate_order_payment($data)
{
    $amount = Arr::get($data, 'amount', 0);
    $order = Arr::get($data, 'order', NULL);
    if (!$order)
        return FALSE;

    $customer = Customer::instance($order->get('affiliate_id'));
    if($customer->get('id'))
    {
        $customer->add_commission(array(
            'order_id' => $order->get('id'),
            'order_date' => time(),
            'order_total' => $amount,
            'order_currency' => $order->get('currency'),
            'commission' => $amount * $customer->get('affiliate_rate'),
            'note' => '',
        ));
    }
}

Event::add('Order.payment', 'affiliate_order_payment');
