<?php
/**
* Model.php
* 
* Core_Model class
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

require_once('database'.DS.'oracle.php');

class Core_Model extends ORACLE{
	
    function __construct(){
        parent::__construct();
    }
    public function log($data,$filename="custom.log"){
        $logFile=ROOT_DIR.DS."vars" . DS."log".DS.$filename;
        if (!$log=fopen($logFile, "a+")) {
            throw new Exception("Cannot open file ".$logFile);
            // die;
        }else{
            fwrite($log,'Date:'.date('d-m-Y H:i:s'));
            fwrite($log,print_r($data, TRUE)."\n");
            fclose($log);
        }
    }

}