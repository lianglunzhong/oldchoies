<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=emulateie7" />
        <title>ПЛАТЕЖ</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link type="image/x-icon" rel="shortcut icon" href="images/favicon.ico" />
        <!--                <link type="text/css" rel="stylesheet" href="/css/all_new.css" media="all" id="mystyle"  />-->
        <style>
            /* cart_paypal */
            .cart_paypal{ max-width:720px; margin:0 auto; background-color:#fff; padding:0 0 30px;border:1px solid #ebebeb;}
            .cart_paypal h2{ height:48px; line-height:48px;padding-left:100px; color:#000; font-size:16px; font-weight:bold; text-transform:capitalize; margin:0 0 30px; background-color:#f5f5f5;border-bottom:1px solid #ebebeb;}
            .cart_paypal h2 span{ color:#000;font-size:20px;}
            .cart_paypal h2 img{ vertical-align:middle; margin-left:10px;}
            .cart_paypal p{ line-height:30px; margin:0 100px; color:#444; font-size:14px;}
            .cart_paypal p a{ color:#000;font-weight:bold;}
      .cart_paypal p.bottom{padding-bottom:50px;}
        </style>
    </head>
    <body>
        <div class="icontainer">
            <div class="login">
                <!-- cart_paypal begin -->
                <div class="cart_paypal">
                    <h2>Ваш номер заказа: <span><?php echo $ordernum; ?></span><img src="<?php echo STATICURLHTTPS; ?>/assets/images/loading.gif" /></h2>
                    <p>Страница Оплата загружается, это может занять несколько секунд или даже больше.</p>
                    <p>Пожалуйста, не оставляйте, а если у вас есть какие-либо вопросы,</p>
                    <p class="bottom">пожалуйста, обращайтесь: <a href="mailto:service_ru@choies.com">service_ru@choies.com</a></p>
                </div>
                <div class="message">
                    <?php if($isgift){echo $paypal_form;} ?> 
                </div>
            </div>
        </div>
        <script>
        <?php if(!$isgift){ ?>
            window.onload = function(){
                window.location.href = '<?php echo BASEURL . LANGPATH . "/payment/ppec_set1/" . $ordernum; ?>';
            }
        <?php   }  ?>
        </script>
        
        <!-- GA code -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            
            ga('create', 'UA-32176633-1', 'choies.com');
            ga('send', 'pageview');
        </script>

        
    </body>
</html>
