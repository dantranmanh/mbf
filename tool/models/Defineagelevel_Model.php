<?php

/**
* Defineagelevel_Model.php
* 
* Defineagelevel_Model class
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

class Defineagelevel_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getAll(){
		
		$select = $this->Select("SELECT * FROM def_age_level ORDER BY LEVEL_ID ASC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getById($LEVEL_ID){
        $select = $this->Select("SELECT * FROM def_age_level WHERE LEVEL_ID='".$LEVEL_ID."'");
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result;
        }
	}
	
	public function update($LEVEL_ID, $arrParams){

		$arr = array(
				'MIN_EQUAL_DAYS'  => $arrParams['min_equal_days'],
				'MAX_LESS_DAYS'  => $arrParams['max_less_days'],
				'CARD_AMOUNT'  => $arrParams['card_amount'],
				'DES'  => "'".$arrParams['des']."'",
				'BIT_POS'  => $arrParams['bit_pos'],
		);
		$this->UpdateRow('def_age_level', $arr, "LEVEL_ID='".$LEVEL_ID."'");
		return $this->GetExecuteStatus();
	}
}