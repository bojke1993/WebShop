<?php

require_once APP_ROOT.'/models/UserModel.php';

$user = new UserModel();
$user->getByID($_SESSION['user']);
$url = $user->getPictureUrl();
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
    <li style="float: right">
        <a><?php echo $user->getFirstName().'&nbsp;'.$user->getLastName(); ?></a>
        <ul class="dropdown">
            <li style="float: left"><a href="index.php?op=userInfo"> MyProfile</a></li>
            <li style="float: left"><a href="index.php?op=logout">logout</a></li>
        </ul>
    </li>
</ul>
</body>
</html>
