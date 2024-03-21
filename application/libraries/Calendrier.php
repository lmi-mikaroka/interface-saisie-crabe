<?php
	class Calendrier {
		
		public function nombre_de_jours_du_mois($mois, $annee) {
			$mois31 = array(1, 3, 5, 7, 8, 10, 12);
			$mois30 = array(4, 6, 9, 11);
			$jours = 0;
			if(in_array(intval($mois), $mois31)) $jours = 31;
			elseif (in_array(intval($mois), $mois30)) $jours = 30;
			elseif (intval($mois) === 2) {
				if(intval($annee) % 400 === 0 || intval($annee) % 4 === 0 && intval($annee) % 100 !== 0) $jours = 29;
				else $jours = 28;
			}
			return $jours;
		}
	}
