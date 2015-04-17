<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sales_items
 *
 * @author Sakkeer Hussain
 */
class sales_items {

    public $id;
    public $sale_id;
    public $item_id;
    public $rate;
    public $quantity;
    public $tax;
    public $last_edited;
    private $db_handler;
    private $tag = 'SALES ITEMS CONTROLLER';

    function __construct() {
        $this->db_handler = new DBConnection();
    }

    public function to_string() {
        return 'id : ' . $this->id . ' - '
                . 'sale_id : ' . $this->sale_id . ' - '
                . 'item_id : ' . $this->item_id . ' - '
                . 'rate : ' . $this->rate . ' - '
                . 'quantity : ' . $this->quantity . ' - '
                . 'tax : ' . $this->tax;
    }

    function addSaleItem($sale_item = null) {
        if ($sale_item == null){
            $sale_item = $this;
        }
        $this->db_handler->add_model($sale_item);
        $description = "Added new Sale Item (" . $sale_item->to_string() . ")";
        Log::i($this->tag, $description);
    }
    function getSaleItem(){
        return $this->db_handler->get_model(new SaleItem(),  $this->id);
    }

}
