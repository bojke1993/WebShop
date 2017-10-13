<?php
/**
 * Created by PhpStorm.
 * User: ivanbojovic
 * Date: 11.10.17.
 * Time: 15.08
 */

class UsrController extends Controller
{
    private $user = null;

    /**
     * @return null|UserModel
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * UsrController constructor.
     */
    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function login($username, $password)
    {
        if ($this->authenticate($username, $password)) {
            $_SESSION['user'] = $this->user->getId();
            include APP_ROOT . '/views/menu.php';
        } else {
            include APP_ROOT . '/views/login.php';
            include APP_ROOT . '/views/loginError.php';
        }
    }

    //validates email and password
    public function authenticate($e, $p)
    {
        $authentic = false;
        $this->user->getByEmail($e);
        if ($e == $this->user->getEmail() && $p == $this->user->getPassword()) {
            $authentic = true;
        }
        return $authentic;
    }

    public function logout()
    {
        $_SESSION["user"] = null;
        session_destroy();
        include APP_ROOT . '/views/login.php';
    }

    public function showAddUserForm()
    {
        if ($this->isLogged()) {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/listAllUsers.php';
            include APP_ROOT . '/views/addNewUser.php';
        } else {
            require_once APP_ROOT . '/views/login.php';
            require_once APP_ROOT . '/views/notLoggedMessage.php';
        }
    }

    //call userModel method with same params
    public function addNewUser()
    {
        $ret = false;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $type = $_POST['tip'];
        if ($this->user->addUser($email, $password, $fname, $lname, $type)) {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/listAllUsers.php';
            include APP_ROOT . '/views/updateUserMessage.php';
        } else {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/listAllUsers.php';
            include APP_ROOT . '/views/addNewUser.php';
            include APP_ROOT . '/views/updateUserMessageError.php';

        }

        return $ret;
    }

    public function checkPermission($request)
    {
        $ret = true;
        if(!$this->user->checkPermission($request)) {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/accessDeniedMessage.php';
            $ret = false;
        }

        return $ret;
    }

    //collect user data from DB
    public function fetchUserInfo($id)
    {
        if ($this->isLogged()) {
            $this->user->getByID($id);
            $_SESSION['userForChange'] = $this->user->getId();
            require_once APP_ROOT . '/views/menu.php';
            require_once APP_ROOT . '/views/user_info.php';
        } else {
            require_once APP_ROOT . '/views/login.php';
            require_once APP_ROOT . '/views/notLoggedMessage.php';
        }
    }

    //change user data by himself
    public function updateUser()
    {
        if ($this->isLogged()) {
            $id = $_POST['id'];
            $email = $_POST['email'];
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $fname = $_POST['firstname'];
            $lname = $_POST['lastname'];
            if ($this->user->updateUserByHimself($id, $email, $fname, $lname, $currentPassword, $newPassword)) {
                require_once APP_ROOT . '/views/menu.php';
                require_once APP_ROOT . '/views/updateUserMessage.php';
            } else {
                require_once APP_ROOT . '/views/menu.php';
                require_once APP_ROOT . '/views/change_user_data.php';
                require_once APP_ROOT . '/views/updateUserMessageError.php';
            }
        } else {
            require_once APP_ROOT . '/views/login.php';
            require_once APP_ROOT . '/views/notLoggedMessage.php';
        }
    }

    //change user data by himself
    public function updateUserByAdmin()
    {
        if ($this->isLogged()) {
            $id = $_POST['id'];
            $email = $_POST['email'];
            $newPassword = $_POST['newPassword'];
            $fname = $_POST['firstname'];
            $lname = $_POST['lastname'];
            $type = $_POST['tip'];
            if ($this->user->updateUserByAdmin($id, $email, $fname, $lname, $newPassword, $type)) {
                require_once APP_ROOT . '/views/menu.php';
                require_once APP_ROOT . '/views/updateUserMessage.php';
            } else {
                require_once APP_ROOT . '/views/menu.php';
                require_once APP_ROOT . '/views/updateUserMessageError.php';
            }
        } else {
            require_once APP_ROOT . '/views/login.php';
            require_once APP_ROOT . '/views/notLoggedMessage.php';
        }
    }

    //check if user logged in
    public function isLogged()
    {
        $ret = true;
        if ($_SESSION == null) {
            $ret = false;
        }

        return $ret;
    }

    //open page for update data by himself
    public function goToUpdatePage()
    {
        if ($this->isLogged()) {
            require_once APP_ROOT . '/views/menu.php';
            require_once APP_ROOT . '/views/change_user_data.php';
        } else {
            require_once APP_ROOT . '/views/login.php';
            require_once APP_ROOT . '/views/notLoggedMessage.php';
        }
    }

    //open page for update data by admin
    public function goToUpdatePageByAdmin()
    {
        if ($this->isLogged()) {
            include APP_ROOT . '/views/menu.php';
            $_SESSION['userForChange'] = $_GET['id'];
            include APP_ROOT . '/views/change_user_data_By_admin.php';
        } else {
            include APP_ROOT . '/views/login.php';
            include APP_ROOT . '/views/notLoggedMessage.php';
        }
    }

    //shows all users from database
    public function displayAllUsers()
    {
        if ($this->isLogged()){
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/listAllUsers.php';
        } else {
            include APP_ROOT . '/views/login.php';
            include APP_ROOT . '/views/notLoggedMessage.php';
        }
    }

    //delete user with id = $_GET[id]
    public function deleteUser()
    {
        if ($this->isLogged()){
            $id =$_GET['id'];
            if ($this->user->delete($id)) {
                include APP_ROOT . '/views/menu.php';
                include APP_ROOT . '/views/listAllUsers.php';
                include APP_ROOT . '/views/deleteUserSuccessMessege.php';
            }
        } else {
            include APP_ROOT . '/views/login.php';
            include APP_ROOT . '/views/notLoggedMessage.php';
        }
    }
}