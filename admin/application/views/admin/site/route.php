<?php echo View::factory('admin/sys/sys_left')->render(); ?>
<div id="do_right">
<div class="box">
<h3>route修改</h3>
<form action="" method="post" name="form1" id="form1">
<ul>
<li>
<label>login:</label>
<div><input class="short text" type="text" id="login" name="login" value="<?php echo $data->login?>"></div>
</li>
<li>
<label>logout:</label>
<div><input class="short text" type="text" id="logout" name="logout" value="<?php echo $data->logout?>"></div>
</li>
<li>
<label>register:</label>
<div><input class="short text" type="text" id="register" name="register" value="<?php echo $data->register?>"></div>
</li>
<li>
<label>cart:</label>
<div><input class="short text" type="text" id="cart" name="cart" value="<?php echo $data->cart?>"></div>
</li>
<li>
<label>find_password:</label>
<div><input class="short text" type="text" id="find_password" name="find_password" value="<?php echo $data->find_password?>"></div>
</li>
<li>
<label>get_password:</label>
<div><input class="short text" type="text" id="get_password" name="get_password" value="<?php echo $data->get_password?>"></div>
</li>
<li>
<label>product:</label>
<div><input class="short text" type="text" id="product" name="product" value="<?php echo $data->product?>"></div>
</li>
<li>
<label>catalog:</label>
<div><input class="short text" type="text" id="catalog" name="catalog" value="<?php echo $data->catalog?>"></div>
</li>
<li>
<label>promotion:</label>
<div><input class="short text" type="text" id="promotion" name="promotion" value="<?php echo $data->promotion?>"></div>
</li>
<li>
<label>package:</label>
<div><input class="short text" type="text" id="package" name="package" value="<?php echo $data->package?>"></div>
</li>
<li>
<label>suffix:</label>
<div><input class="short text" type="text" id="suffix" name="suffix" value="<?php echo $data->suffix?>"></div>
</li>
<li>
<label>user:</label>
<div><input class="short text" type="text" id="user" name="user" value="<?php echo $data->user?>"></div>
</li>
<li>
<div><input type="submit" value="修  改"></div>
</li>
</ul>
</form>
</div>
</div>
