<script type="text/javascript" src="/js/product.js"></script>
<script>
    var page = <?php echo isset($_GET['page']) ? 1 : 0; ?>;
    $(function(){
        if(page)
        {
            window.location.href = '#pagefocus';
        }
    })
</script>
<?php
$images = unserialize($lookbook['images']);
?>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>  >  SHOW DE COMPRADORES</div>
        </div>
        <?php echo message::get(); ?>
    </div>
    <section class="layout fix">
        <h3 class="lookbook_tit">
            <div class="fll">SHOW DE COMPRADORES</div>
            <a class="flr red" href="<?php echo LANGPATH; ?>/lookbook">VOLVER AL LOOKBOOK</a>
        </h3>
        <div class="lookbook_details_rows1 fix">
            <div class="left fll"><img src="<?php echo 'http://img.choies.com/simages/' . $images['main']; ?>" width="422" alt="" /></div>
            <div class="right fll">
                <div class="fix">
                    <?php
                    foreach ($images as $pid => $image)
                    {
                        if ($pid == 'main')
                            continue;
                        $product = Product::instance(Product::get_productId_by_sku($pid));
                        $link = $product->permalink();
                        ?>
                        <div class="fll"><a href="<?php echo $link; ?>"><img src="<?php echo 'http://img.choies.com/simages/' . $image; ?>" width="260" alt="" /></a></div>
                        <div class="fll con">
                            <p><a href="<?php echo $link; ?>"><?php echo $product->get('name'); ?></a></p>
                            <h2><?php echo Site::instance()->price($product->price(), 'code_view'); ?></h2>
                        </div>
                        <div class="lookbook_share mtb20 font14">
                            <span>Compartir en:</span>
                            <span class="sns fix">
                                <a rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($link); ?>" target="_blank" class="sns1"></a>
                                <a rel="nofollow" href="http://twitter.com/share?url=<?php echo urlencode($link); ?>" target="_blank" class="sns2"></a>
                                <a rel="nofollow" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($link); ?>&media=<?php echo Image::link($product->cover_image(), 1); ?>&description=<?php $product->get('name'); ?>" target="_blank" class="sns5"></a>
                            </span>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="lookbook_details_rows1 fix">
            <div class="left_reviews fll">
                <h3>COMENTARIOS</h3>
                <ul class="con">
                    <?php
                    if (count($reviews) > 0)
                    {
                        foreach ($reviews as $review)
                        {
                            $firstname = Customer::instance($review['user_id'])->get('firstname');
                            $date = date('d/m/Y', $review['created']);
                            ?>
                            <li>
                                <div class="fix"><strong class="rating_show fll"><span class="rating_value<?php echo $review['star']; ?>">rating</span></strong><span class="time flr"><?php echo $firstname . ' on ' . $date; ?></span></div>
                                <p><?php echo $review['content']; ?></p>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
                <?php echo $pagination; ?>
            </div>
            <div id="pagefocus"></div>
            <div class="right_reviews flr">
                <h3>COMENTAR</h3>
                <!--　login before -->
                <div class="review-form">
                    <?php
                    if ($customer_id = Customer::logged_in())
                    {
                        ?>
                        <form method="post" action="/site/lookbook_review" class="form form2 user_form" id="reviewForm">
                            <input type="hidden" name="type" value="0" />
                            <?php
                            if (count($reviews) == 0)
                            {
                                ?>
                                <b>Sea el primero en escribir una opinión</b>
                                <?php
                            }
                            ?>

                            <ul class="mtb10">
                                <li class="fix">
                                    <label class="fll"><span>*</span>Grado:</label>
                                    <div class="right_box fll">
                                        <span class="rating_wrap fix">
                                            <input class="star" type="radio" name="star" value="1" />
                                            <input class="star" type="radio" name="star" value="2" />
                                            <input class="star" type="radio" name="star" value="3" />
                                            <input class="star" type="radio" name="star" value="4" />
                                            <input class="star" type="radio" name="star" value="5" checked="checked" />
                                        </span>
                                    </div>
                                </li>
                                <li class="fix">
                                    <label><span>*</span>Comentar:</label>
                                    <div class="right_box"><textarea name="content"></textarea></div>
                                </li>
                                <li class="fix">
                                    <label for="submit">&nbsp;</label>
                                    <input type="hidden" name="lookbook_id" value="<?php echo $lookbook['id']; ?>" />
                                    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
                                    <div class="right_box"><input type="submit" value="PRESENTAR" class="view_btn btn26" /></div>
                                </li>
                            </ul>
                        </form>
                        <script>
                            $("#reviewForm").validate({
                                rules: {
                                    star: {
                                        required: true
                                    },
                                    content: {
                                        required: true,
                                        minlength: 5
                                    }
                                },
                                messages: {
                                    email:{
                                        required:"Requerido Campo."
                                    },
                                    password: {
                                        required: "Requerido Campo.",
                                        minlength: "Su contraseña debe tener al menos 5 caracteres."
                                    }
                                }
                            });
                        </script>
                        <?php
                    }
                    else
                    {
                        ?>
                        <form action="/customer/login" method="post" class="form form1 user_form" id="loginForm">
                            <input type="hidden" value="<?php echo 'http://' . Site::instance()->get('domain') . '/lookbook/' . $lookbook['id'] . '#pagefocus'; ?>" name="referer">
                            <b>Por favor accede en primer lugar</b>
                            <ul class="mtb10">
                                <li class="fix">
                                    <label for="email"><span>*</span> Su Email :</label>
                                    <div class="right_box"><input type="text" value="" name="email" class="text" /></div>
                                </li>
                                <li class="fix">
                                    <label for="password1"><span>*</span> Contraseña :</label>
                                    <div class="right_box"><input type="password" value="" name="password" class="text" /></div>
                                </li>
                                <li class="fix">
                                    <label for="submit">&nbsp;</label>
                                    <div class="right_box"><input type="submit" value="ACCEDER" class="view_btn btn26 btn40" /></div>
                                </li>
                            </ul>
                        </form>
                        <script>
                            $("#loginForm").validate({
                                rules: {
                                    email: {
                                        required: true,
                                        email: true
                                    },
                                    password: {
                                        required: true,
                                        minlength: 5,
                                        maxlength:20
                                    }
                                },
                                messages: {
                                    email:{
                                        required:"Por favor, proporcione un email.",
                                        email:"Por favor, introduce una dirección de correo electrónico válida."
                                    },
                                    password: {
                                        required: "Por favor, ingrese su contraseña.",
                                        minlength: "Su contraseña debe tener al menos 5 caracteres."
                                    }
                                }
                            });
                        </script>
                        <?php
                    }
                    ?>
                </div>

                <!--　login after -->
                <div class="review-form">

                </div>                                                            
            </div>
        </div>
    </section>
</section>
<script type="text/javascript">
    $(function(){
        $('.grade').children().click(function(){
            var star = $(this).attr('alt');
            $('#star').val(star);
        })
    })
</script>