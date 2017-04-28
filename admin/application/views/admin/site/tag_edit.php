<h2><a href="/admin/site/product/taglist">返回tag列表</a></h2>
<div id="do_right">
    <div class="box">
        <h3>Tag Edit</h3>
		
		<?php
		$now_lang = Arr::get($_GET, 'lang', 'en');
			if($banner['link'])
			{
				$newlink=explode("-c-",$banner['link'])
		?>
			<h3><a href="/admin/site/product/seo_edit?id=<?php echo $newlink[1];?>&lang=<?php echo $now_lang;?>" style="color:red;">Tag SEO Edit</a></h3>
			
		<?php
			}
		?>
        <form method="post" action="#" name="ptype_add_form" class="need_validation">
            <ul>
                <li>
                    <label>Link<span class="req">*</span></label>
                    <div><input id="link" name="link" class="short text required" type="text" value="<?php echo $banner['link']; ?>"></div>
                </li>

                <li>
                    <label>Name<span class="req">*</span></label>
                    <div><input id="alt" name="name" class="short text required" type="text" value="<?php echo $banner['name']; ?>"></div>
                </li>

                <li>
                    <label>Position<span class="req">*(排序:数字越大排在越前)</span></label>
                    <div><input id="position" name="position" class="short text required" type="text" value="<?php echo $banner['position']; ?>"></div>
                </li>

                <li>
                    <button type="submit">Edit</button> 
                </li>

            </ul>
        </form>
    </div>
</div>
