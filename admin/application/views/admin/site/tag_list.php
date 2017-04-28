<h2><a href="/admin/site/product/addtag">新建tag</a></h2>
<div id="do_right">
    <div class="box">
        <h3>Tag List
        <?php
        if($lang == '')
                $lang = 'en';
            $languages = Kohana::config('sites.1.language');
            foreach($languages as $l)
            {
                ?>
                <a class="nolang" href="/admin/site/product/taglist/<?php if($l != 'en') echo $l; ?>" <?php if($lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
        </h3>
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Link</th>
                    <th scope="col">position</th>
                    <th scope="col">查看tag下关联sku</th>
                    <th width="60" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $tags as $banner )
                {
                    ?>
                    <tr>
                        <td><?php echo $banner['id']; ?></td>
                        <td><?php echo $banner['name']; ?></td>
                        <td><?php echo $banner['link']; ?></td>
                        <td><?php echo $banner['position']; ?></td>
                        <td>
                         <a target="_blank" href="/admin/site/product/look/<?php echo $banner['id']; ?>">查看</a>
                        </td>
                        <td>
                        <?php if($lang == 'en'){ ?>
                         <a target="_blank" href="/admin/site/product/edittag/<?php echo $banner['id']; ?>">修改</a>
                        <?php }else{ ?>
                        <a target="_blank" href="/admin/site/product/edittag/<?php echo $banner['id']; ?>?lang=<?php echo $lang;?>">修改</a>
                        <?php } ?>
                         
                            <!-- <a href="/admin/site/product/deletetag/<?php echo $banner['id']; ?>" class="delete">删除</a> -->
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php // echo $page_view; ?>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('.delete').click(function(){
            if(!confirm('Are you sure to delete this tag?')){
                return false;
            }
        });
    });
</script>