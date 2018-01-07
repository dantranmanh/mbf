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
    /*public function bieu_do_no_xauAction()
    {
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {
            $t_date = $t_date." 23:59:59";
            $description = "";
            $result = null;
            $title = "Biểu đồ giao dịch tạo nợ xấu theo ngày";

            $str_fdate = strtotime($f_date);
            $str_tdate = strtotime($t_date);
            $fdate = date('d-m-Y', $str_fdate);
            $tdate = date('d-m-Y', $str_tdate);

            $model = new Statistics_Model();
            $debtAll = $model->getBadDebtEachDate($fdate,$tdate,0);
            $debt10k = $model->getBadDebtEachDate($fdate,$tdate,'10000');
            //var_dump($debt10k);
            if($debt10k == "31dayslimitted"){
                $data = array(
                    'description' => "Hệ thống giới hạn xem thống kê trong vòng 31 ngày.Hãy chọn lại số ngày dưới 31!",
                    'title' => $title,
                    'f_date' => $this->_arrParams['f_date'],
                    't_date' => $this->_arrParams['t_date']
                );
            }else{
                $debt20k = $model->getBadDebtEachDate($fdate,$tdate,'20000');
                $debt30k = $model->getBadDebtEachDate($fdate,$tdate,'30000');
                $debt50k = $model->getBadDebtEachDate($fdate,$tdate,'50000');
                $debt100k = $model->getBadDebtEachDate($fdate,$tdate,'100000');
                $debt200k = $model->getBadDebtEachDate($fdate,$tdate,'200000');
                $debt500k = $model->getBadDebtEachDate($fdate,$tdate,'500000');

                $dataAll = $model->generateChartData($debtAll);
                $data10k = $model->generateChartData($debt10k);
                //var_dump($data10k);die;


                $data20k = $model->generateChartData($debt20k);
                $data30k = $model->generateChartData($debt30k);
                $data50k = $model->generateChartData($debt50k);
                $data100k = $model->generateChartData($debt100k);
                $data200k = $model->generateChartData($debt200k);
                $data500k = $model->generateChartData($debt500k);
                $xAxis = $model->generateChartXAxis($debt);
                //var_dump($xAxis);
                $data = array(
                    'description' => $description,
                    'title' => $title,
                    'chartdata'=> array(
                        'chartdataall' => $dataAll,
                        'chartdata10k' => $data10k,
                        'chartdata20k' => $data20k,
                        'chartdata30k' => $data30k,
                        'chartdata50k' => $data50k,
                        'chartdata100k' => $data100k,
                        'chartdata200k' => $data200k,
                        'chartdata500k' => $data500k
                    ),
                    'xaxis' => $xAxis,
                    'f_date' => $this->_arrParams['f_date'],
                    't_date' => $this->_arrParams['t_date']
                );
            }

        } else {
            $result = null;
            $data = array(
                'description' => $description,
                'title' => $title
            );
        }
        $this->view->assign('statistics/bieu_do_no_xau', $data, $this->layoutAdmin);
    }*/
    public function bao_cao_tien_no_xauAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $title = "Thống kê nợ xấu";
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {

            $deadLine = date('d-m-Y', strtotime('+1 month', strtotime($f_date)));
            $lastDeadline = date('t',strtotime($deadLine));
            $deadLineDate = $lastDeadline."-".date('m-Y', strtotime('+1 month', strtotime($f_date)));

            $model = new Statistics_Model();
            $data = $model->bao_cao_tien_no_xau($f_date,$t_date);
            $debt = $model->generateChartDataColumn($data);
            $data = array(
                'title' => $title,
                'chartdata'=> $debt,
                'deadline'  => $deadLineDate,
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
        $this->view->assign('statistics/bao_cao_tien_no_xau', $data, $this->layoutAdmin);
    }
    public function bao_cao_sl_giao_dich_no_xauAction(){
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $title = "Thống kê số lượng giao dịch nợ xấu";
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {
            $deadLine = date('d-m-Y', strtotime('+1 month', strtotime($f_date)));
            $lastDeadline = date('t',strtotime($deadLine));
            $deadLineDate = $lastDeadline."-".date('m-Y', strtotime('+1 month', strtotime($f_date)));

            $model = new Statistics_Model();
            $data = $model->bao_cao_sl_giao_dich_no_xau($f_date,$t_date);
            $debt = $model->generateChartDataColumn($data);
            $data = array(
                'title' => $title,
                'chartdata'=> $debt,
                'deadline'  => $deadLineDate,
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

        $this->view->assign('statistics/bao_cao_sl_giao_dich_no_xau', $data, $this->layoutAdmin);
    }
    public function thong_ke_no_xau_moi_ngayAction()
    {
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $title = "Biểu đồ đối chiếu nợ xấu của các giao dịch từng ngày";
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
        $title = "Biểu đồ đối chiếu số lượng giao dịch nợ xấu từng ngày";
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {

            $model = new Statistics_Model();
            $data = $model->getNumBadDebtEachDateColumn($f_date,$t_date);
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

    public function bao_cao_sl_giao_dich_no_xaubakkkkAction(){
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $title = "Thống kê số lượng giao dịch nợ xấu";
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {
            $deadLine = date('d-m-Y', strtotime('+1 month', strtotime($f_date)));
            $lastDeadline = date('t',strtotime($deadLine));
            $deadLineDate = $lastDeadline."-".date('m-Y', strtotime('+1 month', strtotime($f_date)));

            $model = new Statistics_Model();
            $data = $model->getMonthDebtColumn($f_date,$t_date);
            $debt = $model->generateChartDataColumn($data);
            $data = array(
                'title' => $title,
                'chartdata'=> $debt,
                'deadline'  => $deadLineDate,
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

        $this->view->assign('statistics/bieu_do_so_luong_no_xau_cot', $data, $this->layoutAdmin);
    }
}








