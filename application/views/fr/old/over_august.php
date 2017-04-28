<?php
 date_default_timezone_set('America/Chicago');
?>
<section class="container">
<section class="icontainer fix">
  <article class="main">
    <article class="imain">
      <nav>
        <ul class="fix">
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/dog" title="Dog" class="first">Dog</a></li>
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/cat" title="Cat">Cat</a></li>
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/boutique-for-dog" title="Dog Boutique">Dog Boutique</a></li>
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/boutique-for-cat" title="Cat Boutique ">Cat Boutique </a></li>
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/bestsellers" title="Bestsellers" class="last">Bestsellers</a></li>
          <li><a href="http://<?php echo Site::instance()->get('domain');?>/new-arrivals" title="New Arrivals" class="last">New Arrivals</a></li>
        </ul>
      </nav>
<article class="category">
      <div class="crumb"><h1>August Freebie Week Four &gt;&gt;</h1> Back to: <a href="<?php echo LANGPATH; ?>/" title="">Home</a></div>
<style type="text/css">
.freebie{ width:780px; margin:0 auto; font:12px/18px Arial, Helvetica, sans-serif; }
.snsall,.a_allbtn{background: url(images/freebie/alltheme.png) no-repeat;}
.fix{ clear:both; *zoom:1;}
.time{ width:514px; height:47px; padding:22px 0 37px 267px; background: url(images/freebie/shine_time.png) no-repeat;  }
.time span{margin-right:7px;}
.num{ display:inline-block; width:32px; height:47px; background:url(images/freebie/a_num.png) no-repeat;}
.num0{ background-position:0 0;}
.num1{ background-position:-32px 0;}
.num2{ background-position:-64px 0;}
.num3{ background-position:-96px 0;}
.num4{ background-position:-128px 0;}
.num5{ background-position:-160px 0;}
.num6{ background-position:-192px 0;}
.num7{ background-position:-224px 0;}
.num8{ background-position:-256px 0;}
.num9{ background-position:-288px 0;}
.numdot{ width:4px; background-position:-320px 0;} 
.banner_a img{height:347px;}
.sns{ position:relative; display:block; width:780px; height:327px; background:url(images/freebie/shinebg.png) no-repeat;}
.snsall{ position:absolute; left:52px;  display:inline-block; }
.sns_fblike{ top:80px; width:133px; height:42px;}
.sns_fbsign{ top:136px; width:240px; height:38px; background-position:0 -42px;}
.sns_fbshare{ top:190px; width:432px; height:45px; background-position:0 -80px;}
.sns_get{ top:241px; left:475px; width:187px; height:40px; background-position:0 -125px;}
.a_pr01{ position:relative; display:block;}
.a_pr01 .a_allbtn{ position:absolute; top:270px; left:526px; width:157px; height:38px; }
.a_pr01 .a_btn-add-g{ background-position:0 -166px;}
.a_pr01 .a_btn-add{ background-position:0 -213px;}
.a_pr01 .a_btn-add-s{ background-position:0 -260px;}
</style>
</head>
<body>
<div class="freebie">
 <div class="time">
  <span class="num num0" id="time_h_1"></span>
      <span class="num num0" id="time_h_0"></span>
      <span class="num numdot"></span>
      <span class="num num0" id="time_m_1"></span>
      <span class="num num0" id="time_m_0"></span>
      <span class="num numdot"></span>
      <span class="num num0" id="time_s_1"></span>
      <span class="num num0" id="time_s_0"></span>
 </div>
 <div class="banner_a fix"><img src="images/freebie/banner_l.png" width="20" height="347" /><img src="images/freebie/banner_c.png" width="740" height="348" /><img src="images/freebie/banner_r.png" width="20" height="347" /></div>
 <div class="a_pr01"><img src="images/freebie/a_title01.png" width="780" height="60" /><img src="images/freebie/a_pr01.png" width="780" height="258" border="0" /><a href="#" class="a_allbtn a_btn-add-s"></a></div><div><img src="images/freebie/a_title03.png" width="780" height="58" /><a href="http://www.myfavoritepetshop.com/product/favorite-shiny-silver-points-cat-collar-with-bell" target="_blank"><img src="images/freebie/a_pr04.png" width="780" height="130" border="0" /></a>
    <!--<map name="Map5" id="Map5">
      <area shape="rect" coords="21,-2,385,128" href="http://www.myfavoritepetshop.com/product/favorite-shiny-silver-points-cat-collar-with-bell" target="_blank" />
    </map>-->
    <img src="images/freebie/a_title02.png" width="780" height="58" /><img src="images/freebie/a_pr02.png" width="780" height="275" border="0" usemap="#Map2" />
    <map name="Map2" id="Map2">
      <area shape="rect" coords="22,1,259,210" href="http://www.myfavoritepetshop.com/product/favorite-rhinestone-ribbon-collar-for-dog-cat" target="_blank" />
      <area shape="rect" coords="268,4,513,202" href="http://www.myfavoritepetshop.com/product/favorite-reflective-cat-collar" target="_blank" />
      <area shape="rect" coords="522,4,761,204" href="http://www.myfavoritepetshop.com/product/favorite-rhinestone-ribbon-cat-or-dog-collar" target="_blank" />
    </map>
  </div>
</div>
</article>
<?php echo View::factory('footer')->render(); ?>
<aside>
	<?php echo View::factory('aside_catalog')->set('catalog',$catalog)->render();?>
  </aside>