<?php echo View::factory('admin/sys/sys_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script>
$(function(){
        $("#role").change(function(){
                var role = $(this).val();
                $("#parent").children().hide();
                $("#parent").find(".user_"+role).show();
                $("#parent .user_0").show();
                if(role == 8)
                {
                    $("#small_language").show();
                }
                else
                {
                    $("#small_language").hide();
                }
        });
})
</script>
<div id="do_right">
        <div class="box">
                <h3>Edit <?php echo $data['name']; ?></h3>

                <form action=" " method="post" id="form1" class="need_validation">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <ul>

                                <li>
                                        <label>Email：<span class="req">*</span></label>
                                        <div>
                                                <input class="text short required email" id="email" name="email" value="<?php echo $data['email']; ?>" type="text">
                                                <div class="errorInfo"></div>
                                        </div>
                                </li>

                                <li>
                                        <label>Name:</label>
                                        <div>
                                                <input class="text short" type="text" id="name" name="name" value="<?php echo $data['name']; ?>">
                                                <div class="errorInfo"></div>
                                        </div>
                                </li>

                                <li>
                                        <label>Password:</label>
                                        <div>
                                                <input class="text short" data="{validation:{minlength:5}}" type="password" id="password" name="password" value="">
                                                <div class="errorInfo"></div>
                                        </div>
                                </li>

                                <li>
                                        <label>Role:</label>
                                        <div>
                                                <select name="role_id" id="role">
                                                        <?php
                                                        $roles = ORM::factory('role')->find_all();
                                                        foreach ($roles as $role)
                                                        {
                                                                ?>
                                                                <option value="<?php echo $role->id; ?>" <?php if ($data['role_id'] == $role->id)
                                                        { ?>selected<?php } ?>><?php echo $role->name; ?>(<?php echo $role->brief; ?>)</option>
                                                                <?php
                                                        }
                                                        ?>
                                                </select>
                                        </div>
                                </li>
                                
                                <li id="small_language" <?php if($data['role_id'] != 8) echo 'style="display:none;"'; ?>>
                                        <label>Small Language:</label>
                                        <div>
                                                <select name="small_lang">
                                                    <option value=""></option>
                                                <?php
                                                $languages = Kohana::config('sites.'.Session::instance()->get('SITE_ID').'.language');
                                                foreach($languages as $lang):
                                                    if($lang == 'en')
                                                        continue;
                                                    ?>
                                                    <option value="<?php echo $lang; ?>"><?php echo $lang; ?></option>
                                                    <?php
                                                endforeach;
                                                ?>
                                                </select>
                                        </div>
                                </li>

                                <li>
                                        <label>Parent:</label>
                                        <div>
                                                <select name="parent_id" id="parent" class="required">
                                                        <option value=""></option>
                                                        <?php
                                                        $users = ORM::factory('user')->order_by('role_id')->find_all();
                                                        foreach ($users as $user)
                                                        {
                                                                ?>
                                                                <option value="<?php echo $user->id; ?>" 
                                                                        <?php if($data['parent_id'] == $user->id) echo 'selected'; ?> 
                                                                        class="user_<?php echo $user->role_id; ?>" <?php if($user->role_id != $data['role_id']) echo 'style="display:none;"'; ?>>
                                                                                <?php echo $user->name; ?>
                                                                </option>
                                                                <?php
                                                        }
                                                        ?>
                                                </select>
                                        </div>
                                </li>

                                <li>
                                        <label>Lang:</label>
                                        <div>
                                                <select name="lang">
                                                        <option value="zh">zh</option>
                                                        <option value="en">en</option>
                                                </select>
                                        </div>
                                </li>

                                <li>
                                        <label>状态:</label>
                                        <div>
                                                <select name="active">
                                                        <option value="1" <?php if ($data['active'])
                                                        { ?>selected<?php } ?>>可用</option>
                                                        <option value="0" <?php if (!$data['active'])
                                                        { ?>selected<?php } ?>>不可用</option>
                                                </select>
                                        </div>
                                </li>

                                <li>
                                        <div><input type="submit" value="Save"/></div>
                                </li>
                        </ul>
                </form>
        </div>
</div>

