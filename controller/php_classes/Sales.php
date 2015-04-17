<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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

    private $db_handler;
    private $tag = 'SALES CONTROLLER';
    
    function __construct() {
        $this->db_handler = new DBConnection();
    }
    public function to_string() {
        return 'id : '.$this->id.' - '
                .'customer_id : '.$this->customer_id.' - '
                .'amount : '.$this->amount.' - '
                .'sale_at : '.$this->sale_at.' - '
                .'net_amount : '.$this->net_amount.' - '
                .'company_id : '.$this->company_id;
    }
    function addSales($sale=null){
        if($sale==null){
            $sale = $this;
        }
        $this->db_handler->add_model($sale);
        $description = "Added new Sale (". $sale->to_string().")";
        Log::i($this->tag, $description);
    }
    function getSales(){
        return $this->db_handler->get_model(new Sales(),  $this->id);
    }
}
