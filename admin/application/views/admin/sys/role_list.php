<?php echo View::factory('admin/sys/sys_left')->render(); ?>
<div id="do_right">
<div class="box">
<h3><span class="moreActions">
<a href="/admin/sys/role/add" >Add Role</a></span>Role List</h3>
<link rel="stylesheet" href="/media/js/jquery.treeview/jquery.treeview.css" />

<script src="/media/js/jquery.treeview/jquery.treeview.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
    $("#role_list").treeview({
        toggle: function() {
            console.log("%s was toggled.", $(this).find(">span").text());
        }
    });
});
</script>
<?php
function view($id = 1)
{
    $role = ORM::factory('role',$id);
    if(!$role->loaded()) return;

    if($id = 1)
    {
        echo '<ul id="role_list" class="filetree treeview-famfamfam">';
    }
    else
    {
        echo '<ul>';
    }
    echo '<li><span class="file">'.$role->name.'('.$role->brief.')<a href="/admin/sys/role/edit/'.$role->id.'"> Edit </a></span>';
    $roles = ORM::factory('role')->where('parent_id','=',$role->id)->find_all();
    foreach($roles as $item)
    {
        view($item->id);
    }
    '</li>';
    echo '</ul>';
}
$roles = DB::select('id')->from('roles')->where('id', '>', 0)->execute();
foreach($roles as $role)
{
        view($role['id']);
}
?>
<!-- 
    <ul id="role_list" class="filetree treeview-famfamfam">
        <li><span class="folder">Folder 1<a href="#">edit</a></span>
            <ul>
                <li><span>Item 1.1</span>
                    <ul>
                        <li><span>Item 1.1.1</span></li>
                    </ul>
                </li>
                <li><span>Folder 2</span>
                    <ul>
                        <li><span>Subfolder 2.1</span>
                            <ul id="folder21">
                                <li><span class="file">File 2.1.1</span></li>
                                <li><span class="file">File 2.1.2</span></li>
                            </ul>
                        </li>
                        <li><span class="folder">Subfolder 2.2</span>
                            <ul>
                                <li><span class="file">File 2.2.1</span></li>
                                <li><span class="file">File 2.2.2</span></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="closed"><span class="folder">Folder 3 (closed at start)</span>
                    <ul>
                        <li><span class="file">File 3.1</span></li>
                    </ul>
                </li>
                <li><span class="file">File 4</span></li>
            </ul>
        </li>
    </ul>
-->

</div>
</div>

