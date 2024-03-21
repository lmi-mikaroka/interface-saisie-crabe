<?php

class ZoneAPI extends CI_Controller {
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
    }


    public function actualiser(){
        $village = $this->db_village->selection_api();
        $zone = $this->db_zone_corecrabe->liste();
        echo json_encode(array('zone'=>$zone,'village'=>$village), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function zone(){
        $data = $this->db_zone_corecrabe->liste();
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

}
