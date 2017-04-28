<?php defined('SYSPATH') or die('No direct script access.');

class Promotion_Action_Bundle
{
    public function apply($cart,$promotion_id)
    {

        $cpromo = ORM::factory('cpromotion',$promotion_id);
        $actions = unserialize($cpromo->actions);

        $restrictions  = unserialize($cpromo->restrictions);

        if($details = $actions['action'])
        {
            if($details == 'bundle')
            {
                //分类/产品限制
                $saving = $cart['amount']['coupon_save'] + $cart['amount']['point'];
                $total = count($cart['products']);
                $probundlearr = array();

                if(isset($restrictions['restrict_catalog']))
                {
                        $rate_amount = 0;
                        $catalogs = explode(',', $restrictions['restrict_catalog']);
                        $catalogs_in = '0';
                        foreach ($catalogs as $c)
                        {
                            $posterity_ids = array();
                            $posterity_ids = Catalog::instance($c)->posterity();
                            $posterity_ids[] = $c;
                            $catalogs_in = $catalogs_in . ',' . implode(',', $posterity_ids);
                        }

                        $other_amount = 0;

                        foreach($cart['products'] as $key=>$product)
                        {
                            $has = DB::query(Database::SELECT, 'SELECT id FROM products_categoryproduct WHERE product_id = ' . $product['id'] . ' AND category_id IN (' . $catalogs_in . ')')->execute()->get('id');
                            if($has)
                            {
                                $probundlearr[] = array(
                                    'id' => $product['id'],
                                    'quantity' => $product['quantity'],
                                    'price' => $product['price'],
                                    'key' => $key,
                                    'numtotal' => 0,
                                    );
                                $other_amount += $product['price'] * $product['quantity'];
                            }

                            $rate_amount += $product['price'] * $product['quantity'];             
                        }

                        if($bundlenum = explode(':',$actions['bundlenum']))
                        {
                            $tot = '';//初始化除商
                            $mproduct = '';
                            if($bundlenum[0] == 'sum')
                            {
                                $bundlenum = $bundlenum[1];
                            }
                        }

                        $bundlesaving = '';

                        if($bundleprice = explode(':',$actions['bundleprice']))
                        {
                        }

                        if(!empty($probundlearr) && is_array($probundlearr))
                        {
                            $sumqty = '';//符合条件SKU个数 获取整数个数 直接算出折扣价格
                            foreach ($probundlearr as $key => $value) 
                            {
                                $count = '';
                                $floornum = '';
                                if($value['quantity']  >= $bundlenum)
                                {
                                    if(!($value['quantity'] % $bundlenum))
                                    {
                                        $count = $value['quantity'] / $bundlenum;
                                        //$bundlesaving += $value['price'] * $value['quantity']; 
                                        if($bundleprice[0] == 'amt')
                                        {
                                            $bundlesaving += $count * $bundleprice[1];
                                        }
                                        //设置价格
                                        $cart['products'][$value['key']]['price'] = $bundleprice[1] / $bundlenum;
                                        unset($probundlearr[$key]);
                                    }
                                    else
                                    {
                                       $count = floor($value['quantity'] / $bundlenum);
                                       $floornum = $value['quantity'] % $bundlenum;
                                        if($bundleprice[0] == 'amt')
                                        {
                                            $bundlesaving += $count * $bundleprice[1];
                                        }
                                        $cart['products'][$value['key']]['price'] = ($bundlesaving +$cart['products'][$value['key']]['price'])  / $value['quantity'];
                                        $probundlearr[$key]['quantity'] = $floornum;
                                        $probundlearr[$key]['numtotal'] = 1;
                                        $sumqty += $floornum; 
                                    }                                        
                                }
                                else
                                {
                                        $sumqty += $value['quantity'];                        
                                }

                            }
                            usort($probundlearr, function($a, $b) 
                            {
                                $al = $a['price'];
                                $bl = $b['price'];
                                if ($al == $bl)
                                return 0;
                                return ($al > $bl) ? -1 : 1;
                            });              
                        }

                        if($bundlenum = explode(':',$actions['bundlenum']))
                        {
                            $tot = '';//初始化除商
                            $mproduct = '';
                            if($bundlenum[0] == 'sum')
                            {
                                $tot = $sumqty % $bundlenum[1];
                                if($tot == 0)
                                {
                                   $mproduct = $sumqty / $bundlenum[1]; 
                                }
                                else
                                {
                                   $mproduct = floor($sumqty / $bundlenum[1]);
                                }
                            }
                        }

                        $k = 0;
                        for($i = 0; $i < $tot; $i++)
                        {
                            if($k < $tot)
                            {
                                if(isset($probundlearr[$i]))
                                {
                                    $bundlesaving += $probundlearr[$i]['price'] * $probundlearr[$i]['quantity'];     
                                    $probundlearr[$i]['numtotal'] = 1;               
                                }                                
                                $k += $probundlearr[$i]['quantity'];                               
                            }
                        }



                        foreach ($probundlearr as $key => $value) 
                        {
                            if(!$value['numtotal'])
                            {
                               $cart['products'][$value['key']]['price'] = $bundleprice[1]  / $bundlenum[1]; 
                            }

                            if($tot == 0)
                            {
                               $cart['products'][$value['key']]['price'] = $bundleprice[1]  / $bundlenum[1];           
                            }
                        }

                        if($bundleprice = explode(':',$actions['bundleprice']))
                        {
                            if($bundleprice[0] == 'amt')
                            {

                                $bundlesaving += $mproduct * $bundleprice[1];
                            }
                        }
                        $cart_total = $rate_amount + $bundlesaving - $other_amount - $saving;
                }
                else
                {
                    return $cart;
                }


                if($cart_total >= 0)
                {
                    $cart['amount']['save'] += $cart['amount']['total'] - $cart_total;
                    $cart['temp']['promotion_logs_should_be'][$cpromo->id] = array(
                        'id' => $cpromo->id,
                        'method' => 'bundle',
                        'save' => $cart['amount']['items'] - $cart_total,
                        'value' => '%',
                        'log' => $cpromo->name.' sale',
                        'restrictions' => $cpromo->restrictions
                    );
                    $cart['amount']['total'] = $cart_total + $cart['amount']['shipping'];
                }
            }
        }
        return $cart;
    }
}
