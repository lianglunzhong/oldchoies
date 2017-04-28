<section id="main">
  <!-- crumbs -->
  <div class="container">
    <div class="crumbs">
      <div><a href="<?php echo LANGPATH; ?>/">Accueil</a><a href="<?php echo LANGPATH; ?>/mobile-left" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > CENTRE D'AIDE</a>  >  <?php echo $doc['name']; ?></div>
    </div>
  </div>
  
  <!-- main begin -->
<div class="container">
        <div class="row">
            <?php echo View::factory(LANGPATH . '/doc/left'); ?>
  <article class="user col-sm-9 col-xs-12">
    <div class="tit"><h2><?php echo $doc['name']; ?></h2></div>
      <div class="doc-box">
      <?php echo $doc['content']; ?>  
      </div>
    </article>
    </div>
  </div>
</section>