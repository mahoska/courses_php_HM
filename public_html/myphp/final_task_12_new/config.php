<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__.DS);


define('TABLE_NAME', 'MY_TEST');
define('PG_TABLE_NAME', 'PG_TEST');

//mysql
define('HOST','localhost');
define('DBNAME', 'user1');
//define('USER', 'user1');
//define('PSW', 'tuser1');

//local
define('USER', 'root');
define('PSW', '111'); //linux
//define('PSW', '');  //xampp


//postgres
define('PGHOST', 'localhost');
define('PGDBNAME', 'user1');
//hosting
//define('PGUSER', 'user1'); 
//define('PGPSW', 'user1z');

//local
define('PGUSER', 'anna');
define('PGPSW', '111');

define("MYSQL","MySql");
define("PGSQL","PgSql");

define('ERROR_CONNECT', "could not connect");
define('ERROR_DB', "can not connect to the database");

define('ERROR_READING_TABLE','Table reading error');
define('ERROR_EXIST_FIELD','Field is missing');
define('ERROR_RECORD','Insufficient data to create record');


define('FATAL_ERR', 'not selected poles in select');
define('FLASH_KEY', 'flash_message');
