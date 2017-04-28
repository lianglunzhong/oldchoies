<?php
$url1 = parse_url(Request::$referrer);

?>
		<section id="main">
			<!-- crumbs -->
			<div class="container">
				<div class="crumbs">
					<div>
						<a href="<?php echo LANGPATH; ?>/">home</a> > blogger wanted
					</div>
					<div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="<?php echo LANGPATH.$url1['path']; ?>">back</a>
					</div>
				</div>
			</div>
			<!-- main begin -->
			<section class="container">
				<div class="blogger-img hidden-xs">
					<div class="step-nav step-nav1">
                        <ul class="clearfix">
                            <li class="current">Fashion Programme<em></em><i></i></li>
                            <li>Read Policy<em></em><i></i></li>
                            <li>Submit Information<em></em><i></i></li>
                            <li>Get A Banner<em></em><i></i></li>
                        </ul>
                    </div>
				</div>
				<p class="hidden-xs img-active">
					<img src="<?php echo STATICURL; ?>/assets/images/blogger/blogger.jpg" border="0" usemap="#Map13" />
					<map name="Map13" id="Map13">
                      <area shape="poly" coords="112,337,182,187,437,134,495,203,544,187,520,232,565,321,501,458,195,482" href="<?php echo LANGPATH; ?>/blogger/read_policy">
                      <area shape="poly" coords="712,379,915,377,922,484,697,481" href="<?php echo LANGPATH; ?>/blogger/read_policy">
                      <area shape="poly" coords="1196,504,1197,654,1188,662,913,664" href="<?php echo LANGPATH; ?>/blogger/get_banner?shortcut">
                    </map>
				</p>
			</section>
			<section class="visible-xs-block hidden-sm hidden-md hidden-lg blogger-step1-phone">
				<div class="col-xs-12">
					<p><a href="<?php echo LANGPATH; ?>/blogger/read_policy">I want to join Chioes!</a>
					</p>
					<p><a href="<?php echo LANGPATH; ?>/blogger/get_banner?shortcut">I simply want to get a banner.</a>
					</p>
				</div>
			</section>
		</section>

		<!-- footer begin -->

		<!-- gotop -->
		<div id="gotop" class="hide">
			<a href="#" class="xs-mobile-top"></a>
		</div>


	</body>

</html>

<script>
<?php if(Kohana_Cookie::get('isone')){  ?>
        adjust();  
        var timeout = null;
        window.onresize = function () {  
            clearTimeout(timeout);  
            timeout = setTimeout(function () { window.location.reload(); },50);//
        }  
  
     
        function adjust() {  
            var map = document.getElementById("Map13");  
            var element = map.childNodes;  
            var itemNumber = element.length / 2;  
            for (var i = 0; i < itemNumber - 1; i++) {  
                var item = 2 * i + 1;  
                var oldCoords = element[item].coords;  
                var newcoords = adjustPosition(oldCoords);  
                element[item].setAttribute("coords", newcoords);  
            }  
            var test = element;  
        }  
  

        function adjustPosition(position) {   
  			var boxWidth = $(".img-active").width();
			var boxHeight = $(".img-active").height();

            var imageWidth =  1200;   
            var imageHeight = 666;  
  
            var each = position.split(",");  

            for (var i = 0; i < each.length; i++) {  
                each[i] = Math.round(parseInt(each[i]) * boxWidth / imageWidth).toString();
                i++;  
                each[i] = Math.round(parseInt(each[i]) * boxHeight / imageHeight).toString();
            }  
         
            var newPosition = "";  
            for (var i = 0; i < each.length; i++) {  
                newPosition += each[i];  
                if (i < each.length - 1) {  
                    newPosition += ",";  
                }  
            }  
            return newPosition;  
        }  
        <?php } ?>
</script>
<?php SetCookie('isone', 1, time()+ 24*3600, '/'); ?>