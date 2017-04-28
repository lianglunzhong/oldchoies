<style>
    .wid805{ width:805px;}
    .lp_jewelry{ position:relative;}
    .lp_jewelry img{ display:block; border:0 none;}
    .lp_jewelry .tit{ border-bottom:1px solid #fad0a1; padding-bottom:1px; margin-bottom:15px;}
    .lp_jewelry .tit h3{ font-size:25px; color:#fff; font-weight:normal; height:32px; line-height:32px; padding-left:15px; font-family:"Century Gothic"; background-color:#fad0a1;}
    .lp_jewelry .t1{ border-bottom-color:#b1e9b7;}
    .lp_jewelry .t1 h3{ background-color:#b1e9b7;}
    .lp_jewelry .t2{ border-bottom-color:#f4d57a;}
    .lp_jewelry .t2 h3{ background-color:#f4d57a;}
    .lp_jewelry .t3{ border-bottom-color:#feb1a8;}
    .lp_jewelry .t3 h3{ background-color:#feb1a8;}

    .lp_jewelry .pro_listcon ul{ width:110%;}
    .lp_jewelry .pro_listcon li{ width:250px; height:auto; font-size:14px;margin-right:27px;}
    .lp_jewelry .pro_listcon li img{ width:250px; height:auto;}
    .lp_jewelry .pro_listcon li .name{ height:36px; line-height:18px;}
    .lp_jewelry .outstock{ top:280px; width: 105px;}

    .lp_jewelry .flv_product_details_nav{ top:275px;}
    .lp_jewelry .flv_product_details_nav li{ margin-bottom:5px; cursor:pointer;}
.lp_jewelry .flv_product_details_nav li:hover,.lp_jewelry .flv_product_details_nav li.current{ filter: alpha(opacity=40); opacity: 0.4;}

    .lp_jewelry .flv_product_details_nav{ position:absolute; top:0; right:90px; overflow:hidden; z-index:100;}
.lp_jewelry .flv_product_details_nav a{ display:block; width:140px; height:35px; line-height:35px; text-align:center; font-size:14px; text-transform:uppercase; color:#7d7d7d; background-color:#f4f4f0; border:1px solid #f4f4f0; margin-bottom:5px;}
.lp_jewelry .flv_product_details_nav a.current{ background-color:#fcfcfc; border-color:#ccc;}
</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Jewelry Clearance</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
            <div class="lp_jewelry wid805">
                <p class="mb25"><img src="<?php echo STATICURL; ?>/ximg/activity/lp_jewelry_img.jpg" /></p>
                <?php
                foreach ($prices as $key => $price):
                    ?>
                    <div class="tit t<?php echo $key; ?>" id="d<?php echo $key + 1; ?>"><h3><?php echo Site::instance()->price($price['price'], 'code_view'); ?></h3></div>
                    <div class="pro_listcon">
                        <ul class="fix">
                            <?php
                            $datas = DB::select()->from('spromotions')->where('price', '=', $price['price'])->where('type', '=', 5)->order_by('position', 'desc')->execute();
                            foreach ($datas as $data):
                                $product = Product::instance($data['product_id'], LANGUAGE);
                                if (!$product->get('id'))
                                    continue;
                                $orig_price = $product->get('price');
                                $off = round(($orig_price - $data['price']) / $orig_price, 2) * 100;
                                if ($off <= 0)
                                    continue;
                                $link = $product->permalink();
                                ?>
                                <li>
                                    <a href="<?php echo $link ?>"><img src="<?php echo Image::link($product->cover_image(), 7); ?>" /></a>
                                    <a href="<?php echo $link; ?>" class="name"><?php echo $product->get('name'); ?></a>
                                    <p class="price fix"><b><?php echo Site::instance()->price($data['price'], 'code_view'); ?></b><del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del></p>
                                    <span class="icon_sale"></span>
<!--                                    <span class="outstock">out of stock</span>-->
                                </li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <?php
                endforeach;
                ?>
                <!-- flv_product_details_nav -->
                <div class="flv_product_details_nav JS_cart_side" style="position: fixed; top: 210px; right: 98px;">
                    <li onclick="goto(1);"><img src="<?php echo STATICURL; ?>/ximg/activity/lp_jewelry_nav1.jpg" /></li>
                    <li onclick="goto(2);"><img src="<?php echo STATICURL; ?>/ximg/activity/lp_jewelry_nav2.jpg" /></li>
                    <li onclick="goto(3);"><img src="<?php echo STATICURL; ?>/ximg/activity/lp_jewelry_nav3.jpg" /></li>
                    <li onclick="goto(4);"><img src="<?php echo STATICURL; ?>/ximg/activity/lp_jewelry_nav4.jpg" /></li>
                    </map>
                </div>
            </div>
        </section>
        <?php echo View::factory('/catalog_left'); ?>
    </section>
</section>
<script type="text/javascript">
    // JS_cart_side
    function goto(k){
        var id = "#d"+k;
        var obj = $(id).offset();
        var pos = obj.top - 70;
        var position = $(".JS_cart_side").css("position");
        if(position=="fixed"){
            pos = obj.top - 70; 
        }
        $("html,body").animate({scrollTop: pos}, 1000);
    };
</script>