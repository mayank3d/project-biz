<?php
ini_set('display_errors', 'On');
include_once 'library.php';
include 'GroupManager.php';
$userId = $_POST['userId'];
$groupManager = new GroupManager;
echo $groupManager->getAllGroupsOfUser($userId);
?>
