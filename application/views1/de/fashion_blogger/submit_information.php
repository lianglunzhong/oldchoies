<!DOCTYPE html>
<html lang="zh-CN">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>blogger-wanted-step3</title>
	<link href="<?php echo LANGPATH; ?>/assets/css/style.css" rel="stylesheet" type="text/css">
	<script src="/assets/js/jquery-1.8.2.min.js"></script>		
</head>

<body>
<?php
$url1 = parse_url(Request::$referrer);
?>
<!-- header begin -->
<!-- main begin -->
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">Homepage</a> > Blogger Werden Wollen
			</div>
			<div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="<?php echo LANGPATH.$url1['path']; ?>">Zurück</a>
			</div>
		</div>
	</div>
	<!-- main begin -->
	<section class="container blogger-wanted">
		<div class="blogger-img hidden-xs">
			<div class="step-nav step-nav1">
                <ul class="clearfix">
                    <li>Fashion Programm<em></em><i></i></li>
                    <li>Lesen Sie die Politik<em></em><i></i></li>
                    <li class="current">Informationen Bestätigen<em></em><i></i></li>
                    <li>Holen Sie sich einen Banner<em></em><i></i></li>
                </ul>
            </div>
		</div>
<?php echo Message::get(); ?>
		<article class="row blogger-form">
			<div class="col-sm-2 hidden-xs"></div>
			<div class="col-sm-8 col-xs-12">
				<div class="fashion-tit">Informationen Bestätigen</div>
				<div>
					<div class="sub-info">
						<form class="form" id="submitInfo" method="post" action="">
							<ul>
								<li>
									<label class="col-sm-2 col-xs-12"><span>*</span> Email Adresse:</label>
									<div class="col-sm-7 col-xs-12">
										<input type="text" class="sub-info-text col-xs-12" name="email" id="email">
									</div>
									<span class="errorInfo col-sm-3 col-xs-12"></span>
								</li>
								<li>
									<label class="col-sm-2 col-xs-12"><span>*</span> Geschlecht:</label>
									<div class="col-sm-7 col-xs-12">
										<select id="gender" name="gender" class="col-xs-12 selected-option">
											<option value="">Geschlecht Wählen</option>
											<option value="0">Weiblich</option>
											<option value="1">Männlich</option>
										</select>
									</div>
									<span class="errorInfo col-sm-3 col-xs-12"></span>
								</li>
								<li>
									<label class="col-sm-2 col-xs-12"><span>*</span> Land:</label>
									<div class="col-sm-7 col-xs-12">
										<select id="country" name="country" class="col-xs-12 selected-option">
											<option value="">Land Wählen</option>
										<?php
										$countries = Site::instance()->countries(LANGUAGE);
										foreach ($countries as $country):
											?>
										<option value="<?php echo $country['isocode']; ?>"><?php echo $country['name']; ?></option>
										<?php
										endforeach;
										?>
										</select>
									</div>
									<span class="errorInfo col-sm-3 col-xs-12"></span>
								</li>
								<li>
									<table id="tab" class="col-xs-12">
										<tbody>
											<tr>
												<td>
													<label class="col-sm-2 col-xs-12"><span>*</span> Hauptseite Typ: </label>
													<div class="col-sm-7 col-xs-12">
														<select name="sites[type][]" id="type" maxlength="16" class="col-xs-12 selected-option">
															<option value="lookbook">Look Book</option>
		                                                    <option value="personal Blog">Persönlicher Blog</option>
		                                                    <option value="facebook">Facebook</option>
		                                                    <option value="youtube">Youtube</option>
		                                                    <option value="chictopia">Chictopia</option>
		                                                    <option value="pinterest">Pinterest</option>
		                                                    <option value="instagram">Instagram</option>
		                                                    <option value="tumblr">Tumblr</option>
		                                                    <option value="twitter">Twitter</option>
														</select>
													</div>
													<label class="col-sm-3 hidden-xs">&nbsp;</label>
												</td>
											</tr>
											<tr>
												<td>
													<label class="col-sm-2 col-xs-12"><span>*</span> Hauptseite URL: </label>
													<div class="col-sm-5 col-xs-12">
														<input type="text" class="sub-info-text col-xs-12" name="sites[url][]" id="url">
													</div>
													<label class="col-sm-2 col-xs-12"><span>*</span> Fans / Verfolger: </label>
													<div class="col-sm-2 col-xs-12">
														<input type="text" class="sub-info-text col-xs-12" name="sites[flow][]" id="flow">
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</li>
								<li style="margin-top:0;">
									<label class="col-sm-2 hidden-xs"></label>
									<div class="col-sm-7 col-xs-12">
										<input type="button" onclick="AddNewRow()" value="eine weitere Website hinzufügen" class="add-more" name="Submit">
									</div>
									<input type="hidden" value="1" id="txtTRLastIndex" name="txtTRLastIndex">
									<input type="hidden" value="2" id="txtTDLastIndex" name="txtTDLastIndex">
								</li>
								<li>
									<label class="col-sm-2 col-xs-12"><span>*</span> Nachricht:</label>
									<div class="col-sm-7 col-xs-12">
									<?php
									$message_value = 'Schreiben Sie etwas, um sich vorzustellen und uns mitzuteilen, was ist Ihre Idee über Mode.Danke !';
									?>
										<textarea onfocus="this.value=(this.value=='<?php echo $message_value; ?>')?'':this.value" value="<?php echo $message_value; ?>" onblur="this.value=(this.value=='')?'<?php echo $message_value; ?>':this.value"
										class="input textarea sub-info-text3 col-xs-12" rows="10" id="input_comment" name="comment"><?php echo $message_value; ?></textarea>
									</div>
								</li>
								<li>
									<label class="col-sm-2 col-xs-12"></label>
									<div class="col-sm-7 col-xs-12">
										<input type="submit" value="BESTÄTIGEN" class="btn btn-primary btn-lg" id="inforSubmit">
									</div>
									<label class="col-sm-3 hidden-xs"></label>
								</li>
							</ul>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-2 hidden-xs"></div>
		</article>
	</section>
<div class="hide" id="catalog_link" style="position: fixed;padding: 10px 10px 20px; top: 0px;left: 400px;width: 640px;height: 230px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:#CCC 1px solid;">
<div class="order order_addtobag">
<div class="fashion_thank"></div>
</div>
<div class="clsbtn close-btn3" style="right: 3px;top: 3px;"></div>
</div>

<script type="text/javascript">
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
		    //添加两行
		    var index = 1;
		    function AddNewRow() {
		        var txtTRLastIndex = findObj("txtTRLastIndex", document);
		        var rowID = parseInt(txtTRLastIndex.value);
		        var tab = findObj("tab", document);
		        var columnLength = tab.rows[0].cells.length;
		        var columnLength1 = tab.rows[1].cells.length;							
		        //添加行
		        var newTR = tab.insertRow(tab.rows.length);
		        newTR.id = "SignItem" + rowID;
		        for (var i = 0; i < columnLength; i++) {
		            if (i == 0) {//第一列:序号
		                newTR.insertCell(i).innerHTML = "<label class='col-sm-2 col-xs-12'><span>*</span> Hauptseite Typ: </label><div class='col-sm-7 col-xs-12'><select id='type_"+i+"' name='sites[type][]' class='col-xs-12 selected-option' maxlength='16'><option value='Look Book'>Look Book</option><option value='Personal Blog'>Personal Blog</option><option value='Facebook'>Facebook</option><option value='Youtube'>Youtube</option><option value='Chictopia'>Chictopia</option><option value='Pinterest'>Pinterest</option><option value='Instagram'>Instagram</option><option value='Tumblr'>Tumblr</option><option value='Twitter'>Twitter</option></select></div><label class='col-sm-3 hidden-xs'> </label>";
		            } 
		        }
		        var newTR1 = tab.insertRow(tab.rows.length);
		        newTR1.id = "SignItem" + (rowID + 1);
		        for (var i = 0; i < columnLength1; i++) {
		            if (i == 0) {//第一列:序号
		                newTR1.insertCell(i).innerHTML = "<label class='col-sm-2 col-xs-12'><span>*</span>Hauptseite URL:</label><div class='col-sm-5 col-xs-12'><input type='text' id='url_"+i+"' name='sites[url][]' class='sub-info-text col-xs-12'></div><label class='col-sm-2 col-xs-12'><span>*</span>Fans / Verfolger:</label><div class='col-sm-2 col-xs-12'><input id='flow_"+i+"' class='sub-info-text col-xs-12' type='text' name='sites[flow][]'></div><div align='left' class='col-sm-1 col-xs-12'><a style='color:black;text-decoration:underline;' href='javascript:' onclick=\"DeleteSignRow('SignItem" + (rowID+1) + "')\">Löschen</a></div>";
		            } 
		        }
		        //将行号推进下一行
		        txtTRLastIndex.value = (rowID + 2).toString();
		    }
		    //删除指定两行
		    function DeleteSignRow(rowid) {
		        var tab = findObj("tab", document);
		        var signItem = findObj(rowid, document);
		        //获取将要删除的行的Index
		        var rowIndex = signItem.rowIndex;
		        //删除指定Index的行
		        tab.deleteRow(rowIndex);
		        tab.deleteRow(rowIndex-1);
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
	<script>
	    
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
                        required:"Bitte geben Sie eine E-Mail ein.",
                        email:"Bitte geben Sie eine gültige E-Mail-Adresse ein."
                    },
                    gender:{
                        required:"Erforderliches Feld"
                    },
                    country:{
                        required:"Erforderliches Feld"
                    }
				}
			});
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
                    var message = '<h3>Entschuldigung!</h3><p>Diese E-Mail wurde verwendet.</p>';
                    $('.fashion_thank').html(message);
                    $(".wingray").delay(3000).fadeOut();
                    $('#catalog_link').delay(3000).fadeOut();
                }
                else
                {
                    $('body').append('<div class="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                    $('#catalog_link').appendTo('body').fadeIn(320);
                    $('#catalog_link').show();
                    var message = '<h3>DANKE!</h3><p>Wir würden Ihnen innerhalb einer Woche kontaktieren, nachdem Sie das Antragsformular eingeriechen.</p>';
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