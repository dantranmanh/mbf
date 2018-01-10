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
    
    public function addAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
		$model = new Controlsystem_Model();
		
        $data = array(
            'collection' => $model->getAllEvents(),
            'title' => "Tạo trigger"
        );
        $this->view->assign('controlsystem/add', $data, $this->layoutAdmin);
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
	
	public function insertAction(){
		
		if(IS_AJAX){
            $model = new Controlsystem_Model();
			$arr = array(
				'EVENT_CODE' => "'".strtoupper($this->_arrParams['EVENT_CODE'])."'",
				'EVENT_TIME'  => "'".date('d-M-Y H:i:s')."'",
				'ACTOR'  => "'".Core_Login::getUserName()."'",
				'STATUS' => 0,
			);
			//print_r($arr);exit;
			$id = $model->add($arr);
            if($id){
                echo $id;
            }
		}
	}
}








