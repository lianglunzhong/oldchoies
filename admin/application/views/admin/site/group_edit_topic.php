<script type="text/javascript" src="/media/js/my_validation.js"></script>
<div id="do_content">
    <form method="post" action="#" name="form_add_set" class="need_validation">
        <div class="box">
            <h3>Forum Edit<span class="moreActions"><a href="/admin/site/group/topic">Back to topic list</a></span></h3>

            <ul>

                <li>
                    <label>Group name</label>
                    <div>
                        <select name="group_id" class="drop">
                        <?php
                        $groups = DB::query(DATABASE::SELECT,'SELECT id,name FROM groups WHERE site_id = '.$topic->site_id.' order by id')->execute();
                        foreach($groups as $key=>$group)
                        {
                        ?>
                            <option value="<?php echo $group['id'];?>"<?php echo $topic->group_id == $group['id'] ? ' selected="selected"' : '';?>><?php echo $group['name'];?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>
                </li>

                <li>
                    <label>Product</label>
                    <div><input style="width:80px;" name="product" type="text" value="<?php echo Product::instance($topic->product_id)->get('sku'); ?>"></div>
                </li>

                <li>
                    <label>Subject</label>
                    <div><textarea name="subject" class="medium text required" cols="80" rows="8"><?php echo $topic->subject; ?></textarea></div>
                </li>

                <li>
                    <label>Content</label>
                    <div><textarea name="content" class="medium text required" cols="80" rows="8"><?php echo $topic->content; ?></textarea></div>
                </li>

                <?php 
                $top_posts = DB::query(DATABASE::SELECT,'SELECT post_id FROM topic_posts WHERE topic_id = '.$topic->id.' order by id')->execute(); 
                ?>
                <li>
                    <label>Top post</label>
                    <div>
                        <select name="top_post" class="drop" style="width:80px;">
                        <?php
                        foreach($top_posts as $key=>$top_post)
                        {
                        ?>
                            <option value="<?php echo $top_post['post_id'];?>"<?php echo $topic->top_post == $top_post['post_id'] ? ' selected="selected"' : '';?>><?php echo $top_post['post_id'];?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>
                </li>

                <li>
                    <label>Last post</label>
                    <div>
                        <select name="last_post" class="drop" style="width:80px;">
                        <?php
                        foreach($top_posts as $key=>$top_post)
                        {
                        ?>
                            <option value="<?php echo $top_post['post_id'];?>"<?php echo $topic->last_post == $top_post['post_id'] ? ' selected="selected"' : '';?>><?php echo $top_post['post_id'];?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>
                </li>

                <li>
                    <label>Sticky</label>
                    <div>
                        <select name="sticky" class="drop">
                            <option value="1"<?php echo $topic->sticky == 1 ? ' selected="selected"' : '';?>>Sticky</option>
                            <option value="0"<?php echo $topic->sticky == 0 ? ' selected="selected"' : '';?>>Not sticky</option>
                        </select>
                    </div>
                </li>

                <li>
                    <label>Locked</label>
                    <div>
                        <select name="locked" class="drop">
                            <option value="1"<?php echo $topic->locked == 1 ? ' selected="selected"' : '';?>>Locked</option>
                            <option value="0"<?php echo $topic->locked == 0 ? ' selected="selected"' : '';?>>Unlocked</option>
                        </select>
                    </div>
                </li>

                <li>
                    <label>Started by</label>
                    <div>
                        <input type="text" class="email required" name="started_by" style="width:200px;" value="<?php echo Customer::instance($topic->started_by)->get('email'); ?>" />
                    </div>
                </li>

                <li>
                    <label>Created</label>
                    <div>
                        <input type="text" class="required" name="created" style="width:200px;" value="<?php echo $topic->created; ?>" />
                    </div>
                </li>

                <li>
                    <label>Add moderators</label>
                    <div>
                        <input type="text" name="moderators" style="width:200px;" />
                    </div>
                </li>

                <li>
                    <button type="submit">保存</button>
                </li>

            </ul>
        </div>
    </form>
</div>



