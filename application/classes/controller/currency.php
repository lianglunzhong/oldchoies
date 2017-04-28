<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Currency extends Controller
{

        public function action_set()
        {
                $name = $this->request->param('id');
                $referer = '/';
                if(isset($_SERVER['HTTP_REFERER']) AND toolkit::is_our_url($_SERVER['HTTP_REFERER']))
                {
                        $referer = $_SERVER['HTTP_REFERER'];
                }
                if(Site::instance()->get('currency') != '' AND array_search($name, explode(',', Site::instance()->get('currency'))) !== FALSE)
                {
                        Site::instance()->currency_set($name);
                        Cookie::set('cookie_currency',$name,5184000);//60 days expire
                }
                $this->request->redirect($referer);
        }

}
