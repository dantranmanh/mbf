<?php

/**
* Group_Model.php
* 
* Group_Model class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 16/7/2015
* @time 11:48
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

class Resendsms_Model extends Core_Model{
    
    public function __construct(){
        
    }
	public function resendGiaoDichUng($id){

		$arr = array(
            'CREDIT_TRANS_ID' => "'".$id."'",
			'CREATE_DATE'  => "TO_DATE('".date('Y-m-d H:i:s')."','yyyy/mm/dd hh24:mi:ss')",
            'STATUS'      => '0',
		);
		$this->Insert('resend_credit_sms_queue', $arr);
		return $this->GetExecuteStatus();
	}
    public function resendGiaoDichHoanUng($id){

        $arr = array(
            'PAYMENT_TRANS_ID' => "'".$id."'",
            'CREATE_DATE'  => "TO_DATE('".date('Y-m-d H:i:s')."','yyyy/mm/dd hh24:mi:ss')",
            'STATUS'      => '0',
        );
        $this->Insert('resend_payment_sms_queue', $arr);
        return $this->GetExecuteStatus();
    }
	/**
     * This function return last command exec status
     *
     * @return bool
     */
    public function GetExecuteStatus(){
        return $this->execute_status;
    }
}