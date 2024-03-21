<?php
if (!function_exists('route_active')) {
	/* *
		 * Helper qui se chargera d'ajouter la classe d'activation des liens
		 * Le critere d'activation peut s'appliquer une liste de lien pour les liens groupés
		 * ou aussi pour un simple lien
		 * le nom de la classe d'activation par défaut est 'active'
		 * */
	function route_active($routes, $url, $class_active = 'active'): string {
		$active = '';
		if (is_string($routes)) {
			$active = ($url == $routes ? $class_active : '');
		} elseif (is_array($routes)) {
			foreach ($routes as $route) {
				if ($url == $route) $active = $class_active;
			}
		}
		return $active;
	}
}
