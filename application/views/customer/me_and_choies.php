<section id="main">
    <div class="layout fix">
        <table width="1024" border="0" align="center" cellpadding="0" cellspacing="0" style="display:inline-block;">
            <tr>
                <td>    
                    <img src="/images/docs/order_01.jpg" width="1024" height="366" style="display:block" border="0"/>
                </td>
            </tr><!--banner-->

            <tr>
                <td background="/images/docs/order_02.jpg" width="1024" height="999">
                    <table width="1024" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="900" width="125"></td>
                            <td>
                                <table width="775" height="900" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="775" height="295" valign="top">
                                            <table width="775" height="295" border="0" align="right" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="95" height="105"></td>
                                                    <td width="206" height="105" align="left" valign="bottom" style="color: #dd1d51; font-size: 26px; font-style: italic; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">
                                                    <?php echo date('Y – m – d', $customer->get('created')); ?>
                                                    </td>
                                                    <td width="474" height="105"></td>
                                                </tr>
                                                <tr>
                                                    <td width="95" height="30" ></td>
                                                    <td width="206" height="30" style="color: #000000; font-size: 18px; font-style: italic; font-family: Arial, Helvetica, sans-serif;">
                                                        I Joined Choies
                                                    </td>
                                                    <td width="474" height="30"></td>
                                                </tr>
                                                <tr>
                                                    <td width="95" height="160"></td>
                                                    <td height="160" width="206"></td>
                                                    <td height="160" width="474"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr><!--first-->

                                    <tr>
                                        <td height="404">
                                            <table width="775" height="404" border="0" align="right" cellpadding="0" cellspacing="0">    
                                                <tr>
                                                    <td width="95" height="95"></td>
                                                    <td width="400" height="95" align="left" valign="bottom" style="color: #dd1d51; font-size: 26px; font-style: italic; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">
                                                        <?php echo date('Y – m – d', $first_order['created']); ?> 
                                                    </td>
                                                    <td width="280" height="95"></td>
                                                </tr>
                                                <tr>
                                                    <td width="95" height="37" ></td>
                                                    <td height="37">
                                                        <table border="0" cellspacing="0" cellpadding="0" width="400" >
                                                            <tr>
                                                                <td height="37"  width="66" style="color: #000000; font-size: 18px; font-style: italic; font-family: Arial, Helvetica, sans-serif;">I Spent </td>
                                                                <td width="71" height="37" style="color: #dd1d51; font-size: 18px; font-style: italic; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">$ <?php echo round($first_order['amount'] / $first_order['rate'], 2); ?></td>
                                                                <td width="204"  height="32" style="color: #000000; font-size: 18px; font-style: italic; font-family: Arial, Helvetica, sans-serif;">and Made My First Order</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="272" width="95"></td>
                                                    <td height="272" colspan="2">
                                                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td height="20" width="680"></td>
                                                            </tr>
                                                            <tr>
                                                                <td height="252" width="680" >
                                                                    <table width="680"  height="109" border="0" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                        <?php
                                                                        foreach($fisrt_order_items as $item)
                                                                        {
                                                                        ?>
                                                                            <td width="205" height="109" >
                                                                                <table border="0" cellspacing="0" cellpadding="0" bgcolor="#fafafa" width="220" height="109" Style=" border-top:#b0b0b0 1px solid; border-bottom:#b0b0b0 1px solid; border-left:#b0b0b0 1px solid; border-right:#b0b0b0 1px solid;">
                                                                                    <tr>
                                                                                        <td width="75" height="105" style="margin-top:2; margin-bottom:2;">
                                                                                            <img src="<?php echo Image::link(Product::instance($item['product_id'])->cover_image(), 3); ?>" width="75" height="100">
                                                                                        </td>
                                                                                        <td width="130" style="padding-left: 5px;">
                                                                                            <table border="0" cellspacing="0" cellpadding="0">
                                                                                                <tr>
                                                                                                    <td width="130" height="50" valign="bottom" style="color: #000000; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; line-height:18px;">
                                                                                                        <?php echo $item['name']; ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="130" height="25" valign="middle" style="color: #000000; font-size: 12px;  font-family: Arial, Helvetica, sans-serif;">
                                                                                                        $<?php echo round($item['price'], 2); ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td width="130" height="34" valign="top" style="color: #000000; font-size: 12px;  font-family: Arial, Helvetica, sans-serif;">
                                                                                                        <?php
                                                                                                        $eur = strpos($item['attributes'], 'EUR');
                                                                                                        if($eur !== False)
                                                                                                        {
                                                                                                            $size = substr($item['attributes'], $eur + 3, 2);
                                                                                                            $item['attributes'] = 'Size: ' . $size . ';';
                                                                                                        }
                                                                                                        echo $item['attributes'];
                                                                                                        ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr><!--second-->

                                    <tr>
                                        <td height="300">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="95" height="300"></td>
                                                    <td width="355" height="300">
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="355" height="90" align="left" valign="bottom" style="color: #dd1d51; font-size: 20px; font-style: italic; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">Till Now, I have 
                                                            </tr>
                                                            <tr>
                                                                <td width="355" height="60">
                                                                    <table border="0" cellspacing="0" cellpadding="0" width="355">
                                                                        <tr>
                                                                            <td width="105"  height="60" valign="bottom" style="color: #000000; font-size: 16px; font-style: italic; font-family: Arial, Helvetica, sans-serif;">
                                                                            Totally Spent:
                                                                            </td>
                                                                            <td height="60" valign="bottom" style="line-height: 22px; color: #36944f; font-size: 25px; font-style: italic; font-family: Arial, Helvetica, sans-serif;">
                                                                                $<?php echo round($customer->get('order_total'), 2); ?>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="355" height="45">
                                                                    <table border="0" cellspacing="0" cellpadding="0" width="355">
                                                                        <tr>
                                                                            <td width="188"  height="45" valign="bottom" style="color: #000000; font-size: 16px; font-style: italic; font-family: Arial, Helvetica, sans-serif;">
                                                                                Points Altogether Earned: 
                                                                            </td>
                                                                            <td height="45" valign="bottom" style="line-height: 22px; color: #d29224; font-size: 25px; font-style: italic; font-family: Arial, Helvetica, sans-serif;">
                                                                                <?php echo $points_rewarded; ?>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="355" height="45">
                                                                    <table border="0" cellspacing="0" cellpadding="0" width="355">
                                                                        <tr>
                                                                            <td width="175"  height="45" valign="bottom" style="color: #000000; font-size: 16px; font-style: italic; font-family: Arial, Helvetica, sans-serif;">
                                                                                Activated Points to Use: 
                                                                            </td>
                                                                            <td height="45" valign="bottom" style="line-height: 20px; color: #2ba4d0; font-size: 25px; font-style: italic; font-family: Arial, Helvetica, sans-serif">
                                                                                <?php echo $points_activated; ?>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="355" height="60"></td>
                                                            </tr>
                                                        </table>
                                                    </td>

                                                    <td width="325" height="300">
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="325" height="100">
                                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td width="110"></td>
                                                                            <td><a href="<?php echo BASEURL ;?>/customer/orders?EDM0120" target="_blank"><img src="/images/docs/order.png" width="100" height="65" onMouseOver="this.src='/images/docs/order_on.png'" onMouseOut="this.src='/images/docs/order.png'" style="margin-bottom:25px;margin-top:10px; display:block;"  border="0" /></a></td>
                                                                            <td width="115" ></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td width="325" height="100"><table border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td><a href="<?php echo BASEURL ;?>/customer/wishlist?EDM0120" target="_blank"><img src="/images/docs/wishlist.png" width="100" height="65" onMouseOver="this.src='/images/docs/wishlist_on.png'" onMouseOut="this.src='/images/docs/wishlist.png'"style="margin-bottom:30px;margin-top:5px;display:block;" border="0"/></a></td>
                                                                            <td width="110"></td>
                                                                            <td><a href="<?php echo BASEURL ;?>/customer/points_history?EDM0120" target="_blank"><img src="/images/docs/point.png" width="100" height="65" onMouseOver="this.src='/images/docs/point_on.png'" onMouseOut="this.src='/images/docs/point.png'" style="margin-bottom:30px;margin-top:5px; margin-right:15px;display:block;"border="0"/></a></td>
                                                                        </tr>
                                                                    </table></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="325" height="100">
                                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td width="110"></td>

                                                                            <td><a href="<?php echo BASEURL ;?>/customer/summary?EDM0120" target="_blank"><img src="/images/docs/vip.png" width="100" height="65" onMouseOver="this.src='/images/docs/vip_on.png'" onMouseOut="this.src='/images/docs/vip.png'" style="margin-bottom:30px;margin-top:5px;display:block;" border="0"/></a></td>
                                                                            <td width="115"></td>
                                                                        </tr>
                                                                    </table>

                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </td><!--third_right-->
                                                </tr>
                                            </table>

                                        </td>
                                    </tr><!--third-->

                                </table>
                            </td>

                            <td height="900" width="124"></td>
                        </tr>
                    </table>
                </td>
            </tr><!--order-->


            <tr>
                <td width="1024" height="221" background="/images/docs/order_03.jpg"> 
                </td>
            </tr><!--bottom_banner-->

        </table>
    </div>
</section>