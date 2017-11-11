<?php

/**
* Permission_Controller.php
* 
* Permission_Controller class
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

class Permission_Controller extends Core_Controller{
    
    protected $layoutDefault;
    protected $layoutAdmin;
    
    public function __construct(){
        parent::__construct();
        
        $this->layoutDefault = "default";
        $this->layoutAdmin = "admin";
        $this->LoadModel("Permission");
        $this->model = new Permission_Model();
        $this->controller = $this->getClassMethod("controller");
        $this->action = $this->getClassMethod("action");
        
        if(!Core_Login::getLoginSession()){
            $this->_redirect($this->baseUrl.'login');
        }
        
        $this->acl = new Core_Acl();
    }
    
    public function indexAction(){
        
        if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        
        $dir   = CONTROL_DIR;
        $files = $this->dirToArray($dir);
        
        $data = array(
                "files" => $files,
                "model" => $this->model,
                "title" => "Phân quyền"
        );
        
        if($_POST){
            
            $permission = $this->_arrParams['permission'];
			//echo "<pre>";
			//print_r($permission);
            $task = $this->_arrParams['task'];
            $task_list = $this->_arrParams['task-list'];
            $id = $this->_arrParams['id'];
            
            // Xóa các quyen cu
            if($task_list != "submit"){
                if($task == "user"){
                    $this->model->deleteUserPermission($id);
                }else if($task == "group"){
                    $this->model->deleteGroupPermission($id);
                }else{
                    
                }
            }
                
            if(count($permission) > 0){
                foreach($permission as $value){
                    $value = @explode("|",strtolower($value));
                    $controller = $value[0];
                    $controller = @explode("_",$controller);
                    $controller = $controller[0];
                    $action     = $value[1];
                    
                    $params = array(
                        "PERMISSION_NAME" => "'".$action."'",
                        "PERMISSION_TYPE" => 1,
                        "CONTROLLER_NAME" => "'".$controller."'",
                    );
                    
                    // Add cac quyen moi
                    if($task == "user"){
                        $params['userid'] = $id;
                        $this->model->addUserPermission($params);
                    }else if($task == "group"){
                        $params['group_id'] = $id;
                        $this->model->addGroupPermission($params);
                    }else{
                        
                    }
                }
            }
            
        }
        $this->view->assign('permission/index', $data, $this->layoutAdmin);
    }
    
    public function actionAction(){
        
        if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        
        $dir   = CONTROL_DIR;
        $files = $this->dirToArray($dir);
        $data = array(
            "actions" => $this->model->getActions(),
            "controller" => $files,   
            "title" => "Danh sách Action"         
        );
        
        if($_POST){
            if($this->model->addAction($this->_arrParams)){
                $this->_redirect($this->baseUrl."permission/action");
            }
            
        }
        
        $this->view->assign('permission/action', $data, $this->layoutAdmin);
    }

    public function delete_actionAction(){
        if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //print_r($_GET);
        if($_GET){
            if($this->model->deleteAction($_GET['id'])){
                $this->_redirect($this->baseUrl."permission/action");
            }else{
                echo "Error";
            }
        }
    }
    
    function dirToArray($dir) {
  
       $result = array();
    
       $cdir = scandir($dir);
       foreach ($cdir as $key => $value){
            $value = str_replace(".php","",$value);
          //$value = strtolower($value);
          //$value = explode("_",$value); 
          //$value = $value[0]; 
          if (!in_array($value,array(".","..",".htaccess"))){
             if (is_dir($dir . DIRECTORY_SEPARATOR . $value)){
                $result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value);
             }else{
                $result[] = $value;
             }
          }
       }
      
       return $result;
    } 
}








