<?php

	

	class UtilisateurModel extends CI_Model {

		public function __construct() {

			parent::__construct();

		}

		

		public function insertion($utilisateur) {

			return $this->db->set($utilisateur)->insert('login');

		}

		

		private function constructeur_de_requete($contraintes) {

			$colonnes = array('identifiant', 'nom_utilisateur', 'groupe.nom');

			$this->db

				->select(array(

					'login.id' => 'id',

					'identifiant',

					'nom_utilisateur' => 'nom',

					'groupe.nom' => 'groupe'

				))

				->from('login')->join('groupe', 'login.groupe=groupe.id', 'inner');

			$recherche_active = isset($contraintes['search']['value']) && !empty($contraintes['search']['value']);

			if ($recherche_active) {

				$this->db->ilike('identifiant', $contraintes['search']['value'])

					->or_ilike('groupe.nom', $contraintes['search']['value']);

			}

			$order_active = isset($contraintes['order']) && !empty($contraintes['order']);

			if ($order_active) return $this->db->order_by($colonnes[$contraintes['order']['0']['column']], $contraintes['order']['0']['dir']);

			else return $this->db->order_by($colonnes[0], 'asc');

		}

		

		public function datatable($contraintes) {

			$constructeur_de_requete = $this->constructeur_de_requete($contraintes);

			if ($contraintes['length'] != null && $contraintes['length'] != -1) $this->db->limit($contraintes['length'], $contraintes['start']);

			return $constructeur_de_requete->get()->result_array();

		}

		

		public function records_total() {

			return $this->db->from('login')->count_all_results();

		}

		

		public function records_filtered($contraintes) {

			$query_builder = $this->constructeur_de_requete($contraintes);

			return $query_builder->get()->num_rows();

		}

		

		public function dernier_login() {

			return intval($this->db->select('id')->order_by('id', 'desc')->limit('1')->get('login')->result_array()[0]['id']);

		}

		

		public function existe($identifiant, $id = 0) {

			if (intval($id) !== 0) $this->db->where('id != ', intval($id));

			return $this->db->where(array('identifiant' => $identifiant))->from('login')->get()->num_rows() > 0;

		}

		

		public function modifier($id, $login) {

			return $this->db->set($login)->where('id', intval($id))->update('login');

		}

		

		public function selection_par_id($id) {

			return $this->db->from('login')->where('id', intval($id))->get()->result_array()[0];

		}

		

		public function supprimer($id) {

			$this->db->where('login', intval($id))->set(array('login' => null))->update('enqueteur');

			return $this->db->where('id', intval($id))->delete('login');

		}

		

		public function verifier_donnees_de_connexion($donnees) {

			return $this->db->from('login')->where($donnees)->get()->num_rows() > 0;

		}

		

		public function information_utilisateur_complet($donnees) {

			$login = $this->db->select(array("login.id" => "id_login", 'identifiant', 'nom_utilisateur', 'groupe'))->from('login')->where($donnees)->get()->result_array()[0];

			$login['groupe'] = $this->db->from('groupe')->where('id', intval($login['groupe']))->get()->result_array()[0];

			$enqueteur = $this->db->select('enqueteur.*, village.nom as NomVillage')->from('enqueteur')->where('enqueteur.login', intval($login['id_login']))->join('village', 'enqueteur.village=village.id', 'inner')->get()->result_array();

			$login['enqueteur'] = is_array($enqueteur) && count($enqueteur) > 0 ? $enqueteur[0] : null;

			return $login;

		}

	}

