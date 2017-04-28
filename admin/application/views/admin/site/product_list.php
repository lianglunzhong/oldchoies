<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script type="text/javascript">
    $(function(){
        jQuery("#toolbar").jqGrid({
            url:'/admin/site/product/data<?php $lang_url = $lang ? '?lang=' . $lang : ''; echo $lang_url; ?>',
            datatype: "json",
            height: 600,
            width: 1250,
            colNames:['ID','Name','Type','Set','SKU','Price','Created','Stock','Visibility','Status','Picker','Hits','Q_clicks','Add Times','Presell','Admin','Source','Position','level','design','style','optimization','store','Action'],
            colModel:[
                {name:'product_id',index:'id', width:30},
                {name:'product_name',index:'name', width:180},
                {name:'product_type',index:'type', width:50,align:'center',formatter:typeFormatter,searchoptions:{'value':':所有产品;0:基本产品;1:配置产品;2:打包产品'},stype:'select',"summaryTpl":"{0}"},
                {name:'product_set',index:'set_id', width:80,formatter:setFormatter,
                    "searchoptions":{"value":":All"},
                    "stype":"select",
                    "summaryTpl":"{0}"
                },
                {name:'product_sku',index:'sku', width:50},
                {name:'product_price',index:'price', width:40},
                {name:'product_created',index:'created', width:50},
                {name:'product_stock',index:'stock', width:30},
                {name:'product_visibility',index:'visibility', width:40,formatter:visibilityFormatter,
                    "searchoptions":{"value":":All;1:Visibility;0:不可见"},
                    "stype":"select",
                    "summaryTpl":"{0}"
                },
                {name:'product_status',index:'status', width:30,formatter:statusFormatter,
                    "searchoptions":{"value":":所有产品;1:上架;0:下架"},
                    "stype":"select",
                    "summaryTpl":"{0}"
                },
                {name:'product_offline_picker',index:'offline_picker', width:30},
                {name:'product_hits',index:'hits', width:30},
                {name:'product_quick_clicks',index:'quick_clicks', width:40},
                {name:'product_add_times',index:'add_times', width:40},
                {name:'product_presell',index:'presell', width:40,formatter:presellFormatter,
                    "searchoptions":{"value":":所有产品;1:预售;0:非预售"},
                    "stype":"select",
                    "summaryTpl":"{0}"
                },
                {name:'product_admin',index:'admin',width:30},
                {name:'product_source',index:'source',width:30},
                {name:'product_position', index: 'position',width:40},
                {name:'level',index:'level', width:40,formatter:levelFormatter,
                    "searchoptions":{"value":":null;1:A档(>30);2:B档(<30)"},
                    "stype":"select",
                    "summaryTpl":"{0}"
                },
                {name:'design',index:'design', width:40,formatter:designFormatter,
                    "searchoptions":{"value":":null;1:开发设计款;2:非开发设计款"},
                    "stype":"select",
                    "summaryTpl":"{0}"
                },
                {name:'style',index:'style', width:40,formatter:styleFormatter,
                    "searchoptions":{"value":":null;1:潮款;2:基本款"},
                    "stype":"select",
                    "summaryTpl":"{0}"
                },
                {name:'optimization',index:'optimization', width:40,formatter:optimizationFormatter,
                    "searchoptions":{"value":":null ;1:已操作;0:未操作"},
                    "stype":"select",
                    "summaryTpl":"{0}"
                },
                {name:'product_store',index:'store', width:50},
                {width:80,search:false,formatter:actionFormatter}
            ],
            rowNum:20,
            //  rowTotal: 12,
            rowList : [20,50,100,300],
            // loadonce:true,
            mtype: "POST",
            // rownumbers: true,
            // rownumWidth: 40,
            gridview: true,
            postData: {id_for_search:true},
            pager: '#ptoolbar',
            sortname: 'id',
            viewrecords: true,
            sortorder: "desc"
            //            caption: "Toolbar Searching"
        });

        jQuery("#toolbar").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
        jQuery("#toolbar").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
        set_search_options();
        
        $('#gs_product_created').daterangepicker({
            dateFormat:'yy-mm-dd',
            rangeSplitter:' to ',
            onRangeComplete:(function(){
                var last_date = '',$input = $('#gs_product_created');
                return function(){
                    if(last_date != $input.val()) {
                        $('#toolbar')[0].triggerToolbar();
                        last_date = $input.val();
                    }
                };
            })()
        });

        $('.delete').live('click',function(){
            var $this = $(this);
            var confirm_info = '';

            if ($this.attr('product_type') == 1 /* config product */) {
                confirm_info = '该产品类型是配置产品，关联的简单产品将一并删除，确定么？';
            } else {
                confirm_info = 'Delete this Product: # ' + $this.attr('product_sku') + ' ?\nIt can not be undone!';
            }

            if(!confirm(confirm_info)){
                return false;
            }
        });
        
        $('.export_all').live('click', function(){
            window.location.href = '/admin/site/product/products_all';
            return false;
        })
        $('.export_offline').bind('click',function(){
            window.location.href = '/admin/site/product/products_offline'
            return false
        })
        
<?php
if ($lang_url)
{
    ?>
                    var lang_url = '<?php echo $lang_url; ?>';
                    $("a").live('click', function(){
                        var href = $(this).attr('href');
                        var pclass = $(this).attr('class');
                        if(pclass != 'product_list')
                        {
                            href += lang_url;
                            $(this).attr('href', href);
                        }
                    })
                    $("form").live('submit', function(){
                        var action = $(this).attr('action');
                        action += lang_url;
                        $(this).attr('action', action);
                    })
                    $(".lang_hidden").hide();
    <?php
}
?>
            });
            function typeFormatter (cellvalue, options, rowObject)
            {
                var types = ['Simple','Configure','Package','Simple-Config'];
                return ! types[cellvalue] ? '未知' : types[cellvalue] ;
            }
            function visibilityFormatter(cellvalue,options,rowObject) {
                return cellvalue == 1 ? '可见' : '不可见';
            }
            function setFormatter(cellvalue,options,rowObject) {
                var userdata = jQuery("#toolbar").getGridParam('userData');
                return userdata['sets'][cellvalue];
            }
            function actionFormatter(cellvalue,options,rowObject) {
                // return '<a target="_blank" href="/admin/site/product/edit/' + rowObject[0] + '">Edit</a> <?php if(!$lang_url){ ?><a href="/admin/site/product/delete/' + rowObject[0] + '" class="delete" product_type="'+rowObject[2]+'" product_sku="' + rowObject[4] + '">Delete</a><?php } ?>';
                return '<a target="_blank" href="/admin/site/product/edit/' + rowObject[0] + '">Edit</a>';
            }
            function set_search_options(){
                var $gs_product_set = $('#gs_product_set');
                $gs_product_set.append('<option value="0">无</option>');
<?php
$sets = Site::instance()->sets();
if (count($sets))
{
    foreach ($sets as $set)
    {
        ?>
                        $gs_product_set.append('<option value="<?php echo $set['id']; ?>"><?php echo $set['name']; ?></option>');
        <?php
    }
}
?>
    }
    function statusFormatter(cellvalue) {
        return cellvalue == 1 ? 'On' : 'Off';
    }
        
    function presellFormatter(cellvalue){
        return cellvalue == 0 ? 'No' : 'Yes';
    }
                        
    function export_outstock()
    {
        window.location.href = '/admin/site/product/export_outstock';
        return false;
    }
    function levelFormatter(cellvalue){
        return cellvalue == 1 ? 'A档' : cellvalue == 2?'B档':'';
    }
    function designFormatter(cellvalue){
        return cellvalue == 1 ? '开发设计款' : cellvalue == 2?'非发设计款':'';
    }
    function styleFormatter(cellvalue){
        return cellvalue == 1 ? '潮款' : cellvalue == 2?'基本款':'';
    }
    function optimizationFormatter(cellvalue){
        return cellvalue == 1 ? '已操作' : cellvalue == 2?'未操作':'';
    }
</script>
<div id="do_content">

    <div class="box" style="overflow:hidden;">
        <fieldset>
            <h4>产品统计：</h4>
            <table>
                <tr><td>时间:</td>
                    <?php
                    foreach ($dates as $date)
                    {
                        echo '<td>' . $date . '</td>';
                    }
                    ?>
                </tr>
                <tr><td>当日上新数:</td>
                    <?php foreach ($products_statistics['today_display_count'] as $date => $count): ?>
                        <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
                    <?php endforeach ?>
                </tr>
                <tr><td>当日下架数:</td>
                    <?php foreach ($products_statistics['today_nosale_count'] as $date => $count): ?>
                        <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
                    <?php endforeach ?>
                </tr>
                <tr><td>当日隐藏数:</td>
                    <?php foreach ($products_statistics['today_invisible_count'] as $date => $count): ?>
                        <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
                    <?php endforeach ?>
                </tr>
                <tr><td>在架并显示产品总数:</td>
                    <?php foreach ($products_statistics['visible_sale_count'] as $date => $count): ?>
                        <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
                    <?php endforeach ?>
                </tr>
                <tr><td>当日销量:</td>
                    <?php foreach ($products_statistics['today_orderitem_count'] as $date => $count): ?>
                        <?php echo "<td><strong>$count</strong> &nbsp;</td>"; ?>
                    <?php endforeach ?>
                </tr>

            </table>
        </fieldset>
        <h3>Products
            <?php
            $languages = Kohana::config('sites.1.language');
            $now_lang = Arr::get($_GET, 'lang', 'en');
            foreach ($languages as $l)
            {
                ?>
                <a class="product_list" href="/admin/site/product/list<?php if ($l != 'en') echo '?lang=' . $l; ?>" <?php if ($now_lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
            ?>
            <div style="margin:20px;">
                <form action="/admin/site/product/products" method="post">
                    <label for="export-start">From: </label>
                    <input type="text" name="from" id="export-from" class="ui-widget-content ui-corner-all">
                    <label for="export-end">To: </label>
                    <input type="text" name="to" id="export-to" class="ui-widget-content ui-corner-all">
                    <select name="type">
                        <option value="0">All products</option>
                        <option value="1">显示的产品</option>
                        <option value="2">上架的产品</option>
                        <option value="3">显示并上架的产品</option>
                    </select>
                    <input type="submit" name="Submit" value="导出产品" />
                    <script type="text/javascript">
                        $('#export-from, #export-to').datepicker({
                            'dateFormat': 'yy-mm-dd'
                        });
                    </script>
                    <button class="export_all" style="margin-left:100px;">导出所有产品</button>
                    <button onclick="return export_outstock();" style="margin-left:5px;">导出下架并显示的产品</button>
                    <button class="export_offline" style="margin-left:5px;">导出在架在售产品supplier</button>
                </form>
                <span class="moreActions lang_hidden">
                    <a href="/admin/site/product/add">Add Product</a>
                </span>
                <form enctype="multipart/form-data" method="post" action="/admin/site/data/upload_products" class="lang_hidden">
                    <input id="file" type="file" name="file">
                    <input type="submit" value="Bulk Upload" name="submit">
                    <a href="/media/images/upload.csv">上传模板.csv</a>
                </form>
                <form enctype="multipart/form-data" action="/admin/site/product/import_basic" method="post" class="lang_hidden">
                    <input type="file" name="file" />
                    <input type="submit" name="submit" value="Import product basic" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin/site/product/presell" style="color:red;">导出预售产品信息</a>
                </form>
<!--                 <form enctype="multipart/form-data" action="/admin/site/product/special_bulk" method="post" class="lang_hidden">
                    <input type="file" name="file" />
    <input type="submit" name="submit" value="批量basic修改product store" /> 
                            
                            
                            </form> -->
                <div>
                </div>
                <!--                <form enctype="multipart/form-data" action="/admin/site/data/upload_simple_products" method="post">
                                    <input type="file" name="file" />
                                    <input type="submit" name="submit" value="礼服产品上传" />
                                </form>-->
                <?php
                if ($lang)
                {
                    echo '<a href="/admin/site/product/small_import" target="_blank">小语种产品数据修改</a>';
                }
                ?>
            </div>
            <div class="lang_hidden">
                <span>
                    <a href="/admin/site/product/product_onstock">批量上架产品</a>
                </span>&nbsp;&nbsp;&nbsp;
                <span>
                    <a href="/admin/site/product/product_outstock">批量下架产品</a>
                </span>&nbsp;&nbsp;&nbsp;
                <span>
                    <a href="/admin/site/product/product_visible">批量显示产品</a>
                </span>&nbsp;&nbsp;&nbsp;
                <span>
                    <a href="/admin/site/product/product_invisible">批量隐藏产品</a>
                </span>&nbsp;&nbsp;&nbsp;
                <span>
                    <a href="/admin/site/product/product_attributes">批量查询attributes</a>
                </span>&nbsp;&nbsp;&nbsp;

                <span><a href="/admin/site/product/import_extra">导出extra_fee为3的产品</a></span>
                <span style="float:right;"><a href="/admin/site/product/taobao">产品状态统计</a></span>
            </div>
        </h3>


        <table id="toolbar"></table>
        <div id="ptoolbar"></div>
        <div class="lang_hidden">
            <fieldset>
                <div>
                    <h3>
                        <a href="/admin/site/product/delete_images">批量产品图片删除</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a target="_blank" href="/admin/site/image/product_configs_check">小语种图片顺序同步</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="/admin/site/product/offline_picker">产品表现统计</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="/admin/site/product/all_brief">产品brief同步</a>
                        <span style="float:right;">
                            <a href="/admin/site/product/weight_history" target="_blank">产品weight变化记录表</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="/admin/site/clicks/products">每日产品点击统计</a>
                        </span>
                    </h3>
                </div>
                <div style="width:300px;float:left;">
                    <h4>产品 成本/原售价/现售价 导出</h4>
                    <form action="/admin/site/product/export_cost" method="post" target="_blank">
                        <div><span style="color:#FF0000"></span>一行一个SKU</div>
                        <div><span>请输入产品SKU:</span><br>
                            <textarea name="SKUARR" cols="30" rows="20"></textarea>       
                        </div>
                        <input type="submit" value="Submit">   
                    </form>
                </div>
                <div style="width:200px;float:right;">
                    <h4>产品缩略图,线下供货商,线下SKU,库存信息 导出</h4>
                    <form action="/admin/site/product/export_thumb" method="post" target="_blank">
                        <div><span style="color:#FF0000"></span>一行一个SKU</div>
                        <div><span>请输入产品SKU:</span><br>
                            <textarea name="SKUARR" cols="25" rows="20"></textarea>       
                        </div>
                        <input type="submit" value="Submit">   
                    </form>
                </div>
                <div style="width:200px;float:right;">
                    <h4>产品上下架/显隐信息</h4>
                    <form action="/admin/site/product/status_visibility" method="post" target="_blank">
                        <div><span style="color:#FF0000"></span>一行一个SKU</div>
                        <div><span>请输入产品SKU:</span><br>
                            <textarea name="SKUARR" cols="25" rows="20"></textarea>       
                        </div>
                        <input type="submit" value="Submit">   
                    </form>
                </div>
                <div style="width:200px;float:right;">
                    <h4>PID查询SKU</h4>
                    <form target="_blank" method="post" action="/admin/site/product/from_id_export_products">
                        <div><span style="color:#FF0000"></span>一行一个Pid</div>
                        <div><span>请输入产品pid:</span><br>
                            <textarea rows="20" cols="25" name="SKUARR"></textarea>       
                        </div>
                        <input type="submit" value="Submit">   
                    </form>
                </div>
                <h4>线下供货商导出SKU</h4>
                <form action="/admin/site/product/offline_export_sku" method="post" target="_blank">
                    <div><span>线下供货商:</span><br>
                        <input type="text" name="offline_factory" />       
                    </div>
                    <input type="submit" value="Submit">   
                </form>
                <br/><br/>
                <div>
                    <h4>
                        批量产品stock导入, 上传模板: <span style="color:red;">sku, size, qty</span><br/>
                        <a target="_blank" href="/admin/site/product/attribute_outstock">Out of stock products</a>
                    </h4>
                    <form enctype="multipart/form-data" action="/admin/site/product/stock_import" method="post" target="_blank">
                        <input type="file" name="file" />
                        <input type="submit" name="submit" value="批量产品stock导入" />
                    </form>
                </div>
            <br /><br /><br />
                <div>
                    <h4>批量输入store，导出sku(一行一个store,请不要输入重复store)
                    <form enctype="multipart/form-data" action="/admin/site/product/importstore" method="post" target="_blank">
                      <textarea name="SKUARR"  cols="10" rows="10" ></textarea>  
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type="submit" name="submit" value="批量store sku导出" />
                    </form>
                </div>
                <div style="width:300px;float:left;">
                    <h4>产品信息批量导出</h4>
                    <form action="/admin/site/product/export_products_info" method="post" target="_blank">
                        <div><span style="color:#FF0000"></span>一行一个SKU</div>
                        <div><span>请输入产品SKU:</span><br>
                            <textarea name="SKUARR" cols="30" rows="20"></textarea>
                        </div>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </fieldset>
            <div style="float:left;">
                <a href="/admin/site/product/image_link_export">Export images link</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="/admin/site/model/list">Model List</a>
            </div>
            <div style="float:right;">
                <button onclick="location='/admin/site/product/no_sale';">Export No Sale products</button>
            </div>
            <br /><br />
            <form method="post" action="/admin/site/product/export_pro_sorts">
				<label for="export-start">From: </label>
				<input type="text" class="ui-widget-content ui-corner-all" id="export-from2" name="from">
				<label for="export-end">To: </label>
				<input type="text" class="ui-widget-content ui-corner-all" id="export-to2" name="to">
			
				<input type="submit" value="export_pro_sorts" name="Submit">
				<script type="text/javascript">
					$('#export-from2, #export-to2').datepicker({
						'dateFormat': 'yy-mm-dd'
					});
				</script>
			</form>
			<br />

            <form method="post" action="/admin/site/product/export_product_sorts">
                <label for="export-start">From: </label>
                <input type="text" class="ui-widget-content ui-corner-all" id="export-from3" name="from">
                <label for="export-end">To: </label>
                <input type="text" class="ui-widget-content ui-corner-all" id="export-to3" name="to">
            
                <input type="submit" value="导出产品数据" name="Submit">
                <script type="text/javascript">
                    $('#export-from3, #export-to3').datepicker({
                        'dateFormat': 'yy-mm-dd'
                    });
                </script>
            </form>
            <br />
            <form method="post" action="/admin/site/product/export_productspecific">
                <label for="export-start">From: </label>
                <input type="text" class="ui-widget-content ui-corner-all" id="export-from4" name="from">
                <label for="export-end">To: </label>
                <input type="text" class="ui-widget-content ui-corner-all" id="export-to4" name="to">
            
                <input type="submit" value="导出产品详情信息" name="Submit">
                <script type="text/javascript">
                    $('#export-from4, #export-to4').datepicker({
                        'dateFormat': 'yy-mm-dd'
                    });
                </script>
            </form>
            <br />
            <form method="post" action="/admin/site/product/export_productsmall">
                <label for="export-start">From: </label>
                <input type="text" class="ui-widget-content ui-corner-all" id="export-from5" name="from">
                <label for="export-end">To: </label>
                <input type="text" class="ui-widget-content ui-corner-all" id="export-to5" name="to">
            
                <input type="submit" value="导出产品详情(小语言用)" name="Submit">
                <script type="text/javascript">
                    $('#export-from5, #export-to5').datepicker({
                        'dateFormat': 'yy-mm-dd'
                    });
                </script>
            </form>
        </div>
    </div>
    <div style="font-size: 16px;font-weight:bold;">
    <?php
    $user_id = Session::instance()->get('user_id');
    $role_id = User::instance($user_id)->get('role_id');
    if($role_id <= 2)
    {
    ?>
        <a target="_blank" href="/admin/site/lookbook/attributes">分类产品筛选属性处理</a>
    <?php
    }
    ?>
    </div>
            <fieldset>
            <form method="post" action="/admin/site/product/upload_planame">
            <div style="width:270px;float:left;">
                <h4>批量修改产品PLA_NAME</h4>
                <div><span style="color:#FF0000" >注意： 格式如右:</span>CDZT4321212,Silver Open Deer Ring</div>
                <div><span>请输入:</span><br />
                 <textarea name="SKUARR"  cols="30" rows="15" ></textarea>      
                </div>
                <input type="submit" value="submit" id="products_relate" />  
                  </div>
              </form>
            <form method="post" action="/admin/site/product/jdzs" >
                            <div style="width:270px;float:left;">
                                <h4>批量传入JD后台产品</h4>
                                <div><span style="color:#FF0000" >注意： (一行一个SKU！！！)</span></div>
                                <div><span></span><br />

                                    <textarea name="SKUARR"  cols="30" rows="15" ></textarea>       
                                </div>
                                <input type="submit" value="submit" />
<!--                                                                        <input type="submit" value="Unrelate" id="products_unrelate" />-->
                            </div>
                            </form>
             <!-- 品类经理批量入库 2015-08-27 Ma-->
             <form method="post" action="/admin/site/product/catemanger" >
                <div style="width:270px;float:left;">
                    <h4>品类经理批量入库</h4>
                    <div><span style="color:#FF0000" >如：set,catemanger</span></div>
                    <div><span></span><br />
                        <textarea name="catemanger"  cols="30" rows="15" ></textarea>       
                    </div>
                    <input type="submit" value="submit" />
                    <!-- <input type="submit" value="Unrelate" id="products_unrelate" />-->
                </div>
             </form>
<!-- 产品条件导出： Ma 2015-08-28 --> 
         <fieldset>
            <form method="post" action="/admin/site/product/prolist_yy" enctype="multipart/form-data">
            <div>
                <h4>产品信息条件导出<small>根据上传excel数据进行数据匹配导出</small></h4>
                <span>请选择excel文件：</span><input type="file" name="excel_file"/>
                <input type="submit" value="开始执行" />
            </div>
            </form>
         </fieldset>

         <!-- 订单条件导表： Ma 2015-09-02 --> 
         <fieldset>
            <form method="post" action="/admin/site/product/tborder" enctype="multipart/form-data">
            <div>
                <h4>按条件导表<small>根据上传excel数据进行数据匹配导出</small></h4>
                <span>请选择excel文件：</span><input type="file" name="tb_file"/>
                <input type="submit" value="执行导表" />
            </div>
            </form>
         </fieldset>

              </fieldset>

              <fieldset>
                
                <div style="width:300px;float:left;">
                    <h4>导出Admin</h4>
                    <form action="/admin/site/product/export_admin_by_sku" method="post" target="_blank">
                        <div><span style="color:#FF0000"></span>一行一个SKU</div>
                        <div><span>请输入产品SKU:</span><br>
                            <textarea name="SKUARR" cols="30" rows="20"></textarea>       
                        </div>
                        <input type="submit" value="Submit">   
                    </form>
                    <br />
                    <h3><a href="/admin/site/product/product_stock_status">导出限制库存choies未上架尺码的产品</a></h3>
                    <br />
                    <h3><a href="/admin/site/product/export_productstatus">导出下架有库存的产品</a></h3>
                </div> 

                <div style="width:300px;float:left;">
                    <h4>注册有礼产品SKU修改</h4>
                    <form action="/admin/site/product/regist_sku" method="post" target="_blank">
                        <div><span>请输入产品SKU:格式(sku1,sku2)</span><br>
                            <input type="text" name="prosku" />      
                        </div>
                        <input type="submit" value="Submit">   
                    </form>
                </div>     

                <div style="width:300px;float:left;">
                    <h4>首页手机站底部推荐产品修改</h4>
                    <form action="/admin/site/product/uploadsku" method="post" target="_blank">
                        <div><span style="color:#FF0000"></span>一行一个SKU</div>
                        <div><span>请输入产品SKU:</span><br>
                            <textarea name="SKUARR" cols="30" rows="20"></textarea>       
                        </div>
                        <input type="submit" value="Submit">   
                    </form>
                </div>  

				<div style="width:300px;float:left;display:none">
					<a href="/admin/site/product/selectproduct">获取产品图片不满足3/4的产品</a>

                </div>
            </fieldset>
        <!-- 以下工作为抽奖 --> 
        <br><br><h2 style="color:red">抽奖后台管理功能</h2>
        <fieldset>
            <form method="post" action="/admin/site/product/draw_userlist">
            <div>
                <h4>批量导出获奖者名单</h4>
                <label for="export-start">From: </label>
                <input type="text" name="draw_from" id="export-from1" class="ui-widget-content ui-corner-all">
                <label for="export-end">To: </label>
                <input type="text" name="draw_to" id="export-to1" class="ui-widget-content ui-corner-all">
                <input type="submit" value="导出中奖报表">
            </div>
            </form>
        </fieldset>
        <script type="text/javascript">
            $('#export-from1, #export-to1').datepicker({
                'dateFormat': 'yy-mm-dd'
            });
        </script>
        
        <fieldset>
            <form method="post" action="/admin/site/product/draw_position">
            <div>
                <h4>获奖者录入</h4>
                <table>
                    <tr>
                        <td width="10%"><label for="export-start">User Email（邮箱）: </label></td>
                        <td><input type="text" name="email" class="ui-widget-content ui-corner-all" placeholder="中奖邮箱"></td>
                    </tr>
                    <tr>
                        <td><label for="export-end">Prize（奖项）: </label></td>
                        <td><input type="text" name="draw_name" class="ui-widget-content ui-corner-all" placeholder="奖品名称"></td>
                    </tr>
                    <tr>
                        <td><label for="export-end">Position（排序）: </label></td>
                        <td><input type="text" name="position" class="ui-widget-content ui-corner-all" placeholder="数字越小越靠前"></td>
                    </tr>
                    <tr>
                        <td><label for="export-end">Created Time（日期）: </label></td>
                        <td><input type="text" name="created" class="ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="获奖者录入"></td>
                    </tr>
                </table>
            </div>
            </form>
        </fieldset>
        
        <fieldset>
            <form method="post" action="/admin/site/product/draw_portion">
            <div>
                <h4>抽奖参与奖项录入</h4>
                <table>
                    <tr>
                        <td><label for="export-end">Prize（奖项）: </label></td>
                        <td><input type="text" name="draw_name" class="ui-widget-content ui-corner-all" placeholder="奖品名称"></td>
                    </tr>
                    <tr>
                        <td><label for="export-end">Prize（折扣券ID）: </label></td>
                        <td><input type="text" name="coupon_id" class="ui-widget-content ui-corner-all" placeholder="折扣券ID"></td>
                    </tr>
                    <tr>
                        <td width="13%"><label for="export-start">Probability（概率）: </label></td>
                        <td><input type="text" name="probability" class="ui-widget-content ui-corner-all" placeholder="中奖概率"></td>
                    </tr>
                    <tr>
                        <td><label for="export-end">created（日期）: </label></td>
                        <td><input type="text" name="created" class="ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" placeholder="添加日期"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="奖项概率录入"><input type="button" value="概率修改" onclick="drawup()"></td>
                    </tr>
                </table>
            </div>
            </form>
        </fieldset>
        
        
        <fieldset id="draw_up" style="display:none">
            <div>
                <h4>奖项概率列表</h4>
                <table id="list">
                    <tr>
                        <th>ID（编号）</th>
                        <th>Prize（奖项）</th>
                        <th>Probability（概率）</th>
                        <th>Coupon_id（折扣券ID）</th>
                        <th>created（日期）</th>
                        <th>操作</th>
                    </tr>
                </table>
            </div>
        </fieldset>
        
        
        <!-- <td><a href='javascript:;' data-id='"+item.id+"' data-pro='"+item.probability+"'>概率更改</a></td> -->
        <script type="text/javascript">
        function drawup(){
            $("#draw_up").fadeIn();
            var strVar = "";
            $.post('/admin/site/product/drawlist',function(data)
            {             
                strVar += "<tr>";
                strVar += "<th>ID（编号）<\/th>";
                strVar += "<th>Prize（奖项）<\/th>";
                strVar += "<th>Probability（概率）<\/th>";
                strVar += "<th>Coupon_id（折扣券ID）<\/th>";
                strVar += "<th>created（日期）<\/th>";
                strVar += "<\/tr>"; 
                $.each(data, function(i, item) {
                    strVar += "<tr><td>"+item.id+"</td><td>"+item.draw_name+"</td><td><input type='text' value='"+item.probability+"%' onchange='changeNum(this, "+item.id+")'/></td><td>"+item.coupon_id+"</td><td>"+item.created+"</td></tr>";    
                });
                $("#list").empty().append(strVar);
            },"json")
        }

        function changeNum(obj, id){
            var Probability = $(obj).val();
            $.post('/admin/site/product/drawlist',{babil:Probability,id:id,type:"edit"},function(data){})
        }
        </script>              
</div>
