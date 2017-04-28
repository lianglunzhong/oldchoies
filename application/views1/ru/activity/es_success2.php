<link type="text/css" rel="stylesheet" href="/css/giveaway.css" media="all" />
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Home</a>  >  Questionnaire</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
            <!-------------ES_Questionnaire---------------->
            <div class="fix esq">
                <div><img src="<?php echo STATICURL; ?>/ximg/activity/esq_01.jpg"/></div>
                <div><img src="<?php echo STATICURL; ?>/ximg/activity/esq_02.jpg"/></div>

                <div class="fix summary">
                    <div class="text pt15">
                        <p class="mt15">Dear customers,<br/>
                            The purpose of this survey is to get your feedbacks regarding to our new coming brand '<a href="<?php echo LANGPATH; ?>/elf-sack/?queationnaire" title="elf sack" target="_blank">ELF SACK</a>'. Please take a moment to complete the following questions and help us know what you think of our services. Your responses are very important to us and will be kept strictly confidential.</p>
                        <p>Before you start the questionnaire, please have a look at the <a href="<?php echo LANGPATH; ?>/elf-sack/?queationnaire" title="elf sack" target="_blank">ELF SACK Collection</a>.</p>
                    </div>
                </div>
                <div class="fix">
                    <div class="successs" >
                        <h3>THANK YOU!<br/>You have submitted your questionnaire successfully!</h3>
                        <P style="text-align:center;">And your gift is a <strong>30% OFF</strong> Coupon Code: </P>
                        <div class="code">ESQ30OFF </div>
                        <P style="text-align:center;">This code can only be used to buy <a href="<?php echo LANGPATH; ?>/elf-sack/?queationnaire" target="_blank">ELF SACK ITEMS</a>.</P>
                        <P style="text-align:center;"><span class="remark">(This code has also been sent to your email box. Please check later.)</span></P>
                    </div>
                </div>
            </div>
        </section>
        <?php echo View::factory('/catalog_left'); ?>
    </section>
</section>