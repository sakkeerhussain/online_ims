<?php

/**
 * Description of Bank_deposits
 *
 * @author Sakkeer Hussain
 */
class bank_deposits {

    public $id;
    public $bank_id;
    public $amount;
    public $description;
    public $user_id;
    public $company_id;
    public $deposited_at;
    public $last_edited;
    
    private $db_handler;
    private $tag = 'BANK DEPOSITS CONTROLLER';

    function __construct() {
        $this->db_handler = new DBConnection();
    }

    public function to_string() {
        return 'id : ' . $this->id . ' - '
                . 'bank_id : ' . $this->bank_id . ' - '
                . 'amount : ' . $this->amount . ' - '
                . 'description : ' . $this->description . ' - '
                . 'user_id : ' . $this->user_id . ' - '
                . 'company_id : ' . $this->company_id . ' - '
                . 'deposited_at : ' . $this->deposited_at . ' - '
                . 'last_edited : ' . $this->last_edited;
    }

    function addBankDeposits($bank_deposit = null) {
        if ($bank_deposit == null){
            $bank_deposit = $this;
        }
        $result = $this->db_handler->add_model($bank_deposit);
        if($result){
            $description = "Added new Bank Deposit (" . $bank_deposit->to_string() . ")";
            Log::i($this->tag, $description);
            return TRUE;
        }else{
            return FALSE;
        }
    }    
    function getBankDeposit(){
        return $this->db_handler->get_model($this,  $this->id);
    }    
    function getBankDeposits($company_id){
        $expences = $this->db_handler->get_model_list($this, 'company_id = ' . $company_id . ' ORDER BY `id` DESC LIMIT 50');
        return $expences;
    }
    function deleteBankDeposit(){
        $result = $this->db_handler->delete_model($this);
        if($result){
            $description = "Bank Deposit deleted, result : ".$result;
            Log::i($this->tag, $description);
        }
        return $result;
    }
    function updateBankDeposit(){
        $result = $this->db_handler->update_model($this);
        $description = "Updating BankDeposit (" . $this->to_string() . ")";
        Log::i($this->tag, $description);
        return $result;
    }
}
