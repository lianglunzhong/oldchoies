<?php
echo View::factory('admin/site/banner_left')->render(); 
$domain = Site::instance()->get('domain');
?>
<div id="do_right">
    <div class="box">
        <h3>Side Banner List
        <?php
            if($lang == '')
                $lang = 'en';
            $languages = Kohana::config('sites.1.language');
            foreach($languages as $l)
            {
                ?>
                <a class="nolang" href="/admin/site/banner/side/<?php if($l != 'en') echo $l; ?>" <?php if($lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
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
                    <th scope="col">Type</th>
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
                        <td><img width="150px" src="http://<?php echo Site::instance()->get('domain'); ?>/uploads/1/simages/<?php echo $banner['image']; ?>" /></td>
                        <td><?php echo $banner['type']; ?></td>
                        <td><?php echo $banner['alt']; ?></td>
                        <td><?php echo $banner['title']; ?></td>
                        <td><?php echo $banner['visibility']; ?></td>
                        <td><?php echo $banner['position']; ?></td>
                        <td>
                            <a target="_blank" href="/admin/site/banner/side_edit/<?php echo $banner['id']; ?>">修改</a>
                        </td>
                    </tr>
                    <?php
                }


                ?>
            </tbody>
        </table>
    </div>
</div>