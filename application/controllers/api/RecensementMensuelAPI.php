<?php

class RecensementMensuelAPI extends CI_Controller {
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Header:*');
    }
    public function sync(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
       $i = 0;
       $dd = null;
       foreach($obj as $enquetes){
        $d = $enquetes['dateEnquete'];
        $i = $i + 1;
        $jour = substr($d,0,2);
        $mois = substr($d,3,2);
        $annee = substr($d,6,4); 
        
        $dateEnq = $annee."-".$mois."-".$jour;
        $data = array(
            'village'=>$enquetes["village"],
            'annee'=>$enquetes['annee'],
            'mois'=>$enquetes['mois'],
            'date'=>$dateEnq,
            'enqueteur'=>$enquetes['IdEnqueteur'],
        );
        $existe = $this->db_recensement_mensuel->existe(array('village'=>$data['village'],'annee'=>$data['annee'],'mois'=>$data['mois']));
        if($existe){
            $idfiche = $this->db_recensement_mensuel->existe_id(array('village'=>$data['village'],'annee'=>$data['annee'],'mois'=>$data['mois']));	
        }
        else{
             $insertion = $this->db_recensement_mensuel->inserer($data);
             $idfiche = $this->db_recensement_mensuel->existe_id($data);
        }
         foreach($enquetes['enquetes'] as $enquete){
            
            $data_enquete = array('pecheur'=>$enquete['pecheur'],'recensement_mensuel'=>$idfiche,'crabe'=>$enquete['crabe']);
            $insertion = $this->db_recensement_mensuel->inserer_enquete($data_enquete);
            $idEnquete = $this->db_recensement_mensuel->dernier_id_enquete();
            if($enquete['activite1'] != null && $enquete['pourcentage1'] != null ){
                $insertion = $this->db_recensement_mensuel->inserer_activite_enquete(array('enquete_recensement_mensuel'=>$idEnquete,'activite'=>$enquete['activite1'],'pourcentage'=>$enquete['pourcentage1']));
                
            }
            if($enquete['activite2'] != null && $enquete['pourcentage2'] != null ){
                $insertion = $this->db_recensement_mensuel->inserer_activite_enquete(array('enquete_recensement_mensuel'=>$idEnquete,'activite'=>$enquete['activite2'],'pourcentage'=>$enquete['pourcentage2']));
                
            }
            if($enquete['activite3'] != null && $enquete['pourcentage3'] != null ){
                $insertion = $this->db_recensement_mensuel->inserer_activite_enquete(array('enquete_recensement_mensuel'=>$idEnquete,'activite'=>$enquete['activite3'],'pourcentage'=>$enquete['pourcentage3']));
                
            }

         }
       }
       echo json_encode(array('success'=>'success'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        

    }

}
