<?php echo View::factory('admin/site/news_left')->render(); ?>
<script type="text/javascript" src="/media/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
//简易的tinyMCE
  tinyMCE.init({
    
    mode : "textareas",
        theme : "advanced",
        plugins : "fullscreen",
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,fullscreen",
        theme_advanced_buttons2 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        elements : "content"
});
</script>
<div id="do_right">
	<div class="box">
		<h3>新闻编辑</h3>
		<form name="news_add" action="/admin/site/news/edit_go" method="post">
                    <input type="hidden" name="id" value="<?php echo $news->id;?>">
			<ul>

				<li>
					<label>标题<span class="req">*</span></label>
					<div>
                                            <input name="title" class=""  type="text"  value="<?php echo $news->title;?>"  />
					</div>
				</li>

                                 <li>
					<label>正文</label>
					<div>
                                            <textarea name="content" cols="5" rows="5"><?php echo $news->content;?></textarea>
					</div>
				</li>
				<li>
						<input value="Submit" class="button" type="submit" />
				</li>
			</ul>
		</form>
	</div>
</div>
