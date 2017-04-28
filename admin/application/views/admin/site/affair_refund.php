<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<style type="text/css">
.order_tabs{padding-bottom: 20px;}
.order_tabs li{float: left;font-weight: bold;}
.order_tabs .on{color: #ff0000;}
</style>
<script type="text/javascript">
	$(function(){
		jQuery("#toolbar").jqGrid({
			url:'/admin/site/data/refund_data',
			datatype: "json",
			height: 500,
			width: 1200,
			colNames:['Selected','ID','OrderNo','订单生成日期','订单print time','Refund date', 'Currency','Amount','Style','ship status','Ship Code'],
			colModel:[
				{name:'selectall',align:'center',search:false,formatter:actionSelect,index:false,width:100},
				{name:'order_id',index:'id', width:200,search:false},
                {name:'ordernum',index:'ordernum',width:150},
                {name:'created',index:'created',width:150,search:false},
                {name:'shipping_date',index:'shipping_date',width:150,search:false},
                //{name:'trans_id',index:'trans_id', width:200,search:false},
                {name:'created',index:'created',width:150},
			    {name:'currency',index:'currency',width:100,search:false},
			    {name:'refund',index:'refund',width:200,search:false},
			    {name:'payment_method',index:'payment_method',width:200,search:false},
			    {name:'shipping_status',index:'shipping_status',width:200},
			    {name:'shipping_code',index:'shipping_code',width:200,search:false},
			],
			rowNum:20,
			rowList : [20,100,250,500],
			mtype: "POST",
			gridview: true,
			pager: '#ptoolbar',
			viewrecords: true,
			sortname: 'id',
			sortorder: "desc",
			recordtext: "View {0} - {1} of {2}",
			emptyrecords: "No records to view",
			loadtext: "Loading...",
			pgtext : "Page {0} of {1}",
			gridComplete: function () {
				$("table:first").find("tr:last").find("th:first").find("div").html("All<input id='selectall' type='checkbox'>");
				$("#selectall").click(function(){
					$("#selectall").attr('checked') == true?$("input[name='orders[]']").each(function(){$(this).attr("checked", true)}):$("input[name='orders[]']").each(function(){$(this).attr("checked", false)});
				});
			}
		});

		jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,multipleSearch:true});
		jQuery("#toolbar").jqGrid('navButtonAdd','#ptoolbar',{position:'last',title:'导出为Excel文件',caption:'ExportData',onClickButton:exportCsv});
		jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});

	    $('#gs_created').daterangepicker({
		    		dateFormat:'yy-mm-dd',
		    		rangeSplitter:' to ',
		    		onRangeComplete:(function(){
					    	var last_date = '',$input = $('#gs_created');
					    	return function(){
						    	if(last_date != $input.val()) {
							    	$('#toolbar')[0].triggerToolbar();
							    	last_date = $input.val();
						    	}
					    	};
		    		})()
	    });
	});
</script>
		
<script type="text/javascript">
		function actionSelect(cellvalue,options,rowObject){
			return '<input type="checkbox" name="orders[]" value ="'+rowObject[1]+'" >';
		}

    	function exportCsv()
    	{
    		var mya = new Array();
    		mya = $("#toolbar").getDataIDs();     //得到所有展示出来的 ID
    		var labels = jQuery("#toolbar").getGridParam('colNames');   //得到所有的 colNames label
    		var html = " ";
    		
    		for (var i in labels) 
    		{
    			if( i == 0 ) continue;  	//+++++0开始++++0对应select
    			html += labels[i] + "\t ";    		//输出头部信息
    		}
    		html = html + "\t\n ";
    		for( i=0; i<mya.length; i++ )
    		{
    			for( j=0; j<labels.length; j++ )    //+++++此处减n ,n是continue排出的个+++
    			{
    				if( j == 0 ) continue;
    				html += $("#toolbar").getCell(mya[i],j) + "\t ";   //得到一行中每个单元格的值
    			}
    			html=html+"\t\n "; //一行结束
    		}
    		html=html+"\t\n ";
    		html = html.replace(/<.*?>/g,"");
    		document.getElementById('csvBuffer').value=html;
    		document.getElementById('form-2').method='POST';
    		document.getElementById('form-2').action='exprotcsv';
    		document.getElementById('form-2').target='_blank';
    		document.getElementById('form-2').submit();
    	}
</script>
	
	
<div id="do_content">
		<div class="box" style="overflow:hidden;">
		
		<ul class="order_tabs">
<!-- 		  	<li><a href="/admin/site/affair/affair_noship">未确认</a></li>
			<li><a href="/admin/site/affair/affair_no">已确认</a></li>
			<li><a href="/admin/site/affair/affair">已做帐</a></li> -->
			<li><a class="on" href="/admin/site/affair/refund">退款表</a></li>
    	</ul>
    	
			<h3>退款表</h3>
            <div style="margin:20px;"></div>
            <table id="toolbar"></table>
			<div id="ptoolbar"></div>
		</div>
</div>
<form id="form-2"><input type="hidden" name="csvBuffer" id="csvBuffer" /></form>


        