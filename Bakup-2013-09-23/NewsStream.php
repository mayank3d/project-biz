<?php
//ini_set('display_errors',1);
session_start();
include_once 'library.php';
include 'UserManager.php';

//print_r($_SESSION);
//die();
if (isset($_SESSION['username']) && ($_SESSION['isAllowed'] == 'true')) {
    
} else {
    $_SESSION['notification'] = 'InValid Login';
    redirect('index.php');
}
//echo '<pre>';
//print_r($_SESSION);
$user_info = user_info();
//print_r($user_info);
?>
<!DOCTYPE html>
<html lang="">


    <?php include_once 'header.php'; ?>
    <body>
    <style>
    section.widget .content{
		padding:15px;
	}
	section.widget .content .stats-wrapper .stats:last-child{
		float:left;
	}
	section.widget .content .stats-wrapper:last-child div{
	 margin:5px;
	}
    </style>
    <?php include_once 'ajaxloading_up.php'; ?>
        <?php include_once 'logo.php'; ?>
        <?php include_once 'sideMenu.php'; ?>
        <?php //include_once 'alert.php'; ?>
        <?php include_once 'UserManager.php';?>
        <section class="content">

            <div class="widget-container">
                <section class="widget small" style="width:40%;">
                    <header> 
                        <span class="icon">&#128214;</span>
                        <hgroup>
                            <h1>Subscribed NewsID</h1>
                            <h2>Individual and Groups</h2>
                        </hgroup>
                    </header>
                    <div class="content">
                        <section class="stats-wrapper">
                            <?php
                            $userManager = new UserManager;
                            echo $userManager->getAllFolloiwingUsersAndGroups($_SESSION['userId'])
                            ?>
                        </section>
                    </div>
                </section>
                <script type="text/javascript">
                    $(document).ready(function() {
                        //var firstId = $("#firstBizId").val();
						var firstId = '<?php echo $_SESSION['userId'];?>';
                        getNewslets('I',firstId);
                    });
                </script>
                <section class="widget small" style="width:59%;">
                    <header> 
                        <span class="icon">&#128640;</span>
                        <hgroup>
                            <h1>News Stream</h1>
							<h2>Recent Newslets</h2>
                        </hgroup>

                    </header>
                    <div class="content">
                        <div class="content no-padding timeline" id="myNewslets">
                        </div>
                    </div>
                </section>
            </div>

        </section>
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
        <script type="text/javascript">
            function getNewslets(filter,bussinessId) {
				//alert (filter+bussinessId);
				$('#fancyboxloading_up').css('display','block');
                $.post("getMessagesByBiz.php", {bussinessId: bussinessId, filter:filter},
                function(data) {
					$('#fancyboxloading_up').css('display','none');
                    $('#myNewslets').html(data);
                    $(".tl-post").each(function() {
                        i = 10;
                        $(this).delay(i).animate({"opacity": 1});
                        i = i + 20;
                    });
                });
            }
            function getNewsletsByGroup(groupId) {
                $.post("getMessagesByGroup.php", {userId: '<?php echo $_SESSION['userId'] ?>', sId: '<?php echo session_id() ?>', groupId: groupId},
                function(data) {
                    $('#myNewslets').html(data);
                    $(".tl-post").each(function() {
                        i = 10;
                        $(this).delay(i).animate({"opacity": 1});
                        i = i + 20;
                    });
                });
            }
            function deleteNewslet(msgId) {
                $.post("getMessages.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                        .done(function(data) {

                });
            }

            function coolMessage(msgId) {
				$("#" + msgId + "coolBtn").html('&nbsp;');
                $.post("coolMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                        .done(function(data) {
                    //alert(data);
                    $("#" + msgId + "msgId").html(data + " Stars");
                    $("#" + msgId + "coolBtn").html("Unstar");
                    //$("#" + msgId + "coolBtn").attr("onclick", 'unCoolMessage(\'' + msgId + '\')');
					$("#" + msgId + "coolBtn").attr("href", 'javascript:unCoolMessage(\'' + msgId + '\')');
                });
            }

            function unCoolMessage(msgId) {
				$("#" + msgId + "coolBtn").html('&nbsp;');
                $.post("uncoolMessage.php", {userId: '<?php echo $_SESSION['userId'] ?>', msgId: msgId})
                        .done(function(data) {
							//alert(data);
                    $("#" + msgId + "msgId").html(data + " Stars");
                    $("#" + msgId + "coolBtn").html("Star");
                    //$("#" + msgId + "coolBtn").attr("onclick", 'coolMessage(\'' + msgId + '\')');
					$("#" + msgId + "coolBtn").attr("href", 'javascript:coolMessage(\'' + msgId + '\')');
					
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
							//alert(data);
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
			function delete_msg(tw_id,uid){
			//alert(tw_id+'--'+uid);
			
			$('#fancyboxloading_up').css('display','block');
			jQuery.ajax({
				type: 'GET',
				url: 'ajax.php',
				data: {action:'delete_brodcast_msg',userId: uid, msgId: tw_id},
				/*dataType: 'json',*/
				success: function(data) {
					$('#fancyboxloading_up').css('display','none');
					$('div#mystream_msg_'+tw_id).remove();
					//alert(data);
					//'mystream_msg_';
					
					}
				});
		}
        </script>
    </body>
</html>  
