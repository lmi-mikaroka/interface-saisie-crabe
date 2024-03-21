<?php
	
	class HistoriqueController extends ApplicationController {
		public function __construct() {
			parent::__construct();
			// Chargement des composants statiques de bases (header, footer)
			$this->application_component['header_component'] = $this->load->view('basic-structure/topbar.php', array('utilisateur' => array('nom' => $this->session->userdata('nom_utilisateur'))), true);
			$this->application_component['footer_component'] = $this->load->view('basic-structure/footer.php', null, true);
		}
		
		public function page_presentation() {
			$this->root_states['title'] = 'Historique';
			$this->root_states['custom_javascripts'] = array(
				'pages/historique/index.js',
			);
			// précision du route courant afin d'ajouter la "classe" active au lien du composant actif
			$etat_menu = array(
				'active_route' => 'historique'
			);
			// rassembler les vues chargées
			$this->application_component['aside_menu_component'] = $this->load->view('basic-structure/aside-menu.php', $etat_menu, true);
			$this->application_component['context_component'] = $this->load->view('historique/index.php',array("historiques" => $this->db_historique->liste_complet()), true);
			// affichage du composant dans la vue de base
			$this->root_states['routes'] = $this->load->view('basic-structure/application.php', $this->application_component, true);
			// importation des composants dans la vue racine
			if($this->lib_autorisation->visualisation_autorise(23))
				$this->load->view('index.php', $this->root_states, false);
		}
		
		public function operation_nettoyer() {
			$this->db_historique->nettoyer();
			header("location:".site_url("historique"));
		}
	}
