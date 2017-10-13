<?php
/**
 * Created by PhpStorm.
 * User: ivanbojovic
 * Date: 11.10.17.
 * Time: 14.16
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

define('APP_ROOT', __DIR__);
require_once 'models/UserModel.php';
require_once 'controllers/Controller.php';
require_once 'controllers/UsrController.php';
require_once 'controllers/Router.php';
require_once 'database/DB.php';

$op = $_REQUEST['op'];
$req = new Router();
$req->handleRequest($op);

