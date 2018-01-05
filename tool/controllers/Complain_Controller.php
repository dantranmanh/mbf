<?php

/**
* Complain_Controller.php
* 
* Complain_Controller class
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

class Complain_Controller extends Core_Controller{
    
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
		
		$this->LoadModel('Blacklistreason');
		$this->Md_Blacklistreason = new Blacklistreason_Model();
        
        $this->acl = new Core_Acl();
    }
    
    public function xoa_no_do_khieu_naiAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $model = new Complain_Model();
        $data = array(
            'title' => "Xóa nợ do khiếu nại"
        );
        $this->view->assign('complain/xoa_no_do_khieu_nai', $data, $this->layoutAdmin);
    }
	
	public function bu_the_do_khieu_naiAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $model = new Complain_Model();
        $data = array(
            'title' => "Bù thẻ do khiếu nại"
        );
        $this->view->assign('complain/bu_the_do_khieu_nai', $data, $this->layoutAdmin);
    }
    
    public function dua_thue_bao_vao_blacklistAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
		$black_list_reason = $this->Md_Blacklistreason->getBlacklistReason();
		
        if($_POST){
            $model = new Complain_Model();
			$id = $model->addToBlacklist($this->_arrParams);
            if($id){
                $this->_redirect($this->baseUrl.'complain/danh_sach_blacklist'); 
            }
        }
        
        $data = array(
			'title' => "Đưa thuê bao vào black list",
			'black_list_reason' => $black_list_reason,
		);
        $this->view->assign('complain/dua_thue_bao_vao_blacklist', $data, $this->layoutAdmin);
    }
	
	public function danh_sach_blacklistAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $model = new Complain_Model();
        $data = array(
            'blacklist' => $this->model->geBlacklist(),
            'title' => "Danh sách thuê bao black list"
        );
        $this->view->assign('complain/danh_sach_blacklist', $data, $this->layoutAdmin);
    }
    
    public function deleteAction(){

		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $ids = $this->_arrParams['ids']; 
        //print_r($ids);exit; 
        if(count($ids) > 0){
            $model = new Complain_Model();
            foreach($ids as $id){
				if($model->delete_blacklist($id)){
				   $this->_redirect($this->baseUrl.'complain/danh_sach_blacklist'); 
                }
            }
        }
        $this->_redirect($this->baseUrl.'complain/danh_sach_blacklist');      
    }
	
    public function checkAction(){

		if(IS_AJAX){
    		$checkType 	= $this->_arrParams['check_type'];
            $original 	= $this->_arrParams['original'];
    		$value 		= $this->_arrParams[$checkType];
            $model = new Complain_Model();
    		$result = false;
            if ($original == null || ($original != null && $value != $original)) {
    		   $result = $model->exist($checkType, $value);
           }	
    		echo ($result == true) ? "false" : "true";
        }
	}
}








