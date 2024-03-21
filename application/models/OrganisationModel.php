<?php



class OrganisationModel extends CI_Model {



	public function __construct() {

		parent::__construct();

	}



	public function inserer($organisation) {

		return $this->db->set($organisation)->insert('organisation');

	}



	private function constructeur_de_requete($contraintes) {

		$colonnes = array('id', 'label');

		$this->db->from('organisation');

		$recherche_active = isset($contraintes['search']['value']) && !empty($contraintes['search']['value']);

		if ($recherche_active) {

			$this->db->ilike('id::varchar', $contraintes['search']['value'])

				->or_ilike('label', $contraintes['search']['value']);

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

		return $this->db->from('organisation')->count_all_results();

	}



	public function records_filtered($contraintes) {

		$query_builder = $this->constructeur_de_requete($contraintes);

		return $query_builder->get()->num_rows();

	}

	

	public function nom_existant($nom) {

		return $this->db->where(array('UPPER(label)' => $this->db->escape_str(strtoupper($nom))), false)->from('organisation')->get()->num_rows() > 0;

	}



	public function nom_existant_en_dehors_id($id, $nom) {

		$this->db->where('id !=', $id);

		return $this->db->where(array('UPPER(label)' => $this->db->escape_str(strtoupper($nom))))->from('organisation')->get()->num_rows() > 0;

	}



	public function modifier($id, $organisation) {

		return $this->db->set($organisation)->where('id', intval($id))->update('organisation');

	}



	public function selection_par_id($id) {

		return $this->db->from('organisation')->where('id', intval($id))->get()->result_array()[0];

	}



	public function supprimer($id) {

		return $this->db->where('id', intval($id))->delete('organisation');

	}


    public function existe_organisation($organisation, $id = 0) {

        if (intval($id) !== 0) $this->db->where('id != ', intval($id));

        return $this->db->where(array('label' => $organisation))->from('organisation')->get()->num_rows() > 0;

    }



	public function dernier_id() {

		return intval($this->db->select('id')->from('organisation')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

	}


	

	public function liste() {

		return $this->db->get('organisation')->result_array();

	}

	

}

