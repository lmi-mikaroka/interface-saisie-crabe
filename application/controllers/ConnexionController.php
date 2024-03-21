<?php
class ConnexionController extends CorecrabeController {
  public function __construct() {
    parent::__construct();

    // styles et scripts personnalises
    $this->root_states['body_classes'] = array(
      'login-page',
    );
  }

  public function page_connexion() {
    if (!empty($this->session->userdata('token'))) {
      redirect(base_url('/'));
    }
    // chargement de la vue d'insertion et modification dans une variable
    $this->root_states['title'] = 'Page de connexion';
    $this->root_states['custom_stylesheets'] = array_merge($this->root_states['custom_stylesheets'], array(
      'jquery-confirm.min.css',
      'icheck-bootstrap.min.css',
    ));
    $this->root_states['custom_javascripts'] = array_merge($this->root_states['custom_javascripts'], array(
      'jquery-confirm.min.js',
      'jquery-confirm.min.js',
      'pages/connexion.js',
    ));
    // affichage du composant dans la vue de base
    $this->root_states['routes'] = $this->load->view('connexion.php', null, true);
    // importation des composants dans la vue racine
    $this->load->view('index.php', $this->root_states, false);
  }

  public function operation_validation_login() {
    $donnees_formulalire = array('identifiant' => $_POST['identifiant'], 'mot_de_passe' => hash('sha256', $_POST['motDePasse']));
    $existe = $this->db_utilisateur->verifier_donnees_de_connexion($donnees_formulalire);
    $autorise = true;
    $message = '';
    if ($existe) {
      $information_login = $this->db_utilisateur->information_utilisateur_complet($donnees_formulalire);
      $information_login['groupe']['autorisations'] = $this->db_groupe->selection_autorisation_par_groupe($information_login['groupe']['id']);
      $information_login['token'] = (new DateTime())->getTimestamp();
      $this->session->set_userdata($information_login);
    } else {
      $autorise = false;
      $message = 'Impossible de demarrer une session, veuillez vérifier que:<ul><li>Les informations que vous avez fournies sont correctes</li><li>L\'administrateur a ajouté votre identifiant dans la base de données</li></ul>';
    }
	  $this->db_historique->archiver("Connexion");
    echo json_encode(array('autorise'=> $autorise, 'message' => $message));
  }

  public function page_deconnexion() {
	  $this->db_historique->archiver("Déconnexion");
    $this->session->sess_destroy();
    header('location:'.site_url('/connexion'));
  }
}
