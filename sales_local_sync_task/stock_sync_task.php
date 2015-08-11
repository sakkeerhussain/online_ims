<?php
define("COOKIE_FILE", "cookie.txt");
define("BASE_URL", "http://localhost/piknik_ims/controller/api/");
$user_id = 0;

if(is_loggedin()){
    sync_stock_report();
    if($user_id==0){ //session expired
        if(login()){
            sync_stock_report();
        }else{
            send_error_message("");
        }
    }
}else{
    if(login()){
        sync_stock_report();
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

function sync_stock_report(){
    global $user_id;
    $tag = 'STOCK SYNC';
    $ch = curl_init(BASE_URL.'get_form_data.php?user_id='.$user_id);
    $post_params = array('form_id'=>9);
    curl_setopt ($ch, CURLOPT_COOKIEJAR, COOKIE_FILE); 
    curl_setopt ($ch, CURLOPT_COOKIEFILE, COOKIE_FILE);     
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($post_params));                
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    $content = curl_exec ($ch);    
    curl_close($ch);
    $json = json_decode($content, TRUE);

    echo "<hr/>STOCK SYNC<br/>";
    print_r($json);
    echo "<hr/>";
                
    Log::i($tag, "Stock sync Responce : ".  multi_implode(" ", $json));
                
    $status = $json['status'];
    if($status == 'success'){
        write_plu_file($json['data']['stock']);
    }else{
        if($json['error'] == 'Session expired'){
            $user_id = 0;
        }else{
            send_error_message(mysql_error());
        }
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
}

function login(){
    global $user_id;
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
        $user_id = $json["data"]["user"]["id"];
        return TRUE;
    }else{
        return FALSE;
    }
}

function write_plu_file($stock){
    $file_name = "C:\Users\Sakkeer Hussain\Desktop\mtch\plu.txt";
    if(!file_exists(dirname($file_name))){
        mkdir(dirname($file_name), 0777, true);
    }
    $handle = fopen($file_name, 'w');
    fwrite($handle, get_plu_file_content($stock));
    fclose($handle);
}

//utilities
function get_plu_file_content($stock) {
    $ret = '';
    if(is_array($stock)){
        foreach ($stock as $stock_item) {
            if(is_array($stock_item)){
                $ret .= $stock_item["item_id"].','
                        .$stock_item["item_code"].','
                        .$stock_item["item_unit"].','
                        .$stock_item["selling_prize"].','
                        .$stock_item["item_name"].','
                        .$stock_item["tax_percentage"].','
                        .$stock_item["stock_count"];              
            }
            $ret .= "\n";
        }
        return $ret;
    }else{
        return $array;
    }
}

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