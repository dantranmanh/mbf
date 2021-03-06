<?php

/**
 * Class Report_Model
 */

class Statistics_Model extends Core_Model
{

    public function __construct()
    {

    }

    /**
     * @param $f_date
     * @param $t_date
     * @param $card
     * @return array|string
     */
    public function getBadDebtEachDate($f_date, $t_date, $card = 0)
    {
        $debt = array();
        $dates = $this->getDatesFromRange($f_date, $t_date);
        /*if(count($dates) > 31){
            return "31dayslimitted";
        }*/
        foreach ($dates as $date) {
            /*$total = $this->getBadDebtByDateInDb($date,$card);
            if($total == 'not found'){
                $total = $this->getBadDebtByDate($date,$card);
                $this->insertBadDebt($date,$total,$card);
            }*/
            $total = $this->getBadDebtByDate($date, $card);
            if (empty($total)) $total = 0;

            $debt[] = array('date' => date('d-m', strtotime($date)), 'total' => $total);
        }
        return $debt;
    }

    /**
     * @param $t_date
     * @return array|bool
     */
    public function getBadDebtByDateInDb($t_date, $card = 0, $format = "d-m-Y")
    {
        $qr = "SELECT *
        FROM IDVN_REPORT_BAD_DEBT
        WHERE ";
        if ($card >= 0) $qr = $qr .
            " CARD_AMOUNT = " . $card . " AND";
        $qr = $qr . " 
        DATES = '" . $t_date . "'";
        $select = $this->Select($qr);
        $result = $this->FetchAll($select);
        if ($this->NumRows($select) > 0) {
            //var_dump($result[0]['ORG_DEBT']);
            return isset($result[0]['AMOUNT']) ? $result[0]['AMOUNT'] : 0;
        } else return 'not found';
    }
    /**
     * @param $t_date
     * @return array|bool
     */
    public function getBadDebtByDate($t_date, $card = 0)
    {
        $qr = "SELECT * from  REPORT_BAD_DEBT_BY_TRANSDATE WHERE  TRANS_DATE = to_date('" . $t_date . "','dd/mm/yyyy')";
        if ($card > 0) $qr = $qr . " AND CARD_AMOUNT = '" . $card . "'";
        $select = $this->Select($qr);
        $result = $this->FetchAll($select);

        if ($this->NumRows($select) > 0) {
            return $result[0]['TOTAL'];
        } else return false;
    }

    /**
     * @param $f_date
     * @param $t_date
     * @return array|bool
     */
    public function getBadDebtByDateByRange($f_date, $t_date)
    {
        $qr = "SELECT * from  REPORT_BAD_DEBT_BY_TRANSDATE WHERE  
          TRANS_DATE >= to_date('" . $f_date . "','dd/mm/yyyy')
          AND TRANS_DATE <= to_date('" . $t_date . "','dd/mm/yyyy')
          ";

        $select = $this->Select($qr);
        $result = $this->FetchAll($select);

        if ($this->NumRows($select) > 0) {
            return $result;
        } else return false;
    }
    public function getCreditTransByDateRange($f_date, $t_date)
    {
        $qr = "SELECT * from  REPORT_CREDIT_AMOUNT_DATE WHERE  
          TRANS_DATE >= to_date('" . $f_date . "','dd/mm/yyyy')
          AND TRANS_DATE <= to_date('" . $t_date . "','dd/mm/yyyy')
          ";

        $select = $this->Select($qr);
        $result = $this->FetchAll($select);

        if ($this->NumRows($select) > 0) {
            return $result;
        } else return false;
    }
    /**
     * @param $data
     * @return string
     */
    function generateChartXAxis($data)
    {
        $xAxis = array();
        $i = 0;
        foreach ($data as $d) {
            $label = $d['date'];
            $date = explode("-", $d['date']);
            if ($i != 0 && !in_array($date[0], array("1", "01"))) {
                $label = $date[0];
                //var_dump($label);
            }
            $elm = "{v:'" . $d['date'] . "',f:'" . $label . "'}";
            $xAxis[] = $elm;
            $i++;
        }
        return implode(",", $xAxis);
    }

    /**
     * @param $data
     * @return string
     */
    function generateChartData($data)
    {
        $chart = array();
        foreach ($data as $d) {
            $total = !empty($d['total']) ? $d['total'] : 0;
            $elm = "['" . $d['date'] . "'," . $total . "]";
            $chart[] = $elm;
        }
        return implode(",", $chart);
    }

    /**
     * @param $data
     * @return string
     */
    function generateChartDataColumn($data)
    {
        $chart = array();
        foreach ($data as $index => $debt) {
            $elm = "['" . $debt['date'] . "'," . $debt['all'] . "," . $debt['10k'] . "," . $debt['20k'] . "," . $debt['30k'] . "," .
                $debt['50k'] . "," . $debt['100k'] . "," . $debt['200k'] . "," . $debt['500k'] . "]";
            $chart[] = $elm;
        }
        return implode(",", $chart);
    }
    /**
     * @param $data
     * @return string
     */
    function generateChartDataColumn_tyle($data)
    {
        $chart = array();
        foreach ($data as $debt) {
            $elm = "['" . $debt['date'] . "'," .$debt['credit'].",". $debt['all'] . "," . $debt['10k'] . "," . $debt['20k'] . "," . $debt['30k'] . "," .
                $debt['50k'] . "," . $debt['100k'] . "," . $debt['200k'] . "," . $debt['500k'] . "]";
            $chart[] = $elm;
        }
        return implode(",", $chart);
    }

    /**
     * @param $f_date
     * @param $t_date
     * @return array
     */
    public function thong_ke_no_xau_moi_ngay($f_date, $t_date)
    {
        $debt = array();
        $dates = $this->getDatesFromRange($f_date, $t_date);
        $data = $this->getBadDebtByDateByRange($f_date, $t_date);
        $badDebt = array();
        foreach ($dates as $date) {
            $_d = date('d-m', strtotime($date));
            $column = array(
                'date' => $_d,
                'all' => 0,
                '10k' => 0,
                '20k' => 0,
                '30k' => 0,
                '50k' => 0,
                '100k' => 0,
                '200k' => 0,
                '500k' => 0
            );
            foreach ($data as $debt) {
                if ($_d == date('d-m', strtotime($debt['TRANS_DATE']))) {
                    switch ($debt['CARD_AMOUNT']) {
                        case 10000:
                            $column['10k'] = $debt['TOTAL'];
                            break;
                        case 20000:
                            $column['20k'] = $debt['TOTAL'];
                            break;
                        case 30000:
                            $column['30k'] = $debt['TOTAL'];
                            break;
                        case 50000:
                            $column['50k'] = $debt['TOTAL'];
                            break;
                        case 100000:
                            $column['100k'] = $debt['TOTAL'];
                            break;
                        case 200000:
                            $column['200k'] = $debt['TOTAL'];
                            break;
                        case 500000:
                            $column['500k'] = $debt['TOTAL'];
                            break;
                    }
                    $column['all'] = $column['all'] + $debt['TOTAL'];
                }

            }
            $badDebt[] = $column;
        }
        return $badDebt;
    }

    /**
     * @param $f_date
     * @param $t_date
     * @return array
     */
    public function thong_ke_tien_no_xau($f_date, $t_date)
    {
        $data = $this->getBadDebtByDateByRange($f_date, $t_date);
        $badDebt = array();
        $column = array(
            'date' => $f_date." đến "."$t_date",
            'all' => 0,
            '10k' => 0,
            '20k' => 0,
            '30k' => 0,
            '50k' => 0,
            '100k' => 0,
            '200k' => 0,
            '500k' => 0
        );
        foreach ($data as $debt) {
                switch ($debt['CARD_AMOUNT']) {
                    case 10000:
                        $column['10k'] = $column['10k'] + $debt['TOTAL'];
                        break;
                    case 20000:
                        $column['20k'] = $column['20k'] + $debt['TOTAL'];
                        break;
                    case 30000:
                        $column['30k'] = $column['30k'] + $debt['TOTAL'];
                        break;
                    case 50000:
                        $column['50k'] = $column['50k'] + $debt['TOTAL'];
                        break;
                    case 100000:
                        $column['100k'] = $column['100k'] + $debt['TOTAL'];
                        break;
                    case 200000:
                        $column['200k'] = $column['200k'] + $debt['TOTAL'];
                        break;
                    case 500000:
                        $column['500k'] = $column['500k'] + $debt['TOTAL'];
                        break;
                }
                $column['all'] = $column['all'] + $debt['TOTAL'];
        }
        $badDebt[] = $column;
        return $badDebt;
    }
    public function thong_ke_sl_giao_dich_no_xau($f_date, $t_date)
    {
        $data = $this->getBadDebtByDateByRange($f_date, $t_date);
        $badDebt = array();
        $column = array(
            'date' => $f_date." đến "."$t_date",
            'all' => 0,
            '10k' => 0,
            '20k' => 0,
            '30k' => 0,
            '50k' => 0,
            '100k' => 0,
            '200k' => 0,
            '500k' => 0
        );
        foreach ($data as $debt) {
            switch ($debt['CARD_AMOUNT']) {
                case 10000:
                    $column['10k'] = $column['10k'] + $debt['SUBS_COUNTS'];
                    break;
                case 20000:
                    $column['20k'] = $column['20k'] + $debt['SUBS_COUNTS'];
                    break;
                case 30000:
                    $column['30k'] = $column['30k'] + $debt['SUBS_COUNTS'];
                    break;
                case 50000:
                    $column['50k'] = $column['50k'] + $debt['SUBS_COUNTS'];
                    break;
                case 100000:
                    $column['100k'] = $column['100k'] + $debt['SUBS_COUNTS'];
                    break;
                case 200000:
                    $column['200k'] = $column['200k'] + $debt['SUBS_COUNTS'];
                    break;
                case 500000:
                    $column['500k'] = $column['500k'] + $debt['SUBS_COUNTS'];
                    break;
            }
            $column['all'] = $column['all'] + $debt['SUBS_COUNTS'];
        }

        $badDebt[] = $column;
        return $badDebt;
    }
    public function thong_ke_ty_le_giao_dich_no_xau($f_date, $t_date)
    {
        $debt = $this->getBadDebtByDateByRange($f_date, $t_date);

        $badDebt = $this->processReportTableTotalData($debt,$f_date,$t_date,"TOTAL");
        /*$creditDemo = array(
            'date' => $f_date." đến "."$t_date",
            'all' => 1277700000,
            '10k' => 400000000,
            '20k' => 150360000,
            '30k' => 12990000,
            '50k' => 315250000,
            '100k' => 205000000,
            '200k' => 140600000,
            '500k' => 53500000
        );*/
        $credit = $this->getCreditTransByDateRange($f_date, $t_date);

        $creditTrans = $this->processReportTableTotalData($credit,$f_date,$t_date,"TOTAL_CREDIT_AMOUNT");
        $column = array(
            'date' => $f_date." đến "."$t_date",
            'credit' => $creditTrans['all'],
            'all' => $badDebt['all'],
            '10k' => $badDebt['10k'],
            '20k' => $badDebt['20k'],
            '30k' => $badDebt['30k'],
            '50k' => $badDebt['50k'],
            '100k' => $badDebt['100k'],
            '200k' => $badDebt['200k'],
            '500k' => $badDebt['500k']
        );
        return array($column);
    }
    public function thong_ke_ty_le_sl_giao_dich_no_xau($f_date, $t_date)
    {
        $debt = $this->getBadDebtByDateByRange($f_date, $t_date);

        $badDebt = $this->processReportTableTotalData($debt,$f_date,$t_date,"SUBS_COUNTS");
        /*$creditDemo = array(
            'date' => $f_date." đến "."$t_date",
            'all' => 57116,
            '10k' => 40000,
            '20k' => 7518,
            '30k' => 433,
            '50k' => 6305,
            '100k' => 2050,
            '200k' => 703,
            '500k' => 107
        );*/
        $credit = $this->getCreditTransByDateRange($f_date, $t_date);

        $creditTrans = $this->processReportTableTotalData($credit,$f_date,$t_date,"SUBS_COUNTS");
        $column = array(
            'date' => $f_date." đến "."$t_date",
            'credit' => $creditTrans['all'],
            'all' => $badDebt['all'],
            '10k' => $badDebt['10k'],
            '20k' => $badDebt['20k'],
            '30k' => $badDebt['30k'],
            '50k' => $badDebt['50k'],
            '100k' => $badDebt['100k'],
            '200k' => $badDebt['200k'],
            '500k' => $badDebt['500k']
        );
        return array($column);
    }
    public function thong_ke_sl_no_xau_moi_ngay($f_date, $t_date)
    {
        $dates = $this->getDatesFromRange($f_date, $t_date);
        $data = $this->getBadDebtByDateByRange($f_date, $t_date);
        $badDebt = array();
        foreach ($dates as $date) {
            $_d = date('d-m', strtotime($date));
            $column = array(
                'date' => $_d,
                'all' => 0,
                '10k' => 0,
                '20k' => 0,
                '30k' => 0,
                '50k' => 0,
                '100k' => 0,
                '200k' => 0,
                '500k' => 0
            );
            foreach ($data as $debt) {
                if ($_d == date('d-m', strtotime($debt['TRANS_DATE']))) {
                    switch ($debt['CARD_AMOUNT']) {
                        case 10000:
                            $column['10k'] = $debt['SUBS_COUNTS'];
                            break;
                        case 20000:
                            $column['20k'] = $debt['SUBS_COUNTS'];
                            break;
                        case 30000:
                            $column['30k'] = $debt['SUBS_COUNTS'];
                            break;
                        case 50000:
                            $column['50k'] = $debt['SUBS_COUNTS'];
                            break;
                        case 100000:
                            $column['100k'] = $debt['SUBS_COUNTS'];
                            break;
                        case 200000:
                            $column['200k'] = $debt['SUBS_COUNTS'];
                            break;
                        case 500000:
                            $column['500k'] = $debt['SUBS_COUNTS'];
                            break;
                    }
                    $column['all'] = $column['all'] + $debt['SUBS_COUNTS'];
                }

            }
            $badDebt[] = $column;
        }
        return $badDebt;
    }
    public function processReportTableTotalData($data,$f_date,$t_date,$type){
        $results = array(
            'date' => $f_date." đến "."$t_date",
            'all' => 0,
            '10k' => 0,
            '20k' => 0,
            '30k' => 0,
            '50k' => 0,
            '100k' => 0,
            '200k' => 0,
            '500k' => 0
        );
        foreach ($data as $item) {
            switch ($item['CARD_AMOUNT']) {
                case 10000:
                    $results['10k'] = $results['10k'] + $item[$type];
                    break;
                case 20000:
                    $results['20k'] = $results['20k'] + $item[$type];
                    break;
                case 30000:
                    $results['30k'] = $results['30k'] + $item[$type];
                    break;
                case 50000:
                    $results['50k'] = $results['50k'] + $item[$type];
                    break;
                case 100000:
                    $results['100k'] = $results['100k'] + $item[$type];
                    break;
                case 200000:
                    $results['200k'] = $results['200k'] + $item[$type];
                    break;
                case 500000:
                    $results['500k'] = $results['500k'] + $item[$type];
                    break;
            }
            $results['all'] = $results['all'] + $item[$type];
        }
        return $results;
    }
    /**
     * @param $start
     * @param $end
     * @param string $format
     * @return array
     */
    /*function getDatesFromRange($start, $end,$format = 'd-m-Y'){
        $dates = array($start);
        while(end($dates) < $end){
            $dates[] = date($format, strtotime(end($dates).' +1 day'));
        }
        return $dates;
    }*/
    function getDatesFromRange($first, $last, $step = '+1 day', $format = 'd-m-Y')
    {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }



    /**
     * @param $date
     * @param $amount
     * @return bool
     */
    public function insertBadDebt($date, $amount, $card = 0)
    {
        if (empty($amount)) $amount = 0;
        $table = 'IDVN_REPORT_BAD_DEBT';
        $arr = array(
            'CARD_AMOUNT' => $card,
            'DATES' => "'" . $date . "'",
            'AMOUNT' => $amount,
            'REPORT_TIME' => "TO_DATE('" . date('Y-m-d H:i:s') . "','yyyy/mm/dd hh24:mi:ss')"
        );
        $this->Insert($table, $arr);
        if ($this->GetExecuteStatus()) {
            $this->log('Thành công thêm dữ liệu vào bảng ' . $table);
            $this->log(array('CARD_AMOUNT' => $card, 'DATES' => $date));
        }
        return $this->GetExecuteStatus();
    }

    /**
     * @param $date
     * @param $amount
     * @return bool
     */
    public function insertBadDebtCreditTrans($date, $amount, $card = 0, $num)
    {
        if (empty($amount)) $amount = 0;
        $table = 'REPORT_BAD_DEBT_BY_TRANSDATE';
        $arr = array(
            'TRANS_DATE' => "'" . $date . "'",
            'TOTAL' => $amount,
            'CARD_AMOUNT' => $card,
            'SUBS_COUNTS' => $num
        );
        $this->Insert($table, $arr);
        if ($this->GetExecuteStatus()) {
            /*$this->log('Thành công thêm dữ liệu vào bảng '.$table);
            $this->log(array('CARD_AMOUNT'=>$card,'DATES'=>$date));*/
            var_dump('insert thanh cong');
        }
        return $this->GetExecuteStatus();
    }
    public function makeTestDataBadDebtCreditTrans()
    {
        $cards = array(10000, 20000, 30000, 50000, 100000, 200000, 500000);
        for ($i = 1; $i <= 30; $i++) {
            $date = $i . "-11-2017";
            if ($i < 10)
                $date = "0" . $i . "-11-2017";
            foreach ($cards as $card) {
                $num = rand(1, 30);
                $amount = $num * $card;
                $this->insertBadDebtCreditTrans($date, $amount, $card, $num);
            }
        }
    }
    public function makeTestDataCreditTransAmountDate()
    {
        $cards = array(10000, 20000, 30000, 50000, 100000, 200000, 500000);
        for ($i = 1; $i <= 30; $i++) {
            $date = $i . "-11-2017";
            if ($i < 10)
                $date = "0" . $i . "-11-2017";
            $count = 0;
            foreach ($cards as $card) {
                $num = rand(0, 300);
                $amount = $num * $card;
                $table = 'REPORT_CREDIT_AMOUNT_DATE';
                $arr = array(
                    'TRANS_DATE' => "'" . $date . "'",
                    'TOTAL_CREDIT_AMOUNT' => $amount,
                    'CARD_AMOUNT' => $card,
                    'SUBS_COUNTS' => $num
                );
                $this->Insert($table, $arr);
                if ($this->GetExecuteStatus()) {
                    $count++;
                }
            }
            var_dump('inserting '.count($cards).' into table '.$table);
            var_dump('insert thành công '.$count.' records');
        }
    }
}