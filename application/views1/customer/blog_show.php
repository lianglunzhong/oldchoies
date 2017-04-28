<?php
$message = Message::get();
$referrer = Request::$referrer;
$url1 = parse_url($referrer);
$uri = '/' . Request::instance()->uri();
$onshowed = 0;
if ($message)
{
    $onshowed = 1;
}
elseif ($url1['path'] == $uri)
{
    parse_str($url1['query'], $query1);
    parse_str($_SERVER['QUERY_STRING'], $query2);
    $_page2 = Arr::get($query1, 'page2', 1);
    $page2 = Arr::get($query2, 'page2', 1);
    if ($_page2 != $page2)
        $onshowed = 1;
}
$c_admin = DB::select('admin_id')->from('celebrities_celebrits')->where('id', '=', $cele_id)->execute()->get('admin_id');
$admin_email = DB::select('email')->from('auth_user')->where('id', '=', $c_admin)->execute()->get('email');
$admin_name = substr($admin_email, 0, strpos($admin_email, '@'));

if(empty(LANGUAGE))
{
	$lists = Kohana::config('/customer/my_blog_show.en');
}
else
{
	$lists = Kohana::config('/customer/my_blog_show.'.LANGUAGE);
}

?>
<!-- main begin -->
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/"><?php echo $lists['title1']; ?></a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > <?php echo $lists['title2']; ?></a> > <?php echo $lists['title3']; ?>
			</div>
			
		</div>
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
				<ul class="JS_tab1 detail_tab detail-tab hidden-xs">
            <li <?php if (!$onshowed) echo 'class="on"'; ?>><?php echo $lists['TO SHOW']; ?></li>
            <li <?php if ($onshowed) echo 'class="on"'; ?>><?php echo $lists['SHOWED']; ?></li>
				</ul>
				<div class="JS_tabcon1 detail-tabcon hidden-xs">
					<div <?php echo $onshowed ? 'style="display:none;"' : 'style="display:block;"'; ?>>
						<p><?php echo $lists['How to Complete a Show']; ?></p>
						<p>
							<span><?php echo $lists['1. Copy the Item Link and Paste it to your Blog Show Picture']; ?></span>
							<span><?php echo $lists['2. Write your show url in the right column and click "Submit"']; ?></span>
						</p>
						<div class=" table-responsive">
							<table class="user-table">
								<tbody>
									<tr>
										<th width="20%"><?php echo $lists['Show No']; ?></th>
										<th width="40%"><?php echo $lists['Product Info']; ?></th>
										<th width="40%"><?php echo $lists['Show Link']; ?></th>
									</tr>
								<?php
			                    foreach ($toshow as $key => $data)
			                    {
			                        $product_id = Product::get_productId_by_sku($data['sku']);
			                        ?>
									<tr>
										<td class="listNumber"><?php echo $key + 1; ?></td>
										<td>
											<div class="pr-info fix">
												<div class="left"><a><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 3); ?>" alt="" /></a></div>
												<div class="right">
												<p><?php echo $lists['Item#']; ?><?php echo $data['sku']; ?></p>
												<p><?php echo Product::instance($product_id)->get('name'); ?></p>
												<p>
													<?php echo $lists['Order NO']; ?>
													<a><?php echo $data['ordernum']; ?></a>
												</p>
												<input class="copy-link btn btn-primary btn-xs" type="button" value="<?php echo $lists['Copy Item Link']; ?>" style="padding:0 5px;" name="<?php echo Product::instance($product_id)->permalink() . '?cid=' . $cele_id . $admin_name; ?>">
											</div>
										</td>
										<td>
											<div class="show-link left">
												<form action="/customer/add_url?<?php echo http_build_query($_GET); ?>" method="post">
										<input type="hidden" name="cele_id" value="<?php echo $cele_id; ?>" />
                                        <input type="hidden" name="ordernum" value="<?php echo $data['ordernum']; ?>" />
                                        <input type="hidden" name="sku" value="<?php echo $data['sku']; ?>" />
													<input class="link-input text text-long" type="url" value="" name="url[]">
													<a class="addMoreLink a-red"><?php echo $lists['add one more link']; ?></a>
													<input class="link-btn btn btn-primary btn-xs" style="margin-top:5px;" type="submit" value="<?php echo $lists['Submit']; ?>">
												</form>
											</div>
										</td>
									</tr>
								<?php
								}
								?>
								</tbody>
							</table>
							<?php
	                        echo $pagination1;
	                        ?>
						</div>

					</div>
					<div <?php echo $onshowed ? 'style="display:block;"' : 'style="display:none;"'; ?>>
						<p><?php echo $lists['How to Complete a Show']; ?></p>
						<p>
							<span><?php echo $lists['1. Copy the Item Link and Paste it to your Blog Show Picture']; ?></span>
							<span><?php echo $lists['2. Write your show url in the right column and click "Submit"']; ?></span>
						</p>
						<div class=" table-responsive">
							<table class="user-table">
								<tbody>
									<tr>
										<th width="20%"><?php echo $lists['Show No']; ?></th>
										<th width="40%"><?php echo $lists['Product Info']; ?></th>
										<th width="40%"><?php echo $lists['Show Link']; ?></th>
									</tr>
			                    <?php
			                    foreach ($showed as $key => $data)
			                    {
			                        $product_id = Product::get_productId_by_sku($data['sku']);
			                        ?>
									<tr>
										<td class="listNumber"><?php echo $key; ?></td>
										<td>
											<div class="pr-info fix">
												<div class="left"><a><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 3); ?>" alt="" /></a></div>
												<div class="right">
												<p>Item# :<?php echo $data['sku']; ?></p>
												<p><?php echo Product::instance($product_id)->get('name'); ?></p>
												<p>
													Order NO.:
													<a><?php echo $data['ordernum']; ?></a>
												</p>
												<input class="copy-link btn btn-primary btn-xs" style="padding:0 5px;" type="button"  name="<?php echo Product::instance($product_id)->permalink() . '?cid=' . $cele_id . $admin_name; ?>" value="<?php echo $lists['Copy Item Link']; ?>" />
											</div>
										</td>
										<td>
											<div class="show-link">
												<div class="showurl">
										<?php
                                        $urls = DB::select('id', 'url')->from('celebrities_celebrityorder')->where('ordernum', '=', $data['ordernum'])->and_where('sku', '=', $data['sku'])->execute()->as_array();
                                        foreach ($urls as $url):
                                            ?>
													<a href="<?php echo $url['url']; ?>" class="showLinkhref"><?php echo $url['url']; ?></a>
										<?php
                                        endforeach;
                                        ?>
												</div>
													<div style="display:none;" class="edit-url">
													<form action="/customer/edit_url?<?php echo http_build_query($_GET); ?>" method="post">
												<input type="hidden" name="cele_id" value="<?php echo $cele_id; ?>" />
                                                <input type="hidden" name="ordernum" value="<?php echo $data['ordernum']; ?>" />
                                                <input type="hidden" name="sku" value="<?php echo $data['sku']; ?>" />
												<?php foreach ($urls as $url): ?>
                                                    <input type="hidden" name="id[]" value="<?php echo $url['id'] ?>" />
                                                    <input type="text" name="url[]" class="link-input" value="<?php echo $url['url'] ?>" />
                                                    <?php
                                                endforeach;
                                                ?>
															<br>
															<div class="more"></div>
															<a class="addMoreLink a-red"><?php echo $lists['add one more link']; ?></a>
															<br>
															<input type="submit" style="margin-top:5px;" value="<?php echo $lists['Submit']; ?>" class="btn btn-primary btn-xs">
															<a style="text-decoration:underline;margin-left:10px;" class="link-cancel" href="#"><?php echo $lists['Cancel']; ?></a>
															<br>
															<br>
														</form>
													</div>
													<input type="button" value="<?php echo $lists['Edit']; ?>" class="btn btn-default btn-xs link-edit" name="">
											</div>
										</td>
									</tr>
								<?php
								}
								?>
								</tbody>
							</table>
							<?php
	                        echo $pagination2;
	                        ?>
						</div>
					</div>
				</div>
				<div class="blgger-show-mobile visible-xs-block hidden-sm hidden-md hidden-lg">
					<ul class="detail-tab">
						<li class="on"><?php echo $lists['TO SHOW']; ?></li>
					</ul>
					<div class="detail-tabcon">
						<div>
							<p><?php echo $lists['How to Complete a Show']; ?></p>
							<p>
								<span><?php echo $lists['1. Copy the Item Link and Paste it to your Blog Show Picture']; ?></span>
								<span><?php echo $lists['2. Write your show url in the right column and click "Submit"']; ?></span>
							</p>
							<div class=" table-responsive">
								<table class="user-table">
									<tbody>
										<tr>
											<th width="20%"><?php echo $lists['Show No']; ?></th>
											<th width="40%"><?php echo $lists['Product Info']; ?></th>
											<th width="40%"><?php echo $lists['Show Link']; ?></th>
										</tr>
									<?php
				                    foreach ($toshow as $key => $data)
				                    {
				                        $product_id = Product::get_productId_by_sku($data['sku']);
				                        ?>
										<tr>
											<td><?php echo $key + 1; ?></td>
											<td>
												<div class="pr-info fix">
													<div class="left"><a><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 3); ?>" alt="" /></a></div>
													<div class="right">
													<p><?php echo $lists['Item#']; ?> <?php echo $data['sku']; ?></p>
													<p><?php echo Product::instance($product_id)->get('name'); ?></p>
													<p>
														<?php echo $lists['Order NO']; ?>
														<a><?php echo $data['ordernum']; ?></a>
													</p>
													<input class="copy-link btn btn-primary btn-xs" type="button" style="padding:0 5px;" value="<?php echo $lists['Copy Item Link']; ?>" name="<?php echo Product::instance($product_id)->permalink() . '?cid=' . $cele_id . $admin_name; ?>">
													</div>
												</div>
											</td>
											<td>
												<div class="show-link left">
													<form action="/customer/add_url?<?php echo http_build_query($_GET); ?>" method="post">
														<input type="hidden" name="cele_id" value="<?php echo $cele_id; ?>" />
				                                        <input type="hidden" name="ordernum" value="<?php echo $data['ordernum']; ?>" />
				                                        <input type="hidden" name="sku" value="<?php echo $data['sku']; ?>" />
														<input class="link-input text text-long" type="url" value="" name="url[]">
														<a class="addMoreLink a-red"><?php echo $lists['add one more link']; ?></a>
														<input class="link-btn btn btn-primary btn-xs" style="margin-top:5px;" type="submit" value="<?php echo $lists['Submit']; ?>">
													</form>
												</div>
											</td>
										</tr>
									<?php
									}
									?>
									</tbody>
								</table>
							</div>
					</div>
				</div>
				<ul class="detail-tab">
					<li class="on"><?php echo $lists['Showed']; ?></li>
				</ul>
				<div class="detail-tabcon">
						<p><?php echo $lists['How to Complete a Show']; ?></p>
						<p>
							<span><?php echo $lists['1. Copy the Item Link and Paste it to your Blog Show Picture']; ?></span>
							<span><?php echo $lists['2. Write your show url in the right column and click "Submit"']; ?></span>
						</p>
						<div class=" table-responsive">
							<table class="user-table">
								<tbody>
									<tr>
										<th width="20%"><?php echo $lists['Show No']; ?></th>
										<th width="40%"><?php echo $lists['Product Info']; ?></th>
										<th width="40%"><?php echo $lists['Show Link']; ?></th>
									</tr>
								<?php
			                    foreach ($showed as $key => $data)
			                    {
			                        $product_id = Product::get_productId_by_sku($data['sku']);
			                        ?>
									<tr>
										<td><?php echo $key; ?></td>
										<td>
											<div class="pr-info fix">
												<div class="left"><a><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 3); ?>" alt="" /></a></div>
												<div class="right">
												<p><?php echo $lists['Item#']; ?><?php echo $data['sku']; ?></p>
												<p><?php echo Product::instance($product_id)->get('name'); ?></p>
												<p>
													<?php echo $lists['Order NO']; ?>
													<a><?php echo $data['ordernum']; ?></a>
												</p>
												<input class="copy-link btn btn-primary btn-xs" type="button"  style="padding:0 5px;" value="<?php echo $lists['Copy Item Link']; ?>" name="<?php echo Product::instance($product_id)->permalink() . '?cid=' . $cele_id . $admin_name; ?>" value="<?php echo $lists['Copy Item Link']; ?>">
												</div>
											</div>
										</td>
										<td>
											<div class="show-link">
												<div class="showurl">
												<?php
		                                        $urls = DB::select('id', 'url')->from('celebrities_celebrityorder')->where('ordernum', '=', $data['ordernum'])->and_where('sku', '=', $data['sku'])->execute()->as_array();
		                                        foreach ($urls as $url)
		                                        {
                                            	?>
												<a href="<?php echo $url['url']; ?>" class="showLinkhref"><?php echo $url['url']; ?></a>
												<?php
			                                    }
			                                    ?>
												</div>
													<div style="display:none;" class="edit-url">
														<form action="/customer/edit_url?<?php echo http_build_query($_GET); ?>" method="post">
															<input type="hidden" name="cele_id" value="<?php echo $cele_id; ?>" />
			                                                <input type="hidden" name="ordernum" value="<?php echo $data['ordernum']; ?>" />
			                                                <input type="hidden" name="sku" value="<?php echo $data['sku']; ?>" />
														<?php
														foreach ($urls as $url)
														{ 
														?>
															<input type="hidden" value="<?php echo $url['id'] ?>" name="id[]">
															<input type="text" value="<?php echo $url['url'] ?>" class="link-input" name="url[]">
														<?php
		                                                }
		                                                ?>
															<br>
															<div class="more"></div>
															<a class="addMoreLink a-red"><?php echo $lists['add one more link']; ?></a>
															<br>
															<input type="submit" style="margin-top:5px;" value="<?php echo $lists['Submit']; ?>" class="btn btn-primary btn-xs">
															<a style="text-decoration:underline;margin-left:10px;" class="link-cancel" href="#"><?php echo $lists['Cancel']; ?></a>
															<br>
															<br>
														</form>
													</div>
													<input type="button" value="<?php echo $lists['Edit']; ?>" class="btn btn-default btn-xs link-edit" name="">
											</div>
										</td>
									</tr>
								<?php
								}
								?>
								</tbody>
							</table>
							<?php
	                        echo $pagination2;
	                        ?>						
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>
</section>
<div id="site_link">
    <div id="cboxWrapper" style="height: 168px; width: 472px;"><div>
            <div id="cboxTopLeft" style="float: left;"></div>
            <div id="cboxTopCenter" style="float: left; width: 422px;"></div>
            <div id="cboxTopRight" style="float: left;"></div></div>
        <div style="clear: left;"><div id="cboxMiddleLeft" style="float: left; height: 118px;"></div>
            <div id="cboxContent" style="float: left; width: 422px; height: 118px;">
                <div id="cboxLoadedContent" style="display: block; width: 422px; overflow: auto; height: 98px;">
                    <div style="padding:10px; background:#fff;" id="inline_example2">
                        <textarea id="site_image" onmousemove="this.select(),this.focus();" cols="" rows="" name="" style="width: 370px; height: 75px; font-size:15px;padding:5px 20px;"></textarea>
                    </div>
                </div>
                <div class="closebtn" style="top: 125px;">close</div>
            </div>
            <div id="cboxMiddleRight" style="float: left; height: 118px;"></div>
        </div>
        <div style="clear: left;">
            <div id="cboxBottomLeft" style="float: left;"></div>
            <div id="cboxBottomCenter" style="float: left; width: 422px;"></div>
            <div id="cboxBottomRight" style="float: left;"></div>  
        </div>
    </div>
    <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>
<script type="text/javascript">

    $(function(){
        $(".link-edit").live('click', function(){
            $(this).parent().parent().find(".showurl").hide();
            $(this).parent().find(".edit-url").show();
        })
                
        $(".link-cancel").live('click', function(){
            $(this).parent().parent().parent().parent().find(".showurl").show();
            $(this).parent().parent().hide();
            return false;
        })
                
        $(".copy-link").live('click', function(){
            var link = $(this).attr('name');
            $("#site_image").val(link);
            $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
            $('#site_link').appendTo('body').fadeIn(320);
            return false;
        })
        $("#site_link .closebtn,#wingray").live("click",function(){
            $("#wingray").remove();
            $('#site_link').fadeOut(160).appendTo('#tab2');
            $('#site_login').fadeOut(160).appendTo('#tab2');
            return false;
        })
    })
	
    $(function(){
        $('.addMoreLink').click(function(){
        	var add=$(this).prev('.link-input')
            $('<input class="link-input text text-long" type="url" name="url[]" value="">').insertAfter(add);
        })
        $('.edit-url .addMoreLink').click(function(){
            var more=$(this).parent().find('.more');
            $('<input type="text" name="more[]" class="link-input text text-long" value="" />').appendTo(more);
        })
    })
    $(function(){
    $(".link-edit").live('click', function(){
        $(this).parent().parent().find(".showurl").hide();
        $(this).parent().find(".edit-url").show();
    })
            
    $(".link-cancel").live('click', function(){
        $(this).parent().parent().parent().parent().find(".showurl").show();
        $(this).parent().parent().hide();
        return false;
    })
            
    $(".copy-link").live('click', function(){
        var link = $(this).attr('name');
        $("#site_image").val(link);
        $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
        $('#site_link').appendTo('body').fadeIn(320);
        return false;
    })
    $("#site_link .closebtn,#wingray").live("click",function(){
        $("#wingray").remove();
        $('#site_link').fadeOut(160).appendTo('#tab2');
        $('#site_login').fadeOut(160).appendTo('#tab2');
        return false;
    })
})

</script>