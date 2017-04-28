<h2><a href="/admin/site/product/taglist">返回tag列表</a></h2>
<div id="do_right">
    <div class="box">
        <h3>Tag Add</h3>
        <form method="post" action="#" name="ptype_add_form" class="need_validation">
            <ul>
                <li>
                    <label>Link<span class="req">*</span></label>
                    <div><input id="link" name="link" class="short text required" type="text" value=""></div>
                </li>

                <li>
                    <label>Name<span class="req">*</span></label>
                    <div><input id="alt" name="name" class="short text required" type="text" value=""></div>
                </li>

                <li>
                    <label>Position<span class="req">*(排序:数字越大排在越前)</span></label>
                    <div><input id="position" name="position" class="short text required" type="text" value=""></div>
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
                                <option value="<?php echo $l; ?>"><?php echo $l; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </li>
                <li>
                    <input type="submit" value="ADD" />
                </li>



            </ul>
        </form>
    </div>
</div>
