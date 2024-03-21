<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	if (!function_exists('css_url')) {
		function css_url($fichier) {
			return base_url('assets/css/' . $fichier);
		}
	}
	
	if (!function_exists('js_url')) {
		function js_url($fichier) {
			return base_url('assets/js/' . $fichier);
		}
	}
	
	if (!function_exists('img_url')) {
		function img_url($fichier) {
			return base_url('assets/img/' . $fichier);
		}
	}
	
	if (!function_exists('charger_css')) {
		function charger_css($styles = array()) {
			$texte_formatee = '';
			// pour chaque tour boucle vérifie si le style est distant ou en local (contient un dossier parent)
			foreach ($styles as $style) {
				$fichier_distant = preg_match('#^((http|https)://){1}|(//){1}#', $style);
				$texte_formatee .= '<link rel="stylesheet" href="' . ($fichier_distant ? $style : css_url($style)) . '" />';
			}
			return $texte_formatee;
		}
	}
	
	if (!function_exists('charger_js')) {
		function charger_js($scripts = array()) {
			$texte_formatee = '';
			// pour chaque tour boucle vérifie si le style est distant ou en local (contient un dossier parent)
			foreach ($scripts as $script) {
				$fichier_distant = preg_match('#^((http|https)://){1}|(//){1}#', $script);
				$texte_formatee .= '<script type="text/javascript" src="' . ($fichier_distant ? $script : js_url($script)) . '"></script>';
			}
			return $texte_formatee;
		}
	}
	
	if (!function_exists('charger_classes')) {
		function charger_classes($nom_de_classes = array()) {
			$texte_formatee = 'class="';
			// pour chaque tour boucle vérifie si le style est distant ou en local (contient un dossier parent)
			foreach ($nom_de_classes as $nom_de_classe) $texte_formatee .= $nom_de_classe . ' ';
			return substr($texte_formatee, 0, strlen($texte_formatee) - 1).'"';
		}
	}
