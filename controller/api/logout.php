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

//if (isset($_POST['id']) and !empty($_POST['id'])) {
    $user = new User();
//    $user->id = $_POST['id'];

    if (session_destroy()) {
        $responce = array('status' => 'success', 'error' => '', 'data' => array('message' => 'Loged out successfully'));
    } else {
        $responce = array('status' => 'failed', 'error' => 'Some server error occured', 'data' => array());
    }
//    $result = $user->login($user_name, $password);
//    if($result===FALSE){        
//        $responce = array('status'=>'failed','error'=>'User does not exists','data'=> array());
//    }  elseif ($result===TRUE) {        
//        $responce = array('status'=>'failed','error'=>'Username or password is not correct','data'=> array());
//    }  else {  
//        $responce = array('status'=>'success','error'=>'','data'=> array('user'=>$user));
//    }
//} else {
//    $responce = array('status' => 'failed', 'error' => 'Data missing', 'data' => array());
//}
echo json_encode($responce);
