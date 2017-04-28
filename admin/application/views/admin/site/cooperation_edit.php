<?php echo View::factory('admin/site/feedback_left')->render(); ?>
<div id="do_right">
    <div class="box" style="overflow:hidden;">
        <div class="requirement">
            <div class="require">
			<style>
			.requirement { background:#FFF; width:740px; padding:10px 0; margin:10px;}
			.require { width:740px; margin:auto;}
			.formbg { width:740px; margin:0 auto; padding:10px 5x;}
			.formbg h3 { width:98%; text-align:center; margin:0 auto; padding:10px 0px; border-bottom:1px dotted #111;}
			.formbg ul li { padding-bottom:9px; margin: 0;} 
			.formbg ul li select { width:544px; padding:1px 0px; font:12px/16px Arial;}
			.formbg ul li label { font:12px/18px Arial; color:#000; display:inline-block; width:100px; text-align:right; position:relative; *top:-4px;}
			.formbg ul li input { width:540px; padding:6px 0px 6px 3px; border:1px solid #b0c4df; font-family:Arial; font-size:12px; border-radius:3px;}
			.formbg ul li .otherbox { margin-left:3px; height:100px; width:540px; resize:none; padding:6px 0px 6px 3px; border:1px solid #b0c4df; font-family:Arial; font-size:12px; border-radius:3px;}
			.formbg ul .reqsubmit { width:86px; height:25px; cursor:pointer;color: #08C;font-weight: bold;background: #F8F8F8;}
			.formbg li .redsize { font:bold 12px/18px Arial; color:#f00;}
			</style>
                <div class="formbg">
                    <h3>供应商信息</h3>
                    <form action="/admin/site/cooperation/edit/<?php echo $content['id']; ?>" method="POST">
                        <ul>
                            <li><label><span class="redsize">*</span>公司名称:</label> <input type="text" name="name" value="<?php echo $content['name']; ?>" /></li>
                            <li>
                                <label><span class="redsize">*</span>主营品类:</label>
                                <select name="cata">
                                    <?php
                                        $options = array( '游戏配件', '手机配件', '电脑配件', '摄影器材', '家居产品', '服饰配件',
                                                        '美容美发', '儿童玩具', '汽车配件', '工艺品珠宝', '户外运动用品', '其它' );
                                        foreach ( $options as $option )
                                        {
                                            if ( $content['cata'] == $option )
                                            {
                                                echo '<option selected="selected">'.$option.'</option>';
                                            }
                                            else
                                            {
                                                echo '<option>'.$option.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </li>
                            <li><label><span class="redsize">*</span>所在省份:</label> <input type="text" name="state" value="<?php echo $content['state']; ?>" /></li>
                            <li><label><span class="redsize">*</span>所在城市:</label> <input type="text" name="city" value="<?php echo $content['city']; ?>" /></li>
                            <li><label>邮编:</label> <input type="text" name="code" value="<?php echo $content['code']; ?>" /></li>
                            <li><label>通信地址:</label> <input type="text" name="add" value="<?php echo $content['add']; ?>" /></li>
                            <li><label>传真:</label> <input type="text" name="num" value="<?php echo $content['num']; ?>" /></li>
                            <li><label>公司主页:</label> <input type="text" name="page" value="<?php echo $content['page']; ?>" /></li>
                            <li><label><span class="redsize">*</span>联系人:</label> <input type="text" name="people" value="<?php echo $content['people']; ?>" /></li>
                            <li><label><span class="redsize">*</span>负责人电话:</label> <input type="text" name="tele" value="<?php echo $content['tele']; ?>" /></li>
                            <li><label>QQ:</label> <input type="text" name="qqnum" value="<?php echo $content['qqnum']; ?>" /></li>
                            <li><label>MSN:</label> <input type="text" name="msn" value="<?php echo $content['msn']; ?>" /></li>
                            <li><label>Skype:</label> <input type="text" name="skype" value="<?php echo $content['skype']; ?>" /></li>
                            <li><label>其他网络联系方式:</label> <input type="text" name="other_link" value="<?php echo $content['other_link']; ?>" /></li>
                            <li class="fix"><label class="fll">备注:</label> <textarea class="otherbox fll" name="other_info"><?php echo $content['other_info']; ?></textarea></li>
                            <li><label></label><input type="submit" class="reqsubmit" name="" value="SAVE" /></li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>