<?php

/**
 * Kpi_Controller.php
 *
 * Kpi_Controller class
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
class Kpi_Controller extends Core_Controller
{

    protected $layoutDefault;
    protected $layoutAdmin;

    public function __construct()
    {
        parent::__construct();

        $this->layoutDefault = "default";
        $this->layoutAdmin = "admin";
        $this->LoadModel("Kpi");
        $this->model = new Kpi_Model();
        $this->controller = $this->getClassMethod("controller");
        $this->action = $this->getClassMethod("action");

        if (!Core_Login::getLoginSession()) {
            $this->_redirect($this->baseUrl . 'login');
        }

        $this->acl = new Core_Acl();
    }

    public function kpi_mtAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
		
		$f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
		
		//$f_date = date("d-m-Y", strtotime(date("d-m-Y")." -7 day"));
		//$f_date = date("d-m-Y");
        //$t_date = date("d-m-Y");
		
		$str_fdate = strtotime($f_date);
		$str_tdate = strtotime($t_date);
		$fdate = date('d-M-Y', $str_fdate);
		$tdate = date('d-M-Y', $str_tdate);
		//echo $fdate;
        $data = array(
            'title' => "Tỷ lệ MT thành công",
			'kpi_mt' => $this->model->getMTLog($fdate, $tdate),
			'f_date' => $f_date,
            't_date' => $t_date,
        );
		//echo "<pre>";
		//print_r($data);

        $this->view->assign('kpi/kpi_mt', $data, $this->layoutAdmin);
    }

    public function kpi_moAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
		
		$f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
		
		//$f_date = date("d-m-Y", strtotime(date("d-m-Y")." -7 day"));
		//$f_date = date("d-m-Y");
        //$t_date = date("d-m-Y");
		
		$str_fdate = strtotime($f_date);
		$str_tdate = strtotime($t_date);
		$fdate = date('d-M-Y', $str_fdate);
		$tdate = date('d-M-Y', $str_tdate);
		//echo $fdate;
        $data = array(
            'title' => "Thống kê kpi MO",
			'kpi_mo' => $this->model->getMOLog($fdate, $tdate),
			'f_date' => $f_date,
            't_date' => $t_date,
        );
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
		
        $this->view->assign('kpi/kpi_mo', $data, $this->layoutAdmin);
    }

    public function tyle_ungthe_thanhcongAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
		
		$f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
		
		//$f_date = date("d-m-Y", strtotime(date("d-m-Y")." -7 day"));
		//$f_date = date("d-m-Y");
        //$t_date = date("d-m-Y");
		
		$str_fdate = strtotime($f_date);
		$str_tdate = strtotime($t_date);
		$fdate = date('d-M-Y', $str_fdate);
		$tdate = date('d-M-Y', $str_tdate);
		//echo $fdate;
        $data = array(
            'title' => "KPI Tỷ lệ ứng thẻ thành công",
			'response_data' => $this->model->TyleUngThanhCong($fdate, $tdate),
			'f_date' => $f_date,
            't_date' => $t_date,
        );
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";

        $this->view->assign('kpi/tyle_ungthe_thanhcong', $data, $this->layoutAdmin);
    }

    public function tyle_hoanung_thanhcongAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
		
		$f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
		
		//$f_date = date("d-m-Y", strtotime(date("d-m-Y")." -7 day"));
		//$f_date = date("d-m-Y");
        //$t_date = date("d-m-Y");
		
		$str_fdate = strtotime($f_date);
		$str_tdate = strtotime($t_date);
		$fdate = date('d-M-Y', $str_fdate);
		$tdate = date('d-M-Y', $str_tdate);
		//echo $fdate;
        $data = array(
            'title' => "KPI Tỷ lệ hoàn ứng thành công",
			'response_data' => $this->model->TyleHoanUngThanhCong($fdate, $tdate),
			'f_date' => $f_date,
            't_date' => $t_date,
        );
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";

        $this->view->assign('kpi/tyle_hoanung_thanhcong', $data, $this->layoutAdmin);
    }
}








