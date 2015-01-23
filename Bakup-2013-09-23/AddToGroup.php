<?php
ini_set('display_errors', 'On');

include_once 'library.php';
include 'GroupManager.php';
$userId = $_POST['userId'];
$bizId = $_POST['bizId'];
$groupName = $_POST['groupName'];
$groupId = $_POST['groupId'];
$groupManager = new GroupManager;
print 'SHIVAGANESH';
return $groupManager->addtoGroup($groupName, $groupId, $bizId, $userId);

?>
