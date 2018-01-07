<?php
/**
* Model.php
* 
* Core_Model class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 13/7/2015
* @time 21:43
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

require_once('database'.DS.'oracle.php');

class Core_Model extends ORACLE{
	
    function __construct(){
        parent::__construct();
    }
}