<?php echo View::factory('admin/site/celebrity_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript">
        $(function(){
                $('#add_blog').click(function(){
                        var blog = $('#blog').html();
                        var $this = $(this),count = parseInt($this.attr('count')) + 1;
                        var $div = $('<div class="blog_add">\
                                    <label for="blog_type">Blog Type: </label>\
                                    <select name="blog[type][]" id="blog_type">\
                                            <option value="blog">Blog</option>\
                                            <option value="lookbook">Lookbook</option>\
                                            <option value="facebook">Facebook</option>\
                                            <option value="youtube">Youtube</option>\
                                            <option value="polyvore">Polyvore</option>\
                                            <option value="twitter">Twitter</option>\
                                            <option value="pinterest">Pinterest</option>\
                                            <option value="other">Other</option>\
                                    </select>\
                                    <label for="blog_url">Blog Url: </label><input name="blog[url][]" id="blog_url" class="inline short" value="" /> &nbsp;&nbsp;&nbsp;&nbsp;\
                                    <label for="blog_fanse">Blog Fanse: </label><input name="blog[profile][]" id="blog_fanse" class="inline numeric" value="0" />&nbsp;&nbsp;<a href="#" class="delete_blog">删除</a>\
                                                </div>');
                                                            $div.insertAfter($this.parent().parent().find('div:last'));
                                                            $this.attr('count',count);
                                                            return false;
                                                    });
                                                    $('.delete_blog').live('click',function(){
                                                            var id = $(this).attr('title');
                                                            if(id)
                                                            {
                                                                var delete_blog = $("#delete_blog_ids").val();
                                                                $("#delete_blog_ids").val(delete_blog += ',' + id);
                                                            }
                                                            $(this).parent().remove();
                                                            return false;
                                                    });
                                            });
</script>
<div id="do_right">
        <div class="box">
                <h3>Celebrity Edit</h3>
                <form name="celebrity_add" action="" method="post" class="need_validation">
                        <ul>

                                <li>
                                        <label>Name<span class="req">*</span></label>
                                        <div>
                                                <input name="name" id="name" value="<?php echo $celebrity['name']; ?>" class="text medium required" type="text" />
                                        </div>
                                </li>

                                <li>
                                        <label>Email<span class="req">*</span></label>
                                        <div>
                                                <input name="email" id="email" value="<?php echo $celebrity['email']; ?>" class="text medium required email" type="text" />
                                        </div>
                                </li>

                                <li>
                                        <label>Country</label>
                                        <div>
                                                <select name="country" id="country">
                                                        <option value="">select a country</option>
                                                        <?php
                                                        $countries = Site::instance()->countries();
                                                        foreach ($countries as $country):
                                                                ?>
                                                                <option value="<?php echo $country['name']; ?>" <?php echo $country['name'] == $celebrity['country'] ? "selected" : ""; ?>><?php echo $country['name']; ?></option>
                                                                <?php
                                                        endforeach;
                                                        ?>
                                                </select>
                                        </div>
                                </li>   

                                <li>
                                        <label>Sex<span class="req">*</span></label>
                                        <div>
                                                <select name="sex" id="sex">
                                                        <option value="1" <?php 
                                                        $countrysex = isset($country['sex']) ? $country['sex'] : '';
                                                        echo $countrysex == '1' ? "selected" : ""; ?>>Man</option>
                                                        <option value="2" <?php echo $countrysex == '2' ? "selected" : ""; ?>>Woman</option>
                                                </select>
                                        </div>
                                </li>

                                <li>
                                        <label>Birthday<span class="req">*(example:1988-01-01)</span></label>
                                        <div>
                                                <input name="birthday" id="birthday" value="<?php echo date('Y-m-d', $celebrity['birthday']); ?>" class="text medium required" type="text" />
                                        </div>
                                </li>

                                <li>
                                        <label>Level<span class="req">*</span>(1:大,2:中,3:小)</label>
                                        <div>
                                                <select name="level" id="level">
                                                        <option value="1" <?php if ($celebrity['level'] == 1) echo 'selected="selected"' ?>>1</option>
                                                        <option value="2" <?php if ($celebrity['level'] == 2) echo 'selected="selected"' ?>>2</option>
                                                        <option value="3" <?php if ($celebrity['level'] == 3) echo 'selected="selected"' ?>>3</option>
                                                </select>
                                        </div>
                                </li>

                                <li>
                                        <label>Blogs</label>
                                        <div>
                                                <?php
                                                if (empty($blogs))
                                                {
                                                        ?>
                                                        <label for="blog_type">Blog Type: </label>
                                                        <select name="blog[type][]" id="blog_type">
                                                                <option value="blog">Blog</option>
                                                                <option value="lookbook">Lookbook</option>
                                                                <option value="facebook">Facebook</option>
                                                                <option value="youtube">Youtube</option>
                                                                <option value="polyvore">Polyvore</option>
                                                                <option value="twitter">Twitter</option>
                                                                <option value="pinterest">Pinterest</option>
                                                                <option value="other">Other</option>
                                                        </select>
                                                        <label for="blog_url">Blog Url: </label><input name="blog[url][]" id="blog_url" class="inline short" value="" /> &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label for="blog_fanse">Blog Fanse: </label><input name="blog[profile][]" id="blog_fanse" class="inline numeric" value="0" />&nbsp;&nbsp;
                                                        <?php
                                                }
                                                else
                                                {
                                                        foreach ($blogs as $key => $blog)
                                                        {
                                                                ?>
                                                                <div class="blog_add">
                                                                <label for="blog_type">Blog Type: </label>
                                                                <select name="blog[type][<?php echo $key; ?>]" id="blog_type">
                                                                        <option value="blog" <?php if ($blog['type'] == 'blog') echo 'selected="selected"' ?>>Blog</option>
                                                                        <option value="lookbook" <?php if ($blog['type'] == 'lookbook') echo 'selected="selected"' ?>>Lookbook</option>
                                                                        <option value="facebook" <?php if ($blog['type'] == 'facebook') echo 'selected="selected"' ?>>Facebook</option>
                                                                        <option value="youtube" <?php if ($blog['type'] == 'youtube') echo 'selected="selected"' ?>>Youtube</option>
                                                                        <option value="polyvore" <?php if ($blog['type'] == 'polyvore') echo 'selected="selected"' ?>>Polyvore</option>
                                                                        <option value="twitter" <?php if ($blog['type'] == 'twitter') echo 'selected="selected"' ?>>Twitter</option>
                                                                        <option value="pinterest" <?php if ($blog['type'] == 'pinterest') echo 'selected="selected"' ?>>Pinterest</option>
                                                                        <option value="other" <?php if ($blog['type'] == 'other') echo 'selected="selected"' ?>>Other</option>
                                                                </select>
                                                                <label for="blog_url">Blog Url: </label><input name="blog[url][<?php echo $key; ?>]" id="blog_url" class="inline short" value="<?php echo $blog['url']; ?>" /> &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <label for="blog_fanse">Blog Fanse: </label><input name="blog[profile][<?php echo $key; ?>]" id="blog_fanse" class="inline numeric" value="<?php echo $blog['profile']; ?>" />&nbsp;&nbsp;
                                                                <input type="hidden" name="blog[blog_id][]" value="<?php echo $blog['id']; ?>" />
                                                                <a href="#" class="delete_blog" title="<?php echo $blog['id']; ?>">删除</a>
                                                                </div>
                                                                <?php
                                                        }
                                                }
                                                ?>
                                                <a href="#" id="add_blog" count="1">+更多Blog</a>
                                        </div>
                                        <input type="hidden" id="delete_blog_ids" name="delete_blog" value="" />
                                </li>
                                
                                <li>
                                        <label>备注: </label>
                                        <div>
                                                <input name="remark" id="remark" value="<?php echo $celebrity['remark']; ?>" class="text medium" type="text" />
                                        </div>
                                </li>

                                <li>
                                        <input value="Submit" class="button" type="submit" />
                                </li>
                        </ul>
                </form>
        </div>
</div>