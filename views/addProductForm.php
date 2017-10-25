<?php
require_once APP_ROOT . '/models/ProductsModel.php';
require_once APP_ROOT . '/models/CategoriesModel.php';

$cat = new CategoriesModel();
$allCategories = $cat->allCategories();
$p = new ProductsModel();
?>

<body>
<br>
<h2>---Add New Product---</h2>
<form action="index.php?op=addProduct" method="post" enctype="multipart/form-data">
    <input type="file" name="pictureURL" id="pictureURL"><br><br>
    <input type="text" name="productName" placeholder="product name"><br><br>
    <input type="text" name="description" placeholder="product description"><br><br>
    <input type="text" name="productPrice" placeholder="product price"><br><br>
    <select name="categories[]" multiple="multiple" style="height: 200px">
        <option value="0">--no parent option--</option>
        <?php
        foreach ($allCategories as $item) {
            echo '<option value="'.$item['idCategory'].'">'.$item['name'].'</option>';
        }
        ?>
    </select>
    Hold CTRL for multiple select
    <br><br>
    <input type="submit" value="addProduct" name="op">
</form>
</body