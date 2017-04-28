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
                <a class="nolang" href="/admin/site/banner/phoneindex/<?php if($l != 'en') echo $l; ?>" <?php if($lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
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
                        <td><img width="150px" src="<?php echo STATICURL; ?>/simages/<?php echo $banner['image']; ?>" /></td>
                        <td><?php echo $banner['alt']; ?></td>
                        <td><?php echo $banner['title']; ?></td>
                        <td><?php echo $banner['visibility']; ?></td>
                        <td><?php echo $banner['position']; ?></td>
                        <td>
                            <a target="_blank" href="/admin/site/banner/edit/<?php echo $banner['id']; ?>">修改</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>

                <h2 style="color:red;">前三张为手机版轮播banner</h2>
                <hr/>
                <?php
                foreach($phonebanners as $banner )
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
                            <a href="/admin/site/banner/edit/<?php echo $banner['id']; ?>">修改</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

            <fieldset>
                <div style="width:300px;float:left;">
                    <h4>首页手机站底部推荐产品修改</h4>
                    <?php
                    $cache = Cache::instance('memcache');
                    $indexsku = $cache->get('indexsku',array());
                    ?>

                    <form action="/admin/site/product/uploadsku" method="post" target="_blank">
                        <div><span style="color:#FF0000"></span>一行一个SKU</div>
                        <div><span>请输入产品SKU:</span><br>
                            <textarea name="SKUARR" cols="30" rows="20"><?php 
                             foreach ($indexsku as $key => $value) 
                             {
                                echo $value."\n";
                             }  
                             ?></textarea>       
                        </div>
                        <input type="submit" value="Submit">   
                    </form>
                </div>              
            </fieldset>
    </div>
</div>