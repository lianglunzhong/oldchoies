<?php echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<script type="text/javascript" src="/media/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />
<script type="text/javascript">
$(document).ready(
	function()
	{
		$("#tk_from").validate();
		$("#re_from").validate();
		$("#note_from").validate();
		<?php
		if($data['detail']['status']!="Closed"&&$data['detail']['is_active']==1){
		?>
		var uploader = new qq.FileUploader({
		    // pass the dom node (ex. $(selector)[0] for jQuery users)
		    element: document.getElementById('file-uploader'),
		    allowedExtensions: ["<?php echo implode('","',kohana::config('ticket.attachment.filetypes'));?>"],
		    sizeLimit:<?php echo kohana::config('ticket.attachment.max_size');?>,
		    // path to server-side upload script
		    action: '/admin/ticket/ticket/upload_file',
		    debug: false
		});
		<?php }
		?> 
		$('#dialog-form').dialog({ autoOpen: false });
	    $('#do_template').click(function(){
	        $('#dialog-form').dialog('open');
	        return false;
	    });
	    $('.tp_box a').click(function(){
	    	$('#fixtextarea').load(this.href,function(){
	    		$('#content').val($('#fixtextarea').text());
		    	});
		    $('#dialog-form').dialog('close');	
			return false;
		});
	    $('#do_copy').click(function(){
	    	setClipboard("<?php echo $data['detail']['email'];?>");
	        return false;
	    });
	    $('#do_copy_order').click(function(){
	    	setClipboard("<?php echo trim($data['detail']['order_no']);?>");
	        return false;
	    });
	    $('#delete').live('click',function(){
            if(!confirm('To delete the tickets permanently?')){
                return false;
            }
        });
	}
	);
function setClipboard(maintext) {
    if(window.clipboardData) {   
            window.clipboardData.clearData();   
            window.clipboardData.setData("Text", maintext); 
            return false; 
    } else if(navigator.userAgent.indexOf("Opera") != -1) {   
         window.location = txt; 
         return false;
    } else if (window.netscape) {   
         var clip ;
         try {   
             netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");   
             clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);   
             if (!clip)   
                  return false;  
         } catch (e) {   
              alert("Your WebBrowser not allow this.\nPlease type 'about:config'in your address bar and ENTER.\nThen set 'signed.applets.codebase_principal_support' to 'true'"); 
              return false;
         }
         var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);   
         if (!trans)   
              return false;   
         trans.addDataFlavor('text/unicode');   
         var str = new Object();   
         var len = new Object();   
         var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);   
         var copytext = maintext;   
         str.data = copytext;   
         trans.setTransferData("text/unicode",str,copytext.length*2);   
         var clipid = Components.interfaces.nsIClipboard;   
         if (!clip)   
              return false;   
         clip.setData(trans,null,clipid.kGlobalClipboard);
         return false; 
    }
    alert('Your WebBrowser not allow this.');
    return false;
}
function display_manager(id)
{
	$('#'+id).css("display")=="none"?$('#'+id).css("display","block"):$('#'+id).css("display","none");
}
</script>
<div id="do_right">
<div id="dialog-form" title="select template">
<ul>
<?php 
$i=0;
foreach ($templates as $value)
{
	if(isset($value['tpl'])){
?>
<li>
	<a href="#" onclick="display_manager('box<?php echo $i;?>');return false"><?php echo $value['cate']; ?></a>
		<ul id="box<?php echo $i;?>" style="display:none" class="tp_box">
	<?php 
	foreach($value['tpl'] as $k=>$v){
		?>
		<li><a href="/admin/ticket/ticket/get_template/<?php echo $k;?>"><?php echo $v; ?></a></li>
		<?php 
	}
	?>
		</ul>
</li>
<?php
	$i++;
	}
}?>
</ul>
</div>
	<?php if($data['detail']['status']=="Closed")
			echo '<label style="color: #222222;font-size: 12px;font-weight: bold;">This ticket is closed. Please create a new ticket if you have any more questions.</label>';
	?>
<fieldset class='clr'>
	<legend><b>Ticket ID: <?php echo $data['detail']['ticketID'];?></b></legend>
	<form action="/admin/ticket/ticket/edit/" method="post" id="tk_from">
	<div class='ticket_info_left'>
		<ul>
            <li>
                 <label>Subject: <input maxlength="40" class="required" type="text" id="subject" name="subject" value="<?php echo $data['detail']['subject'];?>"/></label>
            </li>
            <li>
                 <label>Site: <?php echo $data['site'];?></label>
            </li>
            <li>
                 <label>Create Date: <?php echo date('Y-m-d',$data['detail']['created']);?></label>
            </li>
            <li>
                 <label>Status:</label>
                 <select name='status'>
								<?php 
									foreach ($status as $value)
									{
								?>
								<option value="<?php echo $value;?>" <?php if($value==$data['detail']['status']) echo 'selected'; ?>><?php echo $value;?></option>
								<?php 
									}
								?>
				</select>		
            </li>
            <li>
                 <label>Topic:</label>
                 <select name='topic_id'>
								<?php 
                			foreach ($topics as $topic)
                			{
                				if($topic['for_customer']==$topic_customer)
                				{
                			?>
                			<option value='<?php echo $topic['id'];?>' <?php if($topic['id']==$data['detail']['topic_id']) echo "selected";?>><?php echo $topic['topic'];?></option>
                			<?php 
                				}
                			}
                			?>
				</select>			
            </li>
            <li>
            <label>Assign To User:</label>
            <select name="user_id">
            <option value="0">Not Assign</option>
            <?php foreach($users as $user){?>
            <option value="<?php echo $user['user_id']?>" <?php if($user['user_id']==$data['detail']['user_id']) echo "selected";?>><?php echo $user['nickname']?>(<?php echo $user['user_id']?>)</option>
            <?php }?>
            </select>
            </li>
            <li>
            <label>Priority:</label>
					<select name='priority_id'>
						<?php 
							foreach ($priority as $key=>$value)
							{
						?>
						<option value="<?php echo $key;?>" <?php if($key==$data['detail']['priority_id']) echo 'selected'; ?>><?php echo $value['status'];?></option>
						<?php 
							}
						?>
					</select>		
            </li>
            <li>
				<label>Set Top:</label><input type="checkbox" name='istop' <?php if($data['detail']['istop']==1) echo "checked";?>/>
			</li>
			<li>
				<label>Send mail:</label><input type="checkbox" name='sendmail' <?php echo "checked";?>/>
			</li>
			<li>
				<input type="submit" value="save"/>
			</li>		
		</ul>
	</div>
	<div>
		<ul>
			<li>
                 <label>Customer Name: </label><input class="required" id="ifirst_name" name="first_name" type="text" value="<?php echo $data['detail']['first_name'];?>" />&nbsp;<input class="required" type="text" id="last_name" name="last_name" value="<?php echo $data['detail']['last_name'];?>">
            </li>
            <li>
                 <label>Email: <input class="required" id="email" name="email" value="<?php echo $data['detail']['email'];?>" />&nbsp;<a href="/admin/ticket/ticket/list?email=<?php echo $data['detail']['email'];?>"><?php echo '['.$emailnum.']';?></a></label>&nbsp;<a href="#" id="do_copy">Copy</a>
            </li>
            <li>
                 <label>Phone: </label><input class="short text" type="text" id="phone" name="phone" value="<?php echo $data['detail']['phone'];?>">-<input class="short text" type="text" id="phone_ext" name="phone_ext" value="<?php echo $data['detail']['phone_ext'];?>">
            </li>
            <li>
                 <label>Country:</label>
                 <select name="country">
                 <option value="">No Country Selected</option>
                 <?php foreach ($countries as $country){?>
                 <option value="<?php echo $country['isocode'];?>" <?php if($country['isocode']==$data['detail']['country']) echo "selected";?>><?php echo $country['name'];?></option>
                 <?php }?>
                 </select>
            </li>
            <li>
                 <label>Order#: <input  type="text" id="order_no" name="order_no" value="<?php echo $data['detail']['order_no'];?>" /></label>&nbsp;<a href="#" id="do_copy_order">Copy</a>
            </li>
            <li>
				<label>Classification:</label>
				<select name='classification'>
				<?php 
					foreach ($classifications as $value)
					{
				?>
					<option value="<?php echo $value;?>" <?php if($value==$data['detail']['classification']) echo 'selected'; ?>><?php echo $value;?></option>
				<?php 
					}
				?>
				</select>		
			</li>
			<li>
				<label>Evaluation:</label>
				<select name='evaluation'>
				<?php 
					for($i=0;$i<6;$i++)
					{
				?>
					<option value="<?php echo $i;?>" <?php if($i==$data['detail']['evaluation']) echo 'selected'; ?>><?php echo $i==0?'--':$i;?></option>
				<?php 
					}
				?>
				</select>					
			</li>	
			<li>
				<label>IP:<?php 
				$address=Geoip::instance()->geoip_country_name_by_addr(long2ip($data['detail']['ip_address']));
				echo long2ip($data['detail']['ip_address']).'['.($address!=false?$address:"unknown").']';
				?>
				</label>
			</li>	
		</ul>
	</div>
<input type="hidden" value="<?php echo $data['detail']['ticketID'];?>" name="ticketID"/>
</form>
<form action="/admin/ticket/ticket/active/" method="post">
<input type="hidden" value="<?php echo $data['detail']['ticketID'];?>" name="ticketID"/>
<?php if($data['detail']['is_active']==1){?>
<input type="submit" value="inactive" name="inactive"/>
<?php }
elseif ($data['detail']['is_active']==0){?>
<input type="submit" value="reactive" name="reactive"/>
<?php }
?>
</form>
<?php
if ($data['detail']['is_active']==0&&Session::instance()->get('ticket_role')!="User"){
?>
<form action="/admin/ticket/ticket/delete/" method="post">
<input type="hidden" value="<?php echo $data['detail']['ticketID'];?>" name="ticketID"/>
<input type="submit" value="Delete" name="delete" id="delete"/>
</form>
<?php 
}
?>
</fieldset>
<?php if($data['detail']['note']!=''){?>
<div class="tk_block">
<ul>
Note:
<li>
<?php echo $data['detail']['note'];?>
</li>
</ul>
</div>
<?php }?>
<?php 
if($messages!=1)
{
?>
<div class="tk_block">
<?php 
	foreach($messages as $message)
	{
?>
<ul>
<?php 
		if($message['user_id']!='')
			$name=ticket::instance()->get_ticket_user_name($message['user_id']);
		else 
			$name=$data['detail']['first_name'].' '.$data['detail']['last_name'];
		echo date('D F d Y H:i:s',$message['created']).' - By '.$name;
?>
<li>
<?php 	echo nl2br($message['message']);?>
</li>
<?php 
		foreach($attaches as $attach)
		{
			if($attach['ticket_message_id']==$message['id'])			
				echo '<li><a href="'.Kohana::config('ticket.attachment.URL').'/'.$data['detail']['ticketID'].'/'.$message['id'].'/'.$attach['attach_name'].'">'.$attach['attach_name'].'('.($attach['attach_size']/1000).'k)</a></li>';
		}
?>
<?php 
	if($message['user_id']!='')
	{
		$signature=Kohana::config('ticket.signature');
		$signature=str_ireplace('{nickname}',$name,str_ireplace('{site}',$data['site'],$signature));
?>
<li>
<?php echo $signature;?>
</li>
<?php
	}
?>
</ul>
<?php 
	}
?>
</div>
<?php 
}
echo $page_view;
?>
<div class="ticket_info_left">
<b>Reply</b><br/>
<form action="/admin/ticket/ticket/addmessage/" id="re_from" method="post">  
<textarea rows="10" cols="55" name="content" class="short text required" id="content"></textarea><br/>
<div id="file-uploader"></div>
<div>
<a href="#" id="do_template">Select Template</a>
</div>
<input type="hidden" id="fixtextarea" />
<input type="hidden" value="<?php echo $data['detail']['ticketID'];?>" name="ticketID"/>
<input type="submit" value="Reply" <?php if($data['detail']['status']=="Closed"||$data['detail']['is_active']==0) echo 'disabled';?>/>
</form>
</div>
<div>
<b>Note</b><br/>
<form action="/admin/ticket/ticket/addnote/" method="post" id="note_from">
<textarea rows="10" cols="55" name="content" class="short text required" id="content" ></textarea><br/>
<input type="hidden" value="<?php echo $data['detail']['ticketID'];?>" name="ticketID"/>
<input type="submit" value="Note"/>
</form>
</div>
</div>
