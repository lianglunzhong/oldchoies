<?php
defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://docs.kohanaphp.com/about.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array( 'Kohana', 'auto_load' ));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(
    array(
        'base_url' => '',
        'index_file' => '',
        'errors' => FALSE
    )
);

/**
 * Attach the file write to logging. Multiple writers are supported.
 * Attach the errors file write to error logging. --- sjm 2015-12-22
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs/errors'), array(Kohana::ERROR));
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs/404'), array('PAGE_404'));
// modify cofree structure's logs 
//Kohana::$log->attach(new Kohana_Log_File($_SERVER['COFREE_LOG_DIR']));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
    // 'auth'       => MODPATH.'auth',       // Basic authentication
    // 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
    'database' => MODPATH.'database', // Database access
    // 'image'      => MODPATH.'image',      // Image manipulation
    'orm' => MODPATH.'orm', // Object Relationship Mapping
    'pagination' => MODPATH.'pagination', // Paging of results
    'cache' => MODPATH.'cache', // Paging of results
    'event' => MODPATH.'event',
    // 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
    'carrier' => MODPATH.'carrier', // Carrier
    'payment' => MODPATH.'payment', // Payment
    'kernel' => MODPATH.'kernel',
    'points' => MODPATH.'points',
    'affiliate' => MODPATH.'affiliate',
    'facebook' => MODPATH.'facebook',
    'mysqli' => MODPATH.'mysqli',
));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
//$domain = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ?
//$_SERVER['HTTP_X_FORWARDED_HOST'] :
//(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');

$domain = $_SERVER['COFREE_DOMAIN'];

$site = Site::instance(0, $domain);

if( ! $site->get('id'))
{
        echo 'no domain data';
        exit;
}

// Set LANGUAGE
$uri = $_SERVER['REQUEST_URI'];
$uris = explode('/', $uri);
$lang = $uris[1];
$path = strpos($lang, '?');
if($path !== FALSE)
    $lang = substr($lang, 0, $path);
if(strlen($lang) > 2)
    $lang = '';

// ru redirect to en --- sjm 2016-01-25
if($lang == 'ru')
{
    $redirect = str_replace('/' . $lang, '', $uri);
    header('HTTP/1.1 301 Moved Permanently');//发出301头部 
    header('Location:'.$redirect);
    die;
}

$languages = Kohana::config('sites.language');
$lang_currency = Kohana::config('sites.lang_currency');
$currency = Site::instance()->currency();
if($lang !== 'en' && in_array($lang, $languages))
{
//    if($currency['name'] != $lang_currency[$lang])
//    {
//        Site::instance()->currency_set($lang_currency[$lang]);
//    }
    I18n::lang($lang);
    define('LANGUAGE', $lang);
}
else
{
    I18n::lang('en');
    define('LANGUAGE', '');
}
// 过滤跨站脚本
if($_GET)
{
    foreach($_GET as $key => $val)
    {
        // unset kohana_uri in njnix --- sjm 2015-12-22
        if($key == 'kohana_uri')
        {
            unset($_GET[$key]);
        }
        else
        {
            $_GET[$key] = Security::xss_clean($val);
        }
    }
}

//+++++是否手机访问++
if(!empty($_SERVER['HTTP_USER_AGENT']) && Session::instance()->get('user_device') === NULL)
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $agent_from = strpos($user_agent, '(');
    $agent_to = strpos($user_agent, ';');
    $device = strtolower(substr($user_agent, $agent_from + 1, $agent_to - $agent_from - 1));
    Session::instance()->set('user_device', $device);
}

if(Session::instance()->get('is_mobile') === NULL)
{
    $is_mobile = 0;
    if(empty($_SERVER['HTTP_USER_AGENT']))
    {
        $is_mobile = 0;
    }
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false)
    {
        $device = Session::instance()->get('user_device');
        if($device != 'ipad')
            $is_mobile = 1;
        else
            $is_mobile = 0;
    }
    else
    {
        $is_mobile = 0;
    }

    Session::instance()->set('is_mobile', $is_mobile);
}
//+++++是否手机访问++

Route::set('search', '(<language>/)search(/<q>)')
    ->defaults(array(
        'controller' => 'site',
        'action' => 'search'
    ));

Route::set('search_es', '(<language>/)search_es(/<q>)')
    ->defaults(array(
        'controller' => 'site',
        'action' => 'search_es'
    ));

//TODO 
Route::set('404', '(<language>/)404')
    ->defaults(array(
        'controller' => 'site',
        'action' => '404',
    ));

//TODO  guo 11.2
Route::set('singles-day-sale', '(<language>/)singles-day-sale')
    ->defaults(array(
        'controller' => 'activity',
        'action' => 'singles_day_sale',
    ));

Route::set('Copyright-Infringement-Notice', '(<language>/)Copyright-Infringement-Notice')
    ->defaults(array(
        'controller' => 'activity',
        'action' => 'Copyright_Infringement_Notice',
    ));

Route::set('lookbook', '(<language>/)lookbook(/<id>)')
    ->defaults(array(
        'controller' => 'site',
        'action' => 'lookbook',
    ));

Route::set('trends', '(<language>/)trends(/<id>)')
    ->defaults(array(
        'controller' => 'site',
        'action' => 'trends',
    ));
$site->route();
//$site->tags_route();
Route::set('gcustomer', '(<language>/)customer/(<action>)', array( 'action' => 'product_request' ))
    ->defaults(array(
        'controller' => 'gcustomer',
        'action' => 'index',
    ));

$langpath = '';
if(in_array($lang, $languages))
{
    if($lang !== 'en')
    {
        $langpath = '/'.$lang;
    }
    Route::set('default', '<language>/(<controller>(/<action>(/<id>)))')
        ->defaults(array(
            'controller' => 'site',
            'action' => 'view',
        ));
}
else
{
    Route::set('default', '(<controller>(/<action>(/<id>)))')
        ->defaults(array(
            'controller' => 'site',
            'action' => 'view',
        ));
}

define('LANGPATH', $langpath);
define('LANGTEMP', '/layout/template');
// define('LANGTEMP', $langpath . '/layout/template');
define('STATICURL', 'https://d1cr7zfsu1b8qs.cloudfront.net');
// define('STATICURL', 'http://127.0.0.1:8000/site_media/');
// define('LOCALURL', 'http://192.168.11.153/site_media/');
//define('LOCALURL', 'http://58.213.103.194:8069/uploads/');
define('STATICURLHTTPS', 'https://d1cr7zfsu1b8qs.cloudfront.net');
define('BASEURL', 'https://www.choies.com');
define('URLSTR', 'www.choies.com');
define('EDM', 'http://edm.choies.com');

// define('BASEURL', 'http://local.oldchoies.com');
// define('URLSTR', 'local.oldchoies.com');

/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
//如果是缩略图应用的话，不能有header输出
/*
  $uri = Request::instance()->uri;
  if(substr($uri, 0, 5) == 'image')
  {//image controller
  Request::instance()
  ->execute();
  }
  else
  {
  echo Request::instance()
  ->execute()
  ->send_headers()
  ->response;
  }
 */

//301 Jump----sjm add 2015-02-13
$urls = array(
);

$jumps = array(
);

if(LANGUAGE)
{
    $need_uri = str_replace(LANGUAGE . '/', '', Request::instance()->uri);
}
else
{
    $need_uri = Request::instance()->uri;
}
$url_key = array_search($need_uri, $urls);
if($url_key !== False)
{
    Request::instance()->redirect(LANGPATH . '/' . $jumps[$url_key]);
}

//define('IN_PRODUCTION', '');
if($need_uri == 'cart/ajax_coupon')
{
    define('IN_PRODUCTION', FALSE);
}
else
{
    define('IN_PRODUCTION', $_SERVER['COFREE_ENV_TYPE'] == 'production');
}
//define('IN_PRODUCTION', $_SERVER['COFREE_ENV_TYPE'] == 'production111111');

try
{
        $request = Request::instance();

        //301 jump -- SJM ADD 2014-12-16
        $jumpArr = array('2014-summer-sale');
        $toArr = array('usd-9');
        $uri = $request->uri;
        $uri = str_replace($lang . '/', '', $uri);
        if(in_array($uri, $jumpArr))
        {
            $key = array_keys($jumpArr, $uri);
            $to = $toArr[$key[0]];
            $request->redirect($langpath . '/' . $to);
        }

        // Attempt to execute the response
        $request->execute();

        if($request->send_headers()->response)
        {
                // Get the total memory and execution time
                $total = array(
                    '{memory_usage}' => number_format((memory_get_peak_usage() - KOHANA_START_MEMORY) / 1024, 2).'KB',
                    '{execution_time}' => number_format(microtime(TRUE) - KOHANA_START_TIME, 5).__(' seconds') );

                // Insert the totals into the response
                $request->response = str_replace(array_keys($total), $total, $request->response);
        }
}
catch( Exception $e )
{
        if( ! IN_PRODUCTION)
        {
                throw $e;
        }

        // Log the error --- sjm 2015-12-22
        if($need_uri)
        {
            $referrer = Request::$referrer;
            Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e) . '; URL:/' . $need_uri . ' | REF:' . $referrer);
        }

        $request = Request::instance();

        if($request->uri != '404')
        {
                $current_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
                $referrer = Request::$referrer;
                $client_ip = Request::$client_ip;
                $user_agent = Request::$user_agent;
                if($referrer && $user_agent && strpos($current_uri, '.') === FALSE)
                {
                    Kohana_log::instance()->add('PAGE_404', 'URL:' . $current_uri . ' | REF:' . $referrer . ' | IP:' . $client_ip . ' | AGENT:' . $user_agent);
                }
                $request->redirect(LANGPATH . '/404');
        }
        else
        {
                // Create a 404 response
                $request->status = 404;
                $request->response = '404 - Page not found. <br /><a href="'.LANGPATH.'/">Return to homepage</a>';
        }
}

// Display the request response.
echo $request->response;
/*
  // route test
  $uri = 'site/404';
  // This will loop trough all the defined routes and
  // tries to match them with the URI defined above
  foreach (Route::all() as $r)
  {
  echo Kohana::debug($r->matches($uri));
  }
  exit;
 */
//echo View::factory('profiler/stats');