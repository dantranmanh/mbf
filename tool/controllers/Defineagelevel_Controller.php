<?php

/**
* Defineagelevel_Controller.php
* 
* Defineagelevel_Controller class
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

class Defineagelevel_Controller extends Core_Controller{
    
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
		
        $model = new Defineagelevel_Model();
        $data = array(
            'defineagelevel' => $this->model->getAll(),
            'title' => "Định nghĩa mức tuổi thọ"
        );
		
        $this->view->assign('defineagelevel/list', $data, $this->layoutAdmin);
    }
    
    public function editAction(){
        
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $id = $this->_arrParams['id']; 
        $model = new Defineagelevel_Model();
        $data = array(
            "data" => $model->getById($id),
            "title" => "Sửa định nghĩa mức tuổi thọ"
        );
        
        if($_POST && $_POST['task'] == 'edit'){
            
            if($model->update($id, $this->_arrParams)){
                
				$this->_redirect($this->baseUrl.'defineagelevel/list'); 
            }
        }
        $this->view->assign('defineagelevel/edit', $data, $this->layoutAdmin);
    }
}








