<?php echo View::factory('admin/site/basic_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<div id="do_right">
    <div class="box">
        <form action="/admin/site/basic/payment" method="post" name="form1" id="form1" class="need_validation">
            <ul>
				<li style="cursor: pointer;" onclick="$('#CCDiv').fadeIn(2000);"><h3>Credit Card</h3></li>
				<ul id="CCDiv" style="display:none">
					<li>
						<label>CC Payment ID:</label>
						<div><input class="text short required" type="text" id="cc_payment_id" name="cc_payment_id" value="<?php echo $site->cc_payment_id; ?>"></div>
					</li>
					<li>
						<label>CC Secure Code:</label>
						<div><input class="text short required" type="text" id="cc_secure_code" name="cc_secure_code" value="<?php echo $site->cc_secure_code; ?>"></div>
					</li>
					<li>
						<label>CC Payment URL:</label>
						<div><input class="text long required url" type="text" id="cc_payment_url" name="cc_payment_url" value="<?php echo $site->cc_payment_url; ?>"></div>
						[ <a href="#" onclick="$('#CCDiv').fadeOut(1000);">Hide</a> ]
					</li>
				</ul>
				<li style="cursor: pointer;" onclick="$('#PPDiv').fadeIn(2000);"><h3>Paypal</h3></li>
				<ul id="PPDiv" style="display:none">
					<li>
						<label>Paypal Payment URL:</label>
						<div><input class="text medium url" type="text" id="pp_payment_url" name="pp_payment_url" value="<?php echo $site->pp_payment_url; ?>"></div>
						<div><strong>Formal:</strong> https://www.paypal.com/row/cgi-bin/webscr <strong>Test:</strong> https://www.sandbox.paypal.com/cgi-bin/webscr</div>
					</li>
					<li>
						<label>Paypal API Submit URL:</label>
						<div><input class="text long url" type="text" id="pp_submit_url" name="pp_submit_url" value="<?php echo $site->pp_submit_url; ?>"></div>
						<div><strong>Formal:</strong> https://api-3t.paypal.com/nvp <strong>Test:</strong> https://api-3t.sandbox.paypal.com/nvp</div>
					</li>
					<li>
						<label>Paypal Sync URL:</label>
						<div><input class="text medium url" type="text" id="pp_sync_url" name="pp_sync_url" value="<?php echo $site->pp_sync_url; ?>"></div>
					</li>
					<li>
						<label>Paypal Account:</label>
						<div><input class="text medium email" type="text" id="pp_payment_id" name="pp_payment_id" value="<?php echo $site->pp_payment_id; ?>"></div>
						<div><strong>Test:</strong> ketai_1279509382_biz@gmail.com</div>
					</li>
					<li>
						<label>Paypal Tiny Payment Account:</label>
						<div><input class="text medium email" type="text" id="pp_tiny_payment_id" name="pp_tiny_payment_id" value="<?php echo $site->pp_tiny_payment_id; ?>"></div>
						<div><strong>Test:</strong> ketai_1279509382_biz@gmail.com</div>
					</li>
					<li>
						<label>Paypal API Version</label>
						<div><input class="text medium" type="text" id="pp_api_version" name="pp_api_version" value="<?php echo $site->pp_api_version; ?>"></div>
					</li>
					<li>
						<label>Paypal API User:</label>
						<div><input class="text medium" type="text" id="pp_api_user" name="pp_api_user" value="<?php echo $site->pp_api_user; ?>"></div>
						<div><strong>Test:</strong> ketai_1279509382_biz_api1.gmail.com</div>
					</li>
					<li>
						<label>Paypal API Password:</label>
						<div><input class="text medium" type="text" id="pp_api_pwd" name="pp_api_pwd" value="<?php echo $site->pp_api_pwd; ?>"></div>
						<div><strong>Test:</strong> 1279509387</div>
					</li>
					<li>
						<label>Paypal API Signature:</label>
						<div><input class="text long" type="text" id="pp_api_signa" name="pp_api_signa" value="<?php echo $site->pp_api_signa; ?>"></div>
						<div><strong>Test:</strong> ALTBEB.5BTHCjQYjgZ7mbdtgngZDAcGit0L20wfVfyyvhInmYEBbMH3W</div>
					</li>
					<li>
						<label>Paypal Notify URL:</label>
						<div><input class="text long url" type="text" id="pp_notify_url" name="pp_notify_url" value="<?php echo $site->pp_notify_url; ?>"></div>
					</li>
					<li>
						<label>Paypal EC Notify URL:</label>
						<div><input class="text long url" type="text" id="pp_ec_notify_url" name="pp_ec_notify_url" value="<?php echo $site->pp_ec_notify_url; ?>"></div>
					</li>
					<li>
						<label>Paypal Return URL:</label>
						<div><input class="text long url" type="text" id="pp_return_url" name="pp_return_url" value="<?php echo $site->pp_return_url; ?>"></div>
					</li>
					<li>
						<label>Paypal EC Return URL:</label>
						<div><input class="text long url" type="text" id="pp_ec_return_url" name="pp_ec_return_url" value="<?php echo $site->pp_ec_return_url; ?>"></div>
					</li>
					<li>
						<label>Paypal Cancel URL:</label>
						<div><input class="text long url" type="text" id="pp_cancel_return_url" name="pp_cancel_return_url" value="<?php echo $site->pp_cancel_return_url; ?>"></div>
					</li>
					<li>
						<label>Paypal Logo URL:</label>
						<div><input class="text long url" type="text" id="pp_logo_url" name="pp_logo_url" value="<?php echo $site->pp_logo_url; ?>"></div>
						[ <a href="#" onclick="$('#PPDiv').fadeOut(1000);">Hide</a> ]
					</li>
				</ul>
				<li>
					<div><input type="submit" value="Save"></div>
				</li>
            </ul>
        </form>
    </div>
</div>

