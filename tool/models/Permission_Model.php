<?php

/**
* Permission_Model.php
* 
* Permission_Model class
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

class Permission_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getActions(){

		$select = $this->Select("SELECT * FROM ".$this->prefix."core_action WHERE type = 'TOOL' ORDER BY controller_name ASC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getActionsByController($controller_name){
		
		$select = $this->Select("SELECT * FROM ".$this->prefix."core_action WHERE controller_name = '".$controller_name."' AND type = 'TOOL'");
        $result = $this->FetchAll($select); 
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getUserPermissionByActionController($action_name,$controller_name,$user_id){
        $controller = strtolower($controller_name);
        $controller = explode("_", $controller);
        $controller = $controller[0];		
		$select = $this->Select("SELECT permission_name FROM ".$this->prefix."core_user_permissions WHERE controller_name = '".$controller."' AND permission_name = '".$action_name."' AND userid = '".$user_id."'");
        $result = $this->FetchObject($select); 
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
    
    public function getGroupPermissionByActionController($action_name,$controller_name,$group_id){
        $controller = strtolower($controller_name);
        $controller = explode("_", $controller);
        $controller = $controller[0];
        $result = $this->FetchObject("SELECT permission_name FROM ".$this->prefix."core_group_permissions WHERE controller_name = '".$controller."' AND permission_name = '".$action_name."' AND group_id = '".$group_id."'");
        return $result;
    }
	
	public function addGroupPermission($arrParams){

		$this->Insert($this->prefix.'core_group_permissions', $arrParams);
		return $this->GetExecuteStatus();
	}
    
    public function deleteGroupPermission($group_id){

		$sql = "DELETE FROM ".$this->prefix."core_user_permissions WHERE GROUP_ID = $group_id";
        $this->Query($sql);
		return $this->GetExecuteStatus();
	}
    
    public function addUserPermission($arrParams){
		
		$this->Insert($this->prefix.'core_user_permissions', $arrParams);
		return $this->GetExecuteStatus();
	}
    
    public function deleteUserPermission($userid){
		
		$sql = "DELETE FROM ".$this->prefix."core_user_permissions WHERE USERID = $userid";
        $this->Query($sql);
		return $this->GetExecuteStatus();
	}
	
    public function addAction($arrParams){

		$params = array(
            'ACTION_NAME' 		=> "'".$arrParams['action_name']."'",
			'CONTROLLER_NAME' 	=> "'".$arrParams['controller_name']."'",
            'TYPE' => "'TOOL'",
		);
		$this->Insert($this->prefix.'core_action', $params);
		return $this->GetExecuteStatus();
	}

    public function deleteAction($id){
		$sql = "DELETE FROM ".$this->prefix."core_action WHERE ACTION_ID = $id";
        $this->Query($sql);
		return $this->GetExecuteStatus();
    }
}