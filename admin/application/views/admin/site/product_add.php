<div id="do_content">
	<div class="box">
		<h3>Add Product</h3>
		<form method="post" action="/admin/site/product/add?step=1">

			<ul>
				<li>
					<label>Select Product Type</label>
					<div>
						<select name="type" id="type" class="drop" changed="0">
							<option selected="selected" value="0">Simple</option>
							<option value="1">Config</option>
							<option value="2">Package</option>
							<option value="3">Simple-Config</option>
						</select>
					</div>
				</li>

				<li id="set_select_box">
					<label>Select Product Set</label>
					<div>
						<select name="set_id" id="set_id" class="drop">
							<option selected="selected" value="0">None</option>
							<?php
							foreach( $sets as $set )
							{
							?>
								<option value="<?php echo $set->id; ?>"><?php echo $set->name.'('.$set->brief.')'; ?></option>
							<?php
							}
							?>
						</select>
					</div>
				</li>

				<li>
					<input value="next" class="button" type="submit" />
				</li>
			</ul>
		</form>
	</div>
</div>
                            <script type="text/javascript">
                            $('#type').change(function(){
                                if($(this).val() == 2) {
                                    $('#set_select_box').hide();
                                }else{
                                    $('#set_select_box').show();
                                }
                            });
                            </script>
