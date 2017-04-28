<?php
echo View::factory('admin/site/catalog_left')->set('catalog_tree',$catalog_tree)->render();
?>

<div id="do_right" class="catalog_right">

    <div class="box">
        <h3>商品分类</h3>
		<p>请在左侧的列表中选择一个操作吧。</p>
    </div>
</div>
