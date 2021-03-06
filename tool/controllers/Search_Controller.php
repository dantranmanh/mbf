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

class Search_Controller extends Core_Controller
{

    protected $layoutDefault;
    protected $layoutAdmin;

    public function __construct()
    {
        parent::__construct();

        $this->layoutDefault = "default";
        $this->layoutAdmin = "admin";

        $this->model = new Core_Model();

        $this->controller = $this->getClassMethod("controller");
        $this->action = $this->getClassMethod("action");

        if (!Core_Login::getLoginSession()) {
            $this->_redirect($this->baseUrl . 'login');
        }

        $this->acl = new Core_Acl();
    }

    public function muc_the_ungAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $collection = array();
        $description = "";
        $result = null;
        $title = "Tra cứu mức thẻ ứng áp dụng cho thuê bao";

        $msisdn = $this->_arrParams['msisdn'];
        $first = substr($msisdn,0,1);
        if($msisdn && $first == '0'){
            $msisdn = substr($msisdn,1);
        }
        $sql = 'BEGIN :v_Return := pkg_query.FUNC_QUERY_SATISFY_CARD(:P_MSISDN, :P_SATISFY_CARD_AMOUNT, :P_OUT); END;';
        $this->model->con();
        $stmt = oci_parse($this->model->conn_handle, $sql);
        oci_bind_by_name($stmt, ':P_MSISDN', $msisdn, 20);
        oci_bind_by_name($stmt, ':P_SATISFY_CARD_AMOUNT', $amount, 30);
        oci_bind_by_name($stmt, ':P_OUT', $description, 255);
        oci_bind_by_name($stmt, ':v_Return', $result, 5);
        oci_execute($stmt);
        $this->model->FreeStatement($stmt);

        $entry = array('amount' => ($amount) ? ($amount) : 0);
        $collection = array();
        if(!empty($msisdn)) $collection[] = $entry;

        $data = array(
            'msisdn' => $msisdn,
            'return_value' => $result,
            'collection' => $collection,
            'description' => $description,
            'title' => $title
        );
        $this->view->assign('search/muc_the_ung', $data, $this->layoutAdmin);
    }

    public function giao_dich_ung_theAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $collection = array();
        $description = "";
        $result = null;
        $title = "Tra cứu giao dịch ứng thẻ";

        $msisdn = $this->_arrParams['_msisdn'];
        $serial = $this->_arrParams['serial'];
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {
            $str_fdate = strtotime($f_date);
            $str_tdate = strtotime($t_date);
            $fdate = date('d-M-Y', $str_fdate);
            $tdate = date('d-M-Y', $str_tdate);
            $sql = 'BEGIN :v_Return := pkg_query.FUNC_QUERY_CREDIT_TRANS(:P_MSISDN, :CARD_SERIAL, :F_DATE, :T_DATE, :P_DATA_CURSOR, :P_OUT); END;';
            $this->model->con();
            //$this->updateDateFormatForCurrentSession();
            $stmt = oci_parse($this->model->conn_handle, $sql);
            $curs = oci_new_cursor($this->model->conn_handle);
            //echo $f_date;
            oci_bind_by_name($stmt, ':P_MSISDN', $msisdn, 20);
            oci_bind_by_name($stmt, ':F_DATE', $fdate, 20);
            oci_bind_by_name($stmt, ':T_DATE', $tdate, 20);
            oci_bind_by_name($stmt, ':CARD_SERIAL', $serial, 20);
            oci_bind_by_name($stmt, ':P_DATA_CURSOR', $curs, -1, OCI_B_CURSOR);
            oci_bind_by_name($stmt, ':P_OUT', $description, 255);
            oci_bind_by_name($stmt, ':v_Return', $result, 5);
            oci_execute($stmt);
            oci_execute($curs);
            $this->model->FreeStatement($stmt);

            while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                if (count($row) < 1) continue;
                $collection[] = $row;
            }
        } else {
            $description = "Thông tin ngày tháng không hợp lệ.";
            $result = null;
        }
        //echo "<pre>";
        //print_r($collection);
        //echo "</pre>";

        $data = array(
            'msisdn' => $msisdn,
            'f_date' => $f_date,
            't_date' => $t_date,
            'serial' => $serial,
            'return_value' => $result,
            'collection' => $collection,
            'description' => $description,
            'curs' => $entry,
            'title' => $title
        );
        $this->view->assign('search/giao_dich_ung_the', $data, $this->layoutAdmin);
    }

    public function giao_dich_hoan_ungAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $collection = array();
        $description = "";
        $result = null;
        $title = "Tra cứu giao dịch hoàn ứng";
        $msisdn = $this->_arrParams['msisdn'];

        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;

        if ($f_date && $t_date) {
            $str_fdate = strtotime($f_date);
            $str_tdate = strtotime($t_date);
            $fdate = date('d-m-Y H:i:s', $str_fdate);
            $tdate = date('d-m-Y H:i:s', $str_tdate);

            $sql = 'BEGIN :v_Return := PKG_QUERY.FUNC_QUERY_PAYMENT_TRANS(:P_MSISDN, :F_DATE, :T_DATE, :P_DATA_CURSOR, :P_OUT); END;';
            $this->model->con();
            //$this->updateDateFormatForCurrentSession();
            $stmt = oci_parse($this->model->conn_handle, $sql);
            $curs = oci_new_cursor($this->model->conn_handle);

            oci_bind_by_name($stmt, ':P_MSISDN', $msisdn, 20);
            oci_bind_by_name($stmt, ':F_DATE', $fdate, 20);
            oci_bind_by_name($stmt, ':T_DATE', $tdate, 20);
            oci_bind_by_name($stmt, ':P_DATA_CURSOR', $curs, -1, OCI_B_CURSOR);
            oci_bind_by_name($stmt, ':P_OUT', $description, 255);
            oci_bind_by_name($stmt, ':v_Return', $result, 5);
            oci_execute($stmt);
            oci_execute($curs);
            $this->model->FreeStatement($stmt);

            while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                if (count($row) < 1) continue;
                $collection[] = $row;
            }
        } else {
            $description = "Thông tin ngày tháng không hợp lệ.";
            $result = null;
        }

        $data = array(
            'msisdn' => $msisdn,
            'f_date' => $f_date,
            't_date' => $t_date,
            'return_value' => $result,
            'collection' => $collection,
            'description' => $description,
            'title' => $title
        );
        $this->view->assign('search/giao_dich_hoan_ung', $data, $this->layoutAdmin);
    }

    public function tra_cuu_noAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $collection = array();
        $description = "";
        $result = null;
        $title = "Tra cứu nợ";

        $msisdn = $this->_arrParams['msisdn'];

        $sql = 'BEGIN :v_Return := PKG_QUERY.FUNC_QUERY_DEBT(:P_MSISDN, :P_DATA_CURSOR, :P_OUT); END;';
        $this->model->con();
        //$this->updateDateFormatForCurrentSession();
        $stmt = oci_parse($this->model->conn_handle, $sql);
        $curs = oci_new_cursor($this->model->conn_handle);

        oci_bind_by_name($stmt, ':P_MSISDN', $msisdn, 20);
        oci_bind_by_name($stmt, ':P_DATA_CURSOR', $curs, -1, OCI_B_CURSOR);
        oci_bind_by_name($stmt, ':P_OUT', $description, 255);
        oci_bind_by_name($stmt, ':v_Return', $result, 5);
        oci_execute($stmt);
        oci_execute($curs);
        $this->model->FreeStatement($stmt);

        $collection = array();
        while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            if (count($row) < 1) continue;
            $collection[] = $row;
        }
        //echo "<pre>";
        //print_r($collection);
        //echo "</pre>";
        $data = array(
            'msisdn' => $msisdn,
            'return_value' => $result,
            'collection' => $collection,
            'description' => $description,
            'title' => $title
        );

        $this->view->assign('search/tra_cuu_no', $data, $this->layoutAdmin);
    }


    public function danh_sach_blacklistAction()
    {
        //ini_set('display_errors', 1);
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $collection = array();
        $description = "";
        $result = null;
        $title = "Tra cứu Blacklist";


        $msisdn = $this->_arrParams['msisdn'];
        $sql = 'BEGIN :v_Return := pkg_query.FUNC_QUERY_BLACKLIST(:P_MSISDN, :P_DATA_CURSOR, :P_OUT); END;';
        $this->model->con();
        //$this->updateDateFormatForCurrentSession();
        $stmt = oci_parse($this->model->conn_handle, $sql);
        oci_bind_by_name($stmt, ':P_MSISDN', $msisdn, 20);
        $p_data_cursor = oci_new_cursor($this->model->conn_handle);
        oci_bind_by_name($stmt, ':P_DATA_CURSOR', $p_data_cursor, -1, OCI_B_CURSOR);
        oci_bind_by_name($stmt, ':P_OUT', $description, 255);
        oci_bind_by_name($stmt, ':v_Return', $result, 5);
        oci_execute($stmt);
        oci_execute($p_data_cursor);
        $this->model->FreeStatement($stmt);

        $collection = array();
        while (($row = oci_fetch_array($p_data_cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            if (count($row) < 1) continue;
            $collection[] = $row;
        }

        $data = array(
            'msisdn' => $msisdn,
            'return_value' => $result,
            'collection' => $collection,
            'description' => $description,
            'title' => $title
        );

        $this->view->assign('search/danh_sach_blacklist', $data, $this->layoutAdmin);
    }

    public function thong_tin_thue_baoAction()
    {
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $collection = array();
        $description = "";
        $result = null;
        $title = "Tra cứu thông tin thuê bao";

        $msisdn = $this->_arrParams['msisdn'];
        $sql = 'BEGIN :v_Return := pkg_query.FUNC_QUERY_SUBS_INF(:P_MSISDN, :P_DATA_CURSOR, :P_OUT); END;';
        $this->model->con();
        //$this->updateDateFormatForCurrentSession();
        $stmt = oci_parse($this->model->conn_handle, $sql);
        oci_bind_by_name($stmt, ':P_MSISDN', $msisdn, 20);
        $p_data_cursor = oci_new_cursor($this->model->conn_handle);
        oci_bind_by_name($stmt, ':P_DATA_CURSOR', $p_data_cursor, -1, OCI_B_CURSOR);

        oci_bind_by_name($stmt, ':P_OUT', $description, 255);
        oci_bind_by_name($stmt, ':v_Return', $result, 5);
        oci_execute($stmt);
        oci_execute($p_data_cursor);
        $this->model->FreeStatement($stmt);

        $collection = array();
        while (($row = oci_fetch_array($p_data_cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            if (count($row) < 1) continue;
            $collection[] = $row;
        }
        //var_dump($collection);
        $data = array(
            'title' => $title,
            'msisdn' => $msisdn,
            'collection' => $collection,
            'return_value' => $result,
            'description' => $description
        );
        $this->view->assign('search/thong_tin_thue_bao', $data, $this->layoutAdmin);
    }

    public function trang_thai_the_caoAction()
    {
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        #ini_set('display_errors', 1);
        $collection = array();
        $description = "";
        $result = null;
        $title = "Tra cứu thông tin thẻ cào";

        $msisdn = $this->_arrParams['msisdn'];
        $sql = 'BEGIN :v_Return := PKG_QUERY.FUNC_QUERY_CARD_STORE(:P_SERIAL, :P_DATA_CURSOR, :P_OUT); END;';
        $this->model->con();
        //$this->updateDateFormatForCurrentSession();
        $stmt = oci_parse($this->model->conn_handle, $sql);
        oci_bind_by_name($stmt, ':P_SERIAL', $msisdn, 20);
        $p_data_cursor = oci_new_cursor($this->model->conn_handle);
        oci_bind_by_name($stmt, ':P_DATA_CURSOR', $p_data_cursor, -1, OCI_B_CURSOR);

        oci_bind_by_name($stmt, ':P_OUT', $description, 255);
        oci_bind_by_name($stmt, ':v_Return', $result, 5);
        oci_execute($stmt);
        oci_execute($p_data_cursor);
        $this->model->FreeStatement($stmt);

        $collection = array();
        while (($row = oci_fetch_array($p_data_cursor, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            if (count($row) < 1) continue;
            $collection[] = $row;
        }
        //var_dump($collection);
        $data = array(
            'title' => $title,
            'msisdn' => $msisdn,
            'collection' => $collection,
            'return_value' => $result,
            'description' => $description
        );
        $this->view->assign('search/trang_thai_the_cao', $data, $this->layoutAdmin);
    }

    public function sms_logAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $collection = array();
        $description = "";
        $result = null;
        $title = "Tra cứu thông tin SMS";

        $msisdn = $this->_arrParams['msisdn'];
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {
            $str_fdate = strtotime($f_date);
            $str_tdate = strtotime($t_date);
            $fdate = date('d-m-Y H:i:s', $str_fdate);
            $tdate = date('d-m-Y H:i:s', $str_tdate);
            $sql = 'BEGIN :v_Return := PKG_QUERY.FUNC_QUERY_SMS_LOG(:P_MSISDN, :F_DATE, :T_DATE, :P_DATA_CURSOR, :P_OUT); END;';
            $this->model->con();
            //$this->updateDateFormatForCurrentSession();
            $stmt = oci_parse($this->model->conn_handle, $sql);
            $curs = oci_new_cursor($this->model->conn_handle);

            oci_bind_by_name($stmt, ':P_MSISDN', $msisdn, 20);
            oci_bind_by_name($stmt, ':F_DATE', $fdate, 20);
            oci_bind_by_name($stmt, ':T_DATE', $tdate, 20);
            oci_bind_by_name($stmt, ':P_DATA_CURSOR', $curs, -1, OCI_B_CURSOR);
            oci_bind_by_name($stmt, ':P_OUT', $description, 255);
            oci_bind_by_name($stmt, ':v_Return', $result, 5);
            oci_execute($stmt);
            oci_execute($curs);
            $this->model->FreeStatement($stmt);
            while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                if (count($row) < 1) continue;
                $collection[] = $row;
            }
        }else{
            $description = "Thông tin ngày tháng không hợp lệ.";
            $result = null;
        }

        //echo "<pre>";
        //print_r($collection);
        //echo "</pre>";

        //var_dump($collection);
        $data = array(
            'title' => $title,
            'msisdn' => $msisdn,
            'f_date' => $this->_arrParams['f_date'],
            't_date' => $this->_arrParams['t_date'],
            'collection' => $collection,
            'return_value' => $result,
            'description' => $description
        );
        $this->view->assign('search/sms_log', $data, $this->layoutAdmin);
    }

    public function tra_cuu_lich_su_nap_theAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $collection = array();
        $description = "";
        $result = null;
        $title = "Tra cứu lịch sử nạp thẻ";

        $msisdn = $this->_arrParams['_msisdn'];

        $P_IMSI = $this->_arrParams['imsi'];
        $P_CARD_NUMBER = $this->_arrParams['mathe'];
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;

        //print_r($this->_arrParams);
        if ($f_date && $t_date) {
            $str_fdate = strtotime($f_date);
            $str_tdate = strtotime($t_date);
            $fdate = date('d-m-Y H:i:s', $str_fdate);
            $tdate = date('d-m-Y H:i:s', $str_tdate);
            //function func_query_refill_his(p_msisdn varchar2,p_imsi varchar2, p_card_number varchar2,f_date date,t_date date,p_data_cursor out SYS_REFCURSOR, p_out out varchar2) return number;
            $sql = 'BEGIN :v_Return := PKG_QUERY.FUNC_QUERY_REFILL_HIS(:P_MSISDN, :P_IMSI, :P_CARD_NUMBER, :F_DATE, :T_DATE, :P_DATA_CURSOR, :P_OUT); END;';
            $this->model->con();
            $stmt = oci_parse($this->model->conn_handle, $sql);
            $curs = oci_new_cursor($this->model->conn_handle);

            oci_bind_by_name($stmt, ':P_MSISDN', $msisdn, 20);
            oci_bind_by_name($stmt, ':P_IMSI', $P_IMSI, 20);
            oci_bind_by_name($stmt, ':P_CARD_NUMBER', $P_CARD_NUMBER, 20);
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
        //print_r($collection);
        //echo "</pre>";

        //var_dump($collection);
        $data = array(
            'title' => $title,
            'msisdn' => $msisdn,
            'imsi' => $P_IMSI,
            'mathe' => $P_CARD_NUMBER,
            'f_date' => $this->_arrParams['f_date'],
            't_date' => $this->_arrParams['t_date'],
            'collection' => $collection,
            'return_value' => $result,
            'description' => $description
        );

        $this->view->assign('search/tra_cuu_lich_su_nap_the', $data, $this->layoutAdmin);
    }
    public function tra_cuu_lich_su_gui_sms_ma_theAction()
    {
        //ini_set('display_errors', 1);
        $collection = array();
        $description = "";
        $result = null;
        $title = "Tra cứu lịch sử gửi SMS mã thẻ";

        $requestid = $this->_arrParams['_requestid'];
        $requestid = str_replace("ut","",strtolower($requestid));
        $msisdn = $this->convertNumberToVN($this->_arrParams['_msisdn']);

        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {
            $str_fdate = strtotime($f_date);
            $str_tdate = strtotime($t_date);
            $fdate = date('d-m-Y H:i:s', $str_fdate);
            $tdate = date('d-m-Y H:i:s', $str_tdate);
            //function func_query_mt2_log(p_requestID varchar2,p_msisdn varchar2,f_date date,t_date date,p_data_cursor out SYS_REFCURSOR, p_out out varchar2) return number
            $sql = 'BEGIN :v_Return := PKG_QUERY.func_query_mt2_log(:P_REQUESTID, :P_MSISDN,  :F_DATE, :T_DATE, :P_DATA_CURSOR, :P_OUT); END;';
            $this->model->con();
            $stmt = oci_parse($this->model->conn_handle, $sql);
            $curs = oci_new_cursor($this->model->conn_handle);

            oci_bind_by_name($stmt, ':P_REQUESTID', $requestid, 20);
            oci_bind_by_name($stmt, ':P_MSISDN', $msisdn, 20);
            oci_bind_by_name($stmt, ':F_DATE', $fdate, 20);
            oci_bind_by_name($stmt, ':T_DATE', $tdate, 20);
            oci_bind_by_name($stmt, ':P_DATA_CURSOR', $curs, -1, OCI_B_CURSOR);
            oci_bind_by_name($stmt, ':P_OUT', $description, 255);
            oci_bind_by_name($stmt, ':v_Return', $result, 5);
            oci_execute($stmt);
            oci_execute($curs);
            $this->model->FreeStatement($stmt);
            while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                if (count($row) < 1) continue;
                $collection[] = $row;
            }
        }else{
            $description = "Thông tin ngày tháng không hợp lệ.";
            $result = null;
        }

        $data = array(
            'title' => $title,
            'msisdn' => $msisdn,
            '_requestid' => $requestid,
            'f_date' => $this->_arrParams['f_date'],
            't_date' => $this->_arrParams['t_date'],
            'collection' => $collection,
            'return_value' => $result,
            'description' => $description
        );

        $this->view->assign('search/tra_cuu_lich_su_gui_sms_ma_the', $data, $this->layoutAdmin);
    }

    /**
     * @param $num
     * @return bool|void
     */
    public function convertNumberToVN($num)
    {
        if(empty($num)) return false;
        $second = substr($num,0,2);
        if($second === "84"){
            return $num;
        }
        $first = substr($num,0,1);
        if($first == '0'){
            return "84".substr($num,1);
        }
        return false;
    }
    public function convertCurrency($amount)
    {

    }
}








