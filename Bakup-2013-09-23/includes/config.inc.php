<?php session_start();
$_SESSION['language'] = 'en_US';
include_once 'includes/library.php';
include_once 'includes/class.database.php';
include_once 'includes/class.img.php';
define('HOSTNAME','shivaganesh.com');
define('DB_USERNAME','shiv0943_tni');
define('DB_PASSWORD','P@ssw0rd');
define('DB_NAME','shiv0943_thenewsid');
define('ADMINISTRATOR_EMAIL','info@thenewsid.com');
$db = new DB(array(
	'hostname'=>HOSTNAME,
	'username'=>DB_USERNAME,
	'password'=>DB_PASSWORD,
	'db_name'=>DB_NAME
));
if($db===FALSE) {
	$db_errors = $db->errors;
}

?>


