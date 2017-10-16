<?php

require_once APP_ROOT.'/models/UserModel.php';
$curUser = new UserModel();
$curUser->getByID($_SESSION['user']);
$url = $curUser->getPictureUrl();
$_SESSION['userForChange'] = $curUser->getId();
?>
<html>
<body>
    <img src="<?php echo $url;?>" alt="Profile Picture" style="width:300px;height:300px">
    <table border="2">
        <tr>
            <th>FirstName</th>
            <th><?php echo $curUser->getFirstName();?></th>
        </tr>
        <tr>
            <th>LastName</th>
            <th><?php echo $curUser->getLastName();?></th>
        </tr>
        <tr>
            <th>email</th>
            <th><?php echo $curUser->getEmail();?></th>
        </tr>
    </table>
    <form method="get" action="index.php?id=<?php echo $curUser->getId();?>">
        <input type="submit" name="op" value="update">
    </form>
</body>
</html>