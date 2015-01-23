<?php
include_once 'library.php';
include 'UserManager.php';
session_start();
session_destroy();
redirect('index.php');
?>
