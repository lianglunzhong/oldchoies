<?php echo View::factory('admin/site/basic_left')->render(); ?>
<script type="text/javascript" src="/media/js/my_validation.js"></script>
<script type="text/javascript" src="/media/js/set_admin.js"></script>
<div id="do_right">

	<div class="box">
		<h3>Product Set</h3>
		<form method="post" action="#" name="ptype_add_form" class="need_validation">

			<ul>
				<li>
					<label>Name<span class="req">*</span></label>
					<div><input id="name" name="set[name]" class="short text required" type="text"></div>
				</li>

				<li>
					<label>Label<span class="req">*</span></label>
					<div><input id="label" name="set[label]" class="text medium required" type="text"></div>
                </li>

                <li>
					<label>Brief</label>
					<div><input id="brief" name="set[brief]" class="text medium" type="text"></div>
                </li>

                <li class="clr">
					<div  class="attributes_ul_box">
						<h4 class="ul_title">Current attributes ( <span id="select_num">0</span> ) :</h4>
						<ul id="attributes_inside" class="attributes_box">
						</ul>
					</div>
					<div class="jqgrid_little_box">
                        <h4 class="ul_title">Add new attributes:</h4>
                        <table id="toolbar"></table>
                        <div id="ptoolbar"></div>
                    </div>
				</li>

				<li>
                    <button type="submit">Save</button> 
				</li>

			</ul>
		</form>
	</div>

</div>
