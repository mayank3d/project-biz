<?php

ini_set('display_errors', 'On');
include_once 'library.php';
include 'UserManager.php';
$userId = $_POST['userId'];
$status = $_POST['status'];
$userManager = new UserManager;
echo $userManager->makeProfilePublic($userId, $status);
?>
