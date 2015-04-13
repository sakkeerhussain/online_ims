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

sleep(2);

if (isset($_POST['form_id']) and !empty($_POST['form_id'])) {
    $form_id = $_POST['form_id'];
    $tag = "ADD_FORM_DATA";
    if ($form_id == 11) { //item form
        if (isset($_POST['item_code']) and !empty($_POST['item_code']) and isset($_POST['item_name']) and !empty($_POST['item_name']) and isset($_POST['mrp']) and !empty($_POST['mrp']) and isset($_POST['purchace_rate']) and !empty($_POST['purchace_rate'])) {

            $item = new Item();
            $item->item_code = $_POST['item_code'];
            $item->item_name = $_POST['item_name'];
            $item->mrp = $_POST['mrp'];
            $item->purchace_rate = $_POST['purchace_rate'];
            if ($item->addItem()) {
                $responce = array('status' => 'success', 'error' => '',
                    'data' => array('message' => 'Item Added successfully'));
            } else {
                Log::e($tag, "Item adding failed item : ".$item->to_string());
                $responce = array('status' => 'failed', 'error' => 'Some server error occured', 'data' => array());
            }
        } else {
            $responce = array('status' => 'failed', 'error' => 'Data missing', 'data' => array());
        }
    }
//    $user = new User();
//    $user_name = $_POST['user_name'];
//    $password = $_POST['password'];
//    $result = $user->login($user_name, $password);
//    if($result===FALSE){        
//        $responce = array('status'=>'failed','error'=>'User does not exists','data'=> array());
//    }  elseif ($result===TRUE) {        
//        $responce = array('status'=>'failed','error'=>'Username or password is not correct','data'=> array());
//    }  else {  
//        $responce = array('status'=>'success','error'=>'','data'=> array('user'=>$user));
//    }
} else {
    $responce = array('status' => 'failed', 'error' => 'Data missing', 'data' => array());
}
echo json_encode($responce);
