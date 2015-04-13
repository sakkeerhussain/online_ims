<?php

/**
 * Description of Expences
 *
 * @author Sakkeer Hussain
 */
class Expences {
    public $id;
    public $amount;
    public $description;
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
                . 'created_at : ' . $this->created_at . ' - '
                . 'last_edited : ' . $this->last_edited;
    }

    function addExpemce($expemce = null) {
        if ($expemce == null){
            $expemce = $this;
        }
        $this->db_handler->add_model($expemce);
        $description = "Added new Expemce (" . $expemce->to_string() . ")";
        Log::i($this->tag, $description);
    }
    function getExpemce(){
        return $this->db_handler->get_model(new Expemce(),  $this->id);
    }
}
