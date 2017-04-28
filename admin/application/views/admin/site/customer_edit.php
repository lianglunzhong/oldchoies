<div id="do_content" class="box">
    <h3>编辑客户信息</h3>
	<div id="customer-edit-tabs">
        <ul>
            <li><a href="#customer-edit-basic">基本</a></li>
            <li><a href="#customer-edit-affiliate">联盟</a></li>
            <li><a href="#customer-edit-point">积分</a></li>
        </ul>
        <div id="customer-edit-basic">
            <?php print $customer_edit_basic; ?>
        </div>
        <div id="customer-edit-affiliate">
            <?php print $customer_edit_affiliate; ?>
        </div>
        <div id="customer-edit-point">
            <?php print $customer_edit_point; ?>
        </div>
	</div>
    <script type="text/javascript">
        $('#customer-edit-tabs').tabs({
            select: function(event, ui) {
                window.location.hash = ui.tab.href.split('#')[1];
            }
        });

        if (window.location.hash) {
            $('#customer-edit-tabs').tabs('select', window.location.hash);
        }
    </script>
</div>
