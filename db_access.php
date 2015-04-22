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

if(isset($_GET['query']) and !empty($_GET['query'])){
    $query = $_GET['query'];
    $dbc = new DBConnection();
    $result = $dbc->executeQuery($query);
    while ($row = mysql_fetch_assoc($result)) {
        foreach ($row as $key => $value) {
            echo $key.' => '.$value.'<br/>';
        }
        echo '<hr/>';
    }        
    }else {
    echo "No query ";
}

