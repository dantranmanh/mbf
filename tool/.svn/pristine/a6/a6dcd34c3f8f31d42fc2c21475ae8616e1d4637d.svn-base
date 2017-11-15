<?php

/**
* User_Controller.php
* 
* User_Controller class
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

class User_Controller extends Core_Controller{
    
    protected $layoutDefault;
    protected $layoutAdmin;
    
    public function __construct(){
        parent::__construct();
        
        $this->layoutDefault = "default";
        $this->layoutAdmin = "admin";
        $this->LoadModel("Group");
        $this->mdGroup = new Group_Model();
		//$this->LoadModel("Permission");
        //$this->mdPermission = new Permission_Model();
        
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
		
        $model = new User_Model();
        if(Core_Login::getUserId() != 1){
            $exp = array(
                "created_user_id" => Core_Login::getUserId(),
                "type"  => "TOOL"
            );
        }else{
            $exp = array(
                "type"  => "TOOL"
            );
        }

        if ($_POST && ($_POST['task'] == "filter")) {
            $user_name = $this->_arrParams['user_name'];
            $full_name = $this->_arrParams['full_name'];
            $email = $this->_arrParams['email'];
            $status = $this->_arrParams['status'];

            if ($user_name) {
                $exp['username'] = $user_name;
            }
            if ($full_name) {
                $exp['full_name'] = $full_name;
            }
            if ($email) {
                $exp['email'] = $email;
            }
            if ($status == 0 && ($status != null)) {
                $exp['status'] = 0;
            } elseif ($status == null) {
                $exp['status'] = null;
            } else {
                $exp['status'] = $status;
            }

            $params = rawurlencode(base64_encode(json_encode($exp)));
        } else {

            $params = $this->_arrParams['q'];
            if (null != $params) {
                $exp = rawurldecode(base64_decode($params));
                $exp = json_decode($exp);
            } else {
                $params = rawurlencode(base64_encode(json_encode($exp)));
            }
        }
        $exp = (array)$exp;
		//print_r($exp);
        $numUser = $model->count($exp);
		//echo $numUser;
        $config = array(
            'current_page'  => isset($_GET['page']) && (int)$_GET['page'] ? str_replace('-','',$_GET['page']) : 1,
            'total_record'  => $numUser,
            'limit'         => 25,
            'link_full'     => $this->baseUrl.'user/list?page={page}&q=' . $params,
            'link_first'    => $this->baseUrl.'user/list&q=' . $params,
            'range'         => 9 
        );
        
        $start = ($config['current_page'] - 1) * $config['limit'];
        $count = $config['limit'];
        
        $paging = new Core_Pagination();
         
        $paging->init($config);
		$users = $model->find($start, $count, $exp);
         
        $data = array(
            'users' => $users,
            'paging' => $paging->show(),
            'mdGroup' => $this->mdGroup ,
            'exp' => $exp,
            'title' => "Danh sách người dùng"
        );
		//echo "<pre>";
		//print_r($data['users']);
		//foreach($data['users'] as $val){
		//	echo $val['FULL_NAME'];
			
		//}
        $this->view->assign('user/list', $data, $this->layoutAdmin);
    }
    
    public function addAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        
        if($_POST){
            $model = new User_Model();
			$id = $model->add($this->_arrParams);
            if($id){
                $this->_redirect($this->baseUrl.'user/list'); 
                //$data = array('message'=>'Người dùng mới đã được thêm thành công.');  
            }
			/**
			// Add default permission
			$permission = array('Report_Controller|thongke_thuebao_dangky','Report_Controller|thongke_nhandien_thuebao','Report_Controller|thongke_thanhtoan');
			if(count($permission) > 0){
                foreach($permission as $value){
                    $value = @explode("|",strtolower($value));
                    $controller = $value[0];
                    $controller = @explode("_",$controller);
                    $controller = $controller[0];
                    $action     = $value[1];
                    
                    $params = array(
                        "permission_name" => $action,
                        "permission_type" => 1,
                        "controller_name" => $controller,
                    );
                    
                    // Add các quyen mac dinh
                    $params['userid'] = $id;
                    $this->mdPermission->addUserPermission($params);
                }
            }*/
        }
        
        $groups = $this->mdGroup->getGroups();
        $data['groups'] = $groups;
        $data['title'] = "Thêm người dùng mới";
        $this->view->assign('user/add', $data, $this->layoutAdmin);
    }
    
    public function editAction(){
        
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $id = $this->_arrParams['id']; 
        $model = new User_Model();
        $data = array(
            "user" => $model->getUserById($id),
            "title" => "Sửa người dùng"
        );
        
        if($_POST && $_POST['task'] == 'edit'){
            
            if($model->update($id, $this->_arrParams)){
                
                //$data['message'] = 'Sửa người dùng thành công.';
				$this->_redirect($this->baseUrl.'user/list'); 
            }
        }
        $groups = $this->mdGroup->getGroups();
        $data['groups'] = $groups;
        
        $this->view->assign('user/edit', $data, $this->layoutAdmin);
    }
    
    public function deleteAction(){
		//echo 1;exit;
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $ids = $this->_arrParams['ids']; 
        //print_r($ids); 
        if(count($ids) > 0){
            $model = new User_Model();
            foreach($ids as $id){
                if($id != Core_Login::getUserId()){
                    if($model->delete($id)){
                       $this->_redirect($this->baseUrl.'user/list'); 
                    }
                }
            }
        }
        $this->_redirect($this->baseUrl.'user/list');      
    }
    
    public function activateAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
        $ids = $this->_arrParams['ids'];
        $model = new User_Model();
        if(count($ids) > 0){
            foreach($ids as $id){
                if($id != Core_Login::getUserId()){
                    if($model->toggleStatus($id)){
                        $this->_redirect($this->baseUrl.'user/list'); 
                    }
                }
            }
        }
        $this->_redirect($this->baseUrl.'user/list');
    }
    
    public function checkAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
		if(IS_AJAX){
    		$checkType 	= $this->_arrParams['check_type'];
            $original 	= $this->_arrParams['original'];
    		$value 		= $this->_arrParams[$checkType];
            $model = new User_Model();
    		$result = false;
            if ($original == null || ($original != null && $value != $original)) {
    		   $result = $model->exist($checkType, $value);
           }	
    		echo ($result == true) ? "false" : "true";
        }
	}
    
    public function suggestAction(){

		$limit 		= 20;
		$keyword 	= $this->_arrParams['term'];
		$keyword 	= strip_tags($keyword);
		
		$exp = array(
			'keyword' 	=> $keyword,
            'type' => 'REPORT'
		);
        
        $model = new User_Model();
		$users = $model->find(0, $limit, $exp);
		//$response = array();
		//foreach ($users as $user) {
		//	$response[] = $user->user_name;
	//	}
		//echo json_encode($response);
        echo str_replace(array('user_id','full_name'), array("id","value"), json_encode($users));
	}
}








