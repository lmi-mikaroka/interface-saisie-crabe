<?php

	

	class FicheEnqueteurController extends ApplicationController {

		const FICHE_MAX = 2;

		

		public function __construct() {

			parent::__construct();

			

			// Chargement des composants statiques de bases (header, footer)

			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);

			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);

		}

		

		public function page_saisie_de_fiche() {

			// chargement de la vue d'insertion et modification dans une variable

			$this->root_states['title'] = 'Fiche d\'enquêteur';

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/saisie-fiche/enqueteur.js'

			);

			$months = $this->mois_francais;

			$current_context_state = array(

				'zone_corecrabes' => $this->db_zone_corecrabe->liste(),

				'mois' => $months,

				'annee_courante' => intval(date('Y')),

				'mois_courant' => intval(date('m')),

				'droit_de_creation' => $this->lib_autorisation->creation_autorise(8)

			);

			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif

			$etat_menu = array(

				'active_route' => 'saisie-de-fiche-enqueteur'

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('saisie-fiche/enqueteur.php', $current_context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			if ($this->lib_autorisation->visualisation_autorise(8))

				$this->load->view('index.php', $this->root_states, false);

		}

		

		public function page_modification_de_fiche($fiche) {

			$information_fiche = $this->db_fiche->selection_par_id($fiche, 'ENQ');

			$village = $this->db_village->selection_par_id($information_fiche['village']);

			// chargement de la vue d'insertion et modification dans une variable

			$this->root_states['title'] = 'Fiche d\'enquêteur';

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/modification-fiche/fiche-enqueteur.js'

			);

			$months = $this->mois_francais;

			$current_context_state = array(

				'zone_corecrabes' => $this->db_zone_corecrabe->liste(),

				'enqueteurs' => $this->db_enqueteur->liste_par_type('Enquêteur'),

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

				'active_route' => 'saisie-de-fiche-enqueteur'

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('modification-fiche/fiche-enqueteur.php', $current_context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			if ($this->lib_autorisation->modification_autorise(11))

				$this->load->view('index.php', $this->root_states, false);

		}

		

		public function page_insertion_enquete($fiche) {

			$this->root_states['title'] = 'ajout de fiche d\'enquêteur';

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/saisie-fiche/enquete-enqueteur.js',

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'saisie-de-fiche-enqueteur'

			);

			$information_fiche = $this->db_fiche->selection_par_id($fiche, 'ENQ');

			

			$this->load->library('calendrier', null, 'lib_calendrier');

			$jours_max_du_mois = $this->lib_calendrier->nombre_de_jours_du_mois($information_fiche['mois'], $information_fiche['annee']);

			$maintenant = array('jour' => intval(date('j')), 'mois' => intval(date('n')), 'annee' => intval(date('Y')));

			

			if (intval($information_fiche['mois']) == $maintenant['mois'] && intval($information_fiche['annee']) == $maintenant['annee']) {

				$jours_max_du_mois = $maintenant['jour'];

			}

			

			$donnees_contexte = array(

				'fiche' => $information_fiche,

				'jours_max_du_mois' => $jours_max_du_mois,

				'mois_francais' => $this->mois_francais,

				'pecheurs' => $this->db_pecheur->liste_par_village($information_fiche['village']),

				'engins' => $this->db_engin->liste(),

				'jours_nominaux' => array(

					'Aujourd\'hui',

					'Hier',

					'Avant-hier',

					'Avant-avant-hier',

				),

				'max_enquete' => self::FICHE_MAX,

				'enquete_enregistrees' => $this->db_fiche_enqueteur->enquete_totale_par_fiche($fiche),

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('saisie-fiche/enquete-enqueteur.php', $donnees_contexte, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

		}

		

		public function page_consultation() {

			$this->root_states['title'] = 'Consultation des enquetes';

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/consultation-fiche/enquete.js'

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-enqueteur'

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('consultation-fiche/enquete.php', null, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

			$this->db_historique->archiver("Visite", "Consultation des fiches d'Enquêteur");

		}

		

		public function page_detail_enquete($fiche) {

			$fiche_bd = $this->db_fiche->selection_par_id($fiche, 'ENQ');

			$enquetes = $this->db_fiche_enqueteur->selection_par_fiche($fiche);

			foreach ($enquetes as $iteration_enquete => $enquete) {

				$enquetes[$iteration_enquete]["sortie_de_peche"] = $this->db_fiche_enqueteur->selection_sortie_de_peche_par_fiche_enqueteur($enquete["id"]);

				$enquetes[$iteration_enquete]["echantillon"] = $this->db_echantillon->selection_par_fiche_enqueteur($enquete["id"]);

				$enquetes[$iteration_enquete]["echantillon"]["crabes"] = $this->db_crabe->selection_par_echantillon($enquetes[$iteration_enquete]["echantillon"]["id"]);

				foreach ($enquetes[$iteration_enquete]["sortie_de_peche"] as $iteration_sortie_de_peche => $sortie_de_peche) {

					$enquetes[$iteration_enquete]["sortie_de_peche"][$iteration_sortie_de_peche]["engins"] = $this->db_engin->selection_engin_sortie_de_peche_enqueteur_par_sortie_de_peche_enqueteur($sortie_de_peche["id"]);

				}

			}

			$this->root_states['title'] = 'Fiche d\'Enquêteur N°:' . $fiche_bd['code'];

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/consultation-fiche/enquete-detail.js'

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-enqueteur'

			);

			

			$session_enqueteur = $this->session->userdata('enqueteur');

			$context_state = array(

				'fiche' => $fiche_bd,

				'enquetes' => $enquetes,

				'max_enquete' => self::FICHE_MAX,

				'autorisation_creation' => $this->lib_autorisation->creation_autorise(8),

				'autorisation_modification' => $this->lib_autorisation->modification_autorise(13),

				'autorisation_suppression' => $this->lib_autorisation->suppression_autorise(11),

				'enqueteur_responsable' => ($session_enqueteur == null || intval($session_enqueteur['id']) === intval($fiche_bd['enqueteur']))

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('consultation-fiche/enquete-detail.php', $context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

			$this->db_historique->archiver("Visite", "Consultation de la fiche d'Enquêteur de code: ".$fiche_bd["code"]);

		}

		

		public function page_de_modification($fiche_enquete) {

			$enquete_db = $this->db_fiche_enqueteur->selection_par_id($fiche_enquete);

			$enquete_db['fiche'] = $this->db_fiche->selection_par_enquete_et_type($fiche_enquete, 'ENQ');

			$enquete_db['sortie_de_peches'] = $this->db_fiche_enqueteur->selection_sortie_de_peche_par_fiche_enqueteur($fiche_enquete);

			$enquete_db['echantillon'] = $this->db_echantillon->selection_par_fiche_enqueteur($fiche_enquete);

			$enquete_db['echantillon']['crabes'] = $this->db_crabe->selection_par_echantillon($enquete_db['echantillon']['id']);

			foreach ($enquete_db['sortie_de_peches'] as $indexe => $sortie_de_peche_enqueteur) {

				$enquete_db['sortie_de_peches'][$indexe]['engins'] = $this->db_engin->selection_engin_sortie_de_peche_enqueteur_par_sortie_de_peche_enqueteur($sortie_de_peche_enqueteur['id']);

			}

			$this->root_states['title'] = 'modification de fiche';

			

			$this->load->library('calendrier', null, 'lib_calendrier');

			$jours_max_du_mois = $this->lib_calendrier->nombre_de_jours_du_mois($enquete_db['fiche']['mois'], $enquete_db['fiche']['annee']);

			$maintenant = array('jour' => intval(date('j')), 'mois' => intval(date('n')), 'annee' => intval(date('Y')));

			

			if (intval($enquete_db['fiche']['mois']) == $maintenant['mois'] && intval($enquete_db['fiche']['annee']) == $maintenant['annee']) {

				$jours_max_du_mois = $maintenant['jour'];

			}

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/modification-fiche/enquete.js',

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-enqueteur'

			);

			

			$date_courant = strtotime($enquete_db['date_originale']);

			$context_state = array(

				'enquete' => $enquete_db,

				'jours_enquete' => date('j', (new DateTime($enquete_db['date_originale']))->getTimestamp()),

				'jours_max_du_mois' => $jours_max_du_mois,

				'mois_francais' => $this->mois_francais,

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

			$this->application_component['context_component'] = $this->load->view('modification-fiche/enquete-enqueteur.php', $context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

		}

		

		public function operation_mise_a_jour() {

			$fiche_enquete = array(

				'date' => $_POST['date'],

				'participant_individu' => $_POST['participant'],

				'participant_nombre' => $_POST['nombreParticipant'],

				'capture_poids' => $_POST['poidsTotalDeLaCapture'],

				'crabe_consomme_poids' => $_POST['crabeConsomme']['poids'],

				'crabe_consomme_nombre' => null,

				'collecte_poids1' => $_POST['venteDeCrabe']['collecte'][0]['poids'],

				'collecte_poids2' => null,

				'collecte_prix1' => $_POST['venteDeCrabe']['collecte'][0]['prix'],

				'collecte_prix2' => null,

				'marche_local_poids' => $_POST['venteDeCrabe']['marcheLocal']['poids'],

				'marche_local_prix' => empty($_POST['venteDeCrabe']['marcheLocal']['prix']) ? 0 : intval($_POST['venteDeCrabe']['marcheLocal']['prix']),

				'pecheur' => $_POST['pecheur'],

				"nombre_sortie_capture" => $this->input->post("nombreSortieCapture")

			);

			if ($_POST['crabeConsomme']['nombre'] !== '') {

				$fiche_enquete['crabe_consomme_nombre'] = $_POST['crabeConsomme']['nombre'];

			}

			if ($_POST['venteDeCrabe']['collecte'][1]['poids'] !== '') {

				$fiche_enquete['collecte_poids2'] = $_POST['venteDeCrabe']['collecte'][1]['poids'];

			}

			if ($_POST['venteDeCrabe']['collecte'][1]['prix'] !== '') {

				$fiche_enquete['collecte_prix2'] = $_POST['venteDeCrabe']['collecte'][1]['prix'];

			}

			$this->db->trans_begin();

			$erreurExecution = false;

			$insertion = $this->db_fiche_enqueteur->mettre_a_jour($fiche_enquete, $_POST['ficheEnquete']);

			if (!$insertion) $erreurExecution = true;

			$id_fiche_enqueteur = $_POST['ficheEnquete'];

			$insertion = $this->db_fiche_enqueteur->supprimer_sortie_de_peche_par_enquete($id_fiche_enqueteur);

			if (!$insertion) $erreurExecution = true;

			foreach ($_POST['dernierSortieDePeches'] as $iteration_sortie_de_peche) {

				$dernier_sortie_de_peche = array(

					'fiche_enqueteur' => $id_fiche_enqueteur,

					'nombre' => $iteration_sortie_de_peche['nombreDeSortie'],

					'pirogue' => $iteration_sortie_de_peche['nombreDePirogue'],

					'date' => $iteration_sortie_de_peche['date'],

				);

				$insertion = $this->db_fiche_enqueteur->inserer_sortie_de_peche($dernier_sortie_de_peche);

				if (!$insertion) $erreurExecution = true;

				$id_sortie_de_peche = $this->db_fiche_enqueteur->selection_id_sortie_de_peche_par_enquete_et_date($id_fiche_enqueteur, $iteration_sortie_de_peche['date']);

				$insertion = $this->db_engin->supprimer_engin_sortie_de_pecheur_enqueteur_par_sortie_de_peche($id_sortie_de_peche);

				if (!$insertion) $erreurExecution = true;

				foreach ($iteration_sortie_de_peche['engins'] as $iteration_engin_de_peche) {

					$engin_sortie_de_peche_enqueteur = array(

						'sortie_de_peche_enqueteur' => $id_sortie_de_peche,

						'engin' => $iteration_engin_de_peche['nom'],

						'nombre' => $iteration_engin_de_peche['nombre']

					);

					$insertion = $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin_sortie_de_peche_enqueteur);

					if (!$insertion) $erreurExecution = true;

				}

			}

			if (!$insertion) $erreurExecution = true;

			$echantillon = array(

				'trie' => $_POST['echantillon']['trie'],

				'poids' => null,

				'taille_absente' => $_POST['echantillon']['tailleAbsente']['taille'],

				'taille_absente_autre' => $_POST['echantillon']['tailleAbsente']['precision'],

			);

			if ($_POST['echantillon']['poids'] !== '' || $_POST['echantillon']['poids'] != null) {

				$echantillon['poids'] = $_POST['echantillon']['poids'];

			}else{
				$echantillon['poids'] = $_POST['poidsTotalDeLaCapture'];
			}

			$insertion = $this->db_echantillon->mettre_a_jour($_POST['ficheEnquete'], $echantillon);

			if (!$insertion) $erreurExecution = true;

			$id_echantillon = $this->db_echantillon->selection_id_par_fiche_enqueteur($id_fiche_enqueteur);

			$this->db_crabe->supprimer_crabe_par_echantillon($id_echantillon);

			foreach ($_POST['echantillon']['crabes'] as $iteration_crabe) {

				$crabe = array(

					'echantillon' => $id_echantillon,

					'sexe' => $iteration_crabe['sexe'],

					'taille' => $iteration_crabe['taille'],

					'destination' => $iteration_crabe['destination'],

				);

				$insertion = $this->db_crabe->insertion($crabe);

				if (!$insertion) $erreurExecution = true;

			}

			

			if ($erreurExecution) $this->db->trans_rollback();

			else $this->db->trans_commit();

			echo json_encode(array('succes' => $insertion));

		}

		

		public function operation_suppression($fiche) {

			echo json_encode($this->db_fiche_enqueteur->supprimer($fiche));

		}

		

		public function operation_insertion() {

			$fiche_enquete = array(

				'fiche' => $_POST['fiche'],

				'date' => $_POST['date'],

				'participant_individu' => $_POST['participant'],

				'participant_nombre' => $_POST['nombreParticipant'],

				'capture_poids' => $_POST['poidsTotalDeLaCapture'],

				'crabe_consomme_poids' => $_POST['crabeConsomme']['poids'],

				'crabe_consomme_nombre' => null,

				'collecte_poids1' => $_POST['venteDeCrabe']['collecte'][0]['poids'],

				'collecte_poids2' => null,

				'collecte_prix1' => 0,

				'collecte_prix2' => null,

				'marche_local_poids' => $_POST['venteDeCrabe']['marcheLocal']['poids'],

				'marche_local_prix' => empty($_POST['venteDeCrabe']['marcheLocal']['prix']) ? 0 : intval($_POST['venteDeCrabe']['marcheLocal']['prix']),

				'pecheur' => $_POST['pecheur'],

				"nombre_sortie_capture" => $this->input->post("nombreSortieCapture")

			);

			if ($_POST['crabeConsomme']['nombre'] !== '') {

				$fiche_enquete['crabe_consomme_nombre'] = $_POST['crabeConsomme']['nombre'];

			}

			if ($_POST['venteDeCrabe']['collecte'][1]['poids'] !== '') {

				$fiche_enquete['collecte_poids2'] = $_POST['venteDeCrabe']['collecte'][1]['poids'];

			}

			if ($_POST['venteDeCrabe']['collecte'][1]['prix'] !== '') {

				$fiche_enquete['collecte_prix2'] = $_POST['venteDeCrabe']['collecte'][1]['prix'];

			}
			if ($_POST['venteDeCrabe']['collecte'][0]['prix'] !== '') {

				$fiche_enquete['collecte_prix1'] = $_POST['venteDeCrabe']['collecte'][0]['prix'];

			}

			$this->db->trans_begin();

			$erreurExecution = false;

			$insertion = $this->db_fiche_enqueteur->inserer($fiche_enquete);

			if (!$insertion) $erreurExecution = true;

			$id_enquete_insere = $this->db_fiche_enqueteur->dernier_id();

			foreach ($_POST['dernierSortieDePeches'] as $iteration_sortie_de_peche) {

				$sortie_de_peche = array(

					'fiche_enqueteur' => $id_enquete_insere,

					'nombre' => $iteration_sortie_de_peche['nombreDeSortie'],

					'date' => $iteration_sortie_de_peche['date'],

					'pirogue' => $iteration_sortie_de_peche['nombreDePirogue'],

				);

				$insertion = $this->db_fiche_enqueteur->inserer_sortie_de_peche($sortie_de_peche);

				if (!$insertion) $erreurExecution = true;

				$id_dernier_sortie_de_peche = $this->db_fiche_enqueteur->dernier_id_sortie_de_peche();

				foreach ($iteration_sortie_de_peche['engins'] as $iteration_engin) {

					$engin = array(

						'sortie_de_peche_enqueteur' => $id_dernier_sortie_de_peche,

						'engin' => $iteration_engin['nom'],

						'nombre' => $iteration_engin['nombre']

					);

					$insertion = $this->db_engin->inserer_engin_sortie_de_peche_enqueteur($engin);

					if (!$insertion) $erreurExecution = true;

				}

			}

			$echantillon = array(

				'fiche_enqueteur' => $id_enquete_insere,

				'trie' => intval($_POST['echantillon']['trie']) > 0,

				'poids' => null,

				'taille_absente' => $_POST['echantillon']['tailleAbsente']['taille'],

				'taille_absente_autre' => $_POST['echantillon']['tailleAbsente']['precision'],

			);

			if ($_POST['echantillon']['poids'] !== '' || $_POST['echantillon']['poids'] != null) {

				$echantillon['poids'] = $_POST['echantillon']['poids'];

			}else{
				$echantillon['poids'] = $_POST['poidsTotalDeLaCapture'];
			}

			$insertion = $this->db_echantillon->inserer($echantillon);

			if (!$insertion) $erreurExecution = true;

			$id_echantillon = $this->db_echantillon->dernier_id();

			foreach ($_POST['echantillon']['crabes'] as $iteration_crabe) {

				$crabe = array(

					'echantillon' => $id_echantillon,

					'sexe' => $iteration_crabe['sexe'],

					'taille' => $iteration_crabe['taille'],

					'destination' => $iteration_crabe['destination'],

				);

				$insertion = $this->db_crabe->insertion($crabe);

				if (!$insertion) $erreurExecution = true;

			}
			$id_enquete_suivi = 'ENQ_'.$id_enquete_insere;
			
			$insertion = $this->db_suivi_prime->archiver($id_enquete_suivi);

			if(!$insertion)$erreurExecution = true;

			if ($erreurExecution) $this->db->trans_rollback();

			else $this->db->trans_commit();

			echo json_encode(array('succes' => !$erreurExecution));

		}

	}
