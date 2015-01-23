<?php
ini_set('display_errors', 'On');
include_once 'library.php';
include 'MessageManager.php';
$userId = $_POST['userId'];
$msgId = str_replace('i','',$_POST['msgId']);
$commentId= $_POST['commentId'];
$msgManager = new MessageManager;
echo $msgManager->deleteComment($userId, $msgId, $commentId);
?>
