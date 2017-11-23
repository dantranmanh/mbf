<?php

/**
 * Core_Logs.php
 *
 * Core_Logs class
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
class Core_Logs{
	
	public static function AddImpactlogs($arrParams){
		
		$Controller = new Core_Controller();
		$Controller->LoadModel('Impactlogs');
		$Impactlogs = new Impactlogs_Model();
		$Impactlogs->add($arrParams);
	}
}