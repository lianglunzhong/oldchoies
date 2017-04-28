<?php echo View::factory('admin/site/basic_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/set_admin.js"></script>
<div id="do_right">
    <form method="post" action="#" name="form_add_set" class="need_validation">
        <div class="box">
            <h3>Set Edit</h3>

            <ul>
                <li>
                    <label>Name<span class="req">*</span></label>
                    <div><input name="set[name]" id="name" class="short text required" type="text" value="<?php echo $data->name; ?>"></div>
                </li>

                <li>
                    <label>Label</label>
                    <div><input name="set[label]" class="short text" type="text" value="<?php echo $data->label; ?>"></div>
                </li>

                <li>
                    <label>Biref</label>
                    <div><input name="set[brief]" class="short text" type="text" value="<?php echo $data->brief; ?>"></div>
                </li>
                <li class="clr">
                    <div  class="attributes_ul_box">
                        <h4 class="ul_title">Current attributes ( <span id="select_num"><?php echo $attributes_current->count(); ?></span> ) :</h4>
                        <ul id="attributes_inside" class="attributes_box">
<?php
$attributes_current_ids = array( );
foreach( $attributes_current as $attribute )
{
?>
                                <li class="attribute_drag_item" attr_id="<?php echo $attribute->id; ?>">
                                    <a href="#" class="remove_attribute" title="Remove"></a><div><?php echo $attribute->name; ?></div>
                                    <input type="hidden" name="set[attribute][]" value="<?php echo $attribute->id; ?>"/>
                                </li>
<?php
    $attributes_current_ids[] = $attribute->id;
}
?>

                        </ul>
                    </div>
                    <div class="jqgrid_little_box">
                        <h4 class="ul_title">Add new attributes:</h4>
                        <table id="toolbar"></table>
                        <div id="ptoolbar"></div>
                    </div>
                </li>

                <li>
                    <button type="submit">Save</button>
                </li>

            </ul>
        </div>
    </form>
</div>

<script type="text/javascript">
attribute_ids = <?php echo json_encode($attributes_current_ids);?>;
</script>
