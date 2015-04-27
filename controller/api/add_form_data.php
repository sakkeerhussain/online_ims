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
        if ($form_id == 1) {
            if (isset($_POST['customer_id']) 
                    and isset($_POST['total']) and !empty($_POST['total']) 
                    and isset($_POST['net_amount']) and !empty($_POST['net_amount']) 
                    and isset($_POST['tax_amount']) and !empty($_POST['tax_amount']) 
                    and isset($_POST['items']) and !empty($_POST['items'])) {
                $sale = new sales();
                $sale->customer_id = $_POST['customer_id'];
                $sale->amount = $_POST['total'];
                $sale->net_amount = $_POST['net_amount'];
                $sale->tax_amount = $_POST['tax_amount'];
                $user = new user();
                $user->id = $_SESSION['user_id'];
                $user->getUser();
                $sale->company_id = $user->company_id;
                $sales_items = array();
                foreach ($_POST['items'] as $sales_array_item) {
                    $sales_item = new sales_items();
                    $sales_item->item_id = $sales_array_item['id'];
                    $sales_item->quantity = $sales_array_item['quantity'];
                    $sales_item->rate = $sales_array_item['rate'];
                    $sales_item->tax = $sales_array_item['tax'];
                    array_push($sales_items, $sales_item);
                }
                $sale->setSalesItems($sales_items);
                $inserted_id = $sale->addSales();
                $message = "Sale completed successfuly";
                $responce = array('status' => 'success', 'error' => ''.$sale->to_string(), 'data' => array("message" => $message, "id"=>$inserted_id));
            } else {
                ob_start();
                $a = ob_get_clean();
                $responce = array('status' => 'failed', 'error' => 'Data missing' . $a, 'data' => array());
            }
        } else if ($form_id == 6) {
            if (isset($_POST['customer_name']) and !empty($_POST['customer_name']) 
                    and isset($_POST['contact_number']) and !empty($_POST['contact_number']) ) {
                $customer = new customer();
                $customer->customer_name = $_POST['customer_name'];
                $customer->contact_number = $_POST['contact_number'];
                $user = new user();
                $user->id = $_SESSION['user_id'];
                $user->getUser();
                $customer->company_id = $user->company_id;
                $customer->addCustomer();
                $message = "Customer added successfully";
                $responce = array('status' => 'success', 'error' => '', 'data' => array("message" => $message));
            } else {
                ob_start();
                $a = ob_get_clean();
                $responce = array('status' => 'failed', 'error' => 'Data missing' . $a, 'data' => array());
            }
        }else if ($form_id == 7) {
            if (isset($_POST['wendor_id']) and !empty($_POST['wendor_id']) 
                    and isset($_POST['total']) and !empty($_POST['total']) 
                    and isset($_POST['items']) and !empty($_POST['items'])) {
                $purchace = new purchaces();
                $purchace->amount = $_POST['total'];
                $purchace->wendor_id = $_POST['wendor_id'];
                $purchace->purchace_manager_id = $_SESSION['user_id'];
                $user = new user();
                $user->id = $_SESSION['user_id'];
                $user->getUser();
                $purchace->company_id = $user->company_id;
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
                $a = ob_get_clean();
                $responce = array('status' => 'failed', 'error' => 'Data missing' . $a, 'data' => array());
            }
        } else if ($form_id == 10) { //vendor form
            if (isset($_POST['vendor_name']) and !empty($_POST['vendor_name']) 
                    and isset($_POST['contact_number']) and !empty($_POST['contact_number']) 
                    and isset($_POST['tin_number']) and !empty($_POST['tin_number']) 
                    and isset($_POST['contact_address']) and !empty($_POST['contact_address'])) {

                $vendor = new wendors();
                $vendor->wendor_name = $_POST['vendor_name'];
                $vendor->contact_no = $_POST['contact_number'];
                $vendor->wendor_tin_number = $_POST['tin_number'];
                $vendor->contact_address = $_POST['contact_address'];
                if ($vendor->addWendor()) {
                    $responce = array('status' => 'success', 'error' => '',
                        'data' => array('message' => 'Vendor Added successfully'));
                } else {
                    Log::e($tag, "Vendor adding failed item : " . $vendor->to_string());
                    $responce = array('status' => 'failed', 'error' => 'Some server error occured', 'data' => array());
                }
            } else {
                $responce = array('status' => 'failed', 'error' => 'Data missing', 'data' => array());
            }
        }else if ($form_id == 11) { //item form
            if (isset($_POST['item_code']) and !empty($_POST['item_code']) 
                    and isset($_POST['item_name']) and !empty($_POST['item_name']) 
                    and isset($_POST['mrp']) and !empty($_POST['mrp']) 
                    and isset($_POST['tax_category_id']) and !empty($_POST['tax_category_id']) 
                    and isset($_POST['purchace_rate']) and !empty($_POST['purchace_rate'])) {

                $item = new item();
                $item->item_code = $_POST['item_code'];
                $item->item_name = $_POST['item_name'];
                $item->mrp = $_POST['mrp'];
                $item->tax_category_id = $_POST['tax_category_id'];
                $item->purchace_rate = $_POST['purchace_rate'];
                if ($item->addItem()) {
                    $responce = array('status' => 'success', 'error' => '',
                        'data' => array('message' => 'Item Added successfully'));
                } else {
                    Log::e($tag, "Item adding failed item : " . $item->to_string() . 'Error : '.  mysql_error());
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
