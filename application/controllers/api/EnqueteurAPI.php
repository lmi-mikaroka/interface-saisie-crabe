<?php

class EnqueteurAPI extends CI_Controller {
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Header:*');
    }


    public function actualiser(){
        $pecheur = $this->db_pecheur->liste_pecheur();
        $enqueteur = $this->db_enqueteur->liste_enqueteur();
        echo json_encode(array('pecheur'=>$pecheur, 'enqueteur'=>$enqueteur), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function sync(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $type = "ENQ";
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

                    //Précision Individu
                    $individu = "seul";
                    if($res['Accompagnateur'] == "conjoint"){
                        $individu = "partenaire";
                    }elseif($res['Accompagnateur'] == "ami"){
                        $individu = "amis";
                    }else{
                        $individu = $res['Accompagnateur'];
                    }

                    //FICHE ENQUETEUR
                    $ficheEnq = array(
                        'date' => $dateEnquete,
                        'participant_individu' => $individu,
                        'participant_nombre' => $res['NombreAccompagnateur'],
                        'capture_poids' => $res['PoidsTotalCapture'],
                        'crabe_consomme_poids' => $res['ConsommePoids'],
                        'crabe_consomme_nombre' => $res['ConsommeNombre'],
                        'collecte_prix1' => $res['CollectPrix1'],
                        'collecte_poids1' => $res['CollectPoids1'],
                        'marche_local_prix' => $res['LocalPrix'],
                        'marche_local_poids' => $res['LocalPoids'],
                        'fiche' => $idFiche,
                        'pecheur' => $idPecheur,
                        'collecte_poids2' => $res['CollectPoids2'],
                        'collecte_prix2' => $res['CollectPrix2'],
                        'nombre_sortie_capture' => $res['NombreSortie']
                    );

                    $this->db_fiche_enqueteur->inerer_fiche_enqueteur($ficheEnq);
                    $idFicheEnq = $this->db_fiche_enqueteur->lastFicheEnq($ficheEnq);

                    //Précision taille absente
                    $tailleAbsente = "plus petit";
                    if($res['TailleAbsente'] == 'gros'){
                        $tailleAbsente = "plus gros";
                    }elseif($res['TailleAbsente'] == 'petit'){
                        $tailleAbsente = "plus petit";
                    }else{
                        $tailleAbsente = $res['TailleAbsente'];
                    }

                    //Echantillon
                    $trie = $res['EchantillonTrie'];
                    if($res['EchantillonTrie'] == "false"){
                        $trie = false;
                    }elseif($res['EchantillonTrie'] == "true"){
                        $trie = true;
                    }else{
                        $trie = $res['EchantillonTrie'];
                    }

                    $echantillon = array(
                        'trie' => $res['EchantillonTrie'],
                        'poids' => $res['PoidsTotalEchantillon'],
                        'taille_absente' => $tailleAbsente,
                        'taille_absente_autre' => $res['PrecisionTailleAbsente'],
                        'fiche_enqueteur' => $idFicheEnq
                    );

                    //Insérer Echantillon

                    $this->db_echantillon->inserer($echantillon);
                    $idEchantillon = $this->db_echantillon->lastEchantillon($echantillon);

                    //Opération Crabe
                    foreach($res['crabe'] as $crabes){
                        $sexe = "M";
                        //sexe
                        switch ($crabes['Sexe']) {
                            case 0:
                                $sexe = "NR";
                                break;
                            case 1:
                                $sexe = "M";
                                break;
                            case 2:
                                $sexe = "FO";
                                break;
                            case 3:
                                $sexe = "NO";
                                break;
                            
                            default:
                            $sexe = "M";
                            break;
                                break;
                        }

                        //Ajouter Crabe

                        $crabe = array(
                            'destination'=> $crabes['Destination']+1,
                            'sexe'=> $sexe,
                            'echantillon'=> $idEchantillon,
                            'taille'=> $crabes['Taille']
                        );

                        $this->db_crabe->insertion($crabe);
                    }

                    //SORTIES DE PÊCHES 1

                    $mois1 = substr($res['DateSortie1'],3,2);
                    $annee1 = substr($res['DateSortie1'],6,4);
                    $jour1 = substr($res['DateSortie1'],0,2);

                    $dateSortie1 = $annee1."/".$mois1."/".$jour1;

                    $sortie1 = array(
                        'date'=> $dateSortie1,
                        'nombre'=> $res['NombreSortie1'],
                        'pirogue'=> $res['SortieAvecPirogue1'],
                        'fiche_enqueteur'=> $idFicheEnq
                    );

                    $this->db_fiche_enqueteur->inserer_sortie_de_peche($sortie1);
                    $idSortie1 = $this->db_fiche_enqueteur->lastSortie($sortie1);

                    //engin 1 sortie de pêche 1

                    $engin1Sortie1 = array(
                        'sortie_de_peche_enqueteur' => $idSortie1,
                        'engin'=> $res['IdEngin1Sortie1'],
                        'nombre'=> $res['NombreEngin1Sortie1']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin1Sortie1);
                    //engin 2 sortie de pêche 1

                    $engin2Sortie1 = array(
                        'sortie_de_peche_enqueteur' => $idSortie1,
                        'engin'=> $res['IdEngin2Sortie1'],
                        'nombre'=> $res['NombreEngin2Sortie1']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin2Sortie1);





                    //SORTIES DE PÊCHES 2

                    $mois2 = substr($res['DateSortie2'],3,2);
                    $annee2 = substr($res['DateSortie2'],6,4);
                    $jour2 = substr($res['DateSortie2'],0,2);

                    $dateSortie2 = $annee2."/".$mois2."/".$jour2;

                    $sortie2 = array(
                        'date'=> $dateSortie2,
                        'nombre'=> $res['NombreSortie2'],
                        'pirogue'=> $res['SortieAvecPirogue2'],
                        'fiche_enqueteur'=> $idFicheEnq
                    );

                    $this->db_fiche_enqueteur->inserer_sortie_de_peche($sortie2);
                    $idSortie2 = $this->db_fiche_enqueteur->lastSortie($sortie2);

                    //engin 1 sortie de pêche 2

                    $engin1Sortie2 = array(
                        'sortie_de_peche_enqueteur' => $idSortie2,
                        'engin'=> $res['IdEngin1Sortie2'],
                        'nombre'=> $res['NombreEngin1Sortie2']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin1Sortie2);
                    //engin 2 sortie de pêche 2

                    $engin2Sortie2 = array(
                        'sortie_de_peche_enqueteur' => $idSortie2,
                        'engin'=> $res['IdEngin2Sortie2'],
                        'nombre'=> $res['NombreEngin2Sortie2']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin2Sortie2);


                    //SORTIES DE PÊCHES 3

                    $mois3 = substr($res['DateSortie3'],3,2);
                    $annee3 = substr($res['DateSortie3'],6,4);
                    $jour3 = substr($res['DateSortie3'],0,2);

                    $dateSortie3 = $annee3."/".$mois3."/".$jour3;

                    $sortie3 = array(
                        'date'=> $dateSortie3,
                        'nombre'=> $res['NombreSortie3'],
                        'pirogue'=> $res['SortieAvecPirogue3'],
                        'fiche_enqueteur'=> $idFicheEnq
                    );

                    $this->db_fiche_enqueteur->inserer_sortie_de_peche($sortie3);
                    $idSortie3 = $this->db_fiche_enqueteur->lastSortie($sortie3);

                    //engin 1 sortie de pêche 3

                    $engin1Sortie3 = array(
                        'sortie_de_peche_enqueteur' => $idSortie3,
                        'engin'=> $res['IdEngin1Sortie3'],
                        'nombre'=> $res['NombreEngin1Sortie3']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin1Sortie3);
                    //engin 2 sortie de pêche 3

                    $engin2Sortie3 = array(
                        'sortie_de_peche_enqueteur' => $idSortie3,
                        'engin'=> $res['IdEngin2Sortie3'],
                        'nombre'=> $res['NombreEngin2Sortie3']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin2Sortie3);



                    //SORTIES DE PÊCHES 4

                    $mois4 = substr($res['DateSortie4'],3,2);
                    $annee4 = substr($res['DateSortie4'],6,4);
                    $jour4 = substr($res['DateSortie4'],0,2);

                    $dateSortie4 = $annee4."/".$mois4."/".$jour4;

                    $sortie4 = array(
                        'date'=> $dateSortie4,
                        'nombre'=> $res['NombreSortie4'],
                        'pirogue'=> $res['SortieAvecPirogue4'],
                        'fiche_enqueteur'=> $idFicheEnq
                    );

                    $this->db_fiche_enqueteur->inserer_sortie_de_peche($sortie4);
                    $idSortie4 = $this->db_fiche_enqueteur->lastSortie($sortie4);

                    //engin 1 sortie de pêche 4

                    $engin1Sortie4 = array(
                        'sortie_de_peche_enqueteur' => $idSortie4,
                        'engin'=> $res['IdEngin1Sortie4'],
                        'nombre'=> $res['NombreEngin1Sortie4']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin1Sortie4);
                    //engin 2 sortie de pêche 4

                    $engin2Sortie4 = array(
                        'sortie_de_peche_enqueteur' => $idSortie4,
                        'engin'=> $res['IdEngin2Sortie4'],
                        'nombre'=> $res['NombreEngin2Sortie4']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin2Sortie4);

                }
            }
            
        }

        echo json_encode(array('success'=>"success"), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    public function sync1(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $type = "ENQ";
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
                    $nombre_enquete = $this->db_fiche_enqueteur->total_enquete_par_fiche($idFiche);
                    if($nombre_enquete == 2){
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

                    //Précision Individu
                    $individu = "seul";
                    if($res['Accompagnateur'] == "conjoint"){
                        $individu = "partenaire";
                    }elseif($res['Accompagnateur'] == "ami"){
                        $individu = "amis";
                    }else{
                        $individu = $res['Accompagnateur'];
                    }

                    //FICHE ENQUETEUR
                    $ficheEnq = array(
                        'date' => $dateEnquete,
                        'participant_individu' => $individu,
                        'participant_nombre' => $res['NombreAccompagnateur'],
                        'capture_poids' => $res['PoidsTotalCapture'],
                        'crabe_consomme_poids' => $res['ConsommePoids'],
                        'crabe_consomme_nombre' => $res['ConsommeNombre'],
                        'collecte_prix1' => $res['CollectPrix1'],
                        'collecte_poids1' => $res['CollectPoids1'],
                        'marche_local_prix' => $res['LocalPrix'],
                        'marche_local_poids' => $res['LocalPoids'],
                        'fiche' => $idFiche,
                        'pecheur' => $idPecheur,
                        'collecte_poids2' => $res['CollectPoids2'],
                        'collecte_prix2' => $res['CollectPrix2'],
                        'nombre_sortie_capture' => $res['NombreSortie']
                    );

                    $this->db_fiche_enqueteur->inerer_fiche_enqueteur($ficheEnq);
                    $idFicheEnq = $this->db_fiche_enqueteur->lastFicheEnq($ficheEnq);

                    //Précision taille absente
                    $tailleAbsente = "plus petit";
                    if($res['TailleAbsente'] == 'gros'){
                        $tailleAbsente = "plus gros";
                    }elseif($res['TailleAbsente'] == 'petit'){
                        $tailleAbsente = "plus petit";
                    }else{
                        $tailleAbsente = $res['TailleAbsente'];
                    }

                    //Echantillon
                    $trie = $res['EchantillonTrie'];
                    if($res['EchantillonTrie'] == "false"){
                        $trie = false;
                    }elseif($res['EchantillonTrie'] == "true"){
                        $trie = true;
                    }else{
                        $trie = $res['EchantillonTrie'];
                    }

                    $echantillon = array(
                        'trie' => $res['EchantillonTrie'],
                        'poids' => $res['PoidsTotalEchantillon'],
                        'taille_absente' => $tailleAbsente,
                        'taille_absente_autre' => $res['PrecisionTailleAbsente'],
                        'fiche_enqueteur' => $idFicheEnq
                    );

                    //Insérer Echantillon

                    $this->db_echantillon->inserer($echantillon);
                    $idEchantillon = $this->db_echantillon->lastEchantillon($echantillon);

                    //Opération Crabe
                    foreach($res['crabe'] as $crabes){
                        $sexe = "M";
                        //sexe
                        switch ($crabes['Sexe']) {
                            case 0:
                                $sexe = "NR";
                                break;
                            case 1:
                                $sexe = "M";
                                break;
                            case 2:
                                $sexe = "FO";
                                break;
                            case 3:
                                $sexe = "NO";
                                break;
                            
                            default:
                            $sexe = "M";
                            break;
                                break;
                        }

                        //Ajouter Crabe

                        $crabe = array(
                            'destination'=> $crabes['Destination']+1,
                            'sexe'=> $sexe,
                            'echantillon'=> $idEchantillon,
                            'taille'=> $crabes['Taille']
                        );

                        $this->db_crabe->insertion($crabe);
                    }

                    //SORTIES DE PÊCHES 1

                    $mois1 = substr($res['DateSortie1'],3,2);
                    $annee1 = substr($res['DateSortie1'],6,4);
                    $jour1 = substr($res['DateSortie1'],0,2);

                    $dateSortie1 = $annee1."/".$mois1."/".$jour1;

                    $sortie1 = array(
                        'date'=> $dateSortie1,
                        'nombre'=> $res['NombreSortie1'],
                        'pirogue'=> $res['SortieAvecPirogue1'],
                        'fiche_enqueteur'=> $idFicheEnq
                    );

                    $this->db_fiche_enqueteur->inserer_sortie_de_peche($sortie1);
                    $idSortie1 = $this->db_fiche_enqueteur->lastSortie($sortie1);

                    //engin 1 sortie de pêche 1

                    $engin1Sortie1 = array(
                        'sortie_de_peche_enqueteur' => $idSortie1,
                        'engin'=> $res['IdEngin1Sortie1'],
                        'nombre'=> $res['NombreEngin1Sortie1']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin1Sortie1);
                    //engin 2 sortie de pêche 1

                    $engin2Sortie1 = array(
                        'sortie_de_peche_enqueteur' => $idSortie1,
                        'engin'=> $res['IdEngin2Sortie1'],
                        'nombre'=> $res['NombreEngin2Sortie1']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin2Sortie1);





                    //SORTIES DE PÊCHES 2

                    $mois2 = substr($res['DateSortie2'],3,2);
                    $annee2 = substr($res['DateSortie2'],6,4);
                    $jour2 = substr($res['DateSortie2'],0,2);

                    $dateSortie2 = $annee2."/".$mois2."/".$jour2;

                    $sortie2 = array(
                        'date'=> $dateSortie2,
                        'nombre'=> $res['NombreSortie2'],
                        'pirogue'=> $res['SortieAvecPirogue2'],
                        'fiche_enqueteur'=> $idFicheEnq
                    );

                    $this->db_fiche_enqueteur->inserer_sortie_de_peche($sortie2);
                    $idSortie2 = $this->db_fiche_enqueteur->lastSortie($sortie2);

                    //engin 1 sortie de pêche 2

                    $engin1Sortie2 = array(
                        'sortie_de_peche_enqueteur' => $idSortie2,
                        'engin'=> $res['IdEngin1Sortie2'],
                        'nombre'=> $res['NombreEngin1Sortie2']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin1Sortie2);
                    //engin 2 sortie de pêche 2

                    $engin2Sortie2 = array(
                        'sortie_de_peche_enqueteur' => $idSortie2,
                        'engin'=> $res['IdEngin2Sortie2'],
                        'nombre'=> $res['NombreEngin2Sortie2']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin2Sortie2);


                    //SORTIES DE PÊCHES 3

                    $mois3 = substr($res['DateSortie3'],3,2);
                    $annee3 = substr($res['DateSortie3'],6,4);
                    $jour3 = substr($res['DateSortie3'],0,2);

                    $dateSortie3 = $annee3."/".$mois3."/".$jour3;

                    $sortie3 = array(
                        'date'=> $dateSortie3,
                        'nombre'=> $res['NombreSortie3'],
                        'pirogue'=> $res['SortieAvecPirogue3'],
                        'fiche_enqueteur'=> $idFicheEnq
                    );

                    $this->db_fiche_enqueteur->inserer_sortie_de_peche($sortie3);
                    $idSortie3 = $this->db_fiche_enqueteur->lastSortie($sortie3);

                    //engin 1 sortie de pêche 3

                    $engin1Sortie3 = array(
                        'sortie_de_peche_enqueteur' => $idSortie3,
                        'engin'=> $res['IdEngin1Sortie3'],
                        'nombre'=> $res['NombreEngin1Sortie3']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin1Sortie3);
                    //engin 2 sortie de pêche 3

                    $engin2Sortie3 = array(
                        'sortie_de_peche_enqueteur' => $idSortie3,
                        'engin'=> $res['IdEngin2Sortie3'],
                        'nombre'=> $res['NombreEngin2Sortie3']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin2Sortie3);



                    //SORTIES DE PÊCHES 4

                    $mois4 = substr($res['DateSortie4'],3,2);
                    $annee4 = substr($res['DateSortie4'],6,4);
                    $jour4 = substr($res['DateSortie4'],0,2);

                    $dateSortie4 = $annee4."/".$mois4."/".$jour4;

                    $sortie4 = array(
                        'date'=> $dateSortie4,
                        'nombre'=> $res['NombreSortie4'],
                        'pirogue'=> $res['SortieAvecPirogue4'],
                        'fiche_enqueteur'=> $idFicheEnq
                    );

                    $this->db_fiche_enqueteur->inserer_sortie_de_peche($sortie4);
                    $idSortie4 = $this->db_fiche_enqueteur->lastSortie($sortie4);

                    //engin 1 sortie de pêche 4

                    $engin1Sortie4 = array(
                        'sortie_de_peche_enqueteur' => $idSortie4,
                        'engin'=> $res['IdEngin1Sortie4'],
                        'nombre'=> $res['NombreEngin1Sortie4']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin1Sortie4);
                    //engin 2 sortie de pêche 4

                    $engin2Sortie4 = array(
                        'sortie_de_peche_enqueteur' => $idSortie4,
                        'engin'=> $res['IdEngin2Sortie4'],
                        'nombre'=> $res['NombreEngin2Sortie4']
                    );

                    $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin2Sortie4);
                }
            }
            
        }

        echo json_encode(array('success'=>"success"), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
