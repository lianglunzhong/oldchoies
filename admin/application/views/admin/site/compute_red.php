<style type="text/css">
 #do_content h4 { margin: 0px 0px 10px 0px; color: #08c; }
 .time-form { padding-bottom: 10px; border-bottom: 2px dotted #e8e8e8; color: #08c;}
 
 .order_tabs li { font-weight: bold;}
 .b_btn li {float: left;}
</style>

<div id="do_content" class="box">
	<h4>红人： </h4><?php echo date('Y-m-d H:i',$from).' 到  '.date('Y-m-d H:i',$to) ; ?>
	<form method="post" style="text-align:right" class="time-form" >
		<label for="start">From: </label>
        <input type="text" name="from" id="from" class="ui-widget-content ui-corner-all" />
      	<label for="end">To: </label>
        <input type="text" name="to" id="to" class="ui-widget-content ui-corner-all" />
		<input type="submit" value="查询" class="ui-button" style="padding:0 .5em" />
	</form>
	<script type="text/javascript">
    	$('#from, #to').datepicker({
        			'dateFormat': 'yy-mm-dd', 
    		});
    </script>
   
	<table >
        <tr>
            <th>序号</th>
            <th>Admin</th>
            <th>lever1</th>
            <th>lever2</th>
            <th>lever3</th>
            <th>所有红人</th>
            <th>新增红人</th>
            <th>订单数量</th>
            <th>采购成本</th>
            <th>已发货数</th>
            <th>发货 %</th>
<!--            <th>show费用</th>-->
<!--            <th>show数量</th>-->
<!--            <th>show %</th>-->
        </tr>
        <?php 
        $i = 1;
        foreach ($data as $key => $val): ?>
        <tr>
       		<td><?php echo $i++; ?></td>
            <td><?php echo $val['admin']; ?></td>
            <td><?php echo $val['eve1']; ?></td>
            <td><?php echo $val['eve2']; ?> </td>
            <td><?php echo $val['eve3']; ?></td>
            <td><?php echo $val['eve_all']; ?></td>
            <td><?php echo $val['new']; ?></td>
            <td><?php echo $val['order']; ?></td>
            <td><?php echo $val['cost']>0 ? round($val['cost'],2) : $val['cost'] ; ?></td>
            <td><?php echo $val['ship_num']; ?></td>
          	<td><?php echo (round($val['ship_per'],4)*100).'%'; ?></td>
<!--          	<td><?php echo $val['show_cost']>0 ? round($val['show_cost'],2) : $val['show_cost'] ; ?></td>-->
<!--          	<td><?php echo $val['show_num']; ?></td>-->
<!--          	<td><?php echo (round($val['show_per'],4)*100).'%'; ?></td>-->
    	</tr>
        <?php endforeach; ?>
    </table>
</div>


