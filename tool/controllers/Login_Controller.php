<?php

/**
 * Login_Controller.php
 *
 * Login_Controller class
 *
 * @project mvc
 * @author duong bien
 * @email bien.duongvan@yahoo.com
 * @date 15/7/2015
 * @time 9:23
 * @copyright 2015 Copyright duong bien
 * @license duong bien
 * @version 1.0.0
 */
class Login_Controller extends Core_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {

        //print_r($this->_arrParams);
		
        $login = new Core_Login();
		//print_r($login->getUser());
        
		if ($login->getLoginSession()) {
            $this->_redirect($this->baseUrl . 'admin');
        }

        if (isset($this->_arrParams['login']) && ($this->_arrParams['login'] == "Login")) {

            $login->setDatabaseUsersTable('idvn_core_user');
            $login->setCryptMethod('md5');
            //$login->setShowMessage(true);          
            $login->setLoginSession();
            if ($login->getLoginSession()) {
                $this->_redirect($this->baseUrl . 'admin');
            }
            //print_r($_SESSION);
        }
        $this->view->assign('login/index', array('error' => null), null);
    }

    public function logoutAction()
    {
        $login = new Core_Login();
        $login->unsetLoginSession();
        $this->_redirect($this->baseUrl . 'login');

    }


}

