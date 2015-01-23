<?php
ini_set('display_errors', 'On');
include_once 'library.php';
include 'MessageManager.php';
$userId = $_POST['userId'];
$msgId = str_replace('i','',$_POST['msgId']);
$msgManager = new MessageManager;
echo $msgManager->coolMessage($msgId, $userId);
?>
