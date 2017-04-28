<?php
if(empty(LANGUAGE))
{
	$lists = Kohana::config('/customer/change_password.en');
}
else
{
	$lists = Kohana::config('/customer/change_password.'.LANGUAGE);
}//var_dump($lists['password']['maxlength ']);die;
?>
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/"><?php echo $lists['title1']; ?></a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > <?php echo $lists['title2']; ?></a> > <?php echo $lists['title3']; ?>
			</div>
		</div>
		<?php echo Message::get(); ?>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory('customer/left'); ?>
<?php echo View::factory('customer/left_1'); ?>
			<article class="user col-sm-9 col-xs-12">
				<div class="tit">
					<h2><?php echo $lists['title4']; ?></h2>
				</div>
				<div class="row">
					<div class="col-sm-2 hidden-xs"></div>
					<form class="user-form user-share-form col-sm-8 col-xs-12" method="post" action="">
						<p class="col-sm-12 col-xs-12 change-password"><?php echo $lists['title5']; ?></p>
						<ul>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span><?php echo $lists['Former Password']; ?></label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="oldpassword">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span><?php echo $lists['New Password']; ?></label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" id="password" name="password">
								</div>
							</li>
							<li>
								<label class="col-sm-3 col-xs-12"><span>*</span><?php echo $lists['Confirm Password']; ?></label>
								<div class="col-sm-9 col-xs-12">
									<input type="password" class="text text-long col-sm-12 col-xs-12" value="" name="confirmpassword">
								</div>
							</li>
							<li>
								<label class="col-sm-3 hidden-xs">&nbsp;</label>
								<div class="btn-grid12 col-sm-9 col-xs-12">
									<input type="submit" class="btn btn-primary btn-sm" value="<?php echo $lists['Change Password']; ?>" name="">
								</div>
							</li>
						</ul>
					</form>
					<div class="col-sm-2 hidden-xs"></div>
				</div>
			</article>
		</div>
	</div>
</section>
<script type="text/javascript">

    $(".user-share-form").validate({
        rules: {
            oldpassword: {    
                required: true,
                minlength: 5,
                maxlength:20
            },
            password: {
                required: true,
                minlength: 5,
                maxlength:20
            },
            confirmpassword: {
                required: true,
                minlength: 5,
                maxlength:20,
                equalTo: "#password"
            }
        },
        messages: {
            oldpassword: {
                required: '<?php echo $lists['oldpassword']['required']; ?>',
                minlength: '<?php echo $lists['oldpassword']['minlength']; ?>',
                maxlength: '<?php echo $lists['oldpassword']['maxlength']; ?>'
            },
            password: {
                required:  '<?php echo $lists['password']['required']; ?>',
                minlength: '<?php echo $lists['password']['minlength']; ?>',
                maxlength: '<?php echo $lists['password']['maxlength']; ?>'
            },
            confirmpassword: {
                required: '<?php echo $lists['confirmpassword']['required']; ?>',
                minlength:'<?php echo $lists['confirmpassword']['minlength']; ?>',
                maxlength:'<?php echo $lists['confirmpassword']['maxlength']; ?>',
                equalTo:  '<?php echo $lists['confirmpassword']['equalTo']; ?>'
            }
        }
    });
</script>
