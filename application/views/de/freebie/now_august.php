<?php
date_default_timezone_set('America/Chicago');
?>
<div id="container">
        <div id="main">
                <?php echo Message::get(); ?>
                <!--add activity start-->
                <div class="activity">
                        <div class="activity_countdown fix mt10">
                                <div class="activity_hours" id="activity_hours"></div>
                                <div class="activity_minutes" id="activity_minutes"></div>
                                <div class="activity_seconds" id="activity_seconds"></div>
                        </div>
                        <?php
                        $loginUrl = '/customer/login';
                        if (class_exists('facebook') AND Site::instance()->get('fb_login') == 1):
                                $page = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'];
                                $facebook = new facebook();
                                $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                        endif;
                        ?>
                        <div class="fix mt10"><img src="/images/freebie/activity_img11.jpg" alt="" usemap="#Map" />
                                <map name="Map" id="Map">
                                        <area shape="rect" coords="52,127,314,176" href="<?php echo $loginUrl; ?>" alt="" />
                                        <area shape="rect" coords="52,185,495,236" href="https://www.facebook.com/sharer/sharer.php?u=https://www.facebook.com/choiescloth" target="_blank" alt="" />
<!--                                        <area id="start" shape="rect" coords="499,241,695,298" href="<?php echo $start ? '/freebie/start' : '#' ; ?>" alt="" />-->
                                        <area shape="rect" coords="499,241,695,298" href="<?php echo LANGPATH; ?>/freebie/start" alt="" />
                                </map>
                                <div class="like">
                                        <div id="fb-root"></div>
                                        <script>(function(d, s, id) {
                                                var js, fjs = d.getElementsByTagName(s)[0];
                                                if (d.getElementById(id)) return;
                                                js = d.createElement(s); js.id = id;
                                                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                                                fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));</script>

                                        <div class="fb-like" data-href="http://www.facebook.com/choiescloth" data-send="false" data-width="450" data-show-faces="false" data-font="arial"></div>
                                </div>
                        </div>
                </div>
                <!--add activity end-->
                
        </div>
        <div id="aside">
                <?php echo View::factory('/freebie/freebie_left'); ?>
        </div>
</div>
<script type="text/javascript">
var temp_src;
$(".list5 .pic img").hover(function(){
        temp_src = $(this).attr("src");
        $(this).attr("src",temp_src.replace(".jpg","_1.jpg"))
},function(){
        $(this).attr("src",temp_src);
})
</script>
<script type="text/javascript">
function dothis()
{
        if(navigator.appName.indexOf("Explorer") > -1)         
                var text = document.getElementById("pro_quantity").innerText;
        else
                var text = document.getElementById("pro_quantity").textContent;
        /*	
        do
        {
                text--;
                document.getElementById("pro_quantity").innerHTML = text;
        }
        while(text>0)
         */
}
</script>
<script type="text/javascript">
startclock();
var timerID = null;
var timerRunning = false;
function showtime() {
        Today = new Date();//开始的时