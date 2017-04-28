<?php echo View::factory('admin/site/basic_left')->render(); ?>
<script type="text/javascript">
$(document).ready(function(){
    $('#form1').submit(function(){
		if($('#site_id').val()=='')
		{
			alert('Please Select a site!');
			return false;
		}
		else
			return window.confirm('Copy all documents from '+$('#site_id').find("option:selected").text());
	});
    
    <?php
        $lang = Arr::get($_GET, 'lang', '');
        $lang_url = $lang ? '?lang=' . $lang : '';
        if($lang_url)
        {
        ?>
        var lang_url = '<?php echo $lang_url; ?>';
        $("a").live('click', function(){
            var href = $(this).attr('href');
            var pclass = $(this).attr('class');
            if(pclass != 'nolang')
            {
                href += lang_url;
                $(this).attr('href', href);
            }
        })
        <?php
        }
        ?>
});
</script>
<div id="do_right">
    <div class="box">
        <h3>站点文案
        <?php
            $languages = Kohana::config('sites.1.language');
            $now_lang = Arr::get($_GET, 'lang', 'en');
            foreach($languages as $l)
            {
                ?>
                <a class="nolang" href="/admin/site/doc/list<?php if($l != 'en') echo '?lang=' . $l; ?>" <?php if($now_lang == $l) echo 'style="color:red"'; ?>><?php echo $l; ?></a>
                <?php
            }
        ?>
        </h3>
        <a class="nolang" href="/admin/site/doc/add<?php if($lang) echo '?lang=' . $lang; ?>">添加站点文案</a><br/>
        <form id='form1' class="nolang" action="/admin/site/doc/copy<?php if($lang) echo '?lang=' . $lang; ?>" method="post">
        Copy From:
	        <select name="site_id" id='site_id'>
	        	<option value="">--Select a Site to Copy From--</option>
	        <?php foreach ($sites as $site):?>
	        	<option value="<?php echo $site->id;?>"><?php echo $site->domain;?></option>
	        <?php endforeach;?>
	        </select>
	        <input type="submit" value="Submit" />
        </form><br/>
        <table>
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Link</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($docs as $doc): ?>
                <tr>
                    <td><?php print $doc->name; ?></td>
                    <td><?php print $doc->link; ?></td>
                    <td>
                        <a class="nolang" target="_blank" href="/admin/site/doc/edit/<?php print $doc->id; ?><?php if($lang) echo '?lang=' . $lang; ?>">Edit</a>&nbsp;
                        <a class="nolang" href="/admin/site/doc/delete/<?php print $doc->id; ?><?php if($lang) echo '?lang=' . $lang; ?>" onclick="return window.confirm('delete?');" style="color:red">Delete</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>