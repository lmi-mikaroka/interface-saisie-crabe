<?php
	
	class ZoneCorecrabeController extends ApplicationController {
		public function __construct() {
			parent::__construct();
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = 'Zone corécrabe';
			$this->root_states['custom_javascripts'] = array(
				'pages/zone/zone-corecrabe/index.js',
				'pages/zone/zone-corecrabe/insert-modal.js',
				'pages/zone/zone-corecrabe/update-modal.js',
			);
			
			// Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
		}
		
		public function page_presentation() {
			// chargement de la vue d'insertion et modification dans une variable
			$current_context_state = array(
				'insert_modal_component' => $this->load->view('zone/zone-corecrabe/insert-modal.php', null, true),
				'update_modal_component' => $this->load->view('zone/zone-corecrabe/update-modal.php', null, true),
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(2),
				'autorisation_modification' => $this->lib_autorisation->modification_autorise(2)
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'edition-de-zone/zone-corecrabe'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('zone/zone-corecrabe/index.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if($this->lib_autorisation->visualisation_autorise(2))
				$this->load->view('index.php', $this->root_states, false);
		}
		
		public function operation_datatable() {
			// requisition des données à afficher avec les contraintes
			$data_query = $this->db_zone_corecrabe->datatable($this->input->post());
			// chargement des données formatées
			$data = array();
			foreach ($data_query as $query_result) {
				$bouton_modification = $this->lib_autorisation->modification_autorise(2) ? '<button class="btn btn-default update-button" data-target="#modal-modification" id="update-'.$query_result['id'].'">Modifier</button>' : '';
				$bouton_suppression = $this->lib_autorisation->suppression_autorise(2) ? '<button class="btn btn-default delete-button"  data-target="'.$query_result['id'].'">Supprimer</button>' : '';
				$data[] = array(
					$query_result['nom'],
					'<div class="btn-group">
						'.$bouton_modification.'
						'.$bouton_suppression.'
					</div>',
				);
			}
			echo json_encode(array(
				'draw' => intval($this->input->post('draw')),
				'recordsTotal' => $this->db_zone_corecrabe->enregistrement_total(),
				'recordsFiltered' => $this->db_zone_corecrabe->enregistrement_filtre($this->input->post()),
				'data' => $data
			));
		}
		
		public function operation_insertion() {
			$zone_corecrabe = array(
				'nom' => $this->input->post('zoneCorecrabeNom')
			);
			$operation = $this->db_zone_corecrabe->inserer($zone_corecrabe);
			$this->db_historique->archiver("Insertion", "Insertion de nouvelle Zone CORECRABE \"".$zone_corecrabe["nom"]."\"");
			echo json_encode(array('success' => $operation));
		}
		
		public function operation_mise_a_jour() {
			$zone_corecrabe = array(
				'nom' => $this->input->post('zoneCorecrabeNom')
			);
			$operation = $this->db_zone_corecrabe->mettre_a_jour($zone_corecrabe, $this->input->post('id'));
			$this->db_historique->actualiser();
			echo json_encode(array('success' => $operation));
		}
		
		public function operation_selection($id) {
			echo json_encode($this->db_zone_corecrabe->selection_par_id($id));
		}
		
		public function operation_suppression($id) {
			$this->db_historique->archiver("Suppression", "Suppression de la Zone CORECRABE \"".$this->db_zone_corecrabe->selection_par_id($id)["nom"]."\"");
			$operation = $this->db_zone_corecrabe->supprimer($id);
			echo json_encode($operation);
		}
	}
