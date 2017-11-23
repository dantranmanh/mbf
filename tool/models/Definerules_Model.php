<?php

/**
* Definerules_Model.php
* 
* Definerules_Model class
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

class Definerules_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getAll(){
		
		$select = $this->Select("SELECT * FROM def_rules ORDER BY RULE_ID ASC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getById($RULE_ID){
        $select = $this->Select("SELECT * FROM def_rules WHERE RULE_ID='".$RULE_ID."'");
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result;
        }
	}
	
	public function update($RULE_ID, $arrParams){

		$arr = array(
				'RULE_NAME'  => "'".$arrParams['rule_name']."'",
				'BLOCK_POS'  => $arrParams['block_pos'],
				'BREAK_LEVEL_TABLE'  => "'".$arrParams['break_level_table']."'",
				'SUBS_BIT_POS_TABLE'  => "'".$arrParams['subs_bit_pos_table']."'",
				'STATUS'  => $arrParams['status'],
				'PARTITON_TIME_TYPE'  => "'".$arrParams['partiton_time_type']."'",
		);
		$this->UpdateRow('def_rules', $arr, "RULE_ID='".$RULE_ID."'");
		return $this->GetExecuteStatus();
	}
}