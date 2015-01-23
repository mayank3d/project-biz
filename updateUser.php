<?php
include_once 'library.php';
include 'UserManager.php';
$userId=$_POST['userId'];
$firstName = $_POST['firstName'];
$name = explode(' ',$firstName);
$firstName = $name[0];
$lastName = $name[1];
//$lastName = $_POST['lastName'];
//$mobile = $_POST['mobile'];
$mobile = NULL;
//$address = $_POST['address'];
$address = NULL;
$city = $_POST['CITY'];
$state = $_POST['STATE'];
$country = $_POST['COUNTRY'];
$timezone = $_POST['TIME_ZONE'];
$email = $_POST['EMAIL'];


    $domains = array('.com', '.co.in');

    $pattern = "/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/";
if (!preg_match($pattern, $email)) {
        header( 'Location: '.SITE_URL.'viewProfile.php?msg=Please Enter Valid Email' ) ;
        die;
}

//echo $country;
$dateOfBirth = $_POST['dateOfBirth'];
//$anniversaryDate = $_POST['anniversaryDate'];
$anniversaryDate =NULL;
$public_profile = (isset($_POST['public_profile'])?$_POST['public_profile']:'');
$userManager = new UserManager;
$userManager->updateUserInfo($userId,$firstName,$lastName,$mobile,$address,$city,$state,$dateOfBirth,$anniversaryDate,$public_profile,$country,$timezone,$email);
redirect('viewProfile.php');
?>
