<?php

class ImportController extends ApplicationController {
    public function __construct() {
        parent::__construct();
    }

    public function enqueteur(){
        // redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Importer des données sur excel/csv dans la base (Suivi Villageois)";
			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
                'pages/import/import-enqueteur.js'
            );
        // Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
            
            $current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(30),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(30)
            );
            
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'import-enqueteur'
            );
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
            $this->application_component['context_component'] = $this->load->view('import/import-enqueteur.php', $current_context_state, true);
            
            // affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(30))
				$this->load->view('index.php', $this->root_states, false);
			
    }

    public function recup(){
        // redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "";
			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
                'pages/import/recup.js'
            );
        // Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
            
            $current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(30),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(30)
            );
            
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'recup'
            );
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
            $this->application_component['context_component'] = $this->load->view('import/recup.php', $current_context_state, true);
            
            // affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(30))
				$this->load->view('index.php', $this->root_states, false);
			
    }
    public function enqueteur_2(){
        // redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Importer des données sur excel/csv dans la base (Suivi Villageois (récupération))";
			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
                'pages/import/import-enqueteur-2.js'
            );
        // Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
            
            $current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(30),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(30)
            );
            
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'import-enqueteur-2'
            );
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
            $this->application_component['context_component'] = $this->load->view('import/import-enqueteur-2.php', $current_context_state, true);
            
            // affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(30))
				$this->load->view('index.php', $this->root_states, false);
			
    }
    public function acheteur(){
        // redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Importer des données sur excel/csv dans la base (Suivi Volontaire)";
			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
                'pages/import/import-acheteur.js'
            );
        // Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
            
            $current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(30),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(30)
            );
            
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'import-acheteur'
            );
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
            $this->application_component['context_component'] = $this->load->view('import/import-acheteur.php', $current_context_state, true);
            
            // affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(30))
				$this->load->view('index.php', $this->root_states, false);
			
    }

    public function acheteur_2(){
        // redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Importer des données sur excel/csv dans la base (Suivi Volontaire (récupération))";
			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
                'pages/import/import-acheteur-2.js'
            );
        // Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
            
            $current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(30),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(30)
            );
            
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'import-acheteur-2'
            );
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
            $this->application_component['context_component'] = $this->load->view('import/import-acheteur-2.php', $current_context_state, true);
            
            // affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(30))
				$this->load->view('index.php', $this->root_states, false);
			
    }



	public function recensement_5(){
        // redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Importer des données sur excel/csv dans la base (Suivi recensement N°5)";
			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
                'pages/import/import-recensement-5.js'
            );
        // Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
            
            $current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(30),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(30)
            );
            
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'import-recensement-5'
            );
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
            $this->application_component['context_component'] = $this->load->view('import/import-recensement-5.php', $current_context_state, true);
            
            // affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(30))
				$this->load->view('index.php', $this->root_states, false);
			
    }


    public function recensement_6(){
        // redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Importer des données sur excel/csv dans la base (Suivi recensement N°6)";
			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
                'pages/import/import-recensement-6.js'
            );
        // Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
            
            $current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(30),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(30)
            );
            
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'import-recensement-6'
            );
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
            $this->application_component['context_component'] = $this->load->view('import/import-recensement-6.php', $current_context_state, true);
            
            // affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(30))
				$this->load->view('index.php', $this->root_states, false);
			
    }

public function recovery(){
        // redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Recovery";
			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
                'pages/import/recovery.js'
            );
        // Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
            
            $current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(30),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(30)
            );
            
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'recovery'
            );
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
            $this->application_component['context_component'] = $this->load->view('import/recovery.php', $current_context_state, true);
            
            // affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(30))
				$this->load->view('index.php', $this->root_states, false);
			
    }


public function date_recovery(){
        // redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Recovery";
			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
                'pages/import/date_recovery.js'
            );
        // Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
            
            $current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(30),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(30)
            );
            
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'recovery'
            );
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
            $this->application_component['context_component'] = $this->load->view('import/date_recovery.php', $current_context_state, true);
            
            // affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(30))
				$this->load->view('index.php', $this->root_states, false);
			
    }


    public function do_recovery(){
        if(is_uploaded_file($_FILES['fichier']['tmp_name'])){
            $this->load->library('Excel');
            $this->load->model('ImportModel','im');
            $erreur = null;
            $titre = null;
            $object = PHPExcel_IOFactory::load($_FILES['fichier']['tmp_name']);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2;$row<=$highestRow; $row++){
                    $date_excel = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $nb = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $prg = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $linux_time = ($date_excel-25569)*86400; 
                    $date = date("Y-m-d",$linux_time);
		    $i = 0;
                    if(count($this->im->check($id,$date))>0){
                        $this->im->do_recovery($id,$date,$nb,$prg);
			$i=$i+1;
                    }
                    
                }
            }
            echo json_encode(array('result'=>true, 'message'=>"Le téléversement des données a été un succès! $i",'titre'=>"Succès"));
        }else{
            echo json_encode(array('result'=>false, 'message'=>"Veuillez choisir votre fichier",'titre'=>"Erreur"));
        }
    }

    public function recuperer(){
        if(is_uploaded_file($_FILES['fichier']['tmp_name'])){
            $this->load->library('Excel');
            $this->load->model('ImportModel','im');
            $object = PHPExcel_IOFactory::load($_FILES['fichier']['tmp_name']);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2;$row<=$highestRow; $row++){
                    $idzone = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $zone = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $idvillage = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $suivi = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $village = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $village = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                }
            }
        }else{
            echo json_encode(array('result'=>false, 'message'=>"Veuillez choisir votre fichier",'titre'=>"Erreur"));
        }
    }

public function do_date_recovery(){
        if(is_uploaded_file($_FILES['fichier']['tmp_name'])){
            $this->load->library('Excel');
            $this->load->model('ImportModel','im');
            $erreur = null;
            $titre = null;
            $object = PHPExcel_IOFactory::load($_FILES['fichier']['tmp_name']);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2;$row<=$highestRow; $row++){
                    $date_excel = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $linux_time = ($date_excel-25569)*86400; 
                    $date = date("Y-m-d",$linux_time);
                    if(count($this->im->check_fiche_acheteur($id))>0){
                        $date = $this->im->get_fiche_date($id)['date'];
                        $sortie = $this->im->get_sortie_acheteur($id);
                        if(count($sortie)>0){
                            $i = 0;
                            foreach($sortie as $s){
                                $date_updated = date_format(date_sub(date_create($date), date_interval_create_from_date_string("$i days")),"Y-m-d");
                                //$this->im->update_date($s['id'], $date_updated);
                                $titre = "( ".$s['id']." ".$date_updated." ".$id." )";
                                $i=$i+1;
                            }
                        }
                    }
                    
                }
            }
            echo json_encode(array('result'=>true, 'message'=>"Le téléversement des données a été un succès! $titre",'titre'=>"Succès"));
        }else{
            echo json_encode(array('result'=>false, 'message'=>"Veuillez choisir votre fichier",'titre'=>"Erreur"));
        }
    }


    public function import_recensement_6(){
        if(is_uploaded_file($_FILES['fichier']['tmp_name'])){
            $this->load->library('Excel');
            $this->load->model('ImportModel','im');
            $erreur = null;
            $titre = null;
            $object = PHPExcel_IOFactory::load($_FILES['fichier']['tmp_name']);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2;$row<=$highestRow; $row++){
                    $date_excel = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $village_nom = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $pecheur_id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $linux_time = ($date_excel-25569)*86400; 
                    $date = date("Y-m-d",$linux_time); 
                    $village_id = $this->im->get_village_id($village_nom)['id'];
                    for($i=4;$i<=10;$i++){
                        $annee = 2021;
                        $activite = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
                        $mois = 12;
                        $insert = false;
                        if($activite != null && $activite != ''){
                            if($i != 4){
                                $mois = $i-4;
                                $annee = 2022;
                            }
                            $recensement = array(
                                'village'=>$village_id,
                                'annee'=>$annee,
                                'mois'=>$mois
                            );
                            $id_recensement = null;
                            if(count($this->im->get_recensement_mensuel($recensement))>0){
                                $id_recensement = $this->im->get_recensement_mensuel($recensement)[0]['id'];
                            }else{
                                $recensement_bis = array(
                                    'village'=>$village_id,
                                    'annee'=>$annee,
                                    'mois'=>$mois,
                                    'date'=>$date
                                );
                                $this->im->insert_recensement_mensuel($recensement_bis);
                                $insert = true;
                                $id_recensement = $this->im->get_recensement_mensuel($recensement)[0]['id'];
                            }
                            $crabe = 1;
                            if(strtoupper($activite) != 'CRABE'){
                                $crabe = 0;
                            }


                            $check_enquete = array(
                                'pecheur'=>$pecheur_id,
                                'recensement_mensuel'=>$id_recensement
                            );
                            if(count($this->im->get_enquete_recensement_mensuel($check_enquete))==0){
                                $enquete = array(
                                    'pecheur'=>$pecheur_id,
                                    'crabe'=>$crabe,
                                    'recensement_mensuel'=>$id_recensement,
                                    'source'=>0
                                );
                                $this->im->insert_enquete_recensement_mensuel($enquete);
                                $id_enquete = $this->im->get_enquete_recensement_mensuel($check_enquete)[0]['id'];
                                $id_act = $this->im->get_id_act(strtoupper($activite))[0]['id'];
                                $data_act = array(
                                    'enquete_recensement_mensuel'=>$id_enquete,
                                    'activite'=> $id_act,
                                    'pourcentage'=> 100
                                );
                                $this->im->insert_activite_recensement_mensuel($data_act);
                            }

                        }

                    }
                }
            }
        }else{
            echo json_encode(array('result'=>false, 'message'=>"Veuillez choisir votre fichier",'titre'=>"Erreur"));
        }
    }


    public function import_recensement_5(){
        if(is_uploaded_file($_FILES['fichier']['tmp_name'])){
            $this->load->library('Excel');
            $this->load->model('ImportModel','im');
            $erreur = null;
            $titre = null;
            $object = PHPExcel_IOFactory::load($_FILES['fichier']['tmp_name']);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2;$row<=$highestRow; $row++){
                    $date_excel = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $village_nom = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $linux_time = ($date_excel-25569)*86400; 
                    $date = date("Y-m-d",$linux_time);
                    $village_id = null;
                    $village_exist = $this->im->check_village($village_nom);
                    $pecheur_nom = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $pecheur_sexe = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $pecheur_age= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $pecheur_id = null;
                    $id_recensement = null;
                    $pirogue = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $toute_annee = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $type_de_maree = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $resident = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $engin = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $annee_debut = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $periode = [];
                    $activite1 = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
                    $activite2 = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
                    $activite3 = $worksheet->getCellByColumnAndRow(26, $row)->getValue();
                    $act_list = [];
                    $village_origine = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    if($village_origine != "" && $village_origine != null){
                        if(count($this->im->check_village($village_origine))>0){
                            $village_origine = $this->im->get_village_id($village_origine)['id'];
                        }else{
                            $data = array(
                                'nom'=>$village_origine
                            );
                            $this->im->creer_village($data);
                            $village_origine = $this->im->get_village_id($village_origine)['id'];
                        }
                    }
                    for($i=24;$i<=26;$i++){
                        if($worksheet->getCellByColumnAndRow($i, $row)->getValue() != "" && $worksheet->getCellByColumnAndRow($i, $row)->getValue() != null){
                            array_push($act_list,strval($worksheet->getCellByColumnAndRow($i, $row)->getValue()));
                        }
                    }
                    $id_engin = $this->im->get_engin_id($engin)[0]['id'];
                    if($resident == "Oui" || $resident == "O" || $resident == 1 || $resident == "OUI"|| $resident == "oui"){
                        $resident = 1;
                    }else{
                        $resident = 0;
                    }
                    if($type_de_maree == "ME"){
                        $type_de_maree = "Mortes eaux";
                    }elseif($type_de_maree == "VE"){
                        $type_de_maree = "Vives eaux"; 
                    }else{
                        $type_de_maree = "Toutes marées"; 
                    }
                    if($toute_annee == "Oui" || $toute_annee == "O" || $toute_annee == 1 || $toute_annee == "OUI"){
                        $toute_annee = 1;
                        $periode = null;
                    }else{
                        $toute_annee = 0;
                    }
                    if($toute_annee == 0){
                        for($i=1;$i<=12;$i++){
                            $index = 12+$i;
                            if($i == 12){
                                if($worksheet->getCellByColumnAndRow($i, $row)->getValue() == 1){
                                    array_push($periode,strval($i));
                                }
                            }else{
                                if($worksheet->getCellByColumnAndRow($index, $row)->getValue() == 1){
                                    array_push($periode,strval($i));
                                }
                            }
                        }
                    }
                    if($pirogue == "Oui" || $pirogue == "O" || $pirogue == 1 || $pirogue == "OUI" || $pirogue == "oui"){
                        $pirogue = 1;
                    }elseif($pirogue == "Non" || $pirogue == "N" || $pirogue == 0 || $pirogue == "NON" || $pirogue == "non"){
                        $pirogue = 0;
                    }else{
                        $pirogue = 2;
                    }
                    if($pecheur_sexe == "Femme" || $pecheur_sexe == "F" || $pecheur_sexe == "V"){
                        $pecheur_sexe = "F";
                    }elseif($pecheur_sexe == "" || $pecheur_sexe == null){
                        $pecheur_sexe = null;
                    }else{
                        $pecheur_sexe = "H";
                    }
			
                    if(is_numeric($pecheur_age)){
                        $pecheur_age = date_format(date_sub(date_create($date),date_interval_create_from_date_string("$pecheur_age years")),"Y");
                    }else{
                        $pecheur_age = null;
                    }
                    if(count($village_exist) > 0){
                        $village_id = $this->im->get_village_id($village_nom)['id'];
                        $pecheur_village = array('nom'=>$pecheur_nom,'village'=>$village_id);
                        $data_pecheur = array('nom'=>$pecheur_nom,'sexe'=>$pecheur_sexe,'datenais'=>$pecheur_age,'village'=>$village_id, 'village_origine'=>$village_origine);
                        
                        if(count($this->im->pecheur_existe($pecheur_village))>0){
                                $pecheur_id = $this->im->pecheur_existe($pecheur_village)[0]['id'];
                        }else{
                            $this->im->creer_pecheur($data_pecheur);
                            $pecheur_id = $this->im->pecheur_existe($data_pecheur)[0]['id'];
                        }

                        for($i=1;$i<1000;$i++){
                            $data_fiche = array('village'=>$village_id,'date'=>$date,'numero_ordre'=>$i);
                            if(count($this->im->check_fiche_recensement($data_fiche))>0){
                                if(count($this->im->check_nombre_enquete_recensement($this->im->check_fiche_recensement($data_fiche)[0]['id']))<5){
                                        $id_recensement = $this->im->check_fiche_recensement($data_fiche)[0]['id'];
                                        $i=2000;
                                }
                            }else{
                                $this->im->creer_fiche_recensement($data_fiche);
                                $id_recensement = $this->im->check_fiche_recensement($data_fiche)[0]['id'];
                                $i=2000;
                            }
                        }

                        $data_enquete = array(
                            'pecheur'=>$pecheur_id,
                            'recensement'=>$id_recensement,
                            'pirogue'=>$pirogue,
                            'toute_annee'=>$toute_annee,
                            'type_periode'=>null,
                            'type_mare'=>$type_de_maree,
                            'periode_mois'=>(($periode != null && count($periode) > 0) ? json_encode($periode) : null),
                            'resident'=>$resident
                        );
                        $data_enquete2 = array(
                            'pecheur'=>$pecheur_id,
                            'recensement'=>$id_recensement,
                            'pirogue'=>$pirogue,
                            'toute_annee'=>$toute_annee,
                            'type_periode'=>null,
                            'type_mare'=>$type_de_maree,
                            'resident'=>$resident
                        );
                        
                        $this->im->insert_enquete_recensement($data_enquete);
                        $id_enquete = $this->im->get_enquete_id($data_enquete2)[0]['id'];
                        $data_engin = array(
                            'enquete_recensement'=>$id_enquete,
                            'engin'=>$id_engin,
                            'annee'=>$annee_debut
                        );
                        $this->im->insert_engin_recensement($data_engin);
                        if(count($act_list)<3){
                            if(count($act_list)<2){
                                $pourcent = [100];
                            }else{
                                $pourcent = [50,50];
                            }
                        }else{
                            $pourcent = [50,25,25];
                        }
                        for($i=0;$i<count($act_list);$i++){
                            $id_act = $this->im->get_id_act(strtoupper($act_list[$i]))[0]['id'];
                            $data_act = array(
                                'enquete_recensement'=>$id_enquete,
                                'activite'=> $id_act,
                                'pourcentage'=> $pourcent[$i]
                            );
                            $this->im->insert_activite_recensement($data_act);
                        }

                        if($resident){
                            $data_pecheur = array(
                                'nom'=>$pecheur_nom,
                                'sexe'=>$pecheur_sexe,
                                'datenais'=>$pecheur_age,
                                'village'=>$village_id,
                                'village_origine'=>$village_id
                            );
                            $this->im->update_pecheur($data_pecheur, $pecheur_id);
                        }else{
                            $data_pecheur = array(
                                'nom'=>$pecheur_nom,
                                'sexe'=>$pecheur_sexe,
                                'datenais'=>$pecheur_age,
                                'village'=>$village_id,
                                'village_origine'=>$village_origine
                            );
                            $this->im->update_pecheur($data_pecheur, $pecheur_id);
                        }
                    }else{
                        //Alerte pour la détection d'un nouveau village à créer. 
                        $erreur = "Le village d'enquête n'a pas été trouvé dans la base, veuillez vérifier l'orthographe ou entrer le village dans la base à la ligne $row";
                        $titre = "Attention";
                        break;
                    }
                }
            }
            if($erreur == null){
                echo json_encode(array('result'=>true, 'message'=>"Le téléversement des données a été un succès!",'titre'=>"Succès"));
            }else{
                echo json_encode(array('result'=>false, 'message'=>$erreur, 'titre'=>$titre));
            }
        }else{
            echo json_encode(array('result'=>false, 'message'=>"Veuillez choisir votre fichier",'titre'=>"Erreur"));
        }
    }






    public function import_enqueteur_2(){
        if(is_uploaded_file($_FILES['fichier']['tmp_name'])){
            $this->load->library('Excel');
            $this->load->model('ImportModel','im');
            $erreur = null;
            $titre = null;
            $donnee = null;
            $mois = null;
            $annee = null;
            $object = PHPExcel_IOFactory::load($_FILES['fichier']['tmp_name']);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2;$row<=$highestRow; $row++){
                    $type = 'ENQ';
                    $village = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $num_fiche = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $code_enqueteur = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $date_excel = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $pecheur = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $capture_poids = $worksheet->getCellByColumnAndRow(39, $row)->getValue();
                    $prix_marche_local = $worksheet->getCellByColumnAndRow(45, $row)->getValue();
                    $poids_marche_local = $worksheet->getCellByColumnAndRow(44, $row)->getValue();
                    $prix_collecte2 = $worksheet->getCellByColumnAndRow(43, $row)->getValue();
                    $prix_collecte1 = $worksheet->getCellByColumnAndRow(41, $row)->getValue();
                    $poids_collecte1 = $worksheet->getCellByColumnAndRow(40, $row)->getValue();
                    $poids_collecte2 = $worksheet->getCellByColumnAndRow(42, $row)->getValue();
                    $poids_consomme = $worksheet->getCellByColumnAndRow(46, $row)->getValue();
                    $linux_time = ($date_excel-25569)*86400; 
                    $date_enquete = date("Y-m-d",$linux_time);
                    $annee = date("Y",$linux_time);
                    $mois = date("m",$linux_time);
                    $epoux = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $enfant = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $ami = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $village_id = null;
                    $check_village = $this->im->check_village($village);
                    $fiche_num = 1;
                    if(is_numeric($num_fiche)){
                        $fiche_num = $num_fiche;
                    }

                    $poids_capture = 0;
                    if(is_numeric($capture_poids)){
                        $poids_capture = $capture_poids;
                    }

                    $trie = $worksheet->getCellByColumnAndRow(48, $row)->getValue();
                    $echantillon_poids = $worksheet->getCellByColumnAndRow(171, $row)->getValue();
                    $poids_echantillon = 0;
                    if(is_numeric($echantillon_poids)){
                        $poids_echantillon = $echantillon_poids;
                    }else{
                        $poids_echantillon = 0;
                    }
                    $taille_ecarte = $worksheet->getCellByColumnAndRow(49, $row)->getValue();
                    $taille_ecarte_precision = $worksheet->getCellByColumnAndRow(50, $row)->getValue();
                    if(count($check_village)>0){ 
                        $village_id = $this->im->get_village_id($village)['id'];
                    }else {
                        $erreur = "Nouveau village detecté à la ligne: $row ! Nom du village : $village";
                        $titre = "Village à renseigner!";
                        break;
                    }

                    $pecheur_id = null;
                    $check_pecheur = $this->im->check_pecheur($pecheur,$village_id);
                    if(count($check_pecheur)>0){ 
                        $pecheur_id = $check_pecheur[0]['id'];
                    }else {
                        $erreur = "Erreur au niveau du nom du pêcheur à la ligne: $row dans le village : $village";
                        $titre = "Information pêcheur à vérifier!";
                        break;
                    }

                    $enqueteur_id = null;
                    $check_enqueteur = $this->im->check_enqueteur($code_enqueteur,$village_id);
                    if(count($check_enqueteur)>0){ 
                        $enqueteur_id = $this->im->get_enqueteur_id($code_enqueteur,$village_id)['id'];
                    }else {
                        $erreur = "Code enqueteur non reconnu à la ligne: $row dans le village : $village";
                        $titre = "Code enqueteur à vérifier!";
                        break;
                    }
                    $nb_sortie_capture = intval($worksheet->getCellByColumnAndRow(38, $row)->getValue());

                    $data_doublon = array(
                        'village'=>$village,
                        'date_premiere_sortie_de_peche'=>$date_enquete,
                        'pecheur'=>$pecheur,
                        'nombre_de_sortie'=>$nb_sortie_capture,
                        'poids_crabe_capture'=>$poids_capture
                    );
                    $check_doublon = $this->im->check_doublon_enqueteur($data_doublon);
                    $fiche_id = null;
                    if(count($check_doublon)<=0){ 
                        $check_fiche = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$fiche_num);
                        if(count($check_fiche)>0){
                            $check_enquete = $this->im->check_enquete($check_fiche[0]['id'],$type);
                            if(count($check_enquete)>=2){
                                for($i = $fiche_num+1;$i<1000;$i++){
                                    $check_fiche = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$i);
                                    if(count($check_fiche)<=0){
                                        $data = array(
                                            'type' => $type,
                                            'mois' => $mois,
                                            'annee' => $annee,
                                            'village' => $village_id,
                                            'enqueteur' => $enqueteur_id,
                                            'numero_ordre' => $i
                                        );
                                        $creer_fiche = $this->im->creer_fiche($data);
                                        $fiche_id = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$i)[0]['id'];
                                        $i=1000;
                                    }
                                }
                            }else{
                                $fiche_id = $check_fiche[0]['id'];
                            }
                        }else{
                            $data = array(
                                'type' => $type,
                                'mois' => $mois,
                                'annee' => $annee,
                                'village' => $village_id,
                                'enqueteur' => $enqueteur_id,
                                'numero_ordre' => $fiche_num
                            );
                            $creer_fiche = $this->im->creer_fiche($data);
                            $fiche_id = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$fiche_num)[0]['id'];
                        }

                        // REQUETE FICHE ENQUETEUR

                        $partenaire = 'seul';
                        $nombre_partenaire = 0;
                        if($epoux != 0){
                            $partenaire = 'partenaire';
                            $nombre_partenaire = $epoux;
                        }else{
                            if($enfant != 0){
                                $partenaire = 'enfant';
                                $nombre_partenaire = $enfant;
                            }else{
                                if($ami != 0){
                                    $partenaire = 'amis';
                                    $nombre_partenaire = $ami;
                                }
                            }
                        }

                        $marche_local_prix = 0;
                        if(is_numeric($prix_marche_local)){
                            $marche_local_prix = $prix_marche_local;
                        }
                        $marche_local_poids = 0;
                        if(is_numeric($poids_marche_local)){
                            $marche_local_poids = $poids_marche_local;
                        }

                        $collecte_prix2 = 0;
                        if(is_numeric($prix_collecte2)){
                            $collecte_prix2 = $prix_collecte2;
                        }
                        $collecte_prix1 = 0;
                        if(is_numeric($prix_collecte1)){
                            $collecte_prix1 = $prix_collecte1;
                        }
                        $collecte_poids1 = 0;
                        if(is_numeric($poids_collecte1)){
                            $collecte_poids1 = $poids_collecte1;
                        }
                        $collecte_poids2 = 0;
                        if(is_numeric($poids_collecte2)){
                            $collecte_poids2 = $poids_collecte2;
                        }
                        $consomme_poids = 0;
                        if(is_numeric($poids_consomme)){
                            $consomme_poids = $poids_consomme;
                        }


                        $data_enqueteur = array(
                            "date"=>$date_enquete,
                            "participant_individu"=>$partenaire,
                            "participant_nombre"=>$nombre_partenaire,
                            "capture_poids"=>$capture_poids,
                            "crabe_consomme_poids"=>$consomme_poids,
                            "collecte_poids1"=>$collecte_poids1,
                            "collecte_poids2"=>$collecte_poids2,
                            "collecte_prix1"=>$collecte_prix1,
                            "collecte_prix2"=>$collecte_prix2,
                            "marche_local_poids"=>$marche_local_poids,
                            "marche_local_prix"=>$marche_local_prix,
                            "fiche"=>$fiche_id,
                            "pecheur"=>$pecheur_id,
                            "nombre_sortie_capture"=>$worksheet->getCellByColumnAndRow(38, $row)->getValue()
                        );

                        $this->im->add_enquete($data_enqueteur,'ENQ');
                        $id_enquete = $this->im->get_id_enquete($data_enqueteur,'ENQ')[0]['id'];

                        $trie_echantillon = false;
                        $taille_absente = null;
                        //REQUETES ECHANTILLON
                        if($trie == 1){
                        $trie_echantillon = true;
                        }
                        if($taille_ecarte == 'Petit'){
                            $taille_absente == 'plus petit';
                        }else if($taille_ecarte == 'Gros'){
                            $taille_absente == 'plus gros';
                        }

                        $data_echantillon =array(
                            "trie"=>$trie_echantillon,
                            "poids"=>$poids_echantillon,
                            "taille_absente"=>$taille_absente,
                            "taille_absente_autre"=>$taille_ecarte_precision,
                            "fiche_enqueteur"=>$id_enquete
                        );

                        $this->im->inserer_echantillon($data_echantillon);
                        $id_echantillon = $this->im->get_id_echantillon($id_enquete)[0]['id'];



                        //REQUETES SORTIES ET ENGINS
                        $indice_sortie = 0;
                        for($i=0;$i<4;$i++){
                            $data_sortie = array(
                                "date"=>date_format(date_sub(date_create($date_enquete), date_interval_create_from_date_string("$i days")),"Y-m-d"),
                                "nombre"=>$worksheet->getCellByColumnAndRow(14+$indice_sortie, $row)->getValue(),
                                "pirogue"=>$worksheet->getCellByColumnAndRow(15+$indice_sortie, $row)->getValue(),
                                "fiche_enqueteur"=>$id_enquete
                            );

                            $this->im->inserer_sortie($data_sortie,'ENQ');
                            $id_sortie = $this->im->get_sortie($data_sortie,'ENQ')[0]['id'];
                            $engin1_nom = $worksheet->getCellByColumnAndRow(16+$indice_sortie, $row)->getValue();
                            $engin2_nom = $worksheet->getCellByColumnAndRow(18+$indice_sortie, $row)->getValue();
                            $engin1_nombre = $worksheet->getCellByColumnAndRow(17+$indice_sortie, $row)->getValue();
                            $engin2_nombre = $worksheet->getCellByColumnAndRow(19+$indice_sortie, $row)->getValue();
                            $id_engin_1 = 1;
                            $id_engin_2 = 1;
                            if($engin1_nom != null && $engin1_nom != '' && $engin1_nom != ' '){
                                $id_engin_1 = $this->im->get_engin_id($engin1_nom)[0]['id'];
                            }else{
                                $engin1_nombre = 0;
                            }
                            if($engin2_nom != null && $engin2_nom != '' && $engin2_nom != ' '){
                                $id_engin_2 = $this->im->get_engin_id($engin2_nom)[0]['id'];
                            }else{
                                $engin2_nombre = 0;
                            }

                            $data_engin_1 = array(
                                'sortie_de_peche_enqueteur'=>$id_sortie,
                                'engin'=>$id_engin_1,
                                'nombre'=>$engin1_nombre
                            );
                            $data_engin_2 = array(
                                'sortie_de_peche_enqueteur'=>$id_sortie,
                                'engin'=>$id_engin_2,
                                'nombre'=>$engin2_nombre
                            );

                            $this->im->insert_engin($data_engin_1,'ENQ');
                            $this->im->insert_engin($data_engin_2,'ENQ');

                            $indice_sortie=$indice_sortie+6;
                        }

                        //REQUETE CRABE

                        $indice_crabe = 0;
                        for($i=0;$i<30;$i++){
                            $destination = $worksheet->getCellByColumnAndRow(51+$indice_crabe, $row)->getValue();
                            $sexe = $worksheet->getCellByColumnAndRow(53+$indice_crabe, $row)->getValue();
                            $taille = $worksheet->getCellByColumnAndRow(52+$indice_crabe, $row)->getValue();

                            $sexe_base = 'M';
                            if(strtoupper($sexe) == 'V'){
                                $oeuf = $worksheet->getCellByColumnAndRow(54+$indice_crabe, $row)->getValue();
                                if($oeuf == 1){
                                    $sexe_base = "FO";
                                }else{
                                    $sexe_base = "NO";
                                }
                            }
                            if($destination == 1 || $destination == 2 | $destination == 3){
                                $data_crabe = array(
                                    "destination"=>$destination,
                                    "sexe"=>$sexe_base,
                                    "taille"=>$taille,
                                    "echantillon"=>$id_echantillon
                                );
                                $this->im->insert_crabe($data_crabe);
                            }
                        $indice_crabe=$indice_crabe+4;    
                        }
                    }
                }
            }
            if($erreur == null){
                echo json_encode(array('result'=>true, 'message'=>"Le téléversement des données a été un succès ($donnee)!",'titre'=>"Succès"));
            }else{
                echo json_encode(array('result'=>false, 'message'=>$erreur, 'titre'=>$titre));
            }
        }else{
            echo json_encode(array('result'=>false, 'message'=>"Veuillez choisir un fichier excel", 'titre'=>"Erreur!"));
        }
    }






    // public function fromExcelToLinux($excel_time) {
    //     return ($excel_time-25569)*86400;
    // }


    public function import_enqueteur(){
        if(is_uploaded_file($_FILES['fichier']['tmp_name'])){
            $this->load->library('Excel');
            $this->load->model('ImportModel','im');
            $erreur = null;
            $titre = null;
            $donnee = null;
            $mois = null;
            $annee = null;
            $object = PHPExcel_IOFactory::load($_FILES['fichier']['tmp_name']);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2;$row<=$highestRow; $row++){
                    $type = 'ENQ';
                    $village = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $num_fiche = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $code_enqueteur = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $date_excel = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $pecheur = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $capture_poids = $worksheet->getCellByColumnAndRow(39, $row)->getValue();
                    $prix_marche_local = $worksheet->getCellByColumnAndRow(45, $row)->getValue();
                    $poids_marche_local = $worksheet->getCellByColumnAndRow(44, $row)->getValue();
                    $prix_collecte2 = $worksheet->getCellByColumnAndRow(43, $row)->getValue();
                    $prix_collecte1 = $worksheet->getCellByColumnAndRow(41, $row)->getValue();
                    $poids_collecte1 = $worksheet->getCellByColumnAndRow(40, $row)->getValue();
                    $poids_collecte2 = $worksheet->getCellByColumnAndRow(42, $row)->getValue();
                    $poids_consomme = $worksheet->getCellByColumnAndRow(46, $row)->getValue();
                    $linux_time = ($date_excel-25569)*86400; 
                    $date_enquete = date("Y-m-d",$linux_time);
                    $annee = date("Y",$linux_time);
                    $mois = date("m",$linux_time);
                    $epoux = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $enfant = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $ami = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $village_id = null;
                    $check_village = $this->im->check_village($village);

                    $fiche_num = 1;
                    if(is_numeric($num_fiche)){
                        $fiche_num = $num_fiche;
                    }

                    $poids_capture = 0;
                    if(is_numeric($capture_poids)){
                        $poids_capture = $capture_poids;
                    }

                    $trie = $worksheet->getCellByColumnAndRow(48, $row)->getValue();
                    $echantillon_poids = $worksheet->getCellByColumnAndRow(171, $row)->getValue();
                    $poids_echantillon = 0;
                    if(is_numeric($echantillon_poids)){
                        $poids_echantillon = $echantillon_poids;
                    }else{
                        $poids_echantillon = 0;
                    }
                    $taille_ecarte = $worksheet->getCellByColumnAndRow(49, $row)->getValue();
                    $taille_ecarte_precision = $worksheet->getCellByColumnAndRow(50, $row)->getValue();
                    if(count($check_village)>0){ 
                        $village_id = $this->im->get_village_id($village)['id'];
                    }else {
                        $erreur = "Nouveau village detecté à la ligne: $row ! Nom du village : $village";
                        $titre = "Village à renseigner!";
                        break;
                    }

                    $pecheur_id = null;
                    $check_pecheur = $this->im->check_pecheur($pecheur,$village_id);
                    if(count($check_pecheur)>0){ 
                        $pecheur_id = $check_pecheur[0]['id'];
                    }else {
                        $erreur = "Erreur au niveau du nom du pêcheur à la ligne: $row dans le village : $village";
                        $titre = "Information pêcheur à vérifier!";
                        break;
                    }

                    $enqueteur_id = null;
                    $check_enqueteur = $this->im->check_enqueteur($code_enqueteur,$village_id);
                    if(count($check_enqueteur)>0){ 
                        $enqueteur_id = $this->im->get_enqueteur_id($code_enqueteur,$village_id)['id'];
                    }else {
                        $erreur = "Code enqueteur non reconnu à la ligne: $row dans le village : $village";
                        $titre = "Code enqueteur à vérifier!";
                        break;
                    }
                    
                    $fiche_id = null;
                    $creer = false;
                    $increment = false;
                    $sauter = false;
                    $check_fiche = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$fiche_num);
                    if(count($check_fiche)>0){
                        $check_enquete = $this->im->check_enquete($check_fiche[0]['id'],$type);
                        if(count($check_enquete)>=2){
                               $creer = true; 
                               $increment = true;
                        }else{
                            $fiche_id = $check_fiche[0]['id'];
                        }
                    }else{
                        $creer = true;
                    }

                    if(!$sauter){
                        if($creer){
                            if($increment){
                                $i = $fiche_num+1;
                                for($i = $fiche_num;$i<1000;$i++){
                                    $check_fiche = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$i);
                                    if(count($check_fiche)<0){
                                        $data = array(
                                            'type' => $type,
                                            'mois' => $mois,
                                            'annee' => $annee,
                                            'village' => $village_id,
                                            'enqueteur' => $enqueteur_id,
                                            'numero_ordre' => $i
                                        );
                                        $creer_fiche = $this->im->creer_fiche($data);
                                        $fiche_id = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$i)[0]['id'];
                                        $i=1000;
                                    }
                                }
                            }else{
                                $data = array(
                                    'type' => $type,
                                    'mois' => $mois,
                                    'annee' => $annee,
                                    'village' => $village_id,
                                    'enqueteur' => $enqueteur_id,
                                    'numero_ordre' => $fiche_num
                                );
                                $creer_fiche = $this->im->creer_fiche($data);
                                $fiche_id = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$fiche_num)[0]['id'];
                            }
                        }
                        

                        // REQUETE FICHE ENQUETEUR

                        $partenaire = 'seul';
                        $nombre_partenaire = 0;
                        if($epoux != 0){
                            $partenaire = 'partenaire';
                            $nombre_partenaire = $epoux;
                        }else{
                            if($enfant != 0){
                                $partenaire = 'enfant';
                                $nombre_partenaire = $enfant;
                            }else{
                                if($ami != 0){
                                    $partenaire = 'amis';
                                    $nombre_partenaire = $ami;
                                }
                            }
                        }

                        $marche_local_prix = 0;
                        if(is_numeric($prix_marche_local)){
                            $marche_local_prix = $prix_marche_local;
                        }
                        $marche_local_poids = 0;
                        if(is_numeric($poids_marche_local)){
                            $marche_local_poids = $poids_marche_local;
                        }

                        $collecte_prix2 = 0;
                        if(is_numeric($prix_collecte2)){
                            $collecte_prix2 = $prix_collecte2;
                        }
                        $collecte_prix1 = 0;
                        if(is_numeric($prix_collecte1)){
                            $collecte_prix1 = $prix_collecte1;
                        }
                        $collecte_poids1 = 0;
                        if(is_numeric($poids_collecte1)){
                            $collecte_poids1 = $poids_collecte1;
                        }
                        $collecte_poids2 = 0;
                        if(is_numeric($poids_collecte2)){
                            $collecte_poids2 = $poids_collecte2;
                        }
                        $consomme_poids = 0;
                        if(is_numeric($poids_consomme)){
                            $consomme_poids = $poids_consomme;
                        }


                        $data_enqueteur = array(
                            "date"=>$date_enquete,
                            "participant_individu"=>$partenaire,
                            "participant_nombre"=>$nombre_partenaire,
                            "capture_poids"=>$capture_poids,
                            "crabe_consomme_poids"=>$consomme_poids,
                            "collecte_poids1"=>$collecte_poids1,
                            "collecte_poids2"=>$collecte_poids2,
                            "collecte_prix1"=>$collecte_prix1,
                            "collecte_prix2"=>$collecte_prix2,
                            "marche_local_poids"=>$marche_local_poids,
                            "marche_local_prix"=>$marche_local_prix,
                            "fiche"=>$fiche_id,
                            "pecheur"=>$pecheur_id,
                            "nombre_sortie_capture"=>$worksheet->getCellByColumnAndRow(38, $row)->getValue()
                        );

                        $this->im->add_enquete($data_enqueteur,'ENQ');
                        $id_enquete = $this->im->get_id_enquete($data_enqueteur,'ENQ')[0]['id'];

                        $trie_echantillon = false;
                        $taille_absente = null;
                        //REQUETES ECHANTILLON
                        if($trie == 1){
                        $trie_echantillon = true;
                        }
                        if($taille_ecarte == 'Petit'){
                            $taille_absente == 'plus petit';
                        }else if($taille_ecarte == 'Gros'){
                            $taille_absente == 'plus gros';
                        }

                        $data_echantillon =array(
                            "trie"=>$trie_echantillon,
                            "poids"=>$poids_echantillon,
                            "taille_absente"=>$taille_absente,
                            "taille_absente_autre"=>$taille_ecarte_precision,
                            "fiche_enqueteur"=>$id_enquete
                        );

                        $this->im->inserer_echantillon($data_echantillon);
                        $id_echantillon = $this->im->get_id_echantillon($id_enquete)[0]['id'];



                        //REQUETES SORTIES ET ENGINS
                        $indice_sortie = 0;
                        for($i=0;$i<4;$i++){
                            $data_sortie = array(
                                "date"=>date_format(date_sub(date_create($date_enquete), date_interval_create_from_date_string("$i days")),"Y-m-d"),
                                "nombre"=>$worksheet->getCellByColumnAndRow(14+$indice_sortie, $row)->getValue(),
                                "pirogue"=>$worksheet->getCellByColumnAndRow(15+$indice_sortie, $row)->getValue(),
                                "fiche_enqueteur"=>$id_enquete
                            );

                            $this->im->inserer_sortie($data_sortie,'ENQ');
                            $id_sortie = $this->im->get_sortie($data_sortie,'ENQ')[0]['id'];
                            $engin1_nom = $worksheet->getCellByColumnAndRow(16+$indice_sortie, $row)->getValue();
                            $engin2_nom = $worksheet->getCellByColumnAndRow(18+$indice_sortie, $row)->getValue();
                            $engin1_nombre = $worksheet->getCellByColumnAndRow(17+$indice_sortie, $row)->getValue();
                            $engin2_nombre = $worksheet->getCellByColumnAndRow(19+$indice_sortie, $row)->getValue();
                            $id_engin_1 = 1;
                            $id_engin_2 = 1;
                            if($engin1_nom != null && $engin1_nom != '' && $engin1_nom != ' '){
                                $id_engin_1 = $this->im->get_engin_id($engin1_nom)[0]['id'];
                            }else{
                                $engin1_nombre = 0;
                            }
                            if($engin2_nom != null && $engin2_nom != '' && $engin2_nom != ' '){
                                $id_engin_2 = $this->im->get_engin_id($engin2_nom)[0]['id'];
                            }else{
                                $engin2_nombre = 0;
                            }

                            $data_engin_1 = array(
                                'sortie_de_peche_enqueteur'=>$id_sortie,
                                'engin'=>$id_engin_1,
                                'nombre'=>$engin1_nombre
                            );
                            $data_engin_2 = array(
                                'sortie_de_peche_enqueteur'=>$id_sortie,
                                'engin'=>$id_engin_2,
                                'nombre'=>$engin2_nombre
                            );

                            $this->im->insert_engin($data_engin_1,'ENQ');
                            $this->im->insert_engin($data_engin_2,'ENQ');

                            $indice_sortie=$indice_sortie+6;
                        }

                        //REQUETE CRABE

                        $indice_crabe = 0;
                        for($i=0;$i<30;$i++){
                            $destination = $worksheet->getCellByColumnAndRow(51+$indice_crabe, $row)->getValue();
                            $sexe = $worksheet->getCellByColumnAndRow(53+$indice_crabe, $row)->getValue();
                            $taille = $worksheet->getCellByColumnAndRow(52+$indice_crabe, $row)->getValue();

                            $sexe_base = 'M';
                            if(strtoupper($sexe) == 'V'){
                                $oeuf = $worksheet->getCellByColumnAndRow(54+$indice_crabe, $row)->getValue();
                                if($oeuf == 1){
                                    $sexe_base = "FO";
                                }else{
                                    $sexe_base = "NO";
                                }
                            }
                            if($destination == 1 || $destination == 2 | $destination == 3){
                                $data_crabe = array(
                                    "destination"=>$destination,
                                    "sexe"=>$sexe_base,
                                    "taille"=>$taille,
                                    "echantillon"=>$id_echantillon
                                );
                                $this->im->insert_crabe($data_crabe);
                            }
                        $indice_crabe=$indice_crabe+4;    
                        }
                    }

                }
            }
            if($erreur == null){
                echo json_encode(array('result'=>true, 'message'=>"Le téléversement des données a été un succès ($donnee)!",'titre'=>"Succès"));
            }else{
                echo json_encode(array('result'=>false, 'message'=>$erreur, 'titre'=>$titre));
            }
        }else{
            echo json_encode(array('result'=>false, 'message'=>"Veuillez choisir un fichier excel", 'titre'=>"Erreur!"));
        }
    }







    public function import_acheteur_2(){
        if(is_uploaded_file($_FILES['fichier']['tmp_name'])){

            $this->load->library('Excel');
            $this->load->model('ImportModel','im');
            $erreur = null;
            $titre = null;
            $donnee = null;
            $mois = null;
            $annee = null;
            $object = PHPExcel_IOFactory::load($_FILES['fichier']['tmp_name']);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2;$row<=$highestRow; $row++){
                    $type = 'ACH';
                    $village = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $num_fiche = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $code_enqueteur = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $date_excel = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $pecheur = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $prix_marche_local = $worksheet->getCellByColumnAndRow(44, $row)->getValue();
                    $poids_marche_local = $worksheet->getCellByColumnAndRow(43, $row)->getValue();
                    $prix_collecte2 = $worksheet->getCellByColumnAndRow(42, $row)->getValue();
                    $prix_collecte1 = $worksheet->getCellByColumnAndRow(40, $row)->getValue();
                    $poids_collecte1 = $worksheet->getCellByColumnAndRow(39, $row)->getValue();
                    $poids_collecte2 = $worksheet->getCellByColumnAndRow(41, $row)->getValue();
                    $poids_consomme = $worksheet->getCellByColumnAndRow(45, $row)->getValue();
                    $nombre_consomme = $worksheet->getCellByColumnAndRow(46, $row)->getValue();
                    $linux_time = ($date_excel-25569)*86400; 
                    $date_enquete = date("Y-m-d",$linux_time);
                    $annee = date("Y",$linux_time);
                    $mois = date("m",$linux_time);
                    $epoux = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $enfant = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $ami = $worksheet->getCellByColumnAndRow(13, $row)->getValue();


                    $fiche_num = 1;
                    if(is_numeric($num_fiche)){
                        $fiche_num = $num_fiche;
                    }

                        $nombre_partenaire = $epoux+$ami+$enfant+1;

                        $marche_local_prix = 0;
                        if($prix_marche_local != null && $prix_marche_local != '' && $prix_marche_local != ' ' && is_numeric($prix_marche_local)){
                            $marche_local_prix = $prix_marche_local;
                        }
                        $marche_local_poids = 0;
                        if($poids_marche_local != null && $poids_marche_local != '' && $poids_marche_local != ' ' && is_numeric($poids_marche_local)){
                            $marche_local_poids = $poids_marche_local;
                        }

                        $collecte_prix2 = 0;
                        if($prix_collecte2 != null && $prix_collecte2 != '' && $prix_collecte2 != ' ' && is_numeric($prix_collecte2)){
                            $collecte_prix2 = $prix_collecte2;
                        }
                        $collecte_prix1 = 0;
                        if($prix_collecte1 != null && $prix_collecte1 != '' && $prix_collecte1 != ' ' && is_numeric($prix_collecte1)){
                            $collecte_prix1 = $prix_collecte1;
                        }
                        $collecte_poids1 = 0;
                        if($poids_collecte1 != null && $poids_collecte1 != '' && $poids_collecte1 != ' ' && is_numeric($poids_collecte1)){
                            $collecte_poids1 = $poids_collecte1;
                        }
                        $collecte_poids2 = 0;
                        if($poids_collecte2 != null && $poids_collecte2 != '' && $poids_collecte2 != ' ' && is_numeric($poids_collecte2)){
                            $collecte_poids2 = $poids_collecte2;
                        }
                        $consomme_poids = 0;
                        if($poids_consomme != null && $poids_consomme != '' && $poids_consomme != ' ' && is_numeric($poids_consomme)){
                            $consomme_poids = $poids_consomme;
                        }
                        $consomme_nombre = 0;
                        if($nombre_consomme != null && $nombre_consomme != '' && $nombre_consomme != ' ' && is_numeric($nombre_consomme)){
                            $consomme_nombre = $nombre_consomme;
                        }

                        $poids_capture = $marche_local_poids+$collecte_poids1+$collecte_poids2+$consomme_poids;
                    $village_id = null;
                    $check_village = $this->im->check_village($village);
                    if(count($check_village)>0){ 
                        $village_id = $this->im->get_village_id($village)['id'];
                    }else {
                        $erreur = "Nouveau village detecté à la ligne: $row ! Nom du village : $village";
                        $titre = "Village à renseigner!";
                        break;
                    }

                    $pecheur_id = null;
                    $check_pecheur = $this->im->check_pecheur($pecheur,$village_id);
                    if(count($check_pecheur)>0){ 
                        $pecheur_id = $check_pecheur[0]['id'];
                    }else {
                        $erreur = "Erreur au niveau du nom du pêcheur à la ligne: $row dans le village : $village";
                        $titre = "Information pêcheur à vérifier!";
                        break;
                    }


                    $enqueteur_id = null;
                    $check_enqueteur = $this->im->check_enqueteur($code_enqueteur,$village_id);
                    if(count($check_enqueteur)>0){ 
                        $enqueteur_id = $this->im->get_enqueteur_id($code_enqueteur,$village_id)['id'];
                    }else {
                        $erreur = "Code enqueteur non reconnu à la ligne: $row dans le village : $village";
                        $titre = "Code enqueteur à vérifier!";
                        break;
                    }
                    $nb_sortie_capture = intval($worksheet->getCellByColumnAndRow(38, $row)->getValue());
                    $data_doublon = array(
                        'village'=>$village,
                        'date_premiere_sortie_de_peche'=>$date_enquete,
                        'pecheur'=>$pecheur,
                        'nombre_de_sortie'=>$nb_sortie_capture,
                        'poids_crabe_capture'=>$poids_capture
                    );
                    $check_doublon = $this->im->check_doublon_acheteur($data_doublon);
                    $fiche_id = null;
                    if(count($check_doublon)<=0){
                        $check_fiche = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$fiche_num);
                        if(count($check_fiche)>0){
                            $check_enquete = $this->im->check_enquete($check_fiche[0]['id'],$type);
                            if(count($check_enquete)>=2){
                                for($i = $fiche_num+1;$i<1000;$i++){
                                    $check_fiche = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$i);
                                    if(count($check_fiche)<=0){
                                        $data = array(
                                            'type' => $type,
                                            'mois' => $mois,
                                            'annee' => $annee,
                                            'village' => $village_id,
                                            'enqueteur' => $enqueteur_id,
                                            'numero_ordre' => $i
                                        );
                                        $creer_fiche = $this->im->creer_fiche($data);
                                        $fiche_id = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$i)[0]['id'];
                                        $i=1000;
                                    }
                                }
                            }else{
                                $fiche_id = $check_fiche[0]['id'];
                            }
                        }else{
                            $data = array(
                                'type' => $type,
                                'mois' => $mois,
                                'annee' => $annee,
                                'village' => $village_id,
                                'enqueteur' => $enqueteur_id,
                                'numero_ordre' => $fiche_num
                            );
                            $creer_fiche = $this->im->creer_fiche($data);
                            $fiche_id = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$fiche_num)[0]['id'];
                        }

                        $data_acheteur = array(
                            "date"=>$date_enquete,
                            "pecheur_nombre"=>$nombre_partenaire,
                            "collecte_poids1"=>$collecte_poids1,
                            "collecte_prix1"=>$collecte_prix1,
                            "collecte_poids2"=>$collecte_poids2,
                            "collecte_prix2"=>$collecte_prix2,
                            "marche_local_poids"=>$marche_local_poids,
                            "marche_local_prix"=>$marche_local_prix,
                            "fiche"=>$fiche_id,
                            "pecheur"=>$pecheur_id,
                            "crabe_non_vendu_poids"=>$consomme_poids,
                            "crabe_non_vendu_nombre"=>$consomme_nombre,
                            "nombre_sortie_vente"=>$nb_sortie_capture
                        );

                        $this->im->add_enquete($data_acheteur,'ACH');
                        $id_enquete = $this->im->get_id_enquete($data_acheteur,'ACH')[0]['id'];



                        //REQUETES SORTIES ET ENGINS
                        $indice_sortie = 0;
                        for($i=0;$i<4;$i++){
                            $data_sortie = array(
                                "date"=>date_format(date_sub(date_create($date_enquete), date_interval_create_from_date_string("$i days")),"Y-m-d"),
                                "nombre"=>$worksheet->getCellByColumnAndRow(14+$indice_sortie, $row)->getValue(),
                                "pirogue"=>$worksheet->getCellByColumnAndRow(15+$indice_sortie, $row)->getValue(),
                                "fiche_acheteur"=>$id_enquete
                            );

                            $this->im->inserer_sortie($data_sortie,'ACH');
                            $id_sortie = $this->im->get_sortie($data_sortie,'ACH')[0]['id'];
                            $engin1_nom = $worksheet->getCellByColumnAndRow(16+$indice_sortie, $row)->getValue();
                            $engin2_nom = $worksheet->getCellByColumnAndRow(18+$indice_sortie, $row)->getValue();
                            $engin1_nombre = $worksheet->getCellByColumnAndRow(17+$indice_sortie, $row)->getValue();
                            $engin2_nombre = $worksheet->getCellByColumnAndRow(19+$indice_sortie, $row)->getValue();
                            $id_engin_1 = 1;
                            $id_engin_2 = 1;
                            if($engin1_nom != null && $engin1_nom != '' && $engin1_nom != ' '){
                                $id_engin_1 = $this->im->get_engin_id($engin1_nom)[0]['id'];
                            }else{
                                $engin1_nombre = 0;
                            }
                            if($engin2_nom != null && $engin2_nom != '' && $engin2_nom != ' '){
                                $id_engin_2 = $this->im->get_engin_id($engin2_nom)[0]['id'];
                            }else{
                                $engin2_nombre = 0;
                            }

                            $data_engin_1 = array(
                                'sortie_de_peche_acheteur'=>$id_sortie,
                                'engin'=>$id_engin_1,
                                'nombre'=>$engin1_nombre
                            );
                            $data_engin_2 = array(
                                'sortie_de_peche_acheteur'=>$id_sortie,
                                'engin'=>$id_engin_2,
                                'nombre'=>$engin2_nombre
                            );

                            $this->im->insert_engin($data_engin_1,'ACH');
                            $this->im->insert_engin($data_engin_2,'ACH');

                            $indice_sortie=$indice_sortie+6;
                        }
                    }
                }// FIN DU FOR
            }//FIN DU FOREACH





            if($erreur == null){
                echo json_encode(array('result'=>true, 'message'=>"Le téléversement des données a été un succès ($donnee)!",'titre'=>"Succès"));
            }else{
                echo json_encode(array('result'=>false, 'message'=>$erreur, 'titre'=>$titre));
            }
        }else{
            echo json_encode(array('result'=>false, 'message'=>"Veuillez choisir un fichier excel", 'titre'=>"Erreur!"));
        }
    }





    public function import_acheteur(){
        if(is_uploaded_file($_FILES['fichier']['tmp_name'])){
            $this->load->library('Excel');
            $this->load->model('ImportModel','im');
            $erreur = null;
            $titre = null;
            $donnee = null;
            $mois = null;
            $annee = null;
            $object = PHPExcel_IOFactory::load($_FILES['fichier']['tmp_name']);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2;$row<=$highestRow; $row++){
                    $type = 'ACH';
                    $village = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $num_fiche = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $code_enqueteur = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $date_excel = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $pecheur = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $prix_marche_local = $worksheet->getCellByColumnAndRow(44, $row)->getValue();
                    $poids_marche_local = $worksheet->getCellByColumnAndRow(43, $row)->getValue();
                    $prix_collecte2 = $worksheet->getCellByColumnAndRow(42, $row)->getValue();
                    $prix_collecte1 = $worksheet->getCellByColumnAndRow(40, $row)->getValue();
                    $poids_collecte1 = $worksheet->getCellByColumnAndRow(39, $row)->getValue();
                    $poids_collecte2 = $worksheet->getCellByColumnAndRow(41, $row)->getValue();
                    $poids_consomme = $worksheet->getCellByColumnAndRow(45, $row)->getValue();
                    $nombre_consomme = $worksheet->getCellByColumnAndRow(46, $row)->getValue();
                    $linux_time = ($date_excel-25569)*86400; 
                    $date_enquete = date("Y-m-d",$linux_time);
                    $annee = date("Y",$linux_time);
                    $mois = date("m",$linux_time);
                    $epoux = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $enfant = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $ami = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $village_id = null;
                    $check_village = $this->im->check_village($village);

                    if(count($check_village)>0){ 
                        $village_id = $this->im->get_village_id($village)['id'];
                    }else {
                        $erreur = "Nouveau village detecté à la ligne: $row ! Nom du village : $village";
                        $titre = "Village à renseigner!";
                        break;
                    }

                    $pecheur_id = null;
                    $check_pecheur = $this->im->check_pecheur($pecheur,$village_id);
                    if(count($check_pecheur)>0){ 
                        $pecheur_id = $check_pecheur[0]['id'];
                    }else {
                        $erreur = "Erreur au niveau du nom du pêcheur à la ligne: $row dans le village : $village";
                        $titre = "Information pêcheur à vérifier!";
                        break;
                    }


                    $enqueteur_id = null;
                    $check_enqueteur = $this->im->check_enqueteur($code_enqueteur,$village_id);
                    if(count($check_enqueteur)>0){ 
                        $enqueteur_id = $this->im->get_enqueteur_id($code_enqueteur,$village_id)['id'];
                    }else {
                        $erreur = "Code enqueteur non reconnu à la ligne: $row dans le village : $village";
                        $titre = "Code enqueteur à vérifier!";
                        break;
                    }

                    $fiche_id = null;
                    $creer = false;
                    $increment = false;
                    $sauter = false;
                    $check_fiche = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$num_fiche);
                    if(count($check_fiche)>0){
                        $check_enquete = $this->im->check_enquete($check_fiche[0]['id'],$type);
                        if(count($check_enquete)>=5){
                            $get_enquete = $this->im->get_enquete_ach($check_fiche[0]['id'],$date_enquete,$pecheur_id);
                            if(count($get_enquete)==0){
                               $creer = true; 
                               $increment = true;
			    }else{$sauter = true;}
                        }else{
                            $fiche_id = $check_fiche[0]['id'];
                        }
                    }else{
                        $creer = true;
                    }

                    if(!$sauter){
                        if($creer){
                            if($increment){
                                $i = $num_fiche+1;
                                for($i = $fiche_num;$i<1000;$i++){
                                    $check_fiche = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$i);
                                    if(count($check_fiche)<0){
                                        $data = array(
                                            'type' => $type,
                                            'mois' => $mois,
                                            'annee' => $annee,
                                            'village' => $village_id,
                                            'enqueteur' => $enqueteur_id,
                                            'numero_ordre' => $i
                                        );
                                        $creer_fiche = $this->im->creer_fiche($data);
                                        $fiche_id = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$i)[0]['id'];
                                        $i=1000;
                                    }
                                }
                            }else{
                                $data = array(
                                    'type' => $type,
                                    'mois' => $mois,
                                    'annee' => $annee,
                                    'village' => $village_id,
                                    'enqueteur' => $enqueteur_id,
                                    'numero_ordre' => $num_fiche
                                );
                                $creer_fiche = $this->im->creer_fiche($data);
                                $fiche_id = $this->im->check_fiche($type,$mois,$annee,$village_id,$enqueteur_id,$num_fiche)[0]['id'];
                            }
                        }

                        // REQUETE FICHE ACHETEUR
                        $nombre_partenaire = $epoux+$ami+$enfant+1;

                        $marche_local_prix = 0;
                        if($prix_marche_local != null && $prix_marche_local != '' && $prix_marche_local != ' ' && is_numeric($prix_marche_local)){
                            $marche_local_prix = $prix_marche_local;
                        }
                        $marche_local_poids = 0;
                        if($poids_marche_local != null && $poids_marche_local != '' && $poids_marche_local != ' ' && is_numeric($poids_marche_local)){
                            $marche_local_poids = $poids_marche_local;
                        }

                        $collecte_prix2 = 0;
                        if($prix_collecte2 != null && $prix_collecte2 != '' && $prix_collecte2 != ' ' && is_numeric($prix_collecte2)){
                            $collecte_prix2 = $prix_collecte2;
                        }
                        $collecte_prix1 = 0;
                        if($prix_collecte1 != null && $prix_collecte1 != '' && $prix_collecte1 != ' ' && is_numeric($prix_collecte1)){
                            $collecte_prix1 = $prix_collecte1;
                        }
                        $collecte_poids1 = 0;
                        if($poids_collecte1 != null && $poids_collecte1 != '' && $poids_collecte1 != ' ' && is_numeric($poids_collecte1)){
                            $collecte_poids1 = $poids_collecte1;
                        }
                        $collecte_poids2 = 0;
                        if($poids_collecte2 != null && $poids_collecte2 != '' && $poids_collecte2 != ' ' && is_numeric($poids_collecte2)){
                            $collecte_poids2 = $poids_collecte2;
                        }
                        $consomme_poids = 0;
                        if($poids_consomme != null && $poids_consomme != '' && $poids_consomme != ' ' && is_numeric($poids_consomme)){
                            $consomme_poids = $poids_consomme;
                        }
                        $consomme_nombre = 0;
                        if($nombre_consomme != null && $nombre_consomme != '' && $nombre_consomme != ' ' && is_numeric($nombre_consomme)){
                            $consomme_nombre = $nombre_consomme;
                        }


                        $data_acheteur = array(
                            "date"=>$date_enquete,
                            "pecheur_nombre"=>$nombre_partenaire,
                            "collecte_poids1"=>$collecte_poids1,
                            "collecte_prix1"=>$collecte_prix1,
                            "collecte_poids2"=>$collecte_poids2,
                            "collecte_prix2"=>$collecte_prix2,
                            "marche_local_poids"=>$marche_local_poids,
                            "marche_local_prix"=>$marche_local_prix,
                            "fiche"=>$fiche_id,
                            "pecheur"=>$pecheur_id,
                            "crabe_non_vendu_poids"=>$consomme_poids,
                            "crabe_non_vendu_nombre"=>$consomme_nombre,
                            "nombre_sortie_vente"=>$worksheet->getCellByColumnAndRow(38, $row)->getValue()
                        );

                        $this->im->add_enquete($data_acheteur,'ACH');
                        $id_enquete = $this->im->get_id_enquete($data_acheteur,'ACH')[0]['id'];


                        //REQUETES SORTIES ET ENGINS
                        $indice_sortie = 0;
                        for($i=0;$i<4;$i++){
                            $data_sortie = array(
                                "date"=>date_format(date_sub(date_create($date_enquete), date_interval_create_from_date_string("$i days")),"Y-m-d"),
                                "nombre"=>$worksheet->getCellByColumnAndRow(14+$indice_sortie, $row)->getValue(),
                                "pirogue"=>$worksheet->getCellByColumnAndRow(15+$indice_sortie, $row)->getValue(),
                                "fiche_acheteur"=>$id_enquete
                            );

                            $this->im->inserer_sortie($data_sortie,'ACH');
                            $id_sortie = $this->im->get_sortie($data_sortie,'ACH')[0]['id'];
                            $engin1_nom = $worksheet->getCellByColumnAndRow(16+$indice_sortie, $row)->getValue();
                            $engin2_nom = $worksheet->getCellByColumnAndRow(18+$indice_sortie, $row)->getValue();
                            $engin1_nombre = $worksheet->getCellByColumnAndRow(17+$indice_sortie, $row)->getValue();
                            $engin2_nombre = $worksheet->getCellByColumnAndRow(19+$indice_sortie, $row)->getValue();
                            $id_engin_1 = 1;
                            $id_engin_2 = 1;
                            if($engin1_nom != null && $engin1_nom != '' && $engin1_nom != ' '){
                                $id_engin_1 = $this->im->get_engin_id($engin1_nom)[0]['id'];
                            }else{
                                $engin1_nombre = 0;
                            }
                            if($engin2_nom != null && $engin2_nom != '' && $engin2_nom != ' '){
                                $id_engin_2 = $this->im->get_engin_id($engin2_nom)[0]['id'];
                            }else{
                                $engin2_nombre = 0;
                            }

                            $data_engin_1 = array(
                                'sortie_de_peche_acheteur'=>$id_sortie,
                                'engin'=>$id_engin_1,
                                'nombre'=>$engin1_nombre
                            );
                            $data_engin_2 = array(
                                'sortie_de_peche_acheteur'=>$id_sortie,
                                'engin'=>$id_engin_2,
                                'nombre'=>$engin2_nombre
                            );

                            $this->im->insert_engin($data_engin_1,'ACH');
                            $this->im->insert_engin($data_engin_2,'ACH');

                            $indice_sortie=$indice_sortie+6;
                        }
                    }
                }
            }if($erreur == null){
                echo json_encode(array('result'=>true, 'message'=>"Le téléversement des données a été un succès ($donnee)!",'titre'=>"Succès"));
            }else{
                echo json_encode(array('result'=>false, 'message'=>$erreur, 'titre'=>$titre));
            }

        }else{
            echo json_encode(array('result'=>false, 'message'=>"Veuillez choisir un fichier excel", 'titre'=>"Erreur!"));
        }
    }



    public function cordonnees(){
        // redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Importer des données sur excel/csv dans la base (Suivi Villageois)";
			$this->root_states['custom_javascripts'] = array(
                'select2.full.min.js',
                'pages/import/import-cordonnes.js'
            );
        // Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
            
            $current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(30),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(30)
            );
            
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'import-enqueteur'
            );
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
            $this->application_component['context_component'] = $this->load->view('import/import-cordonnes.php', $current_context_state, true);
            
            // affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(30))
				$this->load->view('index.php', $this->root_states, false);
			
    }

    public function import_cordonnes(){
        if(is_uploaded_file($_FILES['fichier']['tmp_name'])){

            $this->load->library('Excel');
            $this->load->model('ImportModel','im');
            $erreur = null;
            $object = PHPExcel_IOFactory::load($_FILES['fichier']['tmp_name']);
            
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2;$row<=$highestRow; $row++){
                    $idvillage = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $nomvillage = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $long = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $lat = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $sous_zone = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $bassin = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $village =array(
                        'longitude'=>$long,
                        'latitude'=>$lat,
                        'bassin_collecte'=>$bassin,
                        'sous_zone'=>$sous_zone
                    );
                    $existe = $this->db_village->selection_par_id_index($idvillage);
                    if(count($existe)>0){
                        $ajour = $this->db_village->mettre_a_jour($village, $idvillage) ;
                        if(!$ajour){
                            $erreur = "village non reconnu à la ligne: $row dans le village ";
                        }
                        
                    }
                    
                }
            }

            if($erreur == null){
                echo json_encode(array('result'=>true, 'message'=>"Le téléversement des données a été un succès    !",'titre'=>"Succès"));
            }else{
                echo json_encode(array('result'=>false, 'message'=>$erreur, 'titre'=>'erreur'));
            }



        }

    }
}
