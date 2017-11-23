<?php

/**
* Defineusagelevel_Controller.php
* 
* Defineusagelevel_Controller class
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

class Defineusagelevel_Controller extends Core_Controller{
    
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
		
        $model = new Defineusagelevel_Model();
        $data = array(
            'defineusagelevel' => $this->model->getAll(),
            'title' => "Định nghĩa mức tiêu dùng"
        );
		
        $this->view->assign('defineusagelevel/list', $data, $this->layoutAdmin);
    }
    
    public function editAction(){
        
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $id = $this->_arrParams['id']; 
        $model = new Defineusagelevel_Model();
        $data = array(
            "data" => $model->getById($id),
            "title" => "Sửa định nghĩa mức tiêu dùng"
        );
        
        if($_POST && $_POST['task'] == 'edit'){
            
            if($model->update($id, $this->_arrParams)){
                
				$this->_redirect($this->baseUrl.'defineusagelevel/list'); 
            }
        }
        $this->view->assign('defineusagelevel/edit', $data, $this->layoutAdmin);
    }
}








