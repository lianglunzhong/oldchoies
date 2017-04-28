<?php echo View::factory('/admin/sys/sys_left')->render(); ?>
<div id="do_right">
<div class="box">
<h3>产品线修改</h3>
<form action="/admin/sys/line/edit/<?php echo $id;?>" method="post" name="form1" id="form1">
<ul>
<li>
<label>名称：</label>
<div><input type="text" id="name" name="name" value="<?php echo $name;?>" class="text medium" /></div>
</li>
<li>
<label>简介：</label>
<div><textarea id="brief" name="brief" rows="6" cols="60" tabindex="1" class="textarea"><?php echo $brief;?></textarea></div>
</li>
<li>
<input value="修  改" class="button" type="submit">
</li>
</ul>
</form>
</div>
</div>
