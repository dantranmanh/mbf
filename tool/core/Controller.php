<?php
/**
* Controller.php
* 
* Core_Controller class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 13/7/2015
* @time 21:43
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

class Core_Controller extends Core_Rest{
    
    public $view;
    public $utility;
    public $baseUrl;
    public $_arrParams;
    public $controller;
    
    function __construct(){
        $this->view = new Core_View();
        $this->utility = new Core_Utility();
        $this->baseUrl = str_replace('index.php','',$_SERVER['PHP_SELF']);
        $this->_arrParams = $_REQUEST;
        $this->controller = get_class($this);
    }
    
    /**
    *
    * @param controller or action
    */
    public function getClassMethod($param){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'],"/");
            $url = explode('/',$url);
            
            if($param == "controller"){
                return  strtolower($url[0]);
            }elseif($param == "action"){
                return  strtolower($url[1]);
            }else{
                return false;
            }
        }
    }
    
    public function _redirect($url){
        return Core_Utility::redirect($url);
    }
    
    public function LoadModel($name){ // Auto load model
        $name = ucfirst(strtolower($name));
		$path = "models".DS.$name."_Model.php";
		if(file_exists($path)){
    		require_once($path);
    		$name = $name."_Model";
    		$this->model = new $name;
		}
	}
    
    public function debug($arr){
        return $this->utility->debug($arr);
    }
}