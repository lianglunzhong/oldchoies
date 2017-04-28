<script type="text/javascript" src="/media/js/my_validation.js"></script>
<div id="do_content">
    <form method="post" action="#" name="form_add_set" class="need_validation">
        <div class="box">
            <h3>Forum Add<span class="moreActions"><a href="/admin/site/group/list">Back to Forum list</a></span></h3>

            <ul>

                <li>
                    <label>Name</label>
                    <div><input name="name" class="medium text required" type="text" ></div>
                </li>

                <li>
                    <label>Type</label>
                    <div>
                        <select name="type" class="drop">
                        <?php
                        $types = kohana::config('sites.'.Site::instance()->get('id').'.group_types');
                        foreach($types as $key=>$type)
                        {
                        ?>
                            <option value="<?php echo $key;?>"><?php echo $type;?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>
                </li>

                <li>
                    <label>Description</label>
                    <div><textarea name="description" rows="8" cols="90"></textarea></div>
                </li>                           
                
                <li>
                    <button type="submit">保存</button>
                </li>

            </ul>
        </div>
    </form>
</div>



