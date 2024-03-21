<?php
	
	class FokontanyController extends ApplicationController {
		public function __construct() {
			parent::__construct();
			
			// redéfinition des paramètres parents pour l'adapter à la vue courante
			$this->root_states['title'] = 'Fokontany';
			$this->root_states['custom_javascripts'] = array(
				'pages/zone/fokontany/index.js',
				'pages/zone/fokontany/insert-modal.js',
				'pages/zone/fokontany/update-modal.js',
			);
			
			// Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
		}
		
		public function page_presentation() {
			// chargement de la vue d'insertion et modification dans une variable
			$current_context_state = array(
				'insert_modal_component' => $this->load->view('zone/fokontany/insert-modal.php', array('communes' => $this->db_commune->liste()), true),
				'update_modal_component' => $this->load->view('zone/fokontany/update-modal.php', null, true),
				'autorisation_creation' => $this->lib_autorisation->creation_autorise(6),
				'autorisation_modification' => $this->lib_autorisation->modification_autorise(6)
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'edition-de-zone/fokontany'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('zone/fokontany/index.php', $current_context_state, true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if($this->lib_autorisation->visualisation_autorise(6))
				$this->load->view('index.php', $this->root_states, false);
		}
		
		public function operation_datatable() {
			// requisition des données à afficher avec les contraintes
			$data_query = $this->db_fokontany->datatable($_POST);
			// chargement des données formatées
			$data = array();
			foreach ($data_query as $query_result) {
				$bouton_modification = $this->lib_autorisation->modification_autorise(6) ? '<button class="btn btn-default update-button" data-target="#modal-modification" id="update-'.$query_result['id'].'">Modifier</button>' : '';
				$bouton_suppression = $this->lib_autorisation->suppression_autorise(6) ? '<button class="btn btn-default delete-button"  data-target="'.$query_result['id'].'">Supprimer</button>' : '';
				$data[] = array(
					$query_result['nom'],
					$query_result['commune'],
					'<div class="btn-group">
						'.$bouton_modification.'
						'.$bouton_suppression.'
					</div>',
				);
			}
			echo json_encode(array(
				'draw' => intval($this->input->post('draw')),
				'recordsTotal' => $this->db_fokontany->records_total(),
				'recordsFiltered' => $this->db_fokontany->records_filtered($_POST),
				'data' => $data
			));
		}
		
		public function operation_insertion() {
			$fokontany = array(
				'nom' => $_POST['fokontanyNom'],
				'commune' => $_POST['commune']
			);
			$operation = $this->db_fokontany->inserer($fokontany);
			$this->db_historique->archiver("Insertion", "Insertion d'un nouveau Fokontany \"".$fokontany["nom"]."\"");
			echo json_encode(array('success' => $operation));
		}
		
		public function operation_mise_a_jour() {
			$fokontany = array(
				'nom' => $_POST['fokontanyNom'],
				'commune' => $_POST['commune']
			);
			$operation = $this->db_fokontany->mettre_a_jour($fokontany, $this->input->post("id"));
			$this->db_historique->actualiser();
			echo json_encode(array('success' => $operation));
		}
		
		public function operation_selection($id) {
			echo json_encode($this->db_fokontany->selection_par_id($id));
		}
		
		public function operation_suppression($id) {
			$this->db_historique->archiver("Suppression", "Suppression du Fokontany \"".$this->db_fokontany->selection_par_id($id)["nom"]."\"");
			echo json_encode($this->db_fokontany->supprimer($id));
		}

		public function liste_par_commune() {

			echo json_encode($this->db_fokontany->liste_par_commune($_POST['commune']));

		}

		public function liste_par_zone() {

			echo json_encode($this->db_fokontany->liste_par_zone($_POST['zone']));

		}
	}
