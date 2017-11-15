<?php

/**
* Admin_Controller.php
* 
* Admin_Controller class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 14/7/2015
* @time 11:52
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

class Admin_Controller extends Core_Controller{
    
    protected $layout;
    
    public function __construct(){
        
        parent::__construct();
        
        $this->controller = $this->getClassMethod("controller");
        $this->action = $this->getClassMethod("action");
        
        if(!Core_Login::getLoginSession()){
            $this->_redirect($this->baseUrl.'login');
        }
        
        $this->acl = new Core_Acl();
        
        $this->layout = "admin";
    }
    
    public function indexAction(){
        $this->view->assign('admin/index', null, $this->layout);
    }
    
}
