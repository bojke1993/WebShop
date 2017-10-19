<?php

class ProductController extends Controller
{
    private $product = null;

    public function showProductsByCategory()
    {
        include APP_ROOT.'/views/menu.php';
        include APP_ROOT.'/views/productsByCategory.php';
    }

    public function showProductInfo()
    {
        include APP_ROOT.'/views/menu.php';
        include APP_ROOT.'/views/productInfo.php';
    }
}
