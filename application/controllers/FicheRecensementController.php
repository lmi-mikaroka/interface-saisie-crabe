<?php

	

	class FicheRecensementController extends ApplicationController {

		const FICHE_MAX = 5;

		

		public function __construct() {

			parent::__construct();
			

			// Chargement des composants statiques de bases (header, footer)

			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);

			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);

		}

		

		public function page_saisie_de_fiche() {

			// chargement de la vue d'insertion et modification dans une variable

			$this->root_states['title'] = 'Fiche de recensement';

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/saisie-fiche/recensement.js'

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

				'active_route' => 'saisie-de-fiche-recensement'

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('saisie-fiche/recensement.php', $current_context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

		}

		public function page_insertion_enquete($fiche) {

			$this->root_states['title'] = 'ajout de fiche de recensement';

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/saisie-fiche/enquete-recensement.js',

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'saisie-de-fiche-recensement'

			);

			$information_fiche = $this->db_fiche->selection_par_id($fiche, 'REC');

			

			$this->load->library('calendrier', null, 'lib_calendrier');

			$jours_max_du_mois = $this->lib_calendrier->nombre_de_jours_du_mois($information_fiche['mois'], $information_fiche['annee']);

			$maintenant = array('jour' => intval(date('j')), 'mois' => intval(date('n')), 'annee' => intval(date('Y')));

			

			if (intval($information_fiche['mois']) == $maintenant['mois'] && intval($information_fiche['annee']) == $maintenant['annee']) {

				$jours_max_du_mois = $maintenant['jour'];

			}

			$zone_corecrabe = $this->db_fiche->selection_par_id_zone($fiche);


			$village_origine = $this->db_village->selection_par_zone_corecrabe02($zone_corecrabe['zone_corecrabe'],$information_fiche['village']);

			

			$donnees_contexte = array(

				'fiche' => $information_fiche,

				'jours_max_du_mois' => $jours_max_du_mois,

				'nb_max_du_mois' => 12,

				'maxannee' =>70,

				'anneecourant' =>intval(date('Y')),

				'mois_francais' => $this->mois_francais,

				'village_origines' => $village_origine,

				'pecheurs' => $this->db_pecheur->liste_par_village_origine($information_fiche['village']),

				'engins' => $this->db_engin->liste(),

				'activites' => $this->db_activite->liste(),

				'max_enquete' => self::FICHE_MAX,

				'enquete_enregistrees' => $this->db_fiche_recensement->enquete_totale_par_fiche($fiche),

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('saisie-fiche/enquete-recensement.php', $donnees_contexte, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

		}

		public function page_consultation() {

			$this->root_states['title'] = 'Consultation des fiches de resencement';

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/consultation-fiche/recensement.js'

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-recensement'

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('consultation-fiche/recensement.php', null, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

			$this->db_historique->archiver("Visite", "Consultation des fiches de recensement");

		}

		


		public function page_detail_enquete($fiche) {

			$fiche_bd = $this->db_fiche->selection_par_id($fiche, 'REC');

			$enquetes = $this->db_fiche_recensement->selection_par_fiche($fiche);

			foreach ($enquetes as $iteration_enquete => $enquete) {

				$enquetes[$iteration_enquete]["activite"] = $this->db_fiche_recensement->selection_par_activite_recensement($enquete["id"]);

				$enquetes[$iteration_enquete]["engins"] = $this->db_fiche_recensement->selection_par_engin_recensement($enquete["id"]);

			

			}

			$this->root_states['title'] = 'Fiche de recensment N°:' . $fiche_bd['code'];

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/consultation-fiche/recensement-detail.js'

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-recensement'

			);

			

			$session_enqueteur = $this->session->userdata('enqueteur');

			$context_state = array(

				'fiche' => $fiche_bd,

				'enquetes' => $enquetes,

				'mois_francais' => $this->mois_francais,

				'max_enquete' => self::FICHE_MAX,

				'autorisation_creation' => $this->lib_autorisation->creation_autorise(46),

				'autorisation_modification' => $this->lib_autorisation->modification_autorise(44),

				'autorisation_suppression' => $this->lib_autorisation->suppression_autorise(43),

				'enqueteur_responsable' => ($session_enqueteur == null || intval($session_enqueteur['id']) === intval($fiche_bd['enqueteur']))

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('consultation-fiche/recensement-detail.php', $context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

			$this->db_historique->archiver("Visite", "Consultation de la fiche d'Enquêteur de code: ".$fiche_bd["code"]);

		}


		public function operation_insertion() {

			$erreur_survenu = false;

			$fiche_recensement = array(

				'fiche' => $_POST['fiche'],

				'pecheur' => $_POST['pecheur'],

				'date'	=> $_POST['date'],

				'pirogue' => $_POST['pirogue'],

				'toute_annee' => $_POST['toute_annee'],

				'datedebut' => $_POST['date_debut'],

				'datefin' => $_POST['date_fin'],

			);

			$this->db->trans_begin();

			$insertion = $this->db_fiche_recensement->inserer($fiche_recensement);

			if (!$insertion) $erreur_survenu = true;

			$derniere_enquete = $this->db_fiche_recensement->dernier_id();

			foreach ($_POST['activite'] as $activite_fiche_recensement) {

				$activite_fiche_recensement = array(

					'fiche_recensement' => $derniere_enquete,

					'activite' => $activite_fiche_recensement['id'],

					'pourcentage' => intval($activite_fiche_recensement['pourcent'])

				);
               if($activite_fiche_recensement['activite']!=''){
				$insertion = $this->db_activite->inserer_activite_fiche_recensement($activite_fiche_recensement);

				if (!$insertion) $erreur_survenu = true;
			   }
				

			}

			foreach ($_POST['engins'] as $engin_fiche_recensement) {

				$engin_fiche_recensement = array(

					'fiche_recensement' => $derniere_enquete,

					'engin' => $engin_fiche_recensement['nom'],

					'annee' => intval($engin_fiche_recensement['annee'])

				);
               if($engin_fiche_recensement['engin'] != '')
			   {
				$insertion = $this->db_engin->inserer_engin_fiche_recensement($engin_fiche_recensement);

				if (!$insertion) $erreur_survenu = true;
			   }

			}

			$pecheur_information = array(

				'sexe' => $_POST['sexe'],

				'datenais'=>$_POST['datenais'],

				'village_origine' => $_POST['village_origine'],

				'village_activite' => $_POST['village_activite'],

			);

			 $insertion = $this->db_pecheur->mettre_a_jour($pecheur_information, $_POST['pecheur']);

			 if (!$insertion) $erreur_survenu = true;

			if ($erreur_survenu) $this->db->trans_rollback();

			else $this->db->trans_commit();

			echo json_encode(array('succes' => !$erreur_survenu));

		}

		public function page_modification_de_fiche($fiche) {

			$information_fiche = $this->db_fiche->selection_par_id($fiche, 'REC');

			$village = $this->db_village->selection_par_id($information_fiche['village']);

			// chargement de la vue d'insertion et modification dans une variable

			$this->root_states['title'] = 'Fiche d\'enquêteur';

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/modification-fiche/fiche-recensement.js'

			);

			$months = $this->mois_francais;

			$current_context_state = array(

				'zone_corecrabes' => $this->db_zone_corecrabe->liste(),

				'enqueteurs' => $this->db_enqueteur->liste_par_tous_village($information_fiche['village']),

				'mois' => $months,

				'annee_courante' => intval(date('Y')),

				'mois_courant' => intval(date('m')),

				'droit_de_modification' => $this->lib_autorisation->modification_autorise(43),

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

			$this->application_component['context_component'] = $this->load->view('modification-fiche/fiche-recensement.php', $current_context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			if ($this->lib_autorisation->modification_autorise(43))

				$this->load->view('index.php', $this->root_states, false);

		}
		public function page_de_modification($fiche_enquete) {

			$enquete_db = $this->db_fiche_recensement->selection_par_id($fiche_enquete);

			$information_fiche = $this->db_fiche->selection_par_enquete_et_type($fiche_enquete, 'REC');

			$information_pecheur = $this->db_pecheur->selection_par_id($enquete_db['pecheur']);

			$enquete_db['fiche'] = $this->db_fiche->selection_par_enquete_et_type($fiche_enquete, 'REC');
            if(($enquete_db['pecheur_village_origine'] != null)&& ($enquete_db['pecheur_village_activite'] != null)&&($enquete_db['pecheur_village_activite']==$enquete_db['pecheur_village_origine']))
			$enquete_db['resident']=1;
			if(($enquete_db['pecheur_village_origine'] != null)&& ($enquete_db['pecheur_village_activite'] != null)&&($enquete_db['pecheur_village_activite']!=$enquete_db['pecheur_village_origine']))
			$enquete_db['resident']=0;

			$enquete_db['activite'] = $this->db_fiche_recensement->selection_par_activite_recensement($fiche_enquete);

			$enquete_db['engins'] = $this->db_fiche_recensement->selection_par_engin_recensement($fiche_enquete);

			$this->root_states['title'] = 'modification de fiche';

			

			$this->load->library('calendrier', null, 'lib_calendrier');

			$jours_max_du_mois = $this->lib_calendrier->nombre_de_jours_du_mois($enquete_db['fiche']['mois'], $enquete_db['fiche']['annee']);

			$maintenant = array('jour' => intval(date('j')), 'mois' => intval(date('n')), 'annee' => intval(date('Y')));

			

			if (intval($enquete_db['fiche']['mois']) == $maintenant['mois'] && intval($enquete_db['fiche']['annee']) == $maintenant['annee']) {

				$jours_max_du_mois = $maintenant['jour'];

			}

			$zone_corecrabe = $this->db_fiche->selection_par_id_zone($information_fiche['id']);


			$village_origine = $this->db_village->selection_par_zone_corecrabe02($zone_corecrabe['zone_corecrabe'],$information_fiche['village']);

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['custom_javascripts'] = array(

				'pages/modification-fiche/recensement.js',

			);

			// précision du route courant afin d'ajouter la classe active au lien du composant active

			$etat_menu = array(

				'active_route' => 'consultation-de-fiche-recensement'

			);

			

			$date_courant = strtotime($enquete_db['date_originale']);

			$context_state = array(

				'enquete' => $enquete_db,

				'village_origines'=>$village_origine,

				'anneecourant' =>intval(date('Y')),

				'maxannee' =>70,

				'jours_enquete' => date('j', (new DateTime($enquete_db['date_originale']))->getTimestamp()),

				'jours_max_du_mois' => $jours_max_du_mois,

				'nb_max_du_mois' => 12,

				'mois_francais' => $this->mois_francais,

				'pecheurs' => $this->db_pecheur->liste_par_village($enquete_db['fiche']['village']),

				'engins' => $this->db_engin->liste(),

				'activites' => $this->db_activite->liste(),

				'information_pecheur'=>$information_pecheur

				

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('modification-fiche/enquete-recensement.php', $context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			$this->load->view('index.php', $this->root_states, false);

		}


		public function operation_mise_a_jour() {

			$erreur_survenu = false;

			$id_fiche_recencesment = intval($_POST['enquete']);

			$fiche_enquete = array(

				'fiche' => $_POST['fiche'],

				'pecheur' => $_POST['pecheur'],

				'date' => $_POST['date'],

				'pirogue' => $_POST['pirogue'],

				'toute_annee' => $_POST['toute_annee'],

				'datedebut' => $_POST['date_debut'],

				'datefin' => $_POST['date_fin'],


			);

			$this->db->trans_begin();

			$insertion = $this->db_fiche_recensement->mettre_a_jour($fiche_enquete, $id_fiche_recencesment);

			

			$insertion = $this->db_engin->supprimer_engin_fiche_recensement($id_fiche_recencesment);

			if (!$insertion) $erreur_survenu = true;

			foreach ($this->input->post("engins") as $engin) {

				$engin = array(

					'fiche_recensement' => $id_fiche_recencesment,

					'engin' => $engin['nom'],

					'annee' => intval($engin['annee'])

				);
              if($engin['engin'] !='')
			  {
				$insertion = $this->db_engin->inserer_engin_fiche_recensement($engin);

				if (!$insertion) $erreur_survenu = true;
			  }
			  
				

			}

			$insertion = $this->db_activite->supprimer_activite_recensement($id_fiche_recencesment);

			if (!$insertion) $erreur_survenu = true;

			foreach ($this->input->post("activite") as $activite) {

				$activite_recensement = array(

					'fiche_recensement' => $id_fiche_recencesment,

					'activite' => $activite['id'],

					'pourcentage' => intval($activite['pourcent'])

				);
				if($activite_recensement['activite'] !='')
			  {
				$insertion = $this->db_activite->inserer_activite_fiche_recensement($activite_recensement);

				if (!$insertion) $erreur_survenu = true;
			  }
				

			}

			if (!$insertion) $erreur_survenu = true;

			$pecheur_information = array(

				'sexe' => $_POST['sexe'],

				'datenais' => $_POST['datenais'],

				'village_origine' => $_POST['village_origine'],

				'village_activite' => $_POST['village_activite'],

			);

			$insertion = $this->db_pecheur->mettre_a_jour($pecheur_information, $_POST['pecheur']);

			if (!$insertion) $erreur_survenu = true;

			if ($erreur_survenu) $this->db->trans_rollback();

			else $this->db->trans_commit();

			echo json_encode(array('succes' => !$erreur_survenu));

		}

		public function operation_suppression($fiche) {

			echo json_encode($this->db_fiche_recensement->supprimer($fiche));

		}

		public function liste_engin(){
			echo json_encode($this->db_engin->liste());
		}
		public function liste_village_par_commune(){
			echo json_encode($this->db_village->liste_par_commune($_POST['commune']));
		}



	}

