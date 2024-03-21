<?php

	

	class FicheRecensementMensuelController extends ApplicationController {


		

		public function __construct() {

			parent::__construct();
			

			// Chargement des composants statiques de bases (header, footer)

			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);

			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);

		}


		public function operation_datatable() {
			// requisition des données à afficher avec les contraintes
			   
				$data_query = $this->db_recensement_mensuel->datatable($_POST);
	
				// chargement des données formatées
	
				$data = array();
	
				foreach ($data_query as $query_result) {
	
					$bouton_details = $this->lib_autorisation->modification_autorise(12) ? '<a class="btn btn-default update-button" href="'.base_url("consultation-de-recensement-mensuel/detail-et-action/").$query_result['id'].'">Details</a>' : '';
	
					$bouton_modification = $this->lib_autorisation->modification_autorise(11) ? '<a class="btn btn-default update-button" data-target="#update-modal" href="'.base_url("consultation-de-recensement-mensuel/modification/").$query_result['id'].'"  id="update-' . $query_result['id'] . '">Modifier</a>' : '';
	
					$bouton_suppression = $this->lib_autorisation->suppression_autorise(11) ? '<button class="btn btn-default delete-button"  data-target="' . $query_result['id'] . '">Supprimer</button>' : '';
	
					$data[] = array(
	
						$query_result['code'],
						$query_result['date'],
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
	
					'recordsTotal' => $this->db_recensement_mensuel->records_total(),
	
					'recordsFiltered' => $this->db_recensement_mensuel->records_filtered($_POST),
	
					'data' => $data
	
				));
			
		}


		public function existe_fiche(){
			$data = array(
				'village'=>$_POST['village'],
				'annee'=>$_POST['annee'],
				'mois'=>$_POST['mois']
			);
			$pecheur = [];
			if($data['village'] != null && $data['annee'] != null && $data['mois'] != null){
				$existe = $this->db_recensement_mensuel->existe($data);
				if($existe){
					$idfiche = $this->db_recensement_mensuel->existe_id($data); 
					$pecheur = $this->db_recensement_mensuel->liste_fiche_existe($data['village'],$idfiche);

				}
				else{

					$pecheur = $this->db_pecheur->liste_par_village($data['village']);
				}
				echo json_encode($pecheur);
			}

		}

		public function insertion_enquete(){
			$enqueteur = null;
			$erreur_survenu = false;
			if($this->input->post('enqueteur')!=""){
				$enqueteur = $this->input->post('enqueteur');
			}
			$data = array(
				'village'=>$_POST['village'],
				'annee'=>$_POST['annee'],
				'mois'=>$_POST['mois'],
				'date'=>$_POST['date'],
				'enqueteur'=>$enqueteur,
				
			);
			$enquetes = $_POST['enquete'];
          
			$existe = $this->db_recensement_mensuel->existe(array('village'=>$data['village'],'annee'=>$data['annee'],'mois'=>$data['mois']));
			if($existe){
				$idfiche = $this->db_recensement_mensuel->existe_id(array('village'=>$data['village'],'annee'=>$data['annee'],'mois'=>$data['mois']));	
			}
			else{
				 $insertion = $this->db_recensement_mensuel->inserer($data);
				 if(!$insertion){
					$erreur_survenu = true;
				 }
				$idfiche = $this->db_recensement_mensuel->dernier_id();
			}
			foreach($enquetes as $enquete){
				$data_enquete = array('pecheur'=>$enquete['pecheur'],'recensement_mensuel'=>$idfiche,'crabe'=>$enquete['crabe']);
				$insertion = $this->db_recensement_mensuel->inserer_enquete($data_enquete);
				if(!$insertion){
					$erreur_survenu = true;
				} 
				else{
					if($enquete['sexe_status']==0){
						$this->db_pecheur->mettre_a_jour(array('sexe'=>$enquete['sexe']), $data_enquete['pecheur']);
					}
					$idEnquete = $this->db_recensement_mensuel->dernier_id_enquete();
					if($enquete['activite']['activite1'] != null && $enquete['activite']['pourcentage1'] != null ){
						$insertion = $this->db_recensement_mensuel->inserer_activite_enquete(array('enquete_recensement_mensuel'=>$idEnquete,'activite'=>$enquete['activite']['activite1'],'pourcentage'=>$enquete['activite']['pourcentage1']));
						if(!$insertion){
							$erreur_survenu = true;
						}
						
					}
					if($enquete['activite']['activite2'] != null && $enquete['activite']['pourcentage2'] != null ){
						$insertion = $this->db_recensement_mensuel->inserer_activite_enquete(array('enquete_recensement_mensuel'=>$idEnquete,'activite'=>$enquete['activite']['activite2'],'pourcentage'=>$enquete['activite']['pourcentage2']));
						if(!$insertion){
							$erreur_survenu = true;
						}
						
					}
					if($enquete['activite']['activite3'] != null && $enquete['activite']['pourcentage3'] != null ){
						$insertion = $this->db_recensement_mensuel->inserer_activite_enquete(array('enquete_recensement_mensuel'=>$idEnquete,'activite'=>$enquete['activite']['activite3'],'pourcentage'=>$enquete['activite']['pourcentage3']));
						if(!$insertion){
							$erreur_survenu = true;
						}
						
					}
				}
			}
			if($erreur_survenu){
				 $this->db->trans_rollback();
				 echo json_encode(array('result' => false,'title'=>'Erreur non identifié', 'message' => 'Une erreur de serveur a été observée, veuillez vous réferrer à l\'administrateur de la base'));
			}
			else {
				$archive = $this->db_recensement_mensuel->selection_par_id($idfiche);
				$numFiche = $archive['code'];
				$this->db_historique->archiver("Insertion", "Insertion d'une nouvelle fiche de recensement N° 6: ".$numFiche);
				echo json_encode(array('result' => TRUE,'title'=>'Succès', 'message' => 'Les données sont ajoutées avec succès','fiche'=>$idfiche));
			} 
			
			
			
			

		}


	

		public function page_saisie_de_fiche() {

			// chargement de la vue d'insertion et modification dans une variable

			$this->root_states['title'] = 'Fiche de recensement';	

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/saisie-fiche/recensement-mensuel.js'

			);

			$months = $this->mois_francais;

			$current_context_state = array(

				'zone_corecrabes' => $this->db_zone_corecrabe->liste(),

				'enqueteurs' => $this->db_enqueteur->liste_par_tous(),

				'mois' => $months,

				'annee_courante' => intval(date('Y')),

				'mois_courant' => intval(date('m'))

			);

			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif

			$etat_menu = array(

				'active_route' => 'saisie-de-fiche-recensement-mensuel'

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('saisie-fiche/recensement_mensuel.php', $current_context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

		}



		//nouveau
		public function insertion(){
			$enqueteur = null;
			if($this->input->post('enqueteur')!=""){
				$enqueteur = $this->input->post('enqueteur');
			}
				$data = array(
					'zoneCorecrabe'=> $this->input->post('zoneCorecrabe'),
					'fokontany'=> $this->input->post('fokontany'),
					'village'=> $this->input->post('village'),
					'date'=> $this->input->post('date'),
					'annee'=> $this->input->post('annee'),
					'mois'=> $this->input->post('mois'),
					'enqueteur'=> $enqueteur,
					'enquete'=> $this->input->post('enquete'),
				);
	
			 $fiche_existe = $this->db_recensement_mensuel->existe(array(
	
			'village' => $data['village'],
	
			'annee' => $data['annee'],
			
			'mois' => $data['mois']

	
	
			 ));
	
			 if ($fiche_existe) {
	
				echo json_encode(array('result' => false,'title'=>'Erreur doublant', 'message' => 'Le fiche est déja existe'));
	
			 } else {
				$fiche = array(
					
	
					'village' => $data['village'],

					'annee'=>$data['annee'],

					'mois'=> $data['mois'],
   
				   'date' => $data['date'],
   
				   'enqueteur' => $data['enqueteur'],
   
			   );
   
				$insertion = $this->db_recensement_mensuel->inserer($fiche);
   
				if($insertion){
					 $recensement = $this->db_recensement_mensuel->dernier_id();
					 $data2 = array('recensement'=>$recensement,'enquete'=>$data['enquete']);
					 foreach($data2['enquete'] as $key=>$enquete_recensement){
   
						 $data_enquete= array(
							 'recensement'=>$data2['recensement'],
							 'pecheur'=>$enquete_recensement['pecheur'],
							 'crabe'=>$enquete_recensement['crabe']
						 );
						 $insertion_enquete = $this->db_enquete_recensement_mensuel->inserer($data_enquete);
						 if($insertion_enquete)
						 {
							 if($data_enquete['crabe']== '0'){
								$dernier_id = $this->db_enquete_recensement->dernier_id(); 
								if($enquete_recensement['activite']['activite1'] !=null&& $enquete_recensement['activite']['pourcentage1'] !=null ){
								  $dataActivite1 = array('activite'=>$enquete_recensement['activite']['activite1'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$enquete_recensement['activite']['pourcentage1']);
								  $this->db_activite->inserer_activite_enquete_recensement_mensuel($dataActivite1);
								}
								
								if($enquete_recensement['activite']['activite2'] !=null&& $enquete_recensement['activite']['pourcentage2'] !=null ){
								  $dataActivite2 = array('activite'=>$enquete_recensement['activite']['activite2'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$enquete_recensement['activite']['pourcentage2']);
								  $this->db_activite->inserer_activite_enquete_recensement_mensuel($dataActivite2);
							  }
							  if($enquete_recensement['activite']['activite3'] !=null&& $enquete_recensement['activite']['pourcentage3'] !=null ){
								  $dataActivite3 = array('activite'=>$enquete_recensement['activite']['activite3'],'enquete_recensement'=>$dernier_id,'pourcentage'=>$enquete_recensement['activite']['pourcentage3']);
								  $this->db_activite->inserer_activite_enquete_recensement_mensuel($dataActivite3);
							  }
							 }
						   
						 }else echo json_encode(array('result' => false,'title'=>'Erreur non identifié', 'message' => 'Une erreur de serveur a été observée, veuillez vous réferrer à l\'administrateur de la base'));
						 
					 }
					$archive = $this->db_recensement_mensuel->selection_par_id($recensement);
					$numFiche = $archive['nomVillage'].'/'.$archive['annee'].'/'.$archive['mois'];
					$this->db_historique->archiver("Insertion", "Insertion d'une nouvelle fiche de recensement N° 6: ".$numFiche);
				   echo json_encode(array('result' => TRUE, 'message' => 'Les données sont ajoutées avec succès', 'title' => 'Succès', 'fiche' => $recensement));
			   }else echo json_encode(array('result' => false,'title'=>'Erreur non identifié', 'message' => 'Une erreur de serveur a été observée, veuillez vous réferrer à l\'administrateur de la base'));
			 }
				
	
				 
	
			 
			
		}



		public function page_consultation() {

			$this->root_states['title'] = 'Consultation des fiches de resencement N°5';

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/consultation-fiche/recensement-mensuel.js'

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-recensement-mensuel'

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('consultation-fiche/recensement-mensuel.php', null, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

			$this->db_historique->archiver("Visite", "Consultation des fiches de recensement N° 6");

		}

		public function page_detail_enquete($fiche){

			$this->root_states['title'] = 'Consultation des fiches de resencement N°6';

			$information_fiche = $this->db_recensement_mensuel->selection_par_id($fiche);

			$enquetes = $this->db_recensement_mensuel->selection_enquete_par_fiche($fiche);

			foreach ($enquetes as $iteration_enquete => $enquete) {

				$enquetes[$iteration_enquete]["activite"] = $this->db_recensement_mensuel->selection_par_activite_recensement($enquete["id"]);

			}

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/consultation-fiche/recensement-mensuel-detail.js'

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-recensement-mensuel'

			);

			$donnees_contexte = array(

				'fiche' => $information_fiche,
				'enquetes'=>$enquetes
			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('consultation-fiche/recensement-mensuel-detail.php', $donnees_contexte, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

		}

		public function operation_suppression($fiche) {

			echo json_encode($this->db_recensement_mensuel->supprimer($fiche));

		}

		public function operation_suppression_enquete($enquete) {

			echo json_encode($this->db_recensement_mensuel->supprimer_enquete($enquete));

		}

		public function page_modification_fiche($fiche){

			$information_fiche = $this->db_recensement_mensuel->selection_par_id($fiche);
			$this->root_states['title'] = 'Consultation des fiches de resencement N° 6';
			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/consultation-fiche/recensement-mensuel.js'

			);

			$current_context_state = array(

				'fiche' => $information_fiche,

				'enqueteurs' => $this->db_enqueteur->liste_par_village_enqueteur($information_fiche['village'])


			);


			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-recensement-mensuel'

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('modification-fiche/recensement-mensuel.php', $current_context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

		}

		public function page_modification_enquete($enquete_donnes){

			$enquetes = explode("_", $enquete_donnes);
			$enquete1 = $this->db_recensement_mensuel->selection_par_id_enquete($enquetes[0]);
			$information_enquete = [];
			foreach($enquetes as $enquete){
				$data_enquete = $this->db_recensement_mensuel->selection_par_id_enquete($enquete);
				$data_enquete['activites']=$this->db_recensement_mensuel->selection_par_activite_recensement($data_enquete["id"]);
				$information_enquete [] = $data_enquete;
			}

			

			// $information_fiche = $information_enquete['recensement_mensuel'];

			$this->root_states['title'] = 'Consultation des fiches de resencement N° 6';
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(

				'pages/modification-fiche/enquete-recensement-mensuel.js'

			);
			$information_fiche =  $this->db_recensement_mensuel->selection_par_id($enquete1['recensement_mensuel']);
			$current_context_state = array(

				'fiche' => $information_fiche,
				'enquetes'=>$information_enquete,
				'activites'=>$this->db_activite->liste(),

				// 'enqueteurs' => $this->db_enqueteur->liste_par_village_enqueteur($information_fiche['village'])


			);


			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-recensement-mensuel'

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('modification-fiche/enquete-recensement-mensuel.php', $current_context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

		}
		public function operation_mise_a_jour_enquete(){
			$erreur_survenu = false;
			$enquetes = $_POST['enquetes'];
			foreach($enquetes as $enquete){
				$data_enquete = array('crabe'=>$enquete['crabe']);
				$insertion = $this->db_recensement_mensuel->mettre_a_jour_enquete($data_enquete,$enquete['enquete_mensuel']);
				if(!$insertion){
					$erreur_survenu = true;
				} 
				else{

					$idEnquete = $enquete['enquete_mensuel'] ;
					$this->db_recensement_mensuel->supprimer_activite_recensement_mensuel($idEnquete);
					if($enquete['activite']['activite1'] != null && $enquete['activite']['pourcentage1'] != null ){
						$insertion = $this->db_recensement_mensuel->inserer_activite_enquete(array('enquete_recensement_mensuel'=>$idEnquete,'activite'=>$enquete['activite']['activite1'],'pourcentage'=>$enquete['activite']['pourcentage1']));
						if(!$insertion){
							$erreur_survenu = true;
						}
						
					}
					if($enquete['activite']['activite2'] != null && $enquete['activite']['pourcentage2'] != null ){
						$insertion = $this->db_recensement_mensuel->inserer_activite_enquete(array('enquete_recensement_mensuel'=>$idEnquete,'activite'=>$enquete['activite']['activite2'],'pourcentage'=>$enquete['activite']['pourcentage2']));
						if(!$insertion){
							$erreur_survenu = true;
						}
						
					}
					if($enquete['activite']['activite3'] != null && $enquete['activite']['pourcentage3'] != null ){
						$insertion = $this->db_recensement_mensuel->inserer_activite_enquete(array('enquete_recensement_mensuel'=>$idEnquete,'activite'=>$enquete['activite']['activite3'],'pourcentage'=>$enquete['activite']['pourcentage3']));
						if(!$insertion){
							$erreur_survenu = true;
						}
						
					}
				}
			}
			if($erreur_survenu){
				 $this->db->trans_rollback();
				 echo json_encode(array('result' => false,'title'=>'Erreur non identifié', 'message' => 'Une erreur de serveur a été observée, veuillez vous réferrer à l\'administrateur de la base'));
			}
			else {
				echo json_encode(array('result' => TRUE,'title'=>'Succès', 'message' => 'Les données sont modifiées avec succès','fiche'=>$_POST['fiche']));
			}
		}



	}

