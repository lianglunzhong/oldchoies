<?php defined('SYSPATH') or die('No direct script access.');

class Promotion_Action_Largess
{
    public function apply($cart,$promotion_id)
    {
        if(!empty($cart['temp']['largesses_for_choosing']))
            return $cart;
        $cpromo = ORM::factory('cpromotion',$promotion_id);
        $actions = unserialize($cpromo->actions);

        $largesses_already_chosen = $cart['temp']['largesses_already_chosen'];
        $largesses_for_choosing = $cart['temp']['largesses_for_choosing'];
        $largesses_should_be = $cart['temp']['largesses_should_be'];
        $promotion_logs_should_be = $cart['temp']['promotion_logs_should_be'];

        if(!empty($cart['promotion_logs']['cart']) AND isset($cart['promotion_logs']['cart'][$cpromo->id]))
        {
            $largesses_already_chosen_qty = $cart['promotion_logs']['cart'][$cpromo->id]['largesses'];
            $this_largesses_num = 0;
            $tmp_largesses_for_choosing = array();
            $tmp_save = 0;
            foreach($actions['details']['largesses'] as $largess)
            {
                $largess_obj = Product::instance($largess['id']);
                if(!$largess_obj->get('id') OR !$largess_obj->get('status') OR !$largess_obj->get('visibility') OR !in_array($largess_obj->get('type'),array(0,1,3)))
                {
                    continue;
                }
                
                $qty_idxes = Toolkit::array_2d_search($largesses_already_chosen_qty,array('id'=>$largess['id']),TRUE);
                $qty_log = 0;
                foreach($qty_idxes as $idx)
                {
                    if(isset($largesses_already_chosen[$idx]) AND $largesses_already_chosen[$idx]['quantity'] >= $largesses_already_chosen_qty[$idx]['quantity'])
                    {
                        $qty_log += $largesses_already_chosen_qty[$idx]['quantity'];
                    }
                    else
                    {
                        return FALSE;
                    }
                }

                if($qty_log > 0)
                {
                    if($qty_log > $largess['max_quantity'])
                    {
                        return FALSE;
                    }
                    elseif($qty_log < $largess['max_quantity'])
                    {
                        $tmp_largesses_for_choosing['largesses'][$largess['id']] = array(
                            'price' => $largess['price'],
                            'available_quantity' => $largess['max_quantity'] - $qty_log,
                            'type' => $largess_obj->get('type')
                        );
                    }

                    foreach($qty_idxes as $idx)
                    {
                        if(!isset($largesses_should_be[$idx]))
                        {
                            $largesses_should_be[$idx] = $largesses_already_chosen[$idx];
                            $largesses_should_be[$idx]['quantity'] = 0;
                        }
                        $largesses_should_be[$idx]['quantity'] += $largesses_already_chosen_qty[$idx]['quantity'];

                        if($largesses_already_chosen[$idx]['quantity'] == $largesses_already_chosen_qty[$idx]['quantity'])
                        {
                            unset($largesses_already_chosen[$idx]);
                        }

                        $tmp_largess_price = round($largess['price'] * $largesses_already_chosen_qty[$idx]['quantity'],2);
                        $cart['amount']['items'] += $tmp_largess_price;
                        $cart['amount']['total'] += $tmp_largess_price;
                        $tmp_tmp_save = round((Product::instance($largesses_already_chosen_qty[$idx]['items'][0])->price() - $largess['price']) * $largesses_already_chosen_qty[$idx]['quantity'],2);
                        $tmp_save += $tmp_tmp_save;

                        $promotion_logs_should_be[$cpromo->id]['largesses'][$idx] = array(
                            'id' => $largess['id'],
                            'method' => 'largess',
                            'save' => $tmp_tmp_save,
                            'items' => array($largesses_already_chosen_qty[$idx]['items'][0]),
                            'price' => $largess['price'],
                            'quantity' => $largesses_already_chosen_qty[$idx]['quantity'],
                            'type' => $largess_obj->get('type')
                        );
                    }

                    $this_largesses_num += $qty_log;
                }
                else
                {
                    $tmp_largesses_for_choosing['largesses'][$largess['id']] = array(
                        'price' => $largess['price'],
                        'available_quantity' => $largess['max_quantity'],
                        'type' => $largess_obj->get('type')
                    );
                }
            }

            if($this_largesses_num > $actions['details']['max_sum_quantity'])
            {
                return FALSE;
            }
            elseif($this_largesses_num < $actions['details']['max_sum_quantity'] AND !empty($tmp_largesses_for_choosing['largesses']))
            {
                $tmp_largesses_for_choosing['promotion_id'] = $cpromo->id;
                $tmp_largesses_for_choosing['name'] = $cpromo->name;
                $tmp_largesses_for_choosing['available_quantity'] = $actions['details']['max_sum_quantity'] - $this_largesses_num;
                $largesses_for_choosing[$cpromo->id] = $tmp_largesses_for_choosing; 

                $promotion_logs_should_be[$cpromo->id]['name'] = $cpromo->name;
                $promotion_logs_should_be[$cpromo->id]['method'] = 'largess';
                $promotion_logs_should_be[$cpromo->id]['save'] = $tmp_save;
            }
        }
        else
        {
            if(!empty($actions['details']['largesses']))
            {
                $this_largesses_for_choosing = array(
                    'name' => $cpromo->name,
                    'brief' => $cpromo->brief,
                    'promotion_id' => $cpromo->id,
                    'available_quantity' => $actions['details']['max_sum_quantity']
                );

                foreach($actions['details']['largesses'] as $largess)
                {
                    $largess_obj = Product::instance($largess['id']);
                    if(!$largess_obj->get('id') OR !$largess_obj->get('status') OR !$largess_obj->get('visibility') OR !in_array($largess_obj->get('type'),array(0,1,3)))
                    {
                        continue;
                    }
                    $this_largesses_for_choosing['largesses'][$largess['id']] = array(
                        'price' => $largess['price'],
                        'available_quantity' => $largess['max_quantity'],
                        'type' => $largess_obj->get('type')
                    );
                }

                if(!empty($this_largesses_for_choosing['largesses']))
                {
                    $largesses_for_choosing[$cpromo->id] = $this_largesses_for_choosing;
                }
            }
        }

        //add largess
        if(!empty($cart['largess_add']) AND $cart['largess_add']['promotion_id'] == $cpromo->id AND  isset($largesses_for_choosing[$cpromo->id]) AND isset($largesses_for_choosing[$cpromo->id]['largesses'][$cart['largess_add']['id']]) AND $cart['largess_add']['quantity'] <= min($largesses_for_choosing[$cpromo->id]['largesses'][$cart['largess_add']['id']]['available_quantity'],$largesses_for_choosing[$cpromo->id]['available_quantity']))
        {
            //check if it is a legal product 
            $product = Product::instance($cart['largess_add']['id']);
            $is_legal = TRUE;
            if(!$product->get('id') OR !$product->get('status') OR !$product->get('visibility'))
            {
                $is_legal = FALSE;
            }
            if($product->get('type') == 0 AND $cart['largess_add']['id'] != $cart['largess_add']['items'][0])
            {
                $is_legal = FALSE;
            }
            elseif($product->get('type') == 1)
            {
                $configred_products = $product->items();
                if(!in_array($cart['largess_add']['items'][0],$configred_products))
                {
                    $is_legal = FALSE;
                }
            }

            if($is_legal)
            {
                $idx = $cart['largess_add']['id']
                    .'_'.$largesses_for_choosing[$cpromo->id]['largesses'][$cart['largess_add']['id']]['price']
                    .'_'.$cart['largess_add']['items'][0];
                $idx = str_replace('.', '_', $idx);
                if(!isset($largesses_should_be[$idx]))
                {
                    $largesses_should_be[$idx] = array(
                        'id' => $cart['largess_add']['id'],
                        'method' => 'largess',
                        'quantity' => 0,
                        'items' => array($cart['largess_add']['items'][0]),
                        'price' => $largesses_for_choosing[$cpromo->id]['largesses'][$cart['largess_add']['id']]['price'],
                        'type' => $product->get('type'),
                        'attributes' => $cart['largess_add']['attributes']
                    );
                }
                $largesses_should_be[$idx]['quantity'] += $cart['largess_add']['quantity'];

                if(!isset($promotion_logs_should_be[$cpromo->id]))
                {
                    $promotion_logs_should_be[$cpromo->id] = array(
                        'promotion_id' => $cpromo->id,
                        'name' => $cpromo->name,
                        'method' => 'largess',
                        'save' => 0,
                        'largesses' => array()
                    );
                }
                if(!isset($promotion_logs_should_be[$cpromo->id]['largesses'][$idx]))
                {
                    $promotion_logs_should_be[$cpromo->id]['largesses'][$idx] = array(
                        'id' => $cart['largess_add']['id'],
                        'method' => 'largess',
                        'save' => 0,
                        'items' => array($cart['largess_add']['items'][0]),
                        'price' => $largesses_for_choosing[$cpromo->id]['largesses'][$cart['largess_add']['id']]['price'],
                        'quantity' => 0,
                        'type' => $product->get('type')
                    );
                }
                $tmp_largess_price = round($largesses_for_choosing[$cpromo->id]['largesses'][$cart['largess_add']['id']]['price'] * $cart['largess_add']['quantity'],2);
                $cart['amount']['items'] += $tmp_largess_price;
                $cart['amount']['total'] += $tmp_largess_price;
                $tmp_save = round((Product::instance($cart['largess_add']['items'][0])->price() - $largesses_for_choosing[$cpromo->id]['largesses'][$cart['largess_add']['id']]['price']) * $cart['largess_add']['quantity'],2);
                $promotion_logs_should_be[$cpromo->id]['largesses'][$idx]['save'] += $tmp_save;
                $promotion_logs_should_be[$cpromo->id]['save'] += $tmp_save;
                $promotion_logs_should_be[$cpromo->id]['largesses'][$idx]['quantity'] += $cart['largess_add']['quantity'];

                $largesses_for_choosing[$cpromo->id]['largesses'][$cart['largess_add']['id']]['available_quantity'] -= $cart['largess_add']['quantity'];
                $largesses_for_choosing[$cpromo->id]['available_quantity'] -= $cart['largess_add']['quantity'];
                if(!$largesses_for_choosing[$cpromo->id]['available_quantity'])
                {
                    unset($largesses_for_choosing[$cpromo->id]);
                }
                elseif(!$largesses_for_choosing[$cpromo->id]['largesses'][$cart['largess_add']['id']]['available_quantity'])
                {
                    unset($largesses_for_choosing[$cpromo->id]['largesses'][$cart['largess_add']['id']]);
                    if(empty($largesses_for_choosing[$cpromo->id]['largesses']))
                    {
                        unset($largesses_for_choosing[$cpromo->id]);
                    }
                }
            }
        }

        if(isset($promotion_logs_should_be[$cpromo->id]))
        {
            $tmp_count = 0;
            $tmp_price = 0;
            foreach($promotion_logs_should_be[$cpromo->id]['largesses'] as $largess)
            {
                $tmp_count += $largess['quantity'];
                $tmp_price += round($largess['quantity'] * $largess['price'],2);
            }
            $promotion_logs_should_be[$cpromo->id]['log'] = $cpromo->name.': '.$tmp_count.' item'.($tmp_count > 1 ? 's' : '').' for '.($tmp_price > 0 ? Site::instance()->price($tmp_price, 'code_view') : 'FREE');
        }

        if(!empty($largesses_for_choosing[$cpromo->id]))
        {
            foreach($largesses_for_choosing[$cpromo->id]['largesses'] as $key => $largess)
            {
                $largesses_for_choosing[$cpromo->id]['largesses'][$key]['available_quantity'] = min($largesses_for_choosing[$cpromo->id]['largesses'][$key]['available_quantity'],$largesses_for_choosing[$cpromo->id]['available_quantity']);
            }
        }

        $cart['temp']['largesses_already_chosen'] = $largesses_already_chosen;
        $cart['temp']['largesses_for_choosing'] = $largesses_for_choosing;
        $cart['temp']['largesses_should_be'] = $largesses_should_be;
        $cart['temp']['promotion_logs_should_be'] = $promotion_logs_should_be;

        return $cart;
    }
}
