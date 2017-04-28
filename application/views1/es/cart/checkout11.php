<?php
              $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
               $default_shipping = 0;
                          /*  if($show_address)
                                {*/
                foreach ($site_shipping as $key => $price)
                {
                    if ($cart_shipping == -1)
                    {
                        if ($key == 1)
                        {
                            $default_shipping = $price['price'];
                        }
                    }
                    elseif ($price['price'] == $cart_shipping)
                    {
                        $default_shipping = $price['price'];
                    }
                }
                 ?>

<div class="page">
        <header class="site-header">
            <div class="cart-header">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-8 col-md-8">
                            <a href="http://www.choies.com<?php echo LANGPATH;?>" class="logo" style="margin-top:0px;"></a>
                            <h2 class="logo-checkout">Pago</h2>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            <a href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&amp;dn=www.choies.com&amp;lang=es" target="_blank"><img src="/assets/images/card-pay.png"></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
                            <?php  if($_SESSION['insurance'] != -1){ 
                                    $insurance = 0.99;
                                  }else{
                                    $insurance = 0;
                                    }  ?>
        <div class="site-content">
            <div class="main-container clearfix">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div  class="lay-one order-info pt5">
                                <div class="lay-title">
                                    <h2>
                                        <i class="on">1</i>Información del pedido<a href="<?php echo LANGPATH;?>/cart/view" class="flr a-back">Volver a mi bolsa</a>
                                        <p class="hidden-xs">Pedido total:
                                        <span class="red" id="totalsum"><?php echo $cart['amount']['shipping'] ? Site::instance()->price($cart['amount']['total']+ $insurance, 'code_view') : Site::instance()->price($cart['amount']['total'] + $default_shipping + $insurance, 'code_view'); ?></span>
                                        <a class="flr JS_click drop-down-hd">Detalles del pedido<i class="fa fa-caret-down ml5"></i></a></p>
                                        
                                        <p class="col-xs-12 hidden-sm hidden-md hidden-lg">Pedido total:<span class="red" style="font-size:16px;" id="totalsum1"><?php echo $cart['amount']['shipping'] ? Site::instance()->price($cart['amount']['total']+ $insurance, 'code_view') : Site::instance()->price($cart['amount']['total'] + $default_shipping + $insurance, 'code_view'); ?></span><a class="flr JS_click drop-down-hd">Detalles del pedido<i class="fa fa-caret-down ml5"></i></a></p>
                                    </h2>

                                </div>
                                <div class="information-box JS_clickcon">
                                    <div class="payment-table">
                                    <table class="shopping-table" width="100%">
                                        <tbody>
                        <?php
                        $ecomm_prodid = array();
                        $p_saving = 0;
                        foreach (array_reverse($cart['products']) as $key => $product):
                            $sku = Product::instance($product['id'])->get('sku');
                            $ecomm_prodid[] = "'$sku'";
                            $name = Product::instance($product['id'],LANGUAGE)->get('name');
                            $img = Product::instance($product['id'])->cover_image();
                            $link = Product::instance($product['id'],LANGUAGE)->permalink();
                            ?>
                                            <tr>
                                                <td width="60%">
                                                    <div class="clearfix">
                                                        <div class="left">
                                                            <a href="<?php echo $link;?>">
                                                                <img src="<?php echo '/pimages1/' . $img['id'] . '/3.' . $img['suffix']; ?>" alt="<?php echo $name; ?>" / width="45">
                                                            </a>
                                                        </div>
                                                        <div class="right">
                                                            <a href="<?php echo $link;?>" class="name">
                                                                <?php echo $name; ?>
                                                            </a>
                                                            <p>
                                                            <?php
                                                            $delivery_time = kohana::config('prdress.delivery_time');
                                                            if (isset($product['attributes'])):
                                                                foreach ($product['attributes'] as $attribute => $option):
                                                                
                                                                    if ($attribute == 'delivery time'){
                                                                        $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                                                    }
                                                                    $attribute = str_replace('Size','Talla',$attribute);
                                                                    echo ucfirst($attribute) . ': ' . $option . '<br>';
                                                                endforeach;
                                                            endif;
                                                            ?>
                                                            </p>
                                                            <p class="hidden-sm hidden-md hidden-lg">Cantidad: <?php echo $product['quantity']; ?></p>
                                                            <p class="hidden-sm hidden-md hidden-lg">Precio:<?php echo Site::instance()->price($product['price'], 'code_view'); ?></p>
                                                            
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="20%" class="hidden-xs">
                                                    <label>Cantidad: </label><?php echo $product['quantity']; ?>
                                                </td>
                                                <td width="20%" class="hidden-xs">
                                                    <strong><?php echo Site::instance()->price($product['price'], 'code_view'); ?></strong>
                                                </td>
                                            </tr>
                                        <?php
                                            endforeach;
                        if (!empty($cart['largesses'])):

                            foreach ($cart['largesses'] as $key => $product):
                                $sku = Product::instance($product['id'])->get('sku');
                                $ecomm_prodid[] = "'$sku'";
                                $img = Product::instance($product['id'])->cover_image();
                                $name1 = Product::instance($product['id'])->get('name');
                                $link1 = Product::instance($product['id'])->permalink();
                                ?>
                                            <tr>
                                                <td width="60%">
                                                    <div class="clearfix">
                                                        <div class="left">
                                                            <a href="<?php echo $link1; ?>">
                                                                <img src="<?php echo '/pimages1/' . $img['id'] . '/3.' . $img['suffix']; ?>" alt="<?php echo $name1; ?>" / width="45">
                                                            </a>
                                                        </div>
                                                        <div class="right">
                                                            <a href="<?php echo $link1; ?>" class="name">
                                                                <?php echo $name1; ?>
                                                            </a>
                                                            <p>
                                                            <?php
                                                            $delivery_time = kohana::config('prdress.delivery_time');
                                                            if (isset($product['attributes'])):
                                                                foreach ($product['attributes'] as $attribute => $option):
                                                                    if ($attribute == 'delivery time'){
                                                                        $option = $option > 0 ? 'Rush Order' . ' ( + ' . Site::instance()->price($option, 'code_view') . ' )' : 'Regular Order';
                                                                    }
                                                                    $attribute = str_replace('size','Talla',$attribute);
                                                                    echo ucfirst($attribute) . ': ' . $option . '<br>';
                                                                endforeach;
                                                            endif;
                                                            ?>
                                                            </p>
                                                            <p class="hidden-sm hidden-md hidden-lg">Cantidad:<?php echo $product['quantity']; ?></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td width="20%" class="hidden-xs">
                                                    <label>Cantidad:</label><?php echo $product['quantity']; ?>
                                                </td>
                                            </tr> 
                                <?php
                                $p_saving += Product::instance($product['id'])->get('price') - $product['price'];
                            endforeach;
                        endif;
                        ?> 
                                        </tbody>
                                    </table>
                                    </div>

 
                                    <div class="p clearfix">
                                    <!-- pc coupon -->
                                        <form method="post" action="<?php echo LANGPATH; ?>/cart/set_coupon" onsubmit="return setCoupon();">
                                        <input type="hidden" name="return_url" value="<?php echo LANGPATH ?>/cart/checkout" />
                                        <label class="fll mt5">Utilizar Código de Promoción:</label>
                                        <input class="form-control form-payment fll hidden-xs" type="text" id="coupon_code1" name="coupon_code">
                                        <input class="btn btn-sm btn-default fll ml10 hidden-xs fll" style="margin-top:2px;" type="submit" value="APLICAR">
                                        </form>
                                 <!-- end coupon -->
                                        <div style="position:relative;display:inline-block;float:left;" class="code">
                                        <a class="fll cold-list J-pop-btn code-list">
                                            <i>Lista de código</i>
                                        </a>
                                                <div id="available_codes" class="codelist-con J-popcon hide" >
                                                    <span class="close-btn"></span>
                                                    <div class="tit"><h3>Código disponible</h3></div>
                                                  <?php
                                                if (count($codes) > 0):
                                                    echo '<ul class="list_con">';
                                                    foreach ($codes as $code):
                                                        ?>
                                                        <li><a href="javascript:;" onclick="choice_coupon('<?php echo $code['code']; ?>');"><?php echo $code['code']; ?></a></li>
                                                        <?php
                                                    endforeach;
                                                    echo '</ul>';
                                                else:
                                                    ?>
                                                    <div class="codenone">No código disponible.</div> 
                                                <?php
                                                endif;
                                                ?>                                            
                                                </div>
                                            </i>
                                        </div>


                                        <!-- <a  class="fll cold-list J-pop-btn a-underline"><i>Code List</i></a> -->
                                        <span class="col-xs-12 hidden-sm hidden-md hidden-lg">

                                        <!-- phone coupon -->
                                        
                                        <input type="hidden" name="return_url" value="<?php echo LANGPATH ?>/cart/checkout" />
                                        <input class="form-control form-payment fll" type="text" id="coupon_code" name="coupon_code">
                                        <input class="btn btn-xs btn-default fll ml10" style="margin-top:2px;" type="submit" id="onclickcoupon" value="APLICAR"></span>
                                        
                                        <!-- end phone -->

                                        <p class="fll p p-second hidden-xs"> 
                                     <strong>Subtotal:</strong><?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?>
                                         + Código de Promoción:<span class="red" id="coupon_save_pc">-<?php echo Site::instance()->price($cart['amount']['coupon_save'], 'code_view'); ?> </span> 
                                         <?php if($cart['amount']['point'] >0){ 
                                            ?>

                                          + Puntos de Choies: <span class="red" id="point_save_pc">-<?php echo Site::instance()->price($cart['amount']['point'], 'code_view'); ?></span> 
                                        <?php } ?>
                                          + Costo del Envío:
                                          <span id="shipping_total_pc"><?php echo $cart_shipping == -1 ? Site::instance()->price($site_shipping[2]['price'], 'code_view') : Site::instance()->price($cart_shipping, 'code_view'); ?>
                                      </span>
                                          + Seguro del Envío:<span id="oi_insurance_pc"><?php if($_SESSION['insurance'] != -1){
                                           echo Site::instance()->price(0.99, 'code_view');
                                           } ?>
                                        </span>  =  
                                             <span class="red" style="font-size:24px;font-weight:bold;">Pedido total:
                                             <span id="totalPrice_pc"><?php echo $cart['amount']['shipping'] ? Site::instance()->price($cart['amount']['total']+ $insurance, 'code_view') : Site::instance()->price($cart['amount']['total'] + $default_shipping + $insurance, 'code_view'); ?>
                                             </span>
                                             </span>
                                        </p>
                                        <table class="add-table hidden-sm hidden-md hidden-lg" width="100%">
                                            <tbody>
                                       <tr>
                                                    <td width="50%">
                                                        Subtotal: 
                                                    </td>
                                                    <td width="50%">
                                                        <?php echo Site::instance()->price($cart['amount']['items'], 'code_view'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">
                                                        Codigo promocional: 
                                                    </td>
                                                    <td width="50%">
                                                        <span class="red" id="coupon_save">-<?php echo Site::instance()->price($cart['amount']['coupon_save'], 'code_view'); ?></span>  
                                                    </td>
                                                </tr>
                                                <?php if($cart['amount']['point'] >0){ ?>
                                                <tr>
                                                    <td width="50%">
                                                        Choies puntos: 
                                                    </td>
                                                    <td width="50%">
                                                        <span class="red" id="point_save">-<?php echo Site::instance()->price($cart['amount']['point'], 'code_view'); ?></span>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td width="50%">
                                                        Estimado de transporte:
                                                    </td>
                                                    <td width="50%">
                                                      <span id="shipping_total">            
                                                      <?php echo $cart_shipping == -1 ? Site::instance()->price($site_shipping[2]['price'], 'code_view') : Site::instance()->price($cart_shipping, 'code_view'); ?>
                                                      </span>
                                                    </td>
                                                </tr>
                                                <tr id="phone_in">
                                                    <td width="50%">
                                                        Seguro de envio: 
                                                    </td>
                                                    <td width="50%">
                                                    <span id="oi_insurance"><?php if($_SESSION['insurance'] != -1){
                                           echo Site::instance()->price(0.99, 'code_view');
                                           } ?>
                                                    </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="50%">
                                                        Total: 
                                                    </td>
                                                  <?php  if($_SESSION['insurance'] != -1){ 
                                                    $insurance = 0.99;
                                                  }else{
                                                    $insurance = 0;
                                                    }  ?>
                                                    <td width="50%">
                                                    <span class="font18">
                                                    <span id="totalPrice"><?php echo $cart['amount']['shipping'] ? Site::instance()->price($cart['amount']['total']+ $insurance, 'code_view') : Site::instance()->price($cart['amount']['total'] + $default_shipping + $insurance, 'code_view'); ?>
                                                    </span>
                                                     </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                                    
                                    
                                </div>
                            </div>

                            <!--new user-->
                <?php

                $has_address = (isset($cart['shipping_address']) AND !empty($cart['shipping_address'])) ? 1 : 0;
                ?>
                            <div  class="lay-one">
                            <div id="shippingnew" class="lay-title <?php if($has_address){ echo 'hide'; }?>">
                                <h2><i class="off">2</i>Información de la dirección</h2>
                            </div>
                            <!-- new user begin -->
                                <div class="primaryinfo primaryinfo-block clearfix <?php if($has_address){ echo 'hide'; }?>" id="shippingAddressFill" >
                                    <form class="address-form mt20" action="" method="post" class="form payment-form form2"  onsubmit="return update_address(this);">

                                    <input type="hidden" name="is_cart" value="1">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <h4>Dirección del envío</h4>
                                                <div class="form-group form-name clearfix">
                                                    <div class=" is-empty form-name-div floatLabel">
                                                        <input type="text" class="form-control" name="firstname" id="s_firstname" style="width:100%;">
                                                        <div class="floatlabel-text">Primer nombre</div>
                                                    </div>
                                                    <div class=" is-empty form-name-div floatLabel second" >
                                                        <input type="text" class="form-control" name="lastname"  id="s_lastname" style="width:100%;">
                                                        <div class="floatlabel-text">Apellido</div>
                                                    </div>
                                                </div>
                                                <div class="form-group is-empty floatLabel">
                                                    <input type="text" class="form-control" name="address" id="s_address">
                                                    <div class="floatlabel-text">Línea 1 de dirección</div>
                                                    <label class="a1 error" style="display:none;"  generated="true" id="guo_con1">Por favor, elige tu país.</label>
                                                </div>
<!--                                                 <div class="form-group  is-empty floatLabel">
    <input type="text" class="form-control">
    <div class="floatlabel-text">Address Line 2(Optional)</div>
</div> -->
                                                <div class="form-group">
                                                    <select  name="country" class="form-control" id="s_country" onchange="changeSelectCountry1();$('#billing_country').val($(this).val());">
                                                        <option value="">País</option>
                                                       <?php if (is_array($countries_top)): ?>
                                                                <?php foreach ($countries_top as $country_top): ?>
                                                                    <option value="<?php echo $country_top['isocode']; ?>"><?php echo $country_top['name']; ?></option>
                                                                <?php endforeach; ?>
                                                                <option disabled="disabled">———————————</option>
                                                            <?php endif; ?>
                                          <?php foreach ($countries as $country): ?>
                                                <option value="<?php echo $country['isocode']; ?>" ><?php echo $country['name']; ?></option>
                                            <?php endforeach; ?>

                                                    </select>
                                                </div>

                                                <div class="form-group states1">
                                        <?php
                                        $stateCalled = Kohana::config('state.called');

                                        $stateArr = Kohana::config('state.states');
                                        foreach ($stateArr as $country => $states)
                                        {
                                            if($country == "US")
                                            {
                                                $enter_title = 'Enter a State';
                                            }
                                            else
                                            {
                                                $enter_title = 'Introducir Estado o Provincia';
                                            }
                                            ?>

                                            <div class="all1" id="all1_<?php echo $country; ?>" style="display:none;">
                                                    <select class="form-control s_state" onblur="$('#billing_state1').val($(this).val());" onchange="acecoun()">
                                                        <option value="">[<?php echo $enter_title; ?>]</option>
                                                    <?php
                                                    foreach ($states as $coun => $state)
                                                    {
                                                        if (is_array($state))
                                                        {
                                                            echo '<optgroup label="' . $coun . '">';
                                                            foreach ($state as $s)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                                                                <?php
                                                            }
                                                            echo '</optgroup>';
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <option value="<?php echo $state; ?>"><?php echo $state; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            <?php
                                          }
                                        ?>
                                        </div>
                                                
                                                    <div class="is-empty form-name-div floatLabel second call1" id="all1_default" >
                                                        <input type="text" class="form-control" name="state" id="s_state"  onchange="acecoun()" >
                                                        <div class="floatlabel-text">Estado/provincia</div>

                                                        <div class="errorInfo"></div>
                                                         <label class="error a3" style="display:none;"  generated="true" id="guo_don1">Por favor, elige tu país.</label>
                                                    </div>


                                            
                                                <div class="form-group form-name clearfix">
                                                    <div class=" is-empty form-name-div floatLabel">
                                                        <input type="text" class="form-control" name="city" style="width:100%;" name="city" id="s_city" onchange="acedoun()">
                                                        <div class="floatlabel-text">Ciudad / Pueblo </div>
                                                        <label class="error a4" style="display:none;" generated="true" id="guo_eon1">¿Ciudad / localidad nombre con dígitos?Por favor, Compruebe la precision de la informacion acerca de.</label>
                                                    </div>

                                                    <div class=" is-empty form-name-div floatLabel second">
                                                        <input type="text" class="form-control" name="zip" id="s_zip" style="width:100%;" onchange="ace()">
                                                        <div class="floatlabel-text">Código postal</div>
                                                        <p class="phone_tips">Ingresa 0000, si no hay código postal en tu país.</p>
                                                        <!--
                                                        <label class="error" style="display:none;" generated="true" id="guo_fon1">It seems that there are no digits in your code, please check the accuracy.</label>
                                                        <p class="phone_tips phone-t">If there is no zip code in your area, please enter 0000 instead.</p>  
                                                        -->
                                                        </div>
                                                </div>

                                                <div class="form-group  is-empty floatLabel">
                                                    <input type="text" class="form-control" name="phone" id="s_phone">
                                                    <div class="floatlabel-text">Teléfono</div>
                                                </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                    <label style="font-weight:normal; display:block;"><input  type="checkbox" id="billaddress2" checked="checked" style="margin:4px 10px 0 0;">Guardar como mi dirección de facturación.</label>
                                                    <input type="hidden" id="billaddress3" name="billaddress3" value="1" />
                                                </div>
                                        </div>
                                        <script>
                                        $("#billaddress2").click(function(){
                                            var ace = document.getElementById('billaddress3').value;
                                               if(ace ==1){
                                                document.getElementById('billaddress3').value = 0;
                                               }else{
                                                document.getElementById('billaddress3').value = 1;
                                               }                                     
                                        })
                                                
                                        </script>
                                        </div>
                                        <div calss="col-xs-12 ">
                                            <input id="spgInfoCountinue" type="submit" class="btn btn-primary btn-md flr " value="Continuar">
                                        </div>  
                                    </form>               
                                </div>


                                <!-- new user end -->

                            <!-- begin -->
                                <div  id="myModal10-1" class="primaryinfo primaryinfo-block clearfix  reveal-modal large" style="padding:30px 10px">
                                    <a class="close-reveal-modal-1 close-btn3"></a>
                                    <form onsubmit="return update_address(this);" class="address-form mt20 form1 form"  method="post">
                                    <input type="hidden" name="address_id" id="shipping_address_id" value="<?php echo $cart['shipping_address']['shipping_address_id']; ?>" />
                                    <input type="hidden" name="is_cart" id="is_cart" value="1" />
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <h4>Dirección del envío</h4>
                                                <div class="form-group form-name clearfix">
                                                    <div class=" is-empty form-name-div floatLabel"><label>Primer Nombre</label>
                                                        <input type="text" class="form-control" name="firstname"  id="shipping_firstname" style="width:100%;" value="" kai="kai">
                                                    </div>
                                                    <div class=" is-empty form-name-div floatLabel second" ><label>Apellido</label>
                                                        <input type="text" class="form-control" name="lastname"  id="shipping_lastname" style="width:100%;" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group is-empty floatLabel"><label>Dirección</label>
                                                    <input type="text" class="form-control" name="address"  id="shipping_address" onchange="ace2()" value="<?php echo $cart['shipping_address']['shipping_address']; ?>">
                                                </div>


                                                <div class="form-group"><label>País</label>
                                                    <select  name="country" class="form-control" id="shipping_country" onchange="changeSelectCountry2();$('#billing_country').val($(this).val());">
                                                    <?php if (is_array($countries_top)): ?>
                                                        <?php foreach ($countries_top as $country_top): ?>
                                                            <option value="<?php echo $country_top['isocode']; ?>"><?php echo $country_top['name']; ?></option>
                                                        <?php endforeach; ?>
                                                        <option disabled="disabled">———————————</option>
                                                    <?php endif; ?>
                                                    <?php foreach ($countries as $country): ?>
                                                        <option value="<?php echo $country['isocode']; ?>" <?php if ($cart['shipping_address']['shipping_country'] == $country['isocode']) echo 'selected'; ?> ><?php echo $country['name']; ?></option>
                                                    <?php endforeach; ?>

                                                    </select>
                                                </div>
                                                <div class="form-group states2">
                                        <?php
                                        $stateCalled = Kohana::config('state.called');

                                        $stateArr = Kohana::config('state.states');
                                        foreach ($stateArr as $country => $states)
                                        {
                                            if($country == "US")
                                            {
                                                $enter_title = 'Enter a State';
                                            }
                                            else
                                            {
                                                $enter_title = 'Introducir Estado o Provincia';
                                            }
                                            ?>
                                            <div class="all2" id="all2_<?php echo $country; ?>" style="display:none;"><label>Estado</label>
                                                    <select  name="" class="form-control s_state" onblur="$('#billing_state1').val($(this).val());" onchange="acecoun()" id="s_state">
                                                        <option value="">[<?php echo $enter_title; ?>]</option>
                                                    <?php
                                                    foreach ($states as $coun => $state)
                                                    {
                                                        if (is_array($state))
                                                        {
                                                            echo '<optgroup label="' . $coun . '">';
                                                            foreach ($state as $s)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                                                                <?php
                                                            }
                                                            echo '</optgroup>';
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <option value="<?php echo $state; ?>"><?php echo $state; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            <?php
                                          }
                                        ?>
                                       
                                                   <div class="is-empty form-name-div floatLabel second call2" id="all2_default" ><label id="ace">Estado</label>
                                                        <input type="text" class="form-control" name="state" id="shipping_state"  onchange="acecoun()" value="<?php echo $cart['shipping_address']['shipping_state']; ?>" >
                                                        <div class="errorInfo"></div>
                                                         <label class="error a3" style="display:none;"  generated="true" id="guo_don">Por favor, elige tu país.</label>
                                                    </div>
                                         </div>

                                        <script>
                                     
                                            function changeSelectCountry2(){
                                                var select = document.getElementById("shipping_country");
                                                var countryCode = select.options[select.selectedIndex].value;
                                                if(countryCode == 'BR')
                                                {
                                                    $("#shipping_cpf").show();
                                                    $("#guo111").hide();
                                                }
                                                else if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
                                                {   
                                                
/*                                                var ooo = $("#guo_con");
                                                    ooo.show();
                                                    ooo.html('請輸入中文地址(Please enter the address in Chinese.)');*/
                                                }
                                                else
                                                {
                                                    $("#shipping_cpf").hide();
                                                    $("#guo_con").hide();
                                                }
                                                var c_name = 'call2_' + countryCode;
                                                $(".states2 .call2").hide();
                                                if(document.getElementById(c_name))
                                                {
                                                    $(".states2 #"+c_name).show();
                                                }
                                                else
                                                {
                                                    $(".states2 #call2_Default").show();
                                                    $("#guo111").hide();
                                                }
                                                var s_name = 'all2_' + countryCode;
                                                  $(".states2 .all2").hide();
                                                  $(".states2 #all2_default input").hide();
                                                if(document.getElementById(s_name))
                                                {
                                                    $(".states2 #"+s_name).show();
                                                    document.getElementById("ace").style.display = 'none';;
                                                }
                                                else
                                                {
                                                    document.getElementById("ace").style.display = 'block';
                                                    $(".states2 #all2_default").show();
                                                    $(".states2 #all2_default input").show();
                                                }
                                                $("#all2_default input").val('');
                                            }
                                            $(function(){
                                                $(".states2 .all2 select").change(function(){
                                                    var val = $(this).val();
                                                    $("#all2_default input").val(val);
                                                })
                                            })
                                        </script>

                                                <div class="form-group form-name clearfix">
                                                    <div class=" is-empty form-name-div floatLabel"><label>Ciudad</label>
                                                        <input type="text" class="form-control" name="city" style="width:100%;" value="<?php echo $cart['shipping_address']['shipping_city']; ?>" name="city" id="shipping_city" onchange="acedoun()">
                                                        
                                                        <label class="error a4" style="display:none;"  generated="true" id="guo_eon">¿Ciudad / localidad nombre con dígitos?Por favor, Compruebe la precision de la informacion acerca de</label>
                                                    </div>

                                                    <div class=" is-empty form-name-div floatLabel second"><label>Código Postal</label>
                                                        <input type="text" class="form-control"  style="width:100%;" value="<?php echo $cart['shipping_address']['shipping_zip']; ?>" name="zip" id="shipping_zip" onchange="ace()">
                                                        <p class="phone_tips">Ingresa 0000, si no hay código postal en tu país.</p>
                                                        <label class="error" style="display:none;" generated="true" id="guo_fon520">Parece que no hay dígitos en su código, por favor compruebe la exactitud.</label>
                                                    </div>
                                                </div>
                                                <div class="form-group  is-empty floatLabel"><label>Teléfono</label>
                                                    <input type="text" class="form-control" value="<?php echo $cart['shipping_address']['shipping_phone']; ?>" name="phone" id="shipping_phone">
                                                    
                                                </div>
                                                <div class="form-group hide" value="0">
                                                    <input type="text" name="cpf" id="shipping_cpf" class="form-control" value="">
                                                    <div class="floatlabel-text">O cadastro de Pessoa f í sica</div>
                                                </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                    <label style="font-weight:normal; display:block;"><input name="" type="checkbox" value="" checked="checked" style="margin:4px 10px 0 0;">Configurar como predeterminada.</label>
                                                    <label style="font-weight:normal; display:block;"><input type="checkbox" style="margin:4px 10px 0 0;" value="" checked="checked" name="" id="billaddress1">Guardar como mi dirección de facturación.</label>
                                                    <input type="hidden" id="billaddress" name="billaddress" value="1" />                                             
                                                     </div>
                                        </div>
                                        </div>
                                        <script>
                                        $("#billaddress1").click(function(){
                                            var ac = document.getElementById('billaddress').value;
                                               if(ac ==1){
                                                document.getElementById('billaddress').value = 0;
                                               }else{
                                                document.getElementById('billaddress').value = 1;
                                               }                                     
                                        })
                                                
                                        </script>
                                        <div calss="col-xs-12 ">
                                            <input type="submit" class="btn btn-primary btn-md flr " value="Continuar">
                                        </div>  
                                    </form>               
                                </div>
                                <!-- end -->
                            </div>
                            
                            <!--user address-->
                            <div  class="lay-one order-info hide pt5 <?php if(!$has_address){ echo 'hide'; }?>" id="successaddress" >
                            <div class="lay-title">
                                <h2><i class="on">2</i>Información de la dirección</h2>
                        <?php
                        $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
                        $count_address = count($addresses);
                        $show_address = $has_address AND isset($cart['shipping']['price']) ? 1 : 0;
                        if ($show_address)
                        {
                            $shipping_country = $cart['shipping_address']['shipping_country'];
                            foreach ($countries as $c)
                            {
                                if ($c['isocode'] == $shipping_country)
                                {
                                    $shipping_country = $c['name'];
                                    break;
                                }
                            }
                        }
                        ?>
                                <div class="primaryinfo primaryinfo-on clearfix hidden-xs hide" id="shippingAddressInfo">
                                <?php
                                    if ($has_address)
                                    {
                                    ?>
                                        <strong><?php echo $cart['shipping_address']['shipping_firstname'] . ' ' . $cart['shipping_address']['shipping_lastname']; ?></strong>  &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cart['shipping_address']['shipping_address'] . ' ' . $cart['shipping_address']['shipping_city'] . ', ' . $cart['shipping_address']['shipping_state'] . ' ' . $shipping_country ?>   &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $cart['shipping_address']['shipping_phone']; ?>
                                        <div>
                                            <button type="button" class="btn btn-edit btn-xs flr" onclick="edit_address2();">
                                            <a href="javascript:;" onclick="edit_address2();">Modificar</a>
                                            </button>
                                        </div>
                                    <?php
                                    }
                                    ?> 
                                </div>
                                <div class="primaryinfo primaryinfo-on clearfix hidden-sm hidden-md hidden-lg hide" id="m-shippingAddressInfo">
                                    <p><strong><?php echo $cart['shipping_address']['shipping_firstname'] . ' ' . $cart['shipping_address']['shipping_lastname']; ?></strong></p>
                                    <p><?php echo $cart['shipping_address']['shipping_address'] . ' ' . $cart['shipping_address']['shipping_city'] . ', ' . $cart['shipping_address']['shipping_state'] . ' ' . $shipping_country ?> <p>
                                    <p><?php echo $cart['shipping_address']['shipping_phone']; ?></p>
                                    <div>
                                        <button type="button" class="btn btn-edit btn-xs flr" onclick="edit_address2();">
                                        <a  onclick="edit_address2();">Modificar</a>   
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!--老用户-->
                            <div  class="lay-one <?php if(!$has_address){ echo 'hide'; }?>" id="shippingAddressAdd">
                                <div class="lay-title">
                                    <h2><i class="off">2</i>Información de la dirección</h2>
                                    <div class="information-box primaryinfo-block clearfix">
                                        <form action="" method="post" name="shipping_address_radio">
                                        <ul class="hidden-xs address-list mt10" id="shipping_address_ul">
                                    <?php
                                    $default_key = 0;
                                    if ($has_address)
                                    {
                                        if ($cart['shipping_address']['shipping_address_id'] == 'new')
                                        {
                                            foreach ($addresses as $key => $value)
                                            {
                                                if ($value['id'] > $default_key)
                                                    $default_key = $key;
                                            }
                                        }
                                        else
                                        {
                                            foreach ($addresses as $key => $value)
                                            {
                                                if ($value['is_default'])
                                                    $default_key = $key;
                                            }
                                        }
                                    }
                                    foreach($addresses as $key => $value)
                                    {
                                    ?>
                                            <li class="mb20" >
                                                <table class="shopping-table address-option-list" width="100%">
                                                    <tr                                                  <?php  if ($cart['shipping_address']['shipping_address_id'] == $value['id'])
                                                    { echo "class='address-option-selected'";
                                                      }  ?>
                                                        >
                                                        <td width="5%">
                                                        <span onclick="select_address(<?php echo $value['id']; ?>);" id="address_li_<?php echo $value['id']; ?>" <?php if($cart['shipping_address']['shipping_address_id'] == $value['id']) echo 'class="selected"'; ?> ></span>
                                                        </td>
                                                <?php  if ($cart['shipping_address']['shipping_address_id'] == $value['id'])
                                                    { ?>
                                                    <td width="10%">Seleccionado</td>
                                                   <?php   }else{  ?>
                                                     <td width="10%">Seleccionar</td>   
                                                    <?php } ?>
                                                        <td width="15%"><?php echo $value['firstname'] . ' ' . $value['lastname']; ?>
                                                        </td>
                                                        <td width="45%"><?php echo $value['address'] . ', ' . $value['city'] . ', ' . $value['state'] . ', ' . $value['country'] . ', ' . $value['zip']; ?>
                                                        </td>
                                                    <?php
                                                    if ($key == $default_key)
                                                    {
                                                        ?>
                                                        <td width="10%" class="address-detault" id="detault_<?php echo $value['id']; ?>">
                                                        <a class="default"><i>Predeterminada</i></a>
                                                        </td>
                                                        <td style="display:none;" width="10%" class="address-detault-a" id="address_detault_<?php echo $value['id']; ?>" >
                                                        <a style="text-decoration:underline;"  href="javascript:;" onclick="default_address(<?php echo $value['id']; ?>);">
                                                        <i>Configurar como predeterminada</i>
                                                        </a>
                                                        </td>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td width="10%" class="address-detault-a" id="address_detault_<?php echo $value['id']; ?>">
                                                        <a style="text-decoration:underline;"  href="javascript:;"  onclick="default_address(<?php echo $value['id']; ?>);">
                                                        <i>Configurar como predeterminada</i>
                                                        </a>
                                                        </td>
                                                        <td width="10%" class="address-detault" id="detault_<?php echo $value['id']; ?>" style="display:none;">
                                                        <a class="default"><i>Predeterminada</i></a>
                                                        </td>
                                                        <?php
                                                    }
                                                    ?>
                                                        <td width="5%"><a style="text-decoration:underline;" data-reveal-id="myModal10-1" onclick="edit_address(<?php echo $value['id']; ?>, 1);" href="javascript:;"><i>Modificar</i></a></td>
                                                        <td width="10%"><a style="text-decoration:underline;" data-reveal-id="myModal6" onclick="delete_address(<?php echo $value['id']; ?>);" href="javascript:;"><i>Eliminar</i></a></td>
                                                    </tr>
                                                </table>
                                            </li>
                                    <?php
                                    }
                                    ?>
                                            <li>
                                                <span><a class="a-underline js-add" href="javascript:;" id="add_new_address" data-reveal-id="myModal10-1" onclick="return new_address_show();"><strong>+ Añadir una nueva dirección</strong></a></span>
                                            </li>
                                        </ul>

                                        
                                        <ul class="phone-ul hidden-sm hidden-md hidden-lg address-list-phone" id="m_phone">
                                   <?php
                                    $default_key = 0;
                                    if ($has_address)
                                    {
                                        if ($cart['shipping_address']['shipping_address_id'] == 'new')
                                        {
                                            foreach ($addresses as $key => $value)
                                            {
                                                if ($value['id'] > $default_key)
                                                    $default_key = $key;
                                            }
                                        }
                                        else
                                        {
                                            foreach ($addresses as $key => $value)
                                            {
                                                if ($value['is_default'])
                                                    $default_key = $key;
                                            }
                                        }
                                    }
                                    foreach($addresses as $key => $value)
                                    {
                                    ?>
                                            <li class="mb20"  id="m_address_li_<?php echo $value['id']; ?>">
                                                <table class="shopping-table address-option-list" width="100%">
                                                    <tr      <?php  if ($cart['shipping_address']['shipping_address_id'] == $value['id'])
                                                    { echo 'class="address-option-selected"';
                                                    }
                                                        ?>
                                                         onclick="select_address(<?php echo $value['id']; ?>);" >
                                                        <td width="15%" >
                                                        <span <?php if($cart['shipping_address']['shipping_address_id'] == $value['id']) echo 'class="selected"'; ?> ></span>
                                                        </td>
                                                        <td width="85%" style="text-align:left;">
                                                            <p>Dirección <?php echo $key+1;?></p>
                                                            <p><?php echo $value['firstname'] . ' ' . $value['lastname']; ?></p>
                                                            <p><?php echo $value['address'] . ', ' . $value['city'] . ', ' . $value['state'] . ', ' . $value['country'] . ', ' . $value['zip']; ?></p>
                                                            <p><?php echo $value['phone'];?></p>
                                                            <p>
                                                    <?php
                                                    if ($key == $default_key)
                                                    {
                                                        ?>                                             <a><i>Predeterminada</i></a>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                            <a style="text-decoration:underline;"href="javascript:;" id="address_detault_<?php echo $value['id']; ?>" onclick="default_address(<?php echo $value['id']; ?>);"><i>Configurar como predeterminada</i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                            <a style="text-decoration:underline;"data-reveal-id="myModal10-1" onclick="edit_address(<?php echo $value['id']; ?>, 1);" href="javascript:;"><i>Modificar</i></a><a style="text-decoration:underline;"data-reveal-id="myModal6" onclick="delete_address(<?php echo $value['id']; ?>);" href="javascript:;"><i>Eliminar</i></a></p>
                                                        </td> 
                                                    </tr>
                                                </table>
                                            </li>
                                            <?php
                                            }
                                            ?>
                                            <li>
                                                <span><a class="a-underline js-add" href="javascript:;" id="add_new_address" data-reveal-id="myModal10-1" onclick="return new_address_show();"><strong>+ Añadir una nueva dirección</strong></a></span>
                                            </li>
                                        </ul>
                                     </form>
                                        <div calss="col-sm-12">
                                            <input type="submit" class="btn btn-primary btn-md flr mt20" value="Continuar" onclick="return showaddress()">
                                        </div>
                                   
                                    </div>
                                </div>
                            </div>

                            <!--老用户物流信息展示-->
                            <div  class="lay-one order-info pt5 hide" id="shippingsuccessdiv">
                            <div class="lay-title">
                                    <?php
                      $cart_shipping = !empty($cart['shipping']) ? $cart['shipping']['price'] : -1;
                       $default_shipping = 0;

                        foreach ($site_shipping as $key => $price)
                        {
                            if ($cart_shipping == -1)
                            {
                                if ($key == 1)
                                {
                                    $default_shipping = $price['price'];
                                }
                            }
                            elseif ($price['price'] == $cart_shipping)
                            {
                                $default_shipping = $price['price'];
                            }

                            if($key == 1 && $cart_shipping == 7){
                                $default_shipping = 7;
                                $site_shipping[1]['price'] = 7;
                            }
                        } ?>


                                <h2><i class="on">3</i>Método del envío</h2>
                                <div class="primaryinfo primaryinfo-on clearfix hidden-xs">
                <?php
                foreach ($site_shipping as $key => $price)
                { 
                    $name1 = 'Envío Estándar';
                    $site_shipping[1]['name'] = $name1;
                    $name2 = 'Envío Exprés';
                    $site_shipping[2]['name'] = $name2;

                    $day1 = '10-15 días laborables';
                    $site_shipping[1]['days'] = $day1;
                    $day2 = '4-7 días laborables';
                    $site_shipping[2]['days'] = $day2;
                }
                 foreach ($site_shipping as $key => $price)
                { 
                    ?>
                        <span <?php if ($price['price'] != $default_shipping){
                            echo 'class="hide"';
                            }?>>
                            <div id="kai" style="float:left;">
                            <?php if($price['name']=='Standard Shipping'){echo 'Envío Estándar';}else{echo $price['name'];} ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($price['days']=='10-15 Days'){echo '10-15 días laborables';}else{echo $price['days'];} ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Site::instance()->price($price['price'], 'code_view'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </div>
                            <span id="click1" style="float:left;">Seguro de envio&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Site::instance()->price(0.99, 'code_view'); ?></span>
                        </span>
                <?php
                    }
                    ?>
                                    <div>
                                        <button type="button" class="btn btn-edit btn-xs flr" onclick="return shippingshow();">Modificar</button>
                                    </div>
                                </div>

                                <!--phone -->
            <div class="primaryinfo primaryinfo-on clearfix hidden-sm hidden-md hidden-lg">
                                <?php
                foreach ($site_shipping as $key => $price)
                { 
                    ?>
                                <span <?php if ($price['price'] != $default_shipping){
                            echo 'class="hide"';
                            }?>>
                                    <p id="shipping1"><?php echo $price['name']; ?></p><p id="shipping2"><?php echo $price['days']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Site::instance()->price($price['price'], 'code_view');?></p><p id="shipping3">Seguro de envio&nbsp;&nbsp;&nbsp;&nbsp;$0.99</p>
                                </span>
                                  <?php
                }
                    ?>
                
                                   <div>
                                        <button type="button" class="btn btn-edit btn-xs flr" onclick="return shippingshow();">Modificar</button>
                                    </div>
                                </div>
                                <!-- end phone -->
                            </div>
                            </div>
                            <div  class="lay-one">
                            <div class="lay-title hide" id="shippingdiv">
                            <form action="<?php echo LANGPATH; ?>/cart/edit_shipping" method="post" class="form payment-form" onsubmit="return setShipping(this);" id="editshipingform">
                            <input type="hidden" id="shipping_price" value="<?php echo $default_shipping; ?>" name="shipping_price" />
                                <h2><i class="off">3</i>Método del envío</h2>
                                <div class="information-box primaryinfo-block clearfix">
                                    <ul>
                <?php
                foreach ($site_shipping as $key => $price)
                {?>
                                        <li class="mb20" id="shipping_price_list_<?php echo $key; ?>" <?php if(in_array($cart['shipping_address']['shipping_country'], $no_express_countries) && $key==2) echo 'style="display:none;"'; ?>>
                                            <table class="shopping-table shipping-list" width="100%">
                                                <tr>
                                                    <td width="45%"><input type="radio" class="s_price_list" <?php if ($price['price'] == $default_shipping || $price['price']==7) echo 'checked'; ?>  name="sprice" value="<?php echo $price['price']; ?>" id="sprice_radios<?php echo $key; ?>" onclick="change_sprice(<?php echo $price['price']; ?>);">
                                                    <?php  if($price['name']=='Envío Estándar'){ echo 'Envío Estándar';}else{ echo 'Envío Exprés';} ?>
                                                    </td>
                                                    <td width="30%">
                                                    <?php if($price['days']=='10-15 días laborables'){ echo '10-15 días laborables';}else{ echo '4-7 días laborables';}?>
                                                    </td>
                                                    <td width="25%">
                                                    <?php echo Site::instance()->price($price['price'], 'code_view'); ?>
                                                    </td>  
                                                </tr>
                                            </table>
                                        </li>
                        <?php
                            }
                          /*  }*/
                            ?>
                                        <li class="mb20">
                                            <table class="shopping-table shipping-list" width="100%">
                                                <tr>
                                                    <td width="75%" class="method" style="color:#a9a9a9;"><input type="checkbox" value="1" name="insurance_pc" id="insurance_pc" <?php if($_SESSION['insurance'] != -1){ echo 'checked'; } ?>> 
                                                     Añade el seguro de envío para su pedido                            
                                                       <div class="JS-show add-s-fa" id="showshipping">
                                                            <a href="javascript:viod();" class="fa fa-question-circle" style="text-decoration:none; color:#a9a9a9;"></a>
                                                            <div class="ins-info JS-showcon" id="hideshipping" style="display: none;" >
                                                                <b class="arrow-up"></b>
                                                                <div class="ins-tipscon">El seguro de envío ofrece una protección superior y la seguridad para su paquete durante la entrega internacional. Vamos a reenviar su paquete inmediatamente sin coste adicional si se pierde o se rompe.
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </td>
                                                    <td width="25%"><?php echo Site::instance()->price(0.99, 'code_view'); ?></td>  
                                                </tr>
                                            </table>
                                        </li>
                                    </ul>
                                    <input type="hidden" name="shipping_price" id="new_shipping_price" value="<?php echo $default_shipping; ?>" />
                                    <div calss="col-sm-12">
                                        <button type="button" class="btn btn-primary btn-md flr mb20" onclick="return edit_address3()">Continuar</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <div  class="lay-one hide" id="paymentInfo" <?php if(!$has_address) echo 'style="display:none;"'; ?> >
                                <div class="lay-title">
                                    <h2><i class="off">4</i>Pago</h2>
                                    <form  method="post" action="" id="payment_form">
                                    <div class="information-box payment-information primaryinfo-block clearfix">
                                        <label>Por favor, elija un método de pago:</label>
                                        <ul class="radio-option-list">
                                          <?php
                                            $no_paypal = 0;
                                            if(!$no_paypal)
                                            {
                                            ?>
                                            <li onclick="return showpaytype2()" class="radio-option  radio-option-condensed-s">
                                                <input type="radio" value="PP" id="radio_2" class="radio" name="payment_method" checked="" />
                                                <label  class="payment-radio-opt ">
                                                    <img src="/assets/images/paypal.png">
                                                </label>
                                            </li>
                                          <?php
                                            }
                                            ?>
                                            <li class="radio-option  radio-option-condensed-s" onclick="return showpaytype()">
                                                <input type="radio" value="GC" id="radio_1" class="radio" name="payment_method" <?php if($no_paypal) echo 'checked="checked"'; ?> />
                                                <label  class="payment-radio-opt">
                                                    <img src="/assets/images/card-type.jpg">
                                                </label>
                                            </li>
                                            <li  onclick="return showpaytype2()" id="sofort_banking" class="radio-option  radio-option-condensed-s" <?php if(!array_key_exists($cart['shipping_address']['shipping_country'], $sofort_countries)) echo 'style="display:none;";' ?>>
                                                <input type="radio" value="SOFORT" id="radio_3" class="radio" name="payment_method"/>
                                                <label  class="payment-radio-opt ">
                                                    <img src="/assets/images/card12.jpg">
                                                </label>
                                            </li>
                                            <li  onclick="return showpaytype2()" id="ideal" class="radio-option  radio-option-condensed-s" id="ideal" <?php if($cart['shipping_address']['shipping_country'] != 'NL') echo 'style="display:none;";' ?>>
                                                <input type="radio" value="IDEAL" id="radio_4" class="radio" name="payment_method"/>
                                                <label class="payment-radio-opt ">
                                                    <img src="/assets/images/card13.jpg">
                                                </label>
                                            </li>
                                        </ul>

                                        <div class="pay-paypal" id="paypaldiv">
                                            <p>PayPal es un metodo de pago seguro y confiable para las compras en linea. Si usted no tiene una cuenta de PayPal, usted también puede pagar a través de PayPal con tu tarjeta de credito o tarjeta de debito bancario.</p>
                                            <p class="mt20"><img src="/assets/images/paypal-payment.png"></p>
                                        </div>

                                        <div class="hide pay-credit">
                                            <div class="form-group">
                                                <label>* Tipo de tarjeta:</label>
                                                <div class="clearfix" >
                                                    <select name="card_type" class="form-control sm-width col-sm-12 col-md-6 mr10" id="card_select" onchange="select_ch()">
                                                         <option selected="selected" value="0">Por favor, elija el tipo de tarjeta</option>
                                                        <option value="1"> Visa </option><!--11111-->
                                                        <option value="3"> MasterCard </option>
                                                        <option value="122"> Visa Electron </option>
                                                        <option value="114"> Visa Debit </option>
                                                        <option value="119"> MasterCard Debit </option>
                                                        <option value="125"> JCB </option>
                                                        <option value="128"> Discover </option>
                                                        <option value="132"> Diners Club </option>
                                                    </select>
                                                    <div class="col-sm-12 col-md-5" style="padding:0px;paddding-top:2px;">
                                                <ul class="cards-img">
                                                    <li onclick="return change_card(1);">
                                                        <label for=""><img src="/assets/images/card16.jpg" title="Visa"></label>
                                                    </li>
                                                    <li onclick="return change_card(2);">
                                                        <label for=""><img src="/assets/images/card15.jpg" title="MasterCard"></label>
                                                    </li>
                                                    <li onclick="return change_card(3);">
                                                        <label for=""><img src="/assets/images/card17.jpg" title="Visa Electron"></label>
                                                    </li>
                                                    <li onclick="return change_card(4);">
                                                        <label for=""><img src="/assets/images/card18.jpg" title="Visa Debit"></label>
                                                    </li>
                                                    <li onclick="return change_card(5);">
                                                        <label for=""><img src="/assets/images/card19.jpg" title="MasterCard Debit"></label>
                                                    </li>
                                                    <li onclick="return change_card(6);">
                                                        <label for=""><img src="/assets/images/card20.jpg" title="JCB"></label>
                                                    </li>
                                                    <li onclick="return change_card(7);">
                                                        <label for=""><img src="/assets/images/card21.jpg" title="Discover"></label>
                                                    </li>
                                                    <li onclick="return change_card(8);">
                                                        <label for=""><img src="/assets/images/card22.jpg" title="Diners Club"></label>
                                                    </li>                    
                                                </ul>
                                                    </div>
                                                </div>
                                                <div class="error red hide" id="card_error1">Por favor, elige tu tipo de tarjeta de crédito.</div> 
                                            </div>
                                            <div class="form-group">
                                                <label>* Número de tarjeta:</label>
                                                <input class="form-control sm-width" name="cardNo" id="cardNo" onclick="error_clean('card_error');" type="text" onkeydown="showcardnum();" onkeyup="clean();">
                                                <div class="card_num_box" id="card_num_box"></div>
                                                <div class="error red hide" id="card_error">El numero de tarjeta de credito es incorrecta.</div>
                                            </div>
                                            <div class="col-sm-12 col-md-3 form-group ">
                                                <label>* Fecha de caducidad:</label>
                                            <?php
                                            $now_month_list = '<option value="0"> Month </option>';
                                            $all_month_list = '<option value="0"> Month </option>';
                                            $m = date('m');
                                            ?>
                                                <div class="clearfix">
                                                    <select  name="cardExpireMonth" class="form-control fll" id="cardExpireMonth" style=" width:90px;" onclick="error_clean('expire_error')">
                                                    <option selected="selected" value="0"> Mes </option>
                                                    <?php
                                                    for($i = 1;$i <= 12;$i ++)
                                                    {
                                                        $j = $i < 10 ? '0' . $i : $i;
                                                        if($i >= $m)
                                                            $now_month_list .= '<option value="' . $j . '"> '. $j . ' </option>';
                                                        $all_month_list .= '<option value="' . $j . '"> '. $j . ' </option>';
                                                    ?>
                                                        <option value="<?php echo $j; ?>"> <?php echo $j; ?> </option>
                                                    <?php
                                                    }
                                                    ?>
                                                    </select>
                                                    <div class="fll" style="margin:8px 10px;">/</div>
                                                    <select  name="cardExpireYear" class="form-control fll" id="cardExpireYear" style="width:80px;" onclick="error_clean('expire_error')">
                                                    <option value="0" selected="selected">Año</option>
                                                    <?php
                                                    $y = date('y');
                                                    for($i = 0;$i < 18;$i ++)
                                                    {
                                                    ?>
                                                        <option value="<?php echo $y + $i; ?>"> <?php echo $y + $i; ?> </option>
                                                    <?php
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="error hide red" id="expire_error">El mes de la fecha de caducidad es incorrecta.</div>  
                                            </div>
                                            <div class="col-sm-12 col-md-9 form-group " >
                                                <label>* Código de seguridad (CVV / CVC):<i class="fa fa-question-circle"></i></label>
                                                <div class="clearfix credit-crad" >
                                                    <input class="form-control col-sm-12 col-md-7 mr10"  id="cvv2" name="cardSecurityCode" type="text" onclick="error_clean('cvv_error')">
                                                    <div class="col-sm-12 col-md-4" style="padding:0px;"><img src="/assets/images/payment-new-credit-crad.png"></div>                              
                                                </div>
                                                <div class="error red hide" id="cvv_error">Introduzca un codigo de 3 digitos CVV / CVC</div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <input type="hidden" name="paytype" id="paytype" value="" />
                                        <div class="form-group mt20">
                                        <input type="submit" id="checkoutbtn" class="btn btn-primary btn-md" value="Realizar Pedido" onclick="return btn_loading();" />
                                            <input type="button" id="checkoutbtn1" class="btn btn-primary btn-md" value="Realizar Pedido" onclick="return btn_loading();" style="display:none;" />
                                            <button type="button" id="loadingbtn" disabled="disabled"  class="btn btn-primary btn-md" style="display:none;">Realizar Pedido</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div  class="lay-one lay-disable" id="type3disabled" style="display:bolck;">
                                <div class="lay-title"><!--111-->
                                    <h2><i class="disable">3</i>Método del envío </h2>
                                </div>
                            </div>
                            <div  class="lay-one lay-disable mb20" id="type4disabled" style="display:bolck;">
                                <div class="lay-title">
                                    <h2><i class="disable">4</i>Pago</h2>
                                </div>
                            </div>

                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <footer>
            <div class="w-top container-fluid">
                <div class="container">
                    <div style="text-align:center;">
                        <p class="paypal-card container">
                            <img usemap="#Card" src="/assets/images/card-payment.jpg">
                            <map id="Card" name="Card">
                                <area target="_blank" href="https://trustsealinfo.websecurity.norton.com/splash?form_file=fdf/splash.fdf&dn=www.choies.com&lang=en" coords="88,2,193,62" shape="rect">
                            </map>
                        </p>
                    </div>
                </div>
                <div class="copyr">
                    <p class="bottom container-fluid">Derechos de autor © 2006-2015 Choies.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color: #ccc;" href="#" class="hidden-xs">Privacidad &amp; Seguridad</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color: #ccc;" href="#" class="hidden-xs">Acerca de Choies</a>
                    </p>
                </div>
            </div>
        </footer>
        <div id="gotop" class="hide ">
            <a href="#" class="xs-mobile-top"></a>
        </div>
    </div>

    <!-- JS-popwincon2 -->
    <div id="myModa2" class="reveal-modal large">
        <a class="close-reveal-modal-1 close-btn3"></a>
        <form class="form payment-form form2">
            <div class="shipping-methods">
                <ul class="clearfix">
                    <li class="col-xs-12 col-md-6">
                        <input type="radio" name="" id="" class="radio"> 
                        <span> 10 - 15 días laborables ( $0.00 )</span>
                    </li>
                    <li class="col-xs-12 col-md-6">
                        <input type="radio" name="" id="" class="radio"> 
                        <span> 4 - 7 días laborables ( $15.00 )</span>
                    </li>
                    
                </ul>
                <p><input type="submit" value="Continuar" class="btn btn-default"></p>
            </div>
        </form>
    </div>
    <!-- JS-popwincon3 -->
<!-- JS-popwincon3 -->
<div id="myModal6" class="reveal-modal medium" id="cart_delete">
        <a class="close-reveal-modal-1 close-btn3"></a>
    <h3>ACCIÓN DE CONFIRMACIÓN</h3>
    <div class="order-addtobag">
        <div class="prompt">¿Está segura de eliminar esta dirección?</div>
        <form action="/cart/delete_address" method="post" id="delete_address_form" onsubmit="return delete_address_submit();">
             <input type="hidden" name="address_id" id="address_id" value="" />
            <input type="submit" class="btn btn-default btn-sm" value="Eliminar">
            <a class="cancel" href="">Cancelar</a>
        </form>
    </div>
</div>

<div class="loading" id="payment_wrap2" style="display:none;">
    <div class="loading-box">
        <div class="loading-title">cargando</div>
        <div class="loading-pic"><img src="/assets/images/gb_loading.gif" alt="" height="68" width="100">  
        <div class="loading-prompt">¡cargando, por favor, espere un momento!</div>
        </div>
    </div>
</div>
<div id="pageOverlay" style="visibility: hidden;"></div>

    <script>
                                        $(".address-form").validate({
        rules: {
            firstname: {    
                required: true,
                maxlength:50
            },
            lastname: {    
                required: true,
                maxlength:50
            },
            address: {
                required: true,
                rangelength:[3,200]
            },
            zip: {
                required: true,
                rangelength:[3,10]
            },
            city: {
                required: true,
                maxlength:50
            },
            country: {
                required: true,
                maxlength:50
            },
            state: {
                required: true,
                maxlength:50
            },
            phone: {
                required: true,
                rangelength:[6,20]
            }
        },
        messages: {
            firstname: {
                required: "Por favor introduce tu nombre.",
                maxlength:"El primer nombre que excede la longitud maxima de 50 caracteres."
            },
            lastname: {
                required: "Por favor introduce tu apellido.",
                maxlength:"El primer nombre que excede la longitud maxima de 50 caracteres."
            },
            address: {
                required: "Por favor introduce tu dirección.",
                rangelength: $.validator.format("Por favor, introduzca 3 - 100 caracteres.")
            },
            zip: {
                required: "Por favor introduce tu código postal.",
                rangelength: $.validator.format("Por favor, introduzca 3 - 10 caracteres.")
            },
            city: {
                required: "Por favor introduce tu ciudad.",
                maxlength:"La ciudad excede la longitud maxima de 50 caracteres."
            },
            country: {
                required: "Por favor, elige tu país.",
                maxlength:"El país excede la longitud maxima de 50 caracteres."
            },
            state: {
                required: "Por favor introduce tu Provincia / Estado.",
                maxlength:"El país excede la longitud maxima de 50 caracteres."
            },
            phone: {
                required: "Por favor introduce tu teléfono.",
                rangelength: $.validator.format("Por favor introduce un teléfono dentro de 6 a 20 digitos.")
            }
        }
                                        });
                            </script>   



<script type="text/javascript">

 // paymeng js
    $(".radio-option-list li").eq(0).click(function(){
        $(".pay-paypal").show();
        $(".pay-credit").hide();
    })
    $(".radio-option-list li").eq(1).click(function(){
        $(".pay-paypal").hide();
        $(".pay-credit").show();
    })      
    $(".radio-option-list li").eq(1).nextAll().click(function(){
        $(".pay-paypal").hide();
        $(".pay-credit").hide();
    })

function btn_loading()
{
    var v = document.getElementById('paytype').value;

    if(v == 0){
    document.getElementById('checkoutbtn').style.display = 'none';
    document.getElementById('loadingbtn').style.display = 'block';
    document.getElementById('payment_form').submit();        
    }

    if(v){  //GC

        var checks = checkFormData();
        if(!checks){
            return false;
        }
        datas = new Object();
    $.ajax({
        type:"post",
        url : '/order/getorm',
        data: datas,
        dataType: "json",
        success: function(data){
            if(data.success == 1){
        $("#payment_form").attr('action', 'https://www.choies.com/payment/gc_pay/'+data.ordernum);
        document.getElementById('checkoutbtn').style.display = 'none';
        document.getElementById('checkoutbtn1').style.display = 'none';
        document.getElementById('loadingbtn').style.display = 'block';
        document.getElementById('payment_form').submit();
            }
        }
    });

    }else{
    document.getElementById('checkoutbtn').style.display = 'none';
    document.getElementById('loadingbtn').style.display = 'block';
    document.getElementById('payment_form').submit();
    }
}

function showaddress()
{
document.getElementById('shippingAddressAdd').style.display = 'none';
document.getElementById('successaddress').style.display = 'block';  
document.getElementById('m-shippingAddressInfo').style.display = 'block';  
document.getElementById('shippingAddressInfo').style.display = 'block'; 
document.getElementById('type3disabled').style.display = 'none'; 
document.getElementById('shippingdiv').style.display = 'block'; 
        var aoep = $("#shippingsuccessdiv").css("display");
        if(aoep == 'block'){
            document.getElementById('shippingdiv').style.display = 'none';
        }    
}   


function change_address_show()
{
    document.getElementById('shippingAddressAdd').style.display = 'block';
    document.getElementById('shippingAddressInfo').style.display = 'none';
    $('html, body').animate({scrollTop: $('#shippingAddressAdd').offset().top}, 300);
    return false;
}

function new_address_show()
{
    document.getElementById('shipping_address_id').value = '';
    document.getElementById('shipping_firstname').value = '';
    document.getElementById('shipping_lastname').value= '';
    document.getElementById('shipping_address').value = '';
    document.getElementById('shipping_country').value = '';
    document.getElementById('shipping_state').value = '';
    document.getElementById('shipping_city').value = '';
    document.getElementById('shipping_zip').value = '';
    document.getElementById('shipping_phone').value = '';

}

function change_sprice(price)
{
    document.getElementById('shipping_price').value = price;
}

function setShipping(formObj)
{
    var datas = createData(formObj);
    $.ajax({
        type:"POST",
        url :"/cart/ajax_shipping_price",
        data:datas,
        dataType:"json",
        success:function(res){
            if(res.response ==1){
/*                 document.getElementById('totalPrice').innerHTML = res.total;
                 document.getElementById('totalPrice_pc').innerHTML = res.total;*/
                 document.getElementById('shipping3').style.display = 'block';//111111
                 document.getElementById('shipping3').innerHTML ="Seguro de envío&nbsp;&nbsp;"+res.insurance;
                 
                 //document.getElementById('oii_insurance_pc').style.display = 'block';
                 //document.getElementById('oi_insurance_pc').innerHTML = res.insurance;
                 $("#phone_in").show();
                 $("#oi_insurance").show();
                 $("#oi_insurance").html(res.insurance);
                 $("#oi_insurance_pc").html(res.insurance);
                 $("#totalPrice_pc").html(res.total);
                 //document.getElementById('oi_insurance').innerHTML = res.insurance;
                 $("#totalsum1").html(res.total);
                $("#totalsum").html(res.total);

                document.getElementById('totalPrice').innerHTML = '';
                document.getElementById('totalPrice').innerHTML = res.total;
                
                 return false;
            }
            if(res.response ==2){
/*                document.getElementById('totalPrice').innerHTML = res.total;
                document.getElementById('totalPrice_pc').innerHTML = res.total;*/
                //document.getElementById('oi_insurance_pc').style.display = 'none';
                document.getElementById('phone_in').style.display = 'none';
                document.getElementById('oi_insurance').style.display = 'none';
                document.getElementById('shipping3').style.display = 'none';
                $("#totalPrice_pc").html(res.total);
                $("#totalsum").html(res.total);
                $("#totalsum1").html(res.total);
                $("#oi_insurance_pc").html("$0.00");
                document.getElementById('totalPrice').innerHTML = '';
                document.getElementById('totalPrice').innerHTML = res.total;
                return false;
            }
            
            var ship_name = $("#sprice_title" + res.val).text();
/*            document.getElementById('shipping_price_list').innerHTML = '';
            document.getElementById('shipping_price_list').innerHTML = ship_name;*/
            
            if(res.val==15){
				$("#shipping1").html("Envío Exprés");
                $("#shipping2").html("4-7&nbsp;&nbsp;días laborables &nbsp;&nbsp;&nbsp;&nbsp;"+ res.price);
                $("#totalsum").html(res.total);
                $("#totalsum1").html(res.total);
                
            }else{
				$("#shipping1").html("Envío Estándar");
                $("#shipping2").html("10-15&nbsp;&nbsp;días laborables &nbsp;&nbsp;&nbsp;&nbsp;"+ res.price);
                $("#totalsum1").html(res.total);
                $("#totalsum").html(res.total);
                
            }
            
                             $("#totalsum1").html(res.total);
                $("#totalsum").html(res.total);
            document.getElementById('shipping_total').innerHTML = '';
            document.getElementById('shipping_total').innerHTML = res.price;
            document.getElementById('shipping_total_pc').innerHTML = '';
            document.getElementById('shipping_total_pc').innerHTML = res.price;
            document.getElementById('totalPrice').innerHTML = '';
            document.getElementById('totalPrice').innerHTML = res.total;
            document.getElementById('totalPrice_pc').innerHTML = '';
            document.getElementById('totalPrice_pc').innerHTML = res.total;
            //document.getElementById('totalPrice_pc').innerHTML = '';
            //document.getElementById('totalPrice_pc').innerHTML = res.total;
            
            $(".opacity").hide();
            $(".JS-popwincon2").hide();
        }
    });
    return false;
}

function showpaytype()
{
    document.getElementById('paytype').value = 1;
    document.getElementById('checkoutbtn1').style.display = 'block';
    document.getElementById('checkoutbtn').style.display = 'none';
}

function showpaytype2()
{
    document.getElementById('paytype').value = 0;
    document.getElementById('checkoutbtn').style.display = 'block';
    document.getElementById('checkoutbtn1').style.display = 'none';
}

function setShippingAddress(id)
{
    datas = new Object();
    datas.address_id = id;
    $.ajax({
        type:"POST",
        url :"/cart/set_address",
        data:datas,
        dataType:"json",
        success:function(datas){
        }
    });
    $(".address_edit").hide();
    $("#address_edit_" + id).show();
    // window.location.reload();
}

function default_address(id)
{
    datas = new Object();
    datas.id = id;
    $.ajax({
        type:"POST",
        url :"/address/ajax_default/",
        data:datas,
        dataType:"json",
        success:function(res){
            if(res.success == 1)
            {
          //      alert(res.message);
                $(".address-detault").hide();
                $(".address-detault-a").show();
                document.getElementById('address_detault_' + id).style.display = 'none';
                document.getElementById('detault_' + id).style.display = 'block';
            }
            else
            {
                alert(res.message);
            }
        }
    });
}

function edit_address(id, is_cart)
{
    if(!id){
        return;
    }
    if(typeof(is_cart) == 'undefined')
    {
        is_cart = 1;
    }
    datas = new Object();
    datas.id = id;
    $.ajax({
        type:"POST",
        url :"/address/ajax_data",
        data:datas,
        dataType:"json",
        success:function(address){
            if(address != 0){
                document.getElementById('shipping_address_id').value = address.id;
                document.getElementById('shipping_firstname').value = address.firstname;
                document.getElementById('shipping_lastname').value = address.lastname;
                document.getElementById('shipping_address').value = address.address;
                document.getElementById('shipping_country').value = address.country;
                document.getElementById('shipping_state').value = address.state;
                document.getElementById('s_state').value = address.state;
                document.getElementById('shipping_city').value = address.city;
                document.getElementById('shipping_zip').value = address.zip;
                document.getElementById('shipping_phone').value = address.phone;
                document.getElementById('shipping_cpf').value = address.cpf;
                
                if(address.country == 'BR')
                {
                    document.getElementById('cpf_list').style.display = 'block';
                }
               var s_name = 'all2_'+address.country;
                    if(document.getElementById(s_name))
                    {
                     $(".states2 .all2").hide();
                     $(".states2 #"+s_name).show();
                     $(".states2 #"+s_name+ " select").val(address.state);
                     document.getElementById('shipping_state').style.display = 'none';
                     document.getElementById('ace').style.display = 'none';
                    }
                    else
                    {
                     $(".states2 .all2").hide();
                     document.getElementById('all2_default').style.display = 'block';
                     $("#all2_default").show();
                     document.getElementById('ace').style.display = 'block';
                     document.getElementById('shipping_state').style.display = 'block';
                    }
            }
            else
            {
               // alert('failed');
            }
        }
    });
}

function edit_address2()
{
    document.getElementById('shippingAddressAdd').style.display = 'block';
    document.getElementById('successaddress').style.display = 'none';
}

function edit_address3()
{
   document.getElementById('shippingdiv').style.display = 'none'; 
   document.getElementById('type4disabled').style.display = 'none'; 
   document.getElementById('shippingsuccessdiv').style.display = 'block'; 
   document.getElementById('paymentInfo').style.display = 'block'; 
   

}

function shippingshow()
{
  document.getElementById('shippingdiv').style.display = 'block';
  document.getElementById('shippingsuccessdiv').style.display = 'none';   
}


function getnewaddress()
{
    $.ajax({
        type:"POST",
        url :"/address/newaddresslist?lang=<?php echo LANGUAGE;?>",
        dataType:"json",
        success:function(result){
        $("#shipping_address_ul").html(result)
        }})
}

//修改
function getnewaddress1()
{

    $.ajax({
        type:"POST",
        url :"/address/newaddresslist1?lang=<?php echo LANGUAGE;?>",
        dataType:"json",
        success:function(result){
        console.log(result);
        $("#m_phone").html(result)

        }})

}



function update_address(formObj)
{
    var datas = createData(formObj);
    var newdata = datas;
    if(!check_address(datas))
        return false;
    if (typeof(datas.shipping_price) != "undefined")
    {
        $.ajax({
            type:"post",
            url : '/address/ajax_edit1',
            data: datas,
            dataType: "json",
            success: function(result){
                if(result.success == 1){

                    var shipping_address_list = '<dt>Dirección del envío<a data-reveal-id="myModal10-1" onclick="return edit_address('+result.address_id+');">Modificar</a>'+change+'</dt>'+
                                    '<dd class="fix"><label>Nombre:</label><span>'+datas.firstname+' '+datas.lastname+'</span></dd>'+
                                    '<dd class="fix"><label>Teléfono:</label><span>'+datas.phone+'</span></dd>'+
                                    '<dd class="fix"><label>Dirección:</label><span>'+datas.address+', '+datas.city+' '+datas.state+', '+datas.country+' '+datas.zip+'</span></dd>';
                    document.getElementById('shipping_address_list').innerHTML = '';
                    document.getElementById('shipping_address_list').innerHTML = shipping_address_list;

            var str = '';
            str +=  "<strong>"+datas.shipping_firstname+' '+datas.shipping_lastname+"</strong>";
            str += "&nbsp;&nbsp;&nbsp;&nbsp;"+datas.shipping_address+', '+datas.shipping_city+' '+datas.shipping_state+', '+datas.shipping_country+' '+datas.shipping_zip;
            str +=  "&nbsp;&nbsp;&nbsp;&nbsp;"+datas.shipping_address+datas.shipping_phone;
            str += "<div><button type=\"button\" class=\"btn btn-edit btn-xs flr\" onclick=\"return edit_address2("+result.address_id+");\">";
            str += '<a href=\"javascript:;\"   onclick=\"return edit_address2();\">Modificar</a>';
            str += "</button></div>";

            $("#shippingAddressInfo").html(str);

                    change_paypal_refund(datas.country);
                    if(result.val ==15){
                      document.getElementById('sprice_radios2').checked=true;
                      document.getElementById('sprice_radios1').checked=false;
                    }

                    if(result.has_no_express)
                    {
                        var ship_name = $("#sprice_title" + result.shipping_val).text();
                        document.getElementById('shipping_price_list_2').style.display = 'none';
                        document.getElementById('shipping_price_list_1').style.display = 'block';
                        document.getElementById('aaab').style.display = 'block';
                        document.getElementById('shipping_total').innerHTML = '';
                        document.getElementById('shipping_total').innerHTML = result.shipping_price;
                        document.getElementById('totalPrice').innerHTML = '';
                        document.getElementById('totalPrice').innerHTML = result.total_price;
                        document.getElementById('totalPrice_pc').innerHTML = '';
                        document.getElementById('totalPrice_pc').innerHTML = result.total_price;
                    }
                    else
                    {
                        document.getElementById('shipping_price_list_2').style.display = 'block';
                    }

                    if(in_array(datas.country, sofort))
                    {
                        document.getElementById('sofort_banking').style.display = 'block';
                    }
                    else
                    {
                        document.getElementById('sofort_banking').style.display = 'none';
                    }
                    if(in_array(datas.country, ideal))
                    {
                        document.getElementById('ideal').style.display = 'block';
                    }
                    else
                    {
                        document.getElementById('ideal').style.display = 'none';
                    }

                    var new_address_li = '<li id="address_li_'+result.address_id+'">'+
                                            '<div class="clearfix">'+
                                                '<input type="radio" value="'+result.address_id+'" name="address_id" id="radio'+result.count_address+'" class="radio" onclick="select_address('+result.address_id+');" checked="checked">'+
                                                '<label for="radio'+result.count_address+'">'+
                                                '<b>Dirección'+result.count_address+'</b></label>'+
                                                    '<div class="flr">'+
                                                        '<span class="b address-detault" id="detault_'+result.address_id+'" style="display:none;">Predeterminada</span>'+
                                                            '<a href="javascript:;" class="a-underline address-detault-a" id="address_detault_'+result.address_id+'" onclick="default_address('+result.address_id+');">Configurar como predeterminada</a>'+
                                                            '<a class="view_btn  btn btn-primary btn-sm btn40" data-reveal-id="myModal10-1" onclick="edit_address('+result.address_id+', 1);">Modificar</a>'+
                                                            '<a href="javascript:;" class="view_btn btn26 delete_address btn btn-default btn-sm"  data-reveal-id="myModal6" onclick="delete_address('+result.address_id+');">Eliminar</a>'+
                                                    '</div>'+
                                                    '<p class="bottom" id="address_list_'+result.address_id+'">'+
                                                        '<span>'+datas.firstname+' '+datas.firstname+'</span>'+
                                                        '<span class="tel">'+datas.phone+'</span>'+
                                                        '<span>'+datas.address+', '+datas.city+' '+datas.state+', '+datas.country+' '+datas.zip+'</span>'+
                                                    '</p>'+
                                                '</label>'+
                                            '</div>'+
                                        '</li>';
                    $("#shipping_address_ul").append(new_address_li);
                    $("#shipping_address_ul .radio").removeAttr("checked");
                    $("#address_li_" + result.address_id + " .radio").attr("checked","checked");

                    //common alert
                    $("#myModal10-1").css("visibility","hidden");
                    $(".reveal-modal-bg").fadeOut();
                    $.ajax({
                        type:"POST",
                        url :"/cart/ajax_shipping_price",
                        data:"shipping_price="+datas.shipping_price,
                        dataType:"json",
                        success:function(res){
                            var ship_name = $("#sprice_title" + res.val).text();
                          if(res.val == 15){
                             document.getElementById('sprice_radios1').checked=false;
                              document.getElementById('sprice_radios2').checked=true;
                            }

                            document.getElementById('shipping_total').innerHTML = '';
                            document.getElementById('shipping_total').innerHTML = res.price;
                            document.getElementById('shipping_total_pc').innerHTML = '';
                            document.getElementById('shipping_total_pc').innerHTML = res.price;
                            document.getElementById('totalPrice').innerHTML = '';
                            document.getElementById('totalPrice').innerHTML = res.total;
                            document.getElementById('totalPrice_pc').innerHTML = '';
                            document.getElementById('totalPrice_pc').innerHTML = res.total;
                            document.getElementById('shippingAddressFill').style.display = 'none';
                            document.getElementById('shippingAddressInfo').style.display = 'block';
                            document.getElementById('paymentInfo').style.display = 'block';
                            $('html, body').animate({scrollTop: $('body').offset().top}, 10);
                        }
                    });
                }
                else
                {
                    alert(result.message);
                }
            }
        });
    }
    else
    {
        $.ajax({
            type:"post",
            url : '/address/ajax_edit1',
            data: datas,
            dataType: "json",
            success: function(result){
                if(result.success == 1){
                  //  alert(result.message);
                    //common alert
                    $(".reveal-modal-bg").fadeOut();
                    $("#myModal10-1").css("visibility","hidden");          
                    $(".opacity").hide();
                    $(".JS-popwincon1").hide();

document.getElementById('shippingAddressAdd').style.display = 'none';
document.getElementById('successaddress').style.display = 'block';  
document.getElementById('m-shippingAddressInfo').style.display = 'block';  
document.getElementById('shippingAddressInfo').style.display = 'block'; 
document.getElementById('type3disabled').style.display = 'none'; 

    document.getElementById('shippingAddressFill').style.display = 'none';
    document.getElementById('shippingnew').style.display = 'none';
    document.getElementById('shippingdiv').style.display = 'block';
    var aoep = $("#shippingsuccessdiv").css("display");
    if(aoep == 'block'){
        document.getElementById('shippingdiv').style.display = 'none';
    }
                    if(datas.address_id)
                    {
                        var str = '';
                        str +=  "<strong>"+newdata.firstname+' '+newdata.lastname+"</strong>";
                        str += "&nbsp;&nbsp;&nbsp;&nbsp;"+newdata.address+', '+newdata.city+' '+newdata.state+', '+newdata.country+' '+newdata.zip;
                        str +=  "&nbsp;&nbsp;&nbsp;&nbsp;"+newdata.address+newdata.phone;
                        str += "<div><button type=\"button\" class=\"btn btn-edit btn-xs flr\" onclick=\"return edit_address2();\">";
                        str += '<a href=\"javascript:;\"   onclick=\"return edit_address2();\">Modificar</a>';
                        str += "</button></div>";
//修改
                        $("#shippingAddressInfo").html(str);
                        $("#m-shippingAddressInfo").html(str);
                        getnewaddress()
                        getnewaddress1();
                    }
                    else
                    {
    document.getElementById('shippingAddressAdd').style.display = 'none';
                        var str = '';
                        str +=  "<strong>"+newdata.firstname+' '+newdata.lastname+"</strong>";
                        str += "&nbsp;&nbsp;&nbsp;&nbsp;"+newdata.address+', '+newdata.city+' '+newdata.state+', '+newdata.country+' '+newdata.zip;
                        str +=  "&nbsp;&nbsp;&nbsp;&nbsp;"+newdata.address+newdata.phone;
                        str += "<div><button type=\"button\" class=\"btn btn-edit btn-xs flr\" onclick=\"return edit_address2();\">";
                        str += '<a href=\"javascript:;\"  onclick=\"return edit_address2();\">Modificar</a>';
                        str += "</button></div>";
//修改
                        $("#shippingAddressInfo").html(str);
                        $("#m-shippingAddressInfo").html(str);
                          getnewaddress();
                          getnewaddress1();
                    }
                          
                            //common alert
                    $(".reveal-modal-bg").fadeOut();
                    $("#myModal10-1").css("visibility","hidden");          
                    $(".opacity").hide();
                    $(".JS-popwincon1").hide();

                    if(result.val ==15){
                      document.getElementById('sprice_radios2').checked=true;
                      document.getElementById('sprice_radios1').checked=false;
                    }else{
                       document.getElementById('sprice_radios1').checked=true; 
                    }

                    document.getElementById('paymentInfo').style.display = 'block';
                    $('html, body').animate({scrollTop: $('body').offset().top}, 10);

                    if(in_array(datas.country, sofort))
                    {
                        document.getElementById('sofort_banking').style.display = 'block';
                    }
                    else
                    {
                        document.getElementById('sofort_banking').style.display = 'none';
                    }
                    if(in_array(datas.country, ideal))
                    {
                        document.getElementById('ideal').style.display = 'block';
                    }
                    else
                    {
                        document.getElementById('ideal').style.display = 'none';
                    }

                    change_paypal_refund(datas.country);

                    if(result.has_no_express)
                    {
                      
                        document.getElementById('shipping_price_list_2').style.display = 'none';
                        document.getElementById('shipping_price_list_1').style.display = 'block';
                        document.getElementById('shipping_total').innerHTML = '';
                        document.getElementById('shipping_total').innerHTML = result.shipping_price;
                        document.getElementById('shipping_total_pc').innerHTML = '';
                        document.getElementById('shipping_total_pc').innerHTML = result.shipping_price;
                        document.getElementById('totalPrice').innerHTML = '';
                        document.getElementById('totalPrice').innerHTML = result.total_price;
                        document.getElementById('totalPrice_pc').innerHTML = '';
                        document.getElementById('totalPrice_pc').innerHTML = result.total_price;
                    }
                    else
                    {
                        document.getElementById('shipping_price_list_2').style.display = 'block';
                    }

                    $.ajax({
                        type:"POST",
                        url :"/cart/ajax_shipping_price",
                        data:"shipping_price="+datas.shipping_price,
                        dataType:"json",
                        success:function(res){
                            var ship_name = $("#sprice_title" + res.val).text();
                          if(res.val == 15){
                             document.getElementById('sprice_radios1').checked=false;
                              document.getElementById('sprice_radios2').checked=true;
                            }
                             $("#totalsum1").html(res.total);
                            $("#totalsum").html(res.total);
                            document.getElementById('shipping_total').innerHTML = '';
                            document.getElementById('shipping_total').innerHTML = res.price;
                            document.getElementById('shipping_total_pc').innerHTML = '';
                            document.getElementById('shipping_total_pc').innerHTML = res.price;
                            document.getElementById('totalPrice').innerHTML = '';
                            document.getElementById('totalPrice').innerHTML = res.total;
                            document.getElementById('totalPrice_pc').innerHTML = '';
                            document.getElementById('totalPrice_pc').innerHTML = res.total;
                            document.getElementById('shippingAddressFill').style.display = 'none';
                            document.getElementById('shippingAddressInfo').style.display = 'block';
                            document.getElementById('paymentInfo').style.display = 'block';
                            $('html, body').animate({scrollTop: $('body').offset().top}, 10);
                        }
                    });

                  return false;   

                }
                else
                {
                    alert(result.message);
                }
            }
        });
    }
    
    return false;
}

var sofort = new Array('DE', 'AT', 'CH', 'BE', 'FR', 'IT', 'GB', 'ES', 'NL', 'PL');
var ideal = new Array('NL');
//修改
function select_address(id)
{
    if (window.innerWidth)
        winWidth = window.innerWidth;
    else if ((document.body) && (document.body.clientWidth))
        winWidth = document.body.clientWidth;
    if(winWidth<=768)
        var  m=winWidth;
    else
        var m=winWidth;
    datas = new Object();
    datas.address_id = id;
    datas.width = m;
    $.ajax({
        type:"post",
        url : '/cart/ajax_shipping',
        data: datas,
        dataType: "json",
        success: function(res){
        var aoep = $("#shippingsuccessdiv").css("display");
        if(aoep == 'block'){
            document.getElementById('shippingdiv').style.display = 'none';
        }
            var change = '';
            if(res.count_address > 1)
                change = '<a href="javascript:;" class="red" onclick="change_address_show();">Modificar</a>';
/*            var shipping_address_list = '<dt>Shipping Address  <a class="red" data-reveal-id="myModal10-1" onclick="return edit_address('+res.shipping_address_id+');">Edit</a>'+change+'</dt>'+
                    '<dd class="fix"><label>Name:</label><span>'+res.shipping_firstname+' '+res.shipping_lastname+'</span></dd>'+
                    '<dd class="fix"><label>Tel:</label><span>'+res.shipping_phone+'</span></dd>'+
                    '<dd class="fix"><label>Address:</label><span>'+res.shipping_address+', '+res.shipping_city+' '+res.shipping_state+', '+res.shipping_country+' '+res.shipping_zip+'</span></dd>';*/

            var str = '';
            str +=  "<strong>"+res.shipping_firstname+' '+res.shipping_lastname+"</strong>";
            str += "&nbsp;&nbsp;&nbsp;&nbsp;"+res.shipping_address+', '+res.shipping_city+' '+res.shipping_state+', '+res.shipping_country+' '+res.shipping_zip;
            str +=  "&nbsp;&nbsp;&nbsp;&nbsp;"+res.shipping_address+res.shipping_phone;
            str += "<div><button type=\"button\" class=\"btn btn-edit btn-xs flr\" onclick=\"return edit_address2();\">";
            str += '<a href=\"javascript:;\"   onclick=\"return edit_address2();\">Modificar</a>';
            str += "</button></div>";
            //修改
            if(res.width<=768){
                            var str = '';
                            str +=  "<p><strong>"+res.shipping_firstname+' '+res.shipping_lastname+"</strong></p>";
                            str += "<p>"+res.shipping_address+', '+res.shipping_city+' '+res.shipping_state+', '+res.shipping_country+' '+"</p>";
                            str +=  "<p>"+res.shipping_zip+res.shipping_address+"</p>";
                            str +=  "<p>"+res.shipping_zip+"</p>";
                            str += "<div><button type=\"button\" class=\"btn btn-edit btn-xs flr\" onclick=\"return edit_address2();\">";
                            str += '<a href=\"javascript:;\"   onclick=\"return edit_address2();\">Modificar</a>';
                            str += "</button></div>";
                            
                            $("#m-shippingAddressInfo").html(str);
                            getnewaddress1();
                        }else{
                            $("#shippingAddressInfo").html(str);
                            getnewaddress();
                        }
                        $("#m-shippingAddressInfo").html(str);
                            getnewaddress1();

/*            document.getElementById('shipping_address_list').innerHTML = '';
            document.getElementById('shipping_address_list').innerHTML = shipping_address_list;*/
            change_paypal_refund(res.shipping_country);

          //  document.getElementById('shippingAddressAdd').style.display = 'none';

            if(res.has_no_express)
            {
                var ship_name = $("#sprice_title" + res.shipping_val).text();
                document.getElementById('shipping_price_list_2').style.display = 'none';
                document.getElementById('shipping_total').innerHTML = '';
                document.getElementById('shipping_total').innerHTML = res.shipping_price;
            document.getElementById('shipping_total_pc').innerHTML = '';
            document.getElementById('shipping_total_pc').innerHTML = res.shipping_price;
                document.getElementById('totalPrice').innerHTML = '';
                document.getElementById('totalPrice').innerHTML = res.total_price;
                document.getElementById('totalPrice_pc').innerHTML = '';
                document.getElementById('totalPrice_pc').innerHTML = res.total_price;
            }
            else
            {
                document.getElementById('shipping_price_list_2').style.display = 'block';
            }

            $(".opacity").hide();
            $(".JS-popwincon1").hide();
          //  document.getElementById('shippingAddressAdd').style.display = 'none';
            document.getElementById('shippingAddressInfo').style.display = 'block';
          if(in_array(res.shipping_country, sofort))
            {
                document.getElementById('sofort_banking').style.display = 'block';
            }
            else
            {
                document.getElementById('sofort_banking').style.display = 'none';
            }
            if(in_array(res.shipping_country, ideal))
            {
                document.getElementById('ideal').style.display = 'block';
            }
            else
            {
                document.getElementById('ideal').style.display = 'none';
            }
            $('html, body').animate({scrollTop: $('body').offset().top}, 10);
        }
    });
}

function check_shipping_address(datas)
{
    if(!trim(datas.shipping_firstname) || !datas.trim(shipping_lastname) || !trim(datas.shipping_address) || !trim(datas.shipping_country) || !trim(datas.shipping_state) || !trim(datas.shipping_city) || !trim(datas.shipping_zip) || !trim(datas.shipping_phone))
        return 0;
    else
        return 1;
}

function ace2(){
    var select = document.getElementById("shipping_country");
    var countryCode = select.options[select.selectedIndex].value;
        if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
        {   
            $("#guo111").show();
            $("#guo111").html('請輸入中文地址(Por favor, introduzca la direccion en chino.)');
        }else{
            $("#guo111").hide();
        }   
}

function acecoun(){
    var s = $("#shipping_state").val(); 
    var scon = $("#s_state").val(); 
    var re = /.*\d+.*/;
    if(!re.test(s)){ 
            $("#guo_don").hide();
        }else{
            
            $("#guo_don").show();
            $("#guo_don").html('¿Estado / provincia con dígitos? Por favor compruebe la exactitud.');
        }   
        
    if(!re.test(scon)){  
            $("#guo_don1").hide();
        }else{
            $("#guo_don1").show();
            $("#guo_don1").html('¿Estado / provincia con dígitos? Por favor compruebe la exactitud.');
            
        }   
}

function acedoun(){
    var s = $("#shipping_city").val();
    var s2 = $("#s_city").val(); 
    var re = /.*\d+.*/;
    if(re.test(s)){ 
            $("#guo_eon").show();
            $("#guo_eon").html('¿Ciudad con dígitos? Por favor compruebe la exactitud.');
        }else{
            $("#guo_eon").hide();
        }   
        
    if(re.test(s2)){    
            $("#guo_eon1").show();
            $("#guo_eon1").html('¿Ciudad con dígitos? Por favor compruebe la exactitud.');
        }else{
            $("#guo_eon1").hide();
        }   
}

//点击打开shipping说明
$("#showshipping").toggle(function(){
    $("#hideshipping").css("display","block");
},function(){
    $("#hideshipping").css("display","none");
}
);

function ace(){
    var str1 = $("#shipping_zip").val(); 
    s = str1.replace(/[\ |\~|\`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\+|\=|\||\\|\[|\]|\{|\}|\;|\:|\"|\'|\,|\，|\。|\<|\.|\>|\/|\?]/g,""); 
    $("#shipping_zip").val(s);
    var str3 = $("#s_zip").val(); 
    s3 = str3.replace(/[\ |\~|\`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\+|\=|\||\\|\[|\]|\{|\}|\;|\:|\"|\'|\,|\，|\。|\<|\.|\>|\/|\?]/g,""); 
    $("#s_zip").val(s3);
    var re = /^[a-zA-Z]{3,10}$/;
    var reg = new RegExp("[\\u4E00-\\u9FFF]+","g");
    
        if(re.test(s) || reg.test(s)){
        $("#guo_fon520").show();
        $("#guo_fon520").html("Parece que no hay dígitos en su código, por favor compruebe la exactitud.");
    }else{
        $("#guo_fon520").hide();
    }
    
        if(re.test(s3) || reg.test(s3)){        
        $("#guo_fon1").show();
        $("#guo_fon1").html("Parece que no hay dígitos en su código, por favor compruebe la exactitud.");
    }else{
        $("#guo_fon1").hide();
    }
}

function check_address(datas)
{
        var s = datas.zip;
        var re = /^[a-zA-Z]{3,10}$/;
        var c = datas.state;
        var ct = datas.city;
        var ret = /.*\d+.*/;
        var reg = new RegExp("[\\u4E00-\\u9FFF]+","g");
    // if(re.test(s)){
        // $("#guo222").show();
        // $("#guo222").html("It seems that there are no digits in your code, please check the accuracy.");
    // }else{
        // $("#guo222").hide();
    // }
    if(!trim(datas.firstname) || !trim(datas.lastname) || !trim(datas.address) || !trim(datas.country) || !trim(datas.state) || !trim(datas.city) || !trim(datas.zip) || !trim(datas.phone) || datas.address.length>100 || datas.address.length<3 || (re.test(s)) || (ret.test(c)) || (ret.test(ct)) || datas.phone.length>20 || datas.phone.length<6 || s.length>10 || s.length<3 || reg.test(s)) 
    {
        if((ret.test(c)))
            alert($("#guo_don").text());
        else if((ret.test(ct)))
            alert($("#guo_eon").text());
        else if((re.test(s)))
            alert($("#guo_fon520").text());    
        document.getElementById('successaddress').style.display = 'none';
        document.getElementById('shippingdiv').style.display = 'none'; 
        return 0;
    }
    else
        return 1;
}

function delete_address(id)
{
    /*$('body').append('<div id="wingray1" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');*/
    $('#cart_delete').appendTo('body').fadeIn(320);
    document.getElementById('address_id').value = id;
    document.getElementById('cart_delete').style.display = 'block';
    return false;
}

function delete_close()
{
    document.getElementById('wingray1').remove();
    document.getElementById('cart_delete').style.display = 'none';
    return false;
}

function delete_address_submit()
{
    var id = document.getElementById('address_id').value;
    datas = new Object();
    datas.id = id;
    $.ajax({
        type:"post",
        url : '/address/ajax_delete1',
        data: datas,
        dataType: "json",
        success: function(data){
            if(data.success == 1){
                var address_li_id = 'address_li_' + id;
                document.getElementById(address_li_id).remove();
                    $(".reveal-modal-bg").fadeOut();
                    $("#myModal6").css("visibility","hidden"); 
                    getnewaddress()
                    getnewaddress1()
                //document.getElementById('wingray1').remove();
              //  document.getElementById('cart_delete').style.display = 'none';
               // $(".opacity").hide();
            }else{
                alert(data.message);
            }
        }
    });
    return false;
}

function choice_coupon(code)
{
    document.getElementById('coupon_code1').value = code;
    document.getElementById('coupon_code').value = code;
    document.getElementById('available_codes').style.display = 'none';
    //document.getElementById('available_codes1').style.display = 'none';
}

$("#onclickcoupon").click(function(){
    setCoupon();
});

function setCoupon()
{
    coupon = document.getElementById('coupon_code');
    coupon1 = document.getElementById('coupon_code1');
    if(coupon.value == ''){
        coupon = coupon1;
    }
    if(coupon.value == ''){
        return false;
    }
    datas = new Object();
    datas.coupon_code = coupon.value;
    
    $.ajax({
        type:"POST",
        url :"/cart/ajax_coupon?lan=<?php echo LANGUAGE;?>",
        data:datas,
        dataType:"json",
        success:function(datas){
            console.log(datas);
            if(datas.success == 1)
            {
                alert(datas.message);
                $("#totalPrice").html(datas.total);
                $("#coupon_save").html('-'+datas.save);
                $("#coupon_save_pc").html('-'+datas.save);
                $("#totalPrice_pc").html(datas.total);
                $("#totalsum1").html(datas.total);
                $("#totalsum").html(datas.total);
                return false;
                document.getElementById('cart_saving').innerHTML = '';
                document.getElementById('cart_saving').innerHTML = datas.saving;
                document.getElementById('cart_saving_pc').innerHTML = '';
                document.getElementById('cart_saving_pc').innerHTML = datas.saving;
                document.getElementById('save_total').innerHTML = '';
                document.getElementById('save_total').innerHTML = datas.save_total;
                document.getElementById('save_total_pc').innerHTML = '';
                document.getElementById('save_total_pc').innerHTML = datas.save_total;
                document.getElementById('coupon_points_save').style.display = 'block';
                document.getElementById('coupon_points_save_pc').style.display = 'block';
                document.getElementById('totalPrice').innerHTML = '';
                document.getElementById('totalPrice').innerHTML = datas.total;
                document.getElementById('totalPrice_pc').innerHTML = '';
                document.getElementById('totalPrice_pc').innerHTML = datas.total;
                coupon.value = '';
            }
            else
            {
                alert(datas.message);
            }
        }
    });
    return false;
}

function setPoints()
{
    elment = document.getElementById('points');
    elment1 = document.getElementById('points1');
    points = Number(elment.value);
    if(points <= 0 || !points){
        points = Number(elment1.value);
    }
    if(points <= 0 || !points)
        return false;
    datas = new Object();
    datas.points = points;
    $.ajax({
        type:"POST",
        url :"/cart/ajax_point",
        data:datas,
        dataType:"json",
        success:function(datas){
            if(datas.success == 1)
            {
                alert(datas.message);
                document.getElementById('cart_saving').innerHTML = '';
                document.getElementById('cart_saving').innerHTML = datas.saving;
                document.getElementById('cart_saving_pc').innerHTML = '';
                document.getElementById('cart_saving_pc').innerHTML = datas.saving;
                document.getElementById('save_total').innerHTML = '';
                document.getElementById('save_total').innerHTML = datas.save_total;
                document.getElementById('save_total_pc').innerHTML = '';
                document.getElementById('save_total_pc').innerHTML = datas.save_total;
                document.getElementById('coupon_points_save').style.display = 'block';
                document.getElementById('coupon_points_save_pc').style.display = 'block';
                document.getElementById('totalPrice').innerHTML = '';
                document.getElementById('totalPrice').innerHTML = datas.total;
                document.getElementById('totalPrice_pc').innerHTML = '';
                document.getElementById('totalPrice_pc').innerHTML = datas.total;
                elment.value = '';
            }
            else
            {
                alert(datas.message);
            }
        }
    });
    return false;
}

function change_paypal_refund(country)
{
    var paypal_refund_config = new Array();
    paypal_refund_config = <?php echo json_encode($paypal_refund_config); ?>;
    var change_img = paypal_refund_config[country];
    if(typeof(change_img) != "undefined")
    {
        $("#paypal_shipping_refund a").hide();
        $("#paypal_shipping_refund ." + change_img).show();
    }
    else
    {
        $("#paypal_shipping_refund a").hide();
    }
}

function setMessage()
{
    message_change = document.getElementById('message_change').value;
    if(!message_change)
        return false;
    elment = document.getElementById('set_message');
    datas = new Object();
    datas.message = elment.value;
    datas.message_change = document.getElementById('message_change').value;
    datas.return_url = 'ajax';
    $.ajax({
        type:"post",
        url : '/cart/set_message',
        data: datas,
        dataType: "json",
        success: function(data){
            if(data.success == 1){
                // alert(data.message);
                document.getElementById('message_submit').style.display = 'none';
                document.getElementById('message_edit').style.display = 'block';
                elment.style.display = 'none';
                document.getElementById('now_message').innerHTML = datas.message;
                document.getElementById('now_message').style.display = 'block';
            }
        }
    });
    return false;
}

function editMessage()
{
    document.getElementById('set_message').style.display = 'block';
    document.getElementById('now_message').style.display = 'none';
    document.getElementById('message_submit').style.display = 'block';
    document.getElementById('message_edit').style.display = 'none';
}

function messageChange()
{
    return window.setTimeout(function(){
        var message = document.getElementById('set_message').value;
        message = message.replace(/(^\s*)|(\s*$)/g, "");
        document.getElementById('message_change').value = message;
    }, 0);
}

function createData(formObj){
    var datas = new Object();
    formElement = $(formObj).find("input,select,textarea");
    formElement.each(function(i,n){
        datas[$(n).attr("name")] = $(n).val();
    });
    return datas;
}

function radio_change(radio_oj,aValue){//传入一个对象
   for(var i=0;i<radio_oj.length;i++) {//循环
        if(radio_oj[i].value==aValue){  //比较值
            radio_oj[i].checked=true; //修改选中状态
            break; //停止循环
        }
   }
}

function in_array(search,array){
    for(var i in array){
        if(array[i]==search){
            return true;
        }
    }
    return false;
}

function trim(str){
    return str.replace(/(^\s*)|(\s*$)/g, "");
}

$(document).ready(function(){
    $("div.pc-apply").click(function(){
        $(this).siblings().toggle();
    });    

//insurance 
    $("#insurance_pc").click(function(){
        if(this.checked == true){
                $(this).attr("checked", true);  
                $("#click1").show();
          document.getElementById('insurance_pc').value = 1;
        }else{
          document.getElementById('insurance_pc').value = 2;
                $(this).attr("checked", false);  
            $("#click1").hide();
        }
var a = this;
var parent = a.parentNode; 
while(parent .tagName == "form")
{
    parent = parent .parentNode;
}
        setShipping(parent);
    })

    $("#insurance").click(function(){
        if(this.checked == true){
          document.getElementById('insurance').value = 1;
        }else{
          document.getElementById('insurance').value = 2;
        }
var a = this;
var parent = a.parentNode; 
while(parent .tagName == "form")
{
    parent = parent .parentNode;
}
        setShipping(parent);
    })


    //shipping price
    $(".s_price_list").click(function(){

            var a = this;
var parent = a.parentNode; 
while(parent .tagName == "form")
{
    parent = parent .parentNode;
}
      //  var form = document.getElementById('editshipingform');
        setShipping(parent);
        var price = $(this).attr('value');
        var code = "<?php $currency = Site::instance()->currency(); echo $currency['code']; ?>";
        var rate = <?php echo $currency['rate']; ?>;
        var amount = <?php echo $cart['amount']['total'] - $cart['amount']['shipping']; ?>;
        var shipping_price = tofloat(price * rate, 2);
        shipping_price += " ";
        var shipping_total = code + shipping_price;
        var insurance = tofloat(<?php echo $cart['amount']['insurance']; ?>  * rate, 2);
        var amount_total =  tofloat((amount  + parseInt(price)) * rate, 2);
        var amount_total = parseFloat(insurance) + parseFloat(amount_total);
        var amount_total = code + tofloat(amount_total,2);
        $("#shipping_total").html(shipping_total);
        $("#shipping_total_pc").html(shipping_total);
        $("#shipping_amount").val(price);
        $("#shipping_amount_pc").val(price);
/*        $("#totalPrice").html(amount_total);
        $("#totalPrice_pc").html(amount_total);*/
        $("#amount_left").html(tofloat((amount + parseInt(price)), 2));
        $("#amount_left_pc").html(tofloat((amount + parseInt(price)), 2));
    })


    $(".states2 .all2 .s_state").change(function(){
        var val = $(this).val();
        if(val == ' ')
        {
            $(".states2 .all2").hide();
            $(".states2 .text").show();
            $(".states2 .text").val("");
        }
    })
})
</script>
<script type="text/javascript">
    /* form1 */
    $(".form1").validate({
        rules: {
            firstname: {    
                required: true,
                maxlength:50
            },
            lastname: {    
                required: true,
                maxlength:50
            },
            address: {
                required: true,
                rangelength:[3,200]
            },
            zip: {
                required: true,
                rangelength:[3,10]
            },
            city: {
                required: true,
                maxlength:50
            },
            country: {
                required: true,
                maxlength:50
            },
            state: {
                required: true,
                maxlength:50
            },
            phone: {
                required: true,
                rangelength:[6,20]
            }
        },
        messages: {
            firstname: {
                required: "Por favor introduce tu nombre.",
                maxlength:"El primer nombre que excede la longitud maxima de 50 caracteres."
            },
            lastname: {
                required: "Por favor introduce tu apellido.",
                maxlength:"El primer nombre que excede la longitud maxima de 50 caracteres."
            },
            address: {
                required: "Por favor introduce tu dirección.",
                rangelength: $.validator.format("Por favor, introduzca 3 - 100 caracteres.")
            },
            zip: {
                required: "Por favor introduce tu código postal.",
                rangelength: $.validator.format("Por favor, introduzca 3 - 10 caracteres.")
            },
            city: {
                required: "Por favor introduce tu ciudad.",
                maxlength:"La ciudad excede la longitud maxima de 50 caracteres."
            },
            country: {
                required: "Por favor, elige tu país.",
                maxlength:"El país excede la longitud maxima de 50 caracteres."
            },
            state: {
                required: "Por favor introduce tu Provincia / Estado.",
                maxlength:"El país excede la longitud maxima de 50 caracteres."
            },
            phone: {
                required: "Por favor introduce tu teléfono.",
                rangelength: $.validator.format("Por favor introduce un teléfono dentro de 6 a 20 digitos.")
            }
        }
    });

    /* form2 */
    $(".form2").validate({
        rules: {
            firstname: {    
                required: true,
                maxlength:50
            },
            lastname: {    
                required: true,
                maxlength:50
            },
            address: {
                required: true,
                rangelength:[3,200]
            },
            zip: {
                required: true,
                rangelength:[3,10]
            },
            city: {
                required: true,
                maxlength:50
            },
            country: {
                required: true,
                maxlength:50
            },
            state: {
                required: true,
                maxlength:50
            },
            phone: {
                required: true,
                rangelength:[6,20]
            }
        },
        messages: {
            firstname: {
                required: "Por favor introduce tu nombre.",
                maxlength:"El primer nombre que excede la longitud maxima de 50 caracteres."
            },
            lastname: {
                required: "Por favor introduce tu apellido.",
                maxlength:"El primer nombre que excede la longitud maxima de 50 caracteres."
            },
            address: {
                required: "Por favor introduce tu dirección.",
                rangelength: $.validator.format("Por favor, introduzca 3 - 100 caracteres.")
            },
            zip: {
                required: "Por favor introduce tu código postal.",
                rangelength: $.validator.format("Por favor, introduzca 3 - 10 caracteres.")
            },
            city: {
                required: "Por favor introduce tu ciudad.",
                maxlength:"La ciudad excede la longitud maxima de 50 caracteres."
            },
            country: {
                required: "Por favor, elige tu país.",
                maxlength:"El país excede la longitud maxima de 50 caracteres."
            },
            state: {
                required: "Por favor introduce tu Provincia / Estado.",
                maxlength:"El país excede la longitud maxima de 50 caracteres."
            },
            phone: {
                required: "Por favor introduce tu teléfono.",
                rangelength: $.validator.format("Por favor introduce un teléfono dentro de 6 a 20 digitos.")
            }
        }
    });

    function tofloat(f,dec)       
    {          
        if(dec <0) return "Error:dec <0! ";          
        result=parseInt(f)+(dec==0? " ": ".");          
        f-=parseInt(f);          
        if(f==0)
        {
            for(i=0;i <dec;i++) result+= '0';          
        }
        else       
        {          
            for(i=0;i <dec;i++)
            {
                f*=10;
                if(parseInt(f) == 0)
                {
                    result+= '0';
                }
            }          
            result+=parseInt(Math.round(f));
        } 
        return result;          
    }

 
/*    $(".radio-option-list li").eq(1).click(function(){
        $(".pay-paypal").hide();
        $(".pay-credit").show();
    })
    $(".radio-option-list li").eq(1).siblings().click(function(){
        $(".pay-paypal").show();
        $(".pay-credit").hide();
    }) 

    $(".radio-option-list li").siblings().click(function(){
        $(".pay-paypal").hide();

    })   */


   $("input[type='radio']").click(function(){

    var id= $(this).attr("id");
    if(id=='sprice_radios1'){
        $("#kai").html('Envío Estándar  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10-15 días laborables&nbsp;&nbsp;&nbsp;&nbsp;$0.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
    }else if(id=='sprice_radios2'){
        $("#kai").html('Envío Exprés  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4-7 días laborables&nbsp;&nbsp;&nbsp;&nbsp;$15.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
    }
   });
       
       
       
       

 
</script>

<script type="text/javascript">
        var no_express_countries = new Array();
        no_express_countries = <?php echo json_encode($no_express_countries); ?>;
        function changeSelectCountry1(){
            var select = document.getElementById("s_country");
            var countryCode = select.options[select.selectedIndex].value;
            if(in_array(countryCode, no_express_countries))
            {
                document.getElementById("shipping_price_list_2").style.display = 'none';
                document.getElementById("sprice_radios1").checked = true;
                document.getElementById("new_shipping_price").value=0;
            }
            else
            {
                document.getElementById("shipping_price_list_2").style.display = 'block';
            }
            if(countryCode == 'BR')
            {
                $("#shipping_cpf").show();
            }
            else if(countryCode == 'HK' || countryCode == 'MO' || countryCode == 'TW')
            {   

/*                var aa = $("#guo_con1");
                    aa.show();
                aa.html('請輸入中文地址(Por favor, introduzca la direccion en chino.)');*/
            }
            else
            {
                $("#shipping_cpf").hide();
                $("#guo_con1").hide();
            }
            var c_name = 'call1_' + countryCode;
            $(".states1 .call1").hide();
            if(document.getElementById(c_name))
            {
                $(".states1 #"+c_name).show();
            }
            else
            {
                $(".states1 #call1_Default").show();
            }

            var s_name = 'all1_' + countryCode;
            $(".states1 .all1").hide();
            $("#all1_default").hide();

            $(".states1 #all1_default input").hide();
            if(document.getElementById(s_name))
            {
                $(".states1 #"+s_name).show();
            }
            else
            {
                $("#all1_default").show();
                $("#all1_default input").show();
            }
            $("#all2_default input").val('');
        }
        $(function(){
            $(".states1 .all1 select").change(function(){
                var val = $(this).val();
                $("#all1_default input").val(val);
            })
        })
    </script>

<script type="text/javascript">  
    $(function(){  
        var bool=false;  
        var offsetX=0;  
        var offsetY=0;  
        $("#popup_title").mousedown(function(){  
                bool=true;  
                offsetX = event.offsetX;  
                offsetY = event.offsetY;
                $(this).css('cursor','move');  
                })  
                .mouseup(function(){  
                bool=false;  
                })  
                $(document).mousemove(function(e){  
                if(!bool)  
                return;  
                var x = event.clientX-offsetX;  
                var y = event.clientY-offsetY;  
                $("#popup_container").css("left", x);  
                $("#popup_container").css("top", y);  
        })  
    })
</script> 

<script type="text/javascript">
$(function(){
    $(".payment_icon").mouseover(function(){
       $(".payment_icon_box").fadeIn(200);
    });
    $(".payment_icon").mouseout(function(){
       $(".payment_icon_box").hide();
    });
    
    $(".payment_icon_en").mouseover(function(){
           $(".payment_icon_box_en").fadeIn(200);
        });
        $(".payment_icon_en").mouseout(function(){
           $(".payment_icon_box_en").hide();
        });
            
    $("#cardNo").keydown(function(){
        showcardnum(event.keyCode); 
    });
    $("#cardNo").keyup(function(){
        this.value=this.value.replace(/\D/g,'');
        clean(event.keyCode);
    });
    $("#cardNo").blur(function(){
        if(window.XMLHttpRequest)document.getElementById('card_num_box').style.display = "none";
        $(".card_num_box").css({ display: "none" });
    });

});
var num='';
var lastnum='';

function change_card(index)
{
    var card_select = document.getElementById('card_select');
    card_select.selectedIndex = index;
    
        $popup_message = document.getElementById('card_error1');
        $popup_message.style.display = 'none';  
}

function select_ch(){
    var card_select = document.getElementById('card_select');
    if(card_select.value>0){
        $popup_message = document.getElementById('card_error1');
        $popup_message.style.display = 'none';  
    }else{
        $popup_message = document.getElementById('card_error1');
        $popup_message.style.display = 'block';     
    }
}

// check cardNo, cardExpireMonth, cardExpireYear, CVV2 Code
function checkFormData()
{
    var now_year = '<?php echo date('y'); ?>';
    var now_month = '<?php echo date('m'); ?>';
    var error = 0;
    var cardNo = document.getElementById('cardNo').value;
    var card_select = document.getElementById('card_select');
    
    if(card_select.value == 0){
        $popup_message = document.getElementById('card_error1');
        $popup_message.innerHTML = 'Por favor, elige tu tipo de tarjeta de crédito.';
        $popup_message.style.display = 'block';
        error = 1;
    }   
    
    if(cardNo.length == 0)
    {
        $popup_message = document.getElementById('card_error');
        $popup_message.innerHTML = 'Por favor ingrese el número de la tarjeta.';
        $popup_message.style.display = 'block';
        error = 1;
    }
    var check = luhnCheckSum(cardNo);
    if(!check)
    {
        $popup_message = document.getElementById('card_error');
        $popup_message.innerHTML = 'El numero de tarjeta de credito es incorrecta.';
        $popup_message.style.display = 'block';
        error = 1;
    }
    var month = document.getElementById("cardExpireMonth").value;
    if(month == 0)
    {
        $popup_message = document.getElementById('expire_error');
        $popup_message.innerHTML = 'Seleccione la fecha de caducidad.';
        $popup_message.style.display = 'block';
        error = 1;
    }
    var year = document.getElementById("cardExpireYear").value;
    if(year == 0)
    {
        $popup_message = document.getElementById('expire_error');
        $popup_message.innerHTML = 'Seleccione la fecha de caducidad.';
        $popup_message.style.display = 'block';
        error = 1;
    }
    if(year == now_year && month < now_month)
    { 
        $popup_message = document.getElementById('expire_error');
        $popup_message.innerHTML = 'Fecha de caducidad no es válida.';
        $popup_message.style.display = 'block';
        error = 1;
    }
    var cvv2 = document.getElementById("cvv2").value;
    reg = /^[0-9]\d*$|^0$/;
    if(cvv2.length != 3 || reg.test(cvv2) != true)
    {
        $popup_message = document.getElementById('cvv_error');
        $popup_message.innerHTML = 'Introduzca un codigo de 3 digitos CVV / CVC.';
        $popup_message.style.display = 'block';
        error = 1;
    }

    if(error == 1)
    {
        return false;
    }
    else
    {  
        $popup_message = document.getElementById('card_error');
        $popup_message.style.display = 'none';
        $popup_message = document.getElementById('expire_error');
        $popup_message.style.display = 'none';
        $popup_message = document.getElementById('cvv_error');
        $popup_message.style.display = 'none';
        document.getElementById('pageOverlay').style.visibility = 'initial';
        document.getElementById('payment_wrap2').style.display = 'block';
        var correct1 = 1;
        return correct1;
    }
        
}

function error_clean(error_id)
{
    $error_div = document.getElementById(error_id);
    $error_div.style.display = 'none';
}

function luhnCheckSum(Luhn)
{
    var ca, sum = 0, mul = 1;
    var len = Luhn.length;
    while (len--)
    {
        ca = parseInt(Luhn.charAt(len),10) * mul;
        sum += ca - (ca>9)*9;// sum += ca - (-(ca>9))|9
        // 1 <--> 2 toggle.
        mul ^= 3; // (mul = 3 - mul);
    };
    return (sum%10 === 0) && (sum > 0);
}

function showcardnum(keycode)
{
    if(window.XMLHttpRequest)document.getElementById('card_num_box').style.display = "block";
    if(parseInt($("#cardNo").val().length + 1) >= 17)
    {
        return false;
    }
    if(parseInt(keycode) >=96 && parseInt(keycode) <=105)
    {
        $(".card_num_box").css({ display: "block" });
        num+=lastnum;
        newnum=num.replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1-");
         $(".card_num_box").html(newnum);
    }
    else if(parseInt(keycode) >=48 && parseInt(keycode) <=57)
    {
        $(".card_num_box").css({ display: "block" });
        num+=lastnum;
        newnum=num.replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1-");
         $(".card_num_box").html(newnum);
    }
    else
    {
        return false;
    }
    
}

function clean(keycode)
{
    num=$("#cardNo").val();
    newnum=$("#cardNo").val().replace(/\s/g,'').replace(/(\d{4})(?=\d)/g,"$1-");
     $(".card_num_box").html(newnum);
     if($("#cardNo").val().length == '0')
     {
        $(".card_num_box").css({ display: "none" }); 
    }
}

//keep out
(function(){
    // get object
    var $ = function (id){
        return document.getElementById(id);
    };
    // traverse
    var each = function(a, b) {
        for (var i = 0, len = a.length; i < len; i++) b(a[i], i);
    };
    // event binding
    var bind = function (obj, type, fn) {
        if (obj.attachEvent) {
            obj['e' + type + fn] = fn;
            obj[type + fn] = function(){obj['e' + type + fn](window.event);}
            obj.attachEvent('on' + type, obj[type + fn]);
        } else {
            obj.addEventListener(type, fn, false);
        };
    };
    
    // remove event
    var unbind = function (obj, type, fn) {
        if (obj.detachEvent) {
            try {
                obj.detachEvent('on' + type, obj[type + fn]);
                obj[type + fn] = null;
            } catch(_) {};
        } else {
            obj.removeEventListener(type, fn, false);
        };
    };
    
    // prevent brower default action
    var stopDefault = function(e){
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
    };
    // get page scroll bar position
    var getPage = function(){
        var dd = document.documentElement,
            db = document.body;
        return {
            left: Math.max(dd.scrollLeft, db.scrollLeft),
            top: Math.max(dd.scrollTop, db.scrollTop)
        };
    };
    
    // lock screen
    var lock = {
        show: function(){
            $('pageOverlay').style.visibility = 'visible';
            var p = getPage(),
                left = p.left,
                top = p.top;
            
            // page mouse operation limit
            this.mouse = function(evt){
                var e = evt || window.event;
                stopDefault(e);
                scroll(left, top);
            };
            each(['DOMMouseScroll', 'mousewheel', 'scroll', 'contextmenu'], function(o, i) {
                    bind(document, o, lock.mouse);
            });
            // shield special key: F5, Ctrl + R, Ctrl + A, Tab, Up, Down
            this.key = function(evt){
                var e = evt || window.event,
                    key = e.keyCode;
                if((key == 116) || (e.ctrlKey && key == 82) || (e.ctrlKey && key == 65) || (key == 9) || (key == 38) || (key == 40)) {
                    try{
                        e.keyCode = 0;
                    }catch(_){};
                    stopDefault(e);
                };
            };
            bind(document, 'keydown', lock.key);
        },
        close: function(){
            $('pageOverlay').style.visibility = 'hidden';
            each(['DOMMouseScroll', 'mousewheel', 'scroll', 'contextmenu'], function(o, i) {
                unbind(document, o, lock.mouse);
            });
            unbind(document, 'keydown', lock.key);
        }
    };
    bind(window, 'load', function(){
        /*$(".jq_close01")onclick = function(){
           $(".jq_box01").hide();
           lock.close(); 
        };
        $('paybutton').onclick = function(){
            lock.show();
        };
        $('jq_close01').onclick = function(){
             lock.close(); 
        };
        $('jq_close02').onclick = function(){
             lock.close(); 
        };
        jq_close01*/
    });
})();

function lockpage() {
    
    // get object
    var $ = function (id){
        return document.getElementById(id);
    };
    // traverse
    var each = function(a, b) {
        for (var i = 0, len = a.length; i < len; i++) b(a[i], i);
    };
    // event binding
    var bind = function (obj, type, fn) {
        if (obj.attachEvent) {
            obj['e' + type + fn] = fn;
            obj[type + fn] = function(){obj['e' + type + fn](window.event);}
            obj.attachEvent('on' + type, obj[type + fn]);
        } else {
            obj.addEventListener(type, fn, false);
        };
    };
    
    // remove event
    var unbind = function (obj, type, fn) {
        if (obj.detachEvent) {
            try {
                obj.detachEvent('on' + type, obj[type + fn]);
                obj[type + fn] = null;
            } catch(_) {};
        } else {
            obj.removeEventListener(type, fn, false);
        };
    };
    
    // prevent brower default action
    var stopDefault = function(e){
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
    };
    // get page scroll bar position
    var getPage = function(){
        var dd = document.documentElement,
            db = document.body;
        return {
            left: Math.max(dd.scrollLeft, db.scrollLeft),
            top: Math.max(dd.scrollTop, db.scrollTop)
        };
    };
    
    // lock screen
    var lock = {
        show: function(){
            $('pageOverlay').style.visibility = 'visible';
            var p = getPage(),
                left = p.left,
                top = p.top;
            
            // page mouse operation limit
            this.mouse = function(evt){
                var e = evt || window.event;
                stopDefault(e);
                scroll(left, top);
            };
            each(['DOMMouseScroll', 'mousewheel', 'scroll', 'contextmenu'], function(o, i) {
                    bind(document, o, lock.mouse);
            });
            // shield special key: F5, Ctrl + R, Ctrl + A, Tab, Up, Down
            this.key = function(evt){
                var e = evt || window.event,
                    key = e.keyCode;
                if((key == 116) || (e.ctrlKey && key == 82) || (e.ctrlKey && key == 65) || (key == 9) || (key == 38) || (key == 40)) {
                    try{
                        e.keyCode = 0;
                    }catch(_){};
                    stopDefault(e);
                };
            };
            bind(document, 'keydown', lock.key);
        },
        close: function(){
            $('pageOverlay').style.visibility = 'hidden';
            each(['DOMMouseScroll', 'mousewheel', 'scroll', 'contextmenu'], function(o, i) {
                unbind(document, o, lock.mouse);
            });
            unbind(document, 'keydown', lock.key);
        }
    };
    lock.show();
}
</script>