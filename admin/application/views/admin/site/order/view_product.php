<?php if ($data['products']){?>
<div class="navigation">
    <ul>
        <li>
            <h4>Order Products</h4>
            <table>
                <tr>
                    <td>SKU</td>
                    <td>Image</td>
                    <td>Name</td>
                    <td>Quantity</td>
                    <td>Price</td>
                    <td>Subtotal</td>
                </tr>
                <?php foreach($data['products'] as $product){?>
                <tr>
                    <td>
                        <table>
                        <?php foreach($product['items'] as $item){?>
                            <tr><td style="border-bottom:none;"><?php echo Product::instance($item)->get('sku');?></td></tr>
                        <?php }?>
                        </table>
                    </td>
                    <td><img src="<?php echo Image::link(Product::instance($product['id'])->cover_image(), 0);?>"/></td>
                    <td>
                        <a href="<?php echo Product::instance($product['id'])->permalink();?>" target="_blank"><?php echo Product::instance($product['id'])->get('name');?></a>
                    </td>
                    <td><?php echo $product['quantity'];?></td>
                    <td><?php echo $product['price'];?></td>
                    <td><?php echo $product['quantity']*$product['price'];?></td>
                </tr>
                <?php }?>
            </table>
        </li>
    </ul>
</div>
<?php }?>
