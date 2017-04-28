<link type="text/css" rel="stylesheet" href="/css/giveaway.css" media="all" />
<script type="text/javascript" src="/js/catalog.js"></script>
<script type="text/javascript">
        $(function(){
                var step = '<?php echo $step; ?>';
                if(step != '')
                {
                        location.href = '#step' + step;
                }
                $("#loginLink,#registerLink").click(function(){
                        $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                        $('#catalog_link').appendTo('body').fadeIn(320);
                        $('#catalog_link').show();
                        return false;
                })
                
                $("#catalog_link .closebtn,#wingray").live("click",function(){
                        $("#wingray").remove();
                        $('#catalog_link').fadeOut(160).appendTo('#tab2');
                        return false;
                })
                
                $("#product input").click(function(){
                        var sku = $(this).val();
                        $("#sku").val(sku);
                        location.href = '#step3';
                })
        })
        function addTags()
        {
                var itemOriginal =document.getElementsByName("tagsInput");
                var arr = new Array(itemOriginal.length);
                for(var j = 0; j < itemOriginal.length;j++){
                        arr[j] = itemOriginal.item(j).value;
                }
         
                var str = "<table><tr><td><input type='url' name='urls[]' id='url2' class='allInput mt5' style='width:509px;' value='' maxlength='390' /></td></tr></table>";
                document.getElementById("tags").innerHTML += str;
                var itemNew =document.getElementsByName("tagsInput");
                for(var i=0;i<arr.length;i++)
                {
                        itemNew.item(i).value = arr[i];
                }
        }
        function showTags(){
                var item=document.getElementsByName("tagsInput");
                for(var i=0;i<item.length;i++)
                {
                        document.getElementById("showTags").innerHTML += item[i].value + " ";
                }
        }
</script>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Giveaway</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
                        <!--hgiveaway star-->
                        <div class="giveaway">
                                <div>
                                        <img src="/images/activity/winer_list1.jpg" alt="winners" title="winners" style="display:block;"/>
                                        <img src="/images/activity/winer_list2.jpg" alt="winners" title="winners" style="display:block;"/>
                                </div>
<!--                                <div><img src="/images/activity/giveaway1.jpg" /></div>
                                <div class="step1">
                                        <?php if(Customer::logged_in()): ?>
                                        <div class="successText pl90">YOU ARE IN NOW!</div>
                                        <?php else: ?>
                                        <div class="fix pl90">
                                                <span class="btn1 fll"><a href="#" id="loginLink"><strong> LOG IN </strong></a></span> 
                                                <span class="fll mr5 ml5">or</span> 
                                                <span class="btn2 fll"><a href="#" id="registerLink"><strong>REGISTER</strong></a></span> 
                                                <span>&nbsp;to Enter this Giveaway.</span> 
                                        </div>
                                        <?php endif; ?>
                                </div>
                                <a name="step2"><img src="/images/null.png" /></a>
                                <div class="step2">
                                        <div class="tit"></div>
                                        <p class="pl90 remark mb5">Please Chseck the Optional Gifts, and Choose Your Favorite One.</p>
                                        <h3 class="pl90"><strong>TIPS:</strong></h3>
                                        <p class="pl90 fll">1. Don’t forget to click the button</p>
                                        <div class="clickImg fll">&nbsp;</div>
                                        <p class="fll">to mark your favorite item.</span></p>
                                        <p class="pl90 clear">2. Please ignore the sizes in this page, we will email you for your personal size if you finally win.</p>
                                        <div class="pro pl90">
                                                <ul id="product">
                                                        <li><a href="#" title="CTZY0131"><img src="http://www.choies.com/pimages/36249/1.jpg" alt="CTZY0131" title="CTZY0131"/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CTZY0131" name="SKU" />
                                                                        CTZY0131
                                                                </div>
                                                        </li>
                                                        <li><a href="#" title="CDDL0188"><img src="http://www.choies.com/pimages/13745/1.jpg" alt="CDDL0188"/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CDDL0188" name="SKU" />
                                                                        CDDL0188
                                                                </div>
                                                        </li>
                                                        <li><a href="#" title="CSDL1820"><img src="http://www.choies.com/pimages/30139/1.jpg" alt="CSDL1820 "/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CSDL1820" name="SKU" />
                                                                        CSDL1820
                                                                </div>
                                                        </li>
                                                        <li><a href="#" title="CDWC1087"><img src="http://www.choies.com/pimages/31783/1.jpg" alt="CDWC1087"/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CDWC1087" name="SKU" />
                                                                        CDWC1087
                                                                </div>
                                                        </li>
                                                        <li><a href="#" title="CSWC1210"><img src="http://www.choies.com/pimages/32759/1.jpg" alt="CSWC1210"/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CSWC1210" name="SKU" />
                                                                        CSWC1210
                                                                </div>
                                                        </li>
                                                        <li><a href="#" title="CDDL2231"><img src="http://www.choies.com/pimages/33594/1.jpg" alt="CDDL2231"/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CDDL2231" name="SKU" />
                                                                        CDDL2231
                                                                </div>
                                                        </li>
                                                        <li><a href="#" title="CDDL0457"><img src="http://www.choies.com/pimages/18448/1.jpg" alt="CDDL0457 "/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CDDL0457" name="SKU" />
                                                                        CDDL0457
                                                                </div>
                                                        </li>
                                                        <li><a href="#" title="CDDL0292"><img src="http://www.choies.com/pimages/15833/1.jpg" alt="CDDL0292  "/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CDDL0292" name="SKU" />
                                                                        CDDL0292 
                                                                </div>
                                                        </li>
                                                        <li><a href="#" title="CDDL0424"><img src="http://www.choies.com/pimages/36693/1.jpg" alt="CDDL0424"/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CDDL0424" name="SKU" />
                                                                        CDDL0424
                                                                </div>
                                                        </li>
                                                        <li><a href="#" title="CKWC1351"><img src="http://www.choies.com/pimages/33753/1.jpg" alt="CKWC1351"/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CKWC1351" name="SKU" />
                                                                        CKWC1351
                                                                </div>
                                                        </li>
                                                        <li><a href="#" title="CSZY0011"><img src="http://www.choies.com/pimages/42483/1.jpg" alt="CSZY0011"/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CSZY0011" name="SKU" />
                                                                        CSZY0011
                                                                </div>
                                                        </li>
                                                        <li><a href="#" title="CSDL2281"><img src="http://www.choies.com/pimages/34043/1.jpg" alt="CSDL2281"/></a>
                                                                <div class="sku mt5">
                                                                        <input type="radio" value="CSDL2281" name="SKU" />
                                                                        CSDL2281
                                                                </div>
                                                        </li>
                                                </ul>
                                        </div>
                                </div>
                                <a name="step3"><img src="/images/null.png" /></a>
                                <div class="step3">
                                        <div class="tit"></div>
                                        <p class="pl90 remark mb5">Share this Giveaway to Your BFF and leave your share URL / links.</p>
                                <?php
                                if($success == 0)
                                {
                                        ?>
                                        <form id="giveawayForm" method="post" action="" class="formArea pl90">
                                                <ul class="pt10 mt5">
                                                        <li>
                                                                <label for="name"><span>*</span> NAME:</label>
                                                                <input type="text"name="name" id="name" class="allInput" value="" maxlength="340" />
                                                                <div class="errorInfo"></div>
                                                        </li>
                                                        <li>
                                                                <label for="sku"><span>*</span> SKU:</label>
                                                                <input type="text" name="sku" id="sku" class="allInput" value="" maxlength="340" />
                                                                <div class="errorInfo"></div>
                                                        </li>
                                                        <li>
                                                                <label for="giveawaw_comment"><span>*</span> Comment:</label>
                                                                <textarea name="comment" id="giveawaw_comment" rows="10" class="input textarea fll"onblur="this.value=(this.value=='')?'Comment on your favorite item. ':this.value" value="Comment on your favorite item. " onfocus="this.value=(this.value=='Comment on your favorite item. ')?'':this.value">Comment on your favorite item. </textarea>
                                                                <div class="errorInfo"></div>
                                                        <li>
                                                                <label for="sku" style="display:block; width:100%; margin:0;" ><span>*</span> Share URL/Links: ( <em>More Share links, more chances to win! </em>) <span class="ml10">Please leave the share links.</span></label>
                                                                <br/>
                                                                <table>
                                                                        <tr>
                                                                                <td><input type="url" name="url" id="url2" class="allInput mt5" style="width:509px;" value="" maxlength="390" /></td>
                                                                        </tr>
                                                                </table>
                                                                <table>
                                                                        <tr>
                                                                                <td><input type="url" name="urls[]" id="url2" class="allInput mt5" style="width:509px;" value="" maxlength="390" /></td>
                                                                        </tr>
                                                                </table>
                                                                <table>
                                                                        <tr>
                                                                                <td><input type="url" name="urls[]" id="url2" class="allInput mt5" style="width:509px;" value="" maxlength="390" /></td>
                                                                        </tr>
                                                                </table>
                                                                <div id="tags"></div>
                                                                <table cellpadding="1" cellspacing="0" style="text-align: center; display:block;" class="mt10">
                                                                        <tr>
                                                                                <td><input type="button" name="Submit" class="add_more"  value="add one more site" onclick="addTags()" />
                                                                                        <input name='txtTDLastIndex' type='hidden' id='txtTDLastIndex' value="2" /></td>
                                                                                <td><input name='txtTRLastIndex' type='hidden' id='txtTRLastIndex' value="1" /></td>
                                                                        </tr>
                                                                </table>
                                                        </li>
                                                </ul>
                                                <div class="shareto mt10">
                                                        <div class="fix mt15 ml10">
                                                                <?php
                                                                $domain = Site::instance()->get('domain');
                                                                ?>
                                                                <div class="fll mr10"><strong>SHARE TO:</strong></div>
                                                                <div class="fll mr10 ml5"><span class="shareto1 fll"></span>
                                                                        <a rel="nofollow" target="_blank" href="http://www.facebook.com/sharer.php?u=http%3A%2F%2F<?php echo $domain; ?>%2Factivity%2Fgiveaway"> FACEBOOK</a>                                                                </div>
                                                                <div class="fll mr10 ml5"><span class="shareto2 fll"></span><a rel="nofollow" target="_blank" href="http://twitter.com/share?url=http%3A%2F%2F<?php echo $domain; ?>%2Factivity%2Fgiveaway"> TWITTER</a></div>
                                                                <div class="fll mr10 ml5"><span class="shareto3 fll"></span><a rel="nofollow" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode('http://www.choies.com/activity/giveaway'); ?>&media=http://www.choies.com/images/activity/giveaway1.jpg&description=giveaway"> PIN IT</a></div>
                                                        </div>
                                                        <p class="remark ml10">Or you can share to your personal blogs and any other social network. Just leave the share URL / Links above.</p>
                                                </div>
                                                <div>
                                                        <input type="submit" class="submit_btn" value="SUBMIT"/>
                                                </div>
                                        </form>
                                        <script type="text/javascript">
                                                $("#giveawayForm").validate($.extend(formSettings,{
                                                        rules: {
                                                                name:{required: true},
                                                                sku:{required: true},
                                                                comment: {required: true,minlength: 5},
                                                                url: {required: true}
                                                        }
                                                }));
                                        </script>
                                <?php
                                }
                                elseif($success == 1)
                                {
                                        ?>
                                        <div class="successText pl90">YOU HAVE SUCCESSFULLY SUBMITTED A COMMENT.</div>
                                        <?php
                                }
                                ?>
                                </div>
                                <a name="step4"><img src="/images/null.png" /></a>
                                <div class="step4">
                                        <div class="tit"></div>
                                        <p class="pl90 remark mb5">Enter Choies facebook APP for the Lucky Draw.</p>
                                        <div class="fblink"><a href="https://www.facebook.com/choiescloth/app_200328890006489" target="_blank"><strong> Enter the Lucky Draw</strong></a></div>
                                        <span class="red" style="margin-left: 88px;">(* To Get the Chance to win, you must take part in the Lucky Draw!)</span>
                                </div>
                                <div class="goodluck">GOOD LUCK!</div>-->
                                <a name="step5"><img src="/images/null.png" /></a>
                                <div class="comments">
                                        <div style="height:34px; border-bottom:#CCC 1px solid;"> <span class="tit fll">COMMENTS</span></div>
                                        <?php
                                        foreach($comments as $comment):
                                                $urls = unserialize($comment['urls']);
                                        ?>
                                        <div class="detils">
                                                <span class="sku fll"><strong><?php echo $comment['sku']; ?></strong></span>
                                                <span class="name fll"><strong><?php echo $comment['firstname']; ?></strong></span>
                                                <span class="date fll"><strong><?php echo date('M d, Y', $comment['created']); ?></span>
                                                <div class="clear pt5"><strong><?php echo $comment['comments']; ?></div>
                                                <div class="clear pt5" style="word-wrap: break-word;">
                                                <?php
                                                if(!empty($urls))
                                                {
                                                foreach($urls as $url)
                                                {
                                                        echo '<a rel="nofollow" target="_blank" href="'.$url.'">'.$url.'</a><br>';
                                                }
                                                }
                                                ?>
                                                </div>
                                        </div>
                                        <?php
                                        endforeach;
                                        echo $pagination;
                                        ?>
                                </div>
                        </div>
                </section>
        <?php echo View::factory('/catalog_left'); ?>
    </section>
</section>
<div id="catalog_link" class="" style="position: fixed;z-index: 1000;width: 662px; height: 280px; top: 70px; left: 380px;">
        <div style="background:#fff; height: 280px;" id="inline_example2">
                <div class="login">
                        <div class="clear"></div>
                        <div class="login_l fll ml10">
                                <div class="step_form_h2">LOG IN</div>
                                <form id="loginForm" method="post" action="<?php echo LANGPATH; ?>/customer/login?redirect=activity/giveaway#step2" class="">
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
                                <form id="registerForm" method="post" action="<?php echo LANGPATH; ?>/customer/register?redirect=activity/giveaway#step2" class="">
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
                                                        <label><span>*</span> Confirm Password: </label>
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