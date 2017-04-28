
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<div id="do_content">

    <div class="box" style="overflow:hidden;">
        <p>User Log Export
        <br />默认导出从前一天到现在的数据
            <div style="margin:20px;">
            <h2>导出所有产品数据</h2>
             <form action="/admin/site/webpower/itemlist_export" method="post">
                    <span>日期:</span>
                    <label>From: </label><input type="text" name="start" class="ui-widget-content ui-corner-all time-to time-to" />
                    <input type="submit" name="Submit" value="导出" />
                </form>
            </div>
            <div style="margin:20px;">
            <h2>导出piwik数据</h2>
                <form action="/admin/site/webpower/userlog_export" method="post">
                    <span>日期:</span>
                    <label>From(小): </label><input type="text" name="start" class="ui-widget-content ui-corner-all time-to time-to" />
                    <label>To(大): </label><input type="text" name="end" class="ui-widget-content ui-corner-all time-to time-to" />
                    <input type="submit" name="Submit" value="导出" />
                </form>
            </div>
            <div style="margin:20px;">
            <h2>导出站内数据</h2>
                <form action="/admin/site/webpower/customer_export" method="post">
                    <span>日期:</span>
                    <label>From(小): </label><input type="text" name="start" class="ui-widget-content ui-corner-all time-to time-to" />
                    <label>To(大): </label><input type="text" name="end" class="ui-widget-content ui-corner-all time-to time-to" />
                    <input type="submit" name="Submit" value="导出" />
                </form>
            </div>
            <div style="margin:20px;">
            <h2>导出google products数据</h2>
            <a href="/admin/site/webpower/googleproduct_export"><input type="button" value="导出" /></a>
            </div>

                <script type="text/javascript">
                    Date.prototype.pattern = function(fmt) {
                        var o = {
                            "M+": this.getMonth() + 1, //月份         
                            "d+": this.getDate(), //日         
                            "h+": this.getHours() % 12 == 0 ? 12 : this.getHours() % 12, //小时         
                            "H+": this.getHours(), //小时         
                            "m+": this.getMinutes(), //分         
                            "s+": this.getSeconds(), //秒         
                            "q+": Math.floor((this.getMonth() + 3) / 3), //季度         
                            "S": this.getMilliseconds() //毫秒         
                        };
                        var week = {
                            "0": "/u65e5",
                            "1": "/u4e00",
                            "2": "/u4e8c",
                            "3": "/u4e09",
                            "4": "/u56db",
                            "5": "/u4e94",
                            "6": "/u516d"
                        };
                        if (/(y+)/.test(fmt)) {
                            fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
                        }
                        if (/(E+)/.test(fmt)) {
                            fmt = fmt.replace(RegExp.$1, ((RegExp.$1.length > 1) ? (RegExp.$1.length > 2 ? "/u661f/u671f" : "/u5468") : "") + week[this.getDay() + ""]);
                        }
                        for (var k in o) {
                            if (new RegExp("(" + k + ")").test(fmt)) {
                                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
                            }
                        }
                        return fmt;
                    }

                    $('.time-to').datepicker({
                        dateFormat: 'yy-mm-dd',
                        yearRange: '2000:2020',
                        defaultDate: "+1w",
                        changeMonth: true,
                        changeYear: true,
                    });

                    //$('.time-to').val(new Date().pattern("yyyy-MM-dd"));
                </script>
            
        </p>
    </div>
</div>
