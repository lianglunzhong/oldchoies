<?php
/**
 * The directory in which your application specific resources are located.
 * The application directory must contain the bootstrap.php file.
 *
 * @see  http://kohanaframework.org/guide/about.install#application
 */
$application = 'application';

/**
 * The directory in which your modules are located.
 *
 * @see  http://kohanaframework.org/guide/about.install#modules
 */
$modules = 'modules';

/**
 * The directory in which the Kohana resources are located. The system
 * directory must contain the classes/kohana.php file.
 *
 * @see  http://kohanaframework.org/guide/about.install#system
 */
$system = 'system';

/**
 * The default extension of resource files. If you change this, all resources
 * must be renamed to use the new extension.
 *
 * @see  http://kohanaframework.org/guide/about.install#ext
 */
define('EXT', '.php');

/**
 * Set the PHP error reporting level. If you set this in php.ini, you remove this.
 * @see  http://php.net/error_reporting
 *
 * When developing your application, it is highly recommended to enable notices
 * and strict warnings. Enable them by using: E_ALL | E_STRICT
 *
 * In a production environment, it is safe to ignore notices and strict warnings.
 * Disable them by using: E_ALL ^ E_NOTICE
 *
 * When using a legacy application with PHP >= 5.3, it is recommended to disable
 * deprecated notices. Disable with: E_ALL & ~E_DEPRECATED
 */
//if(isset($_SERVER['COFREE_ENV_TYPE']) AND $_SERVER['COFREE_ENV_TYPE'] == 'PRODUCTION')
//{
    error_reporting(0);
    ini_set('display_errors', 0);
//}
//else
//{
//    error_reporting(E_ALL & ~E_DEPRECATED);
//}


/**
 * End of standard configuration! Changing any of the code below should only be
 * attempted by those with a working knowledge of Kohana internals.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 */
// Set the full path to the docroot
define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

/*
  // Make the application relative to the docroot
  if ( ! is_dir($application) AND is_dir(DOCROOT.$application))
  $application = DOCROOT.$application;

  // Make the modules relative to the docroot
  if ( ! is_dir($modules) AND is_dir(DOCROOT.$modules))
  $modules = DOCROOT.$modules;

  // Make the system relative to the docroot
  if ( ! is_dir($system) AND is_dir(DOCROOT.$system))
  $system = DOCROOT.$system;
 */

// Define the absolute paths for configured directories
define('APPPATH', realpath(DOCROOT.'application').DIRECTORY_SEPARATOR);
define('MODPATH', realpath(DOCROOT.'modules').DIRECTORY_SEPARATOR);
define('SYSPATH', realpath(DOCROOT.'system').DIRECTORY_SEPARATOR);

// modify cofree structure
//define('MODPATH', realpath($_SERVER['COFREE_KO3_DIR'].DIRECTORY_SEPARATOR.'modules').DIRECTORY_SEPARATOR);
//define('SYSPATH', realpath($_SERVER['COFREE_KO3_DIR'].DIRECTORY_SEPARATOR.'system').DIRECTORY_SEPARATOR);
// Clean up the configuration vars
//unset($application, $modules, $system);
/*
  if (file_exists('install'.EXT))
  {
  // Load the installation check
  return include 'install'.EXT;
  }
 */

// Load the base, low-level functions
require SYSPATH.'base'.EXT;

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

/*
  if (is_file(APPPATH.'classes/kohana'.EXT))
  {
  // Application extends the core
  require APPPATH.'classes/kohana'.EXT;
  }
  else
  {
  // Load empty core extension
  require SYSPATH.'classes/kohana'.EXT;
  }
 */

require SYSPATH.'classes/kohana'.EXT;

// require geoip
require(APPPATH . "classes/geoip.inc.php");

// Bootstrap the application
require APPPATH.'bootstrap'.EXT;
