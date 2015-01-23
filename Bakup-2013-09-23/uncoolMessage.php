<?php
//ini_set('display_errors', 'On');
include_once 'library.php';
include 'MessageManager.php';

$userId = $_REQUEST['userId'];
$msgId = str_replace('i','',$_REQUEST['msgId']);

$msgManager = new MessageManager;
echo $msgManager->unCoolMessage($msgId, $userId);;
?>
