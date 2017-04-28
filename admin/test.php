<?php
$link = @mysql_connect('localhost', 'root', '') OR die(mysql_error());
mysql_select_db('clothes',$link);
$sql = 'SELECT id FROM sites WHERE id = 1';
$query = mysql_query($sql);
$array = mysql_fetch_array($query);
print_r($array);exit;
