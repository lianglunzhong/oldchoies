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
            <?php echo View::factory('doc/en/left'); ?>
                    <article class="user col-sm-9 col-xs-12">
                        <div class="tit">
                            <h2>Wholesale</h2>
                        </div>
                        <div class="doc-box">
                            <p>
                                <span>Choies provides clothing to retail boutique shops and women’s department stores from all over the world. Whether you're a personal buyer looking for fashion clothes, or a store owner or business wholesaler searching for suppliers to give your business the competitive edge, Choies is perfect for you.And now you can easily get a wholesale discount for any of your orders.The more you buy, the more you save! Please check the wholesale discount for orders in details:</span>
                            </p>
                            <div class="whosale row">
                                <div class="whosale-left col-sm-7 col-xs-12">
                                    <table class="user-table f11">
                                        <tbody>
                                            <tr height="60">
                                                <th width="50%">Total consumption per order</th>
                                                <th width="50%">Extra Wholesale Discount</th>
                                            </tr>
                                            <tr height="60">
                                                <td>USD 200-500</td>
                                                <td>Extra 4% Off</td>
                                            </tr>
                                            <tr height="60">
                                                <td>USD 500-1000</td>
                                                <td>Extra 6% Off</td>
                                            </tr>
                                            <tr height="60">
                                                <td>USD 1000-2000</td>
                                                <td>Extra 8% Off</td>
                                            </tr>
                                            <tr height="60">
                                                <td>More than USD 2000</td>
                                                <td>Extra 10% Off</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="margin-top:40px;" class="red">* This discount will be added automatically at the checkout.</p>
                                </div>
                                <div class="col-sm-5 hidden-xs">
                                    <img src="<?php echo STATICURL; ?>/assets/images/docs/whosale-doc.jpg">
                                </div>
                                <div class="col-xs-12">
                                    <p>For those who do wholesale business with us frequently, you can also enjoy an extra discount code from our sellers according to the total history consumption. Got interested? Please contact: <a href="mailto:service@choieswholesale.com">service@choieswholesale.com.</a></p>
                                    <h4 style="font-size:16px;">Wholesale Business Terms</h4>
                                    <strong>1.Time for Goods Preparation</strong>
                                    <p>Orders under 10 pieces, it takes 5 business days to prepare your goods. But if orders with shoes, it should extend the time for 3 business days. Orders between 11-50 pieces, it takes 15 business days to prepare your goods. Orders over 50 pieces, it takes 20 business days to prepare your goods. Note: orders with customized clothes or labeling service, the preparing time would be 20 business day.</p>
                                    <strong>2.Late Delivery and Compensation:</strong>
                                    <p>Should Choies fail to make delivery on time, with exception of Force Majeure causes. The Buyers shall agree to postpone the delivery on condition that Choies agree to give some discount codes as compensation. The Codes, however, shall not exceed 20%. The rate of discount code is charged at 5% for every seven days. Odd days less than seven days should be counted as seven days. In case Choies fail to make delivery four weeks later than the time of shipment stipulated above, the Buyers shall have the right to cancel the order and Choies, in spite the cancellation, shall still give the aforesaid discount code to the Buyers without delay.</p>
                                    <strong>3.Package Late, Damage& Lost and Compensation</strong>
                                    <p>If Buyers fail to receive the package in three months, with exception of Force Majeure causes. The Buyers shall agree to accept the goods when they reach on condition that Choies agree to give 10% discount codes as compensation. Due to the defect of package, the damage occur to the goods, Choies will compensate for the loss to the buyers. If the package is confirmed to be lost, Choies will resend the goods at our cost or return the money in full as the buyers request. And Choies shall still give 5% discount code as compensation.</p>
                                    <strong>4.Duty & Taxes</strong>
                                    <p>The buyers are full responsible for the duty and taxes if there is any and Choies would do any effort to assistant you to pass the customs clearance.</p>
                                    <strong>5.Discrepancy:</strong>
                                    <p>In case of quality discrepancy, claim should be lodged by the Buyers within 30 days after receiving the goods, goods must not by returned except by permission of the seller. While for quantity discrepancy, claim should be lodged by the Buyers within 15 days after receiving the goods. The settlement of such claims is restricted to replacement of the non—conforming commodity on a one—to—one basis or devaluation of the commodity according to degree of inferiority and extent of damage in case of quality discrepancy or supply for the shortage in case of quantity discrepancy.</p>
                                    <strong>6.Discount Codes</strong>
                                    <p>The discounts Choies offered could be accumulated.</p>
                                    <strong>Dropship Service</strong>
                                    <p><strong>We offer Dropship service for business who may bring over 30 orders a week, 10%OFF each order will be given.</strong></p>
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

