<style>
    @charset "utf-8";
    .w1010 li{float:left;}
    .w1010 i{ color:#820707}
    .point{ cursor:pointer}
    .w1010{ max-width:1010px; margin:0 auto;}
    .kban{ width:100%; }
    .knav{width:100%; background-color:#000; height:50px;}
    .knav ul li{  margin:0 4.2%;   }
    .knav ul li>a{ font-weight:bold; font-size: 14px; line-height:50px; color:#fff; }
    .knav ul li>a.on{ color:#c70007;}
    .knav ul li>a:hover{ color:#c70007; text-decoration:none}

    .kwrap{width:100%; overflow:hidden }
    .bgcg{ background-color:#dde2e6}
    .kwrap .kh1{height:60px; font-size:36px; line-height:60px; font-weight:bold; border-bottom:2px solid #000; padding-left:10px;  }
    .kcont{ width:100%; overflow:hidden; } 
    .kcont p{ font-size:12px; line-height:16px; width:98%; }
    .kpeople{ padding:1% 0;}
    .kpeople img{ float: left;width: 30%; max-width: 320px; margin: 10px;}
    .kpeople p{ margin-left:1%}
    .kcont a{ font-weight:bold; font-size:14px;}

    .kstep h3,p{ font-size:16px; line-height:22px;}
    .kstep h3{ font-weight:bold}
    .li4{ border-top:2px solid #000; margin-top:10px; padding-top:10px; overflow:hidden  }
    .li4 li{ width:23.5%; width:23.0%\9; margin-right:2%; margin-top:10px;}<!--   -->
    .mr0{ margin-right:0}
    .li4 li:nth-child(4n){ margin-right:0;}
    .kcheck { background-color:#000; color:#fff; height:25px; text-align:center; font-size:14px; line-height:25px;}
    .kcheck input{ margin-right:20px;}
    .klike,.kliked{text-align:center;line-height:25px; }
    .klike span{ background:url(../images/activity/kimono.png) no-repeat -1px -1px;padding: 0 3px 18px 18px;}
    .kliked span{ background:url(../images/activity/kimono.png) no-repeat -22px -1px;padding: 0 3px 18px 18px;}
    .ka{ text-align:center; margin:15px 0; }
    .knext{ background-color:#000; color:#fff; height:30px; padding:5px 20px; font-size:18px; line-height:22px; font-weight:bold;}
    .knext:hover{ color:#fff}
    .kview{ margin-left:10px; font-size:14px; font-weight:bold}
    .kinput input{height: 22px;line-height: 22px;padding: 0 5px; border: 1px solid #CCCCCC; width:400px; font-size:12px; color:#999}
    .focus{background-color: #F4F4F0;}
    .kadd{ font-size:12px; cursor:pointer}

    .li5{margin-top:10px; padding-top:10px; overflow:hidden  }
    .li5 li{width:18.4%;width:18%\9; margin-right:2%; margin-top:10px;}
    .li5 li:nth-child(5n){ margin-right:0;} 

    .kdp{ overflow:hidden; margin:10px 0;}
    .kdp li{ margin-right:45px; margin-top:30px; }
    .kdp li:nth-child(3n){ margin-right:0;}


    /* v_show style */
    .v_show { width:1000px; position:absolute; margin-left:4px;  }

    .change_btn { float:left; margin:7px 0 0 10px; }
    .change_btn span { display:block; float:left; width:20px; height:46px; overflow:hidden;  text-indent:-9999px; cursor:pointer; z-index:99; }
    .change_btn .prev ,.change_btn .prev22 {   background-image:url(../images/activity/kpage.jpg); position:absolute; top:100px; left:-4px;  }
    .change_btn .next ,.change_btn .next22 {  background-image:url(../images/activity/knext.jpg); position:absolute;top:100px; right:-5px; }
    .v_caption em { display:inline; float:right; margin:10px 12px 0 0; font-family:simsun; }
    .v_content { position:relative;  height:250px; overflow:hidden;  width:996px; }
    .v_content_list { position:absolute; top:0px; left:0px; }
    .v_content ul {float:left;}
    .v_content ul li { display:inline; float:left; margin:10px 5px; padding:8px; background:url(../img/v_bg.gif) no-repeat;text-align:center }
    .v_content ul li a { display:block;  overflow:hidden; }
    .v_content ul li img {   }
    .v_content ul li h4 { width:128px; height:18px; overflow:hidden; margin-top:12px; font-weight:normal; }
    .v_content ul li h4 a { display:inline !important; height:auto !important; }
    .v_content ul li span { color:#666;  }
    .v_content ul li em { color:#888; font-family:Verdana; font-size:0.9em; }
    .v_content .v_content_list img{ width:140px; }


    .tab { }
    .tab_menu {  overflow:hidden}
    .tab_menu li { float:left; text-align:center; cursor:pointer; list-style:none; padding:10px 20px; border:1px solid #000; border-bottom:none;}
    .tab_menu li.hover { background:#000; color:#fff}
    .tab_menu li.selected { color:#FFF; background:#000;}
    .tab_box ,.ktab{   border: 1px solid #000000; height:250px;  }
    .hide{display:none}

    .tpin{ width:25%; text-align:right;float:left;}
    .tno{ width:20%; margin-left:0.5% ;float:left;}
    .tpdd{clear:both;margin:10px 0;width:100%;height:15px;}
    .outbar{background:#ececec;height:18px;width:50%;float:left;}
    .inbar{height:18px;display:block;}
</style>

<script type="text/javascript">

$(function(){
    var page = 1;
    var i = 6;  
    $("span.next22").click(function(){     
         var $parent = $(this).parents("div.v_show"); 
         var $v_show = $parent.find("div.v_content_list");  
         var $v_content = $parent.find("div.v_content");   
         var v_width = $v_content.width() ;
         var len = $v_show.find("li").length;
         var page_count = Math.ceil(len / i) ;    
         if( !$v_show.is(":animated") ){    
              if( page == page_count ){   
                $v_show.animate({ left : '0px'}, "slow");  
                page = 1;
                }else{
                $v_show.animate({ left : '-='+v_width}, "slow");  
                page++;
             }
         }
          
   });
     
    $("span.prev22").click(function(){
         var $parent = $(this).parents("div.v_show"); 
         var $v_show = $parent.find("div.v_content_list");  
         var $v_content = $parent.find("div.v_content");  
         var v_width = $v_content.width();
         var len = $v_show.find("li").length;
         var page_count = Math.ceil(len / i) ;    
         if( !$v_show.is(":animated") ){    
             if( page == 1 ){   
                $v_show.animate({ left : '-='+v_width*(page_count-1) }, "slow");
                page = page_count;
            }else{
                $v_show.animate({ left : '+='+v_width }, "slow");
                page--;
            }
        }
         
    });
});

$(function(){
    var page = 1;
    var i = 6;  
    $("span.next").click(function(){     
         var $parent = $(this).parents("div.v_show"); 
         var $v_show = $parent.find("div.v_content_list");  
         var $v_content = $parent.find("div.v_content");   
         var v_width = $v_content.width() ;
         var len = $v_show.find("li").length;
         var page_count = Math.ceil(len / i) ;  
         var left = $v_show.offset().left;    
         if( !$v_show.is(":animated") ){    
               if( left < -996 ){   
                $v_show.animate({ left : '0px'}, "slow");  
                page = 1;
                }else{
                $v_show.animate({ left : '-='+v_width}, "slow");  
                page++;
             }
         }
          
   });
     
    $("span.prev").click(function(){
         var $parent = $(this).parents("div.v_show"); 
         var $v_show = $parent.find("div.v_content_list");  
         var $v_content = $parent.find("div.v_content");  
         var v_width = $v_content.width();
         var len = $v_show.find("li").length;
         var page_count = Math.ceil(len / i) ; 
         var left = $v_show.offset().left;     
         if( !$v_show.is(":animated") ){    
             if(  left > 0 ){   
                $v_show.animate({ left : '-='+v_width*(page_count-1) }, "slow");
                page = page_count;
            }else{
                $v_show.animate({ left : '+='+v_width }, "slow");
                page--;
            }
        }
         
    });
});
    $(function(){
        var $div_li =$("div.tab_menu ul li");
        $div_li.hover(function(){
            $(this).addClass("selected")             
                   .siblings().removeClass("selected");   
            var index =  $div_li.index(this);   
            $("div.tab_box > div")         
                    .eq(index).show()    
                    .siblings().hide();  
        }) 
    })

</script>

<section id="main">
    <?php echo Message::get(); ?>
    <div class="w1010">
        
        <div id="one" class="kwrap mt15 kstep">
            <img src="/images/activity/kimon_vote.jpg" />
            <!-- <img src="/images/activity/kimon_02.jpg" />
            <!--Step 1 -->
            <!-- <h3 class="mt15">How to win:</h3>
            <p>1. Vote one style you like most.</p>
            <p>2. Share this event with your friends and relatives</p>
            <p>3. 5 lucky winners will be randomly selected to get big prizes </p>
            <span id="go2step2"></span>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;1 winner $100 gift card</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;2 winners $50 gift card</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;2 winnes $30 gift card</p> -->
            <?php
            if (!$has)
            {
                if(0)
                {
                ?>
                <form action="" method="post">
                    <div id="step1">
                        <h3 class="mt15">Step 1: Vote one style you like most</h3>
                        <ul class="li4" id="vote_style">
                            <li>
                                <img src="/images/activity/81.jpg" />
                                <div class="kcheck">
                                    <input type="checkbox" name="vote_style[]" value="1" id="vote_style1" /> <label for="vote_style1">KIMONO + TOP + SHORTS</label>
                                </div>
                            </li>
                            <li>
                                <img src="/images/activity/82.jpg" />
                                <div class="kcheck">
                                    <input type="checkbox" name="vote_style[]" value="2" id="vote_style2" /> <label for="vote_style2">KIMONO AS DRESS</label>
                                </div>
                            </li>
                            <li>
                                <img src="/images/activity/83.jpg" />
                                <div class="kcheck">
                                    <input type="checkbox" name="vote_style[]" value="3" id="vote_style3" /> <label for="vote_style3">KIMONO + SWIMWEAR</label>
                                </div>
                            </li>
                            <li>
                                <img src="/images/activity/84.jpg" />
                                <div class="kcheck">
                                    <input type="checkbox" name="vote_style[]" value="4" id="vote_style4" /> <label for="vote_style4">KIMONO + DRESS</label>
                                </div> 
                            </li>
                            <li>
                                <img src="/images/activity/85.jpg" />
                                <div class="kcheck">
                                    <input type="checkbox" name="vote_style[]" value="5" id="vote_style5" /> <label for="vote_style5">KIMONO + TOP + JEANS</label>
                                </div> 
                            </li>
                            <li>
                                <img src="/images/activity/86.jpg" />
                                <div class="kcheck">
                                    <input type="checkbox" name="vote_style[]" value="6" id="vote_style6" /> <label for="vote_style6">KIMONO + TOP + PANTS</label>
                                </div> 
                            </li>
                            <li>
                                <img src="/images/activity/87.jpg" />
                                <div class="kcheck">
                                    <input type="checkbox" name="vote_style[]" value="7" id="vote_style7" /> <label for="vote_style7">KIMONO + TOP + SKIRT</label>
                                </div> 
                            </li>
                            <li>
                                <img src="/images/activity/88.jpg" />
                                <div class="kcheck">
                                    <input type="checkbox" name="vote_style[]" value="8" id="vote_style8" /> <label for="vote_style8">KIMONO + ROMPER</label>
                                </div> 
                            </li>
                        </ul>
                        <div class="ka">
                            <?php
                            if (!$user_id)
                            {
                                ?>
                                <a class="knext" id="next_step1">Next Step</a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a class="knext" id="next_step">Next Step</a>
                                <?php
                            }
                            ?>
                            <!-- <a class="kview" href="">view more looks +</a> -->
                        </div>
                    </div>
                    <!--Step 2 -->
                    <div id="step2" style="display:none;">
                        <h3 class="mt15">Step 2: Share this event with your friends and relatives via any social networks</h3>
                        <div class="mt10">
                        SHARE TO:
                        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                        <script type="text/javascript">stLight.options({publisher: "76c0dd88-6e79-4e80-875e-7bc8934145b8", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
                        <span class='st_fblike_hcount' displayText='Facebook Like'></span>
                        <span class='st_facebook_hcount' displayText='Facebook'></span>
                        <span class='st_twitter_hcount' displayText='Tweet'></span>
                        <span class='st_tumblr_hcount' displayText='Tumblr'></span>
                        <span class='st_pinterest_hcount' displayText='Pinterest'></span>   
                        </div>
                        <div class="mt10">Please enter the URL/Links of your sharing post </div>
                        <div class="kdiv">
                            <p class="kinput mt10">
                                <input class="kip" type="url" name="urls[]" value="More share links, more chances to win" />
                            </p>
                        </div>
                        <p class="kadd" href="#">+ Add one more link</p>
                        <script type="text/javascript">
                            $(function(){
                                $("#vote_style li input").click(function(){
                                    if($(this).attr('checked') == 'checked')
                                    {
                                        if($("input[name='vote_style[]']:checked").length > 1)
                                        {
                                            return false;
                                        }
                                    }
                                })
                                $("#next_step").click(function(){
                                    if($("input[name='vote_style[]']:checked").length == 1)
                                    {
                                        $("#step1").hide();
                                        $("#step2").show();
                                        $("html,body").animate({scrollTop:$("#go2step2").offset().top},500);
                                    }
                                    else
                                    {
                                        alert('Please vote one style you like most!');
                                    }
                                    return false;
                                })
                                $("#next_step1").click(function(){
                                    if($("input[name='vote_style[]']:checked").length < 1)
                                    {
                                        alert('Please vote one style you like most!');
                                        return false;
                                    }
                                    else
                                    {
                                        var top = getScrollTop();
                                        top = top - 35;
                                        $('body').append('<div class="JS_filter1 opacity"></div>');
                                        $('.JS_popwincon1').css({
                                            "top": top, 
                                            "position": 'absolute'
                                        });
                                        $('.JS_popwincon1').appendTo('body').fadeIn(320);
                                        $('.JS_popwincon1').show();
                                        return false;
                                    }
                                })
                            })
                        </script>
                        <script>
                            $(function(){
                                $(".kip:input").live('focus', function(){
                                    $(this).addClass("focus");
                                    if($(this).val() ==this.defaultValue){  
                                        $(this).val("");           
                                    } 
                                }).live('blur', function(){
                                    $(this).removeClass("focus");
                                    if ($(this).val() == '') {
                                        $(this).val(this.defaultValue);
                                    }
                                });
                            })
                            $(function(){
                                $(".kadd").click(function(){
                                    var add = '<p class="kinput mt10"><input class="kip" type="text" name="urls[]" value="More share links, more chances to win" /></p>';
                                    $(".kdiv").append(add);
                                })
                            })
                        </script>
                        <div class="ka">
                            <input class="knext point" type="submit"  value="SUBMIT"/>
                        </div>
                    </div>
                </form>
                <?php
                }
            }
            else
            {
                ?>
                <!--Step 3 -->
                <?php
                $style_titles = array(
                    1 => 'KIMONO + TOP + SHORTS',
                    2 => 'KIMONO AS DRESS',
                    3 => 'KIMONO + SWIMWEAR',
                    4 => 'KIMONO + DRESS',
                    5 => 'KIMONO + TOP + JEANS',
                    6 => 'KIMONO + TOP + PANTS',
                    7 => 'KIMONO + TOP + SKIRT',
                    8 => 'KIMONO + ROMPER',
                );
                ?>
                <!-- <div class="kh1">YOUR FAVORITE STYLE: <i><?php echo $style_titles[$has]; ?></i></div>
                <div class="mt15">
                    <dl id="studyvote">
                        <dd class="tpdd">
                            <?php
                            $width_sum = 0;
                            $width = round($percents[1] / $sum, 4) * 100;
                            $width_sum += $width;
                            ?>
                            <div class="tpin">KIMONO + TOP + SHORTS：</div>
                            <div class="outbar"><div style="width:<?php echo $width; ?>%;background:#ad0101;" class="inbar"></div></div>
                            <div class="tno"><?php echo $percents[1]; ?> (<?php echo $width; ?>%) </div>
                        </dd>
                        <dd class="tpdd">
                            <?php
                            $width = round($percents[2] / $sum, 4) * 100;
                            $width_sum += $width;
                            ?>
                            <div class="tpin">KIMONO AS DRESS：</div>
                            <div class="outbar"><div style="width:<?php echo $width; ?>%;background:#ad9b01;" class="inbar"></div></div> 
                            <div class="tno"><?php echo $percents[2]; ?> (<?php echo $width; ?>%) </div>
                        </dd>
                        <dd class="tpdd">
                            <?php
                            $width = round($percents[3] / $sum, 4) * 100;
                            $width_sum += $width;
                            ?>
                            <div class="tpin">KIMONO +  SWIMWEAR：</div>
                            <div class="outbar"><div style="width:<?php echo $width; ?>%;background:#029297;" class="inbar"></div></div>
                            <div class="tno"><?php echo $percents[3]; ?> (<?php echo $width; ?>%) </div>
                        </dd>
                        <dd class="tpdd">
                            <?php
                            $width = round($percents[4] / $sum, 4) * 100;
                            $width_sum += $width;
                            ?>
                            <div class="tpin">KIMONO + DRESS：</div>
                            <div class="outbar"><div style="width:<?php echo $width; ?>%;background:#107b04;" class="inbar"></div></div> 
                            <div class="tno"><?php echo $percents[4]; ?> (<?php echo $width; ?>%) </div>
                        </dd>
                        <dd class="tpdd">
                            <?php
                            $width = round($percents[5] / $sum, 4) * 100;
                            $width_sum += $width;
                            ?>
                            <div class="tpin">KIMONO + TOP + JEANS：</div>
                            <div class="outbar"><div style="width:<?php echo $width; ?>%;background:#023e97;" class="inbar"></div></div> 
                            <div class="tno"><?php echo $percents[5]; ?> (<?php echo $width; ?>%) </div>
                        </dd>
                        <dd class="tpdd">
                            <?php
                            $width = round($percents[6] / $sum, 4) * 100;
                            $width_sum += $width;
                            ?>
                            <div class="tpin">KIMONO +  TOP + PANTS：</div>
                            <div class="outbar"><div style="width:<?php echo $width; ?>%;background:#4e06a8;" class="inbar"></div></div> 
                            <div class="tno"><?php echo $percents[6]; ?> (<?php echo $width; ?>%) </div>
                        </dd>
                        <dd class="tpdd">
                            <?php
                            $width = round($percents[7] / $sum, 4) * 100;
                            $width_sum += $width;
                            ?>
                            <div class="tpin">KIMONO +  TOP + SKIRT：</div>
                            <div class="outbar"><div style="width:<?php echo $width; ?>%;background:#bb06a4;" class="inbar"></div></div> 
                            <div class="tno"><?php echo $percents[7]; ?> (<?php echo $width; ?>%) </div>
                        </dd>
                        <dd class="tpdd">
                            <?php
                            $width = round (100 - $width_sum, 2);
                            if($width < 0)
                                $width = 0;
                            ?>
                            <div class="tpin">KIMONO + ROMPER：</div>
                            <div class="outbar"><div style="width:<?php echo $width; ?>%;background:#352128;" class="inbar"></div></div> 
                            <div class="tno"><?php echo $percents[8]; ?> (<?php echo $width; ?>%) </div>
                        </dd>
                    </dl>
                </div>  -->
                <h3 class="mt30">Kimono Outfit Idea for You</h3>
                <div class="ktab mt5"> 
                    <div class="v_show">
                        <div class="v_caption">
                            <div class="change_btn">
                                <span class="prev22" >上一页</span>
                                <span class="next22">下一页</span>
                            </div>
                        </div>
                        <div class="v_content">
                            <div  class="v_content_list">
                                <ul>
                                    <?php
                                    $skus = array(
                                    5 => array(
                                    'CSPY0527', 'CVXR0350', 'CPDL4681', 'CCZY3928', 'CVPY0306', 'CPXF0463',
                                    'CJZY0926', 'CVZY3483', 'CPXF0463', 'CCPY0603', 'CVSM2084', 'CPXR0723',
                                    'CSPY0537', 'CVZY3181', 'CPXF0404', 'CCZY3991', 'CVXF2546', 'CPXF1878',
                                    'CSPY0518', 'CSXF2495', 'CPDL2765', 'CCZY3923', 'CSZY2968', 'CPXF0463',
                                    'CSPY0191', 'CTPY0815', 'CPXF1385', 'CSPY0542', 'CVXR0536', 'CPXF1878',
                                    'CCZY3990', 'CVXR0341', 'CPXR0723', 'CCPY0601', 'CVWC4120', 'CPXF1878',
                                    'CSPY0377', 'CVZY4332', 'CPXF2255', 'CCPY0730', 'CVXR0350', 'CPXF0463',
                                    'CSPY0379', 'CTPY0814', 'CPXF2256', 'CCPY0807', 'CVZY3181', 'CPXF2256',
                                    'CCPY0763', 'CSSM0346', 'CPXF0463', 'CCPY0851', 'CVZY3483', 'CPXF1878',
                                    'CCPY0604', 'CVPY0306', 'CPXF1878', 'CCPY0540', 'CVYY1241', 'CPXR0723',
                                    'CCPY0571', 'CVZY3482', 'CPXF0404', 'CCPY0808', 'CVSY0234', 'CPXF0463',
                                    'CSZY2682', 'CVSM2085', 'CPDL4681', 'CSPY0538', 'CTXR0195', 'CPXF0463',
                                    'CCPY0809', 'CVYY1144', 'CPXF0404',
                                    ),
                                    6 => array(
                                    'CSPY0527', 'CVXR0350', 'CPXR0544', 'CCPY0603', 'CVXR0534', 'CPYY0647',
                                    'CJZY0926', 'CVZY3483', 'CPDL4024', 'CCZY3991', 'CVZY3483', 'CPXR0714',
                                    'CSPY0537', 'CVZY3181', 'CPXR0711', 'CCZY3923', 'CSZY2968', 'CPPY0192',
                                    'CSPY0518', 'CSXF2495', 'CPJY0107', 'CSPY0542', 'CVZY3483', 'CPZY4093',
                                    'CSPY0191', 'CTPY0814', 'CPDL4024', 'CCPY0601', 'CVZY3181', 'CPZY3449',
                                    'CCZY3990', 'CVXR0561', 'CPZY1759', 'CCPY0730', 'CVXR0350', 'CPPY0374',
                                    'CSPY0377', 'CVZY4332', '134806703', 'CCPY0807', 'CVZY3181', '134806703',
                                    'CSPY0379', 'CTPY0814', 'CPZY4095', 'CCPY0851', 'CVZY3483', 'CPZY3449',
                                    'CCPY0763', 'CSSM0346', 'CPZY2256', 'CCPY0540', 'CVYY1241', 'CPZY3383',
                                    'CCPY0604', 'CVPY0306', 'CPXR0544', 'CCPY0808', 'CVSY0234', 'CPZY3925',
                                    'CCPY0571', 'CVZY3482', 'CPZY4094', 'CSPY0538', 'CTXR0195', 'CPXR0710',
                                    'CSZY2682', 'CVSM2085', 'CPZY1719', 'CCPY0809', 'CVYY1144', 'CPZY1245',
                                    'CCZY3928', 'CVPY0306', 'CPZY1719',
                                    ),
                                    7 => array(
                                    'CSPY0527', 'CVXR0350', 'CHDL2700', 'CCZY3928', 'CVPY0306', 'CKPY0508',
                                    'CJZY0926', 'CVZY3483', 'CKDL1918', 'CCPY0603', 'CVXR0350', 'CKPY0869',
                                    'CSPY0537', 'CVXR0349', 'ASMX2101', 'CCZY3991', 'CVXF2546', 'CKSY0531',
                                    'CSPY0518', 'CSXF2495', 'CKPY0666', 'CCZY3923', 'CSZY2968', 'CKDL4835',
                                    'CSPY0191', 'CTPY0815', 'CKPY0393', 'CSPY0542', 'CVXR0536', 'CKPY0661',
                                    'CCZY3990', 'CVXR0341', 'CKPY0394', 'CCPY0601', 'CVZY3181', 'CKWC4275',
                                    'CSPY0377', 'CVZY4332', 'CKSY0148', 'CCPY0730', 'CVXR0350', 'CKYY0981',
                                    'CSPY0379', 'CTPY0814', 'CKPY0490', 'CCPY0807', 'CVZY3181', 'CKPY0394',
                                    'CCPY0763', 'CSSM0346', 'CHXR0505', 'CCPY0851', 'CVZY3483', 'CKPY0586',
                                    'CCPY0604', 'CVPY0306', 'CKPY0616', 'CCPY0540', 'CVYY1241', 'CKPY0645',
                                    'CCPY0571', 'CTPY0814', 'CKZY3981', 'CCPY0808', 'CVSY0234', 'CKWC3896',
                                    'CSZY2682', 'CVSM2085', 'CKWC4067', 'CSPY0538', 'CVXR0350', 'CKYY1529',
                                    'CCPY0809', 'CVYY1144', 'CKSM2042',
                                    ),
                                    1 => array(
                                    'CSPY0527', 'CVXR0350', 'CHDL2700', 'CCZY3928', 'CVPY0306', 'CHYY0789',
                                    'CJZY0926', 'CVZY3483', 'CKDL1918', 'CCPY0603', 'CVXR0350', 'CHXR0147',
                                    'CSPY0537', 'CVXR0349', 'CHXR0505', 'CCZY3991', 'CVXF2546', 'CHPY0231',
                                    'CSPY0518', 'CSXF2495', 'CHPY0515', 'CCZY3923', 'CSZY2968', 'CHPY0002',
                                    'CSPY0191', 'CTPY0815', 'CHYY0517', 'CSPY0542', 'CVXR0536', 'CHWC4079',
                                    'CCZY3990', 'CVXR0341', 'CHYY0789', 'CCPY0601', 'CVZY3181', 'CHWC3895',
                                    'CSPY0377', 'CVZY4332', 'CHPY0376', 'CCPY0730', 'CVXR0350', 'CHSY0200',
                                    'CSPY0379', 'CTPY0814', 'CHYY0517', 'CCPY0807', 'CVZY3181', 'CHZY3892',
                                    'CCPY0763', 'CSSM0346', '131712502', 'CCPY0851', 'CVZY3483', 'CHXF2309',
                                    'CCPY0604', 'CVPY0306', 'CHXR0726', 'CCPY0540', 'CVYY1241', 'CHZY3103',
                                    'CCPY0571', 'CTPY0814', 'CHZY4335', 'CCPY0808', 'CVSY0234', 'CHXF2583',
                                    'CSZY2682', 'CVSM2085', 'CHZY3986', 'CSPY0538', 'CVXR0350', 'CHYY0659',
                                    'CCPY0809', 'CVYY1144', 'CHZY3986',
                                    ),
                                    4 => array(
                                    'CSPY0527', 'CDYY0648', 'CCZY3991', 'CDZY2685', 'CCPY0808', 'CDXF0677',
                                    'CJZY0926', 'CDZY2685', 'CCZY3923', 'CDPY0077', 'CSPY0538', 'CDXR0740',
                                    'CSPY0537', 'CDYY1408', 'CSPY0542', 'CDYY1305', 'CCPY0809', 'CDZY4059',
                                    'CSPY0518', 'CDXR0655', 'CCPY0601', 'CDWC1449', 'CCPY0603', 'CDZY4058',
                                    'CSPY0191', 'CDYY1218', 'CCPY0730', 'CDYY0901', 'CCPY0854', 'CDXR0430',
                                    'CCZY3990', 'CDPY0006', 'CCPY0807', 'CDPY0077', 'CCPY0604', 'CDWC3934',
                                    'CSPY0377', 'CDXF2578', 'CCPY0851', 'CDPY0824', 'CCPY0571', 'CDPY0195',
                                    'CSPY0379', 'CDYY1221', 'CCPY0540', 'CDWC1442', 'CSZY2682', 'CDYY0648',
                                    'CCPY0763', 'CDPY0183', 'CCZY3928',
                                    ),
                                    2 => array(
                                    'CJZY0926',
                                    'CDDL4785',
                                    'CSPY0522',
                                    'CCPY0659',
                                    'CDPY0726',
                                    'CDPY0535',
                                    ),
                                    8 => array(
                                    'CSPY0527', 'CWMX0003', 'CCPY0603', 'CIPY0797', 'CCPY0540', 'CPZY3930',
                                    'CJZY0926', 'CPZY2796', 'CCZY3991', 'CIXR0355', 'CCPY0808', 'CISY0266',
                                    'CSPY0537', 'CPZY3929', 'CCZY3923', 'CPZY3929', 'CSPY0538', 'CPZY3929',
                                    'CSPY0518', 'CIXR0356', 'CSPY0542', 'CPXF1823', 'CCPY0809', 'CIXR0266',
                                    'CSPY0191', 'CIXR0355', 'CCPY0601', 'CPZY3133', 'CCPY0854', 'CIPY0001',
                                    'CCZY3990', 'CIXR0358', 'CCPY0730', 'CIWC4310', 'CCPY0604', 'CIPY0399',
                                    'CSPY0377', 'CPSM0399', 'CCPY0807', 'CHWC4093', 'CCPY0571', 'CPZY2844',
                                    'CSPY0379', 'CPSM0399', 'CCPY0851', 'CPZY3929', 'CSZY2682', 'CIPY0773',
                                    'CCPY0763', 'CPSM0400', 'CCZY3928', 'CPZY3929',
                                    ),
                                    3 => array(
                                    'CSPY0527', 'CBZY0403', 'CSZY2682', 'CGPY0101', 'CCPY0807', 'CBZY0403',
                                    'CJZY0926', 'CGPY0291', 'CCZY3928', 'CGPY0439', 'CCPY0851', 'CBZY0403',
                                    'CSPY0537', 'CBZY1044', 'CCPY0603', 'CGPY0592', 'CCPY0540', 'CGPY0001',
                                    'CSPY0518', 'CGPY0591', 'CCZY3991', 'CGYY0990', 'CCPY0808', 'CGPY0840',
                                    'CSPY0191', 'CGPY0003', 'CCZY3923', 'CGPY0279', 'CCPY0854', 'CGPY0448',
                                    'CCZY3990', 'CGPY0414', 'CSPY0542', 'CGPY0592', 'CCPY0604', 'CGPY0593',
                                    'CSPY0377', 'CBZY0404', 'CCPY0601', 'CGPY0339', 'CCPY0571', 'CGYY1288',
                                    'CSPY0379', 'CGPY0276', 'CCPY0730', 'CGPY0439', 'CSPY0538', 'CGPY0276',
                                    'CCPY0763', 'CGYY0800', 'CCPY0809', 'CBZY0411',
                                    ),
                                    );
                                    foreach($skus[$has] as $s)
                                    {
                                      $product_id = Product::get_productId_by_sku($s);
                                      ?>
                                        <li><a target="_blank" href="<?php echo Product::instance($product_id)->permalink(); ?>?ap"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" alt="" /></a><span><?php echo Site::instance()->price(Product::instance($product_id)->price(), 'code_view'); ?></span></li>
                                      <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="mt15"><a href="/kimonos?ap"><img src="/images/activity/kimono_05.jpg" /></a></div> -->
            </div>
    <?php
}
?>
        <div id="two" class="kwrap bgcg mt15">
            <div class="kh1">KIMONO TREND </div>
            <div class="kcont kpeople">
                <img class="" src="/images/activity/kimono_people.jpg" />
                <p>Is it a scarf?</p>
                <p>Is it a robe?</p>
                <p>Is it a cape?</p>
                <p>No, no, no, but it could be.</p>
                <p>As today we are talking about one of summer's most coveted trends – the KIMONO </p>
                <br />
                <a href="#">What's KIMONO?</a>
                <p>The kimono is a Japanese traditional garment. The word "kimono", which literally means a "thing to wear" (ki "to wear" and mono "thing"), has come to denote these full-length robes.</p>
                <p>However, the kimonos we wear today are adapted version of the traditional one. To the Western eye, which loves its feminine bulges and curves, the simple and straight lined kimono will cause an observer to stop and draw breath while looking at the beauty that is kimono.</p>
                <br />
                <a href="#">Why KIMONO is popular?</a>
                <p>It's incredibly feminine.</p>
                <p>It's sexy.</p>
                <p>It's boho chic.</p>
                <p>It's versatile</p>
                <br />
                <p>The Fashion press says that a kimono jacket "would look great over a white cotton summer dress at festivals or with jeans" and it also mentions the oriental print as being on the rise, especially on long, loose jackets. Besides, these Japanese silhouettes have been worn by a number of celebrities and can be seen all over the streets and social media and blogs.</p>
                <p>The styles kimonos come in a trillion of them: long, short, midi, prints, fringes, silky, oversized, but the best ones are the shorter ones in floral printed styles.</p>
            </div>
        </div>
        <div class="kwrap mt15">
            <div class="tab">
                <div class="tab_menu">
                    <ul>
                        <li class="selected">Hot Picks</li>
                        <li>Short Kimono</li>
                        <li>Midi Kimono</li>
                        <li>Long Kimono</li>
                        <li>Kimono with Tassels</li>
                        <li>Floral Print Kimono</li>
                        <li>Solid Color Kimono</li>
                    </ul>
                </div>
                <div class="tab_box"> 
                    <div class="v_show">
                        <div class="v_caption">
                            <div class="change_btn">
                                <span class="prev" >上一页</span>
                                <span class="next">下一页</span>
                            </div>
                        </div>
                        <div class="v_content">
                            <div  class="v_content_list">
                                <ul>
                                <?php
                                $skus = array(
'CSPY0527',
'CSPY0518',
'CJZY0926',
'CSPY0537',
'CSPY0191',
'CCZY3990',
'CSPY0379',
'CSPY0377',
'CCPY0877',
'CCPY0763',
'CSZY0923',
'CCPY0909',
'CCPY0604',
'CCPY0809',
'CCPY0571',
'CCPY0730',
'CCZY3923',
'CCPY0603',
                                );
                                foreach($skus as $s)
                                {
                                  $product_id = Product::get_productId_by_sku($s);
                                  ?>
                                    <li><a target="_blank" href="<?php echo Product::instance($product_id)->permalink(); ?>?ap"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" alt="" /></a><span><?php echo Site::instance()->price(Product::instance($product_id)->price(), 'code_view'); ?></span></li>
                                  <?php
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="v_show " style=" display:none"> 
                        <div class="v_caption">
                            <div class="change_btn">
                                <span class="prev" >上一页</span>
                                <span class="next">下一页</span>
                            </div>
                        </div>
                        <div class="v_content">
                            <div  class="v_content_list">
                                <ul>
                                <?php
                                $skus = array(
'CCPY0540',
'CCPY0572',
'CCPY0673',
'CCPY0728',
'CCPY0730',
'CCPY0831',
'CCPY0834',
'CCPY0846',
'CCPY0851',
'CCPY0854',
'CCPY0856',
'CCPY0859',
'CCPY0877',
'CCPY0908',
'CCPY0910',
'CCPY0911',
'CCPY0927',
'CCZY3928',
                                );
                                foreach($skus as $s)
                                {
                                  $product_id = Product::get_productId_by_sku($s);
                                  ?>
                                    <li><a target="_blank" href="<?php echo Product::instance($product_id)->permalink(); ?>?ap"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" alt="" /></a><span><?php echo Site::instance()->price(Product::instance($product_id)->price(), 'code_view'); ?></span></li>
                                  <?php
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="v_show " style=" display:none">
                        <div class="v_caption">
                            <div class="change_btn">
                                <span class="prev" >上一页</span>
                                <span class="next">下一页</span>
                            </div>
                        </div>
                        <div class="v_content">
                            <div  class="v_content_list">
                                <ul>
                                <?php
                                $skus = array(
'CCPY0573',
'CCPY0601',
'CCPY0604',
'CCPY0658',
'CCPY0708',
'CCPY0727',
'CCPY0729',
'CCPY0731',
'CCPY0793',
'CCPY0809',
'CCPY0850',
'CCPY0857',
'CCPY0878',
'CJZY0926',
'CSPY0377',
'CSPY0379',
'CSPY0527',
'CCZY3923',
                                );
                                foreach($skus as $s)
                                {
                                  $product_id = Product::get_productId_by_sku($s);
                                  ?>
                                    <li><a target="_blank" href="<?php echo Product::instance($product_id)->permalink(); ?>?ap"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" alt="" /></a><span><?php echo Site::instance()->price(Product::instance($product_id)->price(), 'code_view'); ?></span></li>
                                  <?php
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="v_show " style=" display:none">
                        <div class="v_caption">
                            <div class="change_btn">
                                <span class="prev" >上一页</span>
                                <span class="next">下一页</span>
                            </div>
                        </div>
                        <div class="v_content">
                            <div  class="v_content_list">
                                <ul>
                                <?php
                                $skus = array(
'CSPY0518',
'CCZY3990',
'CCPY0909',
'CSPY0542',
'CCPY0603',
'CCZY3991',
'CCZY4062',
'CCPY0808',
'CCPY0929',
'CCPY0928',
'CCPY0852',
'CCPY0602',
'CCPY0848',
'CCXR0564',
'CCPY0930',
'CCPY0659',
'CCPY0847',
'CCPY0807',
                                );
                                foreach($skus as $s)
                                {
                                  $product_id = Product::get_productId_by_sku($s);
                                  ?>
                                    <li><a target="_blank" href="<?php echo Product::instance($product_id)->permalink(); ?>?ap"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" alt="" /></a><span><?php echo Site::instance()->price(Product::instance($product_id)->price(), 'code_view'); ?></span></li>
                                  <?php
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="v_show " style=" display:none">
                        <div class="v_caption">
                            <div class="change_btn">
                                <span class="prev" >上一页</span>
                                <span class="next">下一页</span>
                            </div>
                        </div>
                        <div class="v_content">
                            <div  class="v_content_list">
                                <ul>
                                <?php
                                $skus = array(
'CSPY0527',
'CSPY0518',
'CSPY0191',
'CSPY0379',
'CSPY0377',
'CCPY0909',
'CCPY0571',
'CCPY0603',
'CSZY2682',
'CCPY0807',
'CCPY0849',
'CCPY0808',
'CCPY0855',
'CCPY0850',
'CCPY0929',
'CCPY0928',
'CCPY0847',
'CCPY0847',
                                );
                                foreach($skus as $s)
                                {
                                  $product_id = Product::get_productId_by_sku($s);
                                  ?>
                                    <li><a target="_blank" href="<?php echo Product::instance($product_id)->permalink(); ?>?ap"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" alt="" /></a><span><?php echo Site::instance()->price(Product::instance($product_id)->price(), 'code_view'); ?></span></li>
                                  <?php
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="v_show " style=" display:none">
                        <div class="v_caption">
                            <div class="change_btn">
                                <span class="prev" >上一页</span>
                                <span class="next">下一页</span>
                            </div>
                        </div>
                        <div class="v_content">
                            <div  class="v_content_list">
                                <ul>
                                <?php
                                $skus = array(
'CSPY0527',
'CSPY0518',
'CSPY0537',
'CSPY0191',
'CCZY3990',
'CSPY0379',
'CSPY0377',
'CCPY0877',
'CCPY0604',
'CCPY0809',
'CCPY0571',
'CCPY0603',
'CSPY0522',
'CCZY3991',
'CCZY3928',
'CDDL4785',
'CCPY0807',
'CCPY0851',
                                );
                                foreach($skus as $s)
                                {
                                  $product_id = Product::get_productId_by_sku($s);
                                  ?>
                                    <li><a target="_blank" href="<?php echo Product::instance($product_id)->permalink(); ?>?ap"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" alt="" /></a><span><?php echo Site::instance()->price(Product::instance($product_id)->price(), 'code_view'); ?></span></li>
                                  <?php
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="v_show " style=" display:none">
                        <div class="v_caption">
                            <div class="change_btn">
                                <span class="prev" >上一页</span>
                                <span class="next">下一页</span>
                            </div>
                        </div>
                        <div class="v_content">
                            <div  class="v_content_list">
                                <ul>
                                <?php
                                $skus = array(
'CCPY0909',
'CCPY0852',
'CCPY0808',
'CSZY2682',
'CCDL3165',
'CCPY0993',
'CCPY0989',
'CCPY0993',
'CCXR0568',
'CCXR0570',
'CCXR0567',
'CCXR0564',
'CCXR0563',
'CCYY0996',
'CCYY0997',
                                );
                                foreach($skus as $s)
                                {
                                  $product_id = Product::get_productId_by_sku($s);
                                  ?>
                                    <li><a target="_blank" href="<?php echo Product::instance($product_id)->permalink(); ?>?ap"><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" alt="" /></a><span><?php echo Site::instance()->price(Product::instance($product_id)->price(), 'code_view'); ?></span></li>
                                  <?php
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="three" class="kwrap mt15">
            <div class="kh1">FASHION INSPIRATION</div>
            <div class="kcont">
                <p>How to wear kimonos and look fabulous? Just throw one on. </p>
                <p>They do look best with shorts, short dresses or skirts, bustier tops, tank tops, over swimsuits, and over anything you'd actually rock on a hot summer night or day. Wear it as a silky jacket, a wrapped dress or as a rocknroll sophisticated cover up. Kimono is one great piece, which makes your shoulders looks slouchier, slim figures look skinnier. It just ads a bit of color, and sophistication to an otherwise boring style. </p>
                <div class="mt15"><img src="/images/activity/kimono_04.jpg" /></div>
                <div class="mt15">
                    <a target="_blank" class="mr20" href="http://instagram.com/p/rD1kCdnNmH/"><img src="/images/activity/kimono_ins.jpg" /></a>
                    <a target="_blank" href="https://www.facebook.com/choiescloth/photos/a.310233545725719.70711.277865785629162/686481718100898/?type=1&relevant_count=1"><img src="/images/activity/kimono_fb.jpg" /></a>
                </div>
            </div>
        </div>
        <div id="four" class="kwrap ">
            <div class="kh1">GET KIMONO LOOK</div>
            <div class="kcont" >
                <ul class="kdp" id="kul">
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/perfectly_unperfect_choies/set?.embedder=10012205&.svc=copypaste&id=129760759"><img width="300" alt="Perfectly unperfect.... by Choies" src="http://embed.polyvoreimg.com/cgi/img-set/cid/129760759/id/nBHF-0IU5BG8pfJBBxFvvQ/size/l.jpg" title="Perfectly unperfect.... by Choies" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113886178"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/113886178.jpg" title="Vintage coat" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=110097680"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/110097680.jpg" title="White waistcoat" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=112119664"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/112119664.jpg" title="Blue denim shorts" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=111834207"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/111834207.jpg" title="Metallic shoes" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=110336022"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/110336022.jpg" title="Jelly purse" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113661429"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/113661429.jpg" title="Leopard print glasses" height="50" /></a></div></div></li>
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/535_you_had_started_doing/set?.embedder=10012205&.svc=copypaste&id=129825659"><img width="300" alt="535: "If you had started doing anything two weeks ago, by today you would have been two weeks better at it." ?" src="http://embed.polyvoreimg.com/cgi/img-set/cid/129825659/id/lta_LMYU5BGF6ojPBhFvvQ/size/l.jpg" title="535: "If you had started doing anything two weeks ago, by today you would have been two weeks better at it." ?" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=108982320"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/108982320.jpg" title="Floral coat" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=109224119"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/109224119.jpg" title="Python bag" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=106195724"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/106195724.jpg" title="Metal jewelry" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=103100336"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/103100336.jpg" title="Metal glasses" height="50" /></a></div></div></li>
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/be_classy/set?.embedder=10012205&.svc=copypaste&id=129839779"><img width="300" alt="Be classy." src="http://embed.polyvoreimg.com/cgi/img-set/cid/129839779/id/WCwDGuEU5BGtGD1g2__Y_w/size/l.jpg" title="Be classy." height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=112189108"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/112189108.jpg" title="Brown coat" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=110538349"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/110538349.jpg" title="Lace romper" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=103868493"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/103868493.jpg" title="Brown handbag" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=85372384"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/85372384.jpg" title="Black sunglasses" height="50" /></a></div></div></li>  
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/choies.com_10/set?.embedder=10012205&.svc=copypaste&id=129594340"><img width="300" alt="choies.com 3/10" src="http://embed.polyvoreimg.com/cgi/img-set/cid/129594340/id/epSQGDYT5BGOTPG3tfvecw/size/l.jpg" title="choies.com 3/10" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=114522372"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/114522372.jpg" title="Red bow back dress" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=114230369"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/114230369.jpg" title="Floral kimono" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113163729"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/113163729.jpg" title="Ankle strap high heel shoes" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=107551374"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/107551374.jpg" title="Pink purse" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=105440235"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/105440235.jpg" title="Cat eye sunglasses" height="50" /></a></div></div></li>  
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/533_some_people_never_go/set?.embedder=10012205&.svc=copypaste&id=129479127"><img width="300" alt="533: "Some people never go crazy. What truly horrible lives they must lead." ?" src="http://embed.polyvoreimg.com/cgi/img-set/cid/129479127/id/GD_NXXAS5BGj9EyhzSGTQA/size/l.jpg" title="533: "Some people never go crazy. What truly horrible lives they must lead." ?" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=112635433"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/112635433.jpg" title="Vintage kimono" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113917313"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/113917313.jpg" title="Golf skirt" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=112501363"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/112501363.jpg" title="Diamond necklace" height="50" /></a></div></div></li> 
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/set_1735_choies_kimonos_all/set?.embedder=10012205&.svc=copypaste&id=129355330"><img width="300" alt="SET #1735. Choies Kimonos: All Black" src="http://embed.polyvoreimg.com/cgi/img-set/cid/129355330/id/vs5_rZoR5BGEpU7Zh-Oa4g/size/l.jpg" title="SET #1735. Choies Kimonos: All Black" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113873650"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/113873650.jpg" title="Black coat" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=108647755"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/108647755.jpg" title="Golf skirt" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=83464335"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/83464335.jpg" title="Flat shoes" height="50" /></a></div></div></li> 
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/choies/set?.embedder=10012205&.svc=copypaste&id=127968566"><img width="300" alt="Choies 2" src="http://embed.polyvoreimg.com/cgi/img-set/cid/127968566/id/grzNSxQI5BGSKa_omu7EJQ/size/l.jpg" title="Choies 2" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113284851"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/113284851.jpg" title="Flower kimono" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=112635520"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/112635520.jpg" title="Denim shorts" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=111547918"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/111547918.jpg" title="Backpacks bag" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=112789332"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/112789332.jpg" title="Wayfarer sunglasses" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=107102277"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/107102277.jpg" title="Lip makeup" height="50" /></a></div></div></li> 
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/wonderful_thing_in_life/set?.embedder=10012205&.svc=copypaste&id=129227820"><img width="300" alt="Wonderful Thing in Life" src="http://embed.polyvoreimg.com/cgi/img-set/cid/129227820/id/xlif6oIR5BGg0aVhDXURzQ/size/l.jpg" title="Wonderful Thing in Life" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=112189139"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/112189139.jpg" title="Kimono coat" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=110538537"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/110538537.jpg" title="Multi color necklace" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=87122340"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/87122340.jpg" title="Digital sports watch" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=114366956"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/114366956.jpg" title="Sivanna Colors Stay Luxurious Lipgloss 11" height="50" /></a></div></div></li>  
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/whos_that_girl/set?.embedder=10012205&.svc=copypaste&id=126936614"><img width="300" alt="Who's That Girl ?" src="http://cfc.polyvoreimg.com/cgi/img-set/.sig/TCrF6C0I6cPaUc4lHFGyFA/cid/126936614/id/BIMiiAoB5BG29YKBZFZllw/size/c300x300.jpg" title="Who's That Girl ?" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=112985092"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/112985092.jpg" title="Chiffon kimono" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=112988834"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/112988834.jpg" title="White romper" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=108099321"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/108099321.jpg" title="White purse" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=107530163"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/107530163.jpg" title="Jewels jewelry" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=90699089"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/90699089.jpg" title="Black sunglasses" height="50" /></a></div></div></li>  
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/choies/set?.embedder=10012205&.svc=copypaste&id=130038725"><img width="300" alt="CHOIES" src="http://embed.polyvoreimg.com/cgi/img-set/cid/130038725/id/XDC3dTsW5BGXeTiGzSGTQA/size/l.jpg" title="CHOIES" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=111716231"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/111716231.jpg" title="Black crop top" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=108982331"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/108982331.jpg" title="Floral print coat" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113917313"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/113917313.jpg" title="Golf skirt" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=108561874"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/108561874.jpg" title="Black handbag" height="50" /></a></div></div></li>
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/kimono_leather/set?.embedder=10012205&.svc=copypaste&id=124860583"><img width="300" alt="Kimono & leather" src="http://embed.polyvoreimg.com/cgi/img-set/cid/124860583/id/xI2uXuby4xGZzXVQSbYPRA/size/l.jpg" title="Kimono & leather" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=111402409"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/111402409.jpg" title="Kimono top" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=109462712"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/109462712.jpg" title="Black purse" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=104834363"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/104834363.jpg" title="Green sunglasses" height="50" /></a></div></div></li>
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/choies/set?.embedder=10012205&.svc=copypaste&id=129354541"><img width="300" alt="choies 5" src="http://embed.polyvoreimg.com/cgi/img-set/cid/129354541/id/cC4tQJgR5BG_hnuJmu7EJQ/size/l.jpg" title="choies 5" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=111402409"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/111402409.jpg" title="Black top" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=114190449"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/114190449.jpg" title="Crochet top" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=111694038"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/111694038.jpg" title="Denim shorts" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113787566"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/113787566.jpg" title="Flat shoes" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=109779939"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/109779939.jpg" title="Black handbag" height="50" /></a></div></div></li>
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/choies.com/set?.embedder=10012205&.svc=copypaste&id=129565175"><img width="300" alt="choies.com 3/9" src="http://cfc.polyvoreimg.com/cgi/img-set/.sig/FWxjy6Q8Ph4YYwdSwESIA/cid/129565175/id/Ok8JcOYS5BGVHO93DXURzQ/size/c300x300.jpg" title="choies.com 3/9" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=112636333"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/112636333.jpg" title="Chiffon shirt" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=114165652"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/114165652.jpg" title="Floral kimono" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=111694038"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/111694038.jpg" title="Jean shorts" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=108099321"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/108099321.jpg" title="White purse" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=109522441"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/109522441.jpg" title="Mirror glasses" height="50" /></a></div></div></li>
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/sunflowers/set?.embedder=10012205&.svc=copypaste&id=129789789"><img width="300" alt="sunflowers ?" src="http://embed.polyvoreimg.com/cgi/img-set/cid/129789789/id/2PjN12sU5BGia9qh2__Y_w/size/l.jpg" title="sunflowers ?" height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=114731904"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/114731904.jpg" title="Lace top" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113873650"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/113873650.jpg" title="Black coat" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=111547795"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/111547795.jpg" title="High waisted shorts" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=106533828"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/106533828.jpg" title="Rhinestone jewelry" height="50" /></a></div></div></li>
                    <li><div style="width:300px;margin:0 auto"><div style="position:relative;"><a target="_blank" href="http://www.polyvore.com/choies....7/set?.embedder=10012205&.svc=copypaste&id=128960753"><img width="300" alt="Choies....7." src="http://embed.polyvoreimg.com/cgi/img-set/cid/128960753/id/nmXlVdEO5BG6H3X2h-Oa4g/size/l.jpg" title="Choies....7." height="300" border="0" /></a></div></div><div style="width:300px;margin:0 auto"><br/><div style="text-align:left;"><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=114180098"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/114180098.jpg" title="Green top" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113872486"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/113872486.jpg" title="Green kimono" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=107967779"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/107967779.jpg" title="White skirt" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=94146895"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/94146895.jpg" title="Rhinestone shoes" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=110270183"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/110270183.jpg" title="Green purse" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113275975"><img vspace="4" width="50" hspace="4" src="http://ak1.polyvoreimg.com/cgi/img-thing/size/s/tid/113275975.jpg" title="Pendants necklace" height="50" /></a><a rel="nofollow" target="_blank" href="http://www.polyvore.com/cgi/thing?.embedder=10012205&.svc=copypaste&id=113344128"><img vspace="4" width="50" hspace="4" src="http://ak2.polyvoreimg.com/cgi/img-thing/size/s/tid/113344128.jpg" title="Round sunglasses" height="50" /></a></div></div></li> 
                </ul>
                <div class="ka"><a href="" class="kview" id="kview">view more looks +</a></div>
                <script type="text/javascript">
                    $(function(){                       
                        var $category = $('#kul li:gt(2)');           
                        $category.hide();              
                        var $toggleBtn = $('#kview');          
                        $toggleBtn.click(function(){
                            if($category.is(":visible")){
                                $category.slideToggle();                   
                                $('#kview').text("view more looks +");              
                            }else{
                                $category.slideToggle();                   
                                $('#kview').text("View less -");               
                            }
                            return false;               
                        })
                    })
                </script>
                <div class="mt15"><a target="_blank" href="http://www.polyvore.com/create_your_kimiono_looks_daily/contest.show?id=504030"><img src="/images/activity/kimono_03.jpg" /></a></div>
            </div>
        </div>
        <div id="five" class="kwrap">
            <div class="kh1">ENTER EVENTS TO GET FREE KIMONOS  </div>
            <div class="kcont">
                <ul class="li5">
                    <li><a target="_blank" href="http://instagram.com/p/rD1kCdnNmH/"><img src="/images/activity/kimono2_bins.jpg"/></a></li>
                    <li><a target="_blank" href="http://choiesclothes.tumblr.com/post/93196073255/choies-kimono-giveaway"><img src="/images/activity/kimono2_btum.jpg"/></a></li>
                    <li><a target="_blank" href="https://www.facebook.com/choiescloth/photos/a.310233545725719.70711.277865785629162/686481718100898/?type=1&relevant_count=1"><img src="/images/activity/kimono2_bfb.jpg"/></a></li>
                    <li><a target="_blank" href="http://www.polyvore.com/create_your_kimiono_looks_daily/contest.show?id=504030"><img src="/images/activity/kimono2_bpol.jpg"/></a></li>
                    <li><a target="_blank" href="/freetrial/add "><img src="/images/activity/kimono2_bfre.jpg"/></a></li>
                </ul> 
            </div>
        </div>
    </div>
</section>

<div class="JS_popwincon1 popwincon w_signup hide">
    <a class="JS_close2 close_btn2"></a>
    <div class="fix">
        <div class="left" style="width:auto;margin-right:30px;padding-right:30px;">
            <h3>CHOIES Member Sign In</h3>
            <form action="/customer/login?redirect=/activity/kimono#go2step2" method="post" class="signin_form sign_form form">
                <ul>
                    <li>
                        <label>Email address: </label>
                        <input type="text" value="" id="email" name="email" class="text" />
                    </li>
                    <li>
                        <label>Password: </label>
                        <input type="password" value="" id="password" name="password" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="Sign In" name="submit" class="btn btn40" /><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text_underline">Forgot password?</a></li>
                    <li>
<?php
$redirect = Arr::get($_GET, 'redirect', '');
$page = 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars('/activity/kimono#go2step2');
;
$facebook = new facebook();
$loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
?>
                        <a href="<?php echo $loginUrl; ?>" class="facebook_btn"></a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="right">
            <h3>CHOIES Member Sign Up</h3>
            <form action="/customer/register?redirect=/activity/kimono#go2step2" method="post" class="signup_form sign_form form">
                <ul>
                    <li>
                        <label>Email address: </label>
                        <input type="text" value="" id="email1" name="email" class="text" />
                    </li>
                    <li>
                        <label>Password: </label>
                        <input type="password" value="" id="password1" name="password" class="text" id="password" maxlength="16" />
                    </li>
                    <li>
                        <label>Confirm password: </label>
                        <input type="password" value="" id="password_confirm" name="password_confirm" class="text" maxlength="16" />
                    </li>
                    <li><input type="submit" value="Sign Up" name="submit" class="btn btn40" /></li>
                </ul>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        // signin_form 
        $(".signin_form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5,
                    maxlength:20
                }
            },
            messages: {
                email:{
                    required:"Please provide an email.",
                    email:"Please enter a valid email address."
                },
                password: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 5 characters long.",
                    maxlength: "The password exceeds maximum length of 20 characters."
                }
            }
        });

        // signup_form 
        $(".signup_form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5,
                    maxlength:20
                },
                password_confirm: {
                    required: true,
                    minlength: 5,
                    maxlength:20,
                    equalTo: "#password1"
                }
            },
            messages: {
                email:{
                    required:"Please provide an email.",
                    email:"Please enter a valid email address."
                },
                password: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 5 characters long.",
                    maxlength:"The password exceeds maximum length of 20 characters."
                },
                password_confirm: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 5 characters long.",
                    maxlength:"The password exceeds maximum length of 20 characters.",
                    equalTo: "Please enter the same password as above."
                }
            }
        });
    </script>
</div>
<script>
    $(function(){
        $(".signin_form").submit(function(){
            var email = $("#email").val();
            var password = $("#password").val();
            $.ajax({
                type: "POST",
                url: "/customer/ajax_login",
                dataType: "json",
                data: "email=" + email + "&password=" + password,
                success: function(data){
                    if(data.success == 1)
                    {
                        $(".JS_filter1").remove();
                        $('.JS_popwincon1').fadeOut(160);
                        $("#step1").hide();
                        $("#step2").show();
                        $("html,body").animate({scrollTop:$("#go2step2").offset().top},500);
                    }
                    else
                    {
                        alert(data.message);
                    }
                }
            });
            return false;
        })

        $(".signup_form").submit(function(){
            var email = $("#email1").val();
            var password = $("#password1").val();
            var password_confirm = $("#password_confirm").val();
            $.ajax({
                type: "POST",
                url: "/customer/ajax_register",
                dataType: "json",
                data: "email=" + email + "&password=" + password + "&password_confirm=" + password_confirm,
                success: function(data){
                    if(data.success)
                    {
                        $(".JS_filter1").remove();
                        $('.JS_popwincon1').fadeOut(160);
                        $("#step1").hide();
                        $("#step2").show();
                        $("html,body").animate({scrollTop:$("#go2step2").offset().top},500);
                    }
                    else
                    {
                        alert(data.message);
                    }
                }
            });
            return false;
        })
    })
</script>