<?php echo View::factory('admin/site/news_left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>站点新闻列表</h3>
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">站点ID</th>
                    <th scope="col">用户ID</th>
                    <th scope="col">标题</th>
                    <th scope="col">内容</th>
                    <th scope="col">发表时间</th>
                    <th scope="col">浏览次数</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>

<?php
foreach( $data as $item )
{
?>
                    <tr>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->site_id; ?></td>
                        <td><?php echo $item->user_id; ?></td>
                        <td><?php echo $item->title; ?></td>
                        <td><?php echo substr($item->content,0,40)."······"; ?></td>
                        <td><?php echo date('Y-m-d H:i:s', $item->create_date); ?></td>
                        <td><?php echo $item->times; ?></td>
                        <td>
                            <a href="/admin/site/news/edit/<?php echo $item->id; ?>">修改</a>
                            <a href="/admin/site/news/del/<?php echo $item->id; ?>">删除</a>
                        </td>
                    </tr>
<?php
}
?>

            </tbody>
        </table>

        <?php echo $page_view; ?>

    </div>
</div>
