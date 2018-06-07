<?php

/**
* Blacklistreason_Model.php
* 
* Blacklistreason_Model class
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

class Searchsmscreditsent_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getSearchsmscreditsent(){
		
		$select = $this->Select("SELECT * FROM sms_report ORDER BY REQUEST_ID ASC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getSearchsmscreditsentById($REQUEST_ID){
        $select = $this->Select("SELECT * FROM sms_report WHERE REQUEST_ID='".$REQUEST_ID."'");
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result;
        }
	}

}