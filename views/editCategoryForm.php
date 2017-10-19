<?php

require_once APP_ROOT.'/models/CategoriesModel.php';

$cat = new CategoriesModel();
if (isset($_SESSION['idCat'])) {
    $cat->getByID($_SESSION['idCat']);
}
$all = $cat->allCategories();
?>

<body>
    <br>
    <h2>---Edit Category---</h2>
    <form action="index.php?op=updateCategory" method="post" id="editForm">
        <input type="hidden" name="id" value="<?php echo $cat->getId();?>">
        <input type="text" name="categoryName" value="<?php echo $cat->getName();?>"><br><br>
        <textarea rows="4" cols="50" name="description" form="editForm"><?php echo $cat->getDescription()?></textarea><br><br>
        <select name="parentCategory">
            <option value="0">--no parent option--</option>
            <?php
            foreach ($all as $item) {
                echo '<option value="'.$item['idCategory'].'">'.$item['name'].'</option>';
            }
            ?>
        </select><br>
        <input type="submit" value="updateCategory" name="op">
    </form>
</body>

