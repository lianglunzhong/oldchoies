<li class="winner_page">
                 <div class="pages ">
                <?php if ($previous_page !== FALSE): ?>
                        <a class="winner_page_down" href="<?php echo $page->url($previous_page); ?>">«</a> 
                <?php endif; ?>
                <?php
                if ($total_pages < 8)
                {
                        for ($i = 1;
                                $i <= $total_pages;
                                $i++)
                        {
                                if ($i != $current_page)
                                {
                                        echo '<a href="' . $page->url($i) . '" rel="nofollow" class="winner_page_down">' . $i . '</a>';
                                }
                                else
                                {
                                        echo '<span class="current">' . $i . '</span>';
                                }
                        }
                }
                elseif ($current_page < 4)
                {
                        for ($i = 1;
                                $i <= 5;
                                $i++)
                        {
                                if ($i != $current_page)
                                {
                                        echo '<a href="' . $page->url($i) . '" rel="nofollow" class="winner_page_down">' . $i . '</a>';
                                }
                                else
                                {
                                        echo '<span class="current">' . $i . '</span>';
                                }
                        }
                        echo '<span>&hellip;</span>';
                        echo '<a href="' . $page->url($total_pages - 1) . '" rel="nofollow" class="winner_page_down">' . ($total_pages - 1) . '</a>';
                        echo '<a href="' . $page->url($total_pages) . '" rel="nofollow" class="winner_page_down">' . $total_pages . '</a>';
                }
                elseif ($current_page > $total_pages - 4)
                {
                        echo '<a href="' . $page->url(1) . '" rel="nofollow" class="winner_page_down">1</a>';
                        echo '<a href="' . $page->url(2) . '" rel="nofollow" class="winner_page_down">2</a>';
                        echo '<span>&hellip;</span>';
                        for ($i = $total_pages - 3;
                                $i <= $total_pages;
                                $i++)
                        {
                                if ($i != $current_page)
                                {
                                        echo '<a href="' . $page->url($i) . '" rel="nofollow" class="winner_page_down">' . $i . '</a>';
                                }
                                else
                                {
                                        echo '<span class="current">' . $i . '</span>';
                                }
                        }
                }
                else
                {
                        echo '<a href="' . $page->url(1) . '" rel="nofollow" class="winner_page_down">1</a>';
                        echo '<span>&hellip;</span>';
                        for ($i = $current_page - 1;
                                $i <= $current_page + 1;
                                $i++)
                        {
                                if ($i != $current_page)
                                {
                                        echo '<a href="' . $page->url($i) . '" rel="nofollow" class="winner_page_down">' . $i . '</a>';
                                }
                                else
                                {
                                        echo '<span class="current">' . $i . '</span>';
                                }
                        }
                        echo '<span>&hellip;</span>';
                        echo '<a href="' . $page->url($total_pages - 1) . '" rel="nofollow" class="winner_page_down">' . ($total_pages - 1) . '</a>';
                        echo '<a href="' . $page->url($total_pages) . '" rel="nofollow" class="winner_page_down">' . $total_pages . '</a>';
                }
                ?>
                <?php if ($next_page !== FALSE): ?>
                        <a class="winner_page_down" href="<?php echo $page->url($next_page); ?>">»</a>
                <?php endif; ?>
        </div>

</li>
