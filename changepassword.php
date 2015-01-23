<?php
session_start();
include_once 'library.php';
include 'UserManager.php';

if (isset($_SESSION['username']) && ($_SESSION['isAllowed'] == 'true')) {
    
} else {
    $_SESSION['notification'] = 'InValid Login';
    redirect('index.php');
}
if($_REQUEST['update_pass']=='change_pass'){
	
	if(empty($_REQUEST['new_pass']) || empty($_REQUEST['rnew_pass']) || empty($_REQUEST['old_pass'])){
		$msg = 'Text field can\'t be empty.';
	}else if($_REQUEST['new_pass'] != $_REQUEST['rnew_pass'] ){
		$msg = 'Please Re-enter valid new password.';
	}else{
		$userId = $_SESSION["userId"];
		$userManager = new UserManager;
		$update_msg = $userManager->updatePasswordmatchold($userId,$_REQUEST['new_pass'],$_REQUEST['old_pass']);
		if($update_msg==true){
			$msg = 'Password updated successfully.';
		}else{
			$msg = 'Please enter valid old password';
		}
	}
//redirect('viewProfile.php');
}
?>
<!DOCTYPE html>
<html lang="">
    <?php include_once 'header.php'; ?>
    <body onLoad="">
    <style>
	div.field-wrap{
		margin:5px;
		 font-weight:bold;
	}
    div.form-row{
		margin:10px;
		 font-weight:bold;
	}
	hgroup h2{
		margin-top:20px;
	}
	input{
		width:65%;
	}
    </style>
        <?php include_once 'logo.php'; ?>
        <?php include_once 'sideMenu.php'; ?>
        <?php //include_once 'alert.php'; ?>
        <section class="content">
            <div class="widget-container">
                <section class="widget small" style=" width:700px;">
                    <header> 
                        <span class="icon">&#128363;</span>
                        <hgroup>
                            <h1>Change Password</h1>
                            <h2>Make sure everything is fine</h2>
                        </hgroup>
                        <!--<aside>
                            <span>
                                <a href="#">&#9881;</a>
                                <ul class="settings-dd">
                                    <li><span style="none"><label style="hidden">Settings</label><input type="checkbox"/></span></li>
                                    <li><label>Public Profile</label><input type="checkbox" id="publicProfile" name="publicProfile" onChange="makePublicProfile(this.checked)"/></li>
                                    <li><label>Public Newslets</label><input type="checkbox" id="publicNewslets" name="publicNewslets" onChange="makePublicNewslets(this.checked)"/></li>
                                </ul>
                            </span>
                        </aside>-->
                    </header>
                    <div style="color:#F00;margin: 17px; font-weight:bold;">
                   <?php
				   if($msg){
					   echo $msg;
				   }
				   ?>
                   </div>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <input type="hidden" value="change_pass" name="update_pass"/>
                        <input type="hidden" value="<?php echo $_SESSION['userId'] ?>" name="userId"/>

                        <div class="content no-padding ">
                            <div class="field-wrap">
                                <div class="form-row">Old Password :</div>  <input type="password" name="old_pass" value="">
                            </div>
                            <div class="field-wrap">
                                <div class="form-row">New Password : </div> 
                                
                                <input type="password" name="new_pass" value="" >
                            </div>
                            
                            <div class="field-wrap">
                                <div class="form-row">Re-enter New Password : </div> <input type="password" name="rnew_pass"  value="">
                            </div>
                           
                            
							<div class="field-wrap" style="width:88%;  margin:0 auto;">
                           
                            <input type="submit" style="color:#FFF; font-weight:bold;" class="blue" value="UPDATE"/>
							</div>
                            </div>
                    </form>
            </div>
        </section>
        
    </div>
</section>
<link rel="stylesheet" href="css/jquery-ui.css" media="all" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="js/jquery.wysiwyg.js"></script>
<script src="js/custom.js"></script>
<script src="js/cycle.js"></script>
<script src="js/jquery.checkbox.min.js"></script>
<!--<script src="js/flot.js"></script>
<script src="js/flot.resize.js"></script>
<script src="js/flot-graphs.js"></script>
<script src="js/flot-time.js"></script>
<script src="js/cycle.js"></script>-->
<script src="js/jquery.tablesorter.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript">

                                        function makePublicProfile(status) {
                                            msg = 'N';
                                            if (status) {
                                                msg = 'Y';
                                            }
                                            $.post("profileSetting.php", {userId: '<?php echo $_SESSION['userId'] ?>', status: msg},
                                            function(data) {
                                            });
                                        }

                                        function makePublicNewslets(status) {
                                            msg = 'N';
                                            if (status) {
                                                msg = 'Y';
                                            }
                                            $.post("NewsletSetting.php", {userId: '<?php echo $_SESSION['userId'] ?>', status: msg},
                                            function(data) {
                                            });
                                        }
                                        $(function() {
                                            $("#dateOfBirth").datepicker({
                                                yearRange: "1900:2013",
                                                changeMonth: true,
                                                changeYear: true
                                            });
                                            $("#anniversaryDate").datepicker({
                                                yearRange: "1900:2013",
                                                changeMonth: true,
                                                changeYear: true
                                            });
                                        });
</script>
</body>
</html>
