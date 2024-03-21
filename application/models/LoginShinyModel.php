<?php



class LoginShinyModel extends CI_Model {



	public function __construct() {

		parent::__construct();

	}



	public function inserer($login_shiny) {

		return $this->db->set($login_shiny)->insert('login_shiny');

	}



	private function constructeur_de_requete($contraintes) {

		$colonnes = array( 'user','nom','organisation.label');

		$this->db->select(array(

            'login_shiny.id' => 'id',
            'user',
            'nom',
            'email',
            'tel',
            'organisation.label'=>'organisation'

        ))->from('login_shiny')->join('organisation', 'login_shiny.organisation=organisation.id', 'inner');

		$recherche_active = isset($contraintes['search']['value']) && !empty($contraintes['search']['value']);

		if ($recherche_active) {

			$this->db->ilike('login_shiny.user', $contraintes['search']['value'])

				->or_ilike('organisation.label', $contraintes['search']['value']);

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

		return $this->db->from('login_shiny')->count_all_results();

	}



	public function records_filtered($contraintes) {

		$query_builder = $this->constructeur_de_requete($contraintes);

		return $query_builder->get()->num_rows();

	}

	

	public function user_existant($user) {

		return $this->db->where(array('user' => $user))->from('login_shiny')->get()->num_rows() > 0;

	}



	public function nom_existant_en_dehors_id($id, $nom) {

		$this->db->where('id !=', $id);

		return $this->db->where(array('UPPER(user)' => $this->db->escape_str(strtoupper($nom))))->from('login_shiny')->get()->num_rows() > 0;

	}



	public function modifier($id, $login_shiny) {

		return $this->db->set($login_shiny)->where('id', intval($id))->update('login_shiny');

	}



	public function selection_par_id($id) {

		return $this->db->from('login_shiny')->where('id', intval($id))->get()->result_array()[0];

	}



	public function supprimer($id) {

		return $this->db->where('id', intval($id))->delete('login_shiny');

	}


    public function existe_login_shiny($login_shiny, $id = 0) {

        if (intval($id) !== 0) $this->db->where('id != ', intval($id));

        return $this->db->where(array('user' => $login_shiny))->from('login_shiny')->get()->num_rows() > 0;

    }



	public function dernier_id() {

		return intval($this->db->select('id')->from('login_shiny')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

	}


	

	public function liste() {

		return $this->db->get('login_shiny')->result_array();

	}

	

}

