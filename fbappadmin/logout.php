<?php
session_start();

if($_SESSION['sess_adminID']!=""){
$_SESSION['sess_adminID']="";
session_destroy();
header("location:login.php");
}
header("location:login.php");
?>
