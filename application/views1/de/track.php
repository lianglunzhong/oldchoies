		<section id="main">
			<!-- crumbs -->
			<div class="container visible-xs-inline hidden-sm hidden-md hidden-lg col-xs-12">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">home</a>
						<a href="<?php echo LANGPATH; ?>/customer/summary"> > KONTOÜBERSICHT</a> > Bestellung Verfolgen
					</div>
					<?php echo Message::get(); ?>
				</div>
			</div>
			<!-- main-middle begin -->
			<div class="container">
				<div class="cart row">
					<div class="order-track-tit col-xs-12">
						<h4>Bestellung Verfolgen </h4>
					</div>
					<div class="order-track-con">
						<form onsubmit="return false" class="form col-xs-12 col-sm-6" method="" action="#">
							<ul>
								<li>
									<input type="text"  value="" id="code" class="text " name="code" value="">
								</li>
								<li>
									<input type="button" id="do_check" class="btn btn-primary btn-sm" value="VERFOLGEN">
								</li>
							</ul>
						</form>
			            <script type="text/javascript">
			                $(function(){
			                    $("#do_check").bind("click",function(){
			                        $("#msg").hide();
			                        $("#track_info").hide();
			                        $(".track-none").hide();
			                        var code = $("#code").val()
			                        $.ajax({
			                            type: "POST",
			                            url: "/tracks/ajax_orderdata",
			                            dataType: "json",
			                            data: "code="+code,
			                            success: function(data)
			                            {
			                              	if(data.result=="has_order")
			                              	{
				                                $("#order_date").html(data.data.created);
				                                $("#order_no").html(data.data.ordernum);
				                                $("#order_total").html(data.data.amount);
				                                $("#order_shipping").html(data.data.shipping);
				                                $("#order_status").html(data.data.order_status);
				                                $("#order_action").html('<a href="<?php echo LANGPATH; ?>/order/view/'+data.data.ordernum+'">View Details</a>');
				                                $(".track-none").fadeIn(620);
			                              	}
			                            }
			                        });
			                        $.ajax({
			                            type: "POST",
			                            url: "/tracks/ajax_pagedata1?lang=<?php echo LANGUAGE; ?>",
			                            dataType: "json",
			                            data: "code="+code,
			                            success: function(data)
			                            {
			                              	if(data.result=="login")
			                              	{
				                                $("#tmp_code").attr("value",code);
				                                var top = getScrollTop();
				                                top = top - 35;
				                                $('body').append('<div class="JS_filter opacity hidden-xs"></div>');
				                                $('.JS_popwincon').css({
				                                    "top": top, 
				                                    "position": 'absolute'
				                                });
				                                $('.JS_popwincon').appendTo('body').fadeIn(320);
				                                $('.JS_popwincon').show();
			                              	}
			                              	else if(data.result=="noData")
			                              	{
				                                $("#msg>p").html(data.msg).fadeIn(320)
				                                $("#msg").fadeIn(620)
				                                window.location.href = '#message';
			                              	}
			                              	else if(data.result=="success")
			                              	{
				                                $("#msg").hide();
				                                var item = eval(data.data)
				                                $("#track_url").html('');
				                                $("#shipping_title").html('');
				                                $("#history").html('');
				                                $(".detail_tabcon").html('');
				                                for(var i=0; i<item.length;i++)
				                                {
				                                  	$("#ordernum").html(item[i]['ordernum']);
				                                  	$("#date").html(item[i]['created']);
				                                  	if(i===0)
				                                  	{
					                                    var cls = "class='current'";
					                                    var hd = "";
				                                  	}
				                                  	else
				                                  	{
					                                    var cls = "";
					                                    var hd = "hide";
			                                  		}

				                                  	$(".detail_tabcon").append('<div class="bd '+hd+'">\
			                                          <ul class="box1 fix">\
			                                            <li><b>Sendungnummer.:</b> <span id="track_no'+i+'"></span></li>\
			                                            <li><b>Status:</b> <span id="status'+i+'"></span></li>\
			                                            <li><b>Herkunftsland:</b><span id="send_country'+i+'"></span></li>\
			                                            <li><b>Zielland:</b><span id="dest_country'+i+'"></span></li>\
			                                          </ul>\
			                                          <dl class="box3" id="history'+i+'"></dl>\
			                                          <dl class="box3">\
			                                            <dt>Versandt Nach:</dt>\
			                                            <dd id="shipping_address'+i+'"></dd>\
			                                            <dd id="shipping_country'+i+'"></dd>\
			                                            <dd id="shipping_zip'+i+'"></dd>\
			                                            <dd id="shipping_phone'+i+'"></dd>\
			                                          </dl>\
			                                        </div>');
				                                  	if(item.length>1)
				                                  	{
					                                    $("#shipping_title").append("<li "+cls+">Paket"+(i+1)+"</li>");
					                                    $("#track_url").append("<li>Paket "+(i+1)+" Sendungnummer.: "+item[i]['tracking_code']+"</li><li>Verfolgungslink: <a href='#'>"+item[i]['tracking_link']+"</a></li>")
				                                  	}
				                                  	else
				                                  	{
				                                    	$("#track_url").append("<li>Sendungnummer: "+item[i]['tracking_code']+"</li><li>Verfolgungslink: <a href='"+item[i]['tracking_link']+"'>"+item[i]['tracking_link']+"</a></li>")
				                                  	}

                                              if(item[i]['history'])
                                              {
				                                  	if(item[i]['history'].length>0)
				                                  	{
					                                  	$("#status"+i).html(item[i]['status']);
					                                  	$("#send_country"+i).html(item[i]['send_country']);
					                                  	$("#dest_country"+i).html(item[i]['dest_country']);
					                                  	$("#shipping_address"+i).html(item[i]['shipping_address']+','+item[i]['shipping_city']+','+item[i]['shipping_state']);
					                                  	$("#shipping_country"+i).html(item[i]['shipping_country']);
					                                  	$("#shipping_zip"+i).html(item[i]['shipping_zip']);
					                                  	$("#shipping_phone"+i).html(item[i]['shipping_phone']);
												
					                                  	$("#track_no"+i).html(item[i]['tracking_code']);
					                                  	if(typeof(item[i]['history'])!="undefined")
					                                  	{
					                                    	$("#history"+i).append("<dt>Zielland Historie</dt>");
					                                    	for (var l = 0; l < item[i]['history'].length; l++)
					                                    	{
					                                      		$("#history"+i).append("<dd>"+item[i]['history'][l]['a']+"<span>"+item[i]['history'][l]['z']+"</span></dd>");
					                                    	}
			                                  			}				                       
			                               	 		}	                  
					                            }
		                                  		else
				                                {
				                                  	$(".JS_tabcon").html('');
				                                }						                                                         
			                                	}
			                                	$("#track_info").fadeIn(620);
			                              	}
			                            },
			                            error:function(){
			                              $("#msg").fadeOut(320);
			                              $("#track_info").fadeOut(320);
			                              $("#msg>p").html("Error.").fadeIn(320)
			                              $("#msg").fadeIn(620)
			                             
			                            }
			                        });
			                    })
			                })
			            </script>
						<dl class="right col-xs-12 col-sm-6">
							<dt>Tipps:</dt>
		                    <dd>*Bitte geben Sie Bestellnummer oder Sendungnummer ein, um Ihre Bestellungen zu verfolgen.</dd>
		                    <dd>*Sie können sich in Ihrem Konto anmelden und finden Sie "Bestellhistorie" und verfolgen Sie Ihren Bestellstatus dort mit alle Informationen Ihrer Bestellungen.</dd>
		                    <dd>*Manchmal können einige Kunden wegen der Netzwerkzugriff Kontrolle in ihren Ländern und Regionen ihre Bestellung hier nicht verfolgen. Für dieses Problem entschuldigen wir uns. In diesem Fall können Sie uns per Email <a style="display:inline-block;margin-left:5px;" href="mailto:service_de@choies.com" class="a-underline a-red">service@choies.com</a> kontaktieren und unser Kundenservice werden Ihnen schnell wie möglich helfen.
							<dd>* Während der Ferienzeit werden Bestellungen mit Standardversand nicht mehr verfolgbar sein, wenn die Sendungen in den Vereinigten Staaten eingegangen sind. Denn USPS Website wird den Status der Sendung nicht mehr aktualisieren. In der Regel werden Sie Ihr Paket in etwa 20 Tage erhalten, bitte gedulden Sie noch einige Tage. Falls Sie es in mehr als 20 Tage noch nicht erhaltet haben, kontaktieren Sie bitte USPS oder das lokale Postamt für weitere Informationen.
							</dd>
		                    </dd>
							
						</dl>
					</div>
				</div>
				<!--无物流 -->
				<div id="msg" class="track-con-no" style="display:none;">
					<p class="red" style="">Sorry, no tracking information found by your order No. or tracking code.</p>
				</div>
				<!--未发货无物流 -->
				<div class="track-none" style="display:none;">
					<div class="order-history">
						<div class="table-responsive">
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tbody>
									<tr bgcolor="#fafafa">
										<th width="20%"><strong>Bestelldatum</strong></th>
			                         	<th width="20%"><strong>Bestellnummer</strong></th>
			                          	<th width="15%"><strong>Gesamtsumme</strong></th>
			                          	<th width="15%"><strong>Lieferung</strong></th>
			                          	<th width="15%"><strong>Bestellstatus</strong></th>
			                          	<th width="15%"><strong>Aktion</strong></th>
									</tr>
									<tr bgcolor="#fff">
                      <td id="order_date"></td>
                      <td id="order_no"></td>
                      <td id="order_total"></td>
                      <td id="order_shipping"></td>
                      <td id="order_status"></td>
                      <td id="order_action"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!--有物流 -->
				<div class="track-con" id="track_info" style="display:none;">
					<ul class="box1">
						<li><b>Bestellnummer.:</b><span id="ordernum"></span></li>
                    	<li><b>Bestelldatum:</b><span id="date"></span></li>
					</ul>

					<ul class="box2" id="track_url">
					</ul>
          <ul class="JS_tab detail_tab fix" id="shipping_title"></ul>
		
					<div class="track-detail hidden-xs">
		
						<div class="JS_tabcon detail_tabcon">
							<div class="bd">
								<ul class="box1 row">
									<li class="col-xs-12 col-sm-6"><b class="col-xs-12 col-sm-2" style="padding:0;">Sendungnummer:</b> <span class="col-xs-12 col-sm-4" id="track_no"></span>
									</li>
									<li class="col-xs-12 col-sm-6"><b>Status:</b><span id="status"></span></li>
									<li class="col-xs-12 col-sm-6"><b>Herkunftsland:</b> <span id="send_country"></span></li>
									<li class="col-xs-12 col-sm-6"><b>Zielland:</b><span id="dest_country"></span></li>
								</ul>
								<dl class="box3" id="history">
								</dl>
								<dl class="box3">
									<dt>Versandt Nach:</dt>
                <dd id="shipping_address"></dd>
                <dd id="shipping_country"></dd>
                <dd id="shipping_zip"></dd>
                <dd id="shipping_phone"></dd>
								</dl>
							</div>
							<div class="bd hide">111</div>
						</div>
					</div>

				</div>
				<p>
					<img src="/assets/images/card4.jpg">
				</p>
			</div>
		</section>
		<!-- footer begin -->
<!-- JS_popwincon -->
<div class="JS_popwincon hidden-xs track-pop w-signup hide" >
			<a class="JS_close2 close-btn3"></a>
			<div>
				<div>
					<h3>CHOIES Mitglied Anmelden</h3>
					<form class="signin-form sign-form form" method="post" action="<?php echo LANGPATH; ?>/customer/login?redirect=/tracks/track_order">
						<input id="tmp_code" type="hidden" value="" name="tmp_code">
						<ul>
							<li>
								<input class="text" type="text" name="email" value="">
							</li>
							<li>
								<input class="text" type="password" name="password" value="">
							</li>
							<li>
								<input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="ANMELDEN"><a href="<?php echo LANGPATH; ?>/customer/forgot_password" class="text-underline">Passwort vergessen?</a>
                            </li>
                            <li>
								<?php
                                $redirect = "tracks/track_order";
                                $page = isset($_SERVER['HTTP_SELF']) ? 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_SELF'] . '/' . htmlspecialchars($redirect) : 'http://' . $_SERVER['HTTP_HOST'] . '/' . htmlspecialchars($redirect);
                                $facebook = new facebook();
                                $loginUrl = $facebook->getFromLoginUrl($page, array('scope' => array('email')));
                                ?>
                                <a href="<?php echo $loginUrl; ?>" class="facebook-btn">Sign in with Facebook</a>
                             </li>
                       </ul>
                 </form>
            </div>
       </div>  
</div> 
		
		<div id="gotop" class="hide">
			<a href="#" class="xs-mobile-top"></a>
		</div>
        <script type="text/javascript">
			function getScrollTop() {
				var scrollPos;
				if (window.pageYOffset) {
					scrollPos = window.pageYOffset;
				} else if (document.compatMode && document.compatMode != 'BackCompat') {
					scrollPos = document.documentElement.scrollTop;
				} else if (document.body) {
					scrollPos = document.body.scrollTop;
				}
				return scrollPos;
			}
			 $(".JS_close2,.JS_filter").live("click", function() {
				$(".JS_filter").remove();
				$('.JS_popwincon').fadeOut(160);
				return false;
			})
	</script>

