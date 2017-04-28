<?php echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<div id="do_right">
<label>Download CSV Template:</label><a href="/media/bulk_upload.csv">bulk_upload.csv</a>
<br/><br/>
<form action="/admin/ticket/ticket/bulk_upload" method="post" enctype="multipart/form-data">
	<label for="file">Filename:</label>
	<input type="file" name="file" id="file" /> 
	<br />
	<input type="submit" name="submit" value="Submit" />
</form>
</div>