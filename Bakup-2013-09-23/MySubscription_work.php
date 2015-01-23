<?php
include_once 'library.php';
include 'UserManager.php';
session_start();
 $date = date('Y-m-d');
			//$sql = "select nt.from_id,nt.notification,nt.read_status,nt.notification_area,ui.USERNAME from notification as nt,USER_LOGIN_INFO as ui where  nt.from_id=ui.USER_ID and nt.to_id='".$uid."' and post_date='".$date."'";
			//echo $sql;
//print_r($_SESSION);
//die();
include 'BusinessManager.php';
$businessManager = new BusinessManager;
if (isset($_SESSION['username']) && ($_SESSION['isAllowed'] == 'true')) {
    
} else {
    $_SESSION['notification'] = 'InValid Login';
    redirect('index.php');
}
//echo '<pre>';
//print_r($_SESSION);

?>
<!DOCTYPE html>
<html lang="">


    <?php include_once 'header.php'; ?>
    <body>
        <?php 
		
		include_once 'ajaxloading.php';
		include_once 'logo.php'; ?>
        <?php include_once 'sideMenu.php'; ?>
        <?php //include_once 'alert.php'; ?>
        <style>
        .name_class{
			font-weight:bold;
		}
        </style>
        <script>
        function open_unsubscribe(id){
			//alert(id);
			document.getElementById(id).innerHTML = 'UNSUBSCRIBE';
			jQuery('#'+id).css('padding-right','0px');
			jQuery('#'+id).css('padding-left','0px');
			
			//jQuery('#'+id).toggleClass( "blue", "orange" );
				
			
		}
		function open_subscribe(id){
			//alert(id);
			jQuery('#'+id).css('padding-right','5px');
			jQuery('#'+id).css('padding-left','5px');
			document.getElementById(id).innerHTML = 'SUBSCRIBED';
			//jQuery('#'+id).toggleClass( "orange", "blue");
		}
        </script>
        <script type="text/javascript">


                        function followUser(userId, bizId) {
                            $.post("followUser.php", {userId: userId, bizId: bizId})
                                    .done(function(data) {
										
                                $("#" + userId + bizId).attr("class", "orange");
                                $("#" + userId + bizId).html('UNFOLLOW');
                                $("#" + userId + bizId).attr("onClick", "unFollowUser(" + userId + "," + bizId + ")");
                            });
                        }
                        /*function unFollowUser(userId, bizId) {
                            $.post("unFollowUser.php", {userId: userId, bizId: bizId})
                                    .done(function(data) {
										
                                $("#" + userId + bizId).attr("class", "blue");
                                $("#" + userId + bizId).html('FOLLOW');
                                $("#" + userId + bizId).attr("onClick", "followUser(" + userId + "," + bizId + ")");
                            });
                        }*/
						function unFollowUser(userId, bizId) {
							if(confirm('Are you sure, want to delete this Subscribed Id?')){
								$('#fancybox-loading').css('display','block');
                            $.post("unFollowUser.php", {userId: userId, bizId: bizId,subs_subscribe:'Y'})
                                    .done(function(data) {
										//alert(data);
										$('#fancybox-loading').css('display','none');
								if(data==1){
									$('div#subscribed_box_'+bizId).remove();
								}
                               /* $("#" + userId + bizId).attr("class", "blue");
                                $("#" + userId + bizId).html('FOLLOW');
                                $("#" + userId + bizId).attr("onClick", "followUser(" + userId + "," + bizId + ")");*/
                            });
							}
						}
                        function resetName() {
                            $("#newGroupName").val("");
                        }
                        function resetSelectOption() {
                            $('#groupName').prop('selectedIndex', 0);
                        }

        </script>
        <section class="content">

            <div class="widget-container">
                <section class="widget small" style="width:100%;">
                    <header> 
                        <span class="icon">&#128214;</span>
                        <hgroup>
                            <h1>Subscribed</h1>
                            <!--<h2>Individual and Groups</h2>-->
                        </hgroup>
                    </header>
                    <div class="content">
                        <section class="stats-wrapper">
                            <?php
                           // $userManager = new UserManager;
                           // echo $userManager->getAllFolloiwingUsersAndGroups($_SESSION['userId'])
                            ?>
                    <div style="" class="subscribed_class">
                        
                           
                
                        <?php
                        
                        //echo $businessManager->getTopUsers($_SESSION['userId']);
						 if(isset($_REQUEST['aa']))
						 {
								if($_REQUEST['aa']==1)
								{
								echo $businessManager->getTopUsers($_SESSION['userId']);
								}
								else
								{
								echo $businessManager->getTopUsers22($_SESSION['userId']);
								}
						}
						else
						{
						//echo $businessManager->getTopUsers($_SESSION['userId']);
							$res = $businessManager->getTopUsers_new($_SESSION['userId']);
							//echo 'hi';
							//var_dump($res);
							if($res == ''){
								echo '<strong>No Subscription found.</strong>';
							}else{
								?>
                                <div class="subscribed_box" style="float:left;width:100%;">
                                    <div class="picture_class" style="">Picture</div>
                                    <div class="name_class" style="">Name</div>
                                    <div class="username_class" >NewsID</div>
                                    <div class="groupname_class" >Subscribers</div>
                                    <div class="subscribe_class_bold" style="">Status</div>
                                    <div class="name_class_bold" >Type</div>
                                </div>
                                <?php
								echo $res;
							}
						}
		             ?>


                   
                </div> 
                        </section>
                    </div>
                </section>
                
                
            </div>

        </section>
        <script src="js/jquery.wysiwyg.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/cycle.js"></script>
        <script src="js/jquery.checkbox.min.js"></script>
        <script src="js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript">
            

            function coolMessage(msgId) {
                $.post("coolMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                        .done(function(data) {
                    alert(data);
                    $("#" + msgId + "msgId").html(data + " cools");
                    $("#" + msgId + "coolBtn").html("uncool");
                    $("#" + msgId + "coolBtn").attr("onclick", 'unCoolMessage(\'' + msgId + '\')');
                });
            }

            function unCoolMessage(msgId) {
                $.post("uncoolMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                        .done(function(data) {
                    $("#" + msgId + "msgId").html(data + " cools");
                    $("#" + msgId + "coolBtn").html("cool");
                    $("#" + msgId + "coolBtn").attr("onclick", 'coolMessage(\'' + msgId + '\')');
                });
            }

            function submitNewslet() {
                var msg = $("#MyMsg").val();
                $.post("BroadCastMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msg: msg})
                        .done(function(data) {
                    $inter = '';
                    $inter = makeListNewslet($inter, msg, data);
                    $("#myNewslets").prepend($inter);
                    i = 20;
                    $(".tl-post").each(function() {
                        $(this).delay(i).animate({"opacity": 1});
                    });
                    $("#MyMsg").val('');
                });
            }

            function reNewslet(msgId) {
                $.post("reNewslet.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                        .done(function(data) {
                    $("#" + msgId + "msgIdshares").html(data + " shares ");
                    $("#" + msgId + "shareBtn").remove();
                    //  $("#" + msgId + "coolBtn").attr("onclick", 'unCoolMessage(\'' + msgId + '\')');
                });
            }

          function makeListNewslet(inter, msg, key) {
                $inter = inter;
                $inter = $inter + '<div class="tl-post"><span class="icon"><img src="images/u.png" /></span>';
                $inter = $inter + ' <p align="justify">';
                $inter = $inter + msg;
                $inter = $inter + '<span class="cools" id="' + key + 'msgId">67 cools</span><a class="blue" id="' + key + 'coolBtn" onclick="coolMessage(\'';
                $inter = $inter + key + '\')">cool!</a> <span class="cools" id="' + key + 'msgIdshares">67 shares </span><a id="' + key + 'shareBtn" onclick="reNewslet(\'' + key + '\')" class="green">share</a> <a class="red" onclick="window.location.href=\'commentSection.php?id=' + key + '\'">comment</a></p></div>';
                return $inter;
            }
        </script>
    </body>
</html>  
