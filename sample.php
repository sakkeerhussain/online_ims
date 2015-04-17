<?php

spl_autoload_register(function($class_name) {
    $controller_root = $_SERVER['DOCUMENT_ROOT'] . '/piknik_ims/controller';
    if (file_exists($controller_root . '/php_classes/' . $class_name . '.php')) {
        $file_name = $controller_root . '/php_classes/' . $class_name . '.php';
        require_once $file_name;
    } else {
        throw new Exception("Class " . $class_name . " Not found");
    }
});

$inv = new inventry();
$invs = $inv->getInventryForSpecificCompanyAndItem();
echo sizeof($invs);
echo typeof($invs);
print_r($invs);
?>