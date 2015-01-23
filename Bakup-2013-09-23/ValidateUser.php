<?php

include_once 'library.php';
include 'UserManager.php';
session_start();
$username = $_POST['email'];
$password = $_POST['password'];
$userManager = new UserManager;
$_SESSION['isAllowed'] = 'true';
$person = $userManager->validateUser($username, $password);
/*var_dump($person);
var_dump($person['isValid']);
die();*/
if ($person['isValid'] == 'true') {
    $_SESSION['username'] = $person['username'];
    $_SESSION['email'] = $person['email'];
    $_SESSION['userId'] = $person['userId'];
    $_SESSION['alert'] = "Welcome Back " . $person['username'];
	$_SESSION['notification'] = 'Welcome ' . $person['username'];
redirect('NewsStream.php');
} else {
    $_SESSION['isAllowed'] = 'false';
	//$_SESSION['notification'] = 'Welcome ' . $person['username'];
redirect('index.php');
}

?>
