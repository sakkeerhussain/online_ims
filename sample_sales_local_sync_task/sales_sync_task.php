<?php
define("COOKIE_FILE", "cookie.txt");
define("BASE_URL", "http://localhost/piknik_ims/controller/api/");
$user_id = 0;

if(is_loggedin()){
    send_sales_to_server();
}else{
    if(login()){
        send_sales_to_server();
    }else{
        send_error_message("");
    }
}



function is_loggedin(){    
    $ch = curl_init(BASE_URL.'is_logged_in.php');
    curl_setopt ($ch, CURLOPT_COOKIEJAR, COOKIE_FILE); 
    curl_setopt ($ch, CURLOPT_COOKIEFILE, COOKIE_FILE);     
    //curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_POSTFIELDS,"user_name=owner&password=1234");                
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    $content = curl_exec ($ch);    
    curl_close($ch);
    $json = json_decode($content, TRUE);
    
    echo "<hr/>IS LOGED IN<br/>";
    print_r($json);
    echo "<hr/>";
    
    $status = $json['status'];    
    if($status === "success"){
        global $user_id;
        $user_id = $json["data"]["user"]["id"];
        return TRUE;
    }else{
        return FALSE;
    }
}

function send_sales_to_server(){
    global $user_id;
    $tag = 'SALES SYNC';
    if(mysql_connect("localhost", "root", "") and mysql_select_db("sample")){
        while (TRUE){
            $query = "SELECT * FROM `sales` WHERE `synced` = 0 Limit 1";
            $result = mysql_query($query);
            if ($row = mysql_fetch_assoc($result)) {
                
                $amount = $row["amount"];
                $customer_id = $row["customer_id"];
                $discount = $row["discount"];
                
                $ch = curl_init(BASE_URL.'add_form_data.php?user_id='.$user_id);
                
                $item = array('id'=>1,'quantity'=>1,'rate'=>1,'tax'=>1,'discount'=>1);
                $items = array($item, $item, $item);
                $fields = array('form_id'=>1, 'customer_id'=>$customer_id,'total'=>$amount,'net_amount'=>$amount,'tax_amount'=>0,'discount'=>$discount,'items'=>$items);
                
                Log::i($tag, "Sale syncing with server, sale : ".  multi_implode(" ", $fields));
                curl_setopt ($ch, CURLOPT_COOKIEJAR, COOKIE_FILE); 
                curl_setopt ($ch, CURLOPT_COOKIEFILE, COOKIE_FILE);     
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($fields));                
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                $content = curl_exec ($ch);    
                curl_close($ch);
                $json = json_decode($content, TRUE);

                echo "<hr/>SALE SYNC<br/>";
                print_r($json);
                echo "<hr/>";
                
                Log::i($tag, "Responce : ".  multi_implode(" ", $json));
                
                $status = $json['status'];
                if($status == 'success'){
                    $sale_id = $json['data']['id'];
                    $query = "UPDATE `sales` SET `synced`=1,`sale_id`='$sale_id' WHERE `id` = '".$row["id"]."'";
                    mysql_query($query);
                }else{
                    break;
                }
                
            } else {
                break;
            }
        }
    }else{
        send_error_message(mysql_error());
    }
}

function send_error_message($error_mesage){
    $tag = 'ERROR';
    $content = "\n\n\n-------------------------------------------\n".
               "Error on syncing sales \n".
               "Error message : ".$error_mesage.
               "At : ".date("Y-M-d, H:i:s (D) e", time()) . "\n";
    
    echo "<hr/>ERROR<br/>";
    print_r($content);
    echo "<hr/>";
    
    Log::e($tag, $content); 
//    Log::e($tag, "Login Responce: ".  multi_implode(" ", $json)); 
}

function login(){
    $tag = 'LOG IN';
    $ch = curl_init(BASE_URL.'login.php');
    $fields = array("user_name"=>'pos2', 'password'=>'1234');
    curl_setopt ($ch, CURLOPT_COOKIEJAR, COOKIE_FILE); 
    curl_setopt ($ch, CURLOPT_COOKIEFILE, COOKIE_FILE);     
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));                
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    $content = curl_exec ($ch);    
    curl_close($ch);
    $json = json_decode($content, TRUE);
    
    echo "<hr/>LOGIN<br/>";
    print_r($json);
    echo "<hr/>";
    
    Log::i($tag, "Login Responce: ".  multi_implode(" ", $json));                
    
    $status = $json['status'];    
    if($status === "success"){
        return TRUE;
    }else{
        return FALSE;
    }
}


//utilities
function multi_implode($glue, $array) {
    $ret = '';
    if(is_array($array)){
        foreach ($array as $key=>$item) {
            if (is_array($item)) {
                $ret .= multi_implode($item, $glue) . $glue;
            } else {
                $ret .= $key.' => '.$item . $glue;
            }
        }
        $ret = substr($ret, 0, 0-strlen($glue));
        return $ret;
    }else{
        return $array;
    }
}
?>


<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Log
 *
 * @author Sakkeer Hussain
 */
class Log {
    private static $mode = "a";
    private static $date_format = "Y-M-d, H:i:s (D) e";
    
    private static $log_folder = "D:/PikNik ims sync manager/log/";
    private static $info_log_file_name = "log-info.txt";        
    private static $error_log_file_name = "log-error.txt";        
    private static $debug_log_file_name = "log-debug.txt";


    private static function open_file_for_i() {        
        $log_file = Log::$log_folder.Log::$info_log_file_name;        
        if(!file_exists(dirname($log_file))){
            mkdir(dirname($log_file), 0777, true);
        }
        
        $handle = fopen($log_file, Log::$mode);
        if(!$handle){
            //TODO - do error handling here.
        }
        return $handle;
    }
    private static function close_file_for_i($handle){
        fclose($handle);
    }
    private static function open_file_for_d() {
        $log_file = Log::$log_folder.Log::$debug_log_file_name; 
        if(!file_exists(dirname($log_file))){
            mkdir(dirname($log_file), 0777, true);
        }
        
        $handle = fopen($log_file, Log::$mode);
        if(!$handle){
            //TODO - do error handling here.
        }
        return $handle;
    }
    private static function close_file_for_d($handle){
        fclose($handle);
    }
    private static function open_file_for_e() {        
        $log_file = Log::$log_folder.Log::$error_log_file_name; 
        if(!file_exists(dirname($log_file))){
            mkdir(dirname($log_file), 0777, true);
        }
        
        $handle = fopen($log_file, Log::$mode);
        if(!$handle){
           //TODO - do error handling here.
        }
        return $handle;
    }
    private static function close_file_for_e($handle){
        fclose($handle);
    }
    public static function i($tag, $description) {
        $handle = Log::open_file_for_i();
        $log = "\n\nINFO  => [". Log::get_time_stamp()."]\t[".$tag."]  =>  [".$description."]\n";
        fwrite($handle, $log);
        Log::close_file_for_i($handle);
    }
    public static function d($tag, $description) {
        $handle = Log::open_file_for_d();
        $log = "\n\nDEBUG => [". Log::get_time_stamp()."]\t[".$tag."]  =>  [".$description."]\n";
        fwrite($handle, $log);
        Log::close_file_for_d($handle);
    }
    public static function e($tag, $description) {
        $handle = Log::open_file_for_e();
        $log = "\n\nERROR => [". Log::get_time_stamp()."]\t[".$tag."]  =>  [".$description."]\n";
        fwrite($handle, $log);
        Log::close_file_for_e($handle);
    }
    public static function get_time_stamp() {
        return date(Log::$date_format, (time()+(5.5*60*60)));
    }
}

?>