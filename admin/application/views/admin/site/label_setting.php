<?php echo View::factory('admin/site/label_left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>Tags General Setting</h3>
        <form name="niche_label" action="" method="post" class="need_validation">
			<ul>
				<li>Replaceable words: <br/>
					{word}, {Word}, {WORD}<br/>
				</li>
				<li>
					<label>List Meta Title</label>
					<div>
						<input id="list_meta_title" name="list_meta_title"  class="long text" type="text"  value="<?php echo $label->list_meta_title;?>"/>
					</div>
				</li>
				
				<li>
					<label>List Meta Description</label>
					<div>
						<textarea name="list_meta_description" style="width: 480px; height: 150px;"><?php echo $label->list_meta_description;?></textarea>
					</div>
				</li>
				
				<li>
					<label>List Meta Keywords</label>
					<div>
						<input id="list_meta_keywords" name="list_meta_keywords"  class="long text" type="text"  value="<?php echo $label->list_meta_keywords;?>"/>
					</div>
				</li>
				
				<li>
					<label>Catalog Meta Title</label>
					<div>
						<input id="catalog_meta_title" name="catalog_meta_title"  class="long text" type="text"  value="<?php echo $label->catalog_meta_title;?>"/>
					</div>
				</li>
				
				<li>
					<label>Catalog Meta Description</label>
					<div>
						<textarea name="catalog_meta_description" style="width: 480px; height: 150px;"><?php echo $label->catalog_meta_description;?></textarea>
					</div>
				</li>
				
				<li>
					<label>Catalog Meta Keywords</label>
					<div>
						<input id="catalog_meta_keywords" name="catalog_meta_keywords"  class="long text" type="text"  value="<?php echo $label->catalog_meta_keywords;?>"/>
					</div>
				</li>
				
				<li>
					<label>Niche Meta Title</label>
					<div>
						<input id="niche_meta_title" name="niche_meta_title"  class="long text" type="text"  value="<?php echo $label->niche_meta_title;?>"/>
					</div>
				</li>
				
				<li>
					<label>Niche Meta Description</label>
					<div>
						<textarea name="niche_meta_description" style="width: 480px; height: 150px;"><?php echo $label->niche_meta_description;?></textarea>
					</div>
				</li>
				
				<li>
					<label>Niche Meta Keywords</label>
					<div>
						<input id="niche_meta_keywords" name="niche_meta_keywords"  class="long text" type="text"  value="<?php echo $label->niche_meta_keywords;?>"/>
					</div>
				</li>
				
				<li>
					<input type="hidden" name="id" value="<?php echo $label->id;?>" />
					<input value="Submit" class="button" type="submit" />
				</li>
			</ul>
		</form>
    </div>
</div>