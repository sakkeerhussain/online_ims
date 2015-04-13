<?php

//registering for class auto loading
spl_autoload_register(function($class_name) {
    $controller_root = $_SERVER['DOCUMENT_ROOT'] . '/piknik_ims/controller';
    if (file_exists($controller_root . '/php_classes/' . $class_name . '.php')) {
        $file_name = $controller_root . '/php_classes/' . $class_name . '.php';
        require_once $file_name;
    } else {
        throw new Exception("Class " . $class_name . " Not found");
    }
});


?>
<form action="../controller/api/login.php" method="post">
user name : <input type="text" name="user_name">
<br/>
Password : <input type="password" name="password">
<br/>
<input type="submit" />
<br/>
</form>