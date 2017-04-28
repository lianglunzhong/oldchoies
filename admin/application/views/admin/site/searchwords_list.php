<?php echo View::factory('admin/site/promotion_left')->render(); ?>

<div id="do_right">
    <div class="box">
        <h3>SeachWords List列表
        <?php
            $lang=Arr::get($_GET, 'lang', '');
            if($lang == ''){ $lang = 'en'; }
            $languages = Kohana::config('sites.1.language');
            foreach($languages as $l)
            {
                ?>
                <a href="/admin/site/promotion/searchwords?lang=<?php echo $l; ?>" <?php if($lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
        </h3>
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Href</th>
                    <th scope="col">Lang</th>
                    <th scope="col">创建时间</th>
                    <th scope="col">type</th>
                    <th scope="col">Admin</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($searchwords as $searchword): 
                $type=$searchword['type']==1?"Search Bar":"Hot Words";
                ?>
                <tr>
                    <td><?php print $searchword['id']; ?></td>
                    <td><?php print $searchword['name']; ?></td>
                    <td><?php print $searchword['href']; ?></td>
                    <td><?php print $searchword['lang']; ?></td>
                    <td><?php print date('Y-m-d',$searchword['created']); ?></td>
                    <td><?php print $type; ?></td>
                    <td><?php print User::instance($searchword['admin'])->get('name'); ?></td>
                    <td>
                        <a href="/admin/site/promotion/searchwords_del/<?php echo $searchword['id']; ?>" onclick="return window.confirm('delete?');">删除</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
