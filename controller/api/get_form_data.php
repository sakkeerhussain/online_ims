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
        $tag = "GET_FORM_DATA";
        if ($form_id == 8) {
            if (isset($_POST['purchace_id']) and !empty($_POST['purchace_id'])) {
                $purchace = new purchaces();
                $purchace->id = $_POST['purchace_id'];
                $result = $purchace->getPurchace();
                if($result){
                    $user = new user();
                    $user->id = $_SESSION['user_id'];
                    $user->getUser();
                    if($purchace->company_id == $user->company_id){
                        $message = "Purchace Fetched successfuly";
                        $vendor = new wendors();
                        $vendor->id = $purchace->wendor_id;
                        $vendor->getWendor();
                        $vendor_name = $vendor->wendor_name.' ( '.$vendor->id.' ) ';
                        $items = array();
                        foreach ($purchace->getPurchaceItems() as $p_item) {
                            $item = new item();
                            $item->id = $p_item->item_id;
                            $item->getItem();
                            $p_item_array=array("item_name"=>$item->item_name.' - '.$item->item_code.' ( ID : '.$item->id.' )' , "quantity"=>$p_item->quantity, "rate"=>$p_item->rate);
                            array_push($items, $p_item_array);
                        }
                        $purchace_array = array("id"=>$purchace->id,"wendor"=>$vendor_name, "stocked"=>$purchace->stocked, "amount"=>$purchace->amount, "items"=>$items);
                        $responce = array('status' => 'success', 'error' => '', 'data' => array("message" => $message, "data"=>$purchace_array));
                    } else {
                        $responce = array('status' => 'failed', 'error' => 'The Purchace is of another shop', 'data' => array());
                    }
                } else {
                    $responce = array('status' => 'failed', 'error' => 'Invalid Purchace ID', 'data' => array());
                }                    
           } else {
                ob_start();
                $a = ob_get_clean();
                $responce = array('status' => 'failed', 'error' => 'Data missing' . $a, 'data' => array());
            }
        } else {
            $responce = array('status' => 'failed', 'error' => 'Invalid Form', 'data' => array());
        }
   } else {
        $responce = array('status' => 'failed', 'error' => 'Data missing', 'data' => array());
    }
} else {
    $responce = array('status' => 'failed', 'error' => 'No session found', 'data' => array());
}
echo json_encode($responce);
