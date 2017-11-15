<?php

/**
* Blacklistreason_Controller.php
* 
* Blacklistreason_Controller class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 16/7/2015
* @time 11:30
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

class Blacklistreason_Controller extends Core_Controller{
    
    protected $layoutDefault;
    protected $layoutAdmin;
    
    public function __construct(){
        parent::__construct();
        
        $this->layoutDefault = "default";
        $this->layoutAdmin = "admin";
        
        $this->controller = $this->getClassMethod("controller");
        $this->action = $this->getClassMethod("action");
        
        if(!Core_Login::getLoginSession()){
            $this->_redirect($this->baseUrl.'login');
        }
        
        $this->acl = new Core_Acl();
    }
    
    public function listAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $model = new Blacklistreason_Model();
        $data = array(
            'BlacklistReason' => $this->model->getBlacklistReason(),
            'title' => "Danh sách lý do Blacklist"
        );
        $this->view->assign('blacklistreason/list', $data, $this->layoutAdmin);
    }
    
    public function addAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        if($_POST){
            $model = new Blacklistreason_Model();
			$id = $model->add($this->_arrParams);
            if($id){
                $this->_redirect($this->baseUrl.'blacklistreason/list'); 
            }
        }
        
        $data['title'] = "Thêm lý do Blacklist mới";
        $this->view->assign('blacklistreason/add', $data, $this->layoutAdmin);
    }
    
    public function editAction(){
        
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $id = $this->_arrParams['id']; 
        $model = new Blacklistreason_Model();
        $data = array(
            "data" => $model->getBlacklistReasonById($id),
            "title" => "Sửa lý do Blacklist"
        );
        
        if($_POST && $_POST['task'] == 'edit'){
            
            if($model->update($id, $this->_arrParams)){
                
				$this->_redirect($this->baseUrl.'blacklistreason/list'); 
            }
        }
        $this->view->assign('blacklistreason/edit', $data, $this->layoutAdmin);
    }
    
    public function deleteAction(){

		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $ids = $this->_arrParams['ids']; 
        //print_r($ids);exit; 
        if(count($ids) > 0){
            $model = new Blacklistreason_Model();
            foreach($ids as $id){
				if($model->delete($id)){
				   $this->_redirect($this->baseUrl.'blacklistreason/list'); 
                }
            }
        }
        $this->_redirect($this->baseUrl.'blacklistreason/list');      
    }
    
    public function checkAction(){

		if(IS_AJAX){
    		$checkType 	= $this->_arrParams['check_type'];
            $original 	= $this->_arrParams['original'];
    		$value 		= $this->_arrParams[$checkType];
            $model = new Blacklistreason_Model();
    		$result = false;
            if ($original == null || ($original != null && $value != $original)) {
    		   $result = $model->exist($checkType, $value);
           }	
    		echo ($result == true) ? "false" : "true";
        }
	}
}








