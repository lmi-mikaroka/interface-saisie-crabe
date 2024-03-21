<?php

class RemoteFIcheAPI extends CI_Controller {
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
    }


    public function actualiser(){
        $remotefiche = $this->db_fiche->RemoteFicheAPI();
        echo json_encode($remotefiche, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

}
