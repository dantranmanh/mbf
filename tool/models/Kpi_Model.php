<?php

/**
* Kpi_Model.php
* 
* Kpi_Model class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 16/7/2015
* @time 11:48
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

class Kpi_Model extends Core_Model{
    
    public function __construct(){
        
    }
    
    public function getMTLog($f_date, $t_date){
		
		/*
		select time, sum(total), sum(sucess) from (
		select trunc(sent_time) time, 0 total, count(*) sucess from sms_log 
		where  SUBMIT_STATUS = 0  and  sent_time >= to_date('25/12/2017','dd/mm/yyyy') and sent_time < to_date('25/12/2017','dd/mm/yyyy') +1  group by trunc(sent_time)
		union all
		select trunc(sent_time) time , count(*) total, 0 sucess from sms_log  where  sent_time >= to_date('25/12/2017','dd/mm/yyyy') and sent_time < to_date('25/12/2017','dd/mm/yyyy') +1   group by trunc(sent_time)
		)
		group by time
		order by time;
		*/
		$select = $this->Select("select time, sum(total) as total, sum(sucess) as num_sucess from (
		select trunc(sent_time) time, 0 total, count(*) sucess from sms_log 
		where  SUBMIT_STATUS = 0  and  sent_time >= to_date('".$f_date."','dd/mm/yyyy') and sent_time < to_date('".$t_date."','dd/mm/yyyy') +1  group by trunc(sent_time)
		union all
		select trunc(sent_time) time , count(*) total, 0 sucess from sms_log  where  sent_time >= to_date('".$f_date."','dd/mm/yyyy') and sent_time < to_date('".$t_date."','dd/mm/yyyy') +1   group by trunc(sent_time)
		)
		group by time
		order by time");
		
		//$select = $this->Select("select count(*) as count, TRUNC(sent_time) as time_sent from sms_log where sent_time >= '" . $f_date . "' and sent_time <= '" . $t_date . "'  group by TRUNC(sent_time) order by TRUNC(sent_time) desc");
		
		$result = $this->FetchAll($select);
		//$this->DumpQueriesStack(); 
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
	
	public function getMOLog($f_date, $t_date){
		/// SELECT * FROM MO_QUEUE WHERE LOG_DATE = ngaythongke
		$select = $this->Select("select count(*) as count, trunc(LOG_DATE) as date_create from MO_QUEUE where LOG_DATE >= to_date('".$f_date."','dd/mm/yyyy') and LOG_DATE <= to_date('".$t_date."','dd/mm/yyyy') + 1 group by trunc(LOG_DATE)");
		
		$result = $this->FetchAll($select);
		//$this->DumpQueriesStack(); 
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
	
	public function TyleUngThanhCong($f_date, $t_date){
		/**
		select log_date, sum(total), sum(sucess) from (
		select trunc(log_date) log_date, 0 total, count(*) sucess from credit_trans 
		where log_date = to_date('25/12/2017','dd/mm/yyyy') and status  = 1 and mt_status = 2  group by log_date
		union all
		select trunc(log_date) log_date , count(*) total, 0 sucess from credit_trans  
		where  log_date = to_date('25/12/2017','dd/mm/yyyy') and condition_status =1  group by log_date
		)
		group by log_date
		order by log_date;
		*/
		$select = $this->Select("select log_date, sum(total) as total, sum(sucess) as sucess from (
		select trunc(log_date) log_date, 0 total, count(*) sucess from credit_trans 
		where log_date >= to_date('".$f_date."','dd/mm/yyyy') and log_date <= to_date('".$t_date."','dd/mm/yyyy') + 1 and status  = 1 and mt_status = 2  group by log_date
		union all
		select trunc(log_date) log_date , count(*) total, 0 sucess from credit_trans  
		where log_date >= to_date('".$f_date."','dd/mm/yyyy') and log_date <= to_date('".$t_date."','dd/mm/yyyy') + 1 and condition_status =1  group by log_date
		)
		group by log_date
		order by log_date");
		
		$result = $this->FetchAll($select);
		//$this->DumpQueriesStack(); 
		if($this->NumRows($select) > 0){
            return $result;
        }
    }
	
	public function TyleHoanUngThanhCong($f_date, $t_date){
		
		$select = $this->Select("select log_date, sum(total) as total, sum(sucess) as sucess from (
		select trunc(log_date) log_date, 0 total, count(*) sucess 
		from payment_trans where log_date >= to_date('".$f_date."','dd/mm/yyyy') and log_date <= to_date('".$t_date."','dd/mm/yyyy') + 1 and  charging_res_code = 'CPS-0000'  group by log_date
		union all
		select trunc(log_date) log_date , count(*) total, 0 sucess from payment_trans 
		where log_date >= to_date('".$f_date."','dd/mm/yyyy') and log_date <= to_date('".$t_date."','dd/mm/yyyy') + 1 and charging_res_code is not null and  charging_res_code like 'CPS-%'  group by log_date
		)
		group by log_date 
		order by log_date");
		
		$result = $this->FetchAll($select);
		//$this->DumpQueriesStack(); 
		if($this->NumRows($select) > 0){
            return $result;
        }
		
	}
    
	/**
    public function getGroupById($id){
        $select = $this->Select("SELECT * FROM ".$this->prefix."core_usergroups WHERE group_id=".$id);
		$result = $this->FetchObject($select);
        if($this->NumRows($select) > 0){
            return $result;
        }
	}
	*/
}