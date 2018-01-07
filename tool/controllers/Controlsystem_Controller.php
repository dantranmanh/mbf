<?php

/**
* Controlsystem_Controller.php
* 
* Controlsystem_Controller class
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

class Controlsystem_Controller extends Core_Controller{
    
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
		
        $model = new Controlsystem_Model();
        $data = array(
            'collection' => $model->getAll(),
            'title' => "Tra cứu event log"
        );
        $this->view->assign('controlsystem/list', $data, $this->layoutAdmin);
    }
    
    public function addAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        if($_POST){
            $model = new Controlsystem_Model();
			$id = $model->add($this->_arrParams);
            if($id){
                $this->_redirect($this->baseUrl.'controlsystem/list'); 
            }
        }
        
        $data['title'] = "Tạo trigger";
        $this->view->assign('controlsystem/add', $data, $this->layoutAdmin);
    }
}








