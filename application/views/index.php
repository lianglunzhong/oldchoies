<?php if($index_close_show){ ?>
<div class="w_bottom JS_hide">
    <div class="bottom layout fix">
      <a href="/black-friday?hp1110" target="_blank"><img src="/images/black-friday.jpg" /></a>
      <span class="JS_close close_btn1" id="closed"></span>
    </div>
</div>
<script language="JavaScript">
    $(function(){
        $("#closed").click(function(){
            $.ajax({
                type: "POST",
                url: "/site/ajax_index",
            });
        });
    })
</script>
<?php } ?>
<section id="main">
    <!-- index_free begin -->
    <div class="w_index_free">
        <div class="layout index_free">
            <img src="/images/index_free.png" border="0" usemap="#Map" />
            <map name="Map" id="Map">
                <area shape="rect" coords="2,1,400,39" href="<?php echo LANGPATH; ?>/shipping-delivery" />
                <?php 
                $user_id = Customer::logged_in();
                if($user_id){?>
                <area shape="rect" coords="402,1,666,39" href="<?php echo LANGPATH; ?>/vip-policy" />
                <?php }else{ ?>
                <area shape="rect" coords="402,1,666,39" href="<?php echo LANGPATH; ?>/customer/login" />
                <?php } ?>
                <area shape="rect" coords="667,1,1023,39" href="<?php echo LANGPATH; ?>/daily-new" />
            </map>
        </div>
    </div>
    
    <div class="banner" id="banner">
        <div class="ibanner layout">
            <ul class="bannerPic">
                <?php
                $count = count($banners);
                foreach ($banners as $banner):
                    if (strpos($banner['link'], 'http://') >= 0 OR strpos($banner['link'], 'https://') >= 0)
                        $link = $banner['link'];
                    else
                        $link = '/' . $banner['link'];
                    if ($banner['map'])
                        $map = 'Map' . $banner['id'];
                    else
                        $map = '';
                    ?>
                    <li>
                        <a href="<?php echo $link; ?>" class="pic" target="_blank"> 
                            <img src="/simages/<?php echo $banner['image']; ?>" alt="<?php echo $banner['alt']; ?>" title="<?php echo $banner['title']; ?>" usemap="#<?php echo $map; ?>" />
                            <p class="st_ty"></p>
                        </a>
                        <div class="slide_Bg"></div>
                    </li>
                    <?php
                    if ($map)
                    {
                        echo '<map name="' . $map . '" id="' . $map . '">' . $banner['map'] . '</map>';
                    }
                endforeach;
                ?>
            </ul>
            <div class="bannerBtn">
            <?php
            if ($count > 1)
            {
                ?>
                <ul class="fix">
                <?php
                for ($i = 1; $i <= $count; $i++)
                {
                    ?>
                    <li<?php if ($i == 1) echo ' class="on"'; ?>></li>
                    <?php
                }
                ?>
                </ul>
                <?php
            }
            ?>
            </div>
            <div class="bannerBtn_bg"></div>
            <div class="banner_lr">
                <button class="previous"></button>
                <button class="next"></button>
            </div>
        </div>
    </div>

    <!-- main begin -->
    <article class="index_fashion layout">
        <p class="mtb5"><a href="<?php echo $index_banners[9]['link']; ?>"><img src="/uploads/1/files/<?php echo $index_banners[9]['image']; ?>" /></a></p>
        <div class="JS_carousel4 product_carousel">
            <ul class="fix">
                <?php
                $skus = DB::select('map')->from('banners_banner')->where('type', '=', 'buyers_show')->execute()->get('map');
                $array = explode("\n", $skus);
                foreach ($array as $sku):
                    $sku = trim($sku);
                    $product_id = Product::get_productId_by_sku($sku);
                    ?>
                    <li class="buys_show">
                        <a href="<?php echo Product::instance($product_id)->permalink(); ?>">
                            <img style="width:195px;height:260px;" src="/uploads/1/files/<?php echo $sku; ?>.jpg" />
                            <img style="display:none;width:195px;height:260px;" src="<?php echo image::link(Product::instance($product_id)->cover_image(), 1); ?>" />
                        </a>
                    </li>
                    <?php
                endforeach;
                ?>
            </ul>
            <span class="prev1 JS_prev4"></span>
            <span class="next1 JS_next4"></span>
        </div>
        <script>
            $(function(){
                $(".buys_show img").live('hover', function(){
                    if($(this).siblings().length > 0)
                    {
                        $(this).toggle();
                        $(this).siblings().toggle();
                    } 
                },function(){
                    if($(this).siblings().length > 0)
                    {
                        $(this).toggle();
                        $(this).siblings().toggle();
                    } 
                })
            })
        </script>
    </article>
    <article class="rows-4 layout">
        <ul class="fix mtb10">
            <li>
                <a href="<?php echo $index_banners[0]['link']; ?>" <?php if(strpos($index_banners[0]['link'], 'http') !== False) echo 'target="_blank"'; ?>>
                    <img src="/uploads/1/files/<?php echo $index_banners[0]['image']; ?>" alt="<?php echo $index_banners[0]['alt']; ?>" title="<?php echo $index_banners[0]['title']; ?>" />
                </a>
            </li>
            <li>
                <a href="<?php echo $index_banners[1]['link']; ?>" <?php if(strpos($index_banners[1]['link'], 'http') !== False) echo 'target="_blank"'; ?>>
                    <img src="/uploads/1/files/<?php echo $index_banners[1]['image']; ?>" alt="<?php echo $index_banners[1]['alt']; ?>" title="<?php echo $index_banners[1]['title']; ?>" />
                </a>
            </li>
            <li>
                <a href="<?php echo $index_banners[2]['link']; ?>" <?php if(strpos($index_banners[2]['link'], 'http') !== False) echo 'target="_blank"'; ?>>
                    <img src="/uploads/1/files/<?php echo $index_banners[2]['image']; ?>" alt="<?php echo $index_banners[2]['alt']; ?>" title="<?php echo $index_banners[2]['title']; ?>" />
                </a>
            </li>
        </ul>
    </article>
    <article class="rows_3 layout">
        <p class="mtb5"><img src="/images/tit_brand-showcase.png" /></p>
        <ul class="fix brandbox">
            <li>
                <a href="<?php echo $index_banners[3]['link']; ?>">
                    <img src="/uploads/1/files/<?php echo $index_banners[3]['image']; ?>" alt="<?php echo $index_banners[3]['alt']; ?>" title="<?php echo $index_banners[3]['title']; ?>" />
                </a>
                <a href="<?php echo $index_banners[4]['link']; ?>" class="brand">
                    <img src="/uploads/1/files/<?php echo $index_banners[4]['image']; ?>" alt="<?php echo $index_banners[4]['alt']; ?>" title="<?php echo $index_banners[4]['title']; ?>" />
                </a>
                <a href="<?php echo $index_banners[4]['link']; ?>" class="name"><?php echo $index_banners[4]['title']; ?></a>
            </li>
            <li>
                <a href="<?php echo $index_banners[5]['link']; ?>">
                    <img src="/uploads/1/files/<?php echo $index_banners[5]['image']; ?>" alt="<?php echo $index_banners[5]['alt']; ?>" title="<?php echo $index_banners[5]['title']; ?>" />
                </a>
                <a href="<?php echo $index_banners[6]['link']; ?>" class="brand">
                    <img src="/uploads/1/files/<?php echo $index_banners[6]['image']; ?>" alt="<?php echo $index_banners[6]['alt']; ?>" title="<?php echo $index_banners[6]['title']; ?>" />
                </a>
                <a href="<?php echo $index_banners[6]['link']; ?>" class="name"><?php echo $index_banners[6]['title']; ?></a>
            </li>
            <li>
                <a href="<?php echo $index_banners[7]['link']; ?>">
                    <img src="/uploads/1/files/<?php echo $index_banners[7]['image']; ?>" alt="<?php echo $index_banners[7]['alt']; ?>" title="<?php echo $index_banners[7]['title']; ?>" />
                </a>
                <a href="<?php echo $index_banners[8]['link']; ?>" class="brand">
                    <img src="/uploads/1/files/<?php echo $index_banners[8]['image']; ?>" alt="<?php echo $index_banners[8]['alt']; ?>" title="<?php echo $index_banners[8]['title']; ?>" />
                </a>
                <a href="<?php echo $index_banners[8]['link']; ?>" class="name"><?php echo $index_banners[8]['title']; ?></a>
            </li>
        </ul>
    </article>
</section>
<script>
    $(".banner .bannerPic li").soChange({
		thumbObj:".banner .bannerBtn li",
		botPrev:".banner .previous",
		botNext:".banner .next",
		botPrevslideTime:500,
		changeTime:5000,
		slideTime:500
		});

    // newsletter_form
    $("#newsletter_form").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email:{
                required:"",
                email:""
            }
        }
		
    });
</script>