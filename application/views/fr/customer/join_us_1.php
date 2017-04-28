<div id="container">
        <div class=" fix">
                <div id="main">
                        <div class="crumb"><a href="<?php echo LANGPATH; ?>/" class="home">Accueil</a>&gt;<span class="current">Join Us</span></div>
                        <?php
                                $domain = Site::instance()->get('domain');
                                $redirect = '?redirect=/contact-us';
                        ?>
                        <div class="help">
                                <div class="step-corp step-corp2"><img src="/images/setp-corp2.jpg" alt="" /></div>
                                <div class="corp-con">
                                        <h4>2.Choose your favorite Choies VIP icon,add the code to your blog.</h4>
                                        <h4><span  class="headline">Lace Vip Icon</span></h4>
                                        <h4>250*250</h4>
                                        <div><a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/images/follow4.jpg" title="follow4" alt="Choies-The latest street fashion" /></a></div>
                                        <h4>300*250</h4>
                                        <div><a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/images/follow5.jpg" title="follow5" alt="Choies-The latest street fashion" /></a></div>
                                        <h4>300*300</h4>
                                        <div><a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/images/follow6.jpg" title="follow6" alt="Choies-The latest street fashion" /></a></div>
                                        <h4>Logo</h4>
                                        <div><a class="join_us" href="#"><img src="http://<?php echo $domain; ?>/images/logo.gif" title="Choies" alt="Choies-The latest street fashion" /></a></div>
                                </div>
                                <div class="tar mt20">
                                <?php
                                if($customer_id = Customer::instance()->logged_in())
                                {
                                        echo '<a href="<?php echo LANGPATH; ?>/contact-us"><img src="/images/next.jpg" alt="" /></a>';
                                }
                                else
                                {
                                        echo '<a id="next" href="#"><img src="/images/next.jpg" alt="" /></a>';
                                }
                                ?>
                                </div>
                        </div>
                        <div class="help" id="site_login" style="display:none;">
                                <div class="corp-con">
                                        <div class="corp-con-box">
                                                <div class="corp-con-box-tip">
                                                        <p>Get your own  account fisrt before next step.
                                                                Please <a style="text-decoration:underline;color:#FD7E07" href="<?php echo LANGPATH; ?>/customer/login<?php echo $redirect; ?>">login</a> or <a style="text-decoration:underline;color:#FD7E07" href="<?php echo LANGPATH; ?>/customer/register<?php echo $redirect; ?>">register</a></p>
                                                        <form id="" method="post"  action="" >
                                                                <div class="tac mt20 btn"> <a href="<?php echo LANGPATH; ?>/customer/login<?php echo $redirect; ?>">Login</a><a href="<?php echo LANGPATH; ?>/customer/register<?php echo $redirect; ?>">Register</a> </div>
                                                        </form>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
                <div id="aside">
                        <div class="nav-sub">
                                <?php foreach ($catalogs as $catalog): ?>
                                        <h3><?php echo $catalog->name; ?></h3>
                                        <ul>
                                                <?php foreach (Catalog::instance($catalog->id)->children() as $sub_catalog): ?>
                                                        <li><a href="<?php echo Catalog::instance($sub_catalog)->permalink(); ?>"><?php echo Catalog::instance($sub_catalog, LANGUAGE)->get('name'); ?></a></li>
                                                <?php endforeach; ?>
                                        </ul>
                                <?php endforeach; ?>
                        </div>
                </div>
                <div id="site_link" class="" style="padding-bottom: 50px; padding-right: 50px; width: 422px; height: 318px; top: 15px; left: 438.5px;">
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
                                                <div class="closebtn" class="">close</div>
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
        </div>
</div>
<script type="text/javascript">
        var domain = "<?php echo $domain; ?>";
        $(function(){
                $(".join_us").live("click",function(){
                        var follow = $(this).children().attr('title');
                        var img = '<img src="http://'+domain+'/images/'+follow+'.jpg" title="Choies" alt="Choies-The latest street fashion" />'
                        var link_text = '<a href="http://' + domain + '">' + img + '</a>';
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