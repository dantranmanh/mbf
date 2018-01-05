<?php

/**
* Search_Model.php
* 
* Search_Model class
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

class Translate_Model{
    public $mbftext;
    public function __construct(){
        /**
         * Include change text file into template
         */
        $path = "translate".DS."Translate.csv";
        $mbftext=array();
        if(file_exists($path)){
            $file = fopen($path, 'r');
            while (!feof($file) ) {
                $line = fgetcsv($file);
                $mbftext[$line[0]] = $line[1];
            }
            fclose($file);
        }
        $this->mbftext = $mbftext;
    }

    /**
     * @param $text
     * @return mixed
     */
    public function __($text)
    {
        if (empty($text)) echo $text;
        $translate = $this->mbftext[$text];
        if (empty($translate))
            echo $text;
        else
            echo $translate;
        return;
    }

    /**
     * @param null $total
     * @param null $error
     */
    public function renderFormMessage($total = null,$error =null){
        echo '<div class="form-message">
                <p class="success-mess">Tổng số '.$total.' bản ghi được tìm thấy.</p>
                <p class="error-mess">'.$error.'</p>
            </div>';
        return;
    }
	public function renderExcelFileButton($id = false, $onclick = "return;"){
        if(!$id)  return '';
        echo '<input class="btn btn-primary" id = "'.$id.'" onclick = "'.$onclick.'" type="button" value="Xuất file Exel">';
    }
    public function renderCsvFileButton($id = false, $onclick = "return;"){
        if(!$id)  return '';
        echo '<input class="btn btn-primary" onclick = "" type="button" id = "'.$id.'" onclick = "'.$onclick.'" value="Xuất file Csv">';
    }
	
	
}