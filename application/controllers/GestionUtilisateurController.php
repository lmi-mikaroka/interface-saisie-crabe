<?php

class GestionUtilisateurController extends ApplicationController {

  public function __construct() {
    parent::__construct();
    // Chargement des composants statiques de bases (header, footer)
    $this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
    $this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
  }

  public function index() {
    // redéfinition des paramètres parents pour l'adapter à la vue courante
    $this->root_states['title'] = 'Utilisateur';
    $this->root_states['custom_javascripts'] = array(
      'pages/utilisateur/index.js',
      'pages/utilisateur/insert-modal.js',
      'pages/utilisateur/update-modal.js',
    );

    // précision du route courant afin d'ajouter la "classe" active au lien du composant actif
    $etat_menu = array(
      'active_route' => 'utilisateur/gestion-utilisateur'
    );
    $etat_contexte_courant = array(
      'insert_modal_component' => $this->load->view('utilisateur/modal-insertion.php', array(
        'groupes' => $this->db_groupe->liste(),
        'enqueteurs' => $this->db_enqueteur->liste_non_utilisateurs(),
      ), true),
      'update_modal_component' => $this->load->view('utilisateur/modal-modification.php', null, true),
	    'autorisation_creation' => $this->lib_autorisation->creation_autorise(24),
	    'autorisation_modification' => $this->lib_autorisation->modification_autorise(24),
	    'session' => $this->session->userdata()
    );
    // rassembler les vues chargées
    $this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
    $this->application_component['context_component'] = $this->load->view('utilisateur/crud-utilisateur.php', $etat_contexte_courant, true);
    // affichage du composant dans la vue de base
    $this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
    // importation des composants dans la vue racine
    $this->load->view('index.php', $this->root_states, false);
  }

  public function operation_datatable() {
    // requisition des données à afficher avec les contraintes
    $data_query = $this->db_utilisateur->datatable($_POST);
    // chargement des données formatées
    $data = array();
    foreach ($data_query as $query_result) {
      $data[] = array(
        $query_result['identifiant'],
        $query_result['nom'],
        $query_result['groupe'],
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
      'recordsTotal' => $this->db_utilisateur->records_total(),
      'recordsFiltered' => $this->db_utilisateur->records_filtered($_POST),
      'data' => $data
    ));
  }

  public function operation_insertion() {
    $login = array(
      'nom_utilisateur' => $_POST['nomUtilisateur'],
      'identifiant' => $_POST['identifiant'],
      'mot_de_passe' => hash('sha256', $_POST['motDePasse']),
      'groupe' => $_POST['groupe'],
    );
    $login_de_type_enqueteur = $_POST['enqueteur'] == 'true';
    if ($login_de_type_enqueteur) {
      $login['nom_utilisateur'] = $this->db_enqueteur->selection_nom_par_id($_POST['nomUtilisateur']);
    }
    $erreurProduite = false;
    $message = '';
    $identifiant_existant = $this->db_utilisateur->existe($login['identifiant']);
    if (!$identifiant_existant) {
      $this->db->trans_begin();
      $insertion = $this->db_utilisateur->insertion($login);
      if (!$insertion)
        $erreurProduite = true;
      if ($login_de_type_enqueteur) {
        $id_dernier_login = $this->db_utilisateur->dernier_login();
        $insertion = $this->db_enqueteur->attribuer_login($_POST['nomUtilisateur'], $id_dernier_login);
        if (!$insertion)
          $erreurProduite = true;
      }
      if ($erreurProduite)
        $this->db->trans_rollback();
      else
        $this->db->trans_commit();
    } else {
      $erreurProduite = true;
      $message = 'Le nom d\'utilisateur existe déjà, veuillez en choisir un autre parce que ce propriété doit être unique pour chaque utilisateur';
    }
    echo json_encode(array('succes' => !$erreurProduite, 'message' => $message));
  }

  public function operation_modification() {
    $login = array(
      'nom_utilisateur' => $_POST['nomUtilisateur'],
      'identifiant' => $_POST['identifiant'],
      'mot_de_passe' => hash('sha256', $_POST['motDePasse']),
      'groupe' => $_POST['groupe'],
    );
    $login_de_type_enqueteur = $_POST['enqueteur'] == 'true';
    if ($login_de_type_enqueteur) {
      $login['nom_utilisateur'] = $this->db_enqueteur->selection_nom_par_id($_POST['nomUtilisateur']);
    }
    $erreurProduite = false;
    $message = '';
    $identifiant_existant = $this->db_utilisateur->existe($login['identifiant'], $_POST['id']);
    if (!$identifiant_existant) {
      $this->db->trans_begin();
      $insertion = $this->db_utilisateur->modifier($_POST['id'], $login);
      if (!$insertion) {
        $erreurProduite = true;
      }
      if ($login_de_type_enqueteur) {
        $id_login = intval($_POST['id']);
        $insertion = $this->db_enqueteur->desassigner_login($_POST['nomUtilisateur']);
        if (!$insertion) {
          $erreurProduite = true;
        }
        $insertion = $this->db_enqueteur->attribuer_login($_POST['nomUtilisateur'], $id_login);
        if (!$insertion) {
          $erreurProduite = true;
        }
      }
      if ($erreurProduite) {
        $this->db->trans_rollback();
      } else {
        $this->db->trans_commit();
      }
    } else {
      $erreurProduite = true;
      $message = 'Le nom d\'utilisateur existe déjà, veuillez en choisir un autre aprce que ce propriété doit être unique pour chaque utilisateur';
    }
    echo json_encode(array('succes' => !$erreurProduite, 'message' => $message));
  }

  public function operaton_supprimer($id) {
    echo json_encode($this->db_utilisateur->supprimer($id));
  }

  public function operation_selection($id) {
    echo json_encode(array('utilisateur' => $this->db_utilisateur->selection_par_id($id), 'enqueteur' => $this->db_enqueteur->selectionner_par_login($id)));
  }
}
