<?php echo View::factory('admin/external/top')->render(); ?>
<body>
	<div id="wrapper">
		<ul id="topbar">
			<li><a class="button white fl" title="preview" href="/external/usa/index"><span class="icon_single preview"></span></a></li>
			<li class="s_1"></li>
			<li class="logo"><strong>Cofree</strong></li>
		</ul>
		<div id="content-login">
			<div class="logo"></div>
			<h2 class="header-login">Login </h2>
			<form id="box-login" action="" method="post">
				<p>
					<label class="req"> username </label>
					<br/>
					<input type="text" name="username" value="" id="username"/>
				</p>
				<p>
					<label class="req"> password </label>
					<br/>
					<input type="password" name="password" value="" id="password"/>
				</p>
				<p class="fr">
					<input type="submit" value="Login" class="button themed" id="login"/>
				</p>
				<div class="clear"></div>
			</form>
		</div>
	</div>
	<?php echo View::factory('admin/external/foot')->render(); ?>