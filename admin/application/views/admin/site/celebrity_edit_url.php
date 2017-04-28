<link type="text/css" href="/media/js/jquery-ui/jquery-ui-1.8.1.custom.css" rel="stylesheet" id="uistyle" />
<script type="text/javascript" src="/media/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" src="/media/js/daterangepicker.jQuery.js"></script>
<script type="text/javascript" src="/media/js/jquery-ui-1.8.1.custom.min.js"></script>
<link rel="stylesheet" href="/media/css/ui.daterangepicker.css" type="text/css" />
<script id="date"></script>
<script type="text/javascript">
    $(function(){
        $('#add_more').click(function(){
            $tr = '<tr><td>New Url: </td><td><input name="newurl[]" value="" />&nbsp;&nbsp;<td>Date: </td><td><input name="new_date[]" class="date1" value="" />&nbsp;&nbsp;<a href="#" class="delete">删除</a></td></tr>';
            $(this).parent().parent().parent().append($tr);
            $("#date").html(function(){
                $('.date1').datepicker({
                    'dateFormat': 'yy-mm-dd'
                });
            });
        })
                
        $('.delete').live('click',function(){
            $(this).parent().parent().remove();
            return false;
        });
                
        $('.delete1').live('click',function(){
            $(this).parent().parent().remove();
            var url = $(this).attr('title');
            var delete_url = '<input type="hidden" name="delete_url[]" value="'+url+'" />';
            $('#delete_url').append(delete_url);
            return false;
        })
    })
</script>
<form action="" method="post">
    <input type="hidden" name="celebrity_id" value="<?php echo $celebrity_id; ?>" />
    <input type="hidden" name="ordernum" value="<?php echo $ordernum; ?>" />
    <input type="hidden" name="sku" value="<?php echo $sku; ?>" />
    <input type="hidden" name="query_string" value="<?php echo $query_string; ?>" />
    <div id="delete_url"></div>
    <table cellspacing="1" cellpadding="1" border="0">
        <tr><td colspan="4"><strong>Celebrity: <?php echo $celebrity_email; ?></strong></td></tr>
        <tr><td colspan="4"><strong>SKU: <?php echo $sku; ?></strong></td></tr>
        <?php
        if ($url)
        {
            foreach ($url as $u)
            {
                ?>
                <tr>
                    <td>Url: </td><td><input name="url[<?php echo $u['id']; ?>]" value="<?php echo $u['url']; ?>" /></td><td>Date: </td><td><input name="show_date[<?php echo $u['id']; ?>]" class="date" value="<?php echo date('Y-m-d H:i:s', $u['show_date']); ?>" /></td><td><a href="#" title="<?php echo $u['url']; ?>" class="delete1">删除</a></td>
                </tr>
                <?php
            }
        }
        ?>
        <tr><td><a href="#" id="add_more" count="1">+更多Url</a></td></tr>
    </table>
    <br>
    <input type="submit" value="submit" />
</form>
<script type="text/javascript">
    $('.date').datepicker({
        'dateFormat': 'yy-mm-dd'
    });
</script>
