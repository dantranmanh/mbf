<?php
/**
 * Class Quanlybpm_Model
 */

class Quanlybpm_Model extends Core_Model
{

    public function __construct()
    {

    }

    public function getProcessHistory($month)
    {
        $qr = "select a.process_name,a.process_id, started_time, completed_time, exec_schedule_time, 
        case when b.status = 0 then 'Executing'
        when b.status = 1 then 'Waiting other process completed' 
        when b.status = 2 then 'Completed with error'
        when b.status = 3 then 'Completed Success'
        else 'NA' end as status
         From bpm_process a, BPM_PROCESS_EXECUTION b
        where b.EXEC_SCHEDULE_TIME = to_date('" . $month . "','mm/yyyy') 
        and a.process_id = b.process_id
        order by b.EXEC_SCHEDULE_TIME desc";
        $select = $this->Select($qr);
        $result = $this->FetchAll($select);

        if ($this->NumRows($select) > 0) {
            return $result;
        } else return false;

    }
}