<?php

//ini_set('display_errors', 'On');
include_once 'library.php';
include 'MessageManager.php';

//print_r($_REQUEST);
if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete_brodcast_msg'){
	$msgId=$_REQUEST['msgId'];
	$userId = $_REQUEST['userId'];
	$msgManager = new MessageManager;
	$post_id = $msgManager->deleteMsg($msgId,$userId);
	if($post_id==true){
		echo $_REQUEST['msgId'];
	}else{
		echo 0;
	}
}
//echo 'qqq';
//print_r($_REQUEST);
if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='notify_delete'){
	include_once 'UserManager.php';
	$userManager = new UserManager();
	echo '<pre>';
	$userId = $_REQUEST['userId'];
	
	print_r($userManager->deleteNotifications($userId));
	echo '1';
}
if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='notify_call'){
	include_once 'UserManager.php';
	$userManager = new UserManager();
	//echo '<pre>';
	$userId = $_REQUEST['userId'];
	
	$total_news = $userManager->getNotificationsdb('Y',$userId);
	$total_msg = $userManager->getNotificationsdb('N',$userId);
$rows = array('t_notification'=>$total_news,'t_notification_msg'=>$total_msg);	
		
		echo json_encode($rows);
	//print_r($userManager->deleteNotifications($userId));
	//echo '1';
}
if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='notify_count_delete'){
	include_once 'UserManager.php';
	$userManager = new UserManager();
	//echo '<pre>';
	$userId = $_REQUEST['userId'];
	$total_news = $userManager->getNotificationscountdelete($userId);
	
		
}

?>
