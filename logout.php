<?php
include_once 'library.php';
include 'UserManager.php';
if(!isset($_SESSION)){
    session_start();
}
session_destroy();
redirect('index.php');
?>
