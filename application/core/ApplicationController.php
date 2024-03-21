<?php
require_once 'CorecrabeController.php';

class ApplicationController extends CorecrabeController {
	public function __construct() {
		parent::__construct();

		// styles et scripts personnalises
		$this->root_states['body_classes'] = array(
			'sidebar-mini',
			'layout-fixed',
			'layout-navbar-fixed',
		);
		$this->root_states['default_stylesheets'] = array_merge($this->root_states['default_stylesheets'], array(
			'OverlayScrollbars.min.css',
			'responsive.bootstrap4.min.css',
			'dataTables.bootstrap4.min.css',
			'buttons.bootstrap4.min.css',
			'select2.min.css',
			'select2-bootstrap4.min.css',
			'icheck-bootstrap.min.css',
			'jquery-confirm.min.css',
			'fixedColumns.dataTables.min.css'
		));
		$this->root_states['default_javascripts'] = array_merge($this->root_states['default_javascripts'], array(
			'jquery.dataTables.min.js',
			'dataTables.bootstrap4.min.js',
			'dataTables.responsive.min.js',
			'responsive.bootstrap4.min.js',
			'dataTables.buttons.min.js',
			'buttons.bootstrap4.min.js',
			'buttons.html5.min.js',
			'buttons.print.min.js',
			'buttons.colVis.min.js',
			'jquery.overlayScrollbars.min.js',
			'select2.full.min.js',
			'jquery-confirm.min.js',
			'JConfirmExtension.js',
			'dataTables.fixedColumns.min.js'
		));
		if (empty($this->session->userdata('token'))) {
			redirect(site_url('connexion'));
		} else {
			$this->load->library('autorisation', $this->session->userdata('groupe'), 'lib_autorisation');
		}
	}
}
