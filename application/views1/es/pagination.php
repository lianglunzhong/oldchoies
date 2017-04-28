<?php if($total_items > 0): ?>
<ul class="pagination">
    <?php if ($previous_page !== FALSE): ?>
        <li><a href="<?php echo $page->get_url($previous_page); ?>" class="prev_btn1" >«</a></li>
    <?php endif; ?>
    <?php
    if ($total_pages < 8)
    {
        for ($i = 1; $i <= $total_pages; $i++)
        {
            if ($i != $current_page)
            {
                echo '<li><a href="' . $page->get_url($i) . '" >' . $i . '</a></li>';
            }
            else
            {
                echo '<li class="active"><a>' . $i . '</a></li>';
            }
        }
    }
    elseif ($current_page < 4)
    {
        for ($i = 1; $i <= 4; $i++)
        {
            if ($i != $current_page)
            {
                echo '<li><a href="' . $page->get_url($i) . '" >' . $i . '</a></li>';
            }
            else
            {
                echo '<li class="active"><a>' . $i . '</a></li>';
            }
        }
        echo '<li><span class="sl">&nbsp;&hellip;</span></li>';
        echo '<li><a href="' . $page->get_url($total_pages - 1) . '" >' . ($total_pages - 1) . '</a></li>';
        echo '<li><a href="' . $page->get_url($total_pages) . '" >' . $total_pages . '</a></li>';
    }
    elseif ($current_page > $total_pages - 4)
    {
        echo '<li><a href="' . $page->get_url(1) . '" >1</a></li>';
        echo '<li><a href="' . $page->get_url(2) . '" >2</a></li>';
        echo '<li><span class="sl">&nbsp;&hellip;</span></li>';
        for ($i = $total_pages - 5; $i <= $total_pages; $i++)
        {
            if ($i != $current_page)
            {
                echo '<li><a href="' . $page->get_url($i) . '" >' . $i . '</a></li>';
            }
            else
            {
                echo '<li class="active"><a>' . $i . '</a></li>';
            }
        }
    }
    else
    {
        echo '<li><a href="' . $page->get_url(1) . '" >1</a></li>';
        echo '<li><a href="' . $page->get_url(2) . '" >2</a></li>';
        echo '<li><span class="sl">&nbsp;&hellip;</span></li>';
        for ($i = $current_page - 1; $i <= $current_page + 2; $i++)
        {
            if ($i != $current_page)
            {
                echo '<li><a href="' . $page->get_url($i) . '" >' . $i . '</a></li>';
            }
            else
            {
                echo '<li class="active"><a>' . $i . '</a></li>';
            }
        }
        echo '<li><span class="sl">&nbsp;&hellip;</span></li>';
        echo '<li><a href="' . $page->get_url($total_pages - 1) . '" >' . ($total_pages - 1) . '</a></li>';
        echo '<li><a href="' . $page->get_url($total_pages) . '" >' . $total_pages . '</a></li>';
    }
    ?>
    <?php if ($next_page !== FALSE): ?>
        <li><a href="<?php echo $page->get_url($next_page); ?>" class="next_btn1" >SIGUIENTE »</a></li>
    <?php endif; ?>
    <?php if ($next_page == FALSE): ?>
        <li class="disabled"><a  class="next_btn1" >SIGUIENTE »</a></li>
    <?php endif; ?>
</ul>
<?php endif; ?>
