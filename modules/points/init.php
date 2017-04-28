<?php

if (!Kohana::config('points.enabled'))
{
        return;
}

function points_order_payment($data)
{
        $amount = Arr::get($data, 'amount', 0);
        $order = Arr::get($data, 'order', NULL);

        //vip
        $customer_id = $order->get('customer_id');
        $order_id = $order->get('id');
        $quantity = DB::select('id')->from('orders_order')
                ->where('customer_id', '=', $customer_id)
                ->and_where('id', '<', $order_id)
                ->and_where('payment_status', 'IN', array('success', 'verify_pass'))
                ->execute()->get('id');
        if ($quantity)
        {
                $vip_level = Customer::instance($customer_id)->get('vip_level');
                $vip_return = DB::select('return')->from('vip_types')->where('level', '=', $vip_level)->execute()->get('return');

                $rate = $order->get('rate');
                $amount_order = $order->get('amount');
                if($amount > $amount_order)
                        $amount = $amount_order;
                if (!$rate)
                        $rate = 1;
                $amount = ($amount / $rate) * $vip_return;
        }
        else
        {
                $amount = 1000; //First order 1000 points
        }

        if (!$order OR !$amount)
                return FALSE;

        $customer = Customer::instance($order->get('customer_id'));

        $order_detail = $order->get();
        if ($customer->get('id'))
        {
                $customer->add_point(array(
                    'type' => 'order',
                    'status' => 'pending',
                    'amount' => (int) $amount,
                    'order_id' => $order_id,
                    'order' => $order_detail,
                ));
        }

        return TRUE;
}

function points_customer_register($customer)
{
        if (!$customer->get('id'))
                return FALSE;

        $amount = Kohana::config('points.register');
        if ($customer->point_inc($amount))
        {
                $customer->add_point(array(
                    'type' => 'register',
                    'amount' => $amount,
                    'status' => 'activated',
                ));
        }

        return TRUE;
}

function points_customer_newsletter($customer)
{
        if (!$customer->get('id'))
                return FALSE;

        $amount = Kohana::config('points.register');
        if ($customer->point_inc($amount))
        {
                $customer->add_point(array(
                    'type' => 'newsletter',
                    'amount' => $amount,
                    'status' => 'activated',
                ));
        }

        return TRUE;
}

Event::add('Order.payment', 'points_order_payment');
Event::add('Customer.register', 'points_customer_register');
Event::add('Customer.newsletter', 'points_customer_newsletter');
