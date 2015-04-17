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
        $tag = "ADD_FORM_DATA";
        if ($form_id == 7) {
            if (isset($_POST['wendor_id']) and !empty($_POST['wendor_id']) and isset($_POST['total']) and !empty($_POST['total']) and isset($_POST['items']) and !empty($_POST['items'])) {
                $purchace = new purchaces();
                $purchace->amount = $_POST['total'];
                $purchace->wendor_id = $_POST['wendor_id'];
                $purchace->purchace_manager_id = $_SESSION['user_id'];
                $user = new user();
                $user->id = $_SESSION['user_id'];
                $user->getUser();
                $purchace->company_id = $user->company_id;
                $message = "";
                $purchace_items = array();
                foreach ($_POST['items'] as $items_array_item) {
                    $purchace_item = new purchace_items();
                    $purchace_item->item_id = $items_array_item['id'];
                    $purchace_item->quantity = $items_array_item['quantity'];
                    $purchace_item->rate = $items_array_item['rate'];
                    array_push($purchace_items, $purchace_item);
                }
                $purchace->setPurchaceItems($purchace_items);
                $purchace->addPurchace();
                $message = "Purchace added successfully";
                $responce = array('status' => 'success', 'error' => '', 'data' => array("message" => $message));
            } else {
                ob_start();
                print_r($_POST);
                $a = ob_get_clean();
                $responce = array('status' => 'failed', 'error' => 'Data missing' . $a, 'data' => array());
            }
        } else if ($form_id == 11) { //item form
            if (isset($_POST['item_code']) and !empty($_POST['item_code']) and isset($_POST['item_name']) and !empty($_POST['item_name']) and isset($_POST['mrp']) and !empty($_POST['mrp']) and isset($_POST['purchace_rate']) and !empty($_POST['purchace_rate'])) {

                $item = new item();
                $item->item_code = $_POST['item_code'];
                $item->item_name = $_POST['item_name'];
                $item->mrp = $_POST['mrp'];
                $item->purchace_rate = $_POST['purchace_rate'];
                if ($item->addItem()) {
                    $responce = array('status' => 'success', 'error' => '',
                        'data' => array('message' => 'Item Added successfully'));
                } else {
                    Log::e($tag, "Item adding failed item : " . $item->to_string());
                    $responce = array('status' => 'failed', 'error' => 'Some server error occured', 'data' => array());
                }
            } else {
                $responce = array('status' => 'failed', 'error' => 'Data missing', 'data' => array());
            }
        } else {
            $responce = array('status' => 'failed', 'error' => 'Invalid Form', 'data' => array());
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
} else {
    $responce = array('status' => 'failed', 'error' => 'No session found', 'data' => array());
}
echo json_encode($responce);
