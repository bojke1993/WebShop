<?php
/**
 * Created by PhpStorm.
 * User: ivanbojovic
 * Date: 11.10.17.
 * Time: 17.10
 */


class Router
{
    //process requests from index.php
    public function handleRequest($request)
    {
        if ($request != null) {
            $ctrl = new UsrController();
            if (!$ctrl->checkPermission($request)) {
                return false;
            }
        }
        switch ($request) {
            case 'login':
                $ctrl = new UsrController();
                $email = $_POST['email'];
                $pass = $_POST['password'];
                $ctrl->login($email, $pass);
                break;

            case 'logout':
                $ctrl = new UsrController();
                $ctrl->logout();
                break;

            case 'userInfo':
                $ctrl = new UsrController();
                $ctrl->fetchUserInfo($_SESSION['user']);
                break;

            case 'allUsers':
                $ctrl = new UsrController();
                $ctrl->displayAllUsers();
                break;

            case 'update':
                $ctrl = new UsrController();
                $ctrl->goToUpdatePage();
                break;

            case 'updateByAdmin':
                $ctrl = new UsrController();
                $ctrl->goToUpdatePageByAdmin();
                break;

            case 'changeUserData':
                $ctrl = new UsrController();
                $ctrl->updateUser();
                break;

            case 'changeUserDataByAdmin':
                $ctrl = new UsrController();
                $ctrl->updateUserByAdmin();
                break;

            case 'addUser':
                $ctrl = new UsrController();
                $ctrl->addNewUser();
                break;

            case 'deleteUser':
                $ctrl = new UsrController();
                $ctrl->deleteUser();
                break;

            case 'showAddUserForm':
                $ctrl = new UsrController();
                $ctrl->showAddUserForm();
                break;

            default:
                require_once APP_ROOT . '/views/login.php';
                break;
        }
    }
}