<?php echo View::factory('admin/ticket/ticket_left')->render(); ?>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />
<script type="text/javascript" src="/media/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(
	function()
	{
		$("#tk_form").validate();
		$('#submit').click(function(){
			if($('#content').val()=='')
			{
				$('#content').attr("style", "border: 2px solid #FF8888");
			};
		});
		$('#line').change(function(){
			$("#site_id").load("/admin/ticket/ticket/get_site_by_privilege/"+$("#line").val());
		});
		$('#cancel').click(function(){
			history.back()
		});
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
		var uploader = new qq.FileUploader({
		    // pass the dom node (ex. $(selector)[0] for jQuery users)
		    element: document.getElementById('file-uploader'),
		    allowedExtensions: ["<?php echo implode('","',kohana::config('ticket.attachment.filetypes'));?>"],
		    sizeLimit:<?php echo kohana::config('ticket.attachment.max_size');?>,
		    // path to server-side upload script
		    action: '/admin/ticket/ticket/upload_file',
		    debug: false
		}); 
	}
);
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
    <div class="box">
        <h3>Open New Ticket</h3>
        <form action="/admin/ticket/ticket/new/" method="post" name="form" id="tk_form" class="need_validation">
            <ul>
                <li>
                    <label>Customer First Name:</label>
                    <div><input class="required" id="ifirst_name" name="first_name" type="text"><span class="req">*</span></div>
                </li>
                <li>
                    <label>Last Name:</label>
                    <div><input class="required" type="text" id="last_name" name="last_name"><span class="req">*</span></div>
                </li>
                <li>
                    <label>Email Address:</label>
                    <div><input class="required" id="email" name="email"><span class="req">*</span></div>
                </li>
                <li>
                    <label>Site:</label>
                    <div>
                    <select id="line" name='line_id'>
                    <option value=''>Select a Line</option>
                    <?php 
                    	foreach($lines as $key=>$value)
                    	{
                    ?>
                    <option value='<?php echo $key;?>'><?php echo $value;?></option>
                    <?php
                    	}
                    ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <select name="site_id" id="site_id" class="select required">
                    </select><span class="req">*</span>
					</div>
                </li>
                <li>
                	<label>Topic:</label>
                	<div>
                		<select id="topic_id" name="topic_id" class="select required">
                			<?php 
                			foreach ($topics as $topic)
                			{
                				if($topic['for_customer']==1)
                				{
                			?>
                			<option value='<?php echo $topic['id'];?>'><?php echo $topic['topic'];?></option>
                			<?php 
                				}
                			}
                			?>
                		</select><span class="req">*</span>
                	</div>
                </li>
                <li>
                    <label>Order No:</label>
                    <div><input  type="text" id="order_no" name="order_no"></div>
                </li>
                <li>
                    <label>Subject:</label>
                    <div><input maxlength="40" class="required" type="text" id="subject" name="subject"><span class="req">*</span></div>
                </li>
                <li>
                    <label>Question:</label>
                    <div><textarea name="content" id="content" cols="55" rows="10" class="required"></textarea><span class="req">*</span></div>
                </li>
				<li>
		            <label>&nbsp;</label><div id="file-uploader">              
					</div>
					<label>&nbsp;</label><a href="#" id="do_template">Select Template</a><br/>
					<input type="hidden" id="fixtextarea" />
		            <label>&nbsp;</label><input type="submit" value="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id='cancel' type="button" value="cancel">
             	</li>
             </ul>
        </form>
    </div>
</div>