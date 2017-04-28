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
            .cart_paypal{ max-width:720px; margin:0 auto; background-color:#f4f4f0; padding:0 0 30px;}
            .cart_paypal h2{ height:60px; line-height:60px; text-align:center; color:#fff; font-size:18px; font-weight:normal; text-transform:uppercase; margin:0 0 30px; background-color:#b4132e;}
            .cart_paypal h2 span{ color:#f6fd93;}
            .cart_paypal h2 img{ vertical-align:middle; margin-left:10px;}
            .cart_paypal p{ line-height:30px; margin:0 45px; color:#666; font-size:14px;}
            .cart_paypal p.bottom{ border-top:1px dashed #ccc; padding-top:10px; margin-top:15px;}
            .cart_paypal p a{ color:#135d90;}
        </style>
    </head>
    <body>
        <div class="icontainer">
            <div class="login">
                <!-- cart_paypal begin -->
                <div class="cart_paypal">
                    <h2>Ваш номер заказа: <span><?php echo $ordernum; ?></span><img src="/images/loading1.gif" /></h2>
                    <p>Страница платежа загружается,это займет несколько секунд или больше.</p>
                    <p>Не уйти,ваш запрос обрабатывается.</p>
                    <p>Этот товар является hot pick, и только продается на ограниченное время, не пропустите!</p>
                    <p class="bottom">Пожалуйста, свяжитесь с нами напрямую :<a href="mailto:service_ru@choies.com">service_ru@choies.com</a></p>
                </div>
                <div class="message">
                    <?php // echo $paypal_form; ?>
                </div>
            </div>
        </div>
        
        <script>
            window.onload = function(){
                window.location.href = '<?php echo "http://" . Site::instance()->get('domain') . LANGPATH . "/payment/ppec_set1/" . $ordernum; ?>';
            }
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
