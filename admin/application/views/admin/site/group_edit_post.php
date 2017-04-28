<script type="text/javascript" src="/media/js/my_validation.js"></script>
<div id="do_content">
    <form method="post" action="#" name="form_add_set" class="need_validation">
        <div class="box">
            <h3>Post Edit<span class="moreActions"><a href="/admin/site/group/post">Back to post list</a></span></h3>

            <ul>

                <li>
                    <label>Topic id</label>
                    <div>
                        <?php
                        $topic = DB::select('topic_id')->from('topic_posts')->where('post_id','=',$post->id)->execute()->current();
                        ?>
                        <input style="width:80px;" name="topic_name" type="text" disabled="disabled" value="<?php echo $topic['topic_id']; ?>"/>
                    </div>
                </li>

                <li>
                    <label>User</label>
                    <div><input style="width:250px;" name="user" type="text" value="<?php echo Customer::instance($post->user_id)->get('email'); ?>"/></div>
                </li>

                <li>
                    <label>Title</label>
                    <div><textarea name="title" cols="50" rows="3"><?php echo $post->title; ?></textarea></div>
                </li>

                <li>
                    <label>Content</label>
                    <div><textarea name="content" class="medium text required" cols="80" rows="8"><?php echo $post->content; ?></textarea></div>
                </li>

                <li>
                    <label>Video url</label>
                    <div><textarea name="video_url" cols="50" rows="3"><?php echo $post->video_url; ?></textarea></div>
                </li>

                <li>
                    <label>Created</label>
                    <div><textarea name="pub_time" cols="50" rows="3"><?php echo $post->pub_time; ?></textarea></div>
                </li>

                <li>
                    <button type="submit">保存</button>
                </li>

            </ul>
        </div>
    </form>
</div>



