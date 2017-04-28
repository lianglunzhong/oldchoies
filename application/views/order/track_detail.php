<!-- main begin -->
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="/">Home Page</a>  >  <a href="/customer/orders">Order History</a></a>  >  Track Detail</div>
        </div>
    </div>
  
    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="tit"><h2>Track Your Order</h2></div>
            <?php if(count($datas)>0){ ?>
            <!-- 有物流 -->
            <div class="track_con">
                <ul class="box1 fix">
                    <li><b>Order No.:</b> <?php echo $datas['ordernum'];?></li>
                    <li><b>Order Date:</b> <?php echo $datas['created'];?></li>
                </ul>
                <?php if(!in_array('error',$datas['tracks'])){ ?>
                <ul class="box1 fix">
                    <?php foreach($datas['tracks'] as $key=>$track){ ?>
                    <li><b>Package <?php echo $key+1;?> Track No.:</b> <?php echo $track['tracking_code'];?></li>
                    <li><b>Track link:</b> <a href="<?php echo $track['tracking_link'];?>" target="_blank"><?php echo $track['tracking_link'];?></a></li>
                    <?php } ?>
                </ul>
          
                <p>The tracking details do not display properly on our site due to technical problems caused by carrier's website, you can also track your order <a class="a_red" target="_blank" href="<?php echo $track['tracking_link'];?>">here</a> with your tracking No.</p>
    
                <div class="track_detail">
                    <?php if(count($datas['tracks'])>1){ ?>
                    <ul class="JS_tab detail_tab fix">
                        <?php foreach($datas['tracks'] as $key=>$track){ ?>
                        <li <?php if($key===0){ echo "class=\"current\""; }?>>Package<?php echo $key+1;?></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                    <div class="JS_tabcon detail_tabcon">
                        <?php foreach($datas['tracks'] as $key=>$track){ ?>
                        <div class="bd <?php if($key!==0){ echo "hide"; }?>">
                            <ul class="box1 fix">
                                <li><b>Tracking No.:</b> <span><?php echo $track['tracking_code'];?></span></li>
                                <li><b>Status:</b> <?php echo $track['status'];?></li>
                                <li><b>Origin Country:</b> <?php echo $track['send_country'];?></li>                                                                              
                                <li><b>Destination Country:</b> <?php echo $track['dest_country'];?></li>
                            </ul>
                            <dl class="box3"> 
                                <dt>Tracking History</dt>
                                <?php if(is_array($track['history'])){foreach ($track['history'] as $value) { ?>
                                <dd><?php echo $value['a'];?>, <span><?php echo $value['z'];?></span></dd>   
                                <?php }} ?>
                            </dl>
                            <dl class="box3">
                                <dt>Shipped To:</dt>
                                <dd><?php echo $track['shipping_address'].','.$track['shipping_city'].','.$track['shipping_state'];?></dd>
                                <dd><?php echo $track['shipping_country'];?></dd>
                                <dd><?php echo $track['shipping_zip'];?></dd>
                                <dd><?php echo $track['shipping_phone'];?></dd>
                            </dl>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php }else{ ?>
                <p class="color666">Sorry, the tracking No. you have entered is wrong, please check your order history again or <a href="/contact-us" class="a_red">contact us</a>.</p>
                <?php } ?>
            </div>
            <?php }else{ ?>
            <!-- 没有物流 -->
            <div class="track_con track_con_no">
            <p class="red">Sorry, the tracking No. you have entered is wrong, please check your order history again or <a href="/contact-us" class="a_red">contac us</a>.</p>
            </div>
            <?php } ?>
        </article>
        <?php echo View::factory('customer/left'); ?>
    </section>
</section>