<?php if($total_items > 0): ?>
<ul class="pagination-mobile flr">
    <?php if ($previous_page !== FALSE): ?>
        <li class="first"><a href="<?php echo $page->get_url($previous_page); ?>" >‹ ANTERIOR</a></li>
    <?php endif; ?>
    <li>
        <span> <?php echo $current_page; ?> of <?php echo $total_pages ?></span>
    </li>
    <?php if ($next_page !== FALSE): ?>
        <li class="last"><a href="<?php echo $page->get_url($next_page); ?>" >SIGUIENTE ›</a></li>
    <?php endif; ?>
</ul>
<?php endif; ?>