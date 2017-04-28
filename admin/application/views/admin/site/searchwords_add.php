<?php echo View::factory('admin/site/promotion_left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>添加Search word</h3>
        <form name="coupon_promotion" action="/admin/site/promotion/searchwords_add" method="post">
            <ul>
                <li>
                <label><span class="req">*</span>语言类型: </label>
                    <select name="lang">
                    <?php
                        $languages = Kohana::config('sites.1.language');
                        foreach($languages as $l)
                        {
                            ?>
                            <option value="<?php echo $l; ?>"><?php echo $l; ?></option>
                            <?php
                        }
                    ?>
                    </select>
                </li>
                <li>
                <label><span class="req">*</span>Type: </label>
                    <select name="type">
                        <option value="1">Search Bar</option>
                        <option value="2">Hot Words</option>
                    </select>
                </li>

                <li>
                <label><span class="req">*</span>Name: </label>
                <input name="title" class="coupon_number" value="" type="text">
                </li>

                <li>
                <label><span class="req">*</span>链接: </label>
                <input name="href" class="coupon_number" value="" type="text">
                </li>
                
                <li>
                <input value="Submit" class="button" type="submit" />
                </li>
            </ul>
        </form>
    </div>
</div>
