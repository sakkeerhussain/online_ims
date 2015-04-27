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
            $inv = new inventry();
            $inv->company_id = $sale->company_id;
            $inv->item_id = $sales_item->item_id;
            $invs = $inv->getInventryForSpecificCompanyAndItem();
            $inv = $invs[0];  
            $inv->in_stock_count = $inv->in_stock_count - $sales_item->quantity; 
            $inv->updateInventry();
        }
        $description = "Added new Sale (". $sale->to_string().")";
        
        $customer = new customer();
        $customer->id = $sale->customer_id;
        $customer->getCustomer();
        $customer->total_purchace_amount = $customer->total_purchace_amount + $sale->amount;
        $customer->updateCustomer();
        
        Log::i($this->tag, $description);
        return $sale_id;
    }
    function updateSale($sale = null){
        if($sale==null){
            $sale = $this;
        }
        $sale_id = $this->id;
        $this->db_handler->update_model($sale);
        $sale_item_obj = new sales_items();
        $sale_item_obj->clearSaleItems($sale_id);
        foreach ($this->sales_items as $sales_item) {
            $sales_item->sale_id = $sale_id;
            $sales_item->addSaleItem();
        }
        $description = "Updating Sale (". $sale->to_string().")";
        Log::i($this->tag, $description);
    }
    function getSale(){
        $this->db_handler->get_model($this,  $this->id);
        $sale_item = new sales_items();
        $this->sales_items = $sale_item->getSaleItems($this->id);
        return $this;
    }
    function getSales($company_id){
        $sales = $this->db_handler->get_model_list($this, 'company_id = ' + $company_id);
        foreach ($sales as $sale) {
            $sale_item = new sales_items();
            $sale->sales_items = $sale_item->getSaleItems($sale->id);
        }
        return $sales;
    }
    function getTodaysSales($company_id){ 
        $sales = $this->db_handler->get_model_list($this, 'company_id = ' . $company_id . ' and DATE(`sale_at`) = DATE(NOW()) ORDER BY `id` DESC');
        foreach ($sales as $sale) {
            $sale_item = new sales_items();
            $sale->sales_items = $sale_item->getSaleItems($sale->id);
        }
        return $sales;
    }
    function getLastWeeksSales($company_id){ 
        $sales = $this->db_handler->get_model_list($this, 'company_id = ' . $company_id . ' and `sale_at` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY `id` DESC');
        foreach ($sales as $sale) {
            $sale_item = new sales_items();
            $sale->sales_items = $sale_item->getSaleItems($sale->id);
        }
        return $sales;
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
