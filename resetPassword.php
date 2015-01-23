<?php
include_once 'library.php';
include 'UserManager.php';
$username = $_GET['username'];
$userManager = new UserManager;
echo $userManager->resetPassword($username);
redirect("index.php");
?>

