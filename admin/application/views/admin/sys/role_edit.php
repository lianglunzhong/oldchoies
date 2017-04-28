<?php echo View::factory('admin/sys/sys_left')->render(); ?>
<div id="do_right">
<div class="box">
<h3>
<span class="moreActions">
<a href="/admin/sys/role/add" >Add Role</a>
</span>
Edit <?php echo $role['name']; ?> Role
</h3>

<form action="/admin/sys/role/edit/<?php echo $data->id; ?>" method="post" class="need_validation">
<ul>
<li>
<label>name:<span class="req">*</span></label>
<div><input class="short text required" id="name" name="name" value="<?php echo $data->name; ?>" type="text"></div>
</li>

<li>
<label>brief:</label>
<div><input class="short text required email" type="text" id="brief" name="brief" value="<?php echo $data->brief; ?>"></div>
</li>

<li>
<label>parent:</label>
<div>
        <select id="parent_id" name="parent_id">
                <option value="0">root</option>
                <?php
                $roles = ORM::factory('role')->find_all();
                foreach ($roles as $item)
                {
                        ?>
                        <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                        <?php
                }
                ?>
        </select>
        <script type="text/javascript">
                $(function(){
                        $("#parent_id option[value='<?php echo $data->parent_id; ?>']").attr("selected" , "selected");
                        $("#parent_id option[value='<?php echo $data->id; ?>']").remove();
                });
        </script>
</div>
</li>

<li>
<label>Lines:</label>
<div><input class="short text " type="text" id="lines" name="lines" value="<?php echo $data->lines; ?>"></div>
</li>

<li style="float:left;width:300px;">
<label>View Pages:</label>
<ul>
        <?php
        $pages = kohana::config('roles.pages');
        $views = $data->views ? unserialize($data->views) : array();
        foreach ($pages as $name => $link)
        {
                ?>
                <li style="width:150px;">
                        <input type="checkbox" name="views[]" value="<?php echo $link; ?>" onchange="role_selectall(this)" <?php if(in_array($link,$views)) echo 'checked="checked"'; ?>><?php echo $name; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                        <script type="text/javascript">
                                function role_selectall(Obj){
                                        if($(Obj).attr("checked")==true){
                                                $(Obj).parent().parent().children("input[@type='checkbox']").each(function(){
                                                        $(this).attr("checked", true);
                                                })
                                        }else{
                                                $(Obj).parent().parent().children("input[@type='checkbox']").each(function(){
                                                        $(this).attr("checked", false);
                                                })
                                        }
                                }
                        </script>
                </li>
                <?php
        }
        ?>
</ul>
</li>

<li style="float:left;">
<label>Edit Pages:</label>
<ul>
        <?php
        $edits = $data->views ? unserialize($data->edits) : array();
        foreach ($pages as $name => $link)
        {
                ?>
                <li style="width:150px;">
                        <input type="checkbox" name="edits[]" value="<?php echo $link; ?>" onchange="role_selectall(this)" <?php if(in_array($link,$edits)) echo 'checked="checked"'; ?>><?php echo $name; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                        <script type="text/javascript">
                                function role_selectall(Obj){
                                        if($(Obj).attr("checked")==true){
                                                $(Obj).parent().parent().children("input[@type='checkbox']").each(function(){
                                                        $(this).attr("checked", true);
                                                })
                                        }else{
                                                $(Obj).parent().parent().children("input[@type='checkbox']").each(function(){
                                                        $(this).attr("checked", false);
                                                })
                                        }
                                }
                        </script>
                </li>
                <?php
        }
        ?>
</ul>
</li>

<li style="clear:both;">
<div><input type="submit" value="submit"/></div>
</li>
</ul>
</form>

</div>
</div>

