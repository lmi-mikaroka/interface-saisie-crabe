<?php



class VillageController extends ApplicationController {

	public function __construct() {

		parent::__construct();



		// redéfinition des paramètres parents pour l'adapter à la vue courante

		$this->root_states['title'] = 'Village';

		$this->root_states['custom_javascripts'] = array(

			'pages/zone/village/index.js',

			'pages/zone/village/insert-modal.js',

			'pages/zone/village/update-modal.js',

		);



		// Chargement des composants statiques de bases (header, footer)

		$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);

		$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);



		// chargement des models à utiliser

		$this->load->model(array(

			'VillageModel' => 'db_village',

			'FokontanyModel' => 'db_fokontany'

		));

	}



	public function page_presentation() {

		// chargement de la vue d'insertion et modification dans une variable

		$current_context_state = array(

			'insert_modal_component' => $this->load->view('zone/village/insert-modal.php', array('fokontanys' => $this->db_fokontany->liste()), true),

			'update_modal_component' => $this->load->view('zone/village/update-modal.php', null, true),

			'autorisation_creation' => $this->lib_autorisation->creation_autorise(7),

			'autorisation_modification' => $this->lib_autorisation->modification_autorise(7)

		);

		// précision du route courant afin d'ajouter la "classe" active au lien du composant actif

		$etat_menu = array(

			'active_route' => 'edition-de-zone/village'

		);

		// rassembler les vues chargées

		$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

		$this->application_component['context_component'] = $this->load->view('zone/village/index.php', $current_context_state, true);

		// affichage du composant dans la vue de base

		$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

		// importation des composants dans la vue racine

		if ($this->lib_autorisation->visualisation_autorise(7))

			$this->load->view('index.php', $this->root_states, false);

	}



	public function operation_datatable() {

		// requisition des données à afficher avec les contraintes

		$data_query = $this->db_village->datatable($_POST);

		// chargement des données formatées

		$data = array();

		foreach ($data_query as $query_result) {

			$bouton_modification = $this->lib_autorisation->modification_autorise(7) ? '<button class="btn btn-default update-button" data-target="#modal-modification" id="update-' . $query_result['id'] . '">Modifier</button>' : '';

			$bouton_suppression = $this->lib_autorisation->suppression_autorise(7) ? '<button class="btn btn-default delete-button"  data-target="' . $query_result['id'] . '">Supprimer</button>' : '';

			$data[] = array(

				$query_result['nom'],

				$query_result['fokontany'],

				$query_result['sous_zone'],

				'<div class="btn-group">

						' . $bouton_modification . '

						' . $bouton_suppression . '

					</div>',

			);

		}

		echo json_encode(array(

			'draw' => intval($this->input->post('draw')),

			'recordsTotal' => $this->db_village->records_total(),

			'recordsFiltered' => $this->db_village->records_filtered($_POST),

			'data' => $data

		));

	}



	public function operation_insertion() {

		$village = array(

			'nom' => $_POST['villageNom'],

			'fokontany' => $_POST['fokontany'],

			'longitude' => $_POST['longitude'],

			'latitude'  => $_POST['latitude'],

			'sous_zone' => $_POST['sous_zone']

		);

		$operation = $this->db_village->insert($village);

		$this->db_historique->archiver("Insertion", "Insertion d'un nouveau Village \"".$village["nom"]."\"");

		echo json_encode(array('success' => $operation));

	}



	public function selection_par_zone_corecrabe($zone_corecrabe) {

		echo json_encode($this->db_village->selection_par_zone_corecrabe($zone_corecrabe));

	}

	public function selection_par_zone_corecrabe01($zone_corecrabe) {

		echo json_encode($this->db_village->selection_par_zone_corecrabe01($zone_corecrabe));

	}

	public function operation_mise_a_jour() {

		$village = array(

			'nom' => $_POST['villageNom'],

			'fokontany' => $_POST['fokontany'],

			'longitude' => $_POST['longitude'],

			'latitude'  => $_POST['latitude'],

			'sous_zone' => $_POST['sous_zone']

		);

		$operation = $this->db_village->mettre_a_jour($village, $this->input->post("id"));

		$this->db_historique->actualiser();

		echo json_encode(array('success' => $operation));

	}



	public function operation_selection($id) {

		echo json_encode($this->db_village->selection_par_id($id));

	}



	public function operation_suppression($id) {

		$this->db_historique->archiver("Suppression", "Suppression du Village \"".$this->db_village->selection_par_id($id)["nom"]."\"");

		echo json_encode($this->db_village->supprimer($id));

	}

	public function liste_par_fokontany() {

		echo json_encode($this->db_village->liste_par_fokontany($_POST['fokontany']));

	}

	public function selection_par_zone_corecrabe_suivi($zone_corecrabe) {

		echo json_encode($this->db_village->selection_par_zone_corecrabe_suivi($zone_corecrabe));

	}

}

