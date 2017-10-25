<?php

require_once APP_ROOT . '/models/UserModel.php';

$user = new UserModel();
$allUsers = $user->allUsers();
?>


<body>
<form action="index.php" method="post">
    <a href="index.php?op=showAddUserForm">Add User</a><br>
    <table style="border=2" width="50%">
        <tr style="text-align: left; background-color:lightgray; color: black">
            <th>id</th>
            <th>firstName</th>
            <th>lastName</th>
            <th>email</th>
            <th>edit</th>
            <th>delete</th>
        </tr>
        <?php foreach ($allUsers as $user) {
            echo '<tr style="text-align: left">
                    <th>' . $user['idperson'] . '</th>
                    <th>' . $user['firstName'] . '</th>
                    <th>' . $user['lastName'] . '</th>
                    <th>' . $user['email'] . '</th>
                    <th><a href="index.php?op=updateByAdmin&id=' . $user['idperson'] . '">edit</a></th>
                    <th><a href="index.php?op=deleteUser&id=' . $user['idperson'] . '" 
                           onclick="return  confirm(\'Do you want to delete user?\')">delete</a></th>';
        } ?>
    </table>
</form>
</body>
