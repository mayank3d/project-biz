<?php
session_start();
//ini_set('display_errors', 'On');
$path = getcwd();
clearstatcache();
include_once 'library.php';
include 'UserManager.php';
include 'BusinessManager.php';
$businessManager = new BusinessManager;


	
$search_content = $_REQUEST['search_cc'];

$msg = '';
$res = $businessManager->searchTopsubscription_new($_SESSION['userId'],$search_content);
	if($res==false){
		echo '<strong>No matching record found.</strong>';
	}else{
		$msg .= '<div class="subscribed_box" style="float:left;width:100%;">
	<div class="name_class_bold" style="">Name</div>
	<div class="name_class_bold" >NewsID</div>
	<div class="subscribe_class_bold" style="width:22%;">Subscribers</div>
	<div class="name_class_bold" >Status</div>
</div>';
		$msg .= $res;
	}
						
echo $msg;


?>
