<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Webpage extends Controller_Template
{

        public $template = LANGTEMP;
        public $auto_render = TRUE;
        public $meta_title;
        public $meta_keyword;
        public $meta_description;
        public $site_id;
        public $language = 'en';
        public $is_mobile = 0;
        public $user_device = '';

        public function before()
        {
            //auto login when has cookie: 当cookie里有登陆状态时自动登陆 sjm added 2015-11-06
            $customer_id = Customer::logged_in();
            if(!$customer_id)
            {
                $customer_login_id = Kohana_Cookie::get('Customer_login_id');
                if($customer_login_id)
                {
                    Customer::instance($customer_login_id)->login_action();
                }
            }
            
            $url = str_replace(LANGPATH,'',url::current());
            if($url == '/top-sellers-c-32'){
               Request::Instance()->redirect(LANGPATH . '/top-sellers-c-32?sort=2'); 
            }
                parent::before();
//                if(preg_match("/(source|SSAID|adnetwork|ref)=([^&]*)/",url::current(),$aryAffi))
//                {
//		    if($aryAffi[1] == "ref" AND $aryAffi[2] == "CJ")
//		        SetCookie('ChoiesCookie', $aryAffi[2], time()+60*24*3600);
//                }
                
	        if(preg_match("/(source|SSAID|adnetwork|ref|clickid)=([^&]*)/",url::current(),$aryAffi))
		    {
		        if($aryAffi[1] == "source"){
			        Kohana_Cookie::set('ChoiesCookie', $aryAffi[2], 24*3600, '/');
		        }
                elseif($aryAffi[1] == "ref" AND $aryAffi[2] == "CJ")
                {
			        Kohana_Cookie::set('ChoiesCookie', $aryAffi[2], 60*24*3600, '/');
		        }
                elseif($aryAffi[1] == "ref" AND $aryAffi[2] == "shareasale")
                {
                    Kohana_Cookie::set('ChoiesCookie', $aryAffi[2], 60*24*3600, '/');
                }
                elseif($aryAffi[1] == "clickid")
                {
                    Kohana_Cookie::set('ChoiesCookie', $aryAffi[1], 60*24*3600, '/');
                    Kohana_Cookie::set('clickid', $aryAffi[2], 60*24*3600, '/');
                }
		    }

            if(isset($_GET['xc_source']) AND strtolower(trim($_GET['xc_source'])) == 'xingcloud')
            {
                SetCookie('xc_source', 'xingcloud', time()+24*3600);
            }
            if(isset($_GET['utm_source']) AND isset($_GET['click_id']))
            {
                SetCookie('click_id', trim($_GET['click_id']), time()+24*3600);
            }
            if(isset($_GET['oid']) AND isset($_GET['rqid']))
            {
                SetCookie('oid', trim($_GET['oid']), time()+24*3600);
                SetCookie('rqid', trim($_GET['rqid']), time()+24*3600);
            }

            $lang = LANGUAGE;

            //set default language, currency
            if(!$lang)
            {
                $lang_status = Session::instance()->get('lang_status');
                $lang_close = Arr::get($_COOKIE, 'lang_close', 0);
                if(!$lang_close && !$lang_status)
                {
                    $lang_cookie = Arr::get($_COOKIE, 'lang_cookie', '');
                    $lang_session = Session::instance()->get('lang_session');
                    $request = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
                    $request = rawurldecode($request);
                    $request = Security::xss_clean($request);
                    $request = htmlentities($request);
                    if($lang_session)
                    {
                        $values = explode('-', $lang_session);
                        $def_lang = $values[0];
                        $def_currency = isset($values[1]) ? $values[1] : '';
                        Session::instance()->set('lang_status', 1);
                        if($def_currency)
                            Site::instance()->currency_set($def_currency);
                        if($lang != $def_lang AND $def_lang != 'en')
                            $this->request->redirect('/' . $def_lang . $request);
                    }
                    elseif($lang_cookie)
                    {
                        $values = explode('-', $lang_cookie);
                        $def_lang = $values[0];
                        $def_currency = isset($values[1]) ? $values[1] : '';
                        Session::instance()->set('lang_status', 1);
                        if($def_currency)
                            Site::instance()->currency_set($def_currency);
                        if($lang != $def_lang AND $def_lang != 'en')
                            $this->request->redirect('/' . $def_lang . $request);
                    }
                    else
                    {
                        // include the php script  
                        $gi = geoip_open(APPPATH . "classes/GeoIP.dat", GEOIP_STANDARD);
                        // 获取国家代码 
                        $ip = $_SERVER['REMOTE_ADDR'];
                        // $ip = '195.164.214.12';
                        $country_code = geoip_country_code_by_addr($gi, $ip);
                        //ad code
                        SetCookie('adadcountry_code', $country_code, time()+24*3600);
                        $daoliu = Kohana::config('daoliu');
                        if(isset($daoliu['country'][$country_code]))
                        {
                            $def_country = $daoliu['country'][$country_code];
                            $currency = isset($daoliu['currency'][$country_code]) ? $daoliu['currency'][$country_code] : '';
                            $currencys = Site::instance()->currencies();
                            if(isset($currencys[$currency]))
                                $def_currency = $currency;
                            else
                                $def_currency = 'EUR';
                            /*echo View::factory('daoliu')->set('def_country', $def_country)->set('currencys', $currencys)->set('def_currency', $def_currency);*/
                        }
                    }
                }
            }
            $seoinfo=array(
                "de"=>array("title"=>"Choies: die neuesten Straßenmode Geschäft - Kaufen Sie die Mode Bekleidung und Schuhe hier","keywords"=>"Straßenmode, Online Mode, Modekleidung, Damen Kleidung, lookbook.nu Mode, Polyvore Mode, Modeschuhe","description"=>"Entdecken Sie die neuesten Damen Straßenmode Online. Kaufen Sie von tausenden Stilen, einschließlich Kleider, Schuhe, Schmuck und Accessoires von choies. Choies bringen Ihnen die besten Mode-Kleidung und Schuhe online."),
                "fr"=>array("title"=>"Choies: le magasin avec la dernière mode de la rue - acheter les vêtements et chaussures de mode","keywords"=>"mode de la rue, mode en ligne, vêtements de mode, vêtements pour femmes, mode de lookbook.nu, mode de polyvore, chaussures de mode","description"=>"Découvrir la dernière mode de la rue des femmes.acheter de milliers styles, y compris robes,chaussures,bijoux et accessoires de choies.choies vous apporte les meilleurs vêtements et chaussures de mode en ligne."),
                "es"=>array("title"=>"Choies: La tienda de moda última de la calle–comprar las prendas y zapatos modernos","keywords"=>"moda de la calle, moda en línea, prenda de moda, prenda de mujer, moda de lookbook.nu, moda de polyvore, zapatos de moda","description"=>"Buscar la moda última de la calle de las mujeres en línea. Comprar los miles estilos, incluyendo vestidos, zapatos,joyas y accesorios desde choies.  choies traerá la mejor ropa de moda y zapatos en línea."),
                "ru"=>array("title"=>"Choies:Магазин последной уличной моды, здесь модные одежды и туфли.","keywords"=>"уличная мода, онлайн мода, модные одежды,женские одежды, lookbook.nu мода, polyvore мода, модные туфли","description"=>"Обнаружить новейшие женская уличная мода онлайн. Купить из тысяч стилей,включая платья, туфли, украшения и аксессуары из choies.Сhoies принесет вам самые лучшие модные одежды и туфли онлайн."),
                );
            if($lang!=""){
                $this->template->title = $seoinfo[$lang]['title'];
                $this->template->keywords = $seoinfo[$lang]['keywords'];
                $this->template->description = $seoinfo[$lang]['description'];
            }else{
                $this->template->title = Site::instance()->get('meta_title');
                $this->template->keywords = Site::instance()->get('meta_keywords');
                $this->template->description = Site::instance()->get('meta_description'); 
            }
            // $this->site_id = Site::instance()->get('id');
            $this->language = $lang;

            //face cpc guo add
            $utm_source = Arr::get($_GET, 'utm_source', 0);
            $utm_medium = Arr::get($_GET, 'utm_medium', 0);
            if($utm_source === 'facebook' and $utm_medium === 'cpc'){
                    $_SESSION['facecpc'] = 1;
            }

            $lang_list = Kohana::config('sites.lang_list');
            $this->template->lang_list = $lang_list;

            $cookie_currency = Cookie::get('cookie_currency');
            if($cookie_currency){
                if(Site::instance()->get('currency') != '' AND 
                    array_search($cookie_currency, explode(',', Site::instance()->get('currency'))) !== FALSE){
                        Site::instance()->currency_set($cookie_currency);
                }
            }

            // set is_mobile --- sjm add 2015-12-15
            $_is_mobile = Session::instance()->get('is_mobile');
            $this->is_mobile = $_is_mobile;
            $this->template->tem_mobile = $_is_mobile; //  guo add 1.25
            $_user_device = Session::instance()->get('user_device');
            $this->user_device = $_user_device;
            $user_session = Session::instance()->get('user');
            $this->template->user_session = $user_session;
            
        }

}
