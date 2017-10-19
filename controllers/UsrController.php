<?php

require_once APP_ROOT.'/exceptions/AccessDeniedException.php';
require_once APP_ROOT.'/exceptions/NotLoggedException.php';

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
        if ($e === $this->user->getEmail() && $p === $this->user->getPassword()) {
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
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/listAllUsers.php';
        include APP_ROOT . '/views/addNewUser.php';
    }

    //call userModel method with same params
    public function addNewUser()
    {
        $email = $password = $fname = $lname = $type = null;
        $ret = false;
        if (isset($_POST['email'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['tip'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $fname = $_POST['firstname'];
            $lname = $_POST['lastname'];
            $type = $_POST['tip'];
        } else {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/listAllUsers.php';
            include APP_ROOT . '/views/addNewUser.php';
            include APP_ROOT . '/views/addUserErrorMessage.php';
            return false;
        }
        if ($this->user->addUser($email, $password, $fname, $lname, $type)) {
            $ret = true;
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/listAllUsers.php';
            include APP_ROOT . '/views/updateUserMessage.php';
        } else {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/listAllUsers.php';
            include APP_ROOT . '/views/addNewUser.php';
            include APP_ROOT . '/views/addUserErrorMessage.php';

        }
        return $ret;
    }

    public function checkPermission($request)
    {
        $ret = true;
        if (!($request == 'login' || $request == 'logout' || $request == 'action')) {
            if (!$this->isLogged()) {
                throw new NotLoggedException('you are not logged on system');
            }
        }
        if (!$this->user->checkPermission($request)) {
            throw new AccessDeniedException('not authorized for this action!!!');
        }

        return $ret;
    }

    //collect user data from DB
    public function fetchUserInfo($id)
    {
        $this->user->getByID($id);
        $_SESSION['userForChange'] = $this->user->getId();
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/user_info.php';
    }

    //change user data by himself
    public function updateUser()
    {
        $id = $email = $currentPassword = $newPassword = $fname = $lname = null;
        if (isset($_POST['id'], $_POST['email'], $_POST['currentPassword'], $_POST['newPassword'], $_POST['firstname'],
            $_POST['lastname']))
        {
            $id = $_POST['id'];
            $email = $_POST['email'];
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $fname = $_POST['firstname'];
            $lname = $_POST['lastname'];
        } else {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/change_user_data.php';
            include APP_ROOT . '/views/addUserErrorMessage.php';
            return false;
        }
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["pictureURL"]['name']);
        if (is_uploaded_file($_FILES['pictureURL']['tmp_name'])) {
            move_uploaded_file($_FILES["pictureURL"]["tmp_name"], $target_file);
            $pictureURL = '../PhpWebShop/'.$target_file;
        } else {
            $pictureURL = $this->user->getByID($_POST['id'])->getPictureUrl();
        }
        if ($this->user->updateUserByHimself($id, $email, $fname, $lname, $currentPassword, $newPassword, $pictureURL)) {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/updateUserMessage.php';
        } else {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/change_user_data.php';
            include APP_ROOT . '/views/updateUserMessageError.php';
        }
    }

    //change user data by himself
    public function updateUserByAdmin()
    {
        $id = $email = $newPassword = $fname = $lname = $type = null;
        if (isset($_POST['id'], $_POST['email'], $_POST['newPassword'], $_POST['firstname'], $_POST['lastname'],
            $_POST['tip']))
        {
            $id = $_POST['id'];
            $email = $_POST['email'];
            $newPassword = $_POST['newPassword'];
            $fname = $_POST['firstname'];
            $lname = $_POST['lastname'];
            $type = $_POST['tip'];
        } else {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/change_user_data.php';
            include APP_ROOT . '/views/addUserErrorMessage.php';
            return false;
        }
        if ($this->user->updateUserByAdmin($id, $email, $fname, $lname, $newPassword, $type)) {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/updateUserMessage.php';
        } else {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/updateUserMessageError.php';
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
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/change_user_data.php';
    }

    //open page for update data by admin
    public function goToUpdatePageByAdmin()
    {
        include APP_ROOT . '/views/menu.php';
        $_SESSION['userForChange'] = $_GET['id'];
        include APP_ROOT.'/views/listAllUsers.php';
        include APP_ROOT . '/views/change_user_data_By_admin.php';
    }

    //shows all users from database
    public function displayAllUsers()
    {
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/listAllUsers.php';
    }

    //delete user with id = $_GET[id]
    public function deleteUser()
    {
        $id = $_GET['id'];
        if ($this->user->delete($id)) {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/listAllUsers.php';
            include APP_ROOT . '/views/deleteUserSuccessMessage.php';
        } else {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/listAllUsers.php';
            include APP_ROOT . '/views/updateUserMessageError.php';
        }
    }

    public function showAccessDeniedMessage()
    {
        include APP_ROOT.'/views/menu.php';
        include APP_ROOT.'/views/accessDeniedMessage.php';
    }

    public function showNotLoggedMessage()
    {
        include APP_ROOT.'/views/login.php';
        include APP_ROOT.'/views/notLoggedMessage.php';
    }
}