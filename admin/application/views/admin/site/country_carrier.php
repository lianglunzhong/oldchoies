<?php
echo View::factory('admin/site/basic_left')->render();
//获取所有国家对应的isocode=》name
$countries = Kohana::config('country');

//获取当前国家的name
foreach( $countries as $k1 => $v1 )
{
	if($v1['isocode'] == $id)
	{
		$c_name = $v1['name'];
	}
}

//获取当前国家默认的物流运费
foreach( $carrier_default as $k2 => $v2 )
{
	$defaults[$v2->carrier_id]['id'] = $v2->id;
	$defaults[$v2->carrier_id]['carrier_name'] = $v2->carrier_name;
	$defaults[$v2->carrier_id]['weight'] = $v2->weight;
}

//获取当前国家自定义的物流运费
$all = '';
if(count($carrier_all) > 0)
{
	foreach( $carrier_all as $k => $v )
	{
		$all[$v->carrier_id]['id'] = $v->id;
		$all[$v->carrier_id]['carrier_name'] = $v->carrier_name;
		$all[$v->carrier_id]['weight'] = $v->weight;
	}
}
?>
<div id="do_right">
	<div class="box">
		<h3>国家（<?php echo $c_name; ?>）</h3>
		<form method="post" action="">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<ul>
				<li>
					<div>选择物流：
						<select class="drop" name="carrier_id">
							<?php
							foreach( $data as $key => $value )
							{
							?>
								<option value="<?php echo $key; ?>"><?php echo $value['name']; ?></option>
							<?php
							}
							?>
						</select>
						重量大于：<input name="weight" class="short text" value="" type="text">
						价格：<input name="price" class="short text" value="" type="text">
						<input type="submit" value="新  增">
					</div>
				</li>
			</ul>
		</form>
	</div>
	<div class="box">
		<table>
			<thead>
				<tr>
					<th scope="col">物流方式</th>
					<th scope="col">重量</th>
					<th scope="col">价格</th>
					<th scope="col">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php
							foreach( $defaults as $k3 => $v3 )
							{
								if(is_array($all) AND array_key_exists($k3, $all))
								{
									$weight = unserialize($all[$k3]['weight']);
									foreach( $weight as $k4 => $v4 )
									{
				?>
										<tr class="odd">
											<td><?php echo $v3['carrier_name']; ?></td>
											<td><?php echo $k4; ?></td>
											<td><?php echo $v4; ?></td>
											<td><a href="/admin/site/carrier/delete/<?php echo $all[$k3]['id']; ?>?k=<?php echo $k4; ?>">删除</a></td>
										</tr>
				<?php
									}
								}
								else
								{
				?>
									<tr class="odd">
										<td><?php echo $v3['carrier_name']; ?></td>
										<td>0</td>
										<td><?php echo $v3['weight']; ?></td>
										<td>&nbsp;</td>
									</tr>
				<?php
								}
							}
				?>
			</tbody>
		</table>
	</div>
</div>
