<div id="do_content" class="box">
    <h3>采购单bb <?php echo $date.' '.$date_end; ?>
    <button type="button" onclick="window.location.href='/admin/site/print/down'">下载</button></h3>
    <?php if (!empty($items)): ?>
    <table>
        <tr>
            <th>SKU</th>
            <th>产品图片</th>
            <th style="width:477px;">产品名称</th>
        </tr>
        <?php foreach ($items as $item): ?>
        <?php $product = new Product($item['product_id']);
            $data = array();
            $attr = $product->get('attributes');
            if( !empty($attr) )
            {
                $attribute = $attr;
                
                if( isset($attribute['Size']) && is_array($attribute['Size']) )
                {
                    foreach( $attribute['Size'] as $key => $val )
                    {
                        if( strpos($val, 'EUR') )
                        {
                            $data[] = substr($val, strpos($val, 'EUR') + 3, 2);
                        }else{
                            $data[] = $val;
                        }
                    }
                }
                elseif( isset($attribute['size']) && is_array($attribute['size']) )
                {
                    foreach( $attribute['size'] as $key => $val )
                    {
                        if( strpos($val, 'EUR') )
                        {
                            $data[] = substr($val, strpos($val, 'EUR') + 3, 2);
                        }else{
                            $data[] = $val;
                        }
                    }
                }
            }
        ?>
        <tr>
            <td><?php print $item['sku']; ?><br>
                <form action="/admin/site/print/ajax_csv" method="post">
                    <input type="hidden" name="sku" value="<?php echo $item['sku'];?>"/>
                    <?php if(!empty($data)){?>
                        <select name="attr" style="width:80px">
                            <option value="0">- select -</option>
                            <?php foreach($data as $val){?>
                            <option value="<?php echo $val;?>"><?php echo $val;?></option>
                            <?php }?>
                        </select><br/><br/>
                    <?php }?>
                    <input type="text" name="print_qty" value="1" size="3"/>
                    <input type="submit" value="print"/>
                </form>
            </td>
            <td><img src="<?php print Image::link($product->cover_image(),3); ?>"/></td>
            <td><?php print html::anchor('/admin/site/product/edit/'.$product->get('id'), $item['name'], array('target'=>'_blank')); ?></td>
        </tr>
        <?php endforeach ?>
    </table>
    <?php else: ?>
    <strong>没有需要采购的订单</strong>
    <?php endif ?>
</div>

<script type="text/javascript">
//$(function(){
//	$(".aja").click(function(){
//			$this = $(this);
//			var sku = $this.siblings('.sku2').val();
//			var attr = $this.siblings('.attr').val()
//			
//			$.ajax({
//		        "url": "/admin/site/print/ajax_csv/", 
//		        "type": "POST", 
//		        "dataType": "json", 
//		        "data": {sku:sku,attr:attr}, 
//		        "success": function (data) {
//			        	$this.siblings('.mss').html('success');
//		        },
//				"error": function (){
//				}
//		    });
//	})
//})
</script>

