<?php
header("Content-Type: text/html; charset=utf-8"); 
session_start();
$_SESSION['test'] = $_SERVER['REMOTE_ADDR']; 
?>