<?php

/**
 * Description of Inventry
 *
 * @author Sakkeer Hussain
 */
class inventry {
    
    public $id;
    public $item_id;
    public $in_stock_count;
    public $cutoff_count;
    public $company_id;
    public $selling_prize;
    public $tax_category_id;
    public $last_edited;
    public $created_at;
    
    private $db_handler;
    private $tag = 'INVENTRY CONTROLLER';
    
    function __construct() {
        $this->db_handler = new DBConnection();
    }
    public function to_string() {
        return 'id : '.$this->id.' - '
                .'in_stock_count : '.$this->in_stock_count.' - '
                .'item_id : '.$this->item_id.' - '
                .'cutoff_count : '.$this->cutoff_count.' - '
                .'company_id : '.$this->company_id.' - '
                .'selling_prize : '.$this->selling_prize.' - '
                .'tax_category_id : '.$this->tax_category_id;
    }
    function addInventry($inventry=null){
        if($inventry==null){
            $inventry = $this;
        }
        $this->db_handler->add_model($inventry);
        $description = "Added new Inventry(Stock) (". $inventry->to_string().")";
        Log::i($this->tag, $description);
    }
    function updateInventry($inventry=null){
        if($inventry==null){
            $inventry = $this;
        }
        $this->db_handler->update_model($inventry);
        $description = "Updated Inventry(Stock) (". $inventry->to_string().")";
        Log::i($this->tag, $description);
    }
    function getInventry(){
        return $this->db_handler->get_model($this,  $this->id);
    }
    function getInventryForSpecificCompanyAndItem(){
        return $this->db_handler->get_model_list($this, "company_id=".$this->company_id." and item_id=".$this->item_id);
    }
}
