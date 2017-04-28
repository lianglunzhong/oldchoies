<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>编辑供货商</h3>
        <form method="post" action="" id="form1">
            <table class="layout">
                <tr>
                    <td><label>名称：</label></td>
                    <td><input id="name" type="text" name="name" value="<?php echo $factory->name; ?>"/></td>
                </tr>
                <tr>
                    <td><label>店铺链接：</label></td>
                    <td><input id="name" type="text" name="url" value="<?php echo $factory->url; ?>"/></td>
                </tr>
                <tr>
                    <td><label>手机：</label></td>
                    <td><input id="name" type="text" name="mobile" value="<?php echo $factory->mobile; ?>"/></td>
                </tr>
                <tr>
                    <td><label>阿里旺旺：</label></td>
                    <td><input id="name" type="text" name="aliwangwang" value="<?php echo $factory->aliwangwang; ?>"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Save" />
                        <a href="/admin/site/doc/list">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
