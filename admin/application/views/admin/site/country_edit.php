<?php echo View::factory('admin/site/basic_left')->render(); ?>
<div id="do_right">
    <form action="" method="post" name="form1" id="form1">
        <div class="box">
            <h3>国家修改</h3>
            <ul>
                <li>
                    <label>isocode:</label>
                    <div><?php echo $data->isocode;?></div>
                </li>
                <li>
                    <label>country name:</label>
                    <div><input class="short text" type="text" id="name" name="name" value="<?php echo $data->name?>"></div>
                </li>
                <li>
                    <label>brief:</label>
                    <div><input class="short text" type="text" id="brief" name="brief" value="<?php echo $data->brief?>"></div>
                </li>
                <li>
                    <div><input type="submit" value="修  改"></div>
                </li>
            </ul>
        </div>
    </form>
</div>
