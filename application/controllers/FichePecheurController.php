<?php
	
	class FichePecheurController extends ApplicationController {
		const FICHE_MAX = 9;
		
		public function __construct() {
			parent::__construct();
			
			// Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
		}
		
		public function page_saisie_de_fiche() {
			// chargement de la vue d'insertion et modification dans une variable
			$this->root_states['title'] = 'Fiche du pêcheur';
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/saisie-fiche/pecheur.js'
			);
			$months = $this->mois_francais;
			$current_context_state = array(
				'zone_corecrabes' => $this->db_zone_corecrabe->liste(),
				'enqueteurs' => $this->db_enqueteur->liste_par_type('Pêcheur'),
				'mois' => $months,
				'annee_courante' => intval(date('Y')),
				'mois_courant' => intval(date('m'))
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'saisie-de-fiche-pecheur'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('saisie-fiche/pecheur.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			$this->load->view('index.php', $this->root_states, false);
		}
		
		public function page_insertion_enquete($fiche) {
			$information_fiche = $this->db_fiche->selection_par_id($fiche, 'PEC');
			// chargement de la vue d'insertion et modification dans une variable
			$this->root_states['title'] = 'Ajout de fiche de pêcheur';
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/saisie-fiche/enquete-pecheur.js'
			);
			
			$this->load->library('calendrier', null, 'lib_calendrier');
			$jours_max_du_mois = $this->lib_calendrier->nombre_de_jours_du_mois(intval($information_fiche['mois']), intval($information_fiche['annee']));
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
				'enquete_enregistrees' => $this->db_fiche_pecheur->enquete_total_par_fiche($fiche),
				'jours_nominaux' => array(
					'aujourd\'hui',
					'hier',
					'avant-hier',
					'avant-avant-hier',
				)
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'saisie-de-fiche-pecheur'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('saisie-fiche/enquete-pecheur.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			$this->load->view('index.php', $this->root_states, false);
		}
		
		public function page_modification_de_fiche($fiche) {
			$information_fiche = $this->db_fiche->selection_par_id($fiche, 'PEC');
			$village = $this->db_village->selection_par_id($information_fiche['village']);
			// chargement de la vue d'insertion et modification dans une variable
			$this->root_states['title'] = 'Fiche de Pêcheur';
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/modification-fiche/fiche-pecheur.js'
			);
			$months = $this->mois_francais;
			$current_context_state = array(
				'zone_corecrabes' => $this->db_zone_corecrabe->liste(),
				'enqueteurs' => $this->db_enqueteur->liste_par_type('Pêcheur'),
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
				'active_route' => 'saisie-de-fiche-pecheur'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('modification-fiche/fiche-pecheur.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->modification_autorise(17))
				$this->load->view('index.php', $this->root_states, false);
		}
		
		public function page_consultation() {
			$this->root_states['title'] = 'Consultation des fiches de Pêcheurs volontaires';
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/consultation-fiche/pecheur.js'
			);
			// précision du route courant afin d'ajouter la classe active au lien du composant active
			$etat_menu = array(
				'active_route' => 'consultation-de-fiche-pecheur'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('consultation-fiche/pecheur.php', null, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			$this->load->view('index.php', $this->root_states, false);
			$this->db_historique->archiver("Visite", "Consultation des fiches de Pêcheur");
		}
		
		public function page_detail_enquete($fiche) {
			$fiche_bd = $this->db_fiche->selection_par_id($fiche, 'PEC');
			$enquetes = $this->db_fiche_pecheur->liste_par_fiche($fiche);
			foreach ($enquetes as $iteration_enquete => $enquete) {
				$enquetes[$iteration_enquete]["engins"] = $this->db_engin->selection_engin_fiche_pecheur_par_fiche_pecheur($enquete["id"]);
			}
			$this->root_states['title'] = 'Fiche de Pêcheur N°:' . $fiche_bd['code'];
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/consultation-fiche/pecheur-detail.js'
			);
			// précision du route courant afin d'ajouter la classe active au lien du composant active
			$etat_menu = array(
				'active_route' => 'consultation-de-fiche-pecheur'
			);
			$session_enqueteur = $this->session->userdata('enqueteur');
			$context_state = array(
				'fiche' => $fiche_bd,
				'max_enquete' => self::FICHE_MAX,
				"mois_francais" => $this->mois_francais,
				'enquetes' => $enquetes,
				'identifiant_fiche' => $fiche,
				'engins' => $this->db_engin->liste(),
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(9),
				'autorisation_modification' => $this->lib_autorisation->modification_autorise(14),
				'autorisation_suppression' => $this->lib_autorisation->suppression_autorise(14),
				'enqueteur_responsable' => ($session_enqueteur == null || intval($session_enqueteur['id']) === intval($fiche_bd['enqueteur']))
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('consultation-fiche/pecheur-detail.php', $context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			$this->load->view('index.php', $this->root_states, false);
			$this->db_historique->archiver("Visite", "Consultation de la fiche de Pêcheur de code: ".$fiche_bd["code"]);
		}
		
		public function page_de_modification($fiche_enquete) {
			$enquete_db = $this->db_fiche_pecheur->selection_par_id($fiche_enquete);
			$enquete_db['fiche'] = $this->db_fiche->selection_par_enquete_et_type($fiche_enquete, 'PEC');
			$enquete_db['engins'] = $this->db_engin->selection_engin_fiche_pecheur_par_fiche_pecheur($fiche_enquete);
			$this->root_states['title'] = 'modification de fiche';
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['custom_javascripts'] = array(
				'pages/modification-fiche/pecheur.js',
			);
			// précision du route courant afin d'ajouter la classe active au lien du composant active
			$etat_menu = array(
				'active_route' => 'consultation-de-fiche-pecheur'
			);
			
			$this->load->library('calendrier', null, 'lib_calendrier');
			$jours_max_du_mois = $this->lib_calendrier->nombre_de_jours_du_mois($enquete_db['fiche']['mois'], $enquete_db['fiche']['annee']);
			$maintenant = array('jour' => intval(date('j')), 'mois' => intval(date('n')), 'annee' => intval(date('Y')));
			
			if (intval($enquete_db['fiche']['mois']) == $maintenant['mois'] && intval($enquete_db['fiche']['annee']) == $maintenant['annee']) {
				$jours_max_du_mois = $maintenant['jour'];
			}
			
			$context_state = array(
				'enquete' => $enquete_db,
				'engins' => $this->db_engin->liste(),
				'jours_enquete' => date('j', (new DateTime($enquete_db['date_originale']))->getTimestamp()),
				'jours_max_du_mois' => $jours_max_du_mois,
				'mois_francais' => $this->mois_francais,
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('modification-fiche/enquete-pecheur.php', $context_state, true);
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
				'partenaire_peche_individu' => $_POST['pecheur']['partenaire'],
				'partenaire_peche_nombre' => $_POST['pecheur']['nombre'],
				'consommation_crabe_poids' => $_POST['consommationCrabe']['poids'],
				'consommation_crabe_nombre' => $_POST['consommationCrabe']['nombre'],
				'collecte_poids' => $_POST['crabeVendu']['collecte']['poids'],
				'collecte_prix' => $_POST['crabeVendu']['collecte']['prix'],
				'marche_local_poids' => $_POST['crabeVendu']['marcheLocal']['poids'],
				'marche_local_prix' => $_POST['crabeVendu']['marcheLocal']['prix'],
				'avec_pirogue' => intval($_POST['avecPirogue']) > 0,
			);
			$this->db->trans_begin();
			$insertion = $this->db_fiche_pecheur->inserer($fiche_enquete);
			if (!$insertion) $erreur_survenu = true;
			$derniere_enquete = $this->db_fiche_pecheur->dernier_id();
			foreach ($_POST['engins'] as $engin_fiche_pecheur) {
				$engin_fiche_pecheur = array(
					'fiche_pecheur' => $derniere_enquete,
					'engin' => $engin_fiche_pecheur['nom'],
					'nombre' => intval($engin_fiche_pecheur['nombre'])
				);
				$insertion = $this->db_engin->inserer_engin_fiche_pecheur($engin_fiche_pecheur);
				if (!$insertion) $erreur_survenu = true;
			}
			if ($erreur_survenu) $this->db->trans_rollback();
			else $this->db->trans_commit();
			echo json_encode(array('succes' => !$erreur_survenu));
		}
		
		public function operation_mise_a_jour() {
			$erreur_survenu = false;
			$id_fiche_enqueteur = intval($_POST['enquete']);
			$fiche_enquete = array(
				'date' => $_POST['date'],
				'partenaire_peche_individu' => $_POST['pecheur']['partenaire'],
				'partenaire_peche_nombre' => $_POST['pecheur']['nombre'],
				'consommation_crabe_poids' => $_POST['consommationCrabe']['poids'],
				'consommation_crabe_nombre' => $_POST['consommationCrabe']['nombre'],
				'collecte_poids' => $_POST['crabeVendu']['collecte']['poids'],
				'collecte_prix' => $_POST['crabeVendu']['collecte']['prix'],
				'marche_local_poids' => $_POST['crabeVendu']['marcheLocal']['poids'],
				'marche_local_prix' => $_POST['crabeVendu']['marcheLocal']['prix'],
				'avec_pirogue' => intval($_POST['avecPirogue']) > 0,
			);
			$this->db->trans_begin();
			$insertion = $this->db_fiche_pecheur->mettre_a_jour($fiche_enquete, $id_fiche_enqueteur);
			if (!$insertion) $erreur_survenu = true;
			$insertion = $this->db_engin->supprimer_engin_fiche_pecheur($id_fiche_enqueteur);
			if (!$insertion) $erreur_survenu = true;
			foreach ($this->input->post("engins") as $engin) {
				$engin = array(
					'fiche_pecheur' => $id_fiche_enqueteur,
					'engin' => $engin['nom'],
					'nombre' => intval($engin['nombre'])
				);
				$insertion = $this->db_engin->inserer_engin_fiche_pecheur($engin);
				if (!$insertion) $erreur_survenu = true;
			}
			if ($erreur_survenu) $this->db->trans_rollback();
			else $this->db->trans_commit();
			echo json_encode(array('succes' => !$erreur_survenu));
		}
		
		public function operation_suppression($fiche_enquete) {
			echo json_decode($this->db_fiche_pecheur->supprimer($fiche_enquete));
		}
	}

?>
