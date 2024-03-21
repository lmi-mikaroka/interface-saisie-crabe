<?php

class AcheteurAPI extends CI_Controller {
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Header:*');
    }



    public function sync(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $type = "ACH";
        foreach($obj as $res){
            $i = 1;
            while($i<1000){
                $fiche_existe = $this->db_fiche->existe(array(

                    'village' => $res['Village'],
        
                    'type' => $type,
        
                    'annee' => intval(substr($res['DateEnquete'],6,4)),
        
                    'mois' => intval(substr($res['DateEnquete'],3,2)),
        
                    'numero_ordre' => $i
        
                ));
                if ($fiche_existe) {
                    $i+=1;
                }else{
                    $fiche = array(

                        'village' => $res['Village'],
        
                        'type' => $type,
            
                        'annee' => intval(substr($res['DateEnquete'],6,4)),
            
                        'mois' => intval(substr($res['DateEnquete'],3,2)),
            
                        'numero_ordre' => $i,
        
                        'date_expedition' => date("Y-m-d"),
                        
                        'enqueteur' => $res['IdEnqueteur']
        
                    );
                    $insertion = $this->db_fiche->inserer($fiche);
                    $idFiche = $this->db_fiche->LastFiche($fiche);
                    $i = 1000;

                    //Précision de l'identification du pêcheur
                    $idPecheur = null;
                    if($res['IdPecheur'] == "0"){
                        $pecheur = array(
                            'village' => $res['Village'],
                            'nom' => $res['NomPecheur']
                        );
                        $this->db_pecheur->inserer($pecheur);
                        $idPecheur = $this->db_pecheur->lastPecheur($pecheur);
                    }else{
                        $idPecheur = $res['IdPecheur'];
                    }

                    //Formatage de la date d'enquête
                    $mois = substr($res['DateEnquete'],3,2);
                    $annee = substr($res['DateEnquete'],6,4);
                    $jour = substr($res['DateEnquete'],0,2);

                    $dateEnquete = $annee."/".$mois."/".$jour;

                    

                    //FICHE ENQUETEUR
                    $ficheAch = array(
                        'date' => $dateEnquete,
                        'pecheur_nombre' => $res['NombrePecheur'],
                        'crabe_non_vendu_poids' => $res['nonvenduPoids'],
                        'crabe_non_vendu_nombre' => $res['nonvenduNombre'],
                        'collecte_prix1' => $res['CollectPrix1'],
                        'collecte_poids1' => $res['CollectPoids1'],
                        'marche_local_prix' => $res['LocalPrix'],
                        'marche_local_poids' => $res['LocalPoids'],
                        'fiche' => $idFiche,
                        'pecheur' => $idPecheur,
                        'collecte_poids2' => $res['CollectPoids2'],
                        'collecte_prix2' => $res['CollectPrix2'],
                        'nombre_sortie_vente' => $res['NombreSortie']
                    );

                    $this->db_fiche_acheteur->insertion_fiche($ficheAch);
                    $idFicheAch = $this->db_fiche_acheteur->lastFicheAch($ficheAch);

                    //SORTIES DE PÊCHES 1

                    $mois1 = substr($res['DateSortie1'],3,2);
                    $annee1 = substr($res['DateSortie1'],6,4);
                    $jour1 = substr($res['DateSortie1'],0,2);

                    $dateSortie1 = $annee1."/".$mois1."/".$jour1;

                    $sortie1 = array(
                        'date'=> $dateSortie1,
                        'nombre'=> $res['NombreSortie1'],
                        'pirogue'=> $res['SortieAvecPirogue1'],
                        'fiche_acheteur'=> $idFicheAch
                    );

                    $this->db_fiche_acheteur->inserer_sortie_de_peche($sortie1);
                    $idSortie1 = $this->db_fiche_acheteur->lastSortie($sortie1);

                    //engin 1 sortie de pêche 1

                    $engin1Sortie1 = array(
                        'sortie_de_peche_acheteur' => $idSortie1,
                        'engin'=> $res['IdEngin1Sortie1'],
                        'nombre'=> $res['NombreEngin1Sortie1']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin1Sortie1);
                    //engin 2 sortie de pêche 1

                    $engin2Sortie1 = array(
                        'sortie_de_peche_acheteur' => $idSortie1,
                        'engin'=> $res['IdEngin2Sortie1'],
                        'nombre'=> $res['NombreEngin2Sortie1']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin2Sortie1);


                    //SORTIES DE PÊCHES 2

                    $mois2 = substr($res['DateSortie2'],3,2);
                    $annee2 = substr($res['DateSortie2'],6,4);
                    $jour2 = substr($res['DateSortie2'],0,2);

                    $dateSortie2 = $annee2."/".$mois2."/".$jour2;

                    $sortie2 = array(
                        'date'=> $dateSortie2,
                        'nombre'=> $res['NombreSortie2'],
                        'pirogue'=> $res['SortieAvecPirogue2'],
                        'fiche_acheteur'=> $idFicheAch
                    );

                    $this->db_fiche_acheteur->inserer_sortie_de_peche($sortie2);
                    $idSortie2 = $this->db_fiche_acheteur->lastSortie($sortie2);

                    //engin 1 sortie de pêche 2

                    $engin1Sortie2 = array(
                        'sortie_de_peche_acheteur' => $idSortie2,
                        'engin'=> $res['IdEngin1Sortie2'],
                        'nombre'=> $res['NombreEngin1Sortie2']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin1Sortie2);
                    //engin 2 sortie de pêche 2

                    $engin2Sortie2 = array(
                        'sortie_de_peche_acheteur' => $idSortie2,
                        'engin'=> $res['IdEngin2Sortie2'],
                        'nombre'=> $res['NombreEngin2Sortie2']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin2Sortie2);


                    //SORTIES DE PÊCHES 3

                    $mois3 = substr($res['DateSortie3'],3,2);
                    $annee3 = substr($res['DateSortie3'],6,4);
                    $jour3 = substr($res['DateSortie3'],0,2);

                    $dateSortie3 = $annee3."/".$mois3."/".$jour3;

                    $sortie3 = array(
                        'date'=> $dateSortie3,
                        'nombre'=> $res['NombreSortie3'],
                        'pirogue'=> $res['SortieAvecPirogue3'],
                        'fiche_acheteur'=> $idFicheAch
                    );

                    $this->db_fiche_acheteur->inserer_sortie_de_peche($sortie3);
                    $idSortie3 = $this->db_fiche_acheteur->lastSortie($sortie3);

                    //engin 1 sortie de pêche 3

                    $engin1Sortie3 = array(
                        'sortie_de_peche_acheteur' => $idSortie3,
                        'engin'=> $res['IdEngin1Sortie3'],
                        'nombre'=> $res['NombreEngin1Sortie3']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin1Sortie3);
                    //engin 2 sortie de pêche 3

                    $engin2Sortie3 = array(
                        'sortie_de_peche_acheteur' => $idSortie3,
                        'engin'=> $res['IdEngin2Sortie3'],
                        'nombre'=> $res['NombreEngin2Sortie3']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin2Sortie3);



                    //SORTIES DE PÊCHES 4

                    $mois4 = substr($res['DateSortie4'],3,2);
                    $annee4 = substr($res['DateSortie4'],6,4);
                    $jour4 = substr($res['DateSortie4'],0,2);

                    $dateSortie4 = $annee4."/".$mois4."/".$jour4;

                    $sortie4 = array(
                        'date'=> $dateSortie4,
                        'nombre'=> $res['NombreSortie4'],
                        'pirogue'=> $res['SortieAvecPirogue4'],
                        'fiche_acheteur'=> $idFicheAch
                    );

                    $this->db_fiche_acheteur->inserer_sortie_de_peche($sortie4);
                    $idSortie4 = $this->db_fiche_acheteur->lastSortie($sortie4);

                    //engin 1 sortie de pêche 4

                    $engin1Sortie4 = array(
                        'sortie_de_peche_acheteur' => $idSortie4,
                        'engin'=> $res['IdEngin1Sortie4'],
                        'nombre'=> $res['NombreEngin1Sortie4']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin1Sortie4);
                    //engin 2 sortie de pêche 4

                    $engin2Sortie4 = array(
                        'sortie_de_peche_acheteur' => $idSortie4,
                        'engin'=> $res['IdEngin2Sortie4'],
                        'nombre'=> $res['NombreEngin2Sortie4']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin2Sortie4);

                }
            }
            
        }

        echo json_encode(array('success'=>"success"), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    public function sync1(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $type = "ACH";
        foreach($obj as $res){
            $i = 1;

            $fiche_existe_num_ordre = $this->db_fiche->existe(array(

                'village' => $res['Village'],
    
                'type' => $type,
    
                'annee' => intval(substr($res['DateEnquete'],6,4)),
    
                'mois' => intval(substr($res['DateEnquete'],3,2)),
    
            ));
            if($fiche_existe_num_ordre){
                $i = $this->db_fiche->dernier_numero_ordre(array(

                    'village' => $res['Village'],
        
                    'type' => $type,
        
                    'annee' => intval(substr($res['DateEnquete'],6,4)),
        
                    'mois' => intval(substr($res['DateEnquete'],3,2)),
        
                ));
            }
            
            while($i<1000){
                $idFiche= null;
                $fiche_existe = $this->db_fiche->existe(array(

                    'village' => $res['Village'],
        
                    'type' => $type,
        
                    'annee' => intval(substr($res['DateEnquete'],6,4)),
        
                    'mois' => intval(substr($res['DateEnquete'],3,2)),
        
                    'numero_ordre' => $i
        
                ));
                if ($fiche_existe) {
                    $idFiche = $this->db_fiche->LastFiche(array(

                        'village' => $res['Village'],
            
                        'type' => $type,
            
                        'annee' => intval(substr($res['DateEnquete'],6,4)),
            
                        'mois' => intval(substr($res['DateEnquete'],3,2)),
            
                        'numero_ordre' => $i
            
                    ));
                    $nombre_enquete = $this->db_fiche_acheteur->total_enquete_par_fiche($idFiche);
                    if($nombre_enquete == 5){
                        $idFiche= null;
                        $i= $i+1;
                    }
                    else{
                        $i = 1000;
                    }

                }else{
                    $fiche = array(

                        'village' => $res['Village'],
        
                        'type' => $type,
            
                        'annee' => intval(substr($res['DateEnquete'],6,4)),
            
                        'mois' => intval(substr($res['DateEnquete'],3,2)),
            
                        'numero_ordre' => $i,
        
                        'date_expedition' => date("Y-m-d"),
                        
                        'enqueteur' => $res['IdEnqueteur']
        
                    );
                    $insertion = $this->db_fiche->inserer($fiche);
                    $idFiche = $this->db_fiche->LastFiche($fiche);
                    $i = 1000;  

                }
                if($idFiche != null){
                    //Précision de l'identification du pêcheur
                    $idPecheur = null;
                    if($res['IdPecheur'] == "0"){
                        $pecheur = array(
                            'village' => $res['Village'],
                            'nom' => $res['NomPecheur']
                        );
                        $this->db_pecheur->inserer($pecheur);
                        $idPecheur = $this->db_pecheur->lastPecheur($pecheur);
                    }else{
                        $idPecheur = $res['IdPecheur'];
                    }

                    //Formatage de la date d'enquête
                    $mois = substr($res['DateEnquete'],3,2);
                    $annee = substr($res['DateEnquete'],6,4);
                    $jour = substr($res['DateEnquete'],0,2);

                    $dateEnquete = $annee."/".$mois."/".$jour;

                    

                    //FICHE ENQUETEUR
                    $ficheAch = array(
                        'date' => $dateEnquete,
                        'pecheur_nombre' => $res['NombrePecheur'],
                        'crabe_non_vendu_poids' => $res['nonvenduPoids'],
                        'crabe_non_vendu_nombre' => $res['nonvenduNombre'],
                        'collecte_prix1' => $res['CollectPrix1'],
                        'collecte_poids1' => $res['CollectPoids1'],
                        'marche_local_prix' => $res['LocalPrix'],
                        'marche_local_poids' => $res['LocalPoids'],
                        'fiche' => $idFiche,
                        'pecheur' => $idPecheur,
                        'collecte_poids2' => $res['CollectPoids2'],
                        'collecte_prix2' => $res['CollectPrix2'],
                        'nombre_sortie_vente' => $res['NombreSortie']
                    );

                    $this->db_fiche_acheteur->insertion_fiche($ficheAch);
                    $idFicheAch = $this->db_fiche_acheteur->lastFicheAch($ficheAch);

                    //SORTIES DE PÊCHES 1

                    $mois1 = substr($res['DateSortie1'],3,2);
                    $annee1 = substr($res['DateSortie1'],6,4);
                    $jour1 = substr($res['DateSortie1'],0,2);

                    $dateSortie1 = $annee1."/".$mois1."/".$jour1;

                    $sortie1 = array(
                        'date'=> $dateSortie1,
                        'nombre'=> $res['NombreSortie1'],
                        'pirogue'=> $res['SortieAvecPirogue1'],
                        'fiche_acheteur'=> $idFicheAch
                    );

                    $this->db_fiche_acheteur->inserer_sortie_de_peche($sortie1);
                    $idSortie1 = $this->db_fiche_acheteur->lastSortie($sortie1);

                    //engin 1 sortie de pêche 1

                    $engin1Sortie1 = array(
                        'sortie_de_peche_acheteur' => $idSortie1,
                        'engin'=> $res['IdEngin1Sortie1'],
                        'nombre'=> $res['NombreEngin1Sortie1']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin1Sortie1);
                    //engin 2 sortie de pêche 1

                    $engin2Sortie1 = array(
                        'sortie_de_peche_acheteur' => $idSortie1,
                        'engin'=> $res['IdEngin2Sortie1'],
                        'nombre'=> $res['NombreEngin2Sortie1']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin2Sortie1);


                    //SORTIES DE PÊCHES 2

                    $mois2 = substr($res['DateSortie2'],3,2);
                    $annee2 = substr($res['DateSortie2'],6,4);
                    $jour2 = substr($res['DateSortie2'],0,2);

                    $dateSortie2 = $annee2."/".$mois2."/".$jour2;

                    $sortie2 = array(
                        'date'=> $dateSortie2,
                        'nombre'=> $res['NombreSortie2'],
                        'pirogue'=> $res['SortieAvecPirogue2'],
                        'fiche_acheteur'=> $idFicheAch
                    );

                    $this->db_fiche_acheteur->inserer_sortie_de_peche($sortie2);
                    $idSortie2 = $this->db_fiche_acheteur->lastSortie($sortie2);

                    //engin 1 sortie de pêche 2

                    $engin1Sortie2 = array(
                        'sortie_de_peche_acheteur' => $idSortie2,
                        'engin'=> $res['IdEngin1Sortie2'],
                        'nombre'=> $res['NombreEngin1Sortie2']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin1Sortie2);
                    //engin 2 sortie de pêche 2

                    $engin2Sortie2 = array(
                        'sortie_de_peche_acheteur' => $idSortie2,
                        'engin'=> $res['IdEngin2Sortie2'],
                        'nombre'=> $res['NombreEngin2Sortie2']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin2Sortie2);


                    //SORTIES DE PÊCHES 3

                    $mois3 = substr($res['DateSortie3'],3,2);
                    $annee3 = substr($res['DateSortie3'],6,4);
                    $jour3 = substr($res['DateSortie3'],0,2);

                    $dateSortie3 = $annee3."/".$mois3."/".$jour3;

                    $sortie3 = array(
                        'date'=> $dateSortie3,
                        'nombre'=> $res['NombreSortie3'],
                        'pirogue'=> $res['SortieAvecPirogue3'],
                        'fiche_acheteur'=> $idFicheAch
                    );

                    $this->db_fiche_acheteur->inserer_sortie_de_peche($sortie3);
                    $idSortie3 = $this->db_fiche_acheteur->lastSortie($sortie3);

                    //engin 1 sortie de pêche 3

                    $engin1Sortie3 = array(
                        'sortie_de_peche_acheteur' => $idSortie3,
                        'engin'=> $res['IdEngin1Sortie3'],
                        'nombre'=> $res['NombreEngin1Sortie3']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin1Sortie3);
                    //engin 2 sortie de pêche 3

                    $engin2Sortie3 = array(
                        'sortie_de_peche_acheteur' => $idSortie3,
                        'engin'=> $res['IdEngin2Sortie3'],
                        'nombre'=> $res['NombreEngin2Sortie3']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin2Sortie3);



                    //SORTIES DE PÊCHES 4

                    $mois4 = substr($res['DateSortie4'],3,2);
                    $annee4 = substr($res['DateSortie4'],6,4);
                    $jour4 = substr($res['DateSortie4'],0,2);

                    $dateSortie4 = $annee4."/".$mois4."/".$jour4;

                    $sortie4 = array(
                        'date'=> $dateSortie4,
                        'nombre'=> $res['NombreSortie4'],
                        'pirogue'=> $res['SortieAvecPirogue4'],
                        'fiche_acheteur'=> $idFicheAch
                    );

                    $this->db_fiche_acheteur->inserer_sortie_de_peche($sortie4);
                    $idSortie4 = $this->db_fiche_acheteur->lastSortie($sortie4);

                    //engin 1 sortie de pêche 4

                    $engin1Sortie4 = array(
                        'sortie_de_peche_acheteur' => $idSortie4,
                        'engin'=> $res['IdEngin1Sortie4'],
                        'nombre'=> $res['NombreEngin1Sortie4']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin1Sortie4);
                    //engin 2 sortie de pêche 4

                    $engin2Sortie4 = array(
                        'sortie_de_peche_acheteur' => $idSortie4,
                        'engin'=> $res['IdEngin2Sortie4'],
                        'nombre'=> $res['NombreEngin2Sortie4']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_acheteur($engin2Sortie4);
                }
            }
            
        }


        echo json_encode(array('success'=>"success"), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
