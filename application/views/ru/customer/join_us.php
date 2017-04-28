<?php $site = Site::instance(); ?>
<div id="container">
        <div class=" fix">
                <div  id="main">
                        <div class="crumb"><a href="<?php echo LANGPATH; ?>/" class="home">Home</a>&gt;<span>Join Us</span></div>
                        <div class="help">
                                <div class="step-corp step-corp1"><img src="/images/setp-corp1.jpg" alt="" /></div>
                                <div class="corp-con">
                                        <h4><span  class="headline">Fashion Blogger:</span></h4>
                                        <p>No matter you a cool girl loving fashion, or a fashion blogger, always show your forward fashion as a free-thinking girl. </p>
                                        <p>What are you waiting for? Contact us via email <a style="color:red;" href="mailto:business@choies.com">business@choies.com</a> about yourself. You may get amazing free clothing that inspires you.</p>
                                        <h4>Fashion Blogger instruction:</h4>
                                        <p><strong>Note: </strong>Sorry for that we can't assume your import customs, because different countries have different customs policy. Hope you could understand us.</p>
                                        <h4>1. Becoming our VIP</h4>
                                        <p>Please put our VIP Fashion Experience Expert logo on the Home of your blog if you are willing to take part in our activities becoming our fashion clothing commentator. The logo links to the Home on our website. We could track your comments about our fashion clothing to update products and improve our services to meet more customers' respect.</p>
                                        <h4>2. Sharing your feelings &amp; thoughts </h4>
                                        <p>You could post photos and comments about our clothes within 7-15 days after getting the package on your blog, face book, look book, twitter etc. Please add the link of our website <a href="http://<?php echo $site->get('domain'); ?>"><?php echo $site->get('domain'); ?></a> or the link of the items' website page. Then we could get feedback from market in time and track the amount of visitors from your blog to our website. According to the number of visitors from your blog or look book etc. to our website after posting items, the quality and quantities of your posts, we’ll send freebies to you via email every month.</p>
                                        <h4>3. Please email us and send links of your post in time after posting our items on your blog, look book, face book, Twitter etc. </h4>
                                        <p>We have the right to collect photos of your post and related comments. Sometimes we use the information, for example, we may put it on face book or use your photos on our website. If you do not agree, please inform us in advance.</p>
                                        <h4>4. Now don’t hesitate, please register on our website firstly before doing anything else.Freebies or coupons could not be arranged to you if you don’t have a Choies in account.</h4>
                                        <table class="b-model">
                                                <tbody>
                                                        <tr>
                                                                <th colspan=6>Fashion Bloggers Levels</th>
                                                        </tr>
                                                        <tr>
                                                                <td>Freebies</td>
                                                                <td>$20/Month</td>
                                                                <td>$50/Month</td>
                                                                <td>$80/Month</td>
                                                                <td>$100/Month</td>
                                                                <td>$150/Month</td>
                                                        </tr>
                                                </tbody>
                                        </table>
                                        <form id="" method="post"  action="" >
                                                <div class="tac mt20">
                                                        <input type="submit" name="submit" value="Agree" />
                                                        &#12288;&#12288;
                                                        <input type="reset" value="I don't agree" onclick="history.back(-1)" />
                                                </div>
                                        </form>
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
        </div>
</div>