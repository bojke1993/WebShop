<?php

require_once APP_ROOT.'/models/UserModel.php';
$user = new UserModel();
$allUsers = $user->allUsers();
?>

<body>
    <table style="border=2">
        <tr style="text-align: left; background-color:darkkhaki">
            <th>id</th>
            <th>firstName</th>
            <th>lastName</th>
            <th>email</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        <?php foreach ($allUsers as $user) {
            echo '<tr>
                    <th>'.$user['idperson'].'</th>
                    <th>'.$user['firstName'].'</th>
                    <th>'.$user['lastName'].'</th>
                    <th>'.$user['email'].'</th>
                    <th><a href="index.php?op=updateByAdmin&id='.$user['idperson'].'">edit</a></th>
                    <th><a href="index.php?op=deleteUser&id='.$user['idperson'].'">delete</a></th>';
        }?>
    </table>
    <a href="index.php?op=showAddUserForm">Add User</a><br>
</body>
