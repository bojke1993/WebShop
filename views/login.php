<?php
/**
 * Created by PhpStorm.
 * User: ivanbojovic
 * Date: 9.10.17.
 * Time: 10.26
 */


$message = "";
if(isset($_SESSION['user'])) {
    require_once APP_ROOT.'/views/menu.php';
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href='views/css/style.css'>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
</head>

<body>
<h2>Login</h2>
<?php if(@$_GET['err'] == 1) $message = "error!!!"; ?>
<form method="post" action='index.php'>
    <fieldset>
        <input type="text" name="email" id="username" placeholder="Enter username" required="required">
        <input type="password" name="password" id="password" placeholder="and password" required="required">
        <input type="submit" value="login" id="submit" name="op">
    </fieldset>
    <span style="color: red"><?php echo $message; ?></span>
</form>
<br>
</body>
</html>