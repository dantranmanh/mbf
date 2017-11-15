<?php

/**
* Message_Controller.php
* 
* Message_Controller class
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

class Message_Controller extends Core_Controller{
    
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
		
        $model = new Message_Model();
        $data = array(
            'message' => $this->model->getMessage(),
            'title' => "Danh sách Message"
        );
        $this->view->assign('message/list', $data, $this->layoutAdmin);
    }
    
    public function addAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        if($_POST){
            $model = new Message_Model();
			$id = $model->add($this->_arrParams);
            if($id){
                $this->_redirect($this->baseUrl.'message/list'); 
            }
        }
        
        $data['title'] = "Thêm Message mới";
        $this->view->assign('message/add', $data, $this->layoutAdmin);
    }
    
    public function editAction(){
        
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $id = $this->_arrParams['id']; 
        $model = new Message_Model();
        $data = array(
            "data" => $model->getMessageById($id),
            "title" => "Sửa Message"
        );
        
        if($_POST && $_POST['task'] == 'edit'){
            
            if($model->update($id, $this->_arrParams)){
                
                //$data['message'] = 'Sửa Message thành công.';
				$this->_redirect($this->baseUrl.'message/list'); 
            }
        }
        $this->view->assign('message/edit', $data, $this->layoutAdmin);
    }
    
    public function deleteAction(){

		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $ids = $this->_arrParams['ids']; 
        //print_r($ids);exit; 
        if(count($ids) > 0){
            $model = new Message_Model();
            foreach($ids as $id){
				if($model->delete($id)){
				   $this->_redirect($this->baseUrl.'message/list'); 
                }
            }
        }
        $this->_redirect($this->baseUrl.'message/list');      
    }
    
    public function checkAction(){

		if(IS_AJAX){
    		$checkType 	= $this->_arrParams['check_type'];
            $original 	= $this->_arrParams['original'];
    		$value 		= $this->_arrParams[$checkType];
            $model = new Message_Model();
    		$result = false;
            if ($original == null || ($original != null && $value != $original)) {
    		   $result = $model->exist($checkType, $value);
           }	
    		echo ($result == true) ? "false" : "true";
        }
	}
}








