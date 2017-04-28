<section id="main">
  <!-- crumbs -->
  <div class="layout">
    <div class="crumbs fix">
      <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  <?php echo $doc['name']; ?></div>
    </div>
  </div>
  
  <!-- main begin -->
  <section class="layout fix">
    <article id="container" class="user doc flr">
	  <div class="tit"><h2><?php echo $doc['name']; ?></h2></div>
      <div class="doc_box">
      <?php echo $doc['content']; ?>  
      </div>
    </article>
    <?php echo View::factory(LANGPATH . '/doc/left'); ?>
  </section>
</section>