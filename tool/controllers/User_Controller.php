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
		$this->LoadModel("Permission");
        $this->mdPermission = new Permission_Model();
        
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
				
				// Insert log
				$arrLOG = array(
					'USER_ID' => Core_Login::getUserId(),
					'USERNAME' => Core_Login::getUserName(),
					'LOCATION' => $this->controller." => ".$this->action,
					'DESCRIPTIONS' => "Them user <b>".$this->_arrParams['full_name']."</b>",
				);
				Core_Logs::AddImpactlogs($arrLOG);
				
                $this->_redirect($this->baseUrl.'user/list'); 
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
		
		//print_r($data);exit;
        
        if($_POST && $_POST['task'] == 'edit'){
            //print_r($this->_arrParams);exit;
            if($model->edit($id, $this->_arrParams)){
                
				// Insert log
				$arrLOG = array(
					'USER_ID' => Core_Login::getUserId(),
					'USERNAME' => Core_Login::getUserName(),
					'LOCATION' => $this->controller." => ".$this->action,
					'DESCRIPTIONS' => "Sua user:<br> 
					Full name: <b>".$data['user']->FULL_NAME."</b> thanh <b>".$this->_arrParams['full_name']."</b><br/>
					User name: <b>".$data['user']->USER_NAME."</b> thanh <b>".$this->_arrParams['user_name']."</b><br/>
					Email: <b>".$data['user']->EMAIL."</b> thanh <b>".$this->_arrParams['email']."</b><br/>
					Group: <b>".$data['user']->GROUP_ID."</b> thanh <b>".$this->_arrParams['group_id']."</b><br/>",
				);
				Core_Logs::AddImpactlogs($arrLOG);
				
				$this->_redirect($this->baseUrl.'user/edit?id='.$id); 
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
					
					$user = $model->getUserById($id);
					// Insert log
					$arrLOG = array(
						'USER_ID' => Core_Login::getUserId(),
						'USERNAME' => Core_Login::getUserName(),
						'LOCATION' => $this->controller." => ".$this->action,
						'DESCRIPTIONS' => "Xoa user <b>".$user->FULL_NAME."</b>",
					);
					Core_Logs::AddImpactlogs($arrLOG);
					
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
					
					$user = $model->getUserById($id);
					// Insert log
					$arrLOG = array(
						'USER_ID' => Core_Login::getUserId(),
						'USERNAME' => Core_Login::getUserName(),
						'LOCATION' => $this->controller." => ".$this->action,
						'DESCRIPTIONS' => "Doi trang thai user <b>".$user->FULL_NAME."</b>",
					);
					Core_Logs::AddImpactlogs($arrLOG);
					
                    if($model->toggleStatus($id)){
                        $this->_redirect($this->baseUrl.'user/list'); 
                    }
                }
            }
        }
        $this->_redirect($this->baseUrl.'user/list');
    }
    
    public function checkAction(){
		
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
            'type' => 'TOOL'
		);
        
        $model = new User_Model();
		$users = $model->find(0, $limit, $exp);
		//$response = array();
		//foreach ($users as $user) {
		//	$response[] = $user->user_name;
	//	}
		//echo json_encode($response);
        echo str_replace(array('USER_ID','FULL_NAME'), array("id","value"), json_encode($users));
	}
	
	
	public function import_excelAction()
    {
        if($_POST && $_POST['importExcel'] == "Excel"){

            $uploaDdir = "upload/"; 
            if(isset($_FILES["fileExcle"]) && $_FILES["fileExcle"]['name'] != "") {
                $resultUpload = Core_Utility::uploadImage("fileExcle", $uploaDdir, "xls,xlsx", 1024 * 1024 * 2);
                $file = $resultUpload['fileName'];
                $fileAvatarError = $resultUpload['error'];
				//echo $fileAvatarError;
				
                //if ($fileAvatarError != "") {
                    require_once(CORE_DIR . DS . 'phpexcel/PHPExcel.php');
                    $objPHPExcel = PHPExcel_IOFactory::load($uploaDdir."/".$file);
                    $response = $objPHPExcel->getWorksheetIterator();
					//print_r($response);
                    foreach ($response as $worksheet) {
                        $highestRow = $worksheet->getHighestRow();
                        //echo $highestRow;
                        for ($row = 2; $row < $highestRow; $row++) {
                            $username = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                            $password = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                            $full_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                            $email = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                            $quyen = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
							
                            $users = array(
                                'USER_NAME' 		=> "'".$username."'",
                                'PASSWORD' 			=> "'".md5($password)."'",
                                'FULL_NAME' 		=> "'".$full_name."'",
                                'EMAIL' 			=> "'".$username."@mobifone.vn'",
                                'IS_ACTIVE' 		=> 1,
                                'CREATED_DATE' 		=> "TO_DATE('".date('Y-m-d H:i:s')."','yyyy/mm/dd hh24:mi:ss')",
								'LOGGED_IN_DATE' 	=> "TO_DATE('".date('Y-m-d H:i:s')."','yyyy/mm/dd hh24:mi:ss')",
								'IS_ONLINE' 		=> 0,
								'GROUP_ID' 			=> 2,
								'CREATED_USER_ID'   => "'".Core_Login::getUserId()."'",
								'TYPE'              => "'TOOL'",
                            );
                            //echo  "<pre>";
                            //print_r($users);

                            $model = new User_Model();
                            $result = $model->import($users);
                            if ($result) {
                                if ($quyen == 1) {
                                    $p = array("muc_the_ung","giao_dich_ung_the","giao_dich_hoan_ung","tra_cuu_no","danh_sach_blacklist","thong_tin_thue_bao","sms_log");
                                }elseif($quyen == 2){
                                    $p = array("muc_the_ung");
                                }

                                foreach ($p as $value) {
                                    $permission = array(
                                        "PERMISSION_NAME" => "'".$value."'",
                                        "PERMISSION_TYPE" => 1,
                                        "CONTROLLER_NAME" => "'search'",
                                        "USERID" => "'".$model->getUserByUserName($username)."'",
                                    );
									//echo "<pre>";
									//print_r($permission);
                                    $this->mdPermission->addUserPermission($permission);
                                }

                                $this->_redirect($this->baseUrl . 'user/list');
                            }
                        }
                    }
               // }
            }else{
				$this->_redirect($this->baseUrl . 'user/add');
			}
        }

        $this->view->assign('user/import_excel', "", $this->layoutAdmin);
    }
}








