<?php
	
	class GroupeController extends ApplicationController {
		
		public function __construct() {
			parent::__construct();
			// Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
		}
		
		public function index() {
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = 'Groupe';
			$this->root_states['custom_javascripts'] = array(
				'pages/groupe/index.js',
				'pages/groupe/insertion.js',
				'pages/groupe/modification.js',
			);
			
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'groupe/gestion-groupe'
			);
			$etat_contexte_courant = array(
				'insert_modal_component' => $this->load->view('groupe/modal-insertion.php', array('operations' => $this->db_operation->liste()), true),
				'update_modal_component' => $this->load->view('groupe/modal-modification.php', null, true),
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(23),
				'autorisation_modification' => $this->lib_autorisation->modification_autorise(23)
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('groupe/crud-groupe.php', $etat_contexte_courant, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(23))
				$this->load->view('index.php', $this->root_states, false);
		}
		
		public function operation_datatable() {
			// requisition des données à afficher avec les contraintes
			$data_query = $this->db_groupe->datatable($_POST);
			// chargement des données formatées
			$data = array();
			foreach ($data_query as $query_result) {
				$data[] = array(
					$query_result['id'],
					$query_result['nom'],
					'<div class="btn-group">
          <button class="btn btn-default update-button" data-target="#modal-modification" id="update-' . $query_result['id'] . '">
            Modifier
          </button>
          ' . (!in_array(intval($query_result['id']), array(1, 2, 3)) ?
						'<button class="btn btn-default delete-button"  data-target="' . $query_result['id'] . '">
            Supprimer
          </button>' :
						'') . '
        </div>'
				);
			}
			echo json_encode(array(
				'draw' => intval($this->input->post('draw')),
				'recordsTotal' => $this->db_groupe->records_total(),
				'recordsFiltered' => $this->db_groupe->records_filtered($_POST),
				'data' => $data
			));
		}
		
		public function operation_insertion() {
			$erreurProduite = false;
			$message = '';
			$nom_existant = $this->db_groupe->nom_existant($this->input->post('nom'));
			if (!$nom_existant) {
				$this->db->trans_begin();
				$insertion = $this->db_groupe->inserer($this->input->post('nom'));
				$groupe_insere = $this->db_groupe->dernier_id();
				if (!$insertion) $erreurProduite = true;
				foreach ($this->input->post('permissions') as $permission) {
					$autorisation = array(
						'groupe' => $groupe_insere,
						'operation' => intval($permission['operation']),
						'creation' => intval($permission['creation']) > 0,
						'modification' => intval($permission['modification']) > 0,
						'visualisation' => intval($permission['visualisation']) > 0,
						'suppression' => intval($permission['suppression']) > 0
					);
					$insertion = $this->db_groupe->inserer_autorisation($autorisation);
					if (!$insertion) $erreurProduite = true;
				}
				if ($erreurProduite) $this->db->trans_rollback();
				else $this->db->trans_commit();
			} else {
				$erreurProduite = true;
				$message = 'Le nom de groupe existe déjà, veuillez en choisir un autre parce que ce propriété doit être unique pour chaque groupe';
			}
			echo json_encode(array('succes' => !$erreurProduite, 'message' => $message));
		}
		
		public function operation_modification() {
			$erreurProduite = false;
			$message = '';
			$nom_existant = $this->db_groupe->nom_existant_en_dehors_id($this->input->post('id'), $this->input->post('nom'));
			if (!$nom_existant) {
				$this->db->trans_begin();
				$insertion = $this->db_groupe->modifier($this->input->post('id'), $this->input->post('nom'));
				if (!$insertion) $erreurProduite = true;
				$insertion = $this->db_groupe->supprimer_autorisation_du_groupe($this->input->post('id'));
				if (!$insertion) $erreurProduite = true;
				foreach ($this->input->post('permissions') as $permission) {
					$autorisation = array(
						'groupe' => intval($this->input->post('id')),
						'operation' => intval($permission['operation']),
						'creation' => intval($permission['creation']) > 0,
						'modification' => intval($permission['modification']) > 0,
						'visualisation' => intval($permission['visualisation']) > 0,
						'suppression' => intval($permission['suppression']) > 0
					);
					$insertion = $this->db_groupe->inserer_autorisation($autorisation);
					if (!$insertion) $erreurProduite = true;
				}
				if ($erreurProduite) $this->db->trans_rollback();
				else $this->db->trans_commit();
			} else {
				$erreurProduite = true;
				$message = 'Le nom d\'opération existe déjà, veuillez en choisir un autre parce que ce propriété doit être unique pour chaque groupe';
			}
			echo json_encode(array('succes' => !$erreurProduite, 'message' => $message));
		}
		
		public function operaton_suppression($id) {
			echo json_encode($this->db_groupe->supprimer($id));
		}
		
		public function operation_selection($id) {
			$groupe = $this->db_groupe->selection_par_id($id);
			$groupe['autorisations'] = $this->db_groupe->selection_autorisation_par_groupe($id);
			echo json_encode($groupe);
		}
	}
