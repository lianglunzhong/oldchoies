<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo Site::instance()->version_file('/assets/css/style.css'); ?>">
    <script src="/assets/js/jquery-1.8.2.min.js"></script>
    <style>
        .rel-rec{text-align:center; margin-top: 2%;}
        .rel-size{ position: relative;}
        .size-choies{position: absolute; top:68%; left: 61.55555%; width: 35%;}
        .size-choies .size-choies-box{display: block; overflow: hidden;}
        .size-choies a.buy-now{ display: block;width: 175px; height: 44px; margin-top: 4%;}
        .size-choies .size-choies-box li{display: block; font-size:16px; background-color: #fff; width: 90px; height: 30px; line-height: 30px; border:1px solid #4d4d4d; margin-right: 2%; text-align: center; float: left;}
        .size-choies .size-choies-box li a{color: #4d4d4d;}
        .size-choies .size-choies-box li.size-on{background-color: #4d4d4d; }
        .size-choies .size-choies-box li.size-on a{color: #fff;}
    </style>

    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-32176633-1', 'choies.com', {'siteSpeedSampleRate': 20});
    ga('require', 'displayfeatures');
    ga('send', 'pageview');
    </script>

    <script>
        $(function(){
            $(".size-choies-box li").click(function(){
                $(this).addClass("size-on").siblings().removeClass("size-on");
                document.getElementById('sizes').value = $(this).children().html()

            })
        })
    </script>
    </head>
<body>
    <div class="site-content">
        <div class="main-container clearfix">
        <div class="col-xs-12"><img src="/assets/images/activity/china/pro9-16_01.jpg"></div>
            <div class="container">
                <div class="row">
                     <form action="/cart/add_moreforchina" method="post" class="form3" id="forms" >
                    <div class="col-xs-12">
                        <div class="rel-size">
                            <img src="/assets/images/activity/china/pro9-16_03.jpg">
                            <div class="size-choies">
                                <ul class="size-choies-box">
                                    <li><a href="javascript:void();">S</a></li>
                                    <li><a href="javascript:void();">M</a></li>
                                    <li><a href="javascript:void();">L</a></li>
                                    <li><a href="javascript:void();">XL</a></li>
                                    <input type="hidden" id="sizes" name="size" value="" />
                                    <input type="hidden" name="item" value="45933" />
                                </ul>
                                <a class="buy-now"  onclick="gogo()"><img src="/assets/images/activity/china/buy-now.jpg"></a>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12"><img src="/assets/images/activity/china/pro9-16_05.jpg"></div>
                    <div class="col-xs-12"><img src="/assets/images/activity/china/pro9-16_06.jpg"></div>
                    <div class="col-xs-12"><img src="/assets/images/activity/china/pro9-16_07.jpg"></div>
                    <div class="col-xs-12"><img src="/assets/images/activity/china/pro9-16_08.jpg"></div>
                    <div class="col-xs-12"><img src="/assets/images/activity/china/pro9-16_09.jpg"></div>
                    <div class="col-xs-12"><img src="/assets/images/activity/china/pro9-16_10.jpg"></div>
                    <div class="col-xs-12"><img src="/assets/images/activity/china/pro9-16_12.jpg"></div>
                    <div class="col-xs-12">
                        <ul class="rel-rec">
                            <li class="col-xs-3"><a href="<?php echo BASEURL ;?>/product/black-shift-dress-with-contrast-mesh-panel_p27944" target="_black"><img src="/assets/images/activity/china/pro01.jpg"></a></li>
                            <li class="col-xs-3"><a href="<?php echo BASEURL ;?>/product/cute-swing-dress-with-organza-yoke_p13337" target="_black"><img src="/assets/images/activity/china/pro02.jpg"></a></li>
                            <li class="col-xs-3"><a href="<?php echo BASEURL ;?>/product/blue-cartoon-patch-organza-sleeveless-dress_p41503" target="_black"><img src="/assets/images/activity/china/pro03.jpg"></a></li>
                            <li class="col-xs-3"><a href="<?php echo BASEURL ;?>/product/floral-organza-dress-with-double-layer-shirt_p18307" target="_black"><img src="/assets/images/activity/china/pro04.jpg"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
function gogo()
{
    var siz =  document.getElementById('sizes').value;

    if(!siz){
        alert("请选择尺码！");
        return false;
    }

    $("#forms").submit();
}
</script>