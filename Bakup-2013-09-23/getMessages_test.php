<?php
session_start();
include_once 'library.php';
include_once 'config.php';
include 'TNIManager.php';
/*$sessionId=$_SESSION['userId'];
$filter = $_REQUEST['filter'];
$bussinessId=$_REQUEST['bussinessId'];*/
//print_r($_REQUEST);
$tniManager = new TNIManager();
print $tniManager->getNewsletsUIByBizIdtest();
//
?>