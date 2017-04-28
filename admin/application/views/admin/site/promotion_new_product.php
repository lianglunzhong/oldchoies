<?php echo View::factory('admin/site/promotion_left')->render(); ?>
<div id="do_right">
    <div class="box">
        <h3>新品促销关联与删除</h3>
        <fieldset>
                <div style="width:600px;float:left;">
                        <h4>新品促销分类产品删除</h4>
                        <form action="/admin/site/promotion/new_delete" method="post">
                                <input type="submit" name="submit" value="Submit">   
                        </form>
                </div>
                <div style="width:200px;float:left;">
                        <h4>新品促销分类产品关联(一周)</h4>
                        <form action="/admin/site/promotion/new_relate" method="post">
                                <input type="submit" name="submit" value="Submit">   
                        </form>
                </div>
                <div style="width:200px;float:left;">
                        <h4>新品促销分类产品关联(两周)</h4>
                        <form action="/admin/site/promotion/new_relate1" method="post">
                                <input type="submit" name="submit" value="Submit">   
                        </form>
                </div>
        </fieldset>
    </div>
</div>
