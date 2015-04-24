<?php

/**
 * Description of Bank_deposits
 *
 * @author Sakkeer Hussain
 */
class bank_deposits {

    public $id;
    public $cachier_id;
    public $bank_id;
    public $amount;
    public $description;
    public $deposited_at;
    public $last_edited;
    
    private $db_handler;
    private $tag = 'BANK DEPOSITS CONTROLLER';

    function __construct() {
        $this->db_handler = new DBConnection();
    }

    public function to_string() {
        return 'id : ' . $this->id . ' - '
                . 'cachier_id : ' . $this->cachier_id . ' - '
                . 'bank_id : ' . $this->bank_id . ' - '
                . 'amount : ' . $this->amount . ' - '
                . '$description : ' . $this->description . ' - '
                . 'deposited_at : ' . $this->deposited_at . ' - '
                . 'last_edited : ' . $this->last_edited;
    }

    function addBankDeposits($bank_deposit = null) {
        if ($bank_deposit == null){
            $bank_deposit = $this;
        }
        $this->db_handler->add_model($bank_deposit);
        $description = "Added new Bank Deposit (" . $bank_deposit->to_string() . ")";
        Log::i($this->tag, $description);
    }
    function getBankDeposit(){
        return $this->db_handler->get_model($this,  $this->id);
    }

}
