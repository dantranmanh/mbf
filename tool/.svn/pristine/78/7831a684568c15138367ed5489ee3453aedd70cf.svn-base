<?php

/**
* Systemparam_Model.php
* 
* Systemparam_Model class
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

class Systemparam_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getErrorCode(){
		
		$select = $this->Select("SELECT * FROM system_param ORDER BY PARAM ASC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getErrorCodeById($PARAM){
        $select = $this->Select("SELECT * FROM system_param WHERE PARAM='".$PARAM."'");
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result;
        }
	}
	
	public function add($arrParams){

		$arr = array(
            'PARAM' => "'".strtoupper($arrParams['param'])."'",
			'VALUE'  => "'".$arrParams['value']."'",
			'DES'  => "'".$arrParams['des']."'",
		);
		$this->Insert('system_param', $arr);
		return $this->GetExecuteStatus();
		//$this->DumpQueriesStack(); 
	}
	
	public function update($PARAM, $arrParams){

		$arr = array(
				'DES'  => "'".$arrParams['des']."'",
				'VALUE'  => "'".$arrParams['value']."'",
		);
		$this->UpdateRow('system_param', $arr, "PARAM='".$PARAM."'");
		return $this->GetExecuteStatus();
	}
    
    public function delete($PARAM){
		$sql = "DELETE FROM system_param WHERE PARAM = '".$PARAM."'";
        $this->Query($sql);
		return $this->GetExecuteStatus();
    }
	
	public function exist($checkFor, $value){
	   
		switch ($checkFor) {
			case 'param':
				$where = "PARAM = '".$value."'";
				break;
			case 'des':
				$where = "DES = '".$value."'";
				break;
		}
        $select = $this->Select("SELECT COUNT(*) AS count FROM system_param WHERE ".$where);
		$result = $this->FetchObject($select);
        $num = $result->COUNT;
		return ($num == 0) ? false : true;
        
	} 
}