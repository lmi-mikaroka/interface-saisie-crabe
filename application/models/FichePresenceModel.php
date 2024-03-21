<?php

	class FichePresenceModel extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}

        public function liste_fiche_presence($village){
            
            $this->db->select('pecheur.id, pecheur.nom,pecheur.sexe');
            $this->db->from('enquete_recensement')->join("pecheur","pecheur=pecheur.id")->where('pecheur.village',intval($village))->group_by(array("pecheur.id", "pecheur.nom","pecheur.sexe"))->order_by('pecheur.nom','asc');
            $query1 = $this->db->get_compiled_select();
            $query = $this->db->query($query1);
            return $query->result_array();
    
        }

        public function existe($fiche) {

			return $this->db->select('id')->from('recensement_mensuel_prime')->where($fiche)->get()->num_rows() > 0;

		}
		public function existe_id($fiche){

			return intval($this->db->select('id')->from('recensement_mensuel_prime')->where($fiche)->get()->result_array()[0]['id']);
		}

        public function inserer($fiche) {

			return $this->db->set($fiche)->insert('recensement_mensuel_prime');

		}

        public function fiche_presence_id($fiche) {

            return intval($this->db->select('id')->from('recensement_mensuel_prime')->where($fiche)->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);
    
        }
        public function existe_presence($fiche){

            return $this->db->select('id')->from('enquete_recensement_mensuel_prime')->where($fiche)->get()->num_rows() > 0;

        }

        public function mettre_a_jour_enquete($enquete, $id) {

			return $this->db->set($enquete)->where('id', intval($id))->update('enquete_recensement_mensuel_prime');

		}
        public function inserer_enquete($enquete) {

			return $this->db->set($enquete)->insert('enquete_recensement_mensuel_prime');

		}
        public function existe_presence_id($fiche){
            return intval($this->db->select('id')->from('enquete_recensement_mensuel_prime')->where($fiche)->get()->result_array()[0]['id']);
        }
        public function requeteCrabe($village,$pecheur,$annee,$mois) {

            return $this->db->select('crabe')->from('enquete_recensement_mensuel_prime')->join('recensement_mensuel_prime','recensement_mensuel_prime=recensement_mensuel_prime.id')
            ->where('recensement_mensuel_prime.village',intval($village))->where('recensement_mensuel_prime.annee',intval($annee))->where('recensement_mensuel_prime.mois',intval($mois))->where('enquete_recensement_mensuel_prime.pecheur',intval($pecheur))->get()->result_array();
    
        }

        public function liste_fiche_presence_trie($village){
            
            $this->db->select('pecheur.id, pecheur.nom,pecheur.datenais,pecheur.sexe,pecheur.nouveau');
            $this->db->from('enquete_recensement')->join("pecheur","pecheur=pecheur.id")->where('pecheur.village',intval($village))->group_by(array("pecheur.id", "pecheur.nom","pecheur.datenais","pecheur.sexe","pecheur.nouveau"));
            $query1 = $this->db->get_compiled_select();
            // $query = $this->db->query($query1 .'ORDER BY CASE WHEN datenais IS NULL THEN 1 ELSE 0 END, nom asc');
            $query = $this->db->query($query1 .'ORDER BY CASE WHEN nouveau IS NULL THEN 1 ELSE 0 END, CASE WHEN datenais IS NULL THEN 1 ELSE 0 END, nom asc');
            return $query->result_array();
    
        }
        public function fiche_presence_liste($pecheur, $contraintes)
        {
            $this->db->select('annee,mois,crabe')->from('requete_consultation_presence_web');
            if(count($contraintes)>0){
                $this->db->group_start();
                foreach($contraintes as $contrainte){
                    $this->db->or_group_start();
                    $this->db->where('annee',$contrainte['annee']);
                    $this->db->where('mois',$contrainte['mois']);
                    $this->db->group_end();
                }
                $this->db->group_end();
                $this->db->where('idpecheur',$pecheur);
                return $this->db->group_by('annee,mois,crabe')->order_by('annee,mois')->get()->result_array();
            }
        }

    }
