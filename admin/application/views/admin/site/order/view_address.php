<div class="navigation">
    <ul>
        <li><h4>Shipping Address</h4>
            <ul>
                <li>
                    Firstname: <?php echo $data['shipping_firstname'];?>
                </li>
                <li>
                    Lastname: <?php echo $data['shipping_lastname'];?>
                </li>
                <li>
                    Address: <?php echo $data['shipping_address'];?>
                </li>
                <li>
                    City: <?php echo $data['shipping_city'];?>
                </li>
                <li>
                    State: <?php echo $data['shipping_state'];?>
                </li>
                <li>
                    Zip code: <?php echo $data['shipping_zip'];?>
                </li>
                <li>
                    Country:
                        <?php
                        foreach($countries as $c){
                            echo $c['isocode']==$data['shipping_country']?$c['name']:'';
                            break;
                        }
                        ?>
                </li>
                <li>
                    Phone: <?php echo $data['shipping_phone'];?>
                </li>
                <li>
                    Mobile: <?php echo $data['shipping_mobile'];?>
                </li>
            </ul>
        </li>
        <li><h4>Billing Address</h4>
            <ul>
                <li>
                    Firstname: <?php echo $data['billing_firstname'];?>
                </li>
                <li>
                    Lastname: <?php echo $data['billing_lastname'];?>
                </li>
                <li>
                    Address: <?php echo $data['billing_address'];?>
                </li>
                <li>
                    City: <?php echo $data['billing_city'];?>
                </li>
                <li>
                    State: <?php echo $data['billing_state'];?>
                </li>
                <li>
                    Zip code: <?php echo $data['billing_zip'];?>
                </li>
                <li>
                    Country:
                        <?php foreach($countries as $c){
                            echo $c['isocode']==$data['billing_country']?$c['name']:"";
                            break;
                        }?>
                </li>
                <li>
                    Phone: <?php echo $data['billing_phone'];?>
                </li>
                <li>
                    Mobile: <?php echo $data['billing_mobile'];?>
                </li>
            </ul>
        </li>
    </ul>
</div>
