<?php

class ActiviteAPI extends CI_Controller {
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
    }


    public function actualiser(){
        $activite = $this->db_activite->liste();
        echo json_encode($activite, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

}
