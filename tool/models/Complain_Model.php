<?php

/**
* Complain_Model.php
* 
* Complain_Model class
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

class Complain_Model extends Core_Model{
    
    public function __construct(){
        
    }
	
	public function geBlacklist(){
		
		$select = $this->Select("SELECT * FROM black_list ORDER BY CREATE_DATE DESC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
	
	public function addToBlacklist($arrParams){

		$arr = array(
            'MSISDN' => "'".$arrParams['msisdn']."'",
			'CREATE_DATE' => "TO_DATE('".date('Y-m-d H:i:s')."','yyyy/mm/dd hh24:mi:ss')",
			'REASON_CODE' => "'".$arrParams['reason_code']."'",
			'DES' => "'".$arrParams['des']."'",
			'STATUS' => 1,
		);
		$this->Insert('black_list', $arr);
		return $this->GetExecuteStatus();
		//$this->DumpQueriesStack(); 
	}
	
    public function delete_blacklist($MSISDN){
		//$sql = "DELETE FROM black_list WHERE MSISDN = '".$MSISDN."'";
		$sql = "UPDATE black_list SET STATUS = '0' WHERE MSISDN = '".$MSISDN."'";
        $this->Query($sql);
		return $this->GetExecuteStatus();
    }
	
	public function exist($checkFor, $value){
	   
		switch ($checkFor) {
			case 'msisdn':
				$where = "MSISDN = '".$value."'";
				break;
			case 'message':
				$where = "MESSAGE = '".$value."'";
				break;
		}
        $select = $this->Select("SELECT COUNT(*) AS count FROM black_list WHERE ".$where);
		$result = $this->FetchObject($select);
        $num = $result->COUNT;
		return ($num == 0) ? false : true;
        
	} 
}