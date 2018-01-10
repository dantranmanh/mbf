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

class Report_Controller extends Core_Controller
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

    public function tongquanAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $title = "Thống kê tổng quan";
        $collection = array();
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {
            $t_date = $t_date." 23:59:59";
            $description = "";
            $result = null;


            $str_fdate = strtotime($f_date);
            $str_tdate = strtotime($t_date);
            $fdate = date('d-m-Y H:i:s', $str_fdate);
            $tdate = date('d-m-Y H:i:s', $str_tdate);
            $collection = $this->buildThongKe($fdate, $tdate);
            $task = $this->_arrParams['task'];
            if ($task == "exportexcel") {
                //$fileName = "baocaosolieu_" . date("Ym", strtotime(date("Ym") . " -1 month"));
                require_once(CORE_DIR . DS . 'phpexcel/PHPExcel.php');
                $objPHPExcel = new PHPExcel();

                $objPHPExcel->removeSheetByIndex(0);
                $newsheet = $objPHPExcel->createSheet();
                $newsheet->setTitle("Báo cáo tổng quan");


                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1')->getStyle('A1:E1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "BÁO CÁO SỐ LIỆU ĐỐI TÁC THÁNG " . " - " . Core_Config::getConfig("web", "service_name"));
                $objPHPExcel->getActiveSheet()->setCellValue('A2', "Ngày tháng")->getStyle('A2')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue('B2', "Số lượng giao dịch ứng")->getStyle('B2')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue('C2', "Số tiền ứng thẻ")->getStyle('C2')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue('D2', "Số lượng hoàn ứng")->getStyle('D2')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue('E2', "Số tiền hoàn ứng")->getStyle('E2')->getFont()->setBold(true);

                $i = 3;
                $j = 1;
                foreach ($collection as $row) {
                    $objPHPExcel->getActiveSheet()
                        ->setCellValue('A' . $i, $row['date'])
                        ->setCellValue('B' . $i, $row['num_ung'])
                        ->setCellValue('C' . $i, $row['total_ung'])
                        ->setCellValue('D' . $i, $row['num_hoan'])
                        ->setCellValue('E' . $i, $row['total_hoan']);
                    $i++;
                    $j++;
                }

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . 'baocao' . '.xls"');
                header('Cache-Control: max-age=0');
                $objWriter->save('php://output');
                exit;
            }
            $data = array(
                'description' => $description,
                'title' => $title,
                'collection' => $collection,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date']
            );
        } else {
            $description = "Thông tin ngày tháng không hợp lệ.";
            $result = null;
            $data = array(
                'description' => $description,
                'title' => $title
            );
        }
        $this->view->assign('report/tongquan', $data, $this->layoutAdmin);
    }

    /**
     * @param $f
     * @param $t
     * @return array
     *
     */
    public function buildThongKe($f, $t)
    {
        $this->model = new Report_Model();
        $entry = array();
        $credit = $this->model->getReportCreditTrans($f,$t);


        $entry['sl_ung'] = $credit['NUM'];
        $entry['tien_ung'] =  $credit['TOTAL'];
        $payment = $this->model->getReportPaymentTrans($f,$t);
        $entry['tien_hoan_ung_goc'] = $payment['ORIGIN'];
        $entry['tien_hoan_ung_phi'] = $payment['FEE'];
        $entry['hoan_ung_tong'] = $payment['TOTAL'];

        $debt = $this->model->getReportDebt($f,$t);
        $entry['no_bt'] = $debt['normal'];
        $entry['no_xau'] = $debt['bad'];

        $cards = $this->model->getReportCard();
        $entry['kho_the'] = $cards;
        return array($entry);
    }

    public function getDataTienUng($f, $t)
    {
        $rs = $this->model->getSoTienUng($f,$t);
        return $rs;
    }
	
	public function phan_tich_moi_ungAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }

        $collection = array();
        $description = "";
        $result = null;
        $title = "Báo cáo phân tích mời ứng";

        $msisdn = $this->_arrParams['msisdn'];
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
		
        if ($f_date && $t_date) {
            $str_fdate = strtotime($f_date);
            $str_tdate = strtotime($t_date);
            $fdate = date('d-m-Y H:i:s', $str_fdate);
            $tdate = date('d-m-Y H:i:s', $str_tdate);
			//pkg_report.rpt_statistic_invite(sysdate - 1,sysdate,?,?)
            $sql = 'BEGIN :v_Return := pkg_report.rpt_statistic_invite(:F_DATE, :T_DATE, :P_DATA_CURSOR, :P_OUT); END;';
            $this->model->con();
            //$this->updateDateFormatForCurrentSession();
            $stmt = oci_parse($this->model->conn_handle, $sql);
            $curs = oci_new_cursor($this->model->conn_handle);

            oci_bind_by_name($stmt, ':F_DATE', $fdate, 20);
            oci_bind_by_name($stmt, ':T_DATE', $tdate, 20);
            oci_bind_by_name($stmt, ':P_DATA_CURSOR', $curs, -1, OCI_B_CURSOR);
            oci_bind_by_name($stmt, ':P_OUT', $description, 255);
            oci_bind_by_name($stmt, ':v_Return', $result, 5);
            oci_execute($stmt);
            oci_execute($curs);
			//print_r($curs);

            while (($row = oci_fetch_array($curs, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                if (count($row) < 1) continue;
                $collection[] = $row;
            }
			//echo "<pre>";
			//print_r($collection);
			//echo "</pre>";
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
            'curs' => $entry,
            'title' => $title
        );
        $this->view->assign('report/phan_tich_moi_ung', $data, $this->layoutAdmin);
    }
	
	public function bao_cao_the_ungAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $title = "Báo cáo thẻ ứng";
        $collection = array();
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
		$card_amount = isset($this->_arrParams['card_amount']) ? $this->_arrParams['card_amount'] : false;
        if ($f_date && $t_date) {
            $t_date = $t_date." 23:59:59";
            $description = "";
            $result = null;


            $str_fdate = strtotime($f_date);
            $str_tdate = strtotime($t_date);
            $fdate = date('d-m-Y', $str_fdate);
            $tdate = date('d-m-Y', $str_tdate);
            $collection = $this->model->bao_cao_the_ung($fdate, $tdate, $card_amount);
            $data = array(
                'description' => $description,
                'title' => $title,
                'collection' => $collection,
                'f_date' => $this->_arrParams['f_date'],
                't_date' => $this->_arrParams['t_date'],
				'card_amount' => $this->_arrParams['card_amount']
            );
        } else {
            $description = "Thông tin ngày tháng không hợp lệ.";
            $result = null;
            $data = array(
                'description' => $description,
                'title' => $title
            );
        }
		$this->view->assign('report/bao_cao_the_ung', $data, $this->layoutAdmin);
	}
	
	public function bao_cao_thu_noAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
		
		$f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
		$card_amount = isset($this->_arrParams['card_amount']) ? $this->_arrParams['card_amount'] : false;
		
		//$f_date = date("d-m-Y", strtotime(date("d-m-Y")." -7 day"));
		//$f_date = date("d-m-Y");
        //$t_date = date("d-m-Y");
		
		$str_fdate = strtotime($f_date);
		$str_tdate = strtotime($t_date);
		$fdate = date('d-M-Y', $str_fdate);
		$tdate = date('d-M-Y', $str_tdate);
		//echo $fdate;
		$model = new Report_Model();
        $data = array(
            'title' => "Báo cáo thu nợ",
			'collection' => $model->BaoCaoThuNo($fdate, $tdate, $card_amount),
			'f_date' => $f_date,
            't_date' => $t_date,
			'card_amount' => $card_amount
        );
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
		
		$this->view->assign('report/bao_cao_thu_no', $data, $this->layoutAdmin);
	}
	
	public function bao_cao_kho_theAction()
    {
		
        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        //ini_set('display_errors', 1);
        $collection = array();
        $cards = $this->model->getReportCard();
        $collection[] = $cards;


        $data = array(
            'title' => $title,
            'collection' => $collection
        );
		$this->view->assign('report/bao_cao_kho_the', $data, $this->layoutAdmin);
	}
    public function thong_ke_thue_bao_no_xauAction()
    {

        if (!$this->acl->allow($this->controller, $this->action)) {
            $this->view->assign('permission/accessdeny', null, $this->layoutAdmin);
            exit;
        }
        $title = "Thống kê thuê bao nợ xấu";
        $f_date = isset($this->_arrParams['f_date']) ? $this->_arrParams['f_date'] : false;
        $t_date = isset($this->_arrParams['t_date']) ? $this->_arrParams['t_date'] : false;
        if ($f_date && $t_date) {
            $model = new Report_Model();
            $collection = array();
            $collection = $model->bao_cao_thue_bao_no_xau($f_date,$t_date);
            $data = array(
                'title' => $title,
                'collection' => $collection,
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

        $this->view->assign('report/thong_ke_thue_bao_no_xau', $data, $this->layoutAdmin);
    }

}








