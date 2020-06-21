<?php

session_start();

/* defined variables for mysql */

define('MYSQL_SERVER', 'localhost');
define('MYSQL_DBNAME', 'webdes28_login');
define('MYSQL_USERNAME', 'webdes28_login');
define('MYSQL_PASSWORD', '1021saeed');

/* other defined variables */

define('SITE_URL', 'http://web-designer-center.ir/');
define('SITE_PATH', __DIR__ . DIRECTORY_SEPARATOR);

/* include all of modules */

foreach (glob('lib/*.php') as $lib_file){
    include_once ($lib_file);
}


