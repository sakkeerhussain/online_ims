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
    if (isset($_POST['form_id']) and !empty($_POST['form_id'])) {
        $form_id = $_POST['form_id'];
        $tag = "DELETE_FORM_DATA";
        if ($form_id == 17) {   ///item delete
            if (isset($_POST['item_id']) and !empty($_POST['item_id'])) {
                $item = new item();
                $item->id = $_POST['item_id'];
                if($item->deleteItem()){
                    $message = "Item deleted Successfuly";
                    $responce = array('status' => 'success', 'error' => '', 'data' => array("message" => $message, "id"=>$item->id)); 
                }else{
                    $description = "Item delete failed, item : ".$item->to_string();
                    Log::e($tag, $description);
                    $message = "Some server error occured";
                    $responce = array('status' => 'success', 'error' => $message, 'data' => array());
                }                    
            }else {
                ob_start();
                print_r($_POST);
                $a = ob_get_clean();
                $responce = array('status' => 'failed', 'error' => 'Data missing' . $a, 'data' => array());
            }            
        }else if ($form_id == 18) {   ///vendor delete
            if (isset($_POST['vendor_id']) and !empty($_POST['vendor_id'])) {
                $vendor = new wendors();
                $vendor->id = $_POST['vendor_id'];
                if($vendor->deleteWendor()){
                    $message = "Vendor deleted Successfuly";
                    $responce = array('status' => 'success', 'error' => '', 'data' => array("message" => $message, "id"=>$vendor->id)); 
                }else{
                    $description = "Vendor delete failed, item : ".$item->to_string();
                    Log::e($tag, $description);
                    $message = "Some server error occured";
                    $responce = array('status' => 'success', 'error' => $message, 'data' => array());
                }                    
            }else {
                ob_start();
                print_r($_POST);
                $a = ob_get_clean();
                $responce = array('status' => 'failed', 'error' => 'Data missing' . $a, 'data' => array());
            }            
        }else {
            $responce = array('status' => 'failed', 'error' => 'Invalid Form', 'data' => array());
        }
    } else {
        $responce = array('status' => 'failed', 'error' => 'Data missing', 'data' => array());
    }
} else {
    $responce = array('status' => 'failed', 'error' => 'No session found', 'data' => array());
}
echo json_encode($responce);
