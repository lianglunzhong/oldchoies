<?php echo View::factory('/admin/site/label_left')->render(); ?>
<div id="do_right">
<label>Download CSV Template For Catalog:</label><a href="/media/catalog_bulk_upload.csv">catalog_bulk_upload.csv</a>
<br/><br/>
<form action="/admin/site/label/bulk_upload" method="post" enctype="multipart/form-data">
	<label for="file">Filename:</label>
	<input type="file" name="file" id="file" /> 
	<input type="hidden" name="style" value="catalog" /> 
	<br />
	<input type="submit" name="submit" value="Submit" />
</form>
<br/><br/>
<label>Download CSV Template For Related:</label><a href="/media/related_bulk_upload.csv">related_bulk_upload.csv</a>
<br/><br/>
<form action="/admin/site/label/bulk_upload" method="post" enctype="multipart/form-data">
	<label for="file">Filename:</label>
	<input type="file" name="file" id="file" /> 
	<input type="hidden" name="style" value="related" /> 
	<br />
	<input type="submit" name="submit" value="Submit" />
</form>
</div>