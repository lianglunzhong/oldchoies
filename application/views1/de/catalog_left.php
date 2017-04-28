<aside id="aside" class="fll">
    <?php
    $links = explode('/', Request::Instance()->uri);
    $catalog_link = $links[0];
    if ($catalog_link == 'search')
    {
        $gets = $_GET;
        ?>
        <div class="category_box">
            <h3 class="line">Color</h3>
            <ul class="color_list fix">
                <?php
                $current_color = Arr::get($_GET, 'color', 0);
                $filtercolors = Kohana::config('filter.colors');
                foreach ($filtercolors as $key => $color):
                    $gets['color'] = $key + 1;
                    $_gets = array();
                    foreach ($gets as $name => $val)
                    {
                        $_gets[] = $name . '=' . $val;
                    }
                    $href = '?' . implode('&', $_gets);
                    $href = Security::xss_clean($href);
                    ?>
                    <li <?php if ($current_color == $key + 1) echo 'class="on"'; ?>>
                        <a href="<?php echo $href; ?>" title="<?php echo ucfirst($color); ?>">
                            <?php if ($current_color == $key + 1) echo '<em></em>'; ?>
                            <span class="icon color_cate_<?php echo strtolower($color); ?>"></span>
                        </a>
                    </li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>
        <?php
    }
    else
    {
        $banners = DB::select()->from('banners')->where('visibility', '=', 0)->and_where('alt', '=', 'List')->and_where('lang', '=', '')->execute()->as_array();
        foreach ($banners as $banner)
        {
            ?>
            <a href="<?php echo $banner['link']; ?>"><img src="http://img.choies.com/simages/<?php echo $banner['image']; ?>" /></a>
            <?php
        }
    }
    ?>
    <?php
    if ($catalog_link == 'search')
    {
        $catalog_id = 40;
    }
    else
    {
        $catalog_id = DB::select('id')->from('products_category')->where('link', '=', $catalog_link)->execute()->get('id');
        if (!$catalog_id)
        {
            $catalog_id = 40;
        }
    }
    $crumbs = Catalog::instance($catalog_id)->crumbs();
    $catalogs = ORM::factory('catalog')
        ->where('site_id', '=', Site::instance()->get('id'))
        ->where('visibility', '=', 1)
        ->where('on_menu', '=', 1)
        ->where('parent_id', '=', 0)
        ->order_by('position', 'desc')
        ->find_all();
    ?>
    <div class="category_box top_line">
        <div class="leftlist JS_leftlist">
            <?php
            $key = 1;
            foreach ($catalogs as $catalog):
                $on = 0;
                if ($catalog->id == $crumbs[0]['id'])
                    $on = 1;
                $children = Catalog::instance($catalog->id)->children();
                if (!empty($children))
                {
                    ?>
                    <p class="down JS_down <?php echo $on ? ' downon' : ''; ?>">
                        <span>
                            <a <?php echo $on ? 'class="on"' : ''; ?> href="<?php echo LANGPATH; ?>/<?php echo $catalog->link; ?>"><?php echo $catalog->link == 'outlet' ? 'Sale' : $catalog->name; ?></a>
                        </span>
                    </p>
                    <ul class="menu JS_menu <?php echo!$on ? ' hide' : ''; ?>">
                        <?php if ($catalog->link != 'occasion-dresses'): ?>
                            <li><a <?php if ($on AND isset($links[1]) AND $links[1] == 'new') echo 'style="color:#F66;"' ?> href="<?php echo LANGPATH; ?>/<?php echo $catalog->link; ?>/new">NEW IN</a></li>
                        <?php endif; ?>
                        <?php foreach ($children as $sub_catalog): ?>
                            <li><a <?php if ($on AND $catalog_link == Catalog::instance($sub_catalog)->get('link')) echo 'style="color:#F66;"' ?> href="<?php echo Catalog::instance($sub_catalog ,LANGUAGE)->permalink(); ?>"><?php echo Catalog::instance($sub_catalog)->get('name'); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php
                }
                else
                {
                    $link = Catalog::instance($catalog->id)->get('link');
                    if ($link == 'new-in')
                        $link = 'daily-new';
                    ?>
                    <ul class="icategory_box font14">
                        <li><a <?php echo $on ? 'class="on"' : ''; ?> href="<?php echo LANGPATH; ?>/<?php echo $link; ?>"><?php echo $catalog->name; ?></a></li>
                    </ul>
                    <?php
                }
            endforeach;
            ?>
        </div>
    </div>
    <div class="category_box">
        <h3 class="line">BRANDS</h3>
        <div class="leftlist JS_leftlist">
            <?php
            $brands = ORM::factory('catalog')
                ->where('site_id', '=', Site::instance()->get('id'))
                ->where('visibility', '=', 1)
                ->where('on_menu', '=', 0)
                ->where('parent_id', '=', 0)
                ->where('is_brand', '=', 1)
                ->order_by('position', 'desc')
                ->find_all();
            foreach ($brands as $catalog):
                $on = 0;
                if ($catalog->id == $crumbs[0]['id'])
                    $on = 1;
                $children = Catalog::instance($catalog->id)->children();
                if (!empty($children))
                {
                    ?>
                    <p class="down JS_down <?php echo $on ? 'downon' : ''; ?>">
                        <span><a href="<?php echo LANGPATH; ?>/<?php echo $catalog->link; ?>"><?php echo $catalog->name; ?></a></span>
                    </p>
                    <ul class="menu JS_menu <?php echo!$on ? 'hide' : ''; ?>">
                        <li><a <?php if ($on AND isset($links[1]) AND $links[1] == 'new') echo 'style="color:#F66;"' ?> href="<?php echo LANGPATH; ?>/<?php echo $catalog->link; ?>/new">NEW IN</a></li>
                        <?php foreach ($children as $sub_catalog): ?>
                            <li><a <?php if ($on AND $catalog_link == Catalog::instance($sub_catalog)->get('link')) echo 'style="color:#F66;"' ?> href="<?php echo Catalog::instance($sub_catalog ,LANGUAGE)->permalink(); ?>"><?php echo Catalog::instance($sub_catalog)->get('name'); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php
                }
                else
                {
                    ?>
                    <ul class="icategory_box font14">
                        <li><a <?php echo $on ? 'class="on"' : ''; ?> href="<?php echo Catalog::instance($catalog->id ,LANGUAGE)->permalink(); ?>"><?php echo $catalog->name; ?></a></li>
                    </ul>
                    <?php
                }
            endforeach;
            ?>
        </div>
    </div>
<!--    <div class="category_box">
        <h3 class="line">Editor's Pick</h3>
        <ul class="icategory_box">
            <li><a href="<?php echo LANGPATH; ?>/choieslooks/video_show">Video Show</a></li>
            <li><a href="<?php echo LANGPATH; ?>/choieslooks/vol1">MIX & MATCH</a></li>
            <?php
            $catalog = ORM::factory('catalog')
                ->where('site_id', '=', Site::instance()->get('id'))
                ->where('link', '=', 'editor-s-pick')
                ->find();
            $on = 0;
            if ($catalog->id == $crumbs[0]['id'])
                $on = 1;
            $children = Catalog::instance($catalog->id)->children();
            if (!empty($children))
            {
                foreach ($children as $sub_catalog):
                    ?>
                    <li <?php echo $on ? 'class="on"' : ''; ?>><a <?php if ($on AND $catalog_link == Catalog::instance($sub_catalog)->get('link')) echo 'style="color:#F66;"' ?> href="<?php echo Catalog::instance($sub_catalog ,LANGUAGE)->permalink(); ?>"><?php echo Catalog::instance($sub_catalog)->get('name'); ?></a></li>
                    <?php
                endforeach;
            }
            ?>
        </ul>
    </div>
    <div class="category_box">
        <h3 class="line">Activities</h3>
        <ul class="icategory_box">
            <?php
            if (url::current() == '/activity/activities_list')
            {
                ?>
                <li class="on"><a style="color:#F66;" href="<?php echo LANGPATH; ?>/activity/activities_list">List</a></li>
                <?php
            }
            else
            {
                ?>
                <li><a href="<?php echo LANGPATH; ?>/activity/activities_list">List</a></li>
                <?php
            }
            ?>
        </ul>
    </div>-->
</aside>
