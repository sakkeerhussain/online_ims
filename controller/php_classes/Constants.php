<?php

Class Constants{
    public static $host;
    public static $document_root;
    public static $project_name;
    public static $database_name;
    public static $project_root;
    
    public static $db_host;
    public static $db_user_name;
    public static $db_password;
    
    public static $info_log_file_name;
    public static $error_log_file_name;
    public static $debug_log_file_name;
    
    public static $error_page;
    public static $ip;

    static function initialize() {
        Constants::initialize_server_constants();
        Constants::initialize_db_constants();
        Constants::initialize_log_constants();
    }
    static function initialize_db_constants(){
        Constants::$db_host = "localhost";
        Constants::$db_user_name = "root";
        Constants::$db_password = "";
        Constants::$database_name = "online_ims";
    }
    static function initialize_server_constants(){
        Constants::$host = $_SERVER['HTTP_HOST'];
        Constants::$document_root = $_SERVER['DOCUMENT_ROOT'];
        Constants::$project_name = "online_ims";
        Constants::$project_root = Constants::$document_root . "/" . Constants::$project_name;
        Constants::$error_page = ' http://'.Constants::$host.'/'.Constants::$project_name."/error.php";
        Constants::$ip = $_SERVER['REMOTE_ADDR'];
    }
    static function initialize_log_constants(){        
        Constants::$info_log_file_name = "log-info.txt";        
        Constants::$error_log_file_name = "log-error.txt";        
        Constants::$debug_log_file_name = "log-debug.txt"; 
    }
}

Constants::initialize();
