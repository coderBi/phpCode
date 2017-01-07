<?php
session_start();
var_dump($_COOKIE);
echo "<br>";
var_dump($_SESSION);
$_SESSION['USERNAME'] = 'xx';
$_SESSION['ADMIN_UID'] = 'xx';
