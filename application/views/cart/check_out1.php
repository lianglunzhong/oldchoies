<div id="container" style="margin-top:30px; background: #fff;">
        <div id="forgot_password">
                <?php echo Message::get(); ?>
        </div>
        <div class="step_l fll">
                <div class="step_tit">YOU’RE ALMOST THERE!</div>
                <div class="step1_wra">
                        <div class="step1_l fll">
                                <div class="step_form_h2">SIGN IN:</div>
                                <form action="/cart/login" method="post" id="formLogin">
                                        <input type="hidden" name="referer" value="/cart/check_out" />
                                <ul>
                                        <li>
                                                <label>Email:</label>
                                                <input type="text" id="email" name="email" class="" />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label>Password: </label>
                                                <input type="password" id="password" name="password" class="" />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <input type="submit" class="form_btn" id="sign_in" value="LOG IN" />
                                                <span class="forgetpwd"><a href="<?php echo LANGPATH; ?>/customer/forgot_password">I forgot my password!</a></span>
                                        </li>
                                </ul>
                                </form>
                                <script type="text/javascript">
                                        $("#formLogin").validate($.extend(formSettings,{
                                                rules: {
                                                        email:{required: true,email: true},
                                                        password: {required: true,minlength: 5}
                                                }
                                        }));
                                </script>
                        </div>
                        <div class="step1_l fll mb10">
                                <div class="step_form_h2">NEW TO REGISTER:</div>
                                <form action="/cart/register" method="post" id="formRegister">
                                        <input type="hidden" name="referer" value="/cart/check_out" />
                                <ul>
                                        <li>
                                                <label>Email:</label>
                                                <input type="text" id="email1" name="email" class="" />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label>Password:</label>
                                                <input type="password" id="password1" name="password" class="" />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <label>Confirm Password:</label>
                                                <input type="password" id="c_password" name="confirmpassword" class="" />
                                                <div class="errorInfo"></div>
                                        </li>
                                        <li>
                                                <input type="submit" class="form_btn" id="register" value="REGISTER" />
                                        </li>
                                </ul>
                                </form>
                                <script type="text/javascript">
                                        $("#formRegister").validate($.extend(formSettings,{
                                                rules: {			
                                                        email:{required: true,email: true},
                                                        password: {required: true,minlength: 5},
                                                        confirmpassword: {required: true,minlength: 5,equalTo: "#password1"}
                                                }
                                        }));
                                </script>
                        </div>
                </div>
                <div class="step_link"><a href="#">SHIPPING ADDRESS</a></div>
                <div class="step_link"><a href="#">PAYMENT</a></div>
        </div>
        <div class="step_r flr">
                <div class="step_form_h2" style="margin-top:0px;">ORDER SUMMARY</div>
                <div class="order">
                        <ul>
                        <?php
                        foreach ($cart['products'] as $key => $product):
                        ?>
                                <li>
                                        <div class="order_img fll">
                                                <a href="<?php echo Product::instance($product['id'])->permalink(); ?>">
                                                        <img width="88" src="<?php echo image::link(Product::instance($product['id'])->cover_image(), 3); ?>" alt="" />
                                                </a>
                                        </div>
                                        <div class="order_desc fll">
                                                <h3><?php echo Product::instance($product['id'])->get('name'); ?></h3>
                                                <p><?php echo Site::instance()->price($product['price'], 'code_view'); ?><br />
                                                <?php
                                                foreach($product['attributes'] as $name => $attribute):
                                                        if ($name == 'delivery time')
                                                        {
                                                                if ($attribute > 0)
                                                                        $attribute = 'rush order';
                                                                else
                                                                        $attribute = 'regular order';
                                                        }
                                                        echo $name . ': ' . $attribute . ';<br>';
                                                endforeach;
                                                ?>
                                                        Quantity: <?php echo $product['quantity']; ?></p>
                                        </div>
                                        <div class="fix"></div>
                                </li>
                        <?php
                        endforeach;
                        ?>        
                        </ul>
                </div>
                <div class="step_total">
                        <ul>
                                <li><span>Subtotal:</span><?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?></li>
                                <li>
                                        <span>Estimated Shipping:</span>
                                        <?php
                                        $shipping_price = 0;
                                        if ($cart['shipping_address'])
                                                echo Site::instance()->price($cart['amount']['shipping'], 'code_view');
                                        else
                                        {
                                                $shipping_price = Session::instance()->get('shipping_price', 0);
                                                echo Site::instance()->price($shipping_price, 'code_view');
                                        }
                                        ?>
                                </li>
                                <?php if ($cart['amount']['save']): ?>
                                        <?php
                                        if(isset($cart['promotion_logs']['cart']))
					{
                                        foreach ($cart['promotion_logs']['cart'] as $p_cart)
                                        {
                                                if ($p_cart['save'])
                                                {
                                                        $p_name = explode(':', $p_cart['log']);
                                                        echo '<li><span>"' . $p_name[0] . '" Save : </span>-' . Site::instance()->price($p_cart['save'], 'code_view') . '</li>';
                                                }
                                        }
                                        }
                                        ?>
                                        <?php
                                        if ($cart['amount']['coupon_save'] > 0):
                                                ?>
                                                <li><span>Coupon Code:</span>- <?php echo Site::instance()->price($cart['amount']['coupon_save'], 'code_view'); ?></li>
                                                <?php
                                        endif;
                                endif;
                                if ($cart['amount']['point']):
                                        ?>
                                        <li><span>Pay with Points:</span>- <?php echo Site::instance()->price($cart['amount']['point'], 'code_view'); ?></li>
                                <?php endif; ?>
                                <li class="amount"><span>Total:</span><?php echo Site::instance()->price($cart['amount']['total'], 'code_view'); ?></li>
                        </ul>
                </div>
                <?php if(!$cart['coupon']): ?>
                <div class="useCode pt10">
                        <h3>Enter Coupon Code</h3>
                        <form id="discount_form" action="/cart/set_coupon" method="post" class="mt10">
                                <input name="return_url" type="hidden" value="/cart/check_out" />
                                <p> <span>
                                                <input name="coupon_code" type="text" class="codeInput" value="" />
                                        </span> <span>
                                                <input id="apply" name="apply" type="submit" value="APPLY" onmouseover="$(this).addClass('on')" onsmouseout="$(this).removeClass('on')" class="allbtn btn-apply on" />
                                        </span> </p>
                                <p class="remark clear">Limit one code per order.</p>
                        </form>
                </div>
                <?php endif; ?>
        </div>
</div>