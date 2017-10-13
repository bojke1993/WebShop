<?php
require_once APP_ROOT.'/models/UserModel.php';

$userForChange = new UserModel();
$userForChange->getByID($_SESSION['userForChange']);
?>

<body>
<form action="index.php" method="post">
    <input type="text" name="firstname" id="firstname" value="<?php echo $userForChange->getFirstName(); ?>" required="required">
    <input type="text" name="lastname" id="lastname" value="<?php echo $userForChange->getLastName(); ?>" required="required">
    <input type="text" name="email" id="username" value="<?php echo $userForChange->getEmail();?>" required="required">
    <input type="password" name="currentPassword" id="currentPassword" placeholder="Enter current password" required="required">
    <input type="password" name="newPassword" id="newPassword" placeholder="Enter new password" required="required">
    <input type="hidden" name="id" value="<?php echo $userForChange->getId();?>">
    <input type="submit" value="changeUserData" id="submit" name="op">
</form>
</body>
