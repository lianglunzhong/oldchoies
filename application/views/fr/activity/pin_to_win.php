<link type="text/css" rel="stylesheet" href="/css/giveaway.css" media="all" />
<script type="text/javascript" src="/js/catalog.js"></script>
<script type="text/javascript">
        function addTags()
        {
                var itemOriginal =document.getElementsByName("tagsInput");
                var arr = new Array(itemOriginal.length);
                for(var j = 0; j < itemOriginal.length;j++){
                        arr[j] = itemOriginal.item(j).value;
                }
         
                var str = "<table><tr><td><input type='text' name='url2' id='url2' class='allInput mt5' style='width:509px;' value='' maxlength='390' /></td></tr></table>";
                document.getElementById("tags").innerHTML += str;
                var itemNew =document.getElementsByName("tagsInput");
                for(var i=0;i<arr.length;i++)
                {
                        itemNew.item(i).value = arr[i];
                }
        }
        function showTags(){
                var item=document.getElementsByName("tagsInput");
                for(var i=0;i<item.length;i++)
                {
                        document.getElementById("showTags").innerHTML += item[i].value + " ";
                }
        }
</script>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  Pin to win</div>
        </div>
        <?php echo Message::get(); ?>
    </div>
    <section class="layout fix">
        <section id="container" class="flr">

                        <!--giveaway start-->
                        <div class="pinToWin">
                                <div><a href="http://pinterest.com/pin/38210296811539709/" target="_blank"><img src="/images/activity/banner_pinterest_1.png" alt="" title=""/></a></div>
                                <div><img src="/images/activity/banner_pinterest_2.jpg" alt="" title=""/></div>
                                <div class=" rules">
                                        <h3>HOW TO ENTER:</h3>
                                        <p>1. Follow <a href="http://pinterest.com/choies/" target="_blank">http://pinterest.com/choies/</a> and create a new Board called "Choies Summer Wishlist".</p>
                                        <p>2. Pin 5 hottest summer items in your opinion from <a href="<?php echo LANGPATH; ?>/summer-new-in-2" target="_blank">http://www.choies.com/summer-new-in-2</a> to your " Choies Summer Wishlist" Board, add #choies to every item you pin (<em> P.S.</em> Please remember this board can only contain 5 items from <a href="<?php echo LANGPATH; ?>/summer-new-in-2" target="_blank">http://www.choies.com/summer-new-in-2</a> and don't repin items from other pinners, hope you could kindly understand.)</p>
                                        <p>3. <a href="http://pinterest.com/pin/38210296811539709/" target="_blank">Comment here</a> and leave your "Choies Summer Wishlist" board link in your comment. </p>
                                </div>
                                <div class="bt1d rules">
                                        <h3>PRIZE:</h3>
                                        <p>We will announce the "Choies Hottest Summer Item" every day. (The hottest One should be the one which get the most repins On the actual day.)</p>
                                        <p>You can see whether The Hottest One is among these 5 items you repined in your board.</p>
                                        <p>If so, Then You can Get It For Free! (If there are more than one people win, we choose the first one who pin It and leave in the comment.)</p>
                                </div>
                                <div class="bt1d mb10 rules">
                                        <p style="font:italic 20px 'Times New Roman', Times, serif; color:#000; margin-top:10px;">Ends on June 28th. </p>
                                        <p>If you have any questions, feel free to email via <a href="mailto:emily@choies.com" target="_blank">emily@choies.com</a>.</p>
                                </div>
                        </div>
                </section>
        <?php echo View::factory('/catalog_left'); ?>
    </section>
</section>