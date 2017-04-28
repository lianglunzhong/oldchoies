<script type="text/javascript" src="/media/js/my_validation.js"></script>
<div id="do_content">
    <div class="box">
        <h3>Site Basic Information</h3>

        <form action="/admin/sys/site/add" method="post" name="form1" id="form1" class="need_validation">
            <ul>
                <li>
                    <label>Domain:<span class="req">*</span></label>
                    <div><input class="short text required" id="domain" name="domain" value="<?php echo $site->domain;?>" type="text"></div>
                </li>
                <li>
                    <label>Email:</label>
                    <div><input class="short text required email" type="text" id="email" name="email" value="<?php echo $site->email;?>"></div>
                </li>
                <li>
                    <label>Permalink structure:</label>
                    <div style="margin-top:10px">
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="route_type" value="0" id="permalink1" <?php if($site->route_type == 0) echo ' checked="checked"';?>/> <label for="permalink1">ID</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="route_type" value="2" id="permalink2" <?php if($site->route_type == 2) echo ' checked="checked"';?>/> <label for="permalink2">Custom</label>
						<br />&nbsp;&nbsp;&nbsp;&nbsp;
						<label for="permalink_product">Product:</label> <input class="short text required" type="text" name="product" id="permalink_product" value="<?php echo $site->product;?>"> <label class="note">e.g. http://<?php echo $site->domain;?>/<strong style="color:blue;"><?php echo $site->product;?></strong>/xx</label>
						<br />&nbsp;&nbsp;&nbsp;&nbsp;
						<label for="permalink_catalog">Catalog:</label> <input class="short text" type="text" name="catalog" id="permalink_catalog" value="<?php echo $site->catalog;?>"> <label class="note">e.g. http://<?php echo $site->domain;?>/<strong style="color:blue;"><?php echo $site->catalog;?></strong>/56 (Required only if the above "ID" has been selected.)</label>
						<br />&nbsp;&nbsp;&nbsp;&nbsp;
						<label for="permalink_suffix">Suffix:</label> <input class="short text" type="text" name="suffix" id="permalink_suffix" value="<?php echo $site->suffix;?>"> <label class="note">e.g. http://<?php echo $site->domain;?>/<?php echo $site->product;?>/xx<strong style="color:blue;"><?php echo $site->suffix != '' ? $site->suffix : '.html';?></strong></label>
                    </div>
                </li>
				<li>
                    <label>Language:</label>
                    <div style="margin-top:10px">
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="lang" value="en" id="language1" <?php if($site->lang == 'en') echo ' checked="checked"';?>/> <label for="language1">English</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="lang" value="de" id="language2" <?php if($site->lang == 'de') echo ' checked="checked"';?>/> <label for="language2">German</label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="lang" value="ja" id="language3" <?php if($site->lang == 'ja') echo ' checked="checked"';?>/> <label for="language3">Japanese</label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="lang" value="zh-cn" id="language4" <?php if($site->lang == 'zh-cn') echo ' checked="checked"';?>/> <label for="language4">Chinese simplified</label>
                    </div>
                </li>
				<li>
                    <label>Items per page:</label>
                    <div><input class="short text digits" type="text" id="per_page" name="per_page" value="<?php echo $site->per_page;?>"></div>
                </li>
                <li>
                    <div><input type="submit" value="Save"></div>
                </li>
            </ul>
        </form>
    </div>
</div>
