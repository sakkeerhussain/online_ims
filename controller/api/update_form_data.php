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
                $responce = array('status' => 'success', 'error' => '', 'data' => array("message" => $message, "id"=>$sale->id));
            } else {
                ob_start();
                $a = ob_get_clean();
                $responce = array('status' => 'failed', 'error' => 'Data missing' . $a, 'data' => array());
            }
        } else if ($form_id == 6) {   ///edit customer
            if (isset($_POST['customer_id']) and !empty($_POST['customer_id']) 
                    and isset($_POST['customer_name']) and !empty($_POST['customer_name']) 
                    and isset($_POST['contact_number']) and !empty($_POST['contact_number'])) {
                $customer = new customer();
                $customer->id = $_POST['customer_id'];
                $customer->getCustomer();
                $customer->customer_name = $_POST['customer_name'];
                $customer->contact_number = $_POST['contact_number'];
                if($customer->updateCustomer()){
                    $message = "Customer Updated Successfuly";
                    $responce = array('status' => 'success', 'error' => '', 'data' => array("message" => $message, "id"=>$customer->id)); 
                }else{
                    $description = "Customer update failed, vendor : ".$customer->to_string();
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
        } else if ($form_id == 8) {   ///edit : purchace return
            if (isset($_POST['purchace_id']) and !empty($_POST['purchace_id']) 
                    and isset($_POST['total']) //and !empty($_POST['total']) 
                    and isset($_POST['items']) and !empty($_POST['items'])) {
                $purchace = new purchaces();
                $purchace->id = $_POST['purchace_id'];
                $purchace->getPurchace();
                $purchace->amount = $_POST['total'];
                $purchace_items_prev = $purchace->getPurchaceItems();
                $purchace_items_new = array();
                if(!($_POST['items'] == 'no_items')){
                    foreach ($_POST['items'] as $purchace_array_item) {
                        $purchace_item = new purchace_items();
                        $purchace_item->item_id = $purchace_array_item['id'];
                        $purchace_item->quantity = $purchace_array_item['quantity'];
                        $purchace_item->rate = $purchace_array_item['rate'];
                        array_push($purchace_items_new, $purchace_item);
                    }
                }
                $purchace->setPurchaceItems($purchace_items_new);
                
                if($purchace->updatePurchace()){
                    $message = "Purchace Updated Successfuly";
                    $responce = array('status' => 'success', 'error' => '', 'data' => array("message" => $message, "id"=>$purchace->id)); 
                }else{
                    $description = "Purchace update failed, vendor : ".$purchace->to_string();
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
        }else if ($form_id == 10) {   ///edit vendor
            if (isset($_POST['vendor_id']) and !empty($_POST['vendor_id']) 
                    and isset($_POST['vendor_name']) and !empty($_POST['vendor_name']) 
                    and isset($_POST['contact_number']) and !empty($_POST['contact_number']) 
                    and isset($_POST['tin_number']) and !empty($_POST['tin_number']) 
                    and isset($_POST['contact_address']) and !empty($_POST['contact_address'])) {
                $vendor = new wendors();
                $vendor->id = $_POST['vendor_id'];
                $vendor->getWendor();
                $vendor->contact_address = $_POST['contact_address'];
                $vendor->contact_no = $_POST['contact_number'];
                $vendor->wendor_name = $_POST['vendor_name'];
                $vendor->wendor_tin_number = $_POST['tin_number'];
                if($vendor->updateWendor()){
                    $message = "Vendor Updated Successfuly";
                    $responce = array('status' => 'success', 'error' => '', 'data' => array("message" => $message, "id"=>$vendor->id)); 
                }else{
                    $description = "Vendor update failed, vendor : ".$vendor->to_string();
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
        }else if ($form_id == 11) {   ///edit item
            if (isset($_POST['item_id']) and !empty($_POST['item_id']) 
                    and isset($_POST['item_name']) and !empty($_POST['item_name']) 
                    and isset($_POST['item_code']) and !empty($_POST['item_code']) 
                    and isset($_POST['mrp']) and !empty($_POST['mrp']) 
                    and isset($_POST['tax_category_id']) and !empty($_POST['tax_category_id']) 
                    and isset($_POST['purchace_rate']) and !empty($_POST['purchace_rate'])) {
                $item = new item();
                $item->id = $_POST['item_id'];
                $item->getItem();
                $item->item_code = $_POST['item_code'];
                $item->item_name = $_POST['item_name'];
                $item->mrp = $_POST['mrp'];
                $item->purchace_rate = $_POST['purchace_rate'];
                $item->tax_category_id = $_POST['tax_category_id'];
                if($item->updateItem()){
                    $message = "Item Updated Successfuly";
                    $responce = array('status' => 'success', 'error' => '', 'data' => array("message" => $message, "id"=>$item->id)); 
                }else{
                    $description = "Item update failed, item : ".$item->to_string();
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
        } else if ($form_id == 22) {   ///edit bank
            if (isset($_POST['bank_id']) and !empty($_POST['bank_id']) 
                    and isset($_POST['bank_name']) and !empty($_POST['bank_name']) 
                    and isset($_POST['branch']) and !empty($_POST['branch']) 
                    and isset($_POST['ifsc_code']) and !empty($_POST['ifsc_code']) 
                    and isset($_POST['account_number']) and !empty($_POST['account_number'])) {
                $bank = new bank();
                $bank->id = $_POST['bank_id'];
                $bank->getBank();
                $bank->bank_name = $_POST['bank_name'];
                $bank->branch = $_POST['branch'];
                $bank->ifsc_code = $_POST['ifsc_code'];
                $bank->account_number = $_POST['account_number'];
                if($bank->updateBank()){
                    $message = "Bank Updated Successfuly";
                    $responce = array('status' => 'success', 'error' => '', 'data' => array("message" => $message, "id"=>$bank->id)); 
                }else{
                    $description = "Bank update failed, item : ".$bank->to_string();
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
