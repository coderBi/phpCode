<?php 
$c = !empty($_GET['c']) ? $_GET['c'] : 'User';
$a = !empty($_GET['a']) ? $_GET['a'] : 'index';
require_once './Framework/mysqlDB.class.php';
require_once './Framework/ModelFactory.class.php';
require_once './Framework/BaseModel.class.php';
require_once './Framework/BaseController.class.php';
require_once './Models/'.$c.'Model.class.php';
require_once './Controllers/'.$c.'Controller.class.php';

$c .= "Controller"; $a .= "Action";
$ctrl = new $c();
$ctrl->$a();
 ?>