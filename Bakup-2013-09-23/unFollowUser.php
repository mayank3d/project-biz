<?php
session_start();
//ini_set('display_errors',1);
include_once 'library.php';
include 'UserManager.php';
if($_REQUEST['search_subscribe']=='Y'){
	$userId = $_SESSION['userId'];
	$bizId = $_REQUEST['bizId'];
	$userManager = new UserManager;
	$userManager->unfollowBiz($userId, $bizId);
	echo 1;
}else if($_REQUEST['subscriber_page'] == 'Y'){
	// block
	$userId = $_SESSION['userId'];
	$bizId = $_REQUEST['bizId'];
	$userManager = new UserManager;
	$userManager->blockfollowBiz($userId, $bizId);
	echo 1;
}else if($_REQUEST['subs_subscribe']=='Y'){
	//pending.php block
	$userId = $_SESSION['userId'];
	$bizId = $_REQUEST['bizId'];
	$userManager = new UserManager;
	$userManager->blockfollowBizUnblock($userId, $bizId);
	echo 1;
}else if($_REQUEST['delete_group']=='Y'){
	$userId = $_SESSION['userId'];
	$groupid = $_REQUEST['groupid'];
	$userManager = new UserManager;
	echo $userManager->deletegroupBizUnblock($userId, $groupid);
}else{
	//pending.php block
	$userId = $_SESSION['userId'];
	$bizId = $_REQUEST['bizId'];
	$userManager = new UserManager;
	$userManager->blockfollowBiz($userId, $bizId);
	echo 1;
}
?>

