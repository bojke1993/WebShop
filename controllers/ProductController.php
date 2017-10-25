<?php

class ProductController extends Controller
{
    private $product = null;

    /**
     * ProductController constructor.
     * @param null $product
     */
    public function __construct()
    {
        $this->product = new ProductsModel();
    }


    public function showProductsByCategory()
    {
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/productsByCategory.php';
    }

    public function showProductInfo()
    {
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/productInfo.php';
    }

    public function goToEditProductPage()
    {
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/editProductForm.php';
    }

    public function goToSearchProductPage()
    {
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/searchProducts.php';
    }

    public function searchProducts()
    {
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/searchProducts.php';
        include APP_ROOT . '/views/searchProductsList.php';
    }

    public function goToAddProductForm()
    {
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/searchProducts.php';
        include APP_ROOT . '/views/addProductForm.php';
    }

    public function addProduct()
    {
        $message = "";
        $name = $desc = $price = null;
        $categories = array();
        if (($_POST['productName'] == null) || ($_POST['productPrice'] == null) || ($_POST['description'] == null) ||
            ($_POST['categories'] == null)) {

            return false;
        }
        $name = $_POST['productName'];
        $price = $_POST['productPrice'];
        $desc = $_POST['description'];
        $categories = $_POST['categories'];
        try {
            $pictureURL = $this->uploadPicture();
            $this->product->addProduct($name, $desc, $price, $categories, $pictureURL);
        } catch (ProductErrorException $e) {
            $message = $e->getMessage();
        } catch (PictureException $e) {
            $message = $e->getMessage();
            $this->product->addProduct($name, $desc, $price, $categories, null);
        }
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/searchProducts.php';
        include APP_ROOT . '/views/searchProductsList.php';
        echo $message;
    }

    public function deleteProduct()
    {
        $id = null;
        if ($_GET['idProd'] != null){
            $id = $_GET['idProd'];
        }
        $this->product->deleteProduct($id);
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/searchProducts.php';
        include APP_ROOT . '/views/searchProductsList.php';
        echo 'Product deleted!!!';
    }

    public function addProductPicture()
    {
        $pictureURL = $id = null;
        if ($_GET['idProd'] != null) {
            $id = $_GET['idProd'];
        }
        try {
            $pictureURL = $this->uploadPicture();
            $this->product->addProductPicture($pictureURL, $id);
        } catch (PictureException $exception) {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/editProductForm.php';
            echo $exception->getMessage();
        }

        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/editProductForm.php';
    }

    public function addProductCategories()

    {
        $categories = array();
        $id = null;
        if (isset($_GET['categories']) && isset($_GET['idProd'])) {
            $categories = $_GET['categories'];
            $id = $_GET['idProd'];
        } else {
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/editProductForm.php';
            return false;
        }
        try {
            $this->product->addAllCategoriesToProduct($categories, $id);
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/editProductForm.php';
        } catch (ProductErrorException $exception){
            include APP_ROOT . '/views/menu.php';
            include APP_ROOT . '/views/editProductForm.php';
            echo $exception->getMessage();
        }
    }

    public function updateProduct()
    {
        $id = $name = $desc = $price = null;
        if ($_POST['idProd'] != null && $_POST['productName'] != null &&
            $_POST['description'] != null && $_POST['productPrice']){

            $id = $_POST['idProd'];
            $name = $_POST['productName'];
            $desc = $_POST['description'];
            $price = $_POST['productPrice'];
            $_GET['idProd'] = $_POST['idProd'];
        }
        $this->product->updateProduct($name, $desc, $price, $id);
        include APP_ROOT . '/views/menu.php';
        include APP_ROOT . '/views/productInfo.php';
    }
}

