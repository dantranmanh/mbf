<?php

/**
 * Group_Controller.php
 *
 * Group_Controller class
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
class Group_Controller extends Core_Controller
{

    protected $layoutDefault;
    protected $layoutAdmin;

    public function __construct()
    {
        parent::__construct();

        $this->layoutDefault = "default";
        $this->layoutAdmin = "admin";
        $this->LoadModel("Group");
        $this->model = new Group_Model();
        $this->controller = $this->getClassMethod("controller");
        $this->action = $this->getClassMethod("action");

        if (!Core_Login::getLoginSession()) {
            $this->_redirect($this->baseUrl . 'login');
        }

        $this->acl = new Core_Acl();
    }

    public function listAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }

        $data = array(
            'groups' => $this->model->getGroups(),
            'title' => "Danh sách nhóm"
        );

        $this->view->assign('group/list', $data, $this->layoutAdmin);
    }

    public function addAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
		//print_r($_POST);
        if ($_POST) {
			$group_name = $this->_arrParams['group_name'];
			//$r = $this->model->add($group_name);
			//var_dump($r);
			//echo $r;
            if ($this->model->add($group_name)) {
                $data = array('message' => 'Nhóm mới đã được thêm thành công.');
            }
        }
        $data['title'] = "Thêm nhóm mới";
        $this->view->assign('group/add', $data, $this->layoutAdmin);
    }

    public function editAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }

        $id = $this->_arrParams['id'];
        $data = array(
            "group" => $this->model->getGroupById($id),
            "title" => "Sửa nhóm"
        );

        if ($_POST && $_POST['task'] == 'edit') {

            if ($this->model->update($id, $this->_arrParams)) {

                //$data['message'] = 'Sửa nhóm thành công.';
				$this->_redirect($this->baseUrl . 'group/list');
            }
        }

        $this->view->assign('group/edit', $data, $this->layoutAdmin);
    }

    public function deleteAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }

        $ids = $this->_arrParams['ids'];
        if (count($ids) > 0) {
            foreach ($ids as $id) {
                if ($this->model->delete($id)) {
                    $this->_redirect($this->baseUrl . 'group/list');
                }
            }
        }
        $this->_redirect($this->baseUrl . 'group/list');
    }

    public function activateAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }

        $ids = $this->_arrParams['ids'];
        if (count($ids) > 0) {
            foreach ($ids as $id) {
                if ($this->model->toggleStatus($id)) {
                    $this->_redirect($this->baseUrl . 'group/list');
                }
            }
        }
        $this->_redirect($this->baseUrl . 'group/list');
    }
}








