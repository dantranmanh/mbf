<?php

/**
* System.php
* 
* System class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 15/7/2015
* @time 20:45
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

class Core_System{
    
    private function roundsize($size){
        $i=0;
        $iec = array("B", "KB", "MB", "GB", "TB");
        while (($size/1024)>1) {
            $size=$size/1024;
            $i++;}
        return(round($size,1)." ".$iec[$i]);
   }
   
   private function formatSize($bytes){
            $types = array( 'B', 'KB', 'MB', 'GB', 'TB' );
            for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
                    return( round( $bytes, 2 ) . " " . $types[$i] );
   }
    
   public function  calculateDisk(){
        $df = disk_free_space("/");
        $dt = disk_total_space("/");
        $du = $dt - $df;
        $dp = sprintf('%.2f',($du / $dt) * 100);
        $df = self::formatSize($df);
        $du = self::formatSize($du);
        $dt = self::formatSize($dt);
        
        echo '
        <!--<li>
            <a>
                <div>
                    <p>
                        <strong>Bandwidth Transfer</strong>
                        <span class="pull-right text-muted">40% Space</span>
                    </p>
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Space (success)</span>
                        </div>
                    </div>
                    <div class="stat">21419.94 / 400 MB</div>
                </div>
            </a>
        </li>-->
        <li class="divider"></li>
        <li>
            <a>
                <div>
                    <p>
                        <strong>Disk Space Usage</strong>
                        <span class="pull-right text-muted">'.$dp.'% Space</span>
                    </p>
                    <div class="progress progress-striped active">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="'.str_replace(" GB","",$du).'" aria-valuemin="0" aria-valuemax="100" style="width: '.$dp.'%;">
                            <span class="sr-only">'.$dp.'% Space</span>
                        </div>
                    </div>
                    <div class="stat">'.$du.' free of '.$dt.'</div>
                </div>
            </a>
        </li>
        ';
    }
}