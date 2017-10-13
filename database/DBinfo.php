<?php
/**
 * Created by PhpStorm.
 * User: ivanbojovic
 * Date: 9.10.17.
 * Time: 10.09
 */



$dbConfig = simplexml_load_file("database/DBconfig.xml");

define('SERVER_NAME',$dbConfig->serverName);
define('DB_NAME',$dbConfig->dbName);
define('USERNAME',$dbConfig->username);
define('PASSWORD',$dbConfig->password);


