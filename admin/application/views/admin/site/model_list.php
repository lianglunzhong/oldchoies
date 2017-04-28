<script type="text/javascript" src="/media/js/my_validation.js"></script>
<div>
    <div class="box">
        <h3>模特信息列表</h3>
        <div>
            <form action="/admin/site/model/add" method="post" class="need_validation" id="fee_add">
                <input type="hidden" name="id" value="0" id="model_id" />
                <label for="name">Name: </label>
                <input type="text" class="text small required" id="name" name="name">
                &nbsp;&nbsp;<label for="height">Height(cm): </label>
                <input type="text" class="text small required" id="height" name="height" style="width: 60px;">
                &nbsp;&nbsp;<label for="bust">Bust(cm): </label>
                <input type="text" class="text small required" id="bust" name="bust" style="width: 60px;">
                &nbsp;&nbsp;<label for="waist">Waist(cm): </label>
                <input type="text" class="text small required" id="waist" name="waist" style="width: 60px;">
                &nbsp;&nbsp;<label for="hip">Hip(cm): </label>
                <input type="text" class="text small required" id="hip" name="hip" style="width: 60px;">
                <input type="submit" style="padding:0 .5em" class="ui-button" value="Add">
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Height</th>
                    <th scope="col">Bust</th>
                    <th scope="col">Waist</th>
                    <th scope="col">Hip</th>
                    <th scope="col">Created</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($models as $model)
                {
                    ?>
                    <tr>
                        <td><?php print $model['id']; ?></td>
                        <td class="name"><?php print $model['name']; ?></td>
                        <td class="height"><?php print $model['height']; ?></td>
                        <td class="bust"><?php print $model['bust']; ?></td>
                        <td class="waist"><?php print $model['waist']; ?></td>
                        <td class="hip"><?php print $model['hip']; ?></td>
                        <td><?php print date('Y-m-d H:i:s', $model['created']); ?></td>
                        <td>
                            <a href="/admin/site/model/edit/<?php print $model['id']; ?>" title="<?php print $model['id']; ?>" class="edit">修改</a>
                            <a href="/admin/site/model/delete/<?php print $model['id']; ?>" onclick="return window.confirm('delete?');">删除</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <script>
            $(function(){
                $(".edit").click(function(){
                    var id = $(this).attr('title');
                    $model = $(this).parent().parent();
                    var name = $model.find('.name').text();
                    var height = $model.find('.height').text();
                    var bust = $model.find('.bust').text();
                    var waist = $model.find('.waist').text();
                    var hip = $model.find('.hip').text();
                    $("#model_id").val(id);
                    $("#name").val(name);
                    $("#height").val(height);
                    $("#bust").val(bust);
                    $("#waist").val(waist);
                    $("#hip").val(hip);
                    return false;
                })
            })
            </script>
        </table>
    </div>
</div>
