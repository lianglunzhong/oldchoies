<script type="text/javascript" src="js/jcarousellite.js"></script>
<script type="text/javascript" src="js/jquery.soChange.js"></script>
<script language="javascript" type="text/javascript">
    function findObj(theObj, theDoc) {
        var p, i, foundObj;
        if (!theDoc) theDoc = document;
        if ((p = theObj.indexOf("?")) > 0 && parent.frames.length) {
            theDoc = parent.frames[theObj.substring(p + 1)].document; theObj = theObj.substring(0, p);
        }
        if (!(foundObj = theDoc[theObj]) && theDoc.all)
            foundObj = theDoc.all[theObj]; for (i = 0; !foundObj && i < theDoc.forms.length; i++) foundObj = theDoc.forms[i][theObj]; for (i = 0; !foundObj &&
            theDoc.layers && i < theDoc.layers.length; i++) foundObj = findObj(theObj, theDoc.layers[i].document);
        if (!foundObj && document.getElementById)
            foundObj = document.getElementById(theObj); return foundObj;
    }
    //添加一个行
    var index = 1;
    function AddNewRow() {
        var txtTRLastIndex = findObj("txtTRLastIndex", document);
        var rowID = parseInt(txtTRLastIndex.value);
        var tab = findObj("tab", document);
        var columnLength = tab.rows[0].cells.length;
			
        //添加行
        var newTR = tab.insertRow(tab.rows.length);
        newTR.id = "SignItem" + rowID;
        for (var i = 0; i < columnLength; i++) {
            if (i == 0) {//第一列:序号
                newTR.insertCell(0).innerHTML = ++index;
            } 
            else if (i > 0 && i < 2) {
                newTR.insertCell(i).innerHTML = "<label><span class='red mb10'>*</span> Tipo Sitio principal: </label><select id='type_"+i+"' name='sites[type][]'><option value='Look Book'>Look Book</option><option value='Personal Blog'>Personal Blog</option><option value='Facebook'>Facebook</option><option value='Youtube'>Youtube</option><option value='Chictopia'>Chictopia</option><option value='Pinterest'>Pinterest</option><option value='Instagram'>Instagram</option><option value='Tumblr'>Tumblr</option><option value='Twitter'>Twitter</option></select><br><label><span class='red'>*</span> URL del sitio principal: </label><input type='text' id='url_"+i+"' name='sites[url][]' class='sub_info_text' style='margin-right:3px;' /><label><span class='red'>*</span> Fans / Seguidores: </label><input type='text' id='flow_"+i+"' name='sites[flow][]' class='sub_info_text2 mb10' style='width:120px; margin-left:5px;' />";
            }
            else if (i >= 2) {
                newTR.insertCell(i).innerHTML = "<label><span class='red'>*</span> URL del sitio principal: </label><input type='text' id='url_"+i+"' name='sites[url][]' class='sub_info_text' /><label><span class='red ml10'>*</span> Fans/ Followers: </label><input type='text' id='flow_"+i+"' name='sites[flow][]' class='sub_info_text2' />";
            }
        }
        //添加列:删除按钮
        var lastTd = newTR.insertCell(columnLength);
        lastTd.innerHTML = "<div align='left' style='width:40px;'><a href='javascript:' onclick=\"DeleteSignRow('SignItem" + rowID + "')\">Borrar</a></div>";
        //将行号推进下一行
        txtTRLastIndex.value = (rowID + 1).toString();
    }
    //删除指定行
    function DeleteSignRow(rowid) {
        var tab = findObj("tab", document);
        var signItem = findObj(rowid, document);
        //获取将要删除的行的Index
        var rowIndex = signItem.rowIndex;
        //删除指定Index的行
        tab.deleteRow(rowIndex);
    }
    //删除指定列
    function DeleteSignColumn(columnId) {
        var tab = document.getElementById("tab");
        var columnLength = tab.rows[1].cells.length;
        //删除指定单元格 
        for (var i = 0; i < tab.rows.length; i++) {
            tab.rows[i].deleteCell(columnId);
        }
        --count;
    }
    //清空列表
    function ClearAllSign() {
        //if (confirm('确定要清空所有吗？')) {
        index = 0;
        var tab = findObj("tab", document);
        var rowscount = tab.rows.length;
        //循环删除行,从最后一行往前删除
        for (i = rowscount - 1; i > 1; i--) {
            tab.deleteRow(i);
        }
        //重置最后行号为1
        var txtTRLastIndex = findObj("txtTRLastIndex", document);
        txtTRLastIndex.value = "1";
        //预添加一行
        AddNewRow();
        //}
    }
</script>
<script type="text/javascript">
    $(function(){
        $("#inforSubmit").live("click", function(){
            var email = $("#email").val();
            var gender = $("#gender").val();
            var country = $("#country").val();
            if(email && gender && country)
            {
                $.post(
                '/blogger/check_email',
                {
                    email: email
                },
                function(data)
                {
                    if(data)
                    {
                        $('body').append('<div class="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                        $('#catalog_link').appendTo('body').fadeIn(320);
                        $('#catalog_link').show();
                        var message = '<h3>¡Lo siento!</h3><p>Correo electrónico se ha utilizado.</p>';
                        $('.fashion_thank').html(message);
                        $(".wingray").delay(3000).fadeOut();
                        $('#catalog_link').delay(3000).fadeOut();
                    }
                    else
                    {
                        $('body').append('<div class="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                        $('#catalog_link').appendTo('body').fadeIn(320);
                        $('#catalog_link').show();
                        var message = '<h3>¡Graias!</h3><p>Nos comunicaremos con usted dentro de una semana después de presentar el formulario de solicitud.</p>';
                        $('.fashion_thank').html(message);
                        setTimeout(function() {  
                            $("#submitInfo").submit();  
                        }, 3000);
                    }
                },
                'json'
            );
                return false;
            }
        })
                
        $("#submitInfo").live("submit", function(){
            $("#submitInfo").validate();
            $("#email").rules("add",{required: true,email: true});
            var valid = $("#submitInfo").valid();
            if (valid==true) {this.submit();}
        })
                
        $("#catalog_link .clsbtn,.wingray").live("click",function(){
            $(".wingray").remove();
            $('#catalog_link').hide();
            return false;
        })
    })
</script>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Página de Inicio</a>  >  Blogger De Moda</div>
        </div>
    </div>
    <section class="layout fix">
        <div class="tit blogger_wanted mb25">
            <span>Blogger De Moda</span><span>Leer La Política</span><span class="on">Presentar Información</span><span>Conseguir Una Bandera</span>
            <img src="/images/de/blogger_wanted3.png" />
        </div>
        <?php echo Message::get(); ?>
        <article style="margin-top:30px;background: #fff;">
            <div class="fashion_tit" style="margin-left:39px">PRESENTAR INFORMACIÓN</div>
            <div class="fll" style="padding-left:70px;">
                <div class="sub_info">
                    <form action="" method="post" id="submitInfo" class="form">
                        <ul>
                            <li>
                                <label style="margin-left:38px"><span class="red">*</span> Dirección de Email:</label>
                                <input type="text" id="email" name="email" class="sub_info_text" />
                                <span class="errorInfo"></span>
                            </li>
                            <li>
                                <label style="margin-left:38px"><span class="red">*</span> Sexo:</label>
                                <select name="gender" id="gender">
                                    <option value="">SELECCIONAR SEXO</option>
                                    <option value="0">Mujer</option>
                                    <option value="1">Hombre</option>
                                </select>
                                <span class="errorInfo"></span>
                            </li>
                            <li>
                                <label style="margin-left:38px"><span class="red">*</span> País:</label>
                                <select name="country" id="country">
                                    <option value="">SELECCIONAR PAÍS</option>
                                    <?php
                                    $countries = Site::instance()->countries(LANGUAGE);
                                    foreach ($countries as $country):
                                        ?>
                                        <option value="<?php echo $country['isocode']; ?>" <?php if($country['isocode'] == 'ES') echo 'selected'; ?>><?php echo $country['name']; ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                                <span class="errorInfo"></span>
                            </li>
                            <li>    
                                <div style="overflow: auto; width:100%; padding:0 10px; float:left">
                                    <table cellpadding="1" id="tab" cellspacing="0">
                                        <tr>
                                            <td style="width:24px;">1</td>
                                            <td>
                                                <label><span class="red mb10">*</span> Tipo Sitio principal: </label>
                                                <select maxlength="16" id="type" name="sites[type][]">
                                                    <option value="lookbook">Look Book</option>
                                                    <option value="personal Blog">Personal Blog</option>
                                                    <option value="facebook">Facebook</option>
                                                    <option value="youtube">Youtube</option>
                                                    <option value="chictopia">Chictopia</option>
                                                    <option value="pinterest">Pinterest</option>
                                                    <option value="instagram">Instagram</option>
                                                    <option value="tumblr">Tumblr</option>
                                                    <option value="twitter">Twitter</option>
                                                </select>

                                                <br/><label><span class='red'>*</span> URL del sitio principal: </label>
                                                <input type='text' id='url' name='sites[url][]' class='sub_info_text' />
                                                <label><span class='red'>*</span> Fans / Seguidores: </label>
                                                <input type='text' id='flow' name='sites[flow][]' class='sub_info_text2 mb10' /> 
                                            </td>
                                        </tr>
                                    </table>
                                    <table cellpadding="1" cellspacing="0" style="text-align: center; display:block;">
                                        <tr>
                                            <td>
                                                <input type="button" name="Submit" class="add_more" style=" margin-left:139px;" value="añadir uno más sitio" onclick="AddNewRow()" />
                                            </td>
                                            <td>
                                                <input name='txtTRLastIndex' type='hidden' id='txtTRLastIndex' value="1" />
                                                <input name='txtTDLastIndex' type='hidden' id='txtTDLastIndex' value="2" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </li>

                            <li>
                                <label  style="margin-left:39px"><span class="red">*</span> Mensaje:</label>
                                <textarea name="comment" id="input_comment" rows="10" class="input textarea sub_info_text3" onblur="this.value=(this.value=='')?'Escribe algo para presentarse y cuál es su idea de la moda. Gracias!':this.value" value="Escribe algo para presentarse y cuál es su idea de la moda. Gracias!" onfocus="this.value=(this.value=='Escribe algo para presentarse y cuál es su idea de la moda. Gracias!')?'':this.value">Escribe algo para presentarse y cuál es su idea de la moda. Gracias!</textarea>
                            </li>
                            <li>
                                <input type="submit" id="inforSubmit" class="form_btn view_btn btn30_14_red" style="height: 38px;" value="PRESENTAR"/>
                            </li>
                        </ul>
                        <script type="text/javascript">
                            $("#submitInfo").validate({
                                rules: {
                                    email: {
                                        required: true,
                                        email: true
                                    },
                                    gender: {
                                        required: true
                                    },
                                    country: {
                                        required: true
                                    }
                                },
                                messages: {
                                    email:{
                                        required:"Requerido Campo.",
                                        email:"Por favor, introduce una dirección de correo electrónico válida."
                                    },
                                    gender:{
                                        required:"Requerido Campo"
                                    },
                                    country:{
                                        required:"Requerido Campo"
                                    }
                                }
                            });
                        </script>
                    </form>
                </div>
            </div>
            </div>
        </article>
    </section>
</section>
<div class="hide" id="catalog_link" style="position: fixed;padding: 10px 10px 20px; top: 0px;left: 400px;width: 640px;height: 230px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:#CCC 1px solid;">
    <div class="order order_addtobag">
        <div class="fashion_thank"></div>
    </div>
    <div class="clsbtn" style="right: -0px;top: 3px;"></div>
</div>