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
require_once 'exceptions/CategoryErrorException.php';
require_once 'exceptions/PictureException.php';
require_once 'exceptions/ProductErrorException.php';
require_once 'exceptions/NotLoggedException.php';
require_once 'exceptions/AccessDeniedException.php';
require_once 'models/UserModel.php';
require_once 'models/CategoriesModel.php';
require_once 'models/ProductsModel.php';
require_once 'controllers/Controller.php';
require_once 'controllers/UsrController.php';
require_once 'controllers/Router.php';
require_once 'controllers/CategoriesController.php';
require_once 'controllers/ProductController.php';
require_once 'database/DB.php';

$op = 'action';
if (isset($_REQUEST['op'])) {
    $op = $_REQUEST['op'];
}

$req = new Router();
$req->handleRequest($op);




