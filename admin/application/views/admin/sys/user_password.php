<script type="text/javascript" src="/media/js/my_validation.js"></script>
<?php $user = User::instance()->logged_in(); ?>
<div id="do_left">
<div class="title">
<h2>User center</h2>
</div>
<div class="navigation">
<ul>

<li>User Manage
<ul>
<li><a href="/admin/user/password/<?php echo $user['id']; ?>">Profile Edit</a></li>
</ul>
</li>

</ul>
</div>
</div>

<div id="do_right">
<div class="box">
<h3>Profile Edit</h3>

<form action=" " method="post" id="form1" class="need_validation">
<input type="hidden" name="id" value="<?php echo $data['id'];?>">
<ul>

<li>
<label>Email：<span class="req">*</span></label>
<div>
<input class="text short required email" id="email" name="email" value="<?php echo $data['email'];?>" type="text">
<div class="errorInfo"></div>
</div>
</li>

<li>
<label>Name:</label>
<div>
<input class="text short" type="text" id="name" name="name" value="<?php echo $data['name'];?>">
<div class="errorInfo"></div>
</div>
</li>

<li>
<label>Password:</label>
<div>
<input class="text short required" data="{validation:{minlength:5}}" type="password" id="password" name="password" value="">
<div class="errorInfo"></div>
</div>
</li>

<li>
<label>Confirm Password:</label>
<div>
<input class="text short required" type="password"  data="{validation:{minlength:5,equalTo:'#password'}}" id="confirm_password" name="confirm_password" value="">
<div class="errorInfo"></div>
</div>
</li>

<li>
<div><input type="submit" value="Save"/></div>
</li>
</ul>
</form>
</div>
</div>
