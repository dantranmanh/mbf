<?php

/**
 * Report_Controller.php
 *
 * Report_Controller class
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

class Statistics_Controller extends Core_Controller
{
    protected $layoutDefault;
    protected $layoutAdmin;
    protected $model;
    public function __construct()
    {
        parent::__construct();

        $this->layoutDefault = "default";
        $this->layoutAdmin = "admin";

        $this->controller = $this->getClassMethod("controller");
        $this->action = $this->getClassMethod("action");

        if (!Core_Login::getLoginSession()) {
            $this->_redirect($this->baseUrl . 'login');
        }

        $this->acl = new Core_Acl();
    }

    public function thong_ke_tien_no_xauAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $title = "Thống kê và đối chiếu tiền nợ xấu";
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {

            $deadLine = date('d-m-Y', strtotime('+1 month', strtotime($f_date)));
            $lastDeadline = date('t',strtotime($deadLine));
            $deadLineDate = $lastDeadline."-".date('m-Y', strtotime('+1 month', strtotime($f_date)));

            $model = new Statistics_Model();
            $data = $model->thong_ke_tien_no_xau($f_date,$t_date);
            $debt = $model->generateChartDataColumn($data);
            $data = array(
                'title' => $title,
                'chartdata'=> $debt,
                'deadline'  => $deadLineDate,
                'total'  => $data,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date']
            );
        }else{
            $description = "Thông tin ngày tháng không hợp lệ.";
            $data = array(
                'description' => $description,
                'title' => $title,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date']
            );
        }
        $this->view->assign('statistics/thong_ke_tien_no_xau', $data, $this->layoutAdmin);
    }
    public function thong_ke_sl_giao_dich_no_xauAction(){
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $title = "Thống kê và đối chiếu số lượng giao dịch nợ xấu";
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {
            $deadLine = date('d-m-Y', strtotime('+1 month', strtotime($f_date)));
            $lastDeadline = date('t',strtotime($deadLine));
            $deadLineDate = $lastDeadline."-".date('m-Y', strtotime('+1 month', strtotime($f_date)));

            $model = new Statistics_Model();
            $data = $model->thong_ke_sl_giao_dich_no_xau($f_date,$t_date);
            $debt = $model->generateChartDataColumn($data);
            $data = array(
                'title' => $title,
                'chartdata'=> $debt,
                'deadline'  => $deadLineDate,
                'total'  => $data,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date']
            );
        }else{
            $description = "Thông tin ngày tháng không hợp lệ.";
            $data = array(
                'description' => $description,
                'title' => $title,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date']
            );
        }

        $this->view->assign('statistics/thong_ke_sl_giao_dich_no_xau', $data, $this->layoutAdmin);
    }
    public function thong_ke_ty_le_giao_dich_no_xauAction(){
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $title = "Thống kê và đối chiếu tỷ lệ giao dịch nợ xấu";
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {

            $model = new Statistics_Model();
            $data = $model->thong_ke_ty_le_giao_dich_no_xau($f_date,$t_date);
            $debt = $model->generateChartDataColumn_tyle($data);
            $data = array(
                'title' => $title,
                'total'=> $data,
                'chartdata'=> $debt,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date']
            );
        }else{
            $description = "Thông tin ngày tháng không hợp lệ.";
            $data = array(
                'description' => $description,
                'title' => $title,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date']
            );
        }

        $this->view->assign('statistics/thong_ke_ty_le_giao_dich_no_xau', $data, $this->layoutAdmin);
    }
    public function thong_ke_ty_le_sl_giao_dich_no_xauAction(){
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $title = "Thống kê và đối chiếu tỷ lệ số lượng giao dịch nợ xấu";
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {

            $model = new Statistics_Model();
            $data = $model->thong_ke_ty_le_sl_giao_dich_no_xau($f_date,$t_date);
            $debt = $model->generateChartDataColumn_tyle($data);
            $data = array(
                'title' => $title,
                'chartdata'=> $debt,
                'total'=> $data,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date']
            );
        }else{
            $description = "Thông tin ngày tháng không hợp lệ.";
            $data = array(
                'description' => $description,
                'title' => $title,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date']
            );
        }

        $this->view->assign('statistics/thong_ke_ty_le_sl_giao_dich_no_xau', $data, $this->layoutAdmin);
    }
    public function thong_ke_no_xau_moi_ngayAction()
    {
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $title = "Thống kê và đối chiếu nợ xấu của các giao dịch từng ngày";
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {
            $t_date = $t_date." 23:59:59";
            $description = "";
            $result = null;

            $str_fdate = strtotime($f_date);
            $str_tdate = strtotime($t_date);
            $fdate = date('d-m-Y', $str_fdate);
            $tdate = date('d-m-Y', $str_tdate);

            $model = new Statistics_Model();
            $data = $model->thong_ke_no_xau_moi_ngay($fdate,$tdate);
            $debt = $model->generateChartDataColumn($data);
            $data = array(
                'description' => $description,
                'title' => $title,
                'chartdata'=> $debt,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date']
            );

        } else {
            $result = null;
            $data = array(
                'description' => $description,
                'title' => $title
            );
        }
        $this->view->assign('statistics/thong_ke_no_xau_moi_ngay', $data, $this->layoutAdmin);
    }


    public function thong_ke_sl_no_xau_moi_ngayAction()
    {
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $title = "Thống kê và đối chiếu số lượng giao dịch nợ xấu từng ngày";
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {

            $model = new Statistics_Model();
            $data = $model->thong_ke_sl_no_xau_moi_ngay($f_date,$t_date);
            $debt = $model->generateChartDataColumn($data);
            //var_dump($debt);die;
            //var_dump($xAxis);
            $data = array(
                'description' => $description,
                'title' => $title,
                'chartdata'=> $debt,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date']
            );

        } else {
            $result = null;
            $data = array(
                'description' => $description,
                'title' => $title
            );
        }
        $this->view->assign('statistics/thong_ke_sl_no_xau_moi_ngay', $data, $this->layoutAdmin);
    }

}








