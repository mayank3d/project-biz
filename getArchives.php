<?php
include_once 'library.php';
include_once 'config.php';
include 'TNIManager.php';
$userId=$_REQUEST['userId'];
$sessionId=$_REQUEST['sId'];
// $trendId=$_REQUEST['tId'];
$tniManager = new TNIManager();
$total_rec = $tniManager->getNewsletsUIArchives($userId, $sessionId);
if(!empty($total_rec)){
	echo $total_rec;
}else{
	echo 'No record found.';
}
?>