<?php echo View::factory('admin/site/ga_left')->render(); ?>
<div id="do_right">
        <h3>Google Analytics Source Views<span style="float:right;">FROM: <?php echo $date_start . ' TO ' . $date_end; ?></span></h3>
        <fieldset style="text-align:right">
                <legend style="font-weight:bold">Filter</legend>
                <form id="frm-customer-export" method="post" action="">
                        <label for="export-start">Date From: </label>
                        <input type="text" name="from" id="export-start" class="ui-widget-content ui-corner-all" />
                        <label for="export-end">Date To: </label>
                        <input type="text" name="to" id="export-end" class="ui-widget-content ui-corner-all" />
                        <input type="submit" value="Filter" class="ui-button" style="padding:0 .5em" />
                </form>
        </fieldset>
        <script type="text/javascript">
                $('#export-start, #export-end').datepicker({
                        'dateFormat': 'yy-mm-dd', 
                });
        </script>
        <table id="orderline-list">
                <tr>
                        <th>URL</th>
                        <th>Visits</th>
                        <th>newVisits</th>
                        <th>Bounces</th>
                </tr>
                <?php foreach ($data as $metric => $val): ?>
                        <tr>
                                <td><?php print $metric; ?></td>
                                <td><?php print $val['ga:visits']; ?></td>
                                <td><?php print $val['ga:newVisits']; ?></td>
                                <td><?php print $val['ga:bounces']; ?></td>
                        </tr>
                <?php endforeach ?>
        </table>
        <fieldset>
                <legend style="font-weight:bold">Export</legend>
                <form id="frm-customer-export" method="post" action="/admin/site/ga/source_export">
                        <label for="export-start1">Date From: </label>
                        <input type="text" name="from" id="export-start1" class="ui-widget-content ui-corner-all" />
                        <label for="export-end1">Date To: </label>
                        <input type="text" name="to" id="export-end1" class="ui-widget-content ui-corner-all" />
                        <div><span>请输入URL(一行一个):</span><br />
                                <textarea name="search"  cols="40" rows="20" ></textarea>
                        </div>
                        <input type="submit" value="Export" class="ui-button" style="padding:0 .5em" />
                </form>
                <script type="text/javascript">
                        $('#export-start1, #export-end1').datepicker({
                                'dateFormat': 'yy-mm-dd', 
                        });
                </script>
        </fieldset>
</div>