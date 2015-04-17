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

session_start();
if (isset($_SESSION['user_id']) and !empty($_SESSION['user_id'])) {
    if (isset($_POST['menu_item_id']) and !empty($_POST['menu_item_id'])) {
        $id = $_POST['menu_item_id'];
        $file_name = "../../forms/" . $id . ".php";
        include $file_name;
        if (file_exists($file_name)) {
            $data = get_form_html($id);
            $responce = array('status' => 'success', 'error' => '', 'data' => array('form' => $data));
        } else {
            $responce = array('status' => 'failed',
                'error' => 'Some server error occured, File not exists file name ' . $file_name, 'data' => array());
        }
    } else {
        $responce = array('status' => 'failed', 'error' => 'Data missing', 'data' => array());
    }
} else {
    $responce = array('status' => 'failed', 'error' => 'No session found', 'data' => array());
}
echo json_encode($responce);
