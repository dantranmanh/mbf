<?php

/**
* User_Model.php
* 
* User_Model class
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

class User_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getUsers($start, $count){
        $select = $this->Select("SELECT * FROM ".$this->prefix.'core_user LIMIT '.$start.', '.$count);
        $result = $this->FetchObject($select); 
		if($this->NumRows($select) > 0){
            return $result;
        }
    }

    public function getUsersPartners(){
        $result = $this->query("SELECT user_id, full_name FROM ".$this->prefix.'core_user WHERE type = "REPORT" ORDER BY full_name ASC');
        if($this->numRows() > 0){
            return $result;
        }
    }
    
    public function getUserById($id){
		
		$select = $this->Select("SELECT * FROM ".$this->prefix."core_user WHERE user_id=".$id);
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result;
        }
	}
	
	public function toggleStatus($id){
		$sql = 'UPDATE '.$this->prefix.'core_user SET IS_ACTIVE = 1 - IS_ACTIVE WHERE USER_ID = '.$id;
		$this->Query($sql);
		return $this->GetExecuteStatus();
	}
	
	public function add($arrParams){
		$params = array(
			'USER_NAME' 		=> "'".$arrParams['user_name']."'",
			'PASSWORD' 			=> "'".md5($arrParams['password'])."'",
			'FULL_NAME' 		=> "'".$arrParams['full_name']."'",
			'EMAIL' 			=> "'".$arrParams['email']."'",
			'IS_ACTIVE' 		=> 0,
			'CREATED_DATE' 		=> "TO_DATE('".date('Y-m-d H:i:s')."','yyyy/mm/dd hh24:mi:ss')",
			'LOGGED_IN_DATE' 	=> "TO_DATE('".date('Y-m-d H:i:s')."','yyyy/mm/dd hh24:mi:ss')",
			'IS_ONLINE' 		=> 0,
			'GROUP_ID' 			=> "'".$arrParams['group_id']."'",
            'CREATED_USER_ID'   => "'".Core_Login::getUserId()."'",
            'TYPE'              => "'TOOL'");
		//echo "<pre>";
		//print_r($params);
		$this->Insert($this->prefix.'core_user', $params);
		return $this->GetExecuteStatus();
	}
	
	public function edit($id, $arrParams){
		
		if($arrParams['group_id'] == '' && $arrParams['group_id'] == null){
			$group_id = 2;
		}else{
			$group_id = $arrParams['group_id'];
		}
		
		$data = array(
			//'USER_NAME' => "'".$arrParams['user_name']."'",
			'FULL_NAME' => "'".$arrParams['full_name']."'",
			'EMAIL' 	=> "'".$arrParams['email']."'",
			'GROUP_ID' 	=> "'".$group_id."'",
            'TYPE'      => "'TOOL'"
		);
		
		if (null != $arrParams['password'] && $arrParams['password'] != ''){
			$data['PASSWORD'] = "'".md5($arrParams['password'])."'";
		} 
		//print_r($data);exit;
		$this->UpdateRow($this->prefix.'core_user', $data, "USER_ID=$id");
		//$this->DumpQueriesStack(); exit;
		return $this->GetExecuteStatus();
	}
	
	public function updatePassword($id, $arrParams){
		return $this->UpdateRow($this->prefix.'core_user', array(
										'PASSWORD' => md5($arrParams['password']),
									), "USER_ID=$id");
	}
	
	public function find($start, $count, $exp = null){
        
		
        $where = null;        
		if (isset($exp['username'])){
			$where = $where."AND user_name = '".$exp['username']."' ";
		}
        if (isset($exp['type'])){
            $where = $where."AND type = '".$exp['type']."' ";
        }
		if (isset($exp['email'])) {
			$where = $where."AND email = '".$exp['email']."' ";
		}
		if (isset($exp['created_user_id']) && $exp['created_user_id'] != '') {
			$where = $where."AND created_user_id = '".$exp['created_user_id']."' ";
		}
		if (isset($exp['status']) && ($exp['status'] == '0' || $exp['status'] == 1)) {
			$where = $where."AND is_active = '".$exp['status']."' ";
		}
        if(isset($exp['keyword'])) {
			$where = $where."AND user_name LIKE '%".addslashes($exp['keyword'])."%' ";
		}

        if(isset($exp['full_name'])) {
            $where = $where."AND full_name LIKE '%".addslashes($exp['full_name'])."%' ";
        }
        
		$select = $this->Select("SELECT * FROM ".$this->prefix."core_user WHERE 1=1 ".$where." ORDER BY user_id DESC");
		
		$result = $this->FetchAll($select);
		if($this->NumRows($select) > 0){
            return $result;
        }
	}
	
	public function count($exp = null){
	    
        $where = null;        
		if (isset($exp['username'])){
			$where = $where."AND user_name = '".$exp['username']."' ";
		}
        if (isset($exp['type'])){
            $where = $where."AND type = '".$exp['type']."' ";
        }
		if (isset($exp['email'])) {
			$where = $where."AND email = '".$exp['email']."' ";
		}
		if (isset($exp['created_user_id']) && $exp['created_user_id'] != '') {
			$where = $where."AND created_user_id = '".$exp['created_user_id']."' ";
		}
		if (isset($exp['status']) && ($exp['status'] == '0' || $exp['status'] == 1)) {
			$where = $where."AND is_active = '".$exp['status']."' ";
		}
        if(isset($exp['keyword'])) {
			$where = $where."AND user_name LIKE %'".addslashes($exp['keyword'])."'% ";
		}
        if(isset($exp['full_name'])) {
            $where = $where."AND full_name LIKE '%".addslashes($exp['full_name'])."%' ";
        }
        
		$select = $this->Select("SELECT COUNT(*) AS count FROM ".$this->prefix."core_user WHERE 1=1 ".$where);
		$result = $this->FetchObject($select);
		return $result->COUNT;
	}
	
	public function exist($checkFor, $value){
	   
		switch ($checkFor) {
			case 'user_name':
				$where = "USER_NAME = '".$value."'";
				break;
			case 'email':
				$where = "EMAIL = '".$value."'";
				break;
		}
        $select = $this->Select("SELECT COUNT(*) AS count FROM ".$this->prefix."core_user WHERE ".$where);
		$result = $this->FetchObject($select);
        $numUsers = $result->COUNT;
		return ($numUsers == 0) ? false : true;
        
	} 
    
    public function delete($id){

		$sql = "DELETE FROM ".$this->prefix."core_user WHERE USER_ID = $id";
        $this->Query($sql);
		return $this->GetExecuteStatus();
    }

    public function getUserSubCp($sid){
        if($sid){
            $sql = "SELECT u.full_name, sub.sid FROM ".$this->prefix."core_user AS u INNER JOIN ".$this->prefix."subcp AS sub ON u.user_id = sub.user_id WHERE u.type = 'REPORT' AND sub.sid = '$sid' ORDER BY sub.sid, u.full_name ASC";
            $result = $this->query($sql);
            if($this->numRows() > 0){
                return $result;
            }
        }
    }
	
	public function import($params = null)
    {
        if ($params != null) {
            $this->Insert($this->prefix.'core_user', $params);
			$this->DumpQueriesStack();
			return $this->GetExecuteStatus();
        }
    }
	
	public function getUserByUserName($user_name){
		
		$select = $this->Select("SELECT USER_ID FROM ".$this->prefix."core_user WHERE user_name='".$user_name."'");
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result->USER_ID;
        }
	}
}