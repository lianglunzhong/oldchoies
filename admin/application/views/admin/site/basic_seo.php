<?php echo View::factory('admin/site/basic_left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>Site Basic SEO</h3>
        <form action="/admin/site/basic/seo" method="post" name="form1" id="form1">
            <ul>
                <li>
                    <label>Global Title:</label>
                    <div><input class="text long" type="text" id="meta_title" name="meta_title" value="<?php echo $site->meta_title;?>"></div>
                </li>
                <li>
                    <label>Global Keywords:</label>
                    <div><input class="text long" type="text" id="meta_keywords" name="meta_keywords" value="<?php echo $site->meta_keywords;?>"></div>
                </li>
                <li>
                    <label>Global Meta Description:</label>
                    <div><input class="text long" type="text" id="meta_description" name="meta_description" value="<?php echo $site->meta_description;?>"></div>
                </li>
				<li>
                    <label>Robots.txt:</label>
                    <div><textarea cols="60" rows="4" name="robots"><?php echo $site->robots;?></textarea></div>
                </li>
				<li>
                    <label>Stat Code:</label>
                    <div><textarea cols="60" rows="8" name="stat_code"><?php echo $site->stat_code;?></textarea></div>
                </li>
                <li>
                    <div><input type="submit" value="Save"></div>
                </li>
            </ul>
        </form>
    </div>
</div>
