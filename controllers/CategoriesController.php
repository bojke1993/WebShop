<?php

class CategoriesController
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
}