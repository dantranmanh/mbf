<?php

/**
* App_Model.php
* 
* App_Model class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 16/7/2015
* @time 11:48
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

class App_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getDef_sum_report(){
		
		$select = $this->Select("SELECT * FROM def_sum_report");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
}