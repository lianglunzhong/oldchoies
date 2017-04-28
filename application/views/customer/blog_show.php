<style>
    /*MY BLOG SHOW*/
    .tab li,.tab-con{position:relative;border:1px solid #CCC;}
    .tab li{float:left;margin:18px 5px 0 0;padding:0 20px;background:#efeeee;border-bottom:none;height:32px;line-height:32px;color:#999;cursor:pointer;}
    .tab li.on{background:#FFF;color:#333;}
    .tab-con{min-height:600px;padding:15px;top:-1px;}
    .tab-con li{display:none;}
    .tab-con li p{line-height:18px;}
    .tab-con .page2{border:none;}
    .tab-con .page2 .pr-nums{text-decoration:none;}
    .tab-con .pr-nums a{color:#F00;font-weight:bold;}
    .tab-con .orderTable{margin:12px 0 0;width:100%;}
    .tab-con th{border:1px solid #EFEFEF;}
    .tab-con td{padding:9px;text-align:left;vertical-align:middle;border: 1px solid #efefef;margin: 0;}
    .tab-con td.listNumber{text-align:center;width:60px;}
    .tab-con .orderTable dd {width:220px;}
    .pr-info dt,.pr-info dd{float:left;}
    .pr-info dt img{height:92px;width:69px;border:1px solid #CCC;}
    .pr-info dd{overflow:hidden;*display:block;*width:224px;padding:2px 0 0 10px;color:#666;}
    .pr-info dd a,.showLinkhref{text-decoration:underline;cursor:pointer;}
    .pr-info dd input{*display:block;margin-top:5px;height:17px;width:101px;background:url(../images/myblog_bg.png) no-repeat;cursor:pointer;}
    .show-link dd{display:block;padding:5px 0 3px 0;}
    .link-input{margin-top:5px;padding:0 4px;width:300px;height:24px;line-height:24px;border:1px solid #DEDEDE;}
    .addMoreLink,.link-btn,.link-edit{display:block;background:url(../images/myblog_bg.png) no-repeat;}
    .addMoreLink{padding-left:15px;height:18px;background-position:0 -40px;color:#FF0000;cursor:pointer;text-decoration:underline;}
    .link-btn{width:68px;height:24px;background-position:0 -19px;cursor:pointer;}
    .showLinkhref{display:block;margin-bottom:8px;color:#3366cc;line-height:14px;}
    .link-edit{position:relative;top:-5px;height:16px;width:54px;background-position:0 -63px;cursor:pointer;}
    .orderTable caption {line-height: 35px;text-align: left;color: #666;}
    .orderTable th {background-color: #efefef;color: #333;line-height: 28px;font-weight: bold;}
    .orderTable td {vertical-align: middle;color: #333;}
</style>
<?php
$message = Message::get();
$url1 = parse_url($_SERVER['HTTP_REFERER']);

$onshowed = 0;
if ($message)
{
    $onshowed = 1;
}
elseif ($url1['path'] == $_SERVER['REDIRECT_URL'])
{
    parse_str($url1['query'], $query1);
    parse_str($_SERVER['QUERY_STRING'], $query2);
    $_page2 = Arr::get($query1, 'page2', 1);
    $page2 = Arr::get($query2, 'page2', 1);
    if ($_page2 != $page2)
        $onshowed = 1;
}
$c_admin = DB::select('admin')->from('celebrities_celebrits')->where('id', '=', $cele_id)->execute()->get('admin');
$admin_email = DB::select('email')->from('auth_user')->where('id', '=', $c_admin)->execute()->get('email');
$admin_name = substr($admin_email, 0, strpos($admin_email, '@'));
?>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  MY BLOG SHOW</div>
        </div>
        <?php echo Message::get(); ?>
    </div>

    <!-- main begin -->
    <section class="layout fix">
        <article id="container" class="user flr">
            <div class="blogshow" style="padding-bottom:20px;">
                <h2>MY BLOG SHOW</h2>
                <ul class="tab fix">
                    <li <?php if (!$onshowed) echo 'class="on"'; ?>>TO SHOW</li>
                    <li <?php if ($onshowed) echo 'class="on"'; ?>>SHOWED</li>
                </ul>
                <ul class="tab-con">
                    <li <?php echo $onshowed ? 'style="display:none;"' : 'style="display:block;"'; ?>>
                        <p>How to Complete a Show?</p>
                        <p>
                            <span>1. Copy the Item Link and Paste it to your Blog Show Picture.</span>
                            <span>2. Write your show url in the right column and click "Submit".</span>
                        </p>
                        <table class="orderTable">
                            <tr>
                                <th>Show No.</th>
                                <th>Product Info.</th>
                                <th>Show Link</th>
                            </tr>
                            <?php
                            foreach ($toshow as $key => $data):
                                $product_id = Product::get_productId_by_sku($data['sku']);
                                ?>
                                <tr>
                                    <td class="listNumber"><?php echo $key + 1; ?></td>
                                    <td width="306">
                                        <dl class="pr-info fix">
                                            <dt>
                                            <a><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 3); ?>" alt="" /></a>
                                            </dt>
                                            <dd>Item# : <?php echo $data['sku']; ?></dd>
                                            <dd><?php echo Product::instance($product_id)->get('name'); ?></dd>
                                            <dd>Order NO.: <a><?php echo $data['ordernum']; ?></a></dd>
                                            <dd><input type="button" class="copy-link" name="<?php echo Product::instance($product_id)->permalink() . '?cid=' . $cele_id . $admin_name; ?>" value="" /></dd>
                                        </dl>
                                    </td>
                                    <td width="310">
                                        <dl class="show-link">
                                            <form action="/customer/add_url?<?php echo http_build_query($_GET); ?>" method="post">
                                                <input type="hidden" name="cele_id" value="<?php echo $cele_id; ?>" />
                                                <input type="hidden" name="ordernum" value="<?php echo $data['ordernum']; ?>" />
                                                <input type="hidden" name="sku" value="<?php echo $data['sku']; ?>" />
                                                <dd>
                                                    <input type="url" name="url[]" class="link-input" value="" />
                                                </dd>
                                                <dd><a class="addMoreLink">add one more link</a></dd>
                                                <dd><input type="submit" class="link-btn" value="" /></dd>
                                            </form>
                                        </dl>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <?php
                        echo $pagination1;
                        ?>
                    </li>
                    <li <?php echo $onshowed ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                        <p>How to Complete a Show?</p>
                        <p>
                            <span>1. Copy the Item Link and Paste it to your Blog Show Picture.</span>
                            <span>2. Write your show url in the right column and click "Submit".</span>
                        </p>
                        <table class="orderTable">
                            <tr>
                                <th>Show No.</th>
                                <th>Product Info.</th>
                                <th>Show Link</th>
                            </tr>
                            <?php
                            foreach ($showed as $key => $data):
                                $product_id = Product::get_productId_by_sku($data['sku']);
                                ?>
                                <tr>
                                    <td class="listNumber"><?php echo $key; ?></td>
                                    <td width="306">
                                        <dl class="pr-info fix">
                                            <dt>
                                            <a><img src="<?php echo Image::link(Product::instance($product_id)->cover_image(), 3); ?>" alt="" /></a>
                                            </dt>
                                            <dd>Item# : <?php echo $data['sku']; ?></dd>
                                            <dd><?php echo Product::instance($product_id)->get('name'); ?></dd>
                                            <dd>Order NO.: <a><?php echo $data['ordernum']; ?></a></dd>
                                            <dd><input type="button" class="copy-link" name="<?php echo Product::instance($product_id)->permalink() . '?cid=' . $cele_id . $admin_name; ?>" value="" /></dd>
                                        </dl>
                                    </td>
                                    <td>
                                        <dl class="show-link">
                                            <dd class="showurl">
                                                <?php
                                                $urls = DB::select('id', 'url')->from('celebrities_celebrityorder')->where('ordernum', '=', $data['ordernum'])->and_where('sku', '=', $data['sku'])->execute()->as_array();
                                                foreach ($urls as $url):
                                                    ?>
                                                    <a class="showLinkhref" href="<?php echo $url['url']; ?>"><?php echo $url['url']; ?></a>
                                                    <?php
                                                endforeach;
                                                ?>
                                            </dd>
                                            <dd>
                                                <div class="edit-url" style="display:none;">
                                                    <form action="/customer/edit_url?<?php echo http_build_query($_GET); ?>" method="post">
                                                        <input type="hidden" name="cele_id" value="<?php echo $cele_id; ?>" />
                                                        <input type="hidden" name="ordernum" value="<?php echo $data['ordernum']; ?>" />
                                                        <input type="hidden" name="sku" value="<?php echo $data['sku']; ?>" />
                                                        <?php foreach ($urls as $url): ?>
                                                            <input type="hidden" name="id[]" value="<?php echo $url['id'] ?>" />
                                                            <input type="text" name="url[]" class="link-input" value="<?php echo $url['url'] ?>" />
                                                            <?php
                                                        endforeach;
                                                        ?>
                                                        <br/>
                                                        <div class="more"></div>
                                                        <a class="addMoreLink">add one more link</a>
                                                        <br/>
                                                        <input type="submit" class="allbtn btn-apply" value="submit">
                                                        <a href="#" class="link-cancel" style="text-decoration:underline;margin-left:10px;">Cancel</a>
                                                        <br/><br/>
                                                    </form>
                                                </div>
                                                <input type="button" name="" class="link-edit" value="" />
                                            </dd>
                                        </dl>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </table>
                        <?php
                        echo $pagination2;
                        ?>
                    </li>
                </ul>
                <script type="text/javascript">
                    $(function(){
                        $('.tab li').hover(function(){
                            $(this).addClass('on').siblings().removeClass('on');
                            var a=$(this).index();
                            var tabCon_li=$(this).parent().siblings('.tab-con').children('li');
                            tabCon_li.eq(a).css('display','block').siblings().css('display','none');
                        });
                        $('.addMoreLink').click(function(){
                            var dd=$(this).parent().prev('dd');
                            $('<input type="text" name="url[]" class="link-input" value="" />').appendTo(dd);
                        })
                        $('.edit-url .addMoreLink').click(function(){
                            var more=$(this).parent().find('.more');
                            $('<input type="text" name="more[]" class="link-input" value="" />').appendTo(more);
                        })
                    })
                </script>
            </div>
        </article>
        <?php
        echo View::factory('customer/left');
        ?>
    </section>
</section>
<div id="site_link" class="" style="padding-bottom: 50px; padding-right: 50px; width: 422px; height: 118px; top: 100px; left: 438.5px;">
    <div id="cboxWrapper" style="height: 168px; width: 472px;"><div>
            <div id="cboxTopLeft" style="float: left;"></div>
            <div id="cboxTopCenter" style="float: left; width: 422px;"></div>
            <div id="cboxTopRight" style="float: left;"></div></div>
        <div style="clear: left;"><div id="cboxMiddleLeft" style="float: left; height: 118px;"></div>
            <div id="cboxContent" style="float: left; width: 422px; height: 118px;">
                <div id="cboxLoadedContent" style="display: block; width: 422px; overflow: auto; height: 98px;">
                    <div style="padding:10px; background:#fff;" id="inline_example2">
                        <textarea id="site_image" onmousemove="this.select(),this.focus();" cols="" rows="" name="" style="width: 380px; height: 70px; font-size:15px;"></textarea>
                    </div>
                </div>
                <div class="closebtn" style="top: 125px;">close</div>
            </div>
            <div id="cboxMiddleRight" style="float: left; height: 118px;"></div>
        </div>
        <div style="clear: left;">
            <div id="cboxBottomLeft" style="float: left;"></div>
            <div id="cboxBottomCenter" style="float: left; width: 422px;"></div>
            <div id="cboxBottomRight" style="float: left;"></div>  
        </div>
    </div>
    <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>

<script type="text/javascript">
    $(function(){
        $(".link-edit").live('click', function(){
            $(this).parent().parent().find(".showurl").hide();
            $(this).parent().find(".edit-url").show();
        })
                
        $(".link-cancel").live('click', function(){
            $(this).parent().parent().parent().parent().find(".showurl").show();
            $(this).parent().parent().hide();
            return false;
        })
                
        $(".copy-link").live('click', function(){
            var link = $(this).attr('name');
            $("#site_image").val(link);
            $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
            $('#site_link').appendTo('body').fadeIn(320);
            return false;
        })
        $("#site_link .closebtn,#wingray").live("click",function(){
            $("#wingray").remove();
            $('#site_link').fadeOut(160).appendTo('#tab2');
            $('#site_login').fadeOut(160).appendTo('#tab2');
            return false;
        })
    })
</script>