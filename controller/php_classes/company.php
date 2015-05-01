<?php

/**
 * Description of Customer
 *
 * @author Sakkeer Hussain
 */
class company {
    
    public $id;
    public $company_name;
    public $company_code;
    public $created_at;
    public $last_edited;
    
    private $db_handler;
    private $tag = 'COMPANY CONTROLLER';

    function __construct() {
        $this->db_handler = new DBConnection();
    }

    public function to_string() {
        return 'id : ' . $this->id . ' - '
                . 'company_name : ' . $this->company_name . ' - '
                . 'company_code : ' . $this->company_code . ' - '
                . 'created_at : ' . $this->created_at . ' - '
                . 'last_edited : ' . $this->last_edited;
    }

    function addCompany($company = null) {
        if ($company == null){
            $company = $this;
        }
        $this->db_handler->add_model($company);
        $description = "Added new Company (" . $company->to_string() . ")";
        Log::i($this->tag, $description);
    }
    function getCompany(){
        return $this->db_handler->get_model($this,  $this->id);
    }
    function updateCompany(){
        return $this->db_handler->update_model($this);
        $description = "Updating Company (" . $company->to_string() . ")";
        Log::i($this->tag, $description);
    }
    function deleteCompany(){
        $result = $this->db_handler->delete_model($this);
        $description = "Company deleted, result : ".$result;
        Log::i($this->tag, $description);
        return $result;
    }
    function getCompanies(){
        return $this->db_handler->get_model_list($this);
    }
}
