<?php
@session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Sakkeer Hussain
 */
class user {

    public $id;
    public $user_name;
    public $name;
    public $company_id;
    public $wacher_id;
    public $access_tocken;
    public $user_type_id;
    public $created_at;
    public $last_edited;
    public $password_hashed;
    public $login_error;
    private $db_handler;
    private $tag = 'USER CONTROLLER';

    function __construct() {
        $this->db_handler = new DBConnection();
    }

    function login($user_name, $password) {        
        $description = "Login attempt with credentials username (" . $user_name . "), passwor(md5) (" . md5($password) . ")";
        Log::i($this->tag, $description);
        $query = "SELECT `id` FROM `user` WHERE `user_name` = '" . $user_name. "'";
        $result = $this->db_handler->executeQuery($query);
        if ($result and $row = mysql_fetch_assoc($result)) {
            $query = "SELECT `id` FROM `user` WHERE `user_name` = '" . $user_name.
                    "'  and `password_hashed` = '".md5($password)."'";
            $result = $this->db_handler->executeQuery($query);
            if ($row = mysql_fetch_assoc($result)) {
                $id = $row['id'];
                $_SESSION['user_id']=$id;
                $this->id = $id;
                $this->getUser();
                return $id;
            }  else {
                return TRUE;    
            }
        } else {
            return FALSE;
        }
    }

    function resetPassword($user_name, $wacher) {
        
    }

    public function logout($user_name) {
        
    }

    public function to_string() {
        return 'id : ' . $this->id . ' - '
                . 'user_name : ' . $this->user_name . ' - '
                . 'company_id : ' . $this->company_id . ' - '
                . 'user_type_id : ' . $this->user_type_id;
    }

    function addUser($user = null) {
        if ($user == null) {
            $user = $this;
        }
        $this->db_handler->add_model($user);
        $description = "Added new user (" . $user->to_string() . ")";
        Log::i($this->tag, $description);
    }

    function getUser() {
        return $this->db_handler->get_model($this);
    }

}
