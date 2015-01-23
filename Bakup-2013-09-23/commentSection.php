<?php
//ini_set('display_errors',1);
include_once 'library.php';
include 'UserManager.php';
session_start();
clearstatcache();
if (isset($_SESSION['username']) && ($_SESSION['isAllowed'] == 'true')) {
    
} else {
    $_SESSION['notification'] = 'InValid Login';
    redirect('index.php');
}
//print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="">
    <?php include_once 'header.php'; ?>
    <body >
        <?php
		include_once 'ajaxloading.php';
        include_once 'logo.php';
        include_once 'sideMenu.php';
        include_once 'MessageManager.php';
        //include_once 'alert.php';
        $msgContent = MessageManager::getMessageInfo($_GET['id']);
        ?>

      
        <script src="js/jquery.wysiwyg.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/cycle.js"></script>
        <script src="js/jquery.checkbox.min.js"></script>
        <script src="js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript">
            function makeComment(userId, msgId) {
                var comment = $("#comment").val();
				$("#fancybox-loading").css('display','block');
                $.post("makeComment.php", {userId: userId, msgId: msgId, comment: comment})
                        .done(function(data) {
							$("#fancybox-loading").css('display','none');
							document.getElementById('comment').value = '';
							if(data ==0){
								alert('Please enter valid content.');
							}else{
								if(data){
									$('#comments').prepend(data);
								}
							}
							
                    //alert(data);
                });
            }
			function deleteComment(id,msgid){
				//alert(id);
				$("#fancybox-loading").css('display','block');
				$.post("makeComment.php", {mode: 'delete', msg_id:msgid,commentid:id})
                        .done(function(data) {
					$("#fancybox-loading").css('display','none');		
                    //alert(data);
					$('div#comment_remarks_'+id).remove();
                });
				
			}

        </script>
        <section class="content">
            <section class="widget">
                <header>
                    <span class="icon">&#59168;</span>
                    <hgroup>
                        <h1><?php 
						$scount = strlen($msgContent);
						echo substr($msgContent,0,120); 
						echo ($scount>120?'...':'');?></h1>
                        <h2>Share your Remarks</h2>
                    </hgroup>
                </header>
                <input type="text" id="comment" name="comment"  class="comment" value="Leave Remarks here"/>
                <button onclick="makeComment(<?php echo '\'' . $_SESSION['userId'] . '\'' ?>, <?php echo '\'' . $_GET['id'] . '\'' ?>);">Post</button>
                <div class="content no-padding timeline" id="comments">
                    <?php
					//echo str_replace('i', '', $_GET['id']);
					//echo 'aaa';
                    $msgManager = new MessageManager;
					$iidd = str_replace('i', '', $_GET['id']);
                    $commentsMap = $msgManager->getCommentsMap($iidd , $_SESSION['userId']);
					//var_dump($commentsMap);
					if($commentsMap){
                    foreach ($commentsMap as $key => $value) {
						//print_r($value);
						//die();
						$userinfo = $msgManager->getUserInfo($value->getUserId());
						if(empty($userinfo['FIRST_NAME']) && empty($userinfo['FIRST_NAME']) ){
							$user_name = '<strong>'.$ccuser. '  : </strong>';
						}else{
							$user_name = '<strong>'.$userinfo['FIRST_NAME'].' '.$userinfo['LAST_NAME'] . '  : </strong>';
						}
                        echo '<div id="comment_remarks_'.$value->getCommentId().'" class="tl-post" style="opacity: 1;">';
                        echo '<span class="icon"><img src="upload/'.$value->getUserId().'_S.png"></span>';
                        echo '<p align="justify">';
                      //  echo '<strong>'.$value->getUsername() . ' : </strong>';
						 echo $user_name;
						echo '<span style="margin:5px;">';
                        echo $value->getComment();
						echo '</span>';
						echo '<br>';
						echo '<br>';
                        if($value->getSelfComment()=='Y'){
                            echo '<span style=""><a href="javascript:void(0);" onclick="deleteComment('.$value->getCommentId().','.$iidd.')"> Delete</a></span>';
                        }
                        echo '</p>';
                        echo '</div>';
                    }
					}else{
						echo '<div>No Remarks found.</div>';
					}
                    ?>

                </div>
            </section>
        </section>

    </body>
</html>