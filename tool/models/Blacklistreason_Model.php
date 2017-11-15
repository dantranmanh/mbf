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

class Blacklistreason_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getBlacklistReason(){
		
		$select = $this->Select("SELECT * FROM def_black_list_reason ORDER BY REASON_CODE ASC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getBlacklistReasonById($REASON_CODE){
        $select = $this->Select("SELECT * FROM def_black_list_reason WHERE REASON_CODE='".$REASON_CODE."'");
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result;
        }
	}
	
	public function add($arrParams){

		$arr = array(
            'REASON_CODE' => "'".strtoupper($arrParams['reason_code'])."'",
			'REASON_NAME' => "'".$arrParams['reason_name']."'",
			'CREATE_DATE' => "TO_DATE('".date('Y-m-d H:i:s')."','yyyy/mm/dd hh24:mi:ss')",
		);
		$this->Insert('def_black_list_reason', $arr);
		return $this->GetExecuteStatus();
		//$this->DumpQueriesStack(); 
	}
	
	public function update($REASON_CODE, $arrParams){

		$arr = array(
				'REASON_NAME'  => "'".$arrParams['reason_name']."'",
		);
		$this->UpdateRow('def_black_list_reason', $arr, "REASON_CODE='".$REASON_CODE."'");
		return $this->GetExecuteStatus();
	}
    
    public function delete($REASON_CODE){
		$sql = "DELETE FROM def_black_list_reason WHERE REASON_CODE = '".$REASON_CODE."'";
        $this->Query($sql);
		return $this->GetExecuteStatus();
    }
	
	public function exist($checkFor, $value){
	   
		switch ($checkFor) {
			case 'reason_code':
				$where = "REASON_CODE = '".$value."'";
				break;
			case 'reason_name':
				$where = "REASON_NAME = '".$value."'";
				break;
		}
        $select = $this->Select("SELECT COUNT(*) AS count FROM def_black_list_reason WHERE ".$where);
		$result = $this->FetchObject($select);
        $num = $result->COUNT;
		return ($num == 0) ? false : true;
        
	} 
}