<?php echo View::factory('admin/site/order/left')->render();?>
<?php $order_status = kohana::config('order_status');?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<div id="do_right">
    <div id="do_content">
        <div class="box">
            <h3>Order Shipment Details: <?php echo $data['ordernum'];?></h3>
            <div class="navigation">
                <ul>
                    <li>&nbsp;
                        <ul>
                            <li>Customer id: <a href="/admin/site/customer/edit/<?php echo $data['customer_id'];?>" target="_blank"><?php echo $data['customer_id'];?></a></li>
                            <li>Email: <a href="mailto:<?php echo $data['email'];?>"><?php echo $data['email'];?></a></li>
                            <li>Created On: <?php echo date('Y-m-d H:i:s', $data['created']);?></li>
                            <li>Updated On: <?php echo $data['updated']?date('Y-m-d H:i:s', $data['updated']):"";?></li>
                            <li>IP: <?php echo long2ip($data['ip']);?></li>
                            <li>Payment Status: <?php echo $order_status['payment'][$data['payment_status']]['name'];?></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <form class="need_validation" method="post">
                <script type="text/javascript">
                    $(function(){
                        $(".datepick").datepicker({dateFormat:'yy-mm-dd'});
                    });
                </script>
                <div class="navigation">
                    <ul>
                        <li><h4>Shipping Method: <?php //$carrier = Carrier::instance($data['shipping_method'])->get(); echo $carrier['carrier']['carrier'];?></h4>
                            <ul>
                                <?php if (isset($order_shipments) && count($order_shipments)){?>
                                <li>
                                    <table>
                                        <tr>
                                            <td>Orderitems</td>
                                            <td>Carrier</td>
                                            <td>Tracking link</td>
                                            <td>Tracking number</td>
                                            <td>Ship date</td>
                                            <td>Created</td>
                                            <td>Updated</td>
                                            <td>Admin</td>
                                        </tr>
                                        <?php foreach($order_shipments as $shipment){?>
                                        <tr>
                                            <td></td>
                                            <td><?php echo $shipment['carrier'];?></td>
                                            <td><?php echo $shipment['tracking_link'];?></td>
                                            <td><?php echo $shipment['tracking_code'];?></td>
                                            <td><?php echo $shipment['ship_date']?date('Y-m-d', $shipment['ship_date']):"";?></td>
                                            <td><?php echo date('Y-m-d H:i:s', $shipment['created']);?></td>
                                            <td><?php echo $shipment['updated']?date('Y-m-d H:i:s', $shipment['updated']):"";?></td>
                                            <td><?php echo $shipment['admin_id'];?></td>
                                        </tr>
                                        <?php }?>
                                    </table>
                                </li>
                                <?php }?>
                                <?php if (isset($shippeditems) && count($shippeditems)){?>
                                <li>Shipped items:
                                    <table>
                                        <tr>
                                            <td>SKU</td>
                                            <td>Image</td>
                                            <td>Name</td>
                                            <td>Quantity</td>
                                        </tr>
                                        <?php foreach($shippeditems as $k => $v){?>
                                        <tr>
                                            <td><?php echo Product::instance($k)->get('sku');?></td>
                                            <td><img src="<?php echo Image::link(Product::instance($k)->cover_image(), 0);?>"/></td>
                                            <td><?php echo Product::instance($k)->get('name');?></td>
                                            <td><?php echo $v;?></td>
                                        </tr>
                                        <?php }?>
                                    </table>
                                </li>
                                <?php }?>
                                <?php
                                $shipping = array();
                                if ($data['refund_status'])
                                    $shipping = $order_status['refund'][$data['refund_status']]['shipment'];
                                elseif ($data['payment_status'])
                                    $shipping = $order_status['payment'][$data['payment_status']]['shipment'];
                                if ($data['shipping_status'])
                                {
                                    if ($order_status['shipment'][$data['shipping_status']]['shipment']){
                                        if (!$shipping)
                                            $shipping = array();
                                        $shipping = array_intersect($order_status['shipment'][$data['shipping_status']]['shipment'], $shipping);
                                    }
                                    else
                                        $shipping = array();
                                }
                                ?>
                                <?php if ($shipping){?>
                                <li>
                                    <label for="shipping_status">Status: <?php echo $order_status['shipment'][$data['shipping_status']]['name'];?></label>
                                    <br/>
                                    <label for="shipping_status">Change Status: </label>
                                    <select name="shipping_status">
                                        <?php foreach($shipping as $v){?>
                                        <option value="<?php echo $v;?>"><?php echo $order_status['shipment'][$v]['name']; ?></option>
                                        <?php }?>
                                    </select>
                                </li>
                                <li>
                                    <label for="shipping_url">Tracking Url: </label>
                                    <input type="text" name="tracking_link" value="<?php echo $data['shipping_url'];?>"/>
                                </li>
                                <li>
                                    <label for="shipping_code">Tracking Code:</label>
                                    <input type="text" name="tracking_code" value="<?php echo $data['shipping_code'];?>"/>
                                </li>
                                <li>
                                    <label for="shipping_date">Shipping Date:</label>
                                    <input type="text" name="ship_date" value="<?php if ($data['shipping_date']) echo date('Y-m-d', $data['shipping_date']);?>" class="datepick"/>
                                </li>
                                <li>&nbsp;</li>
                                <li>
                                    <label for="orderitems">Select products for ship:</label>
                                    <table>
                                        <tr>
                                            <td>
<!--                                                <input type="checkbox" name="shiping_all"/>Check all-->
                                            </td>
                                            <td>SKU</td>
                                            <td>Image</td>
                                            <td>Name</td>
                                            <td>Quantity</td>
                                        </tr>
                                        <?php foreach($orderitems as $k => $v){?>
                                        <tr>
                                            <td><input type="checkbox" name="shipping_items[]" value="<?php echo $k;?>" checked/></td>
                                            <td><?php echo Product::instance($k)->get('sku');?></td>
                                            <td><img src="<?php echo Image::link(Product::instance($k)->cover_image(), 0);?>"/></td>
                                            <td><?php echo Product::instance($k)->get('name');?></td>
                                            <td><input type="text" name="shipping_quantity[<?php echo $k;?>][quantity]" value="<?php echo $v;?>" max="<?php echo $v;?>" min="0" class="digits"/></td>
                                        </tr>
                                        <?php }?>
                                    </table>
                                </li>
                                <li>
                                    <label for="shipping_comment">Comment:</label>
                                    <textarea name="shipping_comment"><?php echo $data['shipping_comment'];?></textarea>
                                </li>
                                <li>
                                    <input type="submit" name="_continue" value="Save and continue editing"/>
                                    <input type="submit" name="_save" value="Save"/>
                                </li>
                                <?php } else {?>
                                <li>
                                    <label for="orderitems">Select products for ship:</label>
                                    <table>
                                        <tr>
                                            <td>SKU</td>
                                            <td>Image</td>
                                            <td>Name</td>
                                            <td>Quantity</td>
                                        </tr>
                                        <?php foreach($orderitems as $k => $v){?>
                                        <tr>
                                            <td><?php echo Product::instance($k)->get('sku');?></td>
                                            <td><img src="<?php echo Image::link(Product::instance($k)->cover_image(), 0);?>"/></td>
                                            <td><?php echo Product::instance($k)->get('name');?></td>
                                            <td><?php echo $v;?></td>
                                        </tr>
                                        <?php }?>
                                    </table>
                                </li>
                                <?php }?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </form>
            <div class="navigation">
                <ul>
                    <li><h4>Shipping Address</h4>
                        <ul>
                            <li>
                                <label for="shipping_firstname">Firstname:</label>
                                <input type="text" name="shipping_firstname" value="<?php echo $data['shipping_firstname'];?>"/>
                            </li>
                            <li>
                                <label for="shipping_lastname">Lastname:</label>
                                <input type="text" name="shipping_lastname" value="<?php echo $data['shipping_lastname'];?>"/>
                            </li>
                            <li>
                                <label for="shipping_address">Address:</label>
                                <input type="text" name="shipping_address" value="<?php echo $data['shipping_address'];?>"/>
                            </li>
                            <li>
                                <label for="shipping_city">City:</label>
                                <input type="text" name="shipping_city" value="<?php echo $data['shipping_city'];?>"/>
                            </li>
                            <li>
                                <label for="shipping_state">State:</label>
                                <input type="text" name="shipping_state" value="<?php echo $data['shipping_state'];?>"/>
                            </li>
                            <li>
                                <label for="shipping_zip">Zip code:</label>
                                <input type="text" name="shipping_zip" value="<?php echo $data['shipping_zip'];?>"/>
                            </li>
                            <li>
                                <label for="shipping_country">Country:</label>
                                <select name="shipping_country">
                                    <?php foreach($countries as $c){?>
                                    <option value="<?php echo $c['isocode'];?>" <?php echo $c['isocode']==$data['shipping_country']?"selected":"";?>><?php echo $c['name'];?></option>
                                    <?php }?>
                                </select>
                            </li>
                            <li>
                                <label for="shipping_phone">Phone:</label>
                                <input type="text" name="shipping_phone" value="<?php echo $data['shipping_phone'];?>"/>
                            </li>
                            <li>
                                <label for="shipping_mobile">Mobile:</label>
                                <input type="text" name="shipping_mobile" value="<?php echo $data['shipping_mobile'];?>"/>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <form action="/admin/site/order/issue/<?php echo $data['id'];?>" method="post">
                <div class="navigation">
                    <ul>
                        <li><h4>Order Issue</h4>
                            <ul>
                                <li>
                                    <label for="issue">Issue:</label>
                                    <?php $order_issues=Order::instance()->get_orderstatus(NULL, Order::instance()->ISSUE_TYPE);?>
                                    <select name="issue">
                                        <option value="">NO ISSUES</option>
                                        <?php foreach($order_issues as $oi){?>
                                        <option value="<?php echo $oi['id'];?>" <?php echo ($data['issue']==$oi['id'])?"selected":""?>><?php echo $oi['name']?></option>
                                        <?php }?>
                                    </select>
                                </li>
                                <li>
                                    <label for="order_issue_comment">Notes:</label>
                                    <input type="text" name="order_issue_comment" value=""/>
                                </li>
                            </ul>
                        </li>
                        <li>
    <!--                        <input type="submit" name="_addanother" value="Save and add another"/>-->
                            <input type="submit" name="_continue" value="Save and continue editing"/>
                            <input type="submit" name="_save" value="Save"/>
                        </li>
                    </ul>
                </div>
            </form>
            <?php echo View::factory('admin/site/order/edit_remark')->set('data', $data)->set('order_remarks', $order_remarks)->render();?>
            <?php echo View::factory('admin/site/order/history')->set('order_history', $order_history)->render();?>
        </div>
    </div>
</div>
