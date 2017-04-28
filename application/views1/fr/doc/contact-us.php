        <style>
        .contact-form div{clear:none;}
        .contect div.contact-note p{color:#444;}
        .contact-form span{margin:none;line-height:24px;}
        .contact-form ul li p{font-size:11px;color:#444;}
        .contect span.btn-span{margin-bottom:20px;}
        
        </style>
        <section id="main">
            <!-- crumbs -->
            <div class="container">
                <div class="crumbs">
                    <div>
                        <a href="<?php echo LANGPATH; ?>/">home</a>
                        <a href="<?php echo LANGPATH; ?>/mobile-left" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > help center</a> > Contact Us
                    </div><?php echo Message::get(); ?>
                </div>
            </div>
            <!-- main-middle begin -->
            <div class="container">
                <div class="row">
            <?php echo View::factory('doc/left'); ?>
                    <article class="user col-sm-9 col-xs-12">
                        <div class="tit">
                            <h2>Contact Us</h2>
                        </div>
                        <div class="doc-box contect">
                            <h3 style="text-transform:uppercase; font-size:18px; font-weight:normal;">We Are Here to Help!</h3>
                            <p class="mt10">If you come across any problems while you are shopping at Choies.com, you can contact us within the following methods:</p>
                            <p>(<strong>Tip</strong>: Customer Service Period: 19:30-11:00 Sunday - Friday, EST.)</p>
                            <div>
                                <span class="btn-span" style="height:20px;"><a class="btn btn-default btn-lg" style="color:#fff;text-decoration:none;" target="_blank" title="LiveChart" href="https://chatserver.comm100.com/chatwindow.aspx?planId=311&siteId=203306"><img src="<?php echo STATICURL; ?>/assets/images/docs/icon_chat.png">LIVECHAT</a>&nbsp;&nbsp;</span>
                                <span class="btn-span" style="font-weight:bold;font-size:18px;">  (FOR <span1 style="color:red">PRE-SALE</span1> QUESTIONS <span1 style="color:red">ONLY</span1>)</span>
                            </div>  
                            
                           <div>
                                <span class="btn-span"><a class="btn btn-default btn-lg JS_click" style="color:#fff;text-decoration:none;" target="_blank" title="">CLICK HERE TO EMAIL US</a></span>
                                &nbsp;&nbsp;
                                <span class="btn-span" style="font-weight:bold;font-size:18px;">(FOR <span1 style="color:red">AFTER-SALE</span1> AND OTHER QUESTIONS)</span>
                            </div>
                            <div>
                                 <div class="JS_clickcon hide">
                                    <div class="row">
                                        <form action="site/docsend" method="post" class="user-form contact-form col-xs-12 mt20" enctype="multipart/form-data">
                                        <ul> 
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>*</span> Name:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="name" class="text-long text col-sm-12 col-xs-12" />
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>*</span> Email Address:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="email" class="text-long text col-sm-12 col-xs-12" />
                                                    <p>Use your registered email if you have a Choies account.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>*</span> Question Type:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <div class="wdrop">
                                                        <select class="selected-option col-sm-12 col-xs-12" name="qt">
                                                            <option value="" class="selected"> - Select the subject of your inquiry - </option>
                                                            <option value="1">Pre-sale General Question/Stock Availability/Product Information</option>
                                                            <option value="2">Pre-sale Wholesale,Bulk Purchase or Dropship Enquiry </option>
                                                            <option value="3">Address or Item Change/Order Cancellation (unshipped orders only)  </option>
                                                            <option value="4">Order Status/Tracking Information/Lost package/Customs Issue </option>
                                                            <option value="5">After-sale Service Support (e.g defective items, incorrect items, missing items,size unfit,etc)  </option>
                                                            <option value="6">Payment Issues/Technical Issues  </option>
                                                            <option value="7">Account Admin Issues (e.g password forgot, unsubscribe from newsletter, etc)  </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>&nbsp;</span>Order Number:<br/><span style="color:#444;">(if applicable)</span></label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="order" class="text-long text col-sm-12 col-xs-12" />
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12">
                                                    <span>*</span> Message:
                                                </label>
                                                <div class="col-sm-6 col-xs-12 mb20">
                                                    <textarea class="textarea-long text col-sm-12 col-xs-12" name="message"></textarea>
                                                </div>
                                            </li>
                                             <li>
                                                <label class="col-sm-3 col-xs-12"><span>&nbsp;</span>Attachment:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                <input type="text" class="text-long text col-sm-9 col-xs-9" readonly name="file_name" id="file_name"/><input type="button" value="upload" class="col-sm-3 col-xs-3 btn btn-xs btn-default" style="height:24px;" onclick="btn_file.click();" name="get_file"/>
                                                    <input type="file" name="btn_file" onchange="file_change(this.value)" style="display:none;"/>
                                                
                                                    <!--  <p class="col-sm-3 col-xs-2"><a><img style="max-width:none;" src="/assets/images/docs/upload.png" ></a></p> -->
                                                    <p>If you would like to show us some files, please upload them here. Each file must be below 2MB. The following file formats are supported: gif, jpg, png, bmp, doc, xls, txt, rar, ppt, pdf.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 hidden-xs">&nbsp;</label>
                                                <div class="btn-grid12 col-sm-6 col-xs-12 mb20">
                                                    <input type="submit"  value="SEND" class="btn btn-primary btn-lg" />
                                                </div>
                                            </li>
                                        </ul>
                                    </form>
                                  </div>
                                </div>
                            </div>
                            <div class="contact-note">
                                <p style="font-weight:bold;">Emails will be replied in 24 hours but may be delayed during the weekends and busy season. To solve your problem quickly, please note:</p>
                                <p>
                                    1.Questions before purchase , please check <i><a href="/faqs" style="color:#444;">FAQ</a> </i>;
                                </p>
                                <p>
                                    2.Not receive Order Confirmation and Tracking Information, Check your<strong> SPAM FOLDER</strong> first;
                                </p>
                                <p>

                                    3.Check Order Status and Track, please <a href="/customer/login" class="a-red">SIGN IN</a> first then click<i><a href="/tracks/track_order" style="color: rgb(65, 140, 175);">TRACK ORDER</a> </i>


                                </p>
                            </div>
                            <br/>

                            <!--更改部分en-->
                            <div style="display:none;">
                                <p><strong>[Company Name]</strong>  V-Shangs Science and Technology(H.K.)Co., Limited</p>
                                <p><strong>[Address]</strong>  Rm1702, 17F, Sino Centre, 582-592 Nathan Rd.,Kln.,HK</p>
                            </div>
                            <p style="display:none;"><strong>[<i>Company Relations</i>]</strong></p>
                            <div class="doc-contact-1230" style="display:none;">
                                <div>
                                    <h4> WUXI INVOGUE TECHNOLOGY GROUP CO., LTD</h4>
                                    <p>Address: Room 1801, No. 855 NANHU Road, YANGMING SCIENCE INNOVATION CENTRE, NANCHANG DISTRICT, WUXI, JIANGSU PROVINCE, CHINA</p>
                                    <ul>
                                        <li><p><img src="<?php echo STATICURL; ?>/assets/images/docs/contact-us-left.jpg"></p><span>Nanjing Kuaiyue E-commerce Co., Limited </span></li>
                                        <li><p><img src="<?php echo STATICURL; ?>/assets/images/docs/contact-us-right.jpg"></p><span style="float:right"> V-Shangs Science and Technology(H.K.) Co., Limited </span><p><img src="<?php echo STATICURL; ?>/assets/images/docs/contact-us-down.jpg"></p><p class="big-icon">choies</p></li>
                                    </ul>
                                    <p style="color:#c30;font-size:14px;">(Please note: These addresses do NOT accept returns.)</p>
                                </div>
                            </div>

                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- footer begin -->

        <div id="gotop" class="hide">
            <a href="#" class="xs-mobile-top"></a>
        </div>
        
    
        
        <script type="text/javascript">
        function file_change(e)
        {
            document.getElementById("file_name").value = e;
        }
        </script>

<script type="text/javascript">

        $(".contact-form").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            qt: {
                required: true,
            },
            message: {
                required: true,
            }
        },
        messages: {
            name: {
                required: "Please provide a name.",
            },
            email:{
                required:"Please provide an email.",
                email:"Please enter a valid email address."
            },
            qt: {
                required: "Please select a question.",
            },
            message:{
                required:"Please provide a message.",
            },
        }
    });
</script>

