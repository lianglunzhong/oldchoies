<?php
if(empty(LANGUAGE))
{
    $lists = Kohana::config('/customer/forgot_password.en');
}
else
{
    $lists = Kohana::config('/customer/forgot_password.'.LANGUAGE);
}
?>
<div class="site-content">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs row">
            <div class="col-xs-12">
                <a href="/"><?php echo $lists['title1'];?></a> > <?php echo $lists['title2'];?>
            </div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <!-- main-middle begin -->
    <div class="container">
        <div class="row">
            <aside id="aside" class="col-sm-1 hidden-xs"></aside>
            <article class="user col-sm-10 col-xs-12">
                <div class="tit">
                    <h2><?php echo $lists['title3'];?></h2>
                </div>
                <form class="forgot-psd-form col-xs-12" method="post" action="/customer/forgot_password">
                    <p><?php echo $lists['title4'];?></p>
                    <ul>
                        <li>
                            <label class="col-sm-2 col-xs-12">
                                <span>*</span> <?php echo $lists['title5'];?>:
                            </label>
                            <div>
                                <input class="text col-xs-12" type="text" value="" name="email">
                            </div>
                        </li>
                        <li>
                            <label class="hidden-xs col-sm-2"> </label>
                            <div>
                                <input class="btn btn-primary btn-lg" type="submit" value="Submit" name="">
                            </div>
                        </li>
                    </ul>
                </form>
            </article>
        </div>
    </div>
</div>
<script type="text/javascript">

/* forgot-psd-form */
$(".forgot-psd-form").validate({
    rules: {
        email: {    
            required: true,
            email: true
        }
    },
    messages: {
        email: {
            required:"<?php echo $lists['message1'];?>",
            email:"<?php echo $lists['message2'];?>"
        }
    }
});
</script>
