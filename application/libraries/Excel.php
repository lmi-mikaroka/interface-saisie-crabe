<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('PHPExcel.php');
class Excel extends PHPExcel{
    public function __construct() {
        parent::__construct();
    }
}
