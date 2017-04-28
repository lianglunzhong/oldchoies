<?php echo View::factory('admin/site/banner_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<link rel="stylesheet" type="text/css" href="/media/js/file-uploader/fileuploader.css" />
<script>
    $(function(){
        if($(".remind").length > 0 )
        {
            location.reload();
        }
    })
</script>
<div id="do_right">
    <div class="box">
        <h3>Side Banner Edit</h3>
        <form enctype="multipart/form-data" action="" method="POST">
            <ul>
                <input type="hidden" name="type" value="<?php echo $banner['type']; ?>" />
                <?php
                $types = array('index', 'apparel', 'activity', 'product', 'activities', 'freetrial','side');
                if (in_array($banner['type'], $types))
                {
                    ?>
                    <li>
                        <div id="image_preview" style="margin-bottom:15px;">
                            <div>
                                <img src="http://<?php echo Site::instance()->get('domain'); ?>/uploads/1/simages/<?php echo $banner['image']; ?>" />
                            </div>
                        </div>
                        <input type="hidden" name="filename" value="<?php echo $banner['image']; ?>" />
                        <input name="file" type="file" />
                    </li>
                    <li>
                        <label>Link<span class="req">*</span></label>
                        <div><input id="link" name="link" class="short text required" type="text" value="<?php echo $banner['link']; ?>"></div>
                    </li>
                    <li>
                        <label>Alt<span class="req">*</span></label>
                        <div><input id="alt" name="alt" class="short text required" type="text" value="<?php echo $banner['alt']; ?>"></div>
                    </li>
                    <li>
                        <label>Title<span class="req">*</span></label>
                        <div><input id="title" name="title" class="short text" type="text" value="<?php echo $banner['title']; ?>"></div>
                    </li>
                    <li>
                        <label>Type<span class="req">*</span></label>
                        <div><input id="type" name="type" class="short text" type="text" value="<?php echo $banner['type']; ?>"></div>
                    </li>
                    <?php
                }
                elseif ($banner['type'] == 'buyers_show')
                {
                    ?>
                    <li>
                        <ul id="images_list">
                            <?php
                            $domain = Site::instance()->get('domain');
                            $skus = explode("\n", $banner['map']);
                            foreach ($skus as $sku)
                            {
                                ?>
                                <li>
                                    <img src="http://<?php echo Site::instance()->get('domain'); ?>/uploads/1/files/<?php echo $sku; ?>.jpg" alt="<?php echo $sku; ?>">
                                    <div class="image_actions">
                                        <span id="is_default"><?php echo $sku; ?></span>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <li>
                        <label>Image Upload:</label>
                        <input name="file" type="file" />
                    </li>
                    <li>
                        <div>
                            <textarea name="map" id="map" rows="15" cols="40" class="textarea"><?php echo $banner['map']; ?></textarea>
                        </div>
                    </li>
                    <li>
                        <label>Image Delete:</label>
                        <div>
                            <textarea name="image_delete" rows="15" cols="40" class="textarea"></textarea>
                        </div>
                    </li>
                    <?php
                }
                ?>
                <li>
                    <label>Visibility</label>
                    <div>
                        <input type="radio" <?php if ($banner['visibility'] == 1) echo 'checked="checked"'; ?> value="1" name="visibility" class="radio"> Visible
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" <?php if ($banner['visibility'] == 0) echo 'checked="checked"'; ?> value="0" name="visibility" class="radio"> Invisible
                    </div>
                </li>
                <li>
                    <label>Position<span class="req">*(排序:数字越小排在越前)</span></label>
                    <div><input id="position" name="position" class="short text required" type="text" value="<?php echo $banner['position']; ?>"></div>
                </li>
                <li>
                    <label>LANGUAGE<span class="req">(语种)</span></label>
                    <div>
                        <select id="lang" name="lang">
                            <option></option>
                            <?php
                            $languages = Kohana::config('sites.' . Session::instance()->get('SITE_ID') . '.language');
                            foreach ($languages as $l)
                            {
                                if ($l == 'en')
                                    continue;
                                ?>
                                <option value="<?php echo $l; ?>" <?php if ($banner['lang'] == $l) echo 'selected'; ?>><?php echo $l; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </li>
                <li>
                    <button type="submit">Edit</button> 
                </li>

            </ul>
        </form>
    </div>
</div>
