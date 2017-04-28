        <div class="site-content">
            <div class="main-container clearfix">
                <div class="container container-xs">
            <!-- Banner Start 2015.10.22 -->
            <div id="homeBigBanner" class="flexslider topbanner hidden-xs">
                <ul class="slides">
                    <?php
                        foreach ($banners as $key=>$banner){
                            $i = $key + 1;
                        if (strpos($banner['link'], 'http://') >= 0 OR strpos($banner['link'], 'https://') >= 0) $link = $banner['link'];
                        else $link = '/' . $banner['link'];
                        if ($banner['map']) $map = 'Map' . $banner['id'];
                        else $map = '';

                        if($is_mobile)
                            $banner_src = STATICURL . '/simages/8_' . $banner['image'];
                        else
                            $banner_src = STATICURL . '/simages/' . $banner['image'];
                    ?>
                    <li><a href="<?php echo $link; ?>"><img src="<?php echo $banner_src; ?>"  alt="<?php echo $banner['title']; ?>" class="<?php echo LANGUAGE;?>_main_banner<?php echo $i;?>" /></a></li>
                    <?php }?>
                </ul>
                <script type="text/javascript">
                    $(function(){
                        $('#homeBigBanner').flexslider({
                            animation: "slides",
                            direction:"horizontal",
                            easing:"swing"
                        });
                    })  
                </script>
            </div>
            <!-- Banner End  2015.10.22 -->
            <div id="phoneBigBanner" class="flexslider topbanner hidden-sm hidden-md hidden-lg">
                <ul class="slides">
                    <?php 
                    if(!empty($phone_banners)){
                        foreach ($phone_banners as $key=>$banner){
                            $i = $key + 1;
                        if (strpos($banner['link'], 'http://') >= 0 OR strpos($banner['link'], 'https://') >= 0) $link = $banner['link'];
                        else $link = '/' . $banner['link'];
                        if ($banner['map']) $map = 'Map' . $banner['id'];
                        else $map = '';

                        $banner_src = STATICURL . '/simages/' . $banner['image'];
                    ?>
                    <li>
                        <a href="<?php echo $link; ?>"><img class="<?php echo LANGUAGE;?>_main_banner<?php echo $i;?>" src="<?php echo $banner_src; ?>" alt="" /></a>
                    </li>
                    <?php }}?>
                </ul>
                <script type="text/javascript">
                    $(function(){
                        $('#phoneBigBanner').flexslider({
                            animation: "slides",
                            direction:"horizontal",
                            easing:"swing"
                        });
                    }) 
                </script>
            </div>  

                        <div class="celection">
                            <ul class="row">
                    <?php 
                    if(!empty($phonecatalog_banners))
                    {
                        foreach ($phonecatalog_banners as $key=>$banner)
                        {
                            $i = $key + 1;
                            if($i <=2)
                            {
                            $banner_src = STATICURL . '/simages/' . $banner['image'];
                    ?>
                                <li class="col-xs-6 col-sm-4">
                                    <a class="img" href="<?php echo $banner['link'];?>">
                                        <p class="show-icon">SHOP</p>
                                        <img src="<?php echo $banner_src; ?>" class="<?php echo LANGUAGE;?>_pin_banner<?php echo $i;?>">
                                    </a>
                                    <p><?php echo $banner['title'];?></p>
                                    <span><a href="<?php echo $banner['link'];?> "><?php echo $banner['alt'];?></a></span>          
                                </li>
                    <?php 
                            }
                        }
                    } 
                    ?>
                                <li class="hot col-xs-12 hidden-sm hidden-md hidden-lg">
                                    <table class="phone-hot" >
                                        <tbody>
                                            <tr>
                                                <td class="col-xs-6">
                                                    <a href="<?php echo LANGPATH;?>/daily-new/week2">Novedades ›</a>
                                                </td>
                                                <td class="col-xs-6">
                                                    <a href="<?php echo LANGPATH;?>/clothing-c-615">Ropa ›</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-xs-6">
                                                    <a href="<?php echo LANGPATH;?>/shoes-c-53">Zapatos ›</a>
                                                </td>
                                                <td class="col-xs-6">
                                                    <a href="<?php echo LANGPATH;?>/accessory-c-52">Accesorios ›</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-xs-6">
                                                    <a href="">Galaxia de Choies ›</a>
                                                </td>
                                                <td class="col-xs-6">
                                                    <a href="<?php echo LANGPATH;?>/outlet-c-101">Rebajas ›</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </li>
                                <li class="hidden-sm hidden-md hidden-lg"></li>
                    <?php 
                    if(!empty($phonecatalog_banners))
                    {
                        foreach ($phonecatalog_banners as $key=>$banner)
                        {
                            $i = $key + 1;
                            if($i > 2 && $i < 7)
                            {
                            $banner_src = STATICURL . '/simages/' . $banner['image'];
                    ?>
                                <li class="col-xs-6 col-sm-4">
                                    <a class="img" href="<?php echo $banner['link'];?>">
                                        <p class="show-icon">SHOP</p>
                                        <img src="<?php echo $banner_src; ?>" class="<?php echo LANGUAGE;?>_pin_banner<?php echo $i;?>">
                                    </a>
                                    <p><?php echo $banner['title'];?></p>
                                    <span><a href="<?php echo $banner['link'];?> "><?php echo $banner['alt'];?></a></span>          
                                </li>
                    <?php 
                            }
                        }
                    } 
                    ?>
                            </ul>
                        </div>            
            <?php
            if(!$is_mobile)
            {       
                $totalindex1 = array();
                $totalindex2 = array();
                $totalindex3 = array();
                if(!empty($index1_banners))
                {
                    $totalindex1['imgsrc'] = unserialize($index1_banners[0]['map']);
                    $totalindex1['link'] = explode(',',$index1_banners[0]['linkarray']);
                    $totalindex2['imgsrc'] = unserialize($index1_banners[2]['map']);
                    $totalindex2['link'] = explode(',',$index1_banners[2]['linkarray']);
                    $totalindex3['imgsrc'] = unserialize($index1_banners[1]['map']);
                    $totalindex3['link'] = explode(',',$index1_banners[1]['linkarray']);                    
                }
            ?>
                    <div class="n-ad hidden-xs">
                        <?php
                        if(isset($newindex_banners))
                        {
                            if(array_key_exists(6, $newindex_banners))
                            {
                            ?>
                               <a href="<?php echo LANGPATH;?><?php echo $newindex_banners[6]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[6]['image']; ?>"  class="<?php echo LANGUAGE;?>_central_banner"></a>
                            <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="arrivals hidden-xs">
                        <?php
                        if(isset($newindex_banners))
                        {
                            if(array_key_exists(7, $newindex_banners))
                            {
                            ?>
                               <a class="arr-pic" href="<?php echo LANGPATH;?><?php echo $newindex_banners[7]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[7]['image']; ?>"  class="<?php echo LANGUAGE;?>_newarrival_banner"></a>
                            <?php
                            }
                        }
                        ?>
                        <ul class="row">
                        <?php 
                        if(isset($totalindex3['link']))
                        {
                            foreach($totalindex3['link'] as $keys=>$value)
                            { 
                                $j = $keys + 1;
                                $proid = Product::get_productId_by_sku($value);
                                $pro_instance = Product::instance($proid,LANGUAGE);
                                $plink = $pro_instance->permalink();
                                $pname = $pro_instance->get('name');
                                $cover_image = $pro_instance->cover_image();
                                $image_link = Image::link($cover_image, 1);
                                ?>
                                <li class="col-xs-2">
                                    <a href="<?php echo $plink; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo isset($totalindex3['imgsrc'][$keys]) ? $totalindex3['imgsrc'][$keys] : ''; ?>" class="<?php echo LANGUAGE;?>_new_banner<?php echo $j;?>"></a>
                                    <a class="arr-name" href="<?php echo $plink; ?>"><?php echo $pname; ?></a>
                                </li>
                            <?php 
                            }
                        }
                         ?>
                        </ul>
                    </div>
                    <div class="follow-us hidden-xs">
                        <?php
                        if(isset($newindex_banners))
                        {
                            if(array_key_exists(8, $newindex_banners))
                            {
                            ?>
                               <a class="flo-pic" href="<?php echo LANGPATH;?><?php echo $newindex_banners[8]['link']; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $newindex_banners[8]['image']; ?>" class="<?php echo LANGUAGE;?>_instagram_banner"></a>
                            <?php
                            }
                        }
                        ?>
                        <ul>
                            <li class="col-xs-4">
                                <a class="col-xs-12" href="<?php echo LANGPATH;?><?php echo isset($totalindex2['link'][0]) ? $totalindex2['link'][0] : ''; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo isset($totalindex2['imgsrc'][0]) ? $totalindex2['imgsrc'][0] : ''; ?>"  class="<?php echo LANGUAGE;?>_ins_banner1"></a>
                                <a class="col-xs-6" href="<?php echo LANGPATH;?><?php echo isset($totalindex2['link'][1]) ? $totalindex2['link'][1] : ''; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo isset($totalindex2['imgsrc'][1]) ? $totalindex2['imgsrc'][1] : ''; ?>"  class="<?php echo LANGUAGE;?>_ins_banner2"></a>
                                <a class="col-xs-6" href="<?php echo LANGPATH;?><?php echo isset($totalindex2['link'][2]) ? $totalindex2['link'][2] : ''; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo isset($totalindex2['imgsrc'][2]) ? $totalindex2['imgsrc'][2] : ''; ?>"  class="<?php echo LANGUAGE;?>_ins_banner3"></a>
                            </li>
                            <li class="col-xs-4">
                            <?php 
                            if(isset($totalindex3['link']))
                            {
                                foreach($totalindex2['link'] as $key => $values)
                                {
                                        if($key >= 3 && $key <= 8)
                                        {
                                 ?>
                                    <a class="col-xs-6" href="<?php echo LANGPATH;?><?php echo isset($totalindex2['link'][$key]) ? $totalindex2['link'][$key] : ''; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo isset($totalindex2['imgsrc'][$key]) ? $totalindex2['imgsrc'][$key] : ''; ?>" class="<?php echo LANGUAGE;?>_ins_banner<?php echo $key+1;?>"></a>
                                <?php 
                                       }
                                }
                            }
                             ?>
                            </li>
                            <li class="col-xs-4">
                                <a class="col-xs-6" href="<?php echo LANGPATH;?><?php echo isset($totalindex2['link'][9]) ? $totalindex2['link'][9] : ''; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo isset($totalindex2['imgsrc'][9]) ? $totalindex2['imgsrc'][9] : ''; ?>"  class="<?php echo LANGUAGE;?>_ins_banner10"></a>
                                <a class="col-xs-6" href="<?php echo LANGPATH;?><?php echo isset($totalindex2['link'][10]) ? $totalindex2['link'][10] : ''; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo isset($totalindex2['imgsrc'][10]) ? $totalindex2['imgsrc'][10] : ''; ?>"  class="<?php echo LANGUAGE;?>_ins_banner11"></a>
                                <a class="col-xs-12" href="<?php echo LANGPATH;?><?php echo isset($totalindex2['link'][11]) ? $totalindex2['link'][11] : ''; ?>"><img src="<?php echo STATICURL;?>/simages/<?php echo isset($totalindex2['imgsrc'][11]) ? $totalindex2['imgsrc'][11] : ''; ?>"  class="<?php echo LANGUAGE;?>_ins_banner12"></a>
                            </li>
                        </ul>
                    </div>
            <?php
            }

            if($is_mobile)
            {
                if(!empty($phonecatalog_banners))
                {
                    if(array_key_exists(6, $phonecatalog_banners))
                    {
                ?>
                <div class="n-ad hidden-sm hidden-md hidden-lg">
                    <a href="<?php echo $phonecatalog_banners[6]['link'];?>"><img src="<?php echo STATICURL;?>/simages/<?php echo $phonecatalog_banners[6]['image']; ?>"></a>
                </div>
                <?php
                    } 
                }
            }

            if($is_mobile || $user_device == 'ipad')
            {
            ?>
                        <div class="phone-also-like mt10 hidden-sm hidden-md hidden-lg">
                            <div class="w-tit">
                                <h2>Los clientes también han visitado</h2>
                            </div>
                            <div class="example-demo">
                                <div class="gallery js-flickity" data-flickity-options='{ "wrapAround": true }'>
                            <?php 
                                $cache = Cache::instance('memcache');
                                $indexsku = $cache->get('indexsku');
                                if(empty($indexsku))
                                {
                                    $indexsku = Kohana::config('sites.indexsku');                                     
                                }

                                if(!empty($indexsku))
                                {
                                    foreach ($indexsku as $key => $value) 
                                    {
                                        $proid1 = Product::get_productId_by_sku($value);
                                        $pro1 = Product::instance($proid1,LANGUAGE);
                                        $cover_image1 = Product::instance($proid1)->cover_image();
                                        $image_link1 = Image::link($cover_image1, 4);
                                        $plink1 = Product::instance($proid1,LANGUAGE)->permalink();
                                        $k = $key + 1;
                                        $price1 = round($pro1->price(), 2);
                                ?>
                                        <?php if($k % 2 ==1)
                                        {       
                                        ?>
                                        <div class="gallery-cell">
                                            <ul>
                                        <?php 
                                        }
                                        ?>
                                                <li class="col-xs-6">
                                                    <a href="<?php echo $plink1;?>"><img src="<?php echo $image_link1;?>" class="<?php echo LANGUAGE;?>_phone_new_banner<?php echo $k;?>"></a>
                                                    <p><a href="<?php echo $plink1;?>"><?php echo $pro1->get('name'); ?></a></p>
                                                    <p><?php echo Site::instance()->price($price1, 'code_view'); ?></p>
                                                </li>
                                        <?php if($k % 2 ==0)
                                        { 
                                        ?>
                                            </ul>
                                           </div>
                                        <?php 
                                        }
                                        ?>

                                    <?php                               
                                    }
                                }
                                    ?>

                                </div>
                            </div>
                        </div>
            <?php
            }
            ?>          
        </div>
    </div>

            </div>
        </div>



