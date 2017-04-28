<?php echo View::factory('admin/site/order/left')->render();?>
<?php
$mail_categories = array();
$mail_categories = DB::select()->from('mailcategories')->execute();
?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<div id="do_right">
	<div id="do_content">
		<div class="box">
			<h3>Edit Status</h3>
			<?php if ($errors){?>
			<ul class="error">
			<?php foreach($errors as $msg){?>
				<li><?php echo $msg;?></li>
			<?php }?>
			</ul>
			<?php }?>
			<form class="need_validation" method="post">
			<div class="navigation">
				<ul>
					<li>&nbsp;
						<ul>
							<?php if (!empty($data)){?>
							<li>
								<label for="type">Type:</label>
								<?php
								switch($data['type']){
									case 1:
										echo "Payment status";
										break;
									case 2:
										echo "Shipment status";
										break;
									case 3:
										echo "Issus status";
										break;
									case 4:
									    echo "Refund status";
									    break;
									default:
										break;
								}
								?>
							</li>
							<li>
								<label for="name">Name: </label>
								<input type="text" class="required" name="name" value="<?php echo $data['name'];?>"/>
							</li>
							<li>
								<label for="description">Description: </label>
								<input type="text" name="description" value="<?php echo $data['description'];?>"/>
							</li>
							<li>
								<label for="show_onfront">Show to customer? </label>
								<input type="checkbox" name="show_onfront" <?php echo ($data['show_onfront'])?"checked":"";?>/>
							</li>
							<li>
								<label for="send_email">Send email?</label>
								<input type="checkbox" name="send_email" <?php echo ($data['send_email'])?"checked":"";?>/>
							</li>
							<li>
								<label for="mailcategory_id">Email template: </label>
								<select name="mailcategory_id">
									<option value="">--</option>
									<?php foreach($mail_categories as $v){?>
                                    <option value="<?php echo $v['id'];?>" <?php echo $data['mailcategory_id']==$v['id']?"selected":"";?>><?php echo $v['name'];?></option>
                                    <?php }?>
								</select>
							</li>
							<?php } else {?>
							<li>
								<label for="type">Type:</label>
								<select name="type">
									<option value="3">Issue status</option>
								</select>
							</li>
							<li>
								<label for="name">Name: </label>
								<input type="text" class="required" name="name" value=""/>
							</li>
							<li>
								<label for="description">Description: </label>
								<input type="text" name="description" value=""/>
							</li>
							<li>
								<label for="show_onfront">Show to customer? </label>
								<input type="checkbox" name="show_onfront"/>
							</li>
							<li>
								<label for="send_email">Send email?</label>
								<input type="checkbox" name="send_email"/>
							</li>
							<li>
								<label for="mailcategory_id">Email template: </label>
								<select name="mailcategory_id">
									<option value="">--</option>
									<?php foreach($mail_categories as $v){?>
									<option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
									<?php }?>
								</select>
							</li>
							<?php }?>
						</ul>
					</li>
					<li>
						<input type="submit" name="_addanother" value="Save and add another"/>
						<input type="submit" name="_continue" value="Save and continue editing"/>
						<input type="submit" name="_save" value="Save"/>
					</li>
				</ul>
			</div>
			</form>
		</div>
	</div>
</div>
