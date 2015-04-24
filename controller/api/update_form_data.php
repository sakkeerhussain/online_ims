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
        $tag = "UPDATE_FORM_DATA";
        if ($form_id == 2) {   ///sales return
            if (isset($_POST['total']) and !empty($_POST['total']) 
                    and isset($_POST['sale_id']) and !empty($_POST['sale_id']) 
                    and isset($_POST['net_amount']) and !empty($_POST['net_amount']) 
                    and isset($_POST['tax_amount']) and !empty($_POST['tax_amount']) 
                    and isset($_POST['items']) and !empty($_POST['items'])) {
                $sale = new sales();
                $sale->id = $_POST['sale_id'];
                $sale->getSale();
                $balance = $_POST['total'] - $sale->amount;
                $sale->amount = $_POST['total'];
                $sale->net_amount = $_POST['net_amount'];
                $sale->tax_amount = $_POST['tax_amount'];
                $sales_items_prev = $sale->getSalesItems();
                $sales_items_new = array();
                foreach ($_POST['items'] as $sales_array_item) {
                    $sales_item = new sales_items();
                    $sales_item->item_id = $sales_array_item['id'];
                    $sales_item->quantity = $sales_array_item['quantity'];
                    $sales_item->rate = $sales_array_item['rate'];
                    $sales_item->tax = $sales_array_item['tax'];
                    array_push($sales_items_new, $sales_item);
                }
                foreach ($sales_items_new as $sale_item_new) {
                    $item_id = $sale_item_new->item_id;
                    $new_item = true;
                    foreach ($sales_items_prev as $sale_item_prev) {
                        if($item_id == $sale_item_prev->item_id){
                            $new_item = false;
                            if($sale_item_new->quantity != $sale_item_prev->quantity ){
                                //updating quantity changed items
                                $diff = $sale_item_prev->quantity - $sale_item_new->quantity;
                                $inv = new inventry();
                                $inv->company_id = $sale->company_id;
                                $inv->item_id = $item_id;
                                $invs = $inv->getInventryForSpecificCompanyAndItem();
                                $inv = $invs[0];  
                                $inv->in_stock_count = $inv->in_stock_count + $diff; 
                                $inv->updateInventry();
                                $description = "Updating inventry (sales return) diff : ".$diff.", inventry : ".$inv->to_string();
                                Log::i($tag, $description);
                            }
                        }
                    }
                    if($new_item){   ///updating stock with new items
                        $qty = $sale_item_new->quantity;
                        $inv = new inventry();
                        $inv->company_id = $sale->company_id;
                        $inv->item_id = $item_id;
                        $invs = $inv->getInventryForSpecificCompanyAndItem();
                        $inv = $invs[0];  
                        $inv->in_stock_count = $inv->in_stock_count - $qty; 
                        $inv->updateInventry();
                        $description = "Updating inventry (sales return - new item) diff : ".$qty.", inventry : ".$inv->to_string();
                        Log::i($tag, $description);
                    }
                }
                //checking for removed items
                foreach ($sales_items_prev as $sale_item_prev) {
                    $item_id = $sale_item_prev->item_id;
                    $removed_item = true;
                    foreach ($sales_items_new as $sale_item_new) {
                        if($item_id == $sale_item_new->item_id){
                            $removed_item = false;
                        }
                    }
                    if($removed_item){
                        $qty = $sale_item_prev->quantity;
                        $inv = new inventry();
                        $inv->company_id = $sale->company_id;
                        $inv->item_id = $item_id;
                        $invs = $inv->getInventryForSpecificCompanyAndItem();
                        $inv = $invs[0];  
                        $inv->in_stock_count = $inv->in_stock_count + $qty; 
                        $inv->updateInventry();
                        $description = "Updating inventry (sales return - remoed item) diff : ".$qty.", inventry : ".$inv->to_string();
                        Log::i($tag, $description);
                    }
                }
                
                $sale->setSalesItems($sales_items_new);
                $sale->updateSale();
                $customer = new customer();
                $customer->id = $sale->customer_id;
                $customer->getCustomer();
                $customer->total_purchace_amount = $customer->total_purchace_amount + $balance;
                $customer->updateCustomer();
                $message = "Sale Updated Successfuly";
                $responce = array('status' => 'success', 'error' => ''.$sale->to_string(), 'data' => array("message" => $message, "id"=>$sale->id));
            } else {
                ob_start();
                $a = ob_get_clean();
                $responce = array('status' => 'failed', 'error' => 'Data missing' . $a, 'data' => array());
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
