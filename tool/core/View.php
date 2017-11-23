<?php
/**
* View.php
* 
* Core_View class
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

class Core_View {

    function __construct(){
    }

    public static function assign($name, $data = null, $layout = "admin"){
        
        if($data != null){
            foreach($data as $key => $value){
                $$key = $value;
            }
        }
        /**
         * Load change text model
         */
        $path = "models".DS."Translate_Model.php";
        if(file_exists($path)){
            require_once($path);

        }else  throw new Exception("Can not load translate model!");
        $mbftext = new Translate_Model();


        if($layout){
            require "templates".DS.$layout.DS."default.phtml";
        }
        
        require "views".DS.$name.".phtml";
        
        if($layout){
            require "templates".DS.$layout.DS."bottom.phtml";
        }
    }
    public static function _view($name, $data = null){
        
        if($data != null){
            foreach($data as $key => $value){
                $$key = $value;
            }
        }
        
        require "views".DS.$name.".phtml";
    }
    
    public function render($name){
        if(file_exists("views".DS.$name.".phtml")){
           require "views".DS.$name.".phtml"; 
        }
        return false;
    }
    
    public function requireFile($name){
        if(file_exists($name.".phtml")){
           require $name.".phtml"; 
        }
        return false;
    }
    
    public static function viewRenderer($name, $path = null){
        if(file_exists($path.DS.$name.".phtml")){
            require $path.DS.$name.".phtml";
        }
        return false;
    }
    
}