<?php
include_once 'library.php';
include_once 'config.php';
include 'BusinessManager.php';
$userId = $_SESSION['userId'];
$bizId = $_REQUEST['bizId'];
if(!empty($bizId) && !empty($userId)){
	$businessManager = new BusinessManager();
	$businessManager->allowUser($userId, $bizId);
	echo 1;
}else{
	echo 0;
}
?>

