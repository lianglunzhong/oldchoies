<?php //var_dump($products);die(); ?>
<div>
        <div>
                <h1>批量sku查询attributes
                        <span class="moreActions">
                                <a href="/admin/site/product/list">Back to Product</a>
                        </span>
                </h1>
        </div>
        <form action="" method="post" name="form" id="form"  enctype="multipart/form-data" style="float:left">
                <div>
                        <div>
                                <fieldset>
                                        <div>
                                                <div><span style="color:#FF0000" >注意： </span>一行一个SKU</div>
                                                <div><span>请输入产品SKU:</span><br />
                                                        <textarea name="SKUARR"  cols="40" rows="20" ></textarea>
                                                </div>
                                        </div>
                                </fieldset>
                        </div>
                </div>
                <div>
                        <div>
                                <div>
                                        <span>
                                                <input  name="" value="提交" type="submit"/>
                                        </span>
                                </div>
                        </div>
                </div>
        </form>
        <?php if(!empty($products)){ ?>
        <div style="width: 60%;float: right;margin-top: 20px;color:#000">
        <table cellspacing="0" cellpadding="0" border="0">
            <tbody>
            <tr>
            <td width="120px">SKU</td>
            <td width="100px">attribute</td>
            </tr>
               <?php foreach($products as $pid){ 
                $detail=Product::instance($pid);
                $attributes=$detail->get('attributes');
                ?>
               <tr>
                <?php 
                echo "<td>".$detail->get('sku')."</td>";
                        foreach($attributes as $key=>$attribute){
                                echo "<td>".$key.": ";
                                foreach($attribute as $val){
                                        echo $val." ";
                                }
                                echo "</td>";
                        }
                ?>
               </tr>
               <?php } ?> 
        </tbody>        
        </table>
        </div>
        <?php } ?>
</div>