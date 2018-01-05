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

class Ajax_Controller extends Core_Controller{
    
    protected $layoutDefault;
    protected $layoutAdmin;
    
    public function __construct(){
        parent::__construct();

        $this->controller = $this->getClassMethod("controller");
        $this->action = $this->getClassMethod("action");
        $this->LoadModel("Resendsms");
        $this->model = new Resendsms_Model();
        if(!Core_Login::getLoginSession()){
            $this->_redirect($this->baseUrl.'login');
        }
        
        $this->acl = new Core_Acl();
    }
    
    public function smsresendgiaodichungAction(){

        if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $message = '';
        if ($_POST) {
            $id = $this->_arrParams['transactionid'];
            if ($this->model->resendGiaoDichUng($id)) {
                // Insert log
                $arrLOG = array(
                    'USER_ID' => Core_Login::getUserId(),
                    'USERNAME' => Core_Login::getUserName(),
                    'LOCATION' => $this->controller." => ".$this->action,
                    'DESCRIPTIONS' => "Gui lai SMS giao dich ung,transaction id =  <b>".$id."</b>",
                );
                Core_Logs::AddImpactlogs($arrLOG);
                echo $message = "Yêu cầu gửi lại SMS cho giao dich ung  id = ".$id." đã được thêm vào hệ thống!";
            }
        }else $message = "Dữ liệu gửi lên không hợp lệ";
        echo $message;
        return;
    }
    public function smsresendhoanungAction(){

        if(!$this->acl->allow($this->controller, $this->action)) {
             $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
             exit;
        }
        $message = '';
        if ($_POST) {
            $id = $this->_arrParams['transactionid'];
            if ($this->model->resendGiaoDichHoanUng($id)) {
                // Insert log
                $arrLOG = array(
                    'USER_ID' => Core_Login::getUserId(),
                    'USERNAME' => Core_Login::getUserName(),
                    'LOCATION' => $this->controller." => ".$this->action,
                    'DESCRIPTIONS' => "Gui lai SMS giao dich hoan ung ,transaction id =  <b>".$id."</b>",
                );
                Core_Logs::AddImpactlogs($arrLOG);
                echo $message = "Yêu cầu gửi lại SMS cho giao dich hoan ung co id = ".$id." đã được thêm vào hệ thống!";
            }
        }else $message = "Dữ liệu gửi lên không hợp lệ";
        echo $message;
        return;
    }
}








