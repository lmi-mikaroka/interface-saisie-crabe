<?php
	
	class EnginModel extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function liste() {
			return $this->db->from('engin')->order_by('id')->get()->result_array();
		}
		
		public function selection_engin_sortie_de_peche_enqueteur_par_sortie_de_peche_enqueteur($sortie_de_peche_enqueteur) {
			$this->db->select(array("nom", "nombre", "engin", "sortie_de_peche_enqueteur"));
			$this->db->join("engin", "engin.id=engin_sortie_de_peche_enqueteur.engin");
			return $this->db->from('engin_sortie_de_peche_enqueteur')->where('sortie_de_peche_enqueteur', intval($sortie_de_peche_enqueteur))->order_by("engin_sortie_de_peche_enqueteur.id")->get()->result_array();
		}
		
		public function inserer_engin_sortie_de_peche_enqueteur($engin_sortie_de_peche_enqueteur) {
			return $this->db->set($engin_sortie_de_peche_enqueteur)->insert('engin_sortie_de_peche_enqueteur');
		}
		
		public function inserer_engin_fiche_pecheur($engin_fiche_pecheur) {
			return $this->db->set($engin_fiche_pecheur)->insert('engin_fiche_pecheur');
		}

		public function inserer_engin_fiche_recensement($engin_fiche_recensement) {
			return $this->db->set($engin_fiche_recensement)->insert('engin_fiche_recensement');
		}
		
		public function supprimer_engin_fiche_pecheur($fiche_pecheur) {
			return $this->db->where(array('fiche_pecheur' => intval($fiche_pecheur)))->delete('engin_fiche_pecheur');
		}
		public function supprimer_engin_fiche_recensement($fiche_recensement) {
			return $this->db->where(array('fiche_recensement' => intval($fiche_recensement)))->delete('engin_fiche_recensement');
		}
		
		public function selection_engin_fiche_pecheur_par_fiche_pecheur($fiche_pecheur) {
			return $this->db->from('engin_fiche_pecheur')->where('fiche_pecheur', intval($fiche_pecheur))->order_by('id')->get()->result_array();
		}
		
		public function inserer_engin_sortie_de_peche_acheteur($engin_sortie_de_peche_acheteur) {
			return $this->db->set($engin_sortie_de_peche_acheteur)->insert('engin_sortie_de_peche_acheteur');
		}
		
		public function selection_engin_sortie_de_peche_acheteur_par_sortie_de_peche_acheteur($sortie_de_peche_acheteur) {
			$this->db->select(array("nom", "nombre", "engin", "sortie_de_peche_acheteur"));
			$this->db->join("engin", "engin.id=engin_sortie_de_peche_acheteur.engin");
			return $this->db->from('engin_sortie_de_peche_acheteur')->where('sortie_de_peche_acheteur', intval($sortie_de_peche_acheteur))->order_by('engin_sortie_de_peche_acheteur.id')->get()->result_array();
		}
		
		public function supprimer_engin_sortie_de_pecheur_enqueteur_par_sortie_de_peche($sortie_de_peche) {
			return $this->db->where('sortie_de_peche_enqueteur', intval($sortie_de_peche))->delete('engin_sortie_de_peche_enqueteur');
		}

		public function inserer_engin_enqute_recensement($engin_enquete_recensement) {
			return $this->db->set($engin_enquete_recensement)->insert('engin_enquete_recensement');
		}

		public function supprimer_engin_enquete_recensement($enquete_recensement) {
			return $this->db->where(array('enquete_recensement' => intval($enquete_recensement)))->delete('engin_enquete_recensement');
		}
	}
