<?php

	

	class SuiviPrimeModel extends CI_Model {

		public function __construct() {

			parent::__construct();

		}


		public function archiver($idenquete) {

			$this->db->set(array(

				"utilisateur" => $this->session->userdata("id_login"),

				"enquete" => $idenquete,

			));

			$this->db->set("dateheure", "current_timestamp", false);

			return $this->db->insert("suivi_prime");

		}

		

		


	}
