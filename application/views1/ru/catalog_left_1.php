<ul class="filter-bar cf">
    <?php
    $attributes = DB::select('id', 'label')->from('attributes')->where('id', '>', 3)->execute('slave');
    $attrArr = array();
    foreach($attributes as $attr)
    {
        $attrArr[$attr['label']] = $attr['id'];
    }
    $uri = Request::Instance()->uri;
    $language = Request::Instance()->param('language');
    if($language)
    {
        $uri = substr($uri, strpos($uri, '/') + 1);
    }
    $links = explode('/', $uri);
    if(!isset($links[3]))
        $links[3] = '';
    $catalog_link = $links[0];
    if (!isset($links[1]))
        $links[1] = 'all';
    if (!isset($links[2]))
        $links[2] = 'all';

    $keysorts = 'site_sort/'.$catalog_id;
    $cache = Cache::instance('memcache');
    if (!($sorts = $cache->get($keysorts)))
    {
    $sorts = DB::select('sort', 'attributes')
            ->from('catalog_sorts')
            ->where('catalog_id', '=', $catalog_id)
            ->order_by('sort')
            ->execute('slave')->as_array();
        $cache->set($keysorts, $sorts, 1800);
    }
    $parent_id = DB::select('parent_id')->from('products_category')->where('id', '=', $catalog_id)->execute('slave')->get('parent_id');
    if (empty($sorts))
    {
        $sorts = DB::select('sort', 'attributes')
                ->from('catalog_sorts')
                ->where('catalog_id', '=', $parent_id)
                ->order_by('sort')
                ->execute('slave')->as_array();
    }
    $filters = array();
    if (isset($links[3]))
    {
        $filter = explode('__', $links[3]);
        foreach ($filter as $f)
        {
            $fil = explode('_', $f);
            if (isset($fil[1]))
            {
                $filters[str_replace('-', ' ', $fil[0])] = str_replace('-', ' ', $fil[1]);
            }
        }
    }
    $limit_link = '';
    $gets = array();
    foreach ($_GET as $name => $val)
    {
        if ($name == 'limit')
            $gets[] = 'limit=' . $val;
        if ($name == 'pick')
            $gets[] = 'pick=' . $val;
        if ($name == 'sort')
            $gets[] = 'sort=' . $val;
    }
    if (!empty($gets))
        $limit_link = '?' . implode('&', $gets);

    $colors = '';
    foreach ($sorts as $key => $sort)
    {
        if ($sort['sort'] == 'Color')
        {
            $colors = $sort['attributes'];
            unset($sort[$key]);
            break;
        }
    }

    $children = array();
    $childrens = array();

    if ($catalog_id == 92 OR $parent_id == 92)
    {
        $childrens = array(
            array('Платья', LANGPATH . '/dresses-c-92'),
            array('Длинные платья', LANGPATH . '/maxi-dresses-c-207'),
            array('Кружевные платья', LANGPATH . '/lace-dresses-c-209'),
            array('Облегающие платья', LANGPATH . '/bodycon-dresses-c-211'),
            array('Платья С Открытым Плечом', LANGPATH . '/off-the-shoulder-dresses-c-504'),
            array('Чёрные платья', LANGPATH . '/black-dresses-c-203'),
            array('Белые платья', LANGPATH . '/white-dresses-c-204'),                           
            array('Платья С Открытой Спиной', LANGPATH . '/backless-dress-c-456'),
            array('Вечернее Платье', LANGPATH . '/party-dresses-c-205'),
        );
    }
    else
    {
        $children = array();
        $children = DB::select('id', 'name', 'link')->from('catalogs_' . LANGUAGE)
                ->where('site_id', '=', 1)
                ->where('visibility', '=', 1)
                ->where('on_menu', '=', 1)
                ->where('parent_id', '=', $catalog_id)
                ->order_by('position', 'desc')
                ->execute()->as_array();
        if (empty($children))
        {
            if ($parent_id == 0)
            {
                $children[] = array(
                    'id' => $catalog_id,
                    'name' => Catalog::instance($catalog_id, LANGUAGE)->get('name'),
                    'link' => Catalog::instance($catalog_id, LANGUAGE)->get('link')
                );
            }
            else
            {
                $children = DB::select('id', 'name', 'link')->from('catalogs_' . LANGUAGE)
                        ->where('site_id', '=', 1)
                        ->where('visibility', '=', 1)
                        ->where('on_menu', '=', 1)
                        ->where('parent_id', '=', $parent_id)
                        ->order_by('position', 'desc')
                        ->execute()->as_array();
                $parent[] = array(
                    'id' => $parent_id,
                    'name' => Catalog::instance($parent_id, LANGUAGE)->get('name'),
                    'link' => Catalog::instance($parent_id, LANGUAGE)->get('link')
                );
                $children = array_merge($parent, $children);
            }
        }
        else
        {
            $parent[] = array(
                'id' => $catalog_id,
                'name' => Catalog::instance($catalog_id, LANGUAGE)->get('name'),
                'link' => Catalog::instance($catalog_id, LANGUAGE)->get('link')
            );
            $children = array_merge($parent, $children);
        }
    }
    $scroll = 1;
    ?>
    <li class="fll mt5"><div>Сортировка по:&nbsp;</div></li>
    <li class="item-l drop-down JS-show">
        <div class="drop-down-hd">
            <?php
            $ens = array("Default","What's New", 'Best Seller', 'Price: Low To High', 'Price: High To Low');
            $trns = array('выбрать','Новинки', 'популярности', 'цене по возрастанию','цене по убыванию');
            if(isset($_GET['sort']))
            {
                $sname = str_replace($ens, $trns, $sort_by[$_GET['sort']]['name']);
                echo $sname;
            }
            else
            {
                echo 'выбрать'; 
            }
            ?>
            <i class="fa fa-angle-down"></i>
        </div>
        <ul class="drop-down-list JS-showcon hide" style="display:none; width:180%;">
        <?php
        foreach ($sort_by as $key => $sort)
        {
            $sname = str_replace($ens, $trns, $sort['name']);
            $link = empty($gets1) ? '' : '?' . implode('&', $gets1);
            if($link == "")
            {
                $tolink = $link . '?sort=' . $key;
            }
            else
            {
                $tolink = $link . '&sort=' . $key;
            }
            ?>
            <li class="drop-down-option">
                <a href="<?php echo LANGPATH . '/' . $uri . $tolink; ?>"><?php echo $sname; ?></a>
            </li>
            <?php
        }
        ?>
        </ul>
    </li>
    <li class="item-l pick">
        <?php
        $gets1 = $gets;
        if (!empty($gets1))
        {
            $has = 0;
            foreach ($gets1 as $key => $get)
            {
                if (strpos($get, 'pick') !== FALSE)
                {
                    $has = 1;
                    $gets1[$key] = 'pick=1';
                    break;
                }
            }
            if (!$has)
                $gets1[] = 'pick=1';
        }
        else
            $gets1[] = 'pick=1';
        ?>
        <a href="<?php echo LANGPATH . '/' . $uri . '?' . implode('&', $gets1); ?>" class=""> <i class="myaccount"></i> Выбор звёзд</a>
    </li>
    <li class="item-r drop-down JS-show">
        <div class="drop-down-hd">
             Цвет <i class="fa fa-angle-down"></i>
        </div>
        <ul class="choice-color drop-down-list JS-showcon hide" id="color_ul" style="display:none; width:218%; left:-38px;padding-bottom:50px;">
        </ul>
    </li>

    <li class="item-r drop-down JS-show">
        <div class="drop-down-hd">
              Цена  <i class="fa fa-angle-down"></i>
        </div>
        <ul class="drop-down-list JS-showcon hide" id="price_ul" style="display:none; width:180%;">
        </ul>
    </li>
<?php
if(count($children) > 1 OR count($childrens) > 1)
{
?>
    <li class="item-r drop-down JS-show">
        <div class="drop-down-hd">
            Категория  <i class="fa fa-angle-down"></i>
        </div>
        <ul class="drop-down-list JS-showcon hide" id="catalog_ul" style="display:none;width: 180%;">
        </ul>
    </li>
<?php
}
?>
<?php
if(!empty($size_filter))
{
    ?>
    <li class="item-r drop-down JS-show">
        <div class="drop-down-hd">
            Pазмер  <i class="fa fa-angle-down"></i>
        </div>
        <ul class="drop-down-list JS-showcon hide" id="size_ul" style="width:100px;display:none;">
        </ul>
    </li>
    <?php
}
?>
    <li class="item-r filter-all drop-down" id="JS_filterAll">
        <?php if(!empty($sorts)): ?>
        <div class="drop-down-hd JS-filterAll">
            <a class="btn btn-default btn-xs">Все Виды</a>
        </div>
        <?php endif; ?>
        <ul class="drop-down-list JS-toggle-box filterall" style="width: 580px; left: -342px; top: 28px; display: none;">
            <div class="JS-filterClose fa-2x flr mr5 mt5"><i class="close-btn3"></i></div>
            <div class="clearfix"></div>
            <div class="filter-list flr">
                <!-- category    -->
                <?php
                $phone_childrens = array();
                if(count($children) > 1 OR count($childrens) > 1)
                {
                ?>
                    <li class="item choice JS-show">
                        <div class="choice-hd">
                          Категория <i class="fa fa-chevron-down"></i>
                        </div>
                        <ul class="choice-list JS-showcon hide" id="catalog_choice" style="display:none;">
                            <?php
                            if ($catalog_id == 92 OR $parent_id == 92)
                            {
                                $url = '/' . $uri;
                                foreach ($childrens as $key => $c)
                                {
                                    $on = 0;
                                    if ($url == $c[1])
                                        $on = 1;
                                     $phone_childrens[] = array('name' => $c[0], 'link' => $c[1], 'on' => $on);
                                    ?>
                                    <li class="drop-down-option">
                                        <a href="<?php echo  $c[1]; ?>">
                                            <?php echo $c[0]; ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            else
                            {
                                foreach ($children as $catalog)
                                {
                                    $on = 0;
                                    if ($catalog['id'] == $catalog_id)
                                        $on = 1;
                                    $clink = LANGPATH . '/' . $catalog['link'] . '-c-' . $catalog['id'] . '/' . $links[1] . '/' . $links[2] . '/' . $links[3];
                                    $phone_childrens[] = array('name' => ucfirst($catalog['name']), 'link' => $clink, 'on' => $on);
                                    ?>
                                    <li class="drop-down-option">
                                        <a href="<?php echo $clink ; ?>">
                                            <?php echo ucfirst($catalog['name']); ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </li>

                <?php
                }
                ?>

                <!-- Size -->
                <?php
                $phone_sizes = array();
                if(!empty($size_filter))
                {
                    ?>
                    <li class="item choice JS-show">
                        <div class="choice-hd">
                             Pазмер <i class="fa fa-chevron-down"></i>
                        </div>
                        <ul class="choice-list JS-showcon" style="display:none;" id="size_choice">
                        <?php
                        foreach ($size_filter as $size => $sname)
                        {
                            $on = 0;
                            if($links[1] == $size)
                                $on = 1;
                            if($on)
                                $flink = LANGPATH . '/' . $catalog_link . '/all/' . $links[2] . '/' . $links[3] . $limit_link;
                            else
                                $flink = LANGPATH . '/' . $catalog_link . '/' . $size . '/' . $links[2] . '/' . $links[3] . $limit_link;
                            $phone_sizes[] = array('name' => $sname, 'link' => $flink);
                        ?>
                            <li class="drop-down-option">
                                <a href="<?php echo $flink; ?>">
                                    <input class="filter_checkbox" type="checkbox" attr-value="<?php echo $flink; ?>" <?php if($on) echo 'checked="checked"'; ?>>
                                    <?php
                                    echo $sname;
                                    ?>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        </ul>
                    </li>
                    <?php
                }
                ?>

                <!-- Color -->
                <li class="item choice JS-show">
                    <div class="choice-hd">
                    Цвет  <i class="fa fa-chevron-down"></i>
                    </div>
                    <ul class="choice-color drop-down-list JS-showcon hide" style="display:none; width:135%; padding-bottom:50px;" id="color_choice">
                    <?php
        $result = DB::query(Database::SELECT, 'SELECT attribute_id, ' . LANGUAGE . ' AS name FROM attributes_small WHERE attribute_id >= 5')->execute();
        $attributes_small = array();
        foreach($result as $a)
        {
            $attributes_small[$a['attribute_id']] = $a['name'];
        }
                    $phone_colors = array();
                    $current_color = isset($filters['color']) ? $filters['color'] : '';
                    $href1 = '/' . $links[0] . '/' . $links[1] . '/' . $links[2] . '/';
                    if ($colors)
                    {
                        $colorArr = explode(',', $colors);
                        foreach ($colorArr as $color)
                        {
                            $href2 = array();
                            $do_filters = $filters;
                            $color = strtolower($color);
                            $do_filters['color'] = $color;
                            foreach ($do_filters as $name => $val)
                            {
                                if(isset($attrArr[$val]))
                                    $val = $attrArr[$val];
                                $href2[] = str_replace(' ', '-', $name) . '_' . str_replace(' ', '-', $val);
                            }
                            $color_name = $color;
                            if(isset($attrArr[$color]))
                            {
                                if(isset($attributes_small[$attrArr[$color]]))
                                    $color_name = $attributes_small[$attrArr[$color]];
                            }
                            $color_link = LANGPATH . $href1 . implode('__', $href2) . $limit_link;
                            $on = ($val == $current_color) ? 1 : 0;
                            $phone_colors[] = array('name' => strtolower($color_name), 'value' => strtolower($color), 'link' => $color_link, 'on' => $on);
                            ?>
                            <li class="drop-down-option <?php if($on) echo 'on'; ?>">
                                <?php if($val == $current_color) echo '<em></em>'; ?>
                                <a href="<?php echo $color_link; ?>" title="<?php echo ucfirst($color_name); ?>">
                                    <span class="icon color-cate-<?php echo strtolower($color); ?>"></span>
                                </a>
                            </li>
                            <?php
                        }
                                   
                    }
                    else
                    {
                        $filtercolors = Kohana::config('filter.colors');
                        foreach ($filtercolors as $color)
                        {
                            $do_filters = $filters;
                            $color = strtolower($color);
                            $do_filters['color'] = $color;
                            $href2 = array();
                            foreach ($do_filters as $name => $val)
                            {
                                $val = str_replace(' ', '-', $val);
                                if(isset($attrArr[$val]))
                                    $val = $attrArr[$val];
                                $href2[] = str_replace(' ', '-', $name) . '_' . str_replace(' ', '-', $val);
                            }
                            $color_name = $color;
                            if(isset($attrArr[$color]))
                            {
                                if(isset($attributes_small[$attrArr[$color]]))
                                    $color_name = $attributes_small[$attrArr[$color]];
                            }
                            $color_link = LANGPATH . $href1 . implode('__', $href2) . $limit_link;
                            $on = ($val == $current_color) ? 1 : 0;
                            $phone_colors[] = array('name' => strtolower($color_name), 'value' => strtolower($color), 'link' => $color_link, 'on' => $on);
                            ?>
                            <li class="drop-down-option <?php if($on) echo 'on'; ?>">
                                <?php if($val == $current_color) echo '<em></em>'; ?>
                                <a href="<?php echo $color_link; ?>" title="<?php echo ucfirst($color_name); ?>">
                                    <span class="icon color-cate-<?php echo strtolower($color); ?>"></span>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                    }
                    ?>
                    </ul>
                </li>
                <!-- Price -->
                <li class="item choice JS-show">
                    <div class="choice-hd">
                        Цена <i class="fa fa-chevron-down"></i>
                    </div>
                    <ul class="choice-list JS-showcon" style="display:none;" id="price_choice">
                    <?php
                    $phone_prices = array();
                    $pricenow = array(-1,-1);
                    if($links[2] != 'all')
                        $pricenow = explode('-', $links[2]);
                    foreach ($pricerang as $key => $c)
                    {
                        $pricefrom = ($key - 1) * 20;
                        if($pricefrom == 1)
                            $pricefrom = 0;
                        $priceto = $key * 20;
                        if($priceto > 120)
                            $priceto = 1000;
                        $on = 0;
                        if($pricenow[0] == $pricefrom AND $pricenow[1] == $priceto)
                            $on = 1;
                        if($on)
                            $flink = LANGPATH . '/' . $catalog_link . '/' . $links[1] . '/all/' . $links[3] . $limit_link;
                        else
                            $flink = LANGPATH . '/' . $catalog_link . '/' . $links[1] . '/' . $pricefrom . '-' . $priceto . '/' . $links[3] . $limit_link;
                        
                        if($priceto == 1000)
                            $pname = Site::instance()->price($pricefrom, 'code_view',null,null,2,0) . ' + ';
                        else
                            $pname = Site::instance()->price($pricefrom, 'code_view',null,null,2,0) . ' - ' . Site::instance()->price($priceto, 'code_view',null,null,2,0); 
                        
                        $phone_prices[] = array('name' => $pname, 'link' => $flink, 'on' => $on);
                    ?>
                        <li class="drop-down-option">
                            <a href="<?php echo $flink; ?>">
                                <input class="filter_checkbox" type="checkbox" name="" attr-value="<?php echo $flink; ?>" <?php if($on) echo 'checked="checked"'; ?>>
                                <?php echo $pname; ?>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    </ul>
                </li>

                <?php
                $filter_images = Kohana::config('filter.images');
                $all_f_images = array();
                $c_f_images = array();
                if (isset($filter_images['all']))
                    $all_f_images = $filter_images['all'];
                $catalog_name = strtolower(Catalog::instance($catalog_id)->get('link'));
                if (isset($filter_images[$catalog_name]))
                    $c_f_images = $filter_images[$catalog_name];
                else
                {
                    $catalog_name = strtolower(Catalog::instance($parent_id)->get('link'));
                    if (isset($filter_images[$catalog_name]))
                        $c_f_images = $filter_images[$catalog_name];
                }
                $current_filters = $filters;
                if (!empty($sorts))
                {
                    $sorts_show = array();
                    foreach ($sorts as $sort)
                    {
                        if ($sort['sort'] == 'Color')
                            continue;
                        $attributes = explode(',', $sort['attributes']);
                        foreach ($attributes as $attr)
                        {
                            $attr = strtolower($attr);
                            $sorts_show[trim($sort['sort'])][] = $attr;
                        }
                    }
        $en_sorts = Kohana::config('sorts.en');
        $small_sorts = Kohana::config('sorts.' . LANGUAGE);
                    foreach ($sorts_show as $sort_name => $attributes)
                    {
                    ?>
                        <!-- DETAIL -->
                        <li class="item choice JS-show">
                            <div class="choice-hd">
                                <?php                   
                              $show_sort_name = $sort_name;
                                $sort_key = array_keys($en_sorts, strtolower($sort_name));
                                if(!empty($sort_key))
                                {
                                    $show_sort_name = $small_sorts[$sort_key[0]];
                                }
                                echo ucfirst($show_sort_name);
                                ?> <i class="fa fa-chevron-down"></i>
                            </div>
                            <?php
                            $f_image = '';
                            if (in_array(strtolower($sort_name), $all_f_images))
                                $f_image = '/assets/images/filter/all/' . str_replace(' ', '-', strtolower($sort_name));
                            elseif (in_array(strtolower($sort_name), $c_f_images))
                                $f_image = '/assets/images/filter/' . $catalog_name . '/' . str_replace(' ', '-', strtolower($sort_name));
                            ?>
                            <ul class="choice-list <?php if($f_image) echo 'choice-list-img choice-list-col choice-color'; ?> JS-showcon" style="display:none;">
                            <?php
                            if (isset($current_filters[$sort_name]))
                            {
                    $keys = array_keys($attrArr, $current_filters[$sort_name]);
                    $current_name = !empty($keys) ? $keys[0] : $current_filters[$sort_name];
                    $attrs = str_replace(' ', '-', strtolower($current_name));
                    $attr_id = isset($attrArr[$attrs]) ? $attrArr[$attrs] : 0;
                    if(isset($attributes_small[$attr_id]))
                        $current_name = $attributes_small[$attr_id];
                    $do_filters = $filters;
                    if (isset($do_filters[ucfirst($sort_name)]))
                        unset($do_filters[ucfirst($sort_name)]);
                    $href2 = array();
                                foreach ($do_filters as $name => $val)
                                {
                                    if(isset($attrArr[$val]))
                                        $val = $attrArr[$val];
                                    $href2[] = str_replace(' ', '-', $name) . '_' . str_replace(' ', '-', $val);
                                }
                                $l = LANGPATH . $href1 . implode('__', $href2) . $limit_link;
                                if($f_image)
                                {
                                     $cdn = STATICURL;
                                ?>
                                <li class="drop-down-option">
                                    <a href="<?php echo $l; ?>">
                                        <?php echo '<img src="' . $cdn.$f_image . '/' . str_replace(' ', '-', strtolower($current_name)) . '.png" title="' . ucfirst($current_name) . '" alt="' . ucfirst($current_name) . '" />'; ?>
                                    </a>
                                </li>
                                <li class="choice-close">
                                    <a href="<?php echo $l; ?>"><i class="fa fa-times-circle fa-lg"></i></a>
                                </li>
                                <?php
                                }
                                else
                                {
                                    ?>
                                    <li class="drop-down-option">
                                    <a href="<?php echo $l; ?>">
                                        <?php echo ucfirst($current_name); ?>
                                        <i class="fa fa-times-circle fa-lg"></i>
                                    </a>
                                    </li>
                                <?php
                                }
                            }
                            else
                            {
                                $c_filters = $filters;
                                foreach ($attributes as $attr)
                                {
                                    $c_filters[$sort_name] = str_replace(' ', '-', strtolower($attr));
                                    $href2 = array();
                                    foreach ($c_filters as $name => $val)
                                    {
                                        $val = str_replace(' ', '-', $val);
                                        if(isset($attrArr[$val]))
                                            $val = $attrArr[$val];
                                        $href2[] = str_replace(' ', '-', $name) . '_' . $val;
                                    }
                                    ?>
                                    <li class="drop-down-option">
                                        <a href="<?php echo LANGPATH . $href1 . implode('__', $href2) . $limit_link; ?>">
                                            <?php
                                            if ($f_image)
                                            {
                                                 $cdn = STATICURL;
                                                echo '<img src="' . $cdn.$f_image . '/' . str_replace(' ', '-', strtolower($attr)) . '.png" title="' . ucfirst($attr) . '" alt="' . ucfirst($attr) . '" />';
                                            }else{
                                              $attrs = str_replace(' ', '-', strtolower($attr));
                                                $attr_id = isset($attrArr[$attrs]) ? $attrArr[$attrs] : 0;
                                                if(isset($attributes_small[$attr_id]))
                                                    $attr = $attributes_small[$attr_id];
                                                echo ucfirst($attr);
                                            }
                                            ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                            </ul>
                        </li>
                    <?php
                    }
                }
                ?>
            </div>
        </ul>
    </li>
</ul>

<script type="text/javascript">
    $(function(){
        $("#color_ul").html($("#color_choice").html());
        $("#price_ul").html($("#price_choice").html());
        $("#catalog_ul").html($("#catalog_choice").html());
        $("#size_ul").html($("#size_choice").html());

        $(".filter_checkbox").live('click', function(){
            var link = $(this).attr('attr-value');
            location.href = link;
        })
    })
</script>

<div class="category-sidebar sidebar">
    <div class="category-sidebar-container">
    <?php
    if(!empty($phone_childrens))
    {
    ?>
        <div class="clearfix">
            <h3 class="page-header JS-toggle">
                <span><?php echo Catalog::instance($catalog_id, LANGUAGE)->get('name'); ?></span>
                <i class="fa fa-caret-down"></i>
            </h3>
            <div class="category-filter sidebar-nav JS-toggle-box hide" style="overflow: hidden; display: none;">
                <div class="category-nav-section">
                    <ul class="unstyled mb10">
                    <?php
                    foreach($phone_childrens as $key => $pcatalog)
                    {
                        if($key == 0)
                        {
                            $view_all = $pcatalog;
                            continue;
                        }
                    ?>
                        <li><a href="<?php echo $pcatalog['link']; ?>"><?php echo $pcatalog['name']; ?></a></li>
                    <?php
                    }
                    ?>
                    </ul>
                    <div class="mb10"><a href="<?php echo $view_all['link']; ?>">All <?php echo $view_all['name']; ?></a></div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
        <div class="sidebar-nav ">
            <h5 class="sort-nav-toggle JS-toggle">
                <span><b class="visible-phone">СОРТИРОВКА И </b> УТОЧНИТЬ<i class="fa fa-caret-down"></i></span>
            </h5>
            <div class="sort-nav-section JS-toggle-box hide" style="overflow: hidden; display: none;">
                <div class="accordion">
                <?php
                if(!empty($phone_sizes))
                {
                ?>
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">Size<i class="fa fa-caret-down flr"></i></a>
                        </div>
                        <div class="accordion-body JS-toggle-box hide">
                            <div class="accordion-inner">
                                <ul class="choice-color">
                                <?php
                                foreach($phone_sizes as $psize)
                                {
                                ?>
                                    <li class="selector">
                                        <a href="<?php echo $psize['link']; ?>"><?php echo $psize['name']; ?></a>
                                    </li>
                                <?php
                                }
                                ?>  
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                <?php
                if(!empty($phone_prices))
                {
                ?>
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">ЦЕНА<i class="fa fa-caret-down flr"></i></a>
                        </div>
                        <div class="accordion-body JS-toggle-box hide">
                            <div class="accordion-inner">
                                <ul class="unstyled">
                                <?php
                                foreach($phone_prices as $pprice)
                                {
                                ?>
                                    <li class="selector" >
                                        <a href="<?php echo $pprice['link']; ?>"><?php echo $pprice['name']; ?></a>
                                    </li>
                                <?php
                                }
                                ?>  
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                <?php
                if(!empty($phone_colors))
                {
                ?>
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">ЦВЕТ<i class="fa fa-caret-down flr"></i></a>
                        </div>
                        <div class="accordion-body JS-toggle-box hide">
                            <div class="accordion-inner">
                                <ul class="choice-color">
                                <?php
                                foreach($phone_colors as $pcolor)
                                {
                                ?>
                                    <li>
                                        <a href="<?php echo $pcolor['link']; ?>" title="<?php echo ucfirst($pcolor['name']); ?>">
                                            <span class="icon color-cate-<?php echo $pcolor['value']; ?>"></span>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$limit_link = '';
if (!empty($gets))
    $limit_link = '?' . implode('&', $gets);
$uri = '/' . $uri;
$uris = explode('/', $uri);
unset($custom_filter['sql']);
$array = array('', 'all', 'new');
$has_size = (isset($links[1]) AND !in_array($links[1], $array)) ? 1 : 0;
if (!empty($custom_filter['filter_attirbutes']) OR !empty($custom_filter['price_range']) OR $has_size):
    ?>
    <div class="filter-selected">
        <?php
        if($has_size)
        {
            $size_filter;
            $href = LANGPATH . $uris[0] . '/' . $uris[1] . '/all/' . $uris[3];
            if (isset($uris[4]))
                $href .= '/' . $uris[4];
            ?>
            <span class="item">
                <a href="<?php echo $href . $limit_link; ?>"><i class="fa fa-times-circle fa-lg"></i><?php echo 'Size:'.$size_filter[$links[1]]; ?></a>
            </span>
            <?php
        }
        if (isset($custom_filter['price_range']))
        {
            $href = LANGPATH . $uris[0] . '/' . $uris[1] . '/' . $uris[2] . '/all';
            if (isset($uris[4]))
                $href .= '/' . $uris[4];
            ?>
            <span class="item">
                <a href="<?php echo $href . $limit_link; ?>"><i class="fa fa-times-circle fa-lg"></i><?php echo 'Price:$' . $custom_filter['price_range'][0] . ' ~ $' . $custom_filter['price_range'][1]; ?></a>
            </span>
            <?php
        }
        if (isset($custom_filter['filter_attirbutes']))
        {
            foreach ($custom_filter['filter_attirbutes'] as $filter)
            {
                $href = LANGPATH . $uris[0] . '/' . $uris[1] . '/' . $uris[2] . '/' . $uris[3];
                $filterArr = explode('__', $now_filters);
                foreach ($filterArr as $key => $f)
                {
                    $fil = str_replace(' ', '-', $filter);
                    if (strpos($f, $fil) != FALSE)
                        unset($filterArr[$key]);
                }
                 if(isset($attributes_small[$filter]))
                    $filterName = $attributes_small[$filter];
                else
                    $filterName = DB::select(LANGUAGE)->from('attributes_small')->where('id', '=', $filter)->execute()->get('name');
                $href .= '/' . implode('__', $filterArr);
                ?>
                <span class="item">
                    <a href="<?php echo $href . $limit_link; ?>"><i class="fa fa-times-circle fa-lg"></i><?php echo ucfirst($filterName); ?></a>
                </span>
                <?php
            }
        }
        ?>
        <span class="item">
            <a href="<?php echo LANGPATH . $uris[0] . '/' . $uris[1]; ?>"><span class="clearall">Очистить Все</span></a>
        </span>
    </div>
    <?php
endif;
?>