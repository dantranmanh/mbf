<?php
/**
* Acl.php
* 
* Core_Acl Class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 13/7/2015
* @time 21:43
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/
/**
 * USE
$acl = new Core_Acl();
if(!$acl->check($controller,$action)) {
// user doesn't have permission to execute the following action
//do something here
}
*/
require_once('database'.DS.'oracle.php');

Class Core_Acl {
   
    private $db;
    private $user_empty = false;
    
   //initialize the database object here
   function __construct() {
     $this->db = new ORACLE();
	 $this->user = new Core_Login();
   }
    
    public function allow($controller, $action){
        
        //we check the user permissions first
         if(!$this->user_permissions($action,$this->user->getUser()->USER_ID,$controller)) {
            return false;
         }
            
         if(!$this->group_permissions($action,$this->user->getUser()->GROUP_ID,$controller) & $this->IsUserEmpty()) {
            return false;
         }
    
         return true;
    }
    
    function user_permissions($permission,$userid,$controller) {
		
		$select = $this->db->Select("SELECT COUNT(*) AS count FROM idvn_core_user_permissions WHERE permission_name='$permission' AND userid='$userid' AND controller_name  = '$controller'");
        $row = $this->db->FetchObject($select); 

        if($row->COUNT == 0){
            return false;
        }
        
        $this->setUserEmpty('true');
        
        return true;
    }
    
    function group_permissions($permission,$group_id,$controller) {
		
        $select = $this->db->Select("SELECT COUNT(*) AS count FROM idvn_core_group_permissions WHERE permission_name='$permission' AND group_id='$group_id' AND controller_name  = '$controller' ");
        
        $row = $this->db->FetchObject($select); 
        if($row->COUNT == 0){
            return false;
        }
        
        return true;
        
    }
    
    
    function setUserEmpty($val) {
         $this->userEmpty = $val;
    }
    
    function isUserEmpty() {
       return $this->userEmpty;
    }

}
