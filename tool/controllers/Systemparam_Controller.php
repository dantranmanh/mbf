<?php

/**
* Systemparam_Controller.php
* 
* Systemparam_Controller class
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

class Systemparam_Controller extends Core_Controller{
    
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
		
        $model = new Systemparam_Model();
        $data = array(
            'SystemParam' => $this->model->getErrorCode(),
            'title' => "Danh sách tham số hệ thống"
        );
        $this->view->assign('systemparam/list', $data, $this->layoutAdmin);
    }
    
    public function addAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        if($_POST){
            $model = new Systemparam_Model();
			$id = $model->add($this->_arrParams);
            if($id){
                $this->_redirect($this->baseUrl.'systemparam/list'); 
            }
        }
        
        $data['title'] = "Thêm tham số hệ thống mới";
        $this->view->assign('systemparam/add', $data, $this->layoutAdmin);
    }
    
    public function editAction(){
        
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $id = $this->_arrParams['id']; 
        $model = new Systemparam_Model();
        $data = array(
            "data" => $model->getErrorCodeById($id),
            "title" => "Sửa tham số hệ thống"
        );
        
        if($_POST && $_POST['task'] == 'edit'){
            
            if($model->update($id, $this->_arrParams)){
                
				$this->_redirect($this->baseUrl.'systemparam/list'); 
            }
        }
        $this->view->assign('systemparam/edit', $data, $this->layoutAdmin);
    }
    
    public function deleteAction(){

		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $ids = $this->_arrParams['ids']; 
        //print_r($ids);exit; 
        if(count($ids) > 0){
            $model = new Systemparam_Model();
            foreach($ids as $id){
				if($model->delete($id)){
				   $this->_redirect($this->baseUrl.'systemparam/list'); 
                }
            }
        }
        $this->_redirect($this->baseUrl.'systemparam/list');      
    }
    
    public function checkAction(){

		if(IS_AJAX){
    		$checkType 	= $this->_arrParams['check_type'];
            $original 	= $this->_arrParams['original'];
    		$value 		= $this->_arrParams[$checkType];
            $model = new Systemparam_Model();
    		$result = false;
            if ($original == null || ($original != null && $value != $original)) {
    		   $result = $model->exist($checkType, $value);
           }	
    		echo ($result == true) ? "false" : "true";
        }
	}
}








