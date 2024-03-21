<?php

class RecensementAPI extends CI_Controller {
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
       foreach($obj as $dateRes){
        $villageId = $dateRes['village'];
        $d = $dateRes['dateEnquete'];
        
        $i = $i + 1;
        $jour = substr($d,0,2);
        $mois = substr($d,3,2);
        $annee = substr($d,6,4); 
        
        $dateEnq = $annee."-".$mois."-".$jour;
        
        $num_ordre = 1;
         $fiche_existe = $this->db_recensement->existe(array(
             'village' => $villageId,
             'date' => $dateEnq
             ));
             
         if($fiche_existe){
            $num_ordre = $this->db_recensement->dernier_numero_ordre(array(
                'village' => $villageId,
                'date' => $dateEnq
                 ))+1; 
        }
         $index = 0;
         
        foreach($dateRes['enquetes'] as $res){
            
           $j = $index;
           if($j < 1){
            $fiche_recensement = array(
                'village' => $villageId,

                'date' => $dateEnq,

                'numero_ordre'=>$num_ordre,

                'enqueteur' => $dateRes['IdEnqueteur'],
            );
            $insertion = $this->db_recensement->inserer($fiche_recensement);
            
           }
           $dernierFiche = $this->db_recensement->dernier_id();
           if($j<5)
           {
            $pecheur_data = array(
                'resident'=>$res['resident'],
                'pecheur'=>$res['pecheur'],
                'origine'=>$res['origine'],
                'nomPecheur'=>$res['nomPecheur'],
                'nomOrigine'=>$res['nomOrigine'],
                'age'=>$res['age'],
                'sexe'=>$res['sexe'],
            ) ;
            $idvillageOrigine = null;
            $idpecheur = null;
            if($pecheur_data['resident']==1){
               $idvillageOrigine = $villageId; 
            }
            else{
                if($pecheur_data['origine'] == 0){
                    $this->db_village->insert(array('nom'=>$pecheur_data['nomOrigine']));
                    $idvillageOrigine= $this->db_village->dernier_id();
                }
                else{
                    $idvillageOrigine = $res['origine'];  
                }
            }
            

            $anneeActuel = intval(date('Y'));
            $sexe = "H";
            if($res['sexe'] == 1){
                $sexe = "F";
            }
            
            if($pecheur_data['pecheur'] == 0){
                
                $this->db_pecheur->inserer(array('nom'=>$res['nomPecheur'],'village'=>$villageId, 'sexe'=>$sexe ,'datenais'=>$anneeActuel-intval($res['age']),'village_origine'=>$idvillageOrigine,'village_activite'=>$villageId));
                $idpecheur= $this->db_pecheur->dernier_id();
            }
            else{
                $idpecheur = $res['pecheur']; 
                $this->db_pecheur->mettre_a_jour(array('village'=>$villageId,'sexe'=>$sexe ,'datenais'=>$anneeActuel-intval($res['age']),'village_origine'=>$idvillageOrigine,'village_activite'=>$villageId), $idpecheur);
            }
            $periode = null;
            $periodeData = $res['periode'];
            if(count($periodeData)<0){
                $periode = null;
            }
            else{
                $periode = json_encode($periodeData) ;
            }

            $data_enquete= array(
                'recensement'=>$dernierFiche,
                'resident'=>$res['resident'],
                'pecheur'=>$idpecheur,
                'pirogue'=>$res['pirogue'],
                'toute_annee'=>$res['toute_annee'],
                'type_mare'=>$res['type_mare'],
                'periode_mois'=>$periode,
            );
            $insertion_enquete = $this->db_enquete_recensement->inserer($data_enquete);
            $dernier_id_enquete = $this->db_enquete_recensement->dernier_id(); 
            if($res['activite1'] != '' && $res['pourcentage1'] !='' ){
                $dataActivite1 = array('activite'=>$res['activite1'],'enquete_recensement'=>$dernier_id_enquete,'pourcentage'=>$res['pourcentage1']);
                $this->db_activite->inserer_activite_enquete_recensement($dataActivite1);
              }
              if($res['activite2'] != '' && $res['pourcentage2'] !='' ){
                $dataActivite2 = array('activite'=>$res['activite2'],'enquete_recensement'=>$dernier_id_enquete,'pourcentage'=>$res['pourcentage2']);
                $this->db_activite->inserer_activite_enquete_recensement($dataActivite2);
              }
              if($res['activite3'] != '' && $res['pourcentage3'] !='' ){
                $dataActivite3 = array('activite'=>$res['activite3'],'enquete_recensement'=>$dernier_id_enquete,'pourcentage'=>$res['pourcentage3']);
                $this->db_activite->inserer_activite_enquete_recensement($dataActivite3);
              }
              if($res['engin1'] !=''&& $res['annee1'] !=''){
                $dataEngin1 = array('engin'=>$res['engin1'],'enquete_recensement'=>$dernier_id_enquete,'annee'=>$res['annee1']);
                $this->db_engin->inserer_engin_enqute_recensement($dataEngin1);
            }
            if($res['engin2'] !=''&& $res['annee2'] !=''){
                $dataEngin2 = array('engin'=>$res['engin2'],'enquete_recensement'=>$dernier_id_enquete,'annee'=>$res['annee2']);
                $this->db_engin->inserer_engin_enqute_recensement($dataEngin2); 
            }

            $index = $index+1;
            

            

           }
           if($j==4){
            $index = 0;
            $num_ordre = $num_ordre + 1;
           }
        }
       }
       echo json_encode(array('success'=>'success'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        

    }

}
