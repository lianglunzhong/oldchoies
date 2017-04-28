<?php
defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Asia/Shanghai');
//date_default_timezone_set('Etc/GMT');
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
Kohana::init(array(
    'base_url' => '',
    'index_file' => ''
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
// modify cofree structure's logs 
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

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
    'carrier' => MODPATH.'carrier', // Carrier
    'payment' => MODPATH.'payment', // Payment
    'geoip' => MODPATH.'geoip', //GEOIP
    'kernel' => MODPATH.'kernel',
    'event' => MODPATH.'event',
    'erp' => MODPATH.'erp',
    'points' => MODPATH.'points',
));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
/*
  Route::set('user_login', 'admin/user/login')
  ->defaults(array(
  'directory'  => 'admin',
  'controller' => 'user',
  'action'     => 'login',
  ));

  Route::set('user_logout', 'admin/user/logout')
  ->defaults(array(
  'directory'  => 'admin',
  'controller' => 'user',
  'action'     => 'logout',
  ));
 */

Route::set('user', 'admin/user/<action>(/<id>)')
    ->defaults(array(
        'directory' => 'admin',
        'controller' => 'user',
        'action' => 'profile',
    ));

Route::set('admin', 'admin/site/<controller>(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'admin/site',
        'controller' => 'all',
        'action' => 'dashboard',
    ));

Route::set('admin_sys', 'admin/sys/<controller>(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'admin/sys',
        'controller' => 'all',
        'action' => 'dashboard',
    ));

Route::set('admin_ticket', 'admin/ticket/<controller>(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'admin/ticket',
        'controller' => 'all',
        'action' => 'dashboard',
    ));

Route::set('manage', 'manage/<controller>(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'admin/manage',
        'controller' => 'summary',
        'action' => 'index',
    ));

Route::set('external', 'external/<controller>(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'admin/external',
        'controller' => 'usa',
        'action' => 'index',
    ));


Route::set('default', '(<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'admin',
        'controller' => 'user',
        'action' => 'login',
    ));

define('STATICURL', 'http://d1cr7zfsu1b8qs.cloudfront.net');

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
//define('IN_PRODUCTION', '');
define('IN_PRODUCTION', $_SERVER['COFREE_ENV_TYPE'] == 'production11');

try
{
    $request = Request::instance();
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

    // Log the error
//    Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));

    // Create a 404 response
    if ($request->uri != '404')
    {
                $request->redirect('404');
     }
        else
        {
                // Create a 404 response
                $request->status = 404;
                $request->response = '404 - Page not found. <br /><a href="/">Return to homepage</a>';
        }
    //	$request->response = View::factory('errors/404');
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
// echo View::factory('profiler/stats');
