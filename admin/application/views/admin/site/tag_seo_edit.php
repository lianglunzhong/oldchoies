<h2><a href="/admin/site/product/taglist">返回tag列表</a></h2>
<div id="do_right">
    <div class="box">
        <h3>Tag SEO Edit</h3>
		<?php
            $lang = Arr::get($_GET, 'lang', 'en');
        ?>
        <form method="post" action="/admin/site/product/seo_submit" name="ptype_add_form" class="need_validation">
            <ul>
                <li>
                    <label>meta_title<span class="req"></span></label>
                    <div>
					<textarea name="meta_title" cols="30" rows="15"><?php echo $result['meta_title']; ?></textarea>
					</div>
					<div>展示已有的title</div>
					<div><?php echo $result['meta_title']; ?></div>
                </li>

                <li>
                    <label>meta_keywords<span class="req"></span></label>
                    <div><input id="meta_keywords" name="meta_keywords" class="short text required" type="text" value="<?php echo $result['meta_keywords']; ?>"></div>
                </li>

                <li>
                    <label>meta_description<span class="req"></span></label>
					<div>
					<textarea name="meta_description" cols="30" rows="15"><?php echo $result['meta_description']; ?></textarea>
					</div>
					<div>展示已有的description</div>
					<div><?php echo $result['meta_description']; ?></div>
                </li>
                    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                    <input type="hidden" name="lang" value="<?php echo $lang; ?>">

                <li>
                    <button type="submit">Edit</button> 
                </li>

            </ul>
        </form>
    </div>
</div>
