<?php
require_once APP_ROOT.'/models/ProductsModel.php';
require_once APP_ROOT.'/models/CategoriesModel.php';
$children = null;
$prodList = null;
if (isset($_GET['idCat'])) {
    $cat = new CategoriesModel();
    $cat->getByID($_GET['idCat']);
    $children = $cat->getChildren($_GET['idCat']);
    $prod = new ProductsModel();
    $prodList = $prod->getByCategory($_GET['idCat']);
}
?>

<body>
    <h2><?php echo $cat->getName()?></h2>
    <ul>
        <?php
        if (!(sizeof($children) == 0)){
            foreach ($children as $child) {
                echo '<li><a href="index.php?op=showProductsByCategory&idCat='.$child['childID'].'">'.$child['name'].'</a></li>';
            }
        }
        ?>
    </ul>
    <table style="border-style: solid" width="60%">
        <tr style="color: black; background-color: gray">
            <th>name</th>
            <th>description</th>
            <th>price</th>
        </tr>
        <?php foreach ($prodList as $prod) {
            echo '<tr><th><a href="index.php?op=showProductInfo&idProd='.$prod['idproducts'].'">'.$prod['name'].'</a></th><th>'.$prod['description'].'</th><th>'.$prod['price'].'</th></tr>';
        }?>
    </table>
</body>
