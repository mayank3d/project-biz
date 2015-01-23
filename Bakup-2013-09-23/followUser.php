<?php
include_once 'library.php';
include 'UserManager.php';

if($_REQUEST['individual']=='Y'){
	$userId = $_SESSION['userId'];
	$bizId = $_REQUEST['bizId'];
	$userManager = new UserManager;
	$userManager->followBiz($userId, $bizId,'Y');
	echo 1;
}else if($_REQUEST['individual']=='N'){
	$userId = $_SESSION['userId'];
	$bizId = $_REQUEST['bizId'];
	$groupid = $_REQUEST['groupid'];
	$userManager = new UserManager;
	$userManager->followBiz($userId, $bizId,'N',$groupid);
	echo 1;
}else{
	$userId = $_SESSION['userId'];
	$bizId = $_REQUEST['bizId'];
	
	
	$userManager = new UserManager;
	$userManager->followBiz($userId, $bizId,'Y');
	echo 1;
}
//return true;
?>

