<?php 
/**
 * Shippr Remaster 2021
 * Designed by Joystick
 * 
 * Do not edit anything below this line
 * or you will be breaking terms of use and service
 * 
 * For more information please contact us at soporte@joystick.com.mx
 * 
 * www.joystick.com.mx
 * 
 */

/** Updated version since 1.0.1 */
/** Development port to work on localhost */
define('PORT' , '8848');

// This will be used on html include header to set a basepath to load all the resources baed
// on this current path defined
// We will need 2 of them, one for development and one form production
// That's why we are using ternary operators right here
// We are using IS_LOCAL wich is an array of 2 local IPs, if REMOTE_ADDR matches then
// we are running on localserver
// LOCAL_FOLDER must be the top parent folder where your project resides
// example: htdocs/afolder/another/lumus/
// then LOCAL_FOLDER should be /afolder/another/lumus/
define('LOCAL_FOLDER' , '/sistemas/shippr/'); // Starting after htdocs or www depends on the virtual server you are using htdocs for XAMPP

// Now remote folder
// Same goes for this one, the base folder must be your domain root
// Example: domain.com/parent/v1/lumus/
// Then REMOTE_FOLDER should be /parent/v1/lumus
define('REMOTE_FOLDER' , '/TU RUTA PARA SERVIDOR DE PRODUCCIÓN/');

/** Extra constants to be used */
/** API Keys */
define('STATIC_GMAPS' , 'TOKEN DE ACCESO PARA GMAPS');

// Versión 1.0.4.9
define('AUTH_TKN_NAME', '__tkn_shppr');
define('AUTH_ID_NAME' , '__id_shppr');

/** Site salt for password and string encryption */
define('SITESALT'       , 'From%!$_JoystickWithLove<3%_$%');

/*
Define if we re on production or sandbox mode to testing
*/
define("MODE"           , "sandbox"); // live or sandbox