<?php echo View::factory('/admin/ticket/ticket_left')->render(); ?>
<script  type="text/javascript">
$(function() {
	$( "button").button();
	$( "button" ).click(function() { $("#form").submit();return false; });
	$( "#statistics_tab" ).tabs({
//		ajaxOptions:{
//			success: plotWithOptionsbars()
//		}
});
});

$(function() {
	var dates = $( "#from, #to" ).datepicker({
		dateFormat:"yy-mm-dd",
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		onSelect: function( selectedDate ) {
			var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});

</script>
<div id="do_right">
    <div class="box" style="overflow: hidden;">
        <h3>General Statistics</h3>
        <form id="form" method="post" action="<?php echo URL::current();?>">
        <label>From:</label><input name="from" type="text" id="from" value="<?php echo isset($_POST["from"])?$_POST["from"]:date("Y-m-d",strtotime("-1 week"));?>"/>
        <label>to:</label><input name="to" type="text" id="to" value="<?php echo isset($_POST["to"])?$_POST["to"]:date("Y-m-d");?>"/>
        <?php $by=isset($_POST['by'])?$_POST['by']:'d';  ?>
        <label>By:</label>
        <input name="by" type="radio" id="by" value="d" <?php if($by=='d') echo "checked";?>/><label>Day&nbsp;&nbsp;</label>
        <input name="by" type="radio" id="by" value="m" <?php if($by=='m') echo "checked";?>/><label>Month&nbsp;&nbsp;</label>
        <input name="by" type="radio" id="by" value="y" <?php if($by=='y') echo "checked";?>/><label>Year</label>
        &nbsp;&nbsp;&nbsp;<button>Filter</button>
        </form><br/>  

	<div id="statistics_tab">
	<ul>
		<li><a href="/admin/ticket/statistics/general_statistics?type=lines&&<?php echo $parameter;?>">Lines</a></li>
		<li><a href="/admin/ticket/statistics/general_statistics?type=users&&<?php echo $parameter;?>">Users</a></li>
		<li><a href="/admin/ticket/statistics/general_statistics?type=topics&&<?php echo $parameter;?>">Topics</a></li>
		<li><a href="/admin/ticket/statistics/general_statistics?type=status&&<?php echo $parameter;?>">Status</a></li>
		<li><a href="/admin/ticket/statistics/general_statistics?type=sites&&<?php echo $parameter;?>">Sites</a></li>
		<li><a href="/admin/ticket/statistics/general_statistics?type=amount&&<?php echo $parameter;?>">Amount</a></li>
		<li><a href="/admin/ticket/statistics/general_statistics?type=workload&&<?php echo $parameter;?>">Workload</a></li>
	</ul>
	</div>
	</div>
</div>