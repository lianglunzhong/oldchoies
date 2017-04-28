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
    $scroll = 1;
    ?>        
<div class="list-main">
    <div class="loading hidden-xs hide"><img src="<?php echo STATICURL; ?>/assets/images/loading.gif"></div>
    <aside class="filter-left hidden-xs">
        <?php
        if(!$is_mobile)
        {
        ?>
        <div class="category-list">
            <div class="leftlist">
            <?php
            if(count($children) > 1 OR count($childrens) > 1)
            {
            ?>
                <p class="down "><span class="list-detail-title">Kategorie </span>
                    <a class="fa fa-angle-up JS_down"></a>
                </p>
                <ul class="menu JS_menu sub-menu" style="display: block; overflow: hidden;" id="catalog_ul">
                </ul>
            <?php
            }
            ?>
            <h3>REFINE BY:</h3>
            <ul class="bar-l" id="bar">
            </ul>
                <p class="down no-line"><span class="list-detail-title">Größe </span>
                    <a class="fa fa-angle-up JS_down"></a>
                </p>
                <ul class="menu JS_menu hide double" id="size_ul" style="display: block;">
                </ul>
                <p class="down "><span class="list-detail-title">Farbe </a></span>
                    <a class="fa fa-angle-up JS_down"></a>
                </p>
                <ul class="menu JS_menu hide double" id="color_ul" style="display: block;">
                </ul>
                <p class="down "><span class="list-detail-title">Preis </span>
                    <a class="fa fa-angle-up JS_down"></a>
                </p>
                <ul class="menu JS_menu hide" id="price_ul" style="display: block;">
            </ul>
        </div>
        <?php
        }
        ?>
    </aside>
    <div class="filter-right">
        <div class="filter-bar">

            <ul class="bar-r">
                <li class=" item-r pick">
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
                    <a href="<?php echo '?' . implode('&', $gets1); ?>" class="">Wahl der Berühmtheit</a>
                </li>
                <li class=" drop-down cs-show">
                    <span class="fll">Sortieren nach:&nbsp;</span>
                    <div class="drop-down-hd">
                        <?php
                        $ens = array("What's New", 'Best Seller', 'Price: Low To High', 'Price: High To Low');
                        $trns = array('Was ist NEU', 'Bestseller', 'Preis: Niedrig zu Hoch', 'Preis: Hoch zu Niedrig');
                        if(isset($_GET['sort']))
                        {
                            if(array_key_exists($_GET['sort'], $sort_by))
                            { 
                            $sname = str_replace($ens, $trns, $sort_by[$_GET['sort']]['name']);
                            echo $sname;
                            }
                        }
                        else
                        {
                            echo 'Default'; 
                        }
                          ?>
                        <i class="fa fa-angle-down"></i>
                    </div>
                    <ul class="drop-down-list cs-list" style=" width:110%;">
                        <?php
                        foreach($gets1 as $k => $g)
                        {
                            if (strpos($g, 'sort') !== FALSE || strpos($g, 'pick') !== FALSE)
                                unset($gets1[$k]);
                        }
                        foreach ($sort_by as $key => $sort)
                        {
                            $link = empty($gets1) ? '' : '?' . implode('&', $gets1);
                            if($link == "")
                            {
                                $tolink = $link . '?sort=' . $key;
                            }
                            else
                            {
                                $tolink = $link . '&sort=' . $key;
                            }
                            $sname = str_replace($ens, $trns, $sort['name']);
                            ?>
                            <li class="drop-down-option">
                                <a href="<?php echo $tolink; ?>"><?php echo $sname; ?></a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <div class="flr hidden-xs pagination_div"></div>
        </div>
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
                    <li class="item choice cs-show">
                        <div class="choice-hd">
                            Kategorie <i class="fa fa-chevron-down"></i>
                        </div>
                        <ul class="choice-list cs-list" id="catalog_choice">
                            <?php
                            if ($catalog_id == 92 OR $parent_id == 92)
                            {
                                $url = '/' . $uri;
                                foreach ($children as $key => $c)
                                {
                                    $on = 0;
                                    if ($c['id'] == $catalog_id)
                                        $on = 1;
                                    $phone_childrens[] = array('name' => $c['name'], 'link' => LANGPATH.'/'.$c['link'].'-c-'.$c['id'], 'on' => $on);
                                    ?>
                                    <li class="drop-down-option">
                                        <a href="<?php echo LANGPATH;?>/<?php echo $c['link'].'-c-'.$c['id']; ?>">
                                            <?php                                 
                                            if(isset($repla[$c['name']]))
                                            {
                                                $c['name'] = $repla[$c['name']];
                                            }
                                            echo $c['name']; ?>
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
                                            <?php 
                                            if(isset($repla[$catalog['name']]))
                                            {
                                                $catalog['name'] = $repla[$catalog['name']];
                                            }
                                            echo ucfirst($catalog['name']); ?>
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
            </div>
        </ul>


<script type="text/javascript">
    $(function(){
        $("#catalog_ul").html($("#catalog_choice").html());
        $(".filter_checkbox").live('click', function(){
            var link = $(this).attr('attr-value');
            location.href = link;
        })
    })
</script>

<?php
if($is_mobile)
{
?>
<div class="category-sidebar sidebar">
    <div class="category-sidebar-container">
        <div class="sidebar-nav ">
            <h5 class="sort-nav-toggle JS-toggle">
                <span><b class="visible-phone">SORTIEREN &amp;</b> FILTERN<i class="fa fa-caret-down"></i></span>
            </h5>
            <ul class="bar-l" id="bar"></ul>
            <div class="sort-nav-section JS-toggle-box hide" id="phone_filter" style="overflow: hidden; display: none;">
                <div class="accordion category-list">
                <?php
                if(!empty($phone_childrens))
                {
                ?>
                <div class="accordion-group visible-phone">
                    <div class="accordion-heading JS-toggle">
                    <a class="accordion-toggle " href="javascript:void(0);">Kategorie<i class="fa fa-caret-down flr"></i></a>
                    </div>
                    <div class="accordion-body JS-toggle-box hide">
                        <div class="accordion-inner">
                            <ul class="unstyled">
                                <?php
                                foreach($phone_childrens as $key => $pcatalog)
                                {
                                    if($key == 0)
                                    {
                                        $view_all = $pcatalog;
                                        continue;
                                    }
                                ?>
                                    <li class="selector" ><a href="<?php echo $pcatalog['link']; ?>">
                                        <?php                                             
                                        if(isset($repla[$pcatalog['name']]))
                                        {
                                            $pcatalog['name'] = $repla[$pcatalog['name']];
                                        }
                                        echo $pcatalog['name']; 
                                        ?></a></li>
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
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">Größe<i class="fa fa-caret-down flr"></i></a>
                        </div>
                        <div class="accordion-body JS-toggle-box hide">
                            <div class="accordion-inner">
                                <ul class="unstyled double" id="size_ul">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">Preis<i class="fa fa-caret-down flr"></i></a>
                        </div>
                        <div class="accordion-body JS-toggle-box hide">
                            <div class="accordion-inner">
                                <ul class="unstyled double" id="price_ul">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group visible-phone">
                        <div class="accordion-heading JS-toggle">
                            <a class="accordion-toggle " href="javascript:void(0);">Farbe<i class="fa fa-caret-down flr"></i></a>
                        </div>
                        <div class="accordion-body JS-toggle-box hide">
                            <div class="accordion-inner">
                                <ul class="unstyled double" id="color_ul">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>

<div id="bar1" class="hide">Alle Löschen</div>
