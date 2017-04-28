<?php foreach ($datas as $data):?>
<table class="statistics_table">
	<thead>
		<tr>
			<?php foreach ($data['header'] as $value):?>
			<th scope="col"><?php echo $value;?></th>
			<?php endforeach;?>			
		</tr>
		<tbody>
			<?php for ($i=1;$i<count($data);$i++):?>
			<tr class="odd">
				<?php foreach ($data[$i] as $value):?>
				<td><?php echo $value;?></td>
				<?php endforeach;?>
			</tr>
			<?php endfor;?>
		</tbody>
	</thead>
</table>
<?php endforeach;
if ($type=="workload"):
?>
<div class="box-content">
	<div id="bargraph" class="graph_chart"></div>
</div>
<link rel="stylesheet" href="/media/css/all.css" type="text/css" />
<script type="text/javascript" src="/media/js/flot/jquery-1.4.2.js"></script>
<script type="text/javascript" src="/media/js/flot/jquery-ui-1.8.2.js"></script>
<script type="text/javascript" src="/media/js/flot/excanvas.js"></script>
<script type="text/javascript" src="/media/js/flot/jquery.fancybox-1.3.2.js"></script>
<script type="text/javascript" src="/media/js/flot/jquery.validate.js" ></script>
<script type="text/javascript" src="/media/js/flot/jquery.wysiwyg.js" ></script>
<script type="text/javascript" src="/media/js/flot/jquery.dataTables.js"></script>
<script type="text/javascript" src="/media/js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="/media/js/flot/jquery.flot.stack.js"></script>
<script type="text/javascript">
	var d1 = [];
	for (var i = 0; i <graph_data.length; i += 1)
		d1.push([i, graph_data[i]]);
	function plotWithOptionsbars() {
		var stack = 0, bars = true, lines = false, steps = false;
		$.plot($("#bargraph"), [d1], {
			series: {
				stack: stack,
				lines: { show: lines, steps: steps },
				bars: { show: bars, barWidth: 0.6,align: "center"}
			},
			xaxis: {
				tickSize:1,
				tickFormatter:actionFormatter
			}
		});
	}
	function actionFormatter(value) {
		return graph_column[value];
	}
	plotWithOptionsbars();
</script>
<?php elseif ($type=="lines"):?>
<div class="box-content">
	<div id="lines" class="graph_chart"></div>
</div>
<link rel="stylesheet" href="/media/css/all.css" type="text/css" />
<script type="text/javascript" src="/media/js/flot/jquery-1.4.2.js"></script>
<script type="text/javascript" src="/media/js/flot/jquery-ui-1.8.2.js"></script>
<script type="text/javascript" src="/media/js/flot/excanvas.js"></script>
<script type="text/javascript" src="/media/js/flot/jquery.fancybox-1.3.2.js"></script>
<script type="text/javascript" src="/media/js/flot/jquery.validate.js" ></script>
<script type="text/javascript" src="/media/js/flot/jquery.wysiwyg.js" ></script>
<script type="text/javascript" src="/media/js/flot/jquery.dataTables.js"></script>
<script type="text/javascript" src="/media/js/flot/jquery.flot.js"></script>
<script type="text/javascript" src="/media/js/flot/jquery.flot.stack.js"></script>
<script type="text/javascript">
	var d1 = [];
	for (var i = 0; i <graph_data.length; i += 1)
		d1.push([i, graph_data[i]]);
	function plotWithOptionsbars() {
		var stack = 0, bars = true, lines = false, steps = false;
		$.plot($("#lines"), [d1], {
			series: {
				stack: stack,
				lines: { show: lines, steps: steps },
				bars: { show: bars, barWidth: 0.6,align: "center"}
			},
			xaxis: {
				tickSize:1,
				tickFormatter:actionFormatter
			}
		});
	}
	function actionFormatter(value) {
		return graph_column[value];
	}
	plotWithOptionsbars();
</script>
<?php endif;?>
<?php exit;?>