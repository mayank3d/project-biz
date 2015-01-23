<?php
ini_set('display_errors', 'On');
include_once 'library.php';
include 'GroupManager.php';
$userId = $_POST['userId'];
$bizId = $_POST['bizId'];
$groupName = $_POST['groupName'];
$groupManager = new GroupManager;
$groupManager->createAndAddtoGroup($groupName, $bizId, $userId);
return true;
?>
