<?php
require_once APP_ROOT.'/models/ProductsModel.php';
require_once APP_ROOT.'/models/CategoriesModel.php';

$prod = new ProductsModel();
$cat = new CategoriesModel();

$prodCategories = null;
$pictures = null;
if (isset($_GET['idProd'])) {
    $prod->getByID($_GET['idProd']);
    $pictures = $prod->getAllProductPictures($_GET['idProd']);
    $prodCategories = $cat->getByProduct($_GET['idProd']);
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
    <br><br>
    <table style="width: 15%; text-align: left;">
        <tr>
            <th>Name: </th>
            <th><?php echo $prod->getName()?></th>
        </tr>
        <tr>
            <th>description: </th>
            <th><?php echo $prod->getDescription()?></th>
        </tr>
        <tr>
            <th>price: </th>
            <th><?php echo $prod->getPrice()?></th>
        </tr>
    </table>
</body>
