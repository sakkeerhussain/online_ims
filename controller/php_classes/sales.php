<?php

/**
 * Description of Sales
 *
 * @author Sakkeer Hussain
 */
class sales {

    public $id;
    public $customer_id;
    public $amount;
    public $sale_at;
    public $net_amount;
    public $tax_amount;
    public $company_id;
    public $last_edited;

    private $sales_items = array();
    private $db_handler;
    private $tag = 'SALES CONTROLLER';
    
    function __construct() {
        $this->db_handler = new DBConnection();
    }
    public function to_string() {
        $sales_items = '';
        foreach ($this->sales_items as $sales_item) {
            $sales_items = $sales_items.'['.$sales_item->to_string().']';
        }
        
        return 'id : '.$this->id.' - '
                .'customer_id : '.$this->customer_id.' - '
                .'amount : '.$this->amount.' - '
                .'sale_at : '.$this->sale_at.' - '
                .'sale_items : '.$sales_items.' - '
                .'net_amount : '.$this->net_amount.' - '
                .'company_id : '.$this->company_id;
    }
    
    public function setSalesItems($sales_items){
        $this->sales_items = $sales_items;
    }
    
    public function getSalesItems(){
        return $this->sales_items;
    }
    function addSales($sale=null){
        if($sale==null){
            $sale = $this;
        }
        $sale_id = $this->db_handler->add_model($sale);
        foreach ($this->sales_items as $sales_item) {
            $sales_item->sale_id = $sale_id;
            $sales_item->addSaleItem();
        }
        $description = "Added new Sale (". $sale->to_string().")";
        Log::i($this->tag, $description);
    }
    function getSale(){
        $this->db_handler->get_model($this,  $this->id);
        $sale_item = new sales_items();
        $this->sales_items = $sale_item->getSaleItems($this->id);
        return $this;
    }
}

//$s = new sales();
//$s->amount  = 100;
//$s->company_id =1;
//$s->customer_id=1;
//$s->net_amount =66;
//$s->tax_amount = 34;
//
//$si = new sales_items();
//$si->item_id = 1;
//$si->quantity=10;
//$si->sale_id = 1;
//$si->rate = 1;
//
//$s->setSalesItems(array($si, $si, $si));

//$s->id = 3;
//$s->getSale();
//
//print_r($s);
//$s->addSales();