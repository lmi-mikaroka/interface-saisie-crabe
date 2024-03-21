<?php

class ConnexionAPI extends CI_Controller {
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
    }

    public function login(){
        if(isset($_GET['user'])&&$_GET['user']!=""&&isset($_GET['pass'])&&$_GET['pass']!=""){

            $donnees_formulalire = array('identifiant' =>$_GET['user'], 'mot_de_passe' => hash('sha256', $_GET['pass']));

            $existe = $this->db_utilisateur->verifier_donnees_de_connexion($donnees_formulalire);

            $autorise = true;

            $message = 'Connexion établie';

            $id = 0;

            $info_user = null;

            if ($existe) {

            $information_login = $this->db_utilisateur->information_utilisateur_complet($donnees_formulalire);
            
            $info_user = $information_login;

            $information_login['groupe']['autorisations'] = $this->db_groupe->selection_autorisation_par_groupe($information_login['groupe']['id']);

            $information_login['token'] = (new DateTime())->getTimestamp();

            $this->session->set_userdata($information_login);

            } else {
                $id = 1;

                $autorise = false;

                $message = 'Impossible de demarrer une session! Informations incorrectes';

            }

	        //$this->db_historique->archiver("Connexion");
            echo json_encode(array('autorise'=> $autorise,'user'=>$info_user), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            

            /*$this->output->set_content_type('application/json','utf-8')
            ->set_output(json_encode($resultat,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));*/

        }
    }
}
