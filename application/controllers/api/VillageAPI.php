<?php

class VillageAPI extends CI_Controller {
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
    }


    public function actualiser(){
        // $village_origine = [];
        if(isset($_GET['village'])){
            $village = $this->db_village->selection_par_id($_GET['village']);
            $fokontany= $this->db_fokontany->selection_par_id($village['fokontany']);
            $commune= $this->db_commune->selection_par_id($fokontany['commune']);
            $district= $this->db_district->selection_par_id($commune['district']);
            $region= $this->db_region->selection_par_id($district['region']);
            $village_origine = $this->db_village->selection_par_zone_corecrabe01($region['zone_corecrabe']) ;
            echo json_encode($village_origine , JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        }
        
        
    }

}
