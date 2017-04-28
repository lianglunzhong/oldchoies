<script type="text/javascript">
	$(function(){
		$(".datepick").datepicker({dateFormat:'yy-mm-dd'});
	});
</script>
<form method="post" action="/admin/site/customer/edit_basic/<?php print $id; ?>">
    <div class="navigation">
        <ul>
            <li>
            <ul>
                <li><label>ID：</label><?php echo $id;?></li>
                <li><label>Created On：</label><?php echo date('Y-m-d H:i:s',$data['created']);?></li>
                <li>
                <label>Email：</label>
                <div><input name="email" class="text short" value="<?php echo $data['email'];?>" type="text"/></div>
                </li>
                <li>
                <label>Firstname：</label>
                <div><input name="firstname" class="text short" value="<?php echo $data['firstname'];?>" type="text"/></div>
                </li>
                <li>
                <label>Lastname：</label>
                <div><input name="lastname" class="text short" value="<?php echo $data['lastname'];?>" type="text"/></div>
                </li>
                <li>
                <label>Birthday：</label>
                <div><input name="birthday" class="text short datepick" value="<?php echo $data['birthday']?date('Y-m-d', $data['birthday']):'';?>" type="text"/></div>
                </li>
                <li>
                <label>Status：</label>
                <div>
                    <select name="status">
                        <option <?php if($data['status'] == 0) echo 'selected="selected"'; ?> value="0">0</option>
                        <option <?php if($data['status'] == 1) echo 'selected="selected"'; ?> value="1">1</option>
                    </select>
                </div>
                </li>
                <li>
                <label>Gender：</label>
                <div>
                    <select name="gender">
                        <option value="<?php echo $data['gender'];?>"><?php if($data['gender']==1){ echo "Female";}elseif($data['gender']==0){ echo "Male";}elseif($data['gender']==2){ echo "order";}?></option>
                    </select>
                </div>
                </li>
                <li>
                <label>Country：</label>
                <div>
                    <select name="country">
                        <?php foreach($countries as $c){?>
                        <option value="<?php echo $c->isocode;?>" <?php echo $c->isocode==$data['country']?"selected":"";?>><?php echo $c->name;?></option>
                        <?php }?>
                    </select>
                </div>
                </li>
                <li>
                <div><input class="hand" name="" value="提  交" type="submit" /></div>
                </li>
            </ul>
            </li>
        </ul>
    </div>
</form>
<div class="navigation">
    <ul>
    <form method="post" action="/admin/site/customer/edit_basic_address">
        <li><h4>Last Login</h4>
            Last Login Time: <?php echo $data['last_login_time'] ? date('Y-m-d H:i:s', $data['last_login_time']) : ''; ?><br/>
            Last Login IP: <?php echo long2ip($data['last_login_ip']); ?>
        </li>
        <li><h4>Customer Addresses</h4>
        <ul>
	   <li>( Exp: FirstName LastName, Address, City State Country, Zip, Phone )</li>
	   <?php foreach($addresses as $key => $address): ?>
            <li><?php echo ($key+1).'. '.$address['firstname'].' '.$address['lastname'].', '.$address['address'].', '.$address['city'].' '.$address['state'].' '.$address['country'].', '.$address['zip'].', '.$address['phone']; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        当前地址：<input id="address_<?php echo $address['id']; ?>" name="<?php echo $address['id']; ?>" class="address123 text short" value="<?php echo $address['address']; ?>" type="text" />  
            </li>
	   <?php endforeach; ?>
        </ul>
        <div><input class="hand" name="" value="修改地址" type="submit" /></div>
        </li>
        </form>
    </ul>
</div>
<div class="navigation">
    <ul>
        <li>
        <h4>Customer Orders</h4>
        <table>
            <tr>
                <td>Order num</td>
                <td>Created</td>
                <td>Currency</td>
                <td>Amount</td>
                <td>Status</td>
                <td>Shipment Status</td>
                <td>Issue</td>
            </tr>
            <?php foreach($orders as $o){?>
            <tr>
                <td><a href="/admin/site/order/edit/<?php echo $o->id;?>" target="_blank"><?php echo $o->ordernum;?></a></td>
                <td>Created</td>
                <td>Currency</td>
                <td>Amount</td>
                <td>Status</td>
                <td>Shipment Status</td>
                <td>Issue</td>
            </tr>
            <?php }?>
        </table>
        </li>
    </ul>
</div>
