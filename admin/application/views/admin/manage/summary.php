<?php echo View::factory('admin/manage/left')->render(); ?>
<script type="text/javascript">
    $(function() {
        $("#tabs").tabs();
    });
</script>
<div id="do_right">
    <div class="box">
        <h3>Summary</h3>
        <div id="tabs" style="margin-bottom: 10px;">
            <ul>
                <li><a href="#tabs-1">订单</a></li>
                <li><a href="#tabs-2">产品</a></li>
                <li><a href="#tabs-3">流量</a></li>
            </ul>
            <div id="tabs-1">
                <table>
                    <tr>
                        <td>订单类型</td>
                        <td>06-25</td>
                        <td>06-26</td>
                        <td>06-27</td>
                        <td>06-28</td>
                        <td>06-29</td>
                        <td>06-30</td>
                        <td>07-01</td>
                    </tr>
                    <tr>
                        <td>已支付</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                    </tr>
                    <tr>
                        <td>未支付</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                    </tr>
                </table>
            </div>
            <div id="tabs-2">
                <table>
                    <tr>
                        <td>操作</td>
                        <td>06-25</td>
                        <td>06-26</td>
                        <td>06-27</td>
                        <td>06-28</td>
                        <td>06-29</td>
                        <td>06-30</td>
                        <td>07-01</td>
                    </tr>
                    <tr>
                        <td>产品上架</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                    </tr>
                    <tr>
                        <td>产品下架</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                    </tr>
                    <tr>
                        <td>产品总数</td>
                        <td>1200</td>
                        <td>1200</td>
                        <td>1200</td>
                        <td>1200</td>
                        <td>1200</td>
                        <td>1200</td>
                        <td>1200</td>
                    </tr>
                </table>
            </div>
            <div id="tabs-3">
                <table>
                    <tr>
                        <td>类型</td>
                        <td>06-25</td>
                        <td>06-26</td>
                        <td>06-27</td>
                        <td>06-28</td>
                        <td>06-29</td>
                        <td>06-30</td>
                        <td>07-01</td>
                    </tr>
                    <tr>
                        <td>搜索引擎</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                    </tr>
                    <tr>
                        <td>网络红人</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                        <td>120</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>