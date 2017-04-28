<script type="text/javascript">
	$(function(){
		$(".datepick").datepicker({dateFormat:'yy-mm-dd'});
	});
</script>
<div id="do_content">
	<div class="box">
		<h3>添加客户</h3>
		<form method="post" action="">
		<div class="navigation">
			<ul>
			<li>
			<ul>
				<li>
					<label>Email：</label>
					<div><input name="email" class="text short" value="" type="text"/></div>
				</li>
				<li>
					<label>Password：</label>
					<div><input name="password" class="text short" value="" type="text"/></div>
				</li>
				<li>
					<label>Firstname：</label>
					<div><input name="firstname" class="text short" value="" type="text"/></div>
				</li>
				<li>
					<label>Lastname：</label>
					<div><input name="lastname" class="text short" value="" type="text"/></div>
				</li>
				<li>
					<label>Birthday：</label>
					<div><input name="birthday" class="text short datepick" value="" type="text"/></div>
				</li>
				<li>
					<label>Status：</label>
					<div>
						<select name="status">
							<option></option>
						</select>
					</div>
				</li>
				<li>
					<label>Gender：</label>
					<div>
						<select name="gender">
							<option value=""></option>
						</select>
					</div>
				</li>
				<li>
					<label>Country：</label>
					<div>
						<select name="country">
							<?php foreach($countries as $c){?>
							<option value="<?php echo $c->isocode;?>"><?php echo $c->name;?></option>
							<?php }?>
						</select>
					</div>
				</li>
				<li>
					<div><input class="hand" name="" value="提  交" type="submit" /></div>
				</li>
			</ul>
			</li>
			</ul>
			</div>
		</form>
	</div>
</div>
