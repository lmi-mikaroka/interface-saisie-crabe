<?php



class EnqueteurController extends ApplicationController {

	public function __construct() {

		parent::__construct();



		// redéfinition des paramètres parents pour l'adapter à la vue courante

		$this->root_states['title'] = 'Enqueteur';

		$this->root_states['custom_javascripts'] = array(

			'pages/entite/enqueteur/index.js',

			'pages/entite/enqueteur/insert-modal.js',

			'pages/entite/enqueteur/update-modal.js',

		);



		// Chargement des composants statiques de bases (header, footer)

		$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);

		$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);

	}



	public function page_presentation() {

		// chargement de la vue d'insertion et modification dans une variable

		$insert_modal_conmponent_states = array(

			'villages' => $this->db_village->liste(),

			'structure_enqueteurs' => $this->db_enqueteur->liste_structure_enqueteur()

		);

		$current_context_state = array(

			'insert_modal_component' => $this->load->view('entite/enqueteur/insert-modal.php', $insert_modal_conmponent_states, true),

			'update_modal_component' => $this->load->view('entite/enqueteur/update-modal.php', null, true),

			'autorisation_creation' => $this->lib_autorisation->creation_autorise(20),

			'autorisation_modification' => $this->lib_autorisation->modification_autorise(20)

		);

		// précision du route courant afin d'ajouter la "classe" active au lien du composant actif

		$etat_menu = array(

			'active_route' => 'entite/enqueteur'

		);

		// rassembler les vues chargées

		$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

		$this->application_component['context_component'] = $this->load->view('entite/enqueteur/index.php', $current_context_state, true);

		// affichage du composant dans la vue de base

		$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

		// importation des composants dans la vue racine

		if ($this->lib_autorisation->visualisation_autorise(20))

			$this->load->view('index.php', $this->root_states, false);

	}



	public function operation_datatable() {

		// requisition des données à afficher avec les contraintes

		$data_query = $this->db_enqueteur->datatable($_POST);

		// chargement des données formatées

		$data = array();

		foreach ($data_query as $query_result) {

			$bouton_modification = $this->lib_autorisation->modification_autorise(20) ? '<button class="btn btn-default update-button" data-target="#update-modal" id="update-' . $query_result['id'] . '">Modifier</button>' : '';

			$bouton_suppression = $this->lib_autorisation->suppression_autorise(20) ? '<button class="btn btn-default delete-button"  data-target="' . $query_result['id'] . '">Supprimer</button>' : '';

			$data[] = array(

				$query_result['code'],

				$query_result['nom'],

				$query_result['type'],

				isset($query_result['valeur']) && $query_result['valeur'] != null ? $query_result['valeur'] : '',

				$query_result['village'],

				'<div class="btn-group">

						' . $bouton_modification . '

						' . $bouton_suppression . '

					</div>',

			);

		}

		echo json_encode(array(

			'draw' => intval($this->input->post('draw')),

			'recordsTotal' => $this->db_enqueteur->records_total(),

			'recordsFiltered' => $this->db_enqueteur->records_filtered($_POST),

			'data' => $data

		));

	}



	public function operation_insertion() {

		$enqueteur = array(

			'type' => $this->input->post('type'),

			'code' => $this->input->post('code'),

			'nom' => $this->input->post('nom'),

			'village' => $this->input->post('village')

		);

		$insertion = $this->db_enqueteur->inserer($enqueteur);

		$structure = $this->input->post('structure');

		if ($structure != null && $insertion) {

			$enqueteur = $this->db_enqueteur->dernier_id();

			$insertion = $this->db_enqueteur->inserer_stucture_enqueteur($enqueteur, $structure);

		}

		echo json_encode(array('success' => $insertion));

	}



	public function operation_mise_a_jour() {

		$this->db_enqueteur->supprimer_structure_enqueteur($this->input->post('id'));

		$enqueteur = array(

			'type' => $this->input->post('type'),

			'code' => $this->input->post('code'),

			'nom' => $this->input->post('nom'),

			'village' => $this->input->post('village')

		);

		$modification = $this->db_enqueteur->mettre_a_jour($enqueteur, $this->input->post('id'));

		$structure = $this->input->post('structure');

		if ($structure != null && $modification) {

			$modification = $this->db_enqueteur->inserer_stucture_enqueteur($this->input->post('id'), $structure);

		}

		echo json_encode(array('success' => $modification));

	}



	public function operation_selection($id) {

		$enqueteur = $this->db_enqueteur->selection_par_id($id);

		$structure = $this->db_enqueteur->selection_structure_par_enqueteur($id);

		if ($structure != null) {

			$enqueteur['structure'] = $structure;

		}

		echo json_encode($enqueteur);

	}



	public function operation_suppression($id) {

		echo json_encode($this->db_enqueteur->supprimer($id));

	}



	public function operation_selection_non_utilisateur() {

		echo json_encode($this->db_enqueteur->liste_non_utilisateurs());

	}



	public function operation_selection_par_village() {

		$enqueteurs = array('Enquêteur', 'Pêcheur', 'Acheteur');

		echo json_encode($this->db_enqueteur->selection_par_village($this->input->post('village'), $enqueteurs[intval($this->input->post('typeEnqueteur')) - 1]));

	}

	public function operation_selection_par_village_seulement() {
		
		echo json_encode($this->db_enqueteur->liste_par_village_enqueteur($this->input->post('village')));

	}

}

