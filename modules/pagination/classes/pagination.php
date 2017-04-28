<?php defined('SYSPATH') or die('No direct script access.');

class Pagination extends Kohana_Pagination {
	public function get_url($page)
	{
		$url = '';
	    $getsArr = array('sort', 'pick');
	    $base_url = '?';
	    foreach($_GET as $key => $get)
	    {
	        if(in_array($key, $getsArr))
	        {
	            if($base_url == '?')
	                $base_url .= $key . '=' . $get;
	            else
	                $base_url .= '&' . $key . '=' . $get;
	        }
	    }
	    if($base_url == '?')
	        $url = $base_url . 'page=' . $page;
	    else
	        $url = $base_url . '&page=' . $page;
	    return $url;
	}
}