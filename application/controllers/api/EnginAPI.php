<?php

class EnginAPI extends CI_Controller {
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
    }


    public function actualiser(){
        $engin = $this->db_engin->liste();
        echo json_encode($engin, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

}
