<?php

/**
* Group_Model.php
* 
* Group_Model class
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

class Group_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getGroups(){
		
		$select = $this->Select("SELECT * FROM ".$this->prefix."core_usergroups");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getGroupById($id){
        $select = $this->Select("SELECT * FROM ".$this->prefix."core_usergroups WHERE group_id=".$id);
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result;
        }
	}
	
	public function toggleStatus($id){
		$sql = 'UPDATE '.$this->prefix.'core_usergroups SET IS_ACTIVE = 1 - IS_ACTIVE WHERE GROUP_ID = '.$id;
		$this->Query($sql);
		return $this->GetExecuteStatus();
	}
	
	public function add($group_name){

		$arr = array(
            'GROUP_NAME' => "'".$group_name."'",
			'IS_ACTIVE'  => 1,
		);
		//print_r($arr);
		$this->Insert($this->prefix.'core_usergroups', $arr);
		return $this->GetExecuteStatus();
		//$this->DumpQueriesStack(); 
	}
	
	public function update($id, $arrParams){
		$sql = "UPDATE ".$this->prefix."core_usergroups SET GROUP_NAME = '".$arrParams['group_name']."' WHERE GROUP_ID = $id";
		$this->Query($sql);
		return $this->GetExecuteStatus();
	}
    
    public function delete($id){
		$sql = "DELETE FROM ".$this->prefix."core_usergroups WHERE GROUP_ID = $id";
        $this->Query($sql);
		return $this->GetExecuteStatus();
    }
}