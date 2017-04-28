        <style>
        .contact-form div{clear:none;}
        .contect div.contact-note p{color:#444;}
        .contact-form span{margin:none;line-height:24px;}
        .contact-form ul li p{font-size:11px;color:#444;}
        .contect span.btn-span{margin-bottom:20px;}
        
        </style>
        <section id="main">
            <!-- crumbs -->
            <div class="container">
                <div class="crumbs">
                    <div>
                        <a href="<?php echo LANGPATH; ?>/">home</a>
                        <a href="<?php echo LANGPATH; ?>/faqs" class="visible-xs-inline hidden-sm hidden-md hidden-lg">  > Centro De Ayuda</a> > Contáctenos
                    </div><?php echo Message::get(); ?>
                </div>
            </div>
            <!-- main-middle begin -->
            <div class="container">
                <div class="row">
            <?php echo View::factory(LANGPATH . '/doc/left'); ?>
                    <article class="user col-sm-9 col-xs-12">
                        <div class="tit">
                            <h2>Contáctenos</h2>
                        </div>
                        <div class="doc-box contect">
                            <h3 style="text-transform:uppercase; font-size:18px; font-weight:normal;">¡ESTAMOS AQUÍ PARA AYUDAR!</h3>
                            <p class="mt10">Si te encuentras con algún problema mientras usted está haciendo compras en Choies.com, puede ponerse en contacto con nosotros dentro de los siguientes métodos:</p>
                            <p>(<strong>Consejo</strong>: Período De Servicio Al Cliente: 19：30-05：00 Domingo-Jueves, EST.</p>
                            <div>
                                <span class="btn-span" style="height:20px;"><a class="btn btn-default btn-lg" style="color:#fff;text-decoration:none;" target="_blank" title="LiveChart" href="https://chatserver.comm100.com/chatwindow.aspx?planId=311&siteId=203306"><img src="/assets/images/docs/icon_chat.png">LIVECHAT</a>&nbsp;&nbsp;</span>
                                <span class="btn-span" style="font-weight:bold;font-size:18px;">  (PREGUNTAS PARA <span1 style="color:red"> PRE-VENTA </span1> SOLEMENTE)</span>
                            </div>
							<div>
                                                                <span class="btn-span"><a class="btn btn-default btn-lg JS_click" style="color:#fff;text-decoration:none;" target="_blank" title="">Haz clic aquí para enviar un email</a></span>
								&nbsp;&nbsp;
								<span class="btn-span" style="font-weight:bold;font-size:18px;">(PREGUNTAS PARA <span1 style="color:red">POST-VENTA</span1> Y OTRAS)</span>
							</div>
							<div>
                                 <div class="JS_clickcon hide">
                                    <div class="row">
                                        <form action="site/docsend" method="post" class="user-form contact-form col-xs-12 mt20" enctype="multipart/form-data">
                                        <ul> 
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>*</span>Nombre:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="name" class="text-long text col-sm-12 col-xs-12" />
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>*</span>Dirección de Email:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="email" class="text-long text col-sm-12 col-xs-12" />
                                                    <p>Utiliza tu email de registro si tienes una cuenta de Choies.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>*</span>Tipo de pregunta:</label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <div class="wdrop">
                                                        <select class="selected-option col-sm-12 col-xs-12" name="qt">
                                                            <option value="" class="selected"> - Seleccione la tema de su pregunta - </option>
                                                            <option value="1">Preguntas acerca de pre-venta / stock disponible / información de producto</option>
                                                            <option value="2">Preguntas acerca de venta al por mayor/ compra al granel o Dropship</option>
                                                            <option value="3">Cambio de dirección o producto / cancelación de pedido( sólo por los pedidos no enviados) </option>
                                                            <option value="4">Estado de pedido / información de seguimiento / paquete perdido / asuntos de clients </option>
                                                            <option value="5">Servicio de posventa ( artículos defectuosos, artículos incorrectos, artículos sin llegar, problema de talla, etc)  </option>
                                                            <option value="6">Problemas de pago / problemas técnicos </option>
                                                            <option value="7">Problema de cuenta(Olvidaste tu contraseña o desuscribirse de nuestro newsletter) </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12"><span>&nbsp;</span>Numero de pedido <br/><span style="color:#444;">(si procede)</span></label>
                                                <div class="col-sm-6 col-xs-12">
                                                    <input type="text" value="" name="order" class="text-long text col-sm-12 col-xs-12" />
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 col-xs-12">
                                                    <span>*</span> Mensaje:
                                                </label>
                                                <div class="col-sm-6 col-xs-12 mb20">
                                                    <textarea class="textarea-long text col-sm-12 col-xs-12" name="message"></textarea>
                                                </div>
                                            </li>
                                             <li>
                                                <label class="col-sm-3 col-xs-12"><span>&nbsp;</span>Archivo :</label>
                                                <div class="col-sm-6 col-xs-12">
                                                <input type="text" class="text-long text col-sm-9 col-xs-9" readonly name="file_name" id="file_name"/><input type="button" value="Subir" class="col-sm-3 col-xs-3 btn btn-xs btn-default" style="height:24px;" onclick="btn_file.click();" name="get_file"/>
                                                    <input type="file" name="btn_file" onchange="file_change(this.value)" style="display:none;"/>
                                                
                                                     <!-- <p class="col-sm-2 col-xs-2"><a><img style="max-width:none;" src="/assets/images/docs/upload.png" ></a></p> -->
                                                    <p>Si usted quisiera mostrarnos algunos archivos, por favor subirlos aquí. Cada archivo debe ser inferior a 2 MB. Los siguientes formatos de archivo son compatibles: gif, jpg, png, bmp, doc, xls, txt, rar, ppt, pdf.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <label class="col-sm-3 hidden-xs">&nbsp;</label>
                                                <div class="btn-grid12 col-sm-6 col-xs-12 mb20">
                                                    <input type="submit"  value="ENVIAR" class="btn btn-primary btn-lg" />
                                                </div>
                                            </li>
                                        </ul>
                                    </form>
                                  </div>
                                </div>
                            </div>
                            <div class="contact-note">
                                <p style="font-weight:bold;">Emails va a ser respuesta en 24 horas pero es posible que sea retrasado durante el fin de semana y temporada ocupada. Para solucionar su problema rápidamente, por favor tenga en cuenta:</p>
                                <p>
                                   1.Preguntas antes de la compra, por favor consulte<i><a href="<?php echo LANGPATH ?>/faqs" style="color:#444;">FAQ</a> </i>;
                                </p>
                                <p>
                                    2.Sin recibir la confirmación de pedido y la información de seguimiento, por favor revise su <strong>CARPETA DE SPAM</strong> en primer lugar;
                                </p>
                                <p>
                                    3.Para ver el estado del pedido, por favor <a href="<?php echo LANGPATH ?>/customer/login" class="a-red">inicia sesión</a> en primer lugar y luego haga clic <a href="<?php echo LANGPATH ?>/tracks/track_order" style="color: rgb(65, 140, 175);">RASTREAR.</a>
                                </p>
                            </div>

							<div style="display:none;">
								<p><strong>[Nombre de Sociedad ]</strong> V-Shangs Ciencia Y Tecnología (H.K.) Sociedad Limitada</p>
								<p><strong>[Dirección]</strong>  1702, Piso 17, Sino Centre, Calle Nathan 582-592, Kln.,HK</p>
							</div>
							<p style="display:none;"><strong>[<i>Relaciónes de Empresa</i>]</strong></p>
							<div class="doc-contact-1230" style="display:none;">
								<div>
									<h4> WUXI INVOGUE TECHNOLOGY GROUP SDAD LTDA</h4>
									<p>Dirección: 1801 CALLE NANHU N°855, YANGMING SCIENCE INNOVATION CENTRE, NANCHANG DISTRITO, WUXI CIUDAD, PROVINCIA DE JIANGSU , CHINA</p>
									<ul>
										<li><p><img src="<?php echo STATICURL; ?>/assets/images/docs/contact-us-left.jpg"></p><span>Nanjing Kuaiyue Comercio Electrónico Sociedad Limitada</span></li>
										<li><p><img src="<?php echo STATICURL; ?>/assets/images/docs/contact-us-right.jpg"></p><span style="float:right"> V-Shangs Ciencia Y Tecnología (H.K.) Sociedad Limitada </span><p><img src="<?php echo STATICURL; ?>/assets/images/docs/contact-us-down.jpg"></p><p class="big-icon">choies</p></li>
									</ul>
									<p style="color:#c30;font-size:14px;">(Atención: Estas direcciónes no aceptan las devoluciónes.)</p>
								</div>
							</div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        
		<script type="text/javascript">
        function file_change(e)
        {
            document.getElementById("file_name").value = e;
        }
        </script>

<script type="text/javascript">
        $(".contact-form").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            qt: {
                required: true,
            },
            message: {
                required: true,
            }
        },
        messages: {
            name: {
                required: "Please provide a name.",
            },
            email:{
                required:"Please provide an email.",
                email:"Please enter a valid email address."
            },
            qt: {
                required: "Please select a question.",
            },
            message:{
                required:"Please provide a message.",
            },
        }
    });
</script>

