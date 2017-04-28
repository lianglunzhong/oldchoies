<style type="text/css">
        .pp1{color:#666;font-size: 12px; }
</style>
<div id="do_content">
        <div class="box" style="overflow:hidden;">
                <h3>Products Pickers Statistics&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin/site/orderproduct/list" target="_blank">订单产品销量统计</a>
                        <fieldset>
                        <legend style="font-weight:bold">选款人上新统计表(check product create time)</legend>
                        <form id="frm-taobao-export" method="post" action="/admin/site/product/offline_picker" target="_blank">
                        <input type="hidden" value="1" name="action">
                                <label for="export-start1">From: </label>
                                <input type="text" name="start" id="export-start1" class="ui-widget-content ui-corner-all" />
                                <label for="export-end1">To: </label>
                                <input type="text" name="end" id="export-end1" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
                        </form>
                        </fieldset>
                        <script type="text/javascript">
                        $('#export-start1, #export-end1').datepicker({
                                'dateFormat': 'yy-mm-dd'
                        });
                        </script>

                </h3>
                <h3>
                        <fieldset>
                        <legend style="font-weight:bold">选款人销售sku数据(check order verify time)</legend>
                        <form id="frm-taobao-export" method="post" action="/admin/site/product/offline_picker" target="_blank">
                        <input type="hidden" value="2" name="action">
                                <label for="export-start2">From: </label>
                                <input type="text" name="start" id="export-start2" class="ui-widget-content ui-corner-all" />
                                <label for="export-end2">To: </label>
                                <input type="text" name="end" id="export-end2" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
                        </form>
                        </fieldset>
                        <script type="text/javascript">
                        $('#export-start2, #export-end2').datepicker({
                                'dateFormat': 'yy-mm-dd'
                        });
                        </script>
                        
                </h3>
                <h3>
                        <fieldset>
                        <legend style="font-weight:bold">选款人上新产品销量统计(check  product create time)</legend>
                        <form id="frm-taobao-export" method="post" action="/admin/site/product/offline_picker" target="_blank">
                        <input type="hidden" value="3" name="action">
                                <label for="export-start3">From: </label>
                                <input type="text" name="start" id="export-start3" class="ui-widget-content ui-corner-all" />
                                <label for="export-end3">To: </label>
                                <input type="text" name="end" id="export-end3" class="ui-widget-content ui-corner-all" />
                                <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
                        </form>
                        </fieldset>
                        <script type="text/javascript">
                        $('#export-start3, #export-end3').datepicker({
                                'dateFormat': 'yy-mm-dd'
                        });
                        </script>
                </h3>
        </div>
</div>
