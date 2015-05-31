<?php

/**
 * Description of Expences
 *
 * @author Sakkeer Hussain
 */
class expences {
    public $id;
    public $amount;
    public $description;
    public $user_id;
    public $company_id;
    public $created_at;
    public $last_edited;
   
    private $db_handler;
    private $tag = 'EXPENCES CONTROLLER';

    function __construct() {
        $this->db_handler = new DBConnection();
    }

    public function to_string() {
        return 'id : ' . $this->id . ' - '
                . 'amount : ' . $this->amount . ' - '
                . 'description : ' . $this->description . ' - '
                . 'user_id : ' . $this->user_id . ' - '
                . 'company_id : ' . $this->company_id . ' - '
                . 'created_at : ' . $this->created_at . ' - '
                . 'last_edited : ' . $this->last_edited;
    }

    function addExpence($expemce = null) {
        if ($expemce == null){
            $expemce = $this;
        }
        $result = $this->db_handler->add_model($expemce);
        if($result){
            $description = "Added new Expemce (" . $expemce->to_string() . ")";
            Log::i($this->tag, $description);
        }
        return $result;
    }
    function getExpence(){
        return $this->db_handler->get_model($this,  $this->id);
    }
    function getExpences($company_id, $start, $limit){
        $expences = $this->db_handler->get_model_list($this, 'company_id = ' . $company_id . " ORDER BY `id` DESC LIMIT  $start,$limit");
        return $expences;
    }
    function updateExpence(){
        $result = $this->db_handler->update_model($this);
        $description = "Updating Expence (" . $this->to_string() . ")";
        Log::i($this->tag, $description);
        return $result;
    }
    function deleteExpence(){
        $result = $this->db_handler->delete_model($this);
        $description = "Expence deleted, result : ".$result;
        Log::i($this->tag, $description);
        return $result;
    }

    function getOneMonthsExpenceSummary($company_id, $month, $year) {
        $query = "SELECT SUM(`amount`) as `amount` FROM `expences` WHERE YEAR(`created_at`) = $year AND MONTH(`created_at`) = $month and `company_id` = $company_id ";
        $result = $this->db_handler->executeQuery($query);
        $vals = array();
        if ($row = mysql_fetch_assoc($result)) {
            foreach ($row as $key => $value) {
                $vals[$key] = $value;
            }
            return $vals;
        } else {
            return FALSE;
        }
    }

    function getExpencesCount($company_id) {
        $expences_count = $this->db_handler->get_model_count($this, 'company_id = ' . $company_id );
        return $expences_count;
    }
}
