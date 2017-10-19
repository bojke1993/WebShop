<?php

require_once APP_ROOT.'/models/CategoriesModel.php';
$cat = new CategoriesModel();
$allCat = $cat->allCategories();
?>

<body>
<table style="border=2">
    <tr style="text-align: left; background-color:darkkhaki">
        <th>name</th>
        <th>description</th>
        <th>edit</th>
        <th>delete</th>
    </tr>
    <?php foreach ($allCat as $item) {
        echo '<tr>
                    <th><a href="index.php?op=showProductsByCategory&idCat='.$item['idCategory'].'">'.$item['name'].'</th>
                    <th>'.$item['description'].'</th>
                    <th><a href="index.php?op=goToEditCategory&idCat='.$item['idCategory'].'">edit</a></th>
                    <th><a href="index.php?op=deleteCategory&idCat='.$item['idCategory'].'" onclick="return  confirm(\'Do you want to delete category?\')">delete</a></th>';
    }?>
</table>
<a href="index.php?op=goToAddCategory">Add Category</a><br>
</body>