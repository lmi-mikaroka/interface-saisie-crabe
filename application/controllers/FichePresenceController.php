<?php

	

	class FichePresenceController extends ApplicationController {
        public function __construct() {
			parent::__construct();
            $this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
		}
        public function page_saisie_de_fiche() {
            $this->root_states['title'] = 'Fiche de recensement';	
			$this->root_states['custom_javascripts'] = array(
				'pages/saisie-fiche/fiche-presence.js'
			);
            $current_context_state = array(

				'zone_corecrabes' => $this->db_zone_corecrabe->liste(),

				'enqueteurs' => $this->db_enqueteur->liste_par_tous(),

			);
            $etat_menu = array(
                
				'active_route' => 'saisie-de-fiche-presence'
			);
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('saisie-fiche/fiche-presence.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			$this->load->view('index.php', $this->root_states, false);

        }

		public function pecheur_existe_presence(){
			$pecheur = $this->db_fiche_presence->liste_fiche_presence($_POST['village']);
			// $pecheur = $this->db_fiche_presence->liste_fiche_presence_trie($_POST['village']);
			$colonnes = $_POST['colonne'];
			foreach ($pecheur as $key => $pech) {
				$i = 0;
				$pecheur[$key]['enquetes'] = $this->db_fiche_presence->fiche_presence_liste($pech['id'],$colonnes);
				
			}
			echo json_encode($pecheur);
		}
		public function insertion(){
			$erreur_survenu = false;
			$data = array(
				'village'=>$_POST['village'],
				'enquete'=>$_POST['enquete'],
				'date'=>$_POST['date']
				
			);
			foreach($data['enquete'] as $enq){
				$pecheur = $enq['pecheur'];
				$enquetes = $enq['enquetes'];
				foreach($enquetes as $enqs){
					$annee= $enqs['annee'];
					$mois=$enqs['mois'];
					$crabe= $enqs['crabe'];
					$idfiche=null;
					$existe = $this->db_fiche_presence->existe(array('village'=>$data['village'],'annee'=>$annee,'mois'=>$mois));
					if($existe){
						$idfiche = $this->db_fiche_presence->existe_id(array('village'=>$data['village'],'annee'=>$annee,'mois'=>$mois));	
					}
					else{
						$insertion = $this->db_fiche_presence->inserer(array(
							'village'=>$data['village'],
							'annee'=>$annee,
							'mois'=>$mois,
							'date'=>$data['date']
						));
						if(!$insertion){
						   $erreur_survenu = true;
						}
					//    $idfiche = $this->db_fiche_presence->dernier_id();
					$idfiche = $this->db_fiche_presence->fiche_presence_id(array(
						'village'=>$data['village'],
						'annee'=>$annee,
						'mois'=>$mois,
						'date'=>$data['date']
					));
				   }
				   $enquete_existe_presence= array(
					'recensement_mensuel_prime'=>$idfiche,
					'pecheur'=>$pecheur
					
				   );
				   $existe_presence = $this->db_fiche_presence->existe_presence($enquete_existe_presence);
				   if($existe_presence){
					$existe_presence_id = $this->db_fiche_presence->existe_presence_id($enquete_existe_presence);
					$insertion = $this->db_fiche_presence->mettre_a_jour_enquete(array('crabe'=>$crabe),$existe_presence_id);
					if(!$insertion){
						$erreur_survenu = true;
					 }
				   }
				   else{
					$data_enquete = array('pecheur'=>$pecheur,'recensement_mensuel_prime'=>$idfiche,'crabe'=>$crabe);
					$insertion = $this->db_fiche_presence->inserer_enquete($data_enquete);
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
			   echo json_encode(array('result' => TRUE,'title'=>'Succès', 'message' => 'Les données sont inserées avec succès','fiche'=>'1'));
		   }
		}
		public function consultation() {
            $this->root_states['title'] = 'Fiche de recensement';	
			$this->root_states['custom_javascripts'] = array(
				'pages/consultation-fiche/fiche-presence.js'
			);
            $current_context_state = array(

				'zone_corecrabes' => $this->db_zone_corecrabe->liste(),

				'enqueteurs' => $this->db_enqueteur->liste_par_tous(),

			);
            $etat_menu = array(
                
				'active_route' => 'consultation-de-fiche-presence'
			);
            // rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('consultation-fiche/fiche-presence.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			$this->load->view('index.php', $this->root_states, false);

        }

		public function enquete_existe_presence(){
			$pecheurs = $this->db_fiche_presence->liste_fiche_presence($_POST['village']);
			// $pecheurs = $this->db_fiche_presence->liste_fiche_presence_trie($_POST['village']);
			$colonnes = $_POST['colonne'];
			$count=0;
            foreach ($pecheurs as $key => $pecheur) {
				$i = 0;
            //    foreach($colonnes as $colonne){
			// 	$crabe = $this->db_fiche_presence->requeteCrabe($_POST['village'],$pecheur['id'],$colonne['annee'],$colonne['mois']);
			// 	$nb= count($crabe);
			// 	$data = '';
			// 	if($nb>0){
			// 		$data=$crabe[0]['crabe'];
			// 	}
			// 	$pecheurs[$key]['enquetes'][$i]['crabe']= $data;
			// 	$pecheurs[$key]['enquetes'][$i]['mois']= $colonne['mois'];
			// 	$pecheurs[$key]['enquetes'][$i]['annee']= $colonne['annee'];
			// 	$i++;
			//    }
			   $pecheurs[$key]['enquetes'] = $this->db_fiche_presence->fiche_presence_liste($pecheur['id'],$colonnes);
			   $pecheurs[$key]['ligne']=$count+1;
			   $count++;
				
			}
			echo json_encode($pecheurs);
		}


    }
