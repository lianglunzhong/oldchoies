<?php defined('SYSPATH') or die('No direct script access.');

class URL extends Kohana_URL 
{
    public static function current($_get = TRUE)
    {
        $request = Request::instance();
        if($_get)
        {
            $current_uri = URL::base().$request->uri.URL::query($_GET);
        }
        else
        {
            $current_uri = URL::base().$request->uri;
        }
        return $current_uri;
    }
}
