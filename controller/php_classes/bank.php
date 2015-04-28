<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bank
 *
 * @author Sakkeer Hussain
 */
class bank {
    
    public $id;
    public $bank_name;
    public $branch;
    public $ifsc_code;
    public $account_number;
    public $created_at;
    public $last_edited;    
    
    private $db_handler;
    private $tag = 'BANK CONTROLLER';
    
    function __construct() {
        $this->db_handler = new DBConnection();
    }
    public function to_string() {
        return 'id : '.$this->id.' - '
                .'bank_name : '.$this->bank_name.' - '
                .'branch : '.$this->branch.' - '
                .'ifsc_code : '.$this->ifsc_code.' - '
                .'created_at : '.$this->created_at.' - '
                .'last_edited : '.$this->last_edited;
    }
    function addBank($bank=null){
        if($bank==null){
            $bank = $this;
        }
        $result = $this->db_handler->add_model($bank);
        $description = "Added new Bank (". $bank->to_string().")";
        Log::i($this->tag, $description);
        return $result;
    }
    function getBank(){
        return $this->db_handler->get_model($this,  $this->id);
    }
    function getBanks(){
        return $this->db_handler->get_model_list($this);
    }
    function deleteBank(){
        $result = $this->db_handler->delete_model($this);
        $description = "Bank deleted, result : ".$result;
        Log::i($this->tag, $description);
        return $result;
    }
    function updateBank($bank=null){
        if($bank==null){
            $bank = $this;
        }
        if($this->db_handler->update_model($bank)){
            $description = "Updated bank (".  $bank->to_string().")";
            Log::i($this->tag, $description);
            return True;
        }else{
            return FALSE;
        }
    }    
}
