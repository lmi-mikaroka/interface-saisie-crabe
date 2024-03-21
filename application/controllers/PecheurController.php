<?php

	

	class PecheurController extends ApplicationController {

		public function __construct() {

			parent::__construct();

			

			// redéfinition des paramètres parents pour l'adapter à la vue courante

			$this->root_states['title'] = 'Pêcheur';

			$this->root_states['custom_javascripts'] = array(

				'pages/entite/pecheur/index.js',

				'pages/entite/pecheur/insert-modal.js',

				'pages/entite/pecheur/update-modal.js',

			);

			

			// Chargement des composants statiques de bases (header, footer)

			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);

			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);

		}

		

		public function page_presentation() {

			// chargement de la vue d'insertion et modification dans une variable

			$current_context_state = array(

				'insert_modal_component' => $this->load->view('entite/pecheur/insert-modal.php', array('villages' => $this->db_village->liste()), true),

				'update_modal_component' => $this->load->view('entite/pecheur/update-modal.php', null, true),

				'autorisation_creation' => $this->lib_autorisation->creation_autorise(21),

				'autorisation_modification' => $this->lib_autorisation->modification_autorise(21)

			);

			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif

			$etat_menu = array(

				'active_route' => 'entite/pecheur'

			);

			// rassembler les vues chargées

			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

			$this->application_component['context_component'] = $this->load->view('entite/pecheur/index.php', $current_context_state, true);

			// affichage du composant dans la vue de base

			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

			// importation des composants dans la vue racine

			if ($this->lib_autorisation->visualisation_autorise(21))

				$this->load->view('index.php', $this->root_states, false);

		}

		

		public function operation_datatable() {

			// requisition des données à afficher avec les contraintes

			$data_query = $this->db_pecheur->datatable($_POST);

			// chargement des données formatées

			$data = array();

			foreach ($data_query as $query_result) {

				$bouton_modification = $this->lib_autorisation->modification_autorise(21) ? '<button class="btn btn-default update-button" data-target="#update-modal" id="update-' . $query_result['id'] . '">Modifier</button>' : '';

				$bouton_suppression = $this->lib_autorisation->suppression_autorise(21) ? '<button class="btn btn-default delete-button"  data-target="' . $query_result['id'] . '">Supprimer</button>' : '';

				$data[] = array(

					$query_result['nom'],

					$query_result['village'],

					'<div class="btn-group">

						' . $bouton_modification . '

						' . $bouton_suppression . '

					</div>',

				);

			}

			echo json_encode(array(

				'draw' => intval($this->input->post('draw')),

				'recordsTotal' => $this->db_pecheur->records_total(),

				'recordsFiltered' => $this->db_pecheur->records_filtered($_POST),

				'data' => $data

			));

		}

		

		public function operation_insertion() {

			$fisherman_length = count($_POST['noms']);

			$insertion = false;

			for ($index = 0; $index < $fisherman_length; $index++) {

				$pecheur = array(

					'village' => $_POST['village'],

					'nom' => $_POST['noms'][$index]

				);

				$insertion = $this->db_pecheur->inserer($pecheur);

			}

			echo json_encode(array('success' => $insertion));

		}

		

		public function operation_mise_a_jour() {

			$pecheur = array(

				'nom' => $_POST['nom'],

				'village' => $_POST['village'],

			);

			echo json_encode(array('success' => $this->db_pecheur->mettre_a_jour($pecheur, $_POST['id'])));

		}

		

		public function operation_selection($id) {

			echo json_encode($this->db_pecheur->selection_par_id($id));

		}

		

		public function operation_suppression($id) {

			echo json_encode($this->db_pecheur->supprimer($id));

		}

		public function pecheur_detail() {

			echo json_encode($this->db_pecheur->selection_par_id($_POST['pecheur']));

		}

		public function operation_mise_a_jour_ville() {

			$pecheur = array(

				'village_origine' => $_POST['village_origine'],

				'village_activite' => $_POST['village_activite'],

			);

			echo json_encode(array('success' => $this->db_pecheur->mettre_a_jour($pecheur, $_POST['pecheur'])));

		}

		public function operation_affiche_ville_origine() {

			

			echo json_encode($this->db_pecheur->liste_par_village_origine($_POST['village']));

		}
		public function operation_affiche_non_recenser() {

			echo json_encode($this->db_pecheur->liste_par_village_origine_non_recenser($_POST['village']));

		}
		public function operation_affiche_non_recenser_origine() {

			echo json_encode($this->db_pecheur->liste_par_village_origine_non_recenser_origine($_POST['village'],$_POST['origine']));

		}

	}
