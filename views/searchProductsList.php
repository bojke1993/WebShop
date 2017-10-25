<?php
require_once APP_ROOT . '/models/ProductsModel.php';

$p = new ProductsModel();
$filter = "";
if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
}
$searchList = $p->searchProducts($filter);
?>

<body>
    <h2>Results</h2>
    <table border="solid" width="30%">
        <tr style="background-color: lightgray; color: black; text-align: left" >
            <th>Name</th>
            <th>Price</th>
            <th>delete</th>
        </tr>
        <?php
        foreach ($searchList as $item) {
            echo '<tr><th><a href="index.php?op=showProductInfo&idProd=' . $item['idproducts'] . '">'
                 . $item['name'] . '</th><th>' . $item['price'] . '
                  <th><a href="index.php?op=deleteProduct&idProd='.$item['idproducts'].'" 
                  onclick="return  confirm(\'Do you want to delete category?\')">delete</a></th></th></tr>';
        }
        ?>
    </table>
</body>
