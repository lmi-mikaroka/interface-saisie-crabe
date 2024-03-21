<?php

	

	class ActiviteController extends CI_Controller {

		public function __construct() {

			parent::__construct();

			

			// chargement des models à utiliser

			

		}

		

		public function index() {

		

		}


		public function liste_tous() {

			echo json_encode($this->db_activite->liste());

		}

		

		public function insertion() {

			$activite = array(

				'nom' => $this->input->post('nom'),

			);

			$insertion = $this->db_crabe->insertion($activite);

			echo json_encode(array('success' => $insertion));

		}

	}

