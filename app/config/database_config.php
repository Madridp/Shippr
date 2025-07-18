<?php 

/*
Configuration of database credentials for local and production
DB credential localhost or vanilla
*/
define('LDB_ENGINE' , 'mysql');
define('LDB_HOST'   , 'localhost');
define('LDB_NAME'   , 'db_shippr');
define('LDB_USER'   , 'root');
define('LDB_PASS'   , '');
define('LDB_CHARSET', 'utf8');

/** Production credentials */
define('DB_ENGINE' , 'mysql');
define("DB_HOST"   , "localhost");
define("DB_NAME"   , "__REMOTE__");
define("DB_USER"   , "__REMOTE__");
define("DB_PASS"   , "__REMOTE__");
define('DB_CHARSET', 'utf8');