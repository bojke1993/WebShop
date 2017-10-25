<?php
require_once APP_ROOT.'/models/UserModel.php';

$userForChange = new UserModel();
$userForChange->getByID($_SESSION['userForChange']);
$url = $userForChange->getPictureUrl();
?>

<body>
<form action="index.php" method="post" enctype="multipart/form-data">
    <img src="<?php echo $url?>" style="height: 200px; width: 200px"><br>
    <input type="file" name="pictureURL" id="pictureURL"><br><br>
    <input type="text" name="firstname" id="firstname" value="<?php echo $userForChange->getFirstName(); ?>" required="required"><br><br>
    <input type="text" name="lastname" id="lastname" value="<?php echo $userForChange->getLastName(); ?>" required="required"><br><br>
    <input type="text" name="email" id="username" value="<?php echo $userForChange->getEmail();?>" required="required"><br><br>
    <input type="password" name="currentPassword" id="currentPassword" placeholder="Enter current password" required="required"><br><br>
    <input type="password" name="newPassword" id="newPassword" placeholder="Enter new password" required="required"><br><br>
    <input type="hidden" name="id" value="<?php echo $userForChange->getId();?>">
    <input type="submit" value="changeUserData" id="submit" name="op">
</form>
<form method=post action="index.php">
    API key:&nbsp;<?php echo $userForChange->getApiKey(); ?><input type="submit" value="generateAPI" name="op"><br><br>
</form>
</body>

