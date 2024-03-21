<?php



class LoginShinyController extends ApplicationController {



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

      'pages/login_shiny/index.js',

      'pages/login_shiny/insert-modal.js',

      'pages/login_shiny/update-modal.js',

    );



    // précision du route courant afin d'ajouter la "classe" active au lien du composant actif

    $etat_menu = array(

      'active_route' => 'login_shiny'

    );

    $etat_contexte_courant = array(

      'insert_modal_component' => $this->load->view('login_shiny/modal-insertion.php', array(

        'organisations' => $this->db_organisation->liste(),


      ), true),

      'update_modal_component' => $this->load->view('login_shiny/modal-modification.php', null, true),

	    'autorisation_creation' => $this->lib_autorisation->creation_autorise(24),

	    'autorisation_modification' => $this->lib_autorisation->modification_autorise(24),

	    'session' => $this->session->userdata()

    );

    // rassembler les vues chargées

    $this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);

    $this->application_component['context_component'] = $this->load->view('login_shiny/crud-login-shiny.php', $etat_contexte_courant, true);

    // affichage du composant dans la vue de base

    $this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);

    // importation des composants dans la vue racine

    $this->load->view('index.php', $this->root_states, false);

  }



  public function operation_datatable() {

    // requisition des données à afficher avec les contraintes

    $data_query = $this->db_login_shiny->datatable($_POST);

    // chargement des données formatées

    $data = array();

    foreach ($data_query as $query_result) {

      $data[] = array(



        $query_result['user'],

        $query_result['email'],

        $query_result['nom'],

        $query_result['tel'],

        $query_result['organisation'],

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

      'recordsTotal' => $this->db_login_shiny->records_total(),

      'recordsFiltered' => $this->db_login_shiny->records_filtered($_POST),

      'data' => $data

    ));

  }



  public function operation_insertion() {

    $login_shiny = array(

      'nom' => $_POST['nom'],

      'user' => $_POST['email'],

      'password' => $_POST['password'],

      'tel' => $_POST['tel'],

      'email' => $_POST['email'],

      'organisation' => $_POST['organisation'],

    );


    $erreurProduite = false;

    $message = '';

    $identifiant_existant = $this->db_login_shiny->user_existant($login_shiny['user']);

    if (!$identifiant_existant) {

      $this->db->trans_begin();

      $insertion = $this->db_login_shiny->inserer($login_shiny);

      if (!$insertion)

        $erreurProduite = true;

      if ($erreurProduite)

        $this->db->trans_rollback();

      else

        $this->db->trans_commit();

    } else {

      $erreurProduite = true;

      $message = 'Le nom d\'utilisateur existe déjà, veuillez en choisir un autre';

    }

    echo json_encode(array('succes' => !$erreurProduite, 'message' => $message));

  }



  public function operation_modification() {

    $login_shiny = array(

      'nom' => $_POST['nom'],

      'user' => $_POST['email'],

      'password' => $_POST['password'],

      'tel' => $_POST['tel'],

      'email' => $_POST['email'],

      'organisation' => $_POST['organisation'],

    );

    $erreurProduite = false;

    $message = '';

    $identifiant_existant = $this->db_login_shiny->existe_login_shiny($login_shiny['user'], $_POST['id']);

    if (!$identifiant_existant) {

      $this->db->trans_begin();

      $insertion = $this->db_login_shiny->modifier($_POST['id'], $login_shiny);

      if (!$insertion) {

        $erreurProduite = true;

      }


      if ($erreurProduite) {

        $this->db->trans_rollback();

      } else {

        $this->db->trans_commit();

      }

    } else {

      $erreurProduite = true;

      $message = 'Le nom d\'utilisateur existe déjà, veuillez en choisir un autre parce que ce propriété doit être unique pour chaque utilisateur';

    }

    echo json_encode(array('succes' => !$erreurProduite, 'message' => $message));

  }



  public function operation_supprimer($id) {

    echo json_encode($this->db_login_shiny->supprimer($id));

  }



  public function operation_selection($id) {

    echo json_encode( $this->db_login_shiny->selection_par_id($id));

  }

}

