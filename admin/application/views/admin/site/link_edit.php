<script type="text/javascript" src="/media/js/my_validation.js"></script>
<div id="do_content">
    <form method="post" action="#" name="form_add_set" class="need_validation">
        <div class="box">
            <h3>Link Edit<span class="moreActions"><a href="/admin/site/links/edit">Back to link list</a></span></h3>

            <ul>

                <li>
                    <label>Name</label>
                    <div>
                        <input style="width:80px;" name="name" type="text" value="<?php echo $link->name; ?>"/>
                    </div>
                </li>

                <li>
                    <label>email</label>
                    <div><input style="width:250px;" name="email" type="text" value="<?php echo $link->email; ?>"/></div>
                </li>

                <li>
                    <label>subject</label>
                    <div><input name="subject" value="<?php echo $link->subject; ?>" /></div>
                </li>

                <li>
                    <label>message</label>
                    <div><textarea name="message" class="medium text required" cols="80" rows="8"><?php echo $link->message; ?></textarea></div>
                </li>

                <li>
                    <label>is_valid</label>
                    <div>
                        <select name="is_valid">
                        <option value="1" <?php echo $link->is_valid ? 'selected="selected"' : ''; ?>>Yes</option>
                        <option value="0" <?php echo !$link->is_valid ? 'selected="selected"' : ''; ?>>No</option>
                        </select>
                    </div>
                </li>

                <li>
                    <label>level</label>
                    <div>
                        <select name="level">
                    <?php
                    $i = 1;
                    while ($i <= 6)
                    {
                    ?>
                            <option value="<?php echo $i; ?>" <?php echo $link->level === $i ? 'selected="selected"' : ''; ?>><?php echo $i; ?></option>
                    <?php
                    $i ++;
                    }
                    ?>
                        </select>
                    </div>
                </li>

                <li>
                    <button type="submit">保存</button>
                </li>

            </ul>
        </div>
    </form>
</div>



