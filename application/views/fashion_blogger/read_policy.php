<?php if (!Customer::logged_in()): ?>
    <script type="text/javascript">
        $(function(){
            $("#agree").live("click", function(){
                $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                $('#catalog_link').appendTo('body').fadeIn(320);
                $('#catalog_link').show();
                return false;
            })
                        
            $("#catalog_link .clsbtn,#wingray").live("click",function(){
                $("#wingray").remove();
                $('#catalog_link').fadeOut(160).appendTo('#tab2');
                return false;
            })
        })
    </script>
<?php endif; ?>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  Blogger Wanted</div>
        </div>
    </div>
    <section class="layout fix">
        <div class="tit blogger_wanted mb25"><img src="/images/blogger_wanted2.png" /></div> 
        <article id="container" style="margin-top:30px;background: #fff;">
            <div class="fashion_policy" style="border-bottom:#CCC 1px dashed;">
                <h3>FASHION BLOGGER:</h3>
                <p>No matter you are a cool girl loving fashion, or a fashion blogger, always show your forward fashion taste as a free-thinking girl.</p>
                <p>By applying to the Choies.com Fashion Blogger program. Our bloggers benefit from special discounts and free products direct from our new product lines.</p>
                <p>Don't hesitate to send us an email(<a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>) about yourself.</p>
            </div>
            <div class="fashion_policy mt20" style="border-bottom:#CCC 1px dashed;">
                <p>How to Join CHOIES Fashion Blogger?</p>
                <h3>1. Are you a blogger who focuses on current fashion and style?</h3>
                <p>CHOIES now has been collaborating with many famous bloggers and will be honored to have you in our fashion programme. </p>
                <h3>Qualification:</h3>
                <p>  1. You believe you have a taste for fashion and are influential in your personal blog, Facebook page, YouTube, <span class="red1">Chicisimo</span> etc,</p>
                <p>  2. You blog about fashion frequently, at least once a week.</p>
                <p>&nbsp;</p>
                <h3>2. What should I do to start?</h3>
                <p>You have to register first in www.choies.com and put up our banner on your blog. You can get banner code by clicking "I agree". Inform us of your register email, we will add points to your account.</p>
                <p>&nbsp;</p>
                <h3>3. What rule should I follow to get my points renewed?</h3>
                <p>Usually you need to show our products within 7days and send me the link of your blog post. There should be a corresponding product link below the product you wear on your blog instead of the main page only unless the product you show has run out of stock. <span class="red1">Extra points if you share your look on Chicisimo.com and include a link to choies.com.</span></p>
                <p>&nbsp;</p>
                <h3>4. How often do you give reward to different bloggers?</h3>
                <p>Usually we give points to bloggers as reward which you can use in our shop. We will renew their points when they make outfits on their blog and as many social platforms as possible and send us the post link.</p>
                <p>&nbsp;</p>
                <h3>5. Do I have to pay customs?</h3>
                <p>Custom policy differs from different countries. For example, Bloggers from Brazil have to provide us their tax number and pay tax. It depends on the policy of your country.</p>
                <p>&nbsp;</p>
                <h3>6. Are there other ways to get more points?</h3>
                <p>Yes, you can get more points by writing blog post featuring CHOIES or hold giveaways for choies and send us the link.</p>
                <p>&nbsp;</p>
                <h3>7. Please register on choies.com first before doing anything else.</h3>
                <p>You cannot use the points unless you have been registered.</p>
            </div>
            <div class="fashion_policy mt20">
                <h3>About the copyright of your photos</h3>
                <p>We have the right to put photos from your blog on our facebook, instagram page and our other official pages.</p>
                <p>If you have any other questions about fashion blogger programme, you can email to <a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>.</p>
                <p>&nbsp;</p>
                <p>We will check it in a week and reply if you are approved.</p>
                <p>If you agree with all the terms above, clicks agree to continue.</p>
                <div class="form_btn mt20 mb10" id="agree">
                    <p><a href="<?php echo LANGPATH; ?>/blogger/submit_information"><strong class="view_btn btn26 btn40" style="width: 100px;">I Agree</strong></a></p>
                </div>
            </div>
        </article>
    </section>
</section>
<div class="hide" id="catalog_link" style="position: fixed;padding: 10px 10px 20px; top: 0px;left: 400px;width: 640px;height: 230px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:#CCC 1px solid;">
    <div class="order order_addtobag">
        <div class="fashion_thank">
            <h4>Get your own account first before next step.<br/>
                Please login or register.</h4>
            <div class="2btns">
                <span class="form_btn mr10"><a href="<?php echo LANGPATH; ?>/customer/login?redirect=/blogger/submit_information" title="Log In"><strong class="view_btn btn26 btn40" style="width: 100px;">Log In</strong></a></span>
                <span class="form_btn"><a href="<?php echo LANGPATH; ?>/customer/register?redirect=/blogger/submit_information" title="REGISTER"><strong class="view_btn btn26 btn40" style="width: 100px;">REGISTER</strong></a></span>
            </div>
        </div>
    </div>
    <div class="clsbtn" style="right: -0px;top: 3px;"></div>
</div>