<?php
?>
<body>
<form action="index.php" method="post">
    <input type="text" name="firstname" id="firstname" placeholder="Enter firstname" required="required">
    <input type="text" name="lastname" id="lastname" placeholder="Enter lastname" required="required">
    <input type="text" name="email" id="username" placeholder="Enter email" required="required">
    <input type="password" name="password" id="password" placeholder="enter password" required="required">
    <input type="hidden" name="id"">
    <select name="tip">
        <option disabled selected value> -- select an role -- </option>
        <option value=1>admin</option>
        <option value=2>writer</option>
        <option value=3>reader</option>
    </select>
    <input type="submit" value="addUser" id="submit" name="op">
</form>
</body>

