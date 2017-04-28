<div class="paginationBar">
<div class="pageChangerWrap">

	<?php if ($previous_page == FALSE){ ?>
<!--        <div class="pArrowLeft" style="float:left; width:50px; height:50px;"><a></a></div>-->
    <?php }else{ ?>
        <a href="<?php echo $page->url($previous_page); ?>" rel="nofollow">
        	<div class="pArrowLeft" style="float:left; width:50px; height:50px;"></div>
        </a>
    <?php } ?>
        
        <div class="pageNumbers"><span class="curPage"><?php echo $current_page; ?></span>Of<span class="maxPage"><?php echo $total_pages; ?></span></div>
        
   	<?php if ($next_page == FALSE){ ?>
<!--        <div class="pArrowRight" style="float:right; width:50px; height:50px;"><a></a></div>-->
    <?php }else{ ?>
	    <a href="<?php echo $page->url($next_page); ?>" rel="nofollow">
	    	<div class="pArrowRight" style="float:right; width:50px; height:50px;"></div>
	    </a>
    <?php } ?>
    
</div>
</div>       
        
        
