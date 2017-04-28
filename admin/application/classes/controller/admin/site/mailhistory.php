<?php
class Controller_Admin_Site_Mailhistory extends Controller_Admin_Site
{
	public function action_index()
	{
		$str='';
		$path=$_SERVER['COFREE_LOG_DIR'].'/MailLog.txt';
    	if(true == ($handle = fopen($path,'a'))){
	    	$lines=file($path);
	    	fclose($handle);
    	}
    	if(!empty($lines))
    	{
    		for($i=1;$i<=20&&$i<=count($lines);$i++)
    		{
    			$str.=$lines[count($lines)-$i].'<br/><br/>';
    		}
    	}
    	$this->request->response = View::factory('admin/template')->set('content', $str)->render();
	}
}

?>