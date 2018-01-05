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
    public function getBadDebtEachDate($f_date,$t_date,$card =0){
        $debt = array();
        $dates = $this->getDatesFromRange($f_date,$t_date);
        if(count($dates) > 31){
            return "31dayslimitted";
        }
        foreach ($dates as $date){
            $total = $this->getBadDebtByDateInDb($date,$card);
            if($total == 'not found'){
                $total = $this->getBadDebtByDate($date,$card);
                $this->insertBadDebt($date,$total,$card);
            }

            $debt[] = array('date' => date('d-m', strtotime($date)), 'total' => $total);
        }
        return $debt;
    }
    /**
     * @param $t_date
     * @return array|bool
     */
    public function getBadDebtByDateInDb($t_date,$card = 0,$format = "d-m-Y"){
        $qr = "SELECT *
        FROM IDVN_REPORT_BAD_DEBT
        WHERE ";
        if($card >= 0) $qr = $qr.
            " CARD_AMOUNT = ".$card." AND";
        $qr = $qr." 
        DATES = '".$t_date."'";
        $select = $this->Select($qr);
        $result = $this->FetchAll($select);
        if ($this->NumRows($select) > 0) {
            //var_dump($result[0]['ORG_DEBT']);
            return isset($result[0]['AMOUNT']) ? $result[0]['AMOUNT']:0 ;
        } else return 'not found';
    }

    /**
     * @param $date
     * @param $amount
     * @return bool
     */
    public function insertBadDebt($date,$amount,$card = 0){
        if(empty($amount)) $amount = 0;
        $table = 'IDVN_REPORT_BAD_DEBT';
        $arr = array(
            'CARD_AMOUNT'=> $card,
            'DATES' => "'".$date."'",
            'AMOUNT' => $amount,
            'REPORT_TIME' => "TO_DATE('".date('Y-m-d H:i:s')."','yyyy/mm/dd hh24:mi:ss')"
        );
        $this->Insert($table, $arr);
        if($this->GetExecuteStatus()){
            $this->log('Thành công thêm dữ liệu vào bảng '.$table);
            $this->log(array('CARD_AMOUNT'=>$card,'DATES'=>$date));
        }
		return $this->GetExecuteStatus();
    }
    /**
     * @param $t_date
     * @return array|bool
     */
    public function getBadDebtByDate($t_date,$card = 0){
        $qr = "SELECT sum(current_card_debt) org_debt
        FROM bad_debt_list
        WHERE ";
        if($card > 0) $qr = $qr.
            " CARD_AMOUNT = ".$card." AND";
        $qr = $qr."
        create_date <= to_date('" . $t_date . "','dd/mm/yyyy') + 1";
        $select = $this->Select($qr);
        $result = $this->FetchAll($select);

        if ($this->NumRows($select) > 0) {
            //var_dump($result[0]['ORG_DEBT']);
            return $result[0]['ORG_DEBT'];
        } else return false;
    }

    /**
     * @param $data
     * @return string
     */
    function generateChartXAxis($data){
        $xAxis = array();
        $i = 0;
        foreach ($data as $d){
            $label = $d['date'];
            $date = explode("-",$d['date']);
            if($i != 0 && !in_array($date[0],array("1","01"))){
                $label = $date[0];
                //var_dump($label);
            }
            $elm = "{v:'".$d['date']."',f:'".$label."'}";
            $xAxis[] = $elm;
            $i++;
        }
        return implode(",",$xAxis);
    }

    /**
     * @param $data
     * @return string
     */
    function generateChartData($data){
        $chart = array();
        foreach ($data as $d){
            $total = !empty($d['total'])?$d['total']:0;
            $elm = "['".$d['date']."',".$total."]";
            $chart[] = $elm;
        }
        return implode(",",$chart);
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
    function getDatesFromRange($first, $last, $step = '+1 day', $format = 'd-m-Y' ) {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while( $current <= $last ) {

            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }
}