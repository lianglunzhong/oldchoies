<div id="container" style="background: #fff;">
        <div id="main">
                <div class="crumb"> <a href="<?php echo LANGPATH; ?>/" class="home">Home</a> &gt;<span>choieslooks</span> </div>
                <!------------- Main --------------->
                <div class="videoshow_box">
                        <p class="tit"><img src="/images/choieslooks/videoshow_tit.png" /></p>
                        <ul class="videoshow_con fix">
                                <?php
                                $videos = array(
                                    'LQHR5TufWSc','VNLUE-A9L_0','QgLD9KeoYsE','TqO_uGqz-ys'
                                );
                                foreach ($videos as $key => $video): ?>
                                        <li>
                                                <a href="http://www.youtube.com/watch?v=<?php echo $video; ?>" title="" id="videolink<?php echo $key; ?>" class="group1" onclick="openVideo('#videolink<?php echo $key; ?>');return false;">
                                                        <img src="http://i1.ytimg.com/vi/<?php echo $video; ?>/mqdefault.jpg" alt="v<?php echo $key; ?>" width="370px"/>
                                                </a>
                                                <div>
                                                        <a href="http://www.youtube.com/watch?v=<?php echo $video; ?>" onclick="openVideo('#videolink<?php echo $key; ?>');return false;">Video Show Items Collection  >></a>
                                                        <a href="http://www.youtube.com/watch?v=<?php echo $video; ?>" class="video_icon<?php echo count($videos) > 1 ? '' : '1'; ?>" onclick="openVideo('#videolink<?php echo $key; ?>');return false;">&nbsp;</a>
                                                </div>
                                                
                                        </li>
                                <?php endforeach; ?>
                        </ul>
                        <script type="text/javascript">
                                function openVideo(e)
                                {
                                        var href = $(e).attr('href');
                                        tt= $(e).offset();
                                        lleft=screen.width/2-345;
                                        ttop=window.screenTop+ tt.top - 1000;
                                        var newwin=window.open(href,"","toolbar=1,location=1,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,top="+ttop+",left="+lleft+",width=750,height=525");
                                }
                        </script>
                </div>
        </div>
        <!------------- Aside --------------->
        <div id="aside">
                <div class="aside-nav">
                        <?php echo View::factory('/de/catalog_left'); ?>
                </div>
        </div>
</div>