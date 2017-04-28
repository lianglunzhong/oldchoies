<ul>

	<?php
	foreach( $attributes as $attribute )
	{
	?>
		<li>
			<label><?php echo $attribute->name; ?>:</label>
			<div>
			<?php
			switch( $attribute->type )
			{
				case 2:
			?>
					<input type="text" name="attributes[<?php echo $attribute->id; ?>]" class="text medium<?php if($attribute->required) echo ' required';?>" value="" />
			<?php
					break;
				case 3:
			?>
					<textarea cols="60" rows="6" class="textarea<?php if($attribute->required) echo ' required';?>" name="attributes[<?php echo $attribute->id; ?>]"></textarea>
			<?php
					break;
				case 1:
					$options = $attribute->options->find_all();
					foreach( $options as $option )
					{
			?>
						<input type="radio" class="radio<?php if($attribute->required) echo ' required';?>" name="option_id[<?php echo $attribute->id; ?>]" value="<?php echo $option->id; ?>"  /> <?php echo $option->label; ?>
						&nbsp;&nbsp;&nbsp;&nbsp;
			<?php
					}
					break;
				case 0:
				default:
			?>
                    <select name="option_id[<?php echo $attribute->id; ?>]" class="drop<?php if($attribute->required) echo ' required';?>" >
                        <option value="">--NONE--</option>
				<?php
					$options = $attribute->options->find_all();
					foreach( $options as $option )
					{
				?>
						<option value="<?php echo $option->id; ?>"><?php echo $option->label; ?></option>
				<?php
					}
				?>
				</select>
			<?php
					break;
			}
			?>
			<label class="note"><?php echo $attribute->brief; ?></label>
		</div>
	</li>
	<?php
		}
	?>
</ul>
