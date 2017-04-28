<form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $procurement['id']; ?>" />
        <table cellspacing="1" cellpadding="1" border="0">
        <?php
        foreach($procurement as $key => $val):
                if($key == 'id')
                        continue;
        ?>
                <tr><td><strong><?php echo $key; ?>:</strong></td><td><input type="text" style="width:400px;" name="<?php echo $key; ?>" value="<?php echo $val; ?>" /></td></tr>
        <?php
        endforeach;
        ?>
        </table>
        <br>
        <input style="margin-left:205px;" type="submit" value="submit" />
</form>
