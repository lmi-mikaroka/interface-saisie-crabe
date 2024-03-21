<?php



class SocieteModel extends CI_Model {



	public function __construct() {

		parent::__construct();

	}



	public function inserer($societe) {

		return $this->db->set($societe)->insert('societe');

	}

	public function lastSociete($societe) {
		return intval($this->db->select('id')->from('societe')->where($societe)->limit(1)->get()->result_array()[0]['id']);
	}



	private function query_builder($constraints) {

		$orderable_columns = array('societe.nom');

		$this->db->select(array('*'))->from('societe');

			// ->join('village', 'village=village.id', 'inner');

		if (isset($constraints['search']['value']) && !empty($constraints['search']['value'])) {

			$this->db->ilike('societe.nom', $constraints['search']['value']);

		}

		if ((isset($constraints['order']) && !empty($constraints['order']))) return $this->db->order_by($orderable_columns[$constraints['order']['0']['column']], $constraints['order']['0']['dir']);

		else return $this->db->order_by($orderable_columns[0], 'asc');

	}



	public function datatable($constraints) {

		$query_builder = $this->query_builder($constraints);

		if ($constraints['length'] != null && $constraints['length'] != -1) $query_builder->limit($constraints['length'], $constraints['start']);

		return $query_builder->get()->result_array();

	}



	public function records_total() {

		return $this->db->from('societe')->count_all_results();

	}



	public function records_filtered($constraints) {

		$query_builder = $this->query_builder($constraints);

		return $query_builder->get()->num_rows();

	}



	public function selection_par_id($id) {

		return $this->db->from('societe')->where('id', intval($id))->get()->result_array()[0];

	}



	public function supprimer($id) {

		return $this->db->where('id', intval($id))->delete('societe');

	}



	public function mettre_a_jour($societe, $id) {

		return $this->db->set($societe)->where('id', intval($id))->update('societe');

	}



	public function liste() {

		return $this->db->from('societe')->order_by('nom', 'asc')->get()->result_array();

	}


}

