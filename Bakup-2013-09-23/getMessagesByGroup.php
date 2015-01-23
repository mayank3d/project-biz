<?php

include_once 'library.php';
include_once 'config.php';
include 'TNIManager.php';
$userId = $_POST['userId'];
$sessionId = $_POST['sId'];
$groupId = $_POST['groupId'];
$tniManager = new TNIManager();
print $tniManager->getNewsletsUIByGroupId($userId, $sessionId, $groupId);
?>