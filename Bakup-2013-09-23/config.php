<?php

//ini_set('display_errors', 0);
//error_reporting(E_ALL);

/**
 * Description of config
 *
 * @author shivaGanesh
 */
// function that returns db connection object
session_start();
define("SITE_URL", "http://50.62.131.205/");
function getDBConnection() {
    $userName = 'root';
    $passWord = 'root';
    $DB = 'thenewsid';
    $server = '127.0.0.1';
    $dbConnection = mysql_connect($server, $userName, $passWord) or die("Could not connect to the database:<br />" . mysql_error());
    mysql_select_db($DB) or die("Database error:<br />" . mysql_error());
    return $dbConnection;
}

function getRAMConnection() {
    require_once "Predis/Autoloader.php";
    Predis\Autoloader::register();
    $redis = new Predis\Client(array(
                "scheme" => "tcp",
                "host" => "127.0.0.1",
                "port" => 6379));
    return $redis;
}

function user_info(){
	$sql = "select ui.FIRST_NAME,ui.LAST_NAME, ui.EMAIL, ui.MOBILE, ui.ADDRESS, ui.CITY, ui.STATE, ui.COUNTRY, ui.DATE_OF_BIRTH, ui.ANNIVERSARY_DATE, ui.TYPE, ui.PUBLIC_PROFILE, ui.PUBLIC_TWEETS,uli.USERNAME, uli.CREATED_DATE_TIME,uli.CREATED_BY,uli.UPDATED_DATE_TIME,uli.UPDATED_BY	IS_ACTIVE,uli.LAST_LOGGED_IN_TIME from USER_LOGIN_INFO as uli,USER_INFO as ui where ui.USER_ID=uli.USER_ID and ui.USER_ID='".$_SESSION['userId']."' ";
	 $db = getDBConnection();
    $stores = mysql_fetch_array(mysql_query($sql));
	return $stores;
}
$user_info = user_info();

$date = new DateTime("2012-07-05 16:43:21", new DateTimeZone('Europe/Paris'));

date_default_timezone_set('America/New_York');

//echo date("Y-m-d h:iA", $date->format('U')); 

?>

