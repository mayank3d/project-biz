<?php
include_once 'library.php';
include 'UserManager.php';
//print_r($_REQUEST);
if($_REQUEST['action']=='check_username'){
	$username = strtolower($_POST['username']);
	$userManager = new UserManager;
	
	$person = $userManager->userNameValidation($username);
	if ($person==1) {
		print 1;
	}else{
		print 2;
	}
}
if($_REQUEST['action']=='registration'){
	//print_r($_REQUEST);
	
	$username = strtolower($_REQUEST['name']);
	$email_input = $_REQUEST['email'];
	$userManager = new UserManager;
	
	$person = $userManager->userNameValidation($username);
	$email = $userManager->emailValidation($email_input);
	//var_dump($person);
	//die();
	if ($person==1) {
		print 1;
	}else if($email){
		print 3;
	}else{
		//register

$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$fullname = $_REQUEST['fullname'];
$name_ex = explode(' ',$fullname);
$fname = isset($name_ex[0])?$name_ex[0]:'';
$lname = isset($name_ex[1])?$name_ex[1]:'';
//$userManager = new UserManager;

	$person = $userManager->saveUser($email, $username, $password,$fname,$lname);
//if ($person['isSaved']) {
	if(!isset($_SESSION)){
            session_start();
        }
    /*$_SESSION['isAllowed'] = 'true';
    $_SESSION['username'] = $person['username'];
    $_SESSION['email'] = $person['email'];
    $_SESSION['userId'] = $person['userId'];
    $_SESSION['alert'] = "Welcome Back " . $person['username'];*/
    //('index.php');
//}
		print 2;
	}
}
?>
