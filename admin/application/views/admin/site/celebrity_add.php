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
                                                            $(this).parent().remove();
                                                            return false;
                                                    });
                                            });
</script>
<div>
        <div class="box">
                <h3>Celebrity Add</h3>
                <form name="celebrity_add" action="" method="post" class="need_validation">
                        <ul>

                                <li>
                                        <label>Name<span class="req">*</span></label>
                                        <div>
                                                <input name="name" id="name" class="text medium required" type="text" />
                                        </div>
                                </li>

                                <li>
                                        <label>Email<span class="req">*</span></label>
                                        <div>
                                                <input name="email" id="email" class="text medium required email" type="text" />
                                        </div>
                                </li>

                                <li>
                                        <label>Country</label>
                                        <div>
                                                <select name="country" id="country">
                                                        <option value="">select a country</option>
                                                <?php
                                                $countries = Site::instance()->countries();
                                                foreach($countries as $country):
                                                ?>
                                                        <option value="<?php print $country['name']; ?>"><?php print $country['name']; ?></option>
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
                                                        <option value="2">Woman</option>
                                                        <option value="1">Man</option>
                                                </select>
                                        </div>
                                </li>

                                <li>
                                        <label>Birthday<span class="req">*(example:1988-01-01)</span></label>
                                        <div>
                                                <input name="birthday" id="birthday" class="text medium required" value="1988-01-01" type="text" />
                                        </div>
                                </li>

                                <li>
                                        <label>Level<span class="req">*</span>(1:大,2:中,3:小)</label>
                                        <div>
                                                <select name="level" id="level">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                </select>
                                        </div>
                                </li>

                                <li>
                                        <label>Blogs</label>
                                        <div>
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
                                                <label for="blog_fanse">Blog Fanse: </label><input name="blog[profile][]" id="blog_fanse" class="inline numeric" value="0" />&nbsp;&nbsp;<a href="#" id="add_blog" count="1">+更多Blog</a>
                                        </div>
                                </li>

                                <li>
                                        <input value="Submit" class="button" type="submit" />
                                </li>
                        </ul>
                </form>
        </div>
</div>