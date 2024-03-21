<?php
	
	class FichePecheurModel extends CI_Model {
		public function __construct() {
			parent::__construct();
		}
		
		public function inserer($fiche_pecheur) {
			return $this->db->set($fiche_pecheur)->insert('fiche_pecheur');
		}
		
		public function mettre_a_jour($fiche_pecheur, $id) {
			return $this->db->set($fiche_pecheur)->where('id', intval($id))->update('fiche_pecheur');
		}
		
		public function supprimer($fiche_pecheur) {
			return $this->db->where('id', $fiche_pecheur)->delete('fiche_pecheur');
		}
		
		public function dernier_id() {
			return intval($this->db->select('id')->from('fiche_pecheur')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);
		}
		
		public function liste_par_fiche($fiche) {
			$investigation_date = "TO_CHAR(date, 'DD TMMonth YYYY')";
			$this->db->select(array($investigation_date => 'date_literalle'), false);
			$this->db->select(array("CASE WHEN avec_pirogue THEN 1 ELSE 0 END" => 'avec_pirogue'), false);
			$this->db->select(array(
				'id',
				'date' => 'date_bd',
				"partenaire_peche_individu",
				"partenaire_peche_nombre",
				"consommation_crabe_poids",
				"consommation_crabe_nombre",
				"collecte_poids",
				"collecte_prix",
				"marche_local_poids",
				"marche_local_prix",
			))->from('fiche_pecheur');
			$this->db->order_by('fiche_pecheur');
			$this->db->where('fiche', intval($fiche));
			return $this->db->get()->result_array();
		}
		
		public function enquete_total_par_fiche($fiche) {
			return $this->db->select('id')->from('fiche_pecheur')->where('fiche', intval($fiche))->get()->num_rows();
		}
		
		public function selection_par_id($fiche_enquete) {
			return $this->db->select(array(
				'id',
				'date' => 'date_originale',
				'partenaire_peche_individu',
				'partenaire_peche_nombre',
				'consommation_crabe_poids',
				'consommation_crabe_nombre',
				'collecte_poids',
				'collecte_prix',
				'marche_local_poids',
				'marche_local_prix',
				'fiche'
			))
				->select(array('case when avec_pirogue then 1 else 0 end' => 'avec_pirogue'), false)
				->from('fiche_pecheur')->where('id', intval($fiche_enquete))->get()->result_array()[0];
		}
		
		public function selection_jour_par_fiche($fiche) {
			$this->db->select('id');
			$this->db->select(array('extract(day from date)::integer' => 'jour'), false);
			$this->db->from('fiche_pecheur');
			$this->db->where('fiche', intval($fiche));
			return $this->db->get()->result_array();
		}
		
		public function generation_csv($champs, $dictionnaire_des_champs, $contrainte_date) {
			foreach ($champs as $champ) {
				$appliquer_order_by = true;
				if ($champ === "engin") {
					$this->db->select(array("(SELECT engin.nom FROM engin INNER JOIN engin_fiche_pecheur ON engin_fiche_pecheur.engin=engin.id WHERE engin_fiche_pecheur.fiche_pecheur=fiche_pecheur.id LIMIT 1)" => "engin1", false));
					$this->db->select(array("(SELECT engin_fiche_pecheur.nombre FROM engin_fiche_pecheur WHERE engin_fiche_pecheur.fiche_pecheur=fiche_pecheur.id LIMIT 1)" => "nombre1", false));
					$this->db->select(array("(SELECT engin.nom FROM engin INNER JOIN engin_fiche_pecheur ON engin_fiche_pecheur.engin=engin.id WHERE engin_fiche_pecheur.fiche_pecheur=fiche_pecheur.id LIMIT 1 OFFSET 1)" => "engin2", false));
					$this->db->select(array("(SELECT engin_fiche_pecheur.nombre FROM engin_fiche_pecheur WHERE engin_fiche_pecheur.fiche_pecheur=fiche_pecheur.id LIMIT 1 OFFSET 1)" => "nombre2", false));
					$appliquer_order_by = false;
				} else if ($champ === "fiche_pecheur.avec_pirogue") $this->db->select(array("CASE WHEN fiche_pecheur.avec_pirogue THEN 'true' ELSE 'false' END" => "avec_pirogue"), false);
				else if (isset($dictionnaire_des_champs[$champ])) $this->db->select(array(strval($champ) => $dictionnaire_des_champs[$champ]));
				else $this->db->select($champ);
				if ($appliquer_order_by) $this->db->order_by($champ);
			}
			foreach ($contrainte_date as $contrainte) {
				$this->db->where($contrainte);
			}
			$this->db->from("fiche_pecheur");
			$this->db->join("fiche", "fiche.id=fiche_pecheur.fiche");
			$this->db->join("village", "village.id=fiche.village");
			$this->db->join("fokontany", "fokontany.id=village.fokontany");
			$this->db->join("commune", "commune.id=fokontany.commune");
			$this->db->join("district", "district.id=commune.district");
			$this->db->join("region", "region.id=district.region");
			$this->db->join("zone_corecrabe", "zone_corecrabe.id=region.zone_corecrabe");
			return $this->db->get()->result_array();
		}
	}
