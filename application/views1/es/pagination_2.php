<?php if($total_items > 0): ?>
<ul class="pagination" style="margin-top:5px;">

<!--    <li><span class="n_border">Resultados:<span><?php //echo $total_items; ?></span></span></li>-->
    <?php if ($previous_page !== FALSE): ?>
        <li><a href="<?php echo $page->url($previous_page); ?>" class="prev_btn1"  title="<?php echo $previous_page; ?>">«</a></li>
    <?php endif; ?>
    <?php
    if ($total_pages < 8)
    {
        for ($i = 1; $i <= $total_pages; $i++)
        {
            if ($i != $current_page)
            {
                echo '<li><a href="' . $page->url($i) . '"  title="' . $i . '">' . $i . '</a></li>';
            }
            else
            {
                echo '<li class="active"><a title="' . $i . '">' . $i . '</a></li>';
            }
        }
    }
    elseif ($current_page < 4)
    {
        for ($i = 1; $i <= 5; $i++)
        {
            if ($i != $current_page)
            {
                echo '<li><a href="' . $page->url($i) . '"  title="' . $i . '">' . $i . '</a></li>';
            }
            else
            {
                echo '<li class="active"><a title="' . $i . '">' . $i . '</a></li>';
            }
        }
        echo '<li><span>&nbsp;&hellip;</span></li>';
        echo '<li><a href="' . $page->url($total_pages - 1) . '"  title="' . ($total_pages - 1) . '">' . ($total_pages - 1) . '</a></li>';
        echo '<li><a href="' . $page->url($total_pages) . '"  title="' . $total_pages . '">' . $total_pages . '</a></li>';
    }
    elseif ($current_page > $total_pages - 4)
    {
            echo '<li><a href="' . $page->url(1) . '"  title="1">1</a></li>';
            echo '<li><a href="' . $page->url(2) . '"  title="2">2</a></li>';
            echo '<li><span>&nbsp;&hellip;</span></li>';
            for ($i = $total_pages - 5; $i <= $total_pages; $i++)
            {
                if ($i != $current_page)
                {
                    echo '<li><a href="' . $page->url($i) . '"  title="' . $i . '">' . $i . '</a></li>';
                }
                else
                {
                    echo '<li class="active"><a title="' . $i . '">' . $i . '</a></li>';
                }
            }
    }
    else
    {
            echo '<li><a href="' . $page->url(1) . '"  title="1">1</a></li>';
            echo '<li><a href="' . $page->url(2) . '"  title="2">2</a></li>';
            echo '<li><span>&nbsp;&hellip;</span></li>';
            for ($i = $current_page - 1; $i <= $current_page + 2; $i++)
            {
                if ($i != $current_page)
                {
                    echo '<li><a href="' . $page->url($i) . '"  title="' . $i . '">' . $i . '</a></li>';
                }
                else
                {
                    echo '<li class="active"><a title="' . $i . '">' . $i . '</a></li>';
                }
            }
            echo '<li><span>&nbsp;&hellip;</span></li>';
            echo '<li><a href="' . $page->url($total_pages - 1) . '"  title="' . $i . '">' . ($total_pages - 1) . '</a></li>';
            echo '<li><a href="' . $page->url($total_pages) . '"  title="' . $i . '">' . $total_pages . '</a></li>';
    }
    ?>
    <?php if ($next_page !== FALSE): ?>
        <li><a href="<?php echo $page->url($next_page); ?>" class="next_btn1"  title="<?php echo $next_page; ?>">SIGUIENTE »</a></li>
    <?php endif; ?>
</ul>
<?php endif; ?>
