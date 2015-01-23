<?php
session_start();
//ini_set('display_errors', 'On');

include_once 'library.php';
include 'MessageManager.php';
$path = getcwd();
$userId = $_REQUEST['userId'];
$message = $_REQUEST['msg'];
if($message){
$rexProtocol = '(https?://)?';
$rexDomain   = '((?:[-a-zA-Z0-9]{1,63}\.)+[-a-zA-Z0-9]{2,63}|(?:[0-9]{1,3}\.){3}[0-9]{1,3})';
$rexPort     = '(:[0-9]{1,5})?';
$rexPath     = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
$rexQuery    = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
$rexFragment = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
$message1= preg_replace_callback("&\\b$rexProtocol$rexDomain$rexPort$rexPath$rexQuery$rexFragment(?=[?.!,;:\"]?(\s|$))&",'callback', htmlspecialchars($_REQUEST['msg']));

//$message = text2link($message);
$post_id = '';
//echo $message;


$msgManager = new MessageManager;
$post_id = $msgManager->postNewslet($userId, $message1);
//print_r($_REQUEST);
//echo $message;
//var_dump($post_id);
$user = $msgManager->getUserInfo($_SESSION['userId']);


$image = $path.'/upload/'.$_SESSION['userId'].'_S.png';
		
if (file_exists($image)) {
	$image_cur = SITE_URL.'upload/'.$_SESSION['userId'].'_S.png';
}else{
	$image_cur = SITE_URL.'upload/un.png';
}

$full_msg = '<div id="mystream_msg_'.$post_id.'" class="tl-post"><span class="icon">
<img src="'.$image_cur.'"></span>
<p align="justify"><strong>'.$user['FIRST_NAME'].' '.$user['LAST_NAME'] . ' : <br></strong>
'.$message1.'
<br>

<br><span style="width: 100px; margin-left: 15px; margin-right: 15px;">
<a onclick="coolMessage(\''.$post_id.'\')" id="'.$post_id.'coolBtn" href="#">Star</a></span> 
<span style="width: 100px; margin-left: 15px; margin-right: 15px;"><a href="'.SITE_URL.'commentSection.php?id='.$post_id.'"> Remarks  </a></span> 
<span style="width: 100px; margin-left: 15px; margin-right: 15px;"> <a href="javascript:delete_msg(\''.$post_id.'\',\''.$_SESSION['userId'].'\');"> Delete  </a></span>
<span id="'.$post_id.'msgId" class="cools" style="width: 100px; margin-left: 15px; margin-right: 15px;">0 Star </span>
<span id="'.$post_id.'msgId" class="cools" style="width: 100px; margin-left: 15px; margin-right: 15px;">0 Remarks </span></p>
</div>';

$rows = array('msg'=>$full_msg,'id'=>$post_id);
echo json_encode($rows);
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
//echo json_encode($rows);

//echo json_encode($_REQUEST);

//return true;
?>
