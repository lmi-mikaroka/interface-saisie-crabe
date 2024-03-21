<?php
	
	class FicheAcheteurModel extends CI_Model {
		public function __construct() {
			parent::__construct();
		}
		
		public function insertion_fiche($fiche) {
			return $this->db->set($fiche)->insert('fiche_acheteur');
		}
		
		public function modification_fiche($fiche_enquete, $reference) {
			return $this->db->set($fiche_enquete)->where('id', $reference)->update('fiche_acheteur');
		}
		
		public function insertion_dernier_sortie($sortie) {
			return $this->db->set($sortie)->insert('sortie_de_peche_acheteur');
		}
		
		public function supprimer_sortie_de_peche_par_fiche($fiche_enquete) {
			return $this->db->where('fiche_acheteur', $fiche_enquete)->delete('sortie_de_peche_acheteur');
		}
		
		public function supprimer_sortie_de_vente_crabe_par_fiche_acheteur($fiche_enquete) {
			return $this->db->where('fiche_acheteur', $fiche_enquete)->delete('sortie_de_vente_crabe_acheteur');
		}
		
		public function derniere_fiche() {
			return intval($this->db->select('id')->from('fiche_acheteur')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);
		}
		
		public function derniere_sortie_de_peche() {
			return intval($this->db->select('id')->from('sortie_de_peche_acheteur')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);
		}
		
		public function liste_par_fiche($id_fiche) {
			$investigation_date = "TO_CHAR(date, 'DD TMMonth YYYY')";
			$this->db->select(array($investigation_date => 'date_literalle'), false);
			$this->db->select(array(
				'fiche_acheteur.id',
				'date',
				'pecheur',
				'pecheur_nombre',
				'collecte_poids1',
				'collecte_prix1',
				'collecte_poids2',
				'collecte_prix2',
				'marche_local_poids',
				'marche_local_prix',
				'crabe_non_vendu_poids',
				'crabe_non_vendu_nombre',
				"nombre_sortie_vente"
			))->from('fiche_acheteur');
			$this->db->join('pecheur', 'pecheur=pecheur.id', 'inner');
			$this->db->order_by('id', 'asc');
			$this->db->where('fiche', $id_fiche);
			return $this->db->get()->result_array();
		}
		
		public function total_enquete_par_fiche($id_fiche) {
			return $this->db->select('id')->from('fiche_acheteur')->where('fiche', $id_fiche)->get()->num_rows();
		}
		
		public function supprimer_fiche_acheteur($fiche_acheteur) {
			return $this->db->where(array('id' => $fiche_acheteur))->delete('fiche_acheteur');
		}
		
		public function selection_par_id($fiche_enquete) {
			return $this->db->from('fiche_acheteur')->where('id', $fiche_enquete)->get()->result_array()[0];
		}
		
		public function selection_dernier_sortie_de_peche($fiche_enquete) {
			return $this->db->select(array(
				'id',
				'nombre',
				'pirogue',
				'date' => 'date_originale'
			))
				->select(array("TO_CHAR(date, 'DD/MM/YYYY')" => 'date_literalle'), FALSE)
				->from('sortie_de_peche_acheteur')
				->order_by('date', 'desc')
				->where('fiche_acheteur', intval($fiche_enquete))
				->get()->result_array();
		}
		
		public function selection_sortie_de_vente_de_crabe($fiche_enquete) {
			return $this->db->select(array(
				'id',
				'nombre',
				'date' => 'date_originale',
				'fiche_acheteur'
			))
				->select(array("TO_CHAR(date, 'DD/MM/YYYY')" => 'date_literalle'), false)
				->from('sortie_de_vente_crabe_acheteur')
				->where('fiche_acheteur', intval($fiche_enquete))
				->order_by('date', 'desc')->get()->result_array();
		}

		public function selection_jour_par_fiche($fiche) {
			$this->db->select('id');
			$this->db->select(array('extract(day from date)::integer' => 'jour'), false);
			$this->db->from('fiche_acheteur');
			$this->db->where('fiche', intval($fiche));
			return $this->db->get()->result_array();
		}
		
		public function generation_csv($champs, $dictionnaire_des_champs, $contrainte_dates) {
			$sortie_des_peches = array(
				"sortie_peche_1",
				"sortie_peche_2",
				"sortie_peche_3",
				"sortie_peche_4"
			);
			foreach ($champs as $champ) {
				$appliquer_order_by = true;
				if (in_array($champ, $sortie_des_peches)) {
					$indexe = array_search($champ, $sortie_des_peches);
					$this->db->select(array("(SELECT sortie_de_peche_acheteur.date FROM sortie_de_peche_acheteur WHERE sortie_de_peche_acheteur.fiche_acheteur = fiche_acheteur.id AND sortie_de_peche_acheteur.date = fiche_acheteur.date - $indexe)" => "date_sortie_de_peche" . ($indexe + 1)." "), false);
					$this->db->select(array("(SELECT sortie_de_peche_acheteur.nombre FROM sortie_de_peche_acheteur WHERE sortie_de_peche_acheteur.fiche_acheteur = fiche_acheteur.id AND sortie_de_peche_acheteur.date = fiche_acheteur.date - $indexe)" => "nombre_sortie_de_peche" . ($indexe + 1)." "), false);
					$this->db->select(array("(SELECT sortie_de_peche_acheteur.pirogue FROM sortie_de_peche_acheteur WHERE sortie_de_peche_acheteur.fiche_acheteur = fiche_acheteur.id AND sortie_de_peche_acheteur.date = fiche_acheteur.date - $indexe)" => "nombre_de_pirogue_sortie_de_peche" . ($indexe + 1)." "), false);
					$this->db->select(array("(SELECT engin.nom FROM engin INNER JOIN engin_sortie_de_peche_acheteur ON engin.id = engin_sortie_de_peche_acheteur.engin INNER JOIN sortie_de_peche_acheteur ON sortie_de_peche_acheteur.id = engin_sortie_de_peche_acheteur.sortie_de_peche_acheteur WHERE sortie_de_peche_acheteur.fiche_acheteur = fiche_acheteur.id AND sortie_de_peche_acheteur.date = fiche_acheteur.date - $indexe LIMIT 1)" => "premier_engin" . ($indexe + 1)." "), false);
					$this->db->select(array("(SELECT engin_sortie_de_peche_acheteur.nombre FROM engin_sortie_de_peche_acheteur INNER JOIN sortie_de_peche_acheteur ON sortie_de_peche_acheteur.id = engin_sortie_de_peche_acheteur.sortie_de_peche_acheteur WHERE sortie_de_peche_acheteur.fiche_acheteur = fiche_acheteur.id AND sortie_de_peche_acheteur.date = fiche_acheteur.date - $indexe LIMIT 1)" => "nombre_premier_engin" . ($indexe + 1)." "), false);
					$this->db->select(array("(SELECT engin.nom FROM engin INNER JOIN engin_sortie_de_peche_acheteur ON engin.id = engin_sortie_de_peche_acheteur.engin INNER JOIN sortie_de_peche_acheteur ON sortie_de_peche_acheteur.id = engin_sortie_de_peche_acheteur.sortie_de_peche_acheteur WHERE sortie_de_peche_acheteur.fiche_acheteur = fiche_acheteur.id AND sortie_de_peche_acheteur.date = fiche_acheteur.date - $indexe LIMIT 1 OFFSET 1)" => "deuxieme_engin" . ($indexe + 1)." "), false);
					$this->db->select(array("(SELECT engin_sortie_de_peche_acheteur.nombre FROM engin_sortie_de_peche_acheteur INNER JOIN sortie_de_peche_acheteur ON sortie_de_peche_acheteur.id = engin_sortie_de_peche_acheteur.sortie_de_peche_acheteur WHERE sortie_de_peche_acheteur.fiche_acheteur = fiche_acheteur.id AND sortie_de_peche_acheteur.date = fiche_acheteur.date - $indexe LIMIT 1 OFFSET 1)" => "nombre_deuxieme_engin" . ($indexe + 1)." "), false);
					$appliquer_order_by = false;
				}
				else if (isset($dictionnaire_des_champs[$champ])) $this->db->select(array(strval($champ) => $dictionnaire_des_champs[$champ]));
				else $this->db->select($champ);
				if ($appliquer_order_by) $this->db->order_by($champ);
			}
			
			foreach ($contrainte_dates as $contrainte_date) {
				$this->db->where($contrainte_date);
			}
			
			$this->db->from("fiche_acheteur");
			$this->db->join("fiche", "fiche.id=fiche_acheteur.fiche");
			$this->db->join("village", "village.id=fiche.village");
			$this->db->join("fokontany", "fokontany.id=village.fokontany");
			$this->db->join("commune", "commune.id=fokontany.commune");
			$this->db->join("district", "district.id=commune.district");
			$this->db->join("region", "region.id=district.region");
			$this->db->join("zone_corecrabe", "zone_corecrabe.id=region.zone_corecrabe");
			return $this->db->get()->result_array();
		}
	}
