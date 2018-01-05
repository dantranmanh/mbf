<?php

/**
* Impactlogs_Controller.php
* 
* Impactlogs_Controller class
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

class Impactlogs_Controller extends Core_Controller{
    
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
		$exp = array();
		//print_r($this->_arrParams);
		$f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : date("d-m-Y", strtotime(date("d-m-Y")." -5 day"));
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : date("d-m-Y H:i:s");
		
		if ($f_date) {
            $exp['f_date'] = date("d-M-Y", strtotime($f_date));
        }
        if ($t_date) {
            $exp['t_date'] = date("d-M-Y", strtotime($t_date));
        }
		
		if ($_POST && ($_POST['task'] == "filter")) {
            $user_id = $this->_arrParams['user_id'];
			$user_name = $this->_arrParams['username'];

            if ($user_id) {
                $exp['user_id'] = $user_id;
            }
			if ($user_name) {
                $exp['username'] = $user_name;
            }
        }
		$exp = (array)$exp;
		
        $model = new Impactlogs_Model();
        $data = array(
            'impactlogs' => $this->model->find($exp),
			'f_date' => $f_date,
			't_date' => $t_date,
			'exp' => $exp,
            'title' => "Danh sách logs tác động hệ thống"
        );
        $this->view->assign('impactlogs/list', $data, $this->layoutAdmin);
    }
}








