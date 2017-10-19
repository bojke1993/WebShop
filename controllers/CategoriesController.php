<?php

class CategoriesController extends Controller
{
    private $cat = null;

    /**
     * CategoriesController constructor.
     * @param null $cat
     */
    public function __construct()
    {
        $this->cat = new CategoriesModel();
    }

    public function showAllCategories()
    {
        include APP_ROOT.'/views/menu.php';
        include APP_ROOT.'/views/allCategories.php';
    }

    public function goToEditCategory()
    {
        $_SESSION['idCat'] = $_GET['idCat'];
        include APP_ROOT.'/views/menu.php';
        include APP_ROOT.'/views/allCategories.php';
        include APP_ROOT.'/views/editCategoryForm.php';
    }

    public function goToAddCategory()
    {
        include APP_ROOT.'/views/menu.php';
        include APP_ROOT.'/views/allCategories.php';
        include APP_ROOT.'/views/addNewCategory.php';
    }

    public function deleteCategory()
    {
        $idCat = null;
        if (isset($_GET['idCat'])) {
            $idCat = $_GET['idCat'];
        }
        if ($this->cat->deleteCategory($idCat)) {
            include APP_ROOT.'/views/menu.php';
            include APP_ROOT.'/views/allCategories.php';
            include APP_ROOT.'/views/deleteUserSuccessMessage.php';
        } else {
            include APP_ROOT.'/views/menu.php';
            include APP_ROOT.'/views/allCategories.php';
        }
    }

    public function updateCategory()
    {
        if (!isset($_POST['categoryName']) || !isset($_POST['description']) || !isset($_POST['parentCategory']) || !isset($_POST['id'])) {
            include APP_ROOT.'/views/menu.php';
            include APP_ROOT.'/views/allCategories.php';
            include APP_ROOT.'/views/editCategoryForm.php';
            return false;
        }
        $id = $_POST['id'];
        $name = $_POST['categoryName'];
        $desc = $_POST['description'];
        $parent = $_POST['parentCategory'];
        if ($this->cat->updateCategory($id, $name, $desc, $parent)) {
            include APP_ROOT.'/views/menu.php';
            include APP_ROOT.'/views/allCategories.php';
            include APP_ROOT.'/views/updateUserMessage.php';
        } else {
            include APP_ROOT.'/views/menu.php';
            include APP_ROOT.'/views/allCategories.php';
        }
    }

    public function addCategory()
    {
        if (!isset($_POST['categoryName'] ) || !isset($_POST['description']) || !isset($_POST['parentCategory'])) {
            include APP_ROOT.'/views/menu.php';
            include APP_ROOT.'/views/allCategories.php';
            include APP_ROOT.'/views/addNewCategory.php';
            return false;
        }
        $name = $_POST['categoryName'];
        $desc = $_POST['description'];
        $parent = $_POST['parentCategory'];
        if ($this->cat->addCategory($name, $desc, $parent)) {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/allCategories.php';
            include APP_ROOT . '/views/updateUserMessage.php';
        } else {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/allCategories.php';
        }

    }
}