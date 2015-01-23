<?php
session_start();
include_once 'library.php';
include 'UserManager.php';

include_once 'config.php';
include 'TNIManager.php';


if (isset($_SESSION['username']) && ($_SESSION['isAllowed'] == 'true')) {
    
} else {
    $_SESSION['notification'] = 'InValid Login';
    redirect('index.php');
}

?>


<!DOCTYPE html>
<html lang="">


    <?php include_once 'header.php'; ?>
	<style>
		.charCount{float: right;color: #3B3E40;}
	</style>
    <body onLoad="getNewslets()">
    
<?php include_once 'ajaxloading.php'; ?>
        <?php include_once 'logo.php'; ?>
        <?php include_once 'sideMenu.php'; ?>
        <?php //include_once 'alert.php'; ?>
        <?php include_once 'MessageManager.php'; ?>

        <section class="content">
            <section class="widget">
                <header>
                    <span class="icon">&#59168;</span>
                    <hgroup>
                        <h1>Help</h1>
                        <h2>How it works</h2>
                    </hgroup>
                </header>
                <div class="content no-padding timeline" id="help">
                
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                </div>
            </section>
        </section>
        <script src="js/jquery.wysiwyg.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/cycle.js"></script>
        <script src="js/jquery.checkbox.min.js"></script>
        <script src="js/jquery.tablesorter.min.js"></script>
       
    </body>
</html>