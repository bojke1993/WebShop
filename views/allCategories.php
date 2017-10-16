<?php

require_once APP_ROOT.'/models/CategoriesModel.php';
$cat = new CategoriesModel();
$allCat = $cat->allCategories();
?>

<body>
<table style="border=2">
    <tr style="text-align: left; background-color:darkkhaki">
        <th>id</th>
        <th>name</th>
        <th>description</th>
    </tr>
    <?php foreach ($allCat as $item) {
        echo '<tr>
                    <th>'.$item['idCategory'].'</th>
                    <th>'.$item['name'].'</th>
                    <th>'.$item['description'].'</th>
                    <th><a href="#">edit</a></th>
                    <th><a href="#" onclick="return  confirm(\'Do you want to delete category?\')">delete</a></th>';
    }?>
</table>
<a href="#">Add Category</a><br>
</body>