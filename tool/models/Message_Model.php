<?php

/**
* Message_Model.php
* 
* Message_Model class
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

class Message_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getMessage(){
		
		$select = $this->Select("SELECT * FROM def_message ORDER BY MESSAGE_CODE ASC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getMessageById($MESSAGE_CODE){
        $select = $this->Select("SELECT * FROM def_message WHERE MESSAGE_CODE='".$MESSAGE_CODE."'");
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result;
        }
	}
	
	public function add($arrParams){
		
		$converted =  iconv("UTF-8//IGNORE", "WINDOWS-1258//IGNORE", $arrParams['message']);
		$converted =  iconv("WINDOWS-1258//IGNORE", "UTF-8//IGNORE", $converted);
		
		$arr = array(
            'MESSAGE_CODE' => "'".strtoupper($arrParams['message_code'])."'",
			'MESSAGE'  => "'".$converted."'",
		);
		$this->Insert('def_message', $arr);
		return $this->GetExecuteStatus();
		//$this->DumpQueriesStack(); 
	}
	
	public function update($MESSAGE_CODE, $arrParams){

		$arr = array(
				'MESSAGE' => "'".$arrParams['message']."'",
		);
		$this->UpdateRow('def_message', $arr, "MESSAGE_CODE='".$MESSAGE_CODE."'");
		return $this->GetExecuteStatus();
	}
    
    public function delete($MESSAGE_CODE){
		$sql = "DELETE FROM def_message WHERE MESSAGE_CODE = '".$MESSAGE_CODE."'";
        $this->Query($sql);
		return $this->GetExecuteStatus();
    }
	
	public function exist($checkFor, $value){
	   
		switch ($checkFor) {
			case 'message_code':
				$where = "MESSAGE_CODE = '".$value."'";
				break;
			case 'message':
				$where = "MESSAGE = '".$value."'";
				break;
		}
        $select = $this->Select("SELECT COUNT(*) AS count FROM def_message WHERE ".$where);
		$result = $this->FetchObject($select);
        $num = $result->COUNT;
		return ($num == 0) ? false : true;
        
	} 
}