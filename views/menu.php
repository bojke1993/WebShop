<?php

require_once APP_ROOT.'/models/UserModel.php';

$user = new UserModel();
$user->getByID($_SESSION['user']);
?>


<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href='views/css/homePageStyle.css'>
</head>
<body>
<ul>
    <li><a href="index.php?op=listAllCategories">Categories</a></li>
    <li><a href="#">Products</a></li>
    <li><a href="index.php?op=allUsers">Users</a></li>
    <span style="float: right">
            <li>
            <a><?php echo $user->getFirstName().'&nbsp;'.$user->getLastName(); ?></a>
                <ul class="dropdown">
                    <li><a href="index.php?op=userInfo"> MyProfile</a></li>
                    <li><a href="index.php?op=logout">logout</a></li>
                </ul>
        </li>
        </span>
</ul>
</body>
</html>
