<?php

/**
 * App_Controller.php
 *
 * App_Controller class
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

class App_Controller extends Core_Controller
{

    protected $layoutDefault;
    protected $layoutAdmin;

    public function __construct()
    {
        parent::__construct();

        $this->layoutDefault = "default";
        $this->layoutAdmin = "admin";
		
		$this->model = new Core_Model();
		$this->LoadModel('App');
		$this->AppModel = new App_Model();
		
        $this->controller = $this->getClassMethod("controller");
        $this->action = $this->getClassMethod("action");

        if (!Core_Login::getLoginSession()) {
            $this->_redirect($this->baseUrl . 'login');
        }

        $this->acl = new Core_Acl();
    }
	
	public function lich_su_chay_tong_hop_bao_caoAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $collection = array();
        $description = "";
        $result = null;
        $title = "Tra cứu lịch sử chạy tổng hợp báo cáo";
		$report_type = $this->AppModel->getDef_sum_report();

		$p_reportID = $this->_arrParams['p_reportID'];
		
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {
            $str_fdate = strtotime($f_date);
            $str_tdate = strtotime($t_date);
            $fdate = date('d-m-Y H:i:s', $str_fdate);
            $tdate = date('d-m-Y H:i:s', $str_tdate);

			//function func_query_run_report_log(p_reportID varchar2,f_date date,t_date date,p_data_cursor out SYS_REFCURSOR, p_out out varchar2) return number
            $sql = 'BEGIN :v_Return := PKG_QUERY.FUNC_QUERY_RUN_REPORT_LOG(:P_REPORTID, :F_DATE, :T_DATE, :P_DATA_CURSOR, :P_OUT); END;';
            $this->model->con();
            $stmt = oci_parse($this->model->conn_handle, $sql);
            $curs = oci_new_cursor($this->model->conn_handle);

            oci_bind_by_name($stmt, ':P_REPORTID', $p_reportID, 20);
            oci_bind_by_name($stmt, ':F_DATE', $fdate, 20);
            oci_bind_by_name($stmt, ':T_DATE', $tdate, 20);
            oci_bind_by_name($stmt, ':P_DATA_CURSOR', $curs, -1, OCI_B_CURSOR);
            oci_bind_by_name($stmt, ':P_OUT', $description, 255);
            oci_bind_by_name($stmt, ':v_Return', $result, 5);
            oci_execute($stmt);
            oci_execute($curs);
		
			$this->model->FreeStatement($stmt);
			//var_dump($result);
            while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                if (count($row) < 1) continue;
                $collection[] = $row;
            }
        }else{
            $description = "Thông tin ngày tháng không hợp lệ.";
            $result = null;
        }
		
		//echo "<pre>";
		///print_r($collection);
		//echo "</pre>";
		
        $data = array(
            'title' => $title,
			'report_type' => $report_type,
            'p_reportID' => $p_reportID,
            'f_date' => $this->_arrParams['f_date'],
            't_date' => $this->_arrParams['t_date'],
            'collection' => $collection,
            'return_value' => $result,
            'description' => $description
        );
        $this->view->assign('app/lich_su_chay_tong_hop_bao_cao', $data, $this->layoutAdmin);
    }
}








