<?php

/**
* Impactlogs_Model.php
* 
* Impactlogs_Model class
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

class Impactlogs_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getAll(){
		
		$select = $this->Select("SELECT * FROM idvn_impact_logs ORDER BY LOG_ID DESC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getById($LOG_ID){
        $select = $this->Select("SELECT * FROM idvn_impact_logs WHERE LOG_ID='".$LOG_ID."'");
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result;
        }
	}
	
	public function find($exp = null){
        
        $where = null;        
		if (isset($exp['user_id'])){
			$where = $where."AND user_id = '".$exp['user_id']."' ";
		}

		//$where = $where."AND TO_DATE(create_date) >= '" . $exp['f_date'] . "' AND TO_DATE(create_date) <= '" . $exp['t_date'] . "'";
        
		$select = $this->query("SELECT * FROM idvn_impact_logs WHERE 1=1 ".$where." ORDER BY LOG_ID DESC");
        $result = $this->FetchAll($select);
		//$this->DumpQueriesStack(); 
		if($this->NumRows($select) > 0){
            return $result;
        }
	}
	
	public function add($arrParams){

		$arr = array(
            'USER_ID' => $arrParams['USER_ID'],
			'USERNAME' => "'".$arrParams['USERNAME']."'",
			'LOCATION' => "'".$arrParams['LOCATION']."'",
			'CREATE_DATE' => "TO_DATE('".date('Y-m-d H:i:s')."','yyyy/mm/dd hh24:mi:ss')",
			'DESCRIPTIONS' => "'".$arrParams['DESCRIPTIONS']."'",
			'IP' => "'".Core_Utility::getIp()."'",
		);
		$this->Insert('idvn_impact_logs', $arr);
		return $this->GetExecuteStatus();
		//$this->DumpQueriesStack(); 
	}
}