<?php
	
	class HistoriqueModel extends CI_Model {
		public function __construct() {
			parent::__construct();
		}
		
		private function constructeur_de_requete($contraintes) {
			$colonnes_ordre = array("login", "action", "detail");
			$this->db->select(array(
				"login.nom_utilisateur" => "login",
				"action",
				"detail"
			));
			$this->db->from("historique");
			$this->db->join("login", "login.id=historique.login");
			$recherche_active = isset($contraintes['search']['value']) && !empty($contraintes['search']['value']);
			if ($recherche_active) {
				$this->db->ilike("login.nom_utilisateur", $contraintes['search']['value'])
					->or_ilike("action", $contraintes['search']['value'])
					->or_ilike("detail", $contraintes['search']['value']);
			}
			$order_active = isset($contraintes['order']) && !empty($contraintes['order']);
			if ($order_active) return $this->db->order_by($colonnes_ordre[$contraintes['order']['0']['column']], $contraintes['order']['0']['dir']);
			else return $this->db->order_by($colonnes_ordre[0], "asc");
		}
		
		public function datatable($contraintes) {
			$constructeur_de_requete = $this->constructeur_de_requete($contraintes);
			if ($contraintes['length'] != null && $contraintes['length'] != -1) $this->db->limit($contraintes['length'], $contraintes['start']);
			return $constructeur_de_requete->get()->result_array();
		}
		
		public function records_total() {
			return $this->db->from("historique")->count_all_results();
		}
		
		public function records_filtered($contraintes) {
			$query_builder = $this->constructeur_de_requete($contraintes);
			return $query_builder->get()->num_rows();
		}
		
		public function archiver($action, $detail = "") {
			$this->db->set(array(
				"login" => $this->session->userdata("id_login"),
				"action" => $action,
				"detail" => $detail
			));
			$this->db->set("date", "current_timestamp", false);
			return $this->db->insert("historique");
		}
		
		public function actualiser() {
			$this->db->set("login", $this->session->userdata("id_login"));
			$this->db->where("date", "(SELECT date FROM historique ORDER BY date DESC LIMIT 1)", FALSE);
			$this->db->update("historique");
		}
		
		public function liste_complet() {
			$this->db->select(array(
				"login.nom_utilisateur" => "utilisateur",
				"login.id" => "login",
				"action",
				"detail"
			));
			$this->db->select(array("TO_CHAR(date, 'DD TMMonth YYYY HH24:MI:SS')" => "date"), false);
			$this->db->from("historique");
			$this->db->join("login", "login.id=historique.login");
			$this->db->order_by("historique.id", "desc");
			return $this->db->get()->result_array();
		}
		
		public function nettoyer() {
			$this->db->where("id !=", 0);
			return $this->db->delete("historique");
		}
	}
