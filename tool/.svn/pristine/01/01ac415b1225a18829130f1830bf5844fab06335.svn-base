<?php
/**
* Bootstrap.php
* 
* Core_Bootstrap Class
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

class Core_Bootstrap{
    
    public function init(){
        
      if(isset($_GET['url'])){
          $url = rtrim($_GET['url'],"/");
          $url = explode('/',$url);
          $c = ucfirst(strtolower($url[0]));
      }else{
          $c = "Admin";
      }
      
      $Action = "Action";
      //print_r($url);
      
      $file_controller = "controllers".DS.$c."_Controller.php";
      
      if(file_exists($file_controller)){
          require_once($file_controller);
      }else{
          require "controllers".DS."Error_Controller.php";
          $controller = new Error_Controller();
          return false;
      } 
      $name_controller = $c."_Controller"; 
      //echo $name_controller;
      $controller = new $name_controller; 
      //print_r($controller);
      $controller->LoadModel($c);//autoload model
      if(isset($url[2])){
          $controller->{$url[1].$Action}($url[2].$Action);
      }else{
          if(isset($url[1])){
            $controller->{$url[1].$Action}();
          }else{
            $controller->indexAction();
          }
        } 
    }
}