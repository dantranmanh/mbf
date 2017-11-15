<?php
/**
* Ini.php
* 
* Core_Ini class
* 
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 13/7/2015
* @time 21:43
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

class Core_Ini{
	
	var $_iniFilename = '';
	var $_iniParsedArray = array();
	
	/** 
	*  erstellt einen mehrdimensionalen Array aus der INI-Datei
	**/
	function __construct($filename){
		$this->_iniFilename = $filename;
		if($this->_iniParsedArray = parse_ini_file( $filename, true ) ) {
			return true;
		} else {
			return false;
		} 
	}
	
	/**
	* gibt die komplette Sektion zurück
	**/
	function getSection( $key ){
		return $this->_iniParsedArray[$key];
	}
	
	/**
	*  gibt einen Wert aus einer Sektion zurück
	**/
	function getValue( $section, $key ){
		if(!isset($this->_iniParsedArray[$section])) return false;
		return $this->_iniParsedArray[$section][$key];
	}
	
	/**
	*  gibt den Wert einer Sektion  oder die ganze Section zurück
	**/
	function get( $section, $key=NULL ){
		if(is_null($key)) return $this->getSection($section);
		return $this->getValue($section, $key);
	}
	
	/**
	* Seta um valor de acordo com a chave especificada
	**/
	function setSection( $section, $array ){
		if(!is_array($array)) return false;
		return $this->_iniParsedArray[$section] = $array;
	}
	
	/**
	* setzt einen neuen Wert in einer Section
	**/
	function setValue( $section, $key, $value ){
		if( $this->_iniParsedArray[$section][$key] = $value ) return true;
	}
	
	/**
	* setzt einen neuen Wert in einer Section oder eine gesamte, neue Section
	**/
	function set( $section, $key, $value=NULL ){
		if(is_array($key) && is_null($value)) return $this->setSection($section, $key);
		return $this->setValue($section, $key, $value);
	}
	
	/**
	* sichert den gesamten Array in die INI-Datei
	**/
	function save( $filename = null ){
		if( $filename == null ) $filename = $this->_iniFilename;
		if( is_writeable( $filename ) ) {
			$SFfdescriptor = fopen( $filename, "w" );
			foreach($this->_iniParsedArray as $section => $array){
				fwrite( $SFfdescriptor, "[" . $section . "]\n" );
				foreach( $array as $key => $value ) {
					fwrite( $SFfdescriptor, "$key = $value\n" );
				}
				fwrite( $SFfdescriptor, "\n" );
			}
			fclose( $SFfdescriptor );
			return true;
		} else {
			return false;
		}
	}
}