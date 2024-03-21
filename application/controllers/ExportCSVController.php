<?php
	
	class ExportCSVController extends ApplicationController {
		private $champs_fiche_enqueteur = array(
			'zone_corecrabe.nom' => 'Zone corecrabe',
			'region.nom' => 'Région',
			'district.nom' => 'District',
			'commune.nom' => 'Commune',
			'fokontany.nom' => 'Fokontany',
			'village.nom' => 'Village',
			'fiche.date_expedition' => 'Date d\'expédition du fiche',
			'fiche_enqueteur.date' => "Date de l'enquête",
			"fiche_enqueteur.participant_individu" => "Accompagnateur du pêcheur",
			"fiche_enqueteur.participant_nombre" => "Nombre d'accompagnateur du pêcheur",
			"fiche_enqueteur.capture_poids" => "Poids total de la capture",
			"fiche_enqueteur.crabe_consomme_poids" => "Poids de crabes consommés",
			"fiche_enqueteur.crabe_consomme_nombre" => "Nombre de crabes consommés",
			"fiche_enqueteur.collecte_poids1" => "Poids de la collecte N°1",
			"fiche_enqueteur.collecte_prix1" => "Prix de la collecte N°1",
			"fiche_enqueteur.collecte_poids2" => "Poids de la collecte N°2",
			"fiche_enqueteur.collecte_prix2" => "Prix de la collecte N°2",
			"fiche_enqueteur.marche_local_poids" => "Poids de la vente au marché local",
			"fiche_enqueteur.marche_local_prix" => "Prix de la vente au marché local",
			"sortie_peche_1" => "Sortie de pêches Aujourd'hui ( date / pirogue / engins )",
			"sortie_peche_2" => "Sortie de pêches Hier ( date / pirogue / engins )",
			"sortie_peche_3" => "Sortie de pêches Avant-hier ( date / pirogue / engins )",
			"sortie_peche_4" => "Sortie de pêches Avant avant-hier ( date / pirogue / engins )",
			"nombre_sortie_capture" => "Nombre de sorties de capture",
			"echantillon.trie" => "Etat de tri de l'échantillon",
			"echantillon.taille_absente" => "Tailles absentes de l'échantillon",
			"echantillon.taille_absente_autre" => "Précision sur les autres tailles absentes de l'échantillon",			"echantillon.poids" => "Poids total de l'échantillon",
			"crabe.destination" => "Destination des crabes",
			"crabe.sexe" => "Sexe des crabes",
			"crabe.taille" => "Taille des crabes",
		);
		
		private $champs_fiche_pecheur = array(
			'zone_corecrabe.nom' => 'Zone corecrabe',
			'region.nom' => 'Région',
			'district.nom' => 'District',
			'commune.nom' => 'Commune',
			'fokontany.nom' => 'Fokontany',
			'village.nom' => 'Village',
			'fiche.date_expedition' => 'Date d\'expédition du fiche',
			'fiche_pecheur.date' => "Date de l'enquête",
			'fiche_pecheur.partenaire_peche_individu' => "Accompagnateur du pêcheur",
			'fiche_pecheur.partenaire_peche_nombre' => "Nombre de participant à la pêche",
			'fiche_pecheur.consommation_crabe_poids' => "Poids de crabe consommé",
			'fiche_pecheur.consommation_crabe_nombre' => "Nombre de crabe consommé",
			'fiche_pecheur.collecte_poids' => "Poids de crabe destiné à la collecte",
			'fiche_pecheur.collecte_prix' => "Prix de crabe destiné à la collecte",
			'fiche_pecheur.marche_local_poids' => "Poids de crabe destiné au marché local",
			'fiche_pecheur.marche_local_prix' => "Prix de crabe destiné au marché local",
			'fiche_pecheur.avec_pirogue' => "Sortie avec une pirogue",
			"engin" => "Engin de pêches"
		);
		
		private $champs_fiche_acheteur = array(
			"zone_corecrabe.nom" => "Zone corecrabe",
			"region.nom" => "Région",
			"district.nom" => "District",
			"commune.nom" => "Commune",
			"fokontany.nom" => "Fokontany",
			"village.nom" => "Village",
			"fiche.date_expedition" => "Date d'expédition du fiche",
			"fiche_acheteur.date" => "Date de l'enquête",
			"fiche_acheteur.pecheur_nombre" => "Nombre du pêcheur",
			"fiche_acheteur.collecte_poids1" => "Poids de la collecte N°1",
			"fiche_acheteur.collecte_prix1" => "Prix de la collecte N°1",
			"fiche_acheteur.collecte_poids2" => "Poids de la collecte N°2",
			"fiche_acheteur.collecte_prix2" => "Prix de la collecte N°2",
			"fiche_acheteur.marche_local_poids" => "Poids du marché local",
			"fiche_acheteur.marche_local_prix" => "Prix du marché local",
			"fiche_acheteur.crabe_non_vendu_poids" => "Poids des crabes non vendus",
			"fiche_acheteur.crabe_non_vendu_nombre" => "Nombre des crabes non vendus",
			"sortie_peche_1" => "Sortie de pêches Aujourd'hui",
			"sortie_peche_2" => "Sortie de pêches Hier",
			"sortie_peche_3" => "Sortie de pêches Avant-hier",
			"sortie_peche_4" => "Sortie de pêches Avant avant-hier",
			"nombre_sortie_vente" => "Nombre de sorties de capture"
		);
		
		private $conversion_champ_fiche_enqueteur = array(
			'zone_corecrabe.nom' => 'zone_corecrabe',
			'region.nom' => 'region',
			'district.nom' => 'district',
			'commune.nom' => 'commune',
			'fokontany.nom' => 'fokontany',
			'village.nom' => 'village',
			"fiche_enqueteur.date" => "date_enquete",
			"echantillon.taille_absente_autre" => "precision_autre_taille",
			"crabe.destination" => "destination_crabe",
			"crabe.taille" => "taille_crabe",
		);
		
		private $conversion_champ_fiche_pecheur = array(
			'zone_corecrabe.nom' => 'zone_corecrabe',
			'region.nom' => 'region',
			'district.nom' => 'district',
			'commune.nom' => 'commune',
			'fokontany.nom' => 'fokontany',
			'village.nom' => 'village'
		);
		
		private $conversion_champ_fiche_acheteur = array(
			'zone_corecrabe.nom' => 'zone_corecrabe',
			'region.nom' => 'region',
			'district.nom' => 'district',
			'commune.nom' => 'commune',
			'fokontany.nom' => 'fokontany',
			'village.nom' => 'village'
		);
		
		public function __construct() {
			parent::__construct();
		}
		
		public function page_presentation_enqueteur() {
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Exportation de la fiche d'Enquêteur en CSV";
			$this->root_states['custom_javascripts'] = array(
				'select2.full.min.js',
				'pages/export-csv/export-csv-fiche-enqueteur.js'
			);
			
			$zone_corecrabes = $this->db_zone_corecrabe->liste();
			foreach ($zone_corecrabes as $iteration => $zone_corecrabe) {
				$zone_corecrabes[$iteration]['villages'] = $this->db_village->selection_par_zone_corecrabe01($zone_corecrabe['id']);
			}
			
			// Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
			
			$current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(30),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(30),
				'zone_corecrabes' => $zone_corecrabes,
				'champs_fiche_enqueteurs' => $this->champs_fiche_enqueteur
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'exporter-csv-enqueteur'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('export-csv/export-csv-enqueteur.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(30))
				$this->load->view('index.php', $this->root_states, false);
		}
		
		public function page_presentation_pecheur() {
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Exportation de la fiche de Pêcheur en CSV";
			$this->root_states['custom_javascripts'] = array(
				'select2.full.min.js',
				'pages/export-csv/export-csv-fiche-pecheur.js'
			);
			
			$zone_corecrabes = $this->db_zone_corecrabe->liste();
			foreach ($zone_corecrabes as $iteration => $zone_corecrabe) {
				$zone_corecrabes[$iteration]['villages'] = $this->db_village->selection_par_zone_corecrabe($zone_corecrabe['id']);
			}
			
			// Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
			
			$current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(31),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(31),
				'zone_corecrabes' => $zone_corecrabes,
				'champs_fiche_pecheurs' => $this->champs_fiche_pecheur
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'exporter-csv-pecheur'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('export-csv/export-csv-pecheur', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(31))
				$this->load->view('index.php', $this->root_states, false);
		}
		
		public function page_presentation_acheteur() {
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = "Exportation de la fiche d'Acheteur' en CSV";
			$this->root_states['custom_javascripts'] = array(
				'select2.full.min.js',
				'pages/export-csv/export-csv-fiche-acheteur.js'
			);
			
			$zone_corecrabes = $this->db_zone_corecrabe->liste();
			foreach ($zone_corecrabes as $iteration => $zone_corecrabe) {
				$zone_corecrabes[$iteration]['villages'] = $this->db_village->selection_par_zone_corecrabe($zone_corecrabe['id']);
			}
			
			// Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
			
			$current_context_state = array(
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(32),
				'autorisation_visualisation' => $this->lib_autorisation->visualisation_autorise(32),
				'zone_corecrabes' => $zone_corecrabes,
				'champs_fiche_acheteurs' => $this->champs_fiche_acheteur
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'exporter-csv-acheteur'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('export-csv/export-csv-acheteur', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(32))
				$this->load->view('index.php', $this->root_states, false);
		}
		
		public function operation_csv_fiche_enqueteur() {
			$champs = $this->input->post("champs") === null ? array() : $this->input->post("champs");
			if(count($champs) === 0) {
				foreach ($this->champs_fiche_enqueteur as $champ => $designation) {
					$champs[] = $champ;
				}
			}
			$donnee_par_village = array();
			$contrainte_date = array();
			if ($this->input->post('villages') !== null && is_array($this->input->post('villages'))) {
				foreach ($this->input->post('villages') as $village) {
					$contrainte_date[] = array("village.id" => $village);
					if ($this->input->post('date') !== null && count($this->input->post('date')) == 2) {
						if ($this->input->post('date')[0] != '') $contrainte_date[] = array("fiche_enqueteur.date >= " => $this->input->post('date')[0]);
						if ($this->input->post('date')[1] != '') $contrainte_date[] = array("fiche_enqueteur.date <= " => $this->input->post('date')[1]);
					}
					$donnee_temporaire = $this->db_fiche_enqueteur->generation_csv($champs, $this->conversion_champ_fiche_enqueteur, $contrainte_date);
					$donnee_par_village = array_merge($donnee_par_village, $donnee_temporaire);
					$contrainte_date = array();
				}
				$donnees = $donnee_par_village;
			} else {
				$contrainte_date = array();
				if ($this->input->post('date') !== null && count($this->input->post('date')) == 2) {
					if ($this->input->post('date')[0] != '') $contrainte_date[] = array("fiche_enqueteur.date >= " => $this->input->post('date')[0]);
					if ($this->input->post('date')[1] != '') $contrainte_date[] = array("fiche_enqueteur.date <= " => $this->input->post('date')[1]);
				}
				$donnees = $this->db_fiche_enqueteur->generation_csv($champs, $this->conversion_champ_fiche_enqueteur, $contrainte_date);
			}
			$champ_modifies = array();
			$sortie_des_peches = array(
				"sortie_peche_1",
				"sortie_peche_2",
				"sortie_peche_3",
				"sortie_peche_4"
			);
			foreach ($champs as $champ) {
				if(in_array($champ, $sortie_des_peches)) {
					$indexe = array_search($champ, $sortie_des_peches);
					$champ_modifies[] = "date_sortie_de_peche".($indexe + 1);
					$champ_modifies[] = "nombre_sortie_de_peche".($indexe + 1);
					$champ_modifies[] = "nombre_de_pirogue_sortie_de_peche".($indexe + 1);
					$champ_modifies[] = "nom_premier_engin".($indexe + 1);
					$champ_modifies[] = "nombre_premier_engin".($indexe + 1);
					$champ_modifies[] = "nom_deuxieme_engin".($indexe + 1);
					$champ_modifies[] = "nombre_deuxieme_engin".($indexe + 1);
				} else $champ_modifies[] = $champ;
			}
			$delimiteur = $this->input->post('delimiteur');
			$maintenant = new DateTime();
			$nom_du_fichier = "exportation-fiche-enquete" . $maintenant->getTimestamp() . '.csv';
			$chemin_fichier = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $nom_du_fichier;
			$creation = $this->creer_csv($champ_modifies, $donnees, $delimiteur, $chemin_fichier);
			$creation["sql"] = $this->db->last_query();
			echo json_encode($creation);
			$this->db_historique->archiver("Exportation CSV", "Exportation de données de la fiche d'Enquêteur");
		}
		
		public function operation_csv_fiche_pecheur() {
			$champs = $this->input->post("champs") === null ? array() : $this->input->post("champs");
			if(count($champs) === 0) {
				foreach ($this->champs_fiche_pecheur as $champ => $designation) {
					$champs[] = $champ;
				}
			}
			$donnee_par_village = array();
			$contrainte_date = array();
			if ($this->input->post('villages') !== null && is_array($this->input->post('villages'))) {
				foreach ($this->input->post('villages') as $village) {
					$contrainte_date[] = array("village.id" => $village);
					if ($this->input->post('date') !== null && count($this->input->post('date')) == 2) {
						if ($this->input->post('date')[0] != '') $contrainte_date[] = array("fiche_pecheur.date >= " => $this->input->post('date')[0]);
						if ($this->input->post('date')[1] != '') $contrainte_date[] = array("fiche_pecheur.date <= " => $this->input->post('date')[1]);
					}
					$donnee_temporaire = $this->db_fiche_pecheur->generation_csv($champs, $this->conversion_champ_fiche_pecheur, $contrainte_date);
					$donnee_par_village = array_merge($donnee_par_village, $donnee_temporaire);
					$contrainte_date = array();
				}
				$donnees = $donnee_par_village;
			} else {
				$contrainte_date = array();
				if ($this->input->post('date') !== null && count($this->input->post('date')) == 2) {
					if ($this->input->post('date')[0] != '') $contrainte_date[] = array("fiche_pecheur.date >= " => $this->input->post('date')[0]);
					if ($this->input->post('date')[1] != '') $contrainte_date[] = array("fiche_pecheur.date <= " => $this->input->post('date')[1]);
				}
				$donnees = $this->db_fiche_pecheur->generation_csv($champs, $this->conversion_champ_fiche_pecheur, $contrainte_date);
			}
			$champ_modifies = array();
			$sortie_des_peches = array(
				"engin"
			);
			foreach ($champs as $champ) {
				if(in_array($champ, $sortie_des_peches)) {
					$champ_modifies[] = "nom_premier_engin";
					$champ_modifies[] = "nombre_premier_engin";
					$champ_modifies[] = "nom_deuxieme_engin";
					$champ_modifies[] = "nombre_deuxieme_engin";
				} else $champ_modifies[] = $champ;
			}
			$delimiteur = $this->input->post('delimiteur');
			$maintenant = new DateTime();
			$nom_du_fichier = "exportation-fiche-enquete" . $maintenant->getTimestamp() . '.csv';
			$chemin_fichier = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $nom_du_fichier;
			$creation = $this->creer_csv($champ_modifies, $donnees, $delimiteur, $chemin_fichier);
			$creation["sql"] = $this->db->last_query();
			echo json_encode($creation);
			$this->db_historique->archiver("Exportation CSV", "Exportation de données de la fiche de Pêcheur");
		}
		
		public function operation_csv_fiche_acheteur() {
			$champs = $this->input->post("champs") === null ? array() : $this->input->post("champs");
			if(count($champs) === 0) {
				foreach ($this->champs_fiche_acheteur as $champ => $designation) {
					$champs[] = $champ;
				}
			}
			$donnee_par_village = array();
			$contrainte_date = array();
			if ($this->input->post('villages') !== null && is_array($this->input->post('villages'))) {
				foreach ($this->input->post('villages') as $village) {
					$contrainte_date[] = array("village.id" => $village);
					if ($this->input->post('date') !== null && count($this->input->post('date')) == 2) {
						if ($this->input->post('date')[0] != '') $contrainte_date[] = array("fiche_acheteur.date >= " => $this->input->post('date')[0]);
						if ($this->input->post('date')[1] != '') $contrainte_date[] = array("fiche_acheteur.date <= " => $this->input->post('date')[1]);
					}
					$donnee_temporaire = $this->db_fiche_acheteur->generation_csv($champs, $this->conversion_champ_fiche_acheteur, $contrainte_date);
					$donnee_par_village = array_merge($donnee_par_village, $donnee_temporaire);
					$contrainte_date = array();
				}
				$donnees = $donnee_par_village;
			} else {
				$contrainte_date = array();
				if ($this->input->post('date') !== null && count($this->input->post('date')) == 2) {
					if ($this->input->post('date')[0] != '') $contrainte_date[] = array("fiche_acheteur.date >= " => $this->input->post('date')[0]);
					if ($this->input->post('date')[1] != '') $contrainte_date[] = array("fiche_acheteur.date <= " => $this->input->post('date')[1]);
				}
				$donnees = $this->db_fiche_acheteur->generation_csv($champs, $this->conversion_champ_fiche_acheteur, $contrainte_date);
			}
			$champ_modifies = array();
			$sortie_des_peches = array(
				"sortie_peche_1",
				"sortie_peche_2",
				"sortie_peche_3",
				"sortie_peche_4"
			);
			foreach ($champs as $champ) {
				if(in_array($champ, $sortie_des_peches)) {
					$indexe = array_search($champ, $sortie_des_peches);
					$champ_modifies[] = "date_sortie_de_peche".($indexe + 1);
					$champ_modifies[] = "nombre_sortie_de_peche".($indexe + 1);
					$champ_modifies[] = "nombre_de_pirogue_sortie_de_peche".($indexe + 1);
					$champ_modifies[] = "nom_premier_engin".($indexe + 1);
					$champ_modifies[] = "nombre_premier_engin".($indexe + 1);
					$champ_modifies[] = "nom_deuxieme_engin".($indexe + 1);
					$champ_modifies[] = "nombre_deuxieme_engin".($indexe + 1);
				} else $champ_modifies[] = $champ;
			}
			$delimiteur = $this->input->post('delimiteur');
			$maintenant = new DateTime();
			$nom_du_fichier = "exportation-fiche-enquete" . $maintenant->getTimestamp() . '.csv';
			$chemin_fichier = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $nom_du_fichier;
			$creation = $this->creer_csv($champ_modifies, $donnees, $delimiteur, $chemin_fichier);
			$creation["sql"] = $this->db->last_query();
			echo json_encode($creation);
			$this->db_historique->archiver("Exportation CSV", "Exportation de données de la fiche d'Acheteur");
		}
		
		private function ligne_csv_vide($lignes) {
			$vide = true;
			foreach ($lignes as $ligne) {
				if ($ligne != '') $vide = false;
			}
			return $vide;
		}
		
		private function transformer_ligne_csv($donnees, $delimiteur) {
			foreach ($donnees as $position => $donnee) {
				if (strpos($donnee, "\"") !== false) {
					$donnees[$position] = '"' . str_replace("\"", "\"\"", $donnee) . '"';
				} else if (strpos($donnee, $delimiteur) !== false) {
					$donnees[$position] = '"' . $donnee . '"';
				}
			}
			return implode($delimiteur, $donnees) . "\n";
		}
		
		private function creer_csv($en_tete, $donnees, $delimiteur, $chemin_fichier) {
			array_unshift($donnees, $en_tete);
			$nom_fichier = substr($chemin_fichier, strrpos($chemin_fichier, DIRECTORY_SEPARATOR) + 1, strlen($chemin_fichier));
			$fichier = fopen($chemin_fichier, 'wb');
			foreach ($donnees as $ligne) {
				$chaine = "";
				if ($this->ligne_csv_vide($ligne)) {
					$chaine = $delimiteur;
				} else {
					$chaine = $this->transformer_ligne_csv($ligne, $delimiteur);
				}
				fwrite($fichier, $chaine);
			}
			fclose($fichier);
			rename($chemin_fichier, "assets".DIRECTORY_SEPARATOR."csvs".DIRECTORY_SEPARATOR.$nom_fichier);
			return array("fichier" => $nom_fichier, "lien" => base_url("assets/csvs/".$nom_fichier));
		}
	}
