<?php
class Error_Controller extends Core_Controller{
    function __construct(){
        parent::__construct();
        echo "This is an Error.";
        $this->view->msg = 'This page doesnt exist.';
        $this->view->debug = $_REQUEST['url'];
        $this->view->render('error/index');
    }
}