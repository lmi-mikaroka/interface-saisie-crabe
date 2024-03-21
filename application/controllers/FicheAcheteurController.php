<?php
	
	class FicheAcheteurController extends ApplicationController {
		const FICHE_MAX = 5;
		
		public function __construct() {
			parent::__construct();
			
			// Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
		}
		
		public function page_saisie_de_fiche() {
			// chargement de la vue d'insertion et modification dans une variable
			$this->root_states['title'] = 'Fiche d\'acheteur';
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/saisie-fiche/acheteur.js'
			);
			$months = $this->mois_francais;
			$current_context_state = array(
				'zone_corecrabes' => $this->db_zone_corecrabe->liste(),
				'enqueteurs' => $this->db_enqueteur->liste_par_type('Acheteur'),
				'mois' => $months,
				'annee_courante' => intval(date('Y')),
				'mois_courant' => intval(date('m'))
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'saisie-de-fiche-acheteur'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('saisie-fiche/acheteur.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			$this->load->view('index.php', $this->root_states, false);
		}
		
		public function page_insertion_enquete($fiche) {
			$information_fiche = $this->db_fiche->selection_par_id($fiche, 'ACH');
			// chargement de la vue d'insertion et modification dans une variable
			$this->root_states['title'] = 'Ajout de fiche d\'echêteur';
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/saisie-fiche/enquete-acheteur.js'
			);
			
			$this->load->library('calendrier', null, 'lib_calendrier');
			$jours_max_du_mois = $this->lib_calendrier->nombre_de_jours_du_mois($information_fiche['mois'], $information_fiche['annee']);
			$maintenant = array('jour' => intval(date('j')), 'mois' => intval(date('n')), 'annee' => intval(date('Y')));
			
			if (intval($information_fiche['mois']) == $maintenant['mois'] && intval($information_fiche['annee']) == $maintenant['annee']) {
				$jours_max_du_mois = $maintenant['jour'];
			}
			
			$current_context_state = array(
				'fiche' => $information_fiche,
				'jours_max_du_mois' => $jours_max_du_mois,
				'mois_francais' => $this->mois_francais,
				'pecheurs' => $this->db_pecheur->liste_par_village($information_fiche['village']),
				'engins' => $this->db_engin->liste(),
				'max_enquete' => self::FICHE_MAX,
				'enquete_enregistrees' => $this->db_fiche_acheteur->total_enquete_par_fiche($fiche),
				'jours_nominaux' => array(
					'Aujourd\'hui',
					'Hier',
					'Avant-hier',
					'Avant-avant-hier',
				)
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'saisie-de-fiche-acheteur'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('saisie-fiche/enquete-acheteur.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			$this->load->view('index.php', $this->root_states, false);
		}
		
		public function page_modification_de_fiche($fiche) {
			$information_fiche = $this->db_fiche->selection_par_id($fiche, 'ACH');
			$village = $this->db_village->selection_par_id($information_fiche['village']);
			// chargement de la vue d'insertion et modification dans une variable
			$this->root_states['title'] = 'Fiche d\'Acheteur';
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/modification-fiche/fiche-acheteur.js'
			);
			$months = $this->mois_francais;
			$current_context_state = array(
				'zone_corecrabes' => $this->db_zone_corecrabe->liste(),
				'enqueteurs' => $this->db_enqueteur->liste_par_type('Acheteur'),
				'mois' => $months,
				'annee_courante' => intval(date('Y')),
				'mois_courant' => intval(date('m')),
				'droit_de_modification' => $this->lib_autorisation->modification_autorise(11),
				'fiche' => $information_fiche,
				'village' => $village,
				'zone_corecrabe' => $this->db_zone_corecrabe->selection_par_village($village['id'])
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'saisie-de-fiche-acheteur'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('modification-fiche/fiche-acheteur.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->modification_autorise(17))
				$this->load->view('index.php', $this->root_states, false);
		}
		
		public function page_consultation() {
			$this->root_states['title'] = 'Consultation des fiches d\'Acheteurs';
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/consultation-fiche/acheteur.js'
			);
			// précision du route courant afin d'ajouter la classe active au lien du composant active
			$etat_menu = array(
				'active_route' => 'consultation-de-fiche-acheteur'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('consultation-fiche/acheteur.php', null, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			$this->load->view('index.php', $this->root_states, false);
			$this->db_historique->archiver("Visite", "Consultation des fiches d'Acheteur");
		}
		
		public function page_detail_enquete($fiche) {
			$fiche_bd = $this->db_fiche->selection_par_id($fiche, 'ACH');
			$enquetes = $this->db_fiche_acheteur->liste_par_fiche($fiche);
			foreach ($enquetes as $iteration_enquete => $enquete) {
				$enquetes[$iteration_enquete]["pecheur"] = $this->db_pecheur->selection_par_id($enquete["pecheur"]);
				$enquetes[$iteration_enquete]["pecheur"]["nombre"] = $enquete["pecheur_nombre"];
				$enquetes[$iteration_enquete]["sortie_de_peche"] = $this->db_fiche_acheteur->selection_dernier_sortie_de_peche($enquete["id"]);
				foreach ($enquetes[$iteration_enquete]["sortie_de_peche"] as $iteration_sortie_de_peche => $sortie_de_peche) {
					$enquetes[$iteration_enquete]["sortie_de_peche"][$iteration_sortie_de_peche]["engins"] = $this->db_engin->selection_engin_sortie_de_peche_acheteur_par_sortie_de_peche_acheteur($sortie_de_peche["id"]);
				}
			}
			$this->root_states['title'] = 'Fiche d\'Acheteur N°:' . $fiche_bd['code'];
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/consultation-fiche/acheteur-detail.js'
			);
			// précision du route courant afin d'ajouter la classe active au lien du composant active
			$etat_menu = array(
				'active_route' => 'consultation-de-fiche-acheteur'
			);
			$session_enqueteur = $this->session->userdata('enqueteur');
			$context_state = array(
				'fiche' => $fiche_bd,
				'max_enquete' => self::FICHE_MAX,
				'enquetes' => $enquetes,
				'identifiant_fiche' => $fiche,
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(10),
				'autorisation_modification' => $this->lib_autorisation->modification_autorise(19),
				'autorisation_suppression' => $this->lib_autorisation->suppression_autorise(17),
				'enqueteur_responsable' => ($session_enqueteur == null || intval($session_enqueteur['id']) === intval($fiche_bd['enqueteur']))
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('consultation-fiche/acheteur-detail.php', $context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			$this->load->view('index.php', $this->root_states, false);
			$this->db_historique->archiver("Visite", "Consultation de la fiche d'Acheteur de code: ".$fiche_bd["code"]);
		}
		
		public function page_de_modification($fiche_enquete) {
			$enquete_db = $this->db_fiche_acheteur->selection_par_id($fiche_enquete);
			$enquete_db['fiche'] = $this->db_fiche->selection_par_enquete_et_type($fiche_enquete, 'ACH');
			$enquete_db['derniere_sortie_acheteur'] = $this->db_fiche_acheteur->selection_dernier_sortie_de_peche($fiche_enquete);
			foreach ($enquete_db['derniere_sortie_acheteur'] as $indexe => $dernier_sortie_pecheur) {
				$enquete_db['derniere_sortie_acheteur'][$indexe]['engins'] = $this->db_engin->selection_engin_sortie_de_peche_acheteur_par_sortie_de_peche_acheteur($dernier_sortie_pecheur['id']);
			}
			$this->root_states['title'] = 'modification de fiche';
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/modification-fiche/acheteur.js',
			);
			// précision du route courant afin d'ajouter la classe active au lien du composant active
			$etat_menu = array(
				'active_route' => 'consultation-de-fiche-acheteur'
			);
			
			$this->load->library('calendrier', null, 'lib_calendrier');
			$jours_max_du_mois = $this->lib_calendrier->nombre_de_jours_du_mois($enquete_db['fiche']['mois'], $enquete_db['fiche']['annee']);
			$maintenant = array('jour' => intval(date('j')), 'mois' => intval(date('n')), 'annee' => intval(date('Y')));
			
			if (intval($enquete_db['fiche']['mois']) == $maintenant['mois'] && intval($enquete_db['fiche']['annee']) == $maintenant['annee']) {
				$jours_max_du_mois = $maintenant['jour'];
			}
			
			$date_courant = strtotime($enquete_db['date']);
			$context_state = array(
				'enquete' => $enquete_db,
				'jours_max_du_mois' => $jours_max_du_mois,
				'mois_francais' => $this->mois_francais,
				'jours_enquete' => date('j', (new DateTime($enquete_db['date']))->getTimestamp()),
				'pecheurs' => $this->db_pecheur->liste_par_village($enquete_db['fiche']['village']),
				'engins' => $this->db_engin->liste(),
				'date_de_sortie' => array(
					date('d/m/Y', $date_courant),
					date('d/m/Y', $date_courant - (60 * 60 * 24)),
					date('d/m/Y', $date_courant - (60 * 60 * 24 * 2)),
					date('d/m/Y', $date_courant - (60 * 60 * 24 * 3)),
				),
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('modification-fiche/enquete-acheteur.php', $context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			$this->load->view('index.php', $this->root_states, false);
		}
		
		public function operation_insertion() {
			$erreur_survenu = false;
			$fiche_enquete = array(
				'fiche' => $_POST['fiche'],
				'date' => $_POST['date'],
				'pecheur' => $_POST['pecheur'],
				'pecheur_nombre' => $_POST['nombrePecheur'],
				'collecte_poids1' => $_POST['venteCrabe']['collecte'][0]['poids'],
				'collecte_prix1' => null,
				'collecte_poids2' => null,
				'collecte_prix2' => null,
				'marche_local_poids' => $_POST['venteCrabe']['marcheLocal']['poids'],
				'marche_local_prix' => empty($_POST['venteCrabe']['marcheLocal']['prix']) ? 0 : intval($_POST['venteCrabe']['marcheLocal']['prix']),
				'crabe_non_vendu_poids' => $_POST['crabeNonVendu']['poids'],
				'crabe_non_vendu_nombre' => $_POST['crabeNonVendu']['nombre'],
				"nombre_sortie_vente" => $this->input->post("nombreSortieVente")
			);
			if (!empty($_POST['venteCrabe']['collecte'][1]['poids'])) {
				$fiche_enquete['collecte_poids2'] = $_POST['venteCrabe']['collecte'][1]['poids'];
			}
			if (!empty($_POST['venteCrabe']['collecte'][1]['prix'])) {
				$fiche_enquete['collecte_prix2'] = $_POST['venteCrabe']['collecte'][1]['prix'];
			}
			if (!empty($_POST['venteCrabe']['collecte'][0]['prix'])) {
				$fiche_enquete['collecte_prix1'] = $_POST['venteCrabe']['collecte'][0]['prix'];
			}
			$this->db->trans_begin();
			$insertion = $this->db_fiche_acheteur->insertion_fiche($fiche_enquete);
			$reference_fiche = $this->db_fiche_acheteur->derniere_fiche();
			if (!$insertion) $erreur_survenu = true;
			$derniers_sortie_de_peche = $_POST['dernierSortieDePeche'];
			foreach ($derniers_sortie_de_peche as $sortie) {
				$dernier_sortie = array(
					'date' => $sortie['date'],
					'nombre' => $sortie['nombre'],
					'pirogue' => $sortie['pirogue'],
					'fiche_acheteur' => $reference_fiche
				);
				$insertion = $this->db_fiche_acheteur->insertion_dernier_sortie($dernier_sortie);
				$id_sortier_de_peche_acheteur_insere = $this->db_fiche_acheteur->derniere_sortie_de_peche();
				if (!$insertion) $erreur_survenu = true;
				foreach ($sortie['engins'] as $engin) {
					$db_engin = array(
						'sortie_de_peche_acheteur' => $id_sortier_de_peche_acheteur_insere,
						'engin' => $engin['nom'],
						'nombre' => $engin['nombre']
					);
					$insertion = $this->db_engin->inserer_engin_sortie_de_peche_acheteur($db_engin);
					if (!$insertion) $erreur_survenu = true;
				}
			}
			
			if ($erreur_survenu) $this->db->trans_rollback();
			else $this->db->trans_commit();
			echo json_encode(array('succes' => $derniers_sortie_de_peche));
		}
		
		public function operation_suppression($fiche) {
			echo json_encode($this->db_fiche_acheteur->supprimer_fiche_acheteur($fiche));
		}
		
		public function operation_mise_a_jour() {
			$erreur_survenu = false;
			$id_fiche_acheteur = $_POST['enquete'];
			$fiche_enquete = array(
				'date' => $_POST['date'],
				'pecheur' => $_POST['pecheur'],
				'pecheur_nombre' => $_POST['nombrePecheur'],
				'collecte_poids1' => $_POST['venteCrabe']['collecte'][0]['poids'],
				'collecte_prix1' => ($_POST['venteCrabe']['collecte'][0]['prix']=='')?null:$_POST['venteCrabe']['collecte'][0]['prix'],
				'collecte_poids2' => null,
				'collecte_prix2' => null,
				'marche_local_poids' => $_POST['venteCrabe']['marcheLocal']['poids'],
				'marche_local_prix' => empty($_POST['venteCrabe']['marcheLocal']['prix']) ? 0 : intval($_POST['venteCrabe']['marcheLocal']['prix']),
				'crabe_non_vendu_poids' => $_POST['crabeNonVendu']['poids'],
				'crabe_non_vendu_nombre' => $_POST['crabeNonVendu']['nombre'],
				"nombre_sortie_vente" => $this->input->post("nombreSortieVente")
			);
			if (!empty($_POST['venteCrabe']['collecte'][1]['poids'])) {
				$fiche_enquete['collecte_poids2'] = $_POST['venteCrabe']['collecte'][1]['poids'];
			}
			if (!empty($_POST['venteCrabe']['collecte'][1]['prix'])) {
				$fiche_enquete['collecte_prix2'] = $_POST['venteCrabe']['collecte'][1]['prix'];
			}
			$this->db->trans_begin();
			$insertion = $this->db_fiche_acheteur->modification_fiche($fiche_enquete, $id_fiche_acheteur);
			#$id_fiche_acheteur = $this->db_fiche_acheteur->derniere_fiche();
			if (!$insertion) $erreur_survenu = true;
			$derniers_sortie_de_peche = $_POST['derniereSortieDePeches'];
			$insertion = $this->db_fiche_acheteur->supprimer_sortie_de_peche_par_fiche($id_fiche_acheteur);
			if (!$insertion) $erreur_survenu = true;
			foreach ($derniers_sortie_de_peche as $sortie) {
				$dernier_sortie = array(
					'date' => $sortie['date'],
					'nombre' => $sortie['nombre'],
					'pirogue' => $sortie['pirogue'],
					'fiche_acheteur' => $id_fiche_acheteur
				);
				$insertion = $this->db_fiche_acheteur->insertion_dernier_sortie($dernier_sortie);
				$id_sortie_de_peche = $this->db_fiche_acheteur->derniere_sortie_de_peche();
				if (!$insertion) $erreur_survenu = true;
				foreach ($sortie['engins'] as $engin) {
					$db_engin = array(
						'sortie_de_peche_acheteur' => $id_sortie_de_peche,
						'engin' => $engin['nom'],
						'nombre' => $engin['nombre']
					);
					$insertion = $this->db_engin->inserer_engin_sortie_de_peche_acheteur($db_engin);
					if (!$insertion) $erreur_survenu = true;
				}
			}

			$id_enquete_suivi = 'ACH_'.$id_fiche_acheteur;
			
			$insertion = $this->db_suivi_prime->archiver($id_enquete_suivi);

			if(!$insertion)$erreur_survenu = true;
			
			if ($erreur_survenu) $this->db->trans_rollback();
			else $this->db->trans_commit();
			echo json_encode(array('succes' => !$erreur_survenu));
		}
	}
