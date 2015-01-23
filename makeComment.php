<?php
session_start();
//ini_set('display_errors', 'On');
$path = getcwd();
clearstatcache();

include_once 'library.php';
include 'MessageManager.php';
if($_REQUEST['mode']=='delete'){
	$msgId = $_REQUEST['msg_id'];
	$commentId = $_REQUEST['commentid'];
	$userId = $_SESSION['userId'];
	print_r($_REQUEST);
	
	$msgManager = new MessageManager;
	$commentId = $msgManager->deleteComment($userId, $msgId, $commentId);
	echo 1;
}else{
	
$userId = $_POST['userId'];
$msgId = $_POST['msgId'];
$comment= $_POST['comment'];
if($comment=='Respond to comment...' || $comment==''){
	echo 0;
	}else{
		$rexProtocol = '(https?://)?';
$rexDomain   = '((?:[-a-zA-Z0-9]{1,63}\.)+[-a-zA-Z0-9]{2,63}|(?:[0-9]{1,3}\.){3}[0-9]{1,3})';
$rexPort     = '(:[0-9]{1,5})?';
$rexPath     = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
$rexQuery    = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
$rexFragment = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
$comment = preg_replace_callback("&\\b$rexProtocol$rexDomain$rexPort$rexPath$rexQuery$rexFragment(?=[?.!,;:\"]?(\s|$))&",'callback', htmlspecialchars($comment));

		$msgManager = new MessageManager;
		$commentId = $msgManager->commentMessage($userId, $msgId, $comment);
		$image = $path.'/upload/'.$_SESSION['userId'].'_S.png';
		
					if (file_exists($image)) {
						$image_cur = SITE_URL.'upload/'.$_SESSION['userId'].'_S.png';
					}else{
						$image_cur = SITE_URL.'upload/un.png';
					}
					$user_info = $msgManager->getUserInfo($_SESSION['userId']);
					echo '<div id="comment_remarks_'.$commentId.'" class="tl-post" style="opacity: 1;">';
								echo '<span class="icon"><img src="'.$image_cur.'"></span>';
								echo '<p align="justify">';
								echo '<strong>'.$user_info['FIRST_NAME'] . ' '.$user_info['LAST_NAME'] . '  : </strong>';
								echo '<span style="margin:5px;">';
								echo $comment;
								echo '</span>';
								echo '<br>';
								echo '<br>';
								echo '<a href="javascript:void(0);" onclick="deleteComment('.$commentId.','.$msgId.')">Delete </a>';
								echo '</p>';
								echo '</div>';
	}
}

function callback($match){
    // Prepend http:// if no protocol specified
    $completeUrl = $match[1] ? $match[0] : "http://{$match[0]}";
	$pos=strpos($completeUrl,'http');
	
	if($pos===false)
	{
    return '<a href="http://' . $completeUrl . '">'
        . $match[2] . $match[3] . $match[4] . '</a>';
	}
	else
	{
	  return '<a href="' . $completeUrl . '">'
        . $match[2] . $match[3] . $match[4] . '</a>';
	}
	//return '<a href="' . $completeUrl . '">'. $match[2] . $match[3] . $match[4] . '</a>';
}
function text2link($text)
{
$text = preg_replace
(
"/(ftp\.|www\.|http:\/\/|https:\/\/|)(.*)(\.)(com|net|co|uk|in)/i",
"<a href='http://$2$3$4' target='_blank'>$1$2$3$4</a>",
$text
);

return $text;
}
?>
