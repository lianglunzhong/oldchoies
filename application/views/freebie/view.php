<link id=mystyle rel=stylesheet type="text/css" href="/css/bombsale.css" media=all>
<script type="text/javascript" src="/js/bombsale_images.js"></script>
<script src="/js/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
        var is_login = <?php echo $customer_id ? $customer_id : 0; ?>;
        var time_left = <?php echo $time_left; ?>;
        var page = <?php echo isset($_GET['page']) ? 1 : 0; ?>;
        $(function(){
                if(page)
                {
                        window.location.href = '#orderlist';
                }
                $('#counter').countdown({
                        image: '/images/freebie/digits.png',
                        startTime: '<?php echo $left_time; ?>'
                });
                $('.addToCart').live('click', function(){
                        if(!is_login)
                        {
                                $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                                $('#catalog_link').appendTo('body').fadeIn(320);
                                $('#catalog_link').show();
                                $("#catalog_link1").hide();
                                return false;
                        }
                        else
                        {
                                $('body').append('<div id="wingray1" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                                $('#catalog_link1').appendTo('body').fadeIn(320);
                                $("#catalog_link1").show();
                                $('#catalog_link').hide();
                                $("#code_image").attr('src', '/site/createcode');
                                return false;
                        }
                })
                
                $("#catalog_link .closebtn,#wingray").live("click",function(){
                        $("#wingray").remove();
                        $('#catalog_link').fadeOut(160).appendTo('#tab2');
                        return false;
                })
                
                $("#catalog_link1 .closebtn,#wingray1").live("click",function(){
                        $("#wingray1").remove();
                        $('#catalog_link1').fadeOut(160).appendTo('#tab2');
                        return false;
                })
                
                $("#change_code").live('click', function(){
                        var rand = generateMixed(6);
                        $("#code_image").attr('src', '/site/createcode/' + rand);
                        return false;
                })
        });
        function generateMixed(n) {
                var chars = ['0','1','2','3','4','5','6','7','8','9'];
                var res = "";
                for(var i = 0; i < n ; i ++) {
                        var id = Math.ceil(Math.random()*9);
                        res += chars[id];
                }
                return res;
        }
<?php
if ($time_left)
{
        ?>
                        $(function(){
                                var interval;
                                interval = setInterval(margin,1000);
                                                
                        })
        <?php
}
?>
        function margin()
        {
                var cnt_0 = $("#cnt_0").css('margin-top');
                var cnt_1 = $("#cnt_1").css('margin-top');
                var cnt_3 = $("#cnt_3").css('margin-top');
                var cnt_4 = $("#cnt_4").css('margin-top');
                var cnt_6 = $("#cnt_6").css('margin-top');
                var cnt_7 = $("#cnt_7").css('margin-top');
                var cnt_9 = $("#cnt_9").css('margin-top');
                var cnt_10 = $("#cnt_10").css('margin-top');
                var string = cnt_0 + '-' + cnt_1 + '-' + cnt_3 + '-' + cnt_4 + '-' + cnt_6 + '-' + cnt_7 + '-' + cnt_9 + '-' + cnt_10;
                if(cnt_0 == '0px' && cnt_1 == '0px' && cnt_3 == '0px' && cnt_4 == '0px' && 
                        cnt_6 == '0px' && cnt_7 == '0px' && cnt_9 == '0px' && cnt_10 == '0px')
                {
                        $(".addToCart").show();
                        $(".addToCart_gray").hide();
                }
        }
</script>
<div id="container">
        <div class="fix">
                <div id="main">
                        <div class="crumb"><a class=home href="<?php echo LANGPATH; ?>/">home</a>&gt;<span>Bomb Sale</span></div>
                        <?php echo Message::get(); ?>
                        <!-------activities star--------->
                        <div class="bombSale mb10">
                                <div><img src="/images/freebie/banner.jpg" alt="Choies Bomb Sale Series   
                                          Aim &amp; Shoot to Get the Killer Price" title="Choies Bomb Sale"/></div>
                                <div class="mt5"><img src="/images/freebie/shipping.png" alt="FREE SHIPPING + IMMEDIATE DELIVERY" title="FREE SHIPPING + IMMEDIATE DELIVERY"/></div>
                                <div class="fix mt10">
                                        <div id="myImagesSlideBox" class="myImagesSlideBox fll">
                                                <div class="myImages2"><img src="/images/freebie/pro01_1.jpg" class="myImgs"></div>
                                                <div id="scrollable">
                                                        <div class="smallimg">
                                                                <div class="scrollableDiv">
                                                                        <a><img src="/images/freebie/pro01_1s.jpg" imgb="/images/freebie/pro01_1.jpg"/></a>
                                                                        <a><img src="/images/freebie/pro01_3s.jpg" alt="" imgb="/images/freebie/pro01_3.jpg"/></a>
                                                                        <a><img src="/images/freebie/pro01_4s.jpg" imgb="/images/freebie/pro01_4.jpg"/></a>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="info flr">
                                                <dl>
                                                        <dd style="position:relative;">
                                                                <h1><?php echo Product::instance($product_id)->get('name'); ?></h1>
                                                                <div class="item">Item# : <?php echo $sku; ?></div>
                                                        </dd>
                                                        <dd>
                                                                <div class="price fll mb5"><span class="killPrice">$<?php echo $price; ?></span><span>Original Price: <strong><?php echo Site::instance()->price(Product::instance($product_id)->get('price'), 'code_view', 'USD'); ?></strong></span></div>
                                                                <div class="fll ml10 qty"><span style=" font-size:55px; line-height:55px;"><?php echo $amount > 0 ? $amount : 0; ?></span>left</div>
                                                        </dd>
                                                        <dd class="clear date">
                                                                <div class="fll" style="margin:15px;">Start At:<br/>
                                                                        <strong><?php echo $start_date; ?> <span class="red">20:30:00</span> EST</strong></div>
                                                                <div class="fll"><!-- 代码 开始 -->
                                                                        <div class="wrapper">
                                                                                <div id="counter"></div>
                                                                                <div class="desc">
                                                                                        <div>DAYS</div>
                                                                                        <div>HOURS</div>
                                                                                        <div>MINUTES</div>
                                                                                        <div>SECONDS</div>
                                                                                </div>
                                                                        </div>
                                                                        <!-- 代码 结束 --> 
                                                                </div>
                                                        </dd>
                                                        <dd class="clear btn">
                                                                <div class="addToCart fll mr10 <?php echo $time_left ? 'hide' : ''; ?>" <?php if ($amount <= 0) echo 'style="display:none;"'; ?>>
                                                                        <input type="submit" value="" />
                                                                </div>
                                                                <div class="addToCart_gray fll mr10 <?php echo $time_left ? '' : 'hide'; ?>" <?php if ($amount <= 0) echo 'style="display:block;"'; ?>>
                                                                        <input type="submit" value="" />
                                                                </div>
                                                                <div class="shopNow fll"><a href="<?php echo Product::instance($product_id)->permalink() . '?' . date('md', strtotime($start_date)); ?>" target="_blank"></a></div>
                                                        </dd>
                                                        <dd class="clear detail mt15">
                                                                <h5>Product Details:</h5>
                                                                <div>Alloy made. Retro swallow flying texture necklace. The swallow decorative design, unique personality. Fashion trend.<br/>
                                                                        <br/>
                                                                        <strong>One Size: </strong><br/>
                                                                        Length: 43cm around <br/><br/>
                                                                        <strong class="red" style="font-size:14px;">Please pay within 30 minutes, or you will lose the chance.</strong>
                                                                </div>
                                                        </dd>
                                                </dl>
                                        </div>
                                </div>
                                <div class="fix comeSoon ml10">
                                        <h3>COMING SOON…</h3>
                                        <ul>
                                                <li class="nextPro"><a href="<?php echo LANGPATH; ?>/product/vintage-floral-corset-vest?<?php echo date('md', strtotime($start_date)); ?>" target="_blank"><img src="/images/freebie/next_1.jpg"/>
                                                                       <p>Vintage Floral Corset Vest</p>
                                                        </a></li>
                                                <li class="nextPro"><a href="<?php echo LANGPATH; ?>/product/blue-lotus-print-bikini?<?php echo date('md', strtotime($start_date)); ?>" target="_blank"><img src="/images/freebie/next_2.jpg"/>
                                                                <p>Blue Lotus Print Bikini</p>
                                                        </a></li>
                                                <li class="nextPro"><a href="<?php echo LANGPATH; ?>/product/retro-drip-green-necklace-unique-color-personalized-fashion-trend/?<?php echo date('md', strtotime($start_date)); ?>" title="Retro Drip Green Necklace" target="_blank"><img src="/images/freebie/next_3.jpg" alt="Retro Drip Green Necklace"/>
                                                                <p>Retro Drip Green Necklace</p>
                                                        </a></li>
                                        </ul>
                                </div>
                                <div class="show">
                                        <h3 >PRODUCT SHOW</h3>
                                        <div class="index_main fix" style="height:390px;">
                                                <div class="rollBox">
                                                        <div class="LeftBotton" onMouseDown="ISL_GoUp()" onMouseUp="ISL_StopUp()" onMouseOut="ISL_StopUp()"></div>
                                                        <div class="Cont" id="ISL_Cont">
                                                                <div class="ScrCont">
                                                                        <div id="List1"> 
                                                                                <!-- 图片列表 begin -->
                                                                                <div class="pic"><a href="#" target="_self"><img src="/images/freebie/show_1.jpg"  alt="" /></a> </div>
                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_2.jpg"  alt="" /></a> </div>
                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_3.jpg"  alt="" /></a> </div>
                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_4.jpg"  alt="" /></a> </div>
                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_5.jpg"  alt="" /></a> </div>
                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_6.jpg"  alt="" /></a> </div>
                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_7.jpg"  alt="" /></a> </div>
<!--                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_8.jpg"  alt="" /></a> </div>
                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_9.jpg"  alt="" /></a> </div>
                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_10.jpg"  alt="" /></a> </div>
                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_11.jpg"  alt="" /></a> </div>
                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_12.jpg"  alt="" /></a> </div>
                                                                                <div class="pic"> <a href="#" target="_self"><img src="/images/freebie/show_13.jpg"  alt="" /></a> </div>-->
                                                                                <!-- 图片列表 end --> 
                                                                        </div>
                                                                        <div id="List2"></div>
                                                                </div>
                                                        </div>
                                                        <div class="RightBotton" onMouseDown="ISL_GoDown()" onMouseUp="ISL_StopDown()" onMouseOut="ISL_StopDown()"></div>
                                                </div>
                                        </div>
                                </div>
                                <a name="orderlist"><img src="/images/null.png" /></a>
                                <?php if(count($orders) > 0): ?>
                                <div class="orderList mt20">
                                        <h3>Bomb Order List</h3>
                                        <table border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                        <th width="280">NAME</th>
                                                        <th width="200">DATE</th>
                                                        <th width="150">SKU</th>
                                                        <th>PRICE</th>
                                                </tr>
                                                <?php
                                                $key = 1;
                                                foreach ($orders as $order):
                                                        ?>
                                                        <tr <?php if ($key % 2 == 0) echo 'class="bgWhite"'; ?>>
                                                                <td><?php echo $order['shipping_firstname']; ?></td>
                                                                <td><?php echo date('Y-m-d H:i:s', $order['created']); ?></td>
                                                                <td><?php echo $order['sku']; ?></td>
                                                                <td>$<?php echo $price; ?></td>
                                                        </tr>
                                                        <?php
                                                        $key++;
                                                endforeach;
                                                ?>
                                        </table>
                                        <?php echo $pagination; ?>
                                </div>
                                <?php endif; ?>
                        </div>
                        <!----------activities end-----------> 

                </div>
                <div id="aside">
                        <div class="aside-nav">
                                <?php echo View::factory('/catalog_left'); ?>
                        </div>
                </div>
        </div>
</div>
<script language="javascript" type="text/javascript">
        var Speed = 10; //速度(毫秒)
        var Space = 20; //每次移动(px)
        var PageWidth = 600; //翻页宽度
        var fill = 0; //整体移位
        var MoveLock = false;
        var MoveTimeObj;
        var Comp = 0;
        var AutoPlayObj = null;
        GetObj("List2").innerHTML = GetObj("List1").innerHTML;
        GetObj('ISL_Cont').scrollLeft = fill;
        GetObj("ISL_Cont").onmouseover = function(){clearInterval(AutoPlayObj);}
        GetObj("ISL_Cont").onmouseout = function(){AutoPlay();}
        //自动滚动 AutoPlay();
        function GetObj(objName){if(document.getElementById){return eval('document.getElementById("'+objName+'")')}else{return eval('document.all.'+objName)}}
        function AutoPlay(){ //自动滚动
                clearInterval(AutoPlayObj);
                AutoPlayObj = setInterval('ISL_GoDown();ISL_StopDown();',5000); //间隔时间
        }
        function ISL_GoUp(){ //上翻开始
                if(MoveLock) return;
                clearInterval(AutoPlayObj);
                MoveLock = true;
                MoveTimeObj = setInterval('ISL_ScrUp();',Speed);
        }
        function ISL_StopUp(){ //上翻停止
                clearInterval(MoveTimeObj);
                if(GetObj('ISL_Cont').scrollLeft % PageWidth - fill != 0){
                        Comp = fill - (GetObj('ISL_Cont').scrollLeft % PageWidth);
                        CompScr();
                }else{
                        MoveLock = false;
                }
                //AutoPlay();
        }
        function ISL_ScrUp(){ //上翻动作
                if(GetObj('ISL_Cont').scrollLeft <= 0){GetObj('ISL_Cont').scrollLeft = GetObj('ISL_Cont').scrollLeft + GetObj('List1').offsetWidth}
                GetObj('ISL_Cont').scrollLeft -= Space ;
        }
        function ISL_GoDown(){ //下翻
                clearInterval(MoveTimeObj);
                if(MoveLock) return;
                clearInterval(AutoPlayObj);
                MoveLock = true;
                ISL_ScrDown();
                MoveTimeObj = setInterval('ISL_ScrDown()',Speed);
        }
        function ISL_StopDown(){ //下翻停止
                clearInterval(MoveTimeObj);
                if(GetObj('ISL_Cont').scrollLeft % PageWidth - fill != 0 ){
                        Comp = PageWidth - GetObj('ISL_Cont').scrollLeft % PageWidth + fill;
                        CompScr();
                }else{
                        MoveLock = false;
                }
                //AutoPlay();
        }
        function ISL_ScrDown(){ //下翻动作
                if(GetObj('ISL_Cont').scrollLeft >= GetObj('List1').scrollWidth){GetObj('ISL_Cont').scrollLeft = GetObj('ISL_Cont').scrollLeft - GetObj('List1').scrollWidth;}
                GetObj('ISL_Cont').scrollLeft += Space ;
        }
        function CompScr(){
                var num;
                if(Comp == 0){MoveLock = false;return;}
                if(Comp < 0){ //上翻
                        if(Comp < -Space){
                                Comp += Space;
                                num = Space;
                        }else{
                                num = -Comp;
                                Comp = 0;
                        }
                        GetObj('ISL_Cont').scrollLeft -= num;
                        setTimeout('CompScr()',Speed);
                }else{ //下翻
                        if(Comp > Space){
                                Comp -= Space;
                                num = Space;
                        }else{
                                num = Comp;
                                Comp = 0;
                        }
                        GetObj('ISL_Cont').scrollLeft += num;
                        setTimeout('CompScr()',Speed);
                }
        }
</script>

<div id="catalog_link" class="" style="position: fixed;z-index: 1000;width: 662px; height: 280px; top: 70px; left: 380px;">
        <div style="background:#fff; height: 280px;" id="inline_example2">
                <div class="login" id="login">
                        <div class="clear"></div>
                        <div class="login_l fll ml10">
                                <div class="step_form_h2">LOG IN</div>
                                <form id="loginForm" method="post" action="/customer/login?redirect=bombsale/view" class="">
                                        <ul>
                                                <li>
                                                        <label><span>*</span> Email:</label>
                                                        <input type="text" id="" name="email" class="" />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li>
                                                        <label><span>*</span> Password: </label>
                                                        <input type="password" id="" name="password" class="" />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li>
                                                        <input type="submit" class="form_btn ml10" value="LOG IN" />
                                                        <span class="forgetpwd"><a href="#">I forgot my password !</a></span>
                                                </li>
                                        </ul>
                                </form>
                                <script type="text/javascript">
                                        $("#loginForm").validate($.extend(formSettings,{
                                                rules: {
                                                        email:{required: true,email: true},
                                                        password: {required: true,minlength: 5}
                                                }
                                        }));
                                </script>
                        </div>
                        <div class="login_l fll">
                                <div class="step_form_h2">I’M NEW TO CHOIES</div>
                                <form id="registerForm" method="post" action="/customer/register?redirect=bombsale/view" class="">
                                        <ul>
                                                <li>
                                                        <label><span>*</span> Email:</label>
                                                        <input type="text" id="email" name="email" class="" />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li>
                                                        <label><span>*</span> Password: </label>
                                                        <input type="password" id="password" name="password" class="" />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li>
                                                        <label><span>*</span> Confirm Pass: </label>
                                                        <input type="password" id="confirmpassword" name="confirmpassword" class="" />
                                                        <div class="errorInfo"></div>
                                                </li>
                                                <li>
                                                        <input type="submit" class="form_btn_long ml10"  value="CREAT ACCOUNT" />
                                                </li>
                                        </ul>
                                </form>
                                <script type="text/javascript">
                                        $("#registerForm").validate($.extend(formSettings,{
                                                rules: {			
                                                        email:{required: true,email: true},
                                                        password: {required: true,minlength: 5},
                                                        confirmpassword: {required: true,minlength: 5,equalTo: "#password"}
                                                }
                                        }));
                                </script>
                        </div>
                </div>
        </div>
        <div class="closebtn" style="right: -0px;top: 3px;"></div>
        <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>
<div id="catalog_link1" class="" style="display:none; position: fixed;z-index: 1000;width: 662px; height: 280px; top: 70px; left: 380px;">
        <div class="code" id="code">
                <p class="red mt10 mb10">Please pay within 30 minutes, or you will lose the chance.</p>
                <form action="" method="post" id="codeForm">
                        <div class="mt20">
                                <label class="mr5">CODE :</label>
                                <input type="text" id="" name="check_code" class="code_textarea"  maxlength=""/>
                                <div class="errorInfo"></div>
                                <p class="remark">Please Enter the Code Below.</p>
                        </div>
                        <div class="pic"><span><img src="" id="code_image" width="100" height="30" alt="code" /></span>
                                <span><a href="#" id="change_code" title="Change One">Change One</a></span>
                        </div>
                        <div>
                                <input type="submit" value="SUBMIT" class="submitCode"/>
                        </div>
                        <script type="text/javascript">
                                $("#codeForm").validate($.extend(formSettings,{
                                        rules: {			
                                                check_code: {required: true,minlength: 5}
                                        }
                                }));
                        </script>
                </form>
        </div>
        <div class="closebtn" style="right: -0px;top: 3px;"></div>
</div>
