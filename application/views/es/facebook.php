<?php
$from_facebook = 0;
$referer = $_SERVER['HTTP_REFERER'];
$code = $_GET['code'];
if(strlen($code) == 323)
        $from_facebook = 1;
?>
<script type="text/javascript" src="/js/facebook_login.js"></script>
<div id="container">
        <div class="icontainer">
                <?php
                $skus = array('CSDL2136','CSDL1367','CDDL0424','CHLS0665','CSDL2135');
                $key = 1;
                foreach($skus as $sku):
                        $product_id = Product::get_productId_by_sku($sku);
                ?>
                <img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 1); ?>" />
                <input type="submit" value="Free Trial" title="<?php echo $product_id; ?>" class="form_btn" id="free<?php echo $key; ?>" onclick="show_facebook_div('<?php echo $product_id; ?>','1');return false;">
                <br/>
                <br/>
                <?php
                        $key ++;
                endforeach;
                ?>
<!--                <script type="text/javascript">
                        <?php
                        $page = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/review/facebook';
                        $facebook = new facebook();
                        $loginUrl = $facebook->getLoginUrl(
                                array(
                                    'display' => 'popup',
                                    'next' => $page . '?loginsucc=1',
                                    'cancel_url' => $page . '?cancel=1',
                                    'req_perms' => 'email,user_birthday',
                                ));
                        ?>
                        var href = '<?php echo $loginUrl; ?>';
                        function openfacebook(e)
                        {
                                lleft=screen.width/2-245;
                                ttop=200;
                                pWin = window.open(href,"","toolbar=1,location=1,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,top="+ttop+",left="+lleft+",width=500,height=250");
                        }
                        $(function(){
                                var from_facebook = <?php echo $from_facebook; ?>;
                                if(from_facebook)
                                {
                                        self.close();
                                }
                                if(pWin == null){
                                        alert('closed!!');
                                }
                        })
                </script>-->
                <div class="trial_body" id="trial_body" style="display: block;">
                        
                        <div style="position:relative;">
                                <a class="trial_close" title="Close" href="javascript:void(0);" onclick="make_div_hiden('trial_body');">close</a>
                                <div class="trial_content">
                                        <h2 class="erial_h2" id="erial_h2_1" style="display: none;">Complete a few tasks,you'll have an extra <strong>5%</strong> off!</h2>
                                        <h2 class="erial_h2" id="erial_h2_2">Complete the following tasks,you'll have the chance to win!</h2>
                                </div>
                                <div class="trial_content">
                                        <div class="trial-main trial_o">
                                                <dl>
                                                        <dt><img src="http://www.sheinside.com/images/trial_01.gif"></dt>
                                                        <dd><p>Like us on facebook</p></dd>
                                                        <dd>
                                                                <img src="http://www.sheinside.com/images/trial_03.gif">
                                                                <span>She Insider</span>
                                                                        
                                                                <div class="trial_facebook_like">
                                                                        <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FSheinside&amp;send=false&amp;layout=button_count&amp;width=80&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=405259832822346" scrolling="no" frameborder="0" style="border:none;overflow:hidden;float:right;width:80px;margin-top:4px; margin-right:20px;height:21px;" allowtransparency="true"></iframe>
                                                                </div>
                                                        </dd>
                                                </dl>
                                                <p id="trial_facebook_like_error" class="trial_facebook_p" style="display: block;">You have to like first(Step 1).</p>              
                                        </div>
                                </div>
                                        
                                <div class="trial_content" style="margin-bottom:30px;background:none;">
                                        <div class="trial-main trial_t">
                                                <dl>
                                                        <dt><img src="http://www.sheinside.com/images/trial_02.gif"></dt>
                                                        <dd><p>Share this item!</p></dd>
                                                        <dd class="trial_facebook_send"><a class="face_share_t" href="javascript:void(0);" onclick="show_facebook_div_to();"></a></dd>
                                                </dl>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>