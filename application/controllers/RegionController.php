<?php
	
	class RegionController extends ApplicationController {
		public function __construct() {
			parent::__construct();
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = 'Région';
			$this->root_states['custom_javascripts'] = array(
				'pages/zone/region/index.js',
				'pages/zone/region/insert-modal.js',
				'pages/zone/region/update-modal.js',
			);
			
			// Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
		}
		
		public function page_presentation() {
			// chargement de la vue d'insertion et modification dans une variable
			$current_context_state = array(
				'insert_modal_component' => $this->load->view('zone/region/insert-modal.php', array('zone_corecrabes' => $this->db_zone_corecrabe->liste()), true),
				'update_modal_component' => $this->load->view('zone/region/update-modal.php', null, true),
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(3),
				'autorisation_modification' => $this->lib_autorisation->modification_autorise(3)
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'edition-de-zone/region'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('zone/region/index.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if ($this->lib_autorisation->visualisation_autorise(3))
				$this->load->view('index.php', $this->root_states, false);
		}
		
		public function operation_datatable() {
			// requisition des données à afficher avec les contraintes
			$data_query = $this->db_region->datatable($_POST);
			// chargement des données formatées
			$data = array();
			foreach ($data_query as $query_result) {
				$bouton_modification = $this->lib_autorisation->modification_autorise(3) ? '<button class="btn btn-default update-button" data-target="#modal-modification" id="update-' . $query_result['id'] . '">Modifier</button>' : '';
				$bouton_suppression = $this->lib_autorisation->suppression_autorise(3) ? '<button class="btn btn-default delete-button"  data-target="' . $query_result['id'] . '">Supprimer</button>' : '';
				$data[] = array(
					$query_result['nom'],
					$query_result['zone_corecrabe'],
					'<div class="btn-group">
						' . $bouton_modification . '
						' . $bouton_suppression . '
					</div>',
				);
			}
			echo json_encode(array(
				'draw' => intval($this->input->post('draw')),
				'recordsTotal' => $this->db_region->records_total(),
				'recordsFiltered' => $this->db_region->records_filtered($_POST),
				'data' => $data
			));
		}
		
		public function operation_insertion() {
			$region = array(
				'nom' => $this->input->post("nom"),
				'zone_corecrabe' => $this->input->post("zoneCorecrabe")
			);
			$operation = $this->db_region->inserer($region);
			$this->db_historique->archiver("Insertion", "Insertion de nouvelle Région \"".$region["nom"]."\"");
			echo json_encode(array('success' => $operation));
		}
		
		public function operation_mise_a_jour() {
			$region = array(
				'nom' => $this->input->post("nom"),
				'zone_corecrabe' => $this->input->post("zoneCorecrabe")
			);
			$operation = $this->db_region->mettre_a_jour($region, $this->input->post("id"));
			$this->db_historique->actualiser();
			echo json_encode(array('success' => $operation));
		}
		
		public function operation_selection($id) {
			echo json_encode($this->db_region->selection_par_id($id));
		}
		
		public function operation_suppression($id) {
			$this->db_historique->archiver("Suppression", "Suppression de la Région \"".$this->db_region->selection_par_id($id)["nom"]."\"");
			$operation = $this->db_region->supprimer($id);
			echo json_encode($operation);
		}
	}
