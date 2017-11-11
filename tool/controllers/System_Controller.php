<?php

/**
* System_Controller.php
* 
* System_Controller class
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

class System_Controller extends Core_Controller{
    
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
    
    public function configAction(){

        if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }

        if(isset($_POST) && $_POST['task'] == "edit" ){
            chmod(CONFIG_DIR.DS.'config.ini',0777);
            $iniArray = array(
                "web" => array(
                    "site_name" => $this->_arrParams["site_name"],
                    "logo" => $this->_arrParams["logo"],
                    "service_name" => $this->_arrParams["service_name"],
                    "default_title" => $this->_arrParams["default_title"],
                    "copyright" => $this->_arrParams["copyright"],
                    "address" => $this->_arrParams["address"],
                    "hotline" => $this->_arrParams["hotline"],
                    "email" => $this->_arrParams["email"],
                ),
            );
            //echo "<pre>";
            //print_r($iniArray);
            Core_Config::saveConfig(CONFIG_DIR.DS.'config.ini', $iniArray);

        }


        $data = array(
            "action_parent" => "system",
            "action" => "config",
            "title" => "Cấu hình hệ thống",
            "site_name" => Core_Config::getConfig("web","site_name"),
            "logo" => Core_Config::getConfig("web","logo"),
            "service_name" => Core_Config::getConfig("web","service_name"),
            "default_title" => Core_Config::getConfig("web","default_title"),
            "copyright" => Core_Config::getConfig("web","copyright"),
            "address" => Core_Config::getConfig("web","address"),
            "hotline" => Core_Config::getConfig("web","hotline"),
            "email" => Core_Config::getConfig("web","email"),
        );

        $this->view->assign('system/config', $data, $this->layoutAdmin);
    }
}








