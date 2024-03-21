<?php

class OperationController extends ApplicationController {

  public function __construct() {
    parent::__construct();
    // Chargement des composants statiques de bases (header, footer)
    $this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
    $this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
  }

  public function index() {
    // redéfinition des paramètres parents pour l'adapter à la vue courante
    $this->root_states['title'] = 'Opération';
    $this->root_states['custom_javascripts'] = array(
      'pages/operation/index.js',
      'pages/operation/insertion.js',
      'pages/operation/modification.js',
    );

    // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
    $etat_menu = array(
      'active_route' => 'operation/gestion-operation'
    );
    $etat_contexte_courant = array(
      'insert_modal_component' => $this->load->view('operation/modal-insertion.php', null, true),
      'update_modal_component' => $this->load->view('operation/modal-modification.php', null, true),
	    'autorisation_creation' => $this->lib_autorisation->creation_autorise(22),
	    'autorisation_modification' => $this->lib_autorisation->modification_autorise(22)
    );
    // rassembler les vues chargées
    $this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
    $this->application_component['context_component'] = $this->load->view('operation/crud-operation.php', $etat_contexte_courant, true);
    // affichage du composant dans la vue de base
    $this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
    // importation des composants dans la vue racine
    $this->load->view('index.php', $this->root_states, false);
  }

  public function operation_datatable() {
    // requisition des données à afficher avec les contraintes
    $data_query = $this->db_operation->datatable($_POST);
    // chargement des données formatées
    $data = array();
    foreach ($data_query as $query_result) {
      $creation = $query_result['creation'] === 't' ? '<h5><span class="badge badge-success">Possible</span></h5>' : '<h5><span class="badge badge-danger">Impossible</span></h5>';
      $modification = $query_result['modification'] === 't' ? '<h5><span class="badge badge-success">Possible</span></h5>' : '<h5><span class="badge badge-danger">Impossible</span></h5>';
      $visualisation = $query_result['visualisation'] === 't' ? '<h5><span class="badge badge-success">Possible</span></h5>' : '<h5><span class="badge badge-danger">Impossible</span></h5>';
      $suppression = $query_result['suppression'] === 't' ? '<h5><span class="badge badge-success">Possible</span></h5>' : '<h5><span class="badge badge-danger">Impossible</span></h5>';
      $data[] = array(
        $query_result['id'],
        $query_result['nom'],
        $creation,
        $modification,
        $visualisation,
        $suppression,
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
      'recordsTotal' => $this->db_operation->records_total(),
      'recordsFiltered' => $this->db_operation->records_filtered($_POST),
      'data' => $data
    ));
  }

  public function operation_insertion() {
    $operation = array(
      'nom' => $_POST['nom'],
      'creation' => intval($_POST['creation']) > 0,
      'modification' => intval($_POST['modification']) > 0,
      'visualisation' => intval($_POST['visualisation']) > 0,
      'suppression' => intval($_POST['suppression']) > 0
    );
    $erreurProduite = false;
    $message = '';
    $nom_existant = $this->db_operation->existe($operation['nom']);
    if (!$nom_existant) {
      $this->db->trans_begin();
      $insertion = $this->db_operation->insertion($operation);
      if (!$insertion) $erreurProduite = true;
      if ($erreurProduite)  $this->db->trans_rollback();
      else $this->db->trans_commit();
    } else {
      $erreurProduite = true;
      $message = 'Le nom d\'opération existe déjà, veuillez en choisir un autre parce que ce propriété doit être unique pour chaque utilisateur';
    }
    echo json_encode(array('succes' => !$erreurProduite, 'message' => $message));
  }

  public function operation_modification() {
    $operation = array(
      'nom' => $_POST['nom'],
      'creation' => intval($_POST['creation']) > 0,
      'modification' => intval($_POST['modification']) > 0,
      'visualisation' => intval($_POST['visualisation']) > 0,
      'suppression' => intval($_POST['suppression']) > 0
    );
    $erreurProduite = false;
    $message = '';
    $nom_existant = $this->db_operation->existe_hormis_id($_POST['id'], $operation['nom']);
    if (!$nom_existant) {
      $this->db->trans_begin();
      $insertion = $this->db_operation->mettre_a_jour($operation, $_POST['id']);
      if (!$insertion) $erreurProduite = true;
      if ($erreurProduite)  $this->db->trans_rollback();
      else $this->db->trans_commit();
    } else {
      $erreurProduite = true;
      $message = 'Le nom d\'opération existe déjà, veuillez en choisir un autre parce que ce propriété doit être unique pour chaque utilisateur';
    }
    echo json_encode(array('succes' => !$erreurProduite, 'message' => $message));
  }

  public function operaton_supprimer($id) {
    echo json_encode($this->db_operation->supprimer($id));
  }

  public function operation_selection($id) {
    echo json_encode($this->db_operation->selection_par_id($id));
  }
}
