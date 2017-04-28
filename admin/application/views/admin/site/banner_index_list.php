<?php
echo View::factory('admin/site/banner_left')->render(); 
$domain = Site::instance()->get('domain');
?>
<div id="do_right">
    <div class="box">
        <h3>Index Banner List
        <?php
            if($lang == '')
                $lang = 'en';
            $languages = Kohana::config('sites.1.language');
            foreach($languages as $l)
            {
                ?>
                <a class="nolang" href="/admin/site/banner/index/<?php if($l != 'en') echo $l; ?>" <?php if($lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
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
                    <th width="80" scope="col">Action</th>
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
                        <td><img width="150px" src="<?php echo STATICURL; ?>/bimg/<?php echo $banner['image']; ?>" /></td>
                        <td><?php echo $banner['alt']; ?></td>
                        <td><?php echo $banner['title']; ?></td>
                        <td><?php echo $banner['visibility']; ?></td>
                        <td><?php echo $banner['position']; ?></td>
                        <td>
                            <a target="_blank" href="/admin/site/banner/index_edit/<?php echo $banner['id']; ?>">修改</a>
                        </td>
                    </tr>
                    <?php
                }
                foreach($buyers_show as $b)
                {
                    ?>
                    <tr>
                        <td><?php echo $b['id']; ?></td>
                        <td><?php echo $b['link']; ?></td>
                        <td><?php echo $b['map']; ?></td>
                        <td><?php echo $b['alt']; ?></td>
                        <td><?php echo $b['title']; ?></td>
                        <td><?php echo $b['visibility']; ?></td>
                        <td><?php echo $b['position']; ?></td>
                        <td>
                            <a href="/admin/site/banner/index_edit/<?php echo $b['id']; ?>">修改</a>
                        </td>
                    </tr>
                    <?php
                }
                foreach( $apparel as $banner )
                {
                    ?>
                    <tr>
                        <td><?php echo $banner['id']; ?></td>
                        <td><?php echo $banner['link']; ?></td>
                        <td><img width="150px" src="<?php echo STATICURL; ?>/bimg/<?php echo $banner['image']; ?>" /></td>
                        <td><?php echo $banner['alt']; ?></td>
                        <td><?php echo $banner['title']; ?></td>
                        <td><?php echo $banner['visibility']; ?></td>
                        <td><?php echo $banner['position']; ?></td>
                        <td>
                            <a href="/admin/site/banner/index_edit/<?php echo $banner['id']; ?>">修改</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <?php 
                foreach( $banners1 as $banner )
                {
                    ?>
                    <tr>
                        <td><?php echo $banner['id']; ?></td>
                        <td><?php echo $banner['link']; ?></td>
                        <td><img width="150px" src="<?php echo STATICURL; ?>/simages/<?php echo $banner['image']; ?>" /></td>
                        <td><?php echo $banner['alt']; ?></td>
                        <td><?php echo $banner['title']; ?></td>
                        <td><?php echo $banner['visibility']; ?></td>
                        <td><?php echo $banner['position']; ?></td>
                        <td>
                            <a href="/admin/site/banner/index_edit/<?php echo $banner['id']; ?>">修改</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <?php 
                foreach( $banners2 as $banner )
                {
                    ?>
                    <tr>
                        <td><?php echo $banner['id']; ?></td>
                        <td><?php echo $banner['link']; ?></td>
                        <td><img width="150px" src="<?php echo STATICURL; ?>/simages/<?php echo $banner['image']; ?>" /></td>
                        <td><?php echo $banner['alt']; ?></td>
                        <td><?php echo $banner['title']; ?></td>
                        <td><?php echo $banner['visibility']; ?></td>
                        <td><?php echo $banner['position']; ?></td>
                        <td>
                            <a href="/admin/site/banner/index_edit/<?php echo $banner['id']; ?>">修改</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>