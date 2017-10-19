<?php

require_once APP_ROOT.'/models/UserModel.php';
$curUser = new UserModel();
$curUser->getByID($_SESSION['user']);
$url = $curUser->getPictureUrl();
$_SESSION['userForChange'] = $curUser->getId();
?>
<html>
<body>
    <img src="<?php echo $url;?>" alt="Profile Picture" style="width:300px;height:300px; border-radius: 50%">
    <br>
    <table style="font-size: 20px; width: 30%; text-align: left">
        <tr>
            <th>Name:</th>
            <th><?php echo $curUser->getFirstName().' '.$curUser->getLastName();?></th>
        </tr>
        <tr>
            <th>email:</th>
            <th><?php echo $curUser->getEmail();?></th>
        </tr>
    </table>
    <form method="get" action="index.php?id=<?php echo $curUser->getId();?>">
        <input type="submit" name="op" value="update">
    </form>
</body>
</html>