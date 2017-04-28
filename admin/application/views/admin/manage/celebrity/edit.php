<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>添加红人</h3>
        <form method="post" action="" id="form1">
            <table class="layout">
                <tr>
                    <td>姓名</td>
                    <td><input id="name" type="text" name="name" value="<?php echo $celebrity->name; ?>"/></td>
                </tr>
                <tr>
                    <td>站点用户ID</td>
                    <td><input id="name" type="text" name="customer_id"  value="<?php echo $celebrity->customer_id; ?>"/></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input id="name" type="text" name="email"  value="<?php echo $celebrity->email; ?>"/></td>
                </tr>
                <tr>
                    <td>联系方式</td>
                    <td><input id="name" type="text" name="contact"  value="<?php echo $celebrity->contact; ?>"/></td>
                </tr>
                <tr>
                    <td>所在地</td>
                    <td><input id="name" type="text" name="location"  value="<?php echo $celebrity->location; ?>"/></td>
                </tr>
                <tr>
                    <td>性别</td>
                    <td>
                        <select name="gender">
                            <option value="男" <?php echo $celebrity->gender == '男' ? 'selected' : '' ?>>男</option>
                            <option value="女" <?php echo $celebrity->gender == '女' ? 'selected' : '' ?>>女</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>年龄</td>
                    <td><input id="name" type="text" name="age"  value="<?php echo $celebrity->age; ?>"/></td>
                </tr>
                <tr>
                    <td>个人博客</td>
                    <td><input id="name" type="text" name="blog_url"  value="<?php echo $celebrity->blog_url; ?>"/></td>
                </tr>
                <tr>
                    <td>博客ALEXA排名</td>
                    <td><input id="name" type="text" name="blog_alexa"  value="<?php echo $celebrity->blog_alexa; ?>"/></td>
                </tr>
                <tr>
                    <td>Lookbook地址</td>
                    <td><input id="name" type="text" name="lookbook_url"  value="<?php echo $celebrity->lookbook_url; ?>"/></td>
                </tr>
                <tr>
                    <td>Lookbook粉丝数</td>
                    <td><input id="name" type="text" name="lookbook_fans"  value="<?php echo $celebrity->lookbook_fans; ?>"/></td>
                </tr>
                <tr>
                    <td>Facebook地址</td>
                    <td><input id="name" type="text" name="facebook_url"  value="<?php echo $celebrity->facebook_url; ?>"/></td>
                </tr>
                <tr>
                    <td>Facebook粉丝数</td>
                    <td><input id="name" type="text" name="facebook_fans"  value="<?php echo $celebrity->facebook_fans; ?>"/></td>
                </tr>
                <tr>
                    <td>其他平台地址</td>
                    <td><input id="name" type="text" name="other_url"  value="<?php echo $celebrity->other_url; ?>"/></td>
                </tr>
                <tr>
                    <td>其他平台数据</td>
                    <td><input id="name" type="text" name="other_data"  value="<?php echo $celebrity->other_data; ?>"/></td>
                </tr>
                <tr>
                    <td>红人等级</td>
                    <td><input id="name" type="text" name="level"  value="<?php echo $celebrity->level; ?>"/></td>
                </tr>
                <tr>
                    <td>积分数</td>
                    <td><input id="name" type="text" name="points"  value="<?php echo $celebrity->points; ?>"/></td>
                </tr>
                <tr>
                    <td>流量总计</td>
                    <td><input id="name" type="text" name="flow"  value="<?php echo $celebrity->flow; ?>"/> IP</td>
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
