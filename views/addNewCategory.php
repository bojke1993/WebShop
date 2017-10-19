<?php
require_once APP_ROOT.'/models/CategoriesModel.php';

$cat = new CategoriesModel();
$all = $cat->allCategories();
?>

<body>
<br>
<h2>---Add New Category---</h2>
<form action="index.php?op=updateCategory" method="post" id="addForm">
    <input type="text" name="categoryName"><br><br>
    <textarea rows="4" cols="50" name="description" form="addForm">---Description---</textarea><br><br>
    <select name="parentCategory">
        <option value="0">--no parent option--</option>
        <?php
        foreach ($all as $item) {
            echo '<option value="'.$item['idCategory'].'">'.$item['name'].'</option>';
        }
        ?>
    </select><br>
    <input type="submit" value="addCategory" name="op">
</form>
</body