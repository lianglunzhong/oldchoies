<style>
        .lp_thanksgiving{ width:810px; position:relative;}
        .lp_thanksgiving img{ border:0 none;}
        .lp_thanksgiving .pic img {width:195px;}
        .lp_thanksgiving .mb20{ margin-bottom:20px;}
        .lp_thanksgiving > .tit{ position:absolute; top: 231px;; left: 830px;z-index:100;}
        .lp_thanksgiving > .tit .titcon{ padding:2px; margin-top: 26px; border:1px solid #fdcfd9; background-color:#fff; width:80px;}
        .lp_thanksgiving_box{ padding-top: 20px;}
        .lp_thanksgiving_box .tit{ height:35px; line-height:35px; background-color:#fdcfd9; padding:0 15px 0 10px; margin:0 0 15px; font-size:18px; color:#fff;}

        .lp_thanksgiving_box .tit h3{ float:left; display:inline-block;color:rgb(101,17,32)}
        .lp_thanksgiving_box .tit a{ float:right; color:rgb(101,17,32);}

        .lp_thanksgiving_box ul{ width:105%;}
        .lp_thanksgiving_box li{ float:left; margin:0 9px 10px 0; width:196px; position:relative;}
        .lp_thanksgiving_box li .pic{ margin:0 0 10px;}
        .lp_thanksgiving_box li .name{ height:25px; overflow:hidden; padding:5px 0;}
        .lp_thanksgiving_box li .price{ padding:2px 0;}
        .lp_thanksgiving_box li .price span{ margin:0 0 0 10px;}
        .lp_thanksgiving_box li .price span.colorc00{ color:#c00; font-weight:bold;}
        .lp_thanksgiving_box li .price span.icon_lips{ background:url(images/lips.png) no-repeat; display:inline-block; width:16px; height:16px;}

        .lp_thanksgiving_box li .off{ position:absolute; top:0; right:1px; z-index:1; width: 40px; font-size:18px; font-weight:bold; background-color:#900303; padding:0 3px; text-align:center; color:#fff;}
        .lp_thanksgiving_box li .off span{ display:block;}
</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Thanksgiving Sale</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">

                        <script src="/js/jquery.colorbox.js"></script>
                        <script>
                                $(document).ready(function(){
                                        //Examples of how to assign the Colorbox event to elements
                                        $(".group1").colorbox({rel:'group1'});
                                                
                                });
                        </script>

                        <!-- time left -->
                        <div class="lp_thanksgiving">
                                <p><img src="/images/activity/thanksgiving_ad.jpg" /></p>
                                <div class="tit">
                                        <div class="titcon" id="Z_TMAIL_SIDER_V2">
                                                <img src="/images/activity/thanksgiving_tit.png" border="0" usemap="#Map" />
                                                <map name="Map" id="Map">
                                                        <area shape="rect" coords="7,6,66,68" href="#dresses" />
                                                        <area shape="rect" coords="11,71,64,130" href="#tops" />
                                                        <area shape="rect" coords="13,133,64,196" href="#coats" />
                                                        <area shape="rect" coords="12,197,67,255" href="#bottoms" />
                                                        <area shape="rect" coords="13,259,64,307" href="#shoes" />
                                                        <area shape="rect" coords="3,309,73,357" href="#accessories" />
                                                </map>
                                        </div>
                                </div>
                                <?php
                                $links = array(
                                    'Dresses' => 'dresses',
                                    'Tops' => 'jumpers-cardigans',
                                    'Coats' => 'coats-jackets',
                                    'Bottoms' => 'bottoms',
                                    'Shoes' => 'shoes',
                                    'Accessories' => 'accessory'
                                );
                                foreach ($catalogs as $catalog):
                                        ?>
                                        <div class="lp_thanksgiving_box" id="<?php echo strtolower($catalog['catalog']); ?>">
                                                <div class="tit fix">
                                                        <h3><?php echo ucfirst($catalog['catalog']); ?></h3>
                                                        <a href="<?php echo LANGPATH; ?>/<?php echo $links[ucfirst($catalog['catalog'])]; ?>" target="_blank">More></a>
                                                </div>
                                                <ul class="fix">
                                                        <?php
                                                        $datas = DB::select()->from('spromotions')->where('catalog', '=', $catalog['catalog'])->order_by('position', 'desc')->execute();
                                                        foreach ($datas as $data):
                                                                $product = Product::instance($data['product_id'], LANGUAGE);
                                                                if(!$product->get('id'))
                                                                        continue;
                                                                $orig_price = $product->get('price');
                                                                $off =  round(($orig_price - $data['price']) / $orig_price, 2) * 100;
                                                                if($off <= 0)
                                                                        continue;
                                                                ?>
                                                                <li>
                                                                        <p class="pic">
                                                                                <a href="<?php echo $product->permalink(); ?>">
                                                                                        <img src="<?php echo Image::link($product->cover_image(), 7); ?>" />
                                                                                </a>
                                                                        </p>
                                                                        <p class="name"><a href="<?php echo $product->permalink(); ?>"><?php echo $product->get('name'); ?></a></p>
                                                                        <p class="price"><del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del><span class="colorc00"><?php echo Site::instance()->price($data['price'], 'code_view'); ?></span><span class="icon_lips"></span></p>
                                                                        <div class="off"><span><?php echo (int)$off; ?>%</span>off</div>
                                                                </li>
                                                        <?php endforeach; ?>
                                                </ul>
                                        </div>
                                <?php endforeach; ?>
                        </div>
                </section>
        <?php echo View::factory('/catalog_left'); ?>
    </section>
</section>
<script src="/js/jquery.tmailsilder.v2.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#Z_TMAIL_SIDER_V2').Z_TMAIL_SIDER_V2();
});
</script>