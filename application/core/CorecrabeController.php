<?php
	
	
	class CorecrabeController extends CI_Controller {
		protected $root_states = array();
		protected $mois_francais = array('Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
		
		public function __construct() {
			parent::__construct();
			/* *
			 * Chargement des helpers qui vont être utilisés pour les contrôleurs héritants la classe CorecrabeController
			 * Par convention tous les contrôleurs seront nommées %Class%Controller
			 * La configuration de route se chargera des mappings de sorte que les liens sera:
			 * * %class% => %Class%Controller
			 * * %class%/snake_case_method/snake_case_args/... => %Class%Controller/camelCaseMethod/camelCaseArgs/...
			 */
			$this->load->helper('assets');
			$this->load->helper('route');
			// Configuration par défauts et initialisation de l'état initial global de cmposant de base
			$this->root_states = array(
				'titre' => 'Corecrabe',
				'default_stylesheets' => array(
					'open-sans-pro.css',
					'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
					'fontawesome-free/css/all.min.css',
					'adminlte.min.css',					'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css'
				),
				'custom_stylesheets' => array(),
				'default_javascripts' => array(
					'jquery.min.js',
					'bootstrap.bundle.min.js',
					'adminlte.min.js',
					'pages/utils.js'
				),
				'custom_javascripts' => array(),
				'body_classes' => array(),
				'routes' => ''
			);
		}
		
		public function index() {
			$this->load->view('index', $this->root_states, false);
		}
	}
