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
                        <a href="<?php echo LANGPATH; ?>/faqs" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > help center</a> > Contact Us
                    </div>
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
                            <div>
                                <span class="btn-span"><a class="btn btn-default btn-lg" style="color:#fff;text-decoration:none;" target="_blank" title="LiveChart" href="https://chatserver.comm100.com/chatwindow.aspx?planId=311&siteId=203306"><img src="/assets/images/docs/icon_chat.png">LIVECHAT</a></span>
                                <span></span>
                            </div>
                           <div>
                                <span class="btn-span"><a class="btn btn-default btn-lg JS_click" style="color:#fff;text-decoration:none;" target="_blank" title="">CLICK HERE TO EMAIL US</a></span>
                                 <div class="JS_clickcon hide">
                                    <div class="row">
                                        <form action="/activity/docsend" method="post" class="user-form contact-form col-xs-12 mt20" enctype="multipart/form-data">
                                        <ul> 
                                            <li>
                                                <label class="col-sm-2 col-xs-12"><span>*</span> Name:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="name" class="text-long text col-sm-12 col-xs-12" />
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-2 col-xs-12"><span>*</span> Email Address:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="email" class="text-long text col-sm-12 col-xs-12" />
                                                    <p>Use your registered email if you have a Choies account.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-2 col-xs-12"><span>*</span> Question Type:</label>
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
                                                <label class="col-sm-2 col-xs-12"><span>&nbsp;</span>Order Number:<br/><span style="color:#444;">(if applicable)</span></label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="order" class="text-long text col-sm-12 col-xs-12" />
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-2 col-xs-12">
                                                    <span>*</span> Message:
                                                </label>
                                                <div class="col-sm-6 col-xs-12 mb20">
                                                    <textarea class="textarea-long text col-sm-12 col-xs-12" name="message"></textarea>
                                                </div>
                                            </li>
                                             <li>
                                                <label class="col-sm-2 col-xs-12"><span>&nbsp;</span>Attachment:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                <input type="text" class="text-long text col-sm-8 col-xs-8" readonly name="file_name" id="file_name"/><input type="button" value="see..." class="col-sm-2 col-xs-2 btn btn-xs btn-default" style="height:24px;" onclick="btn_file.click();" name="get_file"/>
                                                    <input type="file" name="btn_file" onchange="file_change(this.value)" style="display:none;"/>
                                                
                                                    <!-- <p class="col-sm-2 col-xs-2"><a><img style="max-width:none;" src="/assets/images/docs/upload.png" ></a></p>-->
                                                    <p>If you would like to show us some files, please upload them here. Each file must be below 2MB. The following file formats are supported: gif, jpg, png, bmp, doc, xls, txt, rar, ppt, pdf.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-2 hidden-xs">&nbsp;</label>
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
                                <p style="font-weight:bold;">Emails will be replied in 24 hours but may be delayed during the busy season. To solve your problem quickly, please note:</p>
                                <p>
                                    1.Questions before purchase , please check <i><a href="/faqs" style="color:#444;">FAQ</a> </i>;
                                </p>
                                <p>
                                    2.Not receive Order Confirmation and Tracking Information, Check your<strong> SPAM FOLDER</strong> first;
                                </p>
                                <p>
                                    3.Check Order Status and Tracking, please click <i><a href="/tracks/track_order" style="color:#444;">TRACK ORDER</a></i> .
                                </p>
                            </div>

                            <div class="mt20">
                                <span class="icon-contect5"></span>
                                <span><strong>Tel</strong></span>
                                <span> 442032899993 (7*24h) </span>
                            </div>
                            <div>
                                <span class="icon-contect6"></span>
                                <span><strong>Add</strong></span>
                                <span>Third Floor, 207 Regent Street, London, W1B 3HH,United Kingdom</span>
                            </div>
                            <div class="last-contect">
                                [<em style="font-style:normal;">Attention:</em>This address is NOT our delivery address, for exchange & return issue, please contact customer service first.]
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
                name: true
            },
            email: {
                required: true,
                minlength: 5,
                maxlength:20,
                email: true
            },
            select_question: {
                required: true,
            },
            message: {
                required: true,
                minlength: 5,
                maxlength:20
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
            select_question: {
                required: "Please select a question.",
            },
            message:{
                required:"Please provide a message.",
                minlength: "Your password must be at least 5 characters long.",
                maxlength: "The password exceeds maximum length of 20 characters."
            },
        }
    });
</script>

