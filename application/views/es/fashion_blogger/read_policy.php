<?php if (!Customer::logged_in()): ?>
    <script type="text/javascript">
        $(function(){
            $("#agree").live("click", function(){
                $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                $('#catalog_link').appendTo('body').fadeIn(320);
                $('#catalog_link').show();
                return false;
            })
                        
            $("#catalog_link .clsbtn,#wingray").live("click",function(){
                $("#wingray").remove();
                $('#catalog_link').fadeOut(160).appendTo('#tab2');
                return false;
            })
        })
    </script>
<?php endif; ?>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>  >  Blogger De Moda</div>
        </div>
    </div>
    <section class="layout fix">
        <div class="tit blogger_wanted mb25">
            <span>Blogger De Moda</span><span class="on">Leer La Política</span><span>Presentar Información</span><span>Conseguir Una Bandera</span>
            <img src="/images/de/blogger_wanted2.png" />
        </div>
        <article id="container" style="margin-top:30px;background: #fff;">
            <div class="fashion_policy" style="border-bottom:#CCC 1px dashed;">
                <h3>BLOGGER DE MODA:</h3>
                <p>No importa si eres una amante de la moda o una blogger de moda, siempre muestras tu gusto por la moda como una mente libre.</p>
                <p>Uniéndote al programa de Blogger de moda de Choies.com, te beneficiarás de descuentos especiales y artículos gratis de nuestras grandes novedades.</p>
                <p>No dude en enviarnos un correo electrónico a <a href="mailto:business@choies.com" title="business@choies.com">bussiness@choies.com</a> sobre usted mismo.</p>
            </div>
            <div class="fashion_policy mt20" style="border-bottom:#CCC 1px dashed;">
                <p>¿Como unirse al programa de Blogger de moda?</p>
                <h3>1¿Eres una blogger que se centra en la moda y estilo actual?</h3>
                <p>CHOIES ha colaborado con muchos bloggers famosos y sería un honor contar contigo en nuestro programa de moda.</p>
                <h3>Requisitos:</h3>
                <p>  1. ¿Crees que tienes buen gusto en moda y que eres influyente en tu blog personal, página de Facebook, canal de Youtube, Chicisimo?</p>
                <p>  2. ¿Hablas de moda de forma frecuente, al menos una vez por semana?</p>
                <p>&nbsp;</p>
                <h3>2.  ¿Cómo empezar?</h3>
                <p>Primero tienes que registrarte en www.choies.com y poner nuestro banner en tu blog. Puedes conseguir el código para el banner haciendo click en “Acepto”. Infórmanos de tu registro por email, añadiremos puntos en tu cuenta.</p>
                <p>&nbsp;</p>
                <h3>3. ¿Qué regla tengo que seguir para renovar mis puntos?</h3>
                <p>Normalmente tienes que mostrar nuestros productos antes de siete días y enviarnos un link de tu blog. Tiene que haber un link directo al producto que estas llevando en tu blog, únicamente usarás el link de la página principal si el producto se ha agotado. Te daremos puntos extra si compartes tu look en Chicisimo.com e incluyes un link a Choies.com.</p>
                <p>&nbsp;</p>
                <h3>4. ¿Cada cuánto recompensáis a los bloggers?</h3>
                <p>Por lo general, damos puntos a los bloggers para que puedan usarlos en la tienda. Renovamos sus puntos cuando hacen outfits en sus blogs y en tantas redes sociales como puedan y nos envían el link de la publicación.</p>
                <p>&nbsp;</p>
                <h3>5. ¿Tengo que pagar aduanas?</h3>
                <p>La política de aduanas es diferente en cada país. Por ejemplo, los bloggers de Brasil tiene que facilitarnos su DNI y pagar tasas. Todo depende de la política de tu país. </p>
                <p>&nbsp;</p>
                <h3>6. ¿Hay otras formas de conseguir más puntos?</h3>
                <p>Sí, puedes conseguirlos escribiendo una entrada colaborativa con CHOIES o haciendo sorteos para Choies y enviándonos el link de la publicación.</p>
                <p>&nbsp;</p>
                <h3>7. Por favor, regístrate en choies.com antes de continuar.</h3>
                <p>No podrás usar los puntos a no ser que estés registrada.</p>
            </div>
            <div class="fashion_policy mt20">
                <h3>Sobre el copyright de tus fotos.</h3>
                <p>Tenemos derecho de poner fotos de tu blog en nuestra página de Facebook, Instagram y cualquier otra página oficial.</p>
                <p>Si tienes alguna otra duda acerca de nuestro programa Blogger de moda puedes enviarnos un emal a <a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>.</p>
                <p>&nbsp;</p>
                <p>Lo comprobaremos en una semana y te responderemos si has sido seleccionada. </p>
                <p>Si estás de acuerdo con los términos anteriores, haz clic en Acepto para continuar.</p>
                <div class="form_btn mt20 mb10" id="agree">
                    <p><a href="<?php echo LANGPATH; ?>/blogger/submit_information"><strong class="view_btn btn26 btn40" style="width: 100px;">Acepto</strong></a></p>
                </div>
            </div>
        </article>
    </section>
</section>
<div class="hide" id="catalog_link" style="position: fixed;padding: 10px 10px 20px; top: 0px;left: 400px;width: 640px;height: 230px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:#CCC 1px solid;">
    <div class="order order_addtobag">
        <div class="fashion_thank">
            <h4>Consigue tu cuenta primero antes del próximo paso.<br/>
                Por favor ingresa o regístrate.</h4>
            <div class="2btns">
                <span class="form_btn mr10"><a href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/blogger/submit_information" title="Log In"><strong class="view_btn btn26 btn40" style="width: 100px;">ACCEDER</strong></a></span>
                <span class="form_btn"><a href="<?php echo LANGPATH; ?>/customer/register?redirect=<?php echo LANGPATH; ?>/blogger/submit_information" title="REGISTER"><strong class="view_btn btn26 btn40" style="width: 100px;">regístrate</strong></a></span>
            </div>
        </div>
    </div>
    <div class="clsbtn" style="right: -0px;top: 3px;"></div>
</div>