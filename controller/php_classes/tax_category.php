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
        $this->db_handler->add_model($tax_c);
        $description = "Added new Tax category (" . $tax_c->to_string() . ")";
        Log::i($this->tag, $description);
    }
    function getTaxCategory(){
        return $this->db_handler->get_model($this,  $this->id);
    }
}
