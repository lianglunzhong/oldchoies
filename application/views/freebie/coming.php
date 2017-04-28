<?php
$user = Customer::instance(Customer::logged_in())->get();
 if($user == '')
 {
       Request::instance()->redirect(URL::base().'customer/login?redirect=/freebie/start');
 }
?>
<div id="container">
        <div id="main">


                <!--add activity start-->
                <div class="activity">
                        <div class="activity_pro fix mt10">
                                <div class="pro_quantity" id="pro_quantity">
                                        <?php
                                        $amount_left = $amount[0];
                                        if ($amount[0] < 10)
                                                $amount_left = '00' . (string) ($amount_left);
                                        elseif ($amount[0] < 100)
                                                $amount_left = '0' . (string) ($amount_left);
                                        echo $amount_left;
                                        ?>
                                </div>
                        </div>
                        <div class="activity_hot mt10">
                                <?php
                                foreach ($products as $product):
                                        if ($product->get('id')):
                                                ?>
                                                <div class="activity_hot_big fll">
                                                        <?php
                                                        foreach ($product->images() as $key => $image):
                                                                if ($key > 2)
                                                                        continue;
                                                                ?>
                                                                <img src="<?php echo Image::link($image, 1); ?>" alt="" id="pc_<?php echo $key; ?>" style="<?php echo $key ? 'display: none' : 'display: block'; ?>"/> 
                                                                <?php
                                                        endforeach;
                                                        ?>
                                                </div>
                                                <div class="activity_hot_small fll">
                                                        <?php
                                                        foreach ($product->images() as $key => $image):
                                                                if ($key > 2)
                                                                        continue;
                                                                ?>
                                                                <img src="<?php echo Image::link($image, 3); ?>" alt="" onclick="plays(<?php echo $key; ?>)"/> 
                                                                <?php
                                                        endforeach;
                                                        ?>
                                                </div>
                                                <div class="activity_hot_detail flr">
                                                        <div style="height:52px;">
                                                                <a id="more" class="hide" href="<?php echo $product->permalink(); ?>"><img src="/images/freebie/activity_img4.jpg" alt="" /></a>
                                                        </div>
                                                        <div class="activity_hot_name"><?php echo $product->get('name'); ?></div>
                                                        <div class="activity_hot_price">Regular Price: $20.25</div>
                                                        <div class="activity_hot_cart"><a href="<?php echo $product->permalink(); ?>"><img src="/images/freebie/activity_cart.jpg" /></a></div>
                                                </div>
                                                <?php
                                        endif;
                                endforeach;
                                ?>
                        </div>
                        <div class="activity_other">
                                <div class="activity_other_bg"><img src="/images/freebie/activity_img5.jpg" width="725" height="907" usemap="#Map" />
                                        <map name="Map" id="Map">
                                                <area shape="rect" coords="533,718,722,786" href="<?php echo LANGPATH; ?>/outlet" alt="" />
                                        </map>
                                </div>
                                <div class="activity_other_wra">
                                        <ul>
                                                <?php
                                                foreach ($relate_products as $sku):
                                                        $related_product = Product::instance(Product::get_productId_by_sku($sku));
                                                        ?>
                                                        <li>
                                                                <div class="activity_other_img">
                                                                        <a href="<?php echo $related_product->permalink(); ?>"><img src="<?php echo Image::link($related_product->cover_image(), 1); ?>" width="220" /></a>
                                                                </div>
                                                                <div class="activity_other_detail">
                                                                        <div class="activity_other_name"><?php echo $related_product->get('name'); ?></div>
                                                                        <div class="activity_other_price"><?php echo Site::instance()->price($related_product->price(), 'code_view'); ?></div>
                                                                        <div class="activity_ohter_btn"><a href="<?php echo $related_product->permalink(); ?>"><img src="/images/freebie/activity_other_btn.jpg" /></a></div>
                                                                </div>
                                                        </li>
                                                        <?php
                                                endforeach;
                                                ?>
                                        </ul>
                                </div>
                        </div>
                        <div class="fix mt5"><a href="<?php echo LANGPATH; ?>/top-sellers"><img src="/images/freebie/activity_img7.jpg" width="725" height="218" alt="" /></a></div>
                </div>
                <!--add activity end-->


        </div>
        <div id="aside">
                <?php echo View::factory('/freebie/freebie_left'); ?>
        </div>
</div>
<script type="text/javascript">
        var temp_src;
        $(".list5 .pic img").hover(function(){
                temp_src = $(this).attr("src");
                $(this).attr("src",temp_src.replace(".jpg","_1.jpg"))
        },function(){
                $(this).attr("src",temp_src);
        })
</script>
<script type="text/javascript">
        function dothis()
        {
                if(navigator.appName.indexOf("Explorer") > -1)         
                        var text = document.getElementById("pro_quantity").innerText;
                else
                        var text = document.getElementById("pro_quantity").textContent;
                /*	
        do
        {
                text--;
                document.getElementById("pro_quantity").innerHTML = text;
        }
        while(text>0)
                 */
        }
</script>