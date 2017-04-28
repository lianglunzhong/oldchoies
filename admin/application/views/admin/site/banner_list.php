<?php echo View::factory('admin/site/banner_left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>Banner List
        <?php
        if($lang == '')
                $lang = 'en';
            $languages = Kohana::config('sites.1.language');
            foreach($languages as $l)
            {
                ?>
                <a class="nolang" href="/admin/site/banner/list/<?php if($l != 'en') echo $l; ?>" <?php if($lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
        </h3>
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Link</th>
                    <th scope="col">Image</th>
                    <th scope="col">Alt</th>
                    <th scope="col">Title</th>
                    <th scope="col">Visibility</th>
                    <th scope="col">Position</th>
                    <th width="60" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $banners as $banner )
                {
                    ?>
                    <tr>
                        <td><?php echo $banner['id']; ?></td>
                        <td><?php echo $banner['link']; ?></td>
                        <td><?php echo $banner['image']; ?></td>
                        <td><?php echo $banner['alt']; ?></td>
                        <td><?php echo $banner['title']; ?></td>
                        <td><?php echo $banner['visibility']; ?></td>
                        <td><?php echo $banner['position']; ?></td>
                        <td>
                            <a target="_blank" href="/admin/site/banner/edit/<?php echo $banner['id']; ?>">修改</a>
                            <a href="/admin/site/banner/delete/<?php echo $banner['id']; ?>" class="delete">删除</a>
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
            if(!confirm('Are you sure to delete this banner?')){
                return false;
            }
        });
    });
</script>