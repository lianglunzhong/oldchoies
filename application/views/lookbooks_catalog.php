<style>
.list_new .gridLoadingWrapper {
position: relative;
z-index: -2;
margin-top: 30px;
}
.list_new hr {
display: inline-block;
border: solid rgba(0, 0, 0, 0.1);
border-width: 1px 0 0 0;
color: #eee;
width: 100%;
}
.list_new .gridLoading {
background-color: #fff;
display: inline-block;
left: 50%;
margin-left: -24.5px;
padding: 10px 10px;
position: absolute;
text-align: center;
top: -26.5px;
width: 29px;
}
.list_new.showGridLoading .list_newLogoIcon {
display: none;
}
.list_new .gridLoading .gridFooterSpinner {
display: inline-block;
opacity: 0.5;
width: 32px;
height: 32px;
background: url('../images/loading.gif') 0px 0px no-repeat;
text-align: center;
}
</style>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">home</a>  >  LOOKBOOK</div>
        </div>
    </div>
    <section class="list_new layout fix">
        <h3 class="lookbook_tit">LOOKBOOK</h3>
        <!-- lookbook_list -->
        <div id="brand_masonry" class="lookbook">
            <?php
            for ($i = 0; $i < 20; $i++)
            {
                if (isset($lookbooks[$i]['product_id']))
                {
                    if($i == 0)
                        $max_id = $lookbooks[$i]['id'];
                    $product_ins = Product::instance($lookbooks[$i]['product_id']);
                    if($product_ins->get('set_id') == 502)
                        continue;
                    $c = DB::select('id', 'image')->from('celebrity_images')->where('product_id', '=', $lookbooks[$i]['product_id'])->where('type','in',array(1,3))->order_by('position', 'desc')->execute()->current(); 
                    $lookbook['id'] = $c['id'] . '-' . '1';
                    $lookbook['title'] = $product_ins->get('name');
                    $images = array(
                        'main' => $c['image']
                    );
                }
                else
                {
                    $lookbook = $lookbooks[$i];
                    $images = unserialize($lookbook['images']);
                }
                ?>
                <div class="cell">
                    <div class="cell_img">
                        <a target="_blank" href="<?php echo LANGPATH; ?>/lookbook/<?php echo $lookbook['id']; ?>"><img src="<?php echo 'http://img.choies.com/simages/7_' . $images['main']; ?>"></a>
                    </div>
                    <p class="name">
                        <a target="_blank" href="<?php echo LANGPATH; ?>/lookbook/<?php echo $lookbook['id']; ?>">
                            <?php echo $lookbook['title']; ?>
                        </a>
                    </p>
                    <div><a href="#" class="share"></a></div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="gridLoadingWrapper">
            <hr>
            <div class="gridLoading">
                <span class="gridFooterLogoIcon"></span>
                <span class="gridFooterSpinner"></span>
            </div>
        </div>
    </section>
</section>
<script src="/js/jquery.masonry.min.js" type="text/javascript"></script>

<script>
$(function() {
    $('.cell img').load(function(){ 
        $('#brand_masonry').masonry({
            itemSelector: '.cell',
            gutterWidth: 15,
            columnWidth: 242,
            isFitWidth: true
        });

    });

    var num = 1;
    $(window).scroll(function(){
        if ($(document).height() - $(this).scrollTop() - $(this).height()<100){ 
            getList(num)
            num ++;
        }
    });

    var ids = new Array();
    var key = 0;

    function getList(index) {
        $.post(
        '/site/lookbook_ajax',
        {
            index: index
        },
        function(lookbooks){
            key ++;
            html = '';
            for(var i=0;i<21;i++)
            {
                if(i < 20)
                {
                    var j = i;
                    if(in_array(lookbooks[j]['id'], ids))
                        continue;
                    var src="http://img.choies.com/simages/7_"+lookbooks[j]['images']['main'];
                    html+='<div class="cell"><div class="cell_img">\n\
                    <a target="_blank" href="<?php echo LANGPATH; ?>/lookbook/'+lookbooks[j]['id']+'"><img src="'+src+'" /></a></div>\n\
                    <p class="name"><a target="_blank" href="<?php echo LANGPATH; ?>/lookbook/'+lookbooks[j]['id']+'">'+lookbooks[j]['title']+'</p></a></div>';
                    ids.push(lookbooks[j]['id']);
                }
            }
            for(var i=0;i<10;i++)
            {
                if(i < 10)
                {
                    var j = i;
                    if(in_array(lookbooks[j]['id'], ids))
                        continue;
                    var src="http://img.choies.com/simages/7_"+lookbooks[j]['images']['main'];
                    html+='<div class="cell"><div class="cell_img">\n\
                    <a target="_blank" href="<?php echo LANGPATH; ?>/lookbook/'+lookbooks[j]['id']+'"><img src="'+src+'" /></a></div>\n\
                    <p class="name"><a target="_blank" href="<?php echo LANGPATH; ?>/lookbook/'+lookbooks[j]['id']+'">'+lookbooks[j]['title']+'</p></a></div>';
                    ids.push(lookbooks[j]['id']);
                }
            }

            if(key % 4 == 0)
                ids = [];
           
            $("#brand_masonry").append(html)
            $('.cell img').load(function(){ 
                $("#brand_masonry").masonry( 'reload' );
                
            });
           
        },'json');
    };

 });


function in_array(search,array){
    for(var i in array){
        if(array[i]==search){
            return true;
        }
    }
    return false;
}

</script>
