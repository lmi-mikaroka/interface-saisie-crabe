<?php

	

	class FicheEnqueteurModel extends CI_Model {

		

		public function __construct() {

			parent::__construct();

		}

		

		public function inerer_fiche_enqueteur($fiche_enqueteur) {

			return $this->db->set($fiche_enqueteur)->insert('fiche_enqueteur');

		}

		public function lastFicheEnq($ficheEnq){
			return intval($this->db->select('id')->from('fiche_enqueteur')->where($ficheEnq)->limit(1)->get()->result_array()[0]['id']);
		}

		

		public function dernier_id() {

			return intval($this->db->select('id')->from('fiche_enqueteur')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}

		

		public function sortie_de_peche_dernier_id() {

			return intval($this->db->select(['id'])->from('sortie_de_peche_enqueteur')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id']);

		}

		

		private function constructeur_de_requete($contrainte) {

			$this->db->query('SET lc_time = \'fr_FR.UTF_8\'');

			$orderable_columns = array(null, 'fiche_enqueteur.date', 'pecheur.nom');

			$code_fiche = "CONCAT(zone_corecrabe.id, '/', village.nom, '/', fiche.village, '/', fiche_type, '/', annee::varchar, '/', mois::varchar, '/', LPAD(numero_ordre::varchar, 3, '0')";

			$date_literalle = "TO_CHAR(fiche_enqueteur.date,'DD TMMonth YYYY')";

			$this->db->select(array(

				'fiche_enqueteur.id',

				$code_fiche => 'saisie-fiche',

				'fiche_enqueteur.date' => 'date_bd',

				'pecheur.nom' => 'pecheur',

				'participant_individu',

				'participant_nombre',

			))->select(array($date_literalle => 'date_literalle'), false)

				->from('fiche_enqueteur')

				->join('pecheur', 'fiche_enqueteur.pecheur=pecheur.id', 'inner')

				->join('fiche', 'fiche_enqueteur.fiche=fiche.id', 'inner')

				->join('village', 'fiche.village=village.id', 'inner')

				->join('fokontany', 'village.fokontany=fokontany.id', 'inner')

				->join('commune', 'fokontany.commune=commune.id', 'inner')

				->join('district', 'commune.district=district.id', 'inner')

				->join('region', 'district.region=region.id', 'inner')

				->join('zone_corecrabe', 'region.zone_corecrabe=zone_corecrabe.id', 'inner');

			if (isset($contrainte['search']['value']) && !empty($contrainte['search']['value'])) {

				$this->db->ilike($date_literalle, $contrainte['search']['value'])

					->or_ilike($code_fiche, $contrainte['search']['value'], false)

					->or_ilike('pecheur.nom', $contrainte['search']['value'], false);

			}

			$order_active = isset($contrainte['order']) && !empty($contrainte['order']);

			if ($order_active) return $this->db->order_by($orderable_columns[$contrainte['order']['0']['column']], $contrainte['order']['0']['dir']);

			else return $this->db->order_by($orderable_columns[0], 'asc');

		}

		

		public function datatable($constraint) {

			$request_builder = $this->constructeur_de_requete($constraint);

			if ($constraint['length'] != null && $constraint['length'] != -1) $this->db->limit($constraint['length'], $constraint['start']);

			return $request_builder->get()->result_array();

		}

		

		public function records_total() {

			return $this->db->from('fiche_enqueteur')->count_all_results();

		}

		

		public function records_filtered($contrainte) {

			$requete = $this->constructeur_de_requete($contrainte);

			return $requete->get()->num_rows();

		}

		

		public function selection_par_fiche($fiche) {

			$date_literalle = "TO_CHAR(fiche_enqueteur.date,'DD TMMonth YYYY')";

			$this->db->select(array($date_literalle => 'date_literalle'), false);

			$this->db->select(array(

				'fiche_enqueteur.id',

				'date' => 'date_bd',

				'participant_individu',

				'participant_nombre',

				'capture_poids',

				'crabe_consomme_poids',

				'crabe_consomme_nombre',

				'collecte_poids1',

				'collecte_poids2',

				'marche_local_poids',

				'collecte_prix1',

				'collecte_prix2',

				'marche_local_prix',

				'fiche',

				"nombre_sortie_capture",

				'pecheur.nom' => "pecheur_nom"

			))->from('fiche_enqueteur');

			$this->db->join('pecheur', 'pecheur=pecheur.id', 'inner');

			$this->db->order_by('fiche_enqueteur.id');

			$this->db->where('fiche', intval($fiche));

			return $this->db->get()->result_array();

		}

		

		public function selection_par_id($id) {

			$date_literalle = "TO_CHAR(fiche_enqueteur.date,'DD TMMonth YYYY')";

			$this->db->select(array($date_literalle => 'date_literalle'), false);

			return $this->db->select(array(

				'fiche_enqueteur.id',

				'date' => 'date_originale',

				'participant_individu',

				'participant_nombre',

				'capture_poids',

				'crabe_consomme_poids',

				'crabe_consomme_nombre',

				'collecte_poids1',

				'collecte_poids2',

				'marche_local_poids',

				'collecte_prix1',

				'collecte_prix2',

				'marche_local_prix',

				'fiche',

				'pecheur',

				"nombre_sortie_capture"

			))->from('fiche_enqueteur')->where('id', intval($id))->get()->result_array()[0];

		}

		

		public function selection_sortie_de_peche_par_fiche_enqueteur($fiche_enqueteur) {

			$this->db->select(array(

				"id",

				"date" => "date_originale",

				"nombre",

				"pirogue"

			));

			$this->db->select(array(

				"TO_CHAR(date,'DD/MM/YYYY')" => "date_literalle"

			));

			return $this->db->from('sortie_de_peche_enqueteur')->order_by('id')->where('fiche_enqueteur', intval($fiche_enqueteur))->get()->result_array();

		}

		

		public function inserer_sortie_de_peche($sortie_de_peche) {

			return $this->db->set($sortie_de_peche)->insert('sortie_de_peche_enqueteur');

		}

		public function lastSortie($sortie){
			return intval($this->db->select('id')->from('sortie_de_peche_enqueteur')->where($sortie)->limit(1)->get()->result_array()[0]['id']);
		}

		

		public function enquete_totale_par_fiche($fiche) {

			return $this->db->select('id')->from('fiche_enqueteur')->where('fiche', intval($fiche))->get()->num_rows();

		}

		

		public function mettre_a_jour($fiche_enqueteur, $id) {

			return $this->db->set($fiche_enqueteur)->where('id', intval($id))->update('fiche_enqueteur');

		}

		

		public function selection_id_sortie_de_peche_par_enquete_et_date($fiche_enqueteur, $date) {

			return intval($this->db->select('id')->from('sortie_de_peche_enqueteur')->where(array('fiche_enqueteur' => intval($fiche_enqueteur), 'date' => $date))->get()->result_array()[0]['id']);

		}

		

		public function supprimer($fiche_enqueteur) {

			return $this->db->where('id', $fiche_enqueteur)->delete('fiche_enqueteur');

		}

		

		public function inserer($fiche_enqueteur) {

			return $this->db->set($fiche_enqueteur)->insert('fiche_enqueteur');

		}

		

		public function dernier_id_sortie_de_peche() {

			return $this->db->select('id')->from('sortie_de_peche_enqueteur')->order_by('id', 'desc')->limit(1)->get()->result_array()[0]['id'];

		}

		

		public function supprimer_sortie_de_peche_par_enquete($fiche_enqueteur) {

			return $this->db->where('fiche_enqueteur', intval($fiche_enqueteur))->delete('sortie_de_peche_enqueteur');

		}

		

		public function selection_jour_par_fiche($fiche) {

			$this->db->select('id');

			$this->db->select(array('extract(day from date)::integer' => 'jour'), false);

			$this->db->from('fiche_enqueteur');

			$this->db->where('fiche', intval($fiche));

			return $this->db->get()->result_array();

		}

		

		public function generation_csv($champs, $dictionnaire_des_champs, $contrainte_date) {

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

					$this->db->select(array("(SELECT sortie_de_peche_enqueteur.date FROM sortie_de_peche_enqueteur WHERE sortie_de_peche_enqueteur.fiche_enqueteur = fiche_enqueteur.id AND sortie_de_peche_enqueteur.date = fiche_enqueteur.date - $indexe)" => "date_sortie_de_peche" . ($indexe + 1)." "), false);

					$this->db->select(array("(SELECT sortie_de_peche_enqueteur.nombre FROM sortie_de_peche_enqueteur WHERE sortie_de_peche_enqueteur.fiche_enqueteur = fiche_enqueteur.id AND sortie_de_peche_enqueteur.date = fiche_enqueteur.date - $indexe)" => "nombre_sortie_de_peche" . ($indexe + 1)." "), false);

					$this->db->select(array("(SELECT sortie_de_peche_enqueteur.pirogue FROM sortie_de_peche_enqueteur WHERE sortie_de_peche_enqueteur.fiche_enqueteur = fiche_enqueteur.id AND sortie_de_peche_enqueteur.date = fiche_enqueteur.date - $indexe)" => "nombre_de_pirogue_sortie_de_peche" . ($indexe + 1)." "), false);

					$this->db->select(array("(SELECT engin.nom FROM engin INNER JOIN engin_sortie_de_peche_enqueteur ON engin.id = engin_sortie_de_peche_enqueteur.engin INNER JOIN sortie_de_peche_enqueteur ON sortie_de_peche_enqueteur.id = engin_sortie_de_peche_enqueteur.sortie_de_peche_enqueteur WHERE sortie_de_peche_enqueteur.fiche_enqueteur = fiche_enqueteur.id AND sortie_de_peche_enqueteur.date = fiche_enqueteur.date - $indexe LIMIT 1)" => "premier_engin" . ($indexe + 1)." "), false);

					$this->db->select(array("(SELECT engin_sortie_de_peche_enqueteur.nombre FROM engin_sortie_de_peche_enqueteur INNER JOIN sortie_de_peche_enqueteur ON sortie_de_peche_enqueteur.id = engin_sortie_de_peche_enqueteur.sortie_de_peche_enqueteur WHERE sortie_de_peche_enqueteur.fiche_enqueteur = fiche_enqueteur.id AND sortie_de_peche_enqueteur.date = fiche_enqueteur.date - $indexe LIMIT 1)" => "nombre_premier_engin" . ($indexe + 1)." "), false);

					$this->db->select(array("(SELECT engin.nom FROM engin INNER JOIN engin_sortie_de_peche_enqueteur ON engin.id = engin_sortie_de_peche_enqueteur.engin INNER JOIN sortie_de_peche_enqueteur ON sortie_de_peche_enqueteur.id = engin_sortie_de_peche_enqueteur.sortie_de_peche_enqueteur WHERE sortie_de_peche_enqueteur.fiche_enqueteur = fiche_enqueteur.id AND sortie_de_peche_enqueteur.date = fiche_enqueteur.date - $indexe LIMIT 1 OFFSET 1)" => "deuxieme_engin" . ($indexe + 1)." "), false);

					$this->db->select(array("(SELECT engin_sortie_de_peche_enqueteur.nombre FROM engin_sortie_de_peche_enqueteur INNER JOIN sortie_de_peche_enqueteur ON sortie_de_peche_enqueteur.id = engin_sortie_de_peche_enqueteur.sortie_de_peche_enqueteur WHERE sortie_de_peche_enqueteur.fiche_enqueteur = fiche_enqueteur.id AND sortie_de_peche_enqueteur.date = fiche_enqueteur.date - $indexe LIMIT 1 OFFSET 1)" => "nombre_deuxieme_engin" . ($indexe + 1)." "), false);

					$appliquer_order_by = false;

				}

				else if ($champ === "echantillon.trie") $this->db->select(array("case when echantillon.trie then 'true' else 'false' end" => "echantillon_trie"), false);

				else if (isset($dictionnaire_des_champs[$champ])) $this->db->select(array(strval($champ) => $dictionnaire_des_champs[$champ]));

				else $this->db->select($champ);

				if ($appliquer_order_by) $this->db->order_by($champ);

			}

			foreach ($contrainte_date as $contrainte) {

				$this->db->where($contrainte);

			}

			

			$attribut_echantillons = array(

				"echantillon.trie",

				"echantillon.taille_absente",

				"echantillon.taille_absente_autre",
				
				"echantillon.poids"

			);

			$ajouter_echantillon = false;

			foreach ($attribut_echantillons as $attribut_echantillon) {

				if (in_array($attribut_echantillon, $champs)) {

					$ajouter_echantillon = true;

				}

			}

			if ($ajouter_echantillon) $this->db->join('echantillon', 'echantillon.fiche_enqueteur=fiche_enqueteur.id');

			

			$attribut_crabes = array(

				"crabe.destination",

				"crabe.sexe",

				"crabe.taille"

			);

			$ajouter_crabe = false;

			foreach ($attribut_crabes as $attribut_crabe) {

				if (in_array($attribut_crabe, $champs)) {

					$ajouter_crabe = true;

				}

			}

			if ($ajouter_crabe && $ajouter_echantillon) $this->db->join('crabe', 'crabe.echantillon=echantillon.id');

			else if ($ajouter_crabe && !$ajouter_echantillon) {

				$this->db->join('echantillon', 'echantillon.fiche_enqueteur=fiche_enqueteur.id');

				$this->db->join('crabe', 'crabe.echantillon=echantillon.id');

			}

			

			$this->db->from("fiche_enqueteur");

			$this->db->join("fiche", "fiche.id=fiche_enqueteur.fiche");

			$this->db->join("village", "village.id=fiche.village");

			$this->db->join("fokontany", "fokontany.id=village.fokontany");

			$this->db->join("commune", "commune.id=fokontany.commune");

			$this->db->join("district", "district.id=commune.district");

			$this->db->join("region", "region.id=district.region");

			$this->db->join("zone_corecrabe", "zone_corecrabe.id=region.zone_corecrabe");

			return $this->db->get()->result_array();

		}


		public function generation_csv1($champs, $conversion_champ_fiche_enqueteur, $contrainte_date){
			
			$query = "SELECT zone_corecrabe.nom as Zone,region.nom as region,district.nom as Dictrict,commune.nom as commune,fokontany.nom as fokontany,village.nom as village,
			fiche.date_expedition,
			fiche_enqueteur.participant_individu as type_participant, fiche_enqueteur.participant_nombre as nombre_participant, fiche_enqueteur.capture_poids as poids_crabe_capture,
			fiche_enqueteur.crabe_consomme_poids as poids_de_crabes_consommes, fiche_enqueteur.crabe_consomme_nombre as nombre_de_crabes_consommes,fiche_enqueteur.collecte_poids1 as poids_destination_collecte_1,
			fiche_enqueteur.collecte_prix1 as prix_destination_collecte_1, fiche_enqueteur.collecte_poids2 as poids_destination_collecte_2, fiche_enqueteur.collecte_prix2 as prix_destination_collecte_2,
			fiche_enqueteur.marche_local_poids as poids_destination_marche_local, fiche_enqueteur.marche_local_prix as prix_destination_marche_local, fiche_enqueteur.nombre_sortie_capture as nombre_de_sortie
			FROM fiche_enqueteur
			JOIN fiche ON(fiche.id=fiche_enqueteur.fiche)
			JOIN village ON(village.id=fiche.village)
			JOIN fokontany ON(fokontany.id=village.fokontany)
			JOIN commune ON(commune.id=fokontany.commune)
			JOIN district ON(district.id=commune.district)
			JOIN region ON(region.id=district.region)
			JOIN zone_corecrabe ON(zone_corecrabe.id=region.zone_corecrabe)";
			
		}

		public function total_enquete_par_fiche($id_fiche) {

			return $this->db->select('id')->from('fiche_enqueteur')->where('fiche', $id_fiche)->get()->num_rows();

		}

	}
