<?php

/**
 * Description of Wendors
 *
 * @author Sakkeer Hussain
 */
class wendors {

    public $id;
    public $wendor_name;
    public $total_puchace_amount;
    public $wendor_tin_number;
    public $contact_no;
    public $contact_address;
    public $created_at;
    public $last_edited;
    
    private $db_handler;
    private $tag = 'WENDORS CONTROLLER';

    function __construct() {
        $this->db_handler = new DBConnection();
    }

    public function to_string() {
        return 'id : ' . $this->id . ' - '
                . 'wendor_name : ' . $this->wendor_name . ' - '
                . 'total_puchace_amount : ' . $this->total_puchace_amount . ' - '
                . 'wendor_tin_number : ' . $this->wendor_tin_number . ' - '
                . 'contact_no : ' . $this->contact_no . ' - '
                . 'contact_address : ' . $this->contact_address . ' - '
                . 'created_at : ' . $this->created_at . ' - '
                . 'last_edited : ' . $this->last_edited;
    }

    function addWendor($wendor = null) {
        if ($wendor == null) {
            $wendor = $this;
        }
        if($this->db_handler->add_model($wendor)){
            $description = "Added new Wendor (" . $wendor->to_string() . ")";
            Log::i($this->tag, $description);
            return True;
        }else{
            return FALSE;
        }
    }
    function updateWendor($wendor = null) {
        if ($wendor == null) {
            $wendor = $this;
        }
        if($this->db_handler->update_model($wendor)){
            $description = "updated Wendor (" . $wendor->to_string() . ")";
            Log::i($this->tag, $description);
            return True;
        }else{
            return FALSE;
        }
    }
    function getWendor(){
        return $this->db_handler->get_model($this,  $this->id);
        
    }
    function deleteWendor(){
        $result = $this->db_handler->delete_model($this);
        $description = "Vendor deleted, result : ".$result;
        Log::i($this->tag, $description);
        return $result;
    }
    function getWendors(){
        $wendors = $this->db_handler->get_model_list($this);
        return $wendors;
    }
}
