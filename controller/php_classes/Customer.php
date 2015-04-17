<?php

/**
 * Description of Customer
 *
 * @author Sakkeer Hussain
 */
class customer {
    
    public $id;
    public $customer_name;
    public $total_purchace_amount;
    public $customer_code;
    public $company_id;
    public $purchace_amount_to_avail_redeem;
    public $created_at;
    public $last_edited;
    
    private $db_handler;
    private $tag = 'CUSTOMER CONTROLLER';

    function __construct() {
        $this->db_handler = new DBConnection();
    }

    public function to_string() {
        return 'id : ' . $this->id . ' - '
                . 'customer_name : ' . $this->customer_name . ' - '
                . 'total_purchace_amount : ' . $this->total_purchace_amount . ' - '
                . 'purchace_amount_to_avail_redeem : ' . $this->purchace_amount_to_avail_redeem . ' - '
                . 'customer_code : ' . $this->customer_code . ' - '
                . 'company_id : ' . $this->company_id . ' - '
                . 'created_at : ' . $this->created_at . ' - '
                . 'last_edited : ' . $this->last_edited;
    }

    function addCustomer($customer = null) {
        if ($customer == null){
            $customer = $this;
        }
        $this->db_handler->add_model($customer);
        $description = "Added new Customer (" . $customer->to_string() . ")";
        Log::i($this->tag, $description);
    }
    function getCustomer(){
        return $this->db_handler->get_model(new Customer(),  $this->id);
    }

}
