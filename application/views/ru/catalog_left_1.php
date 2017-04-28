<ul class="filter-bar cf">
    <?php
    $attributes = DB::select('id', 'label')->from('attributes')->where('id', '>', 3)->execute();
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
    $catalog_link = $links[0];
    if (!isset($links[1]))
        $links[1] = 'all';
    if (!isset($links[2]))
        $links[2] = 'all';
    $sorts = DB::select('sort', 'attributes')
            ->from('catalog_sorts')
            ->where('catalog_id', '=', $catalog_id)
            ->order_by('sort')
            ->execute()->as_array();
    $parent_id = DB::select('parent_id')->from('products_category')->where('id', '=', $catalog_id)->execute()->get('parent_id');
    if (empty($sorts))
    {
        $sorts = DB::select('sort', 'attributes')
                ->from('catalog_sorts')
                ->where('catalog_id', '=', $parent_id)
                ->order_by('sort')
                ->execute()->as_array();
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

    if ($catalog_id == 92 OR $parent_id == 92)
    {
        $childrens = array(
            array('Платья', LANGPATH . '/dresses-c-92'),
            array('Чёрные Платья', LANGPATH . '/dresses-c-92/all/all/color_8'),
            array('Кружевные Платья', LANGPATH . '/dresses-c-92/all/all/Detail_124'),
            array('Облегающие Платья', LANGPATH . '/dresses-c-92/all/all/Silhouette_62'),
            array('Макси Платья', LANGPATH . '/dresses-c-92/all/all/dresses-c-92-Length_73'),
            array('Скейт-Платья', LANGPATH . '/dresses-c-92/all/all/Silhouette_69'),
            array('Платья С Рисунком Цветов', LANGPATH . '/dresses-c-92/all/all/Pattern-Type_82'),
            array('Шифоновое Платья', LANGPATH . '/dresses-c-92/all/all/Material_19'),
            array('Платья С Длинным Рукавом', LANGPATH . '/dresses-c-92/all/all/Sleeve-Length_56'),
            array('Вечерние Платья', LANGPATH . '/dresses-c-92/all/all/Shop-Looks_35'),
            array('Homecoming Платья', LANGPATH . '/homecoming-dress-c-454'),
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
    <li style="float:left;margin-top: 5px;"><div>Сортировка по:&nbsp;</div></li>
    <li class="item-l choice" style="width:140px;">
        <div class="choice-hd">
            <?php
            $ens = array("What's New", 'Best Seller', 'Price: Low To High', 'Price: High To Low','Default');
            $trns = array('Новинки', 'популярности', 'цене по возрастанию', 'цене по убыванию','выбрать');
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
            <i class="fa fa-caret-down"></i>
        </div>
        <ul class="choice-list">
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
            <li class="choice-option">
                <a href="<?php echo $_SERVER['REDIRECT_URL'] . $tolink; ?>"><?php echo $sname; ?></a>
            </li>
            <?php
        }
        ?>
        </ul>
    </li>
    <li class="item-l pick" style="width:148px;">
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
        <a href="<?php echo $_SERVER['REDIRECT_URL'] . '?' . implode('&', $gets1); ?>" class=""> <i class="icon icon-pick"></i> Выбор звёзд</a>
    </li>
    <li class="item-r choice">
        <div class="choice-hd">
            Цвет <i class="fa fa-caret-down"></i>
        </div>
        <ul class="choice-list choice-list-col choice-color" id="color_ul">
        </ul>
    </li>

    <li class="item-r choice">
        <div class="choice-hd">
            Цена <i class="fa fa-caret-down"></i>
        </div>
        <ul class="choice-list" id="price_ul">
        </ul>
    </li>
<?php
if(count($children) > 1 OR count($childrens) > 1)
{
?>
    <li class="item-r choice">
        <div class="choice-hd">
            Категория <i class="fa fa-caret-down"></i>
        </div>
        <ul class="choice-list" id="catalog_ul">
        </ul>
    </li>
<?php
}
?>
<?php
if(!empty($size_filter))
{
    ?>
    <li class="item-r choice">
        <div class="choice-hd">
            Pазмер <i class="fa fa-caret-down"></i>
        </div>
        <ul class="choice-list" id="size_ul" style="width:100px;">
        </ul>
    </li>
    <?php
}
?>
    <li id="JS_filterAll" class="item-r filter-all">
        все Фильтры <i class="fa fa-caret-down"></i>
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

<div class="filter-list" style="display:none;">
    <!-- Категория    -->
    <?php
    if(count($children) > 1 OR count($childrens) > 1)
    {
    ?>
        <div class="item choice">
            <div class="choice-hd">
                Категория <i class="fa fa-chevron-down"></i>
            </div>
            <ul class="choice-list" id="catalog_choice">
                <li class="choice-line"></li>
                <?php
                if ($catalog_id == 92 OR $parent_id == 92)
                {
                    $url = '/' . $uri;
                    foreach ($childrens as $key => $c)
                    {
                        $on = 0;
                        if ($url == $c[1])
                            $on = 1;
                        ?>
                        <li class="choice-option">
                            <a href="<?php echo $c[1]; ?>">
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
                        ?>
                        <li class="choice-option">
                            <a href="<?php echo LANGPATH; ?>/<?php echo $catalog['link'] . '-c-' . $catalog['id'] . '/' . $links[1] . '/' . $links[2] . '/' . $links[3]; ?>">
                                <?php echo ucfirst($catalog['name']); ?>
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    <?php
    }
    ?>

    <!-- Size -->
    <?php
    if(!empty($size_filter))
    {
        ?>
        <div class="item choice">
            <div class="choice-hd">
                Pазмер <i class="fa fa-chevron-down"></i>
            </div>
            <ul class="choice-list" id="size_choice">
                <li class="choice-line"></li>
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
            ?>
                <li class="choice-option">
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
        </div>
        <?php
    }
    ?>
    <!-- Color -->
    <div class="item choice">
        <div class="choice-hd">
            Цвет <i class="fa fa-chevron-down"></i>
        </div>
        <ul class="choice-list choice-list-img choice-list-col choice-color" id="color_choice">
            <li class="choice-line"></li>
        <?php
        $result = DB::query(Database::SELECT, 'SELECT attribute_id, ' . LANGUAGE . ' AS name FROM attributes_small WHERE attribute_id >= 5')->execute();
        $attributes_small = array();
        foreach($result as $a)
        {
            $attributes_small[$a['attribute_id']] = $a['name'];
        }
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
                ?>
                <li class="choice-option <?php if($val == $current_color) echo 'on'; ?>">
                    <?php if($val == $current_color) echo '<em></em>'; ?>
                    <a href="<?php echo LANGPATH . $href1 . implode('__', $href2) . $limit_link; ?>" title="<?php echo ucfirst($color_name); ?>">
                        <span class="icon color_cate_<?php echo strtolower($color); ?>"></span>
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
                ?>
                <li class="choice-option <?php if($val == $current_color) echo 'on'; ?>">
                    <?php if($val == $current_color) echo '<em></em>'; ?>
                    <a href="<?php echo LANGPATH . $href1 . implode('__', $href2) . $limit_link; ?>" title="<?php echo ucfirst($color_name); ?>">
                        <span class="icon color_cate_<?php echo strtolower($color); ?>"></span>
                    </a>
                </li>
                <?php
            }
            ?>
            <?php
        }
        ?>
        </ul>
    </div>

    <!-- Price -->
    <div class="item choice">
        <div class="choice-hd">
            Цена <i class="fa fa-chevron-down"></i>
        </div>
        <ul class="choice-list" id="price_choice">
            <li class="choice-line"></li>
        <?php
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
        ?>
            <li class="choice-option">
                <a href="<?php echo $flink; ?>">
                    <input class="filter_checkbox" type="checkbox" name="" attr-value="<?php echo $flink; ?>" <?php if($on) echo 'checked="checked"'; ?>>
                    <?php
                    if($priceto == 1000)
                        echo Site::instance()->price($pricefrom, 'code_view',null,null,2,0) . ' + ';
                    else
                        echo Site::instance()->price($pricefrom, 'code_view',null,null,2,0) . ' - ' . Site::instance()->price($priceto, 'code_view',null,null,2,0); 
                    ?>
                </a>
            </li>
        <?php
        }
        ?>
        </ul>
    </div>

    <?php
    $filter_images = Kohana::config('filter.images');
    $all_f_images = array();
    $c_f_images = array();
    if (isset($filter_images['all']))
        $all_f_images = $filter_images['all'];
    $catalog_name = strtolower(Catalog::instance($catalog_id)->permalink());
    if (isset($filter_images[$catalog_name]))
        $c_f_images = $filter_images[$catalog_name];
    else
    {
        $catalog_name = strtolower(Catalog::instance($parent_id)->permalink());
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
            <div class="item choice">
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
                    $f_image = '/images/filter/all/' . str_replace(' ', '-', strtolower($sort_name));
                elseif (in_array(strtolower($sort_name), $c_f_images))
                    $f_image = '/images/filter/' . $catalog_name . '/' . str_replace(' ', '-', strtolower($sort_name));
                ?>
                <ul class="choice-list <?php if($f_image) echo 'choice-list-img choice-list-col'; ?>">
                    <li class="choice-line"></li>
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
                    ?>
                    <li class="choice-option">
                        <a href="<?php echo $l; ?>">
                            <?php echo '<img src="' . $f_image . '/' . str_replace(' ', '-', strtolower($current_name)) . '.png" title="' . ucfirst($current_name) . '" alt="' . ucfirst($current_name) . '" />'; ?>
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
                        <li class="choice-option">
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
                        <li class="choice-option">
                            <a href="<?php echo LANGPATH . $href1 . implode('__', $href2) . $limit_link; ?>">
                                <?php
                                if ($f_image)
                                {
                                    $attrs = str_replace(' ', '-', strtolower($attr));
                                    $attr_id = isset($attrArr[$attrs]) ? $attrArr[$attrs] : 0;
                                    if(isset($attributes_small[$attr_id]))
                                        $title = $attributes_small[$attr_id];
                                    echo '<img src="' . $f_image . '/' . str_replace(' ', '-', strtolower($attr)) . '.png" title="' . ucfirst($title) . '" alt="' . ucfirst($title) . '" />';
                                }
                                else
                                {
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
            </div>
        <?php
        }
    }
    ?>
    <span id="JS_filterClose" class="close">
        <i class="fa fa-times fa-2x"></i>
    </span> 
</div>

<?php
$limit_link = '';
if (!empty($gets))
    $limit_link = '?' . implode('&', $gets);
$uri = $_SERVER['REDIRECT_URL'];
$language = Request::Instance()->param('language');
if ($language)
{
    $uri = substr($uri, strpos($uri, $language, 0) + strlen($language));
}
$uris = explode('/', $uri);
unset($custom_filter['sql']);
$has_size = (isset($links[1]) AND $links[1] != 'all' AND $link[1] != 'new') ? 1 : 0;
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
                <a href="<?php echo $href . $limit_link; ?>"><i class="fa fa-times-circle fa-lg"></i><?php echo 'Pазмер:'.$size_filter[$links[1]]; ?></a>
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
                <a href="<?php echo $href . $limit_link; ?>"><i class="fa fa-times-circle fa-lg"></i><?php echo 'Цена:$' . $custom_filter['price_range'][0] . ' ~ $' . $custom_filter['price_range'][1]; ?></a>
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
