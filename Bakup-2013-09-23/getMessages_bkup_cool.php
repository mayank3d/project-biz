<?php
session_start();
include_once 'library.php';
include_once 'config.php';
include 'TNIManager.php';
$userId=$_POST['userId'];
$sessionId=$_POST['sId'];
$userId=$_SESSION['userId'];
$sessionId=session_id();
//echo session_id();
//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';
$tniManager = new TNIManager();
print $tniManager->getNewsletsUI($userId, $sessionId);
?>