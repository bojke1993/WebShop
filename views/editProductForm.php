<?php
require_once APP_ROOT.'/models/ProductsModel.php';
require_once APP_ROOT.'/models/CategoriesModel.php';

$prod = new ProductsModel();
$cat = new CategoriesModel();

$prodCategories = null;
$difference = null;
$pictures = null;
if (isset($_GET['idProd'])) {
    $prod->getByID($_GET['idProd']);
    $pictures = $prod->getAllProductPictures($_GET['idProd']);
    $prodCategories = $cat->getByProduct($_GET['idProd']);
    $difference = $cat->getCategoriesWhichNotBelongsToProduct($_GET['idProd']);
}
?>

<body>
<h2><?php echo $prod->getName()?></h2>
<ul>
    <?php foreach ($prodCategories as $category) {
        echo '<li><a href="index.php?op=showProductsByCategory&idCat='.$category['idCategory'].'">'.$category['name'].'</a></li>';
    }?>
</ul>
<fieldset style="border-style: solid" name="Product Pictures">
    <?php foreach ($pictures as $picture) {
        echo '<img src="'.$picture['imageUrl'].'" width=300px height=200px>';
    }?>
</fieldset>

<form action="index.php?idProd=<?php echo $prod->getId();?>" method="post" enctype="multipart/form-data">
    <input type="file" name="pictureURL" id="pictureURL"><br><br>
    <input type="submit" name="op" value="addProductPicture">
</form>

<form action="index.php" method="get">
    <input type="hidden" name="idProd" value="<?php echo $prod->getId();?>">
    <select name="categories[]" multiple="multiple" style="height: 200px">
        <?php
        foreach ($difference as $item) {
            echo '<option value="'.$item['idCategory'].'">'.$item['name'].'</option>';
        }
        ?>
    </select>
    Hold CTRL for multiple select
    <br><br>
    <input type="submit" value="addProductCategory" name="op">
</form>

<form action="index.php?op=updateProduct" method="post" >
    <input type="hidden" name="idProd" value="<?php echo $prod->getId();?>">
    <input type="text" name="productName" value="<?php echo $prod->getName();?>"><br><br>
    <input type="text" name="description" value="<?php echo $prod->getDescription();?>"><br><br>
    <input type="text" name="productPrice" value="<?php echo $prod->getPrice()?>"><br><br>

    <input type="submit" value="updateProduct" name="op">
</form>
</body>