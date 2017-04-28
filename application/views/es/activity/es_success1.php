<link type="text/css" rel="stylesheet" href="/css/giveaway.css" media="all" />
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>  >  Questionnaire</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">
            <!-------------ES_Questionnaire---------------->
            <div class="fix esq">
                <div><img src="/images/activity/esq_01.jpg"/></div>
                <div><img src="/images/activity/esq_02.jpg"/></div>

                <div class="fix summary">
                    <div class="text pt15">
                        <p class="mt15">Dear customers,<br/>
                            The purpose of this survey is to get your feedbacks regarding to our new coming brand '<a href="<?php echo LANGPATH; ?>/elf-sack/?queationnaire" title="elf sack" target="_blank">ELF SACK</a>'. Please take a moment to complete the following questions and help us know what you think of our services. Your responses are very important to us and will be kept strictly confidential.</p>
                        <p>Before you start the questionnaire, please have a look at the <a href="<?php echo LANGPATH; ?>/elf-sack/?queationnaire" title="elf sack" target="_blank">ELF SACK Collection</a>.</p>
                    </div>
                </div>
                <div class="fix">
                    <div class="successs">
                        <h3>THANK YOU!<br/>You have submitted your questionnaire successfully!</h3>
                        <P>And your gift is a piece of ELF SACK clothing. What’s more, you can choose the item 
                            you like for <strong>FREE</strong> with <strong>FREE SHIPPING</strong>! </P>
                        <P>What are you waiting for? <a href="<?php echo LANGPATH; ?>/elf-sack/?queationnaire" target="_blank">Choose the Item Right Now</a> !</P>
                        <P><span class="remark">(Just place an order with your favorite ELF SACK ITEM and do not pay for it. We will process the order and arrange the delivery as soon as possible.)</span></P>
                        <P>If you have any further questions, please feel free to contact your particular Choies Blogger Contactor or <a href="mailto:lisaconnor@choies.com" title="Lisa">Lisa</a>.</P>
                    </div>
                </div>
            </div>
        </section>
        <?php echo View::factory('/catalog_left'); ?>
    </section>
</section>