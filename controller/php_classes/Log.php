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


    private static function open_file_for_i() {
        $handle = fopen(Constants::$project_root.'/'.Constants::$info_log_file_name, Log::$mode);
        if(!$handle){
            header("Location: ".Constants::$error_page."?error_message=log_file_opening_failed");
        }
        return $handle;
    }
    private static function close_file_for_i($handle){
        fclose($handle);
    }
    private static function open_file_for_d() {
        $handle = fopen(Constants::$project_root.'/'.Constants::$debug_log_file_name, Log::$mode);
        if(!$handle){
            header("Location: ".Constants::$error_page."?error_message=log_file_opening_failed");
        }
        return $handle;
    }
    private static function close_file_for_d($handle){
        fclose($handle);
    }
    private static function open_file_for_e() {
        $handle = fopen(Constants::$project_root.'/'.Constants::$error_log_file_name, Log::$mode);
        if(!$handle){
            header("Location: ".Constants::$error_page."?error_message=log_file_opening_failed");
        }
        return $handle;
    }
    private static function close_file_for_e($handle){
        fclose($handle);
    }
    public static function i($tag, $description) {
        $handle = Log::open_file_for_i();
        $log = "\n\nINFO  => [". Log::get_time_stamp()."]\t[".Constants::$ip."]\t[".$tag."]  =>  [".$description."]\n";
        fwrite($handle, $log);
        Log::close_file_for_i($handle);
    }
    public static function d($tag, $description) {
        $handle = Log::open_file_for_d();
        $log = "\n\nDEBUG => [". Log::get_time_stamp()."]\t[".Constants::$ip."]\t[".$tag."]  =>  [".$description."]\n";
        fwrite($handle, $log);
        Log::close_file_for_d($handle);
    }
    public static function e($tag, $description) {
        $handle = Log::open_file_for_e();
        $log = "\n\nERROR => [". Log::get_time_stamp()."]\t[".Constants::$ip."]\t[".$tag."]  =>  [".$description."]\n";
        fwrite($handle, $log);
        Log::close_file_for_e($handle);
    }
    public static function get_time_stamp() {
        return date(Log::$date_format, (time()+(5.5*60*60)));
    }
}