<?php
$domain = Site::instance()->get('domain');
$redirect = '?redirect=/contact-us';
$customer_id = Customer::logged_in();
$celebrity = Customer::instance($customer_id)->is_celebrity();
?>
<section id="main">
    <div class="layout" style="margin-top:30px;background: #fff;">
        <div class="tit blogger_wanted mb25">
            <span>Модные программы</span><span>Читать политики</span><span>Представить информацию</span><span class="on">Получить Баннер</span>
            <img src="/images/<?php echo LANGUAGE; ?>/blogger_wanted4.png" />
        </div>  
        <div class="fashion_tit">ПОЛУЧИТЬ БАННЕР</div>
        <div class="fashion_policy">
            <p>Выберите ваш любимый Choies VIP-значок, нажмите изображение, чтобы получить код.</p>
            <p>Если вы согласны, чтобы добавить Choies баннер на главной странице вашего блога, странице лукбука, или других сайтах модных платформ , вы будете получить больше на халяву, если у вас больше поклонников.</p>
            <p>Если у вас есть свой аккаунт на youtube, где баннер не допускается, вы можете использовать нашу ссылку <a href="<?php echo LANGPATH; ?>/" title="choies.com" class="red"> http://<?php echo $domain; ?></a> .</p>
        </div>
        <!--    <div class="banner_area">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>250*250</td>
                        <td>250*250</td>
                    </tr>
                </table>
            </div>-->
        <div class="banner_area mt20">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
				<a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/uploads/1/files/<?php echo $index_banners[0]['image']; ?>" title="<?php echo $index_banners[0]['title']; ?>" alt="Choies-The latest street fashion" width="300" height="250"/></a>
				</td>
                <td><a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/uploads/1/files/<?php echo $index_banners[3]['image']; ?>" title="<?php echo $index_banners[3]['title']; ?>" alt="Choies-The latest street fashion" width="300" height="250"/></a></td>
            </tr>
                <tr>
                    <td>300*250</td>
                    <td>300*250</td>
                </tr>
            </table>
        </div>
        <div class="banner_area mt20">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/uploads/1/files/<?php echo $index_banners[4]['image']; ?>" title="<?php echo $index_banners[4]['title']; ?>" alt="Choies-The latest street fashion" width="300" height="300"/></a></td>
                <td><a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/uploads/1/files/<?php echo $index_banners[5]['image']; ?>" title="<?php echo $index_banners[5]['title']; ?>" alt="Choies-The latest street fashion" width="300" height="300"/></a></td>
            </tr>
                <tr>
                    <td>300*300</td>
                    <td>300*300</td>
                </tr>
            </table>
        </div>
        <div class="banner_area mt20">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/uploads/1/files/<?php echo $index_banners[6]['image']; ?>" title="<?php echo $index_banners[6]['title']; ?>" alt="Choies-The latest street fashion" width="728" height="90" style="display:block;" class="mb10"/></a>
                    <a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/uploads/1/files/<?php echo $index_banners[7]['image']; ?>" title="<?php echo $index_banners[7]['title']; ?>" alt="Choies-The latest street fashion" width="728" height="90" style="display:block;" class="mb10"/></a>
                </td>
            </tr>
                <tr>
                    <td>728*90</td>
                </tr>
            </table>
        </div>
        <div class="banner_area mt20">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/uploads/1/files/<?php echo $index_banners[8]['image']; ?>" title="<?php echo $index_banners[8]['title']; ?>" alt="Choies-The latest street fashion" width="160" height="600" class="mr10"/></a>
                    <a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/uploads/1/files/<?php echo $index_banners[9]['image']; ?>" title="<?php echo $index_banners[9]['title']; ?>" alt="Choies-The latest street fashion" width="160" height="600" class="mr10"/></a>
                    <a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/uploads/1/files/<?php echo $index_banners[10]['image']; ?>" title="<?php echo $index_banners[10]['title']; ?>" alt="Choies-The latest street fashion" width="160" height="600" class="mr10"/></a>
                </td>
            </tr>
                <tr>
                    <td>160*600</td>
                </tr>
            </table>
        </div>
    </div>
    <div id="site_link" style="padding-bottom: 50px; padding-right: 50px; width: 422px; height: 318px; top: 15px; left: 438.5px; display:none;">
        <div id="cboxWrapper" style="height: 368px; width: 472px;"><div>
                <div id="cboxTopLeft" style="float: left;"></div>
                <div id="cboxTopCenter" style="float: left; width: 422px;"></div>
                <div id="cboxTopRight" style="float: left;"></div></div>
            <div style="clear: left;"><div id="cboxMiddleLeft" style="float: left; height: 318px;"></div>
                <div id="cboxContent" style="float: left; width: 422px; height: 318px;">
                    <div id="cboxLoadedContent" style="display: block; width: 422px; overflow: auto; height: 298px;">
                        <div style="padding:10px; background:#fff;" id="inline_example2">
                            <textarea id="site_image" onmousemove="this.select(),this.focus();" cols="" rows="" name="" style="width: 380px; height: 270px; font-size:15px;"></textarea>
                        </div>
                    </div>
                    <div class="closebtn" class="" style="right: 43px;">close</div>
                </div>
                <div id="cboxMiddleRight" style="float: left; height: 318px;"></div>
            </div>
            <div style="clear: left;">
                <div id="cboxBottomLeft" style="float: left;"></div>
                <div id="cboxBottomCenter" style="float: left; width: 422px;"></div>
                <div id="cboxBottomRight" style="float: left;"></div>  
            </div>
        </div>
        <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
    </div>
</section>
<script type="text/javascript">
    var domain = "<?php echo $domain; ?>";
    var cidb = "<?php echo $celebrity ? '?cidb=' . $celebrity : ''; ?>";
    var langpath = '<?php echo LANGPATH; ?>';
    $(function(){
        $(".join_us").live("click",function(){
            var follow = $(this).children().attr('src');
            var img = '<img src="'+follow+'" title="Choies" alt="Choies-The latest street fashion" />'
            var link_text = '<a href="http://' + domain + langpath + cidb + '">' + img + '</a>';
            $("#site_image").val(link_text);
            $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
            $('#site_link').appendTo('body').fadeIn(320);
            return false;
        })
                
        $("#next").live('click', function(){
            $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
            $('#site_login').appendTo('body').fadeIn(320);
            return false;
        })
    })
        
    $(function(){
        $("#site_link .closebtn,#wingray").live("click",function(){
            $("#wingray").remove();
            $('#site_link').fadeOut(160).appendTo('#tab2');
            $('#site_login').fadeOut(160).appendTo('#tab2');
            return false;
        })
    })
    $(function(){
        $(".technical dd:even").css('background-color','#313131');
        return this;
    })
</script>