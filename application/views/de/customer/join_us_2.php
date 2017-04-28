
<div id="container">
        <div class=" fix">
                <div id="main">
                        <div class="crumb"><a href="<?php echo LANGPATH; ?>/" class="home">Home</a>&gt;<span class="current">Join Us</span></div>
                        <?php $domain = Site::instance()->get('domain'); ?>
                        <div class="help">
                                <div class="step-corp step-corp1"><img src="/images/setp-corp3.jpg" alt="" /></div>
                                <div style="font-size: 13px;color:#FD7E07;font-weight:bold;">
                                        3.See our "leave message box", let us know you are ready to get freebies!<br>4.We will sent your freebies in 12 hours, details of how to use freebie,<a href="http://www.romwe.com/How%20to%20use%20freebies-ezp-22.html">click here</a>
                                </div>
                                <div id="do_right">
                                        <h3>Join Us</h3> 
                                        <h4>Don't forget your blog address in the message.</h4>
                                        <form id="send_message" action="" method="post" class="formArea fix">
                                                <ul>
                                                        <li>
                                                                <label><span>*</span>Full Name:</label>
                                                                <div>
                                                                        <input id="name" class="text medium required" type="text" name="name" size="40" />
                                                                </div>
                                                                <div class="errorInfo"></div>
                                                        </li>
                                                        <li>
                                                                <label><span>*</span>Email Address:</label>
                                                                <div>
                                                                        <input id="email" class="text medium required" type="text" name="email" size="40" />
                                                                </div>
                                                                <div class="errorInfo"></div>
                                                        </li>
                                                        <li>
                                                                <label><span>*</span>Message:</label>
                                                                <div>
                                                                        <textarea id="message" class="textarea" tabindex="1" cols="60" rows="6" name="message"></textarea>
                                                                </div>
                                                                <div class="errorInfo"></div>
                                                        </li>
                                                        <li style="margin-top:40px;">
                                                                <a href="<?php echo LANGPATH; ?>/">Back</a>
                                                                <input class="button" type="submit" value="Send" />
                                                        </li>
                                                </ul>
                                        </form>
                                        <script type="text/javascript">
                                                $("#send_message").validate($.extend(formSettings,{
                                                        rules: {
                                                                name: {required: true},
                                                                email:{required: true,email: true},
                                                                message: {required: true,minlength: 5}
                                                        }
                                                }));
                                        </script>
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