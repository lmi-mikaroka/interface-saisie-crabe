<?php
  class Autorisation {
    private $_autorisations = array();
    public function __construct($session){
      $this->_autorisations = $session['autorisations']; 
    }

    public function visualisation_autorise($id_operation) {
      foreach($this->_autorisations as $autorisation) {
        if(intval($autorisation['operation']) === intval($id_operation)) {
          return filter_var($autorisation['visualisation'], FILTER_VALIDATE_BOOLEAN);
        }
      }
    }

    public function modification_autorise($id_operation) {
      foreach($this->_autorisations as $autorisation) {
        if(intval($autorisation['operation']) === intval($id_operation)) {
          return filter_var($autorisation['modification'], FILTER_VALIDATE_BOOLEAN);
        }
      }
    }

    public function creation_autorise($id_operation) {
      foreach($this->_autorisations as $autorisation) {
        if(intval($autorisation['operation']) === intval($id_operation)) {
          return filter_var($autorisation['creation'], FILTER_VALIDATE_BOOLEAN);
        }
      }
    }

    public function suppression_autorise($id_operation) {
      foreach($this->_autorisations as $autorisation) {
        if(intval($autorisation['operation']) === intval($id_operation)) {
          return filter_var($autorisation['suppression'], FILTER_VALIDATE_BOOLEAN);
        }
      }
    }
  }
