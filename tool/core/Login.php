<?php

/**
* Core_Login.php
* 
* Core_Login class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 15/7/2015
* @time 11:38
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/
 
require_once('database'.DS.'oracle.php');
 
class Core_Login extends ORACLE{
    
    private $databaseUsersTable;
    private $showMessage;
    private $cryptMethod;
    
    function __construct(){
        if(!isset($_SESSION)) session_start();
        //$_SESSION['login_session']=false;
    }

    public function setDatabaseUsersTable($database_user_table){
        $this->databaseUsersTable=$database_user_table;
    }
    
    public function setCryptMethod($crypt_method){
        $this->cryptMethod=$crypt_method;
    }

    public function setCrypt($text_to_crypt){
        $text_to_crypt = addslashes($text_to_crypt);
        switch($this->cryptMethod){
            case 'md5': $text_to_crypt=trim(md5($text_to_crypt)); break;
            case 'sha1': $text_to_crypt=trim(sha1($text_to_crypt)); break;
        }
        return $text_to_crypt;
    }

    static public function setEscape($text_to_escape){
        if(!get_magic_quotes_gpc()) $text_to_escape=addslashes($text_to_escape);
        return $text_to_escape;
    }

    public function setShowMessage($login_show_message){
        if(is_bool($login_show_message)) $this->showMessage=$login_show_message;
    }
    
    public function getMessage($message_text, $message_die=false){
        if($this->showMessage){
            if(!$message_die){
                die($message_text);
            }else{ 
                echo $message_text;
            }
        }
    }

    public function setLoginSession(){
        if(!$this->databaseUsersTable) $this->getMessage('Users table in the database is not specified. Please specify it before any other operation using the method setDatabaseUsersTable();', '', '', 'true');
        if(!$this->getLoginSession()){
            $user_name=$this->setEscape($_REQUEST['txtUsername']);
            $user_pass=$this->setCrypt($_REQUEST['txtPassword']);
            
            $select = $this->Select("SELECT user_id,group_id,user_name,full_name,is_active,email FROM"." ".$this->databaseUsersTable." "."WHERE user_name='$user_name' AND password='$user_pass' AND is_active = 1 AND type = 'TOOL'");
            $row = $this->FetchObject($select); 
			
            if($this->NumRows($select) > 0){
                $_SESSION['user_id']       = $row->USER_ID;
                $_SESSION['group_id']      = $row->GROUP_ID;
                $_SESSION['user_name']     = $row->USER_NAME;
                $_SESSION['full_name']     = $row->FULL_NAME;
                $_SESSION['is_active']     = 1;
                $_SESSION['email']         = $row->EMAIL;      
                $_SESSION['login_session'] = true;
            }else{
                $this->getMessage('Access data entered is incorrect.', true);
            }
        }
    }
    
    public function getUser(){
		
        $select = $this->Select("SELECT * FROM idvn_core_user WHERE USER_ID ='".self::getUserId()."' AND IS_ACTIVE = 1");
        $row = $this->FetchObject($select); 
		//$this->DumpQueriesStack(); 
		if($this->NumRows($select) > 0){
            return $row;
        }
    }

    public static function getLoginSession(){
        if($_SESSION['login_session']) return true;
        else return false;
    }

    public function unsetLoginSession(){
        if($this->getLoginSession()){
            unset($_SESSION['user_id']);
            unset($_SESSION['group_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['full_name']);
            unset($_SESSION['is_active']);
            unset($_SESSION['email']);      
            unset($_SESSION['login_session']);
        }
    }

    public static function getUserId(){
        if($_SESSION['login_session']) return $_SESSION['user_id'];      
    }
    
    public static function getGroupId(){
        if($_SESSION['login_session']) return $_SESSION['group_id'];      
    }

    public static function getUserName(){
        if($_SESSION['login_session']) return $_SESSION['user_name'];      
    }
    
    public static function getFullName(){
        if($_SESSION['login_session']) return $_SESSION['full_name'];      
    }
    
    public static function getEmail(){
        if($_SESSION['login_session']) return $_SESSION['email'];      
    }

    public function getUserActive(){
        if($this->getLoginSession()){
            if($_SESSION['is_active'] == 1) return true;
            else return false;
        }
    }
    
}

?>