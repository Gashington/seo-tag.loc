<?php

defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------
// Load the core Kohana class
require SYSPATH . 'classes/kohana/core' . EXT;

if (is_file(APPPATH . 'classes/kohana' . EXT)) {
    // Application extends the core
    require APPPATH . 'classes/kohana' . EXT;
} else {
    // Load empty core extension
    require SYSPATH . 'classes/kohana' . EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Minsk');

/**
 * Set the default locale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
//if (isset($_SERVER['KOHANA_ENV'])) {
//Kohana::$environment = constant('Kohana::' . strtoupper($_SERVER['KOHANA_ENV']));
//}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Cookie::$salt = '1';
Cookie::$expiration = Date::MONTH * 3;
Cookie::$domain = $_SERVER['HTTP_HOST'];
if ($_SERVER["REMOTE_ADDR"] == '127.0.0.1') {
    Kohana::$environment = Kohana::DEVELOPMENT;
    ini_set('display_errors', 1);
} else {
    Kohana::$environment = Kohana::PRODUCTION;
    ini_set('display_errors', 0);
}

Kohana::init(array(
    'base_url' => 'http://' . $_SERVER['HTTP_HOST'],
    'index_file' => false,
    'charset' => 'utf-8',
    'profile' => Kohana::$environment === Kohana::DEVELOPMENT, // Профилирование
    'caching' => Kohana::$environment === Kohana::PRODUCTION, // Кешировать внутреннюю информацию.
    'errors' => Kohana::$environment === Kohana::DEVELOPMENT, // Обрабатывать станд-ый вывод ошибок
));

/**
 * Вести логи только в режиме PRODUCTION
 */
if (Kohana::$environment == Kohana::PRODUCTION)
    Kohana::$log->attach(new Log_File(APPPATH . 'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);


/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
    'auth' => MODPATH . 'auth', // Basic authentication
    'cache' => MODPATH . 'cache', // Caching with multiple backends
    //'codebench'  => MODPATH.'codebench',  // Benchmarking tool
    'database' => MODPATH . 'database', // Database access
    'image' => MODPATH . 'image', // Image manipulation
    'orm' => MODPATH . 'orm', // Object Relationship Mapping
    //'unittest'   => MODPATH.'unittest',   // Unit testing
    //'userguide'  => MODPATH.'userguide',  // User guide and API documentation
    //'profilertoolbar'  => MODPATH.'profilertoolbar',
    'pagination' => MODPATH . 'pagination',
    'orm-mptt' => MODPATH . 'orm-mptt',
    'captcha'  => MODPATH.'captcha', //Captcha 
    //'email' => MODPATH.'email',
));
Kohana::$config->attach(new Kohana_Config_Database(array('table' => 'config')));

if (!Route::cache()) {

    Route::set('admin', 'admin(/<controller>(/<action>(/<params>(/<page>))))', array('params' => '[a-z\/\_0-9\.\-]+', 'page' => '[0-9]+'))
            ->defaults(array(
                'directory' => 'admin',
                'controller' => 'main',
                'action' => 'index',
    ));


    Route::set('contact', '<controller>', array('controller' => 'contact'))
            ->defaults(array(
                'directory' => 'index',
                'action' => 'index',
    ));

    Route::set('search', '<controller>(/<id>)', array('controller' => 'search'))
            ->defaults(array(
                'directory' => 'index',
                'action' => 'index',
    ));

    /*Route::set('gallery', '<controller>/(<params>(/<page>))', array('controller' => 'gallery', 'params' => '[A-zА-я\/0-9\-]+', 'page' => '[0-9]+'))
            ->defaults(array(
                'directory' => 'index',
                'controller' => 'gallery',
                'action' => 'index',
    ));*/

    Route::set('docs', '<controller>/(<params>(/<page>))', array('controller' => 'docs', 'params' => '[a-zа-я\/\-0-9]+', 'page' => '[0-9]+'))
            ->defaults(array(
                'directory' => 'index',
                'controller' => 'docs',
                'action' => 'index',
    ));

    Route::set('auth', '<action>', array('action' => 'login|logout|register|change'))
            ->defaults(array(
                'directory' => 'index',
                'controller' => 'auth',
    ));

    
    Route::set('page', 'page(/<page_alias>)')
            ->defaults(array(
                'directory' => 'index',
                'action' => 'index',
                'controller' => 'page',
    ));

    Route::set('tags', 'tags(/<tag>)')
        ->defaults(array(
            'directory' => 'index',
            'action' => 'index',
            'controller' => 'tags',
        ));

    Route::set('widgets', 'widgets(/<controller>(/<param>))', array('param' => '[A-z\/0-9\-]+'))
            ->defaults(array(
                'action' => 'index',
                'directory' => 'widgets',
    ));

    Route::set('ie', '<controller>', array('controller' => 'ie'))
            ->defaults(array(
                'controller' => 'ie',
                'action' => 'index',
    ));

    Route::set('sitemap', '<controller>.xml', array('controller' => 'sitemap'))
            ->defaults(array(
                'controller' => 'sitemap',
                'action' => 'index',
    ));

    Route::set('error', 'error/<action>(/<message>)', array('action' => '[0-9]++', 'message' => '.+'))
        ->defaults(array(
            'controller' => 'error_handler'
     ));

    Route::set('default', '(<controller>(/<action>(/<id>)))')
            ->defaults(array(
                'directory' => 'index',
                'controller' => 'main',
                'action' => 'index',
    ));



    // кешируем роуты    
    Route::cache(TRUE);
}