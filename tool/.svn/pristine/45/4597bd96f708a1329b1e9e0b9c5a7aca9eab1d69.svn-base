<?php

/**
 * Common_Model.php
 *
 * Common_Model class
 *
 * @project mvc
 * @author duong bien
 * @email bien.duongvan@yahoo.com
 * @date 23/7/2015
 * @time 9:46
 * @copyright 2015 Copyright duong bien
 * @license duong bien
 * @version 1.0.0
 */
class Common_Model extends Core_Model
{

    public function __construct()
    {

    }

    public function getCountSubQueue($table){
        $this->query("SELECT id FROM " . $this->prefix .$table);
        if ($this->numRows() > 0) {
            return $this->numRows();
        }
    }

    public function insertLogs($arrParams)
    {
        $this->insertRow('logs', $arrParams);
        return $this->insertId('logs');
    }

    public function ThongkeThuebaoDangky($start, $count, $exp = null)
    {
        $where = null;
        if (isset($exp['sid'])) {
            $where = $where . "AND s.sid = '" . $exp['sid'] . "' ";
        }
        if (isset($exp['package'])) {
            $where = $where . "AND s.package_name = '" . $exp['package'] . "' ";
        }
        if (Core_Login::getUserId() != ADMIN_ID) {
            if (!isset($exp['sid']) && $exp['sid'] == "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        if (Core_Login::getUserId() == ADMIN_ID) {
            if(isset($exp['user_id']) && $exp['user_id'] != "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }

        $result = $this->query("SELECT
                                s.createdate, s.msisdn, s.package_name, s.channel, s.sid, s.params, s.status
                                FROM " . $this->prefix . "sub AS s WHERE 1=1 " . $where . "
                                AND DATE(s.createdate) >= '" . $exp['fromdate'] . "'
                                AND DATE(s.createdate) <= '" . $exp['todate'] . "'
                                ORDER BY s.id DESC  LIMIT " . $start . "," . $count);
        if ($this->numRows() > 0) {
            return $result;
        }
    }

    public function countThongkeThuebaoDangky($exp = null)
    {
        $where = null;
        if (isset($exp['sid'])) {
            $where = $where . "AND s.sid = '" . $exp['sid'] . "' ";
        }
        if (isset($exp['package'])) {
            $where = $where . "AND s.package_name = '" . $exp['package'] . "' ";
        }
        if (Core_Login::getUserId() != ADMIN_ID) {
            if (!isset($exp['sid']) && $exp['sid'] == "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        if (Core_Login::getUserId() == ADMIN_ID) {
            if(isset($exp['user_id']) && $exp['user_id'] != "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }

        $this->query("SELECT s.id FROM " . $this->prefix . "sub AS s WHERE 1=1 " . $where . "
                            AND DATE(s.createdate) >= '" . $exp['fromdate'] . "'
                            AND DATE(s.createdate) <= '" . $exp['todate'] . "'");
        if ($this->numRows() > 0) {
            return $this->numRows();
        }
    }

    public function TongThuebao($exp = null, $option = null)
    {
        $where = null;
        if (isset($exp['sid'])) {
            $where = $where . "AND s.sid = '" . $exp['sid'] . "' ";
        }
        if (Core_Login::getUserId() != ADMIN_ID) {
            if (!isset($exp['sid']) && $exp['sid'] == "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        if (Core_Login::getUserId() == ADMIN_ID) {
            if(isset($exp['user_id']) && $exp['user_id'] != "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        if (isset($exp['package'])) {
            $where = $where . "AND s.package_name = '" . $exp['package'] . "' ";
        }
        if (isset($option['task']) && $option['task'] == "thuebao_tuhuy") {
            $where = $where . "AND s.params = 1";
        }
        if (isset($option['task']) && $option['task'] == "hethong_huy") {
            $where = $where . "AND s.params = 2";
        }
        if (isset($option['task']) && $option['task'] == "thuebao_active") {
            $where = $where . "AND s.params = 0";
        }
        if (isset($option['task']) && $option['task'] == "dangky_moi") {
            $where = $where . "AND s.status = 2";
        }
        if (isset($option['task']) && $option['task'] == "tong_thuebao_huy") {
            $where = $where . "AND (s.params = 1 OR s.params = 2)";
        }
        $result = $this->query("SELECT COUNT(1) AS count FROM " . $this->prefix . "sub AS s WHERE 1=1 " . $where . "
                        AND DATE(s.createdate) >= '" . $exp['fromdate'] . "'
                        AND DATE(s.createdate) <= '" . $exp['todate'] . "'");

        if ($this->numRows() > 0) {
            return $result[0]->count;
        }
    }

    public function ThongkeNhandienThuebao($start, $count, $exp = null)
    {
        $where = null;
        if (isset($exp['sid'])) {
            $where = $where . "AND s.sid = '" . $exp['sid'] . "' ";
        }
        if (isset($exp['cmd'])) {
            $where = $where . "AND s.cmd = '" . $exp['cmd'] . "' ";
        }
		
        if (Core_Login::getUserId() != ADMIN_ID) {
            if (!isset($exp['sid']) && $exp['sid'] == "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        if (Core_Login::getUserId() == ADMIN_ID) {
            if(isset($exp['user_id']) && $exp['user_id'] != "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }

        $result = $this->query("SELECT
                                s.* FROM " . $this->prefix . "sub_log AS s WHERE 1=1 " . $where . "
                                AND DATE(s.createdate) >= '" . $exp['fromdate'] . "'
                                AND DATE(s.createdate) <= '" . $exp['todate'] . "' AND sid != '68'
                                ORDER BY s.id DESC  LIMIT " . $start . "," . $count);
        if ($this->numRows() > 0) {
            return $result;
        }
    }

    public function countThongkeNhandienThuebao($exp = null)
    {
        $where = null;
        if (isset($exp['sid'])) {
            $where = $where . "AND s.sid = '" . $exp['sid'] . "' ";
        }
        if (isset($exp['cmd'])) {
            $where = $where . "AND s.cmd = '" . $exp['cmd'] . "' ";
        }
        if (Core_Login::getUserId() != ADMIN_ID) {
            if (!isset($exp['sid']) && $exp['sid'] == "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        if (Core_Login::getUserId() == ADMIN_ID) {
            if(isset($exp['user_id']) && $exp['user_id'] != "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        $this->query("SELECT s.id FROM " . $this->prefix . "sub_log AS s WHERE 1=1 " . $where . "
                            AND DATE(s.createdate) >= '" . $exp['fromdate'] . "'
                            AND DATE(s.createdate) <= '" . $exp['todate'] . "' AND sid != '68'");
        if ($this->numRows() > 0) {
            return $this->numRows();
        }
    }

    public function ThongkeThanhtoan($start, $count, $exp = null)
    {
        $where = null;
        if (isset($exp['sid'])) {
            $where = $where . "AND s.sid = '" . $exp['sid'] . "' ";
        }
        if (isset($exp['package'])) {
            $where = $where . "AND s.package_name = '" . $exp['package'] . "' ";
        }
		
		if (isset($exp['channel'])) {
            $where = $where . "AND s.channel = '" . $exp['channel'] . "' ";
        }

        if (Core_Login::getUserId() != ADMIN_ID) {
            if (!isset($exp['sid']) && $exp['sid'] == "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        if (Core_Login::getUserId() == ADMIN_ID) {
            if(isset($exp['user_id']) && $exp['user_id'] != "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }

        $result = $this->query("SELECT
                                s.createdate, s.msisdn, s.package_name, s.amount, s.sid, s.channel, s.params
                                FROM " . $this->prefix . "monfree AS s WHERE 1=1 " . $where . "AND s.params = '0' AND s.amount > 0
                                AND DATE(s.createdate) >= '" . $exp['fromdate'] . "'
                                AND DATE(s.createdate) <= '" . $exp['todate'] . "'
                                ORDER BY s.id DESC  LIMIT " . $start . "," . $count);
        if ($this->numRows() > 0) {
            return $result;
        }
    }

    public function countThongkeThanhtoan($exp = null)
    {
        $where = null;
        if (isset($exp['sid'])) {
            $where = $where . "AND s.sid = '" . $exp['sid'] . "' ";
        }
        if (isset($exp['package'])) {
            $where = $where . "AND s.package_name = '" . $exp['package'] . "' ";
        }
		if (isset($exp['channel'])) {
            $where = $where . "AND s.channel = '" . $exp['channel'] . "' ";
        }
        if (Core_Login::getUserId() != ADMIN_ID) {
            if (!isset($exp['sid']) && $exp['sid'] == "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        if (Core_Login::getUserId() == ADMIN_ID) {
            if(isset($exp['user_id']) && $exp['user_id'] != "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        $this->query("SELECT s.id FROM " . $this->prefix . "monfree AS s WHERE 1=1 " . $where . " AND s.params = '0' AND s.amount > 0
                            AND DATE(s.createdate) >= '" . $exp['fromdate'] . "'
                            AND DATE(s.createdate) <= '" . $exp['todate'] . "'");
        if ($this->numRows() > 0) {
            return $this->numRows();
        }
    }

    public function totalAmountMonfree($exp = null)
    {
        $where = null;
        if (isset($exp['sid'])) {
            $where = $where . "AND s.sid = '" . $exp['sid'] . "' ";
        }
        if (isset($exp['package'])) {
            $where = $where . "AND s.package_name = '" . $exp['package'] . "' ";
        }
		if (isset($exp['channel'])) {
            $where = $where . "AND s.channel = '" . $exp['channel'] . "' ";
        }
        if (Core_Login::getUserId() != ADMIN_ID) {
            if (!isset($exp['sid']) && $exp['sid'] == "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        if (Core_Login::getUserId() == ADMIN_ID) {
            if(isset($exp['user_id']) && $exp['user_id'] != "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        $result = $this->query("SELECT SUM(s.amount) AS amount FROM " . $this->prefix . "monfree AS s WHERE 1=1 " . $where . " AND s.params = '0' AND s.amount > 0
                            AND DATE(s.createdate) >= '" . $exp['fromdate'] . "'
                            AND DATE(s.createdate) <= '" . $exp['todate'] . "'");
        if ($this->numRows() > 0) {
            return $result[0]->amount;
        }
    }
	
	public function getMonfree($exp = null){

		$result = $this->query("SELECT sid,
                                COUNT(CASE WHEN amount = 3000 THEN 1 END) AS price_3000
                                FROM " . $this->prefix . "monfree WHERE params = '0'
                                AND DATE(createdate) >= '" . $exp['fromdate'] . "'
                                AND DATE(createdate) <= '" . $exp['todate'] . "'
                                GROUP BY sid ORDER by sid * 1 ASC");
        if ($this->numRows() > 0) {
            return $result;
        }
    }
	
	// Doi soat nha mang
	public function doisoatNhamang($exp = null)
    {
        $result = $this->query("SELECT amount,count(*) AS count FROM " . $this->prefix . "monfree WHERE params = '0' AND DATE(createdate) >= '" . $exp['fromdate'] . "'
                                AND DATE(createdate) <= '" . $exp['todate'] . "' GROUP BY amount");
        if ($this->numRows() > 0) {
            return $result;
        }
    }

    // =========== Phan thong ke tong hop ===============================

    public function ThongkeTonghop($exp = null)
    {

        $where = null;
        if (isset($exp['sid'])) {
            $where = $where . "AND s.sid = '" . $exp['sid'] . "' ";
        }

        if (Core_Login::getUserId() != ADMIN_ID) {
            if (!isset($exp['sid']) && $exp['sid'] == "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }
        if (Core_Login::getUserId() == ADMIN_ID) {
            if(isset($exp['user_id']) && $exp['user_id'] != "") {
                if (isset($exp['partners'])) {
                    $where = $where . "AND s.sid IN(" . $exp['partners'] . ")";
                }
            }
        }

        $result = $this->query("SELECT
                                COUNT(CASE WHEN reason = 'RENEW' AND params = '0' THEN 1 END) AS GiaHanThanhCong,
                                COUNT(CASE WHEN reason = 'RENEW' AND params != '0' THEN 1 END) AS GiaHanLoi,
                                s.createdate, s.sid, s.channel
                                FROM " . $this->prefix . "monfree AS s WHERE
                                DATE(s.createdate) >= '" . $exp['fromdate'] . "'
                                AND DATE(s.createdate) <= '" . $exp['todate'] . "' ".$where. "
                                GROUP BY DATE(s.createdate), s.sid
                                ORDER BY DATE(s.createdate) DESC, s.sid ASC");
        if ($this->numRows() > 0) {
            return $result;
        }
    }

    public function ThongkeTonghopTotalAmount($date, $sid)
    {
        $result = $this->query("SELECT SUM(s.amount) AS amount FROM " . $this->prefix . "monfree AS s WHERE s.params = '0' AND s.amount > 0 AND sid = '".$sid."'
                            AND DATE(s.createdate) = '" . $date . "'  ORDER BY DATE(s.createdate) ASC");
        if ($this->numRows() > 0) {
            return $result[0]->amount;
        }
    }

    public function ThongkeTonghopDangKyHuy($date, $sid)
    {
        $result = $this->query("SELECT
                            COUNT(CASE WHEN params = '1' OR params = '0' THEN 1 END) AS DangKy,
                            COUNT(CASE WHEN params = '1' THEN 1 END) AS Huy
                            FROM " . $this->prefix . "sub AS s WHERE sid = '".$sid."'
                            AND DATE(s.createdate) = '" . $date . "' ORDER BY DATE(s.createdate) ASC");
        if ($this->numRows() > 0) {
            return $result;
        }
    }

    public function ThongkeTonghopTongActive($sid)
    {
        $result = $this->query("SELECT COUNT(1) AS count
                            FROM " . $this->prefix . "sub AS s WHERE sid = '".$sid."' AND params = 0
                            ORDER BY DATE(s.createdate) ASC");
        if ($this->numRows() > 0) {
            return $result[0]->count;
        }
    }
	
}