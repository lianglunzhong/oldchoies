<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Site_Print extends Controller_Admin_Site
{
	public function action_ajax_csv()
	{
		if($_POST['sku'])
		{
			$sku = $_POST['sku'];
			$qty = Arr::get($_POST, 'print_qty',1);
			$attr = Arr::get($_POST, 'attr','');
			$time = date('Y-m-d H:i');
			if( !is_numeric($qty) )
			{
				$qty = 1;
			}
			
			if( stristr($attr,'one') || empty($attr))
			{
				$attr = '';
			}
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename= print.csv');
			
			for($i = 1 ; $i<=$qty; $i++)
			{
				echo $sku. ',';
				echo $attr. ',';
				echo $time, PHP_EOL;
			}
			exit;
		}
	}
	
}
