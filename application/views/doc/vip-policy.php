<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  VIP LEVEL & PRIVILEGES</div>
        </div>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user doc flr">
            <div class="tit"><h2>VIP LEVEL & PRIVILEGES</h2></div>
            <!-- vip -->
            <div class="vip">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th width="15%" class="first">
                    <div class="r">Privileges</div>
                    <div>VIP Level</div>
                    </th>
                    <th width="20%">Accumulated Transaction Amount</th>
                    <th width="16%">Extra Discounts For Fullprice Items</th>
                    <th width="16%">Points Use Permissions</th>
                    <th width="15%">Order Points Reward</th>
                    <th width="18%">Other Privileges</th>
                    </tr>
                    <tr>
                        <td><span class="icon_nonvip" title="Non-VIP"></span><strong>Non-VIP</strong></td>
                        <td>$0</td>
                        <td>/</td>
                        <td rowspan="6"><div>You may apply Points equaling up to only 10% of your  order value.</div></td>
                        <td rowspan="6">$1 = 1 points</td>
                        <td>15% off Coupon Code</td>
                    </tr>
                    <tr>
                        <td><span class="icon_vip" title="Diamond VIP"></span><strong>VIP</strong></td>
                        <td>$1 - $199</td>
                        <td>/</td>
                        <td rowspan="5"><div>Get double shopping points during major holidays.<br />
                                Special birthday gift.<br />
                                And More...</div></td>
                    </tr>
                    <tr>
                        <td><span class="icon_bronze" title="Bronze VIP"></span><strong>Bronze VIP</strong></td>
                        <td>$199 - $399</td>
                        <td>5% OFF</td>
                    </tr>
                    <tr>
                        <td><span class="icon_silver" title="Silver VIP"></span><strong>Silver VIP</strong></td>
                        <td>$399 - $599</td>
                        <td>8% OFF</td>
                    </tr>
                    <tr>
                        <td><span class="icon_gold" title="Gold VIP"></span><strong>Gold VIP</strong></td>
                        <td>$599 - $1999</td>
                        <td>10% OFF</td>
                    </tr>
                    <tr>
                        <td><span class="icon_diamond" title="Diamond VIP"></span><strong>Diamond VIP</strong></td>
                        <td>&ge; $1999</td>
                        <td>15% OFF</td>
                    </tr>
                </table>
            </div> 
            <div class="f00 mtb20">
                <b>Note: </b>
                <p>Order value redeemed by Points, codes and shipping fees are excluded from the transaction accumulation to get points. Please understand that.</p>
            </div>
            <p><img src="/images/vip_img.png" border="0" usemap="#Map" />
                <map name="Map" id="Map">
                    <area shape="rect" coords="598,272,760,294" href="<?php echo LANGPATH; ?>/customer/summary" />
                </map>
            </p>
        </article>
        <?php echo View::factory('doc/left'); ?>
    </section>
</section>