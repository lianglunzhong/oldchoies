<h2><a href="/admin/site/product/taglist">返回tag列表</a></h2>
<br />
<h2><a href="/admin/site/product/addtag">新建tag</a></h2>
<br />
        <form method="post" action="#" class="need_validation" id="catalog_set">

        <h3>请选择你要设置的tag:</h3><select style="width:200px;" name="tag_id" id="select1">
                        <?php foreach($tag as $v): ?>
                            <option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
                        <?php endforeach;?>
                            </select>
                    <div>
                        <fieldset>

                            <div style="width:270px;float:left;">
                                <h4>批量tag产品关联</h4>
                                <div><span style="color:#FF0000" >注意： (会覆盖原来的分类产品)</span>一行一个SKU</div>
                                <div><span>请输入产品SKU:</span><br />
                                    <textarea name="SKUARR"  cols="30" rows="15" ></textarea>       
                                </div>
                                <input type="submit" value="Relate" id="products_relate" />
                            </div>
                            <div style="width:250px;float:left;">
                                <h4>批量tag产品添加</h4>
                                <div><span style="color:#FF0000" >注意： </span>一行一个SKU</div>
                                <div><span>请输入产品SKU:</span><br />                
                                    <textarea name="SKUARR1"  cols="30" rows="15" ></textarea>   
                                </div>
                                <input type="submit" value="Add" id="products_add" />
                            </div>
                            <div style="width:250px;float:left;">
                                <h4>批量清空tag下的产品</h4>
                                <!-- <div><span style="color:#FF0000" ></span>一行一个SKU</div> -->
                                <!--                                 <div><span>请输入产品SKU:</span><br />
                                    <textarea name="SKUARR2" cols="30" rows="15" ></textarea>       
                                </div> -->
                                <button type="button" value="delete" id="products_delete"  />
                                delete
                                </button>
                            </div>
<!--                             <div style="width:250px;float:left;">
    <h4>批量分类产品置顶显示</h4>
    <div><span style="color:#FF0000" ></span>一行一个SKU</div>
    <div><span>请输入产品SKU:</span><br />
        <textarea name="SKUARR2" cols="30" rows="15" ></textarea>       
    </div>
    <input type="submit" value="Submit" id="products_top" />
</div>
<div style="width:250px;float:left;">
    <h4>批量分类Position置零</h4>
    <div><span style="color:#FF0000" ></span>一行一个SKU</div>
    <div><span>请输入产品SKU:</span><br />
        <textarea name="SKUARR3" cols="30" rows="15" ></textarea>       
    </div>
    <input type="submit" value="Submit" id="products_zero" />
</div>
<div style="width:250px;float:left;">
    <h4>批量产品positon设置</h4>
    <div><span style="color:#FF0000" ></span>格式如右:CDZT4321212,2</div>
    <div><span>CDZT4321212,3</span><br />
        <textarea name="SKUARR4" cols="30" rows="15" ></textarea>       
    </div>
    <input type="submit" value="Submit" id="products_zero12" />
</div>
<div style="width:250px;float:left;">
    <h4>批量营销分类positon设置</h4>
    <div><span style="color:#FF0000" ></span>格式如右:CDZT4321212,2</div>
    <div><span>CDZT4321212,3</span><br />
        <textarea name="SKUARR5" cols="30" rows="15" ></textarea>       
    </div>
    <input type="submit" value="Submit" id="products_zero13" />
</div> -->
                        </fieldset>
                    </div>

        </form>

<script type="text/javascript">
    $(function(){
        $("#products_relate").click(function(){
            $("#catalog_set").attr('action', '/admin/site/product/products_relate');
            $("#catalog_set").submit();
        });
        $("#products_add").click(function(){
            $("#catalog_set").attr('action', '/admin/site/product/products_add');
            $("#catalog_set").submit();
        });
        $("#products_top").click(function(){
            $("#catalog_set").attr('action', '/admin/site/product/products_top');
            $("#catalog_set").submit();
        });
        $("#products_delete").click(function(){
            var tags = $("#select1  option:selected").text();
            if(confirm('你确定删除['+tags+']标签下的所有产品嘛')){
                window.location.href="http://choies.jinjidexiaoxuesheng.com/admin/site/product/products_delete/"+jQuery("#select1").val();
            }
        });
        $("#products_zero").click(function(){
            $("#catalog_set").attr('action', '/admin/site/product/products_zero');
            $("#catalog_set").submit();
        });
        $("#products_zero12").click(function(){
            $("#catalog_set").attr('action', '/admin/site/product/products_zero12');
            $("#catalog_set").submit();
        });
        $("#products_zero13").click(function(){
            $("#catalog_set").attr('action', '/admin/site/product/products_zero13');
            $("#catalog_set").submit();
        });
        

    })
        
    function export_products($id)
    {
        location.href = "/admin/site/catalog/export_products/" + $id;
        return false;
    }

    function delete_products($id)
    {
        location.href = "/admin/site/catalog/delete_products/" + $id;
        return false;        
    }

    function catalogdelete_products($id)
    {
        location.href = "/admin/site/catalog/catalogdelete_products/" + $id;
        return false;        
    }


</script>