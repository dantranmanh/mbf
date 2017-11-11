<?php

/**
* Errorcode_Model.php
* 
* Errorcode_Model class
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

class Errorcode_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getErrorCode(){
		
		$select = $this->Select("SELECT * FROM def_error_code ORDER BY ERROR_CODE ASC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getErrorCodeById($ERROR_CODE){
        $select = $this->Select("SELECT * FROM def_error_code WHERE ERROR_CODE='".$ERROR_CODE."'");
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result;
        }
	}
	
	public function add($arrParams){

		$arr = array(
            'ERROR_CODE' => "'".strtoupper($arrParams['error_code'])."'",
			'ERROR_DES'  => "'".$arrParams['error_des']."'",
			'MESSAGE'  => "'".$arrParams['message']."'",
			'SYSTEM'  => "'".strtoupper($arrParams['system'])."'",
			'FUNCTION'  => "'".strtoupper($arrParams['_function'])."'",
		);
		$this->Insert('def_error_code', $arr);
		return $this->GetExecuteStatus();
		//$this->DumpQueriesStack(); 
	}
	
	public function update($ERROR_CODE, $arrParams){

		$arr = array(
				'ERROR_DES'  => "'".$arrParams['error_des']."'",
				'MESSAGE'  => "'".$arrParams['message']."'",
				'SYSTEM'  => "'".strtoupper($arrParams['system'])."'",
				'FUNCTION'  => "'".strtoupper($arrParams['_function'])."'",
		);
		$this->UpdateRow('def_error_code', $arr, "ERROR_CODE='".$ERROR_CODE."'");
		return $this->GetExecuteStatus();
	}
    
    public function delete($ERROR_CODE){
		$sql = "DELETE FROM def_error_code WHERE ERROR_CODE = '".$ERROR_CODE."'";
        $this->Query($sql);
		return $this->GetExecuteStatus();
    }
	
	public function exist($checkFor, $value){
	   
		switch ($checkFor) {
			case 'error_code':
				$where = "ERROR_CODE = '".$value."'";
				break;
			case 'message':
				$where = "MESSAGE = '".$value."'";
				break;
		}
        $select = $this->Select("SELECT COUNT(*) AS count FROM def_error_code WHERE ".$where);
		$result = $this->FetchObject($select);
        $num = $result->COUNT;
		return ($num == 0) ? false : true;
        
	} 
}