<script src="/js/jquery-1.7.2.min.js" type="text/javascript"></script> 
<style>
    .dleb{ font-size:10px; font-style:italic; vertical-align:bottom}
    .dwrapper{ width:460px; margin:0 auto; border:1px solid #CCC; background-color:#fff; position:absolute; height:460px; left:50%; margin-left:-240px; top:50%; margin-top:-240px; z-index:1001; border:10px solid #e5e5e5; }
    .dcontent{ font:12px/30px Verdana, Geneva, sans-serif;}
    .dwrap{ margin:0px 20px; padding:15px 10px 20px; border-bottom:3px solid #ccc; text-align:center} 
    .dwrap .icon_flag{display: inline-block;height: 16px;margin: 0;vertical-align: middle;width: 25px;} 
    .dselect { background: url(/images/select11.png) no-repeat 0 0; cursor: pointer; width: 112px; height: 22px; position: relative; vertical-align: middle; z-index: 2; margin-left:143px; margin-top:10px; }
    .dselect_over { background-position: 0 -22px; }
    .dselect .text { border:none; font: 14px/22px arial; display: block; width: 92px; height: 22px; overflow: hidden; padding: 0 10px; color: #666; text-align:left }
    .dselect .list { background: #f4f4f0; border: solid 2px #ccc; border-top:none; position: absolute; width:108px; }
    .dselect .list li {   font: 12px/24px arial;padding: 0 8px;  text-align:left ; font: 14px/22px arial; }
    .dselect .list li.sel { background: #ddd; }
    .dbutton { padding: 0 10px; margin-top:10px; vertical-align: middle;  }
    .dbutton input { background-color:#b10303; width: 112px; height: 28px; border: none; font-weight: bold;font-size: 18px; color: #fff; cursor: pointer; }
    .close_btn3 {right: 10px;top: 10px;background: url("/images/icons.png") no-repeat scroll -34px -568px transparent;cursor: pointer;display: inline-block;height: 24px;position: absolute;width: 24px;}
    .dnoborder{ border:none}
    .dnoborder a{ font-size:12px; font-weight:bold; text-decoration:underline;}
</style>

<div class="JS_popwincon1 dwrapper" id="lang_change" style="display:none;">
    <a class="JS_close2 close_btn3" id="lang_close"></a>
    <div class="dcontent">
        <div class="dwrap">
          <p><img src="/images/daoliu.jpg"></p>
        </div>
        <form action="/site/change_country" method="post">
            <?php $request = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/'; ?>
            <input type="hidden" name="request" value="<?php echo $request; ?>" />
            <input type="hidden" id="lang_code" name="lang_code" value="<?php echo $def_country; ?>" />
            <input type="hidden" id="currency_code" name="currency_code" value="<?php echo $def_currency; ?>" />
            <div class="dwrap search_box">
                <div>Please select the store you would like to visit</div>
                <div class="dselect" style="z-index:99">
                    <?php
                    $countrys = array(
                        'en' => 'English',
                        'de' => 'German',
                        'fr' => 'French',
                        'es' => 'Spanish',
                        'ru' => 'Russian',
                    );
                    foreach($currencys as $key => $currency)
                    {
                        if(strpos($currencys[$key]['code'], '$') !== FALSE)
                        {
                          $currencys[$key]['code'] = '$';
                        }
                    }
                    ?>
                    <span class="text"><?php echo $countrys[$def_country]; ?> Site</span>
                    <div class="list" style="display:none;" id="select_lang">
                        <ul>
                            <?php
                            foreach ($countrys as $cname => $title)
                            {
                                ?>
                                <li title="<?php echo $cname; ?>"><?php echo $title; ?> Site</li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="dselect">
                    <div class="text"><span class="icon_flag icon_<?php echo strtolower($def_currency); ?>"></span><?php echo $currencys[$def_currency]['code'] . $def_currency; ?></div>
                    <div class="list" style="display:none;" id="select_currency">
                        <ul>
                        <?php
                        foreach($currencys as $currency)
                        {
                        ?>
                            <li title="<?php echo $currency['name']; ?>"><span class="icon_flag icon_<?php echo strtolower($currency['name']); ?>"></span><?php echo $currency['code'] . $currency['name']; ?></li>
                        <?php
                        }
                        ?>
                        </ul>
                    </div>
                </div>
                <div class="dbutton"><input name="" type="submit" value="GO"></div>
                <div>
                    <input name="remember" type="checkbox" id="remember"/>
                    <label for="remember" class="dleb">Remember your preference</label>
                </div>
            </div>
            <div class="dwrap dnoborder"><a class="JS_close2" id="stay_on">STAY ON THIS SITE>></a></div>  
        </form>
    </div>
</div> 
<script>
    $(function(){
        $("#select_lang li").click(function(){
            var title = $(this).attr('title');
            $("#lang_code").val(title);
        })
        $("#select_currency li").click(function(){
            var title = $(this).attr('title');
            $("#currency_code").val(title);
        })
        $("#lang_close, #stay_on").click(function(){
            $.ajax({
                url:'/site/change_country',
                type:'POST',
                data:{
                    lang_close: 1,
                },
                success:function(rs){
                }
            });
        })
    })
    $(function(){ 
        $(".search_box .dselect").hover( function () {
            $(this).addClass("dselect_over");
        },function () {
            $(this).removeClass("dselect_over");
        }).on('click',function(){
            var _this = $(this),
            _bthis = $(this).find(".list");
            if ( _this.attr('isopen') ) {
                _bthis.slideUp(200 , function(){
                    _this.removeAttr('isopen');
                });     
            } else {
                _bthis.slideDown(200,function(){
                    _this.attr('isopen',"1");
                }); 
            }
        }).on('mouseleave',function(){
            var _thisa = $(this).find(".list"),
            _this = $(this);
            _thisa.hide();
            _this.removeAttr('isopen');
        }),$(this).find(".list li").hover( function (){
            $(this).addClass("sel");    
        },function (){
            $(this).removeClass("sel"); 
        }).on('click',function(){
            var _this = $(this).html();
            var _thisText = $(this).closest(".dselect").find(".text");
            _thisText.html(_this);
        })
    });

    $(function(){
        $('body').append('<div class="JS_filter1 opacity"></div>');
        $('#lang_change').appendTo('body').fadeIn(320);
        $('#lang_change').show();
        return false;
    })

    $(".JS_close2,.JS_filter1").live("click",function(){
        $(".JS_filter1").remove();
        $('.JS_popwincon1').fadeOut(160);
        return false;
    })
</script>