<?php

include_once 'library.php';
include_once 'config.php';
include 'TNIManager.php';
$userId=$_POST['userId'];
$sessionId=$_POST['sId'];
$trendId=$_POST['tId'];
$tniManager = new TNIManager();
$total_rec = $tniManager->getNewsletsUIByTrends($userId, $sessionId, $trendId);
if(!empty($total_rec)){
	echo $total_rec;
}else{
	echo 'No record found.';
}
?>