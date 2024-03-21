<?php

class ZoneCorecrabeModel extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function inserer($zone_corecrabe) {
		return $this->db->set($zone_corecrabe)->insert('zone_corecrabe');
	}

	private function constructeur_de_requete($contraintes) {
		$orderable_columns = array('nom');
		$this->db->select(array('id', 'nom'))->from('zone_corecrabe');
		if (isset($contraintes['search']['value']) && !empty($contraintes['search']['value'])) {
			$this->db->ilike('nom', $contraintes['search']['value']);
		}
		if ((isset($contraintes['order']) && !empty($contraintes['order']))) return $this->db->order_by($orderable_columns[$contraintes['order']['0']['column']], $contraintes['order']['0']['dir']);
		else return $this->db->order_by($orderable_columns[0], 'asc');
	}

	public function datatable($contraintes) {
		$query_builder = $this->constructeur_de_requete($contraintes);
		if ($contraintes['length'] != null && $contraintes['length'] != -1) $this->db->limit($contraintes['length'], $contraintes['start']);
		return $query_builder->get()->result_array();
	}

	public function enregistrement_total() {
		return $this->db->from('zone_corecrabe')->count_all_results();
	}

	public function enregistrement_filtre($constraints) {
		$query_builder = $this->constructeur_de_requete($constraints);
		return $query_builder->get()->num_rows();
	}

	public function supprimer($id) {
		return $this->db->where('id', intval($id))->delete('zone_corecrabe');
	}

	public function mettre_a_jour($zone_corecrabe, $id) {
		return $this->db->set($zone_corecrabe)->where('id', $id)->update('zone_corecrabe');
	}

	public function selection_par_id($id) {
		return $this->db->from('zone_corecrabe')->where('id', intval($id))->get()->result_array()[0];
	}

	public function liste() {
		return $this->db->order_by('id', 'asc')->get('zone_corecrabe')->result_array();
	}
	
	public function selection_par_village($village) {
		$this->db->select(array('zone_corecrabe.id', 'zone_corecrabe.nom'))->from('zone_corecrabe');
		$this->db->join('region', 'region.zone_corecrabe=zone_corecrabe.id');
		$this->db->join('district', 'district.region=region.id');
		$this->db->join('commune', 'commune.district=district.id');
		$this->db->join('fokontany', 'fokontany.commune=commune.id');
		$this->db->join('village', 'village.fokontany=fokontany.id');
		$this->db->where('village.id', intval($village));
		return $this->db->get()->result_array()[0];
	}
}
