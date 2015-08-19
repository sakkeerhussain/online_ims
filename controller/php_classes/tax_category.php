<?php

/**
 * Description of Expences
 *
 * @author Sakkeer Hussain
 */
class tax_category {
    public $id;
    public $tax_category_name;
    public $tax_percentage;
    public $created_at;
    public $last_edited;
   
    private $db_handler;
    private $tag = 'TAX CATEGORY CONTROLLER';

    function __construct() {
        $this->db_handler = new DBConnection();
    }

    public function to_string() {
        return 'id : ' . $this->id . ' - '
                . 'tax_category_name : ' . $this->tax_category_name . ' - '
                . 'tax_percentage : ' . $this->tax_percentage . ' - '
                . 'created_at : ' . $this->created_at . ' - '
                . 'last_edited : ' . $this->last_edited;
    }

    function addTaxCategory($tax_c = null) {
        if ($tax_c == null){
            $tax_c = $this;
        }
        $result = $this->db_handler->add_model($tax_c);
        if($result){
            $description = "Added new Tax category (" . $tax_c->to_string() . ")";
            Log::i($this->tag, $description);
        }
        return $result;
    }
    function getTaxCategory(){
        return $this->db_handler->get_model($this,  $this->id);
    }
    function getTaxCategories(){
        return $this->db_handler->get_model_list($this);
    }

    function updateTaxCategory() {
        $result = $this->db_handler->update_model($this);
        if($result){
            $description = "Updating TaxCategory (" . $this->to_string() . ")";
            Log::i($this->tag, $description);
        }
        return $result;
    }
    
    function deleteTaxCategory() {
        $result = $this->db_handler->delete_model($this);
        if($result){
            $description = "Tax Category deleted, Tax Category ID : ".$this->id;
            Log::i($this->tag, $description);
        }
        return $result;
    }
}
