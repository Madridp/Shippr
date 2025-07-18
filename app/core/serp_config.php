<?php

/**
 * Shippr Remaster 2021
 * Desarrollado por Joystick SA de CV
 * Todos los derechos reservados
 * Versión 2.2.0
 */
define('SITEVERSION'                                          , '2.5.0');

/*
 Paths constants
 */
define("DS"                                                   , DIRECTORY_SEPARATOR);
define("ROOT"                                                 , getcwd() . DS);
define("EXT"                                                  , ".php");

/**
 * Folder to save backups and new updates
 */
define('BACKUPS'                                              , ROOT . 'backups' . DS);
define('UPDATES'                                              , ROOT . 'updates' . DS);
define('VERSIONS'                                             , ROOT . 'versions' . DS);

/*
 Main app folder and subfolders
 */
define("APP"                                                  , ROOT . "app" . DS);
define("CONTROLLERS"                                          , ROOT . "app" . DS . "controllers" . DS);
define("CORE"                                                 , ROOT . "app" . DS . "core" . DS);
define("FUNCTIONS"                                            , ROOT . "app" . DS . "functions" . DS);
define("CRON"                                                 , ROOT . "app" . DS . "cron" . DS);
define("DB"                                                   , ROOT . "app" . DS . "db" . DS);
define("DB_BU"                                                , ROOT . "app" . DS . "db_backups" . DS);
define("HELPERS"                                              , ROOT . "app" . DS . "helpers" . DS);
define("HANDLERS"                                             , ROOT . "app" . DS . "handlers" . DS);
define("MIGRATIONS"                                           , ROOT . "app" . DS . "migrations" . DS);
define("INTERFACES"                                           , ROOT . "app" . DS . "interfaces" . DS);
define("MODELS"                                               , ROOT . "app" . DS . "models" . DS);
define('LOGS'                                                 , ROOT . 'app' . DS . 'logs' . DS);
define("VENDOR"                                               , ROOT . "app" . DS . "vendor" . DS);

/*
 Resources paths
 */
define("RES"                                                  , "assets/");
define("CSS"                                                  , RES . "css/");
define('PLUGINS'                                              , RES . 'plugins/');
define("JS"                                                   , RES . "js/");
define('SAT'                                                  , JS  . 'catalogos_sat_3.3/');
define("IMG"                                                  , RES . "img/");
define("COURIERS"                                             , IMG . "couriers/");
define("FAVICON"                                              , RES . "favicon/");
define('SAVE_FILES'                                           , RES . 'files' . DS);
define('UPLOADS'                                              , RES . "uploads" . DS);
define('QR'                                                   , UPLOADS . "qr" . DS);
define("IMAGES"                                               , ROOT . RES . "img" . DS);
define("REL_IMAGES"                                           , RES . "img" . DS);

/*
 Main templates folder and views paths
 */
define("TEMPLATES"                                            , ROOT . "templates" . DS);
define('EMAIL_TEMPLATES'                                      , TEMPLATES . 'email/');
define("INCLUDES"                                             , TEMPLATES . "includes" . DS);
define("VIEWS"                                                , TEMPLATES . "views" . DS);
define('PDF'                                                  , TEMPLATES . "pdf" . DS);
define('MODULES'                                              , TEMPLATES . "modules" . DS);


/**
 * Defines basepath of our application
 * 
 * This is pretty important                                   , every file and redirection will take place based on this constant
 */
define('BASEPATH'                                             , in_array($_SERVER['REMOTE_ADDR'], array("127.0.0.1", "::1")) ? LOCAL_FOLDER : REMOTE_FOLDER);

/*
Define URL of the website or application
*/
//$web_url = (in_array($_SERVER['REMOTE_ADDR']                ,['127.0.0.1','::1'])) ? 'http://127.0.0.1:'.PORT.'/SAISCO/admin/' : 'https://www.saisco.com.mx/admin/';
$web_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
  ? "https" : "http") . '://' . ($_SERVER['HTTP_HOST'] === 'localhost' ? $_SERVER['HTTP_HOST'] . ':' . PORT
  : $_SERVER['HTTP_HOST']) . (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) ? LOCAL_FOLDER : REMOTE_FOLDER);
define("URL"                                                  , $web_url); // Web url of the website

/**
 * Define CUR_PAGE and PREV_PAGE
 */
$cur_page = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
  ? "https" : "http") . '://' . ($_SERVER['HTTP_HOST'] == 'localhost' ? 'localhost:' . PORT
  : $_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI'];
define('CUR_PAGE'                                             , $cur_page);

/**
 * Mailling constants
 */
define('SMTP'                                                 , false);                      // Set it to false if you dont want to use SMTP authentification
define('SMTP_SSL'                                             , true);

// en caso de no ser SSL mail.shippr.com.mx 
define('SMTP_HOST'                                            , 'host de tu server');   // Your hostname, mydomain.godaddy.com example
define('SMTP_USERNAME'                                        , 'correo electrónico'); // For apps use
define('SMTP_PASSWORD'                                        , 'contraseña del correo');      // Real password for this account
define('SMTP_CHARSET'                                         , 'UTF-8');                // Charset to use, by default is UTF-8
define('SMTP_DEBUG'                                           , false);
define('SMTP_PORT'                                            , 26);                     // Port 26 en caso de que no funcione SSL
define('MP_TEST_ACCESS_TOKEN'                                 , null);
