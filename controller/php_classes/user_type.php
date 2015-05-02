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
class user_type {

    public $id;
    public $user_type_name;
    private $db_handler;
    private $tag = 'USER TYPE CONTROLLER';

    function __construct() {
        $this->db_handler = new DBConnection();
    }

    public function to_string() {
        return 'id : ' . $this->id . ' - '
                . 'user_type_name : ' . $this->user_type_name;
    }

    function getUserType() {
        return $this->db_handler->get_model($this);
    }

    function getUserTypes() {
        return $this->db_handler->get_model_list($this);
    }

}
