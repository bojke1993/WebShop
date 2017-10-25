<?php
/**
 * Created by PhpStorm.
 * User: ivanbojovic
 * Date: 11.10.17.
 * Time: 14.17
 */
require_once APP_ROOT . '/exceptions/PictureException.php';
class Controller
{
    //function for translation
    public static function __($string)
    {
        return $string;
    }

    //uploads picture to server
    public function uploadPicture()
    {
        //todo check if uploaded file is image, file size...
        $pictureURL = null;
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["pictureURL"]['name']);
        if (is_uploaded_file($_FILES['pictureURL']['tmp_name'])) {
            move_uploaded_file($_FILES["pictureURL"]["tmp_name"], $target_file);
            $pictureURL = '../PhpWebShop/'.$target_file;
        } else {
            throw new PictureException('Picture not uploaded!!!');
        }

        return $pictureURL;
    }

}
