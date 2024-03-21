<?php

	

	class OrganisationController extends ApplicationController {

		public function __construct() {

            parent::__construct();
        
            // Chargement des composants statiques de bases (header, footer)
        
            $this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
        
            $this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
        
          }
        
        
        
          public function index() {
        
            // redéfinition des paramètres parents pour l'adapter à la vue courante
        
            $this->root_states['title'] = 'Organisation';
        
            $this->root_states['custom_javascripts'] = array(
        
              'pages/organisation/index.js',
        
              'pages/organisation/insert-modal.js',
        
              'pages/organisation/update-modal.js',
        
            );
        
        
        
            // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
        
            $etat_menu = array(
        
              'active_route' => 'organisation'
        
            );
        
            $etat_contexte_courant = array(
        
              'insert_modal_component' => $this->load->view('organisation/modal-insertion.php', null, true),
        
              'update_modal_component' => $this->load->view('organisation/modal-modification.php', null, true),
        
                'autorisation_creation' => $this->lib_autorisation->creation_autorise(24),
        
                'autorisation_modification' => $this->lib_autorisation->modification_autorise(24),
        
                'session' => $this->session->userdata()
        
            );
        
            // rassembler les vues chargées
        
            $this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
        
            $this->application_component['context_component'] = $this->load->view('organisation/crud-organisation.php', $etat_contexte_courant, true);
        
            // affichage du composant dans la vue de base
        
            $this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
        
            // importation des composants dans la vue racine
        
            $this->load->view('index.php', $this->root_states, false);
        
          }
        
        
        
          public function operation_datatable() {
        
            // requisition des données à afficher avec les contraintes
        
            $data_query = $this->db_organisation->datatable($_POST);
        
            // chargement des données formatées
        
            $data = array();
        
            foreach ($data_query as $query_result) {
        
              $data[] = array(
        
        
                $query_result['label'],
        
        
                '<div class="btn-group">
        
                  <button class="btn btn-default update-button" data-target="#modal-modification" id="update-' . $query_result['id'] . '">
        
                    Modifier
        
                  </button>
        
                  <button class="btn btn-default delete-button"  data-target="' . $query_result['id'] . '">
        
                    Supprimer
        
                  </button>
        
                </div>'
        
              );
        
            }
        
            echo json_encode(array(
        
              'draw' => intval($this->input->post('draw')),
        
              'recordsTotal' => $this->db_organisation->records_total(),
        
              'recordsFiltered' => $this->db_organisation->records_filtered($_POST),
        
              'data' => $data
        
            ));
        
          }
        
        
        
          public function operation_insertion() {
        
            $organisation = array(
        
              'label' => $_POST['label'],
        
        
            );
        
        
            $erreurProduite = false;
        
            $message = '';
        
            $identifiant_existant = $this->db_organisation->nom_existant($organisation['label']);
        
            if (!$identifiant_existant) {
        
              $this->db->trans_begin();
        
              $insertion = $this->db_organisation->inserer($organisation);
        
              if (!$insertion)
        
                $erreurProduite = true;
        
              if ($erreurProduite)
        
                $this->db->trans_rollback();
        
              else
        
                $this->db->trans_commit();
        
            } else {
        
              $erreurProduite = true;
        
              $message = 'Le nom d\'organisation existe déjà, veuillez en choisir un autre ';
        
            }
        
            echo json_encode(array('succes' => !$erreurProduite, 'message' => $message));
        
          }
        
        
        
          public function operation_modification() {
        
            $organisation = array(
        
              'label' => $_POST['label'],
        
            );
        
            $erreurProduite = false;
        
            $message = '';
        
            $label_existant = $this->db_organisation->existe_organisation($organisation['label'], $_POST['id']);
            if(!$label_existant){

                $this->db->trans_begin();
        
                $modification = $this->db_organisation->modifier($_POST['id'], $organisation);
        
              if (!$modification) {
        
                $erreurProduite = true;
        
              }
        
              if ($erreurProduite) {
        
                $this->db->trans_rollback();
        
              } else {
        
                $this->db->trans_commit();
        
              }

            }
            else {

                $erreurProduite = true;
          
                $message = 'Le nom de l\'organisation existe déjà, veuillez en choisir un autre';
          
              }
              
            echo json_encode(array('succes' => !$erreurProduite, 'message' => $message));
        
          }
        
        
        
          public function operation_supprimer($id) {
        
            echo json_encode($this->db_organisation->supprimer($id));
        
          }

          public function operation_selection($id) {

			echo json_encode($this->db_organisation->selection_par_id($id));

		}
        
        

        }
