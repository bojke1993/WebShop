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
        //before calling the action system always checks if the user is logged and
        //if it has required permissions
        if ($request != null) {
            try {
                $ctrl = new UsrController();
                $ctrl->checkPermission($request);
            } catch (NotLoggedException $e) {
                $ctrl->showNotLoggedMessage();
                return false;
            } catch (AccessDeniedException $e){
                $ctrl->showAccessDeniedMessage();
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

            case 'generateAPI':
                $ctrl = new UsrController();
                $ctrl->generateApiKey();
                break;

            case 'listAllCategories':
                $ctrl = new CategoriesController();
                $ctrl->showAllCategories();
                break;

            case 'goToEditCategory':
                $ctrl = new CategoriesController();
                $ctrl->goToEditCategory();
                break;

            case 'goToAddCategory':
                $ctrl = new CategoriesController();
                $ctrl->goToAddCategory();
                break;

            case 'updateCategory':
                $ctrl = new CategoriesController();
                $ctrl->updateCategory();
                break;

            case 'deleteCategory':
                $ctrl = new CategoriesController();
                $ctrl->deleteCategory();
                break;

            case 'addCategory':
                $ctrl = new CategoriesController();
                $ctrl->addCategory();
                break;

            case 'showProductsByCategory':
                $ctrl = new ProductController();
                $ctrl->showProductsByCategory();
                break;

            case 'showProductInfo':
                $ctrl = new ProductController();
                $ctrl->showProductInfo();
                break;

            case 'edit product':
                $ctrl = new ProductController();
                $ctrl->goToEditProductPage();
                break;

            case 'goToSearchProducts':
                $ctrl = new ProductController();
                $ctrl->goToSearchProductPage();
                break;

            case 'searchProducts':
                $ctrl = new ProductController();
                $ctrl->searchProducts();
                break;

            case 'addProductForm':
                $ctrl = new ProductController();
                $ctrl->goToAddProductForm();
                break;

            case 'addProduct':
                $ctrl = new ProductController();
                $ctrl->addProduct();
                break;

            case 'deleteProduct':
                $ctrl = new ProductController();
                $ctrl->deleteProduct();
                break;

            case 'updateProduct':
                $ctrl = new ProductController();
                $ctrl->updateProduct();
                break;

            case 'addProductPicture':
                $ctrl = new ProductController();
                $ctrl->addProductPicture();
                break;

            case 'addProductCategory':
                $ctrl = new ProductController();
                $ctrl->addProductCategories();
                break;

            default:
                require_once APP_ROOT . '/views/login.php';
                break;
        }
    }
}