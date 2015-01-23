<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 'On');*/
session_start();
include_once 'library.php';
include_once 'config.php';
include 'TNIManager.php';
$userId=$_REQUEST['userId'];
$msgID=$_REQUEST['msgId'];
if($userId != '' && $msgID != ''){
	$tniManager = new TNIManager();
	print $tniManager->deleteArchiveMessage($userId, $msgID);
} else {
	echo '0';
}
?>