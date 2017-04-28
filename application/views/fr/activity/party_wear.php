<link type="text/css" rel="stylesheet" href="/css/quickview.css" media="all" />
<style>
    .lp_partywear{ width:820px; margin:0 0 20px; position:relative;}
    .lp_partywear .center{ text-align:center; height:auto;}
    .lp_partywear img{ border:0 none;}
    .lp_partywear_nav{ padding:0 20px; position:relative; z-index:20;}
    .lp_partywear_nav ul{ width:105%;}
    .lp_partywear_nav li{ float:left; margin:0 11px 10px 0; position:relative; cursor:pointer;}
    .lp_partywear_nav li img{ border:1px solid #040000;}
    .lp_partywear_nav li .img_con{ position:absolute; top:40px; left:0; z-index:10;}

    .lp_partywear .tit{ height:42px; background-color:#000; margin:35px 0 20px;}
    .lp_partywear_carousel{ margin:15px 20px 0; width:776px; height:277px; border:1px solid #040000; position:relative;}
    .lp_partywear_carousel ul{ width:105%;}
    .lp_partywear_carousel li{ float:left; margin:0 4px 0 0; width:152px; height:255px;}

    .lp_prev1,.lp_next1{ display:inline-block; background:url(/images/activity/lp_btn1.png) no-repeat; width:10px; height:29px; position:absolute; top:120px; cursor:pointer; z-index:1;}
    .lp_prev1{ background-position:0 -29px; left:0;}
    .lp_next1{ background-position:-11px -29px; right:0;}
    .lp_partywear_carousel .prev_disabled{cursor:default; background-position:0 0;}
    .lp_partywear_carousel .next_disabled{cursor:default; background-position:-11px 0;}

    #Z_TMAIL_SIDER_V2{width:780px; background-color:#fff;}
</style>
<<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Party Wear</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">

            <div class="lp_partywear">
                <p class="mb10"><a href="<?php echo LANGPATH; ?>/party-wear"><img src="/images/activity/partywear_banner.jpg" /></a></p>
                <div class="lp_partywear_nav" id="Z_TMAIL_SIDER_V2">
                    <ul class="fix">
                        <li class="JS_show">
                            <a onclick="goto(1);">
                                <img src="/images/activity/partywear_nav1.png" />
                                <div class="img_con JS_showcon hide"><img src="/images/activity/partywear_navcon1.jpg" /></div>
                            </a>
                        </li>
                        <li class="JS_show">
                            <a onclick="goto(2);">
                                <img src="/images/activity/partywear_nav2.png" />
                                <div class="img_con JS_showcon hide"><img src="/images/activity/partywear_navcon2.jpg" /></div>
                            </a>
                        </li>
                        <li class="JS_show">
                            <a onclick="goto(3);">
                                <img src="/images/activity/partywear_nav3.png" />
                                <div class="img_con JS_showcon hide"><img src="/images/activity/partywear_navcon3.jpg" /></div>
                            </a>
                        </li>
                        <li class="JS_show">
                            <a onclick="goto(4);">
                                <img src="/images/activity/partywear_nav4.png" />
                                <div class="img_con JS_showcon hide"><img src="/images/activity/partywear_navcon4.jpg" /></div>
                            </a>
                        </li>
                        <li class="JS_show">
                            <a onclick="goto(5);">
                                <img src="/images/activity/partywear_nav5.png" />
                                <div class="img_con JS_showcon hide"><img src="/images/activity/partywear_navcon5.jpg" /></div>
                            </a>
                        </li>
                        <li class="JS_show">
                            <a onclick="goto(6);">
                                <img src="/images/activity/partywear_nav6.png" />
                                <div class="img_con JS_showcon hide"><img src="/images/activity/partywear_navcon6.jpg" /></div>
                            </a>
                        </li>      
                    </ul>
                </div>
                <p class="center mt20"><img src="/images/activity/partywear_tit.png" /></p>
                <p class="tit center" id="nav1"><img src="/images/activity/partywear_tit1.png" /></p>
                <p><img src="/images/activity/partywear_pr01.jpg" /></p>
                <div class="JS_carousel1 lp_partywear_carousel">
                    <ul class="fix">
                        <li>
                            <a class="" id="<?php echo $products[0][0]; ?>" href="<?php echo Product::instance($products[0][0], LANGUAGE)->permalink(); ?>" target="_blank"><img src="/images/activity/partywear_pr07.jpg" /></a>
                        </li>
                        <li>
                            <a class="" id="<?php echo $products[0][1]; ?>" href="<?php echo Product::instance($products[0][1], LANGUAGE)->permalink(); ?>" target="_blank"><img src="/images/activity/partywear_pr08.jpg" /></a>
                        </li>
                        <li>
                            <a class="" id="<?php echo $products[0][2]; ?>" href="<?php echo Product::instance($products[0][2], LANGUAGE)->permalink(); ?>" target="_blank"><img src="/images/activity/partywear_pr09.jpg" /></a>
                        </li>
                        <li>
                            <a class="" id="<?php echo $products[0][3]; ?>" href="<?php echo Product::instance($products[0][3], LANGUAGE)->permalink(); ?>" target="_blank"><img src="/images/activity/partywear_pr10.jpg" /></a>
                        </li>
                        <li>
                            <a class="" id="<?php echo $products[0][4]; ?>" href="<?php echo Product::instance($products[0][4], LANGUAGE)->permalink(); ?>" target="_blank"><img src="/images/activity/partywear_pr11.jpg" /></a>
                        </li>

                        <li>
                            <a class="" id="<?php echo $products[0][5]; ?>" href="<?php echo Product::instance($products[0][5], LANGUAGE)->permalink(); ?>" target="_blank"><img src="/images/activity/partywear_pr93.jpg" /></a>
                        </li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                    </ul>
                    <span class="lp_prev1 JS_prev1"></span>
                    <span class="lp_next1 JS_next1"></span>
                </div>
                <p class="tit center" id="nav2"><img src="/images/activity/partywear_tit2.png" /></p>
                <p class="center"><img src="/images/activity/partywear_pr12.jpg" /></p>
                <div class="JS_carousel2 lp_partywear_carousel">
                    <ul class="fix">
                        <li>
                            <a class="quick_view" id="<?php echo $products[1][0]; ?>" href="#"><img src="/images/activity/partywear_pr13.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[1][1]; ?>" href="#"><img src="/images/activity/partywear_pr14.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[1][2]; ?>" href="#"><img src="/images/activity/partywear_pr15.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[1][3]; ?>" href="#"><img src="/images/activity/partywear_pr16.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[1][4]; ?>" href="#"><img src="/images/activity/partywear_pr17.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[1][5]; ?>" href="#"><img src="/images/activity/partywear_pr94.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[1][6]; ?>" href="#"><img src="/images/activity/partywear_pr95.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[1][7]; ?>" href="#"><img src="/images/activity/partywear_pr96.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[1][8]; ?>" href="#"><img src="/images/activity/partywear_pr97.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[1][9]; ?>" href="#"><img src="/images/activity/partywear_pr98.jpg" /></a>
                        </li>
                    </ul>
                    <span class="lp_prev1 JS_prev2"></span>
                    <span class="lp_next1 JS_next2"></span>
                </div>
                <p class="tit center" id="nav3"><img src="/images/activity/partywear_tit3.png" /></p>
                <p class="center"><img src="/images/activity/partywear_pr18.jpg" /></p>
                <div class="JS_carousel3 lp_partywear_carousel">
                    <ul class="fix">
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][0]; ?>" href="#"><img src="/images/activity/partywear_pr19.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][1]; ?>" href="#"><img src="/images/activity/partywear_pr20.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][2]; ?>" href="#"><img src="/images/activity/partywear_pr21.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][3]; ?>" href="#"><img src="/images/activity/partywear_pr22.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][4]; ?>" href="#"><img src="/images/activity/partywear_pr23.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[2][5]; ?>" href="#"><img src="/images/activity/partywear_pr24.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][6]; ?>" href="#"><img src="/images/activity/partywear_pr25.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][7]; ?>" href="#"><img src="/images/activity/partywear_pr26.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][8]; ?>" href="#"><img src="/images/activity/partywear_pr27.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][9]; ?>" href="#"><img src="/images/activity/partywear_pr28.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[2][10]; ?>" href="#"><img src="/images/activity/partywear_pr29.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][11]; ?>" href="#"><img src="/images/activity/partywear_pr30.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][12]; ?>" href="#"><img src="/images/activity/partywear_pr31.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[2][13]; ?>" href="#"><img src="/images/activity/partywear_pr32.jpg" /></a>
                        </li>
                        <li>&nbsp;</li>
                    </ul>
                    <span class="lp_prev1 JS_prev3"></span>
                    <span class="lp_next1 JS_next3"></span>
                </div>
                <p class="tit center" id="nav4"><img src="/images/activity/partywear_tit4.png" /></p>
                <p class="center"><img src="/images/activity/partywear_pr33.jpg" /></p>
                <div class="JS_carousel4 lp_partywear_carousel">
                    <ul class="fix">
                        <li>
                            <a class="quick_view" id="<?php echo $products[3][0]; ?>" href="#"><img src="/images/activity/partywear_pr34.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[3][1]; ?>" href="#"><img src="/images/activity/partywear_pr35.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[3][2]; ?>" href="#"><img src="/images/activity/partywear_pr36.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[3][3]; ?>" href="#"><img src="/images/activity/partywear_pr37.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[3][4]; ?>" href="#"><img src="/images/activity/partywear_pr38.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[3][5]; ?>" href="#"><img src="/images/activity/partywear_pr39.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[3][6]; ?>" href="#"><img src="/images/activity/partywear_pr40.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[3][7]; ?>" href="#"><img src="/images/activity/partywear_pr41.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[3][8]; ?>" href="#"><img src="/images/activity/partywear_pr42.jpg" /></a>
                        </li>
                        <li>&nbsp;</li>
                    </ul>
                    <span class="lp_prev1 JS_prev4"></span>
                    <span class="lp_next1 JS_next4"></span>
                </div>
                <p class="tit center" id="nav5"><img src="/images/activity/partywear_tit5.png" /></p>
                <p class="center"><img src="/images/activity/partywear_pr43.jpg" /></p>
                <p class="center mt15"><img src="/images/activity/partywear_pr44.jpg" /></p>
                <div class="JS_carousel5 lp_partywear_carousel">
                    <ul class="fix">
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][0]; ?>" href="#"><img src="/images/activity/partywear_pr45.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][1]; ?>" href="#"><img src="/images/activity/partywear_pr46.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][2]; ?>" href="#"><img src="/images/activity/partywear_pr47.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][3]; ?>" href="#"><img src="/images/activity/partywear_pr48.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][4]; ?>" href="#"><img src="/images/activity/partywear_pr49.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[4][5]; ?>" href="#"><img src="/images/activity/partywear_pr50.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][6]; ?>" href="#"><img src="/images/activity/partywear_pr51.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][7]; ?>" href="#"><img src="/images/activity/partywear_pr52.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][8]; ?>" href="#"><img src="/images/activity/partywear_pr53.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][9]; ?>" href="#"><img src="/images/activity/partywear_pr54.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[4][10]; ?>" href="#"><img src="/images/activity/partywear_pr55.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][11]; ?>" href="#"><img src="/images/activity/partywear_pr56.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][12]; ?>" href="#"><img src="/images/activity/partywear_pr57.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][13]; ?>" href="#"><img src="/images/activity/partywear_pr58.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][14]; ?>" href="#"><img src="/images/activity/partywear_pr59.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[4][15]; ?>" href="#"><img src="/images/activity/partywear_pr60.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][16]; ?>" href="#"><img src="/images/activity/partywear_pr61.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][17]; ?>" href="#"><img src="/images/activity/partywear_pr62.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][18]; ?>" href="#"><img src="/images/activity/partywear_pr63.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[4][19]; ?>" href="#"><img src="/images/activity/partywear_pr64.jpg" /></a>
                        </li>
                    </ul>
                    <span class="lp_prev1 JS_prev5"></span>
                    <span class="lp_next1 JS_next5"></span>
                </div>
                <p class="tit center" id="nav6"><img src="/images/activity/partywear_tit6.png" /></p>
                <p class="center"><img src="/images/activity/partywear_pr65.jpg" /></p>
                <div class="JS_carousel6 lp_partywear_carousel">
                    <ul class="fix">
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][0]; ?>" href="#"><img src="/images/activity/partywear_pr66.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][1]; ?>" href="#"><img src="/images/activity/partywear_pr67.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][2]; ?>" href="#"><img src="/images/activity/partywear_pr68.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][3]; ?>" href="#"><img src="/images/activity/partywear_pr69.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][4]; ?>" href="#"><img src="/images/activity/partywear_pr70.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[5][5]; ?>" href="#"><img src="/images/activity/partywear_pr71.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][6]; ?>" href="#"><img src="/images/activity/partywear_pr72.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][7]; ?>" href="#"><img src="/images/activity/partywear_pr73.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][8]; ?>" href="#"><img src="/images/activity/partywear_pr74.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][9]; ?>" href="#"><img src="/images/activity/partywear_pr75.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[5][10]; ?>" href="#"><img src="/images/activity/partywear_pr76.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][11]; ?>" href="#"><img src="/images/activity/partywear_pr77.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][12]; ?>" href="#"><img src="/images/activity/partywear_pr78.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][13]; ?>" href="#"><img src="/images/activity/partywear_pr79.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][14]; ?>" href="#"><img src="/images/activity/partywear_pr80.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[5][15]; ?>" href="#"><img src="/images/activity/partywear_pr81.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][16]; ?>" href="#"><img src="/images/activity/partywear_pr82.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][17]; ?>" href="#"><img src="/images/activity/partywear_pr83.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][18]; ?>" href="#"><img src="/images/activity/partywear_pr84.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][19]; ?>" href="#"><img src="/images/activity/partywear_pr85.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[5][20]; ?>" href="#"><img src="/images/activity/partywear_pr86.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][21]; ?>" href="#"><img src="/images/activity/partywear_pr87.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][22]; ?>" href="#"><img src="/images/activity/partywear_pr88.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][23]; ?>" href="#"><img src="/images/activity/partywear_pr89.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][24]; ?>" href="#"><img src="/images/activity/partywear_pr90.jpg" /></a>
                        </li>

                        <li>
                            <a class="quick_view" id="<?php echo $products[5][25]; ?>" href="#"><img src="/images/activity/partywear_pr91.jpg" /></a>
                        </li>
                        <li>
                            <a class="quick_view" id="<?php echo $products[5][26]; ?>" href="#"><img src="/images/activity/partywear_pr92.jpg" /></a>
                        </li>
                        <li>&nbsp;</li> 
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                    </ul>
                    <span class="lp_prev1 JS_prev6"></span>
                    <span class="lp_next1 JS_next6"></span>
                </div>

            </div>
        </section>
        <?php echo View::factory('/catalog_left'); ?>
    </section>
</section>
<div id="catalog_link" class="" style="width: 922px; height: 538px; top: -35px; left: 250px;">
    <div style="background:#fff; height: 545px;" id="inline_example2">
        <div id="quickView">

            <!------------------------------------ Product Images-------------------------------------->         
            <div class="content-product-image fix">
                <div class="myImagesSlideBox1" id="myImagesSlideBox">
                    <div class="myImages1">
                        <img src="" class="myImgs" alt="" />
                    </div>
                    <div id="scrollable"> 
                        <div class="items" >
                            <div class="scrollableDiv"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!------------------------------------ Product Info-------------------------------------->
            <div id="productInfo">
                <dl>
                    <dd>
                        <h1 id="product_name">Floral Print Skinny Jean</h1>
                        <div class="infoText">Item# : <span id="product_sku">CPDL1959</span></div>
                        <div class="stock" id="stock">
                            <span class="icon-stock">&nbsp;</span>In Stock
                        </div>
                        <div class="hide" id="outstock">
                            <span class="icon-outstock">&nbsp;</span> Out Of Stock
                        </div>
                        <div class="detils"><a id="product_link" href="#" title="VIEW FULL DETAILS">VIEW FULL DETAILS</a></div>
                        <div class="clear"></div>
                    </dd>
                    <dd>
                        <div class="price">
                            <span class="reg"><del id="product_s_price"></del></span>
                            <br/>
                            <span id="product_price" class="nowPrice">$65.99</span>
                        </div>
                    </dd>

                    <dd class="fix">
                        <div class="charge_fix" id="action-form">
                            <form action="#" method="post" id="formAdd">
                                <input id="product_id" type="hidden" name="id" value="8468"/>
                                <input id="product_items" type="hidden" name="items[]" value="8468"/>
                                <input id="product_type" type="hidden" name="type" value="3"/>
                                <div class="btn_size"></div>
                                <div class="btn_color"></div>
                                <div class="btn_type"></div>
                                <div class="qty mt10">Qty: 
                                    <input type="button" onclick="minus()" value="-" class="btn_qty1" />
                                    <input type="text" name="quantity" class="btn_text" value="1" id="count_1"/>
                                    <input type="button" onclick="plus()" value="+" class="btn_qty" />
                                    <strong class="red" id="outofstock"></strong>
                                </div>
                                <div class="btnadd"> 
                                    <input type="submit" value="" class="sub" id="addCart" />
                                    <span class="s-wl ml10"><a id="addWishList" href="#"><img src="/images/btn_atw.png" /></a></span> 
                                </div>
                            </form>
                        </div>
                    </dd>
                    <dd>
                        <div id="tab5">
                            <div id="tab5-nav1">
                                <ul class="fix idTabs">
                                    <li><a href="#tab5-1-con" class="selected">DETAILS</a></li>
                                    <li><a href="#tab5-2-con">CONTACT</a></li>
                                </ul>
                            </div>
                            <div>
                                <div id="tab5-1-con"></div>
                                <div class="description hide" id="tab5-2-con">
                                    <div class="LiveChat2  mt15 pl10">
                                        <a href="#" onclick="psSMPPow(); return false;"><img name="psSMPPimage" src="http://www.choies.com/images/livechat_online.gif" border="0" /> LiveChat</a>
                                    </div>
                                    <div class="LiveChat2 mt10 pl10"><a href="mailto:webmaster@choies.com"><img src="/images/livemessage.png" alt="Leave Message" /> Leave Message</a></div>
                                    <div class="LiveChat2 mt10 pl10"><a href="<?php echo LANGPATH; ?>/faqs" target="_blank"><img src="/images/faq.png" alt="FAQ" /> FAQ</a></div>
                                </div>
                            </div>
                        </div>
                    </dd>
                    <dd>
                      <div><!--  <a href="<?php echo LANGPATH; ?>/20-coupon-code-for-spring-festival"><img src="/images/gift_banner.jpg" alt="" /></a>--></div>
                    </dd>
                </dl>
            </div>

        </div>
    </div>
    <div class="closebtn" style="right: -0px;top: 3px;"></div>
    <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>
<div class="mybag hide" id="mybag" style="position: fixed;top: 10px;right: 140px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border-style: solid;border-width: 8px 4px 4px;">
    <div class="add_tit" style="margin-top:0px;">Success! Item Added To BAG</div>
    <div class="order order_addtobag">
        <ul id="bag_items">
            <li>
            </li>
        </ul>
    </div>
    <div class="mybagButton"><a href="<?php echo LANGPATH; ?>/cart/view" id="checkout1" class="allbtn btn-chk1">&nbsp;</a></div>
</div>
<script src="/js/jquery-1.4.2.min.js"></script>
<script src="/js/catalog.js"></script>
<script src="/js/Carousel.js"></script>
<script>
    (function($) {
        $.fn.Z_TMAIL_SIDER_V2 = function(options) {
            var opts = $.extend( {}, $.fn.Z_TMAIL_SIDER_V2.defaults, options);
            var base = this;
            var navPosTop = $(base).offset().top;

            $(window).resize(function() {
                var sTop = $(window).scrollTop();
			
                if(sTop >= navPosTop) {
                    if($.browser.msie && $.browser.version < 7){
                        $(base).css({position: 'absolute', top: sTop});
                    }else {
                        $(base).css({position: 'fixed', top: 26});
                    }
                }else {
                    $(base).css({position: 'relative', top: 0});
                }
            });
		
            $(window).scroll(function() {
                var sTop = $(window).scrollTop();
			
                if(sTop >= navPosTop) {
                    if($.browser.msie && $.browser.version < 7){
                        $(base).css({position: 'absolute', top: sTop});
                    }else {
                        $(base).css({position: 'fixed', top: 26});
                    }
                }else {
                    $(base).css({position: 'relative', top: 0});
                }
            });
        };
	
        $.fn.Z_TMAIL_SIDER_V2.defaults = {
            slideHeight : 8
        };
    })(jQuery);
</script>
<script type="text/javascript">
    function goto(k){
        var id = "#nav"+k;
        var obj = $(id).offset();
        var pos = obj.top - 140;
        var position = $("#Z_TMAIL_SIDER_V2").css("position");
        if(position=="fixed"){
            pos = obj.top - 140; 
        }
        else{
            pos = obj.top - 140 - 120; 
        }
        $("html,body").animate({scrollTop: pos}, 1000);
    }

    $(function(){	

        $('#Z_TMAIL_SIDER_V2').Z_TMAIL_SIDER_V2();
	 
        // show / hide hover
        $(".JS_show").hover(function(){
            $(this).find('.JS_showcon').show();
        },function(){
            $(this).find('.JS_showcon').hide();
        })
	
        // JS_carousel1
        $(".JS_carousel1").carousel({
            btnPrev:".JS_prev1",
            btnNext:".JS_next1",
            scrolls:5,
            circular:false,
            visible:5
        })
	
        // JS_carousel2
        $(".JS_carousel2").carousel({
            btnPrev:".JS_prev2",
            btnNext:".JS_next2",
            scrolls:5,
            circular:false,
            visible:5
        })	
		
        // JS_carousel3
        $(".JS_carousel3").carousel({
            btnPrev:".JS_prev3",
            btnNext:".JS_next3",
            scrolls:5,
            circular:false,
            visible:5
        })
		
        // JS_carousel4
        $(".JS_carousel4").carousel({
            btnPrev:".JS_prev4",
            btnNext:".JS_next4",
            scrolls:5,
            circular:false,
            visible:5
        })	
		
        // JS_carousel5
        $(".JS_carousel5").carousel({
            btnPrev:".JS_prev5",
            btnNext:".JS_next5",
            scrolls:5,
            circular:false,
            visible:5
        })
	
        // JS_carousel6
        $(".JS_carousel6").carousel({
            btnPrev:".JS_prev6",
            btnNext:".JS_next6",
            scrolls:5,
            circular:false,
            visible:5
        })	
        $(".lp_partywear_carousel").css("width","776px");	
	
    });
</script>
<script>
    $(function(){
        $("#formAdd").submit(function(){
            $.post(
            '/cart/ajax_add',
            {
                id: $('#product_id').val(),
                type: $('#product_type').val(),
                size: $('.s-size').val(),
                color: $('.s-color').val(),
                attrtype: $('.s-type').val(),
                quantity: $('#count_1').val()
            },
            function(product)
            {
                var count = 0;
                var cart_view = '';
                var cart_view1 = '';
                var key = 0;
                for(var p in product)
                {
                    if(key == 0)
                    {
                        cart_view = '\
                                                <div class="order_img fll"><a href="'+product[p]['link']+'"><img src="'+product[p]['image']+'" alt="'+product[p]['name']+'" /></a></div>\
                                                        <div class="order_desc fll">\
                                                        <h3><a href="'+product[p]['link']+'">'+product[p]['name']+'</h3>\
                                                        <p>Item# : '+product[p]['sku']+'<br />\
                                                        '+product[p]['price']+'<br />\
                                                        '+product[p]['attributes']+'<br />\
                                                        Quantity: '+product[p]['quantity']+'</p>\
                                                </div>\
                                                <div class="fix"></div>\
                                                ';
                    }
                    else
                    {
                    cart_view1 += '\
                                                <li>\
                                                <div class="order_img fll"><a href="'+product[p]['link']+'"><img src="'+product[p]['image']+'" alt="'+product[p]['name']+'" /></a></div>\
                                                        <div class="order_desc fll">\
                                                        <h3><a href="'+product[p]['link']+'">'+product[p]['name']+'</h3>\
                                                        <p>Item# : '+product[p]['sku']+'<br />\
                                                        '+product[p]['price']+'<br />\
                                                        '+product[p]['attributes']+'<br />\
                                                        Quantity: '+product[p]['quantity']+'</p>\
                                                </div>\
                                                <div class="fix"></div>\
                                                </li>';
                                                                                count = count + product[p]['quantity'];
                                                                            }
                                                                            key = key + 1;
                                                                        }
                                                                        $('#bag_items li').html(cart_view);
                                                                        $('#mybag').fadeIn(10).delay(3000).fadeOut(10);
                                                                        $('#accountBag ul').html(cart_view1);
                                                                        $('#cart_count').text(count);
                   },
                   'json'
            );
            $("#wingray").remove();
            $('#catalog_link').fadeOut(160).appendTo('#tab2');
            return false;
        })
    })
</script>