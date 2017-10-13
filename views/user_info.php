<?php

require_once APP_ROOT.'/models/UserModel.php';
$curUser = new UserModel();
$curUser->getByID($_SESSION['user']);
$_SESSION['userForChange'] = $curUser->getId();
?>
<body>
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