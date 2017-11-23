<?php

/**
* Search_Controller.php
* 
* Search_Controller class
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

class Search_Controller extends Core_Controller{
    
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
    
    public function muc_the_ungAction(){
		
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
            'title' => "Tra cứu mức thẻ ứng áp dụng cho thuê bao"
        );
        $this->view->assign('search/muc_the_ung', $data, $this->layoutAdmin);
    }
	
	public function giao_dich_ung_theAction(){
		
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
            'title' => "Tra cứu mức thẻ ứng áp dụng cho thuê bao"
        );
        $this->view->assign('search/giao_dich_ung_the', $data, $this->layoutAdmin);
    }
	
	public function giao_dich_hoan_ungAction(){
		
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
		
		$sql = 'BEGIN :v_Return := PKG_QUERY.FUNC_QUERY_PAYMENT_TRANS(:P_MSISDN, :F_DATE, :T_DATE, :P_DATA_CURSOR, :P_OUT); END;';
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
		//print_r($entry);
        $data = array(
			'msisdn' => $msisdn,
			'f_date' => $f_date,
			't_date' => $t_date,
			'return_value' => $result,
			'p_data_cursor' => $p_data_cursor,
			'description' => $description,
			'curs' => $entry,
            'title' => "Tra cứu giao dịch hoàn ứng"
        );
        $this->view->assign('search/giao_dich_hoan_ung', $data, $this->layoutAdmin);
    }
	
	public function tra_cuu_noAction(){
		
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        } 
		
		$msisdn = $this->_arrParams['msisdn'];
		
		$sql = 'BEGIN :v_Return := PKG_QUERY.FUNC_QUERY_DEBT(:P_MSISDN, :P_DATA_CURSOR, :P_OUT); END;';
		$this->model->con();
		$stmt = oci_parse($this->model->conn_handle,$sql);
		$curs = oci_new_cursor($this->model->conn_handle);
		
		oci_bind_by_name($stmt,':P_MSISDN', $msisdn, 20);
		oci_bind_by_name($stmt,':P_DATA_CURSOR', $curs, -1, OCI_B_CURSOR);
		oci_bind_by_name($stmt,':P_OUT', $description, 255);
		oci_bind_by_name($stmt,':v_Return', $result, 5);
		oci_execute($stmt);
		oci_execute($curs);
		
		$entry = oci_fetch_object($curs);
		//print_r($entry);
        $data = array(
			'msisdn' => $msisdn,
			'return_value' => $result,
			'p_data_cursor' => $p_data_cursor,
			'description' => $description,
			'curs' => $entry,
            'title' => "Tra cứu nợ"
        );

        $this->view->assign('search/tra_cuu_no', $data, $this->layoutAdmin);
    }

	// Ong code tiep 4 ham duoi nay nhe.!
    public function danh_sach_blacklistAction()
    {
        #ini_set('display_errors', 1);

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $msisdn = $this->_arrParams['msisdn'];
        $sql = 'BEGIN :v_Return := pkg_query.FUNC_QUERY_BLACKLIST(:P_MSISDN, :P_DATA_CURSOR, :P_OUT); END;';
        $this->model->con();
        $stmt = oci_parse($this->model->conn_handle, $sql);
        oci_bind_by_name($stmt, ':P_MSISDN', $msisdn, 20);
        $p_data_cursor = oci_new_cursor($this->model->conn_handle);
        oci_bind_by_name($stmt, ':P_DATA_CURSOR', $p_data_cursor, -1, OCI_B_CURSOR);

        oci_bind_by_name($stmt, ':P_OUT', $description, 255);
        oci_bind_by_name($stmt, ':v_Return', $result, 5);
        oci_execute($stmt);
        oci_execute($p_data_cursor);
        if ($entry = oci_fetch_array($p_data_cursor)) {
            $date = strtotime($entry['CREATE_DATE']);
            $cDate = date('d-m-Y', $date);


            $data = array(
                'title' => "Tra cứu Blacklist",
                'msisdn' => $msisdn,
                'createdate' => $cDate,
                'reason' => $entry['REASON_CODE'],
                'reasonname' => (strtolower($entry['REASON_NAME']) == 'n/a' || empty($entry['REASON_NAME'])) ? "" : $entry['REASON_NAME'],
                'status' => ((int)$entry['STATUS'] == 1) ? "Còn hiệu lực" : "Hết hiệu lực",
                'return_value' => $result,
                'description' => $description
            );
        } else $data = array(
            'title' => "Tra cứu Blacklist",
            'msisdn' => $msisdn,
            'return_value' => $result,
            'description' => $description
        );

        $this->view->assign('search/danh_sach_blacklist', $data, $this->layoutAdmin);
    }
	
	public function thong_tin_thue_baoAction(){
        if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        #ini_set('display_errors', 1);
        $msisdn = $this->_arrParams['msisdn'];
        $sql = 'BEGIN :v_Return := pkg_query.FUNC_QUERY_SUBS_INF(:P_MSISDN, :P_DATA_CURSOR, :P_OUT); END;';
        $this->model->con();
        $stmt = oci_parse($this->model->conn_handle,$sql);
        oci_bind_by_name($stmt,':P_MSISDN', $msisdn, 20);
        $p_data_cursor = oci_new_cursor($this->model->conn_handle);
        oci_bind_by_name($stmt,':P_DATA_CURSOR', $p_data_cursor, -1, OCI_B_CURSOR);

        oci_bind_by_name($stmt,':P_OUT', $description, 255);
        oci_bind_by_name($stmt,':v_Return', $result, 5);
        oci_execute($stmt);
        oci_execute($p_data_cursor);
        if ($entry = oci_fetch_array($p_data_cursor)) {
            $data = array(
                'title' => "Tra cứu thông tin thuê bao",
                'msisdn' => $msisdn,
                'sub_id' => $entry['SUB_ID'],
                'last_active_date' => $this->convertDateDMY($entry['LAST_ACTIVE_DATE']),
                'deactive_date' => $this->convertDateDMY($entry['DEACTIVE_DATE']),
                'status' => ((int)$entry['STATUS'] == 1) ? "Đang active" : "Đã hủy",
                'return_value' => $result,
                'description' => $description
            );
        }else $data = array(
            'title' => "Tra cứu thông tin thuê bao",
            'msisdn' => $msisdn,
            'description' => $description
        );
		$this->view->assign('search/thong_tin_thue_bao', $data, $this->layoutAdmin);
    }
	
	public function trang_thai_the_caoAction(){
		if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        #ini_set('display_errors', 1);
        $msisdn = $this->_arrParams['msisdn'];
        $sql = 'BEGIN :v_Return := PKG_QUERY.FUNC_QUERY_CARD_STORE(:P_SERIAL, :P_DATA_CURSOR, :P_OUT); END;';
        $this->model->con();
        $stmt = oci_parse($this->model->conn_handle,$sql);
        oci_bind_by_name($stmt,':P_SERIAL', $msisdn, 20);
        $p_data_cursor = oci_new_cursor($this->model->conn_handle);
        oci_bind_by_name($stmt,':P_DATA_CURSOR', $p_data_cursor, -1, OCI_B_CURSOR);

        oci_bind_by_name($stmt,':P_OUT', $description, 255);
        oci_bind_by_name($stmt,':v_Return', $result, 5);
        oci_execute($stmt);
        oci_execute($p_data_cursor);
        if ($entry = oci_fetch_array($p_data_cursor)) {
            $status="n/a";
            if((int)$entry['STATUS'] == 0) $status= "Sẵn sàng sử dụng";
            if((int)$entry['STATUS'] == 1) $status= "Đã sử dụng";
            if((int)$entry['STATUS'] == 2) $status= "<p style='font-weight:bold;color:red;'>Tạm giữ thẻ</p>";
            if((int)$entry['STATUS'] == 3) $status= "Được tái sử dụng";
            if((int)$entry['STATUS'] == 4) $status= "Hủy bỏ không sử dụng";
            $data = array(
                'title' => "Tra cứu thông tin thẻ cào",
                'serial' => $msisdn,
                'card_id' => $entry['CARD_ID'],
                'card_amount' => $entry['CARD_AMOUNT'],
                'create_date' => $this->convertDateDMY($entry['CREATE_DATE']),
                'status' => $status,
                'return_value' => $result,
                'description' => $description
            );
        }else $data = array(
            'title' => "Tra cứu thông tin thẻ cào",
            'msisdn' => $msisdn,
            'description' => $description
        );
		$this->view->assign('search/trang_thai_the_cao', $data, $this->layoutAdmin);
    }
	
	public function sms_logAction(){
        /*
        if(!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }*/
        //ini_set('display_errors', 1);
        $msisdn = $this->_arrParams['msisdn'];
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : date("Y-m-d");
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : date("Y-m-d");

        $str_fdate = strtotime($f_date);
        $str_tdate = strtotime($t_date);
        $fdate = date('d-M-y', $str_fdate);
        $tdate = date('d-M-y', $str_tdate);
        $sql = 'BEGIN :v_Return := PKG_QUERY.FUNC_QUERY_SMS_LOG(:P_MSISDN, :F_DATE, :T_DATE, :P_DATA_CURSOR, :P_OUT); END;';
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
        //var_dump(array($result,$description));
        if ($entry = oci_fetch_array($curs)) { var_dump($entry);
            $status="n/a";
            if((int)$entry['STATUS'] == 0) $status= "Sẵn sàng sử dụng";
            if((int)$entry['STATUS'] == 1) $status= "Đã sử dụng";
            if((int)$entry['STATUS'] == 2) $status= "<p style='font-weight:bold;color:red;'>Tạm giữ thẻ</p>";
            if((int)$entry['STATUS'] == 3) $status= "Được tái sử dụng";
            if((int)$entry['STATUS'] == 4) $status= "Hủy bỏ không sử dụng";
            $data = array(
                'title' => "Tra cứu thông tin SMS",
                'msisdn' => $msisdn,
                'sms' => $entry['SMS'],
                'f_date' => $fdate,
                't_date' => $tdate,
                'sent_time' => $this->convertDateDMY($entry['SENT_TIME']),
                'response_time' => $this->convertDateDMY($entry['RESPONSE_TIME']),
                'deliver_time' => $this->convertDateDMY($entry['DELIVER_TIME']),
                'sms_id' => $entry['SMS_ID'],
                'submit_status' =>$entry['SUBMIT_STATUS'],
                'deliver_status' => $entry['DELIVER_STATUS'],
                'return_value' => $result,
                'description' => $description
            );
        }else $data = array(
            'title' => "Tra cứu thông tin SMS",
            'f_date' => $fdate,
            't_date' => $tdate,
            'msisdn' => $msisdn,
            'return_value' => $result,
            'description' => $description
        );
		$this->view->assign('search/sms_log', $data, $this->layoutAdmin);
    }
    public function convertDateDMY($date){
	    if(empty($date)) return '';
        return date('d-m-Y', strtotime($date));
    }
    public function convertCurrency($amount){

    }
}








