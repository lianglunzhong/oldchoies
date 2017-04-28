<?php echo View::factory('admin/site/basic_left')->render(); ?>
<div id="do_right">
        <div class="box">
                <h3>Site Basic SNS</h3>
                <form action="/admin/site/basic/sns" method="post" name="form1" id="form1">
                        <ul>
                                <li>
                                        <label>Facebook Login:</label>
                                        <div style="margin-top:5px;"><input type="checkbox" id="fb_login" name="fb_login" value="1" <?php echo $site->fb_login == 1 ? 'checked' : ''; ?>> <label class="note">Facebook Login</label></div>
                                </li>
                                <li>
                                        <label>FB API ID:</label>
                                        <div><input class="text long" type="text" id="fb_api_id" name="fb_api_id" value="<?php echo $site->fb_api_id; ?>"></div>
                                </li>
                                <li>
                                        <label>FB API SECRET:</label>
                                        <div><input class="text long" type="text" id="fb_api_secret" name="fb_api_secret" value="<?php echo $site->fb_api_secret; ?>"></div>
                                </li>
                                <li>
                                        <div><input type="submit" value="Save"></div>
                                </li>
                        </ul>
                </form>
        </div>
</div>
