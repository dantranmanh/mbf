<?php

/**
* Controlsystem_Model.php
* 
* Controlsystem_Model class
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

class Controlsystem_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getAll(){
		
		$select = $this->Select("SELECT * FROM EVENT_TRIGGER ORDER BY EVENT_TIME + 1 DESC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
	
	public function getAllEvents(){
		
		$select = $this->Select("SELECT * FROM DEF_EVENTS ORDER BY EVENT_CODE ASC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
	
	public function add($arr){

		$this->Insert('EVENT_TRIGGER', $arr);
		//$this->DumpQueriesStack(); 
		return $this->GetExecuteStatus();
		
	}
}