<?php
//ini_set('display_errors', 'On');
session_start();
//print_r($_REQUEST);
include_once 'library.php';
include 'GroupManager.php';
//print_r($_REQUEST);
if($_REQUEST['imgg']=='Y'){
	
/*foreach ($_FILES["images"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $name = $_FILES["images"]["name"][$key];
        move_uploaded_file( $_FILES["images"]["tmp_name"][$key], "upload/" . $_FILES['images']['name'][$key]);
    }
}*/
//$sql = "insert into GROUPS set GROUP_NAME='".$_REQUEST['gname']."',GROUP_OWNER='".$_SESSION['userId']."'";
$groupName = $_REQUEST['gname'];
$userId = $_SESSION['userId'];

$groupManager = new GroupManager;
$group_id = $groupManager->createAndAddtoGroup($groupName, '', $userId);
//echo $group_id;
//print_r($_FILES["images"]);
try {
    $allowedExts = array("gif", "jpeg", "jpg", "png");
	
	foreach ($_FILES["images"]["error"] as $key => $error) {
		
		$extension = $_FILES["images"]["type"][$key];
		$fileName = $_FILES["images"]["name"][$key];
		$saveFileName = $group_id.'_group';
		//echo $extension;
		if (($extension == "image/gif") || ($extension == "image/jpeg") || ($extension == "image/jpg") || ($extension == "image/pjpeg") || ($extension == "image/x-png") || ($extension == "image/png")) {
			if ($_FILES["images"]["error"][$key] > 0) {
				echo "Return Code: " . $_FILES["images"]["error"][$key] . "<br>";
			} else {
				//echo "Upload: " . $_FILES["images"]["name"][$key] . "<br>";
				//echo "Type: " . $_FILES["images"]["type"][$key] . "<br>";
				//echo "Size: " . ($_FILES["images"]["size"][$key] / 1024) . " kB<br>";
				//echo "Temp file: " . $_FILES["images"]["tmp_name"][$key] . "<br>";
				$file_name =  $saveFileName . '.png';
				move_uploaded_file($_FILES["images"]["tmp_name"][$key], "upload/" . $saveFileName . '.png');
				include('SimpleImage.php');
				$image = new SimpleImage();
				$image->load("upload/" . $saveFileName . '.png');
				$image->resize(32, 32);
				$image->save("upload/" . $saveFileName . '_S.png');
				$image = new SimpleImage();
				$image->load("upload/" . $saveFileName . '.png');
				$image->resize(150, 150);
				$image->save("upload/" . $saveFileName . '_M.png');
				//echo "Stored in: " . "upload/" . $_FILES["images"]["name"][$key];
			}
		} else {
			//echo "Invalid file";
			$file_name = '';
		}
	
	}
	if($group_id){
		$up = "update GROUPS set image='".$file_name."' where GROUP_ID='".$group_id."'";
		mysql_query($up);
	}
} catch (Exception $e) {
    $ex = $e;
}
	
//echo "<h2>Successfully Uploaded Images</h2>";
echo '1';
}else if($_REQUEST['imgg']=='N'){
	$groupName = $_REQUEST['gname'];
	$userId = $_SESSION['userId'];
	
	$groupManager = new GroupManager;
	$group_id = $groupManager->createAndAddtoGroup($groupName, '', $userId);
	echo '1';
}