<?php
$domain = Site::instance()->get('domain');
$redirect = '?redirect=/contact-us';
$customer_id = Customer::logged_in();
if($customer_id){
	$celebrity = Customer::instance($customer_id)->is_celebrity();
    if($celebrity)
    {
        $session = Session::instance();
        $celename = $session->get('celebrity');     
    }
}else{
	$celebrity = '';
}
$url1 = parse_url(Request::$referrer);
?>
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">home</a> > blogger wanted
			</div>
			<div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="<?php echo LANGPATH.$url1['path']; ?>">Zur端ck</a>
			</div>
		</div>
	</div>
	<!-- main begin -->
	<section class="container blogger-wanted">
		<div class="blogger-img hidden-xs">
			<div class="step-nav step-nav1">
                <ul class="clearfix">
                    <li>Fashion Programm<em></em><i></i></li>
                    <li>Lesen Sie die Politik<em></em><i></i></li>
                    <li>Informationen Bestätigen<em></em><i></i></li>
                    <li class="current">Holen Sie sich einen Banner<em></em><i></i></li>
                </ul>
            </div>
		</div>
		<article class="row">
			<div class="col-sm-1 hidden-xs"></div>
			<div class="col-sm-10 col-xs-12">
				<div class="fashion-tit">Holen Sie sich einen Banner</div>
				<div class="fashion-banner">
					<p>Wählen Sie Ihren liebsten Choies VIP Icon, klicken Sie auf das Bild, um den Code zu erhalten.</p>
		            <p>Wenn Sie zustimmen, Choies Banner zur Homepage Ihres Blogs, Lookbook-Seite oder andere Mode-Plattform Sites hinzuzufügen, werden Sie mehr Werbegeschenke bekommen, wenn Sie mehr Fans haben. </p>
		            <p>Wenn Sie ein YouTube-Konto haben, wo Banner nicht zulässig ist, stattdessen können Sie unseren Link <a href="<?php echo LANGPATH; ?>/" title="choies.com" class="red"> http://<?php echo $domain; ?></a> hinzufügen.</p>
				</div>
				<div class="banner-area">
					<table cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td class="col-xs-6">
									<a class="join_us" href="#">
										<img src="http://edm.choies.com/blogger/wanted_1_<?php echo LANGUAGE;?>.jpg" width="300" height="250"/>
									</a>
								</td>
								<td class="col-xs-6">
									<a class="join_us" href="#">
										<img src="http://edm.choies.com/blogger/wanted_2_<?php echo LANGUAGE;?>.jpg" width="300" height="250"/>
									</a>
								</td>
							</tr>
							<tr>
								<td class="col-xs-6">300*250</td>
								<td class="col-xs-6">300*250</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="banner-area">
					<table cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td class="col-xs-6">
									<a class="join_us" href="#">
										<img src="http://edm.choies.com/blogger/wanted_3_<?php echo LANGUAGE;?>.jpg" width="300" height="300"/>
									</a>
								</td>
								<td class="col-xs-6">
									<a class="join_us" href="#">
										<img src="http://edm.choies.com/blogger/wanted_4_<?php echo LANGUAGE;?>.jpg" width="300" height="300"/>
									</a>
								</td>
							</tr>
							<tr>
								<td class="col-xs-6">300*300</td>
								<td class="col-xs-6">300*300</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="banner-area">
					<table cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td class="col-xs-12">
									<a class="join_us" href="#">
										<img src="http://edm.choies.com/blogger/wanted_5_<?php echo LANGUAGE;?>.jpg" width="728" height="90" style="display:block;" class="mb10"/>
									</a>
									<a class="join_us" href="#">
										<img src="http://edm.choies.com/blogger/wanted_6_<?php echo LANGUAGE;?>.jpg" alt="Choies-The latest street fashion" width="728" height="90" style="display:block;" class="mb10"/>
									</a>
								</td>
							</tr>
							<tr>
								<td class="col-xs-12">728*90</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="banner-area">
					<table cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td class="col-xs-12">
									<a class="join_us col-xs-4" href="#">
									<img src="http://edm.choies.com/blogger/wanted_7_<?php echo LANGUAGE;?>.jpg" width="160" height="600" class="mr10"/>
									</a>
									<a class="join_us col-xs-4" href="#">
									<img src="http://edm.choies.com/blogger/wanted_8_<?php echo LANGUAGE;?>.jpg" width="160" height="600" class="mr10"/>
									</a>
									<a class="join_us col-xs-4" href="#">
									<img src="http://edm.choies.com/blogger/wanted_9_<?php echo LANGUAGE;?>.jpg" width="160" height="600" class="mr10"/>
									</a>
								</td>
							</tr>
							<tr>
								<td>160*600</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-sm-1 hidden-xs"></div>
		</article>
	</section>

	<!-- footer begin -->
	<footer></footer>

	<div id="site_link" style="width: 422px; height: 318px; top: 15px; left:20%; display: none;" class="hidden-xs">
		<div id="cboxWrapper" style="height: 368px; width: 472px;">
			<div>
				<div id="cboxTopLeft" style="float: left;"></div>
				<div id="cboxTopCenter" style="float: left; width: 422px;"></div>
				<div id="cboxTopRight" style="float: left;"></div>
			</div>
			<div style="clear: left;">
				<div id="cboxMiddleLeft" style="float: left; height: 318px;"></div>
				<div id="cboxContent" style="float: left; width: 422px; height: 318px;">
					<div id="cboxLoadedContent" style="display: block; width: 422px; overflow: auto; height: 288px;">
						<div id="inline_example2" style="padding:10px; background:#fff;">
							<textarea id="site_image" style="width: 380px; height: 270px; font-size:15px;" name="" rows="" cols="" onmousemove="this.select(),this.focus();"></textarea>
						</div>
					</div>
					<div class="closebtn">schließen</div>
				</div>
				<div id="cboxMiddleRight" style="float: left; height: 318px;"></div>
			</div>
			<div style="clear: left;">
				<div id="cboxBottomLeft" style="float: left;"></div>
				<div id="cboxBottomCenter" style="float: left; width: 422px;"></div>
				<div id="cboxBottomRight" style="float: left;"></div>
			</div>
		</div>
		<div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
	</div>
</section>

<script type="text/javascript">
    var domain = "<?php echo $domain; ?>";
var cidb = "<?php echo $celebrity ? '?cid=' . $celebrity.$celename['name'] : ''; ?>";
$(function(){
    $(".join_us").live("click",function(){
        var follow = $(this).children().attr('src');
        var img = '<img src="'+follow+'" title="Choies" alt="Choies-The latest street fashion" />'
        var link_text = '<a href="http://' + domain + cidb + '">' + img + '</a>';
        $("#site_image").val(link_text);
        $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
        $('#site_link').appendTo('body').fadeIn(320);
        return false;
    })
                
    $("#next").live('click', function(){
        $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
        $('#site_login').appendTo('body').fadeIn(320);
        return false;
    })
})
        
$(function(){
    $("#site_link .closebtn,#wingray").live("click",function(){
        $("#wingray").remove();
        $('#site_link').fadeOut(160).appendTo('#tab2');
        $('#site_login').fadeOut(160).appendTo('#tab2');
        return false;
    })
})
$(function(){
    $(".technical dd:even").css('background-color','#313131');
    return this;
})
</script>