<?php echo View::factory('admin/site/label_left')->render(); ?>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<?php 
	$cats=ORM::factory('catalog')
				->where('site_id','=',site::instance()->get('id'))
				->find_all();
	$catalogs=array();
	foreach ($cats as $cat)
		$catalogs[$cat->id]=$cat->name;
	$has_cates=	DB::select('catalog_id')
					->from('labels')
					->where('site_id','=',site::instance()->get('id'))
					->where('catalog_id','<>',0)
					->where('is_active','=',1)
					->distinct(true)
					->execute()
					->as_array();
	$array_catalogs=array('All');
	foreach ($has_cates as $c)
	{
		if(isset($catalogs[$c['catalog_id']])&&$c['catalog_id']!='')
			$array_catalogs[$c['catalog_id']]=$catalogs[$c['catalog_id']];
	}
	$array_catalogs=str_replace(array( '"', '{', '}', ',','0:All'), array( '', '', '', ';',':All'), json_encode($array_catalogs));
?>
<script type="text/javascript">
$(function(){
	jQuery("#bar").jqGrid({
		url:'/admin/site/label/data',
		datatype: "json",
		height: 500,
		autowidth: true,
		colNames:['Select','ID','Created','Niche','URL','Catalog','Defined Catalog','Display Number','Local Searches','Global Searches','Competition','Active','Action'],
		colModel:[
			{name:'select',align:'center',search:false,formatter:actionSelect,index:false,width:40},
			{name:'id',index:'id', width:50},
			{name:'created',index:'created',width:100},
			{name:'niche',index:'niche',search:true},
			{name:'url',index:'url',width:80},
			{name:'catalog_id',index:'catalog_id',stype:'select',width:100,searchoptions:{value:<?php echo "'".$array_catalogs."'"; ?>}},
			{name:'defined_catalog',index:'defined_catalog',width:100},
			{name:'display_number',index:'display_number',width:60,search:false},
			{name:'local',index:'local',width:60,search:false},
			{name:'global',index:'global',width:60,search:false},
			{name:'competition',index:'competition',width:60,search:false},
			{name:'is_active',index:'is_active',width:60,stype:'select',searchoptions:{value:':All;1:Yes;0:No'}},
			{formatter:actionFormatter, width:120,search:false}
		],
		rowNum:50,
		rowList : [30,50,100,500],
		mtype: "POST",
		gridview: true,
		pager: '#toolbar',
		sortname: 'id',
		viewrecords: true,
		sortorder: "desc",
		recordtext: "View {0} - {1} of {2}",
		emptyrecords: "No records to view",
		loadtext: "Loading...",
		pgtext : "Page {0} of {1}",
		gridComplete: function (){
				$("table:first").find("tr:last").find("th:first").find("div").html("<input id='selectall' type='checkbox'>");
				$("#selectall").click(function(){
					$("#selectall").attr('checked') == true?$("input[name='labels[]']").each(function(){$(this).attr("checked", true)}):$("input[name='labels[]']").each(function(){$(this).attr("checked", false)});
				});
			}
	});
	jQuery("#bar").jqGrid('navGrid','#toolbar',{del:false,add:false,edit:false,multipleSearch:true});
	jQuery("#bar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
	$('#gs_created').daterangepicker({
		dateFormat:'yy-mm-dd',
		rangeSplitter:' to ',
		onRangeComplete:(function(){
			var last_date = '',$input = $('#gs_created');
			return function(){
				if(last_date != $input.val()) {
					$('#bar')[0].triggerToolbar();
					last_date = $input.val();
				}
			};
		})()
	});
});
function actionSelect(cellvalue,options,rowObject){
	return '<input type="checkbox" name="labels[]" value ="'+rowObject[1]+'" >';
}
function actionFormatter(cellvalue,options,rowObject) {
	var status=rowObject[10]=='Yes'?'Deactivate':'Activate';
	return '<a href="/admin/site/label/edit/'+rowObject[1]+'" >Edit</a>&nbsp;&nbsp;&nbsp;<a href="#" labelnum="' + rowObject[1] + '"  class="active" >'+status+'</a>';
}
$('.active').live('click',function(){
	var $this = $(this);
	$.post('/admin/site/label/active',
			{ Action: "post", id: $this.attr('labelnum')},
			function(){
					$this.html($this.html()=='Activate'?'Deactivate':'Activate');
					$this.parent().parent().find('td:eq(10)').text($this.parent().parent().find('td:eq(10)').text()=="Yes"?"No":"Yes");
				}
			);
	return false;
});
</script>
<div id="do_right">
    <div class="box">
        <h3>Label List</h3>
         <div class="box" style="overflow:hidden;">
         <?php echo Form::open('admin/site/label/delete');?>
			<table id="bar"></table>
			<div id="toolbar"></div>
			<?php 
			echo Form::submit('submit', 'delete selected');
			echo Form::close();
			?>	
		</div>
    </div>
</div>