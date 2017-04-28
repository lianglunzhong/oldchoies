<?php echo View::factory('admin/site/promotion_left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>产品促销列表</h3>
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">名称</th>
                    <th scope="col">简介</th>
                    <th scope="col">开始日期</th>
                    <th scope="col">结束日期</th>
                    <th scope="col">Admin</th>
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
                        <td><?php echo $item->name; ?></td>
                        <td><?php echo $item->brief; ?></td>
                        <td><?php echo date('Y-m-d', $item->from_date); ?></td>
                        <td><?php echo date('Y-m-d', $item->to_date); ?></td>
                        <td><?php print User::instance($item->admin)->get('name'); ?></td>
                        <td>
                            <a href="/admin/site/promotion/edit/<?php echo $item->id; ?>">修改</a>
                            <a href="/admin/site/promotion/delete/<?php echo $item->id; ?>" class="delete">删除</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php echo $page_view; ?>
        <div style="float:right;">
            <a target="_blank" href="/admin/site/api/add_spromotion_memcache">生成产品促销memcache(全部)</a>
            <br><br>
            <a target="_blank" href="/admin/site/api/simple_spromotion_memcache">按sku生成促销memcache</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('.delete').click(function(){
            if(!confirm('Are you sure to elete this promotion?')){
                return false;
            }
        });
    });
</script>
