<?php

/**
 * Class Report_Model
 */

class Report_Model extends Core_Model
{

    public function __construct()
    {

    }

    /**
     * @param $f
     * @param $t
     * @return array|int
     */
    public function getReportCreditTrans($f, $t)
    {
        /**
         * status = 1 giao dich thanh cong
         * mt_status = 2 thue bao da nhan dc tin nhan
         */
        $qr = "select count(*) as num, sum(card_amount) as total from credit_trans where trans_date >= '" . $f . "' and trans_date <= '" . $t . "' and status =1 and mt_status = 2";
        $select = $this->Select($qr);

        $result = $this->FetchAll($select);
        if ($this->NumRows($select) > 0) {
            return $result[0];
        }else return array('num' => 0, 'total' => 0);
    }
    /**
     * @param $f
     * @param $t
     * @return array|int
     */
    public function bao_cao_the_ung($f_date, $t_date, $card_amount)
    {
        /**
         * status = 1 giao dich thanh cong
         * mt_status = 2 thue bao da nhan dc tin nhan
         */

        if($card_amount != null || $card_amount != ''){
            $where = "and card_amount = '".$card_amount."'";
        }else{
            $where = '';
        }
        $qr = "
        select log_date,card_amount, count(distinct msisdn) subs, count(*)  credit_counts , sum(card_amount)  sum_card
        from CREDIT_TRANS  
        where log_date >= to_date('".$f_date."','dd-mm-yyyy') and log_date <= to_date('".$t_date."','dd-mm-yyyy')
        and status = 1 and mt_status = 2 ".$where."
        group by log_date, card_amount 
        order by log_date , card_amount";
        $select = $this->Select($qr);

        $result = $this->FetchAll($select);

        if ($this->NumRows($select) > 0) {
            return $result;
        }else return array();
    }

    /**
     * @param $f
     * @param $t
     * @return array|int
     */
    public function getReportPaymentTrans($f, $t)
    {
        $str_fdate = strtotime($f);
        $str_tdate = strtotime($t);
        $fdate = date('d-m-Y', $str_fdate);
        $tdate = date('d-m-Y', $str_tdate);
        var_dump($fdate,$tdate);
        $qr = "select sum(payment_card_amount) as origin , sum(payment_fee_amount) as fee, sum(payment_amount) as total 
            from payment_trans 
            where log_date >= to_date('".$fdate."','dd-mm-yyyy') and log_date < to_date('".$tdate."','dd-mm-yyyy')+1 
            and charging_res_code ='CPS-0000'";
        $select = $this->Select($qr);

        $result = $this->FetchAll($select);
        if ($this->NumRows($select) > 0) {
            return $result[0];
        }else return 0;
    }

    /**
     * @param $f
     * @param $t
     * @return array
     */
    public function getReportDebt($f, $t)
    {
        $qrn = "select (sum(current_card_debt) + sum( current_fee_debt)) as normal from subs_debt where debt_status = 1 and  payment_deadline >= sysdate";
        $qrb = "select (sum(current_card_debt) + sum( current_fee_debt)) as bad from subs_debt where debt_status = 1 and  payment_deadline < sysdate";
        $selectn = $this->Select($qrn);
        $debtn = $this->FetchAll($selectn);
        $normal = $debtn[0]['NORMAL'];
        if (empty($normal))
            $normal = 0;

        $selectb = $this->Select($qrb);
        $debtb = $this->FetchAll($selectb);
        $bad = $debtb[0]['BAD'];
        if (empty($bad))
            $bad = 0;
        return array('normal'=> $normal, 'bad'=> $bad);
    }
    public function getReportCard(){
        $qr = "select  card_amount as amount , count (card_amount) as num from scratch_card_store where status in (0,3) GROUP BY card_amount";
        $select = $this->Select($qr);

        $result = $this->FetchAll($select);
        if ($this->NumRows($select) > 0) {
            return $result;
        }else return array();
    }

    public function BaoCaoThuNo($f_date, $t_date, $card_amount){

        if($card_amount != null || $card_amount != ''){
            $where = "and card_amount = '".$card_amount."'";
        }else{
            $where = '';
        }

        $qr = "select a.log_date,card_amount , sum(payment_card_amount) pay_card_amount, sum(payment_fee_amount) pay_fee_amount, SUM(PAYMENT_AMOUNT) TOTAL, count(distinct a.msisdn) subs
			from PAYMENT_TRANS a, credit_trans b
			where a.log_date >= to_date('".$f_date."','dd/mm/yyyy') and a.log_date < to_date('".$t_date."','dd/mm/yyyy') + 1
			and charging_res_code ='CPS-0000' ".$where."
			and a.credit_trans_id = b.credit_trans_id
			group by a.log_date ,card_amount 
			order by a.log_date ";
        $select = $this->Select($qr);

        $result = $this->FetchAll($select);
        //$this->DumpQueriesStack();
        if ($this->NumRows($select) > 0) {
            return $result;
        }else return array();
    }
    /**
    public function BaoCaoThuNo($f_date, $t_date){
    $qr = "select log_date,sum(payment_card_amount) card_amount, sum(payment_fee_amount) fee_amount, SUM(PAYMENT_AMOUNT) TOTAL, count(distinct msisdn) subs
    from PAYMENT_TRANS
    where log_date >= to_date('".$f_date."','dd/mm/yyyy') and log_date <= to_date('".$t_date."','dd/mm/yyyy') + 1
    and charging_res_code ='CPS-0000'
    group by log_date
    order by log_date";
    $select = $this->Select($qr);

    $result = $this->FetchAll($select);

    if ($this->NumRows($select) > 0) {
    return $result;
    }else return array();
    }*/

    /**
     * @param $f
     * @param $t
     * @return array|int
     */
    public function bao_cao_thue_bao_no_xau($f_date, $t_date)
    {
        $qr = "
        select msisdn, credit_trans_id, credit_trans_date, current_card_debt, payment_deadline, card_amount 
        from bad_debt_list  
        where 
         credit_trans_date >= to_date('" . $f_date . "','dd/mm/yyyy')
         and credit_trans_date <= to_date('" . $t_date . "','dd/mm/yyyy')
        ";
        $select = $this->Select($qr);

        $result = $this->FetchAll($select);

        if ($this->NumRows($select) > 0) {
            return $result;
        }else return array();
    }
}