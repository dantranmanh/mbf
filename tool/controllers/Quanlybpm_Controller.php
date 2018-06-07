<?php

/**
* Quanlybpm_Controller.php
* 
* Quanlybpm_Controller class
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

class Quanlybpm_Controller extends Core_Controller{
    
    protected $layoutDefault;
    protected $layoutAdmin;
    
    public function __construct(){
        parent::__construct();
        
        $this->layoutDefault = "default";
        $this->layoutAdmin = "admin";

		$this->model = new Core_Model();
        
        $this->controller = $this->getClassMethod("controller");
        $this->action = $this->getClassMethod("action");
        
        if(!Core_Login::getLoginSession()){
            $this->_redirect($this->baseUrl.'login');
        }
        
        $this->acl = new Core_Acl();
    }
    
    public function lich_chay_processAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
		$msisdn = $this->_arrParams['msisdn'];
		
		$sql = 'BEGIN :v_Return := pkg_query.FUNC_QUERY_SATISFY_CARD(:P_MSISDN, :P_SATISFY_CARD_AMOUNT, :P_OUT); END;';
		$this->model->con();
		$stmt = oci_parse($this->model->conn_handle,$sql);
		oci_bind_by_name($stmt,':P_MSISDN', $msisdn, 20);
		oci_bind_by_name($stmt,':P_SATISFY_CARD_AMOUNT', $amount, 30);
		oci_bind_by_name($stmt,':P_OUT', $description, 255);
		oci_bind_by_name($stmt,':v_Return', $result, 5);
		oci_execute($stmt);
		
        $data = array(
			'msisdn' => $msisdn,
			'return_value' => $result,
			'amount' => ($amount)?($amount):0,
			'description' => $description,
            'title' => "Lịch chạy process"
        );
        $this->view->assign('quanlybpm/lich_chay_process', $data, $this->layoutAdmin);
    }
	
	public function cau_hinh_process_bpmAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
		$msisdn = $this->_arrParams['msisdn'];
		$f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : date("Y-m-d");
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : date("Y-m-d");

		$str_fdate = strtotime($f_date);
		$str_tdate = strtotime($t_date);
		$fdate = date('d-M-y', $str_fdate);
		$tdate = date('d-M-y', $str_tdate); 
		
		$sql = 'BEGIN :v_Return := pkg_query.FUNC_QUERY_CREDIT_TRANS(:P_MSISDN, :F_DATE, :T_DATE, :P_DATA_CURSOR, :P_OUT); END;';
		$this->model->con();
		$stmt = oci_parse($this->model->conn_handle,$sql);
		$curs = oci_new_cursor($this->model->conn_handle);
		
		oci_bind_by_name($stmt,':P_MSISDN', $msisdn, 20);
		oci_bind_by_name($stmt,':F_DATE', $fdate, 20);
		oci_bind_by_name($stmt,':T_DATE', $tdate, 20);
		oci_bind_by_name($stmt,':P_DATA_CURSOR', $curs, -1, OCI_B_CURSOR);
		oci_bind_by_name($stmt,':P_OUT', $description, 255);
		oci_bind_by_name($stmt,':v_Return', $result, 5);
		oci_execute($stmt);
		oci_execute($curs);
		
		$entry = oci_fetch_object($curs);
		
        $data = array(
			'msisdn' => $msisdn,
			'f_date' => $f_date,
			't_date' => $t_date,
			'return_value' => $result,
			'p_data_cursor' => $p_data_cursor,
			'description' => $description,
			'curs' => $entry,
            'title' => "Cấu hình process BPM"
        );
        $this->view->assign('quanlybpm/cau_hinh_process_bpm', $data, $this->layoutAdmin);
    }
	
	public function tra_cuu_process_executionAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $collection = array();
        $title = "Tra cứu lịch sử các process";
		$month = $this->_arrParams['proccess_months'];
        $year = $this->_arrParams['proccess_years'];
		if(empty($month) || empty($year)){
            $result = null;
            $data = array(
                'title' => $title,
                'month' =>(int) $month,
                'year'  => (int) $year
            );
        }else{
		    $md = new Quanlybpm_Model();
		    $collection = $md->getProcessHistory($month."/".$year);
            $data = array(
                'collection' => $collection,
                'title' => $title,
                'month' =>(int) $month,
                'year'  => (int) $year
            );
        }

        $this->view->assign('quanlybpm/tra_cuu_process_execution', $data, $this->layoutAdmin);
    }
	
}








