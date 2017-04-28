<?php echo View::factory('admin/manage/left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>添加红人</h3>
        <form method="post" action="" id="form1">
            <table class="layout">
                <tr>
                    <td>姓名</td>
                    <td><input id="name" type="text" name="name" /></td>
                </tr>
                <tr>
                    <td>站点用户ID</td>
                    <td><input id="name" type="text" name="customer_id" /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input id="name" type="text" name="email" /></td>
                </tr>
                <tr>
                    <td>联系方式</td>
                    <td><input id="name" type="text" name="contact" /></td>
                </tr>
                <tr>
                    <td>所在地</td>
                    <td><input id="name" type="text" name="location" /></td>
                </tr>
                <tr>
                    <td>性别</td>
                    <td>
                        <select name="gender">
                            <option value="男">男</option>
                            <option value="女">女</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>年龄</td>
                    <td><input id="name" type="text" name="age" /></td>
                </tr>
                <tr>
                    <td>个人博客</td>
                    <td><input id="name" type="text" name="blog_url" /></td>
                </tr>
                <tr>
                    <td>博客ALEXA排名</td>
                    <td><input id="name" type="text" name="blog_alexa" /></td>
                </tr>
                <tr>
                    <td>Lookbook地址</td>
                    <td><input id="name" type="text" name="lookbook_url" /></td>
                </tr>
                <tr>
                    <td>Lookbook粉丝数</td>
                    <td><input id="name" type="text" name="lookbook_fans" /></td>
                </tr>
                <tr>
                    <td>Facebook地址</td>
                    <td><input id="name" type="text" name="facebook_url" /></td>
                </tr>
                <tr>
                    <td>Facebook粉丝数</td>
                    <td><input id="name" type="text" name="facebook_fans" /></td>
                </tr>
                <tr>
                    <td>其他平台地址</td>
                    <td><input id="name" type="text" name="other_url" /></td>
                </tr>
                <tr>
                    <td>其他平台数据</td>
                    <td><input id="name" type="text" name="other_data" /></td>
                </tr>
                <tr>
                    <td>红人等级</td>
                    <td><input id="name" type="text" name="level" /></td>
                </tr>
                <tr>
                    <td>积分数</td>
                    <td><input id="name" type="text" name="points" /></td>
                </tr>
                <tr>
                    <td>流量总计</td>
                    <td><input id="name" type="text" name="flow" /> IP</td>
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
