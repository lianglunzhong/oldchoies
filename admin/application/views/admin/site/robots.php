<?php echo View::factory('admin/site/doc_left')->render(); ?>
<div id="do_right">
<div class="box">
<h3>robots修改</h3>
<form action="" method="post" name="form1" id="form1">
<ul>
<li>
<label>robots:</label>
<div><textarea id="robots" name="robots" cols="70" rows="10"><?php echo $data->robots?></textarea></div>
</li>
<li>
<div><input type="submit" value="修  改"></div>
</li>
</ul>
</form>
</div>
</div>
