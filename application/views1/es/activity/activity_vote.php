    <style>
    .vote-list .title {
  font-size: 12px; }
  .vote-list .title input {
    margin: 0px; }

.vote-bottom {
  background-color: #fafafa;
  *zoom: 1;
  margin: 30px 0  0;
  padding-bottom: 40px; }
  .vote-bottom:before, .vote-bottom:after {
    content: "";
    display: table; }
  .vote-bottom:after {
    clear: both; }
  .vote-bottom .vote-textarea span {
    font-size: 16px;
    margin: 10px 0;
    display: block;
    font-weight: bold; }
    .vote-bottom .vote-textarea span input {
      margin-right: 10px; }
  .vote-bottom .vote-sub {
    text-align: center;
    font-size: 16px;
    line-height: 24px;
    font-weight: bold;
    margin-top: 20px; }
    </style>
          <div class="site-content">
            <div class="main-container clearfix">
                <div class="container">
                    <div class="row">
                    <div class="col-xs-12">
                        <a href=""><img src="<?php echo STATICURL; ?>/assets/images/activity/vote-top-1-<?php echo LANGUAGE; ?>.jpg"></a>
                        <a href="<?php echo LANGPATH;?>/customer/login?redirect=<?php echo LANGPATH; ?>/activity/model_vote"><img src="<?php echo STATICURL; ?>/assets/images/activity/vote-top-2-<?php echo LANGUAGE; ?>.jpg"></a>
                        <form action="" method="post" id="formvote">
                        <div class="pro-list vote-list">
                            <ul class="row">
                            <?php foreach($skuArr as $k=>$v){

                                $a = $k+1;
                                $b = $k+1;
                                if($a<10){
                                    $a = '0'.$a;
                                }
                             ?>
                             <li class="pro-item col-xs-6 col-sm-3">
                                     <div class="pic">
                                     <?php 
                                     $proid = Product::get_productId_by_sku($v);
                                     $plink = Product::instance($proid,LANGUAGE)->permalink();
                                      ?>
                                        <a href="<?php echo $plink; ?>">
                                            <img src="<?php echo STATICURL; ?>/assets/images/activity/<?php echo $a; ?>.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="title clearfix mb10">
                                        <div class="fll"><?php if($cu[$v] !=1){ ?><input class="voteclass" name="voteadd<?php echo $b; ?>" type="checkbox" value="<?php echo $v; ?>" /><?php } ?><?php  ?>SKU# <?php echo $v; ?></div>
                                        <div class="flr"><a href=""><i class="myaccount"></i><b class="red"><?php echo isset($votes[$v]) && $votes[$v] ? $votes[$v] : 0; ?> Votación</b></a></div>
                                    </div>
                                </li>
                            <?php } ?>

                            </ul>
                        </div>
                        
                        <div class="vote-bottom">
                            <div class="col-sm-3"></div>
                            <div class="vote-box col-xs-12 col-sm-6">
                                <div class="clearfix vote-textarea">
                                    <span><input name="Fruit" type="checkbox" value="" />Algunas sugerencias para CHOIES sobre el modelo o la ropa.</span>
                                    <textarea class="textarea-long" name="comment" maxlength="500" 
                                                style="width: 100%; height: 63px;color: #878787;background-color: #fff;" onfocus="this.value=''; this.onfocus=null;" value="Leave your comment...">Dejar su comentario...</textarea>
                                </div>
                                <div class=" vote-sub">
                    <p>Compartirlo con sus amigas en Facebook o Pinterest para votar juntos.</p>
                    <p class="red">Cuanto más compartas, mayor oportunidades ganarás la $ 100 tarjeta de regalo. </p>
                                    <div class="sns clearfix mt20 mb20" style="line-height:32px; text-transform:uppercase">
                                        <div style="display:inline-block; margin-right:10px;"><a  href="http://pinterest.com/pin/create/button/?url=http://http://www.choies.com/activity/model_vote&media=http://cloud.choies.com/assets/images/activity/votepin.jpg&description=Vote To Get Rewarded!" target="_blank" class="sns5"></a>pinterest</div>
                                        <div style="display:inline-block"><a  href="http://www.facebook.com/sharer.php?u=http%3A%2F%2Fwww.choies.com%2Factivity%2Fmodel_vote" target="_blank" class="sns1"></a>facebook</div>
                                    </div>
                                    <button type="button" id="bu" class="btn btn-default btn-lg mt20">ENVIAR</button>
                                </div>
                            </div>
                        </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>
$("#bu").click(function(){
    $("#formvote").submit();

})
</script>
