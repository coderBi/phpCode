<?php
class ModuleController extends BaseController{
	function __construct() {
		parent::__construct();
		$this->startSession();
	}

	function configSessin(){
		ini_set('session.save_path','D:/phpCode/temp/');
	}

	function startSession(){
		$this->configSessin();
		session_start();
	}
}