<?php
echo View::factory('sys/sys_left')->render();
?>
<div id="do_right">
<div class="box">
<h3>管理 -> <a href="/sys/site/list" >站点列表</a> -> 站点信息修改</h3>

<form action="/sys/site/edit/<?php echo $data->id;?>" method="post" name="form1" id="form1">
<ul>
<li>
<label>选择产品线：</label>
<div>
<select class="drop" name="line_id">
<?php
$lines = site::get_lines();
foreach($lines as $k => $v)
{
    $line_id = $v->id;
?>
<option value="<?php echo $line_id;?>" <?php echo (($line_id==$data->id)?"selected":"");?>><?php echo $v->name?></option>
<?php }
?>
</select>
</div>
</li>
<li>
<label>域名：<span class="req">*</span></label>
<div><input class="short text" id="domain" name="domain" value="<?php echo $data->domain?>" type="text"></div>
</li>
<li>
<label>邮箱:</label>
<div><input class="short text" type="text" id="email" name="email" value="<?php echo $data->email?>"></div>
</li>
<li>
<label>meta_title:</label>
<div><input class="text long" type="text" id="meta_title" name="meta_title" value="<?php echo $data->meta_title?>"></div>
</li>
<li>
<label>meta_keywords:</label>
<div><input class="text long" type="text" id="meta_keywords" name="meta_keywords" value="<?php echo $data->meta_keywords?>"></div>
</li>
<li>
<label>meta_description:</label>
<div><input class="text long" type="text" id="meta_description" name="meta_description" value="<?php echo $data->meta_description?>"></div>
</li>
<li>
<label>route_type:</label>
<div><select name="route_type">
<option value="0" <?php echo (($data->route_type==0)?"selected":"");?>>产品分类/详细页面以id为关键词</option>
<option value="1" <?php echo (($data->route_type==1)?"selected":"");?>>产品分类/详细页面以产品名为关键词</option>
</select></div>
</li>
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
<label>page_count:</label>
<div><input class="short text" type="text" id="page_count" name="page_count" value="<?php echo $data->page_count?>"></div></li>
<li>
<label>stat_code:</label>
<div><textarea id="stat_code" name="stat_code" class="textarea" rows="6" cols="60" tabindex="1"><?php echo $data->stat_code?></textarea></div>
</li>
<li>
<label>robots:</label>
<div><textarea id="robots" name="robots" class="textarea" rows="6" cols="60" tabindex="1"><?php echo $data->robots?></textarea></div>
</li>
<li>
<label>是否有效:</label>
<div><input class="radio" type="radio" name="is_active" value="1" <?php echo (($data->is_active==1)?"checked":"");?>><label class="choice">有效</label>   <input class="radio" type="radio" name="is_active" value="0" <?php echo (($data->is_active==0)?"checked":"");?>><label class="choice">无效</label></div>
</li>
<li>
<div><input type="submit" value="修  改"></div>
</li>
</ul>
</form>
</div>
</div>
