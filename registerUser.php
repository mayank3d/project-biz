<?php

include_once 'library.php';
include 'UserManager.php';
session_start();
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$userManager = new UserManager;

$person = $userManager->saveUser($email, $name, $password);
if ($person['isSaved']) {
    $_SESSION['isAllowed'] = 'true';
    $_SESSION['username'] = $person['username'];
    $_SESSION['email'] = $person['email'];
    $_SESSION['userId'] = $person['userId'];
    $_SESSION['alert'] = "Welcome Back " . $person['username'];
    redirect('register_success.php');
}
?>

