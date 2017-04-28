<?php if($index_close_show){ ?>
<div class="w_bottom JS_hide">
    <div class="bottom layout fix">
      <a href="<?php echo LANGPATH; ?>/black-friday?hp1110" target="_blank"><img src="/images<?php echo LANGPATH; ?>/black-friday.jpg" /></a>
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
            <a href="<?php echo LANGPATH; ?>/shipping-delivery" class="a1">LIVRAISON INTERNATIONALE GRATUITE</a>
            <?php 
            $user_id = Customer::logged_in();
            if($user_id){?>
                <a href="<?php echo LANGPATH; ?>/vip-policy" class="a2">PREMIÈRE COMMANDE -15%</a>
            <?php }else{ ?>
                <a href="<?php echo LANGPATH; ?>/customer/login" class="a2">PREMIÈRE COMMANDE -15%</a>
            <?php } ?>
            <a href="<?php echo LANGPATH; ?>/daily-new" class="a3">NOUVEAUTÉS -10%</a>
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
                            <img src="/simages/<?php echo $banner['image']; ?>" alt="" title="" usemap="#<?php echo $map; ?>" />
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
                <button class="previous "></button>
                <button class="next "></button>
            </div>
        </div>
    </div>

    <!-- main begin -->
    <article class="index_fashion layout">
        <div class="index_tit t1"><p><a href="<?php echo $index_banners[9]['link']; ?>"><span><b>Fashion</b> show des acheteurs</span> <span><?php echo $index_banners[9]['title'];  ?></span></a></p></div>
        <div class="JS_carousel4 product_carousel">
            <ul class="fix">
                <?php
                $skus = DB::select('map')->from('banners')->where('type', '=', 'buyers_show')->execute()->get('map');
                $array = explode("\n", $skus);
                foreach ($array as $sku):
                    $sku = trim($sku);
                    $product_id = Product::get_productId_by_sku($sku);
                    ?>
                    <li class="buys_show">
                        <a href="<?php echo Product::instance($product_id, LANGUAGE)->permalink(); ?>">
                            <img style="width:195px;height:260px;" src="http://img.choies.com/cimages/<?php echo $sku; ?>.jpg" />
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
        <div class="index_tit t2 text_upper"><p><span><b class="font18">Caractéristiques</b></span> <span><b> Choies</b></span></p></div>
        <ul class="fix brandbox">
            <li>
                <a href="<?php echo $index_banners[3]['link']; ?>">
                    <img src="http://img.choies.com/cimages/<?php echo $index_banners[3]['image']; ?>" alt="<?php echo $index_banners[3]['alt']; ?>" title="<?php echo $index_banners[3]['title']; ?>" />
                </a>
                <a href="<?php echo $index_banners[4]['link']; ?>" class="brand">
                    <img src="http://img.choies.com/cimages/<?php echo $index_banners[4]['image']; ?>" alt="<?php echo $index_banners[3]['alt']; ?>" title="<?php echo $index_banners[3]['title']; ?>">
                </a>
                <a href="<?php echo $index_banners[3]['link']; ?>" class="name"><?php echo $index_banners[3]['title']; ?></a>
            </li>
            <li>
                <a href="<?php echo $index_banners[5]['link']; ?>">
                    <img src="http://img.choies.com/cimages/<?php echo $index_banners[5]['image']; ?>" alt="<?php echo $index_banners[5]['alt']; ?>" title="<?php echo $index_banners[5]['title']; ?>" />
                </a>
                <a href="<?php echo $index_banners[6]['link']; ?>" class="brand">
                    <img src="http://img.choies.com/cimages/<?php echo $index_banners[6]['image']; ?>" alt="<?php echo $index_banners[5]['alt']; ?>" title="<?php echo $index_banners[5]['title']; ?>">
                </a>
                <a href="<?php echo $index_banners[5]['link']; ?>" class="name"><?php echo $index_banners[5]['title']; ?></a>
            </li>
            <li>
                <a href="<?php echo $index_banners[7]['link']; ?>">
                    <img src="http://img.choies.com/cimages/<?php echo $index_banners[7]['image']; ?>" alt="<?php echo $index_banners[7]['alt']; ?>" title="<?php echo $index_banners[7]['title']; ?>" />
                </a>
                <a href="<?php echo $index_banners[8]['link']; ?>" class="brand">
                    <img src="http://img.choies.com/cimages/<?php echo $index_banners[8]['image']; ?>" alt="<?php echo $index_banners[7]['alt']; ?>" title="<?php echo $index_banners[7]['title']; ?>">
                </a>
                <a href="<?php echo $index_banners[7]['link']; ?>" class="name"><?php echo $index_banners[7]['title']; ?></a>
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