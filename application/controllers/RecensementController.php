<?php

	

	class RecensementController extends ApplicationController {

		public function __construct() {

            parent::__construct();



			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);

			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
        }


    public function page_ajout_fiche(){
        // chargement de la vue d'insertion et modification dans une variable

            $this->root_states['title'] = 'Fiches des récensements';
            
            // redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
				'pages/saisie-fiche/recensement1.js'
            );
            
            $current_context_state = array(

                'zone_corecrabes' => $this->db_zone_corecrabe->liste(),
                'villages' => $this->db_village->liste(),
                'enqueteurs' => $this->db_enqueteur->liste_par_type('Enquêteur'),
				'droit_de_creation' => $this->lib_autorisation->creation_autorise(8)

			);
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif

            $etat_menu = array(

                'active_route' => 'recensement-ajout'

            );
            // rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

            $this->application_component['context_component'] = $this->load->view('saisie-fiche/recensement1.php', $current_context_state, true);
            // affichage du composant dans la vue de base

            $this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
            if ($this->lib_autorisation->visualisation_autorise(37))

				$this->load->view('index.php', $this->root_states, false);
    }

    public function insertion(){
        $enqueteur = null;
        $idcommune = null;
        $idfokontany = null;
        $idvillage = null;
        $data_nouveau = array(
            'nouveau_commune'=>$this->input->post('nouveau_commune'),
            'nouveau_fokontany'=>$this->input->post('nouveau_fokontany'),
            'nouveau_village'=>$this->input->post('nouveau_village'),
        );
        if($this->input->post('enqueteur')!=""){
            $enqueteur = $this->input->post('enqueteur');
        }
            $data = array(
                'zoneCorecrabe'=> $this->input->post('zoneCorecrabe'),
                'commune'=> $this->input->post('commune'),
                'fokontany'=> $this->input->post('fokontany'),
                'village'=> $this->input->post('village'),
                'date'=> $this->input->post('date'),
                'enqueteur'=> $enqueteur,
                'enquete'=> $this->input->post('enquete'),
            );
            //operation commune
        if(intval($data_nouveau['nouveau_commune'])==1){
            $existe_commune = $this->db_commune->existe($data['commune']);
            if($existe_commune){

               $idcommune =  $this->db_commune->recupere_par_nom($data['commune']);

            }
            else{
                $inserer_commune = array('nom'=>$data['commune']);
                $insertion_commune = $this->db_commune->inserer($inserer_commune) ;
                $idcommune = $this->db_commune->dernier_id();
            }

        }
        else{
            $idcommune = intval($data['commune']);
        }
        //operation fokontany

        if(intval($data_nouveau['nouveau_fokontany'])==1){
            $existe_fokontany = $this->db_fokontany->existe($idcommune,$data['fokontany']);
            if($existe_fokontany){

               $idfokontany =  $this->db_fokontany->recupere_par_nom( $idcommune,$data['fokontany']);

            }
            else{
                $inserer_fokontany = array('nom'=>$data['fokontany'],'commune'=>$idcommune);
                $insertion_fokontany = $this->db_fokontany->inserer($inserer_fokontany) ;
                $idfokontany= $this->db_fokontany->dernier_id();
            }

        }
        else{
            $idfokontany = intval($data['fokontany']);
        }
        //operation village

        if(intval($data_nouveau['nouveau_village'])==1){
            $existe_village = $this->db_village->existe_village($idfokontany, $data['village']);
            if($existe_village){

               $idvillage =  $this->db_village->recupere_par_nom_village($idfokontany, $data['village']);

            }
            else{
                $inserer_village = array('nom'=>$data['village'],'fokontany'=>$idfokontany);
                $insertion_village = $this->db_village->insert($inserer_village) ;
                $idvillage= $this->db_village->dernier_id();
            }

        }
        else{
            $idvillage = intval($data['village']);
        }

            // requisition des données du navigateur en le mettant dans leur conteneur respectifs

		 $fiche_existe = $this->db_recensement->existe(array(

		'village' => $idvillage,

		'date' => $data['date']


		 ));

		 if ($fiche_existe) {

		 	$numero_ordre = $this->db_recensement->dernier_numero_ordre(array(

                'village' => $idvillage,
        
                'date' => $data['date']
        
        
                 ))+1; 

		 } else {
            $numero_ordre = 1;
         }
            

		 	$fiche = array(
				

		 		'village' => $idvillage,

                'date' => $data['date'],

                'numero_ordre'=>$numero_ordre,

                'enqueteur' => $data['enqueteur'],

			);

             $insertion = $this->db_recensement->inserer($fiche);

             if($insertion){
                  $recensement = $this->db_recensement->dernier_id();
                  $data2 = array('recensement'=>$recensement,'enquete'=>$data['enquete']);
                  foreach($data2['enquete'] as $key=>$enquete_recensement){
                      $periode_mois = null;
                      $idpecheur = null;
                      $idvillage_origine=null;
                      $anneeActuel = intval(date('Y'));
                      if($enquete_recensement['periode_mois']!=null){
                          
                          $periode_mois= json_encode($enquete_recensement['periode_mois']) ;
                      }
                      $pecheur_data = array(
                          'resident'=>$enquete_recensement['resident'],
                          'nouveau_pecheur'=>$enquete_recensement['nouveau_pecheur'],
                          'nouveau_village_origine'=>$enquete_recensement['nouveau_village_origine'],
                          'age'=>$enquete_recensement['age'],
                          'sexe'=>$enquete_recensement['sexe'],
                      ) ;
                      if($pecheur_data['resident']==1){
                        if($pecheur_data['nouveau_pecheur']==0){
                            $idpecheur= $enquete_recensement['pecheur'];
                            $this->db_pecheur->mettre_a_jour(array('village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage,'village_activite'=>$idvillage), $idpecheur);

                        }
                        else{
                            $existe_pecheur = $this->db_pecheur->existe_nom($enquete_recensement['pecheur'],$idvillage);
                            if($existe_pecheur){
                                $idpecheur = $this->db_pecheur->recupere_par_nom( $enquete_recensement['pecheur'],$idvillage);
                                $this->db_pecheur->mettre_a_jour(array('sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village'=>$idvillage,'village_origine'=>$idvillage,'village_activite'=>$idvillage), $idpecheur);
                            }
                            else{
                                $this->db_pecheur->inserer(array('nom'=>$enquete_recensement['pecheur'],'village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage,'village_activite'=>$idvillage));
                                $idpecheur= $this->db_pecheur->dernier_id();
                            }
                            
                        }
                      }
                      else{

                        if($pecheur_data['nouveau_village_origine']==0){
                            $idvillage_origine= $enquete_recensement['village_origine'];
                            

                        }

                        else{
                            $existe_origine = $this->db_village->existe($enquete_recensement['village_origine']);
                            if($existe_origine){
                                $idvillage_origine =  $this->db_village->recupere_par_nom($enquete_recensement['village_origine']);
                            }
                            else{
                                $this->db_village->insert(array('nom'=>$enquete_recensement['village_origine']));
                                $idvillage_origine= $this->db_village->dernier_id();
                            }
                            
                        }
                        if($pecheur_data['nouveau_pecheur']==0){
                            $idpecheur= $enquete_recensement['pecheur'];
                            $this->db_pecheur->mettre_a_jour(array('village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage_origine,'village_activite'=>$idvillage), $idpecheur);

                        }
                        else{
                            $existe_pecheur_origine = $this->db_pecheur->existe_nom_origine( $enquete_recensement['pecheur'],$idvillage,$idvillage_origine) ;
                            if($existe_pecheur_origine){
                                $idpecheur = $this->db_pecheur->recupere_par_nom_origine( $enquete_recensement['pecheur'],$idvillage,$idvillage_origine);
                                $this->db_pecheur->mettre_a_jour(array('village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage_origine,'village_activite'=>$idvillage), $idpecheur);
                            } 
                            else{
                                $this->db_pecheur->inserer(array('nom'=>$enquete_recensement['pecheur'],'village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage_origine,'village_activite'=>$idvillage));
                                $idpecheur= $this->db_pecheur->dernier_id();
                            }
                            
                        }

                      }

                      $data_enquete= array(
                          'recensement'=>$data2['recensement'],
                          'resident'=>$enquete_recensement['resident'],
                          'pecheur'=>$idpecheur,
                          'pirogue'=>$enquete_recensement['pirogue'],
                          'toute_annee'=>$enquete_recensement['toute_annee'],
                          'type_periode'=>$enquete_recensement['periode_mare'],
                          'type_mare'=>$enquete_recensement['type_mare'],
                          'periode_mois'=>$periode_mois,
                      );
                      $insertion_enquete = $this->db_enquete_recensement->inserer($data_enquete);
                      if($insertion_enquete)
                      {
                          $dernier_id = $this->db_enquete_recensement->dernier_id(); 
                          if($enquete_recensement['activite']['activite1'] !=null&& $enquete_recensement['activite']['pourcentage1'] !=null ){
                            $dataActivite1 = array('activite'=>$enquete_recensement['activite']['activite1'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$enquete_recensement['activite']['pourcentage1']);
                            $this->db_activite->inserer_activite_enquete_recensement($dataActivite1);
                          }
                          
                          if($enquete_recensement['activite']['activite2'] !=null&& $enquete_recensement['activite']['pourcentage2'] !=null ){
                            $dataActivite2 = array('activite'=>$enquete_recensement['activite']['activite2'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$enquete_recensement['activite']['pourcentage2']);
                            $this->db_activite->inserer_activite_enquete_recensement($dataActivite2);
                        }
                        if($enquete_recensement['activite']['activite3'] !=null&& $enquete_recensement['activite']['pourcentage3'] !=null ){
                            $dataActivite3 = array('activite'=>$enquete_recensement['activite']['activite3'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$enquete_recensement['activite']['pourcentage3']);
                            $this->db_activite->inserer_activite_enquete_recensement($dataActivite3);
                        }

                        if($enquete_recensement['engins']['engin1'] !=null&& $enquete_recensement['engins']['annee1'] !=null){
                            $dataEngin1 = array('engin'=>$enquete_recensement['engins']['engin1'],'enquete_recensement'=>$dernier_id,'annee'=>$enquete_recensement['engins']['annee1']);
                            $this->db_engin->inserer_engin_enqute_recensement($dataEngin1);
                        }
                        if($enquete_recensement['engins']['engin2'] !=null&& $enquete_recensement['engins']['annee2'] !=null){
                            $dataEngin2 = array('engin'=>$enquete_recensement['engins']['engin2'],'enquete_recensement'=>$dernier_id,'annee'=>$enquete_recensement['engins']['annee2']);
                            $this->db_engin->inserer_engin_enqute_recensement($dataEngin2); 
                        }
                        
                      }else echo json_encode(array('result' => false,'title'=>'Erreur non identifié', 'message' => 'Une erreur de serveur a été observée, veuillez vous réferrer à l\'administrateur de la base'));
                      
                  }
                 $archive = $this->db_recensement->selection_par_id($recensement);
                 $numFiche = $archive['nomVillage'].'/'.$archive['date'].'/'.$archive['numero_ordre'];
                 $this->db_historique->archiver("Insertion", "Insertion d'une nouvelle fiche de recensement N° 5: ".$numFiche);
                echo json_encode(array('result' => TRUE, 'message' => 'Les données sont ajoutées avec succès', 'title' => 'Succès', 'fiche' => $recensement));
            }else echo json_encode(array('result' => false,'title'=>'Erreur non identifié', 'message' => 'Une erreur de serveur a été observée, veuillez vous réferrer à l\'administrateur de la base'));

         
        
    }

    public function insertion_manquant(){

                  $recensement_info = $this->db_recensement->selection_par_id($_POST['recensement']);
                  $idvillage = $recensement_info['village'];
                  $recensement = $recensement_info['id'];
                      $periode_mois = null;
                      $idpecheur = null;
                      $idvillage_origine=null;
                      $anneeActuel = intval(date('Y'));
                      $val_periodemois = $_POST['periode_mois'];
                      if($val_periodemois != null || $val_periodemois !='' ){
                          
                          $periode_mois= json_encode($_POST['periode_mois']) ;
                      }
                      $pecheur_data = array(
                          'resident'=>$_POST['resident'],
                          'nouveau_pecheur'=>$_POST['nouveau_pecheur'],
                          'nouveau_village_origine'=>$_POST['nouveau_village_origine'],
                          'age'=>$_POST['age'],
                          'sexe'=>$_POST['sexe'],
                      ) ;
                      if($pecheur_data['resident']==1){
                        if($pecheur_data['nouveau_pecheur']==0){
                            $idpecheur= $_POST['pecheur'];
                            $this->db_pecheur->mettre_a_jour(array('sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage,'village_activite'=>$idvillage), $idpecheur);

                        }
                        else{

                            $existe_pecheur = $this->db_pecheur->existe_nom($_POST['pecheur'],$idvillage);
                            if($existe_pecheur){
                                $idpecheur =  $this->db_pecheur->recupere_par_nom($_POST['pecheur'],$idvillage);
                                $this->db_pecheur->mettre_a_jour(array('village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage,'village_activite'=>$idvillage), $idpecheur);
                            }
                            else{
                                $this->db_pecheur->inserer(array('nom'=>$_POST['pecheur'],'village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage,'village_activite'=>$idvillage));
                               $idpecheur= $this->db_pecheur->dernier_id();
                            }
                            
                            
                        }
                      }
                      else{

                        if($pecheur_data['nouveau_village_origine']==0){
                            $idvillage_origine= $_POST['village_origine'];
                        
                        }

                        else{
                            $existe_origine = $this->db_village->existe($_POST['village_origine']);
                            if($existe_origine){
                                $idvillage_origine =  $this->db_village->recupere_par_nom($_POST['village_origine']);
                            }
                            else{
                                $this->db_village->insert(array('nom'=>$_POST['village_origine']));
                                $idvillage_origine= $this->db_village->dernier_id();
                            }
                            
                        }
                        if($pecheur_data['nouveau_pecheur']==0){
                            $idpecheur= $_POST['pecheur'];
                            $this->db_pecheur->mettre_a_jour(array('village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage_origine,'village_activite'=>$idvillage), $idpecheur);

                        }
                        else{
                            $existe_pecheur_origine = $this->db_pecheur->existe_nom_origine( $_POST['pecheur'],$idvillage,$idvillage_origine) ;
                            if($existe_pecheur_origine){
                                $idpecheur =  $this->db_pecheur->recupere_par_nom_origine($_POST['pecheur'],$idvillage,$idvillage_origine);
                                $this->db_pecheur->mettre_a_jour(array('village'=>$idvillage, 'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage_origine,'village_activite'=>$idvillage), $idpecheur);
                            }
                            else{
                                $this->db_pecheur->inserer(array('nom'=>$_POST['pecheur'],'village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage_origine,'village_activite'=>$idvillage));
                                $idpecheur= $this->db_pecheur->dernier_id();
                            }
                            
                        }

                      }

                      $data_enquete= array(
                          'recensement'=>$recensement,
                          'resident'=>$_POST['resident'],
                          'pecheur'=>$idpecheur,
                          'pirogue'=>$_POST['pirogue'],
                          'toute_annee'=>$_POST['toute_annee'],
                          'type_periode'=>$_POST['periode_mare'],
                          'type_mare'=>$_POST['type_mare'],
                          'periode_mois'=>$periode_mois,
                      );
                      $insertion_enquete = $this->db_enquete_recensement->inserer($data_enquete);
                      if($insertion_enquete)
                      {
                          $dernier_id = $this->db_enquete_recensement->dernier_id(); 
                          if($_POST['activite']['activite1'] !=null&& $_POST['activite']['pourcentage1'] !=null ){
                            $dataActivite1 = array('activite'=>$_POST['activite']['activite1'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$_POST['activite']['pourcentage1']);
                            $this->db_activite->inserer_activite_enquete_recensement($dataActivite1);
                          }
                          
                          if($_POST['activite']['activite2'] !=null&& $_POST['activite']['pourcentage2'] !=null ){
                            $dataActivite2 = array('activite'=>$_POST['activite']['activite2'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$_POST['activite']['pourcentage2']);
                            $this->db_activite->inserer_activite_enquete_recensement($dataActivite2);
                        }
                        if($_POST['activite']['activite3'] !=null&& $_POST['activite']['pourcentage3'] !=null ){
                            $dataActivite3 = array('activite'=>$_POST['activite']['activite3'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$_POST['activite']['pourcentage3']);
                            $this->db_activite->inserer_activite_enquete_recensement($dataActivite3);
                        }

                        if($_POST['engins']['engin1'] !=null&& $_POST['engins']['annee1'] !=null){
                            $dataEngin1 = array('engin'=>$_POST['engins']['engin1'],'enquete_recensement'=>$dernier_id,'annee'=>$_POST['engins']['annee1']);
                            $this->db_engin->inserer_engin_enqute_recensement($dataEngin1);
                        }
                        if($_POST['engins']['engin2'] !=null&& $_POST['engins']['annee2'] !=null){
                            $dataEngin2 = array('engin'=>$_POST['engins']['engin2'],'enquete_recensement'=>$dernier_id,'annee'=>$_POST['engins']['annee2']);
                            $this->db_engin->inserer_engin_enqute_recensement($dataEngin2); 
                        }

                        echo json_encode(array('result' => TRUE, 'message' => 'Les données sont ajoutées avec succès', 'title' => 'Succès', 'fiche' => $recensement));
                        
                      }else echo json_encode(array('result' => false,'title'=>'Erreur non identifié', 'message' => 'Une erreur de serveur a été observée, veuillez vous réferrer à l\'administrateur de la base'));
                      
    
                    }

    public function page_ajout_fiche_manquant($recensement){
       

        // chargement de la vue d'insertion et modification dans une variable

        $this->root_states['title'] = 'Fiches des récensements';
            
        // redéfinition des paramètres parents pour l'adapter à la vue courante

        $this->root_states['custom_javascripts'] = array(
            'select2.full.min.js',
            'pages/saisie-fiche/recensement-manquant.js'
        );

        $information_enquete = $this->db_recensement->selection_par_id($recensement);
        $pecheurs= $this->db_pecheur->liste_par_village_origine_non_recenser($information_enquete['village']);
        $num = $information_enquete['nomVillage'].'/'.$information_enquete['date'].'/'.$information_enquete['numero_ordre'];
        
        $current_context_state = array(
            'num'=>$num,
             'anneecourant'=>intval(date('Y')),
            'recensement' => $information_enquete,
            'pecheurs' => $pecheurs,
            'activites' =>$this->db_activite->liste(),
            'engins'=>$this->db_engin->liste(),
            'villages'=>$this->db_village->liste(),
            'autorisation_creation' => $this->lib_autorisation->creation_autorise(8)

        );
        // précision du route courant afin d'ajouter la "classe" active au lien du composant actif

        $etat_menu = array(

            'active_route' => 'saisie-de-recensement'

        );
        // rassembler les vues chargées

        $this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

        $this->application_component['context_component'] = $this->load->view('saisie-fiche/recensement-manquant.php', $current_context_state, true);
        // affichage du composant dans la vue de base

        $this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
        if ($this->lib_autorisation->visualisation_autorise(37))

            $this->load->view('index.php', $this->root_states, false);

    }


    public function page_modification_fiche($recensement){

        // chargement de la vue d'insertion et modification dans une variable

        $this->root_states['title'] = 'Fiches des récensements';
            
        // redéfinition des paramètres parents pour l'adapter à la vue courante

        $this->root_states['custom_javascripts'] = array(
            'select2.full.min.js',
            'pages/modification-fiche/recensement1.js'
        );

        $recensement =$this->db_recensement->selection_par_id($recensement);
        
        $current_context_state = array(

            'recensement' => $recensement,
            'enqueteurs' => $this->db_enqueteur->liste_par_tous_village($recensement['village']),
            'droit_de_creation' => $this->lib_autorisation->creation_autorise(8)

        );
        // précision du route courant afin d'ajouter la "classe" active au lien du composant actif

        $etat_menu = array(

            'active_route' => 'consultation-de-fiche-recensement'

        );
        // rassembler les vues chargées

        $this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

        $this->application_component['context_component'] = $this->load->view('modification-fiche/recensement1.php', $current_context_state, true);
        // affichage du composant dans la vue de base

        $this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
        if ($this->lib_autorisation->visualisation_autorise(37))

            $this->load->view('index.php', $this->root_states, false);

    }


    public function page_modification_enquete($enquete){
       

        // chargement de la vue d'insertion et modification dans une variable

        $this->root_states['title'] = 'Fiches des récensements';
            
        // redéfinition des paramètres parents pour l'adapter à la vue courante

        $this->root_states['custom_javascripts'] = array(
            'select2.full.min.js',
            'pages/modification-fiche/enquete-recensement1.js'
        );

        $enquete = $this->db_enquete_recensement->selection_par_id($enquete);
        $enquete['recensement']= $this->db_recensement->selection_par_id($enquete['recensement']);
        $enquete['activite'] = $this->db_enquete_recensement->selection_par_activite_recensement($enquete['id']);
        $enquete['engins'] = $this->db_enquete_recensement->selection_par_engin_recensement($enquete['id']);
        $num = $enquete['recensement']['nomVillage'].'/'.$enquete['recensement']['date'].'/'.$enquete['recensement']['numero_ordre'];
        $idvillage_pecheur = $enquete['recensement']['village'];
        if($enquete['pecheur_village_origine']==$enquete['pecheur_village_activite']){
            $resident=1;
        }
        else{
            $resident=0; 
            // $idvillage_pecheur=$enquete['pecheur_village_origine']; 
        }
        $enquete['resident']=$resident;
        $current_context_state = array(
            'enquete'=>$enquete,
            'anneecourant'=>intval(date('Y')),
            'activites' =>$this->db_activite->liste(),
            'engins'=>$this->db_engin->liste(),
            'villages'=>$this->db_village->liste(),
            'pecheurs'=>$this->db_pecheur->liste_par_village($idvillage_pecheur),
            'num'=>$num,
            
        );
        // précision du route courant afin d'ajouter la "classe" active au lien du composant actif

        $etat_menu = array(

            'active_route' => 'consultation-de-fiche-recensement'

        );
        // rassembler les vues chargées

        $this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

        $this->application_component['context_component'] = $this->load->view('modification-fiche/enquete-recensement1.php', $current_context_state, true);
        // affichage du composant dans la vue de base

        $this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
        if ($this->lib_autorisation->visualisation_autorise(37))

            $this->load->view('index.php', $this->root_states, false);

    }


    public function page_detail_enquete($fiche){
        $recensement = $this->db_recensement->selection_par_id($fiche);
        $enquetes = $this->db_enquete_recensement->get_enquetes($fiche);
        $numRecensement = $recensement['nomVillage'].'/'.$recensement['date'].'/'.$recensement['numero_ordre'];

         foreach($enquetes as $iteration_enquete => $enquete){
            $enquetes[$iteration_enquete]["activites"] = $this->db_enquete_recensement->selection_par_activite_recensement($enquete["id"]);
            $enquetes[$iteration_enquete]["engins"] = $this->db_enquete_recensement->selection_par_engin_recensement($enquete["id"]);
           
        }

			$this->root_states['title'] = 'fiche de recensment N°:'.$numRecensement;

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				 'pages/consultation-fiche/recensement-detail1.js'

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-recensement'

			);

			

			// $session_enqueteur = $this->session->userdata('enqueteur');

			$context_state = array(

				'recensement' => $recensement,

                'enquetes' => $enquetes,
                
                'num' => $numRecensement,

                'mois_francais' => $this->mois_francais,


				// 'max_enquete' => self::FICHE_MAX,

				'autorisation_creation' => $this->lib_autorisation->creation_autorise(39),

				'autorisation_modification' => $this->lib_autorisation->modification_autorise(39),

				'autorisation_suppression' => $this->lib_autorisation->suppression_autorise(39),

				// 'enqueteur_responsable' => ($session_enqueteur == null || intval($session_enqueteur['id']) === intval($fiche_bd['enqueteur']))

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('consultation-fiche/recensement-detail1.php', $context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

			$this->db_historique->archiver("Visite", "Consultation de la fiche de récensement N° 5 de code: ".$numRecensement);
    }

    public function page_consultation(){
        $this->root_states['title'] = 'Consultation de fiche des recensments';

        // redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/consultation-fiche/recensementPage.js'

            );
            // précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-recensement'

            );
            
            // rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

            $this->application_component['context_component'] = $this->load->view('consultation-fiche/recensement_page.php', null, true);
            
            // affichage du composant dans la vue de base

            $this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
            // importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);
    }


    public function operation_datatable() {
        // requisition des données à afficher avec les contraintes
           
			$data_query = $this->db_recensement->datatable($_POST);

			// chargement des données formatées

			$data = array();
 
			foreach ($data_query as $query_result) {

                $bouton_details = $this->lib_autorisation->modification_autorise(11) ? '<a class="btn btn-default update-button" href="'.base_url("consultation-de-recensement/detail-et-action/").$query_result['id'].'">Details</a>' : '';

                $bouton_modification = $this->lib_autorisation->modification_autorise(11) ? '<a class="btn btn-default update-button" data-target="#update-modal" href="'.base_url("consultation-de-recensement/modification/").$query_result['id'].'"  id="update-' . $query_result['id'] . '">Modifier</a>' : '';

				$bouton_suppression = $this->lib_autorisation->suppression_autorise(11) ? '<button class="btn btn-default delete-button"  data-target="' . $query_result['id'] . '">Supprimer</button>' : '';

				$data[] = array(

					$query_result['code'],
					$query_result['enqueteur'],

                    '<div class="btn-group">
                        ' . $bouton_details . '

						' . $bouton_modification . '

						' . $bouton_suppression . '

					</div>',

				);

			}

			echo json_encode(array(

				'draw' => intval($this->input->post('draw')),

				'recordsTotal' => $this->db_recensement->records_total(),

				'recordsFiltered' => $this->db_recensement->records_filtered($_POST),

				'data' => $data

			));
		
    }

    public function operation_mise_a_jour() {

        $recensement_info = $this->db_recensement->selection_par_id($_POST['recensement']);
        $information_enquete = $this->db_enquete_recensement->selection_par_id($_POST['enquete_recensement']);
        $idvillage = $recensement_info['village'];
        $recensement = $recensement_info['id'];
        $periode_mois = null;
        $idpecheur = null;
        $idvillage_origine=null;
        $anneeActuel = intval(date('Y'));
            if($_POST['periode_mois']!=null){
                
                $periode_mois= json_encode($_POST['periode_mois']) ;
            }
            $pecheur_data = array(
                'resident'=>$_POST['resident'],
                'nouveau_pecheur'=>$_POST['nouveau_pecheur'],
                'nouveau_village_origine'=>$_POST['nouveau_village_origine'],
                'age'=>$_POST['age'],
                'sexe'=>$_POST['sexe'],
            ) ;
            if($pecheur_data['resident']==1){
              if($pecheur_data['nouveau_pecheur']==0){
                  $idpecheur= $_POST['pecheur'];
                  $this->db_pecheur->mettre_a_jour(array('sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage,'village_activite'=>$idvillage), $idpecheur);

              }
              else{
                  
                  $this->db_pecheur->inserer(array('nom'=>$_POST['pecheur'],'village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage,'village_activite'=>$idvillage));
                  $idpecheur= $this->db_pecheur->dernier_id();
              }
            }
            else{

              if($pecheur_data['nouveau_village_origine']==0){
                  $idvillage_origine= $_POST['village_origine'];
              
              }

              else{
                  $existe_origine = $this->db_village->existe($_POST['village_origine']);
                  if($existe_origine){
                      $idvillage_origine =  $this->db_village->recupere_par_nom($_POST['village_origine']);
                  }
                  else{
                      $this->db_village->insert(array('nom'=>$_POST['village_origine']));
                      $idvillage_origine= $this->db_village->dernier_id();
                  }
                  
              }
              if($pecheur_data['nouveau_pecheur']==0){
                  $idpecheur= $_POST['pecheur'];
                  $this->db_pecheur->mettre_a_jour(array('village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage_origine,'village_activite'=>$idvillage), $idpecheur);

              }
              else{
                  $this->db_pecheur->inserer(array('nom'=>$_POST['pecheur'],'village'=>$idvillage,'sexe'=>$pecheur_data['sexe'],'datenais'=>$anneeActuel-intval($pecheur_data['age']),'village_origine'=>$idvillage_origine,'village_activite'=>$idvillage));
                  $idpecheur= $this->db_pecheur->dernier_id();
              }

            }

            $data_enquete= array(
                'recensement'=>$recensement_info['id'],
                'resident'=>$_POST['resident'],
                'pecheur'=>$idpecheur,
                'pirogue'=>$_POST['pirogue'],
                'toute_annee'=>$_POST['toute_annee'],
                'type_periode'=>$_POST['periode_mare'],
                'type_mare'=>$_POST['type_mare'],
                'periode_mois'=>$periode_mois,
            );
            $mise_a_jour_enquete = $this->db_enquete_recensement->mettre_a_jour($information_enquete['id'], $data_enquete);
            if($mise_a_jour_enquete)
            {
                $this->db_activite->supprimer_enquete_activite_recensement($information_enquete['id']);
                $this->db_engin->supprimer_engin_enquete_recensement($information_enquete['id']);
                $dernier_id = $information_enquete['id']; 
                if($_POST['activite']['activite1'] !=null&& $_POST['activite']['pourcentage1'] !=null ){
                  $dataActivite1 = array('activite'=>$_POST['activite']['activite1'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$_POST['activite']['pourcentage1']);
                  $this->db_activite->inserer_activite_enquete_recensement($dataActivite1);
                }
                
                if($_POST['activite']['activite2'] !=null&& $_POST['activite']['pourcentage2'] !=null ){
                  $dataActivite2 = array('activite'=>$_POST['activite']['activite2'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$_POST['activite']['pourcentage2']);
                  $this->db_activite->inserer_activite_enquete_recensement($dataActivite2);
              }
              if($_POST['activite']['activite3'] !=null&& $_POST['activite']['pourcentage3'] !=null ){
                  $dataActivite3 = array('activite'=>$_POST['activite']['activite3'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$_POST['activite']['pourcentage3']);
                  $this->db_activite->inserer_activite_enquete_recensement($dataActivite3);
              }

              if($_POST['engins']['engin1'] !=null&& $_POST['engins']['annee1'] !=null){
                  $dataEngin1 = array('engin'=>$_POST['engins']['engin1'],'enquete_recensement'=>$dernier_id,'annee'=>$_POST['engins']['annee1']);
                  $this->db_engin->inserer_engin_enqute_recensement($dataEngin1);
              }
              if($_POST['engins']['engin2'] !=null&& $_POST['engins']['annee2'] !=null){
                  $dataEngin2 = array('engin'=>$_POST['engins']['engin2'],'enquete_recensement'=>$dernier_id,'annee'=>$_POST['engins']['annee2']);
                  $this->db_engin->inserer_engin_enqute_recensement($dataEngin2); 
              }

              echo json_encode(array('result' => TRUE, 'message' => 'Les données sont ajoutées avec succès', 'title' => 'Succès', 'fiche' => $recensement_info['id']));
              
            }else echo json_encode(array('result' => false,'title'=>'Erreur non identifié', 'message' => 'Une erreur de serveur a été observée, veuillez vous réferrer à l\'administrateur de la base'));
            
        

}

            public function operation_mise_a_jour_fiche(){

                $recensement = $_POST['recensement'];

                $recensement_info = $this->db_recensement->selection_par_id($recensement);
                $fiche_existe = $this->db_recensement->existe(array(

                    'village' => $recensement_info['village'],
            
                    'date' => $_POST['date']
            
            
                     ));
            
                     if ($fiche_existe) {

                        if($recensement_info['date'] == $_POST['date']){
                            $numero_ordre = $recensement_info['numero_ordre']; 
                        }

                        else{
                            $numero_ordre = $this->db_recensement->dernier_numero_ordre(array(
            
                                'village' => $recensement_info['village'],
                        
                                'date' => $_POST['date']
                        
                        
                                 ))+1; 
                        }
                         
            
                     } else {
                        $numero_ordre = 1;
                     }

                $enqueteur= $_POST['enqueteur'];
                if($_POST['enqueteur']==''){
                    $enqueteur= null;
                }
                $data = array(
                    'date'=>$_POST['date'],
                    'numero_ordre'=>$numero_ordre,
                    'enqueteur'=>$enqueteur
            );
                $update = $this->db_recensement->update($data,$recensement);
                if($update){
                    echo json_encode(array('result' => TRUE, 'message' => 'Les données sont modifiées avec succès', 'title' => 'Succès', 'fiche' => $recensement));
                }
            }
                
                public function operation_suppression($id){
                    echo json_encode($this->db_recensement->supprimer($id));
                }

                public function operation_suppression_enquete($id){
                    echo json_encode($this->db_enquete_recensement->supprimer($id)); 
                }

                // public function ordonnes_resident(){
                //     $enquetes = $this->db_enquete_recensement->ordonnes_resident();
                //     $erreur_survenu = false;
                //     foreach($enquetes as $enquete)
                //     {
                //         $mise_a_jour_enquete = $this->db_enquete_recensement->mettre_a_jour($enquete['id'], array('resident'=>0));
                //         if(!$mise_a_jour_enquete){
                //             $erreur_survenu = true;
                //         }
                //     }
                //     if($erreur_survenu){
                //         echo json_encode("erreur");
                //     }
                //     else{
                //         $enquetess = $this->db_enquete_recensement->ordonnes_resident();
                //         echo json_encode("success"); 
                //     }
                // }


}
