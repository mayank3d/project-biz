<?php
session_start();
include_once 'config.php';
include_once 'TNI.php';
include_once 'MessageManager.php';
$obb = new TNI();
print_r($_SESSION);
die();
$ramConnection = getRAMConnection();
$userId = '42';
$userName = 'Biswa';
$encryptedPassword = '96e79218965eb72c92a549dd5a330112';
echo $ramConnection->hget('USER_ID_NAME', $userId);
//$ll = $ramConnection->hget('USER_LOGIN');
//var_dump($ll);
//$ramConnection->delete('USER_LOGIN', $userName);

//$ramConnection->hset('USER_LOGIN', $userName, $encryptedPassword);
//$ramConnection->hDel('USER_LOGIN', $userName);

echo $ramConnection->hget('USER_LOGIN', $userName);
//echo $obb->delete('123');
?>