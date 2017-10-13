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
    <input type="password" name="newPassword" id="newPassword" placeholder="password" required="required">
    <input type="hidden" name="id" value="<?php echo $userForChange->getId();?>">
    <select name="tip">
        <option disabled selected value> -- select an role -- </option>
        <option value=1>admin</option>
        <option value=2>writer</option>
        <option value=3>reader</option>
    </select>
    <input type="submit" value="changeUserDataByAdmin" id="submit" name="op">
</form>
</body>
