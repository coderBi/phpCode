<?php 
$c = !empty($_GET['c']) ? $_GET['c'] : 'User';
$a = !empty($_GET['a']) ? $_GET['a'] : 'index';
require_once './ModelFactory.class.php';
require_once './BaseController.class.php';
require_once './'.$c.'Model.class.php';
require_once './'.$c.'Controller.class.php';
$c .= "Controller"; $a .= "Action";
$ctrl = new $c();
$ctrl->$a();
 ?>