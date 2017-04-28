<?php echo View::factory('admin/site/banner_left')->render(); ?>

<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/file-uploader/fileuploader.js"></script>
<script type="text/javascript" src="/media/js/jquery.form.min.js"></script> 
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
        <h3>Banner Edit</h3>
        <form enctype="multipart/form-data" action="" method="POST" id="imageform">
            <ul>
                <input type="hidden" name="type" value="<?php echo $banner['type']; ?>" />
                <?php
                if ($banner['type'] == 'index' OR $banner['type'] == 'apparel' OR $banner['type'] == 'activities' OR $banner['type'] == 'product' OR $banner['type'] == 'accessory' OR $banner['type'] == 'newindex' OR $banner['type'] == 'phonecatalog')
                {
                    ?>
                    <li>
                        <div id="image_preview" style="margin-bottom:15px;">
                            <div>
                                <?php if($banner['type'] == 'newindex'){ ?>
                                <img src="<?php echo STATICURL . '/simages/' . $banner['image']; ?>" />
                                <?php }else{ ?>
                                <img src="<?php echo STATICURL . '/bimg/' . $banner['image']; ?>" />
                                <?php } ?>
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
                        <div><input id="title" name="title" class="short text required" type="text" value="<?php echo $banner['title']; ?>"></div>
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
                                    <img src="<?php echo STATICURL; ?>/bimg/<?php echo $sku; ?>.jpg" alt="<?php echo $sku; ?>">
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
                }elseif ($banner['type'] == 'index1'){
                    $maparr = unserialize($banner['map']);
                ?>
                    <div class="celection hidden-xs">
                        <ul class="row" id="index1">
                            <li class="col-xs-4" style=" text-align:left;">
                                <?php foreach($maparr as $key=>$value){ ?>
                                <a><img src="<?php echo STATICURL; ?>/simages/<?php echo $value; ?>" id="img<?php echo $key; ?>"></a>
                                <?php  }   ?>
                            </li>

                        <li>
                        <?php  ?>
                            <label>Link<span class="req">*</span></label>
                            <div>
                            <textarea name="link" cols="40" rows="20"><?php if($banner['type'] == 'index1'){echo $banner['linkarray'];}else{echo $banner['link'];}?></textarea>
                            </div>
                            <h3 style="color:red;">如果为6张图，请在此输入产品SKU，英文逗号隔开</h3>
                        </li>
                            <input type="text" class="text-long text col-sm-9 col-xs-9" readonly name="file_name" id="file_name"/>
                            <input type="button" id="v12345" value="upload"  style="height:24px;" onclick="btn_file.click();" name="get_file"/>
                            <input type="file" id="btn_file"  name="btn_file" onchange="file_change(this.value,1)"  style="display:none;"/>
                            <input type="hidden" name="isgoimg" value="" id="isgoimg" />
                        </ul>
                    </div>
                <?php } ?>
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
                    <input type="hidden" name="hiddenid" value="<?php echo $banner['id']; ?>" />
                    <button type="submit">Edit</button> 
                </li>

            </ul>
        </form>
    </div>
</div>

<script type="text/javascript">
        function file_change(e,avalue)
        {
            document.getElementById("file_name").value = e;
            var gotoimg = document.getElementById("isgoimg").value;
            ajaxsub(gotoimg);
        }

        function ajaxsub(ace2)
        {
            alert('图片上传成功！')
            $("#imageform").attr('action', '/admin/site/banner/ajaximg/?img='+ace2);
                $("#imageform").ajaxForm({ 
                    beforeSubmit:function(){ 
                    },  
                    success:function(data){ 
                        var thisimg = "#"+ace2;
                        var yimg = "<?php echo STATICURL;?>/simages/"+data;
                        $(thisimg).attr("src",yimg);
                    },  
                    error:function(){ 
                } }).submit();            
        }


            

        $(function(){
            var cimgs = $("#index1").find("img");
            cimgs.live('click', function(){ 
                var aimgs = this.id;
                //设置参数
                document.getElementById("isgoimg").value = aimgs; 
                btn_file.click(); 
            })            
        })

   
</script>
